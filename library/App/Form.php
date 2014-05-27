<?php


class App_Form extends Zend_Form
{
	
	
	
	public function init()
	{
		$this->addElementPrefixPath(
 			'App_Filter',
 			APPLICATION_PATH . '/../library/App/Filter/',
 			'filter'
 		); 
	}
	
	
	
}