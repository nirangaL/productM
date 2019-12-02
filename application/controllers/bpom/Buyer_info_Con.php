<?php
error_reporting(-1);
ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');
class Buyer_info_Con extends MY_Controller{

    public function __construct() {
        parent::__construct();
        $this->checkSession();
         $this->load->model('bpom/Buyer_info_model');
    }

    public function index(){

    
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('bpom/buyer_Info_view');
        $this->load->view('template/footer');
    }



    public function insert_data(){
        $result = $this->Buyer_info_model->buyerSaveAll();

        if($result){
            echo "added";
        } else{
            echo "Buyer Not Save";
        }

    }

    public function deleteBuyer(){
        $result = $this->Buyer_info_model->deleteBuyer();

        if($result){
            echo "deleted";
        }else{
            echo "not deleted";
        }
    }

    public function getTableData(){

        $result= $this->Buyer_info_model->getAllBuyers();

        if($result){
         echo json_encode($result);

        }
    }


    public function updateBuyer(){
          $result = $this->Buyer_info_model->updateBuyer();

        if($result){
            echo "updated";
        }else{
            echo "not updated";
        }
    }
}
?>