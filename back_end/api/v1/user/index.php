<?php
/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/4/14
 * Time: 15:27
 */

include '../../../core/core.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    if (!$_GET['token']) error_handler(44001);
    print_r($sql->query("SELECT username FROM admin WHERE username='" . $username    . "';"));
}
error_handler(43001);