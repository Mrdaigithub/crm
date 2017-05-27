<?php
/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/5/11
 * Time: 22:16
 * Des: 获取role列表
 */

//检查当前用户是否有管理权限组的权限
if (!$GLOBALS['permission']->has_permission('system_role')) error_handler(48001);

$role_name_list = $GLOBALS['sql']->query("SELECT role_id, role_name, role_state, role_must FROM roles");
print_r(json_encode($role_name_list));
exit();

