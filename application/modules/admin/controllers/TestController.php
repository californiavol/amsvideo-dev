<?php

class Admin_TestController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	//set different layout
    	$this->_helper->layout->setLayout('admin-layout');

    	//get db tables
    	$this->teststreamsTable = new Admin_Model_DbTable_Teststreams();
    }

    public function indexAction()
    {
        // action body
        
    }

    public function teststreamAction()
    {
        // action body
        $id = $this->_request->getParam('tsid');
        $this->view->teststream = $this->teststreamsTable->getTeststreamById($id);
    	
    	
        $this->view->teststreams = $this->teststreamsTable->getTeststreams();
    }
    
    
}

