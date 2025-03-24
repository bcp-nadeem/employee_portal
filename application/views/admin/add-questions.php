<div class="content-wrapper">
<div class="container-xxl flex-grow-1 container-p-y">
   <h4 class="fw-bold "><a href="<?php echo base_url("admin/dashboard"); ?>"><i class='bx bx-left-arrow-alt'></i> BACK</a></h4>
   <h4 class="fw-bold py-1 mb-3"><span class="text-muted fw-light"> Dashboard / </span> Add Question</h4>
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
               <form id="formAccountSettings" method="POST" action="<?php echo base_url('admin/AM_Controller/addQuestionRecords'); ?>"  data-parsley-validate data-toggle="validator" enctype="multipart/form-data">
                  <div class="mb-3">
                     <label for="designation" class="form-label">Select Spectrum <span class="isrequired">*</span></label>
                     <select class="select2 form-select" name="spectrum_id" id="spectrum_value">
                        <option selected="" disabled>Please select section name</option>
                        <?php if($records): ?>
                        <?php foreach ($records as $data): ?>
                        <?php if($data->emp_level == $data->employee_level && $data->emp_sub_level == $data->employee_sub_level): ?>
                        <option value="<?php echo $data->spectrum_id; ?>"><?php echo $data->designation_name; ?> - <?php echo $data->spectrum_color_name; ?></option>
                        <?php endif; ?>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <?php endif; ?> 
                     </select>
                  </div>
                  <div class="mb-3">
                     <label for="designation" class="form-label">Section Name <span class="isrequired">*</span></label>
                     <select class="select2 form-select" name="section_id" id="section_dropdown">
                        <option selected="" disabled>Please select section name</option>
                     </select>
                  </div>
                  <div class="mb-3">
                     <label for="question_weight" class="form-label">Question Category <span class="isrequired">*</span></label>
                     <select class="select2 form-select" name="question_weight_id" id="question_weight" required>
                        <option value="" disabled selected>Please select question category</option>
                        <option value="1">A</option>
                        <option value="2">B</option>
                     </select>
                  </div>
                  <div class="mb-3">
                     <label class="form-label" for="basic-default-fullname">Enter your question <span class="isrequired">*</span></label>
                     <textarea class="form-control" name="question_value"></textarea>
                  </div>
                  <button type="submit" class="btn btn-success">Submit</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>