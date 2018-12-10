<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Response {

    public static $result = array(
        'result_code' => 0,
        'time' => 0,
        'data' => array(),
        'error' => array()
    );
    public static $status_header = 200;

    public static function sendResponse() {

        $CI = & get_instance();
        if ($CI->router->class != "C_console") {
            self::$result['time'] = date("Y-m-d H:i:s");
            self::$result['executionTime'] = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
            $CI->output
                    ->set_status_header(self::$status_header)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode(self::camelizeJsonIndex(self::$result)))
                    ->_display();
            exit;
        }
    }

    /**
     * Camelize Json Index
     * @param array $json_array
     * @return array
     */
    public static function camelizeJsonIndex($json_array) {
        if (is_array($json_array) > 0) {
            foreach ($json_array as $key => $value) {
                if (is_object($value)) {
                    $value = get_object_vars($value);
                }
                if (is_array($value)) {
                    $value = self::camelizeJsonIndex($value);
                }
                $new_key = '';
                foreach (explode('_', $key) as $i => $v) {
                    $new_key .= $i == 0 ? $v : ucfirst($v);
                }
                unset($json_array[$key]);
                $json_array[$new_key] = $value;
            }
        }

        return $json_array;
    }

}
