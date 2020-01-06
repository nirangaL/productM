<?php

class Style_color_wise_report_model extends CI_model{

  public function getCutDataFromGamaSys($style){
    $sql = "SELECT
            style,
            color,
            size,
            MIN(cutQty) AS cutQty
          FROM
            (SELECT
              styleNo AS style,
              colour AS color,
              size,
              SUM(qty) AS cutQty
            FROM
              cuttinginformation
            WHERE styleNo = '$style'
            GROUP BY gmtPannel,
              size,
              colour) t1 GROUP BY size ORDER BY color,size ";

    return $this->gamaSysDb->query($sql)->result();

  }


  public function getProductMData($style){

      $sql = "SELECT 
              style,
              color,
              size,
              SUM(orderQty) AS orderQty,
              SUM(cutInQty) AS cutInQty,
              SUM(issueQty) AS issueQty,
              SUM(outQty) AS outQty
              FROM (SELECT
                  sinfo.`styleNo` AS style,
                  sinfo.deliveryNo AS delv,
                  sinfo.orderQty AS delvOrderQty,
                  sinfo.garmentColour AS `color`,
                  sinfo.`size`,
                  IFNULL(sinfo.`qty`,0) AS orderQty,
                  IFNULL(ct.`inputQty`,0) AS cutInQty,
                  IFNULL(input.`inputQty`,0) AS issueQty,
                  IFNULL(ot.qty,0) AS outQty
                FROM
                style_Info sinfo
                LEFT JOIN `line_cutin_view` ct ON (sinfo.`styleNo` = ct.`style`) AND (sinfo.`deliveryNo` = ct.`delv`) AND (sinfo.`garmentColour` = ct.`color`) AND (sinfo.`size` = ct.`size`)
                  LEFT JOIN `line_issue_view` input ON (sinfo.`styleNo` = input.`style`) AND (sinfo.`deliveryNo` = input.`delv`) AND (sinfo.`garmentColour` = input.`color`) AND (sinfo.`size` = input.`size`)
                  LEFT JOIN `line_out_view` ot ON (sinfo.`styleNo` = ot.`style`) AND (sinfo.`deliveryNo` = ot.`delv`) AND (sinfo.`garmentColour` = ot.`color`) AND (sinfo.`size` = ot.`size`) 
                  WHERE sinfo.`styleNo` = '$style' GROUP BY sinfo.`size`,sinfo.garmentColour,sinfo.deliveryNo ORDER  BY sinfo.deliveryNo,sinfo.garmentColour,sinfo.`size`) t1 GROUP BY size,color ORDER BY color,size";

                  return $this->db->query($sql)->result();
  }

}