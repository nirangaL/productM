<?php
// error_reporting(-1);
// ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');
class Incentive_con extends MY_Controller{

    function __construct(){
        parent::__construct();
        $this->checkSession();
        $this->load->model('Incentive_model');
    }

    public function index(){

        $data['range'] = $this->Incentive_model->getRange($this->myConlocation);

        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('master/incentive/incentive_ladder_list');
        $this->load->view('template/footer');
    }

    public function addNewRange(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('master/incentive/addIncentiveMaster');
        $this->load->view('template/footer');
    }

    public function setIncentiveRenge(){
      $result = $this->Incentive_model->setIncentiveRenge($this->myConlocation);

      if($result){
          redirect(base_url('Incentive_con'), 'refresh');
      }else{
          $this->addNewRange();
      }
    }

    public function checkOutSmvRange(){
        $result = $this->Incentive_model->checkOutSmvRange($this->myConlocation);

        if($result){
            echo 'notOk';
        }else{
            echo 'ok';
        }
    }

    public function getIncentiveRangeToEdit($id){
      $data['lData'] = $this->Incentive_model->getIncentiveRangeToEdit($id);

      $this->load->view('template/header',$data);
      $this->load->view('template/sidebar');
      $this->load->view('master/incentive/editIncentiveMaster');
      $this->load->view('template/footer');

    }
    public function editIncentiveRenge($id){
      $result = $this->Incentive_model->editIncentiveRenge($id);
      if($result){
          redirect(base_url('Incentive_con'), 'refresh');
      }else{
          $this->addNewRange();
      }
    }

}
