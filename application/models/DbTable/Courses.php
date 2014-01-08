<?php

class Application_Model_DbTable_Courses extends Zend_Db_Table_Abstract
{

    protected $_name = 'courses';
    
    public function init()
    {
		$logger = Zend_Registry::get('log');
		$this->logger = $logger;
		//$this->logger->log('Informational message', Zend_Log::INFO);
    }   
    
    public function getCourses()
    {
        $rows = $this->fetchAll();
        return $rows;    	
    }
    
    public function getCourseById($id)
    {
    	if ($id == NULL) {
	  		return;
		}
		
		$row = $this->fetchRow($this->select()->where('course_id = ?', $id));
		return $row;	
    }
    
    
    public function insertCsv()
    {
    	$data = $this->_parseCsv();
    	return $data;
    }
    
    private function _parseCsv()
    {
    	 $coursesCsv = APPLICATION_PATH . '/../data/csv/sac_cm_courses.csv';	
    	 
    	 if (file_exists($coursesCsv)) {
	    	$exception = new Zend_Exception('Courses CSV did not parse');
	    	$this->logger->err($exception);
	     }
	    
	    
		require_once APPLICATION_PATH . '/../library/vendors/DataSource.php';
		
		$csv = new File_CSV_DataSource;
		
		$csv->load($coursesCsv);
		$csvarray = $csv->connect();
		
		$rowCount = $csv->countRows();
		
    	for ($row=1; $rowCount; $row++) 
		{         
	  		
	  
			$data = array(
				'start_dt'    => $csvarray[0],
				'days'        => $csvarray[1],
				'studio'      => $csvarray[2],
				'start_time'  => $csvarray[3],
				'duration'    => $csvarray[4],
				'course_name' => $csvarray[5],
				'section'     => $csvarray[6],
				'course_id'   => $csvarray[7],
			);  

			var_dump($data);                  
	  		//$this->insert($data); 
		}   
    }
    
    
    public function addCoursesFromXls()
    {
    	return $this->_addCourses();
    }

    private function _addCourses()
    {
      //load the excel parser
      error_reporting(E_ALL ^ E_NOTICE);
      require_once APPLICATION_PATH . '/../library/vendors/excel_reader2.php';
      
      $xlsPath = APPLICATION_PATH . '/../data/courses.xls';
      
      $xlsData = new Spreadsheet_Excel_Reader($xlsPath);
      //return $xlsData->dump(true,true);
      for ($row=2; $row<=$xlsData->rowcount(); $row++) 
	{         
	  $vals = array();
	  for ($col=1;$col<=$xlsData->colcount();$col++) {         
	    $vals[] = $xlsData->value($row,$col);
	    
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

	  // var_dump($data);                  
	  $this->insert($data); 
	}


    }



}

