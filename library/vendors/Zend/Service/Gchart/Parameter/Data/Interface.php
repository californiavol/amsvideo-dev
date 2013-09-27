<?php


	interface Zend_Service_Gchart_Parameter_Data_Interface {
		
		/**
		 * Add new series to the data, returns a hash id to the series.
		 *
		 * @param array $data_points
		 * @return string id
		 */
		public function addDataSeries(Array $data_points = array());
		
		/**
		 * Add data points to the current data points in $series
		 *
		 * @param unknown_type $series
		 * @param array $data_point
		 */
		public function addDataPoints($series, Array $data_points);
		
		/**
		 * Return the series array
		 *
		 * @return array
		 */
		public function getDataSeries();
		
		/**
		 * Return data points for a specified series
		 *
		 * @param string $seriesId
		 * @return array
		 */
		public function getDataPoints($seriesId);
		
		/**
		 * Check if seriesId exist in this data set
		 *
		 * @param string $seriesId
		 * @return boolean;
		 */
		public function isSeriesId($seriesId);
		
		/**
		 * Remove series from data specified by id
		 *
		 * @param string $id
		 */
		public function removeDataSeries($id);
	}