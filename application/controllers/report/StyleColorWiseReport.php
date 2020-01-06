<?php
//
error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class StyleColorWiseReport extends MY_Controller{

    function __construct(){
        parent::__construct();
        $this->checkSession();
        $this->load->model('report/Style_color_wise_report_model');
        $this->load->model('Style_model');
    }

    public function index($style='',$getCutDataFromGamaSys='',$getProductMData=''){    
        
        $data['style'] = $this->Style_model->getProcessedStyle();
        $data['CutDataFromGama'] = $getCutDataFromGamaSys;
        $data['ProductMData'] = $getProductMData;
        $data['selectStyle'] = $style;

        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('report/style_color_wise_report_view');
        $this->load->view('template/footer');
    }

    public function getTableData(){
        $style = $this->input->post('style');

        if($style !=''){
            $getCutDataFromGamaSys =  $this->Style_color_wise_report_model->getCutDataFromGamaSys($style);
            $getProductMData =  $this->Style_color_wise_report_model->getProductMData($style);

            if($getCutDataFromGamaSys && $getProductMData){
                $this->index($style,$getCutDataFromGamaSys,$getProductMData);
            }else{
                $this->index($style,$getCutDataFromGamaSys='',$getProductMData='');
            }
        }
    }
}