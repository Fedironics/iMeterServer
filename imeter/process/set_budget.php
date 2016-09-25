<?php

 header('Access-Control-Allow-Origin: *'); 
require_once("../includes/initialize.php");
$energy_budget=$_POST['e_budget'];
if(!isset($_POST['e_budget'])){
	echo 'there was no budget recieved';
	
	
	
}else {
	if(!$session->check_login()){
		echo 'user not recognised ';
	
		
		
	}
	
	else {
$insert=$mysqli->query("INSERT INTO user_queries (meter_no,energy_budget,topup_code,payment_method,amount_paid,query_code,done,time_requested) VALUES('$meter_no','$energy_budget','','','','1','1',NOW())");		
			
		redirect_to("../energy_profile.php");
		
	}
	
}



?>