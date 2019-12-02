<?php
//
error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class StyleSizeWise_con extends MY_Controller{

    function __construct(){
        parent::__construct();
        $this->checkSession();
        $this->load->model('report/Style_size_wise_model');
        $this->load->model('Style_model');
    }

    public function index($style='',$delivery='',$team='',$result=''){

        $data['style'] = $this->Style_model->getProcessedStyle();
        $data['tableData'] = $result;
        $data['selectStyle'] = $style;
        $data['selectDelivery'] = $delivery;
        $data['selectTeam'] = $team;

        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('report/style/styleSizeWiseReport');
        $this->load->view('template/footer');
    }


    public function getDelivery(){
        $result = $this->Style_model->getProcessedDelivery();
        echo json_encode($result);
    }

    public function getTeam(){
        $result = $this->Style_model->getStyleProcessedTeam();
        if($result){
            echo json_encode($result);
        }

    }

    public function getTableData(){
        $style = $this->input->post('style');
        $delivery = $this->input->post('delivery');
        $team = $this->input->post('team');

        if($style !='' && $delivery != '' && $team !=''){
            $result =  $this->Style_size_wise_model->getTableData($style,$delivery,$team);

            if($result){
                $this->index($style,$delivery,$team,$result);
            }else{
                $this->index($style,$delivery,$team,$result='');
            }
        }


    }
}