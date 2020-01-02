<?php

error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class DateWisePassQtyReport extends MY_Controller{

    function __construct(){
        parent::__construct();
        $this->checkSession();
        $this->load->model('report/Date_wise_pass_qty_model');
    }

    public function  index($tableData ='',$team='',$selectedDate=''){

        $data['team'] = $this->Date_wise_pass_qty_model->getTeam($this->myConlocation);

        $data['selectedTeam'] = $team;
        $data['selectedDate'] = $selectedDate;
        $data['tableData'] = $tableData;

        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('report/date_wise_pass_qty_report_view');
        $this->load->view('template/footer');
    }

   
    public function getTableData(){
        $team = $this->input->post('team');
        $date = $this->input->post('date');
    
         if($team !='' && $date !='' ){
            $result =  $this->Date_wise_pass_qty_model->getTableData($team,$date);
    
            if(!empty($result)){
                $this->index($result,$team,$date);
            }else{
                $this->index($tableData ='',$team,$date);
            }
        }
    }

}
