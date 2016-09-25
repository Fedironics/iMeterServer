<?php
require_once("../includes/initialize.php");
if(!$session->check_login()){
	header("Location:../login.php");
}
if(isset($admin_id)){

		$id=$user->id;
		
		
if($_FILES['ppix']['name'] !="" and $_FILES['ppix']['error']===0) {
        
require_once '../SimpleImage/src/abeautifulsite/SimpleImage.php';
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
$rega = "../images/admins/$id.jpg";
$image->save($rega);
$image->fit_to_width(100);
$regs = "../images/admins/thumbs/$id.jpg";
$image->save($regs);

}
}
		

if(isset($userid)){
$id=$userid;
if($_FILES['ppix']['name'] !="" and $_FILES['ppix']['error']===0) {
        
require_once '../SimpleImage/src/abeautifulsite/SimpleImage.php';
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
$rega = "../images/imeters/$id.jpg";
$image->save($rega);
$image->fit_to_width(100);
$regs = "../images/imeters/thumbs/$id.jpg";
$image->save($regs);

}	
}

redirect_to('../index.php');



?>
