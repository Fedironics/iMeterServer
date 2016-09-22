<?php 
 header('Access-Control-Allow-Origin: *'); 
 require_once('../includes/functions.php') ;
if(!isset($_POST['userid']) || !isset($_POST['password'])) {
echo ' desc= "please enter your username and password"
';
exit();
}
$email=$_POST['userid'];
$password=$_POST['password']; 
//$email=clean($email);
//$password=clean($password);
$query="SELECT password,id,userid FROM user_informations WHERE userid='$email' ";
$kuser=$mysqli->query($query);
$user_exists=$kuser->num_rows;
if($user_exists>0){
//echo "that email exists<br/>";
while($row=$kuser->fetch_assoc()){
//echo "one iteration";
$nowpass=$row['password'];
if($nowpass==$password){
$id=$row['id'];
//id gotten
$token='tui'.rand(0,9999999999);
$mysqli->query("INSERT INTO security_tokens (id,token,power) VALUES ('','$token','1')");
$_SESSION['imeter_id']=  $row['id'];
$imeter_id=  $row['id'];
$_SESSION['imeter_token']=  $token;
echo"imeterid= $imeter_id
";
echo"imetertoken= '$token'
";

if(isset($_POST['login_keeping'])){
setcookie("imeter_id",$row['id'],time() + 86740 *30, "/");
setcookie("imeter_token",$token,time() + 86740 *30, "/");
}     
$know_abt=$mysqli->query("INSERT INTO visitors (id,time,type, visitor_id) VALUES ('',NOW(),'0','$id')");
echo ' desc="success"';
exit();}
 
else {
echo ' desc= "incorrect password for this user"
';}
}
}
else{
echo ' desc= "username not recognised"
';
}


 
?>


