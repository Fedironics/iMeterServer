<?php
defined('DS')?null:define('DS', '\\');
require_once SITE_ROOT.DS."includes".DS.'user.php';

class Admin extends User {
    protected static $db_fields;
    public static $tableName= 'administrators';
      public function login(){
      global $database;
if(!empty($this->token)){
$know_abt=$database->query("INSERT INTO visitors (time,type, visitor_id) VALUES (NOW(),'1','$this->id')");
$_SESSION['imeter_id']= $this->id;
$_SESSION['imeter_token']=  $this->token;

}


  }
}



