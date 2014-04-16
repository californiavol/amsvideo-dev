<?php

class Admin_Form_Register extends App_Form
{

 	private $elementDecorators = array(
        'ViewHelper',
        array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'element')),
        'Label',
        array(array('row' => 'HtmlTag'), array('tag' => 'li')),
    );
 
    private $buttonDecorators = array(
        'ViewHelper',
        array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'button')),
        array(array('row' => 'HtmlTag'), array('tag' => 'li')),
    );
 
    public function init()
    {
    	parent::init();
    	
        $this->setMethod('post');
 
        $firstName = new Zend_Form_Element_Text('first_name', array(
            'decorators' => $this->elementDecorators,
            'label' => 'First name',
            'required' => true,
            'filters' => array(
                'StringTrim', 'HTMLPurifier'
            ),
            'validators' => array(
                array('StringLength', false, array(2, 50))
            ),
            'class' => 'input-text'
        ));
 
        $lastName = new Zend_Form_Element_Text('last_name', array(
            'decorators' => $this->elementDecorators,
            'label' => 'First name',
            'required' => true,
            'filters' => array(
                'StringTrim', 'HTMLPurifier'
            ),
            'validators' => array(
                array('StringLength', false, array(2, 50))
            ),
            'class' => 'input-text'
        ));
 
        $email = new Zend_Form_Element_Text('email', array(
            'decorators' => $this->elementDecorators,
            'label' => 'Email',
            'required' => true,
            'filters' => array(
                'StringTrim', 'HTMLPurifier'
            ),
            'validators' => array(
                'EmailAddress'
            ),
            'class' => 'input-text'
        ));
 

        $username = new Zend_Form_Element_Text('username', array(
            'decorators' => $this->elementDecorators,
            'label' => 'Username',
            'required' => true,
            'filters' => array(
                'StringTrim', 'HTMLPurifier'
            ),
            'validators' => array(
                array('StringLength', false, array(3, 50))
            ),
            'class' => 'input-text'
        ));
 
        $password = new Zend_Form_Element_Password('password', array(
            'decorators' => $this->elementDecorators,
            'label' => 'Password',
            'required' => true,
            'filters' => array(
                'StringTrim', 'HTMLPurifier'
            ),
            'validators' => array(
                array('StringLength', false, array(6, 50))
            ),
            'class' => 'input-password'
        ));
 
        
        $role = $this->createElement('select', 'role');
        
        $role->setDecorators($this->elementDecorators);
        $role->setLabel('Select a role');
        $role->addMultiOption('user', 'User');
        $role->addMultiOption('editor', 'Editor');
        $role->addMultiOption('admin', 'Admin');
        
        
 
        $submit = new Zend_Form_Element_Submit('register', array(
            'decorators' => $this->buttonDecorators,
            'label' => 'Register',
            'class' => 'input-submit'
        ));
 
        $this->addElements(array(
            $firstName,
            $lastName,
            $email,
            $username,
            $password,
            $role,
            $submit
        ));
    }
 
    public function loadDefaultDecorators()
    {
        $this->setDecorators(array(
            'FormErrors',
            'FormElements',
            array('HtmlTag', array('tag' => 'ol')),
            'Form'
        ));
    }

}

