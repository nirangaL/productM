<?php

error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Cut_In_Con extends MY_Controller{

    public $team;

    function __construct() {
        parent::__construct();
        $this->checkCookies();
        $this->team = get_cookie('line');
        $this->load->model('Style_model');
        $this->load->model('app/Cut_in_model');
    }


    public function index(){
        $data['style'] = $this->Style_model->getStyle();
        $this->load->view('app/templateApp/header',$data);
        // $this->load->view('app/templateApp/sidebar');
        $this->load->view('app/teamRecoder/cut_in_view');
        $this->load->view('app/templateApp/footer');
    }

    public function getDelv(){
        $result = $this->Style_model->getDelivery();
        if($result){
            echo json_encode($result);
        }else{
            echo '';
        }
    }

    public function getColor(){
        $result = $this->Style_model->getColor();
        if($result){
            echo json_encode($result);
        }else{
            echo '';
        }
    }

    public function getSize(){
        $result = $this->Style_model->getSize();
        if($result){
            echo json_encode($result);
        }else{
            echo '';
        }
    }

    public function saveInput(){
        $result = $this->Cut_in_model->saveInput($this->team);
        if($result){
            echo 'success';
        }else{
            echo 'fail';
        }
    }

    public function savedInputTotal(){
        $totalInput =  $this->Cut_in_model->savedInputTotal($this->team);
        if($totalInput){
         echo json_encode($totalInput);
        }

    }
    public function getSavedInput(){
        $result = $this->Cut_in_model->getSavedInput($this->team);
        if($result){
            echo json_encode($result);
        }else{
            echo 'noInput';
        }
    }

    public function getLastEnterSizeInput(){
      $result = $this->Cut_in_model->getLastEnterSizeInput($this->team);
      if($result){
          echo json_encode($result);
      }else{
          echo 'noInput';
      }
    }

    public function editInput()  {
      $result = $this->Cut_in_model->editInput();
      if($result){
          echo 'success';
      }else{
          echo 'fail';
      }
    }
}
