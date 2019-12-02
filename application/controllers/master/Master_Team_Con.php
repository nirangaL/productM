<?php
//
error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_Team_Con extends MY_Controller{

  function __construct(){
    parent::__construct();
    $this->checkSession();
    $this->load->model('master/Master_team_model');
  }

  public function index(){
    $data['teams'] = $this->Master_team_model->getAllTeam();

    // print_r($data);exit();

    $this->load->view('template/header',$data);
    $this->load->view('template/sidebar');
    $this->load->view('master/team/team_list');
    $this->load->view('template/footer');
  }

  public function addTeam(){
    $data['locations'] = $this->Master_team_model->getAllLocations();
    $this->load->view('template/header',$data);
    $this->load->view('template/sidebar');
    $this->load->view('master/team/team_add');
    $this->load->view('template/footer');
  }

  public function getDepart(){
    $result = $this->Master_team_model->getDepart();
    if(!empty($result)){
      echo json_encode($result);
    }else{
      echo "";
    }
  }

  public function saveData(){
      if($this->formValidation('save')){
        $result = $this->Master_team_model->saveData();
        if(!empty($result)){
          redirect(base_url('master/Master_Team_Con'), 'refresh');
        }else{
          $this->addTeam();
        }
      }
  }

  public function getTeamToEdit($teamId){
    $data['locations'] = $this->Master_team_model->getAllLocations();
    $data['editTeam'] = $this->Master_team_model->getTeamToEdit($teamId);
    $this->load->view('template/header',$data);
    $this->load->view('template/sidebar');
    $this->load->view('master/team/team_edit');
    $this->load->view('template/footer');

  }

  public function updateData($teamId){
    if($this->formValidation('edit')){
      $result = $this->Master_team_model->updateData($teamId);
      if(!empty($result)){
        redirect(base_url('master/Master_Team_Con'), 'refresh');
      }else{
        $this->getTeamToEdit($teamId);
      }
    }
  }

  public function formValidation($valildTo){

    if($valildTo=='save'){
        $this->form_validation->set_rules('location', 'Location', 'trim|required');
        $this->form_validation->set_rules('department', 'Department', 'trim|required');
        $this->form_validation->set_rules('team', 'Team', 'trim|required');

        $result = $this->Master_team_model->validateTeam();
        if(!empty($result)){
          return false;
        }
    }
    if($valildTo=='edit'){
      $this->form_validation->set_rules('team', 'Team', 'trim|required');

      $result = $this->Master_team_model->validateTeam();
      if(!empty($result)){
        return false;
      }

    }

    return $this->form_validation->run();

  }

  public function validateTeam(){
    $result = $this->Master_team_model->validateTeam();
    if(!empty($result)){
      echo "duplicate";
    }else{
      echo "valid";
    }


  }

}
