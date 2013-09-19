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

require_once 'Newsky/Google/Chart/Background.php';

class Newsky_Google_Chart_Background_Solid extends Newsky_Google_Chart_Background
{
	protected $_identity = 's';
	
	/**
	 * Array of fill type allowed.
	 * @var array
	 */
	protected $_fillTypeAllowed = array( 'bg', 'c', 'a', 'b' );
	
	
	public function toParam() {
		/** Fatal error: Method Newsky_Google_Chart_Line::__toString() must not throw an exception in xxx
		if( ! $this->getFillType() || ! $this->getColor() ) {
			require_once 'Newsky/Google/Chart/Background/Solid/Exception.php';
			throw new Newsky_Google_Chart_Background_Solid_Exception( 'Fill Type and Color is required.' );
		}
		*/
		return implode( ',', array( $this->getFillType(), $this->getIdentity(), $this->getColor() ) );
	}
}