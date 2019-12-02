<?php
defined('BASEPATH') OR exit('No direct script access allowed');

error_reporting(-1);
ini_set('display_errors', 1);

class App_TeamRecorder_Con extends MY_Controller {

    private $location;
    private $team;

    function __construct(){
        parent::__construct();
        $this->checkCookies();
        $this->location = get_cookie('location');
        $this->team = get_cookie('line');
        $this->load->model('app/App_team_recorder_model');
    }

    public function index(){

        $data['operations'] = $this->App_team_recorder_model->getOperations();
        $data['dayType'] = $this->App_team_recorder_model->getAllDayType($this->location);

        $this->load->view('app/templateApp/header',$data);
        // $this->load->view('app/templateApp/sidebar');
        $this->load->view('app/teamRecoder/worker_checking');
        $this->load->view('app/templateApp/footer');
    }

    public function workerList(){

      $data['workerList'] = $this->App_team_recorder_model->getTodayWorkerList();
      $data['dayType'] = $this->App_team_recorder_model->getAllDayType($this->location);

      $this->load->view('app/templateApp/header',$data);
      // $this->load->view('app/templateApp/sidebar');
      $this->load->view('app/teamRecoder/assigned_worker_list');
      $this->load->view('app/templateApp/footer');
    }

    public function verifyEmp(){
        $empNo = $this->input->post('epfNo');
        $empValidate = $this->App_team_recorder_model->empValidate($empNo);

        if(empty($empValidate)){
            echo 'noEmp';
        }else{

           $empActive =  $empValidate[0]->active;
           if($empActive != 0){
               $result = $this->App_team_recorder_model->verifyEmp($empValidate[0]->epf_no);

               if(empty($result)){
                   $data = array(
                       'empTbId'=>$empValidate[0]->id,
                       'empId'=>$empValidate[0]->epf_no,
                       'empName'=>$empValidate[0]->emp_name,
                       'empDesig'=>$empValidate[0]->designation,
                       'status'=>'notAssign',
                   );
                 echo  json_encode($data);
               }else{
                   if($result[0]->workerIn == '1' && $result[0]->workerOut == '1'){
                       $data = array(
                           'id'=>$result[0]->id,
                           'empTbId'=>$result[0]->empTbId,
                           'empId'=>$result[0]->emp_no,
                           'empName'=>$result[0]->emp_name,
                           'empDesig'=>$result[0]->designation,
                           'team'=>$result[0]->line,
                           'operation'=>$result[0]->operation,
                           'operation_id'=>$result[0]->operation_id,
                           'inTime'=>$result[0]->workerInTime,
                           'locationShift'=>$result[0]->locationShift,
                           'status'=>'workerOut',
                       );
                   }else if($result[0]->teamId == get_cookie('line') && $result[0]->workerIn == '1' && $result[0]->workerOut == '0'){
                           $data = array(
                               'id'=>$result[0]->id,
                               'empTbId'=>$result[0]->empTbId,
                               'empId'=>$result[0]->emp_no,
                               'empName'=>$result[0]->emp_name,
                               'empDesig'=>$result[0]->designation,
                               'team'=>$result[0]->line,
                               'operation'=>$result[0]->operation,
                               'operation_id'=>$result[0]->operation_id,
                               'outTime'=>$result[0]->workerOutTime,
                               'locationShift'=>$result[0]->locationShift,
                               'status'=>'workingCurrentTeam',
                           );


                   }else if($result[0]->workerIn == '1'){
                       $data = array(
                           'id'=>$result[0]->id,
                           'empTbId'=>$result[0]->empTbId,
                           'empId'=>$result[0]->emp_no,
                           'empName'=>$result[0]->emp_name,
                           'empDesig'=>$result[0]->designation,
                           'team'=>$result[0]->line,
                           'operation'=>$result[0]->operation,
                           'operation_id'=>$result[0]->operation_id,
                           'inTime'=>$result[0]->workerInTime,
                           'locationShift'=>$result[0]->locationShift,
                           'status'=>'working',
                       );
                   }
                  echo json_encode($data);
               }

           }else{
               echo 'inactiveEmp';
           }
        }

    }

    public function assignEmpToTeam(){
        $workerInOut = $this->input->post('inOut');

        if($workerInOut == 'in'){
            $result = $this->App_team_recorder_model->workerIn();
            if($result){
                echo 'success';
            }else{
                echo 'unsuccess';
            }
        }else if($workerInOut == 'out'){
            $result = $this->App_team_recorder_model->workerOut();
            if($result){
                echo 'success';
            }else{
                echo 'failure';
            }
        }
    }

    public function opeChange(){
        $result = $this->App_team_recorder_model->opeChange();

        if($result){
            echo 'success';
        }else{
            echo 'failure';
        }

    }

    public function getPreWorker(){
      $data['worker'] = $this->App_team_recorder_model->getPreWorker();
      $data['operation'] = $this->App_team_recorder_model->getOperations();

      if($data){
          echo json_encode($data);
      }else{
          echo 'Something wrong';
      }

    }

    public function setPrevWorkers(){
      $date = date('Y-m-d');
      $i = 0;
      $toView['unSavedWorkser'] = array();

      $jsonData = json_decode($this->input->post('jsonData'),true);
      $dayType = $this->input->post('dayType');

      // print_r($jsonData);

      foreach (array_keys($jsonData) as $epfNo) {
         $operationId = $jsonData[$epfNo];
         // echo $epfNo;
        $empValidate = $this->App_team_recorder_model->empValidate($epfNo);
        // print_r($empValidate);
        if($empValidate){
          $result = $this->App_team_recorder_model->verifyEmp($epfNo);
          if(empty($result)){

            $headCount = $this->App_team_recorder_model->getInHeadCount($epfNo,date('Y-m-d H:i:s'),$dayType);

            $data = array(
              'empTbId'=>$empValidate[0]->id,
              'emp_no'=>$empValidate[0]->epf_no,
              'operation_id'=>$jsonData[$epfNo],
              'locationId'=>$this->location,
              'teamId'=>$this->team,
              'locationShift'=>$dayType,
              'workerIn'=>1,
              'workerInTime'=>date('Y-m-d H:i:s'),
              'workerOut'=>0,
              'headCount'=>$headCount,
              'createDateTime'=>date('Y-m-d H:i:s'),
            );

             $isSaved  =  $this->App_team_recorder_model->savePreLoadWorkers($data);
          }else{
            $toView['unSavedWorkser'][$i] = array(
              'epfN0'=>$empValidate[0]->epf_no,
              'name'=>$result[0]->emp_name
            );
            $i++;
          }
        }

      }

      if(empty($toView['unSavedWorkser'])){
        echo "";
      }else{
        echo json_encode($toView);
      }


    }

}
