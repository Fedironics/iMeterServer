<?php
class Content extends DatabaseTable {
    public static $tableName='contents';
    public static function organise($on_page='',$is_all=false){
        if(!empty($on_page)){
        $page=$on_page;
        }else {
            global $page;
        }
        $sub=' AND fixed=0';
        if($is_all){
            $sub='';
        }
                   $get_content=  static::find_by_sql("SELECT * FROM contents WHERE page='$page'". $sub);
                   return $get_content;
                              }
                             
                              public static function pages(){
                                  global $database;
                                  $result_set=array();
                                  $get_pages=$database->query("SELECT * FROM pages");
                                  while($apage=$get_pages->fetch_array()){
                                   $result_set[]=$apage;
                                         }
                                  return $result_set;
                              }
                              
                              public static function build($title='',$body='',$page=1){
                                  global $session;
    if(!empty($title) ){
        $content= new Content();
        $content->title=$title;
        $content->body=$body;
        $content->page=$page;
        return $content;
              
    }  else {
        $session->message("the title of your new item was empty");        
        return false;   
    }
}
public static function find_by_id($id) {
   $result= parent::find_by_id($id);
   if($result){
    $result->title=  strtoupper($result->title);
    return $result;
}else {
    return false;
}
}

   
   
   }
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

