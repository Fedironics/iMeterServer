<?php
require_once("../includes/functions.php");
if(!isset($_POST['phone']) || !isset($_POST['sender']) || !isset($_POST['message']) || $_POST['phone']=='' || $_POST['sender']=='' || $_POST['message']=='' ){
	$meter_no=$_POST['meter_no'];
	
	
	header("Location:../admin.php?error=1&edefin=please fill in the input fields");
}

else {
//if the topup code is valid	
$phone_no=$_POST['phone'];
$countryCode='234';
if(substr($phone_no,0,1)=='0'){
	$l3n=strlen($phone_no);
	$phone_send='234'.substr($phone_no,1,$l3n);
	}	
else {
	$phone_send=$phone_no;
}
	// Authorisation details.
	$username = "fedironics";
	$password = "imeter";
	// Config variables. Consult http://api.txtlocal.com/docs for more info.
	
	// Data for text message. This is the text message data.
	$sender = $_POST['sender']; // This is who the message appears to be from.
		$message = $_POST['message'];
	// 612 chars or less
	// A single number or a comma-seperated list of numbers
	$message = urlencode($message);
	$data = "username=".$username."&password=".$password."&sender=".$sender."&recipient=".$phone_send."&message=".$message;

function httpGet($url)
{
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false); 
 
    $output=curl_exec($ch);
 
    curl_close($ch);
    return $output;
}

$reply= httpGet("api.smartsmssolutions.com/smsapi.php?$data");
//this is to check bundle balance http://api.smartsmssolutions.com/smsapi.php?username=YourUsername&password=YourPassword&balance=true&
 if(strlen($reply)>2){
	 
	header("Location:../admin.php?error=0&edefin=sms to $phone_send send succesfully");
 
 }else {
	header("Location:../admin.php?error=1&edefin=message failed to send");
  
	 
 }

//after that
}






?>
