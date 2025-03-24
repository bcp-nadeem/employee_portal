<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rbac {
    protected $CI;
    protected $permissions = [];

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('api_model/role_model');
    }

    public function get_user_permissions($user_id) {
        if (empty($this->permissions)) {
            $this->permissions = $this->CI->role_model->get_user_permissions($user_id);
        }
        return $this->permissions;
    }

    public function has_permission($permission_name) {
        return in_array($permission_name, array_column($this->permissions, 'name'));
    }

    public function has_role($role_name) {
        return $this->CI->session->userdata('user_data')['role'] === $role_name;
    }
}
?>