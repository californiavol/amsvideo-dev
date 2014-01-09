<?php
	require_once 'Zend/Service/Gchart/Parameter/Interface.php';
	require_once 'Zend/Service/Gchart/Parameter/Data/Interface.php';

	/**
	 * Google Chart Optional Parameter: Chart Legend
	 * 
	 *
	 */
	class Zend_Service_Gchart_Parameter_Legend implements Zend_Service_Gchart_Parameter_Interface {
		/**
		 * Position constants for the legend
		 */
		const LEGEND_POSITION_BOTTOM = 'b';
		const LEGEND_POSITION_TOP = 't';
		const LEGEND_POSITION_RIGHT = 'r';
		const LEGEND_POSITION_LEFT = 'l';
		
		protected $data;
		protected $labels = array();
		protected $position = null;

		/**
		 * Leged option expects a reference to the chart data so it can handle parametizing correctly
		 *
		 * @param Zend_Service_Gchart_Parameter_Data_Interface $data
		 */
		public function __construct(Zend_Service_Gchart_Parameter_Data_Interface & $data) {
			$this->data = $data;
		}
		
		/**
		 * Set the label for a series in the data set.
		 * $seriesId must exist in the data set!
		 *
		 * @param string $seriesId
		 * @param string $label
		 */
		public function setDataLabel($seriesId, $label) {
			// check if series exist
			if(!$this->data->isSeriesId($seriesId))
				throw new Exception("Unable to set label for non-existant series.");
			
			// get the current set of series from the data container
			$series_data = $this->data->getDataSeries();
			foreach($series_data as $id => $data_points) {
			 	// check to make sure we have a place holder for the series
				if(!isset($this->labels[ $id ]))
					$this->labels[ $id ] = '';
				// set the label for the series
				if($id == $seriesId)
					$this->labels[ $id ] = $label;
			}
			
			return;
		}
		
		/**
		 * Set the position of the legend labels
		 *
		 * @param string $position
		 */
		public function setPosition($position) {
			$this->position = $position;
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
			$request = array('chdl' => join('|', $this->labels));
			
			// if position has been set
			if($this->position != null)
				$request['chdlp'] = $this->position;
			
			return $request;
		}
		
	}