<?php
class Category extends DatabaseTable {
    public static $tableName='categories';
    public $default_image='pages/images/services/service-1.jpg';
    public function image_path(){
        
   $item=     Item::find_by_sql("SELECT * FROM items WHERE category_id=". $this->id." LIMIT 1");
  if(!empty($item)){
      
      $item=  array_shift($item);
   return    $item->image_path();
    }
 else {
        return $this->default_image;    
    }
    }
    
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

