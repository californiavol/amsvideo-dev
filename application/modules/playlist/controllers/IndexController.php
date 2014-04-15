<?php

class Playlist_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	//set different layout
    	$this->_helper->layout->setLayout('playlist-layout');   

    	
    	$this->db_table = new Playlist_Model_DbTable_Playlists();
   	  
    }

    public function indexAction()
    {
        // action body
    }


}

