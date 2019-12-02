<?php
//
//error_reporting(-1);
//ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Tv_Manager_Con extends MY_Controller
{

    public $toDayMaxProHr;
    public $hourPlanQty;
    public $finalHour;

    private $lineNo;
    private $timeTemplId;
    private $location;
    private $roundup_start;
    private $styleRunDatys;

    function __construct()
    {
        parent::__construct();
        $this->load->helper('cookie');
        $this->location = get_cookie('location');
        $this->load->model('tv/Tv_manager_model');
    }

    public function index()
    {

        if($this->location == ''){
            $this->load->view('tv/tv_login');
        }else{
            $this->load->view('tv/tv_manager');
        }
//        $data['lineName'] = $this->Tv_manager_model->getLineName();
    }

    public function getTvData(){
        $getTeams = $this->Tv_manager_model->getTeamData($this->location);
        $teamsSize = $getTeams['num_rows'];

        for($i=0;$i<$teamsSize;$i++){
            $this->lineNo = $getTeams['qResult'][$i]->teamId;
            $data['tvData'][$i] =   $this->getTeamData($getTeams['qResult'][$i]->teamId);
            $data['team'][$i] = $getTeams['qResult'][$i]->team;
        }

        echo json_encode($data);

    }

    ////// Get the round up decimal point to give the incentive related to effi //////
    public function getRoundUpstart()
    {
        $result = $this->Tv_manager_model->getRoundUpstart($this->lineNo);
        if($result){
            return $result[0]->roundup_start;
        }else{
            return 0;
        }
    }

    //// Get Grid Data and Tile Data to TV Display ///////
    public function getTeamData($teamId){

        $result = $this->Tv_manager_model->getGridData($teamId);

        if (!empty($result)) {

            $this->toDayMaxProHr = $result[0]->hrs;

            //// Set Day plan Qty /////
            if ($result[0]->dayPlanQty != '') {
                $dayPlannedQty = $result[0]->dayPlanQty;
            } else {
                $dayPlannedQty = 0;
            }

            //// Set Day Working hours /////
            if ($result[0]->hrs != '') {
                $hrs = $result[0]->hrs;
            } else {
                $hrs = 1;
            }

            $this->timeTemplId = $result[0]->timeTemplate;
//            echo $this->timeTemplId;

            ///// Get this time range hour and which start, end time //////
            $getTime = $this->getTeamTime($result[0]->hrs);
//            $getTime = $this->getWorkingHour($result[0]->hrs);

            if (!empty($getTime)) {
                $startDateTime = date('Y-m-d') . ' ' . $getTime[0]->startTime;
                $endDateTime = date('Y-m-d') . ' ' . $getTime[0]->endTime;
                $lineOutQty = $this->Tv_manager_model->getLineOutHrly($result[0]->style, $result[0]->scNumber, $result[0]->delivery, $startDateTime, $endDateTime);
            }

            ///// This is get to TV Display to show count down ///////
            $timeForTimeCountDown = date('M j, Y') . ' ' . $getTime[0]->endTime;

            //// get current time's line out qty //////


            //// Hour plan Qty ///
            $plannedQtyHrs = (Int)($dayPlannedQty / $hrs);
            $this->hourPlanQty = $plannedQtyHrs;

            //// Behind or Excess qty //////
            $behindQty = (Int)($plannedQtyHrs - $lineOutQty);


            /// check the line up down status  /////
            $startTime = $getTime[0]->startTime;
            $endTime = $getTime[0]->endTime;
            $timeFramePerMin = $this->get_time_difference($startTime, $endTime) * 60;
            $currentTime = date('H:i:s');

            // One Pcs sawing time
            $perPcsMinits = $timeFramePerMin / $plannedQtyHrs;

            // Current time GAP
            $timeGapfromStartTime = $this->get_time_difference($startTime, $currentTime) * 60;

            /// actual ne Pcs sawing time within current progress ////
            $planPerPcsForMin = $timeGapfromStartTime / $perPcsMinits;

            //// Line status /////
            if ($planPerPcsForMin <= $lineOutQty) {
                $status = 'up';
            } else if ($planPerPcsForMin > $lineOutQty) {
                $status = 'down';
            } else {
                $status = 'unknown';
            }

            $payIncentive  = true;
            $qrLevel = $this->getQrLevel($this->location);
            $actualQrLevel = 100-(((int)$result[0]->rejectQty/((int)$result[0]->actualQty + (int)$result[0]->rejectQty))*100);
            $actualQrLevel  =  number_format((float)$actualQrLevel, 2, '.', '');

            if($actualQrLevel == 100.00){
                $actualQrLevel = '100';
            }

            if($qrLevel <= $actualQrLevel ){
                $payIncentive  = true;
            }else{
                $payIncentive  = false;
            }

                /// Get the Previous Hour Information ////
                $data['prePrInfp'] = $this->getPrevHourProd($getTime[0]->currentHour, $result[0]->line);
//                $completeWorkingHo = $getTime[0]->currentHour - $getTime[0]->startHour;

                //////Get the current hour's minute
                $finalHourMin = $this->get_time_difference($startTime, $currentTime) * 60;

//               $workingMin = ($completeWorkingHo * 60) + $finalHourMin;

                /////// Calculate Efficiency ///////
                //// Total working time to this time ////
                $workingMin = ($data['prePrInfp']['hour'] * 60) + $finalHourMin;
                $poduceMin = $result[0]->actualQty * (float)$result[0]->smv;
                $totalUseMuni = ((int)$result[0]->noOfwokers * $workingMin);
                $efficiency = (double)($poduceMin / $totalUseMuni) * 100;
                $efficiency = (number_format((float)$efficiency, 2, '.', ''));

                $neededQtyAtTime = $this->getNeededQtyAtTime($result[0]->hrs,$workingMin,$dayPlannedQty);

                /// Set current data to
                $this->session->set_userdata('lineData', $data);

                $needEff = $this->getTargetEffi($result[0]->style, $result[0]->smv);
                ///// data to calculate incentive /////
//                $targetEfficiency = $data['needEff']['0']->efficiency;
                $targetEfficiency = $result[0]->incenEffi;
                $currentEfficiency = $efficiency;
                $baseAmount = $needEff['0']->base_amount;
                $increPrecent = $needEff['0']->incre_percent;
                $increAmount = $needEff['0']->incre_amount;
                $reductAmount = $needEff['0']->reduct_amount;

                if($payIncentive == true){
                    $incentive = $this->getIncentive($currentEfficiency, $targetEfficiency, $baseAmount, $increPrecent, $increAmount, $reductAmount);
                }else{
                    $incentive = 0;
                }

            //// prepared data to send the TV display //////
            if (!empty($getTime)) {
                $data['gridData'] = array(
                    'whatData' => 'gridAndTile',
                    'lineName' => $result[0]->lineName,
                    'style' => $result[0]->style,
                    'delivery' => $result[0]->delivery,
                    'orderQty' => $result[0]->orderQty,
                    'dayPlanQty' => $result[0]->dayPlanQty,
                    'hrs' => $result[0]->hrs,
                    'plannedQtyHrs' => $plannedQtyHrs,
                    'lineOutQty' => $result[0]->actualQty,
                    'lineHrsOutQty' => $lineOutQty,
                    'behindQty' => $behindQty,
                    'status' => $status,
                    'currentHr' => $getTime[0]->currentHour,
                    'hourStartTime' => $startTime,
                    'timeForTimeCountDown' => $timeForTimeCountDown,
                    'hourEndTime' => $endTime,
                    'ForEff' => $result[0]->efficiency,
                    'actEff' => $efficiency,
                    'rejectQty' => ((int)$result[0]->rejectQty - (int)$result[0]->remakeQty),
                    'remakeQty' => $result[0]->remakeQty,
                    'actualQrLevel' => $actualQrLevel,
                    'incentive' => $incentive,
                    'styleRunDatys' =>  $this->styleRunDatys,
                    'neededQtyAtTime' => (Int)$neededQtyAtTime,
                    'workingMin' => $workingMin,
                );

            }else{
                /////// Calculate Efficiency ///////
                //// Total working time to this time ////
//                $workingMin = ($data['prePrInfp']['hour'] * 60) + $finalHourMin;
                $workingMin = (int)$result[0]->hrs * 60;
                $poduceMin = $result[0]->actualQty * (float)$result[0]->smv;
                $totalUseMuni = ((int)$result[0]->noOfwokers * $workingMin);
                $efficiency = (double)($poduceMin / $totalUseMuni) * 100;
                $efficiency = (number_format((float)$efficiency, 2, '.', ''));



                $data['prePrInfp'] = $this->getPrevHourProd($getTime[0]->currentHour,$result[0]->hrs);
                $needEff = $this->getTargetEffi($result[0]->style, $result[0]->smv);

                /// data to calculate incentive /////

                $targetEfficiency = $result[0]->incenEffi;

                $currentEfficiency = $efficiency;
                $baseAmount = $needEff['0']->base_amount;
                $increPrecent = $needEff['0']->incre_percent;
                $increAmount = $needEff['0']->incre_amount;
                $reductAmount = $needEff['0']->reduct_amount;

                if($payIncentive){
                    $incentive = $this->getIncentive($currentEfficiency, $targetEfficiency, $baseAmount, $increPrecent, $increAmount, $reductAmount);
                }else{
                    $incentive = 0;
                }

                $data['gridData'] = array(
                    'whatData' => 'tile',
                    'lineName' => $result[0]->lineName,
                    'style' => $result[0]->style,
                    'delivery' => $result[0]->delivery,
                    'orderQty' => $result[0]->orderQty,
                    'dayPlanQty' => $result[0]->dayPlanQty,
                    'lineOutQty' => $result[0]->actualQty,
                    'finalHour' => $result[0]->hrs,
                    'ForEff' => $result[0]->efficiency,
                    'actEff' => $efficiency,
                    'rejectQty' => ((int)$result[0]->rejectQty - (int)$result[0]->remakeQty),
                    'remakeQty' => $result[0]->remakeQty,
                    'actualQrLevel' => $actualQrLevel,
                    'incentive' => $incentive,
                    'styleRunDatys' =>  $this->styleRunDatys,
                );

            }
            ////// Set day efficiency to when plan hours is over //////
//            echo (strtotime($endTime)+(60*3)).'  '.strtotime(date('H:i:s'));

            $lastHourData = $this->Tv_manager_model->getTimeRange($result[0]->hrs, $this->timeTemplId);
            $lastHourEndTime = $lastHourData[0]->endTime;
            $lastHourEndTime = date('H:i', strtotime($lastHourEndTime));

            if ($lastHourEndTime != '') {
                if ((strtotime($lastHourEndTime) + (60 * 3)) == strtotime(date('H:i'))) {
                    //// after production time is finished //////
                    $this->setDayEfficiency();
                }
            }
            return $data;
        }else{

            $result = $this->Tv_manager_model->checkTodayFeedingSPlan();
            if (!empty($result)){

                $data['gridData'] = array(
                    'whatData' => 'feeding',
                    'style' => $result[0]->style,
                );
               return $data;
            }
        }
    }


    public function getTeamTime($maxHrs){
        $lineId = $this->lineNo;
        $timeTemplId = $this->timeTemplId;
        $currentTime  = date('H:i:s');

        $workedHours = 0;
        $qResult = $this->Tv_manager_model->getOtherCloseDayPlan($lineId);
        $queryResult = $this->Tv_manager_model->getFeedingHour($lineId);
        $feedingHour = 0;
        if($queryResult){
            $feedingHour = $queryResult[0]->feedingHour;
        }

        if($qResult && $queryResult){
//            print_r($qResult);
            $workedHours = $qResult[0]->workedHours;
            $newStyleStartHour = $workedHours + 1 +$feedingHour;
            $totalHour = $maxHrs + $workedHours;
            for($i=$newStyleStartHour;$i<=$totalHour;$i++){
                $result = $this->Tv_manager_model->getTimeRange($i,$timeTemplId);
                if(!empty($result)){
                    if(strtotime($currentTime) > strtotime($result[0]->startTime) && strtotime($currentTime) < strtotime($result[0]->endTime)){
                        $result[0]->currentHour = new stdClass();
                        $result[0]->currentHour = $i;
                        return $result;
                    }
                }
            }
        }else{
            for($i=1;$i<=$maxHrs;$i++){
                $result = $this->Tv_manager_model->getTimeRange($i,$timeTemplId);
                if(!empty($result)){
                    if(strtotime($currentTime) > strtotime($result[0]->startTime) && strtotime($currentTime) < strtotime($result[0]->endTime)){
                        $result[0]->currentHour = new stdClass();
                        $result[0]->currentHour = $i;
                        return $result;
                    }
                }
            }
        }

    }

    ////// Get the time different from two hours /////
    public function get_time_difference($time1, $time2)
    {

//       echo $time1.'  '.$time2;exit();
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

    /// Get the Previous Hour Information ////
    public function getPrevHourProd($currentHour,$planHour)
    {

        if ($currentHour < $planHour) {
            $getTime = $this->Tv_manager_model->getTimeRange(($currentHour - 1), $this->timeTemplId);

            $startDateTime = date('Y-m-d') . ' ' . $getTime[0]->startTime;
            $endDateTime = date('Y-m-d') . ' ' . $getTime[0]->endTime;
            $preHour = $currentHour - 1;
            if($preHour <0){
                $preHour = 0;
            }
        } else {
            $getTime = $this->Tv_manager_model->getTimeRange(($planHour-1), $this->timeTemplId);

            $startDateTime = date('Y-m-d') . ' ' . $getTime[0]->startTime;
            $endDateTime = date('Y-m-d') . ' ' . $getTime[0]->endTime;
            $preHour = ($planHour-1);
        }



        $lineOutQty = $this->Tv_manager_model->getPrevHourProd($startDateTime, $endDateTime);

        $data = array(
            'planQty' => $this->hourPlanQty,
            'prodOut' => $lineOutQty,
            'hour' => $preHour
        );

        return $data;

    }

    //// Set the day efficiency  //////
    public function setDayEfficiency()
    {
        $style = $_SESSION['lineData']['gridData']['style'];
        $result = $this->Tv_manager_model->checkDayEfficiencySaved($style);
        if (empty($result) && $style != '') {
            $delivery = $_SESSION['lineData']['gridData']['delivery'];
            $orderQty = $_SESSION['lineData']['gridData']['orderQty'];
            $planQty = $_SESSION['lineData']['gridData']['dayPlanQty'];
            $actualQty = $_SESSION['lineData']['gridData']['lineOutQty'];
            $efficiency = $_SESSION['lineData']['efficiency']['eff'];

            $this->Tv_manager_model->setDayEfficiency($style, $delivery, $orderQty, $planQty, $actualQty, $efficiency);
        }
    }

    ///// Get planned Efficiency //////
    public function getTargetEffi($style, $smv)
    {
        $styleRunDays = $this->Tv_manager_model->getStyleRunDays($style);

        $this->styleRunDatys = $styleRunDays['num_rows'];
        $needEff = $this->Tv_manager_model->needRuningDaysEffi($styleRunDays['num_rows'], $smv);
        return $needEff;
    }

    /////// Get Incentive /////
    public function getIncentive($currentEfficiency, $targetEfficiency, $baseAmount, $increPrecent, $increAmount, $reductAmount)
    {
        $incentive = 0;

        $roundDownEffi = floor($currentEfficiency);
        $roundUpStartNu = $this->getRoundUpstart();
        $checkingValue = $roundDownEffi + $roundUpStartNu;
        $decimalValue = (double)$currentEfficiency - $roundDownEffi;

        if ((($targetEfficiency - 1) + $roundUpStartNu) <= $currentEfficiency) {
            $incentive = $baseAmount;

            if ($decimalValue >= $roundUpStartNu) {
                $currentEfficiency = $roundDownEffi + 1;
            } else {
                $currentEfficiency = $roundDownEffi;
            }

            $incrementPrecDiff = $currentEfficiency - (int)$targetEfficiency;

            if ($incrementPrecDiff > 0) {
                if ($increPrecent != 0) {

                    $incrementIncentive = (round(($incrementPrecDiff / $increPrecent), 0, PHP_ROUND_HALF_DOWN)) * $increAmount;
                    $incentive += $incrementIncentive;
                }
            }
        } else {
            $reductPrecDiff = (double)$targetEfficiency - (double)$currentEfficiency;
            if ($increPrecent != 0) {
                $incrementIncentive = (round(($reductPrecDiff / $increPrecent), 0, PHP_ROUND_HALF_DOWN)) * $reductAmount;
                $incentive -= $incrementIncentive;

                if ($incentive < 0) {
                    $incentive = 0;
                }
            }
        }
        return $incentive;
    }


    public function getWorkingHour($hrs)
    {
        $lineId = $this->lineNo;
        $teamWorking = $this->Tv_manager_model->getTeamWorkingHour($lineId);

        $styleStartHour = ($teamWorking - $hrs) + 1;

        $currentTime = date('H:i:s');

        for ($i = $styleStartHour; $i <= $teamWorking; $i++) {
            $result = $this->Tv_manager_model->getTimeRange($i, $this->timeTemplId);

            if (!empty($result)) {
                if (strtotime($currentTime) > strtotime($result[0]->startTime) && strtotime($currentTime) < strtotime($result[0]->endTime)) {
                    $result[0]->currentHour = new stdClass();
                    $result[0]->currentHour = $i;
                    $result[0]->startHour = new stdClass();
                    $result[0]->startHour = $styleStartHour;
//                    print_r($result);
                    return $result;
                }
            }
        }

    }

    public function getQrLevel($location){

        $qrLevel = $this->Tv_manager_model->getQrLevel($location);
        if($qrLevel){
            return $qrLevel[0]->qr_level;
        }else{
            return 0;
        }

    }

    public function getNeededQtyAtTime($totalHour,$currentTimeFromMin,$targtQty){


//        echo $totalHour;exit();

        $oneMinQty = $targtQty/($totalHour*60);
        $neededQty = $currentTimeFromMin*$oneMinQty;

        return $neededQty;

    }

}