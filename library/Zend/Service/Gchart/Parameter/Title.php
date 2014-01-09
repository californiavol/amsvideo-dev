<?php

	require_once 'Zend/Service/Gchart/Parameter/Interface.php';
	
	/**
	 * GChart Optional Parameter: Title
	 *
	 */
	class Zend_Service_Gchart_Parameter_Title implements Zend_Service_Gchart_Parameter_Interface {
		protected $title;
		protected $color = null;
		protected $size = null;
		
		/**
		 * Constructs chart title, encodes spaces with + and newlines with |
		 *
		 * @param string $title
		 */
		public function __construct($title) {
			$this->title = str_replace(array(' ', "\n"), array('+', '|'), $title);
		}
		
		public function setFont($colorHex, $size) {
			$this->color = $colorHex;
			$this->size = null;
		}
		
		/**
		 * Check if parameter is compatible with given chart type
		 *
		 * @param string $chartType
		 * @return boolean
		 */
		public function isCompatibleWithChart($chartType) {
			return true;
		}
		
		/**
		 * Return array pair(s) of request variable name and value
		 *
		 * @return array
		 */
		public function toRequestPairs() {
			$request = array('chtt' => $this->title);
			
			// support optional color and size
			if($this->color != null) {
				$request['chts'] = "{$this->color},{$this->size}";
			}
			
			return $request;
		}
	}