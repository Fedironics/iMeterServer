<?php
$price=16 ;     //the rate or price of power  
$tax=9.3;//in percentage
$service_charge =50;//charge in Naira for each recharge 
//this variable speaks of the speculated maximum no of topup codes i will set it as 100
$max_all=100;
//these are for the tamper types
//1 earthfault
//2 magnetic
//3 opencase

                                                                                                                                                
//this is a help for the query codes to help us identify the type of action the user carried out
//1---energy budget reset
//2---energy topup i.e he paid for nepa bill





date_default_timezone_set("Asia/Bangkok");



  //this function is to get the number of days the current month has
  $month=getdate(time())['mon'];
  $year=getdate(time())['year'];
  $day=getdate(time())['mday'];
  $month_days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
//this is a function for destroing all the security tokens in the users browser
function logout_user() {
setcookie("imeter_id","",time() - 86740 , "/");
setcookie("imeter_token","",time() - 86740, "/");
if(isset($_SESSION['imeter_id'])){
unset($_SESSION['imeter_id']) ;
}
if(isset($_SESSION['imeter_token'])){
unset($_SESSION['imeter_token']) ;
}
unset($userid);
} 

 //this function is for getting time difference from a time object
 
 function humanTiming ($time)
{

    $time = time() - $time; // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }

}	
 
 
 //this function fetches a mysql databaseobject as an array
 function fetch_as_array($databaseobject){
      while($res_array=$databaseobject->fetch_array()){
      return $res_array;
   
      }
  
 }
function fetch_full_array($databaseobject){
    $result_array=array();
      while($res_array=$databaseobject->fetch_array()){
      $result_array[]=$res_array;
   
      }
  return $result_array;
 }



//this function is for the selection of any column from the database through a function without having to write mysql queries evertime
  function eselect($id="1",$row="energy_balance",$compare="id",$table='user_informations') {                
 global $mysqli;
$myquery=$mysqli->query("SELECT $row FROM $table WHERE $compare='$id' ");
if(!$myquery){
     echo "query could not be executed";
      }else{
    while ($page=$myquery->fetch_array()) {
     $code=$page[$row];  
     return $code;

      }}}
	  
	  //this function is to easily select a row from the admin data
	   function adselect($id="1",$row="name",$table='administrators') {                
 $mysqli=new mysqli("localhost",IM_USER,IM_PASSWORD,IM_DATA); 

$myquery=$mysqli->query("SELECT $row FROM $table WHERE id='$id' ");
if(!$myquery){
     echo "query could not be executed";
      }else{
    while ($page=$myquery->fetch_array()) {
     $code=$page[$row];  
     return $code;

      }}} 
	  
	//this is in order to get the line id of an admin
	   function getadminid($id="1") {                
 $mysqli=new mysqli("localhost",IM_USER,IM_PASSWORD,IM_DATA); 

$myquery=$mysqli->query("SELECT id FROM administrators WHERE admin_id='$id' ");
if(!$myquery){
     echo "query could not be executed";
      }else{
    while ($page=$myquery->fetch_array()) {
     $code=$page['id'];  
     return $code;

      }}} 
	  	
	  
//this function was made basically to get the last energy_budget a person sets
  function last_budget($meter_no="0",$row="energy_budget",$table='user_queries') {                
 $mysqli=new mysqli("localhost",IM_USER,IM_PASSWORD,IM_DATA); 

$myquery=$mysqli->query("SELECT $row FROM $table WHERE meter_no='$meter_no' ORDER BY id DESC LIMIT 1 ");
if(!$myquery){
     echo "query could not be executed";
      }else{
    while ($page=$myquery->fetch_array()) {
     $code=$page[$row];  
     return $code;

      }}}

//this function was made basically to get the meters used energy both in hours,days ,month
  function av_daily_energy($meter_no="0",$span='day') {                
 $mysqli=new mysqli("localhost",IM_USER,IM_PASSWORD,IM_DATA); 
if($span='day'){
	//get the total energy consumed in the last 24 hrs
$days_total=0;
$myquery=$mysqli->query("SELECT energy_consumed FROM meter_informations WHERE meter_no='$meter_no' ORDER BY id DESC LIMIT 24 ");
$divisor=$myquery->num_rows;
$divisor=check_zero($divisor);
if(!$myquery){
     echo "query could not be executed";
      }
else{
	while ($page=$myquery->fetch_array()) {
    $code=$page['energy_consumed'];  
    $days_total=$days_total+ $code;
	

  }
  //this will return the total energy consumed that day
  return (($days_total/$divisor)*24);
  
  }}
 if($span='month'){
	//get the total energy consumed in the last 30 days
$hours=$month_days*24;
$months_total=0;
$myquery=$mysqli->query("SELECT energy_consumed FROM meter_informations WHERE meter_no='$meter_no' ORDER BY id DESC LIMIT $hours ");
$divisor=$myquery->num_rows;
if(!$myquery){
     echo "query could not be executed";
      }
else{
	while ($page=$myquery->fetch_array()) {
    $code=$page['energy_consumed'];  
    $months_total=$months_total+ $code;
	

  }
 //this will return the average monthly daily power useage
  return (($months_total/$divisor)*24); 
  }} 
  
	  
	  
	  }

//this function was made basically to calculate how much was deducted from the powertime
  function money_consumed($meter_no="0",$span='day') {                
 $mysqli=new mysqli("localhost",IM_USER,IM_PASSWORD,IM_DATA); 
if($span='day'){
	//get the total energy consumed in the last 24 hrs
$days_total=0;
$myquery=$mysqli->query("SELECT energy_consumed,price FROM meter_informations WHERE meter_no='$meter_no' ORDER BY id DESC LIMIT 24 ");
if(!$myquery){
     echo "query could not be executed";
      }
else{
	while ($page=$myquery->fetch_array()) {
	$code=$page['energy_consumed']*$page['price'];
    $days_total=$days_total+ $code;
	

  }
  return $days_total;
  
  }}
 if($span='month'){
	//get the total energy consumed in the last 24 hrs
$hours=$month_days*24;
$myquery=$mysqli->query("SELECT energy_consumed,price FROM meter_informations WHERE meter_no='$meter_no' ORDER BY id DESC LIMIT $hours ");
if(!$myquery){
     echo "query could not be executed";
      }
else{
	while ($page=$myquery->fetch_array()) {
    $code=$page['energy_consumed']*$page['price'];
    $days_total=$days_total+ $code;
	

  }
  return $days_total;
  
  }} 
  
	  
	  
	  }	  
	  
	  
	  
	  
	  //this is for clearing illegal or malicious characters that may be gotten from input field
function br2nl($title){
return preg_replace('/<br\\s*?\/??>/i','',$title);
}	

function clean($text){
$mysqli=new mysqli("localhost",IM_USER,IM_PASSWORD,IM_DATA); 
$title=br2nl($text);
$title=htmlentities($text,ENT_QUOTES);  
$title=nl2br($text);                 
$title=$mysqli->real_escape_string($text);
return $text;
}	  

//this is for getting any column from a table which we have any data
  function aselect($value="1",$title='id',$order='',$row="token",$table='security_tokens') {                
 $mysqli=new mysqli("localhost",IM_USER,IM_PASSWORD,IM_DATA); 

$myquery=$mysqli->query("SELECT $row FROM $table WHERE id='$value' $order");
if(!$myquery){
     echo "query could not be executed";
      }else{
    while ($page=$myquery->fetch_array()) {
     $code=$page[$row];  
     return $code;

      }}}

//08140576872





//this is to avoid division by zero
function check_zero($no){
if($no==0){
	$no=0.001;
}	
if($no<=0){
$no=0.001;		
}	
else {$no=$no;}
return $no;
}

//i am setting these variables for the color scheming now i will set it based on the fraction rounded


function redirect($location,$message,$error) {
	$_SESSION['curr_mssg']=$message;
if($error){
$_SESSION['is_error']=$error;
}
session_write_close();
header("location:$location");
	exit();
	
}
function pre_format($object){
    echo "<pre>";
 print_r($object);
echo "</pre>";
}
 $characters="a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,1,2,3,4,5,6,7,8,9,0";
 $char_array=  explode(',', $characters);
     
/**
 * 
 * @param <int> $length the length of the random string
 * @return <string> it returns a random string for useage in session and stuff
 */
function random_string($length=10) {
    global $char_array;
    $random_string = '';
    $upper_limit=  count($char_array)-1;
    do {
        $rand_key=  rand(0, $upper_limit);
        $random_string.=$char_array[$rand_key];
        $length--;
    }
    while($length>0); 
    return $random_string;
}
function redirect_to($location=''){
    global $session;
    if(empty($location)){
        $location=$_SERVER['PHP_SELF'];
    }
    if($session->login_type==2) { die($session->message()); return;};
    header("location:$location");
    exit();
}
function validator($email,$type){
    global $session;
    if($type=='e')
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
          }
          else{
              $session->message("That is not a valid email");
              return false;
          }
}

        }
        
  
	



?>