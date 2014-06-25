<?php

class Playlist_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	//set different layout
    	$this->_helper->layout->setLayout('playlist-layout');   

    	
    	$this->playlists_tbl = new Playlist_Model_DbTable_Playlists();
    	$this->playlist_videos_tbl = new Playlist_Model_DbTable_PlaylistVideos();
   	  
    }

    public function indexAction()
    {
        $playlists = $this->playlists_tbl->listitems();
        
        $this->view->playlists = $playlists;
    }
    



}

