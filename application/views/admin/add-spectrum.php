<div class="content-wrapper">
<div class="container-xxl flex-grow-1 container-p-y">
   <h4 class="fw-bold "><a href="<?php echo base_url("admin/dashboard"); ?>"><i class='bx bx-left-arrow-alt'></i> BACK</a></h4>
   <h4 class="fw-bold py-1 mb-3"><span class="text-muted fw-light"> Dashboard / </span> Add Spectrum</h4>
   <div class="row">
      <div class="col-xl">
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
            <div class="card-body">
               <form id="formAccountSettings" method="POST" action="<?php echo base_url('admin/AM_Controller/addSpectrumInDB'); ?>"  data-parsley-validate data-toggle="validator" enctype="multipart/form-data">
                  <div class="mb-3">
                     <label for="designation" class="form-label">Level <span class="isrequired">*</span></label>
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
                  <div class="mb-3 sub-level-show">
                     <label for="designation" class="form-label">SUB LEVELS</label>
                     <select class="select2 form-select emp_sub_level sub-level-show" name="emp_sub_level" id="">
                     </select>
                  </div>
                  <div class="mb-3">
                     <label for="designation" class="form-label">Spectrum Name <span class="isrequired">*</span></label>
                     <input type="text" name="spectrum_name" id="" class="form-control" placeholder="Enter spectrum name">
                  </div>
                  <div class="mb-3">
                     <label for="spectrum_color" class="form-label">Spectrum Color Code <span class="isrequired">*</span></label>
                     <div class="color-picker-container">
                        <input type="text" 
                           name="spectrum_color" 
                           id="spectrum_color" 
                           class="form-control jscolor" 
                           value="FF00FF"
                           required>
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
                  <button type="submit" class="btn btn-success">Submit</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>