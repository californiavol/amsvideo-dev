<?php

class Application_Model_DbTable_Courses extends Zend_Db_Table_Abstract
{

    protected $_name = 'courses';
    
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

