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

class Newsky_Google_Chart_Pie extends Newsky_Google_Chart
{
	
	CONST PARAM_CHART_LABEL					= 'chl';
	CONST PARAM_CHART_PIE_ANGLE				= 'chp';
	
	/**
	 * Allowed type chart
	 * @var array
	 */
	protected $_allowedType = array( 'p', 'p3', 'pc' );
	
	public function __construct( $type = 'p' ) {
		$this->setType( $type );
	}
	
	/**
	 * Set labels
	 * @return Newsky_Google_Chart_Pie
	 */
	public function setLabels() {
		$this->setParam( self::PARAM_CHART_LABEL, null );
		$_labels = array();
		
		foreach( func_get_args() as $arg ) {
			$_labels[] = (string) $arg;
		}
		
		if( count( $_labels ) > 0 ) {
			$this->setParam( self::PARAM_CHART_LABEL, implode( '|', $_labels ) );
		}
		
		return $this;
	}
	
	/**
	 * Get labels
	 * @return string
	 */
	public function getLabels() {
		return $this->getParam( self::PARAM_CHART_LABEL );
	}
	
	/**
	 * Set angle of pie chart
	 * @param float $angle Angle in radian
	 * return Newsky_Google_Chart_Pie
	 */
	public function setAngle( $angle ) {
		if( ! is_numeric( $angle ) ) {
			require_once 'Newsky/Google/Chart/Pie/Exception.php';
			throw new Newsky_Google_Chart_Pie_Exception( 'The parameter $angle must be a numeric value.' );
		}
		
		$angle = (float) $angle;
		$max = 2*M_PI;
		
		// Convert multiple tour to only one
		if( $angle > $max ) {
			$tourNumber = floor( $angle/$max );
			$angle = $angle - $tourNumber*$max;
		}
		
		// 2 decimals limit
		$angle = (float) number_format( $angle, 2 );
		
		$this->setParam( self::PARAM_CHART_PIE_ANGLE, $angle );
		
		return $this;
	}
	
	/**
	 * Retrieve pie chart angle 
	 * @return float
	 */
	public function getAngle() {
		return $this->getParam( self::PARAM_CHART_PIE_ANGLE );
	}
}