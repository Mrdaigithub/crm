<?php
/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/5/11
 * Time: 22:29
 * Des: 新建一个权限组
 */


//检查当前用户是否有管理权限组的权限
if (!$GLOBALS['permission']->has_permission('system_role')) error_handler(48001);

$permission_len = $GLOBALS['sql']->query("SELECT count(permission_id) AS permission_len FROM permission");
$permission_len = $permission_len[0]["permission_len"];
$new_role_permission = str_pad('', $permission_len, '0');

//检查参数是否缺失
if (!array_key_exists('new_role_name', $_POST)) error_handler(44001);

//检查权限组是否已存在
$new_role_name = $_POST['new_role_name'];
if (count($GLOBALS['sql']->query("SELECT role_id FROM roles WHERE role_name='$new_role_name'"))) error_handler(46007);

$GLOBALS['sql']->exec("INSERT INTO roles (role_name, role_permission) VALUES ('" . $_POST['new_role_name'] . "','$new_role_permission')");
$new_role = $GLOBALS['sql']->query("SELECT role_id, role_name, role_permission, role_state, role_must FROM roles WHERE role_name = '$new_role_name'");
print_r(json_encode($new_role[0]));
exit();
