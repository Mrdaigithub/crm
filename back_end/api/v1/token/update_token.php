<?php
/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/5/11
 * Time: 21:22
 * Des: token 过期更换
 */

parse_str(file_get_contents('php://input'), $req_args);

//    缺少token参数
if (!array_key_exists('token', $req_args)) error_handler(41001);

$old_token = $req_args['token'];
$username = $GLOBALS['sql']->query("SELECT username FROM users WHERE token='" . $old_token . "';");

//    无效的token
if (!$username) error_handler(40014);
$username = $username[0]['username'];

//    为用户创建新token
$token = $GLOBALS['jwt']->create_token($username);
$GLOBALS['sql']->exec("UPDATE users SET token='" . $token . "', exp=" . (time() + EXP) . " WHERE username='" . $username . "';");
print_r(json_encode(array('token' => $token)));
exit();