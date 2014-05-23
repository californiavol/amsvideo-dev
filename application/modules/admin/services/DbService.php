<?php
class Admin_Service_DbService
{
	function __construct()
	{
		//get bootstrap
		$bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
		$this->db = $bootstrap->getResource('db');	
	}
	
	
	public function getCourses($semester = NULL, $year = NULL)
	{
		if (($semester != NULL) || ($year != NULL)) {
			
			$sql = 'SELECT * FROM courses WHERE semester = ? AND year = ?';
			$result = $this->db->fetchAll($sql, array($semester, $year));
			
		}
		
		return $result;
	}
	
	public function backupCoursesTable()
	{
		$this->db->query('CREATE TABLE courses_backup LIKE courses');
		$this->db->query('INSERT INTO courses_backup SELECT * FROM courses');
		return;
	}
	
	
	
	
	
	
}