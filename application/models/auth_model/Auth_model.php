<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {
    
    public function verify_user($email, $password) {
        $this->db->where('employee_email', $email);
        $this->db->where('employee_status', 1);
        $user = $this->db->get('employee_table')->row();

        if ($user && password_verify($password, $user->emp_password)) {
            return $user;
        }
        return false;
    }

    public function get_user_by_email($email) {
        $this->db->where('employee_email', $email);
        $this->db->where('employee_status', 1);
        return $this->db->get('employee_table')->row();
    }

    public function verify_current_password($user_id, $password) {
        $this->db->where('main_employee_id', $user_id);
        $query = $this->db->get('employee_table');
        $user = $query->row();
        
        if ($user) {
            return password_verify($password, $user->emp_password);
        }
        return FALSE;
    }

    public function update_password($user_id, $new_password) {
        $this->db->where('main_employee_id', $user_id);
        $this->db->update('employee_table', array('emp_password' => $new_password));
    }
    
}
?>