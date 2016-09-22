<?php

 header('Access-Control-Allow-Origin: *'); 
  
require_once('../includes/initialize.php') ;
if(!isset($_POST['imeterid']) || !isset($_POST['imetertoken'])){
	echo 'desc ="user authentication failed"';
}
else {
	$meter_no=$_POST['imeterid'];
	$meter_token=$_POST['imetertoken'];
if($_FILES['ppix']['name'] !="" and $_FILES['ppix']['error']===0) {
        
require '../SimpleImage/src/abeautifulsite/SimpleImage.php';
$image = new abeautifulsite\SimpleImage($_FILES [ 'ppix' ][ 'tmp_name' ]);
$image->fit_to_width(500);    
$iheight=$image->get_height(); 
$iwidth=500;
if($iheight-$iwidth>0){
//if the height is greater than the width
$cut_off=($iheight-500)/2;
$image->crop(0,$cut_off,500,($iheight-$cut_off)) ;
}else {
 $cut_off=(500-$iheight)/2;
$image->crop($cut_off,0,(500-$cut_off),$iheight) ;
}
$rega = "../images/imeters/$meter_no.jpg";
$image->save($rega);
$image->fit_to_width(100);
$regs = "../images/imeters/thumbs/$meter_no.jpg";
$image->save($regs);
echo "http://imeter.fedironics.com/images/imeters/$meter_no.jpg";

}	
}





?>
