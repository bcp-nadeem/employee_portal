<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('auth_model/Auth_model', 'auth_model');
        $this->load->library(['form_validation', 'session']);
        $this->load->model('employee_model/Employee_model', 'em');  // Make sure this matches the model filename

        if(!$this->session->userdata('logged_in') || $this->session->userdata('user_role') != 1 && $this->session->userdata('user_role') != 2 && $this->session->userdata('user_role') != 3) {
            $this->session->set_flashdata('error', 'Access denied. Admin privileges required.');
            redirect('auth/login');
        }
    }
    
    public function changePassword() {
        $this->load->view('include/header');
        $this->load->view('auth/change-password');
        $this->load->view('include/footer');
    }
    public function changeUserPassword() {

        $user_id = $this->session->userdata('user_id');
        $password = $this->input->post('emp_password');

        $result = $this->auth_model->verify_current_password($user_id, $password);
        
        if ($result) {
            $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[8]');
            $this->form_validation->set_rules('repeat_password', 'Repeat Password', 'required|matches[new_password]');
            if ($this->form_validation->run() == FALSE) {
                
                $this->session->set_flashdata('new_password_error', form_error('new_password'));
                $this->session->set_flashdata('repeat_password_error', form_error('repeat_password'));
                redirect('change-password');
    
            }
            else {
                $user_id = $this->session->userdata('user_id');
                $new_password = $this->input->post('new_password');
                $password = password_hash($new_password , PASSWORD_DEFAULT);
                $this->auth_model->update_password($user_id, $password); 
                $this->session->set_flashdata('success', 'Password updated successfully.');
                redirect('change-password');
            }
        } else {
            $this->session->set_flashdata('emp_password_error', 'The current password is incorrect');
            redirect('change-password');
        }
    }

}
?>