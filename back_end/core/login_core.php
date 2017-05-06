<?php

//error_reporting(0);
//ob_start();
@header('Access-Control-Allow-Origin:*');
@header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Connection, User-Agent, Cookie');
@header("Access-Control-Allow-Methods: GET, POST,HEAD, PATCH,PUT, DELETE");
//@header("Content-type: text/json");

define("ROOT", str_replace("\\", "/", dirname(dirname(__FILE__)))."/");

include ROOT."/config/config.php";
include ROOT."/library/function.php";
include ROOT."/class/class_mysql.php";
include ROOT."/class/class_jwt.php";
include ROOT."/class/class_permission.php";
include ROOT."/class/class_user_info.php";

$sql = new class_mysql();
$jwt = new class_jwt();