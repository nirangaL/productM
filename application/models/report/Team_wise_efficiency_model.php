<?php


class Team_wise_efficiency_model extends CI_model{

    public function getLocation(){
        $sql = "SELECT * FROM `location` WHERE active = '1'";
        return $this->db->query($sql)->result();
    }


    public function getTableData($date,$location){
        $sql = "SELECT
                day_efficiency.*,
                day_plan.`forecastEffi`,
                prod_line.`line`,
                `location`.`location`,
                (SELECT minuuteForHour FROM mstr_department WHERE location ='$location' AND department ='Production') AS minuuteForHour,
                (SELECT buyer FROM temp_accller_view WHERE style = day_efficiency.`style` GROUP BY style) AS buyer
              FROM
                `day_efficiency`
                JOIN day_plan 
                  ON day_efficiency.`dayPlanId` = day_plan.`id`
                JOIN `prod_line`
                  ON `day_efficiency`.`lineId` = prod_line.`line_id`
                JOIN `location`
                  ON `location`.`location_id` = `prod_line`.`location_id`
              WHERE DATE(day_efficiency.`dateTime`) = '$date'
                AND location.`location_id` = '$location'";

        return $this->db->query($sql)->result();
    }



}
