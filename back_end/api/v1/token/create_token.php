<?php
/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/5/11
 * Time: 17:27
 * Des: 以帐号密码方式新建token
 */

// 用戶名或密碼缺失
if (!array_key_exists('username', $_POST) ||
    !array_key_exists('password', $_POST))
    error_handler(40036);

$username = trim($_POST['username']);
$password = trim($_POST['password']);

//用戶名或密碼不合法
if (!preg_match('/^[0-9a-zA-Z]{4,15}$/', $username) ||
    !preg_match('/^[0-9a-zA-Z]{4,15}$/', $password))
    error_handler(40035);

$has_username = $GLOBALS['sql']->query("SELECT username FROM users WHERE username='" . $username . "';");

//    用户名错误或无此用户
if (!$has_username) error_handler(46004);

$password = md5(addslashes(trim($_POST['password'])));
$sql_password = $GLOBALS['sql']->query("SELECT password FROM users WHERE username='" . $username . "';");

//    密码错误
if ($sql_password[0]['password'] !== $password)
    error_handler(46005);

//    为用户创建新token
$token = $GLOBALS['jwt']->create_token($username);
$GLOBALS['sql']->exec("UPDATE users SET token='" . $token . "', exp=" . (time() + EXP) . " WHERE username='" . $username . "';");
print_r(json_encode(array('token' => $token)));
exit();