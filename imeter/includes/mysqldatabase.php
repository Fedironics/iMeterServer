<?php
defined('DS')?null:define('DS', '\\');
require_once SITE_ROOT.DS."includes".DS.'config.php';

class MySqlDatabase {
    public $connection;
    public $magic_quotes_active;
    public $errors=array();
    /**
     * @name class for dealing with mysql
     */
    function __construct() {
        $this->open_connection();
        $this->magic_quotes_active=  get_magic_quotes_gpc();
              
    }
    public function last_id(){
        return $this->connection->insert_id;
        
    }

    public function open_connection()
    {
    /**
     * @method public open_connection(type $paramName) Description open connection is used to open a connection
     */ 
  $this->connection = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD,MYSQL_DATABASE);
   if ($this->connection->connect_errno) {
	  die ( "Failed to connect to Mysql:(" .$this->connection->connect_errno.")". $this->connection->connect_error);
	  
  }
    }
    public function  query($sql){
     //   echo $sql."<br/>"; 
        //' OR id='1
            $result=$this->connection->query($sql);
            $this->_confirm_query($result);
      return $result;
    }
    private function  _confirm_query($result){
           if(!$result){
          die("database query failed ".$this->connection->error);
      }  
    }
 

    public function escape_value($value){
        if($this->magic_quotes_active){
        $value=  stripslashes($value);
        }
        $value=$this->connection->real_escape_string($value);
        return $value;  
    }
}
$database= new MySqlDatabase();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

