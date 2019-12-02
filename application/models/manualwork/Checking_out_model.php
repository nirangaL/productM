<?php

class Checking_out_model extends CI_model{


public function getAllLocation(){
    $sql = "SELECT `location_id`,`location` FROM `location` WHERE `active` ='1'";

    return $this->db->query($sql)->result();
}

public function getTeams(){
$location = $this->input->post('location');

$sql = "SELECT `line_id`,`line` FROM `prod_line` WHERE location_id ='$location'";

 return $this->db->query($sql)->result();

}

public function addToLog(){

  // $logType = $this->input->post('logtype');
  // $locationId = $this->input->post('location');
  // $team = $this->input->post('team');
  // $style = $this->input->post('style');
  // $delivery = $this->input->post('delivery');
  // $chckHeaderId = $this->input->post('chckHeaderId');
  // $chckGridId = $this->input->post('chckGridId');
  // $size = $this->input->post('size');
  // $qty  = $this->input->post('qty');
  // $dateTime = $this->input->post('datetime');

  $qty = 10;

  // if($logType == 1){
    $sql = "INSERT INTO `intranet_db`.`qc_pass_log`";
  // }

  $sql .= "(
        `chckHeaderId`,
        `chckGridId`,
        `color`,
        `size`,
        `dateTime`
        )VALUES";

  for($i=0;$i<$qty;$i++){
    $sql .= "
          (
            '991',
            '5089',
            'Pink',
            '12 Y',
            '2019-09-27 9:10:00'
          ),";

  }

  $sql = substr_replace($sql ,"",-1);
  $sql .=';';
  //
  echo "<pre>";
  echo $sql;
  echo "</pre>";

  $result = $this->db->query($sql);

  // if($result){
  //   echo $qty .'are inserted..';
  // }

}

}
