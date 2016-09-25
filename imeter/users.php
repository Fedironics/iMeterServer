<?php
//this page is where the user is going to see when he logs into his imeter account 
require_once("includes/initialize.php");
if(!isset($admin_id)){
	header("Location:alogin.php");
}
require_once("includes/header.php");
  $pday=$day-1;
			  $timeonly =date('H:i:s');
			  $pdate=$year.'-'.$month.'-'.$pday.' ' .$timeonly;
			  $datetime = date('Y-m-d H:i:s', time());
	$diff=20;
	$query="SELECT * FROM user_informations ";
	$url="users.php?";
	$pagename='Installed Imeters';
	if(isset($_GET['ref'])){
		$ad_id=$_GET['ref'];		
		$a_id=adselect($ad_id,'admin_id');
		$query="SELECT * FROM user_informations WHERE installer='$a_id' ";
		$url="users.php?req=$ad_id&";		
		$aname=adselect($ad_id,'name');
		$pagename="Meters Installed By $aname";
	}
		if(isset($_GET['reg'])){	
	$query="SELECT * FROM user_informations WHERE date_reg BETWEEN '$pdate' AND '$datetime'  ";
		$url="users.php?reg=yes";		
		$pagename="Users Registered Today";
	}
			if(isset($_GET['vc'])){	
	$query="SELECT DISTINCT visitor_id FROM visitors WHERE time BETWEEN '$pdate' AND '$datetime'  ";
		$url="users.php?vc=yes";		
		$pagename="Users Who Logged In today";
	}
if(!isset($_GET['page'])){
	$start=0;
	$page=0;}
	if(isset($_GET['page'])){
	$page=$_GET['page'];
    $start=$page*$diff;}
	$apage=$page+1;
	$next=$page+1;
	$prev=$page-1;

	
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
 <?php   /*  " <h1>
        Widgets
        <small>Preview page</small>
      </h1>"; */ ?>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Widgets</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

 
      <!-- =========================================================== -->

      <h2 class="page-header"><?php echo $pagename ; ?> </h2>

      <div class="row">
        <!-- Widget: user widget style 1 -->
		  <?php 
		  if(isset($_GET['vc'])){	
		    $queries=$query. " LIMIT $start,$diff";
		$counting=$mysqli->query($query);
		$total=$counting->num_rows;
		
		$pages=ceil($total/$diff);
	$quero=$mysqli->query($queries);
	while($one_p=$quero->fetch_array()){
		$vid=$one_p['visitor_id'];
		$one_d=$mysqli->query("SELECT * FROM user_informations WHERE id='$vid'");
		while($data_row=$one_d->fetch_array()){
			
			
			$id=$data_row['id'];
			$name=$data_row['customer_name'];
			$meter_no=$data_row['meter_no'];
			$reg_d=$data_row['date_reg'];
		  $place=$data_row['state'].' '.$data_row['town'].' '.$data_row['address'];
		 $time_reg=strtotime($reg_d,time());
		 $time_str=humanTiming($time_reg);
$monthly_u=av_daily_energy($meter_no,'month');
//no conversion is required as it is in days
//so the percentage energy used is :
  $bal=$mysqli->query("SELECT energy_balance FROM meter_informations WHERE meter_no='$meter_no' ORDER BY id DESC LIMIT 1");
			  while($row=$bal->fetch_array()){
				 $e_balance=$row['energy_balance']; 
				  
			  }		  
		if($bal->num_rows<1){$e_balance='0';}  
	echo "
     <div class=\"col-md-4\">
          <!-- Widget: user widget style 1 --> 
          <div class=\"box box-widget widget-user\">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class=\"widget-user-header bg-aqua-active\" style=\"background: url('images/meterbg.jpg') center center;\">
              <h3 class=\"widget-user-username\"><a href='energy_profile.php?user=$meter_no' > $name jkl</a></h3>
              <h5 class=\"widget-user-desc\">$place</h5>
            </div>
            <div class=\"widget-user-image\">";
			if(file_exists("images/imeters/$id.jpg")){
			echo "
              <img class=\"img-circle\" src=\"images/imeters/$id.jpg\" alt=\"User Avatar\">"	;
			}
			echo "
            </div>
            <div class=\"box-footer\">
              <div class=\"row\">
                <div class=\"col-sm-4 border-right\">
                  <div class=\"description-block\">
		<h5 class=\"description-header\">{$monthly_u}KwH</h5>
                    <span class=\"description-text\">MONTHLY USAGE</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class=\"col-sm-4 border-right\">
                  <div class=\"description-block\">
                    <h5 class=\"description-header\">$e_balance Naira</h5>
                    <span class=\"description-text\">Energy Bal</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class=\"col-sm-4\">
                  <div class=\"description-block\">
                    <h5 class=\"description-header\">$time_str</h5>
                    <span class=\"description-text\">TIME USED</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
   


";		
			
	}
		
		
		
		
	}
	}else {
		  
        $queries=$query. " LIMIT $start,$diff";
		$counting=$mysqli->query($query);
		$total=$counting->num_rows;
		
		$pages=ceil($total/$diff);
		while($user=$counting->fetch_array()){
			$id=$user['id'];
			$name=$user['customer_name'];
			$meter_no=$user['meter_no'];
			$reg_d=$user['date_reg'];
		  $place=$user['state'].' '.$user['town'].' '.$user['address'];
		 $time_reg=strtotime($reg_d,time());
		 $time_str=humanTiming($time_reg);
$monthly_u=av_daily_energy($meter_no,'month');
//no conversion is required as it is in days
//so the percentage energy used is :
  $bal=$mysqli->query("SELECT energy_balance FROM meter_informations WHERE meter_no='$meter_no' ORDER BY id DESC LIMIT 1");
			  while($row=$bal->fetch_array()){
				 $e_balance=$row['energy_balance']; 
				  
			  }		  
		if($bal->num_rows<1){$e_balance='0';}  
	echo "
     <div class=\"col-md-4\">
          <!-- Widget: user widget style 1 -->
          <div class=\"box box-widget widget-user\">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class=\"widget-user-header bg-aqua-active\" style=\"background: url('images/meterbg.jpg') center center;\">
              <h3 class=\"widget-user-username\"><a href='energy_profile.php?user=$id' >$name</a></h3>
              <h5 class=\"widget-user-desc\">$place</h5>
            </div>
            <div class=\"widget-user-image\">";
			if(file_exists("images/imeters/$id.jpg")){
			echo "
              <img class=\"img-circle\" src=\"images/imeters/$id.jpg\" alt=\"User Avatar\">"	;
			}
			echo "
           </div>
            <div class=\"box-footer\">
              <div class=\"row\">
                <div class=\"col-sm-4 border-right\">
                  <div class=\"description-block\">
		<h5 class=\"description-header\">{$monthly_u}KwH</h5>
                    <span class=\"description-text\">MONTHLY USAGE</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class=\"col-sm-4 border-right\">
                  <div class=\"description-block\">
                    <h5 class=\"description-header\">$e_balance Naira</h5>
                    <span class=\"description-text\">Energy Bal</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class=\"col-sm-4\">
                  <div class=\"description-block\">
                    <h5 class=\"description-header\">$time_str</h5>
                    <span class=\"description-text\">TIME USED</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
   


";		
			
	}}
			  ?>
		     </div>
      <!-- /.row -->

  
    </section>
    <!-- /.content -->
	<div class="row">
	<div class="col-sm-5">
	<div aria-live="polite" role="status" id="example2_info" class="dataTables_info">
	<?Php echo " Showing $start to ";echo $start+$diff ;echo " of $total entries"; ?>
	</div></div>
	<div class="col-sm-7">
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
	</ul></div></div> </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
	
      <b>Version</b> 2.3.2
    </div>
    <strong>Copyright &copy; 2014-2015 <a href="http://imeter.com">Fedironics Institute of Research</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
