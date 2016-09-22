<?php
 class Response extends DatabaseTable {
     public static $tableName= 'replies_to_meter';
     
     public static function record($formatted_reply,$query_id){
        global $database; 
         global $user;
         $meter_no=$user->meter_no;
 
  $executer=$database->query("INSERT INTO replies_to_meter (meter_no,reply,time,seen,query_id) VALUES ('$meter_no','$formatted_reply',NOW(),'0','$query_id')");

     }
     
     public static function display_one(){
         global $database;
                  global $user;
         $meter_no=$user->meter_no;
      $one_response=   $database->query("SELECT * FROM replies_to_meter WHERE meter_no='$meter_no' AND seen='0' LIMIT 1");
      if($one_response->num_rows>0)   {
      $one_response_array=  fetch_as_array($one_response);
     $reply_id=$one_response_array['id'];   
     $query_id=$one_response_array['query_id'];
         echo $one_response_array['reply'];
         //to update that particular row that it has been done
         $database->query("UPDATE replies_to_meter SET seen='1' WHERE id=$reply_id LIMIT 1");
         //to notify the user that it has been done
            $database->query("UPDATE user_queries SET done=1 WHERE meter_no='$meter_no' AND id='$query_id' LIMIT 1");
    
      }
         
     }
     
 }
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

