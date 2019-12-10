<?php

// error_reporting(-1);
// ini_set('display_errors', 1);

defined('BASEPATH') or exit('No direct script access allowed');

class Tv_Production_Con extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('cookie');
        $this->location = get_cookie('location');
        $this->team = get_cookie('line');
        // $this->load->library('Production_dashboard_library');
        $this->load->model('tv/Tv_production_model');

    }

    public function index()
    {
        if ($this->location == '' || $this->team == '') {
            redirect(base_url("Profile_App_Con/index?from=prod_tv"), 'refresh');
        } else {
            $this->load->view('tv/tv_production_team');
        }
    }

    public function getTeamData()
    {
        $date = date('Y-m-d');
        
        // $params = array('location' => $this->location, 'team' => $this->team, 'date' => $date);
        $this->load->library('production_dashboard_library');
        $teamData = $this->production_dashboard_library->get_team_data($this->location,$this->team,$date);

        $dayPlanCount = sizeOf($teamData['teamData']);
        $data = '';
        $style ='';
        for ($i = 0; $i < $dayPlanCount; $i++) {
           
            // echo '<pre>';
            // print_r($teamData);
            // echo '</pre>';
             
                if($teamData['teamData'][$i]['dayPlanType']=='4'){
                    if($style != ''){
                        $style =  $style.' & '.$teamData['teamData'][$i]['style'];
                    }else{
                        $style = $teamData['teamData'][$i]['style'];
                    }
                }else{
                    $style = $teamData['teamData'][$i]['style'];
                }
                 
                $data['teamData'] = array(
                    'whatData' => $teamData['teamData'][$i]['whatData'],
                    'lineName' => $teamData['teamData'][$i]['lineName'],
                    'dayPlanType' => $teamData['teamData'][$i]['dayPlanType'],
                    'runStatus' => $teamData['teamData'][$i]['runStatus'],
                    'style' => $style,
                    'dayPlanQty' => $teamData['teamData'][$i]['dayPlanQty'],
                    'hrs' => $teamData['teamData'][$i]['hrs'],
                    'currentHr' => $teamData['teamData'][$i]['currentHr'],
                    'lineOutQty' => $teamData['teamData'][$i]['totalPassQty'],
                    'needOutQtyHr'=> $teamData['teamData'][$i]['needOutQtyHr'],
                    'teamHrsOutQty' => $teamData['teamData'][$i]['teamHrsOutQty'],
                    'preHour' => $teamData['teamData'][$i]['preHour'],
                    'preHourPassQty' => $teamData['teamData'][$i]['preHourPassQty'],
                    'statusTeamTv' => $teamData['teamData'][$i]['statusTeamTv'],
                    'ForEff' => $teamData['teamData'][$i]['ForEff'],
                    'actEff' => $teamData['teamData'][$i]['actEff'],
                    'rejectQty' => $teamData['teamData'][$i]['rejectQty'],
                    'remakeQty' => $teamData['teamData'][$i]['remakeQty'],
                    'actualQrLevel' => $teamData['teamData'][$i]['actualQrLevel'],
                    'incentive' => $teamData['teamData'][$i]['incentive'],
                    'styleRunDays' => $teamData['teamData'][$i]['showRunningDay'],
                    'noOfwokers' => $teamData['teamData'][$i]['noOfwokers'],
                    'neededQtyAtTime' => $teamData['teamData'][$i]['neededQtyAtTime'],
                    'needQrLvl' => $teamData['teamData'][$i]['needQrLvl'],
                    'minuteForHour' => $teamData['teamData'][$i]['minuteForHour'],
                    'timeForTimeCountDown' => $teamData['teamData'][$i]['timeForTimeCountDown'],
                    'hourStartTime' => $teamData['teamData'][$i]['hourStartTime'],
                );

            if($teamData['teamData'][$i]['dayPlanType'] != "4" && $teamData['teamData'][$i]['runStatus']=="1"){
                break;
            }
        }

         echo json_encode($data);

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
       

    }

}
