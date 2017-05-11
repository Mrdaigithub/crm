<?php
/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/5/8
 * Time: 20:54
 */

include '../../../../core/core.php';
if ($user_info->username !== 'root') error_handler(48001);

if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    parse_str(file_get_contents('php://input'), $req_args);
    if (!array_key_exists('username', $req_args) || !array_key_exists('state', $req_args)) error_handler(44001);
    $username = $req_args['username'];
    $state = $req_args['state'];
    $sql->exec("UPDATE users SET state=$state WHERE username='$username'");
    exit();
}

error_handler(43001);
