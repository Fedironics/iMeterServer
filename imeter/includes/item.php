<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of item
 *
 * @author EMMA
 */
class Item extends DatabaseTable {
    protected static $tableName='items' ;
    private $tempPath;
    public $name;
    protected $uploadDirectory='images';
    public $errors= array();
    protected $fileType='image';
    protected $image;
    public  $description;
    /**
     *
     * @var <ArrayObject> a list of possible upload errors
     */

    protected $uploadErrors= array(
     UPLOAD_ERR_OK => "No Errors",
       UPLOAD_ERR_INI_SIZE => " File Is Larger Than The Upload Max Size",
        UPLOAD_ERR_FORM_SIZE => "File Is Larger Than Form, Max_Size",
        UPLOAD_ERR_PARTIAL => "The File Upload Didn't Complete",
       UPLOAD_ERR_NO_FILE => "No File Was Uploaded",
        UPLOAD_ERR_NO_TMP_DIR => "This Server Has No Temporary Directory",
        UPLOAD_ERR_CANT_WRITE => "Disk May Be Full Or You Don't Have The Permission To Upload Files",
        UPLOAD_ERR_EXTENSION => "This Type Of File Cannot Be Uploaded"
            );
    
   

            protected function _set_file_name(){
                $this->image=  random_string();
            }

     public function comments(){
         return Comment::find_on($this->id);
     }
     public function count_comments(){
         return Comment::count_comments($this->id);
     }

     public function attatch_file($file) {
                global $session;
        $this->_set_file_name();
                if(!$file || empty($file) || !is_array($file)){
                    $this->errors[]= "No File Was Uploaded";
                    return false;
                }
                elseif ($file['error']!=0) {
                    $this->errors[]=  $this->uploadErrors[$file['error']];
                    return false;
            }
            else {
                $this->tempPath= $file['tmp_name'];
         //       $this->fileName=  basename($file['name']);
                $this->type=$file['type'];
                $this->size=$file['size'];
                $this->extension=  pathinfo($file['name'],PATHINFO_EXTENSION);
                $this->uploader=$session->get_user_id();
                return true;
            }
            }
            public function save() {
 
     if(strlen($this->name)>255){
         $this->errors[]= "The name of an item must be less than 255 characters";
         return false;
     }
      if(!empty($this->errors)){
         return false;
     }
     if(empty($this->image) || empty($this->tempPath)){
         $this->errors[]= "The file location was not available";
         return false;
     }
 $target_path = SITE_ROOT.DS. $this->uploadDirectory.DS.  $this->image. '.'. $this->extension;
if(file_exists($target_path)){
    $this->errors[]= "A file with that name already exists:".$target_path;
    return false;
};
require 'simpleImage/src/abeautifulsite/SimpleImage.php';
$image = new abeautifulsite\SimpleImage($this->tempPath);
$image->fit_to_width(800);
$image->save($target_path);
     //if they are no errors then create a database record
    if(!isset($this->id))
    {
        $this->create();
    }
          else{
        $this->update();
          }  
     
     
}
 
public function image_path(){
    global $domain;
    $this->uploadDirectory=  trim($this->uploadDirectory);
    $this->image=trim($this->image);
    return 'http://'.$domain. $this->uploadDirectory.DS.$this->image.'.'.$this->extension;
}

public static function build($name='',$desc='',$cat_id=0){
    if(!empty($name) ){
        $item= new Item();
        $item->name=$name;
        $item->description=$desc;
        $item->category_id=$cat_id;
        return $item;
              
    }  else {
        return false;   
    }
}
public function category(){
    global $cat_array;
 $cat_id=  $this->category_id;
 $category=  Category::find_by_id($cat_id);
 return $category;
    
}
     }
