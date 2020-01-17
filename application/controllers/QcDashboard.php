<?php
error_reporting(-1);
ini_set('display_errors', 1);
class QcDashboard extends MY_Controller{


    function __construct(){
        parent::__construct();
        $this->checkSession();
        $this->location = $this->myConlocation;
        $this->load->model('Qc_dashboard_model');
    }

    public function index(){

        // $location = $this->Qc_dashboard_model->getLocation();    

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('qc_dashboard_view');
        $this->load->view('template/footer');
    }

    public function getQcData(){
        $location = $this->input->post('location');
        $date = $this->input->post('date');

        if($location == ''){
            $location = $this->location;
        }
        if($date == ''){
            $date = date('Y-m-d');
        }

        $teams= $this->Qc_dashboard_model->getTeams($location);
        $i = 0;
        $data = '';
        foreach($teams as $team){
            $result['teamData'][$i] = $this->Qc_dashboard_model->getData($team->teamId,$date);
            $result['remakeData'][$i] = $this->Qc_dashboard_model->getRemakeDate($team->teamId,$date);
            $i = $i+1;
        }

        $result['totalData'] = $this->Qc_dashboard_model->getAllDefectSumm($location,$date);

        echo json_encode($result);

        
    }

}