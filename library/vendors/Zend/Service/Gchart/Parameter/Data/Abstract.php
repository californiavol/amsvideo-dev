<?php
	
	require_once 'Zend/Service/Gchart/Parameter/Interface.php';
	
	/**
	 * Google Chart Required Parameter: Chart Data
	 * 
	 *
	 */
	abstract class Zend_Service_Gchart_Parameter_Data_Abstract implements Zend_Service_Gchart_Parameter_Interface {
		protected $_data = array();
		
		/**
		 * Add new series to the data, returns a hash id to the series.
		 *
		 * @param array $data_points
		 * @return string id
		 */
		public function addDataSeries(Array $data_points = array()) {
			$id = 's' . count($this->_data);
			
			$this->_data[ $id ] = array();
			
			foreach($data_points as $dp)
				array_push( $this->_data[ $id ], $dp );
				
			return $id;
		}
		
		/**
		 * Add data points to the current data points in $series
		 *
		 * @param unknown_type $series
		 * @param array $data_point
		 */
		public function addDataPoints($series, Array $data_points) {
			if(!isset($this->_data[ $series ]))
				throw new Exception("Cannot add data points, $series series does not exist.");
			
			foreach($data_points as $dp)
				array_push( $this->_data[ $series ], $dp );
		}
		
		/**
		 * Return the series array
		 *
		 * @return array
		 */
		public function getDataSeries() {
			return $this->_data;
		}
		
		/**
		 * Return data points for a specified series
		 *
		 * @param string $seriesId
		 * @return array
		 */
		public function getDataPoints($seriesId) {
			if(!isset( $this->_data[ $seriesId ] ))
				throw new Exception("$seriesId is not a series in this data set.");
				
			return $this->_data[ $seriesId ];
		}
		
		/**
		 * Check if seriesId exist in this data set
		 *
		 * @param string $seriesId
		 * @return boolean;
		 */
		public function isSeriesId($seriesId) {
			if(isset( $this->_data[ $seriesId ] ))
				return true;
			return false;
		}
		
		/**
		 * Remove series from data specified by id
		 *
		 * @param string $id
		 */
		public function removeDataSeries($id) {
			if(!isset( $this->_data[ $id ] ))
				throw new Exception("Series does not exist."); // should we let this slide?
				
			unset( $this->_data[ $id ] );
		}
		
		
		/**
		 * Check if parameter is compatible with given chart type
		 *
		 * @param string $chartType
		 * @return boolean
		 */
		public function isCompatibleWithChart($chartType) {
			// easy, data is required for all chart types
			return true;
		}
		
	}