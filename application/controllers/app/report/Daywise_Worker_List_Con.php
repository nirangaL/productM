<?php
// error_reporting(-1);
// ini_set('display_errors', 1);
class Daywise_Worker_List_Con extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->checkCookies();
        $this->team = get_cookie('line');
        $this->load->model('app/report/Daywise_worker_list_model');
    }

    public function index(){
      $this->load->view('app/templateApp/header');
      // $this->load->view('app/templateApp/sidebar');
      $this->load->view('app/report/daywise_worker_list');
      $this->load->view('app/templateApp/footer');
    }

    public function getDayWiseWorkerList(){
      $result = $this->Daywise_worker_list_model->getDayWiseWorkerList($this->team);
      if($result){
        echo json_encode($result);
      }else{
        echo '';
      }
    }
}
