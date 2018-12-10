<?php

(defined('BASEPATH')) OR exit('Forbidden 403');

/**
 * API Exception
 */
include_once APPPATH . 'hooks/Response.php';

class Api_Exception extends Exception {

    protected $title;

    public function __construct($code = 0, $message = '', $previous = null) { // $title = '', Exception 
        parent::__construct($message, $code, $previous);
    }

    public function SetExceptionHandler() {
        set_exception_handler(array($this, 'HandleExceptions'));
    }

    public function HandleExceptions($e) {
        if ($e instanceof Api_Exception) {
            $code = $e->getCode();
            $result = array(
                'title' => Result_code::getTitle($code),
                'message' => $e->getMessage()
            );
        } else {
            $result = array(
                'title' => Result_code::getTitle($code),
                'message' => $e->getMessage()
            );
        }
        Response::$status_header = 401;
        Response::$result = array(
            'error' => $result,
            'result_code' => $code,
            'time' => time()
        );
        Response::sendResponse();
    }

}
