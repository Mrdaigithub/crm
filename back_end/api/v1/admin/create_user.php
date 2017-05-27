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
    !array_key_exists('user_tel', $_POST)
) error_handler(44001);

$role_id = $_POST['role_id'];
$username = $_POST['username'];
$password = md5($_POST['password']);
$user_tel = $_POST['user_tel'];
$user_state = array_key_exists('user_state', $_POST) ? $_POST['user_state'] : 'false';

//检查role_id对应的权限组是否存在
if (!count($GLOBALS['sql']->query("SELECT role_id FROM roles WHERE role_id='$role_id'"))) error_handler(46008);

//检查用户名是否重复
if (count($GLOBALS['sql']->query("SELECT user_id FROM users WHERE username='$username'"))) error_handler(46003);

$GLOBALS['sql']->exec("INSERT INTO users (username, password, role_id, user_tel, user_state) VALUES ('$username', '$password', $role_id, '$user_tel', $user_state)");
$new_user = $GLOBALS['sql']->query("SELECT user_id, username, user_tel, user_state, role_id FROM users WHERE username='$username'")[0];
print_r(json_encode($new_user));
exit();
