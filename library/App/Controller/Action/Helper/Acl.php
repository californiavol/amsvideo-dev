<?php
/**
 *
 * @author robertsc
 * @version 
 */

define ('USER_ADMIN', 'OU=Streaming Media');
define ('USER_STAFF', 'CN=univ-staff-all');
define ('USER_FACULTY', 'CN=univ-faculty-all');
define ('USER_STUDENT', 'CN=univ-student-all');
define ('USER_GUEST', 'guest');
/**
 * Acl Action Helper 
 * 
 * @uses actionHelper App_Controller_Action_Helper
 */
class App_Controller_Action_Helper_Acl extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * @var Zend_Loader_PluginLoader
     */
    public $pluginLoader;
    
    
    protected $_action;
    protected $_auth;
    protected $_acl;
    protected $_controllerName;
    
    
    
    /**
     * Constructor: initialize plugin loader
     * 
     * @return void
     */
    public function __construct (Zend_View_Interface $view = null, array $options = array())
    {
        $this->pluginLoader = new Zend_Loader_PluginLoader();
    
    	$this->_auth = Zend_Auth::getInstance();
    	$this->_acl = new App_Acl();
    	//$this->_acl = $options['acl'];
    }
    
    public function init()
    {
    	$this->_action = $this->getActionController();

    	//add resource for this controller
    	$controller = $this->_action->getRequest()->getControllerName();
    	if (!$this->_acl->has($controller)) {
    		$this->_acl->add(new Zend_Acl_Resource($controller));
    	}
    }
    
    public function allow($roles = null, $actions = null)
    {
    	$resource = $this->_controllerName;
    	$this->_acl->allow($roles, $resource, $actions);
    	return $this;
    }
     
    public function deny($roles = null, $actions = null)
    {
    	$resource = $this->_controllerName;
    	$this->_acl->deny($roles, $resource, $actions);
    	return $this;    	
    }
    
    public function preDispatch()
    {
    	$role = 'guest';
    	if ($this->_auth->hasIdentity()) {
    		$identity = $this->_auth->getIdentity();
    		
    		$user = $this->_auth->getIdentity()->user;
    		
    		//get superusers from config application.ini
        	$superusers = array();
        	$superusers = Zend_Registry::get('config')->acl;
        	//set object as an array
        	$superusers = (array) $superusers;
        	//var_dump($superusers);
        
        	//get groups from cas attributes
        	$groups = $identity->{'attributes'}->{'Groups'};
        
	        if (in_array($user, $superusers)) {
	    		$role = 'superuser';
	    	} elseif (strpos($groups, USER_ADMIN) !== false) {
			    $role = 'administrator';
			} elseif (strpos($groups, USER_STAFF) !== false) {
				$role = 'staff';
			} elseif (strpos($groups, USER_FACULTY) !== false) {
				$role = 'faculty';
			} elseif (strpos($groups, USER_STUDENT) !== false) {
				$role = 'student';	
			} else {
				$role = 'guest';
			}
    		
    	}
    	
    	$request = $this->_action->getRequest();
    	$controller = $request->getControllerName();
    	$action = $request->getActionName();
    	$module = $request->getModuleName();
    	$this->_controllerName = $controller;
    	
    	$resource = $controller;
    	$privilege = $action;
    	
    	if (!$this->_acl->isAllowed($role, $resource, $privilege)) {
    		$request->setModuleName('default');
    		$request->setControllerName('cas');
    		$request->setActionName('login');
    		$request->setDispatched(false);
    	}
    }
    
    
    
    /*
     * Strategy pattern: call helper as broker method
     */
    public function direct ()
    {
        // TODO Auto-generated 'direct' method
    }
}
