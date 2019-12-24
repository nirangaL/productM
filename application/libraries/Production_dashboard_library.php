<?php
// error_reporting(-1);
// ini_set('display_errors', 1);
defined('BASEPATH') or exit('No direct script access allowed');

class Production_dashboard_library
{

    private $location;
    private $team;
    private $date;
    private $teamProduceMin;
    private $teamUsedMin;
    private $minuteForHour;
    private $styleStartHour;

    public function __construct()
    {
        // $this->location = $params['location'];
        // $this->team = $params['team'];
        // $this->date = $params['date'];
    }

    public function get_team_data($location,$team,$date)
    {
        $this->location = $location;
        $this->team = $team;
        $this->date = $date;

        // echo $team.', ';
        $CI = &get_instance();
        $CI->load->model('Dashboard_production_model');

        $this->minuteForHour = (Double) $this->getMinutForHour();

        $temaData = $CI->Dashboard_production_model->get_team_data($team,$date);

        // print_r($temaData);exit();

        if (!empty($temaData)) {

            $dayPlanQty = 0;
            $passQty = 0;
            $defectQty = 0;
            $remakeQty = 0;
            $preHourPassQty = 0;
            $plannedQtyHrs = 0;
            $teamOutQty = 0;
            $style='';
           
           $this->teamProduceMin = 0;;
           $this->teamUsedMin = 0;
            $styleDayPlanQty = 0;
            $styleNeedQty = 0;
            $this->styleStartHour = 1;
            for ($i = 0; $i < sizeof($temaData); $i++) {
              
                $dayPlanId = $temaData[$i]->dayPlanId;
                $dayPlanType = $temaData[$i]->dayPlanType;
                $dayPlanStatus = $temaData[$i]->status;
                $location = $temaData[$i]->location;
                $team = $temaData[$i]->line;
                $teamName = $temaData[$i]->lineName;
                $style = $temaData[$i]->style;
                $timeTemplate = $temaData[$i]->timeTemplate;
                $buyer = $temaData[$i]->buyer;
                $scNumber = $temaData[$i]->scNumber;
                $hrs = $temaData[$i]->hrs;
                $smv = $temaData[$i]->smv;
                $noOfwokers = $temaData[$i]->noOfwokers;
                $incentiveHour = $temaData[$i]->incentiveHour;
                $forecastEffi = $temaData[$i]->forecastEffi;
                $incentiveEffi = $temaData[$i]->incenEffi;
                $chckTblHdId = $temaData[$i]->chckTblHdId;
                $styleRunningDay = $temaData[$i]->runningDay;
                $showRunningDay = $temaData[$i]->showRunningDay;
                $styleDayPlanQty = $temaData[$i]->dayPlanQty;
                $allDefectQty = $temaData[$i]->allDefectQty;
               
                $finalHourMin = 0;
                $workingMin = 0; ///// total working min /////
                $preHour = 0;
                $currentHour = 0;
                $hourStartTime = 0;
                $timeForTimeCountDown = '-';
                $statusTeamTv = '-';

                if($temaData[$i]->dayPlanType == '4'){
                    $dayPlanQty += $temaData[$i]->dayPlanQty;
                    $passQty += $temaData[$i]->passQty;
                    $defectQty += $temaData[$i]->defectQty;
                    $remakeQty += $temaData[$i]->remakeQty;
                }else{
                    $dayPlanQty = $temaData[$i]->dayPlanQty;
                    $passQty = $temaData[$i]->passQty;
                    $defectQty = $temaData[$i]->defectQty;
                    $remakeQty = $temaData[$i]->remakeQty;
                    
                }

                ///****** Get this time range hour and which start
                $getTime = $this->getTeamTime($hrs,$dayPlanId,$dayPlanType,$timeTemplate, $team);

                if (!empty($getTime)) {
                    ////// This is the current time day plan ///////
                    $hourStartTime = $getTime[0]->startTime;
                    $endTime = $getTime[0]->endTime;
                    $startDateTime = date('Y-m-d') . ' ' . $getTime[0]->startTime;
                    $endDateTime = date('Y-m-d') . ' ' . $getTime[0]->endTime;
                    $currentTime = date('H:i:s');

                    if(array_key_exists('productHourForStyle',$getTime)){
                        ////this is second or theird day plan current hour ///
                        $currentHour = $getTime[0]->productHourForStyle; 
                    }else{
                        $currentHour = $getTime[0]->currentHour;
                    }
                    

                    ///// This is get to TV Display to show count down ///////
                    $timeForTimeCountDown = date('M j, Y') . ' ' . $getTime[0]->endTime;

                    //// get current hour line out qty //////
                    if($temaData[$i]->dayPlanType == "4"){
                        $teamOutQty = $teamOutQty + (int)$CI->Dashboard_production_model->getPassQtyForTimeRange($startDateTime, $endDateTime, $style, $this->team);
                    }else{
                        $teamOutQty = $CI->Dashboard_production_model->getPassQtyForTimeRange($startDateTime, $endDateTime, $style, $this->team);
                    }
                    // echo $teamOutQty;
               
                    // exit();

                    ////Team wokring min ////
                    $finalHourMin = $this->get_time_difference($hourStartTime, $currentTime) * $this->minuteForHour;

                    $prePrInfp = $this->getPrevHourProd($getTime[0]->currentHour, $hrs, $style, $this->team, $dayPlanId, $timeTemplate);
                    $preHour = $prePrInfp['hour'];
                    if($temaData[$i]->dayPlanType == "4"){
                        $preHourPassQty += (INT)$prePrInfp['prodOut'];
                    }else{
                        $preHourPassQty = $prePrInfp['prodOut'];
                    }
                    
                    $workingMin = ($prePrInfp['hour'] * $this->minuteForHour) + $finalHourMin;

                    /////*********** This is production Team TV ******************//////
                    ///Send frontend whatData ///
                    $whatData = 'gridAndTile';

                   
                    $plannedQtyHrs = (Int)($dayPlanQty/ $hrs);
                    // $plannedQtyHrs = (Int)($dayPlanQty);
                   
                   
                    // Current time GAP
                    $timeGapfromStartTime = $this->get_time_difference($hourStartTime, $currentTime) * $this->minuteForHour;
                    /// check the line up down status  /////

                    $timeFramePerMin = $this->get_time_difference($hourStartTime, $endTime) * $this->minuteForHour;

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

                    /////***********/ This is production Team TV ******************//////

                } else {
                    ///Send frontend whatData ///
                    $whatData = 'tile';
                    $currentHour = $hrs;
                    ////Team wokring min ////
                    $workingMin = $hrs * $this->minuteForHour;
                }

                //// Line status /////
                $neededQtyAtTime = $this->getNeededQtyAtTime($hrs, $workingMin, $dayPlanQty);
                $styleNeedQty = $this->getNeededQtyAtTime($hrs, $workingMin, $styleDayPlanQty);

                if ($neededQtyAtTime > $dayPlanQty) {
                    $neededQtyAtTime = $dayPlanQty;
                }
                if ($styleNeedQty > $styleDayPlanQty) {
                    $styleNeedQty = $styleDayPlanQty;
                }

                if ($temaData[$i]->passQty >= $styleNeedQty) {
                    $status = 'up';
                } else if ($temaData[$i]->passQty < $styleNeedQty) {
                    $status = 'down';
                } else {
                    $status = 'unknown';
                }

                ///// data to calculate incentive /////
                $needEff = $this->getTargetEffi($style,$smv,$styleRunningDay);
                $targetEfficiency = $incentiveEffi;
                if ($needEff != '') {
                    $baseAmount = $needEff['0']->base_amount;
                    $increPrecent = $needEff['0']->incre_percent;
                    $increAmount = $needEff['0']->incre_amount;
                    $reductPrecent = $needEff['0']->decre_percent;
                    $reductAmount = $needEff['0']->reduct_amount;
                } else {
                    $baseAmount = 0;
                    $increPrecent = 0;
                    $increAmount = 0;
                    $reductPrecent = 0;
                    $reductAmount = 0;
                }

                $lineAndStyleEffi = $this->getEfficiency($workingMin, $passQty, $smv, $noOfwokers);

                $efficiency = $lineAndStyleEffi['lineEffi'];
                $styleEffi = $lineAndStyleEffi['styleEff'];
                $actulaOutQty = 0;
                if ($passQty == 0) {
                    $actulaOutQty = 1;
                } else {
                    $actulaOutQty = $passQty;
                }

                $qrLevelNeed = $this->getQrLevel();
                $actualQrLevel = $this->calculateQrLevel($actulaOutQty, $defectQty);
                if($actualQrLevel >= 100){
                    $actualQrLevel = 100;
                }else{
                    $actualQrLevel = number_format((float) $actualQrLevel, 2, '.', '');
                }
                if ($qrLevelNeed <= $actualQrLevel && $targetEfficiency != 0) {

                    // //// if two style and same smv then we need to get incenctive according to  efficiency of both style ////
                    // if ($dayPlanType == '4') {
                    //     if (sizeof($temaData) > 0) {
                    //         // $preStyleRunDays = $CI->Dashboard_production_model->getStyleRunDays($temaData[$i - 1]->stylee, $this->team);
                    //         $incentive = $this->getIncentive($lineAndStyleEffi['lineEffi'], $targetEfficiency, $baseAmount, $increPrecent, $increAmount, $reductPrecent, $reductAmount, $team, $smv,$styleRunningDay);
                    //     }

                    // }

                    $incentive = $this->getIncentive($lineAndStyleEffi['styleEff'], $targetEfficiency, $baseAmount, $increPrecent, $increAmount, $reductPrecent, $reductAmount, $team, $smv, $styleRunningDay);
                    $ince_hour = $temaData[$i]->incentiveHour;
                    if ($ince_hour != 0) {
                        $incentive = ($incentive / ($ince_hour * $this->minuteForHour)) * ($temaData[$i]->hrs * $this->minuteForHour);
                    }
                } else {
                    $incentive = 0;
                }

                // $teamProduceMin +=  ($passQty * (double) $smv);
                // $teamUsedMin += ($noOfwokers * $workingMin);

                $data['teamData'][$i] = array(
                    'whatData' => $whatData,
                    'line' => $team,
                    'lineName' => $teamName,
                    'dayPlanType' => $dayPlanType,
                    'runStatus' => $dayPlanStatus,
                    'buyer' => $buyer,
                    'style' => $style,
                    'smv' => $smv,
                    'dayPlanQty' => $dayPlanQty,
                    'hrs' => $hrs,
                    'currentHr' => $currentHour,
                    'totalPassQty' => $passQty,
                    'stylePassQty' => $temaData[$i]->passQty,
                    'needOutQtyHr'=> $plannedQtyHrs,
                    'teamHrsOutQty' => $teamOutQty,
                    'preHour' => $preHour,
                    'preHourPassQty' => $preHourPassQty,
                    'statusTeamTv'=>$statusTeamTv,
                    'statusProDashboard' => $status,
                    'ForEff' => $forecastEffi,
                    'actEff' => number_format((float) $efficiency, 2, '.', ''),
                    'styleEffi'=>number_format((float) $styleEffi, 2, '.', ''),
                    'rejectQty' => (int)($defectQty -$remakeQty),
                    'remakeQty' => $remakeQty,
                    'needQrLvl' => $qrLevelNeed,
                    'actualQrLevel' => $actualQrLevel,
                    'incentive' => intval($incentive),
                    'styleRunDays' => $styleRunningDay,
                    'showRunningDay' => $showRunningDay,
                    'noOfwokers' => $noOfwokers,
                    'neededQtyAtTime' => intval($neededQtyAtTime),
                    'minuteForHour' => $this->minuteForHour,
                    'timeForTimeCountDown' => $timeForTimeCountDown,
                    'hourStartTime' => $hourStartTime,
                    'teamProduceMin' =>($passQty * (double) $smv),
                    'teamUsedMin' =>  $noOfwokers * $workingMin,
                    'toalEff'=> number_format((float) (( $passQty * (double) $smv)/ ($noOfwokers * $workingMin))*100, 2, '.', ''),
                    'styleDayPlanQty'=> $styleDayPlanQty,
                    'styleNeedQty'=> intval($styleNeedQty),
                    'allDefectQty'=> $allDefectQty,
                );
                
                $data['hourlyOut'][$i] = $this->getHourlyOut($team,$style,$hrs,$smv,$noOfwokers,$dayPlanId,$dayPlanType,$currentHour,$timeTemplate);        
            }

            return $data;

        } else {
            $result = $CI->Dashboard_production_model->checkTodayFeedingSPlan($this->team);
            if (!empty($result)) {

                $data['gridData'][0] = array(
                    'lineName' => $result[0]->line,
                    'whatData' => 'feeding',
                    'buyer' => $result[0]->buyer,
                    'style' => $result[0]->style,
                );
                return $data;
            }
        }
    }


    ////// Get Team Time current hour information //////
    public function getTeamTime($maxHrs,$dayPlanId,$dayPlanType,$timeTemplId){
        $currentTime = date('H:i:s');
        $workedHours = 0;
        $newStyleStartHour = 1;
        $CI = &get_instance();
        $CI->load->model('Dashboard_production_model');

        ///// warning ---- This function not working properly if there are two feeding dayplan //////////
        $otherDayPlan = $CI->Dashboard_production_model->getOtherDayPlan($this->team, $dayPlanId);
    
        $decimalMin = 0;
        $roundDownHour = floor($maxHrs);
        $roundUpHour = ceil($maxHrs);

        $decimalMin = $maxHrs - $roundDownHour;

        if (!empty($otherDayPlan) && $dayPlanType != 4) {
            $workedHours = $otherDayPlan[0]->workedHours;
            $workedHours = $otherDayPlan[0]->workedHours;
            $workedHourDecimal =  $workedHours - floor($workedHours);
            if($workedHourDecimal !=0){
                if($decimalMin != 0){     
                    $result =  $this->getTeamTimeForDecimalValue($roundDownHour,$maxHrs,$timeTemplId,'reduceFromUpperHour');    
                }else{
                    $result = $this->getTeamTimeForDecimalValue($roundDownHour,$maxHrs,$timeTemplId,'addToRoundDownHour');
                }
                $newStyleStartHour =ceil($workedHours);
            }else{
                $newStyleStartHour = $roundDownHour + 1;
            }


            $totalHour = $maxHrs + $workedHours;
            $cHour = 0;
           
            $this->styleStartHour = $newStyleStartHour;
            for ($i = $newStyleStartHour; $i <= $totalHour; $i++) {
                $cHour = $cHour + 1;
                ////// Hour with decimal point ///// ex:5.5h ///////
                $result = $CI->Dashboard_production_model->getTimeRange($i, $timeTemplId);

                if (!empty($result)) {
                    if (strtotime($currentTime) > strtotime($result[0]->startTime) && strtotime($currentTime) < strtotime($result[0]->endTime)) {
                        $result[0]->currentHour = new stdClass();
                        $result[0]->currentHour = $cHour;
                        $result[0]->productHourForStyle = new stdClass();
                        $result[0]->productHourForStyle = $i;
                    }else{
                        $result[0]->currentHour = new stdClass();
                        $result[0]->currentHour = $totalHour;
                    } 
                }
            }

        } else {
            $this->styleStartHour = 1;
            $cHour = 0;
            // echo $maxHrs.'max ';

            for ($i = 1; $i <= $maxHrs; $i++) {
                $cHour = $cHour + 1;
            
                ////// Hour with decimal point ///// ex:5.5h ///////
                $result = $CI->Dashboard_production_model->getTimeRange($i, $timeTemplId);
                if (!empty($result)) {
                    if (strtotime($currentTime) > strtotime($result[0]->startTime) && strtotime($currentTime) < strtotime($result[0]->endTime)) {
                        $result[0]->currentHour = new stdClass();
                        $result[0]->currentHour = $cHour;
                    break;
                    }else{
                        $result[0]->currentHour = new stdClass();
                        $result[0]->currentHour = $maxHrs;
                    }
                } else {
                    if ($decimalMin != 0) {
                        if (($i + $decimalMin) == $maxHrs) {
                            $result = $this->getTeamTimeForDecimalValue($roundDownHour,$maxHrs,$timeTemplId,'addToRoundDownHour');
                        }
                    }
                }
            }
           
        }

     return $result;

    }


    ///// if last hour have decimal value //////////
    public function getTeamTimeForDecimalValue($roundDownHour,$maxHrs,$timeTemplId,$toDo)
    {
        $CI = &get_instance();
        $CI->load->model('Dashboard_production_model');
        $decimal = $maxHrs - $roundDownHour;
        $currentTime = date('H:i:s');
        $min = $this->minuteForHour * ($maxHrs-$roundDownHour);
       
        $result = $CI->Dashboard_production_model->getTimeRange($roundDownHour, $timeTemplId);
        $data = array();
        if (!empty($result)) {
            if (strtotime($currentTime) > strtotime($result[0]->startTime) && strtotime($currentTime) < strtotime($result[0]->endTime)) {

                if($toDo == 'addToRoundDownHour'){
                    $min = '+' . $min . ' minutes';
                    $data[0]->startTime = new stdClass();
                    $data[0]->startTime = $result[0]->endTime;
                    $data[0]->endTime = new stdClass();
                    $data[0]->endTime = date("H:i:s", strtotime($min, strtotime($result[0]->endTime)));
                    $data[0]->currentHour = new stdClass();
                    $data[0]->currentHour = $roundDownHour + $decimal;
                }else if($toDo == 'reduceFromUpperHour'){
                    $min = '-' . $min . ' minutes';
                    $data[0]->startTime = new stdClass();
                    $data[0]->startTime = date("H:i:s", strtotime($min, strtotime($result[0]->startTime)));
                    $data[0]->endTime = new stdClass();
                    $data[0]->endTime = $result[0]->startTime;
                    $data[0]->currentHour = new stdClass();
                    $data[0]->currentHour = $roundDownHour + $decimal;
                }
              
                return $data;
            }
        }
    }

    /// Get the Previous Hour Information ////
    public function getPrevHourProd($currentHour, $planHour, $style, $team, $dayPlanId, $timeTemplate)
    {
        $CI = &get_instance();
        $CI->load->model('Dashboard_production_model');

        $preHour = 0;
        $decimalMin = 0;
        $startDateTime = "";
        $endDateTime = "";

        $otherDayPlan = $CI->Dashboard_production_model->getOtherDayPlan($team, $dayPlanId);
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
            $getTime = $CI->Dashboard_production_model->getTimeRange($preHour, $timeTemplate);

            if (!empty($getTime)) {
                $startDateTime = date('Y-m-d') . ' ' . $getTime[0]->startTime;
                $endDateTime = date('Y-m-d') . ' ' . $getTime[0]->endTime;
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
            $getTime = $CI->Dashboard_production_model->getTimeRange($preHour, $timeTemplate);
            if (!empty($getTime)) {
                $startDateTime = date('Y-m-d') . ' ' . $getTime[0]->startTime;
                $endDateTime = date('Y-m-d') . ' ' . $getTime[0]->endTime;
            }
        }

        if ($startDateTime != "" && $endDateTime != "") {
            $teamOutQty = $CI->Dashboard_production_model->getPassQtyForTimeRange($startDateTime, $endDateTime, $style, $team);

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

    
    ////// Get the time differences in hours /////
    public function get_time_difference($time1, $time2)
    {

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
        // echo $totoalMin;

    }


    //// get minute for hour //This diffent with each team /////
    public function getMinutForHour()
    {
        $CI = &get_instance();
        $CI->load->model('Dashboard_production_model');
        $this->location;
        $result = $CI->Dashboard_production_model->getMinutForHour($this->location, 'Production');
        return $result[0]->minuuteForHour;
    }

    public function getNeededQtyAtTime($totalHour, $currentTimeFromMin, $targtQty)
    {

        $oneMinQty = $targtQty / ($totalHour * (double) $this->minuteForHour);
        $neededQty = $currentTimeFromMin * $oneMinQty;

        return $neededQty;

    }

    //// Get target efficiency from ladder ////
    public function getTargetEffi($style,$smv,$styleRunDays)
    {
        $CI = &get_instance();
        $CI->load->model('Dashboard_production_model');

        // $styleRunDays = $CI->Dashboard_production_model->getStyleRunDays($style, $this->team);

        // $this->styleRunDays = $styleRunDays['num_rows'];
        // $this->styleRunDays = $styleRunDays;
        $needEff = $CI->Dashboard_production_model->needRuningDaysEffi($styleRunDays, $smv, $this->location);
        if (!empty($needEff)) {
            return $needEff;
        } else {
            return '';
        }
    }

    public function getEfficiency($workingMin, $actualOutQty, $smv, $noOfwokers)
    {

        $produceMin = $actualOutQty * (double) $smv;
     
        //// Team Produce Min ////
        $this->teamProduceMin += $produceMin;

        $usedMinu = ((double) $noOfwokers * $workingMin);
        //// Team used Min ////
        $this->teamUsedMin += $usedMinu;
        
        $lineEffi = (double) ($this->teamProduceMin / $this->teamUsedMin) * 100;
        $styleEff = (double) ($produceMin / $usedMinu) * 100;

        // print_r($data);

        return $data = array(
            'lineEffi' => (number_format((float) $lineEffi, 2, '.', '')),
            'styleEff' => (number_format((float) $styleEff, 2, '.', '')),
        );
    }

    public function calculateQrLevel($actulaOutQty, $defectQty)
    {

        $actualQrLevel = 100 - (((int) $defectQty / ((int) $actulaOutQty + (int) $defectQty)) * 100);
        $actualQrLevel = number_format((float) $actualQrLevel, 2, '.', '');
        if ($actualQrLevel == 100.00) {
            $actualQrLevel = '100';
        }

        return $actualQrLevel;
    }

    public function getQrLevel()
    {
        $CI = &get_instance();
        $CI->load->model('Dashboard_production_model');

        //// get allow qr level from db/////
        $qrLevel = $CI->Dashboard_production_model->getQrLevel($this->location);
        if ($qrLevel) {
            return $qrLevel[0]->qr_level;
        } else {
            return 0;
        }

    }

    /////// Get Incentive /////
    public function getIncentive($currentEfficiency, $targetEfficiency, $baseAmount, $increPrecent, $increAmount, $reductAmount)
    {
        $incentive = 0;

        $roundDownEffi = floor($currentEfficiency);
        $roundUpStartNu = $this->getRoundUpstart();
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
    public function getRoundUpstart()
    {
        $CI = &get_instance();
        $CI->load->model('Dashboard_production_model');

        $result = $CI->Dashboard_production_model->getRoundUpstart($this->location, 'Production');
        if ($result) {
            return $result[0]->effi_roundup_start;
        } else {
            return 0.5;
        }
    }


 ////// Get Team Time current hour information //////
 public function getHourlyOut($team,$style,$maxHrs,$smv,$noOfwokers,$dayPlanId,$dayPlanType,$currentHour,$timeTemplId)
 {
    $currentTime = date('H:i:s');
    $workedHours = 0;
    $newStyleStartHour = 1;
    $CI = &get_instance();
    $CI->load->model('Dashboard_production_model');

    ///// warning ---- This function not working properly if there are two feeding dayplan //////////
    $otherDayPlan = $CI->Dashboard_production_model->getOtherDayPlan($this->team, $dayPlanId);

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
                $newStyleStartHour =ceil($workedHours);
                 $result =  $this->getTeamTimeForDecimalValueForHourlyOut($newStyleStartHour,$decimalMin,$timeTemplId,'reduceFromUpperHour');
                 $hourQty = $CI->Dashboard_production_model->getHourQty($team,$style,$result[0]->startTime,$result[0]->endTime);
                 $workingMin = $this->minuteForHour * $decimalMin;
                 $producedMin = ((int)$hourQty[0]->qty) * $smv;
                 $usedMin = $noOfwokers * $workingMin;

                 $hourData[$newStyleStartHour]= array(
                 'style' =>$style,
                 'styleStartHour' =>$newStyleStartHour,
                 'startTime'=>$result[0]->startTime,
                 'endTime'=>$result[0]->endTime,
                 'hour' =>$newStyleStartHour,
                 'qty'=> $hourQty[0]->qty,
                 'prodeMin'=> $producedMin,
                 'userMin'=> $usedMin,
                 'half'=>$decimalMin
                 );
                 $newStyleStartHour +=1;
            }else{
                $newStyleStartHour = ceil($workedHours)+1;
                $totalHour = $maxHrs + ceil($workedHours);
            }
        }else if($decimalMin != 0){
           
            $result = $this->getTeamTimeForDecimalValueForHourlyOut($roundDownHour, $maxHrs,$timeTemplId,'addToRoundDownHour');
            // print_r($result);
            $hourQty = $CI->Dashboard_production_model->getHourQty($team,$style,$result[0]->startTime,$result[0]->endTime);
            $workingMin = $this->minuteForHour * $decimalMin;
            $producedMin = ((int)$hourQty[0]->qty) * $smv;
            $usedMin = $noOfwokers * $workingMin;

            $hourData[$roundUpHour+floor($workedHours)]= array(
                'style' =>$style,
                'styleStartHour' =>$newStyleStartHour,
                'startTime'=>$result[0]->startTime,
                'endTime'=>$result[0]->endTime,
                'hour' =>$roundUpHour+floor($workedHours),
                'qty'=> $hourQty[0]->qty,
                'prodeMin'=> $producedMin,
                'userMin'=> $usedMin,
                'half'=>$decimalMin
            );    
        $newStyleStartHour = $workedHours+1; 
        }else{
            $newStyleStartHour = $workedHours+1; 
        }
        
        $cHour = 0;
       
        $this->styleStartHour = $newStyleStartHour;
        for ($i = $newStyleStartHour; $i <= $totalHour; $i++) {
            $producedMin = 0;
            $usedMin = 0;
            $cHour = $cHour + 1;
            ////// Hour with decimal point ///// ex:5.5h ///////
            $result = $CI->Dashboard_production_model->getTimeRange($i, $timeTemplId);

            if (!empty($result)) {
                if (strtotime($result[0]->startTime) != '00:00:00'  &&  strtotime($result[0]->endTime) != '00:00:00' ) {
                    if($workedHourDecimal !=0 && $i == floor($totalHour)){
                        $hourQty = $CI->Dashboard_production_model->getHourQty($team,$style,$result[0]->startTime,'23:00:00');
                    }else{
                        $hourQty = $CI->Dashboard_production_model->getHourQty($team,$style,$result[0]->startTime,$result[0]->endTime);
                    }
                    
                    $workingMin = $this->minuteForHour;
                    $producedMin = ((int)$hourQty[0]->qty) * $smv;
                    $usedMin = $noOfwokers * $workingMin;

                     $hourData[$i]= array(
                        'style' =>$style,
                        'styleStartHour' =>$newStyleStartHour,
                        'startTime'=>$result[0]->startTime,
                        'endTime'=>$result[0]->endTime,
                        'hour' => $i,
                        'qty'=> $hourQty[0]->qty,
                        'prodeMin'=> $producedMin,
                        'userMin'=> $usedMin,
                        'half'=>'0'
                    );
                }
            }
        }

    } else {
        $this->styleStartHour = 1;
        $cHour = 0;

        for ($i = 1; $i <= $maxHrs; $i++) {
            $cHour = $cHour + 1;
            // echo $i;
            ////// Hour with decimal point ///// ex:5.5h ///////
            $result = $CI->Dashboard_production_model->getTimeRange($i, $timeTemplId);
            if (!empty($result)) {
                if(strtotime($result[0]->startTime) != '00:00:00'  &&  strtotime($result[0]->endTime) != '00:00:00') {
                    if($i == $maxHrs){
                        $hourQty = $CI->Dashboard_production_model->getHourQty($team,$style,$result[0]->startTime,'23:00:00');
                    }else{
                        $hourQty = $CI->Dashboard_production_model->getHourQty($team,$style,$result[0]->startTime,$result[0]->endTime);
                    }
                    
                    $workingMin = $this->minuteForHour;
                    $producedMin = ((int)$hourQty[0]->qty) * $smv;
                    $usedMin = $noOfwokers * $workingMin;

                     $hourData[$i]= array(
                    'style' =>$style,
                    'styleStartHour' =>$newStyleStartHour,
                    'startTime'=>$result[0]->startTime,
                    'endTime'=>$result[0]->endTime,
                    'hour' => $i,
                    'qty'=> $hourQty[0]->qty,
                    'prodeMin'=> $producedMin,
                    'userMin'=> $usedMin,
                    'half'=>'0'
                    );
                }else{
                    return '';
                }
            } 
        }
        
        if ($decimalMin != 0) {
           
            $result = $this->getTeamTimeForDecimalValueForHourlyOut($roundDownHour, $maxHrs,$timeTemplId,'addToRoundDownHour');
            // print_r($result);
            $hourQty = $CI->Dashboard_production_model->getHourQty($team,$style,$result[0]->startTime,$result[0]->endTime);
            $workingMin = $this->minuteForHour * $decimalMin;
            $producedMin = ((int)$hourQty[0]->qty) * $smv;
            $usedMin = $noOfwokers * $workingMin;

            $hourData[$roundUpHour]= array(
                'style' =>$style,
                'styleStartHour' =>$newStyleStartHour,
                'startTime'=>$result[0]->startTime,
                'endTime'=>$result[0]->endTime,
                'hour' =>$roundUpHour,
                'qty'=> $hourQty[0]->qty,
                'prodeMin'=> $producedMin,
                'userMin'=> $usedMin,
                'half'=>$decimalMin
            );
        }

    }

 return $hourData;

}


///// if last hour have decimal value //////////
public function getTeamTimeForDecimalValueForHourlyOut($roundDownHour,$maxHrs,$timeTemplId,$toDo)
{
  
    $CI = &get_instance();
    $CI->load->model('Dashboard_production_model');
    
   if($toDo == 'reduceFromUpperHour'){
    $result = $CI->Dashboard_production_model->getTimeRange(($roundDownHour), $timeTemplId);
    // $min =  $this->minuteForHour * $maxHrs; ///// This is the decimal value not the max value...See the parmeters //////
   }else{
    // $min = $this->minuteForHour * ($maxHrs-$roundDownHour);
    $result = $CI->Dashboard_production_model->getTimeRange(($roundDownHour+1), $timeTemplId);
   }
  
    $data = array();
    if (!empty($result)) {
        if (strtotime($result[0]->startTime) != '00:00:00'  &&  strtotime($result[0]->endTime) != '00:00:00') {

            if($toDo == 'addToRoundDownHour'){
                // $min = '+' . $min . ' minutes';
                $data[0]->startTime = new stdClass();
                $data[0]->startTime = $result[0]->startTime;
                $data[0]->endTime = new stdClass();
                $data[0]->endTime = '23:00:00'; ////this becoz some time checker check the garment after time over//
            }else if($toDo == 'reduceFromUpperHour'){
                // $min = '-' . $min . ' minutes';
                $data[0]->startTime = new stdClass();
                $data[0]->startTime = $result[0]->startTime;
                $data[0]->endTime = new stdClass();
                $data[0]->endTime = $result[0]->endTime;
            }
          
            // print_r($data);

            return $data;
        }
    }
}





}
