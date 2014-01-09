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
		
		//check to see if an intial log has taken place
		$exists = $this->fetchRow($this->select()->where('video_id = ?', $vid)->where('course_id = ?', $cid)->where('section_id = ?', $sid));
		if (!$exists) {
			$this->insert($data);
		} else {
			//update the page load count
			$count = $exists->count;
			$newcount = $count + 1;
			
			$data = array(
				'video_id'   => $vid,
				'course_id'  => $cid,
				'section_id' => $sid,
				'count'      => $newcount
			);
			
			$where = $this->getAdapter()->quoteInto('video_id = ?', $vid);
			
			$this->update($data, $where);
		}
		
			
	}


//close class
}