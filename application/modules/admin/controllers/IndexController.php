<?php

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->usersTable = new Admin_Model_DbTable_Users();
    }

    public function indexAction()
    {
	// REDIRECT LOGGED IN USERS
	    if (Zend_Registry::getInstance()->get('auth')->hasIdentity()) {
	        $this->_redirect('/');
	    }
	    
	 
	    $request = $this->getRequest();
	    $users = $this->usersTable;
	                            
	    $form = new Admin_Form_Login();                         
	    
	    // IF POST DATA HAS BEEN SUBMITTED
	    if ($request->isPost()) {
	        // IF THE LOGIN FORM HAS BEEN SUBMITTED AND THE SUBMITTED DATA IS VALID
	        if (isset($_POST['login']) && $form->isValid($_POST)) {
	 
	            // PREPARE A DATABASE ADAPTER FOR ZEND_AUTH
	            $adapter = new Zend_Auth_Adapter_DbTable($this->_getDb());
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
	                        $this->_redirect('/admin');
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
	 
	            if ($users->getSingleWithEmail($data['email']) != null) {
	                // IF THE EMAIL ALREADY EXISTS IN THE DATABASE
	                $this->view->error = 'Email already taken';
	            } else if ($users->getSingleWithUsername($data['username']) != null) {
	                // IF THE USERNAME ALREADY EXISTS IN THE DATABASE
	                $this->view->error = 'Username already taken';
	            } else if ($data['email'] != $data['emailAgain']) {
	                // IF BOTH EMAILS DO NOT MATCH
	                $this->view->error = 'Both emails must be same';
	            } else if ($data['password'] != $data['passwordAgain']) {
	                // IF BOTH PASSWORDS DO NOT MATCH
	                $this->view->error = 'Both passwords must be same';
	            } else {
	 
	                // EVERYTHING IS OK, LET'S SEND EMAIL WITH A VERIFICATION STRING
	                // THE VERIFICATIONS STRING IS AN SHA1 HASH OF THE EMAIL
	               	$tr = new Zend_Mail_Transport_Smtp('smtp.csus.edu');
	    			Zend_Mail::setDefaultTransport($tr);
	                $mail = new Zend_Mail();
	                $mail->setFrom('charles.brownroberts@csus.edu', 'Web Services');
	                $mail->setSubject('Thank you for registering');
	                $mail->setBodyText('Dear Sir or Madam,
	 
	Thank You for registering at yourwebsite.com. In order for your account to be
	activated please click on the following URI:
	 
	http://amsvideo-dev/admin/login/email-verification?STR=' . SHA1($data['email'])
	. '
	Best Regards,
	Web Services staff');
	                $mail->addTo($data['email'],
	                             $data['first_name'] . ' ' . $data['last_name']);
	 
	                if (!$mail->send()) {
	                    // EMAIL SENDING FAILED
	                    $this->view->error = 'Failed to send email to the address you provided';
	                } else {
	 
	                    // EMAIL SENT SUCCESSFULLY, LET'S ADD THE USER TO THE DATABASE
	                    unset($data['emailAgain'], $data['passwordAgain'],
	                          $data['register']);
	                    $data['salt'] = $this->_helper->RandomString(40);
	                    $data['role'] = 'user';
	                    $data['status'] = 'pending';
	                    $users->add($data);
	                    $this->view->success = 'Successfully registered';
	 
	                }
	 
	            }
	 
	        }
	    }
	 
	    $this->view->form = $form;
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


}





