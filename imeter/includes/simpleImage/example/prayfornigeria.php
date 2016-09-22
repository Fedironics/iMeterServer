<?php
namespace   abeautifulsite;
use         Exception;

require '../src/abeautifulsite/SimpleImage.php';
$level='50';
$watertext='#PrayForNigeria';
$grayscale=0;
$water=0;
if(isset($_POST['submit'])){
$level=$_POST['levels'];
   
try {
    // Flip the image and output it directly to the browser
  //  $img = new SimpleImage('prev_pix.jpg');
    //$info = $img->get_original_info();
   // $width=$info['width'];
    //$height=$info['height'];
} catch(Exception $e) {
    echo '<span style="color: red;">' . $e->getMessage() . '</span>';
}

if(isset($_POST['grayscale']))  {
    
$grayscale=$_POST['grayscale'] ; 
 if($grayscale==1){
//$img->desaturate();

}
}  




 if($level>0){ 
     $level='.'.$level;
     echo $level.'<br/>';
 try {
    // Flip the image and output it directly to the browser
 $ova=  new SimpleImage('cat.jpg');
 $ova->resize(60,60)->save('dynamic_overlay.png');
//$img->overlay('dynamic_overlay.png', 'center', $level);

} catch(Exception $e) {
    echo '<span style="color: red;">' . $e->getMessage() . '</span>';
}    }
if(isset($_POST['watermark'] )) {
$water=$_POST['watermark'] ;   
$watertext=$_POST['watertext'] ;   
if($water==1){
//$img->text($watertext, __DIR__.'/delicious.ttf', 32, '#FFFFFF', 'bottom', 0, -20);
}
}

//$img->save('ppix.jpg');
}

                           
?>
<html>
<body>
<h1>#PrayForNigeria</h1>    
<div style='float:left'>    
<h3>Before</h3>
<img src='prev_pix.jpg' style='width:80%;border:4px solid white;outline:1px solid black;display:block;margin:auto;max-width:400px;' />   </div>    
<div style='float:left'>  
<h3>After</h3>
<div id='holder'>
<img id='show' src='ppix.jpg' style='width:80%;border:4px solid white;outline:1px solid black;display:block;margin:auto;max-width:400px;' /></div> </div>
<form style='clear:both' id='form' action='prayfornigeria.php' method='post'>
<br/>
Overlay LEVEL :<em>.<input style='border:none' type='number' name='levels' value="<?php echo $level; ?>" /> </em> <br/>
Grayscale : <input type='checkbox' name='grayscale' value="1" <?php if($grayscale==1){echo "checked='checked'";} ?> />   <br/>
 Watermark Text : <input type='checkbox' name='watermark' value="1" <?php if($water==1){echo "checked='checked'";} ?>/> <input type='text' name='watertext' value="<?php echo $watertext; ?>" />   <br/>
<input type='submit' value='save changes' id='go' name='submit' />
</form>                                                      
<script type='text/javascript' src='../../js/jquery-1.9.1.min.js'></script>  
<script>

</script>
</body>
</html>