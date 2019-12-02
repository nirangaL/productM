<?php
/**
 * Created by PhpStorm.
 * User: nirangal
 * Date: 01/23/2019
 * Time: 8:32 AM
 */

//error_reporting(-1);
//ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');
class Team_time_con extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->checkSession();
        $this->load->model('ProducLine_model');
        $this->load->model('Workstudy_model');
        $this->load->model('Team_time_model');
    }

    public function index(){
        $data['teamTime'] = $this->Team_time_model->getTeamTime();
        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('workstudy/teamTimeList');
        $this->load->view('template/footer');
    }


    public function addTimesToTeam(){
        $data['prdocLine'] = $this->ProducLine_model->getProdcLine();
        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('workstudy/addTeamTime');
        $this->load->view('template/footer');
    }

    public function setTeamTime(){
            $result = $this->Team_time_model->saveTeamTime();
            if($result){
                redirect(base_url('Team_time_con/addTimesToTeam'), 'refresh');
            }else{
                $this->addTimesToTeam();
            }
    }

    public function getTeamTimeTOEdit($teamTimeId){
        $data['prdocLine'] = $this->ProducLine_model->getProdcLine();
        $data['teamTime'] =  json_decode(json_encode( $this->Team_time_model->getTeamTimeTOEdit($teamTimeId)), true);

        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('workstudy/editTeamTime');
        $this->load->view('template/footer');
    }

    public function editTeamTime($teamTimeId){
        $result = $this->Team_time_model->saveTeamTime();
        if($result){
            redirect(base_url('Team_time_con'), 'refresh');
        }else{
            $this->getTeamTimeTOEdit($teamTimeId);
        }
    }
}