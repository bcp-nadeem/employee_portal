<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">
            <a href="<?php echo base_url("employee/EM_Controller/viewEmployeeEvaluationDetails/".$emp_evaluation_period->employee_evaluation_id); ?>"><i class="bx bx-left-arrow-alt"></i> BACK</a>
        </h4>
        <h4 class="fw-bold py-1 mb-3"><span class="text-muted fw-light">Dashboard / </span> Edit Evaluation</h4>
        <div class="row">
            <?php if ($empdata->employee_status == 2): ?>
            <div class="page_d_msg">
                <h2>Your account deactivated</h2>
                <a href="<?php echo base_url('Employee'); ?>">Back</a>
            </div>
            <?php else: ?>

            <div class="col-xl">
                <?php if($uploaded = $this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <strong><?php echo $uploaded; ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?php endif; ?>

                <?php if($uploaded = $this->session->flashdata('error')): ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <strong><?php echo $uploaded; ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?php endif; ?>
            </div>

                <form id="formAccountSettings" method="POST" action="<?php echo base_url('employee/EM_Controller/editAndSubmitEmployeeEvaluation/'.$emp_evaluation_period->employee_evaluation_id); ?>" data-parsley-validate data-toggle="validator">
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
                                            <span class="badge bg-label-secondary"><?php echo $empdata->employee_designation; ?></span>
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
                                                                    <?php 
                                                                        switch($empdata->emp_level) {
                                                                            case 1:
                                                                                echo "Super Admin";
                                                                                break;
                                                                            case 2:
                                                                                echo "Director";
                                                                                break;
                                                                            case 3:
                                                                                echo "Manager";
                                                                                break;
                                                                            case 4:
                                                                                echo "Consultant";
                                                                                break;
                                                                            case 5:
                                                                                echo "Coordinator";
                                                                                break;
                                                                            case 6:
                                                                                echo "Support";
                                                                                break;
                                                                            default:
                                                                                echo "Unknown Level";
                                                                        }
                                                                    ?>
                                                                </h6>
                                                                <?php if($empdata->emp_level == 6) : ?>
                                                                    <small><?php switch($empdata->emp_sub_level) {
                                                                            case 1:
                                                                                echo "HR";
                                                                                break;
                                                                            case 2:
                                                                                echo "IT";
                                                                                break;
                                                                            case 3:
                                                                                echo "Graphics";
                                                                                break;
                                                                            case 4:
                                                                                echo "Administration";
                                                                                break;
                                                                            case 5:
                                                                                echo "Finance";
                                                                                break;
                                                                            case 6:
                                                                                echo "Automation";
                                                                                break;
                                                                            case 7:
                                                                                echo "BIM Centre";
                                                                                break;
                                                                            case 8:
                                                                                echo "BIM IPD";
                                                                                break;
                                                                            default:
                                                                                echo "Unknown Sub Level";
                                                                        }
                                                                    ?></small>
                                                                <?php else: ?>
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
                                                    <div class="avatar flex-shrink-0 me-2">
                                                        <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-user bx-sm"></i></span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 text-nowrap"></h6>
                                                        <small>Pending</small>
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
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
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
                                    <?php 
                                        $evaluation_periods = [
                                            '90-a' => 'Mid-Probation',
                                            '182-a' => 'Regularization',
                                            '182-e' => 'Bi-Annual'
                                        ];
                                        
                                        $period = '';
                                        $month = '';
                                        
                                        if (isset($emp_evaluation_period->evaluation_period) && 
                                            array_key_exists($emp_evaluation_period->evaluation_period, $evaluation_periods)) {
                                            $month = $emp_evaluation_period->evaluation_period;
                                            $period = $evaluation_periods[$month];
                                        }
                                    ?>
                                    <select name="evaluate_date_category" id="evaluate_date_category" class="form-control" required>
                                        <option selected value="<?php echo $month; ?>"><?php echo $period; ?></option>
                                        <?php foreach($evaluation_periods as $value => $label): ?>
                                            <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                                        <?php endforeach; ?>
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
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                                <div class="row">
                                    <div class="mb-2 col-md-12">
                   
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
                                                                        <textarea name="six_month_goal" class="form-control" cols="5" rows="5" ><?php echo $goals == '' ? '' : $goals->six_month_goal; ?></textarea>
                                                                        <label for="">Evaluatee to write goals</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </section>
                                                        <section class="supervisor-goals-section">
                                                            <div class="goals-section-one">
                                                                <label for="" class="mb-2">Goals to be achieved within 12 months</label>
                                                                <div class="goal-boxes">
                                                                    <div class="goal-box">
                                                                        <textarea name="twelve_month_goal" class="form-control" cols="5" rows="5" ><?php echo $goals == '' ? '' : $goals->twelve_month_goal; ?></textarea>
                                                                        <label for="">Evaluatee to write goals</label>
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
                                                            <input type="hidden" name="question_id[]" value="<?php echo $question->question_id;?>" />
                                                            <tr class="remove_bb">
                                                                <td>
                                                                    <p><?php echo $question->question_value; ?></p>
                                                                    <input type="text" name="employee_feedback[]" id="" value="<?php echo $question->employee_feedback; ?>" class="form-control" placeholder="Evaluatee Feedback"  />
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-2">
                                                                        <select name="employee_marks_category_id[]" class="form-select employee_score">
                                                                            <?php foreach($marks_category as $marks) : ?>
                                                                                <option value="<?php echo $marks->marks_category_id; ?>" 
                                                                                    <?php echo ($question->employee_marks_category_id == $marks->marks_category_id) ? 'selected' : ''; ?>>
                                                                                    <?php echo $marks->marks_name; ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
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

                                            
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <button type="submit" class="btn btn-primary me-2">Save changes</button>

                                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                        </div>
                                </div>
                                <?php endif; ?>
                        </div>
                    </div>
                </form>
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
            <form action="<?php echo base_url('Performance_Evaluation/submitEmployeeEvaluation'); ?>" method="POST">
                <input type="hidden" name="performance_id" value="<?php echo $evaluation_data[0]->employee_evaluation_id; ?>">                                      
                <input type="hidden" name="employee_id" value="<?php echo $empdata->main_employee_id; ?>"> 
                <input type="hidden" name="emp_level" value="<?php echo $empdata->emp_level; ?>">
                <input type="hidden" name="emp_sub_level" value="<?php echo $empdata->emp_sub_level; ?>">
                <input type="hidden" name="spectrum_id" value="<?php echo $empdata->spectrum_id; ?>"> 
                <input type="hidden" name="goals_id" value="<?php echo $goals->employee_evaluation_id; ?>"> 
                <input type="hidden" name="performance_targets_id" value="<?php echo $next_performance_targets->next_performance_targets_id; ?>"> 
                <button type="submit" class="btn btn-success">Submit</button>                                        
            </form>
        </div>
    </div>
    </div>
</div>