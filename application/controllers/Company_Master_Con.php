<?php
//
error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Company_Master_Con extends MY_Controller{

    function __construct(){
        parent::__construct();
        $this->checkSession();
        $this->load->model('Company_master_model');
    }

    public function index(){

        $data['company'] = $this->Company_master_model->getCompany();

        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('master/company/company_view');
        $this->load->view('template/footer');
    }

    public function selectUpdate($comp_id){
        $data['company'] = $this->Company_master_model->getCompany($comp_id);
        $data['country'] = $this->Company_master_model->getCountry();

        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('master/company/company_edit');
        $this->load->view('template/footer');
    }

    public function getPhoneCode(){
        $result = $this->Company_master_model->getPhoneCode();

        if(!empty($result)){
            echo $result[0]->phoneCode;
        }else{
            echo '--';
        }
    }

    public function updateCompany($comp_id){

        $result = $this->Company_master_model->updateCompany($comp_id);

        if($result){
            redirect(base_url('Company_Master_Con'), 'refresh');
        }else{
            redirect(base_url("Company_Master_Con/selectUpdate/$comp_id"), 'refresh');
        }

    }

}