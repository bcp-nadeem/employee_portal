<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <?php 
            $supervisor_link = 'supervisor/SV_Controller/viewAssignEmployeeEvaluationDetails/'.$emp_evaluation_period->employee_evaluation_id;
            $admin_link = 'admin/view-employee-performance-list';
        ?>
        <h4 class="fw-bold "><a href="<?php echo base_url($this->session->userdata('user_role')==2 ?   $supervisor_link : $admin_link); ?>"><i class='bx bx-left-arrow-alt'></i> BACK</a></h4>
        <h4 class="fw-bold py-1 mb-3"><span class="text-muted fw-light">Dashboard / </span> Update Evaluation</h4>
        <div class="row">
           
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

           
            <form action="<?php echo base_url('admin/AM_Controller/adminEditSubmitEmployeeEvaluation/'.$emp_evaluation_period->employee_evaluation_id); ?>" method="POST">

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
                                                            <small><?php echo $empdata->employee_sub_level_name; ?></small>
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
                                                                <textarea name="supervisor_six_month_goal" class="form-control" cols="5" rows="5"><?php echo $goals == '' ? '' : $goals->supervisor_six_month_goal; ?></textarea>
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
                                                                <textarea name="supervisor_twelve_month_goal" class="form-control" cols="5" rows="5"><?php echo $goals == '' ? '' : $goals->supervisor_twelve_month_goal; ?></textarea>
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

                                                        <input type="hidden" name="question_id[]" value="<?php echo $question->question_id;?>" />

                                                        <tr class="remove_bb">
                                                            <td>
                                                                <p><?php echo $question->question_value; ?></p>
                                                                <input type="text" name="employee_feedback[]" id="" value="<?php echo $question->employee_feedback; ?>" class="form-control" placeholder="Evaluatee Feedback"  disabled/>
                                                                <br />
                                                                <input type="text" name="manager_feedback[]" id="" value="<?php echo $question->manager_feedback; ?>" class="form-control" placeholder="Manager Feedback"/>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex gap-2">
                                                                    <?php foreach($marks_category as $marks) : ?>
                                                                        <?php if($question->employee_marks_category_id == $marks->marks_category_id): ?>
                                                                            <input type="text" name="" id="" class="form-control" value="<?php echo $marks->marks_name; ?>" disabled>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                
                                                                  
                                                                    <select name="supervisor_marks_category_id[]" class="form-select employee_score">
                                                                        <?php foreach($marks_category as $marks) : ?>
                                                                            <option value="<?php echo $marks->marks_category_id; ?>" 
                                                                                <?php echo ($question->supervisor_marks_category_id == $marks->marks_category_id) ? 'selected' : ''; ?>>
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
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
