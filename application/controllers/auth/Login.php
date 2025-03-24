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

    public function forgotUserPassword() {
        $this->load->view('include/header');
        $this->load->view('auth/forgot-password');
        $this->load->view('include/footer');
    }

    public function sentForgotUserPassword(){
        $email_id = $this->input->post('email_id');
        $user = $this->auth_model->get_user_by_email($email_id);
        if ($user) {

            $this->load->library('email');

            $email = $user->employee_email;
            $employee_fname = $user->employee_first_name;
            $employee_lname = $user->employee_last_name;
            $employee_id = $user->main_employee_id;
            $token = rand();

            $from_email = "bimcaphk@gmail.com";
            $to_email = $email;
            $from_email = "bimcaphk@gmail.com";
            $to_email = $email;
            $emailContent = 'Hello, '.$employee_fname.'  '.$employee_lname.' To reset your BIMCAP Employee Portal password, please click this link: '.base_url().'auth/Login/updateForgotPassword/'.$token;

            $config['protocol'] = 'smtp';
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'ssl://smtp.googlemail.com';
            $config['smtp_port'] = 465;
            $config['smtp_user'] = 'bimcaphk@gmail.com';
            $config['smtp_pass'] = 'zvxr isum jmvx wboa';
            $config['smtp_timeout'] = '7';
            $config['charset']    = 'iso-8859-1';
            $config['newline']    = "\r\n";
            $config['mailtype'] = 'text'; // or html
            $config['validation'] = FALSE; // bool whether to validate email or not 

            $this->email->initialize($config);
 
            $this->email->from($from_email, 'BIMCAP');
            $this->email->to($to_email);
            $this->email->subject('Employee password reset');
            $this->email->message($emailContent);

            if($this->email->send()){
                $this->session->set_userdata('forgot_token', $token);
                $this->session->set_userdata('employee_id', $employee_id);
                $this->session->set_flashdata('success', 'Please check you outlook inbox.');
                redirect('forgot-password');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong. Please try again!!');
                redirect('forgot-password');
            }
        } else {
            $this->session->set_flashdata('emp_email_error', 'Your email is incorrect');
            redirect('forgot-password');
        }
    }

    public function updateForgotPassword($token){
        if($token == $this->session->userdata('forgot_token')){
            $this->load->view('include/header');
            $this->load->view('auth/update-forgot-password');
            $this->load->view('include/footer');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong. Please try again!!');
            redirect('forgot-password');
        }
    }

    public function submitForgotPassword(){
        $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[8]');
        $this->form_validation->set_rules('repeat_password', 'Repeat Password','required|matches[new_password]');
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('new_password_error', form_error('new_password'));
            $this->session->set_flashdata('repeat_password_error', form_error('repeat_password'));
            redirect('auth/Login/updateForgotPassword/'.$this->session->userdata('forgot_token'));
        }else{

            $new_password = $this->input->post('new_password');
            $employee_id = $this->session->userdata('employee_id');
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $data = array(
                'emp_password' => $hashed_password,
            );
            $this->db->where('main_employee_id', $employee_id);
            $this->db->update('employee_table', $data);
            $this->session->unset_userdata('forgot_token');
            $this->session->unset_userdata('employee_id');
            $this->session->set_flashdata('success', 'Password updated successfully.');
            redirect('auth/login');

        }
    }

}
?>