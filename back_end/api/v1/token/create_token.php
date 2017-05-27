<?php
/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/5/11
 * Time: 17:27
 * Des: 以帐号密码方式新建token
 */


// 用戶名或密碼缺失
if (!array_key_exists('admin_name', $_POST) ||
    !array_key_exists('admin_password', $_POST))
    error_handler(40036);

$admin_name = trim($_POST['admin_name']);
$admin_password = trim($_POST['admin_password']);

//用戶名或密碼不合法
if (!preg_match('/^[0-9a-zA-Z]{4,15}$/', $admin_name) ||
    !preg_match('/^[0-9a-zA-Z]{4,15}$/', $admin_password))
    error_handler(40035);

$has_username = $GLOBALS['sql']->query("SELECT admin_name FROM crm_admin WHERE admin_name='$admin_name';");

//    用户名错误或无此用户
if (!$has_username) error_handler(46004);

$admin_password = md5(addslashes(trim($_POST['admin_password'])));
$sql_password = $GLOBALS['sql']->query("SELECT admin_password FROM crm_admin WHERE admin_name='$admin_name';");

//    密码错误
if ($sql_password[0]['admin_password'] !== $admin_password) error_handler(46005);

//    为用户创建新token
$admin_token = $GLOBALS['jwt']->create_token($admin_name);
$GLOBALS['sql']->exec("UPDATE crm_admin SET admin_token='$admin_token', admin_token_exp=" . (time() + EXP) . " WHERE admin_name='$admin_name';");
print_r(json_encode(array('admin_token' => $admin_token)));
exit();
