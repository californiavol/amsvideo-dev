<?php

	/**
	 * Interface for GChart parameters
	 *
	 */
	interface Zend_Service_Gchart_Parameter_Interface {
		
		/**
		 * Check if parameter is compatible with given chart type
		 *
		 * @param string $chartType
		 * @return boolean
		 */
		public function isCompatibleWithChart($chartType);
		
		/**
		 * Return array pair(s) of request variable name and value
		 *
		 * @return array
		 */
		public function toRequestPairs();
	}