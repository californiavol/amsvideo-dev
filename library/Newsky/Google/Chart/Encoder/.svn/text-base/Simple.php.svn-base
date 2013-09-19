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

/**
 * @see Newsky_Google_Chart_Encoder_Interface
 */
require_once 'Newsky/Google/Chart/Encoder/Interface.php';

class Newsky_Google_Chart_Encoder_Simple implements Newsky_Google_Chart_Encoder_Interface
{
	protected $_prefix = 's:';
	
	/**
	 * Data to encode
	 * @var array
	 */
	protected $_data;
	
	/**
	 * Max value of series data
	 * @var int
	 */
	protected $_maxValue = null;
	
	/**
	 * Max value allowed
	 * @see http://code.google.com/intl/fr/apis/chart/docs/data_formats.html#simple
	 * @var int
	 */
	protected $_maxValueAllowed = 61;
	
	protected $_simpleEncoding = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	
	
	public function encode( $string ) {
		if( !is_array( $string ) ) {
			$string = explode( ',', $string );
		}
		$this->_data = $string;
		
		$simpleEncoding = $this->_simpleEncoding;

		$ret = '';
		foreach( $this->_data as $value ) {
			$index = round( ( strlen( $simpleEncoding ) - 1 ) * $value / $this->getMaxValue() );
			
			if( $index >= 0 && $index <= $this->_maxValueAllowed ) {
				$ret.= $simpleEncoding[$index];
			} else {
				$ret.= '_';
			}
		}
		
		return $ret;
	}
	
	public function decode( $string ) {
		$string = str_replace( '_', '', $string );
		$string = str_replace( $this->getPrefix(), '', $string );
		$string = str_split( $string );
		
		$simpleEncoding = array_flip( str_split( $this->_simpleEncoding ) );

		$ret = array();
		foreach( $string as $value ) {
			if( !isset( $simpleEncoding[$value] ) ) {
				continue;
			}
			
			$ret[] = $simpleEncoding[$value];
		}
		
		return implode( ',', $ret );
	}
	
	/**
	 * Set the max value
	 * @param int $maxValue
	 * @return Newsky_Google_Chart_Encoder_Simple
	 */
	public function setMaxValue( $maxValue ) {
		$this->_maxValue = (int) $maxValue;
		return $this;
	}
	
	/**
	 * Retrieve the max value. If the max value is null, return
	 * the max value in data array
	 * @return int
	 */
	public function getMaxValue() {
		if( null === $this->_maxValue ) {
			try {
				$this->_maxValue = max( $this->_data );
			} catch( Exception $e ) {
				$this->_maxValue = $this->_maxValueAllowed;
			}
		}
		
		return $this->_maxValue;
	}
	
	public function getPrefix() {
		return $this->_prefix;
	}
}