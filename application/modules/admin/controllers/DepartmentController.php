<?php

class Admin_DepartmentController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	//set different layout
    	$this->_helper->layout->setLayout('admin-layout');   

    	$this->_table = new Admin_Model_DbTable_Departments();
    }

	/**
     * The default action - show the home page
     */
    public function indexAction ()
    {
        $this->view->form = new Admin_Form_Department();
                
        $this->view->departments = $this->_table->listitems();
        
        $this->view->count = $this->_table->getCount();
    }


    public function listAction ()
    {

    	$this->view->list = $this->_table->listItems();
    }


    public function addAction()
    {
        // action body
        $this->view->form = new Admin_Form_Department();
    }
    
    public function editAction()
    {
        // action body
    }

    public function deleteAction()
    {
        // action body
    }


}

