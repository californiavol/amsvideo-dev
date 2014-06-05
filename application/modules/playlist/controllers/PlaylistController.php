<?php

class Playlist_PlaylistController extends Zend_Controller_Action
{

    public function init()
    {
    	//set different layout
    	$this->_helper->layout->setLayout('playlist-layout'); 
    	
    	$this->playlistTbl = new Playlist_Model_DbTable_Playlists();
    	$this->playlistVideosTbl = new Playlist_Model_DbTable_PlaylistVideos();
    	$this->streamsTbl = new Playlist_Model_DbTable_Streams();
    }

    public function indexAction()
    {
        $id = $this->getParam('plv');
        $playlistVideos = $this->playlistTbl->getPlaylistVideos($id);
        
        $this->view->playlistVideos = $playlistVideos;
    }


}

