<?php


class Team_workers_list_model extends CI_model{

  public function getWorkersList(){
    $date = $this->input->post('date');
    $teamId = $this->input->post('team');
    $department = $this->input->post('department');

    $sql = "SELECT
    `worker_in_team`.`emp_no`
    , `emp_details`.`emp_name`
    , `dep_style_operation_smv`.`operation`
    , `mstr_department`.`department`
    , `mstr_department`.`id` AS depId
    , `worker_in_team`.`teamId`
    , `prod_line`.`line`
    , `worker_in_team`.`workerIn`
    , TIME(`worker_in_team`.`workerInTime`) AS workerInTime
    , `worker_in_team`.`workerOut`
    , TIME(`worker_in_team`.`workerOutTime`) AS workerOutTime
    , `worker_in_team`.`headCount`
    , `worker_in_team`.`createDateTime`
    FROM
    `worker_in_team`
    INNER JOIN `emp_details`
    ON (`worker_in_team`.`empTbId` = `emp_details`.`id`)
    INNER JOIN `dep_style_operation_smv`
    ON (`worker_in_team`.`operation_id` = `dep_style_operation_smv`.`id`)
    INNER JOIN `mstr_department`
    ON (`dep_style_operation_smv`.`departmentId` = `mstr_department`.`id`)
    INNER JOIN `prod_line` ON  `worker_in_team`.`teamId` = `prod_line`.`line_id`";


    if($teamId =='All'){
      $sql = $sql." WHERE DATE(createDateTime) = '$date' AND `mstr_department`.`id`='$department' ORDER BY teamId ASC";
    }else{
      $sql = $sql." WHERE DATE(createDateTime) = '$date' AND teamId='$teamId' AND `mstr_department`.`id`='$department' ORDER BY teamId ASC";

    }

    return $this->db->query($sql)->result();

  }

  public function getDepartment($locationId){
    $sql ="SELECT
      `id` AS depId,
      `location`,
      `department`,
      `status`
    FROM
      `intranet_db`.`mstr_department` WHERE `location` ='$locationId' AND `status`='1'";

    return $this->db->query($sql)->result();
  }

  public function getTeam($locationId){
    $sql ="SELECT
            `line_id` AS teamId,
            `line` AS team,
            `active`
          FROM
            `intranet_db`.`prod_line` WHERE `location_id` ='$locationId' AND `active`='1'";

    return $this->db->query($sql)->result();
  }

}
