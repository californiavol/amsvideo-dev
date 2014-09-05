<?php
/**
 *
 * @author robertsc
 * @version 
 */
require_once 'Zend/View/Interface.php';
/**
 * LoggedInUser helper
 *
 * @uses viewHelper App_View_Helper
 */
class App_View_Helper_LoggedInUser
{
    /**
     * @var Zend_View_Interface 
     */
    protected $view;
    
	/**
     * Sets the view field 
     * @param $view Zend_View_Interface
     */
    public function setView (Zend_View_Interface $view)
    {
        $this->view = $view;
    }
    
    
    /**
     * 
     */
    public function loggedInUser ()
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
        	$logoutUrl = $this->view->url(array('module' => 'default', 'controller' => 'cas', 'action' => 'logout'));
        	
        	//get user
        	$identity = $auth->getIdentity();
        	$user = $this->view->escape($identity->user);
        	
        	$string = 'Logged in as ' . $user .' | <a href="'.$logoutUrl.'">Log out</a>';
        } else {
        	$loginUrl = $this->view->url(array('module' => 'default', 'controller' => 'cas', 'action' => 'login'));
        	
        	$string = '<a href="'.$loginUrl.'">Log in</a>';
        }

        return $string;
    }
    
    
    
    
}
