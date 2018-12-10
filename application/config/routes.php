<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'C_api';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['get_user'] = "GetUser";

$route['show-data'] = "C_api/get_data";
$route['console'] = "C_console/index";
$route['store-data'] = "C_api/store_data";