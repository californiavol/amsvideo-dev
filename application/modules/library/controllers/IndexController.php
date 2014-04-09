<?php

class Library_IndexController extends Zend_Controller_Action
{

    public function init()
    {
    	//set different layout
    	$this->_helper->layout->setLayout('library-layout');
    }

    public function indexAction()
    {
        // action body
    }


}

