<?php

require_once 'jwt/autoload.php';

use \Firebase\JWT\JWT;

function verify_token($token = '', $key = '') {
    $result = array('error' => 0, 'data' => array());
    if ($token == '') {
        $result['error'] = 5;
        return $result;
    }

    try {
        $decoded = JWT::decode($token, $key, array('HS256'));
        JWT::$leeway = 600; // $leeway in seconds
        
    } catch (\Exception $e) { // Also tried JwtException
        $result['error'] = 1;
        return $result;
    }
    
    $result['data'] = $decoded;

    return $result;
}
