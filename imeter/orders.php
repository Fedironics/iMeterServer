<?php
//this page is where the user is going to see when he logs into his imeter account 
require_once("includes/initialize.php");
if(!isset($admin_id)){
	header("Location:alogin.php");
}
require_once("includes/header.php");
	$diff=20;
	$query="SELECT * FROM user_queries ORDER BY id DESC ";
	$url="orders.php?";
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
        Orders
        <small>Preview page</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Orders</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

 
      <!-- =========================================================== -->

    
      <div class="row">
	  

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Table With Full Features</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table  class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Order Id</th>
                  <th>Meter No</th>
                  <th>Desctiption</th>
                  <th>Time</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>
				<?php 
				    $queries=$query. " LIMIT $start,$diff";
					$game=$mysqli->query($queries);
		$counting=$mysqli->query($query);
		$total=$counting->num_rows;		
		$pages=ceil($total/$diff);
				while($row=$game->fetch_array()){
					$id=$row['id'];
					$type=$row['query_code'];
					$status=$row['done'];
					$strtime=$row['time_requested'];
						$time_obj=strtotime($strtime);
						$ptime=humanTiming($time_obj).' ago';
						$this_mno=$row['meter_no'];
					if($type=='1'){
						//when the user sets an energy budget
						$budget=$row['energy_budget'];
						echo "  <tr>
                    <td>$id</td>
                    <td><a href=\"energy_profile.php?user=$this_mno\">$this_mno</a></td>
                    <td>Set Energy Budget as N$budget</td>";
					
echo '<td>'.$ptime.'</td>';
   if($status=='1'){
	 echo " <td><span class=\"label label-success\">Done</span></td>
                  ";				  
   }                
    else {
		
		echo " <td><span class=\"label label-warning\">Pending</span></td>
                  ";
	}       		}
					if($type=='2'){
						//when the user recharges a topup code
						$amount=$row['amount_paid'];
						echo "  <tr>
						     <td>$id</td>
                    <td><a href=\"energy_profile.php?user=$this_mno\">$this_mno</a></td>
                    <td>Recharge of N$amount into the meter by topupcode</td>";
					
echo '<td>'.$ptime.'</td>';
   if($status=='1'){
	 echo " <td><span class=\"label label-success\">Done</span></td>
                  ";				  
   }                
    else {
		
		echo " <td><span class=\"label label-warning\">Pending</span></td>
                  ";	}
					}
				  echo "   </tr>";					
				}
				
	
				
				
				
				
				?>
				
	       <tfoot>
                <tr>
                  <th>Order Id</th>
                  <th>Meter No</th>
                  <th>Description</th>
                  <th>Time</th>
                  <th>Status</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
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

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->

  </aside>
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
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
</body>
</html>
