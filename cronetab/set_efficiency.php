<?php
date_default_timezone_set("Asia/colombo");
$servername = "192.168.1.211";
$username = "root";
$password = "20@Oa#15";
$db = 'intranet_db';

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$result = getProductionTeam($conn);

if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        getEfficiency($row["line_id"], $row["location"], $conn);
    }
    mysqli_close($conn);
} else {
    echo "0 results";
    mysqli_close($conn);

}

// echo error_reporting(E_ALL);

function getEfficiency($lineNo,$location, $conn){

  $result = getProductionData($lineNo, $conn);
  while($row = mysqli_fetch_assoc($result)){

  if ($row["dayPlanId"] != '') {
    // $getTime = mysqli_fetch_assoc(getTimeRange($row["hrs"], $row["timeTemplate"], $conn));
    // $endTime = date('H:i', strtotime($getTime['endTime']."+30 minutes"));

    // echo $endTime .'</br>';

    // if(strtotime($endTime) == strtotime(date('H:i'))){

      $workingHours = $row['hrs'];
      $noOfwokers = $row['noOfwokers'];

      $minutForHour = (double)getMinutForHour($conn,$row['location']);
      $workingMin =  $workingHours * $minutForHour;
      $poduceMin = $row['actualQty'] * (double)$row['smv'];
      $totalUseMuni = ((double)$noOfwokers * $workingMin);
      $efficiency = (double)($poduceMin / $totalUseMuni) * 100;
      $efficiency = (number_format((float)$efficiency, 2, '.', ''));

      $dayPlanType = $row['dayPlanType'];
      $locationId = $row['location'];
      $lineId = $row['line'];
      $dayPlanId = $row['dayPlanId'];
      $timeTemplId = $row['timeTemplate'];
      $style = $row['style'];
      $runDay = $row['runningDay'];
      $totalPlanQty = $row['dayPlanQty'];
      $actualOutQty = $row['actualQty'];
      $efficiency = $efficiency;
      $dateTime = date('Y-m-d H:i:s');
      // $dateTime =  date('Y-m-d  H:i:s',strtotime("-1 days"));;
      $lineName = $row['lineName'];
      $smv = $row['smv'];
      $incenEffi = $row['incenEffi'];
      $rejectQty = $row['rejectQty'];
      $ince_hour = $row['incentiveHour'];

      $qrLevel = getQrLevel($locationId,$conn);
      $qrLevel = mysqli_fetch_assoc($qrLevel);
      $qrLevel = $qrLevel['qr_level'];

      $actualQrLevel = (($actualOutQty/($actualOutQty + $rejectQty))*100);
      $actualQrLevel  =  (number_format((float)$actualQrLevel, 2, '.', ''));

      $incentiveData = getTargetEffi($style, $smv,$lineId,$locationId,$incenEffi,$conn);
      $incentiveData =  mysqli_fetch_assoc($incentiveData);

      $targetEfficiency = $incenEffi;
      $currentEfficiency = $efficiency;
      $baseAmount = $incentiveData['base_amount'];
      $increPrecent = $incentiveData['incre_percent'];
      $increAmount = $incentiveData['incre_amount'];
      $reductAmount = $incentiveData['reduct_amount'];

      if($qrLevel <= $actualQrLevel && $incenEffi != 0){
        $incentive = getIncentive($currentEfficiency, $targetEfficiency, $baseAmount, $increPrecent, $increAmount, $reductAmount,$lineNo,$conn);
          if($ince_hour!=0){
            $incentive = ($incentive/($ince_hour*$minutForHour)) * ($workingHours*$minutForHour);
          }
      }else{
        $incentive = 0;
      }

       setLastRunDay($lineId,$style,$hrs,$conn);


      $sql = "INSERT INTO `intranet_db`.`day_efficiency` (
        `locationId`,
        `lineId`,
        `dayPlanId`,
        `timeTemplate`,
        `style`,
        `smv`,
        `runDay`,
        `totalPlanQty`,
        `actualOutQty`,
        `workersCount`,
        `workingHour`,
        `efficiency`,
        `incentive`,
        `qr_level`,
        `dateTime`
      )
      VALUES
      (
        '$locationId',
        '$lineId',
        '$dayPlanId',
        '$timeTemplId',
        '$style',
        '$smv',
        '$runDay',
        '$totalPlanQty',
        '$actualOutQty',
        '$noOfwokers',
        '$workingHours',
        '$efficiency',
        '$incentive',
        '$actualQrLevel',
        '$dateTime'
        -- '2019-11-15'
      )";

      setHourlyData($dayPlanId,$dayPlanType,$lineId,$style,$smv,$workingHours,$minutForHour,$noOfwokers,$timeTemplId,$conn);

      // echo "<pre>";
      // echo $sql;
      // echo "</pre>";

      if (mysqli_query($conn, $sql)) {
        echo "Location ".$location." - Line Number ".$lineName.":  Efficiency successfully saved! </br>";
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }

  } else {
    return false;
  }

  }

}

function getProductionTeam($conn){

    $sql = "SELECT
                  `prod_line`.line_id,
                  `prod_line`.line,
                  `prod_line`.location_id,
                  `location`.`location`
                FROM
                  `prod_line`
                  LEFT JOIN `location`
                    ON `prod_line`.`location_id` = `location`.`location_id`
                WHERE `prod_line`.active = '1' ORDER BY `prod_line`.`line` REGEXP '^[a-z]' DESC,`prod_line`.`line`";

    $result = mysqli_query($conn, $sql);

    return $result;
}

function getProductionData($lineNo, $conn){
      ////// ***** save preives day efficiency  ****** ///////
    // $today = date('Y-m-d',strtotime("-1 days"));

    $today = date('Y-m-d');
    // $today= '2019-11-15';



    $sql = "SELECT
            		    `day_plan`.`id` as dayPlanId
                    , day_plan.status
                    , `day_plan`.`dayPlanType`
                    , `day_plan`.`line`
                    , `day_plan`.`timeTemplate`
                    ,`temp_accller_view`.`buyer`
                    , `day_plan`.`style`
                    , `day_plan`.`scNumber`
                    , `day_plan`.`runningDay`
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
                LEFT JOIN `checking_header_tb`
			             ON ( `day_plan`.`style` =`checking_header_tb`.`style` ) AND DATE(day_plan.createDate) = DATE(`checking_header_tb`.`dateTime`) AND `day_plan`.`line` = `checking_header_tb`.`lineNo`
                INNER JOIN `intranet_db`.`prod_line`
                    ON (`day_plan`.`line` = `prod_line`.`line_id`)
                LEFT JOIN `temp_accller_view` ON (`day_plan`.`style` = `temp_accller_view`.`style`)
                        WHERE day_plan.line = '$lineNo' AND day_plan.status IN ( '1','2','4') AND DATE(day_plan.createDate) = '$today' GROUP BY style";


    $result = mysqli_query($conn, $sql);

    return $result;
}

function getTimeRange($lastHour, $timeTemplId, $conn){
    if ($lastHour != 0) {
        $startHour = (string)$lastHour . 'hStart';
        $endHour = (string)$lastHour . 'hEnd';
        $sql = "SELECT $startHour AS startTime,$endHour AS endTime FROM `time_template` WHERE id = '$timeTemplId'";
        $result = mysqli_query($conn, $sql);
        return $result;
    } else {
        return '';
    }
}

///// Get planned Efficiency //////
function getTargetEffi($style,$smv,$lineNo,$location,$incenEffi,$conn){
    $styleRunDays  = getStyleRunDays($style,$lineNo,$conn);
    $needEff = needRuningDaysEffi( $styleRunDays,$smv,$location,$conn);

    return $needEff;
}

function getIncentive($currentEfficiency,$targetEfficiency,$baseAmount,$increPrecent,$increAmount,$reductAmount,$team,$conn){
    $incentive = 0;

    $result = getRoundUpstart($team,$conn);
    $row = mysqli_fetch_assoc($result);

    $roundDownEffi = floor($currentEfficiency);
    $roundUpStartNu = $row['roundup_start'];
    $checkingValue = $roundDownEffi + $roundUpStartNu;
    $decimalValue = (double)$currentEfficiency - $roundDownEffi;

    if ((($targetEfficiency - 1) + $roundUpStartNu) <= $currentEfficiency) {
        $incentive = $baseAmount;

        if($decimalValue>=$roundUpStartNu){
            $currentEfficiency = $roundDownEffi + 1;
        }else{
            $currentEfficiency = $roundDownEffi;
        }
        $incrementPrecDiff = $currentEfficiency - (int)$targetEfficiency;

        if($incrementPrecDiff > 0){
            if($increPrecent != 0){
                $incrementIncentive = (round(($incrementPrecDiff/$increPrecent), 0, PHP_ROUND_HALF_DOWN))  * $increAmount;
                $incentive += $incrementIncentive;
            }
        }
    }else{
        $reductPrecDiff = (double)$targetEfficiency - (double) $currentEfficiency;
        if($increPrecent != 0){
            $incrementIncentive = (round(($reductPrecDiff / $increPrecent), 0, PHP_ROUND_HALF_DOWN)) * $reductAmount;
            $incentive -= $incrementIncentive;

            if ($incentive < 0) {
                $incentive = 0;
            }
        }
    }
    return $incentive;
}

function getStyleRunDays($style,$line,$conn){

    $sql = "SELECT id,runDaysCount,lastRunDate FROM team_wise_style_rundays WHERE `teamId` = '$line' AND `style`='$style'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $getLastRunDay = (Int)$row['runDaysCount'] + 1;
    }else{
      $getLastRunDay = '1';
    }

    return $getLastRunDay;

}

function needRuningDaysEffi($runingDays,$smv,$location,$conn){
    $sql = "SELECT efficiency,base_amount,incre_percent,incre_amount,reduct_amount FROM incentive_ladderid WHERE smv_start <= '$smv' AND smv_end > '$smv' AND days = '$runingDays' AND `locationId` = '$location'";
    return  mysqli_query($conn, $sql);

}

function getRoundUpstart($team,$conn){
    $sql = "SELECT
                `department`.`roundup_start`
            FROM
                `intranet_db`.`prod_line`
                INNER JOIN `intranet_db`.`department`
                    ON (`prod_line`.`line_id` = `department`.`team`) AND (`prod_line`.`location_id` = `department`.`location`) WHERE team = '$team'";
    return mysqli_query($conn, $sql);
}

function getQrLevel($location,$conn){
    $sql = "SELECT qr_level FROM `qr_level` WHERE location_id = '$location';";
    return mysqli_query($conn, $sql);
}

function setLastRunDay($team,$style,$hrs,$conn){
  $runDay ='';
  $sql = "SELECT id,runDaysCount FROM team_wise_style_rundays WHERE `teamId` = '$team' AND `style`='$style'";
  $result =  mysqli_query($conn, $sql);

  $id='';
  $getLastRunDay = 0;

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $getLastRunDay = (Int)$row['runDaysCount'] + 1;
    $id = $row['id'];
  }else{
    $getLastRunDay = 'noCreated';
  }

  $date = date('Y-m-d');

  if($getLastRunDay!='noCreated'){
    $runDay = (Int)$getLastRunDay;

    $sql2 = "UPDATE
    `intranet_db`.`team_wise_style_rundays`
    SET
    `runDaysCount` = '$runDay',
    `lastRunDate` = '$date'
    WHERE `id` = '$id'";

  } else {
    if ($hrs >= 5){
      $runDay = 1;
    }else{
      $runDay = 0;
    }

    $sql2 = "INSERT INTO `intranet_db`.`team_wise_style_rundays` (
      `teamId`,
      `style`,
      `runDaysCount`,
      `lastRunDate`
    )
    VALUES
    (
      '$team',
      '$style',
      '$runDay',
      '$date'
    )";
  }

  mysqli_query($conn,$sql2);

  // return $runDay;
}

function getMinutForHour($conn,$location){

  // echo $location;

  $sql = "SELECT
  `minuuteForHour`
  FROM
  `mstr_department`
  WHERE `location` = '$location'
  AND `department` = 'Production'";

    $result = mysqli_query($conn,$sql);
    $result = mysqli_fetch_assoc($result);
    if($result){
      return $result['minuuteForHour'];
    }else{
      echo 'error in getMinutForHour function';
    }

    // print_r $result;exit();

    // return $result['minuuteForHour'];
}

////// set Hourly Data
function setHourlyData($dayPlanId,$dayPlanType,$team,$style,$smv,$workingHours,$minutForHour,$noOfwokers,$timeTemplId,$conn){

    $date = date('Y-m-d');
    $newStyleStartHour = 1;
    $decimalMin = 0;

    $otherDayPlan = getOtherRunDayPlan($team,$dayPlanId,$conn);
    $otherDayPlan = mysqli_fetch_assoc($otherDayPlan);

    if(!empty($otherDayPlan) && $dayPlanType != 4){
      $workedHours = $otherDayPlan['workedHours'];
      $workedHourDecimal =  $workedHours - floor($workedHours);

      if($workedHourDecimal !=0){
          $newStyleStartHour = floor($workedHours);
      }else{
          $newStyleStartHour = $workedHours + 1;
      }

    }else if($decimalMin != 0){
      $workingHours = ceil($workingHours);
    }

    // echo $newStyleStartHour;

    $sql = "INSERT INTO `intranet_db`.`produc_hourly_progress` (
          `teamId`,
          `style`,
          `timeTemplateId`,
          `hour`,
          `qty`,
          `effi`,
          `date`
        )VALUES";

    for ($i = $newStyleStartHour; $i <= $workingHours; $i++) {
           $producedMin = 0;
           $usedMin = 0;
           $startTime ='';
           $endTime='';

           // echo $i .'<br>';

          // $timeRange = mysqli_fetch_assoc(getTimeRange($i,$timeTemplId,$conn));

          $timeRange = getTimeRange($i,$timeTemplId,$conn);
          while ($row = mysqli_fetch_assoc($timeRange)) {
              $startTime = $row['startTime'];
              $endTime = $row['endTime'];
          }

          // echo $startTime.' '.$endTime;


        if($i == $workingHours ){
            $outQty = mysqli_fetch_assoc(getHourQty($team,$style,$startTime,'23:00:00',$conn));
        }else{
            $outQty = mysqli_fetch_assoc(getHourQty($team,$style,$startTime,$endTime,$conn));
        }

        $producedMin = ((int)$outQty['qty']) * $smv;
        $usedMin = $noOfwokers *$minutForHour;
        $efficiency = number_format((float)(($producedMin/$usedMin) * 100), 2, '.', '');

        $qty = (int)$outQty['qty'];

        $sql .= "(
                '$team',
                '$style',
                '$timeTemplId',
                '$i',
                '$qty',
                '$efficiency',
                '$date'
              ),";

    }



    $sql = mb_substr($sql, 0, -1);

    //
    if (mysqli_query($conn,$sql)) {
      // echo "Location ".$location." - Line Number ".$lineName.":  Efficiency successfully saved! </br>";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

}

function getOtherRunDayPlan($team,$dayPlanId){
        $date = date('Y-m-d');
        $sql = "SELECT DISTINCT
                  `line`,
                  `hrs` AS workedHours
                FROM
                  `day_plan`
                WHERE `dayPlanType` != '2' AND `status` != '3'
                  AND DATE(`createDate`) = '$date'
                  AND `line` = '$team'
                  AND `id` != '$dayPlanId'";

  return  mysqli_query($conn, $sql);
}



function getHourQty($team,$style,$startTime,$endTime,$conn){

        $date = date('Y-m-d');

        $sql = "SELECT
        COUNT(plog.id) AS qty
      FROM
        `checking_header_tb` htb
        LEFT JOIN `qc_pass_log` plog
          ON htb.`id` = plog.`chckHeaderId`
      WHERE htb.`lineNo` = '$team'
        AND htb.`style` = '$style' AND DATE(plog.`dateTime`)='$date' AND TIME(plog.`dateTime`) BETWEEN '$startTime' AND '$endTime'";

            // echo $sql;
            // echo '<br>';

           return  mysqli_query($conn, $sql);
    }


?>
