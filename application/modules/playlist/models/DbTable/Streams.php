<?php

class Playlist_Model_DbTable_Streams extends Zend_Db_Table_Abstract
{

    protected $_name = 'streams';
    


	public function getPlaylistStream($id)
	{
 		$row = $this->fetchRow($this->select()->where('id = ?', $id));
		return $row;  		
	}
}

