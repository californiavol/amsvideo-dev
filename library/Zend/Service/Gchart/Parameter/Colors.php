<?php

	require_once 'Zend/Service/Gchart/Parameter/Interface.php';
	
	class Zend_Service_Gchart_Parameter_Colors implements Zend_Service_Gchart_Parameter_Interface {
		protected $data;
		protected $colors = array();
		protected $extra_colors = array();
		
		/**
		 * Colors option expects a reference to the chart data so it can handle parametizing correctly
		 *
		 * @param Zend_Service_Gchart_Parameter_Data_Interface $data
		 */
		public function __construct(Zend_Service_Gchart_Parameter_Data_Interface & $data) {
			$this->data = $data;
		}
		
		
		/**
		 * Add colors to the chart pallete with no specific assignment.
		 * Colors set by setSeriesColor take precident. If a series does
		 * not have a color specified it will use the first unused color
		 * set by addColor.
		 *
		 * @param array $colorHex
		 */
		public function addColors(array $colorHex) {
			foreach($colorHex as $ch)
				array_push($this->extra_colors, $ch);
		}
		
		/**
		 * Set Series Color will make sure that a specific data series will
		 * recieve the specified color.
		 *
		 * @param string $seriesId
		 * @param string $colorHex
		 */
		public function setSeriesColor($seriesId, $colorHex) {
			//todo check colorHex is valid hex
			// ..
			
			// check if series exist
			if(!$this->data->isSeriesId($seriesId))
				throw new Exception("Unable to set color for non-existant series. Please use addColor instead");
			
			// get the current set of series from the data container
			$series_data = $this->data->getDataSeries();
			foreach($series_data as $id => $data_points) {
			 	// check to make sure we have a place holder for the series
				if(!isset($this->colors[ $id ]))
					$this->colors[ $id ] = '';
				// set the label for the series
				if($id == $seriesId)
					$this->colors[ $id ] = $colorHex;
			}
			
			return;
		}
		
		/**
		 * Check if parameter is compatible with given chart type
		 *
		 * @param string $chartType
		 * @return boolean
		 */
		public function isCompatibleWithChart($chartType){
			return true;
		}
		
		/**
		 * Return array pair(s) of request variable name and value
		 *
		 * @return array
		 */
		public function toRequestPairs() {
			$last_color = null;
			$color_list = array();
			$extra_colors = $this->extra_colors;
			
			// for most charts colors are assigned per data series
			foreach($this->colors as $c) {
				if($c != '')
					$color_list[] = $c;
				else {
					if(count($extra_colors) > 0) {
						$last_color = array_shift($extra_colors);
						$color_list[] = $last_color;
					} else if($last_color != null) {
						$color_list[] = $last_color;
					}
				}
			}
			
			// for pie charts colors are assigned per data point of the first series
			foreach($extra_colors as $ec)
				$color_list[] = $ec;
				
			return array('chco' => join(',', $color_list));
		}
	}