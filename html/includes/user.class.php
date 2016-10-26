<?php
require_once("localobject.php");

class AuthUser extends LocalObject{

    var $userid=null;
    var $username=null;
    var $usercookie=null;
    var $sessioncookie=null;
    var $session_id=null;	

    public function Login($user,$pass,$type){    	
    	
		if (!$user || !$pass || !$type) {            
		  return FALSE;
		}
		
		switch ($type){
			case "admin" : {$lifetime = time() + 365*24*60*60; $sessionLifetime= time() + 43200;} break;
			case "respondent" : { $lifetime =0; $sessionLifetime=0; }break; 
		}
		
		$this->LoadFromSQL("SELECT * FROM USERS WHERE USERNAME='".$user."' AND password='".$pass."' AND status='active'");

		$row=$this->GetAllProperties();
		
		if (count($this->GetAllProperties()) > 0) print_r($row);	//return FALSE;
		
		setcookie( "usercookie[username]", $user, $lifetime, "/" );
		setcookie( "usercookie[id]", $row['ID'], $lifetime, "/" ); 	
		setcookie( "usercookie[usertype]", $type, $lifetime, "/" );
        $this->initSession($sessionLifetime);
        
		$this->LoadFromSQL("UPDATE SESSION SET [USERID]=".$row['ID'].", [USERTYPE]=".$type.", SESS_START=now(), [SESS_EXPIRE]=DATE_ADD(now(),INTERVAL 10 MINUTE), [LAST_ACTIVITY]=now(), [IP]=".$_SERVER['REMOTE_ADDR']." , USER_AGENT=".$_SERVER['HTTP_USER_AGENT']." where SESSION=".$this->session_id); 

		
		$this->userid=$row['ID']; 
        $this->username=$user; 
        $this->usercookie['username']=$user; 
        $this->usercookie['id']=$row['ID']; 
        return TRUE;
		
    }
    

    function Logout($type){
        if ($this->Check_Auth($type)) {
        	
        	$this->DB->query( 'DELETE FROM session WHERE session=? ',$this->session_id);
        	setcookie( "usercookie[username]", "", time() - 36000, "/" );
	   		setcookie( "usercookie[id]", "", time() - 36000, "/" ); 
	   		//setcookie( "usercookie[parentAns]", "", time() - 36000, "/" );	   		 		
        	setcookie( "sessioncookie", "", time() - 36000, "/" );        	       	            
        	
        	if (isset($_COOKIE['usercookie']['parentAns'])){        	
        		foreach ($_COOKIE['usercookie']['parentAns'] as $key=>$value){
					if (is_array($value)){		
						foreach ($value as $valueKey => $valueValue){			
							setcookie( "usercookie[parentAns][$key][$valueKey]","", time() - 36000, "/" );
						}	
					}else 
						setcookie( "usercookie[parentAns][$key]","", time() - 36000, "/" );
				}        	
        	}
			        	
        	$this->MoneyOperations->unfreezeReward($this->userid);
        	
        }
    }        

    		
	function generateId() {
		$failsafe = 20;
		$randnum = 0;
		while ($failsafe--) {
			$randnum = md5( uniqid( microtime(), 1 ) );
			if ($randnum != "") {
				$cryptrandnum = md5( $randnum );
				
				/*
				$this->_db->selectRow( "SELECT * FROM session WHERE session=MD5('$randnum')" );
				if(!$result = $this->_db->query()) {
					die( $this->_db->stderr( true ));
					// todo: handle gracefully
				}
				if ($this->_db->getNumRows($result) == 0) {
					break;
				}
				*/
			}
		}
		$this->sessioncookie = $randnum;
		$this->session_id = md5( $randnum . $_SERVER['REMOTE_ADDR'] );
	} 
    
	function initSession($sessionLifetime) {

		$sessioncookie = GetParam( $_COOKIE, 'sessioncookie', null );
        $sess=md5( $sessioncookie . $_SERVER['REMOTE_ADDR'] );
        
		$row = null;       
		if ($row = $this->DB->selectRow('select * from session where session=?',$sess)) {
			// Session cookie exists, update time in session table
			$this->DB->query('UPDATE session SET last_activity=now(), sess_expire=DATE_ADD(now(),INTERVAL ?d MINUTE) where session=? ',(_DEFAULT_TIMEOUT),$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],$sess);	
			$this->sessioncookie=$sessioncookie;
			$this->session_id=$row['session'];
		} else {
			$this->generateId();
			setcookie( "sessioncookie", $this->sessioncookie, $sessionLifetime, "/" );
            $this->DB->query('INSERT into session SET last_activity=now(), session=?, sess_expire=DATE_ADD(now(),INTERVAL ?d MINUTE)',$this->session_id,(_DEFAULT_TIMEOUT));
		}
	}
    function Check_Auth($type){
		$sess = $_COOKIE['sessioncookie'];
		$ucookie = $_COOKIE['usercookie'];
        $sess=md5( $sess . $_SERVER['REMOTE_ADDR'] );
        
		//$this->LoadFromSQL('DELETE FROM session WHERE getdate() > SESS_EXPIRE'); //PURGE SESSION
		$row = null;     
        
		//$this->LoadFromSQL('SELECT * FROM session LEFT JOIN USERS ON SESSION.USERID=USERS.id WHERE SESSION=?',$sess);
		
    	if (!$row = $this->GetAllProperties()) {
	       			return FALSE;
        		}
        
        if (($row['ID']==$ucookie['id'])&&($row['USERTYPE']==$type)&&($row['USERNAME']==$ucookie['username'])
            &&($_SERVER['REMOTE_ADDR']==$row['IP'])){            	
            // authenticated ok

          $this->userid=$row['ID']; 
		  $this->username=$row['USERNAME'];
          $this->usercookie['username']=$row['USERNAME']; 
          $this->usercookie['id']=$row['ID']; 
    	  $this->sessioncookie =$_COOKIE['sessioncookie'];
		  $this->session_id = $sess;
		  
		  //$this->LoadFromSQL('UPDATE SESSION SET LAST_ACTIVITY=getdate(), SESS_EXPIRE=DATE_ADD(getdate(),INTERVAL 10 MINUTE) WHERE SESSION='.$sess);
			  
 	       return TRUE;
        }else{
	       return FALSE;
        }
        
    }
    
    //проверка запущена ли компания у обладателя этого номера
    public function checkCampaignStarted($phone){
	return $result=$this->DB->selectRow('SELECT campaign_stat.parentans FROM campaign_stat LEFT JOIN respondent ON campaign_stat.respondent_id=respondent.id WHERE username=? AND campaign_stat.status="start" ',$phone);		
			
    }
    
	private function checkUser($phone){
		if (!$this->DB->select('SELECT * FROM respondent WHERE username=? ',$phone))
			$this->DB->query('INSERT INTO respondent (id, username, password, sendsms, status) VALUES (NULL, ?, NULL, 1, ?);',$phone,"active");
	}

	private function setPass2Db($phone,$pass){
		$this->DB->query('UPDATE respondent SET password=?, sendsms=sendsms+1 where username=? ',$pass,$phone);
	}
  	
	private function genPass($length, $case = 'shuffle'){
		global $password;
  		$symbols = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
  		
  		for ($i = 1; $i < $length; $i++){
    	
  			switch ($case){
      			case 'shuffle': $uppercase = rand(0, 1); break;
      			case 'lower':   $uppercase = 0;          break;
      			case 'upper':   $uppercase = 1;          break;
    		}
    	
    		switch ($uppercase)	{
      			case 0: $password = $password.$symbols[array_rand($symbols)];          break;
      			case 1: $password = $password.ucfirst($symbols[array_rand($symbols)]); break;
    			}
  			}
  			return $password;
		}
		
	public function makePass($phone){	
		$pass = $this->genPass(5);	
		$this->checkUser($phone);	
		$this->setPass2Db($phone,$pass);
		return "ваш временный пароль: ".$pass;
	}
  
}

?>