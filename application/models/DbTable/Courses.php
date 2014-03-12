<?php

class Application_Model_DbTable_Courses extends Zend_Db_Table_Abstract
{

    protected $_name = 'courses';
    

    public function init()
    {
		//$logger = Zend_Registry::get('log');
		//$this->logger = $logger;
		//$this->logger->log('Informational message', Zend_Log::INFO);
    }   
    
    public function getCourses()
    {
        $select = $this->select()
        		->from($this->_name)
        		->order('name');
 		
		$rows = $this->fetchAll($select);
		return $rows;
    }
    
    public function getCourseCount()
    {
        $rows = $this->fetchAll();
        $rowCount = count($rows);
        return $rowCount;      	
    }
    
    public function getCourseByClassNbr($classNbr)
    {
 		if ($classNbr == NULL) {
	  		return;
		}
		
		$row = $this->fetchRow($this->select()->where('class_nbr = ?', $classNbr));
		return $row;   	
    }
    
	public function getCourseVideos($class_nbr)
	{
		$select = $this->select();
		$select->setIntegrityCheck(false);
		$select->where('class_nbr = ?', $class_nbr)
				->join('videos', 'courses.class_nbr = videos.class_nbr')
				->where('videos.class_nbr = ?', $class_nbr);
				
		$rows = $this->fetchAll($select);
		return $rows;
	}
    
	public function getCurrentSemester()
	{
		$row = $this->fetchRow($this->select()->limit(1));
		$semester = $row->semester;
		return $semester; 		
	}
	
	public function getCurrentYear()
	{
		$row = $this->fetchRow($this->select()->limit(1));
		$year = $row->year;
		return $year; 		
	}
	
    public function parseCsv()
    {
    	$this->_parseCsv();
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

    private function _parseCsv()
    {
    	require_once APPLICATION_PATH . '/../library/vendors/Datasource.php';
    	
    	$inputFile = APPLICATION_PATH . '/../data/csv/sac_cm_courses.csv';
    	$csv = new File_CSV_DataSource;
		$csv->load($inputFile);
		$csvArray = $csv->connect();
		//var_dump($csvArray);
		return $csvArray;    	
    }
    
    private function _insertCsv2Db($data = null)
    {
    	$csvData = $data;
    	//var_dump($csvData);
	  	
    	//empty the courses table
	  	$this->getAdapter()->query('TRUNCATE TABLE courses');    	
    	
    	$val = array();
    	foreach ($csvData as $val) {
    		
    		//START_DT $val['START_DT'] 1/27/14
    	  	$start_date = $val['START_DT'];
	      	$date_part  = explode('/', $start_date);
	      	
	      	$year  = $date_part[2];
	      	$month = $date_part[0];
	      	$day   = $date_part[1];
    	
			//START_TIME 'START_TIME' 19:30:00
			$start_time = $val['START TIME'];
			$start_time_part = explode(':', $start_time);
	      	
	      	$hour   = $start_time_part[0]; 
	      	$minute = $start_time_part[1];
	      	$second = $start_time_part[2];
	      	
			$datearray = array('hour'   => $hour,
			                   'minute' => $minute,
			                   'second' => $second);	      	
	      	$start_time_time = new Zend_Date();
	      	
	      	//DURATION 'DURATION' 0:50
	      	$duration = $val['DURATION'];
	      	$duration_part = explode(':', $duration);
	      	
	      	$hour   = $duration_part[0]; 
	      	$minute = $duration_part[1];
	           	
			$datearray = array('hour'   => $hour,
			                   'minute' => $minute,
			                   'second' => 00);
			$duration_time = new Zend_Date($datearray);  
			
    		$available_time = date('H:i:s', strtotime($start_time)+strtotime($duration_time));
    		$available_time = date('H:i:s', strtotime($available_time)+10800);
    		
    		$data = array(
    			'start_dt' => $val['START_DT'],
    			'days' => $val['DAYS'],
    			'studio' => $val['STUDIO'],
    			'start_time' => $val['START TIME'],
    			'duration' => $val['DURATION'],
    			'name' => $val['NAME'],
    			'class_section' => $val['CLASS_SECTION'],
    			'crse_id' => $val['CRSE_ID'],
    			'course_name' => $val['COURSE_NAME'],
    			'course_number' => $val['COURSE_NUMBER'],
    			'section' => $val['SECTION'],
    			'course_description' => $val['COURSE_DESCRIPTION'],
    			'instructor' => $val['INSTRUCTOR'],
    			'semester' => $val['SEMESTER'],
    			'year' => $val['YEAR'],
    			'class_nbr' => $val['CLASS_NBR'],
    			'combined_id' => $val['COMBINED_ID'],
    			'combined_class_nbr' => $val['COMBINED_CLASS_NBR'],
    		    'available_time' => $available_time,
    		);
    		//var_dump($data);
    		$this->insert($data);	
    			
    	}
    	return TRUE;
    }

    




}