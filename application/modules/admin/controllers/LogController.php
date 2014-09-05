<?php

class Admin_LogController extends Zend_Controller_Action
{
	
	public $dependencies = array(
        'Log',
    );

    public function init()
    {
    	//set different layout
    	$this->_helper->layout->setLayout('admin-layout');
    }

    public function indexAction()
    {
        $this->view->msg =   'test exception';
        
        $message = new Zend_Exception('exception occured');
        
		App_FileLogger::info($message);
    }


}

