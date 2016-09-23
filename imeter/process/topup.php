<?php
 header('Access-Control-Allow-Origin: *'); 
require_once("../includes/initialize.php");
require_once("../includes/metermessage.php");
$meter_no=$user->meter_no;
if(isset($_POST['topup_code'])){
$code=$_POST['topup_code'];	
	
}else{
//when the user didnt post a topup code
    $session->message("no data recieved",true);
header("Location:../energy_profile.php?error=1&edefin=no data recieveds");

}
function recharger($code)
{ 
    global $database,$session,$meter_no; 
    
$check=$database->query("SELECT id,amount,used FROM imeter_topup_code where pin='$code' ");
if($check->num_rows>0){
	while($info=$check->fetch_array()){
	$recharge_amount=$info['amount'];
$id=$info['id']	;
$used=$info['used'];		
	}
	
//if the topup code has been used
if($used!=0){
    if($used==$user->meter_no){
            $session->message("this code has already been used by you",true);
	redirect_to("../energy_profile.php?error=1&edefin=already used topup code");

    }
    else {
    $session->message("already used topup code",true);
	redirect_to("../energy_profile.php?error=1&edefin=already used topup code");
    }	
}
else {
//if the topup code is valid
    //to execute ite
    $formatted_reply="3200,$recharge_amount";
    //for the history
         $record=$database->query("INSERT INTO user_queries (meter_no,energy_budget,topup_code,payment_method,amount_paid,query_code,done,time_requested) VALUES ('$meter_no','','$id','','$recharge_amount','2','0',NOW())");
$query_id=$database->last_id();
    
$update=$database->query("UPDATE imeter_topup_code SET used='$meter_no' WHERE id='$id'")	;
//to calculate the topup codes
$know=$database->query("INSERT INTO meter_topup (method,value,meter_no,time) VALUES ('topup_code','$recharge_amount','$meter_no',NOW())")	;
 
$session->message("topupcode succesfully inserted you will be credited soon",false);
redirect_to("../energy_profile.php?error=0&edefin=topupcode succesfully inserted you will be credited soon");
}
	
}
else {
	//when the topup code is incorrect
	 $session->message("the topup code you entered does not exist, please check and try again",true);

	redirect_to("../energy_profile.php?error=1&edefin=the topup code you entered does not exist, please check and try again");
}
    
}
  $collected=new MeterMessage();
  //respose is already recorded in class
  echo $collected->recharge_meter($code,$meter_no);



      





?>
