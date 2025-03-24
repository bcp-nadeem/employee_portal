<div class="content-wrapper">
   <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold "><a href="<?php echo base_url("admin/AM_Controller/viewEmployeeEvaluationDetails/".$evaluation_id); ?>"><i class='bx bx-left-arrow-alt'></i> BACK</a></h4>
      <h4 class="fw-bold py-1 mb-3"><span class="text-muted fw-light"> Dashboard / </span> Employee Performance History</h4>
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