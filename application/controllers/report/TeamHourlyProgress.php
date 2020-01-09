<?php
//
error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class TeamHourlyProgress extends MY_Controller{

    function __construct()
    {
        parent::__construct();
        $this->checkSession();
        $this->load->model('report/Team_hourly_progress_model');
    }

    public function index($date='',$selectLocation ='',$result='',$maxHour=0){

        $data['tableData'] = $result;
        $data['selectDate'] = $date;
        $data['selectLocation'] = $selectLocation;
        $data['maxHour'] = $maxHour;

        $data['location']   =  $this->Team_hourly_progress_model->getLocation();

        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('report/team_hourly_progress_view');
        $this->load->view('template/footer');
    }

    public function getTableData(){

        $date = $this->input->post('date');
        $location = $this->input->post('location');

        $data = array();

        if($date !='' && $location !=''){

            $teams = $this->Team_hourly_progress_model->getTeam($location);
            $i = 0;
            $maxHour = 0;
            foreach($teams as $team){
                $hourData =  $this->Team_hourly_progress_model->getTableData($date,$team->line_id);
                if($maxHour < count($hourData) ){
                    $maxHour =  count($hourData);
                } 
               
                $data[$i] = $hourData;
                $i = $i + 1;
            }

            // print_r($data);exit();

            if($data){
                $this->index($date,$location,$data,$maxHour);
            }else{
                $this->index($date,$location,$data='',$maxHour);
            }
        }
    }


}
