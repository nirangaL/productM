<?php

class Style_size_wise_model extends CI_model{

    // // public function getTableData($style,$delivery,$team){
    // //     $sql = " SELECT
    // //             `style_Info`.`styleNo` AS style
    // //             , `style_Info`.`deliveryNo` AS delivery
    // //             , `style_Info`.`orderQty` 
    // //             , `style_Info`.`size` AS defineSize
    // //             , `style_Info`.`qty` AS orderSizeQty
    // //             , `checking_grid_tb`.`size` 
    // //             , SUM(`checking_grid_tb`.`passQty` ) AS passQty
    // //             , `checking_header_tb`.`lineNo`
    // //             , `prod_line`.`line` AS lineName
    // //             , location.`location`
    // //         FROM
    // //             `intranet_db`.`checking_header_tb`
    // //             LEFT JOIN `intranet_db`.`style_Info`
    // //                 ON (`style_Info`.`styleNo` = `checking_header_tb`.`style`)
    // //             INNER JOIN `intranet_db`.`checking_grid_tb` 
    // //                 ON (`style_Info`.`size` = `checking_grid_tb`.`size`) AND (`checking_header_tb`.`id` = `checking_grid_tb`.`chckHeaderId`)
    // //             INNER JOIN `intranet_db`.`prod_line`
    // //                 ON (`checking_header_tb`.`lineNo` = `prod_line`.`line_id`)
    // //                  INNER JOIN `intranet_db`.`location` 
    // //     ON (`prod_line`.`location_id` = `location`.`location_id`) ";

    // //     if($delivery == 'all' &&  $team == 'all'){
    // //         $sql .= " WHERE style = '$style' GROUP BY defineSize";
    // //     }

    // //     if($delivery != 'all' && $team =='all'){
    // //         $sql .= " WHERE style = '$style' AND deliveryNo = '$delivery' GROUP BY defineSize";
    // //     }

    // //     if($team != 'all' && $delivery =='all'){
    // //         $sql .= " WHERE style = '$style' AND lineNo = '$team'  GROUP BY defineSize";
    // //     }

    // //     if($team != 'all' && $delivery !='all'){
    // //         $sql .= " WHERE style = '$style' AND deliveryNo = '$delivery' AND lineNo = '$team' GROUP BY defineSize";
    // //     }

    //     return $this->db->query($sql)->result();
    // }

    public function getTableData($style){

        $sql = "SELECT
        sinfo.`styleNo` AS style,
        sinfo.deliveryNo AS delv,
        sinfo.orderQty AS delvOrderQty,
        sinfo.garmentColour AS `color`,
        sinfo.`size`,
        IFNULL(sinfo.`qty`,0) AS orderQty,
        IFNULL(SUM(ct.`inputQty`),0) AS cutInQty,
        IFNULL(SUM(input.`inputQty`),0) AS issueQty,
        IFNULL(SUM(ot.qty),0) AS outQty
      FROM
      style_Info sinfo
       LEFT JOIN `line_cutin_view` ct ON (sinfo.`styleNo` = ct.`style`) AND (sinfo.`deliveryNo` = ct.`delv`) AND (sinfo.`garmentColour` = ct.`color`) AND (sinfo.`size` = ct.`size`)
        LEFT JOIN `line_issue_view` input ON (sinfo.`styleNo` = input.`style`) AND (sinfo.`deliveryNo` = input.`delv`) AND (sinfo.`garmentColour` = input.`color`) AND (sinfo.`size` = input.`size`)
        LEFT JOIN `line_out_view` ot ON (sinfo.`styleNo` = ot.`style`) AND (sinfo.`deliveryNo` = ot.`delv`) AND (sinfo.`garmentColour` = ot.`color`) AND (sinfo.`size` = ot.`size`) 
        WHERE sinfo.`styleNo` = '$style' GROUP BY sinfo.`size`,sinfo.garmentColour,sinfo.deliveryNo ORDER  BY sinfo.deliveryNo,sinfo.garmentColour,sinfo.`size`";

        return $this->db->query($sql)->result();

    }

}