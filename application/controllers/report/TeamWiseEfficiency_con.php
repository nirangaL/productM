<?php
//
// error_reporting(-1);
// ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class TeamWiseEfficiency_con extends MY_Controller{

    function __construct()
    {
        parent::__construct();
        $this->checkSession();
        $this->load->model('report/Team_wise_efficiency_model');
    }

    public function index($date='',$selectLocation ='',$result=''){

        $data['tableData'] = $result;
        $data['selectDate'] = $date;
        $data['selectLocation'] = $selectLocation;

        $data['location']   =  $this->Team_wise_efficiency_model->getLocation();

        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('report/style/TeamWiseEfficiencyReport');
        $this->load->view('template/footer');
    }

    public function getTableData(){

        $date = $this->input->post('date');
        $location = $this->input->post('location');

        if($date !='' ){
            $result =  $this->Team_wise_efficiency_model->getTableData($date,$location);

            if($result){
                $this->index($date,$location,$result);
            }else{
                $this->index($date,$location,$result='');
            }
        }
    }


}
