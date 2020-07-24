<?php
//
// error_reporting(-1);
// ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class ManualQcOutEnter extends MY_Controller{
    private $location;
    private $oldDayPlanId = 0;

    function __construct(){
        parent::__construct();
        $this->checkSession();
        $this->location = $this->myConlocation;
        $this->load->model('Style_model');
        $this->load->model('Manual_qc_out_enter_model');
    }

  public function index(){

    $data['teams'] = $this->Manual_qc_out_enter_model->getTeams($this->location);
    $data['style'] = $this->Style_model->getStyle();

      $this->load->view('template/header',$data);
      $this->load->view('template/sidebar');
      $this->load->view('workstudy/manual_qc_out_enter_view');
      $this->load->view('template/footer');
  }

  public function getPassDefectQty(){
    $result = $this->Manual_qc_out_enter_model->getPassDefectQty();

    if(!empty($result)){
      echo json_encode($result);
    }else{
        echo '';
    }

  }

  public function doCalculate(){
    $noOfWorkers = $this->input->post('workrs');
    $hour = $this->input->post('hour');
    $passQty = $this->input->post('passQty');
    $smv = $this->input->post('smv');
    $runDays = $this->input->post('runday');
    $incentiveEffi = $this->input->post('incentiveEffi');
    $defectQty = $this->input->post('defectQty');
    $team = $this->input->post('team');
    $incentiveHour = $this->input->post('incenHour');
    $style = $this->input->post('style');
    
    $result['new'] = $this->calculate($style,$team,$noOfWorkers,$hour,$passQty,$smv,$runDays,$incentiveEffi,$defectQty,$incentiveHour);
    $result['old'] = $this->getEffectedOtherDayPlan();

    echo json_encode($result);

  }

  public function calculate($style,$team,$noOfWorkers,$hour,$passQty,$smv,$runDays,$incentiveEffi,$defectQty,$incentiveHour){
   ////// calaculate Effiency //////
 
   $minuteForHour = $this->Manual_qc_out_enter_model->getMinuteForHour($this->location);

  //     echo $smv;

   $effi = (($passQty*$smv)/($noOfWorkers*($minuteForHour*$hour)))*100;
   $effi = number_format((float)$effi, 2, '.', '');

    ///// get Incentive  ///////
    
    $needEff = $this->getTargetEffi($smv,$runDays);
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

    //// Calculate Qr Level
   
    $qrLevelNeed = $this->getQrLevel();
    $actualQrLevel = $this->calculateQrLevel($passQty,$defectQty);
    if($actualQrLevel >= 100){
             $actualQrLevel = 100;
    }else{
            $actualQrLevel = number_format((float) $actualQrLevel, 2, '.', '');
    }

    //// Get Incentive 
    
    if ($qrLevelNeed <= $actualQrLevel && $targetEfficiency != 0) {
        $incentive = $this->getIncentive($effi, $targetEfficiency, $baseAmount, $increPrecent, $increAmount, $reductPrecent, $reductAmount, $team, $smv, $runDays);
        $ince_hour = $incentiveHour;
        if ($ince_hour != 0) {
            $incentive = ($incentive / ($ince_hour * $minuteForHour)) * ($hour * $minuteForHour);
        }
    } else {
        $incentive = 0;
    }


    $data = array(
        'style'=>$style,
        'qty' => $passQty,
        'producedMin'=> number_format((float)($passQty*$smv), 2, '.', ''),
        'usedMin'=>number_format((float)($minuteForHour*$hour), 2, '.', ''),
        'effi'=>$effi,
        'defectQty'=>$defectQty,
        'qrLvl'=>$actualQrLevel,
        'incentive'=>$incentive,
    );

    return $data;


    }

 //// Get target efficiency from ladder ////
 public function getTargetEffi($smv,$styleRunDays){

     $needEff = $this->Manual_qc_out_enter_model->needRuningDaysEffi($styleRunDays,$smv, $this->location);
     if (!empty($needEff)) {
         return $needEff;
     } else {
         return '';
     }
 }


  /////// Get Incentive /////
  public function getIncentive($currentEfficiency,$targetEfficiency,$baseAmount,$increPrecent,$increAmount,$reductAmount)
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

      $result = $this->Manual_qc_out_enter_model->getRoundUpstart($this->location);
      if ($result) {
          return $result[0]->effi_roundup_start;
      } else {
          return 0.5;
      }
  }

  public function calculateQrLevel($actulaOutQty, $defectQty)
  {

        // echo (int) $actulaOutQty.'  ' ;

        $actualQrLevel = 100 - (((int) $defectQty / ((int) $actulaOutQty + (int) $defectQty)) * 100);
        $actualQrLevel = number_format((float) $actualQrLevel, 2, '.', '');
        if ($actualQrLevel == 100.00) {
            $actualQrLevel = '100';
        }

        return $actualQrLevel;
  }

  public function getQrLevel(){
        //// get allow qr level from db/////
        $qrLevel = $this->Manual_qc_out_enter_model->getQrLevel($this->location);
        if ($qrLevel) {
            return $qrLevel[0]->qr_level;
        } else {
            return 0;
        }

  }

  public function getEffectedOtherDayPlan()
  {
    $team = $this->input->post('team');
    $style = $this->input->post('style');
    $passQty = $this->input->post('passQty');
    $defectQty = $this->input->post('defectQty');
    $enterDate = $this->input->post('enterdDate');
    $oldData = '';
    /////Recalculate Old Dayplan ///////
    $oldDayPlan  = $this->getOldDayPlan($team,$style,$enterDate);
   
    // print_r($oldDayPlan);
   
    if(!empty($oldDayPlan)){
     $oldNoOfWorkers = $oldDayPlan[0]->workersCount;
     $oldHour = $oldDayPlan[0]->workingHour;
     $oldpassQty = $oldDayPlan[0]->passQty - (int)$passQty;
     $oldSmv = $oldDayPlan[0]->smv;
     $oldRunDay = $oldDayPlan[0]->runDay;
     $oldIncentiveEff = $oldDayPlan[0]->incenEffi;
     $oldDefectQty = (int)$oldDayPlan[0]->defectQty - (int)$defectQty;
     $oldIncentiveEff = $oldDayPlan[0]->incentiveHour;
     $this->oldDayPlanId = $oldDayPlan[0]->id;
   
     ////// calculate old day plan again and update //////
     $oldData =  $this->calculate($style,$team,$oldNoOfWorkers,$oldHour,$oldpassQty,$oldSmv,$oldRunDay,$oldIncentiveEff,$oldDefectQty,$oldIncentiveEff);
    }
    return $oldData;
  }

    ////save data //////
   public function setData(){

        $oldData = $this->getEffectedOtherDayPlan();

       $updateOldDayEff = $this->Manual_qc_out_enter_model->updateOldDayEffi($oldData,$this->oldDayPlanId);

       ////// Save maunal enterd data to DayPlan //////
       $dayPlanId = $this->Manual_qc_out_enter_model->saveDayPlan($this->location,$this->myConUserName);
       $saveManualDayEffi = $this->Manual_qc_out_enter_model->saveManualData($this->location,$dayPlanId);
       ///// Get and calculet old dayplan data and recalculate ////
       
       if($saveManualDayEffi){
        echo 'ok';
       }else{
           echo 'error';
       }

    }

    public function getOldDayPlan($team,$style,$enterDate){

        $result  = $this->Manual_qc_out_enter_model->getOtherDayPlan($team,$style,$enterDate);

        return $result;
    }






}