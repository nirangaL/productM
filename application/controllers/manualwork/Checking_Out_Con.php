<?php
// error_reporting(-1);
// ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');
class Checking_Out_Con extends MY_Controller{

  function __construct(){
    parent::__construct();
    $this->checkSession();
    $this->load->model('manualwork/Checking_out_model');
  }

  public function index(){

    $data['locations'] = $this->Checking_out_model->getAllLocation();

    $this->load->view('template/header',$data);
    $this->load->view('template/sidebar');
    $this->load->view('manualwork/add_checker_out');
    $this->load->view('template/footer');
  }

  public function getTeams(){
    $result = $this->Checking_out_model->getTeams();

    if(!empty($result)){
      echo json_encode($result);
    }
  }

  public function addToLog(){
  $result = $this->Checking_out_model->addToLog();

  // if($result){
  //
  // }else{
  //
  // }

  }


}
