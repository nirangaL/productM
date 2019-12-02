<?php

class App_team_mng_model extends CI_model{

  public function getInputQty($teamId){
    $date = date('Y-m-d');
    $sql = "SELECT SUM(qty) AS totalQty FROM `cut_in` WHERE teamId='$teamId' AND DATE(createDate) = '$date'";
    return $this->db->query($sql)->result();
  }

  public function getIssueQty($teamId){
    $date = date('Y-m-d');
    $sql = "SELECT SUM(qty) AS totalQty FROM `production_input` WHERE teamId='$teamId' AND DATE(createDate) = '$date'";
    return $this->db->query($sql)->result();
  }

  public function getWorkerCount($teamId){
    $date = date('Y-m-d');
    $sql = "SELECT COUNT(id) AS totalWorker FROM `worker_in_team` WHERE teamId = '$teamId' AND workerIn='1' AND workerOut='0' AND DATE(createDateTime) = '$date'";
    return $this->db->query($sql)->result();
  }


}
