<?php
error_reporting(-1);
ini_set('display_errors', 1);
class App_Report_Con extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->checkCookies();
        $this->team = get_cookie('line');
    }

    public function index(){
      $this->load->view('app/templateApp/header');
      // $this->load->view('app/templateApp/sidebar');
      $this->load->view('app/report/report_list_view');
      $this->load->view('app/templateApp/footer');
    }

  }
