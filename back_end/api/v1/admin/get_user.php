<?php
/**
 * Created by PhpStorm.
 * User: 34613
 * Date: 2017/5/13
 * Time: 22:07
 * Des: 获取用户列表信息
 */


//检查当前用户是否有管理权限组的权限
if (!$GLOBALS['permission']->has_permission('system_user')) error_handler(48001);

print_r(json_encode($GLOBALS['sql']->query("SELECT user_id, username, user_state, user_tel, users.role_id ,roles.role_name FROM users JOIN roles ON users.role_id = roles.role_id")));
exit();
