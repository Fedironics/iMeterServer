<?php
//this page is where the user is going to see when he logs into his imeter account 
require_once("includes/initialize.php");
$toscript='userenergy.php';
if(!isset($userid)){
if(!isset($admin_id)){
  	header("Location:login.php");
}
else {
   if(!isset($_GET['user'])){
	header("Location:admin.php");	
	} else {
	$userid=$_GET['user'];
  $get_id=$database->query("SELECT id FROM user_informations WHERE meter_no='$userid'");
  $id=fetch_as_array($get_id)[0];
      $profile=  User::find_by_id($id);
      $meter_no=$profile->meter_no;
$toscript="userenergy.php?user=$id";

	}
}
}
else {
	
$meter_no=eselect($userid,'meter_no');
}
require_once("includes/header.php");
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php 
	echo	eselect($userid,'customer_name');		?>
        <small>Energy Profile</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<div id='info'></div>
	<?php 
   echo     $session->show_messages();
	?>
	

      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-pencil"></i></span>
 
            <div class="info-box-content">
              <span class="info-box-text">Today's Useage<br/><small>per budget</small></span>
<?php
//that today really means yesterday
//this is a simple maths to realise if someone is using his energy too fast
//first we get the users meter no

//then we get the energy budget the person has set.
$e_budget=last_budget($meter_no);
//to get the optimal budget we divide by the monthly budget
$optimal_daily=(($e_budget/$month_days)/$price);
//then we get the meters useage for the last 24hrs
$observed_daily=av_daily_energy($meter_no,'day');
//no conversion is required as it is in days
//so the percentage energy used is :
//$optimal_daily=check_zero($optimal_daily);
if($optimal_daily!=0){
$useage=round($observed_daily*100/$optimal_daily);
}
else {
    $useage=0;
}
echo "<span class=\"info-box-number\">$useage<small>%</small></span>";

?>



            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-calendar-times-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Average Daily Spend</span>
			  <?php
			  
  $observed_monthly=av_daily_energy($meter_no,'month');
  $r_observed_monthly=round($observed_monthly*$price);
  echo " <span class=\"info-box-number\">$r_observed_monthly<small>Naira</small></span>";
			  ?>
			  
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>
		
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Energy Bal</span>
			  <?php 
			  $bal=$mysqli->query("SELECT energy_balance FROM meter_informations WHERE meter_no='$meter_no' ORDER BY id DESC LIMIT 1");
if($bal->num_rows){			 
			 while($row=$bal->fetch_array()){
				 $e_balance=$row['energy_balance']; 
				  
			  }
echo "<span class=\"info-box-number\">{$e_balance}Naira</span>";  
}else {
	$e_balance=0;
}
			  ?>
			  
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-hourglass-2 "></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Daily Useage</span>
			  <?php
			  $o_useage=round($observed_daily);
			  echo "<span class=\"info-box-number\">$o_useage<small>KwH</small></span>";
			  ?>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
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
                <div class="btn-group">
                  <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <p class="text-center">
                    <strong>Energy Consumed(kwh) Against time(hours)</strong>
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
                    <span class="progress-text">Approximate Days Remaining</span>
					<?php 
//we get how much the user loaded last
$observed_monthly=check_zero($observed_monthly);
$daily_spend=$observed_monthly*$price;
$days_rem=round($e_balance/$daily_spend);
$p_days=round(($e_balance/$daily_spend*100)/$month_days);
					//first we get the amount of kilowatts of energy available for the user from his balance
	echo "<span class=\"progress-number\"><b>$days_rem</b>/$month_days</span>";				
					
	echo "<div class=\"progress sm\">
                      <div class=\"progress-bar progress-bar-aqua\" style=\"width: {$p_days}%\"></div>";				
					?>
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
                    <h5 class="description-header"><?php echo  $observed_monthly*$month_days.'KwH'; ?></h5>
                    <span class="description-text">MONTHLY USAGE</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                   <div class="description-block border-right">
                    <h5 class="description-header"><?php 
					$mcost=$observed_daily*$month_days*$price;
					echo 'N'.$mcost ;
					
					?></h5>
                    <span class="description-text">MONTHLY USEAGE COST</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                     <h5 class="description-header"><?php echo $observed_monthly. 'KwH'; ?></h5>
                    <span class="description-text">AVERAGE DAILY USEAGE</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block">
                    <h5 class="description-header"><?php echo 'N'.money_consumed($meter_no,'day'); ?></h5>
                    <span class="description-text">DAILY COST</span>
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
        <!-- /.col -->
      </div>
      <!-- /.row -->
<?php 
if(!isset($_GET['user'])){
echo "  
  <div class=\"row\">
	<form name='budge_form' method='post' action='process/set_budget.php' >
        <div class=\"col-xs-12\">
          <div class=\"box box-primary\">
            <div class=\"box-header\">
              <h3 class=\"box-title\">Set Energy Budget</h3>
            </div>
            <!-- /.box-header -->
            <div class=\"box-body\">
              <div class=\"row margin\">
                <div class=\"col-sm-6\">
                  <input id=\"range_5\" type=\"text\" name=\"e_budget\" value=\"\" >
                </div>
                <div class=\"col-sm-6\">
                  <input id=\"range_6\" type=\"text\" name=\"range_6\" value=\"\">
                </div>
              </div>
			  <div class=\"box-footer\">
                <button type=\"submit\" class=\"btn btn-primary\">Submit</button>
              </div>
           
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
		</form>
        <!-- /.col -->
      </div>
	  <div class=\"row\">
 <div class=\"col-xs-12\">
          <div class=\"box box-primary\">
		  
      	  <form name=\"topup\" action=\"process/smart_connect.php\" method=\"post\">
            <div class=\"box-header\">
              <h3 class=\"box-title\" id=\"smart\">Smart Disconnect  <img src=\"images/toggle_off.png\" id=\"toggle_img\" style=\"width:34%;float:right;display:block\"></h3>
            </div>
            <!-- /.box-header -->
         
			    <div class=\"box-footer\">
                <button type=\"submit\" id=\"toggle_conn\" class=\"btn btn-primary\">Submit</button>
              </div>
           
		  </form>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>    

   </div>
         <!-- Main row -->
      <div class=\"row\">
        <!-- Left col -->
        <div class=\"col-md-8\">
          <!-- MAP & BOX PANE -->
          <!-- TABLE: LATEST ORDERS -->
		  <form name='topup' action='process/topup.php' method='post' >
              <h3 class=\"box-title\">Insert Topup Code </h3>
              <div class=\"input-group\">
                <div class=\"input-group-btn\">
                  <button type=\"submit\" class=\"btn btn-danger\">SEND</button>
                </div>
                <!-- /btn-group -->
                <input type=\"text\" name='topup_code' class=\"form-control\">
              </div>
			  <br/>
		  </form>
		 </div> 
		  
	  <!-- 
		  <form name='topup' action='payment.php' method='post' >
              <h3 class=\"box-title\">Pay For Power </h3>
		       <div class=\"input-group\"> 
			   <div class=\"input-group-btn\">
                  <button type=\"submit\" class=\"btn btn-danger\">PAY</button>
                </div>
                <span class=\"input-group-addon\">N</span>
                <input type=\"text\" name='amount' class=\"form-control\">
                <span class=\"input-group-addon\">.00</span>
              </div>
			  
			  <br/>
		  </form>
	
		    -->
		  "; }
		  
		  ?>
		  
		  
  <div class="row">
         <div class="col-md-4">
          <!-- Info Boxes Style 2 -->
      
          <!-- /.info-box -->
        
          <!-- /.info-box -->
        
          <!-- /.info-box -->

          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Energy Usage</h3>

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
                  <div class="chart-responsive">
                    <canvas id="pieChart" height="150"></canvas>
                  </div>
                  <!-- ./chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <ul class="chart-legend clearfix">
                    <li><i class="fa fa-circle-o text-red"></i> Early Morning</li>
                    <li><i class="fa fa-circle-o text-green"></i> Morning</li>
                    <li><i class="fa fa-circle-o text-yellow"></i> Afternoon</li>
                    <li><i class="fa fa-circle-o text-aqua"></i> Night</li>
                  </ul>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              <ul class="nav nav-pills nav-stacked">
			  <?php

				
			    $get_last_date=$mysqli->query("SELECT dater from meter_informations WHERE  meter_no='$meter_no' LIMIT 1 ");
if($get_last_date->num_rows>0){  while($last_date=$get_last_date->fetch_array()){
	  $date_string=$last_date['dater'];
}}
else {
	$date_string=date('Y-m-d H-i-s',time());
}
  		$get_total=$mysqli->query("SELECT energy_consumed FROM meter_informations WHERE dater='$date_string' AND meter_no='$meter_no'");
$energy_total=0;
		while($totals=$get_total->fetch_array()){
		$energy_total=$energy_total+$totals['energy_consumed'];	
		}
 $energy_total= check_zero($energy_total);
  $pie_get_night=$mysqli->query("SELECT energy_consumed FROM meter_informations WHERE dater='$date_string' AND meter_no='$meter_no' AND hour<='6'");
$night_cons=0; 
 while($line=$pie_get_night->fetch_array()){
	$night_cons=$night_cons+$line['energy_consumed'];  
 
 ;
  }
   $night_cons=round($night_cons/$energy_total*100);
    $pie_get_morn=$mysqli->query("SELECT energy_consumed FROM meter_informations WHERE dater='$date_string' AND meter_no='$meter_no' AND hour BETWEEN 7 AND 12  ");
$morn_cons=0; 
 while($line=$pie_get_morn->fetch_array()){
	$morn_cons=$morn_cons+$line['energy_consumed'];  
	 
	  
  }
   $morn_cons=round($morn_cons/$energy_total*100);
    $pie_get_aft=$mysqli->query("SELECT energy_consumed FROM meter_informations WHERE dater='$date_string' AND meter_no='$meter_no' AND hour BETWEEN 13 AND 18  ");
$aft_cons=0; 
 while($line=$pie_get_aft->fetch_array()){
	$aft_cons=$aft_cons+$line['energy_consumed'];  
	  
  }
  
	 $aft_cons=round($aft_cons/$energy_total*100) ;
    $pie_get_eve=$mysqli->query("SELECT energy_consumed FROM meter_informations WHERE dater='$date_string' AND meter_no='$meter_no' AND hour >18  ");
$eve_cons=0; 
 while($line=$pie_get_eve->fetch_array()){
	$eve_cons=$eve_cons+$line['energy_consumed']; 
	  
  }
  
	$eve_cons=round($eve_cons/$energy_total*100);  

echo "

                <li><a> Early Morning
                  <span class=\"pull-right text-red\"> $night_cons%</span></a></li>
				   <li><a> Morning
                  <span class=\"pull-right text-green\">$morn_cons%</span></a></li>
                <li><a> Afternoon<span class=\"pull-right text-yellow\"> $aft_cons%</span>
                </a></li>
                <li><a>Night
                  <span class=\"pull-right text-aqua\"> $eve_cons%</span></a></li>
";


	
	?>
              </ul>
            </div>
            <!-- /.footer -->
          </div>
          <!-- /.box -->

          <!-- PRODUCT LIST -->
</div>
        <!-- /.col -->

          <div class="box box-info pull-right">
            <div class="box-header with-border">
              <h3 class="box-title">Event History </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Order ID</th>
                    <th>Item</th>
                    <th>Status</th>
                    <th>Time</th>
                  </tr>
                  </thead>
                  <tbody>
				<?php 
				$user_q=$mysqli->query(" SELECT * FROM user_queries WHERE meter_no='$meter_no' ORDER BY id DESC LIMIT 20");
				while($row=$user_q->fetch_array()){
					$id=$row['id'];
					$type=$row['query_code'];
					$status=$row['done'];
					$strtime=$row['time_requested'];
					$time_obj=strtotime($strtime);
					$timestr=humanTiming($time_obj).' ago';
						
					if($type=='1'){
						//when the user sets an energy budget
						$budget=$row['energy_budget'];
						echo "  <tr>
                    <td>$id</td>
                    <td>Set Energy Budget as N$budget</td>";
   if($status=='1'){
	 echo " <td><span class=\"label label-success\">Done</span></td>
                  ";				  
   }                
    else {
		
		echo " <td><span class=\"label label-warning\">Pending</span></td>
                  ";
	}    

	echo "<td>$timestr</td>";
	echo "   </tr>";
					}
					if($type=='2'){
						//when the user recharges a topup code
						$amount=$row['amount_paid'];
						echo "  <tr>
                    <td>$id</td>
                    <td>Recharge of N$amount into the meter by topupcode</td>";
   if($status=='1'){
	 echo " <td><span class=\"label label-success\">Done</span></td>
                  ";				  
   }                
    else {
		
		echo " <td><span class=\"label label-warning\">Pending</span></td>
                  ";
	}       
	echo "<td>$timestr</td>";
	echo "   </tr>";
					}		
									if($type=='3'){
										
						$on_off=$row['payment_method'];
							if($on_off=='1'){
								$dd='Connected';
							}else {
									$dd='Disconnected';	
							}
						$desc="Your Power Supply Was $dd";
						
						//when the user connects or disconnects his power
						$amount=$row['amount_paid'];
						echo "  <tr>
                    <td>$id</td>
                    <td>$desc</td>";
   if($status=='1'){
	 echo " <td><span class=\"label label-success\">Done</span></td>
                  ";				  
   }                
    else {
		
		echo " <td><span class=\"label label-warning\">Pending</span></td>
                  ";
	}       
	echo "<td>$timestr</td>";
	echo "   </tr>";
					}	
				}
				
				?>  
				  

                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
           <?php
//when the history filter finally needs its own page
/* <div class="box-footer clearfix">
/* <div class="box-footer clearfix">
              <a href="javascript::;" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
              <a href="javascript::;" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
            </div>*/		   
		   ?>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

 		</div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.3.2
    </div>
    <strong>Copyright &copy; 2014-2015 <a href="http://imeter.com">Fedironics Institute Of Research</a>.</strong> All rights
    reserved.
  </footer>

 <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- Ion Slider -->
<script src="plugins/ionslider/ion.rangeSlider.min.js"></script>
<!-- Bootstrap slider -->
<script src="plugins/bootstrap-slider/bootstrap-slider.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="plugins/chartjs/Chart.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<?php 
echo "
<script src=\"dist/js/pages/$toscript\" type='text/javascript'></script>";


?>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<script>





    /* ION SLIDER */
var rate =<?php echo $price; ?> ;
$('document').ready(function(){
	
	
if(!"e_conn" in localStorage){
 e_conn='1';
localStorage.setItem('e_conn',e_conn);
}
e_conn=localStorage.getItem("e_conn");
if(e_conn=='1'){
$('#toggle_img').attr('src','images/toggle_on.png');
}else {
$('#toggle_img').attr('src','images/toggle_off.png');

}
$("#toggle_img").click(function(){
if(e_conn=='1'){
e_conn='0';
$('#toggle_img').attr('src','images/toggle_off.png');
}else {
e_conn='1';
$('#toggle_img').attr('src','images/toggle_on.png');

}})
	
	
	$('#toggle_conn').click(function(){
localStorage.setItem('e_conn',e_conn);
$.post('process/smart_connect.php',{status:e_conn},function(data){
var mssg="<div class='alert alert-info alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button> <h4><i class='icon fa fa-info'></i>Smart Connect Alert!</h4>"+data+".</div>";

$('#info').append(mssg);
})
return false;
})
	
	
	
   $("#range_5").ionRangeSlider({
      min: 1000,
      max: 10000,
      type: 'single',
      step: 25,	  
      from: 5000,
      postfix: " Naira",
      prettify: false,
      hasGrid: true ,
	 onChange:function(data){
		 var where=data.from/rate;
		 kwh.update({from:where})
	 }
    });
var	naira = $("#range_5").data("ionRangeSlider");

    $("#range_6").ionRangeSlider({
      min: 62.5,
      max: 625,
      from: 0,
      type: 'single',
      step: 2.5,
      from: 100,
      postfix: "KwH",
      prettify: false,
      hasGrid: true,
 onChange:function(data){
		 var where=data.from*rate;
		 naira.update({from:where})
	 }
    });
	// 
	var kwh = $("#range_6").data("ionRangeSlider");

	

	//this is to get the energy slide to move


  
     function readURL(input){
	$form=$("#update_image");	 
  
         $.ajax({
          type : "POST",
          url : $form.attr("action"),
          
          xhr : function() {
          myXhr = $.ajaxSettings.xhr();
          if(myXhr.upload){
          myXhr.upload.addEventListener('progress',progressHandlingFunction,false);
          }return myXhr;
          },
          
          beforeSend : function() {
          	show_load();    
            },
          complete : function(){   },
          success : completeHandler = function(data){
		 hide_load();
         location.href="profile.php";
          if(navigator.userAgent.indexOf('Chrome')){
          var catchFile = $(":file").val().replace(/C:\\fakepath\\/i,'');}
          else {
          var catchFile = $(":file").val();}
          
          var writeFile = $(":file");
          },
          error : errorHandler = function() {
          alert ("error occured")
          
          },
           data : formData,
          cache: false,
          contentType : false,
        //  dataType : "text/html",
          processData : false
          },"text/html");
          
   		 
	if(input.files && input.files[0]){
		var reader = new FileReader();
		reader.onload = function(e){
			document.getElementById('photo').src=e.target.result;
		}
		reader.readAsDataURL(input.files[0])
	 }} 

})
</script>
</body>
</html>
