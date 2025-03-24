<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

use chriskacerguis\RestServer\RestController;
header("Access-Control-Allow-Origin: https://bimcapability.com/testing-eep/");


class ApiController extends RestController
{
   public function __construct() {
      parent::__construct();
      
      // Load required dependencies
      $this->load->database();
      $this->load->model('api_model/Api_model', 'api_model');
      
      // Set CORS headers with specific origin
      $allowed_origins = array(
          'https://bimcapability.com/testing-eep/',
          'http://localhost:3000'  // Add local development URL if needed
      );
      
      $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
      
      if (in_array($origin, $allowed_origins)) {
          header('Access-Control-Allow-Origin: ' . $origin);
          header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
          header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
          header('Access-Control-Allow-Credentials: true');
          
          // Handle preflight OPTIONS request
          if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
              header('HTTP/1.1 200 OK');
              exit();
          }
      }
   }
  
    public function indexUsers_get(){
       $this->load->model('api_model/Api_model', 'api_model');
       $result_emp = $this->api_model->get_employees_record_api();
       $this->response($result_emp, 200);
    }

    public function indexUser_get($id){
        $this->load->model('api_model/Api_model', 'api_model');
        $result_emp = $this->api_model->get_employee_record_api($id);
        $this->response($result_emp, 200);
     }
}
?>