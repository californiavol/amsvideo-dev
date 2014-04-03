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

    public function rssAction()
    {
        //set different layout
    	$this->_helper->layout->setLayout('rss-layout');
    	
    	
        $feed = new Zend_Feed_Writer_Feed;
		$feed->setTitle('Paddy\'s Blog');
		$feed->setLink('http://www.example.com');
		$feed->setFeedLink('http://www.example.com/atom', 'atom');
		$feed->addAuthor(array(
		    'name'  => 'Paddy',
		    'email' => 'paddy@example.com',
		    'uri'   => 'http://www.example.com',
		));
		$feed->setDateModified(time());
		$feed->setDescription('cool blog');
		 
		/**
		* Add one or more entries. Note that entries must
		* be manually added once created.
		*/
		$entry = $feed->createEntry();
		$entry->setTitle('All Your Base Are Belong To Us');
		$entry->setLink('http://www.example.com/all-your-base-are-belong-to-us');
		$entry->addAuthor(array(
		    'name'  => 'Paddy',
		    'email' => 'paddy@example.com',
		    'uri'   => 'http://www.example.com',
		));
		$entry->setDateModified(time());
		$entry->setDateCreated(time());
		$entry->setDescription('Exposing the difficultly of porting games to English.');
		$entry->setContent(
		    'I am not writing the article. The example is long enough as is ;).'
		);
		$feed->addEntry($entry);
        
        $this->view->rssoutput = $feed->export('rss');
    }


}













