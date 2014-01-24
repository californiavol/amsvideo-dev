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
    
    
    public function getVideosByClassNbr($id)
    {
		$rows = $this->fetchAll($this->select()->where('class_nbr = ?', $id));
		return $rows;
    }
    
    
    public function getVideoById($id)
    {
        if ($id == NULL) {
	  		return;
        }
    	$row = $this->fetchRow($this->select()->where('id = ?', $id));
		return $row;   	
    }
    

    
	public function getMostRecentVideo($id)
	{
	  	if ($id == NULL) {
			return;
	  	}
		
    	$today = new Zend_Date();
	  	$row = $this->fetchRow($this->select()
				 ->where('course_id = ?', '201066')
				 ->order('start_dt ASC')
				 ->limit(1)
				 );
    	
	  	return $row;
	}  
	
 	private function _parseCsv()
    {
    	require_once APPLICATION_PATH . '/../library/vendors/Datasource.php';
    	
    	$videosCsv = APPLICATION_PATH . '/../data/csv/sac_cm_videos.csv';
    	
    	if (!file_exists($videosCsv)) {
    		die();
    	}
    	
    	$inputFile = $videosCsv;
    	
    	$csv = new File_CSV_DataSource;
		$csv->load($inputFile);
		$csvarray = $csv->connect();
		return $csvarray;    	
    }
    
    public function insertCsv() 
    {
    	$this->_insertCsv2Db();
    }
    
 	private function _insertCsv2Db()
    {
    	$csvData = $this->_parseCsv();
    	
	  //empty the videos table
	  $this->getAdapter()->query('TRUNCATE TABLE videos');
    	
    	
    	$val = array();
    	foreach ($csvData as $val) {
    		
    		
    		$date = DateTime::createFromFormat('j-M-Y', $val['START_DT']);
			$start_dt =  $date->format('Y_m_d');
    				
    		
    		$data = array(
    			'start_dt'  => strtolower($start_dt),
    			'days'      => strtolower($val['DAYS']),
    			'studio'    => $val['STUDIO'],
    			'course_id' => $val['COURSE_ID'],    			
    			'class_nbr' => $val['CLASS_NBR'],

    		);
    		//var_dump($data);	
    		$this->insert($data); 
    	}
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
				  'course_number'   =>  $d['course_number'],
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