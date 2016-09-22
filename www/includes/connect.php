<?php
define("IM_USER","root");
define("IM_PASSWORD","");
define("IM_DATA","imeter");

 $mysqli=new mysqli("localhost",IM_USER,IM_PASSWORD,IM_DATA); 
  if ($mysqli->connect_errno) {
	  echo "Failed to connect to Mysql:(" .$mysqli->connect_errno.")". $mysqli->connect_error;
	  
  }
 //declare to know if itis local or online 
$domain="http://localhost/davidity";
 
?>
