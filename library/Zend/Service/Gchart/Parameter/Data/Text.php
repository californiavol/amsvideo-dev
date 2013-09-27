<?php
	require_once 'Zend/Service/Gchart/Parameter/Data/Interface.php';
	require_once 'Zend/Service/Gchart/Parameter/Data/Abstract.php';

	/**
	 * Google Chart Required Parameter: Chart Data Text Encoded
	 * 
	 *
	 */
	class Zend_Service_Gchart_Parameter_Data_Text
		extends Zend_Service_Gchart_Parameter_Data_Abstract 
		implements Zend_Service_Gchart_Parameter_Data_Interface {
			
		protected $scaled = false;

		/**
		 * Set weather or not we will scale the data
		 *
		 * @param boolean $scale
		 */
		public function setScaled($scale) {
			$this->scaled = $scale;
		}
		
		/**
		 * Return array pair(s) of request variable name and value
		 *
		 * @return array
		 */
		public function toRequestPairs() {
			$request_series = array();
			
			foreach($this->_data as $series)
				$request_series[] = join(',', $series);
			
			$request = array('chd' => 't:' . join('|', $request_series));
			
			// if scaling has been enabled we need to find max/min per series
			if($this->scaled) {
				$minmaxs = array();
				// find max and min
				foreach($this->_data as $d)
					$minmaxs[] = min($d) . ',' . max($d);
				
				// add parameter to request pairs
				$request['chds'] = join(',', $minmaxs);
			}
			
			return $request;
		}
	}