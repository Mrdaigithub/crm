<?php
/**
 * Created by PhpStorm.
 * User: 34613
 * Date: 2017/5/14
 * Time: 19:11
 * Des: 删除指定渠道来源
 */



//检查当前用户是否有管理权限组的权限
if (!$GLOBALS['permission']->has_permission('rm_info_media')) error_handler(48001);

$media_id = pathinfo(parse_url($_SERVER['REQUEST_URI'])['path'])['basename'];
$GLOBALS['sql']->exec("DELETE FROM media WHERE id='$media_id'");
exit();
