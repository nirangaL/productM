<?php
//
error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class MonthlyEfficiecnyReport_con extends MY_Controller{

    function __construct()
    {
        parent::__construct();
        $this->checkSession();
        $this->load->model('report/Monthly_efficiency_model');
    }

    public function index($month='',$selectLocation ='',$result=''){

        $data['tableData'] = $result;
        $data['selectMonth'] = $month;
        $data['selectLocation'] = $selectLocation;

        $data['location']   =  $this->Monthly_efficiency_model->getLocation();

        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('report/style/monthlyEfficiencyReport');
        $this->load->view('template/footer');
    }

    public function getTableData(){

        $date = $this->input->post('date');
        $location = $this->input->post('location');



        if($date !='' ){
            $result =  $this->Team_wise_efficiency_model->getTableData($date,$location);

            if($result){
                $this->index($date,$location,$result);
//               print_r($result);exit();
            }else{
                $this->index($date,$location,$result='');
            }
        }
    }


}