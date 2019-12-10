<?php

// Importent class
// This class use library/Production_dashboard_library.php file 
// This model use for every production dashboard,Team Dashbord
// Do not delete 


class Dashboard_production_model extends CI_Model{

    public function get_team_data($team, $date){

        $sql = "SELECT `day_plan`.`id` AS dayPlanId
        , day_plan.status
        , `day_plan`.`dayPlanType`
        , `day_plan`.`line`
        , `day_plan`.`timeTemplate`
        ,`temp_accller_view`.`buyer`
        , `day_plan`.`style`
        , `day_plan`.`scNumber`
        , `day_plan`.`dayPlanQty`
        , `day_plan`.`runningDay`
        , `day_plan`.`showRunningDay`
        , `day_plan`.`hrs`
        , `day_plan`.`smv`
        , `day_plan`.`noOfwokers`
        , `day_plan`.`incentiveHour`
        , `day_plan`.`forecastEffi` AS forecastEffi
        , `day_plan`.`incenEffi`
        , `day_plan`.`location`
        , prod_line.`line` AS lineName
        ,  IFNULL(`checking_header_tb`.`id`,0) as chckTblHdId
        ,IFNULL((SELECT COUNT(*) AS pass FROM `qc_pass_log` WHERE `chckHeaderId` = ifnull(`checking_header_tb`.`id`,0) AND DATE(`dateTime`) = '$date'),0) AS passQty
          ,IFNULL((SELECT COUNT(*) FROM `qc_reject_log` WHERE `chckHeaderId` = ifnull(`checking_header_tb`.`id`,0) AND DATE(`dateTime`)= '$date' ),0) AS defectQty
         ,IFNULL((SELECT COUNT(*) FROM `qc_remake_log` WHERE `chckHeaderId` = ifnull(`checking_header_tb`.`id`,0) AND DATE(`dateTime`) = '$date' ),0) AS remakeQty
        FROM `day_plan`
        left join `checking_header_tb`
                ON ( `day_plan`.`style` =`checking_header_tb`.`style` ) and DATE(day_plan.createDate) = DATE(`checking_header_tb`.`dateTime`) AND `day_plan`.`line` = `checking_header_tb`.`lineNo`
        INNER JOIN `intranet_db`.`prod_line`
            ON (`day_plan`.`line` = `prod_line`.`line_id`)
        LEFT JOIN `temp_accller_view` ON (`day_plan`.`style` = `temp_accller_view`.`style`)
                WHERE day_plan.line = '$team' AND day_plan.status IN ( '1','2','4') AND DATE(day_plan.createDate) = '$date' GROUP BY style ORDER BY `day_plan`.`id` ASC";

        // echo $sql;exit();

        return $this->db->query($sql)->result();

    }

    //// Get otherDayPlan Hour as current date and team ///
    public function getOtherDayPlan($teamId,$dayPlanId){
        $date = date('Y-m-d');

        $sql = "SELECT DISTINCT
                  `line`,
                  `hrs` AS workedHours
                FROM
                  `day_plan`
                WHERE `dayPlanType` != '2' AND `status` != '3'
                  AND DATE(`createDate`) = '$date'
                  AND `line` = '$teamId'
                  AND `id` != '$dayPlanId'";

//        echo $sql;
        return $this->db->query($sql)->result();
        

    }

    public function getTimeRange($lastHour,$timeTemplId){
        if ($lastHour != 0  ){
            $startHour = (string)$lastHour.'hStart';
            $endHour = (string)$lastHour.'hEnd';
            $sql = "SELECT $startHour AS startTime,$endHour AS endTime FROM `time_template` WHERE id = '$timeTemplId'";
            return $this->db->query($sql)->result();
        }else{
            return '';
        }
    }

    public function getPassQtyForTimeRange($startTime,$endTime,$style,$team){
        $sql = "SELECT
                    COUNT(`qc_pass_log`.`id`) as passQty
                FROM
                    `intranet_db`.`checking_header_tb`
                    INNER JOIN `intranet_db`.`qc_pass_log`
                        ON (`checking_header_tb`.`id` = `qc_pass_log`.`chckHeaderId`)
                WHERE `checking_header_tb`.`lineNo` = '$team' AND (`qc_pass_log`.`dateTime` BETWEEN '$startTime' AND '$endTime') AND `checking_header_tb`.`style`='$style'";

        $result = $this->db->query($sql)->result();
        // echo $sql;exit();
        return $result[0]->passQty;
    }

    //// team second for hour /////
    public function getMinutForHour($location,$dep){

        $sql = "SELECT
        minuuteForHour
        FROM
        mstr_department
        WHERE location = '$location'
        AND department = '$dep'";
  
        return $this->db->query($sql)->result();

    }

    //// Get style runing days /////
    public  function getStyleRunDays($style,$team){
        $sql = "SELECT id,runDaysCount,lastRunDate FROM team_wise_style_rundays WHERE `teamId` = '$team' AND `style`='$style'";

        $result =  $this->db->query($sql)->result();

        if(!empty($result)){
            $data = array(
                'num_rows' =>(Int)$result[0]->runDaysCount+1,
                'lastRunDate' =>$result[0]->lastRunDate
            );
        }else{
          $data = array(
              'num_rows' =>1,
              'lastRunDate' =>'--/--/----'
          );
        }


        return $data;
    }

    ///// get style runday efficiency from ladder /////
    public function needRuningDaysEffi($runingDays,$smv,$location){
        $sql = "SELECT efficiency,base_amount,incre_percent,incre_amount,decre_percent,reduct_amount FROM incentive_ladderid WHERE smv_start <= '$smv' AND smv_end > '$smv' AND days = '$runingDays' AND `locationId` = '$location'";
        return $this->db->query($sql)->result();
    }

    //// get qr level from db/////
    public function getQrLevel($location){
        $sql = "SELECT qr_level FROM `qr_level` WHERE location_id = '$location'";
        return $this->db->query($sql)->result();
    }

    /// check feeding day plan for the team /////
    public function checkTodayFeedingSPlan($team){
        $today = date('Y-m-d');
        $sql = "SELECT
        day_plan.id,
        `prod_line`.line,
        day_plan.style,
        `temp_accller_view`.`buyer`
        FROM
        `day_plan`
        INNER JOIN `prod_line`
        ON day_plan.line = `prod_line`.`line_id`
        LEFT JOIN `temp_accller_view` ON (`day_plan`.`style` = `temp_accller_view`.`style`)
        WHERE day_plan.line = '$team'
        AND DATE(`createDate`) = '$today'
        AND `status` = '4'";

        return $this->db->query($sql)->result();
    }

    public function getRoundUpstart($location,$department){
       
       $sql = "SELECT
        `effi_roundup_start`
      FROM
        `mstr_department`
      WHERE location ='2' AND department ='Production' AND `status` = '1'";
      return $this->db->query($sql)->result();
    }


}
