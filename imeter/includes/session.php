<?php
defined('DS')?null:define('DS', '\\');
require_once SITE_ROOT.DS."includes".DS.'admin.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of session
 *
 * @author EMMA
 */
class Session {
    public $admin= false;
    private $_browsing=false;
    public $login_type=1;
    private $_logged_in=false;
    private $_token;
    private $_user_id;
    public $message=array();
            
            function __construct() {
                session_start();
                $this->_check_message();
        $this->_check_login();
    }
    public function get_user_id(){
        return $this->_user_id;
    }

    public function  check_login(){
       return $this->_logged_in;
    }
private function  _check_message(){
    if(!empty($_SESSION['message'])){
        $this->message= $_SESSION['message'];
        unset($_SESSION['message']);
    }
    else {
        $this->message=array();
        $_SESSION['message']=array();
    }
}
public function message ($mssg='',$error=false){
    if(!empty($mssg)){
        if(is_array($mssg)){
            $this->message=  array_merge($this->message,$mssg);
      
        }
        else{
            if($this->login_type==2) die($mssg);
         $_SESSION['message'][]=array($mssg,$error);
       $this->message[]=array($mssg,$error);     
        }
    }
}
public function show_messages(){
    $messages=  $this->message;
    $result_containing_variable='';
        	if(!empty($messages)){
                        foreach ($messages as $message){
		if($message[1]==false){
			$i_type='info';			
			$msshead='Note: Last Operation Succesful';
		}else {			
			$i_type='danger';
			$msshead='Note: Last Operation Failed';
		}
	$result_containing_variable.= "
      <div class=\"callout callout-{$i_type}\">
        <h4><i class=\"fa fa-info\"></i> $msshead</h4>
    "	;
	
$result_containing_variable.=$message[0];
$result_containing_variable.= "
	  </div>
";
	}
                }
                return $result_containing_variable;
  }

public function login($user){
       if($user){ 
           $this->_user_id=$_SESSION['imeter_id']=$user->id;  
           $this->_token=$_SESSION['imeter_token']=$user->token;  
           $this->_logged_in=true;
           $this->message("Successfully Logged in!");
           return true;
       }
       
       else{
           //do something if no user object was recieved
           $this->logout();
           $this->message("Wrong username or password");  
           return false;
       }
        
    }
  public function mobile_login()
  {
      echo"imeterid= $this->_user_id
"; 
echo"imetertoken= '$this->_token'
";
  }

    public  function logout(){
    if(isset($_SESSION['imeter_id'])){
        unset($_SESSION['imeter_id']);      
    }
        if(isset($_SESSION['imeter_token'])){
        unset($_SESSION['imeter_token']);      
    }   if(isset($this->_user_id)){
        unset($this->_user_id);      
    }
 $this->_logged_in=false;
    }
    private function _check_login()
    {

if(isset($_SESSION['imeter_id']) && isset($_SESSION['imeter_token'])){
$this->_verifier($_SESSION['imeter_id'],$_SESSION['imeter_token']);
}

elseif(isset($_POST['imeterid']) && isset($_POST['imetertoken']))
{
$this->_verifier($_POST['imeterid'],$_POST['imetertoken']);
$this->login_type=2;
}
        else{
            $this->_logged_in=false;
        }
        
    }
private function _verifier($userid,$token)
{
    $this->_user_id=$userid;
   $this->_token=$token;
 $res= User::verify($this->_user_id,  $this->_token);

 if($res){
$this->_browsing=$res;
$this->_logged_in=true;
}else{
$res= Admin::verify($this->_user_id,  $this->_token);
  
 if($res){
 $this->admin=true;
$this->_browsing=$res;
 $this->_logged_in=true;
}
else{     
      
        $this->logout();
}

}
}
    public function person() {
return $this->_browsing;
 }
    function __destruct() {
      //  require SITE_ROOT.DS.'pages/footer.php';
    }
    //end of class
}
$page='0';
$year=date('Y');
$session = new Session();