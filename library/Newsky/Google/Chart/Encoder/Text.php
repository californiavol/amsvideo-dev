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

class Newsky_Google_Chart_Encoder_Text implements Newsky_Google_Chart_Encoder_Interface
{
	protected $_prefix = '';
	
	public function encode( $string ) {
		// Replace spaces at begin or end of each line
		$string = preg_replace( '!^[\r\n ]+|[\r\n ]+$!m', '', $string );
		// Replace spaces by '+'
		$string = preg_replace( '! +!m', '+', $string );
		// replace new line by '|'
		$string = preg_replace( '!\n+|\r\n+!m', '|', $string );
				
		return $string;
	}
	
	public function decode( $string ) {
		$string = preg_replace( '!\++!', ' ', $string );
		$string = preg_replace( '!\|+!', "\n", $string );
		
		return $string;
	}
	
	public function getPrefix() {
		return $this->_prefix;
	}
}