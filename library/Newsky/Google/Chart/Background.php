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
 * This class 
 * @author Luc ALBERT
 */
abstract class Newsky_Google_Chart_Background
{
	/**
	 * Identity of background fills type. Can be 's' for Solid Fills,
	 * 'lg' for Gradient Fills or 'ls' for Stripped Fills. This property
	 * must be overwrited in subclass
	 * @var string
	 */
	protected $_identity;
	
	/**
	 * Fill type. This parameter depends of type of background
	 * @var string
	 */
	protected $_fillType;
	
	/**
	 * Color of background
	 * @var Newsky_Google_Chart_Color
	 */
	protected $_color;
	
	/**
	 * Array of fill type allowed. This property can be 
	 * overwrite in subclass if necessary. It's used in 
	 * setFillType method for validate fill type.
	 * @var array
	 */
	protected $_fillTypeAllowed = array( 'bg', 'c', 'b' );
	
	/**
	 * This method can't be called. Use the subclasses property 
	 * $_identity to initialize it.
	 * @throw Newsky_Google_Chart_Background_Exception
	 */
	final private function setIdentity() {
		require_once 'Newsky/Google/Chart/Background/Exception.php';
		throw Newsky_Google_Chart_Background_Exception( 'This method can\'t be called. Use the subclasses property $_identity to initialize it.' );
	}
	
	/**
	 * Retrive the identity of background. This property
	 * depends of subclass
	 * @return string
	 */
	final public function getIdentity() {
		return $this->_identity;
	}
	
	/**
	 * Set the fill type of background
	 * @param string $fillType
	 * @return Newsky_Google_Chart_Background
	 */
	public function setFillType( $fillType ) {
		if( ! in_array( $fillType, $this->_fillTypeAllowed ) ) {
			require_once 'Newsky/Google/Chart/Background/Exception.php';
			throw new Newsky_Google_Chart_Background_Exception( $fillType . ' is not a valid fill type. The allowed fill type is ' . implode( ', ', $this->_fillTypeAllowed ) );
		}
		
		$this->_fillType = (string) $fillType;
		
		return $this;
	}
	
	/**
	 * Get Fill type of background
	 * @return string
	 */
	public function getFillType() {
		return $this->_fillType;
	}
	
	/**
	 * Set the color of background
	 * @param string|Newsky_Google_Chart_Color $color
	 * @return Newsky_Google_Chart_Background
	 */
	public function setColor( $color ) {
		require_once 'Newsky/Google/Chart/Color.php';
		$this->_color = Newsky_Google_Chart_Color::factory( $color ) ;
		
		return $this;
	}
	
	public function getColor() {
		return $this->_color;
	}
	
	/**
	 * @see Newsky_Google_Chart_Background::toParam()
	 * @return string
	 */
	public function __toString() {
		return $this->toParam();
	}
	
	/**
	 * Prepare data to param
	 * @return string
	 */
	abstract public function toParam();
} 