<?php
/**
 *
 * @author robertsc
 * @version 
 */

/**
 * MobileDetect Action Helper 
 * 
 * @uses actionHelper Zend_Controller_Action_Helper
 */
class App_Controller_Action_Helper_MobileDetect extends Zend_Controller_Action_Helper_Abstract
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
    public function direct ()
    {
        
        require_once APPLICATION_PATH . '/../library/vendors/Mobile-Detect-2.7.0/Mobile_Detect.php';
        
	    $detect = new Mobile_Detect;
	    //are we dealing with mobile, tablet, or computer?
	    $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
		return $deviceType;
    }
    
//close class    
}