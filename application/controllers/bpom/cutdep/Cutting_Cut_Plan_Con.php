<?php
error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Cutting_Cut_Plan_Con extends MY_Controller{

	public function __construct() {
		parent::__construct();
		$this->checkSession();
		$this->load->model('bpom/cutdep/Cutting_cut_plan_model');
	}

	public function index($date=''){

    if($date == ''){
      $date = date('Y-m-d');
    }

  $data['m_cut_plan'] = $this->Cutting_cut_plan_model->getMerchCutPlan($date);
		$data['date'] = $date;
		$this->load->view('template/header',$data);
		$this->load->view('template/sidebar');
		$this->load->view('bpom/cut_plan/cutting_cut_plan_proceed');
		$this->load->view('template/footer');
	}

  public function findCutPlan(){
    $date = $this->input->post('date');
		redirect(base_url('bpom/cutdep/Cutting_Cut_Plan_Con/index/').$date);
  }

public function getCutPlanDetails(){
	$cutPlanId = $this->input->post('cutPlanId');
	$includeDelv = $this->Cutting_cut_plan_model->getincludeDelv($cutPlanId);

	// print_r($includeDelv);exit();

	if($includeDelv){
		$data = new stdClass;
		$i=0;
		foreach ($includeDelv as $row ) {
			$result = $this->Cutting_cut_plan_model->getCutPlanDetails($cutPlanId,$row->po);

			if($result){
				$data->$i = $result;
				$i++;
			}
		}
		// print_r($data);exit();
		echo json_encode($data);
	}
}

public function proceedCutPlan(){
	$result = $this->Cutting_cut_plan_model->proceedCutPlan();

	if($result){
		echo "Proceed";
	}else{
		echo "Failed";
	}
}

}
