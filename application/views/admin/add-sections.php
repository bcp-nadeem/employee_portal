<div class="content-wrapper">
<div class="container-xxl flex-grow-1 container-p-y">
   <h4 class="fw-bold "><a href="<?php echo base_url("admin/dashboard"); ?>"><i class='bx bx-left-arrow-alt'></i> BACK</a></h4>
   <h4 class="fw-bold py-1 mb-3"><span class="text-muted fw-light"> Dashboard / </span> Add Section</h4>
   <div class="row">
      <div class="col-xl">
         <?php if($uploaded = $this->session->flashdata('success')): ?>
         <div class="alert alert-success alert-dismissible" role="alert">
            <strong><?php echo $uploaded; ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php endif; ?>
         </div>
         <?php if($uploaded = $this->session->flashdata('error')): ?>
         <div class="alert alert-danger alert-dismissible" role="alert">
            <strong><?php echo $uploaded; ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php endif; ?>
         </div>
         <div class="card mb-4">
            <div class="card-body">
               <form id="formAccountSettings" method="POST" action="<?php echo base_url('admin/AM_Controller/addSectionInEvaluationForm'); ?>"  data-parsley-validate data-toggle="validator" enctype="multipart/form-data">
                  <div class="mb-3">
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
                     <div class="mb-3 sub-level-show">
                        <label for="designation" class="form-label">SUB LEVELS</label>
                        <select class="select2 form-select emp_sub_level sub-level-show" name="emp_sub_level" id="">
                        </select>
                     </div>
                     <div class="mb-3">
                        <label for="designation" class="form-label">Spectrum</label>
                        <select id="spectrum_select" name="employee_spectrum_id" class="select2 form-select">
                           <option value="" selected disabled>Select Spectrum</option>
                        </select>
                     </div>
                  <div class="mb-3">
                     <label class="form-label" for="basic-default-fullname">Section Name <span class="isrequired">*</span></label>
                     <input type="text" class="form-control" name="section_name" id="basic-default-fullname" placeholder="Communication" required data-parsley-trigger="keyup" />
                  </div>
                  <button type="submit" class="btn btn-success">Submit</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>