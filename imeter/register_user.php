<?php 
require_once("includes/initialize.php");
if(!isset($admin_id)){
	header("Location:alogin.php");	
}
if(isset($admin_id)){
	if($admin_id==0){
	header("Location:alogin.php");		
	}
	
}
class Form {
public $progress;
public $forms=[];
public $fields=[['name','text','Full Name','user'],['email','email','Email','envelope'],['userid','text','Userid','user'],['password','password','Password','lock'],['password1','password',' Confirm Password','lock'],['meterno','text','Meter No','log-in']];
public $template = '  <div class="form-group has-feedback">
        <input type="email" class="form-control" name="email" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
	';
function __construct()
  {
    $this->progress=empty($_SESSION['register_form'])?[]:$_SESSION['register_form']; 
    $this->create_forms();
  }
public function create_forms()
  {
   $this->forms['name']=[$this->_create_input('name','text','Full Name','user')];
   $this->forms['email']=[$this->_create_input('email','email','Email','envelope')];
   $this->forms['userid']=[$this->_create_input('userid','text','Userid','user')];
   $this->forms['password']=[$this->_create_input('password','password','Password','lock')];
   $this->forms['password1']=[$this->_create_input('password1','password',' Confirm Password','lock')];
   $this->forms['meterno']=[$this->_create_input('meterno','text','Meter No','log-in')];
   $this->forms['state']=[$this->create_select('state','states','id','name',[],'states')];
   $this->forms['localgovt']=[$this->create_select('localgovt','local_govt','id','name',['datastate','state_id'],'localg')];
   $this->forms['address']=[$this->_create_input('address','text','Address','log-in')];
  }
private function _create_input($name='',$type='text',$placeholder='',$icon='')
  {
    global $value;
    $labels=$this->_categorize($name);
    $output=$labels."
        <input type=\"$type\" class=\"form-control\" name=\"$name\" placeholder=\"$placeholder\" value=\"$value\">
        <span class=\"glyphicon glyphicon-$icon form-control-feedback\"></span>
      </div>";
    return $output;
  }
  private function _categorize($name)
  {
    global $value;
    $state='feedback';
    $label=$value='';
    if(!empty($_SESSION['register_form'][$name]))
      {
        $error=$_SESSION['register_form'][$name];
         $state='error';
         if(!empty($error))
          {
          $label="<label class=\"control-label\" for=\"$name\"><i class=\"fa fa-times-circle-o\"></i> $error</label>";
          }

      }
    if(!empty($_SESSION['form_data'][$name]))
      {
        $value=$_SESSION['form_data'][$name];
      }
     $output="<div class=\"form-group has-feedback has-$state\">$label ";
     return $output;
  }
  public function create_select($item,$table,$hvalue='id',$choice='',$additional=[],$attributes=[])
  {
    global $database,$value;
    $labels=$this->_categorize($item);
    $output=$labels."<select name=\"$item\" class=\"form-control\" style=\"width:100%\">";
    $sub=!empty($additional)? true : false;
    $goptions=$database->query("SELECT * FROM $table");
    $options= fetch_full_array($goptions);
    foreach ($options as  $option) 
    {
      $output.= "<option value='".$option[$hvalue]."'";
      if($sub)
      {
        $output.=$additional[0]."=\"".$option[$additional[1]]."\"";
      }
      if($value==$option[$hvalue])
      {
        $output.="selected=\"selected\"";
      }
      $output.= " >".$option[$choice]."</option>";
    }

    $output.='</select></div>';
    return $output;
  }

public function display()
  {
    $i=0;
    $start=empty($_SESSION['form_data'])?0:count($_SESSION['form_data']);
    foreach($this->forms as $form)
    {
      $i++;      
      if($i>=$start)echo $form[0];
      if($i-$start>=4) break;
    }

  }
}
$myForm=new Form();
//pre_format($myForm->forms);
//pre_format($_SESSION['register_form']);
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Registration Page</title>
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
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
  
  <link rel="stylesheet" href="plugins/select2/select2.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="index.php"><b>i</b>Meter</a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Register a new imeter</p>

    <form action="process/registrations.php" method="post">
    <?php
    $myForm->display();
    ?>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> I agree to the <a href="#">terms</a>
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>


    <a href="login.php" class="text-center">I already have a membership</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<!-- Select2 -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="plugins/select2/select2.full.min.js"></script>
<script src="plugins/iCheck/icheck.min.js"></script>
<script>

var options;
$(document).ready(function(){
 var default_text= " <option selected='selected' >--choose a state--</option>";
  options = $("#localg").children();
$("#localg").html(default_text);

lg_content='';

$("#states").change(function(){
//put only the first content
state=$("#states").val();
selected_locals=allocator(state);
$("#localg").html(selected_locals);
$("#localg").removeAttr('disabled');

})

function allocator(state){
var result=new Array();
options.each(function(i){
if($(options[i]).attr('datastate')==state){
  result[i]=options[i];
}

})
return result;
}




    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });


//end ready function
})
 
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();

    //Datemask dd/mm/yyyy
   
  });
</script>

</body>
</html>
