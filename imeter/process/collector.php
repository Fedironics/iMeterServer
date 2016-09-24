<?php
header('Access-Control-Allow-Origin: *');
require_once("../includes/initialize.php");
require_once("../includes/metermessage.php");

if(!isset($_POST['Password']))
{
	die("no data recieved");
}
else{
	$replies=   MeterMessage::collector($_POST['Password']);
	echo $replies->show($replies->output()); 
}

