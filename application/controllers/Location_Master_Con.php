<?php
//
error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Location_Master_Con extends MY_Controller{

    function __construct(){
        parent::__construct();
        $this->checkSession();
        $this->load->model('Location_master_model');
    }

    public function index(){
        $data['locations'] = $this->Location_master_model->getLocation($this->myConlocation);

        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('master/location/locations_list');
        $this->load->view('template/footer');
    }

    public function selectUpdate($location_id){
        $data['country'] = $this->Location_master_model->getCountry();
        $data['location'] = $this->Location_master_model->getLocationToUpdate($location_id);

        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('master/location/location_edit');
        $this->load->view('template/footer');
    }

    public function getPhoneCode(){
        $result = $this->Location_master_model->getPhoneCode();

        if(!empty($result)){
            echo $result[0]->phoneCode;
        }else{
            echo '--';
        }
    }

    public function addLocation(){
        $data['country'] = $this->Location_master_model->getCountry();
        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('master/location/location_add');
        $this->load->view('template/footer');
    }

    public function saveLocation(){
        $result = $this->Location_master_model->insertLocation();

        if($result){
            redirect(base_url('Location_Master_Con'), 'refresh');
        }else{
            redirect(base_url("Location_Master_Con/addLocation"), 'refresh');
        }
    }

    public function updateLocation($location_id){

        $result = $this->Location_master_model->updateLocation($location_id);

        if($result){
            redirect(base_url('Location_Master_Con'), 'refresh');
        }else{
            redirect(base_url("Location_Master_Con/selectUpdate/$location_id"), 'refresh');
        }

    }

}