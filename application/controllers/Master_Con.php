<?php
//
error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_Con extends MY_Controller{

    function __construct(){
        parent::__construct();
        $this->checkSession();
    }

  public function index(){
      $this->load->view('template/header');
      $this->load->view('template/sidebar');
      $this->load->view('master/master');
      $this->load->view('template/footer');
  }
}