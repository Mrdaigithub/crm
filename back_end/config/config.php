<?php

//数据库配置
define('SERVERNAME', 'localhost');
define('DBNAME', 'crm');
define('USERNAME', 'root');
define('PASSWORD', '');

//api用户认

//api用户认证私钥
define('SECRET_KEY', 'guahao_spa' . time());

//token有效时间 (s)
define('EXP', 7200);
