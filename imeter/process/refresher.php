<?php

 header('Access-Control-Allow-Origin: *'); 
require_once("../includes/initialize.php");
require_once("../includes/metermessage.php");
//do your error checking and validation here oo
  if(!isset($_POST['Password']))
            {
                die("no data recieved");    
            }
        else 
            {
             $replies=   MeterMessage::collector($_POST['Password'],false);
               }

$stored=Response::display_one();
if($stored)
{
$stored_array=json_decode($stored,true);
$stored_array['key']=$replies->data->key; 
echo $replies->show(json_encode($stored_array));

}
else
{
    $stored_array=[];
    $stored_array['key']=$replies->data->key;
  echo $replies->show(json_encode($stored_array));
  
}
?>