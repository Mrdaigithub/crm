<?php
/**
 * Created by PhpStorm.
 * User: 34613
 * Date: 2017/5/14
 * Time: 11:45
 * Des: 更新用户启用状态
 */


//检查当前用户是否有管理权限组的权限
if (!$GLOBALS['permission']->has_permission('system_user')) error_handler(48001);

$user_id = pathinfo(parse_url($_SERVER['REQUEST_URI'])['path'])['basename'];

//判断要操作的用户是否存在
if (!count($GLOBALS['sql']->query("SELECT user_id FROM users WHERE user_id='$user_id'"))) error_handler(46004);

parse_str(file_get_contents('php://input'), $req_args);

//state参数是否缺失
if (!array_key_exists('state', $req_args)) error_handler(44001);

$state = $req_args['state'];

$GLOBALS['sql']->exec("UPDATE users SET user_state=s$statetate WHERE id='$user_id'");
$new_user = $GLOBALS['sql']->query("SELECT id, username, role_iteltel, user_state FROM users WHERE id='$user_id'")[0];
print_r(json_encode(array(
    'new_user' => $new_user
)));

exit();










