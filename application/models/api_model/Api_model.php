<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }


    // API

    public function get_employees_record_api()
    {
        $query = $this->db->get("employee_table");
        return $query->result();
    }

    public function get_employee_record_api($id)
    {
        $query = $this->db->select('*')
        ->from('employee_table')
        ->where('main_employee_id', $id)
        ->get();
        return $query->result();
    }


}
?>


