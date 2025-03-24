<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('auth_model/Auth_model', 'auth_model');
        $this->load->library(['form_validation', 'session']);
    }
    public function index(){
        $this->load->view('include/header');
        $this->load->view('auth/index');
        $this->load->view('include/footer');
    }

    public function authenticate() {
        $this->form_validation->set_rules('employee_email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('emp_password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->index();
            return;
        }

        $email = $this->input->post('employee_email');
        $password = $this->input->post('emp_password'); // Fixed typo in password field name

        $user = $this->auth_model->verify_user($email, $password);

        if ($user) {
            $this->_set_user_session($user);
            $this->_redirect_by_level();
        } else {
            $this->session->set_flashdata('error', 'Invalid email or password');
            redirect('auth/login');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    private function _set_user_session($user) {
        $session_data = [
            'user_id' => $user->main_employee_id,
            'email' => $user->employee_email,
            'name' => $user->employee_first_name,
            'designation' => $user->employee_designation,
            'image' => $user->employee_image,
            'user_role' => $user->user_role,
            'logged_in' => TRUE
        ];
        $this->session->set_userdata($session_data);
    }

    private function _redirect_by_level() {
        $level = $this->session->userdata('user_role');

        // echo '<pre>'; print_r($level); echo '</pre>'; exit();
        
        switch($level) {
            case 3: // Admin
                redirect('admin/dashboard');
                break;
            case 2: // Supervisor
                redirect('supervisor/dashboard');
                break;
            case 1: // Employee
                redirect('employee/dashboard');
                break;
            default:
                redirect('auth/login');
        }
    }

}
?>