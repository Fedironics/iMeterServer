<?php
 header('Access-Control-Allow-Origin: *'); 
require_once("../includes/functions.php");
if(!isset($_POST['imeterid']) || !isset($_POST['imetertoken'])){
	echo 'desc ="user authentication failed"';
} 
else {
	$userid=$_POST['imeterid'];
	$meter_no=eselect($userid,'meter_no');
}
  
if(isset($_POST['topup_code'])){
$code=$_POST['topup_code'];	
	
}else{
//when the user didnt post a topup code	
echo 'please input a topup code';
exit();
}
$check=$mysqli->query("SELECT id,amount,used FROM imeter_topup_code where pin='$code' ");
if($check->num_rows>0){
	while($info=$check->fetch_array()){
	$recharge_amount=$info['amount'];
$id=$info['id']	;
$used=$info['used'];		
	}
	
//if the topup code has been used
if($used!=0){
	header("Location:../energy_profile.php?error=1&edefin=already used topup code");
	
}
else {
//if the topup code is valid	
$update=$mysqli->query("UPDATE imeter_topup_code SET used='1' WHERE id='$id'")	;
$record=$mysqli->query("INSERT INTO user_queries (meter_no,energy_budget,topup_code,payment_method,amount_paid,query_code,done,time_requested) VALUES ('$meter_no','','$id','','$recharge_amount','2','0',NOW())");
$uid=$mysqli->insert_id;
$know=$mysqli->query("INSERT INTO meter_topup (method,value,meter_no,time) VALUES ('topup_code','$recharge_amount','$meter_no',NOW())")	;
//here the code to send the message to the meter will be ---+++***davidity---+++***
$phone_no=eselect($userid,'meter_sim');
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
	$message = "{$meter_no},+{$phone_send},3,{$recharge_amount}*";
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
	$update=$myqli->query("UPDATE user_queries SET done='1' WHERE id='$uid' ");
echo 'meter succesfully credited ';	
}
//this is to check bundle balance http://api.smartsmssolutions.com/smsapi.php?username=YourUsername&password=YourPassword&balance=true&

//after that
//header("Location:../energy_profile.php?error=0&edefin=topupcode succesfully inserted you will be credited soon");
}
	
}
else {
	//when the topup code is incorrect
	echo "the topup code you entered does not exist";
}






?>
