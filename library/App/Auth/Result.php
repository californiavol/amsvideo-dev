<?php


class App_Auth_Result extends Zend_Auth_Result {
	
    /**
     * Returns the identity used in the authentication attempt
     *
     * @return mixed
     */
    public function getIdentity()
    {
        return json_decode($this->_identity);
    }
}