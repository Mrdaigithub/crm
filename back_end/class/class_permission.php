<?php

/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/4/25
 * Time: 8:48
 */
class class_permission
{
    public $role_permission = null;

    function __construct($username)
    {
        $this->role_permission = $GLOBALS['user_info']->role_permission;
    }

    function has_permission($permission_name)
    {
        $p_sub = $GLOBALS['sql']->query("SELECT permission_id FROM permission WHERE permission_name='$permission_name'");
        $p_sub = $p_sub[0]['permission_id'] - 1;
        return $this->role_permission[$p_sub] === '1' ? true : false;
    }
}