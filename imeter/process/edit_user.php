<?php
require_once("../includes/initialize.php");
if(!isset($userid)){
	header("Location:../login.php");
}

$pasd=($_POST['password']);
$pas2=($_POST['password1']);
$name=$_POST['name'];
$email=$_POST['email'];
$userids=$_POST['userid'];
$phone=$_POST['phone'];

//do your error checking here --//**davidity//+++===
//nna do this error checking soon naa

$update=$mysqli->query("UPDATE user_informations SET password='$pasd' , email='$email', userid='$userids', phone='$phone' ,customer_name='$name' WHERE id='$userid' ");
if($update){
$session->message("profile updated succesfully",false);
	header("Location:../energy_profile.php?error=0&edefin=profile updated succesfully");

}  

  else{
      $session->message("failed to update profile",true);
	  header("Location:../energy_profile.php?error=1&edefin=failed to update profile");

	  echo $mysqli->error;
	  
  }
			 
?>