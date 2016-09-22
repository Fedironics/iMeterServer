<?php 
header('Access-Control-Allow-Origin: *'); 
require_once('../includes/initialize.php') ;
if(!isset($_POST['imeterid']) || !isset($_POST['imetertoken'])){
	echo 'desc ="user authentication failed"';
} 
else {
	$userid=$_POST['imeterid'];
	$meter_no=eselect($userid,'meter_no');
}
    $get_last_date=$mysqli->query("SELECT dater from meter_informations WHERE  meter_no='$meter_no' LIMIT 1 ");
if($get_last_date->num_rows>0){  while($last_date=$get_last_date->fetch_array()){
	  $date_string=$last_date['dater'];
}}
else { 
	$date_string=date('Y-m-d H-i-s',time());
}
  		$get_total=$mysqli->query("SELECT energy_consumed FROM meter_informations WHERE dater='$date_string' AND meter_no='$meter_no'");
$energy_total=0;
		while($totals=$get_total->fetch_array()){
		$energy_total=$energy_total+$totals['energy_consumed'];	
		}
 $energy_total= check_zero($energy_total);
  $pie_get_night=$mysqli->query("SELECT energy_consumed FROM meter_informations WHERE dater='$date_string' AND meter_no='$meter_no' AND hour<='6'");
$night_cons=0; 
 while($line=$pie_get_night->fetch_array()){
	$night_cons=$night_cons+$line['energy_consumed'];  
 
 ;
  }
  echo " night_raw='".$night_cons."'
  ";
   $night_cons=round($night_cons/$energy_total*100);
    $pie_get_morn=$mysqli->query("SELECT energy_consumed FROM meter_informations WHERE dater='$date_string' AND meter_no='$meter_no' AND hour BETWEEN 7 AND 12  ");
$morn_cons=0; 
 while($line=$pie_get_morn->fetch_array()){
	$morn_cons=$morn_cons+$line['energy_consumed'];  
	 
	  
  }
    echo " morn_raw='".$morn_cons."'
  ";
   $morn_cons=round($morn_cons/$energy_total*100);
    $pie_get_aft=$mysqli->query("SELECT energy_consumed FROM meter_informations WHERE dater='$date_string' AND meter_no='$meter_no' AND hour BETWEEN 13 AND 18  ");
$aft_cons=0; 
 while($line=$pie_get_aft->fetch_array()){
	$aft_cons=$aft_cons+$line['energy_consumed'];  
	  
  }
   echo " aft_raw='".$aft_cons."'
  ";
	 $aft_cons=round($aft_cons/$energy_total*100) ;
    $pie_get_eve=$mysqli->query("SELECT energy_consumed FROM meter_informations WHERE dater='$date_string' AND meter_no='$meter_no' AND hour >18  ");
$eve_cons=0; 
 while($line=$pie_get_eve->fetch_array()){
	$eve_cons=$eve_cons+$line['energy_consumed']; 
	  
  }
   echo " eve_raw='".$eve_cons."'
  ";
	$eve_cons=round($eve_cons/$energy_total*100);  

echo "
night_cons = $night_cons 
morn_cons = $morn_cons
aft_cons = $aft_cons
eve_cons = $eve_cons
	";
	
	
?>