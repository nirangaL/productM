<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

require_once ("DBController.php");
require_once ("Main.php");

class Main_Dashboard extends Main{
    private $db_handle;
    function __construct() {
        $this->db_handle = new DBController();
    }

    /// Get Teams/Lines
    public function getTeams(){
        $sql = "SELECT line_id AS teamId,line AS team FROM `prod_line` WHERE location_id ='$this->sesLocation' AND active='1' ORDER BY `line` REGEXP '^[a-z]' DESC,`line`";
        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
    }

    ///Get teams/Lines Data together with dayPlan and QcChecker Data ////
    public function getDayPlanAndQcData($team){
        $date = date('Y-m-d');
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
        ,IFNULL((SELECT SUM(`passQty`) AS pass FROM  checking_grid_tb WHERE `chckHeaderId` = IFNULL(`checking_header_tb`.`id`,0) ),0) AS passQty
         ,IFNULL((SELECT SUM(`rejectQty`) FROM checking_grid_tb WHERE `chckHeaderId` = IFNULL(`checking_header_tb`.`id`,0)),0) AS defectQty
         ,((SELECT COALESCE(SUM(grd.rejectQty),0) FROM checking_header_tb chtb LEFT JOIN checking_grid_tb grd ON chtb.id = grd.chckHeaderId WHERE chtb.style = checking_header_tb.`style` AND chtb.lineNo = checking_header_tb.`lineNo`) - (SELECT COALESCE(SUM(grd.remakeQty),0) FROM checking_header_tb chtb LEFT JOIN checking_grid_tb grd ON chtb.id = grd.chckHeaderId WHERE chtb.style = checking_header_tb.`style` AND chtb.lineNo = checking_header_tb.`lineNo`))  AS allDefectQty
         ,IFNULL((SELECT SUM(`remakeQty`) FROM checking_grid_tb WHERE `chckHeaderId` = IFNULL(`checking_header_tb`.`id`,0)),0) AS remakeQty
        FROM `day_plan`
        left join `checking_header_tb`
                ON ( `day_plan`.`style` =`checking_header_tb`.`style` ) and DATE(day_plan.createDate) = DATE(`checking_header_tb`.`dateTime`) AND `day_plan`.`line` = `checking_header_tb`.`lineNo`
        INNER JOIN `intranet_db`.`prod_line`
            ON (`day_plan`.`line` = `prod_line`.`line_id`)
        LEFT JOIN `temp_accller_view` ON (`day_plan`.`style` = `temp_accller_view`.`style`)
                WHERE day_plan.line = '$team' AND day_plan.status IN ( '1','2','4') AND DATE(day_plan.createDate) = '$date' GROUP BY style ORDER BY `day_plan`.`id` ASC";
       
       
        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
    }

    /// Get howmany minute is allocate for a Hour to the location////
    public function getMinuteForHour(){
        $sql = "SELECT
        minuuteForHour
        FROM
        mstr_department
        WHERE location = '$this->sesLocation'
        AND department = 'Production'";

        $result = $this->db_handle->runBaseQuery($sql);
        return $result[0]['minuuteForHour'];
    }
    
    //// Get otherDayPlan Hour as current date and team ///
    ///// warning ---- This function not working properly if there are two feeding dayplan //////////
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

        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
    }

    public function getTimeRange($lastHour,$timeTemplId){
        if ($lastHour != 0  ){
            $startHour = (string)$lastHour.'hStart';
            $endHour = (string)$lastHour.'hEnd';
            $sql = "SELECT $startHour AS startTime,$endHour AS endTime FROM `time_template` WHERE id = '$timeTemplId'";
            $result = $this->db_handle->runBaseQuery($sql);
        return $result;
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

        $result = $this->db_handle->runBaseQuery($sql);
        return $result[0]['passQty'];

    }

    public function needRuningDaysEffi($runingDays,$smv){
        $sql = "SELECT efficiency,base_amount,incre_percent,incre_amount,decre_percent,reduct_amount FROM incentive_ladderid WHERE smv_start <= '$smv' AND smv_end > '$smv' AND days = '$runingDays' AND `locationId` = '$this->sesLocation'";
        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
    }

     //// get qr level from db/////
    public function getQrLevel(){
        $sql = "SELECT qr_level FROM `qr_level` WHERE location_id = '$this->sesLocation'";
        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
    }

    public function getRoundUpstart(){
       
        $sql = "SELECT
         `effi_roundup_start`
       FROM
         `mstr_department`
       WHERE location ='2' AND department ='Production' AND `status` = '1'";

        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
     }


     function getHourQty($team,$style,$startTime,$endTime){
    
        $date = date('Y-m-d');

        $sql = "SELECT
        COUNT(plog.id) AS qty
      FROM
        `checking_header_tb` htb
        LEFT JOIN `qc_pass_log` plog
          ON htb.`id` = plog.`chckHeaderId`
      WHERE htb.`lineNo` = '$team'
        AND htb.`style` = '$style' AND DATE(plog.`dateTime`)='$date' AND TIME(plog.`dateTime`) BETWEEN '$startTime' AND '$endTime'";
        
        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
        
    }



    
}