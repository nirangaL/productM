<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Comdashboard extends MY_Controller{

    function __construct(){
        parent::__construct();
        $this->checkSession();
       
    }

    public function index(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('main_dashboard');
        $this->load->view('template/footer');
    }
}
