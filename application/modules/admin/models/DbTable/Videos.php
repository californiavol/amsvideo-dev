<?php

class Admin_Model_DbTable_Videos extends Zend_Db_Table_Abstract
{

    protected $_name = 'videos';
    
    
 	public function listitems()
 	{
        $select = $this->select()
        		->from($this->_name)
        		->order('name');
 		
		$rows = $this->fetchAll($select);
		return $rows; 		
 	} 
    
 	public function add()
 	{
 		
 	} 

 	public function edit()
 	{
 		
 	} 
 	
 	public function delete()
 	{
 		
 	}  	
 	

    
}