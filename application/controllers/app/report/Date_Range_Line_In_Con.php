<?php
// error_reporting(-1);
// ini_set('display_errors', 1);
class Date_Range_Line_In_Con extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->checkCookies();
        $this->team = get_cookie('line');
        $this->load->model('app/report/Date_range_line_in_model');
    }

    public function index(){
      $this->load->view('app/templateApp/header');
      // $this->load->view('app/templateApp/sidebar');
      $this->load->view('app/report/date_range_line_in');
      $this->load->view('app/templateApp/footer');
    }

    public function getDateRangeWiseLineInReport(){
      $result = $this->Date_range_line_in_model->getDateRangeWiseLineInReport($this->team);
      if($result){
        echo json_encode($result);
      }else{
        echo '';
      }
    }
}
