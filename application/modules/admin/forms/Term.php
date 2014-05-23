<?php

class Admin_Form_Term extends App_Form
{
	
	private $elementDecorators = array(
        'ViewHelper',
        array(array('data' => 'HtmlTag'), array('tag' => 'span')),
        'Label',
        array(array('data' => 'HtmlTag'), array('tag' => 'span', 'class' => 'form-group')),
    );
 
    private $buttonDecorators = array(
        'ViewHelper',
        array(array('data' => 'HtmlTag'), array('tag' => 'span')),
        
    );

    public function init()
    {
        parent::init();
        
        /* Form Elements & Other Definitions Here ... */
    	$this->setMethod('get');
    	$this->setAttrib('class', 'form');
 		$this->setAttrib('id', 'form--get-term');
 		
 		$front = Zend_Controller_Front::getInstance();
 		$defaultSemester = $front->getRequest()->getParam('semester');
 		$defaultYear = $front->getRequest()->getParam('year');
 		
        $semester = $this->createElement('select', 'semester');
        $semester->setDecorators($this->elementDecorators);
        $semester->setLabel('Select a semester');
        $semester->addMultiOption('Fall', 'Fall');
        $semester->addMultiOption('Spring', 'Spring');
        $semester->addMultiOption('Summer', 'Summer');
 		$semester->addMultiOption('Winter', 'Winter');  
 		$semester->setValue($defaultSemester);      

 		$year = $this->createElement('select', 'year');
 		$year->setDecorators($this->elementDecorators);
        $year->setLabel('Select a year');
        $year->addMultiOption('2013', '2013');
        $year->addMultiOption('2014', '2014');
        $year->addMultiOption('2015', '2015');
 		$year->addMultiOption('2016', '2016');
 		$year->setValue($defaultYear);
            
            
        $submit = new Zend_Form_Element_Submit('submit', array(
            'decorators' => $this->buttonDecorators,
            'label' => 'Submit',
        	'type' => 'submit',
            'class' => 'btn btn-default'
        ));
 
        $this->addElements(array(
            $semester,
            $year,
            $submit
        ));    
            
            
    }


}