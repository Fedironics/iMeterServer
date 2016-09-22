<?php
header('Access-Control-Allow-Origin: *'); 
require_once('../includes/initialize.php') ;
if(!isset($_POST['imeterid']) || !isset($_POST['imetertoken'])){
	echo 'desc ="user authentication failed"';
} 
else {


	$userid=$_POST['imeterid'];
	$meter_no=eselect($userid,'meter_no');

if(!isset($_POST['e_budget'])){
	echo 'there was no budget recieved';
	
	
	
}
	
	else {
		$energy_budget=$_POST['e_budget'];
$insert=$mysqli->query("INSERT INTO user_queries (meter_no,energy_budget,topup_code,payment_method,amount_paid,query_code,done,time_requested) VALUES('$meter_no','$energy_budget','','','','1','1',NOW())");		
		
echo $mysqli->error;		
		
echo "Your Energy Budget Has been set To $energy_budget";		
	}
	
}



?>