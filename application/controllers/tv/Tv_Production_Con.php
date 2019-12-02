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
        
        $totalPlanQty = 0;
        $totalPassQty = 0;
        $totalRemake = 0;
        $totalDefect = 0;

        $totalProduceMin = 0;
        $totalUsedMin = 0;
        $totalEffi = 0;

        $params = array('location' => $this->location, 'team' => $this->team, 'date' => $date);
        $this->load->library('production_dashboard_library', $params);
        $teamData = $this->production_dashboard_library->get_team_data();

        $dayPlanCount = sizeOf($teamData['teamData']);
        $data = '';

        for ($i = 0; $i < $dayPlanCount; $i++) {

            if($teamData['teamData'][$i]['runStatus'] == '1'){
                $totalPlanQty = $teamData['teamData'][$i]['dayPlanQty'];
                $totalPassQty = $teamData['teamData'][$i]['totalPassQty'];
                $totalRemake = $teamData['teamData'][$i]['remakeQty'];
                $totalDefect = $teamData['teamData'][$i]['rejectQty'];
                $totalEffi = $teamData['teamData'][$i]['actEff'];
            }else if ($teamData['teamData'][$i]['dayPlanType'] == '4' ) {
                $totalPlanQty += $teamData['teamData'][$i]['$dayPlanQty'];
                $totalPassQty += $teamData['teamData'][$i]['$passQty'];
                $totalRemake += $teamData['teamData'][$i]['remakeQty'];
                $totalDefect += $teamData['teamData'][$i]['rejectQty'];
                $totalDefect += $teamData['teamData'][$i]['rejectQty'];
                $totalDefect += $teamData['teamData'][$i]['rejectQty'];
                $totalProduceMin += $teamData['teamData'][$i]['teamProduceMin'];
                $totalUsedMin += $teamData['teamData'][$i]['teamUsedMin'];
                if($totalUsedMin != 0 && $totalProduceMin != 0){
                    $totalEffi = ($totalProduceMin / $totalUsedMin) * 100;
                }
            }
        }
        
        for ($i = 0; $i < $dayPlanCount; $i++) {
           
            // echo '<pre>';
            // print_r($teamData);
            // echo '</pre>';

            // echo $teamData['teamData'][$i]['runStatus'];
            if($teamData['teamData'][$i]['runStatus'] == '1'){

                $data['teamData'] = array(
                    'whatData' => $teamData['teamData'][$i]['whatData'],
                    'lineName' => $teamData['teamData'][$i]['lineName'],
                    'dayPlanType' => $teamData['teamData'][$i]['dayPlanType'],
                    'runStatus' => $teamData['teamData'][$i]['runStatus'],
                    'style' => $teamData['teamData'][$i]['style'],
                    'delivery' => $teamData['teamData'][$i]['delivery'],
                    'orderQty' => $teamData['teamData'][$i]['orderQty'],
                    'dayPlanQty' => $totalPlanQty,
                    'hrs' => $teamData['teamData'][$i]['hrs'],
                    'currentHr' => $teamData['teamData'][$i]['currentHr'],
                    'lineOutQty' => $totalPassQty,
                    'needOutQtyHr'=> $teamData['teamData'][$i]['needOutQtyHr'],
                    'teamHrsOutQty' => $teamData['teamData'][$i]['teamHrsOutQty'],
                    'preHour' => $teamData['teamData'][$i]['preHour'],
                    'preHourPassQty' => $teamData['teamData'][$i]['preHourPassQty'],
                    'statusTeamTv' => $teamData['teamData'][$i]['statusTeamTv'],
                    'ForEff' => $teamData['teamData'][$i]['ForEff'],
                    'actEff' => (double) $totalEffi,
                    'rejectQty' => $teamData['teamData'][$i]['rejectQty'],
                    'remakeQty' => $teamData['teamData'][$i]['remakeQty'],
                    'actualQrLevel' => $teamData['teamData'][$i]['actualQrLevel'],
                    'incentive' => $teamData['teamData'][$i]['incentive'],
                    'styleRunDays' => $teamData['teamData'][$i]['styleRunDays'],
                    'neededQtyAtTime' => $teamData['teamData'][$i]['neededQtyAtTime'],
                    'needQrLvl' => $teamData['teamData'][$i]['needQrLvl'],
                    'minuteForHour' => $teamData['teamData'][$i]['minuteForHour'],
                    'timeForTimeCountDown' => $teamData['teamData'][$i]['timeForTimeCountDown'],
                    'hourStartTime' => $teamData['teamData'][$i]['hourStartTime'],
                );
            }

        }

         echo json_encode($data);

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
       

    }

}
