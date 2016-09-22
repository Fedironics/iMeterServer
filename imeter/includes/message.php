<?php
class Message extends DatabaseTable{
    public static $tableName='messages';
    public $errors=array();
    public static function send($name='',$message='', $email='',$phone='',$admin='',$subject=''){
        if(!empty($name) && !empty($message)){
      $envelope= new Message();
      $envelope->message=$message;
      $envelope->email=$email;
      $envelope->phone=$phone;
      $envelope->title=$subject;
      $envelope->name=$name;
      $envelope->admin_id=$admin;
      return $envelope;
            
        }
    else {
        global $session;
        $session->message("Your Name is required along with the message");
        return false; 
    }
        }
        public function reciever(){
            return User::find_by_id($this->admin_id);
        }

        public static function find_by_id($id) {
            global $database;
            $result=parent::find_by_id($id);
            $update=$database->query("UPDATE ".static::$tableName ." SET seen=1 WHERE id=".$id);
            return $result;
            
        }
    
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

