<?php

class Cutting_cut_plan_model extends CI_model{

public function getMerchCutPlan($date){

  $sql = "SELECT
  htbl.`id`,
  cutPlanDate,
  cutPlanName,
  style,
  sc,
  season,
  remark,
  username,
  cuttingCutPlanNum,
  proceed,
  SUM(gtbl.qty) AS total
  FROM
  `product_bpom_cutplan_header` htbl
  INNER JOIN `product_bpom_cutplan_grid` gtbl ON htbl.`id` = gtbl.`hId`
  WHERE htbl.`cutPlanDate` = '$date'";


  return $this->db->query($sql)->result();
  }

  /// Edit & update cutplan //////
  public function getincludeDelv($cutPlanId){


    $sql = "SELECT
    `product_bpom_cutplan_grid`.`po`
    FROM
    `intranet_db`.`product_bpom_cutplan_grid`
    INNER JOIN `intranet_db`.`product_bpom_cutplan_header`
    ON (
      `product_bpom_cutplan_grid`.`hId` = `product_bpom_cutplan_header`.`id`
    )
    WHERE product_bpom_cutplan_header.`id` = '$cutPlanId'
    GROUP BY product_bpom_cutplan_grid.po;
    ";

    return $this->db->query($sql)->result();

  }

  public function getCutPlanDetails($cutPlanId,$po){

    $sql = "SELECT
    `product_bpom_cutplan_header`.`cutPlanDate`,
    `product_bpom_cutplan_header`.`cutPlanName`,
    `product_bpom_cutplan_header`.`remark`,
    `product_bpom_cutplan_header`.`proceed`,
    `product_bpom_cutplan_grid`.`po`,
    `product_bpom_cutplan_grid`.`color`,
    `product_bpom_cutplan_grid`.`size`,
    `product_bpom_cutplan_grid`.`qty`,
    `product_bpom_cutplan_grid`.`hId`
    FROM
    `product_bpom_cutplan_grid`
    INNER JOIN `product_bpom_cutplan_header`
    ON (
      `product_bpom_cutplan_grid`.`hId` = `product_bpom_cutplan_header`.`id`
    )
    WHERE product_bpom_cutplan_header.`id` = '$cutPlanId'
    AND `product_bpom_cutplan_grid`.`po`='$po'
    GROUP BY `product_bpom_cutplan_grid`.`size`";
    return $this->db->query($sql)->result();
  }

  public function proceedCutPlan(){
    $cutPlanId = $this->input->post('cutPlanId');
    $cuttingCutPlanNum = $this->input->post('cuttingCutPlanNum');

    $this->db->trans_start();
    $data = array(
      'proceed'=> '1',
      'proceedBy'=>$_SESSION['session_user_data']['userName'],
      'cuttingCutPlanNum'=>$cuttingCutPlanNum,
      'proceedDateTime'=>date('Y-m-d')
    );
    $this->db->where('id',$cutPlanId);
    $this->db->update('product_bpom_cutplan_header',$data);
    return $this->db->trans_complete();
  }

}
