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
        // action body
        $playlistVideos = $this->playlist_videos_tbl->getPlaylistVideos();
        $this->view->playlistVideos = $playlistVideos;
        //var_dump($playlistVideos);
    }
    
    public function deleteAction()
    {
    	$id = $this->getParam('pl');
    	$this->playlists_tbl->deletePlaylist($id);
    	$this->_helper->redirector('index', 'index', 'playlist');
    }


}

