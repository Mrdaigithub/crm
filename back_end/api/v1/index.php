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
$router->addRoute('POST', '/api/v1/token/', ROOT . "api/v1/token/create_token.php");
$router->addRoute('PUT', '/api/v1/token/', ROOT . "api/v1/token/update_token.php");

////获取当前用户信息
//$user_info = new class_user_info();
//$permission = new class_permission($user_info->username);
//
////menu
//$router->addRoute('GET', '/api/v1/menu/', ROOT . "api/v1/menu/get_menu.php");
//
////admin_group
//$router->addRoute('GET', '/api/v1/roles/', ROOT . "api/v1/admin_group/get_roles.php");
//$router->addRoute('POST', '/api/v1/roles/', ROOT . "api/v1/admin_group/create_role.php");
//$router->addRoute('DELETE', '/api/v1/roles/\d+/', ROOT . "api/v1/admin_group/remove_role.php");
//$router->addRoute('PATCH', '/api/v1/roles/state/\d+/', ROOT . "api/v1/admin_group/update_role_state.php");
//$router->addRoute('PATCH', '/api/v1/roles/name/\d+/', ROOT . "api/v1/admin_group/update_role_name.php");
//
////permission
//$router->addRoute('GET', '/api/v1/permission/\d+/', ROOT . "api/v1/permission/get_permission.php");
//$router->addRoute('PUT', '/api/v1/permission/\d+/', ROOT . "api/v1/permission/update_permission.php");
//
////admin
//$router->addRoute('GET', '/api/v1/users/', ROOT . "api/v1/admin/get_user.php");
//$router->addRoute('POST', '/api/v1/users/', ROOT . "api/v1/admin/create_user.php");
//$router->addRoute('DELETE', '/api/v1/users/\d+/', ROOT . "api/v1/admin/remove_user.php");
//$router->addRoute('PUT', '/api/v1/users/\d+/', ROOT . "api/v1/admin/update_user.php");
//$router->addRoute('PATCH', '/api/v1/users/state/\d+/', ROOT . "api/v1/admin/update_user_state.php");
//
////media
//$router->addRoute('GET', '/api/v1/media/', ROOT . "api/v1/media/get_media.php");
//$router->addRoute('POST', '/api/v1/media/', ROOT . "api/v1/media/create_media.php");
//$router->addRoute('DELETE', '/api/v1/media/\d+/', ROOT . "api/v1/media/remove_media.php");
//$router->addRoute('PATCH', '/api/v1/media/name/\d+/', ROOT . "api/v1/media/update_media_name.php");
//$router->addRoute('PATCH', '/api/v1/media/state/\d+/', ROOT . "api/v1/media/update_media_state.php");
//
//http_response_code(404);