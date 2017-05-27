<?php
/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/5/14
 * Time: 10:48
 * Des: 删除指定用户
 */


//检查当前用户是否有管理权限组的权限
if (!$GLOBALS['permission']->has_permission('system_user')) error_handler(48001);

$user_id = pathinfo(parse_url($_SERVER['REQUEST_URI'])['path'])['basename'];
$GLOBALS['sql']->exec("DELETE FROM users WHERE user_id='$user_id'");
exit();
