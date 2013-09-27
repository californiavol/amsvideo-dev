<?php
	require_once 'Zend/Service/Gchart/Parameter/Interface.php';

	/**
	 * Google Chart Required Parameter: Chart Size
	 * 
	 *
	 */
	class Zend_Service_Gchart_Parameter_Size implements Zend_Service_Gchart_Parameter_Interface {
		const MAX_PIXELS = 300000;
		const MAX_DIMENSION = 1000;
		
		protected $width = 1;
		protected $height = 1;

		/**
		 * Instantiate new size parameter checking that dimensions are valid for googles alloted size
		 * If $chartType is specified, error checking is done against googles recomended size ratios 
		 * 
		 * @param int $width
		 * @param int $height
		 * @param string[optional] $chartType
		 */
		public function __construct($width, $height, $chartType = null) {
			// error checking
			if($width > self::MAX_DIMENSION)
				throw new Exception("Width dimension cannot be greater than ".self::MAX_DIMENSION);
			if($height > self::MAX_DIMENSION)
				throw new Exception("Height dimension cannot be greater than ".self::MAX_DIMENSION);
			if($width * $height > self::MAX_PIXELS)
				throw new Exception("Width * Height cannot exceed ".self::MAX_PIXELS);
			if($width * $height <= 0)
				throw new Exception("Width * Height cannot be less than 1");
				
			switch ($chartType) {
				case Zend_Service_Gchart::CHART_TYPE_PIE_3D:
					if($width/$height < 2.5)
						throw new Exception("Google suggested size ratio(WxH) for 3D pie charts is 2.5");
					break;
					
				case Zend_Service_Gchart::CHART_TYPE_PIE:
					if($width/$height < 2.0)
						throw new Exception("Google suggested size ratio(WxH) for 2D pie charts is 2.0");
					break;
				case Zend_Service_Gchart::CHART_TYPE_MAP:
					if($width > 440 || $height > 220)
						throw new Exception("Google chart map size cannot exceed 440x220");
					break;
				default:
					break;
			}
				
				
			$this->width = intval($width);
			$this->height = intval($height);
		}
		
		
		/**
		 * Check if parameter is compatible with given chart type
		 *
		 * @param string $chartType
		 * @return boolean
		 */
		public function isCompatibleWithChart($chartType) {
			// easy, all charts require size parameter
			return true;
		}
		
		/**
		 * Return array pair(s) of request variable name and value
		 *
		 * @return array
		 */
		public function toRequestPairs() {
			return array('chs' => "{$this->width}x{$this->height}");
		}
		
	}