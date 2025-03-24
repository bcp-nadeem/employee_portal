<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
class EM_Controller extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->load->model('employee_model/Employee_model', 'em');  // Make sure this matches the model filename

        if(!$this->session->userdata('logged_in') || $this->session->userdata('user_role') != 1 && $this->session->userdata('user_role') != 2) {
            $this->session->set_flashdata('error', 'Access denied. Admin privileges required.');
            redirect('auth/login');
        }
    }

    function index() {
        $menuControl = $this->session->userdata('user_role');
        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('employee/dashboard');
        $this->load->view('include/scripts');
        $this->load->view('include/footer');
    }

    public function employeeProfile(){
        $menuControl = $this->session->userdata('user_role');
        $id = $this->session->userdata('user_id');
        $data['empdata'] = $this->em->getEmployeeDetails($id);
        $data['countries'] = $this->em->getCountries();
        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('employee/employee-profile', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');
    }

    public function editEmployeeMyProfile(){

        $emp_id = $this->input->post('main_employee_id');
        
        // Image upload configuration
        $config = [
            'upload_path' => './upload',
            'allowed_types' => 'jpg|jpeg|png',
            'max_size' => 800, // 800KB max
            'file_name' => 'proimg_' . time(),
            'maintain_ratio' => TRUE,
            'width' => 225,
            'height' => 225
        ];
    
        $this->load->library('upload', $config);
    
        // Prepare employee data
        $empData = [
            'employee_first_name' => $this->input->post('employee_first_name'),
            'employee_last_name' => $this->input->post('employee_last_name'),
            'employee_number' => $this->input->post('employee_number'),
            'employee_address' => $this->input->post('employee_address'),
            'employee_city' => $this->input->post('employee_city'),
            'employee_country_id' => $this->input->post('employee_country')
        ];
    
        // Handle image upload
        if (!empty($_FILES['employee_image']['name'])) {
            if ($this->upload->do_upload('employee_image')) {
                $upload_data = $this->upload->data();
                $empData['employee_image'] = 'upload/' . $upload_data['file_name'];
                
                // Delete old image if exists
                $old_image = $this->input->post('old_emp_img');
                if ($old_image && file_exists($old_image)) {
                    unlink($old_image);
                }
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('employee/EM_Controller/employeeProfile/');
                return;
            }
        }
    
        // Update employee profile
        $res = $this->em->updateEmployeeProfile($emp_id, $empData);
    
        if ($res) {
            $this->session->set_flashdata('success', 'Employee Details Updated Successfully!');
            redirect('employee/EM_Controller/employeeProfile/');
        } else {
            $this->session->set_flashdata('error', 'Failed to update employee details. Please try again.');
            redirect('employee/EM_Controller/employeeProfile/');
        }
    
    }

    public function submitEmployeeEvaluation(){
        $menuControl = $this->session->userdata('user_role');
        $loginEmployee = $this->session->userdata('user_id');
        $data["empdata"] = $this->em->getEmployeeDetails($loginEmployee);
        $data['employee'] = $this->em->getEmployeeDetails($loginEmployee);
        $data['sections'] = $this->em->getSectionInLevelTab($data["empdata"]->spectrum_id);

        $goals = $this->em->getprvesEmpGoals($loginEmployee);
        if ($goals) {
            $data["goals"] = $goals;
        } else {
            $data["goals"] = '';
        }

        if($data['sections']){

            foreach($data['sections'] as $row){
                $section_id[] = $row->section_id;
            }

            $data['questions'] = $this->em->getQuestionsRecord($section_id);
        }

        $data['evaluation_marks'] = $this->em->getEvaluationMarks();

        // echo "<pre>"; print_r($data); echo "</pre>"; die;

        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('employee/submit-evaluation', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');

    }

    function insertEmployeeEvaluation(){

        $newData = array(
            "employee_id" => $this->session->userdata("user_id"),
            "evaluation_period" => $this->input->post('evaluate_date_category'),
            "evaluation_start_date" => $this->input->post('emp_performance_start_date'),
            "evaluation_end_date" => $this->input->post('emp_performance_end_date'),
            "modification_date" => date("Y-m-d H:i:s")
        );

        $performanceEvaluation_id = $this->em->insertPerformanceEvaluation($newData);
        if (!$performanceEvaluation_id) {
            $this->session->set_flashdata("error", "Failed to create evaluation");
            redirect("employee/EM_Controller/submitEmployeeEvaluation");
            return;
        }

        // Goals
        $new_goals = array(
            "six_month_goal" => trim($this->input->post('six_month_goal')),
            "twelve_month_goal" => trim($this->input->post('twelve_month_goal')),
            "employee_evaluation_id" => $performanceEvaluation_id,
            "modification_date" => date("Y-m-d H:i:s")
        );
           
        if (!$this->em->insertGoals($new_goals)) {
            $this->session->set_flashdata("error", "Failed to save goals");
            redirect("employee/EM_Controller/submitEmployeeEvaluation");
            return;
        }

        // Evaluation Data
        $evaluation_data = [
            'employee_marks_category_id' => $this->input->post('employee_marks_category_id'),
            'question_id' => $this->input->post('qurestion_id'),
            'employee_feedback' => $this->input->post('employee_feedback'),
        ];

        // echo "<pre>"; print_r($evaluation_data); echo "</pre>"; exit;

        // Validate evaluation data
        if (!$evaluation_data['employee_marks_category_id'] || !$evaluation_data['question_id']) {
            $this->session->set_flashdata("error", "Required evaluation data missing");
            redirect("employee/EM_Controller/submitEmployeeEvaluation");
            return;
        }

        $array_length = count($evaluation_data['employee_marks_category_id']);
        $currentDate = date("Y-m-d H:i:s");

        // Prepare structured data
        $structured_data = [];
        if (count(array_unique(array_map('count', $evaluation_data))) === 1) {
            for ($i = 0; $i < $array_length; $i++) {
                $structured_data[] = [
                    'employee_marks_category_id' => $evaluation_data['employee_marks_category_id'][$i],
                    'question_id' => $evaluation_data['question_id'][$i],
                    'employee_feedback' => $evaluation_data['employee_feedback'][$i],
                    'employee_evaluation_id' => $performanceEvaluation_id,
                    'modification_date' => $currentDate
                ];
            }
        }

        // echo "<pre>"; print_r($structured_data); echo "</pre>"; die;

        if (!empty($structured_data)) {
            if (!$this->em->insertEvaluationData($structured_data)) {
                $this->session->set_flashdata("error", "Failed to save evaluation data");
                redirect("employee/EM_Controller/submitEmployeeEvaluation");
                return;
            }
        }

        $this->session->set_flashdata("success", "Evaluation Saved Successfully");
        redirect("employee/EM_Controller/submitEmployeeEvaluation");
        
    }

    public function listEmployeeEvaluation(){

        $menuControl = $this->session->userdata('user_role');
        // $data['evaluations'] = $this->em->getEmployee_EvaluationList($this->session->userdata('user_id'));

        $data['table_name'] = 'employee_evaluation_table';
        $data['function_url'] = 'employee/EM_Controller/getEmployeeEvaluationRecords';
        $columns = [
            ['data' => 0, 'title' => 'Peroid', 'filterType' => 'select'],
            ['data' => 1, 'title' => 'Start Date', 'filterType' => 'date'],
            ['data' => 2, 'title' => 'End Date', 'filterType' => 'date'],
            ['data' => 3, 'title' => 'Spectrum', 'filterType' => 'select'],
            ['data' => 4, 'title' => 'Evaluation Status', 'filterType' => 'select'],
            ['data' => 5, 'title' => 'Actions', 'orderable' => false, 'filterable' => false]
        ];
        $data['columns'] = $columns;

        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('employee/employee-evaluation-list', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');
        $this->load->view('include/datatable', $data);

    }

    public function getEmployeeEvaluationRecords(){
        $id = $this->session->userdata('user_id');

        
        $resultList = $this->em->fetchEmployeeSubmitedEvaluation($id);

        $result = array();
        $i = 1;
        foreach ($resultList as $key => $value) {

            $button = '<div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="'.base_url('employee/EM_Controller/viewEmployeeEvaluationDetails/'.$value['employee_evaluation_id']).'"><i class="bx bx-edit-alt me-1"></i> View Evaluation</a>
                </div>
            </div>';

            if(($value['evaluation_period'])=='90-a'){
                $period  = 'Mid-Probation';
                $month = '3';
                }elseif(($value['evaluation_period'])=='182-a'){
                $period  = 'Regularization';
                $month = '6';
                }elseif(($value['evaluation_period'])=='182-e'){
                $period  = 'Bi-Annual';
                $month = '6';
                }else{
                $period = '';
                $month = '';
            }

            switch($value['evaluation_status']) {
                case '1':
                    $evaluation_status = '<span class="badge bg-label-primary">Pending</span>';
                    break;
                case '2':
                    $evaluation_status = '<span class="badge bg-label-success">Lock By Employee</span>';
                    break;
                case '3':
                    $evaluation_status = '<span class="badge bg-label-success">Lock By Supervisor</span>';
                    break;
                default:
                    $evaluation_status = '<span class="badge bg-label-danger">Hold</span>';
                    $month = '';
            }

           
            $result['data'][] = array(
                $period,
                $value['evaluation_start_date'],
                $value['evaluation_end_date'],
                $value['spectrum_color_name'],
                $evaluation_status,
                $button
            );
        }
        echo json_encode($result);
    }


    public function viewEmployeeEvaluationDetails($evaluation_id){


        $id = $this->session->userdata('user_id');
      
        $data["empdata"] = $this->em->getEmployeeWithLevel($id);

        // Section & Question Display 

        $data['sections'] = $this->em->getSectionInLevelTab($data["empdata"]->spectrum_id);
        if($data['sections']){
            foreach($data['sections'] as $row){
                $section_id[] = $row->section_id;
            }
            $data['questions'] = $this->em->getQuestionsRecord($section_id);
        }
        
        //--------------------------------------------------------------------------------


        // Get Evaluation Data

        // $data['evaluation_id'] = $this->em->getEmployee_EvaluationID($data["empdata"]->main_employee_id);

        $data['evaluation_data'] = $this->em->getEvaluationData($evaluation_id);

        $data['goals'] = $this->em->getGoals($evaluation_id);

        $data['marks_category'] = $this->em->getEvaluationMarks();

        $data['weight'] = $this->em->getQuestionWeight();

        $data['marks_data'] = $this->em->getMarksData();

        $data['emp_spectrum'] = $this->em->getEmployeeSpectrum();

        $data['emp_evaluation_period'] = $this->em->getEvaluationPeriod($evaluation_id);

        $data['supervisor_data'] = $this->em->getSupervisorData($evaluation_id);

        // echo '<pre>'; print_r($data); echo '</pre>';exit;

        $menuControl = $this->session->userdata('user_role');

        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('employee/view-evaluation-details', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');

    }


    public function editEmployeeEvaluation($evaluation_id){

        $id = $this->session->userdata('user_id');
      
        $data["empdata"] = $this->em->getEmployeeWithLevel($id);

        $data['sections'] = $this->em->getSectionInLevelTab($data["empdata"]->spectrum_id);
        if($data['sections']){
            foreach($data['sections'] as $row){
                $section_id[] = $row->section_id;
            }
            $data['questions'] = $this->em->getQuestionsRecord($section_id);
        }
        
        $data['evaluation_data'] = $this->em->getEvaluationData($evaluation_id);

        $data['goals'] = $this->em->getGoals($evaluation_id);

        $data['marks_category'] = $this->em->getEvaluationMarks();

        $data['weight'] = $this->em->getQuestionWeight();

        $data['marks_data'] = $this->em->getMarksData();

        $data['emp_spectrum'] = $this->em->getEmployeeSpectrum();

        $data['emp_evaluation_period'] = $this->em->getEvaluationPeriod($evaluation_id);

        $data['supervisor_data'] = $this->em->getSupervisorData($id);

        $menuControl = $this->session->userdata('user_role');

        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('employee/edit-evaluation-details', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');
    }


    public function editAndSubmitEmployeeEvaluation($id){

        $this->input->post('evaluate_date_category');
        $this->input->post('emp_performance_start_date');
        $this->input->post('emp_performance_end_date');
        
    
        // Update evaluation period data
        $updateData = array(
            "evaluation_period" => $this->input->post('evaluate_date_category'),
            "evaluation_start_date" => $this->input->post('emp_performance_start_date'),
            "evaluation_end_date" => $this->input->post('emp_performance_end_date'),
            "modification_date" => date("Y-m-d H:i:s")
        );
    
        $result = $this->em->updatePerformanceEvaluation($id, $updateData);
        if (!$result) {
            $this->session->set_flashdata("error", "Failed to update evaluation");
            redirect("employee/EM_Controller/viewEmployeeEvaluationDetails/".$id);
            return;
        }
    
        // Update goals
        $goals_update = array(
            "six_month_goal" => trim($this->input->post('six_month_goal')),
            "twelve_month_goal" => trim($this->input->post('twelve_month_goal')),
            "modification_date" => date("Y-m-d H:i:s")
        );
        
        $this->em->updateGoals($id, $goals_update);
    
        // Update evaluation data
        $evaluation_data = array(
            'employee_marks_category_id' => $this->input->post('employee_marks_category_id'),
            'question_id' => $this->input->post('question_id'),
            'employee_feedback' => $this->input->post('employee_feedback')
        );
    
        // Validate evaluation data
        if (!isset($evaluation_data['employee_marks_category_id']) || 
            !isset($evaluation_data['question_id']) || 
            !is_array($evaluation_data['employee_marks_category_id']) || 
            !is_array($evaluation_data['question_id'])) {
            $this->session->set_flashdata("error", "Invalid evaluation data format");
            redirect("employee/EM_Controller/viewEmployeeEvaluationDetails/".$id);
            return;
        }
    
        $success = true;
        for ($i = 0; $i < count($evaluation_data['employee_marks_category_id']); $i++) {
            $update_data = array(
                'employee_marks_category_id' => $evaluation_data['employee_marks_category_id'][$i],
                'employee_feedback' => isset($evaluation_data['employee_feedback'][$i]) ? $evaluation_data['employee_feedback'][$i] : '',
                'modification_date' => date('Y-m-d H:i:s')
            );
            
            $this->db->where('employee_evaluation_id', $id);
            $this->db->where('question_id', $evaluation_data['question_id'][$i]);
            if (!$this->db->update('pe_evaluation_score_table', $update_data)) {
                $success = false;
                break;
            }
        }
    
        if (!$success) {
            $this->session->set_flashdata("error", "Failed to update evaluation scores");
            redirect("employee/EM_Controller/viewEmployeeEvaluationDetails/".$id);
            return;
        }
    
        $this->session->set_flashdata("success", "Evaluation updated successfully");
        redirect("employee/EM_Controller/viewEmployeeEvaluationDetails/".$id);
    }
        


    public function LockEmployeeEvaluation(){

        $id = $this->input->post('performance_id');
        
        // Validate data exists before proceeding
        if (!$id) {
            $this->session->set_flashdata("error", "No evaluation data provided");
            redirect("employee/EM_Controller/viewEmployeeEvaluationDetails/".$id);
            return;
        }

        $res = $this->em->LockSubmitEvaluation($id, $status = 2);

        if($res){
            $data = [
                'performance_id' => $id,
                'employee_id' => $this->input->post('employee_id'),
                'emp_level' => $this->input->post('emp_level'),
                'emp_sub_level' => $this->input->post('emp_sub_level'),
                'spectrum_id' => $this->input->post('spectrum_id'),
                'goals_id' => $this->input->post('goals_id')
            ];

            // Validate required data before insert
            
            $res = $this->em->insertEvaluationHistory($data);

            if ($res) {
                $this->session->set_flashdata("success", "Evaluation Locked Successfully");
                redirect("employee/EM_Controller/viewEmployeeEvaluationDetails/".$id);
                return;
            }
        }
    }

}
?>