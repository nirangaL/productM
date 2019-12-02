<?php

class App_team_recorder_model extends CI_model{

    public function getOperations(){
        $sql = "SELECT id,operation FROM `dep_style_operation_smv` WHERE active = '1' AND departmentId ='1'";
        return $this->db->query($sql)->result();
    }

    public function getAllDayType($locationId){

        $date = date('Y-mm-dd');

        $weekendDay = false;

//Get the day that this particular date falls on.
        $day = date("D", strtotime($date));

//Check to see if it is equal to Sat or Sun.
        if($day == 'Sat' || $day == 'Sun'){
            //Set our $weekendDay variable to TRUE.
            $weekendDay = true;
        }

//Output for testing purposes.
        if($weekendDay){
            $sql = "SELECT * FROM `location_shift` WHERE `location_id` = '$locationId' AND dayType != 'weekday'" ;
        } else{
            $sql = "SELECT * FROM `location_shift` WHERE `location_id` = '$locationId' AND dayType != 'weekend'" ;
        }

       return $this->db->query($sql)->result();
    }

    public function empValidate($empNo){
       $locationId = get_cookie('location');
        $sql = "SELECT * FROM emp_details WHERE epf_no = '$empNo'AND locationId = '$locationId'";
        return $this->db->query($sql)->result();
    }

    public function verifyEmp($epfNo){
        $locationId = get_cookie('location');
        $toDay = date('Y-m-d');
        $sql = "SELECT
                    `worker_in_team`.`id`
                    , `worker_in_team`.`emp_no`
                    , `worker_in_team`.`empTbId`
                    , `emp_details`.`emp_name`
                    , `emp_details`.`designation`
                    , `worker_in_team`.`teamId`
                    , `prod_line`.`line`
                    , `worker_in_team`.`operation_id`
                    , `dep_style_operation_smv`.`operation`
                    , `worker_in_team`.`workerIn`
                    , `worker_in_team`.`workerInTime`
                    , `worker_in_team`.`workerOut`
                    , `worker_in_team`.`workerOutTime`
                    , `worker_in_team`.`createDateTime`
                    , `worker_in_team`.`locationShift`
                FROM
                    `intranet_db`.`worker_in_team`
                    INNER JOIN `intranet_db`.`emp_details`
                        ON (`worker_in_team`.`empTbId` = `emp_details`.`id`)
                    INNER JOIN `intranet_db`.`prod_line`
                        ON (`worker_in_team`.`teamId` = `prod_line`.`line_id`)
                    INNER JOIN `intranet_db`.`dep_style_operation_smv`
                            ON (`worker_in_team`.`operation_id` = `dep_style_operation_smv`.`id`) WHERE  `worker_in_team`.`emp_no`='$epfNo' AND `worker_in_team`.`locationId`='$locationId' AND DATE(`worker_in_team`.`createDateTime`) = '$toDay' ORDER BY `worker_in_team`.`id` DESC";

        return $this->db->query($sql)->result();
    }

    public function workerIn(){
        $empTbId = $this->input->post('empTbId');
        $epfNu = $this->input->post('epfNu');
        $ope = $this->input->post('operation');
        $locationId = get_cookie('location');
        $teamId = get_cookie('line');
        $workerTbId =  $this->input->post('workerTbId');
        $dayType =  $this->input->post('dayType');
        $date = date('Y-m-d H:i:s');


        $headCount = $this->getInHeadCount($epfNu,$date,$dayType);

        if($workerTbId !=''){

           $result  =  $this->checkIsSameTeam($workerTbId,$teamId,$empTbId);
           if($result){
               $data = array(
                   'workerOut'=>'0',
                   'workerInTime'=>$date,
                   'operation_id' => $ope,
                   'headCount' => $headCount,
               );

               $this->db->trans_start();
               $this->db->set($data);
               $this->db->where('id',$workerTbId);
               $this->db->update('worker_in_team');
               return $this->db->trans_complete();

           }else{
               $data = array(
                   'empTbId' => $empTbId,
                   'emp_no' => $epfNu,
                   'locationId' => $locationId,
                   'operation_id' => $ope,
                   'teamId' => $teamId,
                   'locationShift' => $dayType,
                   'workerIn' => '1',
                   'workerInTime' => $date,
                   'headCount' => $headCount,
                   'createDateTime' => $date
               );
           }
        }else{
            $data = array(
                'empTbId' => $empTbId,
                'emp_no' => $epfNu,
                'locationId' => $locationId,
                'operation_id' => $ope,
                'teamId' => $teamId,
                'locationShift' => $dayType,
                'workerIn' => '1',
                'workerInTime' => $date,
                'headCount' => $headCount,
                'createDateTime' => $date
            );
        }

        $this->db->trans_start();
        $this->db->insert('worker_in_team',$data);
       return $this->db->trans_complete();

    }

    public function workerOut(){
        $empTbId = $this->input->post('empTbId');
        $epfNu = $this->input->post('epfNu');
        $workerTbId = $this->input->post('workerTbId');
        $ope = $this->input->post('operation');
        $dayType = $this->input->post('dayType');
        $locationId = get_cookie('location');
        $teamId = get_cookie('line');
        $date = date('Y-m-d H:i:s');

        $this->getOutHeadCount($date,$dayType);

        $data = array(
            'workerOut'=>'1',
            'workerOutTime'=>$date,
        );

        $this->db->trans_start();
            $this->db->set($data);
            $this->db->where('id',$workerTbId);
            $this->db->update('worker_in_team');
        return $this->db->trans_complete();

    }

    public function opeChange(){
        $workerTbId = $this->input->post('workerOpTbId');
        $opeId = $this->input->post('operationId');

        $this->db->trans_start();
            $this->db->set('operation_id',$opeId);
            $this->db->where('id',$workerTbId);
            $this->db->update('worker_in_team');
        return $this->db->trans_complete();
    }

    public function checkIsSameTeam($workerTbId,$teamId,$empTbId){

        $sql = "SELECT id FROM `worker_in_team` WHERE id = '$workerTbId' AND teamId = '$teamId' AND empTbId = '$empTbId' AND workerOut = '1'";
        return $this->db->query($sql)->result();

    }

    public function getDayTypeData($id){
        $sql = "SELECT * FROM `location_shift` WHERE `id` = '$id'";
        return $this->db->query($sql)->result();
    }

    public function getInHeadCount($epfNo,$inTime,$dayType){

        $dayPlanDate = $this->getDayTypeData($dayType);

        $onTime = $dayPlanDate[0]->onTime;
        $offTime = $dayPlanDate[0]->offTime;
        $halfTime1 = $dayPlanDate[0]->halfTime1;
        $halfTime2 = $dayPlanDate[0]->halfTime2;

        $inTime = date("H:i:s", strtotime($inTime));

        $headCount = 0;

            if( $inTime <= $halfTime1){
                $headCount = 1;
            }else if($inTime > $halfTime1 && $inTime < $halfTime2 ){
                $headCount = 0.5;
            }else if($inTime > $halfTime2){
                $headCount = 0;
            }

        return $headCount;

    }

    public function getOutHeadCount($outTime,$dayType){

        $dayPlanDate = $this->getDayTypeData($dayType);

        $onTime = $dayPlanDate[0]->onTime;
        $offTime = $dayPlanDate[0]->offTime;
        $halfTime1 = $dayPlanDate[0]->halfTime1;
        $halfTime2 = $dayPlanDate[0]->halfTime2;

        $outTime = date("H:i:s", strtotime($outTime));

            $headCount = 0;

            if($outTime > $onTime  && $outTime < $halfTime1 ){
                $headCount = 0;
            }else if($outTime >= $halfTime1 && $outTime < $halfTime2){
                $headCount = 0.5;
            }else if($outTime > $offTime){
                  $headCount = 0.5;
            }

        return $headCount;

    }

    public function getTodayWorkerList(){
      $teamId = get_cookie('line');
      $date = date('Y-m-d');
      $sql = "SELECT
      `worker_in_team`.`emp_no`,
      `emp_details`.`emp_name`,
      `dep_style_operation_smv`.`style_name`,
      `dep_style_operation_smv`.`operation`,
      TIME(
        `worker_in_team`.`workerInTime`
      ) AS workerInTime,
      `worker_in_team`.`headCount`
      FROM
      `intranet_db`.`worker_in_team`
      INNER JOIN `intranet_db`.`dep_style_operation_smv`
      ON (
        `worker_in_team`.`operation_id` = `dep_style_operation_smv`.`id`
      )
      INNER JOIN `intranet_db`.`emp_details`
      ON (
        `worker_in_team`.`empTbId` = `emp_details`.`id`
      )
      WHERE `worker_in_team`.`teamId` = '$teamId'
      AND DATE(
        `worker_in_team`.`workerInTime`
      ) = '$date'
      AND `worker_in_team`.`workerOut` = 0 ORDER BY TIME(`worker_in_team`.`workerInTime`) ASC";

      return $this->db->query($sql)->result();
    }

    public function getPreWorker(){
      $teamId = get_cookie('line');
      $locationId = get_cookie('location');
      $toDay = date('Y-m-d');
      $getPreviousDate = "SELECT MAX(DATE(createDateTime)) AS lastDate FROM `worker_in_team` WHERE teamId = '12' AND DATE(createDateTime) < '$toDay'";
      $preDateResult = $this->db->query($getPreviousDate)->result();

      $preDate = $preDateResult[0]->lastDate;

      $sql = "SELECT DISTINCT
      empTbId,
      emp_no,
      `emp_details`.`emp_name`,
      operation_id,
      teamId
      FROM
      `worker_in_team`
      INNER JOIN `emp_details` ON `worker_in_team`.`emp_no` = `emp_details`.`epf_no`
      WHERE teamId = '$teamId'
      AND DATE(createDateTime) = '$preDate' AND `workerOut` = 0 AND `emp_details`.`locationId` = $locationId";

      return $this->db->query($sql)->result();

    }

    public function savePreLoadWorkers($data){
      // echo $data;exit();

      $this->db->trans_start();
       $this->db->insert('worker_in_team',$data);
      return $this->db->trans_complete();
    }


}
