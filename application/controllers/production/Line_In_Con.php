<?php

error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Line_In_Con extends MY_Controller{

  public function __construct() {
    parent::__construct();
    $this->checkSession();
    $this->load->model('production/Line_in_model');
  }

  public function index(){
    $data['style'] = $this->Line_in_model->getStyle();
    $data['team'] = $this->Line_in_model->getTeam($this->myConLocation);

    $this->load->view('template/header',$data);
    $this->load->view('template/sidebar');
    $this->load->view('production/line_in_add');
    $this->load->view('template/footer');
  }

  public function getDelivery(){
    $result = $this->Line_in_model->getDelivery();
    if($result){
      echo json_encode($result);
    }else{
      echo 'noDelv';
    }
  }

  public function getColor(){
    $result = $this->Line_in_model->getColor();
    if($result){
      echo json_encode($result);
    }else{
      echo 'noColor';
    }
  }

  public function getSavedData(){
    $result = $this->Line_in_model->getSavedData();
    if($result){
      echo json_encode($result);
    }else{
      echo '';
    }
  }

  public function getSeason(){
    $result = $this->Line_in_model->getSeason();
    if($result){
      echo json_encode($result);
    }else{
      echo 'noData';
    }
  }

  public function getStyleData(){
    $result = $this->Line_in_model->getStyleData();
    if($result){
      echo json_encode($result);
    }else{
      echo 'noData';
    }
  }

  public function setData(){

    $result = $this->Line_in_model->setData();
    if($result){
      echo "Saved";
    }else{
      echo 'failed';
    }
  }

  public function updateData(){
    $result = $this->Line_in_model->updateData();
    if($result){
      echo "Updated";
    }else{
      echo 'failed';
    }
  }

  public function getRefNumber(){
    $result = $this->Line_in_model->getRefNumber();
    if($result){
      echo (Int)$result[0]->refNumber + 1;
    }else{
      echo '';
    }
  }

  public function editData(){
    $editId = $this->input->post('id');
    $includeDelv = $this->Line_in_model->getincludeDelv($editId);

    // print_r($includeDelv);exit();

    if($includeDelv){
      $data = new stdClass;
      $i=0;
      foreach ($includeDelv as $row ) {
        $result = $this->Line_in_model->editData($editId,$row->po);

        if($result){
          $data->$i = $result;
          $i++;
        }
      }
      echo json_encode($data);
    }
  }

  public function getOrderQtyEachSize(){
  	$result = $this->Line_in_model->getOrderQtyEachSize();
  	if($result){
  		echo json_encode($result);
  	}else{
  		echo 'noData';
  	}
  }

}
?>
