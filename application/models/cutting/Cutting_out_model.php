<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Cutting_out_model extends CI_model{


  public function getStyle(){
    $sql="SELECT
    `style`,
    `sc`,
    `proceed`
    FROM
    `intranet_db`.`product_bpom_cutplan_header`
    WHERE `proceed` = '1'
    GROUP BY style";

    return $this->db->query($sql)->result();
  }

  public function getSeason(){
    $style = $this->input->post('style');
    $sql  = "SELECT season,sc FROM product_bpom_style_info WHERE style_name='$style' GROUP BY season";
    return $this->db->query($sql)->result();
  }
  public function getDelivery(){
    $style = $this->input->post('style');
    $sql="SELECT
    po
    FROM
    `product_bpom_cutplan_grid`
    INNER JOIN `product_bpom_cutplan_header`
    ON (`product_bpom_cutplan_grid`.`hId` = `product_bpom_cutplan_header`.`id`) WHERE style='$style' AND proceed='1' GROUP BY po;" ;
    return $this->db->query($sql)->result();
  }

  public function getColor(){
    $style = $this->input->post('style');
    $delv = $this->input->post('delv');
    $sql="SELECT
    color
    FROM
    `product_bpom_cutplan_grid`
    INNER JOIN `product_bpom_cutplan_header`
    ON `product_bpom_cutplan_grid`.`hId` = `product_bpom_cutplan_header`.`id`
     WHERE style='$style' AND po='$delv' AND proceed='1' GROUP BY po;";
    return $this->db->query($sql)->result();
  }
  //// get save data ///
  public function getSavedData(){
    $style = $this->input->post('style');
    $sql = "SELECT t1.* , SUM(t2.`qty`) AS totalQty FROM `cutting_cut_out_header` t1 LEFT JOIN `cutting_cut_out_grid` t2 ON t1.id = t2.`hId` WHERE t1.style ='$style' GROUP BY t1.`refNum`";
    return $this->db->query($sql)->result();
  }

//// get size name list to create table column /////
  public function getStyleData(){
    $style = $this->input->post('style');
    $sql  = "SELECT size, qty FROM product_bpom_style_info WHERE style_name='$style' AND qty!=0 GROUP BY size";
    return $this->db->query($sql)->result();
  }

  /// Save New Refer Number /////
  public function getRefNumber(){
    $style = $this->input->post('style');
    $sql = "SELECT  COUNT(refNum ) AS refNumber FROM  `cutting_cut_out_header` WHERE style = '$style'";
    return $this->db->query($sql)->result();
  }

  /// Save Cut Plan ////
  public function setData(){

    //Retrieve the string, which was sent via the POST parameter "user"
    $allData= $this->input->post('allData');

    // Decode the JSON string and convert it into a PHP associative array.
    $cpData = json_decode($allData, true);

    // echo $cpData['cutPlanData'];

    $headerData =  array(
      'proccedDate'=>$cpData['date'],
      'refNum'=>$cpData['refNumber'],
      'style'=>$cpData['style'],
      'sc'=>$cpData['sc'],
      'season'=>$cpData['season'],
      'remark'=>$cpData['remark'],
      'createUser'=> $_SESSION['session_user_data']['userName'],
      'createDate'=>date('Y-m-d H:i:s'),
    );
    // print_r($headerData);exit();

    $this->db->trans_start();
    $this->db->insert('cutting_cut_out_header',$headerData);

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
        $this->db->insert('cutting_cut_out_grid',$gridData);
      }

    }

    return $this->db->trans_complete();
    // exit();
  }

  /// Edit & update cutplan //////
  public function getincludeDelv($editId){


    $sql = "SELECT
    `cutting_cut_out_grid`.`po`
    FROM
    `cutting_cut_out_grid`
    INNER JOIN `cutting_cut_out_header`
        ON (`cutting_cut_out_grid`.`hId` = `cutting_cut_out_header`.`id`)
    WHERE cutting_cut_out_header.`id` = '$editId'
    GROUP BY cutting_cut_out_grid.po;";
    return $this->db->query($sql)->result();
  }

  public function editData($editId,$po){

    $sql = "SELECT
    `cutting_cut_out_header`.`proccedDate`,
    `cutting_cut_out_header`.`refNum`,
    `cutting_cut_out_header`.`remark`,
    `cutting_cut_out_grid`.`po`,
    `cutting_cut_out_grid`.`color`,
    `cutting_cut_out_grid`.`size`,
    `cutting_cut_out_grid`.`qty`,
    `cutting_cut_out_grid`.`hId`
    FROM
    `cutting_cut_out_grid`
    INNER JOIN `cutting_cut_out_header`
    ON (
      `cutting_cut_out_grid`.`hId` = `cutting_cut_out_header`.`id`
    )
    WHERE cutting_cut_out_header.`id` = '$editId'
    AND `cutting_cut_out_grid`.`po` = '$po'
    GROUP BY `cutting_cut_out_grid`.`size`";
    return $this->db->query($sql)->result();
  }
  public function updateData(){
    //Retrieve the string, which was sent via the POST parameter "user"
    $allData= $this->input->post('allData');

    // Decode the JSON string and convert it into a PHP associative array.
    $cpData = json_decode($allData, true);

    // echo $cpData['cutPlanData'];exit()

    $headerData =  array(
      'proccedDate'=>$cpData['date'],
      'remark'=>$cpData['remark'],
      'updateBy'=> $_SESSION['session_user_data']['userName'],
      'updateDate'=>date('Y-m-d H:i:s'),
    );
    // print_r($headerData);exit();


    $this->db->trans_start();
    // $this->db->set('cutPlanDate',$cpData['cutPlanDate']);
    // $this->db->set('remark',$cpData['remark']);
    $this->db->where('id',$cpData['editId']);
    $this->db->update('cutting_cut_out_header',$headerData);

    $rowCount = sizeof($cpData['rowData']);
    $sizeCount =  sizeof($cpData['rowData'][0]['sizeName']);

    /////Delete grid data///////
    $this->db->where('hid', $cpData['editId']);
    $delete = $this->db->delete('cutting_cut_out_grid');


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
            'hId'=>$cpData['editId'],
            'po'=> $cpData['rowData'][$i]['delv'],
            'color'=>$cpData['rowData'][$i]['color'],
            'size'=>$cpData['rowData'][$i]['sizeName'][$x],
            'qty'=>$qty
          );
          $this->db->insert('cutting_cut_out_grid',$gridData);
        }

      }

    }

    return $this->db->trans_complete();

  }

}

?>
