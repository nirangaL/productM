<?php

error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');
class Team_Workers_List_Con extends MY_Controller{

    private $location;
    function __construct(){
        parent::__construct();
        $this->checkSession();
        $this->location = $_SESSION['session_user_data']['location'];;
        $this->load->model('report/Team_workers_list_model');
    }

    public function index($date='',$dep='',$team='',$result=''){

      $data['department'] = $this->Team_workers_list_model->getDepartment($this->location);
      $data['team'] = $this->Team_workers_list_model->getTeam($this->location);

      $data['tableData'] = $result;

      $data['selectDate'] = $date;
      $data['selectDep'] = $dep;
      $data['selectTeam'] = $team;


      $this->load->view('template/header',$data);
      $this->load->view('template/sidebar');
      $this->load->view('report/team_worker_list');
      $this->load->view('template/footer');
    }

    public function getTeam(){
      $result = $this->Team_workers_list_model->getTeam($this->location);

      if($result){
        echo json_encode($result);
      }else{
        echo "";
      }
    }

    public function getTableData(){
      $date = $this->input->post('date');
      $teamId = $this->input->post('team');
      $department = $this->input->post('department');

        if($date !='' ){
            $result =  $this->Team_workers_list_model->getWorkersList();

            if($result){
                $this->index($date,$department,$teamId,$result);
//               print_r($result);exit();
            }else{
                $this->index($date,$department,$teamId,$result='');
            }
        }
    }

}
