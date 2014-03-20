<?php


class Application_Form_Embed extends Zend_Form
{
	
	public function init()
	{
 		$this->setMethod('post');
 
        $this->addElement(
            'text', 'width', array(
                'label' => 'Width:',
                'required' => true,
                'filters'    => array('StringTrim'),
            ));
 
        $this->addElement(
            'text', 'height', array(
                'label' => 'Height:',
                'required' => true,
                'filters'    => array('StringTrim'),
            ));

        $this->addElement(
            'text', 'rtmp_src', array(
                'label' => 'RTMP Src:',
                'required' => true,
                'filters'    => array('StringTrim'),
            ));            

        $this->addElement(
            'text', 'hds_src', array(
                'label' => 'HDS Src:',
                'required' => true,
                'filters'    => array('StringTrim'),
            ));            

        $this->addElement(
            'text', 'hls_src', array(
                'label' => 'HLS Src:',
                'required' => true,
                'filters'    => array('StringTrim'),
            ));            
            
        $this->addElement(
            'text', 'poster', array(
                'label' => 'Poster:',
                'required' => true,
                'filters'    => array('StringTrim'),
            ));            
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Create Code',
            ));		
	}	
	
	
}