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

class Newsky_Google_Chart_Data_Series
{
	protected $_series;
	
	/**
	 * Legend's series
	 * @var string
	 */
	protected $_legend = null;
	
	/**
	 * Color series
	 * @var Newsky_Google_Chart_Color
	 */
	protected $_color = 'ff9900';
	
	public function __construct( array $series = array(), $legend = null ) {
		$this->setSeries( $series );
		$this->setLegend( $legend );
	}
	
	public function setSeries( array $series = array() ) {
		$this->_series = array();
		$this->addSerie( $series );
		
		return $this;
	}
	
	/**
	 * 
	 * @param mixed $serie
	 * @return Newsky_Google_Chart_Data_Series
	 */
	public function addSerie( $serie ) {
		if( is_array( $serie ) ) {
			foreach( $serie as $_serie ) {
				$this->addSerie( $_serie );
			}
			
			return $this;
		}
		
		$serie = self::sanitizeNumber( $serie );
		
		if( ! self::filterNumber( $serie ) ) {
			require_once 'Newsky/Google/Chart/Data/Series/Exception.php';
			throw new Newsky_Google_Chart_Data_Series_Exception( 'The value of $serie is not a valid number' );
		}
		
		$this->_series[] = $serie;
				
		return $this;
	}
	
	/**
	 * 
	 * @return Newsky_Google_Chart_Data_Series
	 */
	public function getSeries() {
		return $this->_series;
	}
	
	/**
	 * Set legend's series
	 * @param string $legend
	 * @return Newsky_Google_Chart_Data_Series
	 */
	public function setLegend( $legend = null ) {
		if( null !== $legend ) {
			$legend = (string) $legend;
		}
		$this->_legend = $legend;
		
		return $this;
	}
	
	/**
	 * Retrieve legend's serie
	 * @return string|null
	 */
	public function getLegend() {
		return $this->_legend;
	}
	
	/**
	 * Set color's series
	 * @param Newsky_Google_Chart_Color|string $color
	 * @return Newsky_Google_Chart_Data_Series
	 */
	public function setColor( $color ) {
		$this->_color = Newsky_Google_Chart_Color::factory( $color ) ;
		
		return $this;
	}
	
	/**
	 * Retrieve color's series
	 * @return Newsky_Google_Chart_Color
	 */
	public function getColor() {
		return $this->_color;
	}
	
	/**
	 * Get the max value of serie
	 * @return int
	 */
	public function getMaxValue() {
		return max( $this->_series );
	}
	
	/**
	 * Get the min value of serie
	 * @return int
	 */
	public function getMinValue() {
		return min( $this->_series );
	}
	
	/**
	 * sanitize number format
	 * @param mixed $number
	 * @return float|int
	 */
	public static function sanitizeNumber( $number ) {
		$number = preg_replace( '#\s+#', '', $number );
		$number = str_replace( ',', '.', $number );
		$number = preg_replace( '#[^\d\.]#', '', $number );
		
		return $number;
	}
	
	/**
	 * Filter non-numeric values
	 * @param mixed $number
	 * @return bool
	 */
	public static function filterNumber( $number ) {
		return is_numeric( $number );
	}
}