<?php
// error_reporting(-1);
// ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');
class Download extends CI_Controller{

    function __construct(){
        parent::__construct();
    }

    public function index(){

        // $this->load->view('template/header');
        // $this->load->view('template/sidebar');
        $this->load->view('download_view');
        // $this->load->view('template/footer');
    }

    

}
