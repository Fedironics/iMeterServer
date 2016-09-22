<?php
defined('DS')?null:define('DS', '\\');
require_once SITE_ROOT.DS."includes".DS.'databasetable.php';

class Misc extends DatabaseTable {
   
    public static $tableName= 'site_data';
    public static function gather(){
        
        $all=  static::find_by_sql("SELECT * FROM site_data");
        $stats=new ValueObject();
        foreach ($all as $object){            
            $title=$object->name;
            $body=$object->statistics;
            $stats->$title=$body;
        }        
    return $stats;
    }
    
}
