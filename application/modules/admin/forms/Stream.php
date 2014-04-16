<?php

class Admin_Form_Stream extends App_Form
{
	
	private $elementDecorators = array(
        'ViewHelper',
        array(array('data' => 'HtmlTag'), array('tag' => 'span')),
        'Label',
        array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form-group')),
    );
 
    private $buttonDecorators = array(
        'ViewHelper',
        array(array('data' => 'HtmlTag'), array('tag' => 'span')),
        
    );

    public function init()
    {
        parent::init();
        
        /* Form Elements & Other Definitions Here ... */
    	$this->setMethod('post');
    	$this->setAttrib('class', 'form');
 		$this->setAttrib('id', 'form-add-stream');
 		
        $this->addElement(
            'text', 'name', array(
		        'decorators' => $this->elementDecorators,
                'label' => 'Stream Name:',
        		'class' => 'form-control',
                'required' => true,
                'filters'    => array('StringTrim'),
            ));
 
 		$this->addElement(
            'text', 'rtmp_url', array(
		        'decorators' => $this->elementDecorators,
                'label' => 'RTMP URL:',
        		'class' => 'form-control',
                'required' => true,
                'filters'    => array('StringTrim'),
            ));
            
        $this->addElement(
            'text', 'hds_url', array(
		        'decorators' => $this->elementDecorators,
                'label' => 'HDS URL:',
        		'class' => 'form-control',
                'required' => true,
                'filters'    => array('StringTrim'),
            ));            

        $this->addElement(
            'text', 'hls_url', array(
		        'decorators' => $this->elementDecorators,
                'label' => 'HLS URL:',
        		'class' => 'form-control',
                'required' => true,
                'filters'    => array('StringTrim'),
            ));             
            
        $this->addElement('button', 'button', array(
        	'decorators' => $this->buttonDecorators,
            'class' => 'btn btn-default',
        	'type' => 'submit',
        	'ignore'   => true,
            'label'    => 'Submit',
            ));
    }


}

