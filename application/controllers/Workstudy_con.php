<?php
/**
* Created by PhpStorm.
* User: nirangal
* Date: 01/23/2019
* Time: 8:32 AM
*/
//
//error_reporting(-1);
//ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');
class Workstudy_con extends MY_Controller{
  public function __construct(){
    parent::__construct();
    $this->checkSession();
    $this->load->model('ProducLine_model');
    $this->load->model('Style_model');
    $this->load->model('Workstudy_model');
    $this->load->model('Plan_efficiency_model');
  }

  public function index(){
    $data['dayPlans'] = $this->Workstudy_model->getAllDayPlans();

    $this->load->view('template/header',$data);
    $this->load->view('template/sidebar');
    $this->load->view('workstudy/dayPlanList');
    $this->load->view('template/footer');
  }

  public function addNewDayPlan(){

    $data['prdocLine'] = $this->ProducLine_model->getProdcLine();
    $data['style'] = $this->Style_model->getStyle();
    $data['timeTempl'] = $this->Workstudy_model->getTimeTemplate($_SESSION['session_user_data']['location']);

    $this->load->view('template/header',$data);
    $this->load->view('template/sidebar');
    $this->load->view('workstudy/addNewDayPlan');
    $this->load->view('template/footer');
  }

  public function getDelivery(){
    $result =  $this->Style_model->getDelivery();
    echo json_encode($result);
  }

  public function getOrderQty(){
    $result =  $this->Style_model->getOrderQty();
    echo json_encode($result);
  }

  public function saveDayPlan(){
    if($this->dayPlanFormValidation('save')) {
      $result = $this->Workstudy_model->saveDayPlan();
      if($result){
        redirect(base_url('Workstudy_con'), 'refresh');
      }else{
        $this->addNewDayPlan();
      }
    }else{
      $this->addNewDayPlan();
    }
  }

  public function getDatPlanToEdit($planId){
    $data['prdocLine'] = $this->ProducLine_model->getProdcLine();
    $data['style'] = $this->Style_model->getStyle();
    $data['dayPlanData'] = $this->Workstudy_model->getDatPlanToEdit($planId);
    $data['timeTempl'] = $this->Workstudy_model->getTimeTemplate($_SESSION['session_user_data']['location']);

    $this->load->view('template/header',$data);
    $this->load->view('template/sidebar');
    $this->load->view('workstudy/editDayPlan');
    $this->load->view('template/footer');
  }

  public function editDayPlan($planId){

      if($this->dayPlanFormValidation('edit')) {
        $result = $this->Workstudy_model->editDayPlan($planId);
        if($result){
          redirect(base_url('Workstudy_con'), 'refresh');
        }else{
          $this->getDatPlanToEdit($planId);
        }
      }else{
        $this->getDatPlanToEdit($planId);
      }


  }

  public function dayPlanFormValidation($task){
    if($task=='save'){
      $this->form_validation->set_rules('line', 'Team', 'trim|required');
      $this->form_validation->set_rules('style', 'Style', 'trim|required');
      $this->form_validation->set_rules('dayPlanType', 'dayPlanType', 'trim|required');
      $this->form_validation->set_rules('timeTempl', 'timeTempl', 'trim|required');
      $this->form_validation->set_rules('delivery', 'Delivery', 'trim|required');
      $this->form_validation->set_rules('smv', 'SMV', 'trim|required');
      $this->form_validation->set_rules('workingHrs', 'Hrs', 'trim|required');
      $this->form_validation->set_rules('noOfWorkser', 'No Of Workers', 'trim|required');
      $this->form_validation->set_rules('ince_hour', 'Incentive calculate Hour', 'trim|required');
    }
    if($task=='edit'){
      // $this->form_validation->set_rules('line', 'Team', 'trim|required');
      // $this->form_validation->set_rules('style', 'Style', 'trim|required');
      // $this->form_validation->set_rules('dayPlanType', 'dayPlanType', 'trim|required');
      // $this->form_validation->set_rules('timeTempl', 'timeTempl', 'trim|required');
      // $this->form_validation->set_rules('delivery', 'Delivery', 'trim|required');
      $this->form_validation->set_rules('smv', 'SMV', 'trim|required');
      $this->form_validation->set_rules('workingHrs', 'Hrs', 'trim|required');
      $this->form_validation->set_rules('noOfWorkser', 'No Of Workers', 'trim|required');
      $this->form_validation->set_rules('ince_hour', 'Incentive calculate Hour', 'trim|required');
    }
    return $this->form_validation->run();
  }

  public function checkLineIsRunning(){
    $result = $this->Workstudy_model->checkLineIsRunning();
    if($result){
      echo $result[0]->style;
    }else{
      echo 'notRunning';
    }
  }

  public function getStyleRunDays(){

    $styleRunDays = $this->Workstudy_model->getStyleRunDays();

    $fDay = 'n';
    if($styleRunDays['num_rows'] == 0){
      $fDay = 'y';
      $styleRunDays['num_rows'] = 1;
    }

    $runDaysinToday = $styleRunDays['num_rows']+1;

    $result = $this->Workstudy_model->needRuningDaysEffi( $runDaysinToday);


    if(!empty($result)){
      $result[0]->styleRunDays = new stdClass();
      if( $fDay == 'y'){
        $result[0]->styleRunDays = 0;
      }else{
        $result[0]->styleRunDays = $styleRunDays['num_rows'];
      }
      $result[0]->lastRunDate = new stdClass();
      $result[0]->lastRunDate = $styleRunDays['lastRunDate'];
      echo json_encode($result);
    }
  }

  public function getPlannedQty(){

    $smv = $this->input->post('smv');
    $hrs = $this->input->post('hrs');
    $workersCount = $this->input->post('workers');

    $result = $this->Workstudy_model->getStyleRunDays();

    if(empty($result) || $result['num_rows'] =='0'){
      $styleRunnigDaysCount = 1;
    }else {
      $styleRunnigDaysCount = $result['num_rows'];
    }

    //        echo 'style run days  '. $styleRunnigDaysCount.'---';

    $PlanEff = $this->Plan_efficiency_model->getDayPlanEff($styleRunnigDaysCount);


    if(empty($PlanEff)){
      $PlanEff = $this->Plan_efficiency_model->getLasDayPlanEff();
    }
    $dayPlanEff = $PlanEff[0]->efficiency;

    //        echo 'plan eff  '.$dayPlanEff.'---';

    $dayPlannedQty = ((($workersCount/$smv)*60)*$dayPlanEff)*$hrs;

    echo (Int)$dayPlannedQty;exit();

  }

  ///// Get planned Efficiency //////
  public function getPreRunnigDayPlan(){
    $result = $this->Workstudy_model->getPreRunnigDayPlan();
    if($result){
      echo json_encode($result);
    }else{
      echo 'noPreDayPlan';
    }
  }

}
