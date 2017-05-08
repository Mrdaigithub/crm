<?php
/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/4/14
 * Time: 15:27
 */

include '../../../core/core.php';
if ($user_info->username !== 'root') error_handler(48001);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    print_r(json_encode($sql->query("SELECT u.id, u.username, u.state, r.role_name FROM users u, role r WHERE u.role_id=r.id;")));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents('php://input'), $req_args);
    if (!array_key_exists('username', $req_args)) error_handler(44001);
    $sql->exec("DELETE FROM users WHERE username='" . $req_args['username'] . "'");
    exit();
}

error_handler(43001);
