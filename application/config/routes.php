<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'dashboard';
$route['404_override'] = 'security/goto404';
$route['translate_uri_dashes'] = FALSE;

$route['user-profile/:any'] = 'user/user_profile';
$route['update-profile'] = 'user/update_profile';
$route['update-profile/avatar'] = 'user/update_avatar';
$route['update-password'] = 'security/update_password';
$route['update-password/post'] = 'security/update_password_submit';

$route['setting/application'] = 'application';
$route['setting/users'] = 'user';
$route['setting/user/list'] = 'user/user_list';
$route['setting/user/post'] = 'user/user_save';
$route['setting/user/lock'] = 'user/user_lock';
$route['setting/user/remove/:num'] = 'user/user_delete';

$route['setting/roles'] = 'role';
$route['setting/role/list'] = 'role/role_data';
$route['setting/role/access'] = 'role/role_access';
$route['setting/role/access/:num'] = 'role/role_access';
$route['setting/role/lock'] = 'role/role_lock';
$route['setting/role/remove/:num'] = 'role/role_delete';
$route['setting/role/save'] = 'role/role_save';

$route['popti'] = 'thalassaemia/popti';
$route['popti/add'] = 'thalassaemia/popti/add';
$route['popti/:num/edit'] = 'thalassaemia/popti/edit';
$route['popti/:num'] = 'thalassaemia/popti/details';
$route['popti/units/:num'] = 'thalassaemia/popti/units';
$route['popti/activate'] = 'thalassaemia/popti/activate';
$route['popti/remove'] = 'thalassaemia/popti/delete';
$route['popti/post'] = 'thalassaemia/popti/submit';

$route['patients'] = 'thalassaemia/patient';
$route['patient/list'] = 'thalassaemia/patient/collections';
$route['patient/add'] = 'thalassaemia/patient/add';
$route['patient/:any'] = 'thalassaemia/patient/detail';
$route['patient/:any/edit'] = 'thalassaemia/patient/edit';
$route['patient/:any/remove'] = 'thalassaemia/patient/delete';
$route['patient/export'] = 'thalassaemia/patient/export';

$route['region/pick-list'] = 'thalassaemia/region/pick_list';
$route['report/patient/export'] = 'thalassaemia/report/export_patient';

$route['screening'] = 'thalassaemia/screening';
$route['screening/list'] = 'thalassaemia/screening/collections';
$route['screening/add'] = 'thalassaemia/screening/add';
$route['screening/:any'] = 'thalassaemia/screening/detail';
$route['screening/:any/edit'] = 'thalassaemia/screening/edit';
$route['screening/:any/remove'] = 'thalassaemia/screening/delete';

$route['login'] = 'security/login';
$route['logout'] = 'security/logout';
