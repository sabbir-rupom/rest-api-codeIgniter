<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @property M_Api $m_api
 */
class C_api extends MY_Controller {

    public $is_hookable = TRUE;

    function __construct() {
        parent::__construct();
        $this->load->model('m_api');
        $this->load->helper('jwt_token');
    }

    public function index() {
        throw new Api_Exception(Result_code::ACCESS_FORBIDDEN, 'Forbidden');
    }
}
