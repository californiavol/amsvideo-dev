<?php

class Application_Model_DbTable_Videos extends Zend_Db_Table_Abstract
{

    protected $_name = 'videos';
    
    public function init()
    {
		//$logger = Zend_Registry::get('log');
		//$this->logger = $logger;
		//$this->logger->log('Informational message', Zend_Log::INFO);
    }  

    public function getAllVideos()
    {    	
    	$select = $this->select()		
             			->from('videos')
             			->joinUsing('courses', 'class_nbr');		
		$select->setIntegrityCheck(false);
        		
		$result = $this->fetchAll($select);
    	
	    return $result;
    }
    
    
    public function getVideosByClassNbr($id)
    {
		$rows = $this->fetchAll($this->select()->where('class_nbr = ?', $id));
		return $rows;
    }
    
    public function getVideoCount()
    {
        $rows = $this->fetchAll();
        $rowCount = count($rows);
        return $rowCount;      	
    }
    
    
    public function getVideoById($id)
    {
        if ($id == NULL) {
	  		return;
        }
    	$row = $this->fetchRow($this->select()->where('id = ?', $id));
		return $row;   	
    }
    
	public function getCourseVideos($class_nbr)
	{
		$select = $this->select();
		$select->setIntegrityCheck(false);
		$select->where('class_nbr = ?', $class_nbr)
				->join('courses', 'videos.class_nbr = courses.class_nbr');
				
		$rows = $this->fetchAll($select);
		return $rows;
	}
    
	public function getMostRecentVideo($id)
	{
	  	if ($id == NULL) {
			return;
	  	}
		
    	$today = date("Y-m-d H:i:s");      
    	//var_dump($today);
	  	
    	$row = $this->fetchRow($this->select()
				 ->where('class_nbr = ?', $id)
				 ->where('recorded_available_datetime <= ?', $today)
				 ->order('recorded_available_datetime DESC')
				 ->limit(1)
				 );
    	
	  	return $row;
	}  
	
  private function _parseCsv()
  {
    require_once  APPLICATION_PATH . '/../library/vendors/DataSource.php';

    $inputFile = APPLICATION_PATH . '/../data/csv/sac_cm_videos.csv';
    $csv = new File_CSV_DataSource;
    $csv->load($inputFile);
    $csvArray = $csv->connect();

    return $csvArray;
  }

  public function insertCsv()
  {
    //parse the csv                                                                                                            
    $data = $this->_parseCsv();

    //insert into db                                                                                                           
    if($this->_insertCsv2Db($data)) {
      return true;
    }
  }

  private function _insertCsv2Db($data = array())
  {
    $csvData = $data;

    //empty the videos table                                                                                                   
    $this->getAdapter()->query('TRUNCATE TABLE videos');
    
    //get the courses table
    $coursesTable = new Application_Model_DbTable_Courses();

    //insert parsed cvs into videos table
    $val = array();
    foreach ($csvData as $val) {
    	
    	//Use START_DT 'START_DT' 27-jan-2014 to create filename_partial
		$date = DateTime::createFromFormat('j-M-Y', $val['START_DT']);
        $filename_partial =  $date->format('Y_m_d');
        
        //get row from courses table by class_nbr
  		$row = $coursesTable->fetchRow($coursesTable->select()
				 ->where('class_nbr = ?', $val['CLASS_NBR'])
				 ->limit(1)
				 );      
         	
				 
        $live_start_datetime = date('Y-m-d H:i:s', strtotime($val['START_DT'].' '.$row['start_time']));
        $live_end_datetime = date('Y-m-d H:i:s', strtotime($val['START_DT'].' '.$row['available_time'])-10800);
        $recorded_available_datetime = date('Y-m-d H:i:s', strtotime($val['START_DT'].' '.$row['available_time']));
                                                                             
      	$data = array(
                    'start_dt'  => $val['START_DT'],
      				'days'      => strtolower($val['DAYS']),
                    'studio'    => $val['STUDIO'],
                    'course_id' => $val['COURSE_ID'],
                    'class_nbr' => $val['CLASS_NBR'],
      				'filename_partial'            => $filename_partial,
      				'live_start_datetime'         => $live_start_datetime,
      				'live_end_datetime'           => $live_end_datetime,
      				'recorded_available_datetime' => $recorded_available_datetime,
                    );
      	//var_dump($data);                                                                                                       
      	$this->insert($data);
    }
    
    return true;
    
  }
  
  public function convertDate($datetimeStr = null)
  {
  	$date = date("Y-m-d H:i:s", strtotime($datetimeStr));
  	return $date;
  }
	



	private function _addVideos()
	{

	  //load the excel parser
	  error_reporting(E_ERROR | E_PARSE);
	  require_once APPLICATION_PATH . '/../library/vendors/php-excel-reader-2.21/excel_reader2.php';
	  
	  $videosXls = APPLICATION_PATH . '/../data/videos.xls';
	  $coursesXls = APPLICATION_PATH . '/../data/courses.xls';
	  //check if files exist
	  if (!file_exists($videosXls)) {
	    
	    $tr = new Zend_Mail_Transport_Smtp('smtp.csus.edu');
	    Zend_Mail::setDefaultTransport($tr);
            
            $mail = new Zend_Mail();
            $mail->setBodyText('The videos.xls file does not exist. Therefore no new courses or videos can be added to Video database.');
            $mail->setFrom('charles.brownroberts@csus.edu', 'Charles');
            $mail->addTo('charlesbrownroberts@gmail.com', 'California Vol');
            $mail->setSubject('Courses.xls');
            $mail->send();
	    return;
	  }
	  
	  if (!file_exists($coursesXls)) {
	    
	    $tr = new Zend_Mail_Transport_Smtp('smtp.csus.edu');
	    Zend_Mail::setDefaultTransport($tr);
            
            $mail = new Zend_Mail();
            $mail->setBodyText('The courses.xls file does not exist. Therefore no new courses or videos can be added to Video database.');
            $mail->setFrom('charles.brownroberts@csus.edu', 'Charles');
            $mail->addTo('charles.brownroberts@csus.edu', 'California Vol');
            $mail->setSubject('Courses.xls');
            $mail->send();
	    return;
	  }
	  
	  //empty the videos table
	  $this->getAdapter()->query('TRUNCATE TABLE videos');
	  
	  $xlsData = new Spreadsheet_Excel_Reader($videosXls);
	  //return $xlsData->dump(true,true);
	  
	  //start at row 2 so as not to include the headers
	  for ($row=2; $row<=$xlsData->rowcount(); $row++) 
	    {         
	      $vals = array();
	      for ($col=1;$col<=$xlsData->colcount();$col++) {         
			$vals[] = $xlsData->value($row,$col);
		
	      }
	              
	      $start_date = $vals[0];
	      $start_date = str_replace('/', '_', $start_date);
	      
	      $parts = explode('_', $start_date);
	      $filename = $parts[2].'_'.$parts[0].'_'.$parts[1];
	      
	      $data = array(
			    'start_dt'           => $vals[0],
			    'days'               => $vals[1],
			    'studio'             => $vals[2],
			    'course_name'        => $vals[3],
			    'course_number'      => $vals[4],
			    'section'            => $vals[5],
			    'description'        => $vals[6],
			    'instructor'         => $vals[7],
			    'semester'           => $vals[8],
			    'year'               => $vals[9],
			    'course_id'          => $vals[10],
			    'filename'           => $filename
			    );
	      
	      //var_dump($data); 
	      //insert videos.xls into videos table                  
	      $this->insert($data); 
	    }
	  

	  //access courses table
	  $coursesTable = new Application_Model_DbTable_Courses();
	  
	  //empty the table
	  $this->getAdapter()->query('TRUNCATE TABLE courses');
	  
	  $coursesXlsData = new Spreadsheet_Excel_Reader($coursesXls);
	  
	  //add courses data from courses.xls
	  for ($row=2; $row<=$coursesXlsData->rowcount(); $row++) 
	    {         
	      $vals = array();
	      for ($col=1;$col<=$coursesXlsData->colcount();$col++) {         
		$vals[] = $coursesXlsData->value($row,$col);
		
	      }
	      
	      $data = array(
			    'start_dt'    => $vals[0],
			    'days'        => $vals[1],
			    'studio'      => $vals[2],
			    'start_time'  => $vals[3],
			    'duration'    => $vals[4],
			    'course_name' => $vals[5],
			    'section'     => $vals[6],
			    'course_id'   => $vals[7],
			    );  

                              
	      $coursesTable->insert($data); 
	    }
	  
	  
	  //get newly inserted videos data
	  $newdata = $this->fetchAll();
	  //var_dump($newdata);   
	  
	  
	  //update courses table with data from videos table
	  $videosData = array();
	  foreach ($newdata as $d)
	    {
	      //echo $d['course_id'];
	      $videosData = array(
				  'instructor' => $d['instructor'],
				  'semester'   =>  $d['semester'],
				  'year'   =>  $d['year'],
				  'course_name'   =>  $d['course_name'],
				  'course_number' =>  $d['course_number'],
				  'description'   =>  $d['description'],
				  );
	      
	      $where = $coursesTable->getAdapter()->quoteInto('course_id = ?', $d['course_id']);
	      $coursesTable->update($videosData, $where);
	    }
	  
	  //var_dump($videosData);

	  $coursesRows = $coursesTable->fetchAll();
	  $courseRowCount = count($coursesRows);
	  //var_dump($coursesData);

	  $videosRows = $this->fetchAll();
	  $videoRowCount = count($videosRows);

	  
	  $tr = new Zend_Mail_Transport_Smtp('smtp.csus.edu');
	  Zend_Mail::setDefaultTransport($tr);
            
	  $mail = new Zend_Mail();
	  $mail->setBodyText('Courses and Videos tables have been updated. There are ' .$courseRowCount. 'courses and ' .$videoRowCount. 'videos.');
	  $mail->setFrom('charles.brownroberts@csus.edu', 'Charles');
	  $mail->addTo('charlesbrownroberts@gmail.com', 'California Vol');
	  $mail->setSubject('Courses.xls');
	  $mail->send();

	}


    
}