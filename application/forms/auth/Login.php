<?php


class Application_Form_Auth_Login extends App_Form
{
	
	public function init()
	{
		parent::init();
		
 		$this->setMethod('post');
 
        $this->addElement(
            'text', 'username', array(
                'label' => 'Username:',
                'required' => true,
                'filters'    => array('StringTrim', 'HTMLPurifier'),
            ));
 
        $this->addElement('password', 'password', array(
            'label' => 'Password:',
            'required' => true,
        'filters'    => array('HTMLPurifier'),
            ));
 
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Login',
            ));		
	}	
	
	
}