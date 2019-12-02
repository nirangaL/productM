<?php

class Master_team_model extends CI_model{

  public function getAllTeam(){
    $sql = "SELECT
    `prod_line`.`line_id`
    , `prod_line`.`line`
    , `mstr_department`.`department`
    , `location`.`location`
    , `prod_line`.`active`
    FROM
    `prod_line`
    INNER JOIN `mstr_department`
    ON (`prod_line`.`dep_id` = `mstr_department`.`id`)
    INNER JOIN `location`
    ON (`prod_line`.`location_id` = `location`.`location_id`) AND (`mstr_department`.`location` = `location`.`location_id`)";

    return $this->db->query($sql)->result();
  }

  public function getAllLocations(){
    $sql = "SELECT
                `location_id`
                , `location`
                , `active`
            FROM
                `intranet_db`.`location`
            WHERE `active`  ='1'";

    return $this->db->query($sql)->result();
  }

  public function getDepart(){
    $department = $this->input->post('location');
    $sql = "SELECT id,department FROM `mstr_department` WHERE location = '$department'";
    return $this->db->query($sql)->result();
  }

  public function saveData(){
    $location = $this->input->post('location');
    $department = $this->input->post('department');
    $team = $this->input->post('team');
    $active = $this->input->post('status');

    $data = array(
        'line' => $team,
        'comp_id' => 1,
        'location_id' => $location,
        'dep_id' => $department,
        'active' => $active,
        // 'createDate' =>  date('Y-m-d H:i:s'),
        // 'createBy' =>  $_SESSION['session_user_data']['userName']
    );

    $this->db->trans_start();
    $this->db->insert('prod_line', $data);
    return $this->db->trans_complete();

  }

  public function validateTeam(){
    $location = $this->input->post("location");
    $department = $this->input->post("depart");
    $team = $this->input->post("team");

    $sql = "SELECT line_id FROM prod_line WHERE location_id = '$location' AND dep_id ='$department' AND line='$team'";

    return $this->db->query($sql)->result();

  }

  public function getTeamToEdit($teamId){

    $sql = "SELECT
    prod_line.*,
    `mstr_department`.`department`,
    `location`.`location`
    FROM
    prod_line
    INNER JOIN `mstr_department` ON prod_line.`dep_id` = `mstr_department`.`id`
    INNER JOIN `location` ON prod_line.`location_id` = `location`.`location_id`
    WHERE line_id = '$teamId'";
    return $this->db->query($sql)->result();
  }

  public function updateData($teamId){
      $team = $this->input->post('team');
      $status = $this->input->post('status');

      	// echo $team;exit();

      $this->db->trans_start();
        $this->db->set('line',$team);
        $this->db->set('active',$status);
        $this->db->where('line_id',$teamId);
        $this->db->update('prod_line');
      return $this->db->trans_complete();
  }




}

?>
