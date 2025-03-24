<?php 


class Employee_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function getEmployeeDetails($id){
        $this->db->select('*')
            ->from('employee_table')
            ->join('spectrum_table', 'employee_table.emp_level = spectrum_table.employee_level')
            ->join('departments', 'departments.department_id = employee_table.employee_department')
            ->join('designation', 'designation.designation_id = employee_table.employee_designation')
            ->join('employee_level', 'employee_table.emp_level = employee_level.employee_level_id')
            ->join('countries', 'employee_table.employee_country_id = countries.country_id')
            ->join('employee_sub_level', 'employee_table.emp_sub_level = employee_sub_level.employee_sub_level_id', 'left')
            ->where('employee_table.main_employee_id', $id)
            ->group_by('employee_table.main_employee_id');
        
        $q = $this->db->get();
        return $q->row();
    }

    public function getCountries(){
        $q = $this->db->select('*')
        ->from('countries')
        ->get();
        return $q->result();
    }

    public function updateEmployeeProfile($id, $data){
        $this->db->where('main_employee_id', $id);
        return $this->db->update('employee_table', $data);
    }

    public function getEmployeeWithLevel($id){
        $q = $this->db->select('*')
        ->from('employee_table')
        ->join('spectrum_table', 'employee_table.emp_level = spectrum_table.employee_level')
        ->join('employee_level', 'employee_table.emp_level = employee_level.employee_level_id')
        ->join('employee_sub_level', 'employee_table.emp_sub_level = employee_sub_level.employee_sub_level_id', 'left')
        ->join('departments', 'employee_table.employee_department = departments.department_id', 'left')
        ->join('designation', 'employee_table.employee_designation = designation.designation_id', 'left')
        ->where('employee_table.main_employee_id', $id)
        ->get();
        return $q->row();
    }

    function getSectionInLevelTab($spectrum_id){
        $q = $this->db->select('pe_section_table.section_id, pe_section_table.section_name')
            ->from('pe_section_table')
            ->join('spectrum_table', 'spectrum_table.spectrum_id = pe_section_table.spectrum_id')
            ->where('pe_section_table.spectrum_id', $spectrum_id)
            ->group_by('pe_section_table.section_name', 'DESC')
            ->get();
        return $q->result();
    }
    public function getprvesEmpGoals($emp_id){
        $q = $this->db->select('*')
        ->from('pe_goals_table')
        ->join('pe_evaluation_table', 'pe_goals_table.employee_evaluation_id = pe_evaluation_table.employee_evaluation_id')
        ->where('pe_evaluation_table.employee_id', $emp_id)
        ->get();
        return $q->row();
    }

    function getQuestionsRecord($sections_id){
        $q = $this->db->select('*')
        ->from('pe_question_table')
        ->where_in('section_id', $sections_id)
        ->get();
        return $q->result();
    }

    function getEvaluationMarks(){
        $q = $this->db->select('*')
        ->from('pe_marks_category_table')
        ->get();
        return $q->result();
    }

    function insertPerformanceEvaluation($data){
        $this->db->insert('pe_evaluation_table', $data); 
        return $this->db->insert_id();
    }

    function insertGoals($data){
        return $this->db->insert('pe_goals_table', $data); 
    }

    function insertEvaluationData($data){
        $this->db->insert_batch('pe_evaluation_score_table', $data);
        return $this->db->insert_id();
    }

    public function getEmployee_EvaluationList($id){
        $q = $this->db->select('*')
        ->from('pe_evaluation_table')
        ->where('employee_id', $id)
        ->get();
        return $q->result();
    }

    public function fetchEmployeeSubmitedEvaluation($id){

        $q = $this->db->select('*')
        ->from('pe_evaluation_table')
        ->join('pe_evaluation_score_table', 'pe_evaluation_table.employee_evaluation_id = pe_evaluation_score_table.employee_evaluation_id')
        ->join('pe_question_table', 'pe_question_table.question_id = pe_evaluation_score_table.question_id')
        ->join('spectrum_table', 'spectrum_table.spectrum_id = pe_question_table.spectrum_id')
        ->where('pe_evaluation_table.employee_id', $id)
        ->group_by('pe_evaluation_table.employee_evaluation_id')
        ->get();
        return $q->result_array();

        // echo '<pre>'; print_r($q->result_array()); die;

    }

    public function getEvaluationData($id){
        $q = $this->db->select('*')
        ->from('pe_evaluation_score_table')
        ->join('pe_question_table', 'pe_question_table.question_id = pe_evaluation_score_table.question_id')
        ->join('pe_question_weight_table', 'pe_question_weight_table.question_weight_id = pe_question_table.question_weight_id')
        ->where('employee_evaluation_id', $id)
        ->get();
        return $q->result();
    }

    public function getGoals($id){
        $q = $this->db->select('*')
        ->from('pe_goals_table')
        ->where('employee_evaluation_id', $id)
        ->get();
        return $q->row();
    }

    function getQuestionWeight(){
        $q = $this->db->select('*')
        ->from('pe_question_weight_table')
        ->get();
        return $q->result();
    }

    function getMarksData(){
        $q = $this->db->select('*')
        ->from('pe_marks_category_table')
        ->get();
        return $q->result();
    }

    public function getEmployeeSpectrum(){
        $q = $this->db->select('*')
        ->from('spectrum_table')
        ->get();
        return $q->result();
    }

    public function getEvaluationPeriod($id){
        $q = $this->db->select('*')
        ->from('pe_evaluation_table')
        ->where('employee_evaluation_id', $id)
        ->get();
        return $q->row();
    }

    public function getSupervisorData($id){
        $q = $this->db->select('main_employee_id, employee_first_name, employee_last_name, employee_email, employee_image')
        ->from('pe_evaluation_history_id')
        ->join('pe_evaluation_table', 'pe_evaluation_table.employee_evaluation_id = pe_evaluation_history_id.performance_id')
        ->join('employee_table', 'employee_table.main_employee_id = pe_evaluation_history_id.supervisor_id')
        ->where('pe_evaluation_history_id.performance_id', $id)
        ->get();
        return $q->row();
    }

    public function LockSubmitEvaluation($id, $status){
        $data = array('evaluation_status' => $status);
        $this->db->where('employee_evaluation_id', $id);
        return $this->db->update('pe_evaluation_table', $data);
    }

    public function insertEvaluationHistory($data){
        $data['modification_date'] = date('Y-m-d H:i:s');
        return $this->db->insert('pe_evaluation_history_id', $data);
    }

    public function updatePerformanceEvaluation($id, $data){
        $this->db->where('employee_evaluation_id', $id);
        return $this->db->update('pe_evaluation_table', $data);
    }

    public function updateGoals($id, $data){
        $this->db->where('employee_evaluation_id', $id);
        return $this->db->update('pe_goals_table', $data);
    }

}

?>