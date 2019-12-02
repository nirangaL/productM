<?php

class Cut_plan_model extends CI_model{

  public function getStyle(){
    $sql="SELECT style_name,sc FROM `product_bpom_style_info` WHERE delete_rec = '0' GROUP BY style_name";
    return $this->db->query($sql)->result();
  }
  public function getSeason(){
    $style = $this->input->post('style');
    $sql  = "SELECT season,sc FROM product_bpom_style_info WHERE style_name='$style' GROUP BY season";
    return $this->db->query($sql)->result();
  }
  public function getDelivery(){
    $style = $this->input->post('style');
    $sql="SELECT po FROM `product_bpom_style_info` WHERE style_name='$style' AND delete_rec = '0' GROUP BY po" ;
    return $this->db->query($sql)->result();
  }
  public function getColor(){
    $style = $this->input->post('style');
    $delv = $this->input->post('delv');
    $sql="SELECT color FROM `product_bpom_style_info` WHERE style_name='$style' AND po='$delv' AND delete_rec = '0' GROUP BY color";
    return $this->db->query($sql)->result();
  }
  public function getCTplanTableData(){
    $style = $this->input->post('style');
    $sql = "SELECT t1.* , SUM(t2.`qty`) AS totalQty FROM `product_bpom_cutplan_header` t1 LEFT JOIN `product_bpom_cutplan_grid` t2 ON t1.id = t2.`hId` WHERE t1.style ='$style' GROUP BY t1.`cutPlanName`";
    return $this->db->query($sql)->result();
  }

  public function getStyleData(){
    $style = $this->input->post('style');
    $sql  = "SELECT size, qty FROM product_bpom_style_info WHERE style_name='$style' AND qty!=0 GROUP BY size";
    return $this->db->query($sql)->result();
  }

  /// Save New cut Plan /////
  public function getCutPlanNumber(){
    $style = $this->input->post('style');
    $sql = "SELECT  COUNT(cutPlanName )  AS countCutPlan FROM  `product_bpom_cutplan_header` WHERE style = '$style'";
    return $this->db->query($sql)->result();
  }
  public function getOrderQtyEachSize(){
    $style = $this->input->post('style');
    $delv = $this->input->post('delv');
    $color = $this->input->post('color');

    $sql = "SELECT
    `product_bpom_style_info`.`size` AS cutSize,
    (
      `product_bpom_style_info`.`qty` - SUM(
        COALESCE(
          `product_bpom_cutplan_grid`.`qty`,
          0
        )
      )
    ) AS balance
    FROM
    `product_bpom_style_info`
    LEFT JOIN `product_bpom_cutplan_header`
    ON (
      `product_bpom_style_info`.`style_name` = `product_bpom_cutplan_header`.`style`
    )
    AND (
      `product_bpom_style_info`.`sc` = `product_bpom_cutplan_header`.`sc`
    )
    LEFT JOIN `product_bpom_cutplan_grid`
    ON (
      `product_bpom_style_info`.`po` = `product_bpom_cutplan_grid`.`po`
    )
    AND (
      `product_bpom_style_info`.`color` = `product_bpom_cutplan_grid`.`color`
    )
    AND (
      `product_bpom_style_info`.`size` = `product_bpom_cutplan_grid`.`size`
    )
    WHERE product_bpom_style_info.style_name = '$style'
    AND product_bpom_style_info.po = '$delv'
    AND product_bpom_style_info.color = '$color' AND product_bpom_style_info.qty !='0'
    GROUP BY product_bpom_style_info.`size`";
    return $this->db->query($sql)->result();

  }

  /// Save Cut Plan ////
  public function setCutPlan(){

    //Retrieve the string, which was sent via the POST parameter "user"
    $allData= $this->input->post('allData');

    // Decode the JSON string and convert it into a PHP associative array.
    $cpData = json_decode($allData, true);

    // echo $cpData['cutPlanData'];

    $headerData =  array(
      'cutPlanDate'=>$cpData['cutPlanData'],
      'cutPlanName'=>$cpData['cutPlanName'],
      'style'=>$cpData['style'],
      'sc'=>$cpData['sc'],
      'season'=>$cpData['season'],
      'remark'=>$cpData['remark'],
      'username'=> $_SESSION['session_user_data']['userName'],
      'time_stamp'=>date('Y-m-d H:i:s'),
    );
    // print_r($headerData);exit();

    $this->db->trans_start();
    $this->db->insert('product_bpom_cutplan_header',$headerData);

    $headerId = $this->db->insert_id();;

    $rowCount = sizeof($cpData['rowData']);
    $sizeCount =  sizeof($cpData['rowData'][0]['sizeName']);

    for($i=0;$i<$rowCount;$i++){

      if($cpData['rowData'][$i]['delv'] == '' || $cpData['rowData'][$i]['color'] == ''){
        continue;
      }

      for($x=0;$x<$sizeCount;$x++){
        $qty = 0;
        if($cpData['rowData'][$i]['size'][$x] !=''){
          $qty = $cpData['rowData'][$i]['size'][$x];
        }

        $gridData = array(
          'hId'=>$headerId,
          'po'=> $cpData['rowData'][$i]['delv'],
          'color'=>$cpData['rowData'][$i]['color'],
          'size'=>$cpData['rowData'][$i]['sizeName'][$x],
          'qty'=>$qty
        );
        // echo "<pre>";
        // print_r($gridData);
        // echo "</pre>";
        $this->db->insert('product_bpom_cutplan_grid',$gridData);
      }

    }

    return $this->db->trans_complete();
    // exit();
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
  public function editCutPlan($cutPlanId,$po){

    $sql = "SELECT
    `product_bpom_cutplan_header`.`cutPlanDate`,
    `product_bpom_cutplan_header`.`cutPlanName`,
    `product_bpom_cutplan_header`.`remark`,
    `product_bpom_cutplan_header`.`proceed`,
    `product_bpom_cutplan_header`.`cuttingCutPlanNum`,
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
  public function updateCutPlan(){
    //Retrieve the string, which was sent via the POST parameter "user"
    $allData= $this->input->post('allData');

    // Decode the JSON string and convert it into a PHP associative array.
    $cpData = json_decode($allData, true);

    // echo $cpData['cutPlanData'];exit()

    $headerData =  array(
      'cutPlanDate'=>$cpData['cutPlanData'],
      'remark'=>$cpData['remark'],
      'username'=> $_SESSION['session_user_data']['userName'],
      'time_stamp'=>date('Y-m-d H:i:s'),
    );
    // print_r($headerData);exit();


    $this->db->trans_start();
    // $this->db->set('cutPlanDate',$cpData['cutPlanDate']);
    // $this->db->set('remark',$cpData['remark']);
    $this->db->where('id',$cpData['cutPlanId']);
    $this->db->update('product_bpom_cutplan_header',$headerData);

    $rowCount = sizeof($cpData['rowData']);
    $sizeCount =  sizeof($cpData['rowData'][0]['sizeName']);

    /////Delete grid data///////
    $this->db->where('hid', $cpData['cutPlanId']);
    $delete = $this->db->delete('product_bpom_cutplan_grid');


    if($delete){
      for($i=0;$i<$rowCount;$i++){

        if($cpData['rowData'][$i]['delv'] == '' || $cpData['rowData'][$i]['color'] == ''){
          continue;
        }

        for($x=0;$x<$sizeCount;$x++){
          $qty = 0;
          if($cpData['rowData'][$i]['size'][$x] !=''){
            $qty = $cpData['rowData'][$i]['size'][$x];
          }

          $gridData = array(
            'hId'=>$cpData['cutPlanId'],
            'po'=> $cpData['rowData'][$i]['delv'],
            'color'=>$cpData['rowData'][$i]['color'],
            'size'=>$cpData['rowData'][$i]['sizeName'][$x],
            'qty'=>$qty
          );
          $this->db->insert('product_bpom_cutplan_grid',$gridData);
        }

      }

    }

    return $this->db->trans_complete();

  }

}

?>
