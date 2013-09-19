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

class Newsky_Google_Chart_Encoder_Basic implements Newsky_Google_Chart_Encoder_Interface
{
	protected $_prefix = 't:';
	
	/**
	 * Data to encode
	 * @var array
	 */
	protected $_data;
	
	/**
	 * Max value allowed
	 * @see http://code.google.com/intl/fr/apis/chart/docs/data_formats.html#text
	 * @var int
	 */
	protected $_maxValueAllowed = 100;
	
	public function encode( $string ) {
		if( !is_array( $string ) ) {
			$string = explode( ',', $string );
		}
		$this->_data = $string;
		
		$data = array_map( array( $this, '_filter'), $this->_data );
		
		return implode( ',', $data );
	}
	
	public function decode( $string ) {
		return $string;
	}
	
	public function getPrefix() {
		return $this->_prefix;
	}
	
	protected function _filter( $value ) {
		if( $value > $this->_maxValueAllowed ) {
			return '_';
		}
		
		return $value;
	}
}