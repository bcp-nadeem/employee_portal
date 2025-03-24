<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">
            <a href="<?php echo base_url("employee-evaluation-list"); ?>"><i class="bx bx-left-arrow-alt"></i> BACK</a>
        </h4>
        <h4 class="fw-bold py-1 mb-3"><span class="text-muted fw-light">Dashboard / </span> Evaluation Details</h4>
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
            </div>
            
                <div class="py-3">
                    <div class="row">
                        <div class="col-12 col-xl-4 col-md-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="rounded-3 text-center mb-3 evaluation-emp-info">
                                        <?php 
                                            $color_code = 'fff';
                                            foreach($emp_spectrum as $spectrum){
                                                if($spectrum->spectrum_id == $empdata->spectrum_id){
                                                    $color_code = $spectrum->spectrum_color_code;
                                                }
                                            }
                                        ?>
                                        <img class="img-fluid w-60" src="<?php echo base_url($empdata->employee_image); ?>" alt="Card girl image" style="border-color: #<?php echo $color_code; ?>" />
                                    </div>
                                    <div class="text-center mb-3">
                                        <h4 class="mb-2 pb-1"><?php echo $empdata->employee_first_name .' '. $empdata->employee_last_name; ?></h4>
                                        <span class="badge bg-label-secondary"><?php echo $empdata->designation_name; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-8 col-md-8">
                            <div class="row">
                                <div class="col-lg-4 col-md-3 col-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div>
                                                    <span class="d-block mb-2">EMPLOYEE LEVEL</span>
                                                    <div class="d-flex">
                                                        <div class="avatar flex-shrink-0 me-2">
                                                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-tachometer bx-sm"></i></span>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0 text-nowrap">
                                                                <?php echo $empdata->employee_level_name; ?>
                                                            </h6>
                                                            
                                                            <?php if($empdata->employee_sub_level_id): ?>
                                                                <?php echo $empdata->employee_sub_level_name; ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="chart-emp-avg-style">
                                                    <canvas id="empAvgChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-3 col-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <span class="d-block mb-2">EMPLOYEE SPECTRUM</span>
                                            <div class="d-flex">
                                                <div class="avatar flex-shrink-0 me-2">
                                                    <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-tachometer bx-sm"></i></span>
                                                </div>
                                                <div>
                                                    <?php 
                                                        $color_code = '';
                                                        $color_name = 'Undifined';
                                                        foreach($emp_spectrum as $spectrum){
                                                            if($spectrum->spectrum_id == $empdata->spectrum_id){
                                                               $color_name = $spectrum->spectrum_color_name;
                                                               $color_code = $spectrum->spectrum_color_code;
                                                            }
                                                        }
                                                    ?>
                                                    <h6 class="mb-0 text-nowrap"><?php echo $color_name; ?></h6>
                                                    <div class="spectrum_color_view" style="background-color: #<?php echo $color_code; ?>"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-3 col-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <span class="d-block mb-2">EVALUATION PERIOD</span>
                                            <div class="d-flex">
                                                <div class="avatar flex-shrink-0 me-2">
                                                    <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-time-five bx-sm"></i></span>
                                                </div>
                                                <div>
                                                    <?php 
                                                        if(($emp_evaluation_period->evaluation_period)=='90-a'){
                                                        $period  = 'Mid-Probation';
                                                        $month = '3';
                                                        }elseif(($emp_evaluation_period->evaluation_period)=='182-a'){
                                                        $period  = 'Regularization';
                                                        $month = '6';
                                                        }elseif(($emp_evaluation_period->evaluation_period)=='182-e'){
                                                        $period  = 'Bi-Annual';
                                                        $month = '6';
                                                        }else{
                                                        $period = '';
                                                        $month = '';
                                                        }
                                                    ?>
                                                    <h6 class="mb-0 text-nowrap"><?php echo $period; ?></h6>
                                                    <small><?php echo $month.' months'; ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-3 col-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <span class="d-block mb-2">SUPERVISOR</span>
                                            <div class="d-flex">
                                                <?php if($emp_evaluation_period->evaluation_status == 3): ?>
                                                <div class="avatar flex-shrink-0 me-2">
                                                    <img src="<?php echo base_url($supervisor_data->employee_image); ?>" alt="employee profile" class="w-px-40 h-auto rounded-circle">                                                
                                                </div>
                                                <?php else: ?>
                                                    <div class="avatar flex-shrink-0 me-2">
                                                        <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-user bx-sm"></i></span>
                                                    </div>
                                                    <h6 class="mb-0 text-nowrap"></h6>
                                                    <small>Evaluation Pending</small>
                                                <?php endif; ?>
                                                <div>
                                                    <?php if($emp_evaluation_period->evaluation_status == 3): ?>
                                                    <h6 class="mb-0 text-nowrap"><?php echo $supervisor_data->employee_first_name . ' ' .$supervisor_data->employee_last_name; ?></h6>
                                                    <small><?php echo $supervisor_data->employee_email; ?></small>
                                                    <?php else: ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-3 col-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <span class="d-block mb-2">EVALUATION START DATE</span>
                                            <div class="d-flex">
                                                <div class="avatar flex-shrink-0 me-2">
                                                    <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-calendar bx-sm"></i></span>
                                                </div>
                                                <div>
                                                <h6 class="mb-0 text-nowrap"><?php echo date('d/m/Y', strtotime($emp_evaluation_period->evaluation_start_date)); ?></h6>
                                                    <small>Date</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-3 col-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <span class="d-block mb-2">EVALUATION END DATE</span>
                                            <div class="d-flex">
                                                <div class="avatar flex-shrink-0 me-2">
                                                    <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-calendar bx-sm"></i></span>
                                                </div>
                                                <div>
                                                <h6 class="mb-0 text-nowrap"><?php echo date('d/m/Y', strtotime($emp_evaluation_period->evaluation_end_date)); ?></h6>
                                                    <small>Date</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="">
                        <div class="card-body bg-primary-b btn-justi-ed">
                            <?php if($emp_evaluation_period->evaluation_status == 1 ): ?>
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#empEvaluationSubmit" class="lockEvaluationBTN btn btn-primary">
                                    Lock Evaluation/Submit
                                </a>
                            <?php else:?>
                                <button class="btn btn-primary" disabled>Lock Evaluation/Submit</button>
                            <?php endif; ?>

                            <?php if($emp_evaluation_period->evaluation_status == 1): ?>
                                <a href="<?php echo base_url('employee/EM_Controller/editEmployeeEvaluation/'.$emp_evaluation_period->employee_evaluation_id); ?>" class="btn btn-primary">Edit Performance</a>
                            <?php else:?>
                                <button class="btn btn-primary" disabled>Edit Performance</button>
                            <?php endif; ?>

                            <a href="#" class="btn btn-primary">
                                Performance History
                            </a>

                        <a href="#" class="btn btn-primary" target="_blank">
                            Print
                        </a>
                    </div>
                </div>
             </div>

                <br>

                <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills mb-3" role="tablist">

                      <li class="nav-item" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="" data-bs-original-title="<span><?php echo ($emp_evaluation_period->evaluation_status > 2) ? 'Supervisor has been locked.' : 'Your supervisor has not locked your evaluation yet.'; ?></span>">
                        <button type="button"
                        class="nav-link"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-pills-top-metrix"
                        aria-controls="navs-pills-top-home"
                        aria-selected="false"
                        data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="" data-bs-original-title="<i class='bx bx-bell bx-xs' ></i> <span>Tooltip on top</span>"
                        <?php echo ($emp_evaluation_period->evaluation_status > 2) ? '' : 'disabled'; ?>>

                        Current Metrics <?php echo ($emp_evaluation_period->evaluation_status > 2) ? '' : ''; ?>
                        </button>
                      </li>
                      <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-form" aria-controls="navs-pills-top-profile" aria-selected="true">
                          Evaluation Form
                        </button>
                      </li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane fade" id="navs-pills-top-metrix" role="tabpanel">
                      <div class="table-container">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <?php foreach($sections as $section) : ?>
                                                <th><?php echo $section->section_name; ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach($marks_category as $marks): ?>
                                            <tr>
                                                
                                                <td><?php echo $marks->marks_name; ?></td>
                                                <?php foreach($sections as $section) : ?>
                                                    <td>
                                                        <?php
                                                                $count_question = 0;
                                                                $count_category = 0;
                                                                $weightData = 0;
                                                                $marksData = 0;
                                                                $weightedSumValue = 0;
                                                                $totalWeightValue = 0;
                                                                $weightedPercentage = 0;
                                                                $totalWeightedPercentage = 0;
                                                                foreach($evaluation_data as $question){ // mark 20, 20
                                                                    if($section->section_id == $question->section_id){
                                                                        $count_question++;
                                                                    }
                                                                    if($question->supervisor_marks_category_id == $marks->marks_category_id){
                                                                        if($section->section_id == $question->section_id){
                                                                        $count_category++;

                                                                    //    $weightData = $question->question_weight_value; // A = 0.7 B = 0.3
                                                                    //    $marksData = $marks->marks_value; // 20, 40

                                                                    //    $weightedSumValue += $weightData * $marksData;
                                                                    //    $totalWeightValue += $weightData;

                                                                    //    if($weightedSumValue != 0 && $totalWeightValue != 0){
                                                                    //     $weightedPercentage += ($weightedSumValue / $totalWeightValue);
                                                                    //     $totalWeightedPercentage += $weightedPercentage;
                                                                    // }

                                                                 }
                                                                    
                                                                }
                                                                
                                                            }  

                                                        ?>
                                                            <?php echo $count_category; ?> of <?php echo $count_question; ?>
                                                    </td>
                                                <?php endforeach; ?>

                       
                                            </tr>
                                        <?php endforeach; ?>

                                        <tr class="highlight">
                                            <!-- For Employee -->
                                            <td>Projects Metric</td>
                                            <?php foreach($sections as $section) : ?>
                                                <td>
                                                    <div class="average-display">
                                                        <span class="section-<?php echo $section->section_id; ?>-average">0.00%</span>
                                                    </div>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
               
                                        <tr class="highlight">
                                            <!-- For Supervisor -->
                                            <td>Spectrum Metric</td>
                                            <?php foreach($sections as $section) : ?>
                                                <td>
                                                    <div class="average-display">
                                                        <span class="section-<?php echo $section->section_id; ?>-supervisor-average">0.00%</span>
                                                    </div>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr class="highlight">
                                            <td>Manager Merits</td>
                                            <?php foreach($sections as $section) : ?>       
                                                <td class="manager-merits-section-<?php echo $section->section_id; ?>">0</td>
                                            <?php endforeach; ?>
                                        </tr>
                                    </tbody>    

                                </table>
                            </div>
                      </div>
                      <div class="tab-pane fade active show" id="navs-pills-top-form" role="tabpanel">
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
                                                                <textarea name="six_month_goal" class="form-control" cols="5" rows="3" disabled><?php echo $goals == '' ? '' : $goals->six_month_goal; ?></textarea>
                                                                <label for="">Evaluatee to write goals</label>
                                                            </div>
                                                            <div class="goal-box">
                                                                <textarea name="supervisor_six_month_goal" class="form-control" cols="5" rows="3" disabled><?php echo $goals == '' ? '' : $goals->supervisor_six_month_goal; ?></textarea>
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
                                                                <textarea name="twelve_month_goal" class="form-control" cols="5" rows="3" disabled><?php echo $goals == '' ? '' : $goals->twelve_month_goal; ?></textarea>
                                                                <label for="">Evaluatee to write goals</label>
                                                            </div>
                                                            <div class="goal-box">
                                                            <textarea name="supervisor_twelve_month_goal" class="form-control" cols="5" rows="3" disabled><?php echo $goals == '' ? '' : $goals->supervisor_twelve_month_goal; ?></textarea>
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

                                                <?php foreach ($evaluation_data as $question): ?>
                                                    <?php if ($section->section_id == $question->section_id): ?>
                                                        <?php foreach($weight as $QW): ?>
                                                            <?php if($question->question_weight_id == $QW->question_weight_id) : ?>
                                                                <?php foreach($marks_data as $marks_value): ?>
                                                                    <?php if($question->employee_marks_category_id == $marks_value->marks_category_id) : ?>
                                                                       
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>




                                                    <?php foreach ($evaluation_data as $question): ?>

                                                    <?php if ($section->section_id == $question->section_id): ?>

                                                    <tr class="remove_bb">
                                                        <td>
                                                            <p><?php echo $question->question_value; ?></p>
                                                            <input type="text" name="employee_feedback[]" id="" value="<?php echo $question->employee_feedback; ?>" class="form-control" placeholder="Evaluatee Feedback"  disabled/>
                                                            <br />
                                                            <input type="text" name="manager_feedback[]" id="" value="<?php echo $question->manager_feedback; ?>" class="form-control" placeholder="Manager Feedback" disabled/>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <?php foreach($marks_category as $marks) : ?>
                                                                    <?php if($question->employee_marks_category_id == $marks->marks_category_id): ?>
                                                                        <input type="text" name="" id="" class="form-control" value="<?php echo $marks->marks_name; ?>" disabled>
                                                                        <input type="hidden" class="employee_marks_value" name="employee_marks_value[]" value="<?php echo $marks->marks_value; ?>" />
                                                                        <?php foreach($weight as $QW): ?>
                                                                            <?php if($question->question_weight_id == $QW->question_weight_id) : ?>
                                                                                <input type="hidden" class="employee_question_weight_data" name="employee_question_weight_data[]" value="<?php echo $QW->question_weight_value; ?>" />
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            
                                                                <?php foreach($marks_category as $marks) : ?>
                                                                    <?php if($question->supervisor_marks_category_id == $marks->marks_category_id): ?>
                                                                        <input type="text" name="" id="" class="form-control" value="<?php echo $marks->marks_name; ?>" disabled>
                                                                        <input type="hidden" class="supervisor_marks_value" name="supervisor_marks_value[]" value="<?php echo $marks->marks_value; ?>" />
                                                                        <?php foreach($weight as $QW): ?>
                                                                            <?php if($question->question_weight_id == $QW->question_weight_id) : ?>
                                                                                <input type="hidden" class="supervisor_question_weight_data" name="supervisor_question_weight_data[]" value="<?php echo $QW->question_weight_value; ?>" />
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    

                                                    <?php else: ?>
                                                    <?php endif; ?>
                                                    
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php endforeach; ?>

                                       

                                        <div class="tab-pane fade" id="navs-justified-next-target" role="tabpanel">
                                            <div class="supervisor-goals-flex">
                                                <section class="summary-grid-section">
                                                        <div class="summary-row-box">
                                                            <label for="" class="summary-list-order">1.</label>
                                                            <textarea name="next_perf_target1" class="form-control" cols="2" rows="2" disabled><?php echo $next_performance_targets->target_1; ?></textarea>
                                                        </div>
                                                        <div class="summary-row-box">
                                                            <label for="" class="summary-list-order">2.</label>
                                                            <textarea name="next_perf_target2" class="form-control" cols="2" rows="2" disabled><?php echo $next_performance_targets->target_2; ?></textarea>
                                                        </div>
                                                        <div class="summary-row-box">
                                                            <label for="" class="summary-list-order">3.</label>
                                                            <textarea name="next_perf_target3" class="form-control" cols="2" rows="2" disabled><?php echo $next_performance_targets->target_3; ?></textarea>
                                                        </div>
                                                        <div class="summary-row-box">
                                                            <label for="" class="summary-list-order">4.</label>
                                                            <textarea name="next_perf_target4" class="form-control" cols="2" rows="2" disabled><?php echo $next_performance_targets->target_4; ?></textarea>
                                                        </div>
                                                        <div class="summary-row-box">
                                                            <label for="" class="summary-list-order">5.</label>
                                                            <textarea name="next_perf_target5" class="form-control" cols="2" rows="2" disabled><?php echo $next_performance_targets->target_5; ?></textarea>
                                                        </div>
                                                </section> 
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
    </div>
</div>

<div class="modal fade" id="empEvaluationSubmit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalCenterTitle">Are you sure you'd like to submit this evaluation? Changes can't be made after the submission.</h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
        </div>
        <div class="modal-footer footer-flex">
        <hr>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
            </button>
            <form action="<?php echo base_url('employee/EM_Controller/LockEmployeeEvaluation'); ?>" method="POST">
                <input type="hidden" name="performance_id" value="<?php echo $evaluation_data[0]->employee_evaluation_id; ?>">                                      
                <input type="hidden" name="employee_id" value="<?php echo $empdata->main_employee_id; ?>"> 
                <input type="hidden" name="emp_level" value="<?php echo $empdata->emp_level; ?>">
                <input type="hidden" name="emp_sub_level" value="<?php echo $empdata->emp_sub_level; ?>">
                <input type="hidden" name="spectrum_id" value="<?php echo $empdata->spectrum_id; ?>"> 
                <input type="hidden" name="goals_id" value="<?php echo $goals->employee_evaluation_id; ?>"> 
                <button type="submit" class="btn btn-success">Submit</button>                                        
            </form>
        </div>
    </div>
    </div>
</div>