<?php

class Tv_production_model extends CI_model{


    //// Get otherDayPlan Hour as current date and team ///
    public function getOtherDayPlan($teamId,$dayPlanId){
        $date = date('Y-m-d');

        $sql = "SELECT DISTINCT
                  `line`,
                  `hrs` AS workedHours
                FROM
                  `day_plan`
                WHERE `dayPlanType` != '2' AND `status` != '3'
                  AND DATE(`createDate`) = '$date'
                  AND `line` = '$teamId'
                  AND `id` != '$dayPlanId'";

        return $this->db->query($sql)->result();

    }




}
