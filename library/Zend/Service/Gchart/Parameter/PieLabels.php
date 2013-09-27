<?php

	require_once 'Zend/Service/Gchart/Parameter/Interface.php';
	require_once 'Zend/Service/Gchart/Parameter/Data/Interface.php';
	

	class Zend_Service_Gchart_Parameter_PieLabels implements Zend_Service_Gchart_Parameter_Interface {
		/**
		 * GChart Data reference
		 *
		 * @var Zend_Service_Gchart_Parameter_Data_Interface
		 */
		protected $data;
		
		/**
		 * Labels is a list of labels applied to a specific indexed datapoint of a series
		 *
		 * @var array
		 */
		protected $labels = array();
		
		/**
		 * Extra labels is a list of labels to be applied to unassigned data points
		 *
		 * @var array
		 */
		protected $extra_labels = array();
		
		
		/**
		 * PieLabels option expects a reference to the chart data so it can handle parametizing correctly
		 *
		 * @param Zend_Service_Gchart_Parameter_Data_Interface $data
		 */
		public function __construct(Zend_Service_Gchart_Parameter_Data_Interface & $data) {
			$this->data = $data;
		}
		
		/**
		 * Add labels to be used for datapoints of a series. 
		 *
		 * @param array $labels
		 */
		public function addLabel(Array $labels) {
			foreach($labels as $l) 
				array_push($extra_labels, $l);
		}
		
		/**
		 * Set a label for a specific datapoint by the index of the dp
		 *
		 * @param int $dpIndex
		 * @param string $label
		 */
		public function setDataPointLabel($dpIndex, $label) {
			for($i = 0; $i <= $dpIndex; $i++) {
				if(!isset($labels[$i]))
					$labels[$i] == null;
				
				if($i == $dpIndex)
					$labels[$i] == $label;
			}
		}
		
		/**
		 * Check if parameter is compatible with given chart type
		 *
		 * @param string $chartType
		 * @return boolean
		 */
		public function isCompatibleWithChart($chartType) {
			if(in_array($chartType, array(Zend_Service_Gchart::CHART_TYPE_PIE, Zend_Service_Gchart::CHART_TYPE_PIE_3D)))
				return true;
			return false;
		}
		
		/**
		 * Return array pair(s) of request variable name and value
		 *
		 * @return array
		 */
		public function toRequestPairs() {
			$request = array('chdl' => join('|', $this->labels));
			
			// if position has been set
			if($this->position != null)
				$request['chdlp'] = $this->position;
			
			return $request;
		}
	}