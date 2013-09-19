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

class Newsky_Google_Chart_Axes implements Countable, ArrayAccess, Iterator
{
	/**
	 * Axes array container
	 * @var array
	 */
	protected $_axes = array();
	
	
	public function addAxe( Newsky_Google_Chart_Axes_Axe $axe ) {
		$this->_axes[] = $axe;
	}

	public function getParamAxesVisibility() {
		$_data = array();
		foreach( $this as $axe ) {
			$_data[] = $axe->getVisibility();
		}
		
		return implode( ',', $_data );
	}
	
	public function getParamAxesRange() {
		$_data = array();
		foreach( $this as $index => $axe ) {
			$axeRange = $axe->getAxeRange();
			if( null === $axeRange ) {
				continue;
			} 
						
			array_unshift( $axeRange, (int) $index );			
			$_data[] = implode( ',', $axeRange );
		}
		
		return implode( '|', $_data );
	}
	
	public function getParamLabelPosition() {
		$_data = array();
		foreach( $this as $index => $axe ) {
			$labelPos = $axe->getLabelPosition();
			if( null === $labelPos ) {
				continue;
			}
			
			array_unshift( $labelPos, (int) $index );			
			$_data[] = implode( ',', $labelPos );
		}
		
		return implode( '|', $_data );
	}
	
	public function getParamCustomLabel() {
		$_data = array();
		foreach( $this as $index => $axe ) {
			$customLabel = $axe->getCustomLabel();
			if( null === $customLabel ) {
				continue;
			}
			
			array_unshift( $customLabel, (int) $index . ':' );
			$_data[] = implode( '|', $customLabel );
		}
		
		return implode( '|', $_data );
	}
	
	
	/**
	 * Implements Countable
	 * @return int
	 */
	public function count() {
		return count( $this->_axes );
	}
	
	/**
	 * Implements ArrayAccess
	 * @param string|int $offset
	 * @return bool
	 */
	public function offsetExists( $offset ) {
		return isset( $this->_axes[$offset] );
	}
	
	/**
	 * Implements ArrayAccess
	 * @param string|int $offset
	 * @return mixed
	 */
	public function offsetGet( $offset ) {
		return isset( $this->_axes[$offset] ) ? $this->_axes[$offset] : null;
	}
	
	/**
	 * Implements ArrayAccess
	 * @param string|int $offset
	 * @param mixed $value
	 * @return void
	 */
	public function offsetSet( $offset, $value ) {
		$this->_axes[$offset] = $value;
	}
	
	/**
	 * Implements ArrayAccess
	 * @param string|int $offset
	 * @return void
	 */
	public function offsetUnset( $offset ) {
		unset( $this->_axes[$offset] );
	}
	
	/**
	 * Implements Iterator
	 * @return mixed
	 */
	public function current() {
		return current( $this->_axes );
	}
	
	/**
	 * Implements Iterator
	 * @return mixed
	 */
	public function key() {
		return key($this->_axes );
	}
	
	/**
	 * Implements Iterator
	 * @return mixed
	 */
	public function next() {
		return next( $this->_axes );
	}

	/**
	 * Implements Iterator
	 * @return mixed
	 */
	public function rewind() {
		return reset( $this->_axes );
	}
	
	/**
	 * Implements Iterrator 
	 * @return bool
	 */
	public function valid() {
		return (bool)current( $this->_axes );
	}
	
}