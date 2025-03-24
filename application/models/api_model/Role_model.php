<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model {
    
    public function get_user_permissions($user_id) {
        $this->db->select('p.name, p.description');
        $this->db->from('roles_permissions rp');
        $this->db->join('permissions p', 'p.id = rp.permission_id');
        $this->db->join('user_roles ur', 'ur.role_id = rp.role_id');
        $this->db->where('ur.user_id', $user_id);
        return $this->db->get()->result_array();
    }

    public function assign_role($user_id, $role_id) {
        return $this->db->insert('user_roles', [
            'user_id' => $user_id,
            'role_id' => $role_id
        ]);
    }
}
?>