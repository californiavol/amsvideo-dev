<?php

class Admin_UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	
    	//set different layout
    	$this->_helper->layout->setLayout('admin-layout');
    	
    	$this->usersTable = new Admin_Model_DbTable_Users();
    }

    public function indexAction()
    {
        // action body
    }

    public function listusersAction()
    {
        // action body
        $result = $this->usersTable->getUsers();
        
        $page= $this->_getParam('page', 1);
	    $paginator = Zend_Paginator::factory($result);
	    $paginator->setItemCountPerPage(10);
	    $paginator->setCurrentPageNumber($page);
    	$this->view->paginator=$paginator;        
    }


}



