<?php

if($session->check_login()){
     if($session->admin){
          $user=  Admin::find_by_id($session->get_user_id());
        $admin_id=$user->id;
             }
    else{
          $user= User::find_by_id($session->get_user_id());
         $userid=$user->id;
  $meter_no=$user->meter_no;
 
    }

}
    $links=array('Home'=>'index.php','About'=>'about.php','Services'=>'services.php','Blog'=>'blog.php','Contact'=>'contact.php');
$current=$_SERVER['PHP_SELF']."?view=yes";
 