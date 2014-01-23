<?php

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->usersTable = new Admin_Model_DbTable_Users();
    	
    	$this->videosTable = new Application_Model_DbTable_Videos();
    	
    	$this->coursesTable = new Application_Model_DbTable_Courses();
    }
    
    public function indexAction()
    {
    	$this->view->msg = 'success';
    }
    
    public function courselistAction()
    {
    	
    	$this->view->courses = $this->coursesTable->getCourses();

    }
    
    public function insertcoursesAction()
    {
    	$this->coursesTable->insertCsv();
    }

    public function insertvideosAction()
    {
    	$this->videosTable->insertCsv();
    }

    public function cleancacheAction()
    {
        // action body
        $cache = Zend_Registry::get('cache');
        
        if($cache->clean(Zend_Cache::CLEANING_MODE_ALL)) {
        	$this->view->cleancache = 'Cache has been cleaned.';
        } else {
			$this->view->cleancache = 'Cache was not cleaned!';	    	
        }
        
    }
    

    public function loginAction()
    {
		// REDIRECT LOGGED IN USERS
	    if (Zend_Registry::getInstance()->get('auth')->hasIdentity()) {
	    	echo 'has identity';
	        //$this->_redirect($this->url(array('module' => 'admin', 'controller' => 'index', 'action' => 'index')));
	    } else {
	    	echo 'no identity';
	    }
	 
	    $request = $this->getRequest();
	    $users = $this->usersTable;
	    
	   
	                            
	    $form = new Admin_Form_Login();                         
	    
	    // IF POST DATA HAS BEEN SUBMITTED
	    if ($request->isPost()) {
	        // IF THE LOGIN FORM HAS BEEN SUBMITTED AND THE SUBMITTED DATA IS VALID
	        if (isset($_POST['login']) && $form->isValid($_POST)) {
	 
	            // PREPARE A DATABASE ADAPTER FOR ZEND_AUTH
	            $adapter = new Zend_Auth_Adapter_DbTable($users->getAdapter());
	            
	            $adapter->setTableName('users');
	            $adapter->setIdentityColumn('username');
	            $adapter->setCredentialColumn('password_hash');
	            $adapter->setCredentialTreatment('CONCAT(SUBSTRING(password_hash, 1, 40), SHA1(CONCAT(SUBSTRING(password_hash, 1, 40), ?)))');
	            $adapter->setIdentity($form->getValue('username'));
	            $adapter->setCredential($form->getValue('password'));
	 
	            // TRY TO AUTHENTICATE A USER
	            $auth = Zend_Registry::get('auth');           
	            $result = $auth->authenticate($adapter);
	 
	            // IS THE USER VALID ONE?
	            switch ($result->getCode()) {
	 
	                case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
	                    $this->view->error = 'Identity not found';
	                    break;
	 
	                case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
	                    $this->view->error = 'Invalid credential';
	                    break;
	 
	                case Zend_Auth_Result::SUCCESS:
	                    // GET USER OBJECT (OMMIT PASSWORD_HASH)
	                    $user = $adapter->getResultRowObject(null, 'password_hash');
	                    // CHECK IF THE USER IS APPROVED
	                    if ($user->status != 'approved') {
	                        $this->view->error = 'User not approved';
	                    } else {
	                        // TO HELP THWART SESSION FIXATION/HIJACKING
	                        if ($form->getValue('rememberMe') == 1) {
	                            // REMEMBER THE SESSION FOR 604800S = 7 DAYS
	                            Zend_Session::rememberMe(604800);
	                        } else {
	                            // DO NOT REMEMBER THE SESSION
	                            Zend_Session::forgetMe();
	                        }
	                        // STORE USER OBJECT IN THE SESSION
	                        $authStorage = $auth->getStorage();
	                        $authStorage->write($user);
	                        $this->_redirect('/admin/index/index');
	                    }
	                    break;
	 
	                default:
	                    $this->view->error = 'Wrong username and/or password';
	                    break;
	            }
	 
	        }
	    }
	 
	    $this->view->form = $form;
    }

    public function registerAction()
    {
        // REDIRECT LOGGED IN USERS
	    if (Zend_Registry::getInstance()->get('auth')->hasIdentity()) {
	        $this->_redirect('/');
	    }
	 
	    $request = $this->getRequest();
		$users = $this->usersTable;
	 
	    $form = new Admin_Form_Register();
	    
	    // IF POST DATA HAS BEEN SUBMITTED
	    if ($request->isPost()) {
	        // IF THE REGISTER FORM HAS BEEN SUBMITTED AND THE SUBMITTED DATA IS VALID
	        if (isset($_POST['register']) && $form->isValid($_POST)) {
	 
	            $data = $form->getValues();
	 
	           	$data['salt'] = $this->generateRandomString(40);
	            $data['status'] = 'approved';
	            $users->add($data);
	 
	        }
	    }
	 
	    $this->view->form = $form;
    }
    
	public function generateRandomString ($length = 32, $chars = '1234567890abcdef')
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

    public function emailVerificationAction()
    {
    	$request = $this->getRequest();
	    $users = $this->_getTable('Admin_Model_DbTable_Users');
	 
	    // GET THE VERIFICATION STRING FROM THE URI
	    $str = $request->getParam('str');
	 
	    // CHECK IF THE USER CORRESPONDING TO THE STRING EXISTS
	    $user = $users->getSingleWithEmailHash($str);
	    if ($user == null) {
	        $this->view->error = 'Invalid verification string';
	    } else {
	        if ($user->status == 'approved') {
	            // USER ACCOUNT HAS ALREADY BEEN ACTIVATED
	            $this->view->error = 'Account has already been activated';
	        } else {
	 
	            // THE USER EXISTS AND THE VERIFICATION STRING IS CORRECT
	            // LET'S APPROVE THE USER
	            if ($users->edit($user->id, array('status' => 'approved')) != false) {
	                $this->view->success = 'Hello, '
	                . $user->username . '! Your account has been activated';
	            }
	 
	        }
	    }
    }

	public function logoutAction()
	{
		$authAdapter = Zend_Auth::getInstance();
		$authAdapter->clearIdentity();
			
	}
    
    public function addCoursesAction()
    {
        // action body
    }


}







