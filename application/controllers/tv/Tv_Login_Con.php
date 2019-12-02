<?php
//
error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Tv_Login_Con extends MY_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('cookie');
        $this->location = get_cookie('location');
        $this->load->model('tv/Tv_login_model');
    }

    public function checkUser(){

        if($this->FormValidation()){
            $result =  $this->Tv_login_model->checkUser();
            if($result == 'block'){
                echo 'block';exit();
            }else if($result == 'notOk'){
                echo 'notOk';exit();
            }else if(!empty($result)){

                $cookie= array(
                    'name'   => 'location',
                    'value'  => (string)$result[0]->location,
                    'expire' => (86400 * 365),
                    'path'   => "/",
                );
                $this->input->set_cookie($cookie);

                echo 'ok';exit();
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

}