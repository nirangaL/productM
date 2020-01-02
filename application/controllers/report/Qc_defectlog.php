<?php

error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Qc_defectlog extends MY_Controller{

    function __construct(){
        parent::__construct();
        $this->checkSession();
        $this->load->model('report/Qc_defectlog_model');
    }

    public function  index($tableData ='',$team='',$selectedFromDate='',$selectedFromTime='',$selectedToDate='',$selecedToTime=''){

        $data['team'] = $this->Qc_defectlog_model->getTeam($this->myConlocation);

        $data['selectedTeam'] = $team;
        $data['selectedFromDate'] = $selectedFromDate;
        $data['selectedFromTime'] = $selectedFromTime;
        $data['selectedToDate'] = $selectedToDate;
        $data['selectedToTime'] = $selecedToTime;
        $data['tableData'] = $tableData;

        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('report/qc_defectlog_view');
        $this->load->view('template/footer');
    }

   
    public function getTableData(){
        $team = $this->input->post('team');
        $fromDate = $this->input->post('fromDate');
        $fromTime = $this->input->post('fromTime');
        $toDate = $this->input->post('toDate');
        $toTime = $this->input->post('toTime');
    
         if($team !='' && $fromDate !=''  && $fromTime !=''  && $toDate !='' && $toTime !=''){
            $result =  $this->Qc_defectlog_model->getTableData($team,$fromDate,$fromTime,$toDate,$toTime);
    
            if(!empty($result)){
                $this->index($result,$team,$fromDate,$fromTime,$toDate,$toTime);
            }else{
                $this->index($tableData ='',$team,$fromDate,$fromTime,$toDate,$toTime);
            }
        }
    }

}
