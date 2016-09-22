<?php
//before continuing.....
//check these things
//1 is nested if statements bad ? or not
//2 what is the function for checking if a string contains a particular character

//etext.com
//
require_once("../includes/initialize.php");
if(!isset($admin_id)){
	header("Location:alogin.php");
}
$new_guy=User::create_user($_POST);
pre_format($_SESSION['register_form']);
?>