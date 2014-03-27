<?php

class Admin_Model_DbTable_Departments extends Zend_Db_Table_Abstract
{

    protected $_name = 'departments';
    
	public function getCount()
	{
        $rows = $this->fetchAll();
        $rowCount = count($rows);
        return $rowCount;  
	}
    
 	public function listitems()
 	{
        $select = $this->select()
        		->from($this->_name)
        		->order('name');
 		
		$rows = $this->fetchAll($select);
		return $rows; 	 		
 	} 
    
 	public function add(array $data)
 	{
        return $this->insert($data);
 	} 

 	public function edit()
 	{
 		
 	} 
 	

    
}