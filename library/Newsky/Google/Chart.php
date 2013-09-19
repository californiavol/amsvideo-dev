<?php
/**
 * Newsky_Google
 *
 * LICENSE
 * 
 * This file is part of Newsky_Google.
 * 
 * Newsky_Google is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Newsky_Google is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.    
 */

/**
 * Abstract class for all Newsky_Google_Chart
 * 
 * @author Luc ALBERT
 * @version 0.1 20/04/2010
 */
abstract class Newsky_Google_Chart
{
	/**
	 * Default width of chart
	 * @var int
	 */
	CONST DEFAULT_WIDTH = 250;
	
	/**
	 * Default height of chart
	 * @var int
	 */
	CONST DEFAULT_HEIGHT = 100;
	
	/**
	 * Url of Google Chart API
	 * @var string
	 */
	CONST API_URL = 'http://chart.apis.google.com/chart';
	
	/**
	 * Params name
	 */
	CONST PARAM_CHART_TYPE					= 'cht';
	CONST PARAM_CHART_SIZE					= 'chs';
	
	CONST PARAM_CHART_OUTPUT_FORMAT			= 'chof';
	
	CONST PARAM_CHART_TITLE					= 'chtt';
	CONST PARAM_CHART_TITLE_STYLE			= 'chts';
	
	CONST PARAM_CHART_DATA					= 'chd';
	CONST PARAM_CHART_DATA_LEGEND			= 'chdl';
	CONST PARAM_CHART_DATA_COLOR			= 'chco';
	
	CONST PARAM_CHART_AXES_VISIBILITY		= 'chxt';
	CONST PARAM_CHART_AXES_RANGE			= 'chxr';
	CONST PARAM_CHART_AXES_LABEL_CUSTOM		= 'chxl';
	CONST PARAM_CHART_AXES_LABEL_POSITION	= 'chxp';
	CONST PARAM_CHART_AXES_LABEL_STYLE		= 'chxs';
	CONST PARAM_CHART_AXES_MARK_STYLE		= 'chxtc';
	
	CONST PARAM_CHART_GRID_LINES			= 'chg';
	
	CONST PARAM_CHART_BACKGROUND			= 'chf';
	
	/**
	 * Max width for a chart
	 * @var int
	 */
	protected $_maxWidth = 1000;
	
	/**
	 * Max height for a chart
	 * @var int
	 */
	protected $_maxHeight = 1000;
	
	/**
	 * Max size of chart, ie $_maxWidth x $_maxHeight
	 * @var int
	 */
	protected $_maxSize = 300000;
	
	/**
	 * With of chart 
	 * @var int
	 */
	protected $_width = null;
	
	/**
	 * Height of chart
	 * @var int
	 */
	protected $_height = null;
	
	/**
	 * Allowed outputFormat
	 * @var array
	 */
	protected $_allowedOutputFormat = array(
		'png', 'gif', 'json', 'validate'
	);
	
	/**
	 * Chart data series
	 * @var Newsky_Google_Chart_Data
	 */
	protected $_data = null;
	
	/**
	 * Default container data class name 
	 * @var string
	 */
	protected $_defaultChartDataClassName = 'Newsky_Google_Chart_Data';
	
	/**
	 * Chart axes
	 * @var Newsky_Google_Chart_Axes
	 */
	protected $_axes = null;
	
	/**
	 * Default container axes class name 
	 * @var string
	 */
	protected $_defaultChartAxesClassName = 'Newsky_Google_Chart_Axes';
	
	/**
	 * Params of chart
	 * @var array
	 */
	protected $_params = array();
	
	/**
	 * Background fills
	 * @var array
	 */
	protected $_backgrounds = array();
	
	/**
	 * Allowed type chart. Must be overwrite in children class 
	 * @var array
	 */
	protected $_allowedType = array();
	
	/**
	 * Images attributes used for __toString method.
	 * Must be an array, each key is attribute name and value is
	 * attribute value.
	 * @var array
	 */
	protected $_imgAttr = array();
		
	/**
	 * Array for mapping className chart.
	 * new Newsky_Google_Chart('lc') as new Newsky_Google_Chart_Line( 'lc' );
	 * 
	 * @var array
	 */
	private static $_chartMapper = array(
				# Newsky_Google_Chart_Bar
				'bhs'	=> 'Bar',
				'bvs'	=> 'Bar',
				'bhg'	=> 'Bar',
				'bvg'	=> 'Bar',
				'bvo'	=> 'Bar',
				
				# Newsky_Google_Chart_Pie
				'p'		=> 'Pie',
				'p3'	=> 'Pie',
				'pc'	=> 'Pie',
	
				# Newsky_Google_Chart_Venn
				'v'		=> 'Venn',
	
				# Newsky_Google_Chart_Radar
				'r'		=> 'Radar',
				'rs'	=> 'Radar',
	
				# Newsky_Google_Chart_Line
				'lc' 	=> 'Line',
				'ls'	=> 'Line',
				'lxy'	=> 'Line',
	
				# Newsky_Google_Chart_Line
				't'		=> 'Map',
				);
	
	/**
	 * Factory
	 * @param string $chart
	 * @param string|null $type
	 * @return Newsky_Google_Chart
	 */
	public static function factory( $chart, $type = null ) {
		if( !is_string( $chart ) ) {
			require_once 'Newsky/Google/Chart/Exception.php';
			throw new Newsky_Google_Chart_Exception( '$chart parameter must be a string.' );
		}
		
		if( array_key_exists( strtolower( $chart ), self::$_chartMapper ) ) {
			$type	= strtolower( $chart );
			$chart	= self::$_chartMapper[strtolower( $chart )];
		}
		
		$className = 'Newsky_Google_Chart_' . ucfirst( strtolower( $chart ) );
		
		if (!class_exists($className)) {
            require_once 'Zend/Loader.php';
            Zend_Loader::loadClass( $className );
        }
                
        $_chart = new $className( $type );
        $_chart->init();
        
        return $_chart;
	}
	
	/**
	 * Run just after class create.
	 * It use in your extends class
	 * @return void
	 */
	public function init() {
		
	}
	
	/**
	 * Set the param $name with the value $value or remove
	 * the param if $value is null 
	 * @param string $name
	 * @param mixed $value
	 * @return Newsky_Google_Chart
	 */
	public function setParam( $name, $value = null ) {
		if( null === $value ) {
			$this->removeParam( $name );
			return $this;
		}
		
		$this->_params[$name] = $value;
		
		return $this;
	}
	
	/**
	 * Remove the param $name if exists
	 * @param string $name
	 * @return bool
	 */
	public function removeParam( $name ) {
		if( $this->hasParam( $name ) ) {
			unset( $this->_params[$name] );
			return true;
		}
		
		return false;
	}
	
	/**
	 * Retrieve the param $name
	 * @param string $name
	 * @return string|null
	 */
	public function getParam( $name ) {
		if( $this->hasParam( $name ) ) {
			return $this->_params[$name];
		}
		
		return null;
	}
	
	/**
	 * Retrieve if param $name exists
	 * @param string $name
	 * @return bool
	 */
	public function hasParam( $name ) {
		return array_key_exists( $name, $this->_params );
	}
	
	/**
	 * Retrieve all params of chart
	 * 
	 * @param bool $filtered If the array must be filtered or not
	 * @return array
	 */
	public function getParams( $filtered = false ) {
		
		// Data parameter
		// is data and must be legend series and color series
		if( count( $this->getData() ) > 0 ) {
			$this->setParam( self::PARAM_CHART_DATA, $this->getData()->getParamData() );
			$this->setParam( self::PARAM_CHART_DATA_COLOR, $this->getData()->getParamColor() );
			$this->setParam( self::PARAM_CHART_DATA_LEGEND, $this->getData()->getParamLegend() );
		}
		
		// Axes params
		if( count( $this->getAxes() ) > 0 ) {
			$this->setParam( self::PARAM_CHART_AXES_VISIBILITY, $this->getAxes()->getParamAxesVisibility() );
			$this->setParam( self::PARAM_CHART_AXES_RANGE, $this->getAxes()->getParamAxesRange() );
			$this->setParam( self::PARAM_CHART_AXES_LABEL_POSITION, $this->getAxes()->getParamLabelPosition() );
			$this->setParam( self::PARAM_CHART_AXES_LABEL_CUSTOM, $this->getAxes()->getParamCustomLabel() );
		}
		
		// Background Fills params
		if( count( $this->getBackgrounds() ) > 0 ) {
			$bg = array();
			foreach( $this->getBackgrounds() as $background ) {
				$bg[] = $background->toParam();
			}
			
			$this->setParam( self::PARAM_CHART_BACKGROUND, implode( '|', $bg ) );
		}
		
		$params = $this->_params;
		
		// Filter params
		if( $filtered ) {
			$oldParams	= $this->_params;
			$oldParamsKeys	= array_keys( $oldParams );
			$newParamsKeys = array_filter( $oldParamsKeys, array( $this, 'filterParam' ) );
			
			$params = array();
			foreach( $newParamsKeys as $key ) {
				$params[$key] = $oldParams[$key];
			}
		}
		
		return $params;
	}
	
	/**
	 * Filter parameters. This method should be extended by classes daughter 
	 * Newsky_Google_Chart to determine which parameters are allowed in the URI 
	 * depending on the chosen graphics.
	 * 
	 * @param string $paramName Parameter name
	 * @return bool Returns TRUE if the parameter is considered valid, otherwise FALSE
	 */
	public function filterParam( $paramName ) {
		return true;
	}
	
	/**
	 * Set width of chart
	 * @param int $width
	 * @return Newsky_Google_Chart
	 */
	public function setWidth( $width = null ) {
		if( null === $width ) {
			$width = self::DEFAULT_WIDTH;
		}
		
		$width = (int) $width;
		
		if( $width > $this->getMaxWidth() ) {
			require_once 'Newsky/Google/Chart/Exception.php';
            throw new Newsky_Google_Chart_Exception("{$width}px is not allowed for " . get_class($this) . " chart. The maximum width should be {$this->getMaxWidth()}px");
		}
		
		$this->_width = $width;
		$this->_validateSize();
		
		$this->setParam( self::PARAM_CHART_SIZE, $this->getWidth() . 'x' . $this->getHeight() );
		
		return $this;
	}
	
	/**
	 * Get width of chart
	 * @return int
	 */
	public function getWidth() {
		if( null === $this->_width ) {
			$this->_width = self::DEFAULT_WIDTH;
		}
		
		return $this->_width;
	}
	
	/**
	 * Set height of chart
	 * @param int $height
	 * @return Newsky_Google_Chart
	 */
	public function setHeight( $height = null ) {
		if( null === $height ) {
			$height = self::DEFAULT_HEIGHT;
		}
		
		$height = (int) $height;
		
		if( $height > $this->getMaxHeight() ) {
			require_once 'Newsky/Google/Chart/Exception.php';
            throw new Newsky_Google_Chart_Exception("{$height}px is not allowed for " . get_class($this) . " chart. The maximum height should be {$this->getMaxHeight()}px");
		}
		
		$this->_height = $height;
		$this->_validateSize();
		
		$this->setParam( self::PARAM_CHART_SIZE, $this->getWidth() . 'x' . $this->getHeight() );
		
		return $this;
	}
	
	/**
	 * Get height of chart
	 * @return int
	 */
	public function getHeight() {
		if( null === $this->_height ) {
			$this->_height = self::DEFAULT_HEIGHT;
		}
		
		return $this->_height;
	}
	
	/**
	 * Retrieve de max with allowed
	 * @return int
	 */
	public function getMaxWidth() {
		return $this->_maxWidth;
	}
	
	/**
	 * Retrieve de max height allowed
	 * @return int
	 */
	public function getMaxHeight() {
		return $this->_maxHeight;
	}
	
	/**
	 * Retrieve de max size allowed
	 * @return int
	 */
	public function getMaxSize() {
		return $this->_maxSize;
	}
	
	/**
	 * Validate size of chart
	 * @return bool
	 * @throw Newsky_Google_Chart_Exception
	 */
	protected function _validateSize() {
		$_size = $this->getWidth() * $this->getHeight();
		
		if( $_size > $this->getMaxSize() ) {
			require_once 'Newsky/Google/Chart/Exception.php';
            throw new Newsky_Google_Chart_Exception("The size of {$_size}px is not allowed for this chart. The maximum size allowed is {$this->getMaxSize()}px");
		}
		
		return true;
	}
	
	/**
	 * Set the type of chart
	 * @param string $type
	 * @return Newsky_Google_Chart
	 */
	public function setType( $type ) {
		if( !$this->typeIsAllowed( $type ) ) {
			require_once 'Newsky/Google/Chart/Exception.php';
            throw new Newsky_Google_Chart_Exception("The type '{$type}' is not allowed for this chart.");
		}
		
		$this->setParam( self::PARAM_CHART_TYPE, $type );
		
		return $this;
	}
	
	/**
	 * Retrieve the type
	 * @return string
	 */
	public function getType() {
		return $this->getParam( self::PARAM_CHART_TYPE );
	}
	
	/**
	 * Verify if type $type is allowed for the chart
	 * @param string $type
	 * @return bool
	 */
	public function typeIsAllowed( $type ) {
		return in_array( $type, $this->_allowedType );
	}
	
	/**
	 * Set chart data series
	 * @param Newsky_Google_Chart_Data $data
	 * @return Newsky_Google_Chart
	 */
	public function setData( Newsky_Google_Chart_Data $data ) {
		$this->_data = $data;
		
		return $this;
	}
	
	/**
	 * Retrieve the data
	 * @return Newsky_Google_Chart_Data
	 */
	public function getData() {
		if( null === $this->_data ) {
			if (!class_exists($this->_defaultChartDataClassName)) {
	            require_once 'Zend/Loader.php';
	            Zend_Loader::loadClass( $this->_defaultChartDataClassName );
	        }
	                
	        $this->_data = new $this->_defaultChartDataClassName;
		}
		
		return $this->_data;
	}
	
	/**
	 * Retrieve a series with $name name
	 * @param string $name
	 * @return Newsky_Google_Chart_Data_Series
	 */
	public function getSerie( $id ) {
		return $this->getData()->getSerie( $id );
	}
	
	/**
	 * Set chart data series
	 * @param Newsky_Google_Chart_Data $data
	 * @return Newsky_Google_Chart
	 */
	public function setAxes( Newsky_Google_Chart_Axes $axes ) {
		$this->_axes = $axes;
		
		return $this;
	}
	
	/**
	 * Retrieve the axes container
	 * @return Newsky_Google_Chart_Axes
	 */
	public function getAxes() {
		if( null === $this->_axes ) {
			if (!class_exists($this->_defaultChartAxesClassName)) {
	            require_once 'Zend/Loader.php';
	            Zend_Loader::loadClass( $this->_defaultChartAxesClassName );
	        }
	                
	        $this->_axes = new $this->_defaultChartAxesClassName;
		}
		
		return $this->_axes;
	}
	
	/**
	 * Set the chart title
	 * @param string $title
	 * @return Newsky_Google_Chart
	 */
	public function setTitle( $title ) {
		require_once 'Newsky/Google/Chart/Encoder/Text.php';                
        $encoder = new Newsky_Google_Chart_Encoder_Text;
        
        $this->setParam( self::PARAM_CHART_TITLE, $encoder->encode( $title ) );
        
        // Set title and alt attributes
        $this->_imgAttr['alt'] = (string) $title;
        $this->_imgAttr['title'] = (string) $title;
        
        return $this;
	}
	
	/**
	 * Get the chart's title
	 * @return string
	 */
	public function getTitle( $encoded = false ) {
		$title = $this->getParam( self::PARAM_CHART_TITLE );
		
		if( !$encoded ) {
			require_once 'Newsky/Google/Chart/Encoder/Text.php';                
        	$encoder = new Newsky_Google_Chart_Encoder_Text;
        	
        	return $encoder->decode( $title );
		}
		
		return $title;
	}
	
	/**
	 * Set the color title and/or size title
	 * @param string|Newsky_Google_Chart_Color $color
	 * @param int $size Font size in point 
	 * @return Newsky_Google_Chart
	 */
	public function setTitleStyle( $color, $size = null ) {
		require_once 'Newsky/Google/Chart/Color.php';
		$titleStyle = Newsky_Google_Chart_Color::factory( $color );
		
		if( null !== $size ) {
			if( ! is_int( $size ) ) {
				require_once 'Newsky/Google/Chart/Exception.php';
				throw new Newsky_Google_Chart_Exception( 'The $size parameter must be a integer.' );
			}
			
			$titleStyle.= ",$size";
		}
		
		$this->setParam( self::PARAM_CHART_TITLE_STYLE, $titleStyle );
		
		return $this;
	}
	
	/**
	 * Add background fills to chart 
	 * @param Newsky_Google_Chart_Background $background
	 * @return Newsky_Google_Chart
	 */
	public function addBackground( Newsky_Google_Chart_Background $background ) {
		$this->_backgrounds[] = $background;
		
		return $this;
	}
	
	public function getBackgrounds() {
		return $this->_backgrounds;
	}
	
	/**
	 * Set the output format
	 * @param string $outputFormat
	 * @return Newsky_Google_Chart
	 */
	public function setOutputFormat( $outputFormat ) {
		if( !$this->outputFormatIsAllowed( $outputFormat ) ) {
			require_once 'Newsky/Google/Chart/Exception.php';
            throw new Newsky_Google_Chart_Exception("The type '{$outputFormat}' is not an allowed output format.");
		}
		
		$this->_outputFormat = $outputFormat;
		
		if( 'png' != $outputFormat ) { // png is default
			$this->setParam( self::PARAM_CHART_OUTPUT_FORMAT, $outputFormat );
		}
		
		return $this;
	}
	
	/**
	 * Retrieve the ouptut format
	 * @return string
	 */
	public function getOutputFormat() {
		if( ! $this->hasParam( self::PARAM_CHART_OUTPUT_FORMAT ) ) {
			return 'png';
		}
		
		return $this->getParam( self::PARAM_CHART_OUTPUT_FORMAT );
	}
	
	/**
	 * Verify if output format $outputFormat is allowed
	 * @param string $outputFormat
	 * @return bool
	 */
	public function outputFormatIsAllowed( $outputFormat ) {
		return in_array( $outputFormat, $this->_allowedOutputFormat );	
	}
	
	/**
	 * Set the grid lines
	 * @return Newsky_Google_Chart
	 */
	public function setGridLines( $x_axis_step_size, $y_axis_step_size, 
								  $dash_length = null , $space_length = null,
								  $x_offset = null , $y_offset = null ) 
								  {
		$_data = array(
			(int) $x_axis_step_size,
			(int) $y_axis_step_size,
		);
		
		foreach( array( 'dash_length', 'space_length', 'x_offset', 'y_offset' ) as $argName ) {
			if( null === $$argName ) {
				break;
			}
			
			$_data[] = (int) $$argName;
		}
		
		$this->setParam( self::PARAM_CHART_GRID_LINES, implode( ',', $_data ) );
		
		return $this;
	}
	
	public function getGridLines() {
		return $this->getParam( self::PARAM_CHART_GRID_LINES );
	}
	
	/**
	 * Get URL of chart
	 * @param int|string $optimizedUrl 0-9 int or r for random
	 * @return string
	 */
	public function getUrl( $optimizedUrl = null ) {
		$url = self::API_URL;
		
		if( null !== $optimizedUrl ) {
			if( is_int( $optimizedUrl ) ) {
				$optimizedUrl = abs( $optimizedUrl );
				if( $optimizedUrl > 9 ) {
					$optimizedUrl = 9;
				}
			} elseif( 'r' == $optimizedUrl ) {
				$optimizedUrl = rand( 0, 9 );
			} else {
				require_once 'Newsky/Google/Chart/Exception.php';
				throw new Newsky_Google_Chart_Exception("\$optimizedUrl parameter must be an integer between 0 and 9 or the 'r' string.");
			}
			$replace = "http://$optimizedUrl.";
			$url = str_replace( 'http://', $replace, $url );
		}
		
		$params = $this->getParams( true );
		$_params = array();
		foreach( $this->getParams() as $paramName => $paramValue ) {
			$_params[] = "$paramName=$paramValue";
		}
		return $url . '?' . implode( '&amp;', $_params );
		
		/**
		 * @todo: do not use http_build_query because it's 
		 * encode all params value like title.
		 */
		$params = http_build_query( $params, '', '&amp;' );
		return $url . '?' . $params;
	}
	
	public function addImgAttribute( $attrName, $attrValue ) {
		$this->_imgAttr[(string) $attrName] = (string) $attrValue; 
		
		return $this;
	}
	
	public function getImgAttributes() {
		$attr = '';
		foreach( $this->_imgAttr as $name => $value ) {
			switch( $name ) {
				case 'alt' :
				case 'class':
				case 'title':
				case 'id':
					$value = htmlspecialchars( (string) $value );
					$attr.= sprintf( '%s="%s" ', $name, $value );
					break;
					
				case 'longdesc':
					$attr.= sprintf( '%s="%s" ', $name, $value );
					break;
					
				case 'dir':
					$value = ( 'rtl' === (string) $value ) ? 'rtl' : 'ltr';
					$attr.= sprintf( '%s="%s" ', $name, $value );
					break;
			}
		}
		
		return $attr;
	}
	
	public function __toString() {
		return  sprintf( '<img src="%s" width="%dpx" height="%dpx" %s />', 
				$this->getUrl(), 
				$this->getWidth(), 
				$this->getHeight(), 
				$this->getImgAttributes() 
			);
	}
	
	/**
     * Newsky_Google_Chart and its subclasses cannot be instantiated directly.
     * Use Newsky_Google_Chart::factory() to return a new Newsky_Google_Chart object.
     *
     * @param string $scheme         The scheme of the URI
     * @param string $schemeSpecific The scheme-specific part of the URI
     */
    abstract public function __construct($type = null);
}