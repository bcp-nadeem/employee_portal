<div class="content-wrapper">
   <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold "><a href="<?php echo base_url("admin/dashboard"); ?>"><i class='bx bx-left-arrow-alt'></i> BACK</a></h4>
      <h4 class="fw-bold py-1 mb-3"><span class="text-muted fw-light"> Dashboard / </span> Spectrum List</h4>
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
        <div class="card">
            <div class="table-responsive text-nowrap">
                <table id="<?php echo $table_name; ?>" class="table">
                    <thead class="table-light">
                        
                    </thead>
                    <tbody class="table-border-bottom-0">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php foreach($spectrums as $spectrum): ?>
   <div class="modal fade" id="editSpectrumModal<?php echo $spectrum->spectrum_id; ?>" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
                  <h5 class="modal-title">Edit Spectrum</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
               <form id="formAccountSettings" method="POST" action="<?php echo base_url('admin/AM_Controller/updateSpectrum'); ?>" 
                  data-parsley-validate data-toggle="validator" enctype="multipart/form-data">
                  <div class="modal-body">
                     <input type="hidden" name="spectrum_id" value="<?php echo $spectrum->spectrum_id; ?>">
                     
                     <div class="mb-3">
                        <label for="designation" class="form-label">Level <span class="isrequired">*</span></label>
                              <select class="select2 form-select employee_level" name="emp_level" disabled>
                              <option value="<?php echo $spectrum->employee_level; ?>" selected><?php echo $spectrum->employee_level_name; ?></option>
                              <?php foreach($employee_levels as $level):?>
                              <option value="<?php echo $level->employee_level_id;?>"><?php echo $level->employee_level_name;?></option>
                              <?php endforeach;?>
                              </select>
                     </div>

                     <div class="mb-3 sub-level-show">
                        <label for="designation" class="form-label">SUB LEVELS</label>
                        <select class="select2 form-select emp_sub_level sub-level-show" name="emp_sub_level" id="">
                           <option value="<?php echo $spectrum->employee_sub_level; ?>" selected><?php echo $spectrum->employee_sub_level_name; ?></option>
                        </select>
                     </div>

                     <div class="mb-3">
                        <label class="form-label">Spectrum Name <span class="isrequired">*</span></label>
                        <input type="text" name="spectrum_name" class="form-control" 
                              value="<?php echo $spectrum->spectrum_color_name; ?>" placeholder="Enter spectrum name" required>
                     </div>

                     <div class="mb-3">
                        <label for="spectrum_color" class="form-label">Spectrum Color Code <span class="isrequired">*</span></label>
                        <div class="color-picker-container">
                              <input type="text" name="spectrum_color" id="spectrum_color" 
                                 class="form-control jscolor" value="<?php echo $spectrum->spectrum_color_code; ?>" required>
                              <div id="color_preview" class="color-preview"></div>
                              <div class="predefined-colors">
                                 <div class="color-box" data-color="#FF00FF" data-bs-toggle="tooltip" title="Magenta"></div>
                                 <div class="color-box" data-color="#800080" data-bs-toggle="tooltip" title="Purple"></div>
                                 <div class="color-box" data-color="#EE82EE" data-bs-toggle="tooltip" title="Violet"></div>
                                 <div class="color-box" data-color="#0000FF" data-bs-toggle="tooltip" title="Blue"></div>
                                 <div class="color-box" data-color="#00FFFF" data-bs-toggle="tooltip" title="Cyan"></div>
                                 <div class="color-box" data-color="#008000" data-bs-toggle="tooltip" title="Green"></div>
                                 <div class="color-box" data-color="#FFFF00" data-bs-toggle="tooltip" title="Yellow"></div>
                                 <div class="color-box" data-color="#FFA500" data-bs-toggle="tooltip" title="Orange"></div>
                                 <div class="color-box" data-color="#FF0000" data-bs-toggle="tooltip" title="Red"></div>
                                 <div class="color-box" data-color="#FFFFFF" data-bs-toggle="tooltip" title="White"></div>
                                 <div class="color-box" data-color="#808080" data-bs-toggle="tooltip" title="Grey"></div>
                                 <div class="color-box" data-color="#000000" data-bs-toggle="tooltip" title="Black"></div>
                              </div>
                        </div>
                     </div>
                     <div class="mb-3">
                        <label for="designation" class="form-label">Status <span class="isrequired">*</span></label>
                        <select class="form-select" name="spectrum_status" id="exampleFormControlSelect1" aria-label="Default select example" required>
                           <option selected="" disabled>Please select status</option>
                           <option value="1">Active</option>
                           <option value="2">Inactive</option>
                        </select>
                  </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-success">Save changes</button>
                  </div>
            </form>
         </div>
      </div>
</div>
<?php endforeach; ?>

