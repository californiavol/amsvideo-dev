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

class Newsky_Google_Chart_Radar extends Newsky_Google_Chart
{
	
	/**
	 * Allowed type chart
	 * @var array
	 */
	protected $_allowedType = array( 'r', 'rs');
	
	public function __construct( $type = 'r' ) {
		$this->setType( $type );
	}
}