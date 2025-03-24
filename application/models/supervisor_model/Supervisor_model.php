<?php 


class Supervisor_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getEmployeeMyAssign($id){
        $q = $this->db->select('assign_employee_id')
        ->from('pe_assign_employee')
        ->where('pe_assign_employee.assign_supervisor_id', $id)
        ->get();
        
        // Extract assign_employee_id values from result objects
        $employee_ids = array();
        foreach($q->result() as $row) {
            $employee_ids[] = $row->assign_employee_id;
        }
        return $employee_ids;
    }

    public function getMyAssignEmployeeRecords($employee_id){
        if (empty($employee_id)) {
            return array(); // Return empty array if no employee IDs
        }
    
        $q = $this->db->select('*')
            ->from('pe_evaluation_table')
            ->join('employee_table', 'employee_table.main_employee_id = pe_evaluation_table.employee_id')
            ->join('spectrum_table', 'spectrum_table.employee_level = employee_table.emp_level')
            ->where_in('pe_evaluation_table.evaluation_status', array(2, 3));
    
        // Ensure employee_id is an array and not empty
        $employee_ids = array_filter(array_map('intval', (array)$employee_id));
        if (!empty($employee_ids)) {
            $this->db->where_in('pe_evaluation_table.employee_id', $employee_ids);
        }
    
        return $q->get()->result_array();

    }


    public function getMyAssignEmployeeList($employee_id){
        if (empty($employee_id)) {
            return array(); // Return empty array if no employee IDs
        }
    
        $q = $this->db->select('*')
            ->from('pe_evaluation_table')
            ->join('employee_table', 'employee_table.main_employee_id = pe_evaluation_table.employee_id')
            ->join('spectrum_table', 'spectrum_table.employee_level = employee_table.emp_level')
            ->join('departments', 'departments.department_id = employee_table.employee_department')
            ->join('designation', 'designation.designation_id = employee_table.employee_designation')
            ->join('employee_sub_level', 'employee_table.emp_sub_level = employee_sub_level.employee_sub_level_id', 'left')
            ->join('employee_level', 'spectrum_table.employee_level = employee_level.employee_level_id')
            ->where_in('pe_evaluation_table.evaluation_status', array(2, 3));
    
        // Ensure employee_id is an array and not empty
        $employee_ids = array_filter(array_map('intval', (array)$employee_id));
        if (!empty($employee_ids)) {
            $this->db->where_in('pe_evaluation_table.employee_id', $employee_ids);
        }
    
        return $q->get()->result_array();

    }

    public function updateEmployeeGoals($id, $data){
        $this->db->where('employee_evaluation_id', $id);
        return $this->db->update('pe_goals_table', $data);
    }
    
    public function updateEmployeeEvaluationData($id, $evaluation_data) {
        $success = true;

        for ($i = 0; $i < count($evaluation_data['supervisor_marks_category_id']); $i++) {
            $update_data = array(
                'supervisor_marks_category_id' => $evaluation_data['supervisor_marks_category_id'][$i],
                'manager_feedback' => isset($evaluation_data['manager_feedback'][$i])? $evaluation_data['manager_feedback'][$i] : '',
               'modification_date' => date('Y-m-d H:i:s')
            );
            $this->db->where('employee_evaluation_id', $id);
            $this->db->where('question_id', $evaluation_data['question_id'][$i]); // Add this line to match specific question
            if (!$this->db->update('pe_evaluation_score_table', $update_data)) {
                $success = false;
            }else{
                $success = true;
            }
        }
        return $success;
    }

    public function LockSubmitEvaluation($id, $status){
        $data = array('evaluation_status' => $status);
        $this->db->where('employee_evaluation_id', $id);
        return $this->db->update('pe_evaluation_table', $data);
    }

    public function updateSupervisorRecord($id, $data){
        $this->db->where('performance_id', $id);
        return $this->db->update('pe_evaluation_history_id', $data);
    }

    public function getEmployeeID($id){
        $q = $this->db->select('employee_id')
        ->from('pe_evaluation_table')
        ->join('employee_table', 'employee_table.main_employee_id = pe_evaluation_table.employee_id')
        ->where('pe_evaluation_table.employee_evaluation_id', $id)
        ->group_by('pe_evaluation_table.employee_evaluation_id')
        ->get();
        return $q->row();
    }

    public function getEmployeeDetails($id){
        $q = $this->db->select('*')
            ->from('employee_table')
            ->join('spectrum_table', 'employee_table.emp_level = spectrum_table.employee_level')
            ->join('departments', 'departments.department_id = employee_table.employee_department')
            ->join('designation', 'designation.designation_id = employee_table.employee_designation')
            ->join('employee_level', 'spectrum_table.employee_level = employee_level.employee_level_id')
            ->join('employee_sub_level', 'employee_level.employee_level_id = employee_sub_level.level_id')
            ->where('main_employee_id', $id)
            ->get();
        return $q->row();
    }

    public function fatchEmployeeEvaluationHistory($evaluation_id, $supervisor_id){
        $q = $this->db->select('*')
        ->from('pe_evaluation_table')
        ->join('employee_table', 'employee_table.main_employee_id = pe_evaluation_table.employee_id')
        ->join('spectrum_table','spectrum_table.employee_level = employee_table.emp_level')
        ->join('employee_history', 'employee_history.history_employee_id = pe_evaluation_table.employee_evaluation_id')
        ->join('pe_assign_employee', 'employee_table.main_employee_id = pe_assign_employee.assign_employee_id', 'left')

        ->where('pe_assign_employee.assign_supervisor_id', $supervisor_id)
        ->where('pe_evaluation_table.employee_evaluation_id', $evaluation_id)
        ->get();
        return $q->result_array();    

    }
    

}
?>