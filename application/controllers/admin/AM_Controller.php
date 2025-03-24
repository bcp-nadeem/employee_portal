<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
class AM_Controller extends CI_Controller {
    function __construct() {
        parent::__construct();
        
        // Load models and libraries first
        $this->load->model('admin_model/Admin_model', 'am');  // Make sure this matches the model filename
        $this->load->model('supervisor_model/Supervisor_model', 'sm');  // Make sure this matches the model filename
        $this->load->model('employee_model/Employee_model', 'em');  // Make sure this matches the model filename

        // $this->load->model('Login_model', 'lm');
        // $this->load->model('Performance_Evaluation_model', 'pe');
        // $this->load->model('Employee_model', 'em');
        $this->load->library(['pagination', 'form_validation']);

        // Check authentication after loading dependencies
        if(!$this->session->userdata('logged_in') || $this->session->userdata('user_role') != 3) {
            $this->session->set_flashdata('error', 'Access denied. Admin privileges required.');
            redirect('auth/login');
        }
    }

    function index() {
        $menuControl = $this->session->userdata('user_role');
        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('admin/dashboard');
        $this->load->view('include/scripts');
        $this->load->view('include/footer');
    }

//------------------------------------------------------------------------------------------

    // Add Deparment Page View

    public function addDepartment(){
        $menuControl = $this->session->userdata('user_role');
        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('admin/add-department');
        $this->load->view('include/scripts');
        $this->load->view('include/footer');
	}

    // Deparment Data Submit

    function submitDepartment(){
        $data['department_name'] = $this->input->post('department_name');
		$data['department_status'] = $this->input->post('department_status');
        $data['date_created'] = date('Y-m-d');

		if($this->am->uploadDepartment($data)){
			$this->session->set_flashdata('success', 'Uploaded Successfully!!!');
			redirect('admin/AM_Controller/addDepartment');
		}else{
			$this->session->set_flashdata('error', 'Please Try Again!');
			redirect('admin/AM_Controller/addDepartment');
		}
    }

    // Deparment List View

    public function departmentList(){
        $config=[
			'base_url' => base_url('admin/AM_Controller/departmentList'),
			'per_page' =>25,
			'total_rows' => $this->am->num_rows_departments(),
			'full_tag_open'=>"<ul class='pagination'>",
			'full_tag_close'=>"</ul>",
			'next_tag_open' =>"<li>",
			'next_tag_close' =>"</li>",
			'prev_tag_open' =>"<li>",
			'prev_tag_close' =>"</li>",
			'num_tag_open' =>"<li>",
			'num_tag_close' =>"<li>",
			'cur_tag_open' =>"<li class='active'><a>",
			'cur_tag_close' =>"</a></li>"
		  ];
	
		  $this->pagination->initialize($config);
		  $data['departmentdata'] = $this->am->fatchDepartmentList($config['per_page'],$this->uri->segment(3));

            // echo '<pre>'; print_r($data); echo '</pre>';exit;
            $data['pagination'] = $this->pagination->create_links();

            $menuControl = $this->session->userdata('user_role');
            $this->load->view('include/header');
            $this->load->view('include/left-navbar', $menuControl);
            $this->load->view('admin/department-list', $data);
            $this->load->view('include/scripts');
            $this->load->view('include/footer');
	}

    // Deparment Data Edit & Submit

    public function deleteDepartmentData(){
		$id = $this->input->post('department_id');
		$result = $this->am->deleteDepDB($id);
		if($result){
			$this->session->set_flashdata('dep_delete_success', 'Department Detail Deleted Successfully!!!');
			redirect('admin/AM_Controller/departmentList');
		}else{
			$this->session->set_flashdata('dep_not_deleted', 'Please Try Again!');
			redirect('admin/AM_Controller/departmentList');
		}
	}

    public function updateDepartmentData(){

		$department_id = $this->input->post('department_id');
		$data = $this->input->post();

		$res = $this->am->updateDepartmentInfo($department_id, $data);
		if($res){
			$this->session->set_flashdata('dep_update_success', 'Department Details Update Successfully!!!');
			redirect('admin/AM_Controller/departmentList');
		}else{
			$this->session->set_flashdata('dep_update_try_again', 'Please Try Again!');
			redirect('admin/AM_Controller/departmentList');
		}

	}


//------------------------------------------------------------------------------------------

    // Add Designation Page View

    public function addDesignation(){
        $menuControl = $this->session->userdata('user_role');
        $data['departments'] = $this->am->getDepartments();

        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('admin/add-designation', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');
	}

    // Designation Data Submit

    public function postDesignationData(){

		$data['designation_name'] = $this->input->post('designation_name');
		$data['department_id'] = $this->input->post('department_id');
		$data['designation_status'] = $this->input->post('designation_status');
		$data['date_created'] = date('Y-m-d');

        // echo '<pre>'; print_r($data); echo '</pre>';exit;

		if($this->am->uploadDesignation($data)){
			$this->session->set_flashdata('success', 'Uploaded Successfully!!!');
			redirect('admin/AM_Controller/addDesignation');
		}else{
			$this->session->set_flashdata('error', 'Please Try Again!');
			redirect('admin/AM_Controller/addDesignation');
		}
	}

    // Designation List View


    public function designationList(){
		
		$config=[
			'base_url' => base_url('AM_Controller/designationList'),
			'per_page' =>25,
			'total_rows' => $this->am->num_rows_designation(),
			'full_tag_open'=>"<ul class='pagination'>",
			'full_tag_close'=>"</ul>",
			'next_tag_open' =>"<li>",
			'next_tag_close' =>"</li>",
			'prev_tag_open' =>"<li>",
			'prev_tag_close' =>"</li>",
			'num_tag_open' =>"<li>",
			'num_tag_close' =>"<li>",
			'cur_tag_open' =>"<li class='active'><a>",
			'cur_tag_close' =>"</a></li>"
		  ];
	
		  $this->pagination->initialize($config);
		  $data['designationdata'] = $this->am->designationListData($config['per_page'],$this->uri->segment(3));
          $data['departments'] = $this->am->getDepartments();

            $menuControl = $this->session->userdata('user_role');
            $this->load->view('include/header');
            $this->load->view('include/left-navbar', $menuControl);
            $this->load->view('admin/designation-list', $data);
            $this->load->view('include/scripts');
            $this->load->view('include/footer');

	}

    // Designation Data Edit & Submit

    public function deleteDesignationData(){

		$id = $this->input->post('designation_id');
		$result = $this->am->deleteDesDB($id);
		if($result){
			$this->session->set_flashdata('success', 'Designation Detail Deleted Successfully!!!');
			redirect('admin/AM_Controller/designationList');
		}else{
			$this->session->set_flashdata('error', 'Please Try Again!');
			redirect('admin/AM_Controller/designationList');
		}

	}

	public function updateDesignationData(){
 
		$Id_department = $this->input->post('main_department_id'); // 2
		$Id_designation = $this->input->post('designation_id'); // 2

		if($this->input->post('department_id')){
			$data['department_id'] = $this->input->post('department_id'); // 2
		}else{
			$data['department_id'] =  $this->input->post('main_department_id'); // 2
		}

		$data['designation_name'] = $this->input->post('designation_name');
		$data['designation_status'] = $this->input->post('designation_status');
		
		$res = $this->am->updateDesignationInfo($Id_department,$Id_designation, $data);

		if($res){
			$this->session->set_flashdata('success', 'Designation Details Update Successfully!!!');
			redirect('admin/AM_Controller/designationList');
		}else{
			$this->session->set_flashdata('error', 'Please Try Again!');
			redirect('admin/AM_Controller/designationList');
		}

	}

//------------------------------------------------------------------------------------------

    // Add Spectrum Page View


    public function addSpectrum(){
        $menuControl = $this->session->userdata('user_role');
        $data['employee_levels'] = $this->am->getEmployeeLevels();
        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('admin/add-spectrum', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');
    }

    // Spectrum Data Submit

       function addSpectrumInDB(){
        
        $data['employee_level'] = $this->input->post('emp_level');

        $data['employee_sub_level'] = $this->input->post('emp_sub_level');
        if($data['employee_sub_level'] == ''){
            $data['employee_sub_level'] = 0;
        }
        $data['spectrum_color_name'] = $this->input->post('spectrum_name');
        $color_code = $this->input->post('spectrum_color');
        $data['spectrum_color_code'] = ltrim($color_code, '#');

        // echo '<pre>'; print_r($data); echo '</pre>';exit;

        $res = $this->am->insertSpectrumRecord($data);

        if($res){
            echo 'working';
            $this->session->set_flashdata('success', 'Spectrum Added Successfully');
            return redirect('admin/AM_Controller/addSpectrum');
        }else{
            $this->session->set_flashdata('error', 'Spectrum Added Successfully');
            return redirect('admin/AM_Controller/addSpectrum');
        }

     }

    // Spectrum List View

    function viewSpectrumList(){
    
        $menuControl = $this->session->userdata('user_role');
        $data['spectrums'] = $this->am->getSpectrumList();
        $data['employee_levels'] = $this->am->getEmployeeLevels();

        $data['table_name'] = 'spectrum_table';
        $data['function_url'] = 'admin/AM_Controller/getSpectrumListRecords';
        $columns = [
            ['data' => 0, 'title' => 'Spectrum', 'filterType' => 'text'],
            ['data' => 1, 'title' => 'Level', 'filterType' => 'select'],
            ['data' => 2, 'title' => 'Sub Level', 'filterType' => 'select'],
            ['data' => 3, 'title' => 'STATUS', 'filterType' => 'select'],
            ['data' => 4, 'title' => 'Date', 'filterType' => 'date'],
            ['data' => 5, 'title' => 'Actions', 'orderable' => false, 'filterable' => false]
        ];
        $data['columns'] = $columns;

        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('admin/spectrum-list', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');
        $this->load->view('include/datatable', $data);
    }

    public function getSpectrumListRecords() {

        $levels = $this->am->getEmployeeLevels();

        $resultList = $this->am->fatchSpectrumListRecords();
        
        // Initialize response array with DataTables structure
        $response = array(
            "draw" => intval($this->input->get('draw')),
            "recordsTotal" => count($resultList),
            "recordsFiltered" => count($resultList),
            "data" => array()
        );

        // $levelOptions = '<option value="'.$value['employee_level'].'" selected>'.$value['employee_level_name'].'</option>';
    
        foreach($levels as $level) {
            $levelOptions = '<option value="'.$level->employee_level_id.'">'.$level->employee_level_name.'</option>';
        }
    
        foreach ($resultList as $value) {
            $button = '<div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editSpectrumModal'.$value['spectrum_id'].'">
                        <i class="bx bx-edit-alt me-1"></i> Edit
                    </a>
                    <a class="dropdown-item text-danger" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deleteSpectrumModal'.$value['spectrum_id'].'">
                        <i class="bx bx-trash me-1"></i> Delete
                    </a>
                </div>
            </div>
    
            <!-- Delete Modal -->
            <div class="modal fade" id="deleteSpectrumModal'.$value['spectrum_id'].'" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Spectrum</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this spectrum?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form action="'.base_url('admin/AM_Controller/deleteSpectrum').'" method="POST">
                                <input type="hidden" name="spectrum_id" value="'.$value['spectrum_id'].'">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>';
    
            $color_code = '<div class="d-flex align-items-center gap-2">
                <div style="width: 30px; height: 20px; background-color: #'.$value['spectrum_color_code'].'; border: 1px solid #ddd;"></div>
                <span>'.$value['spectrum_color_name'].'</span>
            </div>';

            if($value['spectrum_status'] == 1){
                $spectrum_status = 'Active';
            }else{
                $spectrum_status = 'Inactive';
            }
    
            $response['data'][] = array(
                $color_code,
                $value['employee_level_name'],
                $value['employee_sub_level_name'],
                $spectrum_status,
                date('Y-m-d', strtotime($value['date_created'])),
                $button
            );
        }
    
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    // Spectrum Data Edit & Submit

    public function getSpectrumByLevel() {
        if($this->input->is_ajax_request()) {
            $level_id = $this->input->post('employee_level');
            $sub_level_id = $this->input->post('employee_sub_level');
            
            // Add error reporting
            try {
                $spectrums = $this->am->getSpectrumsByLevel($level_id, $sub_level_id);
                echo json_encode($spectrums);
            } catch (Exception $e) {
                log_message('error', $e->getMessage());
                echo json_encode(['error' => 'Failed to fetch spectrum data']);
            }
        }
    }

    // Spectrum Data Edit & Submit

    public function updateSpectrum(){
        $spectrum_id['spectrum_id'] = $this->input->post('spectrum_id');

        // $data['employee_level'] = $this->input->post('emp_level');
        // $data['employee_sub_level'] = $this->input->post('emp_sub_level');
        $data['spectrum_color_name'] = $this->input->post('spectrum_name');


        $color_code = $this->input->post('spectrum_color');
        $data['spectrum_color_code'] = ltrim($color_code, '#');


        $data['spectrum_status'] = $this->input->post('spectrum_status');

        // echo '<pre>'; print_r($data); echo '</pre>';exit;

        $res = $this->am->updateSpectrumRecord($spectrum_id['spectrum_id'], $data);

        if($res){
            $this->session->set_flashdata('success', 'Spectrum Updated Successfully');
            return redirect('admin/AM_Controller/viewSpectrumList');
        }else{
            $this->session->set_flashdata('error', 'Spectrum Updated Successfully');
            return redirect('admin/AM_Controller/viewSpectrumList');
        }
    }

    public function deleteSpectrum(){
        $spectrum_id['spectrum_id'] = $this->input->post('spectrum_id');
        $res = $this->am->deleteSpectrumRecord($spectrum_id['spectrum_id']);
        if($res){
            $this->session->set_flashdata('success', 'Spectrum Deleted Successfully');
            return redirect('admin/AM_Controller/viewSpectrumList');
        }else{
            $this->session->set_flashdata('error', 'Spectrum Deleted Successfully');
            return redirect('admin/AM_Controller/viewSpectrumList');
        }
    }

//------------------------------------------------------------------------------------------

    // Add Employee Page View

    public function addEmployee(){
        $menuControl = $this->session->userdata('user_role');
        $data['countries'] = $this->am->getCountries();
        $data['departments'] = $this->am->getEmpDepartment();
        $data['employee_levels'] = $this->am->getEmployeeLevels();
        // $data['spectrums'] = $this->am->getSpectrums();

        // echo '<pre>'; print_r($data); echo '</pre>';exit;
        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('admin/add-employee', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');
    }

        public function getSubLevels(){
        if($this->input->is_ajax_request()) {
            $level_id = $this->input->post('level_id');
            $sub_levels = $this->am->getSubLevelsByLevelId($level_id);
            echo json_encode($sub_levels);
        }
    }


    public function getUserRole(){
        if($this->input->is_ajax_request()) {
            $level_id = $this->input->post('level_id');
            $sub_levels = $this->am->getUserRoleData($level_id);
            echo json_encode($sub_levels);
        }
    }
    // Employee Data Submit

	public function checkValidAccount(){
		$this->form_validation->set_rules('email','Email Id','is_unique[employee_table.employee_email]');
		if($this->form_validation->run()==FALSE){
			echo json_encode(1);
		}else{
			echo json_encode(2);
		}
	}

    function fetchDepartmentDrop(){
		if($this->input->post('department_id')){
		 echo $this->am->fetchDepartmentList($this->input->post('department_id'));
		}
	}

    public function addDepartmentDynamic() {
        $department_name = $this->input->post('department_name');
        
        $data = array(
            'department_name' => $department_name,
            'date_created' => date('Y-m-d H:i:s')
        );
        
        $this->db->insert('departments', $data);
        $department_id = $this->db->insert_id();
        
        if($department_id) {
            echo json_encode(array('status' => 'success', 'department_id' => $department_id));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }

    public function addDesignationDynamic() {
        $designation_name = $this->input->post('designation_name');  // Match the AJAX data field name
        $department_id = $this->input->post('department_id');  // Match the AJAX data field name
        
        // Debug incoming data
        log_message('debug', 'Designation Name: ' . $designation_name . ', Department ID: ' . $department_id);
        
        if(empty($designation_name) || empty($department_id)) {
            echo json_encode(array(
                'status' => 'error', 
                'message' => 'Missing required fields',
                'received' => array(
                    'designation_name' => $designation_name,
                    'department_id' => $department_id
                )
            ));
            return;
        }
        
        $data = array(
            'designation_name' => $designation_name,
            'department_id' => $department_id,
            'designation_status' => 1,  // Add default status
            'date_created' => date('Y-m-d H:i:s')
        );
        
        try {
            $this->db->insert('designation', $data);
            $designation_id = $this->db->insert_id();
            
            if($designation_id) {
                echo json_encode(array(
                    'status' => 'success', 
                    'designation_id' => $designation_id,
                    'designation_name' => $designation_name
                ));
            } else {
                echo json_encode(array(
                    'status' => 'error', 
                    'message' => 'Failed to add designation'
                ));
            }
        } catch (Exception $e) {
            log_message('error', 'Designation insertion error: ' . $e->getMessage());
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Database error occurred'
            ));
        }
    }

    public function getDepartments() {
        // Check for AJAX request
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
    
        try {
            // Get departments from model
            $departments = $this->am->getAllActiveDepartments();
            
            // Return JSON response
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'data' => $departments
            ]);
        } catch (Exception $e) {
            // Log the error
            log_message('error', 'Failed to fetch departments: ' . $e->getMessage());
            
            // Return error response
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to fetch departments'
            ]);
        }
    }
    
    public function addDepartments() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
    
        $department_name = $this->input->post('department_name');
        
        if (empty($department_name)) {
            echo json_encode(['status' => 'error', 'message' => 'Department name is required']);
            return;
        }
    
        $result = $this->am->insertDepartment(['department_name' => $department_name]);
        
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Department added successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add department']);
        }
    }

    // Main function for submitting

    public function postEmployeeData() {
        // Image upload configuration
        $config = [
            'upload_path' => './upload',
            'allowed_types' => 'jpg|jpeg|png',
            'max_size' => 2048, // 2MB max
            'file_name' => 'proimg_' . time(),
            'maintain_ratio' => TRUE,
            'max_width' => 1600,
            'max_height' => 800
        ];
    
        // Prepare employee data
        $data = [
            'employee_first_name' => $this->input->post('employee_first_name'),
            'employee_last_name' => $this->input->post('employee_last_name'),
            'employee_email' => $this->input->post('employee_email'),
            'employee_number' => $this->input->post('employee_number'),
            'employee_address' => $this->input->post('employee_address'),
            'employee_city' => $this->input->post('employee_city'),
            'employee_country_id' => $this->input->post('employee_country'),
            'employee_department' => $this->input->post('employee_department'),
            'employee_designation' => $this->input->post('employee_designation'),
            'employee_doj' => $this->input->post('employee_doj'),
            'employee_dot' => $this->input->post('employee_dot'),
            'emp_level' => $this->input->post('emp_level'),
            'user_role' => $this->input->post('user_role'),
            'emp_password' => password_hash($this->input->post('emp_password'), PASSWORD_DEFAULT),
            'emp_sub_level' => $this->input->post('emp_sub_level') ?: 0
        ];

        // echo '<pre>'; print_r($data); echo '</pre>';exit;

        if((!empty($_FILES['employee_image']['name']))){
            $check = uploadimgfile("employee_image",$folder="upload",$prefix="proimg_");
            $link  = $check['data']['name'];
            $data['employee_image'] = $link;
        }

        $this->load->library('upload', $config);
        $this->upload->do_upload();

    
        // Insert employee data

        $emp_id = $this->am->uploadEmpDetails($data);

        if($emp_id){
            $history_data = [
                'history_department_id' => $this->input->post('employee_department'),
                'history_designation_id' => $this->input->post('employee_designation'),
                'employee_id' => $emp_id,
                'history_spectrum_id' => $this->input->post('employee_spectrum_id'),
                'history_emp_level' => $this->input->post('emp_level'),
                'history_emp_sub_level' => $this->input->post('emp_sub_level') ?: 0,
                'history_user_role' => $this->input->post('user_role') ?: 0,
                'history_modification_date' => date('Y-m-d H:i:s'),
                'history_status' => 1
            ];
            
            if ($this->am->insertProfileHistory($history_data)) {
                $this->session->set_flashdata('success', 'Employee added successfully');
                redirect('admin/AM_Controller/addEmployee');
            } else {
                $this->session->set_flashdata('error', 'Failed to add employee. Please try again.');
                redirect('admin/AM_Controller/addEmployee');
            }
        }
        
    }

    // Employee List View

    public function viewEmployeeList(){
        $menuControl = $this->session->userdata('user_role');
        $data['table_name'] = 'employee_table';
        $data['function_url'] = 'admin/AM_Controller/getEmployeeRecords';
        $columns = [
            ['data' => 0, 'title' => 'EMPLOYEE', 'filterType' => 'text'],
            ['data' => 1, 'title' => 'EMAIL', 'filterType' => 'select'],
            ['data' => 2, 'title' => 'Level', 'filterType' => 'select'],
            ['data' => 3, 'title' => 'DESIGNATION', 'filterType' => 'select'],
            ['data' => 4, 'title' => 'DATE OF JOINING', 'filterType' => 'date'],
            ['data' => 5, 'title' => 'STATUS', 'filterType' => 'select'],
            ['data' => 6, 'title' => 'Actions', 'orderable' => false, 'filterable' => false]
        ];
        $data['columns'] = $columns;

        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('admin/employee-list', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');
        $this->load->view('include/datatable', $data);
    }

   // Get Employee List

    public function getEmployeeRecords(){
        $resultList = $this->am->fetchAllData('*','employee_table');
        $result = array();
        $i = 1;
        foreach ($resultList as $key => $value) {

            $button = '<div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
    
                </div>
            </div>';

            $Img = '<div class="avatar-edit">
                        <img src="'.base_url($value['employee_image']).'" alt="admin profile" class="w-px-40 h-auto rounded-circle">&nbsp;
                        <a href="'.base_url("admin/AM_Controller/viewEmployeeProfile/".$value['main_employee_id']).'"><strong>'.$value['employee_first_name'].' <i class="bx bx-link"></i></strong></a>
                    </div>';


            if(($value['employee_status'])==1){
                $status = 'Active';
            }else{
                $status = 'Inactive';
            }
            
            $result['data'][] = array(
                $Img,
                $value['employee_email'],
                $value['employee_level_name'],
                $value['designation_name'],
                $value['employee_doj'],
                $status,
                $button
            );
        }
        echo json_encode($result);
    }


    public function viewEmployeeProfile($id){
        $menuControl = $this->session->userdata('user_role');
        $this->load->library('encryption');

        $data['empdata'] = $this->am->getEmployeeRecordIndiv($id);

        $data['countries'] = $this->am->getCountries();
        $data['departments'] = $this->am->getEmpDepartment();
        $data['employee_levels'] = $this->am->getEmployeeLevels();

        $history_data['employee_history'] = $this->am->getEmployeeHistory($id);

        if(empty($history_data['employee_history'])){
            $data['current_employee_history'] = $data['empdata'];
        }else{
            $data['employee_history'] = $history_data['employee_history'];
        }

        // echo '<pre>'; print_r($data); echo '</pre>';exit;

        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('admin/employee-profile-page', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');

    }

    public function deleteHistoryRecord(){
        $id = $this->input->post('history_employee_id');
        $result = $this->am->deleteHistoryDB($id);
        if($result){
            $this->session->set_flashdata('success', 'History Detail Deleted Successfully!!!');
            redirect('admin/AM_Controller/viewEmployeeProfile/'.$this->input->post('employee_id'));
        }else{
            $this->session->set_flashdata('error', 'Please Try Again!');
            redirect('admin/AM_Controller/viewEmployeeProfile/'.$this->input->post('employee_id'));
        }
    }

    // Employee Data Edit & Submit

    public function editEmployeeProfileSubmit() {
        $emp_id = $this->input->post('main_employee_id');
        
        // Get current employee data as object
        $employeeOldData = $this->am->getEmployeeRecordIndiv($emp_id);
        
        // Continue with regular profile update
        $empData = array(
            'employee_first_name' => $this->input->post('employee_first_name'),
            'employee_last_name' => $this->input->post('employee_last_name'),
            'employee_email' => $this->input->post('employee_email'),
            'employee_number' => $this->input->post('employee_number'),
            'employee_address' => $this->input->post('employee_address'),
            'employee_city' => $this->input->post('employee_city'),
            'employee_country_id' => $this->input->post('employee_country'),
            'employee_department' => $this->input->post('department_id'),
            'employee_designation' => $this->input->post('designation_id'),
            'employee_doj' => $this->input->post('employee_doj'),
            'employee_dot' => $this->input->post('employee_dot'),
            'emp_level' => $this->input->post('emp_level'),
            'user_role' => $this->input->post('user_role'),
            'emp_sub_level' => $this->input->post('emp_sub_level') ?: 0
        );
    
        // Update profile
        if ($this->am->updateEmployeeProfile($emp_id, $empData)) {

            // Check for changes requiring history
            if ($employeeOldData->employee_department != $this->input->post('department_id') ||
                $employeeOldData->employee_designation != $this->input->post('designation_id') ||
                $employeeOldData->emp_level != $this->input->post('emp_level') ||
                $employeeOldData->emp_sub_level != ($this->input->post('emp_sub_level') ?: 0) ||
                $employeeOldData->user_role != $this->input->post('user_role')) {
                
                // Store history data in session
                $historyData = array(
                    'history_department_id' => $this->input->post('department_id'),
                    'history_designation_id' => $this->input->post('designation_id'),
                    'employee_id' => $emp_id,
                    'history_spectrum_id' => $this->input->post('employee_spectrum_id'),
                    'history_emp_level' => $this->input->post('emp_level'),
                    'history_emp_sub_level' => $this->input->post('emp_sub_level') ?: 0,
                    'history_user_role' => $this->input->post('user_role') ?: 0,
                    'history_modification_date' => date('Y-m-d H:i:s'),
                    'history_status' => 1
                );

                // echo '<pre>'; print_r($historyData); echo '</pre>';exit;
                
                $this->session->set_userdata('pending_history', $historyData);
                $this->session->set_flashdata('show_history_approval', true);
            }
    
            $this->session->set_flashdata('success', 'Employee Details Updated Successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to update employee details');
        }
    
        redirect('admin/AM_Controller/viewEmployeeProfile/'.$emp_id);
    }

    public function confirmHistoryUpdate() {
        $historyData = $this->session->userdata('pending_history');
        
        if ($historyData && $this->input->post('approve_history') === 'yes') {
            // Insert history record
            $result = $this->am->insertProfileHistory($historyData);
            if ($result) {
                $this->session->set_flashdata('success', 'Profile history updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to update profile history');
            }
        }
        
        // Clear session data
        $this->session->unset_userdata('pending_history');
        
        redirect('admin/AM_Controller/viewEmployeeProfile/'.$historyData['employee_id']);
    }

    public function getDesignationsByDepartment() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
    
        $department_id = $this->input->post('department_id');
        
        if (!$department_id) {
            echo json_encode([]);
            return;
        }
    
        try {
            $designations = $this->am->getDesignationsByDepartmentId($department_id);
            header('Content-Type: application/json');
            echo json_encode($designations);
        } catch (Exception $e) {
            log_message('error', 'Failed to fetch designations: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode([]);
        }
    }
//------------------------------------------------------------------------------------------

        // Add Salary Page View
        public function addSalary(){
            $menuControl = $this->session->userdata('user_role');

            $this->load->library('encryption');
		    $data['salary'] = $this->am->EmployeeSalaryListData();
		    $data['employee_record'] = $this->am->getEmployeeRecord();

            $this->load->view('include/header');
            $this->load->view('include/left-navbar', $menuControl);
            $this->load->view('admin/employee-salary', $data);
            $this->load->view('include/scripts');
            $this->load->view('include/footer');
        }
    
        public function employeeSalary(){
            $this->load->library("encryption");
            $menuControl = $this->session->userdata('user_role');
            $data['table_name'] = 'employee_salary_table';
            $data['function_url'] = 'admin/AM_Controller/getEmployeeSalaryRecords';
            $columns = [
                ['data' => 0, 'title' => 'Employee', 'filterType' => 'text'],
                ['data' => 1, 'title' => 'Salary Type', 'filterType' => 'select'],
                ['data' => 2, 'title' => 'Salary Currency', 'filterType' => 'select'],
                ['data' => 3, 'title' => 'Basic Salary', 'filterType' => 'text'],
                ['data' => 4, 'title' => 'Allowance', 'filterType' => 'text'],
                ['data' => 5, 'title' => 'Salary Date', 'filterType' => 'date'],
                ['data' => 6, 'title' => 'Status', 'filterType' => 'select'],
                ['data' => 7, 'title' => 'Actions', 'orderable' => false, 'filterable' => false]
            ];
            $data['columns'] = $columns;
    
            $data['employees'] = $this->am->getEmployeeRecord();
    
            $data['salaries'] = $this->am->getEmployeeSalaryRecord();
    
    
            // echo '<pre>'; print_r($data); echo '</pre>';exit;
    
            $this->load->view('include/header');
            $this->load->view('include/left-navbar', $menuControl);
            $this->load->view('admin/employee-salary', $data);
            $this->load->view('include/scripts');
            $this->load->view('include/footer');
            $this->load->view('include/datatable', $data);
        }
    
        public function addEmployeeSalary() {
            // Load encryption library
            $this->load->library("encryption");
            
    
                // Encrypt salary data
                $encrypted_basic = $this->encryption->encrypt($this->input->post('basic_salary'));
                $encrypted_allowance = $this->encryption->encrypt($this->input->post('allowance'));
    
    
                // Prepare data array
                $data = array(
                    'employee_id' => $this->input->post('employee_id'),
                    'basic_salary' => $encrypted_basic,
                    'allowance' => $encrypted_allowance,
                    'salary_currency' => $this->input->post('salary_currency'),
                    'salary_date' => $this->input->post('salary_date'),
                    'salary_type' => $this->input->post('salary_type'),
                    'salary_reason' => $this->input->post('salary_reason'),
                    'salary_status' => $this->input->post('salary_status'),
                    'date_created' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('user_id')
                );
    
    
                // Insert salary record
                $result = $this->am->insertEmployeeSalary($data);
    
                if ($result) {
                    $this->session->set_flashdata('success', 'Salary details added successfully');
                } else {
                    $this->session->set_flashdata('error', 'Failed to add salary details');
                }
    
                redirect('admin/AM_Controller/employeeSalary');
    
        }
    
    
        public function getEmployeeSalaryRecords(){
    
            // Load encryption library
            $this->load->library("encryption");
    
            $data['employees'] = $this->am->getEmployeeRecord();
            $resultList = $this->am->fetchEmployeeSalary();
    
            $result = array('data' => array());
            
            foreach ($resultList as $value) {
    
    
                $button = '<div class="dropdown">
    
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editSalaryModal'.$value['salary_id'].'"><i class="bx bxs-edit-alt"></i> Edit</a>
                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deleteSalaryModal'.$value['salary_id'].'"><i class="bx bx-trash me-1"></i> Delete</a>
                    </div>
    
    
                     <!-- Delete Modal -->
                        <div class="modal fade" id="deleteSalaryModal'.$value['salary_id'].'" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete Salary</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this salary?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="'.base_url('admin/AM_Controller/deleteSalaryRecord').'" method="POST">
                                        <input type="hidden" name="employee_id" value="'.$value['employee_id'].'">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
    
                </div>';
        
                $Img = '<div class="avatar-edit">
                    <img src="'.base_url($value['employee_image']).'" alt="admin profile" class="w-px-40 h-auto rounded-circle">&nbsp;
                    <a href="'.base_url('admin/AM_Controller/viewEmployeeProfile/'.$value['main_employee_id']).'"><strong>'.$value['employee_first_name'].' '.$value['employee_last_name'].' <i class="bx bx-link"></i></strong></a>
                    </div>';
        
                $status = ($value['salary_status'] == 1) ? 'Active' : 'Inactive';
    
                $basic_salary = $this->encryption->decrypt(($value['basic_salary']));
                $allowance = $this->encryption->decrypt($value['allowance']);
        
                $result['data'][] = array(
                    $Img,
                    $value['salary_type'],
                    $value['salary_currency'],
                    $basic_salary,
                    $allowance,
                    $value['salary_date'],
                    $status,
                    $button
                );
            }
            
            echo json_encode($result);
    
        }
    
        public function submitEditEmployeeSalary(){
    
            $this->load->library("encryption");
    
                $id = $this->input->post('employee_id');
    
                // Encrypt salary data
                $encrypted_basic = $this->encryption->encrypt($this->input->post('basic_salary'));
                $encrypted_allowance = $this->encryption->encrypt($this->input->post('allowance'));
    
    
                // Prepare data array
                $data = array(
                    'employee_id' => $this->input->post('employee_id'),
                    'basic_salary' => $encrypted_basic,
                    'allowance' => $encrypted_allowance,
                    'salary_currency' => $this->input->post('salary_currency'),
                    'salary_date' => $this->input->post('salary_date'),
                    'salary_type' => $this->input->post('salary_type'),
                    'salary_reason' => $this->input->post('salary_reason'),
                    'salary_status' => $this->input->post('salary_status'),
                    'date_created' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('user_id')
                );
    
                // echo '<pre>'; print_r($data); echo '</pre>';exit;
    
                // updatet salary record
                $result = $this->am->updateEmployeeSalary($id, $data);
    
                if ($result) {
                    $this->session->set_flashdata('success', 'Salary record updated added successfully');
                } else {
                    $this->session->set_flashdata('error', 'Failed to add salary details');
                }
    
                redirect('admin/AM_Controller/employeeSalary');
    
        }
    
        public function deleteSalaryRecord(){
    
            $employee_id = $this->input->post('employee_id');
    
            // echo '<pre>'; print_r($employee_id); '</pre>'; exit;
    
            $res = $this->am->deleteSalaryRecordDB($employee_id);
    
            if ($res) {
                $this->session->set_flashdata('success', 'Salary details deleted successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to add salary details');
            }
    
            redirect('admin/AM_Controller/employeeSalary');
            
        }

//------------------------------------------------------------------------------------------

      // Add Section Page View
      public function addSection(){
        $menuControl = $this->session->userdata('user_role');
        $data['employee_levels'] = $this->am->getEmployeeLevels();
        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('admin/add-sections', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');
    }

    // Section Data Submit

    function addSectionInEvaluationForm(){

        $data['spectrum_id'] = $this->input->post('employee_spectrum_id');
        $data['section_name'] = $this->input->post('section_name');

        $res = $this->am->insertSectionRecord($data);

        if($res){
            $this->session->set_flashdata('success', 'Section Added Successfully!!!');
            redirect('admin/AM_Controller/addSection');
        }else{
            $this->session->set_flashdata('error', 'Failed to add section. Please try again.');
            redirect('admin/AM_Controller/addSection');
        }

    }

    // Section List View

    public function getSectionList(){
        $menuControl = $this->session->userdata('user_role');
        $data['table_name'] = 'section_table';
        $data['function_url'] = 'admin/AM_Controller/getSectionRecords';
        $columns = [
            ['data' => 0, 'title' => 'Section Name', 'filterType' => 'text'],
            ['data' => 1, 'title' => 'Spectrum Color', 'filterType' => 'select'],
            ['data' => 2, 'title' => 'Employee Level', 'filterType' => 'select'],
            ['data' => 3, 'title' => 'Employee Sub Level', 'filterType' => 'select'],
            ['data' => 4, 'title' => 'Post Date', 'filterType' => 'date'],
            ['data' => 5, 'title' => 'Last Changes', 'filterType' => 'date'],
            ['data' => 6, 'title' => 'Actions', 'orderable' => false, 'filterable' => false]
        ];
        $data['columns'] = $columns;

        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('admin/section-list', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');
        $this->load->view('include/datatable', $data);

    }

    public function getSectionRecords(){

        $sections = $this->am->fetchSectionData();

        $sectionOptions = '';
        foreach ($sections as $section) {
           
                $sectionOptions = '<option value="'.$section->section_name.'">'.$section->section_name.'</option>';
           
        }

        $resultList = $this->am->fetchAllSectionData('*','pe_section_table');
        $result = array();
        $i = 1;
        foreach ($resultList as $key => $value) {

            $button = '<div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editSectionModal'.$value['section_id'].'">
                        <i class="bx bx-edit-alt me-1"></i> Edit
                    </a>
                    <a class="dropdown-item text-danger" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deleteSectionModal'.$value['section_id'].'">
                        <i class="bx bx-trash me-1"></i> Delete
                    </a>
                </div>
            </div>
            
            <div class="modal fade" id="editSectionModal'.$value['section_id'].'" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Spectrum</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="'.base_url('admin/AM_Controller/updateSelect').'" method="POST">
                            <div class="modal-body">
                                
                                <div class="mb-3">
                                <label class="form-label">Section <span class="isrequired">*</span></label>
                                    <select class="form-select" name="section_name" required>
                                        <option value="'.$value['section_name'].'" selected="'.$value['section_name'].'">'.$value['section_name'].'</option>
                                        '.$sectionOptions.'
                                    </select>
                                </div>

                                <input type="hidden" name="section_id" value="'.$value['section_id'].'">
                                

                                <div class="mb-3">
                                    <label class="form-label">Status <span class="isrequired">*</span></label>
                                    <select class="form-select" name="spectrum_status" required>
                                        <option value="1" '.($value['spectrum_status'] == 'Active' ? 'selected' : '').'>Active</option>
                                        <option value="0" '.($value['spectrum_status'] == 'Inactive' ? 'selected' : '').'>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Delete Modal -->
            <div class="modal fade" id="deleteSectionModal'.$value['section_id'].'" tabindex="-1" aria-hidden="true">

                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Spectrum</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this spectrum?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <a href="'.base_url('admin/AM_Controller/deleteSectionRecord/'.$value['section_id']).'" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>
            </div>';

            $result['data'][] = array(
                $value['section_name'],
                $value['spectrum_color_name'],
                $value['employee_level_name'],
                $value['employee_sub_level_name'],
                $value['date_created'],
                $value['modification_date'],
                $button
            );
        }
        echo json_encode($result);
    }

    // Section Data Edit & Submit

    
    public function updateSelect(){
        
        $section_id['section_id'] = $this->input->post('section_id');

        $data['section_name'] = $this->input->post('section_name');
        $data['modification_date'] = date('Y-m-d H:i:s');

        // echo '<pre>'; print_r($data); echo '</pre>';exit;


        $res = $this->am->updateSectionRecord($section_id['section_id'], $data);

        if($res){
            $this->session->set_flashdata('success', 'Section Updated Successfully');
            return redirect('admin/AM_Controller/getSectionList');
        }else{
            $this->session->set_flashdata('error', 'Section Updated Successfully');
            return redirect('admin/AM_Controller/getSectionList');
        }
        
    }

    public function deleteSectionRecord($section_id){

        $res = $this->am->deleteSectionRecordDB($section_id);

        if($res){
            $this->session->set_flashdata('success', 'Section Deleted Successfully');
            return redirect('admin/AM_Controller/getSectionList');
        }else{
            $this->session->set_flashdata('error', 'Failed to delete section. Please try again.');
            return redirect('admin/AM_Controller/getSectionList');
        }
    }
//------------------------------------------------------------------------------------------

        // Add Questions Page View
        public function addQuestion(){
            $menuControl = $this->session->userdata('user_role');

            $data['records'] = $this->am->getQuestionRecords();

            // echo '<pre>'; print_r($data); echo '</pre>';exit;

            $this->load->view('include/header');
            $this->load->view('include/left-navbar', $menuControl);
            $this->load->view('admin/add-questions', $data);
            $this->load->view('include/scripts');
            $this->load->view('include/footer');
        }

        public function getSectionsBySpectrum($spectrum_id) {
            $sections = $this->am->get_sections_by_spectrum($spectrum_id);
            
            // Add debug logging
            log_message('debug', 'Sections data: ' . json_encode($sections));
            
            header('Content-Type: application/json');
            echo json_encode(['sections' => $sections]);
        }

        // Questions Data Submit

        public function addQuestionRecords(){

            $data['spectrum_id'] = $this->input->post('spectrum_id');
            $data['section_id'] = $this->input->post('section_id');
            $data['question_weight_id'] = $this->input->post('question_weight_id');
            $data['question_value'] = $this->input->post('question_value');

            $res = $this->am->insertQuestionRecord($data);
            if($res){
                $this->session->set_flashdata('success', 'Question Added Successfully!!!');
                redirect('admin/AM_Controller/addQuestion');
            }else{
                $this->session->set_flashdata('error', 'Failed to add question. Please try again.');
                redirect('admin/AM_Controller/addQuestion');
            }
        }

        // Questions List View

        public function getQuestionList(){
            $menuControl = $this->session->userdata('user_role');
            $data['records'] = $this->am->getQuestionRecords();
            $data['question_records'] = $this->am->fetchAllQuestionDataModel('*','pe_question_table');

            // echo '<pre>'; print_r($data); echo '</pre>';exit;

            $data['table_name'] = 'question_table';
            $data['function_url'] = 'admin/AM_Controller/getQuestionRecords';
            $columns = [
                ['data' => 0, 'title' => 'Question', 'filterType' => 'text'],
                ['data' => 1, 'title' => 'Section', 'filterType' => 'select'],
                ['data' => 2, 'title' => 'Weight Value', 'filterType' => 'select'],
                ['data' => 3, 'title' => 'Spectrum', 'filterType' => 'select'],
                ['data' => 4, 'title' => 'Post Date', 'filterType' => 'date'],
                ['data' => 5, 'title' => 'Last Changes', 'filterType' => 'date'],
                ['data' => 6, 'title' => 'Actions', 'orderable' => false, 'filterable' => false]
            ];
            $data['columns'] = $columns;
    
            $this->load->view('include/header');
            $this->load->view('include/left-navbar', $menuControl);
            $this->load->view('admin/question-list', $data);
            $this->load->view('include/scripts');
            $this->load->view('include/footer');
            $this->load->view('include/datatable', $data);
    
        }

        public function getQuestionRecords(){
            $sections = $this->am->fetchSectionData();
            $sectionOptions = '';
            foreach ($sections as $section) {
                $sectionOptions = '<option value="'.$section->section_name.'">'.$section->section_name.'</option>';
            }
            
            $resultList = $this->am->fetchAllQuestionData('*','pe_question_table');
            $result = array();
            $i = 1;
            foreach ($resultList as $key => $value) {
    
                $button = '<div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editQuestionModal'.$value['question_id'].'">
                        <i class="bx bx-edit-alt me-1"></i> Edit
                    </a>
                    <a class="dropdown-item text-danger" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deleteQuestionModal'.$value['question_id'].'">
                        <i class="bx bx-trash me-1"></i> Delete
                    </a>
                </div>
            </div>
            
            <!-- Delete Modal -->
            <div class="modal fade" id="deleteQuestionModal'.$value['question_id'].'" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Spectrum</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this spectrum?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <a href="'.base_url('admin/AM_Controller/deleteQuestionRecord/'.$value['question_id']).'" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>
            </div>';

                $questionModel = '

                    <a class="dropdown-item text-primary text-center btn" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#showQuestionModal'.$value['question_id'].'">
                        <b>See Question</b>
                    </a>

                    <div class="modal fade" id="showQuestionModal'.$value['question_id'].'" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Question</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <hr>
                                <div class="modal-body">
                                <textarea name="" class="form-control" placeholder="" cols="20" id="" rows="10">'.$value['question_value'].'</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                
                ';
    
                $result['data'][] = array(
                    $questionModel,
                    $value['section_name'],
                    $value['question_weight_name'],
                    $value['spectrum_color_name'],
                    $value['date_created'],
                    $value['modification_date'],
                    $button
                );
            }
            echo json_encode($result);
        }


        // Questions Data Edit & Submit

        public function updateQuestionData(){

            $question_id = $this->input->post('question_id');
            $data = $this->input->post();

            // echo '<pre>'; print_r($data); echo '</pre>';exit;

            $res = $this->am->updateQuestionRecord($question_id, $data);

            if($res){
                
                $this->session->set_flashdata('success', 'Question Updated Successfully');
                return redirect('admin/AM_Controller/getQuestionList');
            }else{
                $this->session->set_flashdata('error', 'Failed to update question. Please try again.');
                return redirect('admin/AM_Controller/getQuestionList');

            }
        }

        public function deleteQuestionRecord($question_id){

            $res = $this->am->deleteQuestionRecordDB($question_id);

            if($res){
                $this->session->set_flashdata('success', 'Question Deleted Successfully');
                return redirect('admin/AM_Controller/getQuestionList');
            }else{
                $this->session->set_flashdata('error', 'Failed to delete question. Please try again.');
                return redirect('admin/AM_Controller/getQuestionList');

            }
        }

//------------------------------------------------------------------------------------------

    // Add Levels Page View
    public function addLevels(){
        $menuControl = $this->session->userdata('user_role');
        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('admin/add-levels');
        $this->load->view('include/scripts');
        $this->load->view('include/footer');
    }

    // Levels Data Submit

    public function addEmployeeLevels() {
        // Main level data
        $data = array(
            'employee_level_name' => $this->input->post('employee_level_name'),
            'employee_level_status' => $this->input->post('employee_level_status'),
            'date_created' => date('Y-m-d')
        );
    
        // Insert main level and get ID
        $level_id = $this->am->insertEmployeeLevel($data);


        // Sub-level data
        $level_name = $this->am->getLevelName($level_id);
    
        if ($level_name) {
            // Handle sub-levels if they exist
            $sub_levels = $this->input->post('sub_levels');
            
            if (!empty($sub_levels)) {
                $result = $this->am->insertEmployeeSubLevel($level_id, $level_name->employee_level_name, $sub_levels);
                
                if ($result) {
                    $this->session->set_flashdata('success', 'Employee Level and Sub-levels Added Successfully');
                } else {
                    $this->session->set_flashdata('error', 'Sub-levels could not be added');
                }
            } else {
                $sub_levels = null;
                $result = $this->am->insertEmployeeSubLevel2($level_id, $level_name->employee_level_name, $sub_levels);
                $this->session->set_flashdata('success', 'Employee Level Added Successfully');
                redirect('admin/AM_Controller/addLevels');
            }
        } else {
            
            $this->session->set_flashdata('error', 'Employee Level could not be added');
            redirect('admin/AM_Controller/addLevels');
        }

        redirect('admin/AM_Controller/addLevels');

        
    }
    // Levels List View



    public function getEmployeeLevelList(){

        $menuControl = $this->session->userdata('user_role');

        // $data['levels'] = $this->am->getEmployeeLevelListData();

        $data['table_name'] = 'user_level_table';
        $data['function_url'] = 'admin/AM_Controller/getUsersLevelRecords';

        $columns = [
            ['data' => 0, 'title' => 'Level', 'filterType' => 'select'],
            ['data' => 1, 'title' => 'Sub Level', 'filterType' => 'select'],
            ['data' => 2, 'title' => 'Status', 'filterType' => 'select'],
            ['data' => 3, 'title' => 'Created Date', 'filterType' => 'date'],
            ['data' => 4, 'title' => 'Actions', 'orderable' => false, 'filterable' => false]
        ];

        $data['columns'] = $columns;

        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('admin/level-list', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');
        $this->load->view('include/datatable', $data);
    }


    public function getUsersLevelRecords(){
    $resultList = $this->am->fatchUsersLevelRecords();

    $response = array(
        "draw" => intval($this->input->get('draw')),
        "recordsTotal" => count($resultList),
        "recordsFiltered" => count($resultList),
        "data" => array()
    );

    foreach ($resultList as $value) {
        $button = '<div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded"></i>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editLevelModal'.$value['employee_level_id'].'">
                    <i class="bx bx-edit-alt me-1"></i> Edit
                </a>
                <a class="dropdown-item text-danger" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deleteLevelModal'.$value['employee_level_id'].'">
                    <i class="bx bx-trash me-1"></i> Delete
                </a>
            </div>
        </div>
        
        <!-- Edit Modal -->
        <div class="modal fade" id="editLevelModal'.$value['employee_level_id'].'" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Level</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="'.base_url('admin/AM_Controller/updateLevelsRecord').'" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="level_id" value="'.$value['employee_level_id'].'">
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Level Name</label>
                                    <input type="text" name="level_name" class="form-control" value="'.$value['employee_level_name'].'">
                                </div>
                                <div class="col mb-3">
                                    <label class="form-label">Sub Level Name</label>
                                    <input type="text" name="sub_level_name" class="form-control" value="'.$value['employee_sub_level_name'].'">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="level_status" class="form-select">
                                        <option value="1" '.($value['employee_level_status'] == 1 ? 'selected' : '').'>Active</option>
                                        <option value="0" '.($value['employee_level_status'] == 0 ? 'selected' : '').'>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteLevelModal'.$value['employee_level_id'].'" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Level</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this level?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="'.base_url('admin/AM_Controller/deleteLevelsRecord').'" method="POST">
                            <input type="hidden" name="level_id" value="'.$value['employee_level_id'].'">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>';

        $status = ($value['employee_level_status'] == 1) ? 'Active' : 'Inactive';

        $response['data'][] = array(
            $value['employee_level_name'],
            $value['employee_sub_level_name'] ?: 'N/A',
            $status,
            date('Y-m-d', strtotime($value['date_created'])),
            $button
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

public function updateLevelsRecord(){
    $level_id = $this->input->post('level_id');
    $level_name = $this->input->post('level_name');
    $level_status = $this->input->post('level_status');

    if($this->input->post('sub_level_name')){
        $sub_level_name = $this->input->post('sub_level_name');
    }else{
        $sub_level_name = null;
    }

    $data = array(
        'employee_level_name' => $level_name,
        'employee_level_status' => $level_status
    );

    $res = $this->am->updateEmployeeLevel($level_id, $data);

    if($sub_level_name){
        $data2['employee_sub_level_name'] = $sub_level_name;
        $this->am->updateEmployeeSubLevel($level_id, $data2);
    }

    if($res){
        $this->session->set_flashdata('success', 'Level Updated Successfully!!!');
        redirect('admin/AM_Controller/getEmployeeLevelList');
    }else{
        $this->session->set_flashdata('error', 'Failed to update level. Please try again.');
        redirect('admin/AM_Controller/getEmployeeLevelList');
    }
}

public function deleteLevelsRecord(){
    $level_id = $this->input->post('level_id');
    $sub_level_id = $this->input->post('sub_level_id');
    $res = $this->am->deleteEmployeeLevel($level_id);
    if($res){
        $this->am->deleteEmployeeSubLevel($sub_level_id);
        $this->session->set_flashdata('success', 'Level Deleted Successfully!!!');
        redirect('admin/AM_Controller/getEmployeeLevelList');
    }else{
        $this->session->set_flashdata('error', 'Failed to delete level. Please try again.');
        redirect('admin/AM_Controller/getEmployeeLevelList');
    }
}
    
    // Levels Data Edit & Submit

//------------------------------------------------------------------------------------------

        // Add Metrix Page View
        // public function addMetrix(){
        //     $menuControl = $this->session->userdata('user_role');
        //     $this->load->view('include/header');
        //     $this->load->view('include/left-navbar', $menuControl);
        //     $this->load->view('admin/add-metrix');
        //     $this->load->view('include/footer');
        // }

        // Metrix Data Submit

        // Metrix List View

        // Metrix Data Edit & Submit

//------------------------------------------------------------------------------------------

            // Add Metrix Page View
            public function assignSupervisorPage(){
                $menuControl = $this->session->userdata('user_role');
                $data['user_id'] = $this->session->userdata('user_id');
            
                // Get employee levels and other required data
                // $data['supervisor_data'] = $this->am->getSupervisorData();
                // $data['departments'] = $this->am->getEmpDepartment();

                // echo '<pre>'; print_r($data); echo '</pre>';exit;
            
                // DataTable configuration
                $data['table_name'] = 'assign_table';
                $data['function_url'] = 'admin/AM_Controller/getAssignRecords';
                $columns = [
                    ['data' => 0, 'title' => 'Supervisor', 'filterType' => 'text'],
                    ['data' => 1, 'title' => 'Role', 'filterType' => 'select'],
                    ['data' => 2, 'title' => 'Designation', 'filterType' => 'select'],
                    ['data' => 3, 'title' => 'Post Date', 'filterType' => 'date'],
                    ['data' => 4, 'title' => 'Last Changes', 'filterType' => 'date'],
                    ['data' => 5, 'title' => 'Actions', 'orderable' => false, 'filterable' => false]
                ];
                $data['columns'] = $columns;

                // Get All Employee Data
                // $data['employee_data'] = $this->am->getAllEmployeeWithLevel();

                // echo '<pre>'; print_r($data); echo '</pre>';exit;
            
                // Load views
                $this->load->view('include/header');
                $this->load->view('include/left-navbar', $menuControl);
                $this->load->view('admin/assign-supervisor', $data);
                $this->load->view('include/scripts');
                $this->load->view('include/footer');
                $this->load->view('include/datatable', $data);
            }


        public function getAssignRecords(){
            $resultList = $this->am->fetchAllAssignData();

            $result = array('data' => array());
            
            foreach ($resultList as $value) {
                $button = '<div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        
                    </div>
                </div>';     

                $Img = '<div class="avatar-edit">
                    <img src="'.base_url($value['employee_image']).'" alt="admin profile" class="w-px-40 h-auto rounded-circle">&nbsp;
                    <a href="'.base_url("admin/AM_Controller/showEmployeeAssignEmployee/".$value['main_employee_id']).'"><strong>'.$value['employee_first_name'].' '.$value['employee_last_name'].' <i class="bx bx-link"></i></strong></a>
                </div>';

                switch ($value['user_role']){
                    case 1:
                        $value['user_role'] = 'Employee';
                        break;
                    case 2:
                        $value['user_role'] = 'Supervisor';
                        break;
                    case 3:
                        $value['user_role'] = 'Admin';
                        break;
                }
                $result['data'][] = array(
                    $Img,
                    $value['user_role'],
                    $value['designation_name'],
                    $value['date_created'],
                    $value['modification_date'],
                    $button
                );
            }
            
            echo json_encode($result);
        }

        // Metrix Data Submit

        public function assignEmptoManager(){
            $supervisor_id = $this->input->post('assign_supervisor_id');
            $employee_id = $this->input->post('assign_employee_id');

            // echo '<pre>'; print_r($employee_id); echo '</pre>';exit;

            $result = $this->am->postAssignEmptoManager($supervisor_id, $employee_id);
    
            if($result){
                redirect('admin/AM_Controller/showEmployeeAssignEmployee/'.$supervisor_id);
            }else{
                redirect('admin/AM_Controller/showEmployeeAssignEmployee/'.$supervisor_id);
            }
        }

        // Metrix List View

        public function showEmployeeAssignEmployee($id){

            $menuControl = $this->session->userdata('user_role');
        
            // Get employee levels and other required data
            // $data['employee_levels'] = $this->am->getEmployeeLevels();
            // $data['departments'] = $this->am->getEmpDepartment();

            // echo '<pre>'; print_r($data); echo '</pre>';exit;
        
            // DataTable configuration
            $data['table_name'] = 'assign_employee_table';
            $data['function_url'] = 'admin/AM_Controller/getAssignEmployeeRecords/'.$id;
            $columns = [
                ['data' => 0, 'title' => 'Employee', 'filterType' => 'text'],
                ['data' => 1, 'title' => 'Designation', 'filterType' => 'select'],
                ['data' => 2, 'title' => 'Date of Joining', 'filterType' => 'date'],
                ['data' => 3, 'title' => 'Last Changes', 'filterType' => 'select'],
                ['data' => 4, 'title' => 'Actions', 'orderable' => false, 'filterable' => false]
            ];
            $data['columns'] = $columns;

            $data['employee_data'] = $this->am->getAllEmployeeWithLevel();
            $data['supervisor_id'] = $id;


            // Load views
            $this->load->view('include/header');
            $this->load->view('include/left-navbar', $menuControl);
            $this->load->view('admin/assign-employee-list', $data);
            $this->load->view('include/scripts');
            $this->load->view('include/footer');
            $this->load->view('include/datatable', $data);

        }

        public function getAssignEmployeeRecords($id){
            $resultList = $this->am->fetchAllAssignemployeeData($id);
            $result = array('data' => array());
            
            foreach ($resultList as $value) {
                $button = '<div class="dropdown">
                  
                </div>';
        
                $Img = '<div class="avatar-edit">
                    <img src="'.base_url($value['employee_image']).'" alt="admin profile" class="w-px-40 h-auto rounded-circle">&nbsp;
                    <a href="'.base_url('admin/AM_Controller/viewEmployeeProfile/').$value['main_employee_id'].'"><strong>'.$value['employee_first_name'].' '.$value['employee_last_name'].' <i class="bx bx-link"></i></strong></a>
                </div>';
        
                $status = ($value['employee_status'] == 1) ? 'Active' : 'Inactive';
        
                $result['data'][] = array(
                    $Img,
                    $value['designation_name'],
                    $value['employee_doj'],
                    $status,
                    $button
                );
            }
            
            echo json_encode($result);
        }
        

        // Metrix Data Edit & Submit
//------------------------------------------------------------------------------------------

// Admin can employee evaluation

    public function viewEmployeePerformanceList(){
        $menuControl = $this->session->userdata('user_role');
    
        $data['table_name'] = 'admin_employee_evaluation_list';
        $data['function_url'] = 'admin/AM_Controller/getEmployeeEvaluationRecords';
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
        $this->load->view('admin/view-employee-performance-list', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');
        $this->load->view('include/datatable', $data);

    }

    public function getEmployeeEvaluationRecords(){

        $resultList = $this->am->getEmployeeEvaluationRecordDB();

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
                                <a class="dropdown-item" href="'.base_url('admin/AM_Controller/viewEmployeeEvaluationDetails/'.$value['employee_evaluation_id']).'">
                                    <i class="bx bx-edit-alt me-1"></i> View Evaluation
                                </a>
                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" 
                                    data-bs-target="#lockEvaluationModal'.$value['employee_evaluation_id'].'">
                                    <i class="bx bxs-lock-alt"></i> Lock/Unlock
                                </a>
                            </div>
                        </div>

                        <div class="modal fade" id="lockEvaluationModal'.$value['employee_evaluation_id'].'" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Evaluation Lock/Unlock Settings</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Employee Lock Form -->
                                        <form method="POST" action="'.base_url('admin/AM_Controller/updateEvaluationLockUnLock').'">
                                            <input type="hidden" name="evaluation_id" value="'.$value['employee_evaluation_id'].'">
                                            
                                            <div class="mb-3">
                                                <label class="form-label d-flex align-items-center gap-2">
                                                    Employee Access
                                                    <i class="bx '.($value['evaluation_status'] < 2 ? 'bxs-lock-open text-success' : 'bxs-lock text-danger').'"></i>
                                                </label>
                                                <div class="d-flex gap-2">
                                                    <select class="form-select" name="employee_lock_status">
                                                        <option value="2" '.($value['evaluation_status'] > 1 ? 'selected' : '').'>Locked</option>
                                                        <option value="1" '.($value['evaluation_status'] < 2 ? 'selected' : '').'>Unlocked</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                        </form>

                                        <!-- Manager Lock Form -->
                                        <form method="POST" action="'.base_url('admin/AM_Controller/updateSupervisorLockUnLock').'">
                                            <input type="hidden" name="evaluation_id" value="'.$value['employee_evaluation_id'].'">
                                            
                                            <div class="mb-3">
                                                <label class="form-label d-flex align-items-center gap-2">
                                                    Supervisor Access
                                                    <i class="bx '.($value['evaluation_status'] < 3 ? 'bxs-lock-open text-success' : 'bxs-lock text-danger').'"></i>
                                                </label>
                                                <div class="d-flex gap-2">
                                                    <select class="form-select" name="supervisor_lock_status">
                                                        <option value="3" '.($value['evaluation_status'] > 2 ? 'selected' : '').'>Locked</option>
                                                        <option value="2" '.($value['evaluation_status'] < 3 ? 'selected' : '').'>Unlocked</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
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
                                <a href="'.base_url("admin/AM_Controller/viewEmployeeProfile/".$value['main_employee_id']).'"><strong>'.$value['employee_first_name'].' <i class="bx bx-link"></i></strong></a>
                            </div>';

                $evaluation_status = ($value['evaluation_status'] == 1)? 'Active' : 'Inactive';

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


    public function viewEmployeeEvaluationDetails($evaluation_id){

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
        $this->load->view('admin/view-employee-evaluation-detail-page', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');
    }

    public function adminEditYourEvaluation($evaluation_id){

        $data['empID'] = $this->sm->getEmployeeID($evaluation_id);

        // echo '<pre>'; print_r($data); echo '</pre>';exit;
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
        $this->load->view('admin/edit-employee-evaluation-detail-page', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');

    }

    public function adminEditSubmitEmployeeEvaluation($id){
        // Validate ID
        if (!$id) {
            $this->session->set_flashdata("error", "Invalid evaluation ID");
            redirect("admin/AM_Controller/viewEmployeeEvaluationDetails/" . $id);
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
            redirect("admin/AM_Controller/viewEmployeeEvaluationDetails/" . $id);
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
            redirect("admin/AM_Controller/viewEmployeeEvaluationDetails/" . $id);
            return;
        }

        if (!$this->sm->updateEmployeeEvaluationData($id, $evaluation_data)) {
            $this->session->set_flashdata("error", "Failed to update evaluation data");
            redirect("admin/AM_Controller/viewEmployeeEvaluationDetails/" . $id);
            return;
        }

        $this->session->set_flashdata("success", "Evaluation updated successfully");
        redirect("admin/AM_Controller/viewEmployeeEvaluationDetails/" . $id);
    }

    public function adminLockEmployeeEvaluation(){

        $supervisorId['supervisor_id'] = $this->session->userdata('user_id');

        $id = $this->input->post('performance_id');
        
        // Validate data exists before proceeding
        if (!$id) {
            $this->session->set_flashdata("error", "No evaluation data provided");
            redirect("admin/AM_Controller/viewEmployeeEvaluationDetails/" . $id);
            return;
        }

        $res = $this->sm->LockSubmitEvaluation($id, $status = 3);

        if($res){

            $res = $this->sm->updateSupervisorRecord($id,$supervisorId);

            if ($res) {
                $this->session->set_flashdata("success", "Evaluation Locked Successfully");
                redirect("admin/AM_Controller/viewEmployeeEvaluationDetails/" . $id);
                return;
            }   
        }else{
            $this->session->set_flashdata("error", "Failed to lock evaluation");
            redirect("admin/AM_Controller/viewEmployeeEvaluationDetails/" . $id);
            return;
        }
    }


    public function updateEvaluationLockUnLock(){
        
        $id = $this->input->post('evaluation_id');
        $status['evaluation_status'] = $this->input->post('employee_lock_status');

        // Validate data exists before proceeding
        if (!$id) {
            $this->session->set_flashdata("error", "No evaluation data provided");
            redirect("admin/AM_Controller/viewEmployeePerformanceList/");
            return;
        }

        $res = $this->am->LockSubmitEvaluation($id, $status);

        if($res){
            $this->session->set_flashdata("success", "Evaluation Update Successfully");
            redirect("admin/AM_Controller/viewEmployeePerformanceList/");
            return;
        }else{
            $this->session->set_flashdata("error", "Failed to lock evaluation");
            redirect("admin/AM_Controller/viewEmployeePerformanceList/");
            return;
        }
    }

    public function updateSupervisorLockUnLock(){
        
        $id = $this->input->post('evaluation_id');
        $status['evaluation_status'] = $this->input->post('supervisor_lock_status');

        // Validate data exists before proceeding
        if (!$id) {
            $this->session->set_flashdata("error", "No evaluation data provided");
            redirect("admin/AM_Controller/viewEmployeePerformanceList/");
            return;
        }

        $res = $this->am->LockSubmitEvaluation($id, $status);

        if($res){
            $this->session->set_flashdata("success", "Evaluation Update Successfully");
            redirect("admin/AM_Controller/viewEmployeePerformanceList/");
            return;
        }else{
            $this->session->set_flashdata("error", "Failed to lock evaluation");
            redirect("admin/AM_Controller/viewEmployeePerformanceList/");
            return;
        }
    }

    public function viewEmployeeEvaluationHistory($evaluation_id){

        $menuControl = $this->session->userdata('user_role');
    
        $data['table_name'] = 'employee_evaluation_history';
        $data['function_url'] = 'admin/AM_Controller/getEmployeeEvaluationHistory/'.$evaluation_id;
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
        $data['evaluation_id'] = $evaluation_id;

        $this->load->view('include/header');
        $this->load->view('include/left-navbar', $menuControl);
        $this->load->view('admin/employee-performance-history', $data);
        $this->load->view('include/scripts');
        $this->load->view('include/footer');
        $this->load->view('include/datatable', $data);

    }

    public function getEmployeeEvaluationHistory($evaluation_id){
        $resultList = $this->am->fatchEmployeeEvaluationHistory($evaluation_id);
        $response = array();
        if (!empty($resultList)) {
            foreach ($resultList as $key => $value) {
                $button = '<div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="'.base_url('admin/AM_Controller/viewEmployeeEvaluationDetails/'.$value['employee_evaluation_id']).'">
                                    <i class="bx bx-edit-alt me-1"></i> View Evaluation
                                </a>
                            </div>
                        </div>';

                        $employee = '<div class="avatar-edit">
                                <img src="'.base_url($value['employee_image']).'" alt="admin profile" class="w-px-40 h-auto rounded-circle">&nbsp;
                                <a href="'.base_url("admin/AM_Controller/viewEmployeeProfile/".$value['main_employee_id']).'"><strong>'.$value['employee_first_name'].' <i class="bx bx-link"></i></strong></a>
                            </div>';

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
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    //----------------------------------------------------------------------------


}
?>