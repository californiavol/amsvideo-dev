<?php

class CasController extends Zend_Controller_Action
{

    public function init()
    {
		$this->_helper->acl->allow(null);
    }

    public function indexAction()
    {
        // action body
        $this->view->msg = 'you are not logged in.';
    }

    public function loginAction()
    {
        // action body
       $this->auth = Zend_Auth::getInstance();
	    
	     
		//$options = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini');
	    
		$config = array(
		    'hostname'  => 'testcas.csus.edu',
		    'port'      => 443,
		    'path'      => 'csus.cas/',
		   
	
		);
		
		$this->adapter = new Zend_Auth_Adapter_Cas($config);
    	
    	
    	$this->adapter->setQueryParams($this->getRequest()->getQuery());
		$this->adapter->setTicket();
		
	    // If no identity is set and a ticket exists, attempt to authenticate
	    if(!$this->auth->hasIdentity() && $this->adapter->hasTicket()) {
	
	        $result = $this->auth->authenticate($this->adapter);
	        
	        if(!$result->isValid()) {
	            $this->view->messages = $result->getMessages();
	            return;
	        }
	    }
	    
        //if no identity send them to CAS
	    if(!$this->auth->hasIdentity()) {
	        $this->_redirect($this->adapter->getLoginUrl());
	    }
	    
	    //has identity so send to account page
	    if ($this->auth->hasIdentity()) {
	    	//redirect to account page
	    	$this->_redirect('/default/cas/account');
	    	
	    }
    }

    public function logoutAction()
    {
        $this->auth = Zend_Auth::getInstance();
        $this->auth->clearIdentity();
         
        // Specify the landing URL to hit after logout
        $landingUrl = 'http://' . $_SERVER['HTTP_HOST'];
        //$this->_redirect($this->adapter->getLogoutUrl($landingUrl));
        $this->_redirect('https://testcas.csus.edu/csus.cas/logout');
    }

    public function accountAction()
    {
        $this->auth = Zend_Auth::getInstance();
    	if ($this->auth->hasIdentity()) {
        	$identity = $this->auth->getIdentity();
        } else {
        	$this->_redirect('/default/cas/login');
        }
    	
	    	
	    $this->view->identity = $identity->user;
	    $this->view->attributes = $identity->attributes;
    }

    public function noaccessAction()
    {
        // action body
    }


}









