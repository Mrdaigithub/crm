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
 * @param $sql_all_username
 * @param $username
 * @return bool
 */
function has_username($sql_all_username, $username)
{
    foreach ($sql_all_username as $key) {
        if ($key['username'] === $username) return $username;
    }
    return false;
}

/**
 * api错误返回码
 * @param $state_code
 */
function error_handler($state_code)
{
    echo json_encode(array('state_code' => $state_code));
    exit();
}
