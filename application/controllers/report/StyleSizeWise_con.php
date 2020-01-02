<?php
//
// error_reporting(-1);
// ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class StyleSizeWise_con extends MY_Controller{

    function __construct(){
        parent::__construct();
        $this->checkSession();
        $this->load->model('report/Style_size_wise_model');
        $this->load->model('Style_model');
    }

    public function index($style='',$result=''){    
        
        $data['style'] = $this->Style_model->getProcessedStyle();
        $data['tableData'] = $result;
        $data['selectStyle'] = $style;

        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('report/style/styleSizeWiseReport');
        $this->load->view('template/footer');
    }

    public function getTableData(){
        $style = $this->input->post('style');

        if($style !=''){
            $result =  $this->Style_size_wise_model->getTableData($style);

            if($result){
                $this->index($style,$result);
            }else{
                $this->index($style,$result='');
            }
        }
    }
}