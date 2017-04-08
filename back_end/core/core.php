<?php

error_reporting(0);
ob_start();

include '../config/index.php';
include '../library/function.php';
include '../class/class_mysql.php';
include '../class/class_Jwt.php';

$sql = new Mysql();
$jwt = new Jwt();


