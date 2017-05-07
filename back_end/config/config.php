<?php

//数据库配置
define('SERVERNAME', 'localhost');
define('DBNAME', 'crm');
define('USERNAME', 'root');
define('PASSWORD', 'root');

//api用户认

//api用户认证私钥
define('SECRET_KEY', 'crm' . time());

//token有效时间 (s)
define('EXP', 7200);

//病人状态
$PATIENT_STATE = array('0'=>'未到','1'=>'已到','2'=>'流失');