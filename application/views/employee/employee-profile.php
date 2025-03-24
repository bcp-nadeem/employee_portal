<div class="content-wrapper">
   <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-md-12">
            <h4 class="fw-bold "><a href="<?php echo base_url($this->session->userdata('user_role')==1 ? 'employee/dashboard' : 'supervisor/dashboard'); ?>"><i class='bx bx-left-arrow-alt'></i> BACK</a></h4>
            <h4 class="fw-bold py-1 mb-3"><span class="text-muted fw-light"> Dashboard / </span> Employee Details</h4>
             
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


            <div class="card mb-2">
                <div class="card-body">
                    <span class="emp_edit_btn">
                    <a data-bs-toggle="modal" data-bs-target="<?php echo '#empEdit'.$empdata->main_employee_id; ?>" href="javascript:void(0);">
                    <i class='bx bx-edit'></i>
                    </a>
                    </span>
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img
                        src="<?php echo base_url($empdata->employee_image); ?>"
                        alt="user-avatar"
                        class="d-block rounded img-d-emp"
                        style="border-radius: 100% !important; border: 3px solid #<?php echo $empdata->spectrum_color_code; ?>;"
                        /> 
                        <div class="emp_info_basic">
                            <div>
                                <h3><?php echo $empdata->employee_first_name; ?> <?php echo $empdata->employee_last_name; ?></h3>
                            </div>
                            <div class="mb-2">
                                <span><?php echo $empdata->department_name; ?></span> / <span><?php echo $empdata->designation_name; ?></span>
                            </div>
                            <div id="">
                                <span>Spectrum Name: <?php echo $empdata->spectrum_color_name; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-0" />
                <div class="card-body">
                    <div class="row">
                        <div class="mb-2 col-md-6">
                        <label for="email" class="form-label"><b>E-mail:</b> </label>
                        <span><?php echo $empdata->employee_email; ?></span>
                        </div>
                        <div class="mb-2 col-md-6">
                        <label for="organization" class="form-label"><b>Phone Number:</b> </label>
                        <span><?php echo $empdata->employee_number; ?></span>                          
                        </div>
                        <div class="mb-2 col-md-6">
                        <label for="address" class="form-label"><b>Address:</b> </label>
                        <span><?php echo $empdata->employee_address; ?></span>
                        </div>
                        <div class="mb-2 col-md-6">
                        <label for="state" class="form-label"><b>City:</b></label>
                        <span><?php echo $empdata->employee_city; ?></span>
                        </div>
                        <div class="mb-2 col-md-6">
                        <label class="form-label" for="country"><b>Country:</b></label>
                        <span><?php echo $empdata->country_name; ?></span>
                        </div>
                        <div class="mb-2 col-md-6">
                        <label for="designation" class="form-label"><b>Date Of Joining:</b> </label>
                        <span><?php echo $empdata->employee_doj; ?></span>
                        </div>
                        <?php if(($empdata->employee_dot)!=='0000-00-00 00:00:00') : ?>
                        <div class="mb-2 col-md-6">
                        <label for="designation" class="form-label"><b>DATE OF TERMINATION:</b> </label>
                        <span><?php echo $empdata->employee_dot; ?></span>
                        </div>
                        <?php else: ?>
                        <?php endif; ?>

                        <div class="mb-2 col-md-6">
                            <label for="designation" class="form-label"><b>Level:</b> </label>
                            <span><?php echo $empdata->employee_level_name; ?> / <?php echo $empdata->employee_sub_level_name; ?></span>
                        </div>

                        <div class="mb-2 col-md-6">
                        <label for="designation" class="form-label"><b>Status:</b> </label>
                        <?php if(($empdata->employee_status)=='1'): ?>
                        <span class="badge bg-label-success me-1">Active</span>
                        <?php else: ?>
                        <span class="badge bg-label-danger">Inactive</span>
                        <?php endif; ?>  
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
   </div>
</div>


<form action="<?php echo base_url('employee/EM_Controller/editEmployeeMyProfile'); ?>" 
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
                                disabled
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
                                    <select id="department_id" name="employee_department" class="select2 form-select" disabled>
                                        <option value="<?php echo $empdata->department_id; ?>"><?php echo $empdata->department_name; ?></option>
                                        <?php if($departments): ?>
                                        <?php foreach($departments as $data): ?>
                                            <option value="<?php echo $data->department_id; ?>"><?php echo $data->department_name; ?></option>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                            </div>
                            <input type="hidden" name="old_employee_department" value="<?php echo $empdata->department_id; ?>">
                            <div class="mb-3 col-md-6">
                                <label for="designation" class="form-label">Designation </label>
                                <select id="designation_id" name="employee_designation" class="select2 form-select" disabled>
                                    <option selected><?php echo $empdata->employee_designation; ?></option>
                                </select>
                                <input type="hidden" name="old_employee_designation" value="<?php echo $empdata->employee_designation; ?>">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="designation" class="form-label">Date Of Joining</label>
                                <input class="form-control" name="employee_doj" type="date" id="html5-date-input" value="<?php echo $empdata->employee_doj; ?>" disabled>
                            </div>
                            <input type="hidden" name="old_employee_doj" value="<?php echo $empdata->employee_doj; ?>">
                            <div class="mb-3 col-md-6">
                                <label for="designation" class="form-label">Date Of Termination</label>
                                <input class="form-control" type="date" name="employee_dot" id="html5-date-input" value="<?php echo $empdata->employee_dot; ?>" disabled>
                            </div>
                            <input type="hidden" name="old_employee_dot" value="<?php echo $empdata->employee_dot; ?>">               
                            <div class="mb-3 col-md-6">
                                <label for="designation" class="form-label">Level</label>
                                <select class="select2 form-select employee_level" name="emp_level" id="" disabled>
                                <option value="<?php echo $empdata->employee_level_id; ?>" selected><?php echo $empdata->employee_level_name; ?></option>
                                <?php foreach($employee_levels as $level):?>
                                <option value="<?php echo $level->employee_level_id;?>"><?php echo $level->employee_level_name;?></option>
                                <?php endforeach;?>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="designation" class="form-label">SUB LEVELS</label>
                                <select class="select2 form-select emp_sub_level" name="emp_sub_level" id="" disabled>
                                <option value="<?php echo $empdata->employee_sub_level_id; ?>" selected><?php echo $empdata->employee_sub_level_name; ?></option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="designation" class="form-label">Spectrum</label>
                                <select id="spectrum_select" name="employee_spectrum_id" class="select2 form-select" disabled>
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
                                <select class="form-select" name="user_role" id="exampleFormControlSelect1" aria-label="Default select example" disabled>
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
