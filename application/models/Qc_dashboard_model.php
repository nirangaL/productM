<?php
class Qc_dashboard_model extends CI_Model{


    public function getTeams($location){
        $sql = "SELECT line_id AS teamId,line AS team,location_id FROM `prod_line` WHERE location_id = '$location' AND active='1' ORDER BY `line` REGEXP '^[a-z]' DESC,`line`";
        return $this->db->query($sql)->result();
    }

    public function getData($team,$date){

        $sql = "SELECT
        teamName, 
        dayPlanId,
        buyer,
        style,
        sc,
        passQty,
        COUNT(defectId) AS defectAmount,
        defectId,
        defectReason 
        FROM(SELECT 
            `day_plan`.`id` AS dayPlanId
                , `day_plan`.`line`
                ,`temp_accller_view`.`buyer`
                , temp_accller_view.`sc`
                , `day_plan`.`style`
                , `day_plan`.`dayPlanQty`
                ,  prod_line.`line` AS teamName
                , IFNULL((SELECT SUM(passQty) FROM `checking_grid_tb` WHERE `chckHeaderId` = IFNULL(`checking_header_tb`.`id`,0)),0) AS passQty
                , qc_reject_log.`rejectReason` AS defectId
                ,`reject_master`.`rejectReason` AS defectReason
                FROM `day_plan`
                LEFT JOIN `checking_header_tb`
                        ON ( `day_plan`.`style` =`checking_header_tb`.`style` ) AND DATE(day_plan.createDate) = DATE(`checking_header_tb`.`dateTime`) AND `day_plan`.`line` = `checking_header_tb`.`lineNo`
            LEFT JOIN qc_reject_log ON qc_reject_log.`chckHeaderId` = `checking_header_tb`.`id`
            LEFT JOIN `reject_master` ON qc_reject_log.`rejectReason` = `reject_master`.`id`
                LEFT JOIN `intranet_db`.`prod_line`
                    ON (`day_plan`.`line` = `prod_line`.`line_id`)
                LEFT JOIN `temp_accller_view` ON (`day_plan`.`style` = `temp_accller_view`.`style`)
                        WHERE day_plan.line = '$team' AND day_plan.status IN ( '1','2','4') AND DATE(day_plan.createDate) = '$date' GROUP BY qc_reject_log.`rejectId`)t1 GROUP BY style,defectId   ORDER BY dayPlanId";   

        return $this->db->query($sql)->result();

    }
   
    public function getRemakeDate($team,$date){
        $sql = "SELECT
                    chtb.`lineNo`,
                    line.`line`,
                    chtb.`style`,
                    chtb.`scNumber`,
                    COUNT(remtb.id) AS amount
                FROM
                    `checking_header_tb` chtb
                INNER JOIN `qc_remake_log` remtb ON chtb.`id`  = remtb.`chckHeaderId`
                INNER JOIN `prod_line` line ON chtb.`lineNo` = line.`line_id`
                WHERE DATE(chtb.`dateTime`) = '$date' AND chtb.`lineNo` ='$team' GROUP BY chtb.`style`";

            return $this->db->query($sql)->result();
    }

    public function getAllDefectSumm($location,$date){

        $sql = "SELECT
            chtb.`lineNo`,
            line.`line`,
            chtb.`style`,
            chtb.`scNumber`,
            rejmstr.`rejectReason`,
            COUNT(rejmstr.`rejectReason`) AS amount
        FROM
            `checking_header_tb` chtb
        INNER JOIN `qc_reject_log` rejtb ON chtb.`id`  = rejtb.`chckHeaderId`
        INNER JOIN reject_master rejmstr ON rejtb.`rejectReason` = rejmstr.`id`
        INNER JOIN `prod_line` line ON chtb.`lineNo` = line.`line_id`
        WHERE DATE(chtb.`dateTime`) = '$date' AND chtb.location ='$location' GROUP BY line.`line`,chtb.`style`,rejmstr.`rejectReason` ORDER BY rejmstr.rejectReason ASC";

        return $this->db->query($sql)->result();
    }


}