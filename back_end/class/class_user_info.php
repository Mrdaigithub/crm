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
        $this->get_token();
        $this->get_username();
        $this->get_role_permission();
        $this->get_role_name();
    }

    /**
     * 获取当前用户的token
     * @return null
     */
    function get_token()
    {
        $http_method = $_SERVER['REQUEST_METHOD'];

        if ($http_method === 'GET') {
            if (!array_key_exists('token', $_GET)) error_handler(41001); //缺少token参数
            $this->token = $_GET['token'];
        } else {
            parse_str(file_get_contents('php://input'), $req_args);
            if (!array_key_exists('token', $req_args)) error_handler(41001); //缺少token参数
            $this->token = $req_args['token'];
        }
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
     * 获取角色权限值
     * @return mixed
     */
    function get_role_permission()
    {
        if (!$this->username) $this->get_username();
        $this->role_permission = $GLOBALS['sql']->query("SELECT permission FROM role WHERE id=(SELECT role_id FROM users WHERE username='$this->username')");
        return $this->role_permission = $this->role_permission[0]['permission'];
    }

    /**
     * 获取角色名
     * @return mixed
     */
    function get_role_name()
    {
        if (!$this->username) $this->get_username();
        $this->role_name = $GLOBALS['sql']->query("SELECT name FROM role WHERE id=(SELECT role_id FROM users WHERE username='$this->username')");
        return $this->role_name = $this->role_name[0]['name'];
    }
}
