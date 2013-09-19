<?php
/**
 * Videostats
 * 
 * @author robertsc
 * @version 
 */

class Application_Model_DbTable_Videostats extends Zend_Db_Table_Abstract
{
    /**
     * The default table name 
     */
    protected $_name = 'videostats';



	public function logVideoPageLoad($vid = Null, $cid = NULL, $sid = NULL)
	{
		if ($vid == NULL && $cid == NULL && $sid == NULL) {
			return;
		}
		
		$data = array(
			'video_id'   => $vid,
			'course_id'  => $cid,
			'section_id' => $sid
		);
		
		$this->insert($data);	
	}


//close class
}