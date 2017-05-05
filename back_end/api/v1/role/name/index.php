<?php
/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/5/5
 * Time: 21:03
 */

include '../../../../core/core.php';
if ($user_info->username !== 'root') error_handler(48001);

if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    parse_str(file_get_contents('php://input'), $req_args);
    if (!array_key_exists('new_role_name',$req_args) || !array_key_exists('old_role_name',$req_args)) error_handler(44001);
    $sql->exec("UPDATE role SET name='".$req_args['new_role_name']."' WHERE name='".$req_args['old_role_name']."'");
    exit();

}

error_handler(43003);