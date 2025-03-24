<div class="content-wrapper">
   <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold "><a href="<?php echo base_url("admin/dashboard"); ?>"><i class='bx bx-left-arrow-alt'></i> BACK</a></h4>
      <h4 class="fw-bold py-1 mb-3"><span class="text-muted fw-light"> Dashboard / </span> Question List</h4>
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

<?php foreach ($question_records as $key => $qData) : ?>
    <div class="modal fade" id="editQuestionModal<?php echo $qData->question_id; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Spectrum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo base_url('admin/AM_Controller/updateQuestionData'); ?>" method="POST">
                    <div class="modal-body">
                    <input type="hidden" name="question_id" value="<?php echo $qData->question_id; ?>">
                    
                    <div class="mb-3">
                        <label for="designation" class="form-label">Select Spectrum <span class="isrequired">*</span></label>
                        <select class="select2 form-select" name="spectrum_id" id="spectrum_value">
                            <option value="<?php echo $qData->spectrum_id; ?>" selected=""><?php echo $qData->spectrum_color_name; ?></option>
                            <?php if($records): ?>
                            <?php foreach ($records as $data): ?>
                            <?php if($data->emp_level == $data->employee_level && $data->emp_sub_level == $data->employee_sub_level): ?>
                            <option value="<?php echo $data->spectrum_id; ?>"><?php echo $data->employee_designation; ?> - <?php echo $data->spectrum_color_name; ?></option>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <?php endif; ?> 
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="designation" class="form-label">Section Name <span class="isrequired">*</span></label>
                        <select class="select2 form-select" name="section_id" id="section_dropdown">
                            <option value="<?php echo $qData->section_id; ?>" selected=""><?php echo $qData->section_name; ?></option>
                        </select>
                    </div>

                    <div class="mb-3">
                     <label for="question_weight" class="form-label">Question Category <span class="isrequired">*</span></label>
                     <select class="select2 form-select" name="question_weight_id" id="question_weight" required>
                        <option value="<?php echo $qData->question_weight_id; ?>" selected><?php echo $qData->question_weight_name; ?></option>
                        <option value="1">A</option>
                        <option value="2">B</option>
                     </select>
                  </div>

                  <div class="mb-3">
                     <label class="form-label" for="basic-default-fullname">Enter your question <span class="isrequired">*</span></label>
                     <textarea class="form-control" name="question_value" id="" cols="10" rows="4"><?php echo $qData->question_value; ?></textarea>
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
<?php endforeach; ?>