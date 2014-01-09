<?php

class Application_Model_DbTable_Devices extends Zend_Db_Table_Abstract
{

    protected $_name = 'devices';
    
	protected $_browsers = array('IE', 'Safari', 'Firefox', 'Chrome', 'unknown');
	protected $_devices = array('computer', 'phone', 'tablet');
    
    public function init()
    {
    	require_once APPLICATION_PATH . '/../library/vendors/Mobile-Detect-2.7.0/Mobile_Detect.php';
        
	    $detect = new Mobile_Detect;
	    $this->_detect = $detect;    	
    }
    
    public function logDeviceType()
    {
    	$deviceType = $this->getDeviceType();
    	$ipAddress  = $this->getIpAddress();
    	$browser    = $this->detectComputerBrowser();
    	$data = array(
			'deviceType' => $deviceType,
			'browser'    => $browser,
			'ip'         => $ipAddress
		);
	                     
	    $this->insert($data); 
    	
    }

    protected function getDeviceType()
    {
	    //are we dealing with mobile, tablet, or computer?
	    $deviceType = ($this->_detect->isMobile() ? ($this->_detect->isTablet() ? 'tablet' : 'phone') : 'computer');  
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
		
		//convert it to store as an INT see: http://daipratt.co.uk/mysql-store-ip-address/
		$ip = ip2long($ip);
		//use php function longtoip to convert back to dotted number when retrieving from db
		return $ip;
    }

    public function getCountByDeviceType($deviceType = NULL)
    {
    	$rows = $this->fetchAll($this->select()->where('deviceType = ?', $deviceType));
    	$rowCount = count($rows);
      	return $rowCount;
    }

    public function detectComputerBrowser()
    {
		$msie    = strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE') ? true : false;
        $firefox = strpos($_SERVER["HTTP_USER_AGENT"], 'Firefox') ? true : false;
        $safari  = strpos($_SERVER["HTTP_USER_AGENT"], 'Safari') ? true : false;
        $chrome  = strpos($_SERVER["HTTP_USER_AGENT"], 'Chrome') ? true : false;
        			
    	if ($firefox) {
			$browser = 'Firefox';
		} elseif ($chrome) {
			$browser = 'Chrome';	
		} elseif ($safari) {
    		$browser = 'Safari';	
		} elseif ($msie) {
        	$browser = 'IE';
        } else {
        	$browser = 'unknown';
        }
        
        return $browser;
    }

	public function getCountByDeviceTypeAndBrowser($deviceType = NULL, $browser = NULL)
	{
		if ($deviceType == NULL) {
			return;
		}
		
    	$rows = $this->fetchAll($this->select()->where('deviceType = ?', $deviceType)->where('browser = ?', $browser ));
    	$rowCount = count($rows);
      	return $rowCount;		
	}

//close class
}