<?php

/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 17/04/08
 * Time: 8:19
 */
class class_jwt
{

    /**
     * 创建用户token
     * @param $username
     * @param string $sub
     * @return string
     */
    function create_token($username, $sub = 'jwt')
    {
        $headers = json_encode(array("typ" => "JWT", "alg" => "HS256"));
        $claims = json_encode(array(
            "iss" => $username,
            "sub" => $sub,
            "exp" => time() + EXP
        ));
        $content = base64url_encode($headers) . '.' . base64url_encode($claims);
        $signature = hash_hmac('sha256', $content, SECRET_KEY);
        $token = $content . '.' . base64url_encode($signature);
        return $token;
    }

    /**
     * 校验token
     * @param $token
     * @return bool
     */
    function verifyToken($token)
    {
        $res = $GLOBALS['sql']->query("SELECT exp FROM users WHERE token='" . $token . "';");
        if (!$res) error_handler(40014); //无效的token
        if ($res[0]['exp'] <= time()) error_handler(42001); //token超时
        return true;
    }
}
