<?php


class Course
{
	var $name;
	var $section;
	var $course_id;
	var $description;
	var $instructor;
	var $semester;
	var $year;
	var $class_nbr;
	
	
	public function __construct()
	{
	
	}	
	
	
}


class VideoCourse extends Course
{

	var $combined_id;
	var $combined_class_nbr;
	var $available_time;
	var $start_dt;
	var $days;
	var $studio;
	
	public function __construct()
	{
		
		
	}

}