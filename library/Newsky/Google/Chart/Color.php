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

class Newsky_Google_Chart_Color
{
	protected $_patterns = array(
		'long_hex_opacity'	=> '/^\#?([A-Fa-f0-9]{6})([A-Fa-f0-9]{2})$/',	// long hexadecimal color and opacity as (#)ff001188
		'long_hex'			=> '/^\#?([A-Fa-f0-9]{6})$/',					// long hecadecimal color as (#)ff0011
		'short_hex_opacity'	=> '/^\#?([A-Fa-f0-9]{3})([A-Fa-f0-9]{2})$/',	// short hexadecimal color and opacity as (#)f0188 => #ff001188
		'short_hex'			=> '/^\#?([A-Fa-f0-9]{3})$/',					// short color as #f01 => #ff0011
		'opacity'			=> '/^([A-Fa-f0-9]{2})$/'						// Just opacity as 88
	);
	
	protected $_format = null;
	
	protected $_patternFormat = null;
	
	protected $_color;
	
	/**
	 * Opacity of color
	 * By default is opaque, ie FF (256)
	 * @var string
	 */
	protected $_opacity;
	
	
	/**
	 * 
	 * @param $color Must be set in hexadecimal format
	 * @param $opacity Must be set in hexadecimal format
	 */
	public function __construct( $color, $opacity = 'ff' ) {
		$this->setOpacity( $opacity );
		$this->setColor( $color );
	}
	
	/**
	 * Factory
	 * @param string|Newsky_Google_Chart_Color $color
	 * @return Newsky_Google_Chart_Color
	 */
	public static function factory( $color ) {
		if( ! $color instanceof Newsky_Google_Chart_Color ) {
			if( !is_string( $color ) ) {
				require_once 'Newsky/Google/Chart/Data/Color/Exception.php';
				throw new Newsky_Google_Chart_Data_Series_Exception( '$color must be an instance of Newsky_Google_Chart_Color or a valid color format' );
			}
			
			$color = new self($color);
		}
		
		return $color;
	}
	
	public function setColor( $color ) {
		$this->_color = strtolower( $this->_extractColor( $color ) );
		if( $this->_hasOpacityInColor( $color ) ) {
			$this->setOpacity( $color );
		}
		
		return $this;
	}
	
	public function getColor() {
		return $this->_color;
	}
	
	public function setOpacity( $opacity = 'ff' ) {
		$this->_opacity = strtolower( $this->_extractOpacity( $opacity ) );
		
		return $this;
	}
	
	public function removeOpacity() {
		$this->_opacity = 'ff';
		
		return $this;
	}
	
	public function getOpacity() {
		return $this->_opacity;
	}
	
	public function __toString() {
		$color = $this->getColor();
		
		if( 'ff' !== $this->getOpacity() ) {
			$color.= $this->getOpacity();
		}
		
		return $color;
	}
	
	protected function _extractColor( $color ) {
		$format = $this->_getColorFormat( $color );
		$pattern = $this->_getPatternFormat( $format );
		
		preg_match( $pattern, $color, $matches );
		
		switch( $format ) {
			case 'long_hex_opacity':
			case 'long_hex':
				$color = $matches[1];
				break;
			case 'short_hex_opacity':
			case 'short_hex':
				$color = $matches[1];
				$color = $this->_short2long( $color );
				break;
		}
		
		return $color;
	}
	
	protected function _extractOpacity( $opacity ) {
		$format = $this->_getColorFormat( $opacity );
		$pattern = $this->_getPatternFormat( $format );
		
		preg_match( $pattern, $opacity, $matches );
		
		switch( $format ) {
			case 'long_hex_opacity':
			case 'short_hex_opacity':
				$opacity = $matches[2];
				break;
			case 'opacity':
				$opacity = $matches[1];
				break;
		}
		
		return $opacity;
	}
	
	/**
	 * Retrieve coor format
	 * @param string $color
	 * @return string
	 * @throw Newsky_Google_Chart_Color_Exception
	 */
	protected function _getColorFormat( $color ) {
		foreach( $this->_patterns as $format => $pattern ) {
			if( 1 == preg_match( $pattern, $color ) ) {
				$this->_format = $format;
				$this->_patternFormat = $pattern;
				
				return $this->_format;
			}
		}
		
		require_once 'Newsky/Google/Chart/Color/Exception.php';
		throw new Newsky_Google_Chart_Color_Exception( "'{$color} is not a valid format. ffaa55, #00f947, #aabbcc00 are a valid format." );
	}
	
	/**
	 * Retrive pattern by format
	 * @param string $format
	 * @return string
	 * @throw Newsky_Google_Chart_Color_Exception
	 */
	protected function _getPatternFormat( $format ) {
		if( array_key_exists( $format, $this->_patterns ) ) {
			return $this->_patterns[$format];
		}
		
		require_once 'Newsky/Google/Chart/Color/Exception.php';
		throw new Newsky_Google_Chart_Color_Exception( "'{$format} is not a valid format." );
	}
	
	/**
	 * Convert short hexadecimal format to long hexadecimal format
	 * f1e => ff11ee
	 * @param string $hex
	 * @return string
	 */
	protected function _short2long( $hex ) {
		$ret = '';
		$hex = str_split( $hex );
		foreach( $hex as $_hex ) {
			$ret.= str_repeat( $_hex, 2 );
		}
		
		return $ret;
	}
	
	protected function _hasOpacityInColor( $color ) {
		$format = $this->_getColorFormat( $color );
		
		switch( $format ) {
			case 'long_hex_opacity':
			case 'short_hex_opacity':
			case 'opacity':
				return true;
				break;
			
			default:
				return false;
				break;
		}
	}
	
	protected function _sanitizeColor( $color ) {
		$color = ( '#' == substr( $color, 0, 1 ) ) ? substr( $color, 1) : $color;
		
		return strtolower( $color );
	}
	
	/**
	 * Create a random color
	 * @param string|bool $opacity
	 * @return Newsky_Google_Chart_Color
	 */
	public static function random( $opacity = false) {
		$color = '';
		for( $i=0; $i<3; $i++ ) {
			$dec = rand( 0, 255 );
			
			$_color = dechex( $dec );
			if( 1 == strlen( $_color ) ) {
				$_color = '0' . $_color;
			}
			
			$color.= $_color;
		}
		return new self( $color );
	}
}