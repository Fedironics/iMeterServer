<?php require_once("../includes/connect.php");
session_start();
$email=$_POST['email'];
$num=$mysqli->query("SELECT id FROM students WHERE email='$email'");
while($this_one=$num->fetch_array()){
$id=$this_one['id'];
}
$num=$num->num_rows;
if($id==$_SESSION['tui_user_id']){
$num=0;	
};
if($num>0){echo "0";
 }
 else {
echo "1";
 }
 ?>