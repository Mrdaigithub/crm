<?php

/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 17/04/08
 * Time: 8:19
 */
class Jwt
{
    /**
     * �����û�token
     * @param $username
     * @param string $sub
     * @return string
     */
    function createToken($username, $sub = 'jwt')
    {
        $headers = json_encode(array("typ" => "JWT", "alg" => "HS256"));
        $claims = json_encode(array(
            "iss" => $username,
            "sub" => $sub,
            "exp" => time() + EXP
        ));
        $content = base64url_encode($headers) . '.' . base64url_encode($claims);
        $signature = hash_hmac('sha256', $content, $GLOBALS['secret_key']);
        $token = $content . '.' . base64url_encode($signature);
        return $token;
    }
}
