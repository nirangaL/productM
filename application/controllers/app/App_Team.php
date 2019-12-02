<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//error_reporting(-1);
//ini_set('display_errors', 1);

class App_Team extends MY_Controller{

    private $location;
    private $team;

    function __construct()
    {
        parent::__construct();
        $this->checkCookies();
        $this->location = get_cookie('location');
        $this->team = get_cookie('line');
       $this->load->model('app/App_team_mng_model');
    }

    public function index(){

      $data['inQty'] = $this->App_team_mng_model->getInputQty($this->team);
      $data['issueQty'] = $this->App_team_mng_model->getIssueQty($this->team);
      $data['workers'] = $this->App_team_mng_model->getWorkerCount($this->team);

        $this->load->view('app/templateApp/header',$data);
        // $this->load->view('app/templateApp/sidebar');
        $this->load->view('app/teamDashborad');
        $this->load->view('app/templateApp/footer');
    }
}
