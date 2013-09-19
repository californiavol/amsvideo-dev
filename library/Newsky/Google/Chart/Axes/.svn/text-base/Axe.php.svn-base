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

class Newsky_Google_Chart_Axes_Axe
{
	/**
	 * Postion of axe. Can be x, y, r or t 
	 * @var string
	 */
	protected $_visibility = null;
	
	/**
	 * @var array
	 */
	protected $_visibilityAllowed = array( 'x', 'y', 'r', 't' );
	
	/**
	 * Axe range configuration
	 * @var null|array
	 */
	protected $_axeRange = null;
	
	/**
	 * Axe label position 
	 * @var array
	 */
	protected $_labelPosition = null;
	
	protected $_customLabel = null;
	
	
	public function __construct( $visibility = 'x' ) {
		$this->setVisibility( $visibility );
	}
	
	/**
	 * Set the visibility of axe. Can be x, y, r or t
	 * @param string $visibility
	 * @return Newsky_Google_Chart_Axes_Axe
	 */
	public function setVisibility( $visibility ) {
		if( ! in_array( $visibility, $this->_visibilityAllowed ) ) {
			require_once( 'Newsky/Google/Chart/Axes/Axe/Exception.php' );
			throw new Newsky_Google_Google_Chart_Axes_Axe_Exception( 'The visibility value is not valid. Can be x, y, r or t.' );
		}
		
		$this->_visibility = $visibility;
		
		return $this;
	}
	
	/**
	 * Retrieve visibility of axe
	 * @return string
	 */
	public function getVisibility() {
		return $this->_visibility;
	}
	
	/**
	 * Set the range of axe
	 * @param int $start
	 * @param int $end
	 * @param int $step
	 * @return Newsky_Google_Chart_Axes_Axe
	 */
	public function setAxeRange( $start, $end, $step = null ) {
		$axeRange = array( (int) $start, (int) $end );
		if( ! is_null( $step ) ) {
			$axeRange[] = $step;
		}
		
		$this->_axeRange = $axeRange;
		
		return $this;
	}
	
	public function getAxeRange() {
		return $this->_axeRange;
	}
	
	public function setLabelPosition() {
		$this->_labelPosition = null;
		$_labelPosition = array();
		
		foreach( func_get_args() as $arg ) {
			if( is_array( $arg ) ) {
				$_labelPosition = array_merge( $_labelPosition, $arg );
			}
			
			$_labelPosition[] = $arg;
		}
		
		$_labelPosition = array_filter( $_labelPosition );
		
		if( count( $_labelPosition ) ) {
			$this->_labelPosition = $_labelPosition;
		}
		
		return $this;
	}
	
	public function getLabelPosition() {
		return $this->_labelPosition;
	}
	
	public function setCustomLabel() {
		$this->_customLabel = null;
		$_customLabel = array();
		
		foreach( func_get_args() as $arg ) {
			if( is_array( $arg ) ) {
				$_customLabel = array_merge( $_customLabel, $arg );
			}
			
			$_customLabel[] = $arg;
		}
				
		if( count( $_customLabel ) ) {
			$this->_customLabel = $_customLabel;
		}
		
		return $this;
	}
	
	public function getCustomLabel() {
		return $this->_customLabel;
	}
}