<?php

//error_reporting(-1);
//ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Worker_Hourly_Out_Con extends MY_Controller{

    private $teamId;

    function __construct(){
        parent::__construct();
        $this->checkCookies();
        $this->teamId = get_cookie('line');
        $this->load->model('app/Worker_hourly_out_model');
    }


    public function index(){

        $this->load->view('app/templateApp/header');
        // $this->load->view('app/templateApp/sidebar');
        $this->load->view('app/teamRecoder/worker_hourly_out.php');
        $this->load->view('app/templateApp/footer');
    }

    public function getEmps(){

        $result = $this->Worker_hourly_out_model->getEmps($this->teamId);

        if($result){
            echo json_encode($result);
        }else{
            echo 'noData';
        }
    }
    public function setWorkerHourlyOut(){
        $result = $this->Worker_hourly_out_model->setWorkerHourlyOut($this->teamId);

        if($result){
            echo 'success';
        }else{
            echo 'failure';
        }
    }

    public function getSavedHourlyData(){

        $result = $this->Worker_hourly_out_model->getSavedHourlyData($this->teamId);
        if($result){
            echo json_encode($result);
        }else{
            echo 'noData';
        }
    }

    public function editEmpQty(){

        $result = $this->Worker_hourly_out_model->editEmpQty();
        if($result){
            echo 'success';
        }else{
            echo 'fail';
        }
    }

}
