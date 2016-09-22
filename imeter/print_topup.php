<?php 
require_once("includes/initialize.php");
if(!isset($admin_id)){
	header("Location:login.php");
}
else {
if(!isset($_GET['price'])){
	header("location:admin.php");
	
}else{

	
	
	if($_GET['price']=='a'){
		$amt='1000';
	}
	else if($_GET['price']=='b'){
		$amt='2000';
	}
		else if($_GET['price']=='c'){
		$amt='5000';
	}
		else if($_GET['price']=='d'){
		$amt='10000';
	}
	else {
		$amt='1000';
	}
		$diff=20;
	$query="SELECT * FROM imeter_topup_code WHERE amount='$amt'  ";
	$val=$_GET['price'];
	$url="print_topup.php?price=$val&";
	if(!isset($_GET['page'])){
	$start=0;
	$page=0;}
	if(isset($_GET['page'])){
	$page=$_GET['page'];
    $start=$page*$diff;}
	$apage=$page+1;
	$next=$page+1;
	$prev=$page-1;

  $counter=0;
  $codes=$mysqli->query("SELECT * FROM imeter_topup_code WHERE amount='$amt' LIMIT 20");
 	
	
	
	
}


}?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
 <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body onload="">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
  <a href='admin.php'><h2>Back to Admin</h2></a>
  <?Php 
  echo "<h3>Page $apage of $amt Topupcode</h3>";
       $queries=$query. " LIMIT $start,$diff";
       $quer=$mysqli->query($queries);
		$counting=$mysqli->query($query);
		$total=$counting->num_rows;
		
		$pages=ceil($total/$diff);

 while($card=$quer->fetch_array()){
	  $counter++;
	  $id=$card['id'];
	  $pin=$card['pin'];
	  $used=$card['used'];
	if($used=='0') { if($counter==1){
		  echo '
     <div class="row">';
	  }
	  echo "        <div class=\"col-md-3\">
          <div class=\"box box-success box-solid\">
            <div class=\"box-header with-border\">
              <h3 class=\"box-title\">N$amt Topup Code</h3>

              <div class=\"box-tools pull-right\">
                <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"remove\"><i class=\"fa fa-times\"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class=\"box-body\">
$pin
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>";
	 if($counter==4){
		 
		 echo "</div>";
		 $counter=0;
	 } 
	}
	else { if($counter==1){
		  echo '
     <div class="row">';
	  }
	  echo "        <div class=\"col-md-3\">
          <div class=\"box box-danger box-solid\">
            <div class=\"box-header with-border\">
              <h3 class=\"box-title\">N$amt Topup Code</h3>
 <div class=\"overlay\">
              <i class=\"fa fa-refresh fa-spin\"></i>
            </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class=\"box-body\">
$pin
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>";
	 if($counter==4){
		 
		 echo "</div>";
		 $counter=0;
	 } 
	}
  }
  
  
  
  
  ?>
     </div>
   </section>
  <!-- /.content -->
</div>
<div class="col-sm-7">
	<div id="example2_paginate" class="dataTables_paginate paging_simple_numbers">
	<ul class="pagination">
	<?php 
	if($page>0){
echo "<li id=\"example2_previous\" class=\"paginate_button previous\"><a tabindex=\"0\" data-dt-idx=\"0\" aria-controls=\"example2\" href=\"{$url}page={$prev}\">Previous</a></li>
	";
	} 
else {
echo "<li id=\"example2_previous\" class=\"paginate_button previous disabled\"><a tabindex=\"0\" data-dt-idx=\"0\" aria-controls=\"example2\" href=\"#\">Previous</a></li>
	";	
}	
echo "<li class=\"paginate_button active\"><a tabindex=\"0\" data-dt-idx=\"1\" aria-controls=\"example2\" href=\"#\">$apage</a></li>
	";	

if($apage<$pages){ 
	for($x=1;$x<6;$x++){
	$apages=$page+$x;
	$sapages=$page+$x+1;
	
if($apages<$pages){ 
	echo "
	<li class=\"paginate_button \"><a tabindex=\"0\" data-dt-idx=\"$sapages\" aria-controls=\"example2\" href=\"{$url}page={$apages}\">$sapages</a></li>";
}
}	
	


echo         "<li id=\"example2_next\" class=\"paginate_button next\"><a tabindex=\"0\" data-dt-idx=\"7\" aria-controls=\"example2\" href=\"{$url}page={$next}\">Next</a></li>";

}
?>
	</ul></div></div>
<!-- ./wrapper -->
</body>
</html>
