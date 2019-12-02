<?php
/**
 *
 */
class Master_department_model extends CI_model{

  public function getAllDepartment(){

    $sql = "SELECT
              mstr_department.*,
              `location`.`location` AS locationName
            FROM
              `mstr_department`
              INNER JOIN `location`
                ON `mstr_department`.`location` = `location`.`location_id`";

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


}
 ?>
