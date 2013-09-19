<?php
/**
 * Newsky_Google_Chart
 *
 * LICENSE
 * 
 * This file is part of Newsky_Google_Chart.
 * 
 * Newsky_Google_Chart is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Newsky_Google_Chart is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.    
 */

require_once 'Newsky/Google/Chart.php';

class Newsky_Google_Chart_Map extends Newsky_Google_Chart
{
	/**
	 * Params name
	 */
	CONST PARAM_CHART_MAP_ZOOM_AERA			= 'chtm';
	CONST PARAM_CHART_MAP_COUNTRIES_CODE	= 'chld';
	
	/**
	 * Max width for map chart
	 * @var int
	 */
	protected $_maxWidth = 440;
	
	/**
	 * Max height for map chart
	 * @var int
	 */
	protected $_maxHeight = 220;
	
	/**
	 * Max size of map chart, ie $_maxWidth x $_maxHeight
	 * @var int
	 */
	protected $_maxSize = 96800;	
	
	/**
	 * Allowed type chart
	 * @var array
	 */
	protected $_allowedType = array( 't' );
	
	protected $_zoomAeraAllowed = array(
		'africa',
    	'asia',
    	'europe',
    	'middle_east',
    	'south_america',
    	'usa',
    	'world'
	);
	
	protected $_countries = array();
	
	public function __construct( $type = null ) {
		$this->setType( 't' );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see lib/Newsky/Google/Newsky_Google_Chart#init()
	 */
	public function init() {
		// Init map on world zoom aera
		$this->setZoomAera();
	}
	
	/**
	 * Set zoom aera
	 * @param string $zoomAera world|africa|asia|europe|middle_east|south_america|usa
	 * @return Newsky_Google_Chart_Map
	 */
	public function setZoomAera( $zoomAera = 'world' ) {
		$zoomAera = strtolower( $zoomAera );
		if( !in_array( $zoomAera, $this->_zoomAeraAllowed ) ) {
			require_once 'Newsky/Google/Chart/Map/Exception.php';
			throw new Newsky_Google_Chart_Map_Exception( "The zoom area '$zoomAera' is not valid. The valid zoom aera is " . implode( ', ', $this->_zoomAeraAllowed ) );
		}
		
		$this->setParam( self::PARAM_CHART_MAP_ZOOM_AERA, $zoomAera );
				
		return $this;
	}
	
	public function getZoomAera() {
		return $this->getParam( self::PARAM_CHART_MAP_ZOOM_AERA );
	}
	
	/**
	 * Set countries
	 * @param array $countries
	 * @return Newsky_Google_Chart_Map
	 */
	public function setCountries( array $countries = array() ) {
		$this->_countries = array();
		
		foreach( $countries as $country ) {
			$this->addCountry( $country );
		}
		
		return $this;
	}
	
	public function addCountry( $country ) {
		if( ! $this->hasCountry( $country ) ) {
			$this->_countries[] = self::sanitizeCountry( $country );
			
			$this->_makeCountriesParam();
		}
		
		return $this;
	}
	
	public function removeCountry( $country ) {
		if( $this->hasCountry( $country ) ) {
			
			$this->_makeCountriesParam();
		}
		
		return $this;
	}
	
	public function hasCountry( $country ) {
		return in_array( self::sanitizeCountry( $country ), $this->_countries );
	}
	
	public static function sanitizeCountry( $country ) {
		return strtoupper( substr( $country, 0, 2 ) );
	}
	
	protected function _makeCountriesParam() {
		$param = null;
		if( count( $this->_countries ) > 0 ) {
			$param = implode( '', $this->_countries );
		}
		
		$this->setParam( self::PARAM_CHART_MAP_COUNTRIES_CODE, $param );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see lib/Newsky/Google/Newsky_Google_Chart#filterParam($paramName)
	 */
	public function filterParam( $paramName ) {
		$_paramsAllowed = array( 'cht', 'chs', 'chtm', 'chld', 'chd', 'chco', 'chtt', 'chts', 'chma', 'chf' );
		
		return in_array( $paramName, $_paramsAllowed );
	}
}