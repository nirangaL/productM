<?php
//
error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_Department_Con extends MY_Controller{

    function __construct(){
        parent::__construct();
        $this->checkSession();
        $this->load->model('master/Master_department_model');
    }

    public function index(){
        $data['departments'] = $this->Master_department_model->getAllDepartment();

        // print_r($data);exit();

        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('master/department/department_list');
        $this->load->view('template/footer');
    }

    public function addDepartment(){
      $data['locations'] = $this->Master_department_model->getAllLocations();
      // print_r($data);exit();
      $this->load->view('template/header',$data);
      $this->load->view('template/sidebar');
      $this->load->view('master/department/department_add');
      $this->load->view('template/footer');
    }

}
