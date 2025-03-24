<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
class SV_Controller extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->load->model('supervisor_model/Supervisor_model', 'sm');
        $this->load->model('employee_model/Employee_model', 'em');

        if(!$this->session->userdata('logged_in') || $this->session->userdata('user_role') != 2) {
            $this->session->set_flashdata('error', 'Access denied. Admin privileges required.');
            redirect('auth/login');
        }
    }

    function index() {
        $menuControl = $this->session->userdata('user_role');
        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('supervisor/dashboard');
        $this->load->view('include/scripts');
        $this->load->view('include/footer');
    }

    public function viewEmployeePerformanceList(){
        $menuControl = $this->session->userdata('user_role');
     
        $data['table_name'] = 'assign_employee_evaluation_table';
        $data['function_url'] = 'supervisor/SV_Controller/getAssignEmployeeEvaluationRecords';
        $columns = [
            ['data' => 0, 'title' => 'Employee', 'filterType' => 'text'],
            ['data' => 1, 'title' => 'Peroid', 'filterType' => 'select'],
            ['data' => 2, 'title' => 'Start Date', 'filterType' => 'date'],
            ['data' => 3, 'title' => 'End Date', 'filterType' => 'date'],
            ['data' => 4, 'title' => 'Spectrum', 'filterType' => 'select'],
            ['data' => 5, 'title' => 'Evaluation Status', 'filterType' => 'select'],
            ['data' => 6, 'title' => 'Actions', 'orderable' => false, 'filterable' => false]
        ];
        $data['columns'] = $columns;


        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('supervisor/view-employee-performance-list', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');
        $this->load->view('include/datatable', $data);

    }

    public function getAssignEmployeeEvaluationRecords(){
        $id = $this->session->userdata('user_id');
        $assign_employee_ids = $this->sm->getEmployeeMyAssign($id);
        $resultList = $this->sm->getMyAssignEmployeeRecords($assign_employee_ids);
    
        // Initialize the response array with required DataTables structure
        $response = array(
            "data" => array()
        );
    
        if (!empty($resultList)) {
            foreach ($resultList as $key => $value) {
                $button = '<div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="'.base_url('supervisor/SV_Controller/viewAssignEmployeeEvaluationDetails/'.$value['employee_evaluation_id']).'"><i class="bx bx-edit-alt me-1"></i> View Evaluation</a>
                    </div>
                </div>';
    
                // Determine period and month
                switch($value['evaluation_period']) {
                    case '90-a':
                        $period = 'Mid-Probation';
                        $month = '3';
                        break;
                    case '182-a':
                        $period = 'Regularization';
                        $month = '6';
                        break;
                    case '182-e':
                        $period = 'Bi-Annual';
                        $month = '6';
                        break;
                    default:
                        $period = '';
                        $month = '';
                }

                $employee = '<div class="avatar-edit">
                                <img src="'.base_url($value['employee_image']).'" alt="admin profile" class="w-px-40 h-auto rounded-circle">&nbsp;
                                <a href="'.base_url("supervisor/SV_Controller/viewAssignEmployeeProfileDetails/".$value['main_employee_id']).'"><strong>'.$value['employee_first_name'].' <i class="bx bx-link"></i></strong></a>
                            </div>';

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
               
                $response['data'][] = array(
                    $employee,
                    $period,
                    $value['evaluation_start_date'],
                    $value['evaluation_end_date'],
                    $value['spectrum_color_name'],
                    $evaluation_status,
                    $button
                );
            }
        }
    
        // Set proper JSON header
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    public function viewAssignEmployeeEvaluationDetails($evaluation_id){
      
        $data['empID'] = $this->sm->getEmployeeID($evaluation_id);
        $data["empdata"] = $this->sm->getEmployeeDetails($data['empID']->employee_id);
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

        // echo "<pre>"; print_r($data); exit;


        $menuControl = $this->session->userdata('user_role');

        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('supervisor/view-assign-evaluation-details', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');

    }


    public function supervisorAssignEditYourEvaluation($evaluation_id){

        $id = $this->session->userdata('user_id');

        $data['empID'] = $this->sm->getEmployeeID($evaluation_id);
        $data["empdata"] = $this->sm->getEmployeeDetails($data['empID']->employee_id);
      
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

        $menuControl = $this->session->userdata('user_role');

        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('supervisor/edit-assign-evaluation-details', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');

    }

    public function supervisorEditAndSubmitEmployeeEvaluation($id){
        // Validate ID
        if (!$id) {
            $this->session->set_flashdata("error", "Invalid evaluation ID");
            redirect("supervisor/SV_Controller/viewAssignEmployeeEvaluationDetails/" . $id);
            return;
        }

        // Update goals
        $goals_update = array(
            "supervisor_six_month_goal" => trim($this->input->post('supervisor_six_month_goal')),
            "supervisor_twelve_month_goal" => trim($this->input->post('supervisor_twelve_month_goal')),
            "modification_date" => date("Y-m-d H:i:s")
        );
        
        if (!$this->sm->updateEmployeeGoals($id, $goals_update)) {
            $this->session->set_flashdata("error", "Failed to update goals");
            redirect("supervisor/SV_Controller/viewAssignEmployeeEvaluationDetails/" . $id);
            return;
        }

        // Update evaluation data
        $evaluation_data = [
            'supervisor_marks_category_id' => $this->input->post('supervisor_marks_category_id'),
            'manager_feedback' => $this->input->post('manager_feedback'),
            'question_id' => $this->input->post('question_id')
        ];

        // Validate evaluation data exists
        if (!$evaluation_data['supervisor_marks_category_id'] || !$evaluation_data['question_id']) {
            $this->session->set_flashdata("error", "Missing evaluation data");
            redirect("supervisor/SV_Controller/viewAssignEmployeeEvaluationDetails/" . $id);
            return;
        }

        if (!$this->sm->updateEmployeeEvaluationData($id, $evaluation_data)) {
            $this->session->set_flashdata("error", "Failed to update evaluation data");
            redirect("supervisor/SV_Controller/viewAssignEmployeeEvaluationDetails/" . $id);
            return;
        }

        $this->session->set_flashdata("success", "Evaluation updated successfully");
        redirect("supervisor/SV_Controller/viewAssignEmployeeEvaluationDetails/" . $id);
    }

    public function LockAssignEmployeeEvaluation(){

        $supervisorId['supervisor_id'] = $this->session->userdata('user_id');

        $id = $this->input->post('performance_id');
        
        // Validate data exists before proceeding
        if (!$id) {
            $this->session->set_flashdata("error", "No evaluation data provided");
            redirect("supervisor/SV_Controller/viewAssignEmployeeEvaluationDetails/" . $id);
            return;
        }

        $res = $this->sm->LockSubmitEvaluation($id, $status = 3);

        if($res){

            $res = $this->sm->updateSupervisorRecord($id,$supervisorId);

            if ($res) {
                $this->session->set_flashdata("success", "Evaluation Locked Successfully");
                redirect("supervisor/SV_Controller/viewAssignEmployeeEvaluationDetails/" . $id);
                return;
            }
        }

    }

    public function updateSupervisorRecord($id, $data){
        $this->db->where('performance_id', $id);
        return $this->db->update('pe_evaluation_history_id', $data);
    }

    public function viewAssignEmployeeProfileDetails($id){

        $menuControl = $this->session->userdata('user_role');
        $data['empdata'] = $this->em->getEmployeeDetails($id);
        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('supervisor/assign-employee-profile', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');

    }

    public function getAssignEmployeeList(){

        $menuControl = $this->session->userdata('user_role');
     
        $data['table_name'] = 'assign_employee_list';
        $data['function_url'] = 'supervisor/SV_Controller/getAssignEmployeeListRecords';
        $columns = [
            ['data' => 0, 'title' => 'Employee', 'filterType' => 'text'],
            ['data' => 1, 'title' => 'Department', 'filterType' => 'select'],
            ['data' => 2, 'title' => 'Designation', 'filterType' => 'date'],
            ['data' => 3, 'title' => 'Level', 'filterType' => 'date'],
            ['data' => 4, 'title' => 'Spectrum', 'filterType' => 'select'],
        ];
        $data['columns'] = $columns;


        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('supervisor/assign-employee-list', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');
        $this->load->view('include/datatable', $data);

    }

    public function getAssignEmployeeListRecords(){

        $id = $this->session->userdata('user_id');
        $assign_employee_ids = $this->sm->getEmployeeMyAssign($id);
        $resultList = $this->sm->getMyAssignEmployeeList($assign_employee_ids);
    
        // Initialize the response array with required DataTables structure
        $response = array(
            "data" => array()
        );
    
        if (!empty($resultList)) {
            foreach ($resultList as $key => $value) {

    
                // Determine period and month
                switch($value['evaluation_period']) {
                    case '90-a':
                        $period = 'Mid-Probation';
                        $month = '3';
                        break;
                    case '182-a':
                        $period = 'Regularization';
                        $month = '6';
                        break;
                    case '182-e':
                        $period = 'Bi-Annual';
                        $month = '6';
                        break;
                    default:
                        $period = '';
                        $month = '';
                }

                $employee = '<div class="avatar-edit">
                                <img src="'.base_url($value['employee_image']).'" alt="admin profile" class="w-px-40 h-auto rounded-circle">&nbsp;
                                <a href="'.base_url("supervisor/SV_Controller/viewAssignEmployeeProfileDetails/".$value['main_employee_id']).'"><strong>'.$value['employee_first_name'].' <i class="bx bx-link"></i></strong></a>
                            </div>';
               
                $response['data'][] = array(
                    $employee,
                    $value['department_name'],
                    $value['designation_name'],
                    $value['employee_level_name'],
                    $value['spectrum_color_name']
                );
            }
        }
    
        // Set proper JSON header
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    public function employeePerformanceHistory($evaluation_id){
        $menuControl = $this->session->userdata('user_role');
        $data['table_name'] = 'supervisor_employee_performance_history';
        $data['function_url'] ='supervisor/SV_Controller/getEmployeeEvaluationHistory/'.$evaluation_id;
        $columns = [
            ['data' => 0, 'title' => 'Employee', 'filterType' => 'text'],
            ['data' => 1, 'title' => 'Evaluation Period', 'filterType' => 'text'],
            ['data' => 2, 'title' => 'Evaluation Start Date', 'filterType' => 'date'],
            ['data' => 3, 'title' => 'Evaluation End Date', 'filterType' => 'date'],
            ['data' => 4, 'title' => 'Spectrum', 'filterType' => 'text'],
            ['data' => 5, 'title' => 'Evaluation Status', 'filterType' => 'text'],
            ['data' => 6, 'title' => 'Action', 'filterType' => 'text'],
        ];
        $data['columns'] = $columns;
        $data['evaluation_id'] = $evaluation_id;
        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('supervisor/employee-performance-history', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');
        $this->load->view('include/datatable', $data);
    }

    public function getEmployeeEvaluationHistory($evaluation_id){

        $supervisor_id = $this->session->userdata('user_id');
        
        $resultList = $this->sm->fatchEmployeeEvaluationHistory($evaluation_id, $supervisor_id);

        // Initialize the response array with required DataTables structure
        $response = array(
            "data" => array()
        );
        if (!empty($resultList)) {
            foreach ($resultList as $key => $value) {
                // Determine period and month
                switch($value['evaluation_period']) {
                    case '90-a':
                        $period = 'Mid-Probation';
                        $month = '3';
                        break;
                    case '182-a':
                        $period = 'Regularization';
                        $month = '6';
                        break;
                    case '182-e':
                        $period = 'Bi-Annual';
                        $month = '6';
                        break;
                    default:
                        $period = '';
                        $month = '';
                }
                $employee = '<div class="avatar-edit">
                                <img src="'.base_url($value['employee_image']).'" alt="admin profile" class="w-px-40 h-auto rounded-circle">&nbsp;
                                <a href="'.base_url("supervisor/SV_Controller/viewAssignEmployeeProfileDetails/".$value['main_employee_id']).'"><strong>'.$value['employee_first_name'].' <i class="bx bx-link"></i></strong></a>
                            </div>';

                $button = '<a href="'.base_url("supervisor/SV_Controller/viewAssignEmployeeEvaluationDetails/".$value['employee_evaluation_id']).'" class="btn btn-icon btn-sm btn-primary"><i class="bx bx-link"></i></a>';
                switch($value['evaluation_status']) {
                    case '1':
                        $evaluation_status = '<span class="badge bg-label-primary">Un-Locked</span>';
                        break;
                    case '2':
                        $evaluation_status = '<span class="badge bg-label-success">Lock By Employee</span>';
                        break;
                    case '3':
                        $evaluation_status = '<span class="badge bg-label-success">Lock By Supervisor</span>';
                        break;
                    default:
                        $evaluation_status = '';
                }
                $response['data'][] = array(
                    $employee,
                    $period,
                    $value['evaluation_start_date'],
                    $value['evaluation_end_date'],
                    $value['spectrum_color_name'],
                    $evaluation_status,
                    $button
                );
            }
        }
        // Set proper JSON header
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }


}
?>