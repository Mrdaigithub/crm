<?php
/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/5/11
 * Time: 21:22
 * Des: token 过期更换
 */

//    缺少token参数
if (!array_key_exists('Authorization', apache_request_headers())) error_handler(41001);

$authorization = apache_request_headers();
$authorization = $authorization['Authorization'];
$old_token = preg_replace('/^Bearer\s/', '', $authorization);

$username = $GLOBALS['sql']->query("SELECT admin_name FROM crm_admin WHERE admin_token='$old_token';");
//    无效的token
if (!$username) error_handler(40014);
$username = $username[0]['admin_name'];

//    为用户创建新token
$token = $GLOBALS['jwt']->create_token($username);
$GLOBALS['sql']->exec("UPDATE crm_admin SET admin_token='$token', admin_token_exp=" . (time() + EXP) . " WHERE admin_name='$username'");
print_r(json_encode(array('admin_token' => $token)));
exit();
