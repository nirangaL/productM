<?php
error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');
class Location_Dashboard_Con extends MY_Controller{

    public $toDayMaxProHr;
    public $hourPlanQty;
    public $finalHour;

    private $lineNo;
    private $timeTemplId;
    private $location;
    private $roundup_start;
    private $styleRunDatys;

    private $factryProduceMin = 0;
    private $factryUsedMini = 0;
    private $factryEfficiency = 0;
    private $totalIncentive = 0;

    private $minuteForHour;
    Private $teamProduceMin;
    Private $teamUsedMin;

    function __construct(){
        parent::__construct();
        $this->location = $this->myConlocation;
        $this->load->model('Location_dashboard_model');
        $this->minuteForHour = (Double)$this->getMinutForHour($this->location);
    }

    public function index(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('location_dashboard');
        $this->load->view('template/footer');
    }

    public function getLocationData(){
        $getTeams = $this->Location_dashboard_model->getTeamData($this->location);
        $teamsSize = $getTeams['num_rows'];

        for($i=0;$i<$teamsSize;$i++){
            $this->lineNo = $getTeams['qResult'][$i]->teamId;
            $data['tvData'][$i] =   $this->getTeamData($getTeams['qResult'][$i]->teamId);
            $data['team'][$i] = $getTeams['qResult'][$i]->team;
            $data['teamWorkers'][$i] = $this->getWorkerCount($getTeams['qResult'][$i]->teamId);

            $this->teamProduceMin = 0;
            $this->teamUsedMin = 0;

        }
        $data['monthlyEffi'] = $this->getMonthlyEffi($this->minuteForHour,$this->location);
        // $datas['monthlyEffi'][0]->date = new stdClass();
        // $datas['tblItems'][0]->returnQty = $returnQty->total2;

        if($this->factryUsedMini == 0){
          $this->factryUsedMini =1;
        }

        $factryEfficiency = (float)($this->factryProduceMin / $this->factryUsedMini) * 100;
        $this->factryEfficiency = (number_format((float)$factryEfficiency, 2, '.', ''));
        $data['LocaEffi'] = $this->factryEfficiency;
        // $data['workerCount'] =  $this->getWorkerCount();
        $data['totalIncentive'] =  $this->totalIncentive;
        echo json_encode($data);
    }

    ////// Get the round up decimal point to give the incentive related to effi //////
    public function getRoundUpstart($teamId){
        $result = $this->Location_dashboard_model->getRoundUpstart($teamId);
        if($result){
            return $result[0]->roundup_start;
        }else{
            return 0;
        }
    }

    //// Get Grid Data and Tile Data to TV Display ///////
    public function getTeamData($teamId){

      $result = $this->Location_dashboard_model->getGridData($teamId);

      if (!empty($result)) {
        $this->teamProduceMin = 0;
        $prodctHour = 0;
        for($i=0;$i<sizeof($result);$i++){

          $this->toDayMaxProHr = $result[$i]->hrs;

          //// Set Day plan Qty /////
          if ($result[$i]->dayPlanQty != '') {
            $dayPlannedQty = $result[$i]->dayPlanQty;
          } else {
            $dayPlannedQty = 0;
          }

          //// Set Day Working hours /////
          if ($result[$i]->hrs != '') {
            $hrs = $result[$i]->hrs;
          } else {
            $hrs = 1;
          }

          $this->timeTemplId = $result[$i]->timeTemplate;

          ///****** Get this time range hour and which start & end time ******///
          $getTime = $this->getTeamTime($result[$i]->hrs,$result[$i]->id);

          $finalHourMin = 0;

          if (!empty($getTime)) {

            $startDateTime = date('Y-m-d') . ' ' . $getTime[0]->startTime;
            $startTime = $getTime[0]->startTime;
            $currentTime = date('H:i:s');
            ////Team wokring min ////
            $finalHourMin = $this->get_time_difference($startTime, $currentTime) * 60;

            $data['prePrInfp'] = $this->getPrevHourProd($getTime[0]->currentHour, $result[0]->hrs);
            // echo $getTime[0]->currentHour;

            $workingMin = ($data['prePrInfp']['hour'] * $this->minuteForHour) + $finalHourMin;
            ///Send frontend whatData ///
            $whatData = 'gridAndTile';
          }else{
            ///Send frontend whatData ///
            $whatData = 'tile';
            ////Team wokring min ////
            $workingMin = $result[$i]->hrs * $this->minuteForHour;
          }


          //// Line status /////
          $neededQtyAtTime = $this->getNeededQtyAtTime($result[$i]->hrs,$workingMin,$dayPlannedQty);
          if($neededQtyAtTime > $result[$i]->dayPlanQty){
            $neededQtyAtTime = $result[$i]->dayPlanQty;
          }


          if ($result[$i]->actualQty >= $neededQtyAtTime) {
            $status = 'up';
          } else if ($result[$i]->actualQty < $neededQtyAtTime) {
            $status = 'down';
          } else {
            $status = 'unknown';
          }

          ///// data to calculate incentive /////
          $needEff = $this->getTargetEffi($result[$i]->style, $result[$i]->smv);
          $targetEfficiency = $result[$i]->incenEffi;
          if($needEff != ''){
            $baseAmount = $needEff['0']->base_amount;
            $increPrecent = $needEff['0']->incre_percent;
            $increAmount = $needEff['0']->incre_amount;
            $reductPrecent = $needEff['0']->decre_percent;
            $reductAmount = $needEff['0']->reduct_amount;
          }else{
            $baseAmount = 0;
            $increPrecent = 0;
            $increAmount = 0;
            $reductPrecent = 0;
            $reductAmount = 0;
          }

          // echo $workingMin."----"$result[$i]->actualQty."------".$result[$i]->smv."---------".$result[$i]->noOfwokers;

          $lineAndStyleEffi = $this->getEfficiency($workingMin,$result[$i]->actualQty,$result[$i]->smv,$result[$i]->noOfwokers);

          // print_r($lineAndStyleEffi);

          $efficiency = $lineAndStyleEffi['lineEffi'];
          $actulaOutQty = 0;
          if($result[$i]->actualQty == 0){
              $actulaOutQty = 1;
          }else{
              $actulaOutQty = $result[$i]->actualQty;
          }
          $qrLevel = $this->getQrLevel($this->location);
          $actualQrLevel = 100-(((int)$result[$i]->rejectQty/((int)$actulaOutQty + (int)$result[$i]->rejectQty))*100);
          $actualQrLevel  =  number_format((float)$actualQrLevel, 2, '.', '');
          if($actualQrLevel == 100.00){
            $actualQrLevel = '100';
          }
          if($qrLevel <= $actualQrLevel && $targetEfficiency != 0){
           if($result[$i]->dayPlanType == "4"){
            $incentive = $this->getIncentive($lineAndStyleEffi['lineEffi'], $targetEfficiency, $baseAmount, $increPrecent, $increAmount,$reductPrecent,$reductAmount,$teamId,$result[$i]->smv,$this->styleRunDatys);
           }else{
            $incentive = $this->getIncentive($lineAndStyleEffi['styleEff'], $targetEfficiency, $baseAmount, $increPrecent, $increAmount,$reductPrecent,$reductAmount,$teamId,$result[$i]->smv,$this->styleRunDatys);
           }
           
            
            $ince_hour = $result[$i]->incentiveHour;
            if($ince_hour!=0){
              $incentive = ($incentive/($ince_hour*$this->minuteForHour)) * ($this->toDayMaxProHr*$this->minuteForHour);
            }
          }else{
            $incentive = 0;
          }

          /// send front end to there is comming enother deyplan in same team and show both together////////
          if(isset($result[($i+1)])){
            if($teamId == $result[($i+1)]->line){
              if($result[($i+1)]->dayPlanType =='4' || $result[($i+1)]->dayPlanType =='2'){ //// If Two style and no split ///
                $efficiency = "nextStyle";
              }
            }
          }
          /// <-- / end front end to there is comming enother deyplan in same team and show both together>////////

          $data['gridData'][$i] = array(
            'whatData' => $whatData,
            'lineName' => $result[$i]->lineName,
            'buyer' => $result[$i]->buyer,
            'style' => $result[$i]->style,
            'delivery' => $result[$i]->delivery,
            'orderQty' => $result[$i]->orderQty,
            'smv' => $result[$i]->smv,
            'dayPlanQty' => $result[$i]->dayPlanQty,
            'hrs' => $result[$i]->hrs,
            'lineOutQty' => $result[$i]->actualQty,
            'status' => $status,
            'ForEff' => $result[$i]->efficiency,
            'actEff' => $efficiency,
            'rejectQty' => ((int)$result[$i]->rejectQty - (int)$result[$i]->remakeQty),
            'remakeQty' => $result[$i]->remakeQty,
            'actualQrLevel' => $actualQrLevel,
            'incentive' => $incentive,
            'styleRunDatys' =>  $this->styleRunDatys,
            'neededQtyAtTime' => (Int)$neededQtyAtTime,
            'needQrLvl' => $qrLevel,
          );
        }

        return $data;
      }else{

        $result = $this->Location_dashboard_model->checkTodayFeedingSPlan();
        if (!empty($result)){

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


    public function showFeedingStyle(){

      $result = $this->Location_dashboard_model->checkTodayFeedingSPlan();
      if (!empty($result)){

        $data = array(
          'lineName' => $result[0]->line,
          'whatData' => 'feeding',
            'buyer' => $result[0]->buyer,
          'style' => $result[0]->style,
        );
        return $data;
      }
    }


    public function getTeamTime($maxHrs,$dayPlanId){
      $lineId = $this->lineNo;
      $timeTemplId = $this->timeTemplId;

      $currentTime  = date('H:i:s');
      $feedingHour=0;
      $workedHours = 0;

      $qResult = $this->Location_dashboard_model->getOtherCloseDayPlan($lineId,$dayPlanId);
      // $queryResult = $this->Location_dashboard_model->getFeedingHour($lineId);
      // $feedingHour = 0;

      // if($queryResult){
      //   $feedingHour = $queryResult[0]->feedingHour;
      // }

      // $timeTemplId = $this->timeTemplId;

      $decimalMin = 0;
      $roundDownHour = floor($maxHrs);
      $decimalMin = $maxHrs - $roundDownHour;

      if($qResult){
        $workedHours = $qResult[0]->workedHours;
        // echo $workedHours;
        $newStyleStartHour = $workedHours+1;
        $totalHour = $maxHrs + $workedHours;
        $cHour = 0;
        for($i=$newStyleStartHour;$i<=$totalHour;$i++){
          $cHour = $cHour + 1;
          ////// Hour with decimal point ///// ex:5.5h ///////

          $result = $this->Location_dashboard_model->getTimeRange($i,$timeTemplId);
          if(!empty($result)){
            if(strtotime($currentTime) > strtotime($result[0]->startTime) && strtotime($currentTime) < strtotime($result[0]->endTime)){
              $result[0]->currentHour = new stdClass();
              $result[0]->currentHour = $cHour;
              $result[0]->productHourForStyle = new stdClass();
              $result[0]->productHourForStyle = $i;
              return $result;
            }else{
              if($decimalMin !=0){
                if(($i+$decimalMin) == $maxHrs){
                  return  $this->getTeamTimeForDecimalValue($roundDownHour,$maxHrs);
                }
              }
            }
          }
        }
      }else{
        $cHour = 0;
        for($i=1;$i<=$maxHrs;$i++){
          $cHour = $cHour + 1;
          ////// Hour with decimal point ///// ex:5.5h ///////
          $result = $this->Location_dashboard_model->getTimeRange($i,$timeTemplId);
          if(!empty($result)){
            if(strtotime($currentTime) > strtotime($result[0]->startTime) && strtotime($currentTime) < strtotime($result[0]->endTime)){
              $result[0]->currentHour = new stdClass();
              $result[0]->currentHour = $cHour;
              return $result;
            }
          }else{
            if($decimalMin !=0){
              if(($i+$decimalMin) == $maxHrs){
                return  $this->getTeamTimeForDecimalValue($roundDownHour,$maxHrs);
              }
            }
          }
        }
      }

    }

  public function getTeamTimeForDecimalValue($roundDownHour,$maxHrs){
    $currentTime  = date('H:i:s');
    $min = $this->minuteForHour / ($maxHrs-$roundDownHour);
    $min = '+'.$min.' minutes';
    $timeTemplId = $this->timeTemplId;
    $result = $this->Location_dashboard_model->getTimeRange($roundDownHour,$timeTemplId);
    $data = array();
    if(!empty($result)){
      if(strtotime($currentTime) > strtotime($result[0]->startTime) && strtotime($currentTime) < strtotime($result[0]->endTime)){
        $data[0]->startTime = new stdClass();
        $data[0]->startTime = $result[0]->endTime;
        $data[0]->endTime = new stdClass();
        $data[0]->endTime = date("H:i:s", strtotime($min,$result[0]->endTime));
        $data[0]->currentHour = new stdClass();
        $data[0]->currentHour = $maxHrs+$roundDownHour;
        return $data;
      }
    }
  }

    ////// Get the time different from two hours /////
    public function get_time_difference($time1, $time2){

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
    public function getPrevHourProd($currentHour,$planHour){
        $preHour = 0;
        $decimalMin = 0;
        if ($currentHour < $planHour) {

          $roundDownHour = floor($currentHour);
          $decimalMin = $currentHour - $roundDownHour;
          if($decimalMin!= 0){
            $preHour = $roundDownHour;
          }else{
            $preHour = $currentHour - 1;
          }

        } else {
          $roundDownHour = floor($planHour);
          $decimalMin = $planHour - $roundDownHour;

          if($decimalMin!= 0){
            $preHour = $roundDownHour;
          }else{
            $preHour = $planHour - 1;
          }
        }

        // echo $planHour."--";

        $data = array(
            'hour' => $preHour
        );

        return $data;

    }

    ///// Get planned Efficiency //////
    public function getTargetEffi($style, $smv){
        $styleRunDays = $this->Location_dashboard_model->getStyleRunDays($style);

        $this->styleRunDatys = $styleRunDays['num_rows'];
        $needEff = $this->Location_dashboard_model->needRuningDaysEffi($styleRunDays['num_rows'], $smv,$this->location);
        if(!empty($needEff)){
            return $needEff;
        }else{
          return '';
        }
    }

    public function getEfficiency($workingMin,$actualOutQty,$smv,$noOfwokers){

        $produceMin = $actualOutQty * (double)$smv;
        //// Team Produce Min ////
        $this->teamProduceMin += $produceMin;
        //// Factory All Produce Min ////
        $this->factryProduceMin += $produceMin;

        $usedMinu = ((double)$noOfwokers * $workingMin);
          //// Team used Min ////
        $this->teamUsedMin += $usedMinu;
        ////Factry all Use Min /////////
        $this->factryUsedMini += $usedMinu;

        $lineEffi = (double)($this->teamProduceMin / $this->teamUsedMin) * 100;
        $styleEff = (double)($produceMin / $usedMinu) * 100;

        // print_r($data);

        return $data = array(
          'lineEffi' => (number_format((float)$lineEffi, 2, '.', '')),
          'styleEff' => (number_format((float)$styleEff, 2, '.', ''))
        );
    }

    /////// Get Incentive /////
    public function getIncentive($currentEfficiency, $targetEfficiency, $baseAmount, $increPrecent, $increAmount,$reductPrecent, $reductAmount,$teamId,$smv,$styleRunDay){
      $incentive = 0;


      $roundDownEffi = floor($currentEfficiency);
      $roundUpStartNu = $this->getRoundUpstart($teamId);

      $checkingValue = $roundDownEffi + $roundUpStartNu;
      $decimalValue = (double)$currentEfficiency - $roundDownEffi;

        $data = $this->getBaseAmountAndDayBaseAmount($smv);

        if(!empty($data)){
          if($data['runDay'] < $styleRunDay){
            if((($data['baseEff'] - 1) + $roundUpStartNu) <= $currentEfficiency  && (($targetEfficiency - 1) + $roundUpStartNu) >= $currentEfficiency ){
              $targetDiffEfficiency  = $currentEfficiency - $data['baseEff'];
              $roundDiffEffi =   $this->roundEff($targetDiffEfficiency,$roundUpStartNu);
              $reduceAmount =   $roundDiffEffi * $reductAmount;

              return $baseAmount - $reduceAmount;
            }

          }
        }


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
          if ($reductPrecent != 0) {
              $incrementIncentive = (round(($reductPrecDiff / $increPrecent), 0, PHP_ROUND_HALF_DOWN)) * $reductAmount;
              $incentive -= $incrementIncentive;

              if ($incentive < 0) {
                  $incentive = 0;
              }
          }
      }
      return $incentive;
    }

    public function getQrLevel($location){
        $qrLevel = $this->Location_dashboard_model->getQrLevel($location);
        if($qrLevel){
            return $qrLevel[0]->qr_level;
        }else{
            return 0;
        }
    }

    public function getNeededQtyAtTime($totalHour,$currentTimeFromMin,$targtQty){

        $oneMinQty = $targtQty/($totalHour*60);
        $neededQty = $currentTimeFromMin*$oneMinQty;

        return $neededQty;

    }


    public function getWorkerCount($teamId){
        return $this->Location_dashboard_model->getWorkerCount($teamId);
    }

    public function getMinutForHour($location){
      $result = $this->Location_dashboard_model->getMinutForHour($location,'Production');
      return $result[0]->minuuteForHour;
    }

    public function getBaseAmountAndDayBaseAmount($smv){
      $baseEffi = $this->Location_dashboard_model->getBaseEffi($smv,$this->location);
      if(!empty($baseEffi)){
        $day = $this->Location_dashboard_model->getBaseAmountAndDayBaseAmount($smv,$baseEffi[0]->base_line_amount,$this->location);
        $baseEfficent = $baseEffi[0]->base_line_amount;
        if($day){
          $runDay = $day[0]->days;
          $baseAmount = $day[0]->base_amount;
        }

        $data = array(
          'baseEff'=>$baseEfficent,
          'runDay'=>$runDay,
          'baseAmount'=>$baseAmount
        );
      }else{
        $data=array();
      }

      return $data;

    }

    public function roundEff($effi,$roundUpNu){
      $roundDownEffi = floor($effi);
      $roundUpStartNu = $roundUpNu;

      $checkingValue = $roundDownEffi + $roundUpStartNu;
      $decimalValue = (double)$currentEfficiency - $roundDownEffi;

      if ($decimalValue >= $roundUpStartNu) {
        $roundEffi = $roundDownEffi + 1;
      } else {
        $roundEffi = $roundDownEffi;
      }

      return $roundEffi;
    }


    public function getMonthlyEffi($minuteForHour,$locationId){
      $result = $this->Location_dashboard_model->getMonthlyEffi($minuteForHour,$locationId);
      if($result){
        return $result;
      }else{
        return '';
      }

    }


}
