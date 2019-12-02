<?php

error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_App_Con extends MY_Controller{

    function __construct(){
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->model('Profile_app_model');
    }


    public function index(){
        $data['company'] = $this->Profile_app_model->getCompany();
        if($this->input->get('from')!=''){
            $wantToGo =  $this->input->get('from');
            $data['wantToGo'] = $wantToGo;
            if($wantToGo == 'prod_tv'){
                $this->load->view('tv/setProfileTv',$data);/////// This go to production team Tv ///////
            }
            if($wantToGo == 'team_end_checker'){
                $this->load->view('tv/setProfileTv',$data);/////// This go to Team end QC checker app ///////
            }
        }else{
            $this->load->view('app/setProfile',$data);
        }
        
    }

    public function getLocations(){
       $result = $this->Profile_app_model->getLocations();
       echo json_encode($result);
    }

    public function getTeams(){
        $result = $this->Profile_app_model->getTeams();
        echo json_encode($result);
    }

    public function setCookies($wantToGo=''){
        $company  = $this->input->post('company');
        $location  = $this->input->post('location');
        $team  = $this->input->post('team');
        $section  = $this->input->post('section');

        setcookie('company', (string)$company, time() + (86400 * 365), "/"); // 86400 = 1 day
        setcookie('location', (string)$location, time() + (86400 * 365), "/"); // 86400 = 1 day
        setcookie('line', (string)$team, time() + (86400 * 365), "/"); // 86400 = 1 day
        setcookie('lineSection', (string)$section, time() + (86400 * 365), "/"); // 86400 = 1 day

        if($wantToGo=='prod_tv'){
            redirect( base_url("tv/Tv_Production_Con"), 'refresh');
        }if($wantToGo =='team_end_checker'){
            redirect( base_url("app/lineend/Checker_Con"), 'refresh');
        }else{
            redirect( base_url("app/App_Team"), 'refresh');
        }
       

    }

}
