<?php

class Admin_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';
    
    
	public function add(array $data)
    {
        $data['password_hash'] = $data['salt'] . sha1($data['salt'] . $data['password']);
        unset($data['password'], $data['salt']);
        return $this->insert($data);
    }
 
    public function getSingleWithUsername($username)
    {
        $select = $this->select();
        $where = $this->getAdapter()->quoteInto('username = ?', $username);
        $select->where($where);
        return $this->fetchRow($select);
    }
 
    public function getSingleWithEmail($email)
    {
        $select = $this->select();
        $where = $this->getAdapter()->quoteInto('email = ?', $email);
        $select->where($where);
        return $this->fetchRow($select);
    }
 
    public function getSingleWithEmailHash($hash)
    {
        $select = $this->select();
        $where = $this->getAdapter()->quoteInto('SHA1(email) = ?', $hash);
        $select->where($where);
        return $this->fetchRow($select);
    }


}

