<?php
error_reporting(-1);
ini_set('display_errors', 1);

class Checker_Con extends MY_Controller {

    public  $location;
    public $team;

    public function __construct() {
        parent::__construct();
        $this->team = get_cookie('line');
        $this->location = get_cookie('location');
        $this->load->model('app/lineend/Qc_checker_model');
    }

    public function index(){
        if ($this->location == '' || $this->team == '') {
            redirect(base_url("Profile_App_Con/index?from=team_end_checker"), 'refresh');
        } else {
            $data['team'] = $this->Qc_checker_model->getTeamName($this->team);
            $data['defectReason'] = $this->Qc_checker_model->getDefectReason($this->location);
            $this->load->view('app/lineend/checker_view',$data);
        }
    }

    public function getStyle(){
        $inputValidate = $this->checkRule('teamInputVsOutput');
        $style = $this->Qc_checker_model->getStyle($this->team,$inputValidate);
      if($style){
          echo json_encode($style);
      }
    }

    public function getDelivery(){
     $inputValidate = $this->checkRule('teamInputVsOutput');
      $delivery = $this->Qc_checker_model->getDelivery($this->team,$inputValidate);
      if($delivery){
          echo json_encode($delivery);
      }
    }

    public function getColor(){
      $inputValidate = $this->checkRule('teamInputVsOutput');
      $color = $this->Qc_checker_model->getColor($this->team,$inputValidate);
      if($color){
          echo json_encode($color);
      }
    }

    public function getSize(){
        $size = $this->Qc_checker_model->getSize();
        if($size){
            echo json_encode($size);
        }
    }

      /// Insert Pass count and data ///////
      public  function insertData(){
        $data = $this->input->get('data');
        $inputValidate = $this->checkRule('teamInputVsOutput');

        // exit($inputValidate);
        ////// check the input qty to checkout qty /////
        if($inputValidate == '1' && ($data[0]['btn'] == 'pass' || $data[0]['btn'] == 'defect' || $data[0]['btn'] == 'remake')){
           
            if($this->validateInput($data)){
                $this->switchingToRunning($data);
                $result =  $this->Qc_checker_model->insertData($data,$this->location);
                if($result){
                    echo $data[0]['btn'];
                }else{
                    echo 'error';
                }
            }else{
                echo 'needInput';
            }
        }else{
            $this->switchingToRunning($data);
            $result =  $this->Qc_checker_model->insertData($data,$this->location);
            if($result){
                echo $data[0]['btn'];
            }else{
                echo 'error';
            }
        }
        
        
        // else{
        //     $this->switchingToRunning($data);
        //     $result =  $this->Qc_checker_model->insertData($data,$this->location);
        //     if($result){
        //         echo $data[0]['btn'];
        //     }
        // }


        
    }

    public function getCount(){
        $result =  $this->Qc_checker_model->getCount($this->myTeam);

        if($result){
            echo json_encode($result);
        }else{
            echo '';
        }
    }

    public function getTeam(){
        $result = $this->Qc_checker_model->getTeam();
        if($result){
            echo $result[0]->line;
        }else{
            echo 'Team is Not Configed';
        }
    }

    /////// Change the running and hold status in day plan //////
    public function switchingToRunning($data){
    
        $otherDayPlan = $this->Qc_checker_model->checkOtherPlan($data[0]['style'],$data[0]['delivery'],$this->team);
        if(!empty($otherDayPlan)){
            $this->Qc_checker_model->switchStyleStatus($otherDayPlan[0]->id,$this->team);
               
            }

    }

    ////// Get Coumt for each tile in checker app //////
    public function getCountFormLog(){
        $result =  $this->Qc_checker_model->getCountFormLog();
        if($result){
            echo json_encode($result);
        }else{
            echo '';
        }
      }

      public function validateInput($data){
        $result =  $this->Qc_checker_model->getInputVsOutBalance($data);
        if($result){
            if($result[0]->balance > 0){
                return true;
            }
        }
        return false;
      }

      public function getInQty(){
        $result =  $this->Qc_checker_model->getInputVsOutBalance();
        if($result){
            echo json_encode($result);
        }
      }

     public function getFrequentDefectReason(){
        $result =  $this->Qc_checker_model->getFrequentDefectReason();
        if($result){
            echo json_encode($result);
        }else{
            echo 'no result';
        }
     }
}
