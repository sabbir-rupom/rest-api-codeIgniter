<?php

defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'Table_structures.php';
include_once 'Server_constants.php';

/**
 * Description of my_controller
 * @property CI_DB_active_record $db
 * @property CI_DB_forge $dbforge
 * @property CI_Benchmark $benchmark
 * @property CI_Calendar $calendar
 * @property CI_Cart $cart
 * @property CI_Config $config
 * @property CI_Controller $controller
 * @property CI_Email $email
 * @property CI_Encrypt $encrypt
 * @property CI_Exceptions $exceptions
 * @property CI_Form_validation $form_validation
 * @property CI_Ftp $ftp
 * @property CI_Hooks $hooks
 * @property CI_Image_lib $image_lib
 * @property CI_Input $input
 * @property CI_Language $language
 * @property CI_Loader $load
 * @property CI_Log $log
 * @property CI_Model $model
 * @property CI_Output $output
 * @property CI_Pagination $pagination
 * @property CI_Parser $parser
 * @property CI_Profiler $profiler
 * @property CI_Router $router
 * @property CI_Session $session
 * @property CI_Sha1 $sha1
 * @property CI_Table $table
 * @property CI_Trackback $trackback
 * @property CI_Typography $typography
 * @property CI_Unit_test $unit_test
 * @property CI_Upload $upload
 * @property CI_URI $uri
 * @property CI_User_agent $user_agent
 * @property CI_Validation $validation
 * @property CI_Xmlrpc $xmlrpc
 * @property CI_Xmlrpcs $xmlrpcs
 * @property CI_Zip $zip
 */
include_once APPPATH . 'hooks/Response.php';

class MY_Controller extends CI_Controller implements Table_structures, Server_constants {

    /**
     * Authentication Required
     */
    const LOGIN_REQUIRED = TRUE;
    const SESSION_EXPIRE = 600;

    /*
     * JWT TOKEN VERIFICATION ERRORS
     */
    const HASH_SIGNATURE_VERIFICATION_FAILED = 1;
    const EMPTY_TOKEN = 5;

    /**
     * Maintenance check required(Default)
     */
    const MAINTENANCE_CHECK = TRUE;

    /**
     * Header TOKEN ID Key
     */
    const HEADER_REQUEST_TOKEN_KEY = 'X-SOL-TOKEN';
    const TOKEN_VERIFICATION_KEY = '0123456789';

    protected $requestMethod;
    protected $getParams;
    protected $postParams;
    protected $headers;
    protected $json;
    protected $langID;
    protected $result;
    protected $tokenPayload;
    protected $tokenId = NULL;
    protected $loginRequired = FALSE;
    protected $admin = FALSE;
    protected $ci;

    /**
     * User IF if users send a valid token
     * @var int
     */
    protected $userId = NULL;

    function __construct() {
        parent::__construct();
        $this->ci = &get_instance();
        /*
         * Get all header data-stream
         */
        $this->headers = $this->input->request_headers(TRUE);

        /*
         * Get all query params
         */
        $this->getParams = $this->input->get();

        $this->requestMethod = $this->input->method(TRUE);
        if (in_array($this->requestMethod, array('POST', 'PUT', 'DELETE'))) {
            /*
             * Get all JSON params 
             */
            $data = $this->input->raw_input_stream;
            $this->json = json_decode($data);
            if (!empty($data) && is_null($this->json)) {
                throw new Api_Exception(Result_code::INVALID_JSON, "Invalid JSON: $data");
            } else {
                /*
                 * Get all post params
                 */
                $this->postParams = $this->input->post();
            }
        }

        if (!isset($this->headers[self::HEADER_REQUEST_TOKEN_KEY])) {
            throw new Api_Exception(Result_code::ACCESS_FORBIDDEN, "Unauthorized access is forbidden");
        }

        $this->tokenId = $this->headers[self::HEADER_REQUEST_TOKEN_KEY];

    }

    /**
     * Filter server config and user data
     *
     * @throws Exception
     */
    protected function _filter() {
        //Check Maintenance Status
        //$this->_checkMaintenance();
        
        /*
         * Verify Request Token
         */
        $result = verify_token($this->tokenId, self::TOKEN_VERIFICATION_KEY);
        if ($result['error'] > 0) {
            switch ($result['error']) {
                case static::HASH_SIGNATURE_VERIFICATION_FAILED:
                    throw new Api_Exception(Result_code::INVALID_REQUEST_HASH, 'Signature Verification Error.');
                    break;
                case static::EMPTY_TOKEN:
                    throw new Api_Exception(Result_code::INVALID_REQUEST_HASH, 'Token is empty.');
                    break;
            }
        }
        $this->tokenPayload = $result['data'];
        // Login check.
        if ($this->loginRequired) {
            if (empty($this->tokenPayload->userID)) {
                throw new Api_Exception(Result_code::SESSION_ERROR, 'Token error.');
            }
            $this->userId = (int) $this->tokenPayload->userID;

            $checkUser = $this->m_app->get_table_row_with_id('app_users', $this->userId);
            if (empty($checkUser)) {
                throw new Api_Exception(Result_code::USER_NOT_FOUND, 'User not found');
            } else if (array_key_exists('sessionToken', $this->tokenPayload)) {
//                $this->tokenPayload->sessionToken;
                if (!$this->isLoggedIn($this->tokenPayload->sessionToken)) {
                    throw new Api_Exception(Result_code::SESSION_ERROR, 'Token expired.');
                }

//                $userTime = static::SESSION_EXPIRE + $issueTime;
//                if ($userTime < time()) {
//                } 
            } else {
                throw new Api_Exception(Result_code::SESSION_ERROR, 'Token error.');
            }
        }
    }

    /**
     * Return extract value from the JSON.
     *
     * @param $path JSON Path array to the value contained in. Is acceptable string if the highest layer.
     * @param $type Type of the variable. "int", "bool", "string".
     * @param $required Required.
     * @return Value extracted from JSON.
     */
    protected function getValueFromJSON($path, $type, $required = FALSE) {
        if (empty($this->json)) {
            throw new Api_Exception(Result_code::INVALID_JSON, 'JSON is empty.');
        }
        if (is_string($path)) {
            $path = array(
                $path
            );
        }
        $pathStr = implode("->", $path);
        $var = $this->json;

        while (!empty($path)) {
            $pathElement = array_shift($path);
            $var = isset($var->$pathElement) ? $var->$pathElement : NULL;
        }
        if (TRUE == $required && (is_null($var) || empty($var))) {
            throw new Api_Exception(Result_code::INVALID_REQUEST_PARAMETER, "$pathStr is not set.");
        }
        if (!$this->isValidType($var, $type)) {
            throw new Api_Exception(Result_code::INVALID_REQUEST_PARAMETER, "The type of $pathStr is not valid.");
        }
        return $var;
    }

    /**
     * Return from GET parameters to extract the value.
     *
     * @param $name GET The name of the parameter.
     * @param $type Type of the variable. "int", "bool", "string".
     * @param $required Required. Extracted value from
     * @return GET parameters.
     */
    protected function getValueFromQuery($name, $type, $required = FALSE) {
        if (isset($this->getParams[$name])) {
            $var = $this->getParams[$name];
            if ('string' != $type && '' === $var) {
                $var = NULL;
            }
        } else {
            $var = NULL;
        }
        if (TRUE == $required && is_null($var)) {
            throw new Api_Exception(Result_code::INVALID_REQUEST_PARAMETER, "$name is not set.");
        }
        if (!is_null($var) && !$this->isValidType($var, $type)) {
            throw new Api_Exception(Result_code::INVALID_REQUEST_PARAMETER, "The type of $name is not valid.");
        }
        return $var;
    }

    protected function isInt($var) {
        if (is_int($var)) {
            return true;
        }
        return preg_match("/^[0-9]+$/", $var) > 0;
    }

    /**
     * Check the type of the value.
     *
     * @param $ Value value to validate.
     * @param $ Type expected to type.
     * The time being "int," string "
     * If it is correct type of @return value TRUE, otherwise FALSE. Value returns TRUE unconditionally if it is NULL.
     */
    protected function isValidType($value, $type) {
        $result = FALSE;
        if (is_null($value)) {
            return TRUE;
        } else {
            switch ($type) {
                case 'int':
                    $result = $this->isInt($value);
                    break;
                case 'bool':
                    $result = is_bool($value);
                    break;
                case 'string':
                    $result = is_string($value);
                    break;
                case 'binary':
                    $result = is_binary($value);
                    break;
                default:
                    $result = TRUE;
                    break;
            }
        }
        return $result;
    }

    /**
     * Or is a login state check.
     * A user ID if the login state, returns FALSE if it is not logged in.
     */
    private function isLoggedIn($tokenId = NULL) {
        if ($tokenId) {
            $query = $this->db->select('userid')->get_where('authsessions', array('tokenid' => $tokenId, 'userid' => $this->userId));
            if ($query->num_rows() == 1) {
                return true;
            }
        }
        return false;
    }

    /**
     * Application of state to check whether maintenance mode.
     *
     * @return boolean In the case of maintenance mode, true. Otherwise, false.
     */
    protected function isMaintenance() {


        // In the case of maintenance state
        if (Const_Application::MAINTENANCE_TYPE_NORMAL == Common_Util_ConfigUtil::getInstance()->getMaintenance()) {

            // If it is not in the test user
            if (false == $this->isTestUser()) {
                return true;
            }
            // No RDB connection maintenance
        } else if (Const_Application::MAINTENANCE_TYPE_NONE_RDB_CONNECTION == Common_Util_ConfigUtil::getInstance()->getMaintenance()) {
            return true;
        }
        return false;
    }

    protected function _uploadUserPicture($field = 'picture', $imageName = '') {
        $config = array(
            'allowed_types' => 'jpg|jpeg|gif|png',
            'upload_path' => USER_IMAGE_PATH,
            'encrypt_name' => empty($imageName) ? TRUE : FALSE,
            'overwrite' => empty($imageName) ? FALSE : TRUE,
            'max_size' => 3072
        );
        if (!empty($imageName)) {
            $config['file_name'] = $imageName;
        }
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($field)) {
            $image_data = $this->upload->data();
            return ['file_name' => $image_data['file_name'], 'file_type' => $image_data['file_type']];
        } else {
            Response::$status_header = 400;
            Response::$result = array('error' => array('message' => $this->upload->display_errors(), "title" => "Picture Upload Error"));
            Response::sendResponse();
            exit;
        }
    }

}
