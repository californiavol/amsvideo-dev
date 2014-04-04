<?php

class Admin_Model_DbTable_Streams extends Zend_Db_Table_Abstract
{

    protected $_name = 'streams';

 	public function listitems()
 	{
    	$select = $this->select();
		$select->setIntegrityCheck(false);
				
		$result = $this->fetchAll($select);
    	
	    return $result; 		
 	}   
 	
 	public function add(array $data)
 	{
        return $this->insert($data);
 	} 

 	public function edit()
 	{
 		
 	} 
 	
 	public function delete($where = null)
 	{
 		if ($where == NULL) {
 			return FALSE;
 		}
 	}  

 	
 	public function getStreamById($id = NULL)
 	{
 		$row = $this->fetchRow($this->select()->where('id = ?', $id));
		return $row;  
 	}
 	
}

