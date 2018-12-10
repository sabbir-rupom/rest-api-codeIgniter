<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of ResultCode
 *
 * @author arifulhaque
 */
class Result_code {

    // No error.
    const SUCCESS = 0;
    // unexpected error.
    const UNKNOWN_ERROR = 1;
    // Illegal JSON.
    const INVALID_JSON = 2;
    // Session Broken.
    const SESSION_ERROR = 3;
    // Request hash is invalid.
    const INVALID_REQUEST_HASH = 4;
    // Request parameter is incorrect.
    const INVALID_REQUEST_PARAMETER = 5;
    // User unregistered.
    const USER_NOT_FOUND = 6;
    // Already registered (at the time of user registration).
    const USER_ALREADY_EXISTS = 7;
    //Already connected game center
    const ALREADY_CONNECTED_TO_GAME_CENTER = 8;
    //Already connected to google play
    const ALREADY_CONNECTED_TO_GOOGLE_PLAY = 9;
    //Another user connected to google play
    const ANOTHER_CONNECTED_TO_GOOGLE_PLAY = 10;
    //Forbidden access error
    const ACCESS_FORBIDDEN = 100;

    /* SERVER RELATED */
    //404
    const NOT_FOUND_404 = 404;
    //Owner Not found
    const OWNER_NOT_FOUND = 500;
    // Login blacklist. Not be able to game play.
    const LOGIN_BLACKLIST = 1000;
    const CODE_MESSAGE = array(
        self::SUCCESS => "Success",
        self::UNKNOWN_ERROR => "Unknown error",
        self::INVALID_JSON => "Invalid JSON",
        self::SESSION_ERROR => "Session expired",
        self::INVALID_REQUEST_HASH => "Invalid request hash",
        self::INVALID_REQUEST_PARAMETER => "Invalid request parameter",
        self::USER_NOT_FOUND => "User not found",
        self::USER_ALREADY_EXISTS => "User already exists",
        self::ALREADY_CONNECTED_TO_GAME_CENTER => "Already Connected to game center",
        self::ALREADY_CONNECTED_TO_GOOGLE_PLAY => "Already Connected to google play",
        self::ANOTHER_CONNECTED_TO_GOOGLE_PLAY => "Another User Connected to google play",
        self::NOT_FOUND_404 => "404 not fount",
        self::OWNER_NOT_FOUND => "Owner not found",
        self::LOGIN_BLACKLIST => "Blacklisted user",
        self::ACCESS_FORBIDDEN => "Direct access forbidden",
    );

    /**
     * Get result code title
     * @param int $code
     * @return string Return message title against result code.
     */
    public static function getTitle($code) {
        $message = self::CODE_MESSAGE;
        return $message[$code];
    }

}
