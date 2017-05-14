<?php
/**
 * Created by PhpStorm.
 * User: 34613
 * Date: 2017/5/14
 * Time: 18:49
 * Des: 创建渠道来源
 */


//检查当前用户是否有管理权限组的权限
if (!$GLOBALS['permission']->has_permission('add_info_media')) error_handler(48001);

//检查参数是否缺失
if (!array_key_exists('media_name', $_POST)) error_handler(44001);

$media_name = $_POST['media_name'];
$state = array_key_exists('state', $_POST) ? $_POST['state'] : false;

//检查渠道来源名称是否重复
if (count($GLOBALS['sql']->query("SELECT id FROM media WHERE media_name='$media_name'"))) error_handler(46003);

$GLOBALS['sql']->exec("INSERT INTO media (media_name, state) VALUES ('$media_name', '$state')");
$new_media = $GLOBALS['sql']->query("SELECT id, media_name, state FROM media WHERE media_name='$media_name'")[0];
print_r(json_encode(array(
    'new_media' => $new_media
)));
exit();
