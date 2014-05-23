<?php

class Admin_Model_Parser_Csv extends Admin_Model_Parser_Abstract
{

	public function parse($inputFile)
	{
    	require_once APPLICATION_PATH . '/../library/vendors/Datasource.php';
    	
    	$csv = new File_CSV_DataSource;
		$csv->load($inputFile);
		$csvArray = $csv->connect();
		//var_dump($csvArray);
		return $csvArray;  		
	}
	
	
}