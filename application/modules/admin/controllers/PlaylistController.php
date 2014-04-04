<?php

class Admin_PlaylistController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	//set different layout
    	$this->_helper->layout->setLayout('admin-layout');   

    	$this->db_table = new Admin_Model_DbTable_Playlists();

   	    $this->request = $this->getRequest(); 	
	    $this->form = new Admin_Form_Playlist();    
    }

	/**
     * The default action - show the home page
     */
    public function indexAction ()
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
    	
    	
        $this->view->form      = $this->form;
        $this->view->listitems = $this->db_table->listitems();
        //$this->view->count     = $this->db_table->getCount();
    }


    public function listAction ()
    {

    	$this->view->list = $this->db_table->listItems();
    }


    public function addAction()
    {
        // action body
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

}

