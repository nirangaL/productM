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
        ct.`style`,
        ct.`delv`,
        ct.`color`,
        ct.`size`,
        IFNULL(ct.`inputQty`,0) AS cutInQty,
        IFNULL(input.`inputQty`,0) AS issueQty,
        IFNULL(ot.qty,0) AS outQty,
        ct.`teamName`,
        ct.`location`
      FROM 
      `line_cutin_view` ct
        JOIN `line_issue_view` input ON (ct.`style` = input.`style`) AND (ct.`delv` = input.`delv`) AND (ct.`color` = input.`color`) AND (ct.`size` = input.`size`) AND (ct.`teamId` = input.`teamId`)
        JOIN `line_out_view` ot ON (input .`style` = ot.`style`) AND (input .`delv` = ot.`delv`) AND (input .`color` = ot.`color`) AND (input .`size` = ot.`size`) AND (input.`teamId` = ot.`line_id`)
        WHERE ct.`style` = '$style'";

        return $this->db->query($sql)->result();

    }

}