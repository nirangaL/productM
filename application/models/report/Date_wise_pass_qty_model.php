<?php

class Date_wise_pass_qty_model extends CI_model{

    public function getTeam($location){
        $sql = "SELECT
                line_id AS teamId,
                line AS team
            FROM
                prod_line
            WHERE location_id = '$location'
                AND permnt_inactive = '0' ORDER BY `line` ASC";

        return $this->db->query($sql)->result();
    }

    public function getTableData($team,$date){

        $date = date("Y-m-d",strtotime($date));

            $sql = "SELECT 
                pl.line, 
                hd.style,
                hd.`scNumber`,
                grd.delivery,
                grd.color,
                grd.size,
                grd.passQty
                FROM `checking_header_tb` hd
                LEFT JOIN `checking_grid_tb`grd ON hd.`id` = grd.`chckHeaderId` 
                LEFT JOIN `prod_line` pl ON hd.`lineNo` = pl.`line_id`
                WHERE DATE(hd.`dateTime`) = '$date'";

                if($team == 'All'){
                    $sql.= " AND hd.`location` = '$this->myConlocation'";
                }else{
                    $sql.= " AND lineNo = '$team'";
                }

                $sql.=" GROUP BY grd.`size`, grd.`color`, grd.`delivery`,hd.`style`";

          return $this->db->query($sql)->result();

    }

}