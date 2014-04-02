<?php

class Admin_StreamController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	//set different layout
    	$this->_helper->layout->setLayout('admin-layout');   

    	$this->db_table = new Admin_Model_DbTable_Streams();
    	
    	$this->request = $this->getRequest(); 	
	    $this->form = new Admin_Form_Stream();
    }

    public function indexAction()
    {
        // action body
        $this->view->listitems = $this->db_table->listitems();
    }

    public function getstreamAction()
    {
        // action body
        $id = $this->_getParam('id');
        $this->view->stream = $this->db_table->getStreamById($id);
    }

    public function addAction()
    {
        // IF POST DATA HAS BEEN SUBMITTED
	    if ($this->request->isPost()) {
	        // IF THE REGISTER FORM HAS BEEN SUBMITTED AND THE SUBMITTED DATA IS VALID
	        if ($this->form->isValid($_POST)) {
	 
	            $data = $this->form->getValues();
				//var_dump($data);
		        $this->db_table->add($data);
	        }
	    }	
    	
        $this->view->form = $this->form;
    }

    public function editAction()
    {
        // action body
    }

    public function deleteAction()
    {
        // action body
    }

    public function listAction()
    {
        // action body
    }


}











