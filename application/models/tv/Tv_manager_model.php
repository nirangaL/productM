<?php

class Tv_manager_model extends CI_model{

    private  $lineNo;
    private $location;

    function __construct()
    {
        parent::__construct();
        $this->load->helper('cookie');
        $this->location = get_cookie('location');
    }


    public function getLineName(){
        $sql= "SELECT `line` FROM `prod_line` WHERE `line_id` = '$this->lineNo'";
        return $this->db->query($sql)->result();
    }

    public function getTeamData($location){
        $sql = "SELECT line_id AS teamId,line AS team,location_id FROM `prod_line` WHERE location_id = '$location'";
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
                    , `day_plan`.`line`
                    , `day_plan`.`timeTemplate`
                    , `day_plan`.`style`
                    , `day_plan`.`scNumber`
                    , `day_plan`.`delivery`
                    , `day_plan`.`orderQty`
                    , `day_plan`.`dayPlanQty`
                    , `day_plan`.`hrs`
                    , `day_plan`.`smv`
                    , `day_plan`.`noOfwokers`
                    , `day_plan`.`forecastEffi` AS efficiency
                    , `day_plan`.`incenEffi`
                    , `day_plan`.`location`
                    , prod_line.`line` AS lineName
                    , `day_plan`.`createDate`
                    ,  `checking_header_tb`.`id`
                    ,(SELECT COUNT(*) AS pass FROM `qc_pass_log` WHERE `chckHeaderId` = `checking_header_tb`.`id` AND DATE(`dateTime`) = '$today'  ) AS actualQty
                      ,(SELECT COUNT(*) FROM `qc_reject_log` WHERE `chckHeaderId` = `checking_header_tb`.`id` AND DATE(`dateTime`) = '$today' ) AS rejectQty
                     ,(SELECT COUNT(*) FROM `qc_remake_log` WHERE `chckHeaderId` = `checking_header_tb`.`id` AND DATE(`dateTime`) = '$today' ) AS remakeQty
                FROM
                    `intranet_db`.`checking_header_tb`
                    INNER JOIN `intranet_db`.`day_plan`
                        ON (`checking_header_tb`.`style` = `day_plan`.`style`) AND (`checking_header_tb`.`deliverNo` = `day_plan`.`delivery`)
                    INNER JOIN `intranet_db`.`checking_grid_tb`
                        ON (`checking_header_tb`.`id` = `checking_grid_tb`.`chckHeaderId`)
                    INNER JOIN `intranet_db`.`prod_line`
                    ON (`checking_header_tb`.`lineNo` = `prod_line`.`line_id`)
                        WHERE day_plan.line = '$lineNo' AND `checking_header_tb`.`lineNo`='$lineNo' AND (day_plan.status ='1' OR day_plan.status ='4') AND DATE(`checking_header_tb`.`dateTime`) = DATE(day_plan.createDate) AND DATE(day_plan.createDate) = '$today' GROUP BY style";

//        echo $sql;exit();

        return $this->db->query($sql)->result();
    }


    public function checkTodayFeedingSPlan(){
        $lineNo = $this->lineNo;
        $today = date('Y-m-d');
        $sql = "SELECT id,style FROM `day_plan` WHERE	line ='$lineNo' AND DATE(`createDate`) = '$today' AND `status` ='4'";

        return $this->db->query($sql)->result();
    }

    public function getLineOutHrly($style,$scNumber,$delivery,$startTime,$endTime){

        $sql = "SELECT
                    `checking_header_tb`.`style`
                    , `checking_header_tb`.`lineNo`
                    , `checking_header_tb`.`scNumber`
                    , `checking_header_tb`.`deliverNo`
                    , `checking_header_tb`.`location`
                    , `qc_pass_log`.`dateTime`
                FROM
                    `intranet_db`.`checking_header_tb`
                    INNER JOIN `intranet_db`.`qc_pass_log`
                        ON (`checking_header_tb`.`id` = `qc_pass_log`.`chckHeaderId`)
                WHERE `checking_header_tb`.`style` = '$style' AND  `checking_header_tb`.`scNumber` ='$scNumber' AND `checking_header_tb`.`deliverNo`='$delivery' AND  `checking_header_tb`.`lineNo` = '$this->lineNo' AND (`qc_pass_log`.`dateTime` BETWEEN '$startTime' AND '$endTime')";

        return $this->db->query($sql)->num_rows();
    }



    public function getTimeRange($lastHour,$timeTemplId){

//        echo $timeTemplId;exit();

        if ($lastHour != 0  ){
            $startHour = (string)$lastHour.'hStart';
            $endHour = (string)$lastHour.'hEnd';
            $sql = "SELECT $startHour AS startTime,$endHour AS endTime FROM `time_template` WHERE id = '$timeTemplId'";
            return $this->db->query($sql)->result();
        }else{
            return '';
        }

    }



    public function setHourlyData(){
        $currentHour = $this->input->post('currentHour');
        $style = $this->input->post('style');
        $orderQty = $this->input->post('orderQty');
        $plannedQtyHr = $this->input->post('plannedQtyHr');
        $lineOutQtyHr = $this->input->post('lineOutQtyHr');
        $behind = $this->input->post('behind');
        $dayPlannedQty = $this->input->post('dayPlannedQty');
        $dayTeamOutQty = $this->input->post('dayTeamOutQty');
        $line = $this->lineNo;
        $location = $this->location;
        $date = date('Y-m-d H:i:s');

        $data = array(
            'style'=>$style,
            'orderQty'=>$orderQty,
            'plannedQtyHr'=>$plannedQtyHr,
            'lineOutQtyHr'=>$lineOutQtyHr,
            'behind'=>$behind,
            'dayPlannedQty'=>$dayPlannedQty,
            'dayTeamOutQty'=>$dayTeamOutQty,
            'lineId'=>$line,
            'locationId'=>$location,
            'dateTime'=>$date,
            'hour'=>$currentHour
        );

        $this->db->trans_start();
        $this->db->insert('hourly_production', $data);
        return $this->db->trans_complete();
    }


    public function getPrevHourProd($startTime,$endTime){
        $sql = "SELECT
                    `checking_header_tb`.`style`
                    , `checking_header_tb`.`lineNo`
                    , `checking_header_tb`.`scNumber`
                    , `checking_header_tb`.`deliverNo`
                    , `checking_header_tb`.`location`
                    , `qc_pass_log`.`dateTime`
                FROM
                    `intranet_db`.`checking_header_tb`
                    INNER JOIN `intranet_db`.`qc_pass_log`
                        ON (`checking_header_tb`.`id` = `qc_pass_log`.`chckHeaderId`)
                WHERE `checking_header_tb`.`lineNo` = '$this->lineNo' AND (`qc_pass_log`.`dateTime` BETWEEN '$startTime' AND '$endTime')";

//        echo $sql;exit();

        return $this->db->query($sql)->num_rows();
    }

    public function checkDayEfficiencySaved($style){
        $date  = date('Y-m-d');
        $sql = "SELECT style,lineId FROM `day_efficiency` WHERE lineId='$this->lineNo' AND style='$style' AND DATE(`dateTime`) = '$date'";

        return $this->db->query($sql)->result();

    }

    public function setDayEfficiency($style,$del,$orderQty,$totalPlanQty,$actualOutQty,$efficiency){
        $data = array(
            'locationId' =>  $this->location,
            'lineId' =>$this->lineNo,
            'style'=> $style,
            'delivery'=>$del,
            'orderQty'=>$orderQty,
            'totalPlanQty'=>$totalPlanQty,
            'actualOutQty'=>$actualOutQty,
            'efficiency'=>$efficiency,
            'dateTime' => date('Y-m-d H:i:s')
        );

        return $this->db->insert('day_efficiency',$data);
    }


    public  function getStyleRunDays($style){
        $line = $this->lineNo;

        // $sql = "SELECT
        //           lineNo,
        //           style,
        //           DATE(`dateTime`) AS lastDate
        //         FROM
        //           `checking_header_tb`
        //         WHERE style = '$style'
        //           AND lineNo = '$line'
        //         GROUP BY DATE(`dateTime`)
        //         ORDER BY DATE(`dateTime`) DESC";

        $sql = "SELECT id,runDaysCount,lastRunDate FROM team_wise_style_rundays WHERE `teamId` = '$line' AND `style`='$style'";

          $result =  $this->db->query($sql)->result();
        // $num_row = $this->db->query($sql)->num_rows();
        //
        // $data = array();
        // if(!empty($result) && !empty($num_row)){
        //     $data = array(
        //         'num_rows' =>$num_row,
        //         'lastRunDate' =>$result[0]->lastDate
        //     );
        // }

        if(!empty($result)){
            $data = array(
                'num_rows' =>(Int)$result[0]->runDaysCount +1,
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

    public function needRuningDaysEffi($runingDays,$smv){
        $sql = "SELECT efficiency,base_amount,incre_percent,incre_amount,reduct_amount FROM incentive_ladderid WHERE smv_start < '$smv' AND smv_end > '$smv' AND days = '$runingDays' AND `locationId` = '$this->location'";
        return $this->db->query($sql)->result();
    }


    public function getTeamWorkingHour($teamId){
        $teamWorkingHour = 0;
        for($i=1;$i<25;$i++){
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

    public function getStyleSizeWiseData($style,$deliv,$team){
        $today = date('Y-m-d');
        $sql = " SELECT
                `style_Info`.`styleNo` AS style
                , `style_Info`.`deliveryNo` AS delivery
                , `style_Info`.`orderQty`
                , `style_Info`.`size` AS defineSize
                , `style_Info`.`qty` AS orderSizeQty
                , `checking_grid_tb`.`size`
                , SUM(`checking_grid_tb`.`passQty` ) AS passQty
                , `checking_header_tb`.`lineNo`
                , `prod_line`.`line` AS lineName
                , location.`location`
            FROM
                `intranet_db`.`checking_header_tb`
                LEFT JOIN `intranet_db`.`style_Info`
                    ON (`style_Info`.`styleNo` = `checking_header_tb`.`style`)
                INNER JOIN `intranet_db`.`checking_grid_tb`
                    ON (`style_Info`.`size` = `checking_grid_tb`.`size`) AND (`checking_header_tb`.`id` = `checking_grid_tb`.`chckHeaderId`)
                INNER JOIN `intranet_db`.`prod_line`
                    ON (`checking_header_tb`.`lineNo` = `prod_line`.`line_id`)
                     INNER JOIN `intranet_db`.`location`
        ON (`prod_line`.`location_id` = `location`.`location_id`)  WHERE style = '$style' AND deliveryNo = '$deliv' AND lineNo = '$team' AND `style_Info`.`qty` != '0' GROUP BY defineSize";

        return $this->db->query($sql)->result();
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

    public function getOtherCloseDayPlan($lineId){
        $today = date('Y-m-d');

        $sql = "SELECT DISTINCT
            day_plan.`line`,
            day_efficiency.`workingHour` AS workedHours
        FROM
            `intranet_db`.`day_plan`
            INNER JOIN `intranet_db`.`day_efficiency`
                ON (`day_plan`.`line` = `day_efficiency`.`lineId`) WHERE `day_plan`.`status` != '4' AND DATE(`day_efficiency`.`dateTime`) = '$today' AND day_plan.`line` = '$lineId';";

        return $this->db->query($sql)->result();
    }


    public function getFeedingHour($lineId){
        $today = date('Y-m-d');
        $sql = "SELECT `feedingHour` FROM `day_plan` WHERE `line` = '$lineId' AND feedingHour != '0' AND DATE(`createDate`) = '$today';";
        return $this->db->query($sql)->result();
    }
}
