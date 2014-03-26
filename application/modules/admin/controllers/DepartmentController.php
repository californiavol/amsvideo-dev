<?php

class Admin_DepartmentController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	//set different layout
    	$this->_helper->layout->setLayout('admin-layout');    	
    }

	/**
     * The default action - show the home page
     */
    public function indexAction ()
    {
        // TODO Auto-generated VideoController::indexAction() default action
    }


    public function listvideosAction ()
    {
		$this->view->videos = $this->videosTable->getAllVideos();
    }


    public function addvideoAction()
    {
        // action body
    }
    
    public function editvideoAction()
    {
        // action body
    }

    public function deletevideoAction()
    {
        // action body
    }


}

