<?php
/**
 *
 * @author robertsc
 * @version 
 */

/**
 * RandomString Action Helper 
 * 
 * @uses actionHelper App_Controller_Action_Helper
 */
class App_Controller_Action_Helper_RandomString extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * @var Zend_Loader_PluginLoader
     */
    public $pluginLoader;
    /**
     * Constructor: initialize plugin loader
     * 
     * @return void
     */
    public function __construct ()
    {
        // TODO Auto-generated Constructor
        $this->pluginLoader = new Zend_Loader_PluginLoader();
    }
    /**
     * Strategy pattern: call helper as broker method
     */
    public function direct ($length = 32, $chars = '1234567890abcdef')
    {
		// LENGTH OF CHARACTER LIST
        $charsLength = (strlen($chars) - 1);
 
        // START OUR STRING
        $string = $chars{rand(0, $charsLength)};
 
        // GENERATE RANDOM STRING
        for ($i = 1; $i < $length; $i = strlen($string)) {
            // GRAB A RANDOM CHARACTER FROM OUR LIST
            $r = $chars{rand(0, $charsLength)};
            // MAKE SURE THE SAME TWO CHARACTERS DON'T APPEAR NEXT TO EACH OTHER
            if ($r != $string{$i - 1}) {
                $string .=  $r;
            } else {
                $i--;
            }
        }
 
        // RETURN THE STRING
        return $string;
    }
}
