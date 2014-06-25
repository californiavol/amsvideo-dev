<?php

class Playlist_AdminController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function deleteAction()
    {
    	$id = $this->getParam('pl');
    	$this->playlists_tbl->deletePlaylist($id);
    	$this->_helper->redirector('index', 'index', 'playlist');
    }


}



