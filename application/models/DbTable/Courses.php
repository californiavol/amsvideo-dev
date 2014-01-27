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
        $rows = $this->fetchAll();
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
    	
    	$coursesCsv = APPLICATION_PATH . '/../data/csv/sac_cm_courses.csv';
    	
    	if (!file_exists($coursesCsv)) {
    		die();
    	}
    	
    	$inputFile = $coursesCsv;
    	
    	$csv = new File_CSV_DataSource;
		$csv->load($inputFile);
		$csvarray = $csv->connect();
		return $csvarray;    	
    }
    
    private function _insertCsv2Db($data = null)
    {
    	$csvData = $data;
    	
	  	//empty the courses table
	  	$this->getAdapter()->query('TRUNCATE TABLE courses');    	
    	
    	$val = array();
    	foreach ($csvData as $val) {
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
    		);
    		//var_dump($data);	
    		$this->insert($data);	
    	}
    }

    




}