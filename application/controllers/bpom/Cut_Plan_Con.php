<?php
error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Cut_Plan_Con extends MY_Controller{

	public function __construct() {
		parent::__construct();
		$this->checkSession();
		$this->load->model('bpom/Cut_plan_model');
	}

	public function index(){
		$data['style'] = $this->Cut_plan_model->getStyle();
		$this->load->view('template/header',$data);
		$this->load->view('template/sidebar');
		$this->load->view('bpom/cut_plan/cut_plan_add');
		$this->load->view('template/footer');
	}

	public function getDelivery(){
		$result = $this->Cut_plan_model->getDelivery();
		if($result){
			echo json_encode($result);
		}else{
			echo 'noDelv';
		}
	}

	public function getColor(){
		$result = $this->Cut_plan_model->getColor();
		if($result){
			echo json_encode($result);
		}else{
			echo 'noColor';
		}
	}

	public function getCTplanTableData(){
		$result = $this->Cut_plan_model->getCTplanTableData();
		if($result){
			echo json_encode($result);
		}else{
			echo 'noData';
		}
	}

	public function getSeason(){
		$result = $this->Cut_plan_model->getSeason();
		if($result){
			echo json_encode($result);
		}else{
			echo 'noData';
		}
	}

	public function getStyleData(){
		$result = $this->Cut_plan_model->getStyleData();
		if($result){
			echo json_encode($result);
		}else{
			echo 'noData';
		}
	}

	public function setCutPlan(){

		$result = $this->Cut_plan_model->setCutPlan();
		if($result){
			echo "Saved";
		}else{
			echo 'failed';
		}
	}

	public function updateCutPlan(){
		$result = $this->Cut_plan_model->updateCutPlan();
		if($result){
			echo "Updated";
		}else{
			echo 'failed';
		}
	}

	public function getCutPlanNumber(){
		$result = $this->Cut_plan_model->getCutPlanNumber();
		if($result){
			echo (Int)$result[0]->countCutPlan + 1;
		}else{
			echo '';
		}
	}

	public function editCutPlan(){
		$cutPlanId = $this->input->post('cutPlanId');
		$includeDelv = $this->Cut_plan_model->getincludeDelv($cutPlanId);

		// print_r($includeDelv);exit();

		if($includeDelv){
			$data = new stdClass;
			$i=0;
			foreach ($includeDelv as $row ) {
				$result = $this->Cut_plan_model->editCutPlan($cutPlanId,$row->po);

				if($result){
					$data->$i = $result;
					$i++;
				}
			}
			// print_r($data);exit();
			echo json_encode($data);
		}
	}

	public function getOrderQtyEachSize(){
		$result = $this->Cut_plan_model->getOrderQtyEachSize();
		if($result){
			echo json_encode($result);
		}else{
			echo 'noData';
		}

	}

}
