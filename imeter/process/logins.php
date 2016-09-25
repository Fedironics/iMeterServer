<?php 
header('Access-Control-Allow-Origin: *'); 
require_once('../includes/initialize.php') ;
if(isset($_POST['userid']) || isset($_POST['password'])) 
{
    $userid=$_POST['userid'];
$password=$_POST['password']; 
$person_from_input=User::authenticate($userid,$password);
$userid=$_POST['userid'];
$password=$_POST['password']; 
$person_from_input=User::authenticate($userid,$password);
//if there is a person who has that username and password
if($person_from_input){
redirect_to('../energy_profile.php');
}
 
else {
$session->message("incorrect username or password",true);
redirect_to("../login.php");
exit();
}

 
}
elseif(isset($_POST['muserid']) || isset($_POST['mpassword'])) 
{
    $userid=$_POST['muserid'];
$password=$_POST['mpassword']; 
$person_from_input=User::authenticate($userid,$password,true);
if($person_from_input){
      echo"imeterid= $person_from_input->id
"; 
echo"imetertoken= '$person_from_input->token'
";
}
}
else
{
echo 'desc="incorrect userid or password "
';
}


 
?>


