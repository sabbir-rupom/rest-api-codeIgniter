<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @property M_Api $m_api
 */
class C_console extends MY_Controller {
    
    function __construct() {
        parent::__construct();
    }

    public function index() {
        $api = array(
            0 => array(
                'name' => 'show-data',
                'title' => 'Show Data',
                'post' => '',
                'user_required' => FALSE
            ),
            1 => array(
                'name' => 'store-data',
                'title' => 'Store Data',
                'post' => 'something',
                'user_required' => TRUE
            )
        );
        $data = array(
            'api' => $api,
            'title' => 'Console | API',
            'start_script' => self::SCRIPT,
            'end_script' => self::END_SCRIPT
        );
        $this->load->view('console', $data);
    }

}
