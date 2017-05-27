<?php
/**
 * Created by PhpStorm.
 * User: 34613
 * Date: 2017/5/14
 * Time: 10:57
 * Des: 更新指定用户信息
 */


//检查当前用户是否有管理权限组的权限
if (!$GLOBALS['permission']->has_permission('system_user')) error_handler(48001);

$user_id = pathinfo(parse_url($_SERVER['REQUEST_URI'])['path'])['basename'];

//判断要操作的用户是否存在
if (!count($GLOBALS['sql']->query("SELECT id FROM users WHERE id='$user_id'"))) error_handler(46004);

parse_str(file_get_contents('php://input'), $req_args);

//检查参数是否缺失
if (!array_key_exists('role_id', $req_args) ||
    !array_key_exists('username', $req_args) ||
    !array_key_exists('tel', $req_args)
) error_handler(44001);

$role_id = $req_args['role_id'];
$username = $req_args['username'];
$password = array_key_exists('password', $req_args) ?
    md5($req_args['password']) :
    $GLOBALS['sql']->query("SELECT password FROM users WHERE id='$user_id'")[0]['password'];
$tel = $req_args['tel'];
$state = array_key_exists('state', $req_args) ? $req_args['state'] : false;

//判断选择的权限组是否存在
if (!count($GLOBALS['sql']->query("SELECT id FROM role WHERE id='$role_id'"))) error_handler(46008);

//检查用户名是否重复
if (count($GLOBALS['sql']->query("SELECT id FROM users WHERE username='$username'"))) error_handler(46003);

$GLOBALS['sql']->exec("UPDATE users SET role_id='$role_id', username='$username', password='$password', tel='$tel', state='$state' WHERE id='$user_id'");
$new_user = $GLOBALS['sql']->query("SELECT id, username, role_id, tel, state FROM users WHERE id='$user_id'")[0];
print_r(json_encode(array(
    'new_user' => $new_user
)));
