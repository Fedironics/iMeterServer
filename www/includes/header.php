<!DOCTYPE html>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
   <!-- Ion Slider -->
  <link rel="stylesheet" href="plugins/ionslider/ion.rangeSlider.css">
  <!-- ion slider Nice -->
  <link rel="stylesheet" href="plugins/ionslider/ion.rangeSlider.skinNice.css">
  <!-- bootstrap slider -->
  <link rel="stylesheet" href="plugins/bootstrap-slider/slider.css">


  <!-- jvectormap -->
  <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  
  
  
  
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="<?php 
	if(isset($admin_id)){
		echo "admin.php";
		
	}else {
		echo "energy_profile.php";
	}
	
	?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>I</b>Meter</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
      </div>

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
		<?php 
		if(isset($userid))
		{
			
			
	 if(isset($admin_id)){
		$id=adselect($admin_id,'id');
		
echo " <img src=\"images/admin/thumbs/$id.jpg\" id='photo' class=\"img-circle\" alt=\"User Image\">
		";
		
		}
		else {
			$id=$userid;
	echo " <img src=\"images/imeters/thumbs/$id.jpg\" id='photo' class=\"img-circle\" alt=\"User Image\">
		";	
		}
		}
		
		?>
           <br/>
        </div>
        <div class="pull-left info">
          <p><?php 
		  
		  
		  if(isset($userid)){echo eselect($userid,'customer_name');}
		  if(isset($admin_id)){
			echo adselect($admin_id,'name');  
			  
		  }
		  ?></p>
          <a href="#"><form name='image_form' id='update_image' method='post' enctype='multipart/form-data' action='process/picture_upload.php'> <input onchange="readURL(this)" type='file' name='ppix' value='select image' /><input type='submit' /></form></a>
   </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
<?php
if(isset($meter_no)){
	
	echo " <li>
          <a href=\"energy_profile.php\">
            <i class=\"fa fa-th\"></i> <span>Energy Profile</span>
          </a>
        </li>";
				echo "
		<li>
          <a href=\"process/logout.php\">
            <i class=\"fa fa-th\"></i> <span>Logout User</span>
          </a>
        </li>
		";
	
};
if(isset($admin_id)){
	
	echo " <li>
          <a href=\"register_user.php\">
            <i class=\"fa fa-th\"></i> <span>Register Imeter</span>
			<small class=\"label pull-right bg-green\">new</small>
          </a>
        </li>";
		echo" <li>
          <a href=\"admin.php\">
            <i class=\"fa fa-th\"></i> <span>Admin STAts</span>
          </a>
        </li>";
			echo" <li>
          <a href=\"admins.php\">
            <i class=\"fa fa-th\"></i> <span>Imeter Installers</span>
          </a>
        </li>";
			echo" <li>
          <a href=\"users.php\">
            <i class=\"fa fa-th\"></i> <span>Imeter Users</span>
          </a>
        </li>";
		echo "
		<li>
          <a href=\"process/logout.php\">
            <i class=\"fa fa-th\"></i> <span>Logout</span>
          </a>
        </li>
		";
		
	
}
else {
	echo  "
		<li>
          <a href=\"alogin.php\">
            <i class=\"fa fa-th\"></i> <span>Login As Admin</span>
          </a>
        </li>
		";
}


?>       

	  
   </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
