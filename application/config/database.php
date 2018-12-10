<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$host = $username = $password = '';

switch (ENVIRONMENT) {
    case 'development':
        $host = 'localhost';
        $username = 'root';
        $password = '123';
        $database = 'test';
        break;
    case 'testing':
    case 'production':
        $host = 'localhost';
        $username = 'root';
        $password = '123';
        $database = 'test';
        break;

    default:
        break;
}

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => $host,
	'username' => $username,
	'password' => $password,
	'database' => $database,
	'dbdriver' => 'mysqli',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);