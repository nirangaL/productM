<?php 


class Team_hourly_progress_model extends CI_model{

    public function getLocation(){
        $sql = "SELECT * FROM `location` WHERE active = '1'";
        return $this->db->query($sql)->result();
    }

    public function getTeam($location){
        $sql = "SELECT
                    line_id,
                    `line`
                FROM
                    prod_line
                WHERE location_id = '$location'
                    AND permnt_inactive = '0' ORDER BY `line` REGEXP '^[a-z]' DESC,`line`";

        return $this->db->query($sql)->result();
    }


    public function getTableData($date,$teamId){
        $sql = "SELECT
                pl.`line` as teamName,
                hpr.*
            FROM
                `prod_line` pl
                LEFT JOIN `produc_hourly_progress` hpr
                ON pl.`line_id` = hpr.`teamId`
            WHERE pl.`line_id` = '$teamId'
                AND hpr.`date` = '$date' ORDER BY pl.`line_id`";

                // exit($sql);

        return $this->db->query($sql)->result();
    }

}