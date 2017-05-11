<?php
/**
 * Created by PhpStorm.
 * User: 34613
 * Date: 2017/5/11
 * Time: 23:22
 * Des: 更新权限组名称
 */

parse_str(file_get_contents('php://input'), $req_args);
if (!array_key_exists('new_role_name',$req_args) || !array_key_exists('old_role_name',$req_args)) error_handler(44001);
$sql->exec("UPDATE role SET role_name='".$req_args['new_role_name']."' WHERE role_name='".$req_args['old_role_name']."'");
exit();
