<?php
//
error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Qc_Summery_Style_Wise extends MY_Controller{

    function __construct(){
        parent::__construct();
        $this->checkSession();
        $this->load->model('report/Qc_summery_style_wise');
        // $this->load->model('Style_model');
    }
}
