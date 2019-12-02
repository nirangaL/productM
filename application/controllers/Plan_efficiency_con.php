<?php
/**
 * Created by PhpStorm.
 * User: nirangal
 * Date: 01/23/2019
 * Time: 8:32 AM
 */

error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');
class Plan_efficiency_con extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->checkSession();
        $this->load->model('Plan_efficiency_model');


    }

    public function index(){
        $data['allPlanEff'] = $this->Plan_efficiency_model->getAllEfficiency();
        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('workstudy/planEfficiency');
        $this->load->view('template/footer');
    }

    public function addNew(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('workstudy/addPlanEfficiency');
        $this->load->view('template/footer');
    }

    public function savePlanEfficiency(){

        if($this->formValidation('save')) {
            $result = $this->Plan_efficiency_model->savePlanEfficiency();
            if ($result) {
                redirect(base_url('Plan_efficiency_con'), 'refresh');
            } else {
                $this->addNew();
            }
        }else{
            $this->addNew();
        }
    }

    public function getPlanEffToEdit($id){

        $data['PlanEff'] = $this->Plan_efficiency_model->getPlanEffToEdit($id);

        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('workstudy/editPlanEfficiency');
        $this->load->view('template/footer');
    }

    public function editPlanEfficiency($id){

        if($this->formValidation('edit')) {
            $result = $this->Plan_efficiency_model->editPlanEfficiency($id);
            if ($result) {
                redirect(base_url('Plan_efficiency_con'), 'refresh');
            } else {
                $this->getPlanEffToEdit($id);
            }
        }else{
            $this->getPlanEffToEdit($id);
        }
    }

    public function formValidation($task){

        if($task=='save'){
            $this->form_validation->set_rules('day', 'Day', 'trim|required|is_unique[mst_plan_eff.day]',
                array('is_unique'=>'This Day already have a Efficiency'));
            $this->form_validation->set_rules('efficiency', 'Efficiency', 'trim|required');
        }

        if($task=='edit'){
            $this->form_validation->set_rules('day', 'Day', 'trim|required');
            $this->form_validation->set_rules('efficiency', 'Efficiency', 'trim|required');
        }

        return $this->form_validation->run();
    }

}