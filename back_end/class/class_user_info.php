<?php

/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/4/25
 * Time: 10:39
 */
class class_user_info
{
    public $token = null;
    public $username = null;
    public $role_permission = null;
    public $role_name = null;

    function __construct()
    {
//        $this->get_token();
//        $this->get_username();
//        $this->get_role_permission();
//        $this->get_role_name();
    }

    /**
     * 获取当前用户的token
     * @return null
     */
    function get_token()
    {
        //    缺少token参数
        if (!array_key_exists('Authorization', apache_request_headers())) error_handler(41001);
        print_r(apache_request_headers());
        $authorization = apache_request_headers();
        $authorization = $authorization['Authorization'];
        $this->token = preg_replace('/^Bearer\s/', '', $authorization);
        $GLOBALS['jwt']->verifyToken($this->token);
        return $this->token;
    }

    /**
     * 获取当前用户的用户名
     * @return mixed
     */
    function get_username()
    {
        if (!$this->token) $this->get_token();
        $this->username = $GLOBALS['sql']->query("SELECT username FROM users WHERE token='$this->token';");
        return $this->username = $this->username[0]['username'];
    }

    /**
     * 获取当前用户的权限值
     * @return mixed
     */
    function get_role_permission()
    {
        if (!$this->username) $this->get_username();
        $this->role_permission = $GLOBALS['sql']->query("SELECT role_permission FROM users JOIN roles ON users.role_id = roles.role_id WHERE users.username = '$this->username'");
        return $this->role_permission = $this->role_permission[0]['role_permission'];
    }

    /**
     * 获取当前用户的权限组名称
     * @return mixed
     */
    function get_role_name()
    {
        if (!$this->username) $this->get_username();
        $this->role_name = $GLOBALS['sql']->query("SELECT role_name FROM users JOIN roles ON users.role_id = roles.role_id WHERE users.username = '$this->username'");
        return $this->role_name = $this->role_name[0]['role_name'];
    }
}
