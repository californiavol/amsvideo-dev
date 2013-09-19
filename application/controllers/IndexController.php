<?php

class IndexController extends Zend_Controller_Action
{

    public $courseId = null;

    public $videoId = null;

    public $section = null;

    public function init()
    {
        /* Initialize action controller here */
                        if ($this->getRequest()->getParam('cid')) {
                        	$this->courseId = $this->getRequest()->getParam('cid');
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
                        $this->devicesTable    = new Application_Model_DbTable_Devices();
                        $this->videostatsTable = new Application_Model_DbTable_Videostats();
                        
        				$ajaxContext = $this->_helper->getHelper('AjaxContext');
        				$ajaxContext->addActionContext('devicestats', 'json')
                    				->initContext();
    }

    public function indexAction()
    {
        if ($this->courseId) {
                   	//get all courses for course list
                   	$this->view->courses = $this->coursesTable->getCourses();
                        	
                   	//get individual course if courseId param set
                   	$this->view->course = $this->coursesTable->getCourseById($this->courseId);;
                			
                   	//get videos by courseId
                   	//$this->view->coursevideos = $this->videosTable->getVideosByCourseId($this->courseId);
                	$this->view->coursevideos = $this->videosTable->getVideosByCourseIdSectionId($this->courseId, $this->section);	
                        	
                	//get most recent video by date and courseId
                    $this->view->recentvideo = $this->videosTable->getMostRecentVideo($this->courseId);        
                } 
                        
                
                        
                if ($this->videoId) {
                    $this->view->video = $this->videosTable->getVideoById($this->videoId);
                    //log video page load if course_id and section exist
                    if ($this->courseId != NULL && $this->section != NULL) {
                    	$this->videostatsTable->logVideoPageLoad($this->videoId, $this->courseId, $this->section);
                    }
                }
    }

    public function edsAction()
    {
        if ($this->courseId) {
                		//get all courses for course list                                                                                           
                		$this->view->courses = $this->coursesTable->getCourses();
                
                        //get individual course if courseId param set                                                                               
                        $this->view->course = $this->coursesTable->getCourseById($this->courseId);;
                
                        //get videos by courseId and section                                                                                       
                        $this->view->coursevideos = $this->videosTable->getVideosByCourseIdSectionId($this->courseId, $this->section);
                
                        //get most recent video by date and courseId                                                                                
                        $this->view->recentvideo = $this->videosTable->getMostRecentVideo($this->courseId);
                      } else {
                        //this is a one-off so we're hardcoding the course_id and section                                                           
                        $courseId = '118741';
                        $section = '03';
                        //get videos by courseId and section                                                                                       
                        $this->view->coursevideos = $this->videosTable->getVideosByCourseIdSectionId($courseId, $section);
                      }
                      if ($this->videoId) {
                        $this->view->video = $this->videosTable->getVideoById($this->videoId);
                      }
    }

    public function mgmtAction()
    {
        if ($this->courseId) {
                		//get all courses for course list                                                                                           
                		$this->view->courses = $this->coursesTable->getCourses();
                
                        //get individual course if courseId param set                                                                               
                        $this->view->course = $this->coursesTable->getCourseById($this->courseId);;
                
                        //get videos by courseId and section                                                                                       
                        $this->view->coursevideos = $this->videosTable->getVideosByCourseIdSectionId($this->courseId, $this->section);
                
                        //get most recent video by date and courseId                                                                                
                        $this->view->recentvideo = $this->videosTable->getMostRecentVideo($this->courseId);
                      } else {
                        //this is a one-off so we're hardcoding the course_id and section                                                           
                        $courseId = '154706';
                        $section = '10';
                        //get videos by courseId and section                                                                                       
                        $this->view->coursevideos = $this->videosTable->getVideosByCourseIdSectionId($courseId, $section);
                      }
                      if ($this->videoId) {
                        $this->view->video = $this->videosTable->getVideoById($this->videoId);
                      }
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

    public function atcsAction()
    {
        // action body
    }

    public function addvideosAction()
    {
        // action body
                        $this->videosTable->addVideosFromXls();
    }

    public function tests1Action()
    {
        // action body
    }

    public function strobeplayerAction()
    {
        // action body
    }

    public function phpcasAction()
    {
        // Load the settings 
                                        		$cas_host = 'testcas.csus.edu';
                                        		$cas_port = 443;
                                        		$cas_context = '/csus.cas';
                                        		$cas_server_ca_cert_path = 'serviceValidate';
                                        		// Load the CAS lib
                                        		require_once 'CAS.php';
                                        		
                                        		// Uncomment to enable debugging
                                        		phpCAS::setDebug();
                                        		
                                        		// Initialize phpCAS
                                        		phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
                                        		
                                        		// For production use set the CA certificate that is the issuer of the cert
                                        		// on the CAS server and uncomment the line below
                                        		phpCAS::setCasServerCACert($cas_server_ca_cert_path, false);
                                        		
                                        		// For quick testing you can disable SSL validation of the CAS server.
                                        		// THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
                                        		// VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
                                        		//phpCAS::setNoCasServerValidation();
                                        		
                                        		// force CAS authentication
                                        		phpCAS::forceAuthentication();
                                        		
                                        		// at this step, the user has been authenticated by the CAS server
                                        		// and the user's login name can be read with phpCAS::getUser().
                                        		
                                        		$this->view->phpCAS = phpCAS;
                                        		
                                        		// logout if desired
                                        		if (isset($_REQUEST['logout'])) {
                                        			phpCAS::logout();
                                        		}
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

    public function detectAction()
    {
        $this->devicesTable->addDevice();
            	   	

            	
            	//log device type in devices table
                // what type of device?
                //$deviceType = $this->_helper->mobileDetect();
                
            	/*
                require_once APPLICATION_PATH . '/../library/vendors/Mobile-Detect-2.7.0/Mobile_Detect.php';
                
        	    $detect = new Mobile_Detect;
        	    //are we dealing with mobile, tablet, or computer?
        	    $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');        
                
                
            	$this->view->deviceType = $deviceType;
        	    
        	    switch ($deviceType) {
        	    	case 'phone':
        	    	//if it's a phone, what OS?
        	    	if ($detect->isiOS()) {
        	    		$this->view->os = 'iOS';
        	    	} elseif ($detect->isAndroidOS()) {
        	    		$this->view->os = 'Android OS';
        	    	} elseif ($detect->isBlackBerryOS()) {
        	    		$this->view->os = 'Blackberry OS';
        	    	} elseif ($detect->isWindowsMobileOS()) {
        	    		$this->view->os = 'Windows Mobile OS';
        	    	} elseif ($detect->isWindowsPhoneOS()) {
        	    		$this->view->os = 'Windows Phone OS';
        	    	} else {
        	    		$this->view->os = 'Unknown OS';
        	    	}
        	    	break;
        	    	case 'tablet':
        	    	//$this->view->deviceType = $deviceType;
        	    	break;
        	    	case 'computer':
        	    	//$this->view->deviceType = $deviceType;
        	    	$msie = strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE') ? true : false;
        			$firefox = strpos($_SERVER["HTTP_USER_AGENT"], 'Firefox') ? true : false;
        			$safari = strpos($_SERVER["HTTP_USER_AGENT"], 'Safari') ? true : false;
        			$chrome = strpos($_SERVER["HTTP_USER_AGENT"], 'Chrome') ? true : false;
        			
        	    	if ($firefox) {
        				$this->view->browser = 'This is Firefox';
        			}
        			 
        			// Safari or Chrome. Both use the same engine - webkit
        			if ($chrome) {
        				$this->view->browser = 'This is Chrome';	
        			}
        	
        	    	// Safari or Chrome. Both use the same engine - webkit
        			if ($safari) {
        				$this->view->browser = 'This is Safari';	
        			}
        			// IE
        			if ($msie) {
        				$this->view->browser = 'This is IE';
        			}
        	    	break;		    	
        	    	//default: $this->view->deviceType = 'computer';
        	    	//break;
        	    }
        	    */
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
		   ->setLabels('Computer','Phone','Tablet');
		   ;
		   
		   
		$gc->getSerie( 'data1' )->addSerie( array($computerCount,$phoneCount, $tabletCount) );
		$gc->setParam('chco', '#f0e1b0');

		$this->view->chart = $gc;
        

    }


}



