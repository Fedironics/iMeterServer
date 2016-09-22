<?php 
require_once('../includes/initialize.php') ;

if(!isset($_POST['userid']) || !isset($_POST['password'])) {
redirect("Location:../alogin.php","please input your password before submitting",true);
exit();
}
$email=$_POST['userid'];
$password=$_POST['password']; 
 $person_from_input=Admin::authenticate($email,$password);
//if there is a person who has that username and password
if($person_from_input){
$session->message("successfully logged in",false);
    redirect_to('../admin.php');
}
 
else {
$session->message("incorrect username or password",true);
redirect_to("../alogin.php");
exit();
}
?>


