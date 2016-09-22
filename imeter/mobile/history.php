<?php
//this page is where the user is going to see when he logs into his imeter account 
 header('Access-Control-Allow-Origin: *'); 
require_once('../includes/initialize.php') ;
if(!isset($_POST['imeterid']) || !isset($_POST['imetertoken'])){
	echo 'desc ="user authentication failed"';
} 
else {
	$userid=$_POST['imeterid'];
	$meter_no=eselect($userid,'meter_no');
}	 
$dava=array();

	$query="SELECT id,meter_no,query_code,energy_budget,done,time_requested,amount_paid,energy_budget FROM user_queries WHERE meter_no='$meter_no' ORDER BY id DESC ";
					$game=$mysqli->query($query);
					$i=0;
					while($row=$game->fetch_array()){
						$save_to=array();
						$save_to['id']=$row['id'];
						$strtime=$row['time_requested'];
						$time_obj=strtotime($strtime);
						$timestr=humanTiming($time_obj).' ago';
						$save_to['time']=$timestr;
						

						$status=$row['done'];
						$on_off=$row['payment_method'];
						$amount=$row['amount_paid'];
						$budget=$row['energy_budget'];
						$type=$row['query_code'];
						
						if($type==2){
							$desc="Recharge Of N$amount ";
						}
						if($type==1){
							
						$desc="Your Energy Budget was set to {$budget}Kwh";
						}
						if($type==3){
							if($on_off=='1'){
								$dd='Connected';
							}else {
									$dd='Disconnected';	
							}
						$desc="Your Power Supply Was $dd";
						}
						$save_to['desc']=$desc;
						$save_to['status']=$status;
						
					$dava[$i]=$save_to;
					$i++;
					}
				
	
				echo 'dava=' .json_encode($dava);
			?>