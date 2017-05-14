<?php
/**
 * Created by PhpStorm.
 * User: 34613
 * Date: 2017/5/14
 * Time: 18:34
 * Des: 获取渠道来源列表
 */


//检查当前用户是否有管理渠道来源的权限
if (!$GLOBALS['permission']->has_permission('info_media')) error_handler(48001);

$media_list = $GLOBALS['sql']->query("SELECT id, name, state FROM media");
print_r(json_encode(array(
    'media_list' => $media_list
)));
exit();
