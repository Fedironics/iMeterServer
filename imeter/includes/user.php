<?php
defined('DS')?null:define('DS', '\\');
require_once SITE_ROOT.DS."includes".DS.'databasetable.php';

/**
 * Description of User
 *
 * @author EMMA
 */
class User extends DatabaseTable 
{
    protected static $db_fields;
    public static $tableName= 'user_informations';
    public $data;
    public $errors=array();

public static function authenticate($username,$password,$mobile=false)
    {
        global  $database;
        $username=$database->escape_value($username);
        $password=$database->escape_value($password);
        $sql= 'SELECT * FROM ';
        $sql.=static::$tableName. " WHERE userid='$username' AND password='$password'";
       //get the user object from the database with all the table columns as attributes
        $person= static::find_by_sql($sql);
        if(!empty($person))
            {
            $person=  array_shift($person);
            $person->token=  random_string(15);
            $person->login();
            $person->save();
            return $person;
            }
        else 
            {
        return false;
            }
        
    }
    public static function verify($user_id,$token)
    {
      $sql= 'SELECT * FROM ';
      $sql.=static::$tableName. " WHERE id='$user_id' AND token='$token'";
      $person= static::find_by_sql($sql);
      return  !empty($person) ?$person :false ;
    }
    public function login()
    {
    global $database,$session;
    if(!empty($this->token))
        {
        $know_abt=$database->query("INSERT INTO visitors (time,type, visitor_id) VALUES (NOW(),'0','$this->id')");
        $session->login($this);
         }
    }

    public static function create_user($data)
    {
        $_SESSION['form_data']=empty($_SESSION['form_data'])?$data:array_merge($_SESSION['form_data'],$data);
        $user=new User();
        $user->data=$_SESSION['form_data'];
        pre_format($_SESSION['form_data']);
        $user->validate();
    }
  
public function validate()
    {
    $this->_validate('name',array("Length"=>"5"));
    $this->_validate('email',array("Length"=>"5","Email"=>true,"Unique"=>'email'));
    $this->_validate('userid',array("Length"=>"5","Unique"=>'userid'));
    $this->_validate('password',array("Length"=>"5","Equals"=>"password1"));
    $this->_validate('password1',array("Equals"=>"password"));
    $this->_validate('meterno',array("Length"=>"5","Unique"=>'meter_no',"Exists"=>["meter_data",'meter_no']));
    $this->_validate('state',["Exists"=>['states','id']]);
    $this->_validate('localgovt',["Exists"=>['local_govt','id']]);
    $this->_validate('address',array("Length"=>"5","Unique"=>"address"),'_geo_locate');
    $_SESSION['register_form']=$this->errors;
    }
private function _validate($item,$params=array(),$callback='')
    {
    global $database;
    if(empty($this->data[$item]))
        {
        $this->_report_error($item." should not be empty",$item);
        }
    else
        {
        $value=&$this->data[$item];
        $value=trim($value);
        if(!empty($params['Length']))
            {
            $length=$params['Length'];
            if(strlen($value)<$length)
	            {
	            $this->_report_error($item." must be more than ".$length." characters",$item);
	            }
            }
        if(!empty($params['Email']))
            {
            if(!filter_var($value,FILTER_VALIDATE_EMAIL)===true)
                {
                $this->_report_error("invalid Email Format",$item);
                }
            }  
        if(!empty($params['Unique']))
            {
            if(User::count_all("WHERE ".$params['Unique']."='$value'")!=0)
                {
                $this->_report_error($item." Must be Unique",$item);
                }
            }  
            if(!empty($params['Equals']))
            {
            if($value!=$this->data[$params['Equals']])
                {
                $this->_report_error($item."s Must be Equal",$item);
                }
            } 
            if(!empty($params['Exists']))
            {
            if($database->query("SELECT id,".$params['Exists'][1]." FROM ".$params['Exists'][0]." WHERE ".$params['Exists'][1]."='$value'")->num_rows!='1')
                {
                $this->_report_error('That '.$item." Does not exist",$item);
                }
            }
            if(!empty($callback))
            {
            $value=$this->$callback($value);
            }  
        }    
       
    }

private function _geo_locate($address)
    {
    return $address;
    }
private function _report_error($error,$key='')
    {
    if(empty($this->errors[$key]))
        {
        $this->errors[$key]=$error;
        }
    }
private function check($condition,$item)
    {
    $this->_functionize($condition) ? null : $this->_report_error($item." has an invalid format");
    }  
private function _functionize($condition)
    {
    return eval("return ".$condition ." ? true: false ;");
    }


}
  
