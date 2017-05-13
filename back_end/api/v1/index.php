<?php
/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/5/11
 * Time: 14:48
 * Des: API 路由入口文件
 */

include '../../core/core.php';

//token
$router->addRoute('POST','/api/v1/token/',ROOT."api/v1/token/create_token.php");
$router->addRoute('PATCH','/api/v1/token/',ROOT."api/v1/token/update_token.php");

//获取当前用户信息
$user_info = new class_user_info();
$permission = new class_permission($user_info->username);


//menu
$router->addRoute('GET','/api/v1/menu/',ROOT."api/v1/menu/get_menu.php");

//role
$router->addRoute('GET','/api/v1/role/',ROOT."api/v1/role/get_roles.php");
$router->addRoute('POST','/api/v1/role/',ROOT."api/v1/role/create_role.php");
$router->addRoute('DELETE','/api/v1/role/\d+/',ROOT."api/v1/role/remove_role.php");
$router->addRoute('PATCH','/api/v1/role/state/\d+/',ROOT."api/v1/role/update_role_state.php");
$router->addRoute('PATCH','/api/v1/role/name/\d+/',ROOT."api/v1/role/update_role_name.php");

//permission
$router->addRoute('GET','/api/v1/permission/\d+/',ROOT."api/v1/permission/get_permission.php");
$router->addRoute('PUT','/api/v1/permission/\d+/',ROOT."api/v1/permission/update_permission.php");

//user
$router->addRoute('GET','/api/v1/user/',ROOT."api/v1/user/get_user.php");


http_response_code(404);
