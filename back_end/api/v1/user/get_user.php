<?php
/**
 * Created by PhpStorm.
 * User: 34613
 * Date: 2017/5/13
 * Time: 22:07
 * Des: 获取用户列表
 */


//检查当前用户是否有管理权限组的权限
if (!$GLOBALS['permission']->has_permission('system_user')) error_handler(48001);

print_r(json_encode($GLOBALS['sql']->query("SELECT u.id, u.username, u.state, u.tel, r.role_name FROM users u, role r WHERE u.role_id=r.id;")));
exit();
