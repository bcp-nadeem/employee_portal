<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

//--------------------------------------------------------------------------------------------

// Department Query

public function uploadDepartment($data){
    return $this->db->insert('departments', $data); 
}
public function fatchDepartmentList($limit, $offset){
    $q = $this->db->select('*')
    ->from('departments')
    ->limit($limit, $offset)
    ->order_by('department_id', "DESC")
    ->get();
    return $q->result();
}
public function num_rows_departments(){
    $q = $this->db->select('*')
    ->from('departments')
    ->get();
    return $q->num_rows();
}
public function deleteDepDB($id){
    return $this->db->delete('departments', ['department_id' => $id]);
}
public function updateDepartmentInfo($id, $data){
    $id = array('department_id' => $id);
    $this->db->where($id);
    $this->db->update('departments', $data);
    return $this->db->affected_rows();
}
public function getDesignationsByDepartmentId($department_id) {
    $this->db->select('designation_id, designation_name');
    $this->db->from('designation');
    $this->db->where('department_id', $department_id);
    $this->db->where('designation_status', 1);
    $this->db->order_by('designation_name', 'ASC');
    
    $query = $this->db->get();
    
    if (!$query) {
        throw new Exception($this->db->error()['message']);
    }
    
    return $query->result();
}
//--------------------------------------------------------------------------------------------
// Designation Query

public function uploadDesignation($data){
    return $this->db->insert('designation', $data); 
}
public function num_rows_designation(){
    $q = $this->db->select('*')
    ->from('designation')
    ->get();
    return $q->num_rows();
}
public function designationListData($limit, $offset){
    $q = $this->db->select('*')
    ->from('designation')
    ->join('departments', 'designation.department_id = departments.department_id')
    ->limit($limit, $offset)
    ->order_by('designation_id', "DESC")
    ->get();
    return $q->result();
}
public function getDepartments(){
    $q = $this->db->select('*')
    ->from('departments')
    ->where('department_status', 1)
    ->get();
    return $q->result();
}
public function deleteDesDB($id){
    return $this->db->delete('designation', ['designation_id' => $id]);
}

public function updateDesignationInfo($Id_department,$Id_designation, $data){

    $departID = array('department_id' => $Id_department);
    $designID = array('designation_id' => $Id_designation);

    $this->db->where($departID);
    $this->db->where($designID);
    $this->db->update('designation', $data);
    return $this->db->affected_rows();
}
//--------------------------------------------------------------------------------------------
// Spectrum Query

public function fatchSpectrumListRecords(){
    $q = $this->db->select('*')
    ->from('spectrum_table')
    ->join('employee_level', 'spectrum_table.employee_level = employee_level.employee_level_id')
    ->join('employee_sub_level', 'spectrum_table.employee_sub_level = employee_sub_level.employee_sub_level_id')
    ->order_by('spectrum_id', "DESC")
    // ->group_by('spectrum_table.employee_level' , 'DESC')
    ->get();
    return $q->result_array();
}

public function deleteSpectrumRecord($spectrum_id){
    $this->db->where('spectrum_id', $spectrum_id);
    return $this->db->delete('spectrum_table');
}

// public function getEmployeeLevels(){
//     $q = $this->db->select('*')
//     ->from('employee_level')
//     ->join('employee_sub_level', 'employee_level.employee_level_id = employee_sub_level.level_id', 'left')
//     ->order_by('employee_level.employee_level_id', "DESC")
//     ->group_by('employee_level.employee_level_name', 'DES')
//     ->get();
//     return $q->result();
// }
//--------------------------------------------------------------------------------------------
// Employee Query



public function getEmployeeLevels(){
    $q = $this->db->select('*')
    ->from('employee_level')
    ->join('employee_sub_level', 'employee_level.employee_level_id = employee_sub_level.level_id', 'left')
    ->order_by('employee_level.employee_level_id', "DESC")
    ->group_by('employee_level.employee_level_id', 'DES')
    ->get();
    return $q->result();
}

public function getLevelName($level_id){
    $this->db->where('employee_level_id', $level_id);
    $query = $this->db->get('employee_level');
    return $query->row();
}

public function getSubLevelsByLevelId($level_id){
    $this->db->where('level_id', $level_id);
    $query = $this->db->get('employee_sub_level');
    return $query->result();
}

public function getUserRoleData($level_id){
    $this->db->select('employee_level_id, employee_level_value, employee_level_name')
        ->from('employee_level')
        ->where('employee_level_id', $level_id);
    
    $query = $this->db->get();
    
    if (!$query) {
        log_message('error', 'Database error in getUserRoleData: ' . $this->db->error()['message']);
        return null;
    }
    
    // return $query->row();

    echo '<pre>';    print_r($query->row()); echo '</pre>';
}


public function getSpectrumsByLevel($level_id, $sub_level_id = null) {
    $this->db->select('spectrum_id, spectrum_color_name, spectrum_color_code');
    $this->db->where('employee_level', $level_id);
    
    if($sub_level_id && $sub_level_id != '') {
        $this->db->where('employee_sub_level', $sub_level_id);
    }
    
    $query = $this->db->get('spectrum_table');
    return $query->result();
}

public function uploadEmpDetails($data){
    $data['date_created'] = date("d-m-Y H:i:s");
    $this->db->insert('employee_table', $data);
    $insert_id = $this->db->insert_id();
    return  $insert_id;
}

public function insertProfileHistory($data){
    return $this->db->insert('employee_history', $data);
}



public function fetchAllData($data,$tablename){
        $query = $this->db->select($data)
        ->from($tablename)
        ->join('employee_level', 'employee_table.emp_level = employee_level.employee_level_id')
        ->join('departments', 'employee_table.employee_department = departments.department_id')
        ->join('designation', 'employee_table.employee_designation = designation.designation_id')
        ->order_by('main_employee_id', "DESC")
        ->get();
        return $query->result_array();
}
    public function getEmployeeRecordIndiv($id){
        $query = $this->db->select('*')
        ->from('employee_table')
        ->join('employee_level', 'employee_table.emp_level = employee_level.employee_level_id')
        ->join('employee_sub_level', 'employee_table.emp_sub_level = employee_sub_level.employee_sub_level_id', 'left')
        ->join('departments', 'employee_table.employee_department = departments.department_id', 'left')
        ->join('designation', 'employee_table.employee_designation = designation.designation_name', 'left')
        ->join('countries', 'employee_table.employee_country_id = countries.country_id', 'left')
        ->join('spectrum_table', 'employee_table.emp_level = spectrum_table.employee_level')
        ->where('employee_table.main_employee_id', $id)
        ->order_by('employee_table.main_employee_id', "DESC")
        ->get();
        return $query->row();
    }
    

    public function updateEmployeeProfile($emp_id, $data){
        $id = array('main_employee_id' => $emp_id);
        $this->db->where($id);
        $this->db->update('employee_table', $data);
        return $this->db->affected_rows();
    }

    public function getAllDepartments() {
        $this->db->select('*');
        $this->db->from('departments');
        $this->db->where('department_status', 1);
        $this->db->order_by('department_name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function insertDepartment($data) {
        $data['department_status'] = 1;
        return $this->db->insert('departments', $data);
    }

    public function getAllActiveDepartments() {
        $this->db->select('department_id, department_name');
        $this->db->from('departments');
        $this->db->where('department_status', 1);
        $this->db->order_by('department_name', 'ASC');
        
        $query = $this->db->get();
        
        if (!$query) {
            throw new Exception($this->db->error()['message']);
        }
        
        return $query->result();
    }
    
//--------------------------------------------------------------------------------------------
// Salary Query
public function EmployeeSalaryListData(){
    $q = $this->db->select('*')
    ->from('employee_table')
    ->join('salary', 'employee_table.main_employee_id = salary.employee_id')
    ->order_by('employee_table.main_employee_id', "DESC")
    ->get();
    return $q->result();
}

public function insertEmployeeSalary($data){
    return $this->db->insert('salary', $data); 
}

public function fetchEmployeeSalary(){
    $q = $this->db->select('*')
    ->from('salary')
    ->join('employee_table', 'salary.employee_id = employee_table.main_employee_id')
    ->order_by('salary_id', "DESC")
    ->get();
    return $q->result_array();
}

public function getEmployeeSalaryRecord(){
    $q = $this->db->select('*')
    ->from('salary')
    ->join('employee_table', 'salary.employee_id = employee_table.main_employee_id')
    ->join('employee_level', 'employee_table.emp_level = employee_level.employee_level_id')
    ->order_by('salary_id', "DESC")
    ->get();
    return $q->result();
}

public function updateEmployeeSalary($emp_id, $data){
    
    $id = array('employee_id' => $emp_id);
    $this->db->where($id);
    $this->db->update('salary', $data);
    return $this->db->affected_rows();

}

public function deleteSalaryRecordDB($id){
    $this->db->where('employee_id', $id);
    return $this->db->delete('salary');
}
//------------------------------------------------------------------------------------------
public function getEmployeeRecord(){
    $q = $this->db->select('*')
    ->from('employee_table')
    ->join('employee_level', 'employee_table.emp_level = employee_level.employee_level_id')
    ->join('employee_sub_level', 'employee_table.emp_sub_level = employee_sub_level.employee_sub_level_id', 'left')
    ->where('employee_status', 1)
    ->order_by('employee_table.main_employee_id', "DESC")
    ->get();
    return $q->result();
}
function insertSpectrumRecord($data){
    return $this->db->insert('spectrum_table', $data); 
}
public function getspectrumList(){
    $q = $this->db->select('*')
    ->from('spectrum_table')
    ->join('employee_level', "spectrum_table.employee_level = employee_level.employee_level_id")
    ->join('employee_sub_level', "spectrum_table.employee_sub_level = employee_sub_level.employee_sub_level_id")
    // ->group_by('spectrum_table.employee_level', "DESC")
    ->get();
    return $q->result();
}
public function getCountries(){
    $this->db->order_by('country_name', 'ASC');
    $query = $this->db->get('countries');
    return $query->result();
}
public function getEmpDepartment(){
    $q = $this->db->select('*')
    ->from('departments')
    ->where('department_status', 1)
    ->order_by('department_id', "DESC")
    ->get();
    return $q->result();
}
public function fetchDepartmentList($department){
    $this->db->where('department_id',$department);
    $this->db->where('department_status', 1);
    $this->db->order_by('designation_id', 'ASC');
    $query = $this->db->get('designation');
    $output = '<option value="">Select Designation</option>';
    foreach($query->result() as $row){
      $output .= '<option value="'.$row->designation_name.'">'.$row->designation_name.'</option>';
    }
    return $output;
}
//--------------------------------------------------------------------------------------------
// Section Query

function insertSectionRecord($data){
    return $this->db->insert('pe_section_table', $data); 
}

public function fetchAllSectionData($data,$tablename){
    $query = $this->db->select($data)
    ->from($tablename)
    ->join('spectrum_table', 'pe_section_table.spectrum_id = spectrum_table.spectrum_id')
    ->join('employee_level', 'spectrum_table.employee_level = employee_level.employee_level_id')
    ->join('employee_sub_level', 'spectrum_table.employee_sub_level = employee_sub_level.employee_sub_level_id' )

    ->order_by('section_id', "DESC")
    ->get();
    return $query->result_array();
}

public function fetchSectionData(){
    $query = $this->db->select('*')
    ->from('pe_section_table')
    ->order_by('section_id', "DESC")
    ->get();
    return $query->result();
}

public function updateSectionRecord($section_id, $data){
    $this->db->where('section_id', $section_id);
    return $this->db->update('pe_section_table', $data);
}

public function deleteSectionRecordDB($section_id){
    $this->db->where('section_id', $section_id);
    return $this->db->delete('pe_section_table');
}
//--------------------------------------------------------------------------------------------
// Questions Query
function getQuestionRecords(){
    $q = $this->db->select('*')
    ->from('pe_section_table')
    ->join('spectrum_table', 'spectrum_table.spectrum_id = pe_section_table.spectrum_id')
    ->join('employee_table', 'spectrum_table.employee_level = employee_table.emp_level')
    ->join('departments', 'employee_table.employee_department = departments.department_id')
    ->join('designation', 'employee_table.employee_designation = designation.designation_id')
    ->group_by('spectrum_table.spectrum_id', 'DESC')
    ->get();
    return $q->result();
}
public function get_sections_by_spectrum($spectrum_id) {
    $query = $this->db
        ->select('section_id, section_name, spectrum_id')
        ->from('pe_section_table')
        ->where('pe_section_table.spectrum_id', $spectrum_id)
        ->group_by('pe_section_table.section_name', 'DESC')
        ->get();
    
    // Debug query
    log_message('debug', 'Last query: ' . $this->db->last_query());
    
    return $query->result();
}
function insertQuestionRecord($data){
    return $this->db->insert('pe_question_table', $data); 
}

public function fetchAllQuestionData($data,$tablename){
    $query = $this->db->select($data)
    ->from($tablename)
    ->join('spectrum_table', 'pe_question_table.spectrum_id = spectrum_table.spectrum_id')
    ->join('pe_section_table', 'pe_question_table.section_id = pe_section_table.section_id')
    ->join('pe_question_weight_table', 'pe_question_table.question_weight_id = pe_question_weight_table.question_weight_id')
    ->get();
return $query->result_array();
}

public function fetchAllQuestionDataModel($data,$tablename){
    $query = $this->db->select($data)
    ->from($tablename)
    ->join('spectrum_table', 'pe_question_table.spectrum_id = spectrum_table.spectrum_id')
    ->join('pe_section_table', 'pe_question_table.section_id = pe_section_table.section_id')
    ->join('pe_question_weight_table', 'pe_question_table.question_weight_id = pe_question_weight_table.question_weight_id')
    ->get();
    return $query->result();
}
public function updateQuestionRecord($question_id, $data){
    $this->db->where('question_id', $question_id);
    return $this->db->update('pe_question_table', $data);
}
public function deleteQuestionRecordDB($question_id){
    $this->db->where('question_id', $question_id);
    return $this->db->delete('pe_question_table');
}
//--------------------------------------------------------------------------------------------
// Level Query

public function insertEmployeeLevel($data){
    if ($this->db->insert('employee_level', $data)) {
        return $this->db->insert_id();
    }
    return false;
}

public function insertEmployeeSubLevel($level_id, $level_name, $sub_levels){
    if (empty($sub_levels)) {
        return true;
    }

    $batch_data = array();
    foreach ($sub_levels as $sub_level) {
        if (!empty($sub_level)) {
            $batch_data[] = array(
                'level_id' => $level_id,
                'level_name' => $level_name,
                'employee_sub_level_name' => $sub_level,
                'date_created' => date('Y-m-d H:i:s')
            );
        }
    }

    if (!empty($batch_data)) {
        return $this->db->insert_batch('employee_sub_level', $batch_data);
    }
    return true;
}

public function insertEmployeeSubLevel2($level_id, $level_name, $sub_levels){
    $data = array(
        'level_id' => $level_id,
        'employee_sub_level_name' => $sub_levels,
        'level_name' => $level_name,
        'date_created' => date('Y-m-d H:i:s')
    );

    // echo '<pre>'; print_r($data); echo '</pre>';exit;
    return $this->db->insert('employee_sub_level', $data);
}

public function getEmployeeLevelListData(){
    $q = $this->db->select('*')
        ->from('employee_level')
        ->join('employee_sub_level', 'employee_level.employee_level_id = employee_sub_level.level_id', 'left')
        ->order_by('employee_level.employee_level_id', "DESC")
        ->group_by('employee_level.employee_level_name', 'DES')
        ->get();
    return $q->result();
}

public function fatchUsersLevelRecords(){
    $q = $this->db->select('*')
    ->from('employee_level')
    ->join('employee_sub_level', 'employee_level.employee_level_id = employee_sub_level.level_id', 'left')
    ->order_by('employee_level.employee_level_id', "DESC")
    ->group_by('employee_level.employee_level_id', 'DES')
    ->get();
    return $q->result_array();

    // echo '<pre>'; print_r($q->result_array()); echo '</pre>';exit;

}

public function updateEmployeeLevel($level_id, $data) {
    $this->db->where('employee_level_id', $level_id);
    return $this->db->update('employee_level', $data);
}
public function updateEmployeeSubLevel($sub_level_id, $data) {
    $this->db->where('employee_sub_level_id', $sub_level_id);
    return $this->db->update('employee_sub_level', $data);
}
public function deleteEmployeeLevel($level_id) {
    $this->db->where('employee_level_id', $level_id);
    return $this->db->delete('employee_level');
}

public function deleteEmployeeSubLevel($sub_level_id) {
    $this->db->where('employee_sub_level_id', $sub_level_id);
    return $this->db->delete('employee_sub_level');
}
//--------------------------------------------------------------------------------------------

// Assign Query

public function fetchAllAssignData(){
    $q = $this->db->select('*')
    ->from('employee_table')
    ->join('employee_level', 'employee_table.emp_level = employee_level.employee_level_id')
    ->join('employee_sub_level', 'employee_table.emp_sub_level = employee_sub_level.employee_sub_level_id', 'left')
    ->join('departments', 'employee_table.employee_department = departments.department_id', 'left')
    ->join('designation', 'employee_table.employee_designation = designation.designation_id', 'left')
    ->where_in('employee_table.user_role', [2, 3])
    ->group_by('employee_table.main_employee_id', 'DES')
    ->get();
    
    return $q->result_array();
}

public function getAllEmployeeWithLevel(){
        $q = $this->db->select('*')
        ->from('employee_table')
        ->join('employee_level', 'employee_table.emp_level = employee_level.employee_level_id')
        ->join('employee_sub_level', 'employee_table.emp_sub_level = employee_sub_level.employee_sub_level_id', 'left')
        ->join('departments', 'employee_table.employee_department = departments.department_id', 'left')
        ->join('designation', 'employee_table.employee_designation = designation.designation_name', 'left')
        ->where_in('employee_table.user_role', [1, 2])
        ->group_by('employee_table.main_employee_id', 'DES')
        ->get();
    return $q->result();
}

public function postAssignEmptoManager($mID, $eID){

    for($i = 0; $i < count($eID); $i++){

        $data[] = [

            'assign_supervisor_id' => $mID,
            'assign_employee_id' => $eID[$i],
            'assign_status' => 1,
            'date_created' => date("d-m-Y H:i:s")
        ];

    }
    return $this->db->insert_batch('pe_assign_employee', $data);
}

public function fetchAllAssignemployeeData($id){
    
    // echo '<pre>'; print_r($id); echo '</pre>';
    $q = $this->db->select('*')
        ->from('pe_assign_employee')
        ->join('employee_table', 'pe_assign_employee.assign_employee_id = employee_table.main_employee_id', 'left')
        ->join('designation' , 'employee_table.employee_designation = designation.designation_id', 'left')
        // ->group_by('pe_assign_employee.assign_id', "DESC")
        ->where('pe_assign_employee.assign_supervisor_id', $id)
        ->get();
        return $q->result_array();
    }

    public function getSupervisorData(){
        $q = $this->db->select('*')
        ->from('employee_table')
        ->join('employee_level', 'employee_table.emp_level = employee_level.employee_level_id')
        ->join('employee_sub_level', 'employee_table.emp_sub_level = employee_sub_level.employee_sub_level_id', 'left')
        ->join('departments', 'employee_table.employee_department = departments.department_id', 'left')
        ->join('designation', 'employee_table.employee_designation = designation.designation_name', 'left')
        ->where_in('employee_level.employee_level_value', [2, 3])
        ->group_by('employee_level.employee_level_name', 'DES')
        ->get();
        return $q->result();
    }


    // Spectrum Update & Delete Query


    public function updateSpectrumRecord($spectrum_id, $data){
        $this->db->where('spectrum_id', $spectrum_id);
        return $this->db->update('spectrum_table', $data);
    }

    
    public function getEmployeeEvaluationRecordDB(){
        
    
        $q = $this->db->select('*')
            ->from('pe_evaluation_table')
            ->join('employee_table', 'employee_table.main_employee_id = pe_evaluation_table.employee_id')
            ->join('spectrum_table', 'spectrum_table.employee_level = employee_table.emp_level')
            ->where_in('pe_evaluation_table.evaluation_status', array(2, 3));
    
    
        return $q->get()->result_array();

    }

    public function LockSubmitEvaluation($id, $data){
        $this->db->where('employee_evaluation_id', $id);
        return $this->db->update('pe_evaluation_table', $data);
    }

    public function getEmployeeHistory($id){
        $q = $this->db->select('*')
        ->from('employee_history')
        ->join('employee_table', 'employee_table.main_employee_id = employee_history.employee_id')
        ->join('employee_level', 'employee_history.history_emp_level = employee_level.employee_level_id')
        ->join('employee_sub_level', 'employee_history.history_emp_sub_level = employee_sub_level.employee_sub_level_id', 'left')
        ->join('departments', 'employee_history.history_department_id = departments.department_id', 'left')
        ->join('designation', 'employee_history.history_designation_id = designation.designation_id', 'left')
        ->join('countries', 'employee_table.employee_country_id = countries.country_id', 'left')
        ->join('spectrum_table', 'employee_history.history_spectrum_id = spectrum_table.spectrum_id')
        ->where('employee_history.employee_id', $id)
        ->get();
        return $q->result();
    }

    public function deleteHistoryDB($id){
        return $this->db->delete('employee_history', ['history_employee_id' => $id]);
    }

    public function fatchEmployeeEvaluationHistory($evaluation_id){
        $q = $this->db->select('*')
        ->from('pe_evaluation_table')
        ->join('employee_table', 'employee_table.main_employee_id = pe_evaluation_table.employee_id')
        ->join('spectrum_table','spectrum_table.employee_level = employee_table.emp_level')
        ->join('employee_history', 'employee_history.history_employee_id = pe_evaluation_table.employee_evaluation_id')
        ->where('pe_evaluation_table.employee_evaluation_id', $evaluation_id)
        ->get();
        return $q->result_array();
    }

}

?>