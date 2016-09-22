<?php

 header('Access-Control-Allow-Origin: *'); 
require_once("../includes/initialize.php");
//do your error checking and validation here oo

$user=  User::find_by_id(2);
Response::display_one();

?>