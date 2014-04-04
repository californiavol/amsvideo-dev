<?php
class App_Controller_Plugin_Auth extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $auth = Zend_Registry::getInstance()->get('auth');
        $acl = new Zend_Acl();
 
        // FOR DEFAULT MODULE
        if ($request->getModuleName() == 'default') {
 
            // ACCESS RESOURCES (CONTROLLERS)
            // USUALLY THERE WILL BE MORE ACCESS RESOURCES
            $acl->addResource(new Zend_Acl_Resource('index'));
            $acl->addResource(new Zend_Acl_Resource('error'));
 			$acl->addResource(new Zend_Acl_Resource('test'));
            $acl->addResource(new Zend_Acl_Resource('department'));
            $acl->addResource(new Zend_Acl_Resource('video'));
            
            // ACCESS ROLES
            $acl->addRole(new Zend_Acl_Role('guest'));
            $acl->addRole(new Zend_Acl_Role('user'));
            $acl->addRole(new Zend_Acl_Role('administrator'));
 
            // ACCESS RULES
            $acl->allow('guest'); // ALLOW GUESTS EVERYWHERE
            $acl->allow('user'); // ALLOW USERS EVERYWHERE
            $acl->allow('administrator'); // ALLOW ADMINISTRATORS EVERYWHERE
 
            $role = ($auth->getIdentity() && $auth->getIdentity()->status = 'approved') ? $auth->getIdentity()->role : 'guest';

            $controller = $request->getControllerName();
            $action = $request->getActionName();
 
            if (!$acl->isAllowed($role, $controller, $action)) {
            	$redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector');
                $redirector->gotoUrlAndExit('/default/index');
            }
 
        }
        // FOR MEMBER MODULE
        else if ($request->getModuleName() == 'member') {
 
            // ACCESS RESOURCES (CONTROLLERS)
            // USUALLY THERE WILL BE MORE ACCESS RESOURCES
            $acl->addResource(new Zend_Acl_Resource('index'));
            $acl->addResource(new Zend_Acl_Resource('error'));
 
            // ACCESS ROLES
            $acl->addRole(new Zend_Acl_Role('guest'));
            $acl->addRole(new Zend_Acl_Role('user'));
            $acl->addRole(new Zend_Acl_Role('administrator'));
 
            // ACCESS RULES
            $acl->allow('user'); // ALLOW USERS EVERYWHERE
            $acl->allow('administrator'); // ALLOW ADMINISTRATORS EVERYWHERE
 
            $role = ($auth->getIdentity() && $auth->getIdentity()->status = 'approved')
            ? $auth->getIdentity()->role : 'guest';
            $controller = $request->getControllerName();
            $action = $request->getActionName();
 
            if (!$acl->isAllowed($role, $controller, $action)) {
                $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector');
                $redirector->gotoUrlAndExit('/admin/login');
            }
 
        }
        // FOR ADMIN MODULE
        else if ($request->getModuleName() == 'admin') {
 
            // ACCESS RESOURCES (CONTROLLERS)
            // USUALLY THERE WILL BE MORE ACCESS RESOURCES
            $acl->addResource(new Zend_Acl_Resource('index'));
            $acl->addResource(new Zend_Acl_Resource('error'));
            $acl->addResource(new Zend_Acl_Resource('user'));
		    $acl->addResource(new Zend_Acl_Resource('video'));
		    $acl->addResource(new Zend_Acl_Resource('department'));
            $acl->addResource(new Zend_Acl_Resource('playlist'));
            $acl->addResource(new Zend_Acl_Resource('stream'));
		    $acl->addResource(new Zend_Acl_Resource('login'));
            $acl->addResource(new Zend_Acl_Resource('register'));
            $acl->addResource(new Zend_Acl_Resource('courselist'));
 			$acl->addResource(new Zend_Acl_Resource('test'));
            
            // ACCESS ROLES
            $acl->addRole(new Zend_Acl_Role('guest'));
            $acl->addRole(new Zend_Acl_Role('user'));
            $acl->addRole(new Zend_Acl_Role('administrator'));
 
            // ACCESS RULES
            $acl->allow('guest', array('index', 'test'),array('login', 'courselist', 'teststream')); // allow guests to login and see courselist
            $acl->allow('administrator'); // ALLOW ADMINISTRATORS EVERYWHERE
 
            $role = ($auth->getIdentity() && $auth->getIdentity()->status = 'approved') ? $auth->getIdentity()->role : 'guest';
            
            $controller = $request->getControllerName();
            $action = $request->getActionName();
 
            if (!$acl->isAllowed($role, $controller, $action)) {
                $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector');
                $redirector->gotoUrlAndExit('/admin/index/login');
            }
 
        }
    }
}