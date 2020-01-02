<?php

class Qc_passlog_model extends CI_model{

    public function getTeam($location){
        $sql = "SELECT
                line_id AS teamId,
                line AS team
            FROM
                prod_line
            WHERE location_id = '$location'
                AND permnt_inactive = '0' ORDER BY `line` ASC";

        return $this->db->query($sql)->result();
    }

    public function getTableData($team,$fromDate,$fromTime,$toDate,$toTime){

        $fromDateTime =  date("Y-m-d",strtotime($fromDate)).' '.$fromTime;
        $toDateTime = date("Y-m-d",strtotime($toDate)).' '.$toTime;
        
                $sql = "SELECT
                `hd`.`style`,
                `hd`.`scNumber`,
                `grd`.`delivery` AS `deliverNo`,
                `pslg`.`color` AS `color`,
                `pslg`.`size` AS `size`,
                `pslg`.`dateTime` AS `datetime`,
                `lc`.`location_id` AS `location`,
                `pl`.`line_id`,
                `pl`.`line`
              FROM
                `checking_header_tb` hd
                LEFT JOIN `qc_pass_log` pslg
                  ON hd.id = pslg.`chckHeaderId`
                LEFT JOIN `prod_line` pl
                  ON hd.`lineNo` = pl.`line_id`
                LEFT JOIN location lc
                  ON hd.`location` = lc.`location_id`
                   LEFT JOIN `checking_grid_tb` grd
                  ON hd.`id` = grd.`chckHeaderId`
              WHERE `pslg`.`datetime` BETWEEN '$fromDateTime'
                AND '$toDateTime'";

                if($team != "All"){
                    $sql .= " AND hd.`lineNo` = '$team' ";
                }else{
                    $sql .= " AND hd.`location` = '$this->myConlocation' ";
                }

                $sql.= 'GROUP BY pslg.`id`';

          return $this->db->query($sql)->result();

    }

}