<?php
error_reporting(-1);
ini_set('display_errors', 1);
class Daywise_line_issue_model extends CI_model {

public function getDayWiseLineIssueReport($teamId){
  $selectDate = $this->input->post('date');
  $orderdate = explode('/', $selectDate);
  $month = $orderdate[0];
  $day   = $orderdate[1];
  $year  = $orderdate[2];
  $newDate = $year.'-'.$month.'-'.$day;

  $sql = "SELECT
          teamId,
          style,
          scNumber,
          delv,
          color,
          size,
          SUM(qty) AS qty,
          DATE(createDate)
          FROM
          production_input WHERE teamId ='$teamId' AND DATE(createDate) = '$newDate'
          GROUP BY delv,size";

  return $this->db->query($sql)->result();

  }

}
