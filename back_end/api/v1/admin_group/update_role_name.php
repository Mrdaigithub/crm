<?php
/**
 * Created by PhpStorm.
 * User: 34613
 * Date: 2017/5/11
 * Time: 23:22
 * Des: 更新权限组名称
 */

//检查当前用户是否有管理权限组的权限
if (!$GLOBALS['permission']->has_permission('system_role')) error_handler(48001);

parse_str(file_get_contents('php://input'), $req_args);
$role_id = pathinfo(parse_url($_SERVER['REQUEST_URI'])['path'])['basename'];

//判断要操作的权限组是否存在
if (!count($GLOBALS['sql']->query("SELECT role_id FROM roles WHERE role_id='$role_id'"))) error_handler(46008);

//判断role_name参数是否存在
if (!array_key_exists('new_role_name', $req_args)) error_handler(44001);

//判断权限组名称是否已存在
$new_role_name = $req_args['new_role_name'];
if (count($GLOBALS['sql']->query("SELECT role_id FROM roles WHERE role_name='$new_role_name'"))) error_handler(46009);

$GLOBALS['sql']->exec("UPDATE roles SET role_name='".$req_args['new_role_name']."' WHERE role_id='$role_id'");
$role = $GLOBALS['sql']->query("SELECT role_id, role_name, role_permission, role_state, role_must FROM roles WHERE role_id='$role_id'");
print_r(json_encode($role[0]));
exit();
