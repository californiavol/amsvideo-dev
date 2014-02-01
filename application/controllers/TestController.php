<?php

class TestController extends Zend_Controller_Action
{

    public $courseId = null;

    public $videoId = null;
    
    public $section = NULL;

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
        $this->coursesTable = new Application_Model_DbTable_Courses();       		                                                                                  
        $this->videosTable = new Application_Model_DbTable_Videos();
        
        //ajax setup
    	$ajaxContext = $this->_helper->getHelper('AjaxContext');
    	$ajaxContext->addActionContext('videolist', 'html')
                ->initContext();
    }

 public function indexAction()
    {
        // action body
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

    public function videosAction()
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
                        			phpCAS::logout(); }
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

    

    
}