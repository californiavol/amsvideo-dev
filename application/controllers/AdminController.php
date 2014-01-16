<?php

class AdminController extends Zend_Controller_Action
{

    public $courseId = '100796';
    public $videoId = NULL;
	
	public function init()
    {
        /* Initialize action controller here */
    	
    	//get db tables  
    	$this->videosTable = new Application_Model_DbTable_Videos();
    	
    	$this->coursesTable = new Application_Model_DbTable_Courses();
    }
	
    /**
     * 
     * TODO remove hard-coded course_id
     */
    public function indexAction()
    {

            
    }
    
    public function courselistAction()
    {
    	
    	$this->view->courses = $this->coursesTable->getCourses();

    }
    
    public function insertcoursesAction()
    {
    	$this->coursesTable->insertCsv();
    }
    
    public function insertvideosAction()
    {
    	$this->videosTable->insertCsv();
    }
    
    
    public function cleancacheAction()
    {
        // action body
        $cache = Zend_Registry::get('cache');
        
        if($cache->clean(Zend_Cache::CLEANING_MODE_ALL)) {
        	$this->view->cleancache = 'Cache has been cleaned.';
        } else {
			$this->view->cleancache = 'Cache was not cleaned!';	    	
        }
        
    }
    

//close class
}