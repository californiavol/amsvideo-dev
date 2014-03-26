<form enctype="application/x-www-form-urlencoded" method="post"
	class="form-inline" action="">
<div>
<div class="sr-only"><label for="name" class="required">Department/Program:</label>
<div class="form-group"><input type="text" name="name" id="name"
	value="" class="form-control"></div>
</div>
<div class="sr-only"><label for="submit" class="optional">Submit</label>
<div class="form-group"><input type="submit" name="submit" id="submit"
	value="Submit"></div>
</div>
</div>
</form>

<?php

class Admin_Form_Department extends Zend_Form
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
        
    	
    	$this->setMethod('post');
    	$this->setAttrib('class', 'form-inline');
 
        $this->addElement(
            'text', 'name', array(
		        'decorators' => $this->elementDecorators,
                'label' => 'Department/Program:',
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

