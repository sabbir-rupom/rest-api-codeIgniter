<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @property CI_DB_active_record $db
 * @property CI_DB_query_builder $db
 * @property CI_DB_forge $dbforge
 * @property CI_Config $config
 * @property CI_Loader $load
 * @property CI_Session $session
 */
class MY_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_table_row($table_name, $where) {
        $result = $this->db->where($where)->get($table_name)->result();
        if (!empty($result)) {
            return $result[0];
        } else {
            return '';
        }
    }
    
    public function get_table_row_with_id($table_name, $id) {
        return $this->db->where('id', $id)->get($table_name)->row();
    }

    public function insert_into_table($table_name, $data) {
        $data['created_at'] = CURR_DATETIME;
        $this->db->insert($table_name, $data);
        return $this->db->insert_id();
    }

    public function update_table($table_name, $data, $condition = '') {
        $this->db->where($condition)->update($table_name, $data);
        $updated_status = $this->db->affected_rows();

        if ($updated_status) {
            return true;
        } else {
            return false;
        }
    }
    
    public function update_table_with_id($table_name, $data, $id) {
        $this->db->where('id', $id)->update($table_name, $data);
    }

    public function truncate_table($table) {
        $this->db->truncate($table);
    }

    public function get_table_data($table_name, $filter = '', $limit = 0, $offset = 0, $sort_by = 'id', $sort_order = 'DESC') {
        if (!empty($filter)) {
            $this->db->where($filter);
        }
        if($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->order_by($sort_by, $sort_order)->get($table_name)->result_array();
    }

    public function get_table_filtered_data($table, $filter = '', $limit = 15, $offset = 0, $sort_by = 'id', $sort_order = 'asc') {
        if ($filter != '') {
            $this->db->where($filter);
        }
        $result['data'] = $this->db->limit($limit, $offset)->order_by($sort_by, $sort_order)->get($table)->result();
        if ($filter != '') {
            $this->db->where($filter);
        }
        $result['num_rows'] = $this->db->select('id')->count_all_results($table);
        return $result;
    }

    public function delete_table_row($table_name, $where) {
        $this->db->delete($table_name, $where);
        return $this->db->affected_rows();
    }

    public function get_table_columns($table = '') {
        if ($table != '') {
            $query = $this->db->query('SHOW COLUMNS FROM ' . $table);
            return $query->result();
        }
    }

    public function check_unique($table_name, $where) {
        $total = $this->db->where($where)->count_all_results($table_name);
        return $total;
    }
    
    public function generateToken() {
        $issueTime = time() . '_' . rand(1000,9999);
        return base64_encode($issueTime);
    }
    
    public function getTestData() {
        return array(
            1 => 'Test1',
            2 => 'Test2',
            3 => 'Test3'
        );
    }

}
