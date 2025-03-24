<div class="content-wrapper">
   <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold "><a href="<?php echo base_url("admin/dashboard"); ?>"><i class='bx bx-left-arrow-alt'></i> BACK</a></h4>
      <h4 class="fw-bold py-1 mb-3"><span class="text-muted fw-light"> Dashboard / </span> Assign Employee List</h4>


      <div class="d-flex justify-content-end my-2">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assignEmployeePop">Assign Employee</button>
      </div>  
      
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

<form action="<?php echo base_url('admin/AM_Controller/assignEmptoManager'); ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="assign_supervisor_id" value="<?php echo $supervisor_id; ?>">
    <div class="card-body">
      <div class="row gy-3">
          <div class="col-lg-4 col-md-6">
                <div class="modal fade" id="assignEmployeePop" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="modalCenterTitle">Select Employee</h5>
                          <button
                              type="button"
                              class="btn-close"
                              data-bs-dismiss="modal"
                              aria-label="Close"
                          ></button>
                      </div>
                      <div class="modal-body">
                        <div class="dropdown-assign-selection-flex">
                            <div class="ManagerOpt-select">
                                <label for="designation" class="form-label">Employee List <span class="isrequired">*</span></label>
                                <select name="assign_employee_id[]" multiple class="ManagerOpt">
                                    <?php foreach ($employee_data as $data): ?>
                                        <?php if(($data->user_role) < 3 ) : ?>
                                            <option value="<?php echo $data->main_employee_id; ?>"><?php echo $data->employee_first_name; ?> 
                                            (<?php echo $data->employee_level_name ; ?>)</option>
                                        <?php else: ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Close
                                </button>
                                <button class="btn btn-success" value="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                  </div>
                  </div>
              </div>
           
              </div>
          </div>
      </div>
  </div>
</form>