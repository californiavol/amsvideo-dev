<?php

class Playlist_IndexController extends Zend_Controller_Action
{

    public function init()
    {
    	//set different layout
    	$this->_helper->layout->setLayout('playlist-layout');
    	
    	//get playlists table
		$this->db_table = new Playlist_Model_DbTable_Playlists();
    }

    public function indexAction()
    {
        // action body
        
    	$playlists = $this->db_table->listitems();
    	$this->view->playlists = $playlists;
    	
    }


}

