<?php 

 header('Access-Control-Allow-Origin: *'); 
require_once('../includes/initialize.php') ;
if(!isset($_POST['imeterid']) || !isset($_POST['imetertoken'])){
	echo 'desc ="user authentication failed"
	'; 
} 
else {
	$userid=$_POST['imeterid'];
	$meter_no=eselect($userid,'meter_no');
}
if(isset($_POST['frame'])){
	$frame='days';
$curr_obj=time();
	$t_day=0;
	$labels='[';
$values_time='[';
	for($i=0;$i<30;$i++){	//get the total energy consumed in the last 24 hrs
	$today=date("Y-m-d",$curr_obj);
	$curr_obj=strtotime('-1 day',$curr_obj);
	$t_day=0;
$myquerys=$mysqli->query("SELECT energy_consumed,hour,id,dater FROM meter_informations WHERE meter_no='$meter_no' AND dater='$today' LIMIT 24");
while($day=$myquerys->fetch_array()){
$t_day=$day['energy_consumed']+$t_day;}
$out_w=date('d M',$curr_obj);
   $labels.="\"$out_w\",";
   $values_time.="$t_day,";
}
  $llen=strlen($labels)-1;
   $labels=substr($labels,0,$llen);
    $vlen=strlen($values_time)-1;
   $values_time=substr($values_time,0,$vlen);
   $labels.=']';
   $values_time.=']';
   
     echo "  labelolo= $labels
  ";
   echo "  values_time= $values_time
  ";
 
}
else{	//get the total energy consumed in the last 24 hrs
$part_query="SELECT energy_consumed,hour FROM meter_informations WHERE meter_no='$meter_no' ORDER BY id DESC LIMIT 24 ";
$myquery=$mysqli->query("(SELECT energy_consumed,hour,id FROM meter_informations WHERE meter_no='$meter_no' ORDER BY id DESC LIMIT 24) ORDER BY id ASC");
$divisor=$myquery->num_rows;
$labels='[';
$values_time='[';
if(!$myquery){
     echo "query could not be executed";
      }
else{
	while ($page=$myquery->fetch_array()) {
    $energy=$page['energy_consumed'];  
    $hour=$page['hour'];  
   $labels.="\"$hour\",";
   $values_time.="$energy,";
   }
   $llen=strlen($labels)-1;
   $labels=substr($labels,0,$llen);
    $vlen=strlen($values_time)-1;
   $values_time=substr($values_time,0,$vlen);
   $labels.=']';
   $values_time.=']';
  //this will return the total energy consumed that day
  
  }
  
  echo "  labelolo= $labels
  ";
   echo "  values_time= $values_time
  ";}
   
?>