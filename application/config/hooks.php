<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$hook['pre_controller'][] = array(
    'class' => 'Api_Exception',
    'function' => 'SetExceptionHandler',
    'filename' => 'Api_Exception.php',
    'filepath' => 'hooks/exception'
);

$hook['post_controller'][] = array(
    'class' => 'Response',
    'function' => 'sendResponse',
    'filename' => 'Response.php',
    'filepath' => 'hooks'
);
