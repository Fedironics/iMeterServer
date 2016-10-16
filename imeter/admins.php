<?php
require_once 'includes/initialize.php';
if(!isset($admin_id)){
    redirect_to('alogin.php');
}
//this page is where the user is going to see when he logs into his imeter account 
require_once("includes/header.php");
	$diff=20;
	$query="SELECT * FROM administrators ";
	$url="admins.php?";
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
      <h1>
        Administrators 
        <small>(Installers)</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Administrators</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

 
      <!-- =========================================================== -->

      
      <div class="row">
	  
	  	  <?php 
		  
        $queries=$query. " LIMIT $start,$diff";
		$counting=$mysqli->query($query);
		$total=$counting->num_rows;
		$pages=ceil($total/$diff);
		while($admin=$counting->fetch_array()){
		$name=$admin['name'];
		$id=$admin['id'];
		$arc_id=$admin['admin_id'];
		$installed=$mysqli->query("SELECT id FROM user_informations WHERE installer='$arc_id' ")->num_rows;	
			
		echo "    <div class=\"col-md-4\">
          <!-- Widget: user widget style 1 -->
          <div class=\"box box-widget widget-user-2\">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class=\"widget-user-header bg-yellow\">
              <div class=\"widget-user-image\">
                <img class=\"img-circle\" src=\"images/admins/$id.jpg\" alt=\"User Avatar\">
              </div>
              <!-- /.widget-user-image -->
              <h3 class=\"widget-user-username\">$name</h3>
              <h5 class=\"widget-user-desc\">Installer</h5>
            </div>
            <div class=\"box-footer no-padding\">
              <ul class=\"nav nav-stacked\">
                <li><a href=\"#\">Profile </a></li>
                <li><a href=\"users.php?ref=$id\">Installed Imeters <span class=\"pull-right badge bg-aqua\">$installed</span></a></li>
                <li><a href=\"#\">Completed Projects * <span class=\"pull-right badge bg-green\">12</span></a></li>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>";	
		}
		
		
		?>
       <!-- /.col -->
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
	echo "
	<li class=\"paginate_button \"><a tabindex=\"0\" data-dt-idx=\"$sapages\" aria-controls=\"example2\" href=\"{$url}page={$apages}\">$sapages</a></li>";
	
}	
	


echo         "<li id=\"example2_next\" class=\"paginate_button next\"><a tabindex=\"0\" data-dt-idx=\"7\" aria-controls=\"example2\" href=\"{$url}page={$next}\">Next</a></li>";

}
?>
	</ul></div></div></div>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.3.2
    </div>
    <strong>Copyright &copy; 2014-2015 <a href="http://imeter.com">Fedironics Institute of Research</a>.</strong> All rights
    reserved.
 </footer>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
</body>
</html>
