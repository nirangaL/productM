<?php

class Manual_qc_out_enter_model extends CI_model{

    public function getTeams($location){
        $sql = "SELECT line_id AS teamId,line AS team FROM `prod_line` WHERE location_id = '$location' AND active='1' ORDER BY `line` REGEXP '^[a-z]' DESC,`line`";
        return $this->db->query($sql)->result();
    }

    public function updateCompany($comp_id){
        $company = $this->input->post('cName');
        $address = $this->input->post('cAddress');
        $country = $this->input->post('cCountry');
        $phone = $this->input->post('phone');
        $web = $this->input->post('web');
        $email = $this->input->post('email1');
        $email2 = $this->input->post('email2');

        $data = array(
            'company' => $company,
            'address'=> $address,
            'phone' => $phone,
            'email' =>$email,
            'email2'=> $email2,
            'web' => $web,
            'country' => $country,
            'active' =>'1'
        );

        $this->db->trans_start();
            $this->db->set($data);
            $this->db->where('comp_id',$comp_id);
            $this->db->update('comp_profile');
        return $this->db->trans_complete();exit();

    }

    public function getPassDefectQty(){
     $team  = $this->input->post('team');
     $style  = $this->input->post('style');
     $enterdDate  = $this->input->post('enterdDate');
     $fromDate  = $this->input->post('fromDate');
     $fromTime  = $this->input->post('fromTime');
     $toDate  = $this->input->post('toDate');
     $toTime  = $this->input->post('toTime');

     $fromDateTime = $fromDate.' '.$fromTime;
     $toDateTime  = $toDate.' '.$toTime;
     $fromDateTime =  date("Y-m-d H:i:s",strtotime($fromDateTime));
     $toDateTime =  date("Y-m-d H:i:s",strtotime($toDateTime));
    
    $sql = "SELECT
            COUNT(pslg.id) AS passQty,
            (SELECT COUNT(rlg.rejectId)  AS defectQty FROM qc_reject_log rlg WHERE rlg.chckHeaderId = hd.`id` AND rlg.`dateTime` BETWEEN '$fromDateTime'
            AND '$toDateTime') AS defectQty
        FROM
        checking_header_tb hd
            LEFT JOIN  qc_pass_log pslg
            ON hd.`id` = pslg.`chckHeaderId`
        WHERE hd.`lineNo` = '$team'
            AND hd.`style` = '$style'
            AND pslg.`dateTime` BETWEEN '$fromDateTime'
            AND '$toDateTime' GROUP BY hd.`id`";

            // echo $sql;

        return $this->db->query($sql)->result();

    }


    public function getMinuteForHour($location){
        
        $sql = "SELECT
            minuuteForHour
        FROM
            `mstr_department`
        WHERE department = 'Production'
            AND location = '2'";

        $result =  $this->db->query($sql)->result();
        return $result[0]->minuuteForHour;

    }

    ///// get style runday efficiency from ladder /////
    public function needRuningDaysEffi($runingDays,$smv,$location){
        $sql = "SELECT efficiency,base_amount,incre_percent,incre_amount,decre_percent,reduct_amount FROM incentive_ladderid WHERE smv_start <= '$smv' AND smv_end > '$smv' AND days = '$runingDays' AND `locationId` = '$location'";
        return $this->db->query($sql)->result();
    }

    /////// Efficency Round up ////////
    public function getRoundUpstart($location){
       $sql = "SELECT
                effi_roundup_start
                FROM
                `mstr_department`
                WHERE department = 'Production'
                AND location = '2'";
                return $this->db->query($sql)->result();
    }


     //// get qr level from db/////
     public function getQrLevel($location){
        $sql = "SELECT qr_level FROM `qr_level` WHERE location_id = '$location'";
        return $this->db->query($sql)->result();
    }

    public function getOtherDayPlan($team,$style,$enterDate){
        $sql = "SELECT
                de.id,
                de.lineId,
                de.style,
                de.smv,
                de.actualOutQty AS passQty,
                de.runDay,
                de.workersCount,
                de.workingHour,
                dp.`forecastEffi`,
                dp.`incentiveHour`,
                dp.`incenEffi`,
                de.incentive,
                de.defectQty
            FROM
                day_efficiency de
                INNER JOIN day_plan AS dp ON de.`dayPlanId` = dp.`id`
            WHERE de.lineId = '$team'
                AND de.style = '$style'
                AND DATE(de.`dateTime`) = '$enterDate'";

                // exit($sql);

                return $this->db->query($sql)->result();
     }



     ////Save A DayPlan //////
    public function saveDayPlan($location,$user){

      
        $data = array(
            'line' => $team = $this->input->post('team'),
            'dayPlanType'  => '1',
            'timeTemplate'  => '0',
            'style'  => $this->input->post('style'),
            'runningDay'  => $this->input->post('runday'),
            'showRunningDay'  => $this->input->post('runday'),
            'dayPlanQty'  => $this->input->post('planQty'),
            'hrs'  => $this->input->post('hour'),
            'smv'  => $this->input->post('smv'),
            'noOfwokers'  => $this->input->post('workrs'),
            'sysEffi'  => $this->input->post('forcastEffi'),
            'incenEffi'  => $this->input->post('incentiveEffi'),
            'incentiveHour'  => $this->input->post('incentiveEffi'),
            'forecastEffi'  => $this->input->post('forcastEffi'),
            'status'  => '1',
            'feedingHour'  => '0',
            'location'  => $location,
            'createBy'  => $user,
            'createDate'  => $this->input->post('enterdDate').' '.date('H:i:s'),
        );
        // echo '<pre>';
        // print_r($data);

        $this->db->insert('day_plan', $data);
        return $this->db->insert_id();
    }

    public function updateOldDayEffi($oldData,$oldDayPlanId){
        $data = array(
            'actualOutQty' => $oldData['qty'],
            'efficiency'  => $oldData['effi'],
            'defectQty'  => $oldData['defectQty'],
            'qr_level'  => $oldData['qrLvl'],
            'incentive'  => $oldData['incentive'],
        );

        // echo '<pre>';
        // print_r($oldDayPlanId);

        $this->db->where('id',$oldDayPlanId);
        $this->db->update('day_efficiency', $data);
    }

    public function saveManualData($location,$dayPlanId){

        $data = array(
            'locationId' => $location,
            'lineId'  => $this->input->post('team'),
            'dayPlanId'=>$dayPlanId,
            'timeTemplate'=>0,
            'style'=>$this->input->post('style'),
            'smv'=>$this->input->post('smv'),
            'runDay'=>$this->input->post('runday'),
            'totalPlanQty'=>$this->input->post('planQty'),
            'actualOutQty'=>$this->input->post('passQty'),
            'workersCount'=>$this->input->post('workrs'),
            'workingHour'=>$this->input->post('hour'),
            'forcastEffi'=>$this->input->post('forcastEffi'),
            'efficiency'=>$this->input->post('effi'),
            'incentive'=>$this->input->post('incentive'),
            'defectQty'=>$this->input->post('defectQty'),
            'qr_level'=>$this->input->post('qrLvl'),
            'dateTime'=>$this->input->post('enterdDate').' '.date('H:i:s'),
        );

        // echo '<pre>';
        // print_r($data);       
      return  $this->db->insert('day_efficiency', $data);
    }


}