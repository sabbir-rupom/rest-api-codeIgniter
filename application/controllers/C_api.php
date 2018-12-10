<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @property M_Api $m_api
 */
class C_api extends MY_Controller {

    public $is_hookable = TRUE;

    function __construct() {
//        echo 1; exit;
        parent::__construct();
        $this->load->model('m_api');
        $this->load->helper('jwt_token');
    }

    public function index() {
        throw new Api_Exception(Result_code::ACCESS_FORBIDDEN, 'Forbidden');
    }

    public function get_data() {
        $this->loginRequired = FALSE;

        $this->_filter();
        
        $data['report'] = $this->m_api->getTestData();
        
        if (empty($data)) {
            throw new Api_Exception(Result_code::DATA_NOT_FOUND, 'Data not found in Database');
        }

        Response::$result['data'] = $data;
    }
    
    public function store_data() {
        $this->loginRequired = FALSE;

        $this->_filter();
        
        $data['report'] = $this->m_api->getTestData();
        
        if (empty($data)) {
            throw new Api_Exception(Result_code::DATA_NOT_FOUND, 'Data not found in Database');
        }

        Response::$result['data'] = $data;
    }

}
