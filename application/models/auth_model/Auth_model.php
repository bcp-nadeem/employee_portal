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
    
}
?>