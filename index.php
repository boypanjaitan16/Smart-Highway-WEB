<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

require_once ("_php/autoloader.php");
require_once ("_php/dbconnector.php");

$config     = new helper\Configuration();
$login      = new helper\Login($cnc);
$url        = new helper\Url();
$assets     = new helper\Assets("../".$config->getAssetsDir());
$session    = $config->getSessionAdmin();

if(isset($_SESSION[$session])){
    include ("index-in.php");
}
else{
    include ("index-out.php");
}
?>