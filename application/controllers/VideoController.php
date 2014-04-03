<?php

class VideoController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	
    	$this->db_table = new Application_Model_DbTable_Videos();
    	
    	//set context switch for xml output in rssAction()
    	$contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->addActionContext('rss', 'xml')
                      ->initContext();
    }

    public function indexAction()
    {
        // action body
    }

    public function rssAction()
    {
        //disable layout so that output is in xml format set in init()
    	$this->_helper->layout->disableLayout();
    	$this->_response->setHeader('Content-Type', 'text/xml; charset=utf-8');
    	
    	$id = $this->_getParam('cid');
    	$items = $this->db_table->getCourseVideos($id);
    	//var_dump($items);
    	
        $feed = new Zend_Feed_Writer_Feed;
		$feed->setTitle('Sacramento State Streaming Videos');
		$feed->setLink('http://www2.csus.edu/video');
		$feed->setFeedLink('http://www.example.com/atom', 'atom');
		$feed->addAuthor(array(
		    'name'  => 'Sacramento State',
		    'email' => 'webmaster@csus.edu',
		    'uri'   => 'http://www.csus.edu',
		));
		$feed->setDateModified(time());
		$feed->setDescription('Sacramento State Streaming Videos');
		 
		/**
		* Add one or more entries.
		*/
    	foreach ($items as $item) {
    		//var_dump($item);
			$entry = $feed->createEntry();
			$entry->setTitle($item['id']);
			$entry->setLink('http://www2.csus.edu/video/default/index/index/cid/'.$item['class_nbr'].'/vid/'.$item['id']);
			$entry->addAuthor(array(
			    'name'  => $item['instructor'],
			));
			//$entry->setDateModified(time());
			$entry->setDateCreated(strtotime($item['live_start_datetime']));
			$entry->setDescription($item['course_name'].' '.$item['course_number']);
			//$entry->setContent('I am not writing the article. The example is long enough as is ;).');
			$feed->addEntry($entry);    		
    	}
        
        $this->view->rssoutput = $feed->export('rss');
    }


}









