<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Production_dashboard_library
{

    private $location;
    private $team;
    private $date;
    private $teamProduceMin;
    private $teamUsedMin;
    private $minuteForHour;
    private $styleRunDays;
    private $totalEffi = 0;

    public function __construct($params)
    {
        $this->location = $params['location'];
        $this->team = $params['team'];
        $this->date = $params['date'];

    }

    public function get_team_data()
    {

        $CI = &get_instance();
        $CI->load->model('Dashboard_production_model');

        $this->minuteForHour = (Double) $this->getMinutForHour();

        $temaData = $CI->Dashboard_production_model->get_team_data($this->team, $this->date);

        if (!empty($temaData)) {

            for ($i = 0; $i < sizeof($temaData); $i++) {
                $dayPlanId = $temaData[$i]->dayPlanId;
                $dayPlanType = $temaData[$i]->dayPlanType;
                $dayPlanStatus = $temaData[$i]->status;
                $location = $temaData[$i]->location;
                $team = $temaData[$i]->line;
                $teamName = $temaData[$i]->lineName;
                $timeTemplate = $temaData[$i]->timeTemplate;
                $buyer = $temaData[$i]->buyer;
                $style = $temaData[$i]->style;
                $scNumber = $temaData[$i]->scNumber;
                $delivery = $temaData[$i]->delivery;
                $orderQty = $temaData[$i]->orderQty;
                $dayPlanQty = $temaData[$i]->dayPlanQty;
                $hrs = $temaData[$i]->hrs;
                $smv = $temaData[$i]->smv;
                $noOfwokers = $temaData[$i]->noOfwokers;
                $incentiveHour = $temaData[$i]->incentiveHour;
                $forecastEffi = $temaData[$i]->forecastEffi;
                $incentiveEffi = $temaData[$i]->incenEffi;
                $chckTblHdId = $temaData[$i]->chckTblHdId;
                $passQty = $temaData[$i]->passQty;
                $defectQty = $temaData[$i]->defectQty;
                $remakeQty = $temaData[$i]->remakeQty;
                $teamOutQty = '-';
                $finalHourMin = 0;
                $workingMin = 0; ///// total working min /////
                $preHour = 0;
                $preHourPassQty = 0;
                $currentHour = 0;
                $hourStartTime = '-';
                $timeForTimeCountDown = '-';
                $statusTeamTv = '-';
                $plannedQtyHrs = '-';

                ///****** Get this time range hour and which start
                $getTime = $this->getTeamTime($hrs, $dayPlanId, $timeTemplate, $team);

                if (!empty($getTime)) {
                    $hourStartTime = $getTime[0]->startTime;
                    $endTime = $getTime[0]->endTime;
                    $startDateTime = date('Y-m-d') . ' ' . $getTime[0]->startTime;
                    $endDateTime = date('Y-m-d') . ' ' . $getTime[0]->endTime;
                    $currentTime = date('H:i:s');

                    if(array_key_exists('productHourForStyle',$getTime)){
                        $currentHour = $getTime[0]->productHourForStyle;
                    }else{
                        $currentHour = $getTime[0]->currentHour;
                    }
                    

                    ///// This is get to TV Display to show count down ///////
                    $timeForTimeCountDown = date('M j, Y') . ' ' . $getTime[0]->endTime;

                    //// get current hour line out qty //////
                    $teamOutQty = $CI->Dashboard_production_model->getPassQtyForTimeRange($startDateTime, $endDateTime, $style, $this->team);

                    ////Team wokring min ////
                    $finalHourMin = $this->get_time_difference($hourStartTime, $currentTime) * 60;

                    $prePrInfp = $this->getPrevHourProd($getTime[0]->currentHour, $hrs, $style, $this->team, $dayPlanId, $timeTemplate);
                    $preHour = $prePrInfp['hour'];
                    $preHourPassQty = $prePrInfp['prodOut'];

                    $workingMin = ($prePrInfp['hour'] * $this->minuteForHour) + $finalHourMin;

                    /////*********** This is production Team TV ******************//////
                    ///Send frontend whatData ///
                    $whatData = 'gridAndTile';

                    $plannedQtyHrs = (Int)($dayPlanQty/ $hrs);
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

                if ($neededQtyAtTime > $dayPlanQty) {
                    $neededQtyAtTime = $dayPlanQty;
                }

                if ($passQty >= $neededQtyAtTime) {
                    $status = 'up';
                } else if ($passQty < $neededQtyAtTime) {
                    $status = 'down';
                } else {
                    $status = 'unknown';
                }

                ///// data to calculate incentive /////
                $needEff = $this->getTargetEffi($style, $smv);
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

                $efficiency = $lineAndStyleEffi['styleEff'];
                $actulaOutQty = 0;
                if ($passQty == 0) {
                    $actulaOutQty = 1;
                } else {
                    $actulaOutQty = $passQty;
                }

                $qrLevelNeed = $this->getQrLevel();
                $actualQrLevel = $this->calculateQrLevel($actulaOutQty, $defectQty);

                if ($qrLevelNeed <= $actualQrLevel && $targetEfficiency != 0) {

                    //// if two style and same smv then we need to get incenctive according to  efficiency of both style ////
                    if ($dayPlanType == '4') {
                        if (sizeof($temaData) > 0) {
                            $preStyleRunDays = $CI->Dashboard_production_model->getStyleRunDays($temaData[$i - 1]->stylee, $this->team);
                            $incentive = $this->getIncentive($lineAndStyleEffi['lineEffi'], $targetEfficiency, $baseAmount, $increPrecent, $increAmount, $reductPrecent, $reductAmount, $team, $smv, $preStyleRunDays);
                        }

                    }

                    $incentive = $this->getIncentive($lineAndStyleEffi['styleEff'], $targetEfficiency, $baseAmount, $increPrecent, $increAmount, $reductPrecent, $reductAmount, $team, $smv, $this->styleRunDays);
                    $ince_hour = $temaData[$i]->incentiveHour;
                    if ($ince_hour != 0) {
                        $incentive = ($incentive / ($ince_hour * $this->minuteForHour)) * ($temaData[$i]->hrs * $this->minuteForHour);
                    }
                } else {
                    $incentive = 0;
                }

                $data['teamData'][$i] = array(
                    'whatData' => $whatData,
                    'lineName' => $teamName,
                    'dayPlanType' => $dayPlanType,
                    'runStatus' => $dayPlanStatus,
                    'buyer' => $buyer,
                    'style' => $style,
                    'delivery' => $delivery,
                    'orderQty' => $orderQty,
                    'dayPlanQty' => $dayPlanQty,
                    'hrs' => $hrs,
                    'currentHr' => $currentHour,
                    'totalPassQty' => $passQty,
                    'needOutQtyHr'=> $plannedQtyHrs,
                    'teamHrsOutQty' => $teamOutQty,
                    'preHour' => $preHour,
                    'preHourPassQty' => $preHourPassQty,
                    'statusTeamTv'=>$statusTeamTv,
                    'statusProDashboard' => $status,
                    'ForEff' => $forecastEffi,
                    'actEff' => $efficiency,
                    'rejectQty' => ((int) $defectQty - (int) $remakeQty),
                    'remakeQty' => $remakeQty,
                    'actualQrLevel' => $actualQrLevel,
                    'incentive' => $incentive,
                    'styleRunDays' => $this->styleRunDays,
                    'neededQtyAtTime' => (Int) $neededQtyAtTime,
                    'needQrLvl' => $qrLevelNeed,
                    'minuteForHour' => $this->minuteForHour,
                    'timeForTimeCountDown' => $timeForTimeCountDown,
                    'hourStartTime' => $hourStartTime,
                    'teamProduceMin' => $passQty * (double) $smv,
                    'teamUsedMin' =>  $noOfwokers * $workingMin,
                );
                if (!empty($getTime)) {
                    break;
                }
            }
            return $data;
        } else {

            $result = $CI->Dashboard_production_model->checkTodayFeedingSPlan($team);
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
    public function getTeamTime($maxHrs, $dayPlanId, $timeTemplId)
    {

        $currentTime = date('H:i:s');
        $workedHours = 0;

        $CI = &get_instance();
        $CI->load->model('Dashboard_production_model');

        $otherDayPlan = $CI->Dashboard_production_model->getOtherDayPlan($this->team, $dayPlanId);

        

        $decimalMin = 0;
        $roundDownHour = floor($maxHrs);
        $decimalMin = $maxHrs - $roundDownHour;

        if (!empty($otherDayPlan)) {
            $workedHours = $otherDayPlan[0]->workedHours;

            $newStyleStartHour = $workedHours + 1;
            $totalHour = $maxHrs + $workedHours;
            $cHour = 0;

          
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
                        return $result;
                    } else {
                        if ($decimalMin != 0) {
                            if (($i + $decimalMin) == $maxHrs) {
                                return $this->getTeamTimeForDecimalValue($roundDownHour, $maxHrs);
                            }
                        }
                    }
                }
            }
        } else {

            $cHour = 0;
            for ($i = 1; $i <= $maxHrs; $i++) {
                $cHour = $cHour + 1;
                ////// Hour with decimal point ///// ex:5.5h ///////
                $result = $CI->Dashboard_production_model->getTimeRange($i, $timeTemplId);
                if (!empty($result)) {
                    // echo $cHour;
                    // echo '<br>';
                    if (strtotime($currentTime) > strtotime($result[0]->startTime) && strtotime($currentTime) < strtotime($result[0]->endTime)) {
                        $result[0]->currentHour = new stdClass();
                        $result[0]->currentHour = $cHour;
                        return $result;
                    }
                } else {
                    if ($decimalMin != 0) {
                        if (($i + $decimalMin) == $maxHrs) {

                            return $this->getTeamTimeForDecimalValue($roundDownHour, $maxHrs);
                        }
                    }
                }
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

        if ($startDateTime != "" && $startDateTime != "") {
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

    ///// if last hour have decimal value //////////
    public function getTeamTimeForDecimalValue($roundDownHour, $maxHrs)
    {
        $CI = &get_instance();
        $CI->load->model('Dashboard_production_model');

        $currentTime = date('H:i:s');
        $min = $this->minuteForHour / ($maxHrs - $roundDownHour);
        $min = '+' . $min . ' minutes';
        $timeTemplId = $this->timeTemplId;
        $result = $CI->Dashboard_production_model->getTimeRange($roundDownHour, $timeTemplId);
        $data = array();
        if (!empty($result)) {
            if (strtotime($currentTime) > strtotime($result[0]->startTime) && strtotime($currentTime) < strtotime($result[0]->endTime)) {
                $data[0]->startTime = new stdClass();
                $data[0]->startTime = $result[0]->endTime;
                $data[0]->endTime = new stdClass();
                $data[0]->endTime = date("H:i:s", strtotime($min, $result[0]->endTime));
                $data[0]->currentHour = new stdClass();
                $data[0]->currentHour = $maxHrs + $roundDownHour;
                return $data;
            }
        }
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
    public function getTargetEffi($style, $smv)
    {
        $CI = &get_instance();
        $CI->load->model('Dashboard_production_model');

        $styleRunDays = $CI->Dashboard_production_model->getStyleRunDays($style, $this->team);

        $this->styleRunDays = $styleRunDays['num_rows'];
        $needEff = $CI->Dashboard_production_model->needRuningDaysEffi($styleRunDays['num_rows'], $smv, $this->location);
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

}
