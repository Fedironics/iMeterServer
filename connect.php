<?php
define("IM_USER","bc98afcc3ec3b1");
define("IM_PASSWORD","21381f7a");
define("IM_DATA","imeter");

 $mysqli=new mysqli("br-cdbr-azure-south-b.cloudapp.net",IM_USER,IM_PASSWORD,IM_DATA); 
  if ($mysqli->connect_errno) {
	  echo "Failed to connect to Mysql:(" .$mysqli->connect_errno.")". $mysqli->connect_error;
	  
  }
 //declare to know if itis local or online 
$domain="http://imeter.azurewebsites.net";
 
?>
