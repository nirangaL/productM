<?php
error_reporting(-1);
ini_set('display_errors', 1);
class Daywise_worker_list_model extends CI_model {

public function getDayWiseWorkerList($teamId){
  $selectDate = $this->input->post('date');
  $orderdate = explode('/', $selectDate);
  $month = $orderdate[0];
  $day   = $orderdate[1];
  $year  = $orderdate[2];
  $newDate = $year.'-'.$month.'-'.$day;

    $sql = "SELECT
  emp_no,
  `emp_details`.`emp_name`,
  `dep_style_operation_smv`.`operation`,
  workerIn,
    TIME(workerInTime) AS inTime,
  workerOut,
  TIME(workerOutTime) AS outTime,
  headCount
FROM
  `worker_in_team`
 INNER JOIN `emp_details` ON `worker_in_team`.`empTbId` = `emp_details`.`id`
 LEFT JOIN `dep_style_operation_smv` ON  `worker_in_team`.`operation_id` = `dep_style_operation_smv`.`id`
WHERE teamId = '$teamId'
  AND workerOut = 0
  AND DATE(createDateTime) = '$newDate'";

  return $this->db->query($sql)->result();

  }

}
