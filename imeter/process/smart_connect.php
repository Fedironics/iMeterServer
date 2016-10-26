<?php
require_once("../includes/initialize.php");
if(!$session->check_login()){
	echo 'Smart Connect Error: You are not logged in"';
} 
else
    {
$meter_no=$user->meter_no;
if(!isset($_POST['status'])){
echo 'Smart Connect Error: there was no budget recieved';
}
else
    {
$status=$_POST['status'];

if($status=='1')
    { 
    
$reply="Smart Connect : Succesfully Turned Power On";
    $formatted_reply="7210";
//that is to turn on
$insert=$database->query("INSERT INTO user_queries (meter_no,energy_budget,topup_code,payment_method,amount_paid,query_code,done,time_requested) VALUES('$meter_no','','','$status','','3','0',NOW())");		

$query_id=$database->last_id();
Response::record($formatted_reply,$query_id);
	//im lazy today i will use payment_method to hold the on or off value 

}
else {
		//that is to turn off
$formatted_reply="7200";
$reply="Smart Connect : Succesfully Turned Power Off";
$insert=$database->query("INSERT INTO user_queries (meter_no,energy_budget,topup_code,payment_method,amount_paid,query_code,done,time_requested) VALUES('$meter_no','','','$status','','3','0',NOW())");		
$query_id=$database->last_id();
Response::record($formatted_reply,$query_id);
 
	}
		
	}
	
}
echo $reply;


?>