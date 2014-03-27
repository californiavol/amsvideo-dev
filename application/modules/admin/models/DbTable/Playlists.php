<?php

class Admin_Model_DbTable_Playlists extends Zend_Db_Table_Abstract
{

    protected $_name = 'playlists';
    
    
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
 	
 	public function delete($where = null)
 	{
 		if ($where == NULL) {
 			return FALSE;
 		}
 	}  	
    
}