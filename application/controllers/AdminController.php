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
        
        //get most recent video by course
    	$mostRecentVideo = $this->videosTable->getMostRecentVideo($this->courseId);
    	$this->view->mostRecentVideo = $mostRecentVideo;	
    	
		//get individual course if courseId param set                                                                        
		$this->view->course = $this->coursesTable->getCourseById($this->courseId);    	
    	
    	//todays date
        $today = $this->videosTable->getTodaysDate();
        $this->view->todaysDate = $today;
        
        //video release date
        $datearray = array('year' => 2013, 'month' => '09', 'day' => '09');
		$releaseDate = new Zend_Date($datearray);
		
		$this->view->releaseDate = $releaseDate;
		
		if ($releaseDate <= $today) {
			$this->view->availableDate = $releaseDate;
		} else {
			$this->view->availableDate = 'not yet available';
		}
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