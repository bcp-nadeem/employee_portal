<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">
        <h4 class="fw-bold "><a href="<?php echo base_url($this->session->userdata('user_role')==1 ? 'employee/dashboard' : 'supervisor/dashboard'); ?>"><i class='bx bx-left-arrow-alt'></i> BACK</a></h4>
        <h4 class="fw-bold py-1 mb-3"><span class="text-muted fw-light">Dashboard / </span> Add Performance</h4>
        <div class="row">
        <div class="col-xl">

        <?php if($uploaded = $this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
            <strong><?php echo $uploaded; ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if($uploaded = $this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
            <strong><?php echo $uploaded; ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
         
           

            <div class="card mb-4">
                <h5 class="card-header">Employee Details</h5>
                <div class="card-body">
                    <form id="formAccountSettings" method="POST" action="<?php echo base_url('employee/EM_Controller/insertEmployeeEvaluation'); ?>" data-parsley-validate data-toggle="validator">
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <input type="hidden" name="employee_id" value="<?php echo $employee->main_employee_id; ?>" />
                                <input type="hidden" name="emp_level" value="<?php echo $employee->emp_level; ?>" />
                                <label for="employee" class="form-label">Employee</label>
                                <input type="text" class="form-control" name="employee_first_name" value="<?php echo $employee->employee_first_name; ?> <?php echo $employee->employee_last_name; ?>" disabled />
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="employee" class="form-label">Level</label>
                                <input type="text" class="form-control" name="emp_level" value="<?php echo $employee->employee_level_name; ?>" disabled />
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="employee" class="form-label">Sub Level</label>
                                <input type="text" class="form-control" name="emp_level" value="<?php echo $employee->employee_sub_level_name; ?>" disabled />
                            </div>
                            <div class="mb-3 col-md-3" >
                                    <label for="employee" class="form-label">Spectrum</label> <span style="display: inline-block; border-radius: 100%; padding: 3px; background-color: #<?php echo $employee->spectrum_color_code; ?>; border: 2px solid #<?php echo $employee->spectrum_color_code; ?>;"></span>
                                <input type="text" class="form-control" name="emp_level" value="<?php echo $employee->spectrum_color_name; ?>" disabled />
                            </div>
                      
                            <div class="mb-3 col-md-6">
                                <label for="designation" class="form-label">Department</label>
                                <input type="text" class="form-control" name="department_name" value="<?php echo $employee->department_name; ?>" disabled />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="designation" class="form-label">Designation</label>
                                <input type="text" class="form-control" name="employee_designation" value="<?php echo $employee->designation_name; ?>" disabled />
                            </div>
                            
                            <div class="mb-2 col-md-12">
                                <label for="designation" class="form-label"><b>Select Date Range</b></label>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="designation" class="form-label">
                                    EVALUATION Period
                                    <i
                                        class="bx bx-info-circle"
                                        data-bs-toggle="tooltip"
                                        data-bs-offset="0,4"
                                        data-bs-placement="right"
                                        data-bs-html="true"
                                        title=""
                                        data-bs-original-title="<span>Mid-Probation ( After 3 months)<br>
                                      Regularization ( After 6 months)<br>
                                      Bi-Annual (Every 6 months)
                                      </span>"
                                    ></i>
                                </label>
                                <select name="evaluate_date_category" id="evaluate_date_category" class="form-control" required>
                                    <option selected disabled>Select Period</option>
                                    <option value="90-a">Mid-Probation</option>
                                    <option value="182-a">Regularization</option>
                                    <option value="182-e">Bi-Annual</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="designation" class="form-label">EVALUATION Start date</label>
                                <input class="form-control" type="date" name="emp_performance_start_date" id="start_date" value="<?= date('Y-m-d') ?>" required />
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="designation" class="form-label">EVALUATION End date</label>
                                <input class="form-control" id="end_date" type="date" value="" disabled />
                                <input type="hidden" name="emp_performance_end_date" id="end_date_set" value="" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <hr />
                            </div>

                            <?php if ($sections): ?>

                            <div class="col-xl-12">
                                <h6 class="text-muted">Add Performance</h6>
                                <div class="nav-align-top mb-4">
                                    <ul class="nav nav-tabs nav-fill" role="tablist">
                                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="" data-bs-original-title="<span>Goals</span>">
                                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-goals" aria-controls="navs-justified-goals" aria-selected="true">
                                                Goals
                                            </button>
                                        </li>

                                        <?php if ($sections): ?>

                                        <?php $count = 0; ?>
                                        <?php foreach ($sections as $section): ?>

                                        <?php $count++; ?>

                                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="" data-bs-original-title="<span>Section <?php echo $count; ?></span>">
                                            <button
                                                type="button"
                                                class="nav-link"
                                                role="tab"
                                                data-bs-toggle="tab"
                                                data-bs-target="#navs-justified-section-<?php echo $section->section_id; ?>"
                                                aria-controls="navs-justified-section-<?php echo $section->section_id; ?>"
                                                aria-selected="true"
                                            >
                                                <?php echo $section->section_name; ?>
                                            </button>
                                        </li>
                                        <?php endforeach; ?>

                                        <?php else: ?>
                                        <?php endif; ?>

                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="navs-justified-goals" role="tabpanel">
                                            <div class="supervisor-goals-flex">
                                                <section class="supervisor-goals-section">
                                                    <div class="goals-section-one">
                                                        <label for="" class="mb-2">Goals to be achieved within 6 months</label>
                                                        <div class="goal-boxes">
                                                            <div class="goal-box">
                                                                <textarea name="six_month_goal" class="form-control" cols="5" rows="5"><?php echo $goals == '' ? '' : $goals->six_month_goal; ?></textarea>
                                                                <label for="">Evaluatee to write goals</label>
                                                            </div>
                                                            <div class="goal-box">
                                                                <textarea class="form-control" cols="5" rows="3" disabled></textarea>
                                                                <label for="">Supervisor to review goals</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                                <section class="supervisor-goals-section">
                                                    <div class="goals-section-one">
                                                        <label for="" class="mb-2">Goals to be achieved within 12 months</label>
                                                        <div class="goal-boxes">
                                                            <div class="goal-box">
                                                                <textarea name="twelve_month_goal" class="form-control" cols="5" rows="5"><?php echo $goals == '' ? '' : $goals->twelve_month_goal; ?></textarea>
                                                                <label for="">Evaluatee to write goals</label>
                                                            </div>
                                                            <div class="goal-box">
                                                                <textarea class="form-control" cols="5" rows="3" disabled></textarea>
                                                                <label for="">Supervisor to review goals</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                        <?php foreach ($sections as $key => $section): ?>
                                        <div class="tab-pane fade" id="navs-justified-section-<?php echo $section->section_id; ?>" role="tabpanel">
                                            <table class="table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>INDICATOR</th>
                                                        <th>
                                                            ASSESSMENT
                                                            <i
                                                                class="bx bx-info-circle"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-offset="0,4"
                                                                data-bs-placement="right"
                                                                data-bs-html="true"
                                                                title="<i class='bx bx-trending-up bx-xs' ></i> <span>Add performance scores</span>"
                                                            ></i>
                                                            (Out of 5)
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-border-bottom-0">
                                                    <?php foreach ($questions as $question): ?>

                                                    <?php if ($section->section_id == $question->section_id): ?>

                                                    <tr class="remove_bb">
                                                        <td>
                                                            <p><?php echo $question->question_value; ?></p>
                                                            <input type="text" name="employee_feedback[]" id="" class="form-control" placeholder="Evaluatee Feedback"  />
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <select name="employee_marks_category_id[]" class="form-select employee_score" data-section="<?php echo $section->section_id; ?>">
                                                                    <option value="0">Employee Score</option>
                                                                    <?php foreach($evaluation_marks as $marks) : ?>
                                                                        <option value="<?php echo $marks->marks_category_id; ?>">
                                                                            <?php echo $marks->marks_name; ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                
                                                                <select name="" class="form-select supervisor_score" data-section="<?php echo $section->section_id; ?>" disabled>
                                                                    <option value="0">Manager Score</option>
                                                                    <?php foreach($evaluation_marks as $marks) : ?>
                                                                            <option value="<?php echo $marks->marks_category_id; ?>">
                                                                                <?php echo $marks->marks_name; ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <input type="hidden" name="qurestion_id[]" value="<?php echo $question->question_id; ?>" />
                                                    <input type="hidden" name="section_id[]" value="<?php echo $section->section_id; ?>" />

                                                    <?php else: ?>
                                                    <?php endif; ?>

                                                    <?php endforeach; ?>

                                                </tbody>
                                            </table>
                                        </div>
                                        <?php endforeach; ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2">Save changes</button>

                                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                </div>
                        </div>

                        <?php else: ?>
                            <p>Here are not any evaluation form for you!! Please contact your supervisor</p>
                        <?php endif; ?>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
