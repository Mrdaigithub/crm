<?php
/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/5/11
 * Time: 22:58
 * Des: 删除指定权限组
 */


//检查当前用户是否有管理权限组的权限
if (!$GLOBALS['permission']->has_permission('system_role')) error_handler(48001);

$role_id = pathinfo(parse_url($_SERVER['REQUEST_URI'])['path'])['basename'];
$GLOBALS['sql']->exec("DELETE FROM roles WHERE role_id='$role_id'");
exit();
