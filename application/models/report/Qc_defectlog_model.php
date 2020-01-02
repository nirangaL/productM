<?php

class Qc_defectlog_model extends CI_model{

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
                `dflg`.`color` AS `color`,
                `dflg`.`size` AS `size`,
                `rgmst`.`rejectReason` AS `reason`,
                `dflg`.`dateTime` AS `datetime`,
                `lc`.`location_id` AS `location`,
                `pl`.`line_id`,
                `pl`.`line`
              FROM
                `checking_header_tb` hd
                LEFT JOIN `qc_reject_log` dflg
                  ON hd.id = dflg.`chckHeaderId`
                LEFT JOIN `prod_line` pl
                  ON hd.`lineNo` = pl.`line_id`
                LEFT JOIN location lc
                  ON hd.`location` = lc.`location_id`
                   LEFT JOIN `checking_grid_tb` grd
                  ON hd.`id` = grd.`chckHeaderId`
                  LEFT JOIN `reject_master` rgmst ON `dflg`.`rejectReason` = rgmst.`id`
              WHERE `dflg`.`datetime` BETWEEN '$fromDateTime'
                AND '$toDateTime'";

                if($team != "All"){
                    $sql .= " AND hd.`lineNo` = '$team' ";
                }else{
                    $sql .= " AND hd.`location` = '$this->myConlocation' ";
                }

                $sql.= 'GROUP BY dflg.`rejectId`';

          return $this->db->query($sql)->result();

    }

}