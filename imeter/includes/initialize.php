<?php
defined('DS')?null:define('DS', DIRECTORY_SEPARATOR);
$siroo=$_SERVER['DOCUMENT_ROOT'].DS.'imeter';
if($_SERVER['HTTP_HOST']=='imeter.fedironics.com')$siroo=$_SERVER['DOCUMENT_ROOT'];
defined('SITE_ROOT')?null: define('SITE_ROOT',$siroo);
require_once SITE_ROOT.DS."includes".DS.'config.php';
require_once SITE_ROOT.DS."includes".DS.'connect.php';
require_once SITE_ROOT.DS."includes".DS.'mysqldatabase.php';
require_once SITE_ROOT.DS."includes".DS.'databasetable.php';
require_once SITE_ROOT.DS."includes".DS.'functions.php';
require_once SITE_ROOT.DS."includes".DS.'user.php';
require_once SITE_ROOT.DS."includes".DS.'admin.php';
require_once SITE_ROOT.DS."includes".DS.'item.php';
require_once SITE_ROOT.DS."includes".DS.'misc.php';
require_once SITE_ROOT.DS."includes".DS.'message.php';
require_once SITE_ROOT.DS."includes".DS.'object.php';
require_once SITE_ROOT.DS."includes".DS.'content.php';
require_once SITE_ROOT.DS."includes".DS.'comment.php';
require_once SITE_ROOT.DS."includes".DS.'image.php';
require_once SITE_ROOT.DS."includes".DS.'blog.php';
require_once SITE_ROOT.DS."includes".DS.'category.php';
require_once SITE_ROOT.DS."includes".DS.'classes.php';
require_once SITE_ROOT.DS."includes".DS.'pagination.php';
require_once SITE_ROOT.DS."includes".DS.'session.php';
require_once SITE_ROOT.DS."includes".DS.'handler.php'; 
require_once SITE_ROOT.DS."includes".DS.'response.php';


