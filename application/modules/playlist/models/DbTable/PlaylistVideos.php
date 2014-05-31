<?php

class Playlist_Model_DbTable_PlaylistVideos extends Zend_Db_Table_Abstract
{

    protected $_name = 'playlist_videos';
    
    
    public function getPlaylistVideos()
    {
        $select = $this->select()
        		->from($this->_name);
 		
		$rows = $this->fetchAll($select);
		return $rows;     	
    }


}

