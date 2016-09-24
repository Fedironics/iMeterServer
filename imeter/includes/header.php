<!DOCTYPE html>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php 
	if(isset($admin_id)){
		echo "iMeter Admin";
		
	}else {
		echo "iMeter Energy";
	}
	
	?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons.min.css">
 
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
      <span class="logo-mini"><b>i</b>Mt</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>i</b>Meter</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
       <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <?php 
		if(isset($userid))
		{
			
			
	 if(isset($admin_id)){
		$id=getadminid($admin_id);
		if(file_exists("images/admins/$id.jpg")){
echo " <img src=\"images/admins/thumbs/$id.jpg\"  class=\"user-image\" alt=\"Admin Image\">
		";
		} else {
			echo "";
		}
		}
		else {
				$id=$userid;
				if(file_exists("images/imeters/$id.jpg")){
		
	echo " <img src=\"images/imeters/thumbs/$id.jpg\"  class=\"user-image\" alt=\"User Image\">
		";	
		}else {
			echo "";
			
		}
		}}
		 else{
		$id=getadminid($admin_id);
		if(file_exists("images/admins/$id.jpg")){
echo " <img src=\"images/admins/$id.jpg\"  class=\"user-image\" alt=\"Admin Image\">
		";
		} else {
			echo "";
		}
		}	
		?>
              <span class="hidden-xs"><?php 
		  
		  
		  if(isset($admin_id)){
			echo adselect($admin_id,'name');  
			  
		  }
		  else{echo eselect($userid,'customer_name');}
		  ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
			  <?php 
		if(isset($userid))
		{
			
			
	 if(isset($admin_id)){
		$id=getadminid($admin_id);
		if(file_exists("images/admins/$id.jpg")){
echo " <img src=\"images/admins/$id.jpg\" id='photo' onclick=\"$('#select_file').click()\" class=\"img-circle\" alt=\"Admin Image\">
		";
		} else {
			echo "<button id='photo' onclick=\"$('#select_file').click()\" >change pix </button>";
		}
		}
		else {
				$id=$userid;
				if(file_exists("images/imeters/$id.jpg")){
		
	echo " <img src=\"images/imeters/$id.jpg\" id='photo' onclick=\"$('#select_file').click()\" class=\"img-circle\" alt=\"User Image\">
		";	
		}else {
			echo "<button onclick=\"$('#select_file').click()\" >change pix </button>";
			
		}
		}}
		 else{
		$id=getadminid($admin_id);
		if(file_exists("images/admins/$id.jpg")){
echo " <img src=\"images/admins/$id.jpg\" id='photo' onclick=\"$('#select_file').click()\" class=\"img-circle\" alt=\"Admin Image\">
		";
		} else {
			echo "<button id='photo' onclick=\"$('#select_file').click()\" >change pix </button>";
		}
		}	
		?>
			  
            
                <p>
                 <?php 
		  
		  
		  if(isset($admin_id)){
			echo $name= adselect($admin_id,'name');  
			  
		  }
		  else{echo  $name= eselect($userid,'customer_name');}
		  ?>
                  <small>Member since Nov. 2012</small>
                </p>
              </li>
              <!-- Menu Body -->
			  <?php 
			  if(isset($userid)){
				    $phone= eselect($userid,'phone');
					  $email= eselect($userid,'email');
					    $userids= eselect($userid,'userid');
				  echo "
				         <li class=\"user-body\">
                <div class=\"row\">
           <form class=\"form-horizontal\" action='process/edit_user.php' method='post'>
                  <div class=\"form-group\">
                    <label for=\"inputName\" class=\"col-sm-2 control-label\">Name</label>

                    <div class=\"col-sm-10\">
                      <input type=\"name\" class=\"form-control\" name='name' placeholder=\"Name\" value='$name'>
                    </div>
                  </div>
                  <div class=\"form-group\">
                    <label for=\"inputEmail\" class=\"col-sm-2 control-label\">Email</label>

                    <div class=\"col-sm-10\">
                      <input type=\"email\" class=\"form-control\" name='email'  placeholder=\"Email\" value='$email'>
                    </div>
                  </div>
				    <div class=\"form-group\">
                    <label for=\"inputEmail\" class=\"col-sm-2 control-label\">Phone</label>

                    <div class=\"col-sm-10\">
                      <input type=\"phone\" class=\"form-control\" name='phone'  placeholder=\"08012345678\" value='$phone'>
                    </div>
                  </div>
                  <div class=\"form-group\">
                    <label for=\"inputName\" class=\"col-sm-2 control-label\">Userid</label>

                    <div class=\"col-sm-10\">
                      <input type=\"text\" class=\"form-control\" name='userid'  placeholder=\"johnsmith\" value='$userids'>
                    </div>
                  </div>
                  <div class=\"form-group\">
                    <label for=\"inputExperience\" class=\"col-sm-2 control-label\">Password</label>

                    <div class=\"col-sm-10\">
                      <input type=\"password\" class=\"form-control\" name='password' placeholder=\"password\">
                    </div>
                  </div>
                  <div class=\"form-group\">
                    <label for=\"inputSkills\" class=\"col-sm-2 control-label\">Confirm</label>

                    <div class=\"col-sm-10\">
                      <input type=\"text\" class=\"form-control\" name='password1'  placeholder=\"password\">
                    </div>
                  </div>
                 
                  <div class=\"form-group\">
                    <div class=\"col-sm-offset-2 col-sm-10\">
                      <button type=\"submit\" class=\"btn btn-danger\">Submit Changes</button>
                    </div>
                  </div>
                </form>
     
                </div>
                <!-- /.row -->
              </li>
       
				  
				  ";
				  
				  
			  }
			  ?>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
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
		$id=getadminid($admin_id);
		if(file_exists("images/admins/thumbs/$id.jpg")){
echo " <img src=\"images/admins/thumbs/$id.jpg\" id='photo' onclick=\"$('#select_file').click()\" class=\"img-circle\" alt=\"Admin Image\">
		";
		} else {
			echo "<button id='photo' onclick=\"$('#select_file').click()\" >change pix </button>";
		}
		}
		else {
				$id=$userid;
				if(file_exists("images/imeters/thumbs/$id.jpg")){
		
	echo " <img src=\"images/imeters/thumbs/$id.jpg\" id='photo' onclick=\"$('#select_file').click()\" class=\"img-circle\" alt=\"User Image\">
		";	
		}else {
			echo "<button onclick=\"$('#select_file').click()\" >change pix </button>";
			
		}
		}}
		 else{
		$id=getadminid($admin_id);
		if(file_exists("images/admins/thumbs/$id.jpg")){
echo " <img src=\"images/admins/thumbs/$id.jpg\" id='photo' onclick=\"$('#select_file').click()\" class=\"img-circle\" alt=\"Admin Image\">
		";
		} else {
			echo "<button id='photo' onclick=\"$('#select_file').click()\" >change pix </button>";
		}
		}	
		?>
           <br/>
        </div>
        <div class="pull-left info">
          <p><?php 
		  
		  
		  if(isset($admin_id)){
			echo adselect($admin_id,'name');  
			  
		  }
		  else{echo eselect($userid,'customer_name');}
		  ?></p>
          <a href="#"><form name='image_form' style='display:none' id='update_image' method='post' enctype='multipart/form-data' action='process/picture_upload.php'> <input onchange="$('#update_image').submit()" type='file' id='select_file' name='ppix' value='select image' /><input type='submit' /></form></a>
   </div>
      </div>
      <!-- search form 
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
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
            <i class=\"fa fa-th\"></i> <span>Logout</span>
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
