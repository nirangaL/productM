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
    , `day_plan`.`scNumber`
    , `day_plan`.`delivery`
    , `day_plan`.`orderQty`
    , `day_plan`.`dayPlanQty`
    , `day_plan`.`hrs`
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
    $delivery = $this->input->post('delivery');
    $orderQty = $this->input->post('orderQty');
    $planPer = $this->input->post('planPer');
    $plannerQty = $this->input->post('plannerQty');
    $dayPlanQty = $this->input->post('planQty');
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
      'delivery' => $delivery,
      'orderQty' =>  $orderQty,
      'plannerPers' =>  $planPer,
      'plannerQty' =>  $plannerQty,
      'dayPlanQty' =>  $dayPlanQty,
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
    $this->db->trans_start();
    $this->db->insert('day_plan', $data);
    return $this->db->trans_complete();
  }

  public function getDatPlanToEdit($planId){
    $sql = "SELECT * FROM `day_plan` WHERE id='$planId'";

    return $this->db->query($sql)->result();
  }

  public function editDayPlan($planId){
    $status = $this->input->post('status');

    $delivery = $this->input->post('delivery');
    $orderQty = $this->input->post('orderQty');
    $planPer = $this->input->post('planPer');
    $plannerQty = $this->input->post('plannerQty');
    $smv = $this->input->post('smv');
    $workingHrs = $this->input->post('workingHrs');
    $noOfWorkser = $this->input->post('noOfWorkser');
    $planQty = $this->input->post('planQty');
    $ince_hour = $this->input->post('ince_hour');
    // $efficiency = $this->input->post('efficiency');
    $forecastEffi = $this->input->post('forecastEffi');
    $status = $this->input->post('status');



    $this->db->trans_start();
    $this->db->set('hrs', $workingHrs);
    $this->db->set('smv', $smv);
    $this->db->set('noOfwokers', $noOfWorkser);
    $this->db->set('dayPlanQty', $planQty);
    $this->db->set('incentiveHour', $ince_hour);
    // $this->db->set('incenEffi', $efficiency);
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

  public  function getStyleRunDays(){
    $style = $this->input->post('style');
    $line = $this->input->post('line');

    $sql = "SELECT id,runDaysCount,lastRunDate FROM team_wise_style_rundays WHERE `teamId` = '$line' AND `style`='$style'";

    $result =  $this->db->query($sql)->result();

    if(!empty($result)){
      $data = array(
        'num_rows' =>(Int)$result[0]->runDaysCount,
        'lastRunDate' =>$result[0]->lastRunDate
      );
    }else{
      $data = array(
        'num_rows' =>1,
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
    `noOfwokers`,
    `sysEffi`,
    `incenEffi`,
    `forecastEffi`
    FROM
    `day_plan` WHERE line='$lineId' AND dayPlanType ='1'AND status !='3' AND DATE(createDate) = '$date'";
    return $this->db->query($sql)->result();
  }

}
