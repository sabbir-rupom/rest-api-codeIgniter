<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @property M_Api $mp
 */
class GetUser extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->loginRequired = FALSE;
    }

    public function index() {
        $this->_filter();
        
        $data['users'] = $this->mp->get_table_data('users', array('first_name <>' => '', 'last_name <>' => ''), 10);
        
        if (empty($data)) {
            throw new Api_Exception(Result_code::NOT_FOUND_404, 'Data not found in Database');
        }

        Response::$result['data'] = $data;
    }

}
