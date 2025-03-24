<div class="layout-wrapper layout-content-navbar">
<div class="layout-container">
<?php 
   switch($this->session->userdata('user_role')){
         case 1:
            $dashboard_link = 'employee/dashboard';
            break;
         case 2:
            $dashboard_link = 'supervisor/dashboard';
            break;
         case 3:
            $dashboard_link = 'admin/dashboard';
            break;
      default:
         $dashboard_link = '';
         break;
   }
?>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
   <div class="app-brand demo">
      <a href="<?php echo base_url(''); ?>" class="app-brand-link">
      <img src="<?php echo base_url('assets/img/logo/bimcap_logo3.png'); ?>" alt="logo">
      </a>
      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
   </div>
   <div class="menu-inner-shadow"></div>
   <ul class="menu-inner py-1">
      <li class="menu-item active">
         <a href="<?php echo base_url($dashboard_link); ?>" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">Dashboard</div>
         </a>
      </li>

      <?php if($this->session->userdata('user_role')==1 || $this->session->userdata('user_role')==2): ?>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Account</span>
            </li>
            <li class="menu-item">
              <a href="<?php echo base_url('employee-profile'); ?>" class="menu-link">
                <i class='bx bx-user' ></i> &nbsp;&nbsp;&nbsp;
                <div data-i18n="Account Settings">Profile</div>
              </a>
            </li>

            <li class="menu-header small text-uppercase"><span class="menu-header-text">Your Performance</span></li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='bx bx-bar-chart-alt' ></i> &nbsp;&nbsp;&nbsp;
                <div data-i18n="Basic">Performance</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="<?php echo base_url('submit-evaluation'); ?>" class="menu-link">
                    <div data-i18n="Basic">Submit Evaluation</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="<?php echo base_url('employee-evaluation-list'); ?>" class="menu-link">
                    <div data-i18n="Basic">View Evaluation</div>
                  </a>
                </li>
              </ul>
            </li>

      <?php endif;?>

    <?php if($this->session->userdata('user_role')==3): ?>
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Create Profile</span>
      </li>

      <li class="menu-item">
         <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='bx bx-user' ></i> &nbsp;&nbsp;&nbsp;
            <div data-i18n="Account Settings">Account</div>
         </a>
         <ul class="menu-sub">
            <li class="menu-item">
               <a href="javascript:void(0);" class="menu-link menu-toggle remove-sub-dots">
                  <strong>Step 1 </strong>&nbsp;&nbsp;&nbsp;
                  <div data-i18n="Authentications">Departments</div>
               </a>
               <ul class="menu-sub">
                  <li class="menu-item">
                     <a href="<?php echo base_url('add-department'); ?>" class="menu-link">
                        <div data-i18n="Basic">Add Departments</div>
                     </a>
                  </li>
                  <li class="menu-item">
                     <a href="<?php echo base_url('department-list'); ?>" class="menu-link">
                        <div data-i18n="Basic">Departments List</div>
                     </a>
                  </li>
               </ul>
            </li>
            <li class="menu-item">
               <a href="javascript:void(0);" class="menu-link menu-toggle remove-sub-dots">
                  <strong>Step 2 </strong>&nbsp;&nbsp;&nbsp;
                  <div data-i18n="Basic">Designation</div>
               </a>
               <ul class="menu-sub">
                  <li class="menu-item">
                     <a href="<?php echo base_url('add-designation'); ?>" class="menu-link">
                        <div data-i18n="Basic">Add Designation</div>
                     </a>
                  </li>
                  <li class="menu-item">
                     <a href="<?php echo base_url('designation-list'); ?>" class="menu-link">
                        <div data-i18n="Basic">Designation List</div>
                     </a>
                  </li>
               </ul>
            </li>

            <li class="menu-item">
               <a href="javascript:void(0);" class="menu-link menu-toggle remove-sub-dots">
                  <strong>Step 3 </strong>&nbsp;&nbsp;&nbsp;
                  <div data-i18n="Basic">Levels</div>
               </a>
               <ul class="menu-sub">
                  <li class="menu-item">
                     <a href="<?php echo base_url('add-levels'); ?>" class="menu-link">
                        <div data-i18n="Basic">Add Levels</div>
                     </a>
                  </li>
                  <li class="menu-item">
                     <a href="<?php echo base_url('level-list'); ?>" class="menu-link">
                        <div data-i18n="Basic">Levels List</div>
                     </a>
                  </li>
               </ul>
            </li>

            <li class="menu-item">
               <a href="javascript:void(0);" class="menu-link menu-toggle remove-sub-dots">
                  <strong>Step 4 </strong>&nbsp;&nbsp;&nbsp;
                  <div data-i18n="Basic">Spectrum</div>
               </a>
               <ul class="menu-sub">
                  <li class="menu-item">
                     <a href="<?php echo base_url('add-spectrum'); ?>" class="menu-link">
                        <div data-i18n="Basic">Add Spectrum</div>
                     </a>
                  </li>
                  <li class="menu-item">
                     <a href="<?php echo base_url('spectrum-list'); ?>" class="menu-link">
                        <div data-i18n="Basic">Spectrum List</div>
                     </a>
                  </li>
               </ul>
            </li>
            <li class="menu-item">
               <a href="javascript:void(0);" class="menu-link menu-toggle remove-sub-dots">
                  <strong>Step 5 </strong>&nbsp;&nbsp;&nbsp;
                  <div data-i18n="Basic">Employee</div>
               </a>
               <ul class="menu-sub">
                  <li class="menu-item">
                     <a href="<?php echo base_url('add-employee'); ?>" class="menu-link">
                        <div data-i18n="Account">Add Employee</div>
                     </a>
                  </li>
                  <li class="menu-item">
                     <a href="<?php echo base_url('employee-list'); ?>" class="menu-link">
                        <div data-i18n="Notifications">Employee List</div>
                     </a>
                  </li>
               </ul>
            </li>
         </ul>
      </li>
      <?php endif; ?>
      <?php if($this->session->userdata('user_role')==3): ?>
      <li class="menu-header small text-uppercase"><span class="menu-header-text">Employee Salary</span></li>
      <li class="menu-item">
         <a href="<?php echo base_url('employee-salary'); ?>" class="menu-link">
            <i class='bx bx-dollar'></i> &nbsp;&nbsp;&nbsp;
            <div data-i18n="Basic">Salary</div>
         </a>
      </li>
      <li class="menu-header small text-uppercase"><span class="menu-header-text">Create Form</span></li>
      <li class="menu-item">
         <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class='bx bx-line-chart'></i> &nbsp;&nbsp;&nbsp;
            <div data-i18n="Employee Evaluation">Sections / Questions</div>
         </a>
         <ul class="menu-sub">
            <li class="menu-item">
               <a href="<?php echo base_url('add-sections'); ?>" class="menu-link">
                  &nbsp;&nbsp;&nbsp;
                  <div data-i18n="Authentications">Add Section</div>
               </a>
            </li>
            <li class="menu-item">
               <a href="<?php echo base_url('section-list'); ?>" class="menu-link">
                  &nbsp;&nbsp;&nbsp;
                  <div data-i18n="Authentications">Section List</div>
               </a>
            </li>
            <li class="menu-item">
               <a href="<?php echo base_url('add-questions'); ?>" class="menu-link">
                  &nbsp;&nbsp;&nbsp;
                  <div data-i18n="Authentications">Add Questions</div>
               </a>
            </li>
            <li class="menu-item">
               <a href="<?php echo base_url('question-list'); ?>" class="menu-link">
                  &nbsp;&nbsp;&nbsp;
                  <div data-i18n="Authentications">Question List</div>
               </a>
            </li>
         </ul>
      <?php endif; ?>

      <?php if($this->session->userdata('user_role')==2): ?>

      <li class="menu-header small text-uppercase"><span class="menu-header-text">EMPLOYEE</span></li>
      <li class="menu-item">
         <a href="<?php echo base_url('assign-employee-list'); ?>" class="menu-link">
            <i class='bx bx-pin'></i> &nbsp;&nbsp;&nbsp;
            <div data-i18n="Basic">Employee List</div>
         </a>
      </li>

      <?php endif; ?>

      <?php if($this->session->userdata('user_role')==3): ?>
      <li class="menu-header small text-uppercase"><span class="menu-header-text">Performance</span></li>
      <li class="menu-item">
         <a href="<?php echo base_url('admin/view-employee-performance-list'); ?>" class="menu-link">
            <i class='bx bx-line-chart'></i> &nbsp;&nbsp;&nbsp;
            <div data-i18n="Authentications">Evaluated Performance</div>
         </a>
      </li>
      <?php endif; ?>

      <?php if($this->session->userdata('user_role')==2): ?>
      <li class="menu-header small text-uppercase"><span class="menu-header-text">Performance</span></li>
      <li class="menu-item">
         <a href="<?php echo base_url('supervisor/view-employee-performance-list'); ?>" class="menu-link">
            <i class='bx bx-line-chart'></i> &nbsp;&nbsp;&nbsp;
            <div data-i18n="Authentications">Evaluated Performance</div>
         </a>
      </li>
      <?php endif; ?>

      <?php if($this->session->userdata('user_role')==3): ?>
      <li class="menu-header small text-uppercase"><span class="menu-header-text">SUPERVISOR</span></li>
      <li class="menu-item">
         <a href="<?php echo base_url('assign-supervisor'); ?>" class="menu-link">
            <i class='bx bx-pin'></i> &nbsp;&nbsp;&nbsp;
            <div data-i18n="Basic">Assign Supervisor</div>
         </a>
      </li>

      <?php endif; ?>
      <?php if($this->session->userdata('user_role')==3): ?>
      <li class="menu-header small text-uppercase"><span class="menu-header-text">Notifications</span></li>
      <li class="menu-item">
         <a href="<?php echo base_url(''); ?>" class="menu-link">
            <i class='bx bx-envelope'></i> &nbsp;&nbsp;&nbsp;
            <div data-i18n="Basic">Email Notification</div>
         </a>
      </li>
      <?php endif; ?>

   </ul>
</aside>
<div class="layout-page">
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
   <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
      <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="bx bx-menu bx-sm"></i>
      </a>
   </div>
   <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
      <div class="navbar-nav align-items-center">
         <div class="nav-item d-flex align-items-center">
         </div>
      </div>
      <ul class="navbar-nav flex-row align-items-center ms-auto">
         <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
               <div class="avatar avatar-online">
                  <img src="<?php echo base_url($this->session->userdata('image')); ?>" alt="employee profile" class="w-px-40 h-auto rounded-circle" />
               </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
               <li>
                  <a class="dropdown-item" href="<?php echo base_url("employee-profile"); ?>">
                     <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                           <div class="avatar avatar-online">
                              <img src="<?php echo base_url($this->session->userdata('image')); ?>" alt="employee profile" class="w-px-40 h-auto rounded-circle" />
                           </div>
                        </div>
                        <div class="flex-grow-1">
                          <?php 
                            switch($this->session->userdata('user_role')){
                              case 1:
                                $role = 'Employee';
                                break;
                              case 2:
                                $role = 'Supervisor';
                                break;
                              case 3:
                                $role = 'Admin';
                                break;
                              default:
                                $role = '';
                                break;
                            }
                          ?>
                           <span class="fw-semibold d-block"><?php echo  $role; ?></span>
                           <small class="text-muted"></small>
                        </div>
                     </div>
                  </a>
               </li>
               <li>
                  <div class="dropdown-divider"></div>
               </li>
               <li>
                  <a class="dropdown-item" href="<?php echo base_url(''); ?>">
                  <i class='bx bx-wrench me-2'></i>
                  <span class="align-middle">Change Password</span>
                  </a>
               </li>
               <li>
                  <a class="dropdown-item" href="<?php echo base_url('logout'); ?>">
                  <i class="bx bx-power-off me-2"></i>
                  <span class="align-middle">Log Out</span>
                  </a>
               </li>
            </ul>
         </li>
      </ul>
   </div>
</nav>