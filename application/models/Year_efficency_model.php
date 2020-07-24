<?php

class year_efficency_model extends CI_model{

    public function getLocations(){
        $sql = "SELECT location_id as id ,`location` FROM `location` WHERE active = '1'";
        return $this->db->query($sql)->result();
    }

    public function getYears(){
       $sql = "SELECT
                DATE_FORMAT(`dateTime`, '%Y') AS `year`
                FROM
                `day_efficiency`
                -- WHERE locationId = '2'
                GROUP BY DATE_FORMAT(`dateTime`, '%Y')";
        return $this->db->query($sql)->result();
    }
    
    public function getYearData($location,$year){
        
        $sql = "SELECT
        pl.`line_id`,
        pl.`line`,
        IFNULL(dp.`dayPlanType`, 0) dayPlanType,
        de.style,
        IFNULL(de.smv, 0) smv,
        de.orderQty,
        de.`workingHour`,
        de.totalPlanQty,
        de.actualOutQty,
        IFNULL(de.workersCount, 0) workersCount,
        IFNULL(de.forcastEffi, 0) forcastEffi,
        de.efficiency,
        de.qr_level,
        DATE_FORMAT(de.`dateTime`, '%Y') `year`,
        DATE_FORMAT(de.`dateTime`, '%m') `month`,
        DATE(de.`dateTime`) `dateTime`
      FROM
        `day_efficiency` de
        LEFT JOIN `prod_line` pl
          ON de.`lineId` = pl.`line_id`
          INNER JOIN `day_plan` dp ON de.`dayPlanId` = dp.`id`
      WHERE de.`locationId` = '$location'
        AND DATE_FORMAT(de.`dateTime`, '%Y') = '$year'
        AND de.smv != ''
      ORDER BY DATE(de.`dateTime`)";

    return $this->db->query($sql)->result();

    }

    //// team second for hour /////
    public function getMinutForHour($location,$dep){

        $sql = "SELECT
        minuuteForHour AS minuteForHour
        FROM
        mstr_department
        WHERE location = '$location'
        AND department = '$dep'";
  
        $result = $this->db->query($sql)->result();
        if($result ){
            return $result[0]->minuteForHour;
        }else{
            return 60;
        }
        

    }

}