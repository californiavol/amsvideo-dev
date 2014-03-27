<?php

class Admin_Model_DbTable_Playlists extends Zend_Db_Table_Abstract
{

    protected $_name = 'playlists';
    
    
 	public function listitems()
 	{
 		
 	} 
    
 	public function add()
 	{
 		
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