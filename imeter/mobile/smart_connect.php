<?php
header('Access-Control-Allow-Origin: *'); 
require_once('../includes/initialize.php') ;
if(!isset($_POST['imeterid']) || !isset($_POST['imetertoken'])){
	echo 'desc ="user authentication failed"';
} 
else {
 

	$userid=$_POST['imeterid'];
	$meter_no=eselect($userid,'meter_no');

if(!isset($_POST['status'])){
	echo 'there was no budget recieved';
	
	
	
}
	
	else {
		$status=$_POST['status'];

$phone_no=eselect($meter_no,'meter_sim','meter_no');
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
	$sender = "FIMCWeb"; // This is who the message appears to be from.
	$numbers = "2347067514145"; // A single number or a comma-seperated list of numbers
	if($status=='1'){
		//that is to turn on
	
	$reply='meter succesfully Connected';	
	$message = "{$meter_no},+{$phone_send},4*";
	//im lazy today i will use payment_method to hold the on or off value 
	$insert=$mysqli->query("INSERT INTO user_queries (id,meter_no,energy_budget,topup_code,payment_method,amount_paid,query_code,done,time_requested) VALUES('','$meter_no','','','$status','','3','0',NOW())");		

	}
	else {
		//that is to turn off
		$message = "{$meter_no},+{$phone_send},1*";
	$reply='meter succesfully Disconnected';
		$insert=$mysqli->query("INSERT INTO user_queries (id,meter_no,energy_budget,topup_code,payment_method,amount_paid,query_code,done,time_requested) VALUES('','$meter_no','','','$status','','3','0',NOW())");		

	}
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
$res= httpGet("api.smartsmssolutions.com/smsapi.php?$data");
if(strlen($res)>0){
	$update=$mysqli->query("UPDATE user_queries SET done='1' WHERE id='$uid' ");
echo $reply;	
}else {
	echo 'there was an error posting your request';
	
}


		
	}
	
}



?>