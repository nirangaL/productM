<?php
error_reporting(E_ALL);
ini_set('display_errors',1);


date_default_timezone_set("Asia/colombo");
// require_once ("class/DBController.php");
require_once ("class/Main_Dashboard.php");


$dashboardData  = new Main_Dashboard();
$minuteForHour =  $dashboardData->getMinuteForHour();

// echo $minuteForHour;

$teams = $dashboardData->getTeams();

// print_r($teams);

$teamsSize = sizeof($teams);

for($i=0;$i<$teamsSize;$i++){
  $teamsData = $dashboardData->getDayPlanAndQcData($teams[$i]['teamId']);

//   echo '<pre>';
//   print_r($teamsData);


  $teamTotUsedMin  = 0;
  $teamTotProdMinTeam = 0;
  $totWorkers  = 0;
  $teamOutQtyHour = 0;

  $dayPlanSize = sizeof($teamsData);
  for($x=0;$x<$dayPlanSize;$x++){

    $teamId = $teamsData[$x]['line'];
    $hours  = $teamsData[$x]['hrs'];
    $dayPlanId = $teamsData[$x]['dayPlanId'];
    $dayPlanType = $teamsData[$x]['dayPlanType'];
    $timeTemplate = $teamsData[$x]['timeTemplate'];
    $style = $teamsData[$x]['style'];
    $smv = $teamsData[$x]['smv'];
    $styleRunningDay = $teamsData[$x]['runningDay'];
    $incentiveEffi = $teamsData[$x]['incenEffi'];
    $noOfwokers = $teamsData[$x]['noOfwokers'];
    $incentiveHour = $teamsData[$x]['incentiveHour'];

    if($dayPlanId == '4'){
        $dayPlanQty += $teamsData[$x]['dayPlanQty'];
        $passQty += $teamsData[$x]['passQty'];
        $defectQty += $teamsData[$x]['defectQty'];
        $remakeQty += $teamsData[$x]['remakeQty'];
    }else{
        $dayPlanQty = $teamsData[$x]['dayPlanQty'];
        $passQty = $teamsData[$x]['passQty'];
        $defectQty = $teamsData[$x]['defectQty'];
        $remakeQty = $teamsData[$x]['remakeQty'];
    }

    $currentHour  = 1;

    
    $getTime = getTeamTime($dashboardData,$teamId,$hours,$dayPlanId,$dayPlanType,$timeTemplate);
    if(array_key_exists('productHourForStyle',$getTime[0])){
        // print_r($getTime); 
        ////this is second or theird day plan current hour ///
        $currentHour = $getTime[0]['productHourForStyle']; 
    }else{
        $currentHour = $getTime[0]['currentHour'];
    }
    $hourStartTime = $getTime[0]['startTime'];
    $hoursEndTime = $getTime[0]['endTime'];
    $startDateTime = date('Y-m-d') . ' ' . $getTime[0]['startTime'];
    $endDateTime = date('Y-m-d') . ' ' . $getTime[0]['endTime'];
    $currentTime = date('H:i:s');


    if($dayPlanType  == "4"){
        $teamOutQty = $teamOutQty + (int)$dashboardData->getPassQtyForTimeRange($startDateTime, $endDateTime, $style, $teamId);
    }else{
        $teamOutQty = $dashboardData->getPassQtyForTimeRange($startDateTime, $endDateTime, $style,$teamId);
    }

    $prePrInfp = getPrevHourProd($dashboardData,$getTime[0]['currentHour'],$hours,$style,$teamId, $dayPlanId,$timeTemplate);
    $preHour = $prePrInfp['hour'];
    if($dayPlanId == "4"){
        $preHourPassQty += (INT)$prePrInfp['prodOut'];
    }else{
        $preHourPassQty = $prePrInfp['prodOut'];
    }

    $finalHourMin = get_time_difference($hourStartTime,$currentTime) * $minuteForHour;
    $workingMin = ($prePrInfp['hour'] *$minuteForHour) + $finalHourMin;

    $plannedQtyHrs = (Int)($dayPlanQty/$hours);

    // echo $plannedQtyHrs .'<br>';
    // Current time GAP
    $timeGapfromStartTime = get_time_difference($hourStartTime,$currentTime) * $minuteForHour;
    /// check the line up down status  /////
    $timeFramePerMin = get_time_difference($hourStartTime,$hoursEndTime) * $minuteForHour;
   
    // One Pcs sawing time
    $perPcsMinits = $timeFramePerMin / $plannedQtyHrs;
    /// actual ne Pcs sawing time within current progress ////
    $planPerPcsForMin = $timeGapfromStartTime / $perPcsMinits;
    //// Line status /////
    if ($planPerPcsForMin <= $teamOutQty) {
        $statusTeamTv = 'up';
    } else if ($planPerPcsForMin > $teamOutQty) {
        $statusTeamTv = 'down';
    } else {
        $statusTeamTv = 'unknown';
    }


    //// Line status /////
    $styleDayPlanQty = (int)$teamsData[$x]['dayPlanQty'];
    $neededQtyAtTime = getNeededQtyAtTime($hours,$workingMin,$dayPlanQty);
     $styleNeedQty = getNeededQtyAtTime($hours,$workingMin,$styleDayPlanQty);

    if ($neededQtyAtTime > $dayPlanQty) {
        $neededQtyAtTime = $dayPlanQty;
    }

    if ($styleNeedQty > $styleDayPlanQty) {
        $styleNeedQty = $styleDayPlanQty;
    }

    if ($passQty >= $dayPlanQty) {
        $status = 'up';
    } else if ($passQty < $dayPlanQty) {
        $status = 'down';
    } else {
        $status = 'unknown';
    }


    ///// data to calculate incentive /////
    $needEff = getTargetEffi($dashboardData,$smv,$styleRunningDay);
    if ($needEff != '') {
        $baseAmount = $needEff[0]['base_amount'];
        $increPrecent = $needEff[0]['incre_percent'];
        $increAmount = $needEff[0]['incre_amount'];
        $reductPrecent = $needEff[0]['decre_percent'];
        $reductAmount = $needEff[0]['reduct_amount'];
    } else {
        $baseAmount = 0;
        $increPrecent = 0;
        $increAmount = 0;
        $reductPrecent = 0;
        $reductAmount = 0;
    }

    $lineAndStyleEffi = getEfficiency($workingMin,$passQty,$smv,$noOfwokers);

    // echo '<pre>';
    // print_r($lineAndStyleEffi);

    $efficiency = $lineAndStyleEffi['lineEffi'];
    $styleEffi = $lineAndStyleEffi['styleEff'];
    $actulaOutQty = 0;
    if ($passQty == 0) {
        $actulaOutQty = 1;
    } else {
        $actulaOutQty = $passQty;
    }

    $qrLevelNeed = getQrLevel($dashboardData);
    $actualQrLevel = calculateQrLevel($actulaOutQty, $defectQty);
    if($actualQrLevel >= 100){
        $actualQrLevel = 100;
    }else{
        $actualQrLevel = number_format((float) $actualQrLevel, 2, '.', '');
    }
    if ($qrLevelNeed <= $actualQrLevel && $incentiveEffi != 0) {

        $incentive = getIncentive($dashboardData,$styleEffi,$incentiveEffi,$baseAmount, $increPrecent, $increAmount, $reductPrecent, $reductAmount, $teamId, $smv, $styleRunningDay);
        
        if ($incentiveHour != 0) {
            $incentive = ($incentive / ($incentiveHour *  $minuteForHour)) * ($hours *  $minuteForHour);
        }
    } else {
        $incentive = 0;
    }

    
    $data['teamData'][$x] = array(
        'line' => $teamId,
        'lineName' => $teams[$i]['team'],
        'dayPlanType' => $dayPlanType,
        'runStatus' => $teamsData[$x]['status'],
        'buyer' => $teamsData[$x]['buyer'],
        'style' => $style,
        'smv' => $smv,
        'dayPlanQty' => $dayPlanQty,
        'hrs' => $hours,
        'currentHr' => $currentHour,
        'totalPassQty' => $passQty,
        'stylePassQty' => $teamsData[$x]['passQty'],
        'needOutQtyHr'=> $plannedQtyHrs,
        'teamHrsOutQty' => $teamOutQty,
        'preHour' => $preHour,
        'preHourPassQty' => $preHourPassQty,
        'statusTeamTv'=>$statusTeamTv,
        'statusProDashboard' => $status,
        'ForEff' => $teamsData[$x]['forecastEffi'],
        'actEff' => number_format((float) $efficiency, 2, '.', ''),
        'styleEffi'=>number_format((float) $styleEffi, 2, '.', ''),
        'rejectQty' => (int)($defectQty -$remakeQty),
        'remakeQty' => $remakeQty,
        'needQrLvl' => $qrLevelNeed,
        'actualQrLevel' => $actualQrLevel,
        'incentive' => intval($incentive),
        'styleRunDays' => $styleRunningDay,
        'showRunningDay' => $teamsData[$x]['showRunningDay'],
        'noOfwokers' => $noOfwokers,
        'neededQtyAtTime' => intval($neededQtyAtTime),
        'minuteForHour' => $minuteForHour,
        'timeForTimeCountDown' => date('M j, Y') . ' ' . $hoursEndTime,
        'hourStartTime' => $hourStartTime,
        'teamProduceMin' =>($passQty * (double) $smv),
        'teamUsedMin' =>  $noOfwokers * $workingMin,
        'toalEff'=> number_format((float) (( $passQty * (double) $smv)/ ($noOfwokers * $workingMin))*100, 2, '.', ''),
        'styleDayPlanQty'=> $teamsData[$x]['dayPlanQty'],
        'styleNeedQty'=> intval($styleNeedQty),
        'allDefectQty'=> $teamsData[$x]['allDefectQty'],
        'defectQty'=> $teamsData[$x]['defectQty'],
    );
    
    $data['hourlyData'][$x] = getHourlyOut($dashboardData,$teamId,$style,$hours,$smv,$noOfwokers,$dayPlanId,$dayPlanType,$timeTemplate);

    // echo '<pre>';
    // print_r($data['hourlyData'][$x]);

    if(!empty($data)){
        echo json_encode($data);
    }else{
        echo 'no any day plan';
    }
  


  }////DayPlanForLoop

 
} //// TeamsforLoop

function getTeamTime($dashboardData,$teamId,$maxHrs,$dayPlanId,$dayPlanType,$timeTemplId){
    $currentTime = date('H:i:s');
    $workedHours = 0;
    $newStyleStartHour = 1;

    ///// warning ---- This function not working properly if there are two feeding dayplan //////////
    $otherDayPlan = $dashboardData->getOtherDayPlan($teamId,$dayPlanId);

    $decimalMin = 0;
    $roundDownHour = floor($maxHrs);

    $decimalMin = $maxHrs - $roundDownHour;

    if (!empty($otherDayPlan) && $dayPlanType != 4) {
        $workedHours = $otherDayPlan[0]->workedHours;
        $workedHourDecimal =  $workedHours - floor($workedHours);
        if($workedHourDecimal !=0){
            if($decimalMin != 0){     
                $result =  getTeamTimeForDecimalValue($dashboardData,$roundDownHour,$maxHrs,$timeTemplId,'reduceFromUpperHour');    
            }else{
                $result = getTeamTimeForDecimalValue($dashboardData,$roundDownHour,$maxHrs,$timeTemplId,'addToRoundDownHour');
            }
            $newStyleStartHour =ceil($workedHours);
        }else{
            $newStyleStartHour = $roundDownHour + 1;
        }


        $totalHour = $maxHrs + $workedHours;
        $cHour = 0;
       
        
        for ($i = $newStyleStartHour; $i <= $totalHour; $i++) {
            $cHour = $cHour + 1;
            ////// Hour with decimal point ///// ex:5.5h ///////
            $result =  $dashboardData->getTimeRange($i, $timeTemplId);

            if (!empty($result)) {
                if (strtotime($currentTime) > strtotime($result[0]['startTime']) && strtotime($currentTime) < strtotime($result[0]['endTime'])) {
                    $result[0]['currentHour']  = new stdClass();
                    $result[0]['currentHour']  = $cHour;
                    $result[0]['productHourForStyle'] = new stdClass();
                    $result[0]['productHourForStyle'] = $i;
                break;
                }else if((strtotime($currentTime) > strtotime($result[0]['endTime']))){
                    $result[0]['currentHour'] = new stdClass();
                    $result[0]['currentHour'] = $totalHour;
                } 
            }
        }

    } else {
        $newStyleStartHour = 1;
        $cHour = 0;
        // echo $maxHrs.'max ';

        for ($i = 1; $i <= $maxHrs; $i++) {
            $cHour = $cHour + 1;
        
            ////// Hour with decimal point ///// ex:5.5h ///////
            $result =  $dashboardData->getTimeRange($i, $timeTemplId);
            if (!empty($result)) {
                if (strtotime($currentTime) > strtotime($result[0]['startTime']) && strtotime($currentTime) < strtotime($result[0]['endTime'])) {
                    $result[0]['currentHour'] = new stdClass();
                    $result[0]['currentHour'] = $cHour;
                break;
                }else{
                    $result[0]['currentHour'] = new stdClass();
                    $result[0]['currentHour'] = $maxHrs;
                }
            } else {
                if ($decimalMin != 0) {
                    if (($i + $decimalMin) == $maxHrs) {
                        $result = getTeamTimeForDecimalValue($dashboardData,$roundDownHour,$maxHrs,$timeTemplId,'addToRoundDownHour');
                    }
                }
            }
        }
       
    }

    return $result;

}

///// if last hour have decimal value //////////
function getTeamTimeForDecimalValue($dashboardData,$roundDownHour,$maxHrs,$timeTemplId,$toDo){
   
    $decimal = $maxHrs - $roundDownHour;
    $currentTime = date('H:i:s');
    $min =   $GLOBALS['minuteForHour'] * ($maxHrs-$roundDownHour);
   
    $result = $dashboardData->getTimeRange($roundDownHour, $timeTemplId);
    $data = array();
    if (!empty($result)) {
        if (strtotime($currentTime) > strtotime($result[0]['startTime']) && strtotime($currentTime) < strtotime($result[0]['endTime'])) {

            if($toDo == 'addToRoundDownHour'){
                $min = '+' . $min . ' minutes';
                $data[0]['startTime']= new stdClass();
                $data[0]['startTime'] = $result[0]['endTime'];
                $data[0]['endTime'] = new stdClass();
                $data[0]['endTime'] = date("H:i:s", strtotime($min, strtotime($result[0]['endTime'])));
                $data[0]['currentHour'] = new stdClass();
                $data[0]['currentHour'] = $roundDownHour + $decimal;
            }else if($toDo == 'reduceFromUpperHour'){
                $min = '-' . $min . ' minutes';
                $data[0]['startTime'] = new stdClass();
                $data[0]['startTime'] = date("H:i:s", strtotime($min, strtotime($result[0]['startTime'])));
                $data[0]['endTime']= new stdClass();
                $data[0]['endTime'] = $result[0]['startTime'];
                $data[0]['currentHour'] = new stdClass();
                $data[0]['currentHour'] = $roundDownHour + $decimal;
            }
          
            return $data;
        }
    }
}


  ////// Get the time differences in hours /////
function get_time_difference($time1, $time2){
    $time1 = strtotime("1/1/1980 $time1");
    $time2 = strtotime("1/1/1980 $time2");
    if ($time2 < $time1) {
        $time2 = $time2 + 86400;
    }
    $totoalMin = ($time2 - $time1) / 3600;
      ////// When user add the lunch time and T time to TEAM TIME//// we get only 1hour ////////
    if ($totoalMin > 1) {
        $totoalMin = 1;
    }
    return $totoalMin;
}


function getPrevHourProd($dashboardData,$currentHour,$planHour,$style,$team,$dayPlanId,$timeTemplate){
   
    $preHour = 0;
    $decimalMin = 0;
    $startDateTime = "";
    $endDateTime = "";

    $otherDayPlan = $dashboardData->getOtherDayPlan($team,$dayPlanId);
    if (!empty($otherDayPlan)) {
        $planHour = $planHour + $otherDayPlan[0]->workedHours;
    }

    if ($currentHour < $planHour) {
        $roundDownHour = floor($currentHour);
        $decimalMin = $currentHour - $roundDownHour;
        if ($decimalMin != 0) {
            $preHour = $roundDownHour;
        } else {
            $preHour = $currentHour - 1;
        }

        ////// Get Team Time ////////////////////An importnet part ///////
        $getTime = $dashboardData->getTimeRange($preHour, $timeTemplate);

        if (!empty($getTime)) {
            $startDateTime = date('Y-m-d') . ' ' . $getTime[0]['startTime'];
            $endDateTime = date('Y-m-d') . ' ' . $getTime[0]['endTime'];
            $preHour = $currentHour - 1;
        }

        if ($preHour < 0) {
            $preHour = 0;
        }

    } else {
        $roundDownHour = floor($planHour);
        $decimalMin = $planHour - $roundDownHour;

        if ($decimalMin != 0) {
            $preHour = $roundDownHour;
        } else {
            $preHour = $planHour - 1;
        }
        $getTime = $dashboardData->getTimeRange($preHour, $timeTemplate);
        if (!empty($getTime)) {
            $startDateTime = date('Y-m-d') . ' ' . $getTime[0]['startTime'];
            $endDateTime = date('Y-m-d') . ' ' . $getTime[0]['endTime'];
        }
    }

    if ($startDateTime != "" && $endDateTime != "") {
        $teamOutQty = $dashboardData->getPassQtyForTimeRange($startDateTime, $endDateTime, $style, $team);

        $data = array(
            'prodOut' => $teamOutQty,
            'hour' => $preHour,
        );
    } else {
        $data = array(
            'prodOut' => 0,
            'hour' => 0,
        );
    }

    return $data;
}

function getNeededQtyAtTime($totalHour,$currentTimeFromMin,$targtQty){

    $oneMinQty = $targtQty / ($totalHour * (double) $GLOBALS['minuteForHour']);
    $neededQty = $currentTimeFromMin * $oneMinQty;

    return $neededQty;

}

 //// Get target efficiency from ladder ////
function getTargetEffi($dashboardData,$smv,$styleRunDays){

     // $styleRunDays = $CI->Dashboard_production_model->getStyleRunDays($style, $this->team);

     // $this->styleRunDays = $styleRunDays['num_rows'];
     // $this->styleRunDays = $styleRunDays;
     $needEff = $dashboardData->needRuningDaysEffi($styleRunDays,$smv);
     if (!empty($needEff)) {
         return $needEff;
     } else {
         return '';
     }
}

function getEfficiency($workingMin, $actualOutQty, $smv, $noOfwokers){

        $produceMin = $actualOutQty * (double) $smv;
     
        //// Team Produce Min ////
        $GLOBALS['teamTotProdMinTeam'] += $produceMin;

        $usedMinu = ((double) $noOfwokers * $workingMin);
        //// Team used Min ////
        $GLOBALS['teamTotUsedMin'] += $usedMinu;
        
        $lineEffi = (double) ($GLOBALS['teamTotProdMinTeam'] / $GLOBALS['teamTotUsedMin'] ) * 100;
        $styleEff = (double) ($produceMin / $usedMinu) * 100;

        // print_r($data);

        return $data = array(
            'lineEffi' => (number_format((float) $lineEffi, 2, '.', '')),
            'styleEff' => (number_format((float) $styleEff, 2, '.', '')),
        );
}

function getQrLevel($dashboardData){
   
    $qrLevel = $dashboardData->getQrLevel();
    if ($qrLevel) {
        return $qrLevel[0]['qr_level'];
    } else {
        return 0;
    }

}

function calculateQrLevel($actulaOutQty,$defectQty){

    $actualQrLevel = 100 - (((int) $defectQty / ((int) $actulaOutQty + (int) $defectQty)) * 100);
    $actualQrLevel = number_format((float) $actualQrLevel, 2, '.', '');
    if ($actualQrLevel == 100.00) {
        $actualQrLevel = '100';
    }

    return $actualQrLevel;
}

  /////// Get Incentive /////
function getIncentive($dashboardData,$currentEfficiency,$targetEfficiency,$baseAmount,$increPrecent,$increAmount,$reductAmount){
    $incentive = 0;

    $roundDownEffi = floor($currentEfficiency);
    $roundUpStartNu = getRoundUpstart($dashboardData);
    $checkingValue = $roundDownEffi + $roundUpStartNu;
    $decimalValue = (double) $currentEfficiency - $roundDownEffi;

    if ((($targetEfficiency - 1) + $roundUpStartNu) <= $currentEfficiency) {
        $incentive = $baseAmount;

        if ($decimalValue >= $roundUpStartNu) {
            $currentEfficiency = $roundDownEffi + 1;
        } else {
            $currentEfficiency = $roundDownEffi;
        }

        $incrementPrecDiff = $currentEfficiency - (int) $targetEfficiency;

        if ($incrementPrecDiff > 0) {
            if ($increPrecent != 0) {

                $incrementIncentive = (round(($incrementPrecDiff / $increPrecent), 0, PHP_ROUND_HALF_DOWN)) * $increAmount;
                $incentive += $incrementIncentive;
            }
        }
    } else {
        $reductPrecDiff = (double) $targetEfficiency - (double) $currentEfficiency;
        if ($increPrecent != 0) {
            $incrementIncentive = (round(($reductPrecDiff / $increPrecent), 0, PHP_ROUND_HALF_DOWN)) * $reductAmount;
            $incentive -= $incrementIncentive;

            if ($incentive < 0) {
                $incentive = 0;
            }
        }
    }
    return $incentive;
    // return 10;
}

////// Get the round up decimal point to give the incentive related to effi //////
function getRoundUpstart($dashboardData){
    $result = $dashboardData->getRoundUpstart();
    if ($result) {
        return $result[0]['effi_roundup_start'];
    } else {
        return 0.5;
    }
}

////// Get Team Time current hour information //////
function getHourlyOut($dashboardData,$team,$style,$maxHrs,$smv,$noOfwokers,$dayPlanId,$dayPlanType,$timeTemplId){
 
    $workedHours = 0;
    $newStyleStartHour = 1;
    

    ///// warning ---- This function not working properly if there are two feeding dayplan //////////
    $otherDayPlan = $dashboardData->getOtherDayPlan($team, $dayPlanId);

    $decimalMin = 0;
    $roundDownHour = floor($maxHrs);
    $roundUpHour = ceil($maxHrs);
    $hourData = array();
    $decimalMin = $maxHrs - $roundDownHour;
    
    if (!empty($otherDayPlan) && $dayPlanType != 4) {
        $workedHours = $otherDayPlan[0]->workedHours;
        $workedHourDecimal =  $workedHours - floor($workedHours);
        $newStyleStartHour =ceil($workedHours);
        $totalHour = $maxHrs + $workedHours;
        if($workedHourDecimal !=0){
            if($decimalMin != 0){
                $newStyleStartHour =floor($workedHours);
            }else{
                $newStyleStartHour = ceil($workedHours)+1;
                $totalHour = $maxHrs + ceil($workedHours);
            }
        }else {
            $newStyleStartHour = $workedHours+1; 
        }
        $cHour = 0;
       
        $this->styleStartHour = $newStyleStartHour;
        for ($i = $newStyleStartHour; $i <= $totalHour; $i++) {
            $producedMin = 0;
            $usedMin = 0;
            $cHour = $cHour + 1;
            ////// Hour with decimal point ///// ex:5.5h ///////
            $result = $dashboardData->getTimeRange($i, $timeTemplId);

            if (!empty($result)) {
                if (strtotime($result[0]['startTime']) != '00:00:00'   &&  strtotime($result[0]['endTime']) != '00:00:00' ) {
                    if($workedHourDecimal !=0 && $i == floor($totalHour)){
                        $hourQty = $dashboardData->getHourQty($team,$style,$result[0]['startTime'],'23:00:00');
                    }else{
                        $hourQty = $dashboardData->getHourQty($team,$style,$result[0]['startTime'],$result[0]['endTime']);
                    }
                    
                    $workingMin =  $GLOBALS['minuteForHour'] ;
                    $producedMin = ((int)$hourQty[0]['qty']) * $smv;
                    $usedMin = $noOfwokers * $workingMin;

                     $hourData[$i]= array(
                        'style' =>$style,
                        'styleStartHour' =>$newStyleStartHour,
                        // 'startTime'=>$result[0]['startTime'],
                        // 'endTime'=>$result[0]['endTime'],
                        'hour' => $i,
                        'qty'=> $hourQty[0]['qty'],
                        'prodeMin'=> $producedMin,
                        'userMin'=> $usedMin,
                        'half'=>'0'
                    );
                }
            }
        }

    } else {
        // $this->styleStartHour = 1;
        $cHour = 0;

        for ($i = 1; $i <= ceil($maxHrs); $i++) {
            $cHour = $cHour + 1;

            ////// Hour with decimal point ///// ex:5.5h ///////
            $result = $dashboardData->getTimeRange($i, $timeTemplId);
            if (!empty($result)) {
                if(strtotime($result[0]['startTime']) != '00:00:00'  &&  strtotime($result[0]['endTime']) != '00:00:00') {
                    if($i == $maxHrs){
                        $hourQty = $dashboardData->getHourQty($team,$style,$result[0]['startTime'],'23:00:00');
                    }else{
                        $hourQty = $dashboardData->getHourQty($team,$style,$result[0]['startTime'],$result[0]['endTime']);
                    }
                    
                    $workingMin =  $GLOBALS['minuteForHour'];
                    $producedMin = ((int)$hourQty[0]['qty']) * $smv;
                    $usedMin = $noOfwokers * $workingMin;

                     $hourData[$i]= array(
                    'style' =>$style,
                    'styleStartHour' =>$newStyleStartHour,
                    // 'startTime'=>$result[0]['startTime'],
                    // 'endTime'=>$result[0]['endTime'],
                    'hour' => $i,
                    'qty'=> $hourQty[0]['qty'],
                    'prodeMin'=> $producedMin,
                    'userMin'=> $usedMin,
                    'half'=>'0'
                    );
                }else{
                    return '';
                }
            } 
        }    

    }

 return $hourData;

}


function calEfficiency($prodMin,$usedMin){
    return ($prodMin/$usedMin)*100;
}

?>


<script>
     var stuff = <?php print json_encode($stuff); ?>;
</script>












































?>