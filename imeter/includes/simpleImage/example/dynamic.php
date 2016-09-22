<?php
namespace   abeautifulsite;
use         Exception;

require '../src/abeautifulsite/SimpleImage.php';
$level='50';
$watertext='#PrayForNigeria';
$grayscale=0;
$water=0;
$level=$_POST['levels'];
   
try {
    // Flip the image and output it directly to the browser
    $img = new SimpleImage('prev_pix.jpg');
    $info = $img->get_original_info();
    $width=$info['width'];
    $height=$info['height'];
} catch(Exception $e) {
    echo '<span style="color: red;">' . $e->getMessage() . '</span>';
}

if(isset($_POST['grayscale']))  {
    
$grayscale=$_POST['grayscale'] ; 
 if($grayscale==1){
$img->desaturate();

}
}  




 if($level>0){ 
     $level='.'.$level;
     echo $level.'<br/>';
 try {
    // Flip the image and output it directly to the browser
 $ova=  new SimpleImage('overlay.png');
 $ova->resize($width,$height)->save('dynamic_overlay.png');
$img->overlay('dynamic_overlay.png', 'center', $level);

} catch(Exception $e) {
    echo '<span style="color: red;">' . $e->getMessage() . '</span>';
}    }
if(isset($_POST['watermark'] )) {
$water=$_POST['watermark'] ;   
$watertext=$_POST['watertext'] ;   
if($water==1){
$img->text($watertext, __DIR__.'/delicious.ttf', 32, '#FFFFFF', 'bottom', 0, -20);
}
}

$img->save('ppix.jpg');

?>