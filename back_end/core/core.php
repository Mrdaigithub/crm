<?php

//error_reporting(0);
//ob_start();
@header('Access-Control-Allow-Origin:http://localhost:8080');
@header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Connection, User-Agent, Cookie');

define("ROOT", str_replace("\\", "/", dirname(dirname(__FILE__)))."/");

include ROOT."/config/config.php";
include ROOT."/library/function.php";
include ROOT."/class/class_mysql.php";
include ROOT."/class/class_Jwt.php";

$sql = new class_mysql();
$jwt = new class_jwt();


