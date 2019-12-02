<?php
// error_reporting(-1);
// ini_set('display_errors', 1);
class Daywise_Line_Issue_Con extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->checkCookies();
        $this->team = get_cookie('line');
        $this->load->model('app/report/Daywise_line_issue_model');
    }

    public function index(){
      $this->load->view('app/templateApp/header');
      // $this->load->view('app/templateApp/sidebar');
      $this->load->view('app/report/daywise_line_issue_view');
      $this->load->view('app/templateApp/footer');
    }

    public function getDayWiseLineIssueReport(){
      $result = $this->Daywise_line_issue_model->getDayWiseLineIssueReport($this->team);
      if($result){
        echo json_encode($result);
      }else{
        echo '';
      }
    }
}
