<?php

class IndexController extends Zend_Controller_Action
{

    public $class_nbr = null;

    public $videoId = null;

    public $section = null;

    public function init()
    {
        /* Initialize action controller here */
        if ($this->getRequest()->getParam('cid')) {
           	$this->class_nbr = $this->getRequest()->getParam('cid');
        }
                                        
        if ($this->getRequest()->getParam('vid')) {
           	$this->videoId = $this->getRequest()->getParam('vid');
        }
                                        		
  		if ($this->getRequest()->getParam('sid')) {
   			$this->section = $this->getRequest()->getParam('sid');
   		}
                                        
        //get db tables                                                                                                              
        $this->coursesTable    = new Application_Model_DbTable_Courses();       		                                                                                  
        $this->videosTable     = new Application_Model_DbTable_Videos();


    }

    public function indexAction()
    {
    	$today = date("Y-m-d H:i:s"); 
    	
		$recentVideo = $this->videosTable->getMostRecentVideo($this->class_nbr);
		$this->view->recentVideo = $recentVideo;
		
		if ($today >= $recentVideo['recorded_available_datetime']) {
			$this->view->linkEnabled = 1;
		} else {
			$this->view->linkEnabled = 0;
		}
		
    	if ($this->class_nbr && !$this->videoId) {
	    	
    		//get individual course if class_nbr param set
    	    $this->view->course = $this->coursesTable->getCourseByClassNbr($this->class_nbr);
    		//get course associated videos
    	    $this->view->coursevideos = $this->videosTable->getVideosByClassNbr($this->class_nbr);
    	     		
    	} elseif ($this->class_nbr && $this->videoId) {
    		
    		//get individual course if class_nbr param set
    	    $this->view->course = $this->coursesTable->getCourseByClassNbr($this->class_nbr);
    		//get course associated videos
    		$coursevideos = 
    	    $this->view->coursevideos = $this->videosTable->getVideosByClassNbr($this->class_nbr);  			
			
			//get individual video
			$video = $this->videosTable->getVideoById($this->videoId);
    		$this->view->video = $video;
    		
    	    //we have to deal with fall 2013 videos which have different filename convention
			$betaThresholdDate = '2013-12-31 12:00:00';
			
    		$available_datetime = date('Y-m-d H:i:s', strtotime($video['recorded_available_datetime']));
			if ($available_datetime < $betaThresholdDate) {
				$this->view->useOsmf2013 = TRUE;
			}	
			
    	} else {
    		//redirect to courselist
    		$this->redirect('/default/index/welcome');
    	}
    	
		
    }
    
    public function welcomeAction()
    {
    	$this->view->courses = $this->coursesTable->getCourses();
    	$this->view->courseCount = $this->coursesTable->getCourseCount();
    }

    public function coursepageAction()
    {
    	$this->view->coursevideos = $this->videosTable->getVideosByClassNbr($this->class_nbr);
    }

    public function live1Action()
    {
        // action body
    }

    public function live2Action()
    {
        // action body
    }

    public function live3Action()
    {
        // action body
    }

    public function live4Action()
    {
        // action body
    }    

    public function outputlinksAction()
    {
        // action body
        $this->view->videolinks = $this->coursesTable->outputVideoLinks();
    }

    public function livetestAction()
    {
        // action body
    }

    public function courselistAction()
    {
        //get all courses for course list
        $this->view->courses = $this->coursesTable->getCourses();
    }

    public function devicestatsAction()
    {
        $computerCount = $this->devicesTable->getCountByDeviceType('computer');
        $this->view->computerCount = $computerCount;
        
        $tabletCount = $this->devicesTable->getCountByDeviceType('tablet');
        $this->view->tabletCount = $tabletCount;
        
        $phoneCount = $this->devicesTable->getCountByDeviceType('phone');
        $this->view->phoneCount = $phoneCount;
        
        
        $gc = Newsky_Google_Chart::factory( 'p3' );
		$gc->setWidth( 600 )
		   ->setHeight( 300 )
		   ->setTitle( 'Video Page Loads by Device Type' )
		   ->setLabels('Computer','Phone','Tablet')
		   ;
		   
		   
		$gc->getSerie( 'data1' )->addSerie( array($computerCount,$phoneCount, $tabletCount) );
		$gc->setParam('chco', '#f0e1b0');

		$this->view->chart = $gc;
		
		//browser stats - browsers by computer
		$computerIeCount = $this->devicesTable->getCountByDeviceTypeAndBrowser($deviceType = 'computer', $browser = 'IE');
		$this->view->computerIeCount = $computerIeCount;

		$computerFirefoxCount = $this->devicesTable->getCountByDeviceTypeAndBrowser($deviceType = 'computer', $browser = 'Firefox');
		$this->view->computerFirefoxCount = $computerFirefoxCount;

		$computerChromeCount = $this->devicesTable->getCountByDeviceTypeAndBrowser($deviceType = 'computer', $browser = 'Chrome');
		$this->view->computerChromeCount = $computerChromeCount;

		$computerSafariCount = $this->devicesTable->getCountByDeviceTypeAndBrowser($deviceType = 'computer', $browser = 'Safari');
		$this->view->computerSafariCount = $computerSafariCount;

		$computerUnknownCount = $this->devicesTable->getCountByDeviceTypeAndBrowser($deviceType = 'computer', $browser = 'unknown');
		$this->view->computerUnknownCount = $computerUnknownCount;	

		
		
		//browser stats - browsers by phone
		$phoneIeCount = $this->devicesTable->getCountByDeviceTypeAndBrowser($deviceType = 'phone', $browser = 'IE');
		$this->view->phoneIeCount = $phoneIeCount;

		$phoneFirefoxCount = $this->devicesTable->getCountByDeviceTypeAndBrowser($deviceType = 'phone', $browser = 'Firefox');
		$this->view->phoneFirefoxCount = $phoneFirefoxCount;

		$phoneChromeCount = $this->devicesTable->getCountByDeviceTypeAndBrowser($deviceType = 'phone', $browser = 'Chrome');
		$this->view->phoneChromeCount = $phoneChromeCount;

		$phoneSafariCount = $this->devicesTable->getCountByDeviceTypeAndBrowser($deviceType = 'phone', $browser = 'Safari');
		$this->view->phoneSafariCount = $phoneSafariCount;

		$phoneUnknownCount = $this->devicesTable->getCountByDeviceTypeAndBrowser($deviceType = 'phone', $browser = 'unknown');
		$this->view->phoneUnknownCount = $phoneUnknownCount;	
		

		//browser stats - browsers by tablet
		$tabletIeCount = $this->devicesTable->getCountByDeviceTypeAndBrowser($deviceType = 'tablet', $browser = 'IE');
		$this->view->tabletIeCount = $tabletIeCount;

		$tabletFirefoxCount = $this->devicesTable->getCountByDeviceTypeAndBrowser($deviceType = 'tablet', $browser = 'Firefox');
		$this->view->tabletFirefoxCount = $tabletFirefoxCount;

		$tabletChromeCount = $this->devicesTable->getCountByDeviceTypeAndBrowser($deviceType = 'tablet', $browser = 'Chrome');
		$this->view->tabletChromeCount = $tabletChromeCount;

		$tabletSafariCount = $this->devicesTable->getCountByDeviceTypeAndBrowser($deviceType = 'tablet', $browser = 'Safari');
		$this->view->tabletSafariCount = $tabletSafariCount;

		$tabletUnknownCount = $this->devicesTable->getCountByDeviceTypeAndBrowser($deviceType = 'tablet', $browser = 'unknown');
		$this->view->tabletUnknownCount = $tabletUnknownCount;		
    }



}





