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

class Newsky_Google_Chart_Data implements Countable, ArrayAccess, Iterator
{
	
	/**
	 * Series data
	 * @var array
	 */
	protected $_series = array();
	
	protected $_defaultSeriesClassname = 'Newsky_Google_Chart_Data_Series';
		
	/**
	 * Series data label
	 * @var string
	 */
	protected $_label;
	
	/**
	 * Series data legend for each data
	 * @var array
	 */
	protected $_legend;
	
	/**
	 * Series data colors
	 * @var Newsky_Google_Chart_Color
	 */
	protected $_colors = array();
	
	/**
	 * Data encoder class
	 * @var Newsky_Google_Chart_Encoder_Interface
	 */
	protected $_seriesEncoder = null;
	
	/**
	 * Default data encoder if $_dataEncoder is null
	 * @param array $data
	 * @return Newsky_Google_Chart_Encoder_Interface
	 */
	protected $_defaultEncoder = 'Newsky_Google_Chart_Encoder_Basic';
	
	/**
	 * Reset all series and add a new serie
	 * @param Newsky_Google_Chart_Data_Series $series
	 * @return Newsky_Google_Chart_Data
	 */
	public function setSeries( Newsky_Google_Chart_Data_Series $series ) {
		$this->_series = array();
		$this->addSeries( $series );
		
		return $this;
	}
	
	/**
	 * Add a series
	 * $param string $id
	 * @param Newsky_Google_Chart_Data_Series $series
	 * @return Newsky_Google_Chart_Data
	 */
	public function addSeries( $id, Newsky_Google_Chart_Data_Series $series ) {
		$this->_series[$id] = $series;
		
		return $this;
	}
	
	/**
	 * Return serie $id
	 * @param string $id
	 * @return Newsky_Google_Chart_Data_Series
	 */
	public function getSerie( $id ) {
		if( !$this->hasSerie( $id ) ) {
			if (!class_exists($this->_defaultSeriesClassname)) {
	            require_once 'Zend/Loader.php';
	            Zend_Loader::loadClass( $this->_defaultSeriesClassname );
	        }

	        $this->addSeries($id, new $this->_defaultSeriesClassname);
		}
				
		return $this->_series[$id];
	}
	
	/**
	 * 
	 * @param string $id
	 * @return bool
	 */
	public function hasSerie( $id ) {
		return isset( $this->_series[$id] );
	}
	
	/**
	 * Remove serie $id
	 * @param string $id
	 * @return bool
	 */
	public function removeSerie( $id ) {
		if( !$this->hasSerie( $id ) ) {
			return false;
		}
		
		unset( $this->_series[$id] );
		
		return true;
	}
	
	/**
	 * Return all series
	 * @return array
	 */
	public function getSeries() {
		return $this->_series;
	}
	
	/**
	 * Retrive the max value of all series
	 * @return int
	 */
	public function getMaxValue() {
		$max = 0;
		foreach( $this->getSeries() as $serie ) {
			if( $serie->getMaxValue() > $max ) {
				$max = $serie->getMaxValue();
			}
		}
		
		return $max;
	}
	
	/**
	 * Retrive the min value of all series
	 * @return int
	 */
	public function getMinValue() {
		$min = null;
		foreach( $this->getSeries() as $serie ) {
			if( null === $min ) {
				$min = $serie->getMinValue();
			}
			elseif( $serie->getMinValue() < $min ) {
				$min = $serie->getMinValue();
			}
		}
		
		return (int) $min;
	}
	
	/**
	 * Set the data series encoder
	 * @param Newsky_Google_Chart_Encoder_Interface $encoder
	 * @return Newsky_Google_Chart_Data
	 */
	public function setEncoder( Newsky_Google_Chart_Encoder_Interface $encoder ) {
		$this->_seriesEncoder = $encoder;
		
		return $this;
	}
	
	/**
	 * Get the data encoder
	 * @return Newsky_Google_Chart_Encoder_Interface
	 */
	public function getEncoder() {
		if( null === $this->_seriesEncoder ) {
			include_once 'Zend/Loader.php';
			Zend_Loader::loadClass( $this->_defaultEncoder );
			$this->_seriesEncoder = new $this->_defaultEncoder;
		}
		
		return $this->_seriesEncoder;
	}
	
	/**
	 * Retrieve formated params data
	 * @return string
	 */
	public function getParamData() {
		$param = $this->getEncoder()->getPrefix();
		
		$_data = array();
		foreach( $this as $data ) {
			$_data[] = $this->getEncoder()->encode( $data->getSeries() );
		}
		
		if( 't:' !== $param ) {
			$param.= implode( ',', $_data );
		} else {
			$param.= implode( '|', $_data );
		}
		
		return $param;
	}
	
	/**
	 * Retrive formated param color
	 * @return string
	 */
	public function getParamColor() {
		$hasColor = false;
		$_data = array();
		foreach( $this as $data ) {
			if( null !== $data->getColor() ) {
				$hasColor = true;
			}
			
			$_data[] = $data->getColor();
		}
		
		if( !$hasColor ) {
			return null;
		}
		
		return implode( ',', $_data );
	}
	
	/**
	 * Retrieve formated param legend
	 * @return string
	 */
	public function getParamLegend() {
		$hasLegend = false;
		$_data = array();
		foreach( $this as $data ) {
			if( null !== $data->getLegend() ) {
				$hasLegend = true;
			}
			
			$_data[] = $data->getLegend();
		}
		
		if( !$hasLegend ) {
			return null;
		}
		
		return implode( '|', $_data );
	}
	
	
	
	/**
	 * Implements Countable
	 * @return int
	 */
	public function count() {
		return count( $this->_series );
	}
	
	/**
	 * Implements ArrayAccess
	 * @param string|int $offset
	 * @return bool
	 */
	public function offsetExists( $offset ) {
		return isset( $this->_series[$offset] );
	}
	
	/**
	 * Implements ArrayAccess
	 * @param string|int $offset
	 * @return mixed
	 */
	public function offsetGet( $offset ) {
		return isset( $this->_series[$offset] ) ? $this->_series[$offset] : null;
	}
	
	/**
	 * Implements ArrayAccess
	 * @param string|int $offset
	 * @param mixed $value
	 * @return void
	 */
	public function offsetSet( $offset, $value ) {
		$this->_series[$offset] = $value;
	}
	
	/**
	 * Implements ArrayAccess
	 * @param string|int $offset
	 * @return void
	 */
	public function offsetUnset( $offset ) {
		unset( $this->_series[$offset] );
	}
	
	/**
	 * Implements Iterator
	 * @return mixed
	 */
	public function current() {
		return current( $this->_series );
	}
	
	/**
	 * Implements Iterator
	 * @return mixed
	 */
	public function key() {
		return key($this->_series );
	}
	
	/**
	 * Implements Iterator
	 * @return mixed
	 */
	public function next() {
		return next( $this->_series );
	}

	/**
	 * Implements Iterator
	 * @return mixed
	 */
	public function rewind() {
		return reset( $this->_series );
	}
	
	/**
	 * Implements Iterrator 
	 * @return bool
	 */
	public function valid() {
		return (bool)current( $this->_series );
	}
	
}