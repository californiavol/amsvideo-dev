<?php

class Playlist_Model_DbTable_PlaylistVideos extends Zend_Db_Table_Abstract
{

    protected $_name = 'playlist_videos';
    
    
    protected $_referenceMap    = array(
        'Playlist' => array(
            'columns'           => array('playlist_id'),
            'refTableClass'     => 'Playlist_Model_DbTable_Playlists',
            'refColumns'        => array('id'),
    		'onDelete'          => self::CASCADE, 
    		'onUpdate'          => self::RESTRICT
        )
    );     
    
    



}

