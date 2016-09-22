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
$toscript='userenergy.php';
if(!isset($userid)){
echo 'desc="please log in first"
';
}
else {
	
$meter_no=eselect($userid,'meter_no');
}
echo 'username ="'.	eselect($userid,'customer_name').'"
';	
//that today really means yesterday
//this is a simple maths to realise if someone is using his energy too fast
//first we get the users meter no

$e_budget=last_budget($meter_no);
//to get the optimal budget we divide by the monthly budget
$optimal_daily=(($e_budget/$month_days)/$price);
$optimal_daily=$optimal_daily==0?1:$optimal_daily;
//then we get the meters useage for the last 24hrs
$observed_daily=av_daily_energy($meter_no,'day');
//no conversion is required as it is in days
//so the percentage energy used is :
$useage=round($observed_daily*100/$optimal_daily);
echo "reluseage= $useage
";
  $observed_monthly=av_daily_energy($meter_no,'month');
  $r_observed_monthly=round($observed_monthly*$price);
  echo "aveuseage=$r_observed_monthly
  ";

	 $bal=$mysqli->query("SELECT energy_balance FROM meter_informations WHERE meter_no='$meter_no' ORDER BY id DESC LIMIT 1");
if($bal->num_rows){			 
			 while($row=$bal->fetch_array()){
				 $e_balance=$row['energy_balance']; 
				  
			  }
		 
}else {
	$e_balance=0;
}
	echo "ebal = $e_balance
			"; 
					  $o_useage=round($observed_monthly);
			  echo "dailyuseage=$o_useage
			  ";
			  //we get how much the user loaded last
$average_useage=check_zero($observed_daily);
echo 'daily_spend ='.$daily_spend=$observed_monthly*$price."
";
$observed_monthly=check_zero($observed_monthly);
$daily_spend=$observed_monthly*$price;
$days_rem=round($e_balance/$daily_spend);
					//first we get the amount of kilowatts of energy available for the user from his balance
echo "days_rem =$days_rem
";				
 $month_useage=$observed_monthly*$month_days;
echo "month_useage =$month_useage
";				
 $month_cost=$observed_monthly*$month_days*$price;
echo "month_cost =$month_cost
";				
						
			echo "
rate=$price
";


 ?> ;
