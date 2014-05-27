<?php

class Admin_Form_Login extends App_Form
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
 
    private $checkboxDecorators = array(
        'Label',
        'ViewHelper',
        array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'checkbox')),
        array(array('row' => 'HtmlTag'), array('tag' => 'li')),
    );
 
    public function init()
    {
    	parent::init();
    	
        $this->setMethod('post');
 
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
 
        $submit = new Zend_Form_Element_Submit('login', array(
            'decorators' => $this->buttonDecorators,
            'label' => 'Login',
            'class' => 'input-submit'
        ));
 
        $this->addElements(array(
            $username,
            $password,
            $submit
        ));
    }
 
    public function loadDefaultDecorators()
    {
        $this->setDecorators(array(
            'FormErrors',
            'FormElements',
            array('HtmlTag', array('tag' => 'ul')),
            'Form'
        ));
    }

}

