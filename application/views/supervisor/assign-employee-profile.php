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

