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
    	$this->coursesTable->insertCsv();
        
        //get most recent video by course
    	$mostRecentVideo = $this->videosTable->getMostRecentVideo($this->courseId);
    	$this->view->mostRecentVideo = $mostRecentVideo;	
    	
		//get individual course if courseId param set                                                                        
		$this->view->course = $this->coursesTable->getCourseById($this->courseId);    	
    	

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