<?php 
require_once('../includes/functions.php') ;
$nums=$_POST['phone'];

echo '<ul class="nav nav-stacked">';
$pour=$mysqli->query("SELECT * FROM user_informations WHERE phone LIKE '%$nums%' LIMIT 5");
while($one=$pour->fetch_array()){
	$u_name=$one['customer_name'];
	$c_num=$one['phone'];
	echo " <li onclick=\"$('#phone_no').val('$c_num'); return false\"><a href=\"#\" >$u_name($c_num)</a></li>
             ";
	
}


echo '</ul>';
?>


