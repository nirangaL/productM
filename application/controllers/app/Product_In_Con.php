<?php
//
// error_reporting(-1);
// ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_In_Con extends MY_Controller{
    private $team;

    function __construct(){
        parent::__construct();
        $this->checkCookies();
        $this->team = get_cookie('line');
        $this->load->model('Style_model');
        $this->load->model('app/Product_in_model');
    }

    public function index(){

        $data['style'] = $this->Product_in_model->getStyle($this->team);

        $this->load->view('app/templateApp/header',$data);
        // $this->load->view('app/templateApp/sidebar');
        $this->load->view('app/teamRecoder/product_in');
        $this->load->view('app/templateApp/footer');
    }

    public function getDelv(){
        $result = $this->Product_in_model->getDelivery($this->team);
        if($result){
            echo json_encode($result);
        }else{
            echo '';
        }
    }

    public function getColor(){
        $result = $this->Product_in_model->getColor($this->team);
        if($result){
            echo json_encode($result);
        }else{
            echo '';
        }
    }

    public function getSize(){
        $result = $this->Product_in_model->getSize($this->team);
        if($result){
            echo json_encode($result);
        }else{
            echo '';
        }
    }

    public function getBalance(){
        $result = $this->Product_in_model->getBalance($this->team);
        if($result){
            echo json_encode($result);
        }else{
            echo '';
        }
    }

    public function saveInput(){
        $result = $this->Product_in_model->saveInput($this->team);
        if($result){
            echo 'success';
        }else{
            echo 'fail';
        }
    }

    public function getSavedInput(){
        $result = $this->Product_in_model->getSavedInput($this->team);
        if($result){
            echo json_encode($result);
        }else{
            echo 'noInput';
        }
    }

    public function getLastEnterSizeInput(){
      $data['editData'] = $this->Product_in_model->getLastEnterSizeInput($this->team);
      $result = $this->Product_in_model->getBalance($this->team);

      if(!empty($result)){
        $data['editData'][0]->balanceQty = new stdClass();
        $data['editData'][0]->balanceQty = $result[0]->balanceQty;
      }

      if($data['editData']){
          echo json_encode($data['editData']);
      }else{
          echo 'noInput';
      }
    }

    public function editInput()  {
      $result = $this->Product_in_model->editInput();
      if($result){
          echo 'success';
      }else{
          echo 'fail';
      }
    }
}
