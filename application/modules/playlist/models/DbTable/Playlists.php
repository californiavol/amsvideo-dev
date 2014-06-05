<?php

class Playlist_Model_DbTable_Playlists extends Zend_Db_Table_Abstract
{

    protected $_name = 'playlists';
    
    protected $_dependentTables = array('Playlist_Model_DbTable_PlaylistVideos');
  
    
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
 	 

    public function getPlaylistVideos($id)
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);				
 		$select->from(array('pl' => $this->_name), 
                     array('pl_name' => 'pl.name')) 
               ->join(array('plv' => 'playlist_videos'), 
                      'plv.playlist_id = pl.id',
               			array())
               ->join(array('s' => 'streams'), 's.id = plv.video_id', array('s_id' => 's.id', 'name'))			 
               ->where('pl.id = ?', $id); 				
				
 		
		$rows = $this->fetchAll($select);
		return $rows;     	
    }
	
	public function deletePlaylist($id)
	{
		//find the row that matches the id
		$row = $this->find($id)->current();
		if ($row) {
			//delete dependent rows
			$row->delete();
			return true;
		} else {
			throw new Zend_Exception('Delete playlist failed; could not find playlist');
		}
	} 	
 	
 	
 	


}

