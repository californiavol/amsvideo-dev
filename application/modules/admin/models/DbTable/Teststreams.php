<?php

class Admin_Model_DbTable_Teststreams extends Zend_Db_Table_Abstract
{

    protected $_name = 'teststreams';
    

    public function init()
    {

    }   

 	public function getTeststreams()
 	{
    	$select = $this->select();
		$select->setIntegrityCheck(false);
				
		$result = $this->fetchAll($select);
    	
	    return $result; 		
 	}   


    public function getTeststreamById($id)
    {
 		if ($id == NULL) {
	  		return;
		}
		
		$row = $this->fetchRow($this->select()->where('id = ?', $id));
		return $row;   	
    }
    

}