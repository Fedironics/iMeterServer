<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of comment
 *
 * @author EMMA
 */
class Comment extends DatabaseTable {
    protected static $tableName='comments';
    public static function  make($item_id,$author,$body,$email='') {
     if(!empty($item_id) && !empty($author) && !empty($body)){
         $comment= new Comment();
         $comment->item_id=(int)$item_id;
      $comment->name = $author;
      $comment->comment=$body;
      $comment->email=$email;
      return $comment;
         
     }   else {
         return false;
     }
    }
    public static function  find_on($item_id=0){
  global $database;
        $sql= "SELECT * FROM ".static::$tableName ;
        $sql .= " WHERE item_id=". $database->escape_value($item_id);
         return static::find_by_sql($sql);
   }
   public static  function count_comments($item_id){
       global $database;
       $sql= "SELECT COUNT(*) FROM ".static::$tableName . " WHERE item_id=".$item_id ;
   $count=    $database->query($sql);
   $comment_count_array=$count->fetch_array();
    return array_shift($comment_count_array);
   }
    //put your code here
}
