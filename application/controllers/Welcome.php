<?php
//error_reporting(-1);
//ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('login_model');
    }

	public function index()
	{
        if ($this->session->userdata('session_user_data'))
        {
//            $this->load->view('Location_Dashboard_Con');
            redirect(base_url('Location_Dashboard_Con'), 'refresh');
        }else{
            $this->load->view('login');
        }
	}

	public function dashboard(){

    }

	public function checkUser(){

        if($this->FormValidation()){
           $result =  $this->login_model->checkUser();
            if($result == 'ok'){
                echo 'ok';
            }else if($result == 'block'){
                echo 'block';
            }else if($result == 'notOk'){
                echo 'notOk';
            }
        }else{
            echo 'notOk';
        }
    }

    public function FormValidation(){
        $this->form_validation->set_rules('userName', 'User Name', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        return $this->form_validation->run();
    }

    public function logOut(){
        $sess_array = $this->session->userdata('session_user_data');

        $username	=	$_SESSION['session_user_data']['userName'];

        $this->login_model->remove_login_time($username);

        if (isset($sess_array)){
            $this->session->unset_userdata('session_user_data');
        }
        $this->index();
    }
}
