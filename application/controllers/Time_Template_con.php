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
class Time_Template_con extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->checkSession();
        $this->load->model('ProducLine_model');
        $this->load->model('Workstudy_model');
        $this->load->model('Time_template_model');
    }

    public function index(){
        $data['teamTime'] = $this->Time_template_model->getTimeTemplate();
        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('workstudy/timeTemplate');
        $this->load->view('template/footer');
    }

    public function addTimesToTemplate(){
//        $data['prdocLine'] = $this->ProducLine_model->getProdcLine();
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('workstudy/addTimeTemplate');
        $this->load->view('template/footer');
    }

    public function setTimeTemplate(){
        if($this->userFormValidation('save')) {
            $result = $this->Time_template_model->saveTimeTemplate();
            if ($result) {
                redirect(base_url('Time_Template_con'), 'refresh');
            } else {
                $this->addTimesToTemplate();
            }
        }else{
            $this->addTimesToTemplate();
        }
    }

    public function getTimeTempEdit($timeTempId){

        $data['timeTemp'] =  json_decode(json_encode( $this->Time_template_model->getTimeTempEdit($timeTempId)), true);
        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('workstudy/editTimeTemplate');
        $this->load->view('template/footer');
    }


    public function editTimeTemp($timeTempId){
        $result = $this->Time_template_model->editTimeTemp($timeTempId);
        if($result){
            redirect(base_url('Time_Template_con'), 'refresh');
        }else{
            $this->getTimeTempEdit($timeTempId);
        }
    }

    public function checkTemplateCode(){

        $result = $this->Time_template_model->checkTemplateCode();
        if($result){
            echo 'duplicate' ;
        }else{
            echo 'NotDuplicate' ;
        }
    }

    public function checkTemplateName(){

        $result = $this->Time_template_model->checkTemplateName();
        if($result){
            echo 'duplicate' ;
        }else{
            echo 'NotDuplicate' ;
        }
    }

    public function userFormValidation($task){

        if($task=='save'){
            $this->form_validation->set_rules('tcode', 'Template Code', 'trim|required|is_unique[time_template.templateCode]',
                array('is_unique'=>'Duplicate Template Code!'));
            $this->form_validation->set_rules('tName', 'Template Name', 'trim|required|is_unique[time_template.templateName]',
                array('is_unique'=>'Duplicate Template Name!'));
        }

        if($task=='edit'){
            $this->form_validation->set_rules('tcode', 'Template Code', 'trim|required');
            $this->form_validation->set_rules('tName', 'Template Name', 'trim|required');

        }

        return $this->form_validation->run();


    }
}