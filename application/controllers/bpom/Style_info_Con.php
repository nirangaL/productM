<?php
error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Style_info_Con extends MY_Controller{

	public function __construct() {
		parent::__construct();
		$this->checkSession();
		$this->load->model('bpom/Style_info_model');
	}

	public function index(){

		$data['buyer'] = $this->Style_info_model->getBuyers();
		// $data['style'] = $this->Style_info_model->getStyle();

		$this->load->view('template/header',$data);
		$this->load->view('template/sidebar');
		$this->load->view('bpom/style_info_view');
		$this->load->view('template/footer');
	}

	public function getSeason_con(){
		$result = $this->Style_info_model->getSeasonModel();

		if($result){
			echo json_encode($result);
		}else{
			echo 'noSeason';
		}

	}

	public function getStyle(){
		$result = $this->Style_info_model->getStyle();

		if($result){
			echo json_encode($result);
		}else{
			echo 'noStyle';
		}

	}

	public function getSC_and_Delivery_con(){

		$result = $this->Style_info_model->getSC_and_Delivery();

		if($result){
			echo json_encode($result);
		}else{
			echo 'noData';
		}

	}

	public function getDelvDateAndColor(){

		$result = $this->Style_info_model->getDelvDateAndColor();

		if($result){
			echo json_encode($result);
		}else{
			echo 'noData';
		}

	}

	public function getSizeAndOrderQty(){
		$result = $this->Style_info_model->getSizeAndOrderQty();

		if($result){
			echo json_encode($result);

		}else{
			echo 'noData';
		}
	}

	public function getQtyAndAccellerId(){
		$result = $this->Style_info_model->getQtyAndAccellerId();

		if($result){
			echo json_encode($result);

		}else{
			echo 'noData';
		}
	}


	public function insertData(){
		$result = $this->Style_info_model->insertStyleData();

		if($result){
			echo "added";
		} else{
			echo "Buyer Not Save";
		}
	}

	public function getTableData(){
		$result = $this->Style_info_model->getTableData();

		if($result){
			echo json_encode($result);
		}else{
			echo '';
		}
	}

	public function deleteRow(){
		$result = $this->Style_info_model->deleteRow();

		if($result){
			echo "deleted";
		}else{
			echo 'not Deleted';
		}
	}

}

?>
