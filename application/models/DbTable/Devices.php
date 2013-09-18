<?php

class Application_Model_DbTable_Devices extends Zend_Db_Table_Abstract
{

    protected $_name = 'devices';
    
    public function addDevice()
    {
    	$deviceType = $this->getDeviceType();
    	$ipAddress = $this->getIpAddress();
    	$data = array(
			'deviceType' => $deviceType,
			'os'         => 'os',
			'browser'    => 'browser',
			'ip'         => $ipAddress
		);
	                     
	    $this->insert($data); 
    	
    }

    protected function getDeviceType()
    {
    	require_once APPLICATION_PATH . '/../library/vendors/Mobile-Detect-2.7.0/Mobile_Detect.php';
        
	    $detect = new Mobile_Detect;
	    //are we dealing with mobile, tablet, or computer?
	    $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');  
	    return $deviceType;
    }
    
    protected function getIpAddress()
    {
    	//Test if it is a shared client
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
		//Is it a proxy address
		}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
		  $ip=$_SERVER['REMOTE_ADDR'];
		}
		//The value of $ip at this point would look something like: "192.0.34.166"
		
		//convert it to store as an INT
		$ip = ip2long($ip);
		//use php function longtoip to convert back to dotted number when retrieving from db
		return $ip;
    }

}

