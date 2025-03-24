<div class="content-wrapper">
<div class="container-xxl flex-grow-1 container-p-y">
<h4 class="fw-bold "><a href="<?php echo base_url("admin/dashboard"); ?>"><i class='bx bx-left-arrow-alt'></i> BACK</a></h4>
<h4 class="fw-bold py-1 mb-3"><span class="text-muted fw-light">Dashboard / </span> Add Employee</h4>
<div class="row">
   <form id="formAccountSettings" method="POST" action="<?php echo base_url('admin/AM_Controller/postEmployeeData'); ?>"  data-parsley-validate data-toggle="validator" enctype="multipart/form-data">
            <div class="col-md-12">
                <?php if($uploaded = $this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <strong><?php echo $uploaded; ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif($tryAgain = $this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <strong><?php echo $tryAgain; ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card mb-4">
               <h5 class="card-header">Profile Details</h5>
               <div class="card-body">
                  <div class="d-flex align-items-start align-items-sm-center gap-4">
                     <div class="holder">
                        <img
                           src="<?php echo base_url('assets/img/icons/profile-upload.png'); ?>"
                           alt="user-avatar"
                           class="d-block rounded"
                           height="100"
                           width="100"
                           id="imgPreview"
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
                           accept="image/png, image/jpeg"
                           name="employee_image"
                           required data-parsley-trigger="keyup"
                           />
                        </label>
                        <p class="text-muted mb-0">Allowed JPG, JPEG or PNG. Image Resolution: 225px * 225px. Max size of 800K </p>
                     </div>
                  </div>
               </div>
               <hr class="my-0" />
               <div class="card-body">
                  <div class="row">
                     <div class="mb-3 col-md-6">
                        <label for="firstName" class="form-label">First Name <span class="isrequired">*</span></label>
                        <input
                           class="form-control"
                           type="text"
                           id="firstName"
                           name="employee_first_name"
                           placeholder="John"
                           autofocus
                           required data-parsley-trigger="keyup"
                           />
                     </div>
                     <div class="mb-3 col-md-6">
                        <label for="lastName" class="form-label">Last Name <span class="isrequired">*</span></label>
                        <input class="form-control" type="text" name="employee_last_name" id="lastName" placeholder="Doe" required data-parsley-trigger="keyup" />
                     </div>
                     <div class="mb-3 col-md-6">
                        <label for="email" class="form-label">E-mail <span>*</span></label>
                        <input
                           class="form-control"
                           type="email"
                           id="login_email"
                           name="employee_email"
                           placeholder="john.doe@example.com"
                           required data-parsley-trigger="keyup"
                           />
                        <span id="vaild_email">
                        <label for="">This email Id already exist!!</label>
                        </span>
                     </div>
                     <div class="mb-3 col-md-6">
                        <label for="organization" class="form-label">Phone Number <span class="isrequired">*</span></label>
                        <div class="form-group md-group show-label">
                           <input class="form-control" name="employee_number" type="tel" id="phone" placeholder="e.g. +1 702 123 4567" value="" required data-parsley-trigger="keyup">
                        </div>
                     </div>
                     <div class="mb-3 col-md-12">
                        <label for="address" class="form-label">Address <span class="isrequired">*</span></label>
                        <input type="text" class="form-control" id="address" name="employee_address" placeholder="Address" required data-parsley-trigger="keyup" />
                     </div>
                     <div class="mb-3 col-md-6">
                        <label for="state" class="form-label">City <span class="isrequired">*</span></label>
                        <input class="form-control" type="text" id="city" name="employee_city" placeholder="City" required data-parsley-trigger="keyup"/>
                     </div>
                     <div class="mb-3 col-md-6">
                        <div class="form-group md-group show-label">
                           <label class="form-label" for="country">Country <span class="isrequired">*</span></label>
                           <span class="child-label-ed w-100-d">
                              <select name="employee_country" id="address-country" class="select2 form-select form-control" required data-parsley-trigger="keyup">
                                    <option value="" selected="">Search Country</option>
                                    <?php if($countries): ?>
                                       <?php foreach($countries as $country): ?>
                                          <option value="<?php echo $country->country_id; ?>" <?php echo ($country->country_id == 96) ? 'selected' : ''; ?>>
                                                <?php echo $country->country_name; ?>
                                          </option>
                                       <?php endforeach; ?>
                                    <?php endif; ?>
                              </select>
                           </span>
                        </div>
                     </div>
                     <div class="mb-3 col-md-6">
                        <label for="designation" class="form-label">Departments <span class="isrequired">*</span></label>
                        <select id="department_id" name="employee_department" class="select2 form-select" required data-parsley-trigger="keyup">
                           <option value="">Select Departments</option>
                           <?php if($departments): ?>
                           <?php foreach($departments as $data): ?>
                           <option value="<?php echo $data->department_id; ?>"><?php echo $data->department_name; ?></option>
                           <?php endforeach; ?>
                           <?php endif; ?>
                        </select>
                        <button type="button" class="btn btn-primary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
                           <i class='bx bx-plus'></i> Add Department
                        </button>

                        <!-- Add Department Modal -->
                        <div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-hidden="true">
                           <div class="modal-dialog">
                              <div class="modal-content">
                                    <div class="modal-header">
                                       <h5 class="modal-title">Add New Department</h5>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                       <div class="mb-3">
                                          <label class="form-label">Department Name</label>
                                          <input type="text" class="form-control" id="new_department_name">
                                       </div>
                                    </div>
                                    <div class="modal-footer">
                                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                       <button type="button" class="btn btn-primary" id="saveDepartment">Save</button>
                                    </div>
                              </div>
                           </div>
                        </div>

                     </div>
                     <div class="mb-3 col-md-6">
                        <label for="designation" class="form-label">Designation <span class="isrequired">*</span></label>
                        <select id="designation_id" name="employee_designation" class="select2 form-select" required data-parsley-trigger="keyup">
                        </select>
                        <button type="button" class="btn btn-primary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#addDesignationModal">
                           <i class='bx bx-plus'></i> Add Designation
                        </button>

                        <!-- Add Designation Modal -->
                        <div class="modal fade" id="addDesignationModal" tabindex="-1" aria-hidden="true">
                           <div class="modal-dialog">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h5 class="modal-title">Add New Designation</h5>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                       <div class="mb-3">
                                          <label class="form-label">Department</label>
                                          <div class="input-group">
                                             <select class="form-select" id="designation_department_id" name="department_id">
                                                   <option value="">Select Department</option>
                                                   <?php if($departments): ?>
                                                      <?php foreach($departments as $data): ?>
                                                         <option value="<?php echo $data->department_id; ?>"><?php echo $data->department_name; ?></option>
                                                      <?php endforeach; ?>
                                                   <?php endif; ?>
                                             </select>
                                             <button class="btn btn-outline-secondary" type="button" id="refreshDepartments" title="Refresh Departments">
                                                   <i class="bx bx-refresh"></i>
                                             </button>
                                          </div>
                                       </div>
                                       <div class="mb-3">
                                             <label class="form-label">Designation Name</label>
                                             <input type="text" class="form-control" id="new_designation_name">
                                       </div>
                                    </div>
                                    <div class="modal-footer">
                                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                       <button type="button" class="btn btn-primary" id="saveDesignation">Save</button>
                                    </div>
                                 </div>
                           </div>
                        </div>
                     </div>
                     <div class="mb-3 col-md-6">
                        <label for="designation" class="form-label">Date Of Joining <span class="isrequired">*</span></label>
                        <input class="form-control" name="employee_doj" type="date" id="html5-date-input" required data-parsley-trigger="keyup">
                     </div>
                     <div class="mb-3 col-md-6">
                        <label for="designation" class="form-label">Date Of Termination</label>
                        <input class="form-control" type="date" name="employee_dot" id="html5-date-input">
                     </div>
                     <div class="mb-3 col-md-4">
                        <label for="designation" class="form-label">Employee Password <span class="isrequired">*</span></label>
                        <input class="form-control" name="emp_password" type="password" id="html5-date-input" required data-parsley-trigger="keyup">
                     </div>
                     
                     <div class="mb-3 col-md-4">
                        <label for="designation" class="form-label">Level</label>
                        <select class="select2 form-select employee_level" name="emp_level" id="">
                           <option value="" selected disabled>Enter Level</option>
                           <?php foreach($employee_levels as $level):?>
                              <option value="<?php echo $level->employee_level_id; ?>">
                                 <?php echo $level->employee_level_name; ?>
                                 <?php echo ($level->employee_sub_level_name != null ? " (".$level->employee_sub_level_name.")" : ""); ?>
                              </option>                           
                           <?php endforeach;?>
                        </select>
                     </div>

                     <div class="mb-3 col-md-4 sub-level-show">
                        <label for="designation" class="form-label">SUB LEVELS</label>
                        <select class="select2 form-select emp_sub_level sub-level-show" name="emp_sub_level" id="" disabled="">
                        </select>
                     </div>
                     <div class="mb-3 col-md-4">
                        <label for="designation" class="form-label">Spectrum</label>
                        <select id="spectrum_select" name="employee_spectrum_id" class="select2 form-select">
                           <option value="" selected disabled>Select Spectrum</option>
                        </select>
                        <div id="spectrum_color_preview" style="height: 20px; margin-top: 5px; border-radius: 4px;"></div>
                     </div>
                     <div class="mb-3 col-md-4">
                        <label for="designation" class="form-label">Position <span class="isrequired">*</span></label>
                        <select class="form-select" name="user_role" id="exampleFormControlSelect1" aria-label="Default select example" required>
                           <option selected="" disabled>Please select department</option>
                           <option value="1">Employee</option>
                           <option value="2">Supervisor</option>
                           <option value="3">Admin</option>
                        </select>
                     </div>
                  </div>
                  <div class="mt-2">
                     <button type="submit" class="btn btn-primary me-2">Save changes</button>
                     <button type="reset" class="btn btn-outline-secondary">Reset</button>
                  </div>
               </div>
            </div>
         </div>
   </form>
   </div>
</div>