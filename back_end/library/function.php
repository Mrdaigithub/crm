<?php
/**
 * base64url编码
 * @param $data
 * @return string
 */
function base64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

/**
 * base64url解码
 * @param $data
 * @return bool|string
 */
function base64url_decode($data)
{
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

/**
 * 判断数据库是否已有此用户名
 * @param $sqlAllUsername
 * @param $username
 * @return bool
 */
function has_username($sqlAllUsername, $username){
    foreach ($sqlAllUsername as $key){
        if ($key['username'] === $username) return $username;
    }
    return false;
}

/**
 * api错误处理
 * @param $stateCode
 */
function error_handler($stateCode){
    echo json_encode(array('stateCode'=> $stateCode));
    exit();
}