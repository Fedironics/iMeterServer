<?php
defined('DS')?null:define('DS', '\\');
require_once SITE_ROOT.DS."includes".DS.'functions.php';

 $id=random_string();
if($_FILES['file']['name'] !="" and $_FILES['file']['error']===0) {
$path=$_FILES [ 'file' ][ 'type' ];
$name=$_FILES['file']['name'];
$ext=pathinfo($name,PATHINFO_EXTENSION);
if($path!='image/jpeg' && $path!='image/png' && $path!='image/gif' && $path!='image/jpg') {
echo '--not an image--';

}  
else{     
require 'simpleImage/src/abeautifulsite/SimpleImage.php';
$image = new abeautifulsite\SimpleImage($_FILES [ 'file' ][ 'tmp_name' ]);
$image->fit_to_width(500);
$rega = "../images/$id.$ext";
$image->save($rega);

echo "images/$id.$ext";
}
} 
else {
 echo "--file has error--";   
}
?>
