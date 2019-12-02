<?php
/**
 * Created by PhpStorm.
 * User: nirangal
 * Date: 01/21/2019
 * Time: 10:11 AM
 */

//error_reporting(-1);
//ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');
class User_con extends MY_Controller{

    public function __construct() {
        parent::__construct();
        $this->checkSession();
        $this->load->model('User_model');
    }

    public function userList(){
        $data['allUsers'] = $this->User_model->getAllUsers();
        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('admin/userList');
        $this->load->view('template/footer');
    }

    public function addUserView(){
        $data['userGroups'] = $this->User_model->getUserGroups();
        $data['location'] = $this->User_model->getLocations();
        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('admin/addUser');
        $this->load->view('template/footer');
    }

    public function editUserView($userId){
        $data['userGroups'] = $this->User_model->getUserGroups();
        $data['location'] = $this->User_model->getLocations();
        $data['user'] = $this->User_model->getUserToEdit($userId);
        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('admin/editUser');
        $this->load->view('template/footer');
    }

    public function getLocations(){
       $result =  $this->User_model->getLocations();
       echo json_encode($result);
    }

    public function saveUser(){

        if($this->userFormValidation('save')){
            $result =  $this->User_model->saveUser();
            if($result){
                redirect(base_url('User_con/userList'), 'refresh');
            }
        }else{
            $this->addUserView();
        }
    }

    public function editUser($userId){

        if($this->userFormValidation('edit')){
            $result =  $this->User_model->editUser($userId);
            if($result){
                redirect(base_url('User_con/userList'), 'refresh');
            }
        }else{
            $this->editUserView($userId);
        }
    }

    public function deleteUser($userId){
        if($userId != '4'){
            $result =  $this->User_model->deleteUser($userId);
            if($result){
                redirect(base_url('User_con/userList'), 'refresh');
            }
        }else{
            $this->editUserView($userId);
        }
    }

    public function userFormValidation($task){

        if($task=='save'){
            $this->form_validation->set_rules('epfNo', 'EPF No.', 'trim|required|is_unique[users.epfNo]',
                array('is_unique'=>'This EPF No. already registered'));
            $this->form_validation->set_rules('uName', 'Name', 'trim|required');
            $this->form_validation->set_rules('designation', 'Designation', 'trim|required');
            $this->form_validation->set_rules('userGroup', 'User Group', 'trim|required');
            $this->form_validation->set_rules('location', 'Location', 'trim|required');
            $this->form_validation->set_rules('userName', 'User Name', 'trim|required|is_unique[users.userName]',
                array('is_unique'=>'This User Name is already used!'));
            $this->form_validation->set_rules('userPassword', 'password', 'trim|required');
            $this->form_validation->set_rules('confPassword', 'Password Confirmation', 'trim|required|matches[userPassword]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        }

        if($task=='edit'){
            $this->form_validation->set_rules('uName', 'Name', 'trim|required');
            $this->form_validation->set_rules('designation', 'Designation', 'trim|required');
            $this->form_validation->set_rules('userGroup', 'User Group', 'trim|required');
            $this->form_validation->set_rules('location', 'Location', 'trim|required');
            $this->form_validation->set_rules('userPassword', 'password', 'trim|required');
            $this->form_validation->set_rules('confPassword', 'Password Confirmation', 'trim|required|matches[userPassword]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        }

        return $this->form_validation->run();
    }


}
