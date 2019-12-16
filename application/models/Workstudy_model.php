<?php
/**
* Created by PhpStorm.
* User: nirangal
* Date: 01/23/2019
* Time: 3:43 PM
*/

class Workstudy_model extends CI_Model{

  public function getAllDayPlans(){

    $date = date('Y-m-d');

    $location = $_SESSION['session_user_data']['location'];

    $sql = "SELECT
    `day_plan`.`id`
    , `prod_line`.`line`
    , `day_plan`.`dayPlanType`
    , `day_plan`.`style`
    , `day_plan`.`smv`
    , `day_plan`.`scNumber`
    , `day_plan`.`dayPlanQty`
    , `day_plan`.`hrs`
    , `day_plan`.`noOfwokers`
    , `day_plan`.`status`
    , `day_plan`.`createDate` AS `dateTime`
    , `location`.`location`
    FROM
    `intranet_db`.`location`
    INNER JOIN `intranet_db`.`day_plan`
    ON (`location`.`location_id` = `day_plan`.`location`)
    INNER JOIN `intranet_db`.`prod_line`
    ON (`prod_line`.`location_id` = `location`.`location_id`) AND (`prod_line`.`line_id` = `day_plan`.`line`)
    WHERE `location`.`location_id` = '$location' AND DATE (`day_plan`.`createDate`) = '$date'";

    return $this->db->query($sql)->result();
  }

  public function saveDayPlan(){
    $line = $this->input->post('line');
    $dayPlanType = $this->input->post('dayPlanType');
    $timeTempl = $this->input->post('timeTempl');
    $style = $this->input->post('style');
    $scNumber = $this->input->post('scNumber');
    $dayPlanQty = $this->input->post('planQty');
    $runningDay = $this->input->post('runDay');
    $showRunningDay = $this->input->post('showRunDay');
    $workingHrs = $this->input->post('workingHrs');
    $smv = $this->input->post('smv');
    $noOfWorkser = $this->input->post('noOfWorkser');
    $efficiency_hid = $this->input->post('efficiency_hid');
    $incenEffi = $this->input->post('efficiency');
    $forecastEffi = $this->input->post('forecastEffi');
    $status = $this->input->post('status');
    $feedingHours = $this->input->post('feedHours');
    $ince_hour = $this->input->post('ince_hour');

    if($status==''){
      $status ='2';
    }

    $data = array(
      'line' => $line,
      'dayPlanType' => $dayPlanType,
      'timeTemplate' => $timeTempl,
      'style' => $style,
      'scNumber' => $scNumber,
      'dayPlanQty' =>  $dayPlanQty, 
      'runningDay' =>  $runningDay,
      'showRunningDay' =>  $showRunningDay,
      'hrs' =>  $workingHrs,
      'smv' =>  $smv,
      'noOfwokers' =>  $noOfWorkser,
      'incentiveHour' =>  $ince_hour,
      'sysEffi' =>  $efficiency_hid,
      'incenEffi' =>  $incenEffi,
      'forecastEffi' =>  $forecastEffi,
      'status' =>  $status,
      'feedingHour' =>  $feedingHours,
      'location' =>  $_SESSION['session_user_data']['location'],
      'createBy' =>  $_SESSION['session_user_data']['userName'],
      'createDate' =>  date('Y-m-d H:i:s'),
    );
    $currentDate = date('Y-m-d');
    $this->db->trans_start();
    $sql = "SELECT id FROM day_plan WHERE style = '$style' AND dayPlanType ='1' AND DATE(`createDate`) = '$currentDate' AND `line`= '$line'";
    $count = $this->db->query($sql)->num_rows();
    
    if($count == 0){
      $this->db->insert('day_plan', $data);
      return $this->db->trans_complete();
    } else{
      return true;
    }
   
  }

  public function getDatPlanToEdit($planId){
    $sql = "SELECT * FROM `day_plan` WHERE id='$planId'";

    return $this->db->query($sql)->result();
  }

  public function editDayPlan($planId){
    $status = $this->input->post('status');

    $runDay = $this->input->post('runDay');
    $smv = $this->input->post('smv');
    $workingHrs = $this->input->post('workingHrs');
    $noOfWorkser = $this->input->post('noOfWorkser');
    $planQty = $this->input->post('planQty');
    $ince_hour = $this->input->post('ince_hour');
    $efficiency = $this->input->post('efficiency');
    $forecastEffi = $this->input->post('forecastEffi');
    $status = $this->input->post('status');
    $runningDay = $this->input->post('showRunDay');

    $this->db->trans_start();
    $this->db->set('hrs', $workingHrs);
    $this->db->set('smv', $smv);
    $this->db->set('noOfwokers', $noOfWorkser);
    $this->db->set('dayPlanQty', $planQty);
    $this->db->set('runningDay', $runDay);
    $this->db->set('showRunningDay', $runningDay);
    $this->db->set('incentiveHour', $ince_hour);
    $this->db->set('incenEffi', $efficiency);
    $this->db->set('forecastEffi', $forecastEffi);
    if($status != '' ){
      $this->db->set('status', $status);
    }
    $this->db->set('modifyBy', $_SESSION['session_user_data']['userName']);
    $this->db->set('modifyDate', date('Y-m-d H:i:s'));
    $this->db->where('id', $planId);
    $this->db->update('day_plan');
    return $this->db->trans_complete();
  }

  public function checkLineIsRunning(){
    $line = $this->input->post('line');
    $date =  date('Y-m-d');
    $sql="SELECT
    style
    FROM
    `day_plan`
    WHERE line = '$line'
    AND DATE(createDate) = '$date'
    AND `status` = '1'";
    return $this->db->query($sql)->result();
  }

  // public function otherDayPlan(){
  //   $style = $this->input->post('style');
  //   $line = $this->input->post('line');
  //   $date = date('Y-m-d');
  //   $sql = "SELECT runnigDay AS runDay,DATE(createDate) AS lastRunDate FROM day_plan WHERE line='$line' AND style='$style' AND DATE(createDate) ='$date';";

  //   $result =  $this->db->query($sql)->result();

  //   if(!empty($result)){
  //     $data = array(
  //       'runDay' =>(Int)$result[0]->runDaysCount,
  //       'lastRunDate' =>$result[0]->lastRunDate
  //     );
  //   }else{
  //     $data = array(
  //       'runDay' =>0,
  //       'lastRunDate' =>'--/--/----'
  //     );
  //   }

  //   return $data;
  // }

  public  function getStyleRunDays(){
    $style = $this->input->post('style');
    $line = $this->input->post('line');

    $sql = "SELECT id,runDaysCount,lastRunDate FROM team_wise_style_rundays WHERE `teamId` = '$line' AND `style`='$style'";

    $result =  $this->db->query($sql)->result();

    if(!empty($result)){
      $data = array(
        'runDay' =>(Int)$result[0]->runDaysCount,
        'lastRunDate' =>$result[0]->lastRunDate
      );
    }else{
      $data = array(
        'runDay' =>0,
        'lastRunDate' =>'--/--/----'
      );
    }



    return $data;
  }


  public function needRuningDaysEffi($runingDays){
    $smv = $this->input->post('smv');
    $location = $_SESSION['session_user_data']['location'];
    $sql = "SELECT efficiency,base_amount,incre_percent,incre_amount,reduct_amount FROM incentive_ladderid WHERE smv_start < '$smv' AND smv_end > '$smv' AND days = '$runingDays' AND `locationId` = '$location'";

    return $this->db->query($sql)->result();
  }

  public function getTimeTemplate($location){
    $sql = "SELECT id,templateCode,templateName FROM `time_template` WHERE location_id ='$location'";
    return $this->db->query($sql)->result();
  }

  public function getInputQty($teamId){
    $date = date('Y-m-d');
    $sql = "SELECT SUM(qty) AS totalQty FROM `cut_in` WHERE teamId='$date' AND DATE(createDate) = '$teamId'";
    return $this->db->query($sql)->result();
  }


  public function getPreRunnigDayPlan(){
    $lineId = $this->input->post('lineId');
    $date = date('Y-m-d');
    $sql = "SELECT
    `id`,
    `line`,
    `dayPlanType`,
    `timeTemplate`,
    `hrs`,
    `smv`,
    `runningDay`,
    `showRunningDay`,
    `noOfwokers`,
    `incentiveHour`,
    `sysEffi`,
    `incenEffi`,
    `forecastEffi`
    FROM
    `day_plan` WHERE line='$lineId' AND dayPlanType ='1'AND status !='3' AND DATE(createDate) = '$date'";
    return $this->db->query($sql)->result();
  }

  public function changeDayPlanType($dayPlanType){
    $otherDayPlanId = $this->input->post('otherDayPlan');
    $this->db->trans_start();
    $this->db->set('dayPlanType',$dayPlanType );
    $this->db->where('id',$otherDayPlanId);
    $this->db->update('day_plan');
    $this->db->trans_complete();

  }


  public function changeDayPlanTypeToNormal($planId){
    $date = date('Y-m-d');
    $otherDayPlan =$this->db->query(
      "SELECT line FROM `day_plan` WHERE id = '$planId'"
    )->result();

    if(!empty($otherDayPlan)){
      $line = $otherDayPlan[0]->line;
      $sql = "UPDATE
              `intranet_db`.`day_plan`
            SET
              `dayPlanType` = '1'
            WHERE `line` = '$line'
              AND DATE(createDate) = '$date'
              AND dayPlanType = '4'";

      $this->db->trans_start();
      $this->db->query($sql);
      $this->db->trans_complete();
    }

    
  }

}
