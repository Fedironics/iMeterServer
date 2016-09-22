<?php
require_once("connect.php");
$price=0.22 ;     //the rate or price of power  
$tax=9.3;//in percentage
$service_charge =50;//charge in Naira for each recharge                                                                                                                                                 
//this is a help for the query codes to help us identify the type of action the user carried out
//1---energy budget reset
//2---energy topup i.e he paid for nepa bill









session_start();
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

 
  
  
//this function is for the selection of any column from the database through a function without having to write mysql queries evertime
  function eselect($id="1",$row="energy_balance",$compare="id",$table='user_informations') {                
 $mysqli=new mysqli("localhost",IM_USER,IM_PASSWORD,IM_DATA); 

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


//this is in order to recognise a logged in imeter user
//for detecting if a person has been logged in 
//first logging in through sessions
if(isset($_SESSION['imeter_id'])){
	$userid=$_SESSION['imeter_id'];
  if(isset($_SESSION['imeter_token'])){   
  $a_token=$_SESSION['imeter_token'];
    $meter_no=eselect($userid,'meter_no');
	$token_query=$mysqli->query("SELECT id FROM security_tokens WHERE token='$a_token'")->num_rows;
      if($token_query<1){
          //if user validation fails
      logout_user();
      $logged_in=0;
	 // echo 'token mismatch';
      }
      else {
      $logged_in=1; 
	  $userid=$_SESSION['imeter_id'];
	//  echo 'logged in';
      }   

   }
  else {  
     //if user doesnt have an access token
   logout_user();
   $logged_in=0;
 //  echo 'if1';
 }                                         
}	




//this is in order to recognise a logged in administrator
//for detecting if a person has been logged in 
//first logging in through sessions
if(isset($_SESSION['admin_id']) || isset($_COOKIE['admin_id'])){
	if(isset($_SESSION['admin_id'])){$admin_id=$_SESSION['admin_id'];}
	else {$admin_id=$_COOKIE['admin_id']; }
	
	
  if(isset($_SESSION['admin_token']) || isset($_COOKIE['admin_token'])){   
 	if(isset($_SESSION['admin_token'])){$a_token=$_SESSION['admin_token'];}
	else {$a_token=$_COOKIE['admin_token']; }
	 
	$admin_query=$mysqli->query("SELECT id FROM administrators WHERE admin_id='$admin_id'")->num_rows;
	$token_query=$mysqli->query("SELECT id FROM security_tokens WHERE token='$a_token' AND power='2'")->num_rows;
	 if($token_query<1 || $admin_query<1){
          //if user validation fails
     // logout_user();
     // $admin_in=0;
	 // echo 'token mismatch';
      }
      else {
      $admin_in=1; 
	 // $userid=$_SESSION['imeter_id'];
	//  echo 'logged in';
      }   

   }
  else {  
     //if user doesnt have an access token
//   logout_user();
  // $admin_in=0;
 //  echo 'if1';
 }                                         
}  
//this is to avoid division by zero
function check_zero($no){
if($no==0){
	$no=1000000;
}	
if($no<=0){
$no=1000000;		
}	
else {$no=$no;}
return $no;
}




?>