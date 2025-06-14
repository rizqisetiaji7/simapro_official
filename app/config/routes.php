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
$route['default_controller'] = 'welcome/index';
$route['404_override'] = 'error404';
$route['translate_uri_dashes'] = FALSE;

/**
 * GLOBAL ROUTES
 * This routes allow to all user role access
*/
$route['logout'] = 'login/logout';
$route['send_email_verify'] = 'forgot_password/send';
$route['change_password'] = 'forgot_password/change_password';
$route['save_password'] = 'forgot_password/reset_process';



/**
 * DIRECTOR ROUTES
 * Allow only director role access
 */
$route['direktur']          = 'direktur/dashboard/index';
$route['direktur/proyek']   = 'direktur/proyek/index';
$route['direktur/riwayat']  = 'direktur/riwayat/index';
$route['direktur/arsip']    = 'direktur/arsip/index';


/**
 * PROJECT MANAGER ROUTES
 * Allow only Project Manajer role access
 */ 
$route['pm']                  = 'pm/dashboard/index';
$route['pm/arsip']            = 'pm/arsip/index';
$route['pm/arsip/detail']     = 'pm/arsip/detail';
$route['pm/riwayat']          = 'pm/riwayat/index';


/**
 * PROJECT MANAGER ROUTES
 * Allow Project Manajer & Director role access
 */ 
$route['chat']          = 'chat/set_chat_data';
$route['chatbox']       = 'chat/index';