<?php 
require_once("includes/functions.php");
if(!isset($userid)){
	header("Location:login.php");
}
else {
	//when the user is already logged in
	if(!isset($_GET['amt'])){
	
	header("Location:energy_profile.php");	
	}
	else {
		$pay=$_GET['amt'];
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
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-globe"></i> AdminLTE, Inc.
          <small class="pull-right">Date: 2/10/2014</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong>Admin, Inc.</strong><br>
            Fedironics Facility<br>
            Gariki Cresent, Abuja<br>
            Phone: (804) 123-5432<br>
            Email: autoengine@imeter.com
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong><?php echo eselect($userid,'customer_name'); ?></strong><br>
           <?php 
		   echo eselect($userid,'address');
		   echo "<br/>";
		   echo eselect($userid,'town');
		   echo " ";
		   echo eselect($userid,'state');
		   echo "<br/>";
		   echo 'Phone: '. eselect($userid,'phone');
		   echo "<br/>";
		   echo 'Email: '.eselect($userid,'email');
		
			?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Invoice #007612</b><br>
          <br>
          <b>Order ID:</b> 4F3S8J<br>
          <b>Payment Due:</b> 2/22/2014<br>
          <b>Account:</b> 968-34567
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

  
      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          <p class="lead">Payment Methods:</p>
          <img src="dist/img/credit/visa.png" alt="Visa">
          <img src="dist/img/credit/mastercard.png" alt="Mastercard">
          <img src="dist/img/credit/american-express.png" alt="American Express">
          <img src="dist/img/credit/paypal2.png" alt="Paypal">

          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            Your Payment will be Immediately effected in your meter for your powe consumtion . This method of payment is safe and effective
          </p>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <p class="lead">Amount Due 2/22/2014</p>

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Subtotal:</th>
                <td><?php 
				echo 'N'.$pay;
				?></td>
              </tr>
              <tr>
                <th><?php 
				echo "Tax (".$tax."%)";
				?></th>
                <td><?php $ptax=$tax*$pay/100; echo 'N'.$ptax;          ?></td>
              </tr>
              <tr>
                <th>Service Charge</th>
                <td><?php echo  'N'.$service_charge; ?></td>
              </tr>
              <tr>
                <th>Total:</th>
                <td><?php $tpay=$pay +$ptax+$service_charge; echo 'N'.$tpay ; ?></td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
 </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
