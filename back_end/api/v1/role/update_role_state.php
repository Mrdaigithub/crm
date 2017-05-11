<?php
/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/5/11
 * Time: 23:16
 * Des: 更新权限组启用状态
 */


parse_str(file_get_contents('php://input'), $req_args);
if (!array_key_exists('role_name',$req_args) || !array_key_exists('state',$req_args)) error_handler(44001);
$sql->exec("UPDATE role SET state=".$req_args['state']." WHERE role_name='".$req_args['role_name']."'");
exit();