<div class="content-wrapper">
   <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="py-1 mb-2">
      </h4>
      <h4 class="fw-bold "><a href="<?php echo base_url("employee-list"); ?>"><i class='bx bx-left-arrow-alt'></i> BACK</a></h4>
      <h4 class="fw-bold py-1 mb-3"><span class="text-muted fw-light"> Dashboard / </span> Employee Profile</h4>
        <?php if($success = $this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <strong><?php echo $success; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if($error = $this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <strong><?php echo $error; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
      <div class="row">
         <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <div class="card mb-4">
               <div class="card-body">
                    <span class="emp_edit_btn">
                        <a data-bs-toggle="modal" data-bs-target="<?php echo '#empEdit'.$empdata->main_employee_id; ?>" href="javascript:void(0);">
                            <i class='bx bx-edit'></i>
                        </a>
                    </span>
                  <div class="user-avatar-section">
                     <div class=" d-flex align-items-center flex-column">
                        <div class="spectrum-current-color my-4" style="border: 3px solid #<?php echo $empdata->spectrum_color_code; ?>;">
                           <img class="img-fluid rounded"
                            src="<?php echo base_url($empdata->employee_image); ?>"
                             height="110" width="110" alt="User avatar">
                        </div>
                        <div class="user-info text-center">
                           <h4 class="mb-2"><?php echo $empdata->employee_first_name; ?> <?php echo $empdata->employee_last_name; ?></h4>
                           <span class="badge bg-label-secondary"><?php echo $empdata->designation_name; ?></span>
                        </div>
                     </div>
                  </div>
                  <div class="d-flex justify-content-around flex-wrap my-2 py-3">
                     <div class="d-flex align-items-start me-4 mt-3 gap-3">
                        <span class="badge bg-label-primary p-3 rounded"></span>
                        <div>
                           <h5 class="mb-0"></h5>
                        </div>
                     </div>
                     <div class="d-flex align-items-start mt-3 gap-3">
                        <span class="badge bg-label-primary p-3 rounded"><i class="bx bx-link"></i></span>
                        <div>
                           <div class="leave_btns">
                              <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addEmployeeLeave"><i class="bx bx-plus"></i></a> &nbsp; 
                           </div>
                           <a href="javascript:void(0)" class="leave_link_style" target="_blank"><span>Leave Sheet</span></a>
                        </div>
                     </div>
                  </div>
                  <h5 class="pb-2 border-bottom mb-4">Details</h5>
                  <div class="info-container">
                     <ul class="list-unstyled">
                        <li class="mb-3">
                           <span class="fw-medium me-2">Email:</span>
                           <span><?php echo $empdata->employee_email; ?></span>
                        </li>
                        <li class="mb-3">
                           <span class="fw-medium me-2">Number:</span>
                           <span><?php echo $empdata->employee_number; ?></span>
                        </li>
                        <li class="mb-3">
                           <span class="fw-medium me-2">Address:</span>
                           <span><?php echo $empdata->employee_address; ?>, <?php echo $empdata->employee_city; ?>, <?php echo $empdata->country_name; ?></span>
                        </li>
                        <li class="mb-3">
                           <span class="fw-medium me-2">Date of Joining:</span>
                           <span><?php echo $empdata->employee_doj; ?></span>
                        </li>
                        <?php if(($empdata->employee_dot)!=='0000-00-00 00:00:00') : ?>
                        <li class="mb-3">
                           <span class="fw-medium me-2">Date of Termination:</span>
                           <span><?php echo $empdata->employee_dot; ?></span>
                        </li>
                        <?php else: ?>
                        <?php endif; ?>
                        <li class="mb-3">
                           <span class="fw-medium me-2">Level:</span>
                           <span><?php echo $empdata->employee_level_name; ?> / <?php echo $empdata->employee_sub_level_name; ?></span>
                        </li>
                        <li class="mb-3">
                           <span class="fw-medium me-2">Role:</span>
                           <span><?php 
                            switch ($empdata->user_role) {
                              case '3':
                                echo "Admin";
                                break;
                              case '2':
                                echo "Supervisor";
                                break;
                               case '1':
                                echo "Employee";
                                break;
                              default:
                                echo "Employee";
                                break;
                            }
                           ?></span>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">

         <div class="row">
            <div class="col-lg-7 col-md-6">
                
                    <div class="card mb-4">
                        <div class="wrapping-designation-title">
                            <h5 class="card-header">Designation History</h5>
                        </div>
                        <div class="card-body">
                            <ul class="timeline">
                                <?php if(empty($employee_history)) : ?>
                                <li class="timeline-item timeline-item-transparent">
                                    <span class="timeline-point-wrapper"><span class="timeline-point" style="background-color: #<?php echo $empdata->spectrum_color_code; ?> !important; box-shadow: 0 0 0 .1875rem #8d8d8d29; "></span></span>
                                    <div class="timeline-event">
                                    <div class="timeline-header mb-1">
                                        <h6 class="mb-0"> 
                                            <?php echo $current_employee_history->department_name; ?> -
                                            <?php echo $current_employee_history->designation_name; ?> <sup><?php echo $current_employee_history->employee_level_name; ?></sup>
                                        </h6>
                                        <!-- <div>
                                            <span class="history_designation_edit_btn"><a href="http://localhost/projects/testing_eep/Admin/viewDesignationEditPage/35">
                                                <i class="bx bx-edit-alt"></i></a>
                                            </span>
                                            <span class="history_designation_trash_btn">
                                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#deleteEmpDesignationRecord35">
                                                <i class="bx bx-trash"></i>
                                                </a>
                                            </span>
                                        </div> -->
                                    </div>
                                    <p class="mb-2"></p>
                                    <div class="d-flex flex-wrap">
                                        <div class="avatar me-3">
                                            <img src="<?php echo base_url($current_employee_history->employee_image); ?>" alt="Avatar" class="rounded-circle">
                                        </div>
                                        <div>
                                            <h6 class="mb-0"><?php echo $current_employee_history->country_name; ?></h6>
                                            <span class="text-muted"><?php echo date('d M Y', strtotime($current_employee_history->employee_doj)); ?></span>
                                        </div>
                                    </div>
                                    </div>
                                </li>
                                <?php else: ?>

                                    <?php foreach($employee_history as $history): ?>

                                        <li class="timeline-item timeline-item-transparent">
                                            <span class="timeline-point-wrapper"><span class="timeline-point" style="background-color: #<?php echo $history->spectrum_color_code; ?> !important; box-shadow: 0 0 0 .1875rem #8d8d8d29; "></span></span>
                                            <div class="timeline-event">
                                            <div class="timeline-header mb-1">
                                                <h6 class="mb-0"> 
                                                    <?php echo $history->department_name; ?> -
                                                    <?php echo $history->designation_name; ?> <sup><?php echo $history->employee_level_name; ?></sup>
                                                </h6>
                                                <div>
                                                    <!-- <span class="history_designation_edit_btn"><a href="http://localhost/projects/testing_eep/Admin/viewDesignationEditPage/35">
                                                        <i class="bx bx-edit-alt"></i></a>
                                                    </span> -->
                                                    <span class="history_designation_trash_btn">
                                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#historyDelete<?php echo $history->history_employee_id; ?>">
                                                        <i class="bx bx-trash"></i>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                            <p class="mb-2"></p>
                                            <div class="d-flex flex-wrap">
                                                <div class="avatar me-3">
                                                    <img src="<?php echo base_url($history->employee_image); ?>" alt="Avatar" class="rounded-circle">
                                                </div>
                                                <div>
                                                    <h6 class="mb-0"><?php echo $history->country_name; ?></h6>
                                                    <?php if(isset($history->history_modification_date)): ?>
                                                    <span class="text-muted"><?php echo date('d M Y', strtotime($history->history_modification_date)); ?> </span>
                                                    <?php else:?>
                                                    <span class="text-muted"><?php echo date('d M Y', strtotime($history->employee_doj));?> </span>
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                            </div>
                                        </li>

                                    <?php endforeach; ?>
                    
                                <?php endif; ?>

                                <li class="timeline-end-indicator">
                                    <i class="bx bx-check-circle"></i>
                                </li>
                            </ul>
                        </div>
                    </div>
            </div>
            <div class="col-lg-4 col-md-6">
            </div>
         </div>
            <!-- <div class="card mb-4 stop-auto-scrolling">
               <h5 class="card-header">Your Salary History</h5>
               <div class="table-responsive mb-3">
                  <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                     <table class="table datatable-project border-top dataTable no-footer dtr-column" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 918px;">
                        <thead>
                           <tr>
                              <th>CURRENCY</th>
                              <th>SALARY</th>
                              <th>SALARY TYPE</th>
                              <th class="sift_next_line">REASON FOR<span>SALARY CHANGE</span></th>
                              <th>DATE</th>
                              <th>ACTION</th>
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
                     </table>
                     <div style="width: 1%;"></div>
                  </div>
               </div>
            </div> -->
         </div>
      </div>
   </div>
</div>

<form action="<?php echo base_url('admin/AM_Controller/editEmployeeProfileSubmit'); ?>" 
      method="POST"
      enctype="multipart/form-data">    
      <div class="card-body">
        <div class="row gy-3">
            <div class="col-lg-4 col-md-6">
                <div class="modal fade" id="<?php echo 'empEdit'.$empdata->main_employee_id; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Update Employee Information?</h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="modal-body">
                        <div class="card mb-4">
                        <h5 class="card-header">Profile Details</h5>
                        <input type="hidden" name="main_employee_id" value="<?php echo $empdata->main_employee_id; ?>">
                        <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <div class="holder">
                            <img
                                src="<?php echo base_url($empdata->employee_image); ?>"
                                alt="user-avatar"
                                class="d-block rounded"
                                height="100"
                                width="100"
                                id="imgPreview"
                                value="<?php echo base_url($empdata->employee_image); ?>"
                            /> 
                            </div>
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input
                                        type="file"
                                        id="upload"
                                        class="account-file-input"
                                        hidden
                                        accept="image/png, image/jpeg, image/jpg"
                                        name="employee_image"
                                        data-max-size="800"
                                        data-allowed-dimensions="225x225"
                                    />
                                    <input type="hidden" name="old_emp_img" value="<?php echo ($empdata->employee_image); ?>">
                                </label>
                                <p class="text-muted mb-0">Allowed JPG, JPEG or PNG. Image Resolution: 225px * 225px. Max size of 800K </p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-0" />
                        <div class="card-body">
                            <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">First Name</label>
                                <input
                                class="form-control"
                                type="text"
                                id="firstName"
                                name="employee_first_name"
                                placeholder="John"
                                value="<?php echo $empdata->employee_first_name; ?>"
                                autofocus
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input class="form-control" type="text" name="employee_last_name" id="lastName"  value="<?php echo $empdata->employee_last_name; ?>" placeholder="Doe" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input
                                class="form-control"
                                type="text"
                                name="employee_email"
                                placeholder="john.doe@example.com"
                                value="<?php echo $empdata->employee_email; ?>"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="organization" class="form-label">Phone Number</label>
                                <div class="form-group md-group show-label">
                                <input class="form-control" name="employee_number" type="tel" id="phone" placeholder="e.g. +1 702 123 4567" value="<?php echo $empdata->employee_number; ?>" required data-parsley-trigger="keyup">
                                </div>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="employee_address" value="<?php echo $empdata->employee_address; ?>" placeholder="Address" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="state" class="form-label">City</label>
                                <input class="form-control" type="text" id="city" name="employee_city" value="<?php echo $empdata->employee_city; ?>" placeholder="City" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <div class="form-group md-group show-label">
                                    <label class="form-label" for="country">Country</label>
                                    <select name="employee_country" id="address-country" class="select2 form-select form-control" required data-parsley-trigger="keyup">
                                            <option value="<?php echo $empdata->country_id; ?>" selected=""><?php echo $empdata->country_name; ?></option>
                                            <?php if($countries): ?>
                                            <?php foreach($countries as $country): ?>
                                                
                                                <option value="<?php echo $country->country_id; ?>">
                                                        <?php echo $country->country_name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3 col-md-6">
                                <label for="designation" class="form-label">Departments <span class="isrequired">*</span></label>
                                    <select id="department_id" name="department_id" class="select2 form-select">
                                        <option selected value="<?php echo $empdata->employee_department; ?>"><?php echo $empdata->department_name; ?></option>
                                        <?php if($departments): ?>
                                        <?php foreach($departments as $data): ?>
                                            <option value="<?php echo $data->department_id; ?>"><?php echo $data->department_name; ?></option>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="designation" class="form-label">Designation</label>
                                <select id="designation_id" name="designation_id" class="select2 form-select">
                                    <option selected value="<?php echo $empdata->employee_designation; ?>"><?php echo $empdata->designation_name; ?></option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="designation" class="form-label">Date Of Joining</label>
                                <input 
                                    class="form-control" 
                                    name="employee_doj" 
                                    type="date" 
                                    id="html5-date-input" 
                                    value="<?php 
                                        $date = new DateTime($empdata->employee_doj);
                                        echo $date->format('Y-m-d'); 
                                    ?>">        
                            </div>
                            <input type="hidden" name="old_employee_doj" value="<?php echo $empdata->employee_doj; ?>">
                            <div class="mb-3 col-md-6">
                                <label for="designation" class="form-label">Date Of Termination</label>
                                <input class="form-control" type="date" name="employee_dot" id="html5-date-input" value="<?php 
                                    $date = new DateTime($empdata->employee_dot);
                                    echo $date->format('Y-m-d'); 
                                ?>">
                            </div>
                            <input type="hidden" name="old_employee_dot" value="<?php echo $empdata->employee_dot; ?>">               
                            <div class="mb-3 col-md-6">
                                <label for="designation" class="form-label">Level</label>
                                <select class="select2 form-select employee_level" name="emp_level" id="">
                                <option value="<?php echo $empdata->employee_level_id; ?>" selected><?php echo $empdata->employee_level_name; ?></option>
                                <?php foreach($employee_levels as $level):?>
                                    <option value="<?php echo $level->employee_level_id; ?>">
                                        <?php echo $level->employee_level_name; ?>
                                        <?php echo ($level->employee_sub_level_name != null ? " (".$level->employee_sub_level_name.")" : ""); ?>
                                    </option>                           
                                <?php endforeach;?>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="designation" class="form-label">SUB LEVELS</label>
                                <select class="select2 form-select emp_sub_level sub-level-show" name="emp_sub_level" id="">
                                <option value="<?php echo $empdata->employee_sub_level_id; ?>" selected><?php echo $empdata->employee_sub_level_name; ?></option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="designation" class="form-label">Spectrum</label>
                                <select id="spectrum_select" name="employee_spectrum_id" class="select2 form-select">
                                <option value="<?php echo $empdata->spectrum_id; ?>" selected><?php echo $empdata->spectrum_color_name; ?></option>
                                </select>
                                <div id="spectrum_color_preview" style="height: 20px; margin-top: 5px; border-radius: 4px;"></div>
                            </div>
                            <?php 
                            
                            switch($empdata->user_role){
                                case 1:
                                    $role = 'Employee';
                                    break;
                                case 2:
                                    $role = 'Supervisor';
                                    break;
                                case 3:
                                    $role = 'Admin';
                                    break;
                                default:
                                    $role = 'Employee';
                                    break;
                            }
                            ?>
                            <div class="mb-3 col-md-6">
                                <label for="designation" class="form-label">Position <span class="isrequired">*</span></label>
                                <select class="form-select" name="user_role" id="exampleFormControlSelect1" aria-label="Default select example" required>
                                <option value="<?php echo $empdata->user_role; ?>" selected=""><?php echo $role; ?></option>
                                <option value="1">Employee</option>
                                <option value="2">Supervisor</option>
                                <option value="3">Admin</option>
                                </select>
                            </div>

                            </div>
                        </div>
                    </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php if($this->session->flashdata('show_history_approval')): ?>
<!-- History Approval Modal -->
<div class="modal fade" id="historyApprovalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Profile History Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Employee profile changes require a history record. Do you want to create this record?</p>
            </div>
            <div class="modal-footer">
                <form action="<?php echo base_url('admin/AM_Controller/confirmHistoryUpdate'); ?>" method="POST">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="approve_history" value="yes" class="btn btn-primary">Create History Record</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if(!empty($employee_history)) : ?>
<?php foreach($employee_history as $history): ?>
<!-- History Delete Modal -->
<div class="modal fade" id="historyDelete<?php echo $history->history_employee_id; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Do you want to delete history</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <form action="<?php echo base_url('admin/AM_Controller/deleteHistoryRecord'); ?>" method="POST">
                    <input type="hidden" name="history_employee_id" value="<?php echo $history->history_employee_id; ?>">
                    <input type="hidden" name="employee_id" value="<?php echo $empdata->main_employee_id; ?>">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="approve_history" value="yes" class="btn btn-danger">Detele History</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>