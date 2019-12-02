<?php

class Location_dashboard_model extends CI_model{

    private  $lineNo;
    private $location;

    function __construct(){
        parent::__construct();
        // $this->load->helper('cookie');
        $this->location = get_cookie('location');
    }

    public function getLineName(){
        $sql= "SELECT `line` FROM `prod_line` WHERE `line_id` = '$this->lineNo'";
        return $this->db->query($sql)->result();
    }

    public function getTeamData($location){
        $sql = "SELECT line_id AS teamId,line AS team,location_id FROM `prod_line` WHERE location_id = '$location' AND active='1' ORDER BY `line` REGEXP '^[a-z]' DESC,`line`";
        $result  = $this->db->query($sql)->result();
        $num_row  = $this->db->query($sql)->num_rows();
        $data = array(
            'qResult' =>$result,
            'num_rows' =>$num_row,
        );
        return  $data;
    }

    public function getGridData($teamId){
        $lineNo = $teamId;
        $this->lineNo = $teamId;
        $today = date('Y-m-d');

        $sql = "SELECT
		    `day_plan`.`id`
                    , day_plan.status
                    , `day_plan`.`dayPlanType`
                    , `day_plan`.`line`
                    , `prod_line`.`line`
                    , `day_plan`.`timeTemplate`
                    ,`temp_accller_view`.`buyer`
                    , `day_plan`.`style`
                    , `day_plan`.`scNumber`
                    , `day_plan`.`delivery`
                    , `day_plan`.`orderQty`
                    , `day_plan`.`dayPlanQty`
                    , `day_plan`.`hrs`
                    , `day_plan`.`smv`
                    , `day_plan`.`noOfwokers`
                    , `day_plan`.`incentiveHour`
                    , `day_plan`.`forecastEffi` AS efficiency
                    , `day_plan`.`incenEffi`
                    , `day_plan`.`location`
                    , prod_line.`line` AS lineName
                    , `day_plan`.`createDate`
                    ,  IFNULL(`checking_header_tb`.`id`,0) as chckTblHdId
                    ,IFNULL((SELECT COUNT(*) AS pass FROM `qc_pass_log` WHERE `chckHeaderId` = ifnull(`checking_header_tb`.`id`,0) AND DATE(`dateTime`) = '$today'),0) AS actualQty
                      ,IFNULL((SELECT COUNT(*) FROM `qc_reject_log` WHERE `chckHeaderId` = ifnull(`checking_header_tb`.`id`,0) AND DATE(`dateTime`)= '$today' ),0) AS rejectQty
                     ,IFNULL((SELECT COUNT(*) FROM `qc_remake_log` WHERE `chckHeaderId` = ifnull(`checking_header_tb`.`id`,0) AND DATE(`dateTime`) = '$today' ),0) AS remakeQty
                FROM `day_plan`
                LEFT join `checking_header_tb`
                ON ( `day_plan`.`style` =`checking_header_tb`.`style` ) AND ( `day_plan`.`delivery` =`checking_header_tb`.`deliverNo` ) and DATE(day_plan.createDate) = DATE(`checking_header_tb`.`dateTime`) AND `day_plan`.`line` = `checking_header_tb`.`lineNo`
                INNER JOIN `intranet_db`.`prod_line`
                    ON (`day_plan`.`line` = `prod_line`.`line_id`)
                LEFT JOIN `temp_accller_view` ON (`day_plan`.`style` = `temp_accller_view`.`style`)
                        WHERE day_plan.line = '$lineNo' AND day_plan.status IN ( '1','2','4') AND DATE(day_plan.createDate) = '$today' GROUP BY `day_plan`.`delivery` ORDER BY `prod_line`.`line` REGEXP '^[a-z]' DESC,`prod_line`.`line`";

        return $this->db->query($sql)->result();
    }

    public function checkTodayFeedingSPlan(){
        $lineNo = $this->lineNo;
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
        WHERE day_plan.line = '$lineNo'
        AND DATE(`createDate`) = '$today'
        AND `status` = '4'";

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

    public  function getStyleRunDays($style){
        $line = $this->lineNo;
        $sql = "SELECT id,runDaysCount,lastRunDate FROM team_wise_style_rundays WHERE `teamId` = '$line' AND `style`='$style'";

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

    public function needRuningDaysEffi($runingDays,$smv,$location){
        $sql = "SELECT efficiency,base_amount,incre_percent,incre_amount,decre_percent,reduct_amount FROM incentive_ladderid WHERE smv_start <= '$smv' AND smv_end > '$smv' AND days = '$runingDays' AND `locationId` = '$location'";
        return $this->db->query($sql)->result();
    }

    public function getTeamWorkingHour($teamId,$hrs){
        $teamWorkingHour = 0;
        for($i=1;$i<=$hrs;$i++){
            $startHour = (string)$i.'hStart';
            $endHour = (string)$i.'hEnd';
            $sql = "SELECT $startHour AS startTime,$endHour AS endTime FROM `team_time` WHERE lineId = '$teamId'";

            $result = $this->db->query($sql)->result();

            if($result){
                if($result[0]->startTime !='00:00:00' && $result[0]->endTime !='00:00:00'  ){
                    $teamWorkingHour = $i;
                }else{
                    break;
                }
            }
        }
        return $teamWorkingHour;
    }

    public function getRoundUpstart($team){
        $sql = "SELECT
                `department`.`roundup_start`
            FROM
                `intranet_db`.`prod_line`
                INNER JOIN `intranet_db`.`department`
                    ON (`prod_line`.`line_id` = `department`.`team`) AND (`prod_line`.`location_id` = `department`.`location`) WHERE team = '$team'";

        return $this->db->query($sql)->result();
    }

    public function getQrLevel($location){
        $sql = "SELECT qr_level FROM `qr_level` WHERE location_id = '$location'";
        return $this->db->query($sql)->result();
    }

    public function getOtherCloseDayPlan($lineId,$dayPlanId){
        $today = date('Y-m-d');

        $sql = "SELECT DISTINCT
                  `line`,
                  `hrs` AS workedHours
                FROM
                  `day_plan`
                WHERE `dayPlanType` != '2' AND `status` != '3'
                  AND DATE(`createDate`) = '$today'
                  AND `line` = '$lineId'
                  AND `id` != '$dayPlanId'";

        return $this->db->query($sql)->result();
    }

    public function getFeedingHour($lineId){
        $today = date('Y-m-d');
        $sql = "SELECT `feedingHour` FROM `day_plan` WHERE `line` = '$lineId' AND `day_plan`.`dayPlanType` = '2' AND feedingHour != '0' AND DATE(`createDate`) = '$today'";
        return $this->db->query($sql)->result();
    }

    public function getWorkerCount($teamId){
        $today = date('Y-m-d');
        $sql = "SELECT
                 COALESCE(SUM(`headCount`),0) AS workers,
                 `prod_line`.`line`
                FROM
                  `worker_in_team`
                  INNER JOIN `prod_line` ON `worker_in_team`.`teamId`  = `prod_line`.`line_id`
                WHERE `teamId` = '$teamId'
                  AND DATE(`workerInTime`) = '$today'
                  AND `workerOut` = '0' GROUP BY teamId";

        return $this->db->query($sql)->result();
    }

    public function getMinutForHour($location,$dep){

      $sql = "SELECT
      minuuteForHour
      FROM
      mstr_department
      WHERE location = '$location'
      AND department = '$dep'";

      return $this->db->query($sql)->result();

    }

    public function getBaseEffi($smv,$location){

      $sql = "SELECT
      `start_smv`,
      `end_smv`,
      `base_line_amount`,
      `delete_ID`
      FROM
      `intranet_db`.`day_plan_eff_baseamout` WHERE start_smv < '$smv' AND end_smv >= '$smv' AND locationId='$location'";
      return $this->db->query($sql)->result();
    }

    public function getBaseAmountAndDayBaseAmount($smv,$eff,$location){

      $sql = "SELECT
              `id`,
              `locationId`,
              `smv_start`,
              `smv_end`,
              `days`,
              `efficiency`,
              `base_amount`
            FROM
             `incentive_ladderid` WHERE smv_start < '$smv' AND smv_end >= '$smv' AND locationId='$location' AND efficiency='$eff'";
      return $this->db->query($sql)->result();
    }

    public function getMonthlyEffi($minuteForHour,$locationId){

      $date = date('Y-m-d');

      $sql = "CALL getDateWiseFactEffi($minuteForHour,$locationId);";
            //add this two line
        $query = $this->db->query($sql);
        $res = $query->result();

        $query->next_result();
        $query->free_result();
        //end of new code
        return $res;

    }


}
