<?php
error_reporting(-1);
ini_set('display_errors', 1);
class Date_range_line_issue_model extends CI_model {

public function getDateRangeWiseLineIssueReport($teamId){
  $fromDate = $this->input->post('fromDate');
  $toDate = $this->input->post('toDate');
  $orderdate = explode('/', $fromDate);
  $month = $orderdate[0];
  $day   = $orderdate[1];
  $year  = $orderdate[2];
  $fromDate = $year.'-'.$month.'-'.$day;

  $orderdate = explode('/', $toDate);
  $month = $orderdate[0];
  $day   = $orderdate[1];
  $year  = $orderdate[2];
  $toDate = $year.'-'.$month.'-'.$day;


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
          production_input
        WHERE teamId = '$teamId' AND
           DATE(createDate) BETWEEN '$fromDate' AND '$toDate' GROUP BY delv,
          size";

  return $this->db->query($sql)->result();

  }

}
