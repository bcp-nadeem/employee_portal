<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'LandingPage';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth Routes
$route['login'] = 'auth/login/index';
$route['logout'] = 'auth/login/logout';


// API Routes

$route['api/users'] = 'ApiController/indexUsers';
$route['api/user/(:any)'] = 'ApiController/indexUser/$1';



// Admin Routes

// All Add Fuctions Group
$route['admin/dashboard'] = 'admin/AM_Controller/index';
$route['add-department'] = 'admin/AM_Controller/addDepartment';
$route['add-designation'] = 'admin/AM_Controller/addDesignation';
$route['add-spectrum'] = 'admin/AM_Controller/addSpectrum';
$route['add-employee'] = 'admin/AM_Controller/addEmployee';
$route['add-salary'] = 'admin/AM_Controller/addSalary';
$route['add-sections'] = 'admin/AM_Controller/addSection';
$route['add-questions'] = 'admin/AM_Controller/addQuestion';
$route['add-levels'] = 'admin/AM_Controller/addLevels';

$route['assign-supervisor'] = 'admin/AM_Controller/assignSupervisorPage';
$route['employee-salary'] = 'admin/AM_Controller/employeeSalary';

$route['employee-performance-history:(any)'] = 'admin/AM_Controller/employeePerformanceHistory/$1';

// All List Functions Group
// Department List Routes
$route['department-list'] = 'admin/AM_Controller/departmentList';
$route['designation-list'] = 'admin/AM_Controller/designationList';
$route['spectrum-list'] = 'admin/AM_Controller/viewSpectrumList';
$route['level-list'] = 'admin/AM_Controller/getEmployeeLevelList';
$route['employee-list'] = 'admin/AM_Controller/viewEmployeeList';
$route['section-list'] = 'admin/AM_Controller/getSectionList';
$route['question-list'] = 'admin/AM_Controller/getQuestionList';
$route['admin/view-employee-performance-list'] = 'admin/AM_Controller/viewEmployeePerformanceList';
$route['admin/employee-performance-history'] = 'admin/AM_Controller/viewEmployeePerformanceHistory';

// Department List Routes with Paramiters
$route['assign-employee-list/(:any)'] = 'admin/AM_Controller/showEmployeeAssignEmployee/$1';

// Profile Details

// $route['department-list/(:num)'] = 'admin/AM_Controller/departmentList/$1';

// Supervisor Routes

$route['supervisor/dashboard'] = 'supervisor/SV_Controller/index';
$route['assign-employee-profile:(any)'] = 'supervisor/SV_Controller/viewAssignEmployeeProfileDetails/$1';
$route['supervisor/view-employee-performance-list'] = 'supervisor/SV_Controller/viewEmployeePerformanceList';
$route['assign-employee-list'] = 'supervisor/SV_Controller/getAssignEmployeeList';



// Employee Routes

$route['employee/dashboard'] = 'employee/EM_Controller/index';
$route['employee-profile'] = 'employee/EM_Controller/employeeProfile';
$route['submit-evaluation'] = 'employee/EM_Controller/submitEmployeeEvaluation';
$route['employee-evaluation-list'] = 'employee/EM_Controller/listEmployeeEvaluation';




// Testing
