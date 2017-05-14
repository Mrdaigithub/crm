<?php
/**
 * Created by PhpStorm.
 * User: 34613
 * Date: 2017/5/14
 * Time: 22:34
 * Des: 更新渠道来源启用状态
 */


//检查当前用户是否有管理权限组的权限
if (!$GLOBALS['permission']->has_permission('edit_info_media')) error_handler(48001);

$media_id = pathinfo(parse_url($_SERVER['REQUEST_URI'])['path'])['basename'];

//判断要操作的渠道来源是否存在
if (!count($GLOBALS['sql']->query("SELECT id FROM media WHERE id='$media_id'"))) error_handler(46004);

parse_str(file_get_contents('php://input'), $req_args);

//检查参数是否缺失
if (!array_key_exists('state', $req_args)) error_handler(44001);

$state = $req_args['state'];

$GLOBALS['sql']->exec("UPDATE media SET state='$state' WHERE id='$media_id'");
$new_media = $GLOBALS['sql']->query("SELECT id, media_name, state FROM media WHERE id='$media_id'")[0];
print_r(json_encode(array(
    'new_media' => $new_media
)));
exit();
