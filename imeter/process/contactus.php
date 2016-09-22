<?php
//this page is where the user is going to see when he logs into his imeter account 
 header('Access-Control-Allow-Origin: *'); 
require_once("../includes/functions.php");
if(!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['phone']) || !isset($_POST['message']) || $_POST['name']=='' || $_POST['email']=='' || $_POST['message']=='' ){
	echo 'desc ="user authentication failed"';
} 
else {
	$name=$_POST['name'];
	$name=clean($name);
	$email=$_POST['email'];
	$email=clean($email);
	$phone=$_POST['phone'];
	$phone=clean($phone);
	$message=$_POST['message'];
	$message=clean($message);
$send_message=$mysqli->query("INSERT INTO web_inbox (id,name,email,phone,message) VALUES ('','$name','$email','$phone','$message')");
if($send_message){
	
	header("Location:../../index.html");
}else {
	

	header("Location:../../contacts.html");
//if it fails	
}

}	
			?>