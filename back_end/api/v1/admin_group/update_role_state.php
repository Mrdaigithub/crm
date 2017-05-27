<?php
/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/5/11
 * Time: 23:16
 * Des: 更新权限组启用状态
 */

//检查当前用户是否有管理权限组的权限
if (!$GLOBALS['permission']->has_permission('system_role')) error_handler(48001);

parse_str(file_get_contents('php://input'), $req_args);
$role_id = pathinfo(parse_url($_SERVER['REQUEST_URI'])['path'])['basename'];

//判断要操作的权限组是否存在
if (!count($GLOBALS['sql']->query("SELECT role_id FROM roles WHERE role_id='$role_id'"))) error_handler(46008);

//判断state参数是否存在
if (!array_key_exists('role_state',$req_args)) error_handler(44001);

$GLOBALS['sql']->exec("UPDATE roles SET role_state=".$req_args['role_state']." WHERE role_id='$role_id'");
$role = $GLOBALS['sql']->query("SELECT role_id, role_name, role_permission, role_state, role_must FROM roles WHERE role_id='$role_id'");
print_r(json_encode($role[0]));
exit();
