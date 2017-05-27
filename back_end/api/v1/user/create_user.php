<?php
/**
 * Created by PhpStorm.
 * User: 34613
 * Date: 2017/5/14
 * Time: 9:46
 * Des: 创建用户
 */

//检查当前用户是否有管理权限组的权限
if (!$GLOBALS['permission']->has_permission('system_user')) error_handler(48001);

//检查参数是否缺失
if (!array_key_exists('role_id', $_POST) ||
    !array_key_exists('username', $_POST) ||
    !array_key_exists('password', $_POST) ||
    !array_key_exists('tel', $_POST)
) error_handler(44001);

$role_id = $_POST['role_id'];
$username = $_POST['username'];
$password = md5($_POST['password']);
$tel = $_POST['tel'];
$state = array_key_exists('state', $_POST) ? $_POST['state'] : false;

//检查role_id对应的权限组是否存在
if (!count($GLOBALS['sql']->query("SELECT id FROM role WHERE id='$role_id'"))) error_handler(46008);

//检查用户名是否重复
if (count($GLOBALS['sql']->query("SELECT id FROM users WHERE username='$username'"))) error_handler(46003);

$GLOBALS['sql']->exec("INSERT INTO users (username, password, role_id, tel, state) VALUES ('$username','$password', $role_id, '$tel', false)");
$new_user = $GLOBALS['sql']->query("SELECT id, username, role_id, tel, state FROM users WHERE username='$username'")[0];
print_r(json_encode(array(
    'new_user' => $new_user
)));
exit();