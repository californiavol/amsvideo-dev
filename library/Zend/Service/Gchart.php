<?php
	require_once 'Zend/Service/Abstract.php';

	class Zend_Service_Gchart extends Zend_Service_Abstract {
		/**
		 *  Chart API URI
		 */
		const API_URI = 'http://chart.apis.google.com/chart';

		/**
		 * Chart Types
		 */
		const CHART_TYPE_LINE = 'lc';
		const CHART_TYPE_LINE_PAIRED = 'lxy';
		const CHART_TYPE_LINE_SPARK = 'ls';
		const CHART_TYPE_BAR_HORIZONTAL_STACKED = 'bhs';
		const CHART_TYPE_BAR_VERTICAL_STACKED = 'bvs';
		const CHART_TYPE_BAR_HORIZONTAL_GROUPED = 'bhg';
		const CHART_TYPE_BAR_VERTICAL_GROUPED = 'bvg';
		const CHART_TYPE_PIE = 'p';
		const CHART_TYPE_PIE_3D = 'p3';
		const CHART_TYPE_VENN_DIAGRAM = 'v';
		const CHART_TYPE_SCATTER_PLOT = 's';
		const CHART_TYPE_RADAR_LINE = 'r';
		const CHART_TYPE_RADAR_SPLINE = 'rs';
		const CHART_TYPE_MAP = 't';
		const CHART_TYPE_GOOGLE_O_METER = 'gom';
		const CHART_TYPE_QR_CODES = 'qr';
		
		/**
		 * Reference to REST client object
		 */
		protected $_restClient = null;
		
		/**
		 * Contains parameters for the google chart
		 *
		 * @var Zend_Service_Gchart_Parameter_Interface[]
		 */
		protected $parameters = array();
		
		/**
		 * Reference to the data set the chart will render
		 *
		 * @var Zend_Service_Gchart_Data_Interface
		 */
		protected $data = null;
		
		/**
		 * Reference to the chart size
		 *
		 * @var unknown_type
		 */
		protected $size = null;
		
		public function __construct() {
			
		}
		

		/**
		 * Set the data for the chart to render.
		 *
		 * @param Zend_Service_Gchart_Data_Interface $data
		 */
		public function setData(Zend_Service_Gchart_Parameter_Data_Interface $data) {
			$this->data = $data;
		}
		
		public function setSize(Zend_Service_Gchart_Parameter_Size $size) {
			$this->size = $size;
		}
		
		/**
		 * Add chart option parameter to this chart.
		 *
		 * @param Zend_Service_Gchart_Parameter_Interface $p
		 */
		public function addParameter(Zend_Service_Gchart_Parameter_Interface $p) {
			array_push($this->parameters, $p);
		}
		
	    /**
	     * Returns a reference to the REST client, instantiating it if necessary
	     *
	     * @return Zend_Rest_Client
	     */
	    public function getRestClient()
	    {
	        if (null === $this->_restClient) {
	            /**
	             * @see Zend_Rest_Client
	             */
	            require_once 'Zend/Rest/Client.php';
	            $this->_restClient = new Zend_Rest_Client(self::API_URI);
	        }
	
	        return $this->_restClient;
	    }

	    /**
	     * Get the request string that would be used for a request to google api
	     *
	     * @param string $chartType
	     * @return string
	     */
		public function getRequestString($chartType) {
			$request_params = array();
			$parameters = $this->parameters;
			
			//todo validate chart type
			// ..
			// add chart type to request params
			array_push($request_params, "cht={$chartType}");
			
			// add chart size to params
			array_push($parameters, $this->size);
			
			// add chart data to params
			array_push($parameters, $this->data);
			
			// validate parameters include data and size 
			// ..
			foreach($parameters as $p) {
				if($p->isCompatibleWithChart($chartType)) {
					foreach($p->toRequestPairs() as $name => $val)
						array_push($request_params, "$name=$val");
				} else echo "Skipping\n";
			}
		
			$request = "";
			
			
			$request = join("&amp;", $request_params);
			
			return $request;
		}

		
		/**
		 * This code generates the <img> src used to diplay the chart.
		 * Because we use support cache, this might not reference google chart uri
		 * but rather a local file!
		 *
		 * @param string chartType
		 * @return string
		 */
		public function getImageUrl($chartType) {
			// todo use cache!

			return self::API_URI . '?' . $this->getRequestString($chartType); 
		}
	}