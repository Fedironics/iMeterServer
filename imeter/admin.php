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
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel(daily)</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<?php 
   echo     $session->show_messages();
	?>
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>
			  <?php 
			  
			  $new_queries=$mysqli->query("SELECT id FROM user_queries WHERE time_requested BETWEEN '$pdate' AND '$datetime' ")->num_rows;
			  echo $new_queries;
			  ?>
			  </h3>

              <p>New Requests</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div> 
            <a href="orders.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
   <?php 
   //this should tell you how much more interest you are making
  
   
   ?>           <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>Bounce Rate</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php 
		
			  $user_reg=$mysqli->query("SELECT id FROM user_informations WHERE date_reg BETWEEN '$pdate' AND '$datetime' ")->num_rows;
echo $user_reg;			

//SELECT DATE_ADD( now( ) , INTERVAL -1 MONTH )  
			 ?></h3>

              <p>
			  User Registrations</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="users.php?reg=yes" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php 
			  $unique=$mysqli->query("SELECT DISTINCT visitor_id FROM visitors WHERE time BETWEEN '$pdate' AND '$datetime' ")->num_rows;
echo $unique;			  ?>
			  </h3>

              <p>Visiting Consumers</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="users.php?vc=yes" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
	  
	        <div class="row">
			<a href='print_topup.php?price=a'>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">N1000 codes</span>
              <span class="info-box-number"><?php echo $no_a= $mysqli->query("SELECT id FROM imeter_topup_code WHERE amount='1000' AND used='0'")->num_rows; 
			  $a_per=round($no_a/$max_all*100).'%';
			  ?></span>

              <div class="progress">
                <div class="progress-bar" style="width:<?php echo $a_per ; ?>"></div>
              </div>
                  <span class="progress-description">
                   <?php echo $a_per ; ?> Remaining N1000 Codes
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div></a>
        <!-- /.col -->
		
			<a href='print_topup.php?price=b'>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">N2000 codes</span>
              <span class="info-box-number"><?php echo $no_b= $mysqli->query("SELECT id FROM imeter_topup_code WHERE amount='2000' AND used='0'")->num_rows; 
			  $b_per=round($no_b/$max_all*100).'%';
			  ?></span>

              <div class="progress">
                <div class="progress-bar" style="width:<?php echo $b_per ; ?>"></div>
              </div>
                  <span class="progress-description">
                <?php echo $b_per ; ?>  Remaining N2000 Codes
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div></a>
        <!-- /.col -->
		
			<a href='print_topup.php?price=c'>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">N5,000 codes</span>
              <span class="info-box-number"><?php echo $no_c= $mysqli->query("SELECT id FROM imeter_topup_code WHERE amount='5000' AND used='0'")->num_rows; 
			  $c_per=round($no_c/$max_all*100).'%';
			  ?></span>

              <div class="progress">
                <div class="progress-bar" style="width:<?php echo $c_per ; ?>"></div>
              </div>
                  <span class="progress-description">
                <?php echo $b_per ; ?>  Remaining N5000 Codes
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
		</a>
        <!-- /.col -->
		
			<a href='print_topup.php?price=d'>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">N10,000 codes</span>
              <span class="info-box-number"><?php echo $no_d= $mysqli->query("SELECT id FROM imeter_topup_code WHERE amount='10000' AND used='0'")->num_rows; 
			  $d_per=round($no_d/$max_all*100).'%';
			  ?></span>

              <div class="progress">
                <div class="progress-bar" style="width:<?php echo $d_per ; ?>"></div>
              </div>
                  <span class="progress-description">
               <?php echo $d_per ; ?>  Remaining N10000 Codes
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div></a>
        <!-- /.col -->
		<button type="button" class="btn btn-default btn-block" onclick='location.href="process/topup_generator.php"'>Refill Codes</button>
		<br/>
      </div>
      <!-- /.row -->

	  
	      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Monthly Recap Report</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <p class="text-center">
                    <strong>No Of topup and Visitors Against time(days)</strong>
                  </p>

                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <canvas id="salesChart" style="height: 180px;"></canvas>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <p class="text-center">
                    <strong>Goal Completion</strong>
                  </p>

                  <div class="progress-group">
                    <span class="progress-text">N1000 codes</span>
					<?php 
echo "<span class=\"progress-number\"><b>$no_a</b>/$max_all</span>";				
					
	echo "<div class=\"progress sm\">
                      <div class=\"progress-bar progress-bar-aqua\" style=\"width: {$a_per}\"></div>";				
					?>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">N2000 codes</span>
                   <?php echo " <span class=\"progress-number\"><b>$no_b</b>/$max_all</span>

                    <div class=\"progress sm\">
                      <div class=\"progress-bar progress-bar-red\" style=\"width: $b_per\"></div>
                    </div>"; ?>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">N5000 codes</span>
                 <?php echo "   <span class=\"progress-number\"><b>$no_c</b>/100</span>

                    <div class=\"progress sm\">
                      <div class=\"progress-bar progress-bar-green\" style=\"width:$c_per\"></div>
"; ?>                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                <?php echo "    <span class=\"progress-text\">N10000 codes</span>
                    <span class=\"progress-number\"><b>$no_d</b>/$max_all</span>

                    <div class=\"progress sm\">
                      <div class=\"progress-bar progress-bar-yellow\" style=\"width: $d_per\"></div>"; ?>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <h5 class="description-header"><?php 
					
		$date_raw=date('r');
		
	$pyesterday=date('Y-m-d H:i:s', strtotime("-1 day", strtotime($date_raw)));
$last_month=date('Y-m-d H:i:s', strtotime("-30 day", strtotime($date_raw)));
	$ptoday=date('Y-m-d H:i:s',  strtotime($date_raw));

					$mon_v=$mysqli->query("SELECT id FROM visitors WHERE time>='$last_month' AND time<='$ptoday'")->num_rows;
					
					
					
					echo  $mon_v.'visitors'; ?></h5>
                    <span class="description-text">TOTAL MONTHLY VISITORS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                   <div class="description-block border-right">
                    <h5 class="description-header"><?php 
					$day_v=$mysqli->query("SELECT id FROM visitors WHERE time>='$pyesterday' AND time<='$ptoday'")->num_rows;
					
					echo $day_v.'visitors' ;
					
					?></h5>
                    <span class="description-text">AVERAGE DAILY VISITORS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <h5 class="description-header"><?php 	
					$mon_t=$mysqli->query("SELECT id FROM meter_topup WHERE time>='$last_month' AND time<='$ptoday'")->num_rows;
					
					echo $mon_t ;
					 ?></h5>
                    <span class="description-text">MONTHLY TOTAL ENERGY TOPUPS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block">
                    <h5 class="description-header"><?php
						$day_t=$mysqli->query("SELECT id FROM meter_topup WHERE time>='$pyesterday' AND time<='$ptoday'")->num_rows;
					
					echo $day_t ;?></h5>
                    <span class="description-text">TODAY'S TOPUPS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
  
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
 
          <!-- /.nav-tabs-custom -->

  
          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">Energy Theft Information</h3>

            
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="todo-list">
<?php 
$get_theft=$mysqli->query("SELECT * FROM energy_theft WHERE active='1' ORDER BY id DESC LIMIT 20");
while($one=$get_theft->fetch_array()){
	$sid=$one['id'];
	$time=$one['time_recieved'];
	$time_obj=strtotime($time);
	$time_str=date('H:i \o\n d M Y');
	$active=$one['active'];
	$meter_no=$one['meter_no'];
	$meter_name=eselect($meter_no,'customer_name','meter_no');
				$t_type=$one['type'];
					if($t_type==1){
						$t_desc='Earth Fault Tamper';
					}
					else if($t_type==2){
						$t_desc='Magnetic Tamper';
					}
						else if($t_type==3){
						$t_desc='Open Case Tamper';
					}
				
	echo " <li>
                  <!-- drag handle -->
                      <span class=\"handle\">
                        <i class=\"fa fa-ellipsis-v\"></i>
                        <i class=\"fa fa-ellipsis-v\"></i>
                      </span>
                  <!-- checkbox -->
                  <input type=\"checkbox\" value=\"\" name=\"\">
                  <!-- todo text -->
                  <span class=\"text\">$t_desc By $meter_name($meter_no)</span>
                  <!-- Emphasis label -->
                  <small class=\"label label-danger\"><i class=\"fa fa-clock-o\"></i> $time_str</small>
                  <!-- General tools such as edit or delete-->
                
                    <div class=\"tools\">
					<a href=\"process/flag_theft.php?id=$sid\" title='turn off flag' > 
					<i class=\"fa fa-trash-o\"></i></a>
                  </div>
                </li>";
	
}




?>             


			
        </ul>
            </div>
            <!-- /.box-body -->
       
          </div>
          <!-- /.box -->

          <!-- quick email widget -->
          <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-envelope"></i>

              <h3 class="box-title">Quick SMS</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
              <!-- /. tools -->
            </div>
            <div class="box-body">
              <form action="process/quicksms.php" method="post" id='sms'>
                <div class="form-group has-feedback">
                  <input type="text" id='phone_no' class="form-control" name="phone" placeholder="Phone Number">
				  <div class='feedback' >
				  </div>
				  
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="sender" placeholder="Sender Name">
                </div>
                <div>
                  <textarea name='message' class="textarea" placeholder="Message" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
              </form>
            </div>
            <div class="box-footer clearfix">
              <button type="button" onclick="$('#sms').submit()" class="pull-right btn btn-default" id="sendEmail">Send
                <i class="fa fa-arrow-circle-right"></i></button>
            </div>
          </div>

        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

          <!-- solid sales graph -->
 
          <!-- Calendar -->
         <!-- /.box -->

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
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
   <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

</script>
<!-- jQuery 2.1.4 -->
<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="bootstrap/js/bootstrap.min.js"></script>

<!-- Bootstrap 3.3.5 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/knob/jquery.knob.js"></script>
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>

<script src="plugins/chartjs/Chart.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/admin_graph.php" type='text/javascript'></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>
$("#phone_no").keyup(function(){
 	$.post('process/stream_feed.php',{phone:$(this).val()},function(data){
		$('.feedback').html(data);
		
	}) 

	
})
$(".feedback").click(function(){
	$(".feedback").html("");
	
})

</script>
</body>
</html>
