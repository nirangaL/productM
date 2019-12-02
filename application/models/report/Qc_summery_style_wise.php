<?php

class Qc_Summery_Style_Wise extends MY_Controller{

  public function getTeam($location){

  }

  public function getStyle(){
    $teamId = $this->input->post('teamId');
    $sql= "SELECT style FROM `checking_header_tb` WHERE lineNo='$teamId' GROUP BY style" ;
    return $this->db->query($sql)->result();
  }

  public function getDelivery(){
    $style = $this->input->post('style');
    $sql = "SELECT deliverNo FROM `checking_header_tb` WHERE style='$style' GROUP BY deliverNo"
    return $this->db->query($sql)->result();
  }

  public public function FunctionName($value=''){

  }

}
