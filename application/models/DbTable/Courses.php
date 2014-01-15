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

    public function parseCsv()
    {
    	$this->_parseCsv();
    }
    
    public function insertCsv() 
    {
    	$this->_insertCsv2Db();
    }

    
    public function getCourses()
    {
        $rows = $this->fetchAll();
        return $rows;    	
    }
    
    public function getCourseByClassNbr($classNbr)
    {
 		if ($classNbr == NULL) {
	  		return;
		}
		
		$row = $this->fetchRow($this->select()->where('class_nbr = ?', $classNbr));
		return $row;   	
    }
    
    public function getCourseById($id)
    {
    	if ($id == NULL) {
	  		return;
		}
		
		$row = $this->fetchRow($this->select()->where('course_id = ?', $id));
		return $row;	
    }
    
    

    

    

    private function _parseCsv()
    {
    	require_once APPLICATION_PATH . '/../library/vendors/Datasource.php';
    	
    	$coursesCsv = APPLICATION_PATH . '/../data/csv/sac_cm_courses.csv';
    	
    	
    	/*
    	 * // outputs e.g.  somefile.txt was last modified: December 29 2002 22:16:23.

			$filename = 'somefile.txt';
			if (file_exists($filename)) {
			    echo "$filename was last modified: " . date ("F d Y H:i:s.", filemtime($filename));
			}
    	 * 
    	 * */
    	
    	
    	if (!file_exists($coursesCsv)) {
    		die();
    	}
    	
    	$inputFile = $coursesCsv;
    	
    	$csv = new File_CSV_DataSource;
		$csv->load($inputFile);
		$csvarray = $csv->connect();
		return $csvarray;    	
    }
    
    private function _insertCsv2Db()
    {
    	$csvData = $this->_parseCsv();
    	
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

