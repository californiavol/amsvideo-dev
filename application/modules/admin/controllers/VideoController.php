<?php
/**
 * VideoController
 * 
 * @author
 * @version 
 */

class Admin_VideoController extends Zend_Controller_Action
{

	public function init()
	{
    	//set different layout
    	$this->_helper->layout->setLayout('admin-layout');
    	
    	//get db tables
    	$this->videosTable = new Application_Model_DbTable_Videos();
    	
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





}
