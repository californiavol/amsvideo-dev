<?php

class Admin_StreamController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	//set different layout
    	$this->_helper->layout->setLayout('admin-layout');   

    	$this->db_table = new Admin_Model_DbTable_Streams();
    }

    public function indexAction()
    {
        // action body
        $this->view->listitems = $this->db_table->listitems();
    }


}

