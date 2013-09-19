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

class Newsky_Google_Chart_Background_Striped extends Newsky_Google_Chart_Background
{
	protected $_identity = 'ls';
	
	protected $_angle = 0;
	
	protected $_color = array();
	
	/**
	 * Set angle of gradient
	 * @param int $angle
	 * @return Newsky_Google_Chart_Background_Striped
	 */
	public function setAngle( $angle ) {
		if( ! is_numeric( $angle ) ) {
			require_once 'Newsky/Google/Chart/Background/Striped/Exception.php';
			throw new Newsky_Google_Chart_Background_Striped_Exception( 'The parameter $angle must be a numeric value.' );
		}
		
		$angle = (int) $angle;
		$max = 360;
		
		// Convert multiple tour to only one
		if( $angle > $max ) {
			$tourNumber = floor( $angle/$max );
			$angle = $angle - $tourNumber*$max;
		}
		
		$this->_angle = $angle;
		
		return $this;
	}
	
	public function getAngle() {
		return $this->_angle;
	}
	
	/**
	 * Extends Newsky_Google_Chart_Background::setColor()
	 * @see lib/Newsky/Google/Chart/Newsky_Google_Chart_Background#setColor($color)
	 */
	public function setColor( $color, $width = 0 ) {
		$this->_color = array();
		return $this->addColor( $color, $width = 0 );
	}
	
	/**
	 * Add a color to gradient background
	 * @param string|Newsky_Google_Chart_Color $color
	 * @param float $width 0.0 to 1.0
	 * @return Newsky_Google_Chart_Background_Striped
	 */
	public function addColor( $color, $width = 0 ) {
		require_once 'Newsky/Google/Chart/Color.php';
		$color = Newsky_Google_Chart_Color::factory( $color )->removeOpacity();
		
		if( ! is_numeric( $width ) ) {
			require_once 'Newsky/Google/Chart/Background/Striped/Exception.php';
			throw new Newsky_Google_Chart_Background_Striped_Exception( 'The parameter $width must be a numeric value.' );
		}
		
		$width = abs( (float) number_format( $width, 2 ) );
		if( $width > 1 ) {
			$width = 1;
		}
		
		$this->_color[] = array( $color, $width );
		
		return $this;
	}
	
	public function toParam() {
		$params =  array( $this->getFillType(), $this->getIdentity(), $this->getAngle() );
		
		foreach( $this->getColor() as $color ) {
			$params[] = $color[0];
			$params[] = $color[1];
		}
		
		return implode( ',', $params );
	}
}