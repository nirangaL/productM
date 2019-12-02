<?php

class Qc_checker_model extends CI_Model{

    private $lastHeaderSavedId;
    private $gridSavedId;

    function __construct(){
        parent::__construct();
        $this->team = get_cookie('line');
    }

    public function getTeamName($team){
        $sql = "SELECT line,active FROM prod_line WHERE line_id = '$team' AND active ='1'";
        return $this->db->query($sql)->result();
    }

    public function getStyle($team){
      $sql = "SELECT style,scNumber FROM `production_input` WHERE teamId = '$team' GROUP BY style ORDER BY createDate DESC LIMIT 10";
      return $this->db->query($sql)->result();
    }

    public function getDelivery($team){
      $style = $this->input->post('style');
      $sql = "SELECT delv,scNumber FROM `production_input` WHERE style = '$style' AND teamId = '$team' GROUP BY delv";
      return $this->db->query($sql)->result();
    }

    public function getColor($team){
      $style = $this->input->post('style');
      $delivery = $this->input->post('delivery');
      $sql = "SELECT
              color
            FROM
              `production_input`
            WHERE style = '$style'
              AND delv = '$delivery'
              AND teamId = '$team'
            GROUP BY color";
      return $this->db->query($sql)->result();
    }

    public function getSize($team){
      $style = $this->input->post('style');
      $delivery = $this->input->post('delivery');
      $color = $this->input->post('color');

      $sql = "SELECT
              size
            FROM
              `production_input`
            WHERE style = '$style'
              AND delv = '$delivery'
              AND color = '$color'
              AND teamId = '$team' GROUP BY size ";

            return $this->db->query($sql)->result();

    }

    public function getDefectReason($location){

          $sql = "SELECT
          id,
          rejectReason
        FROM
          `reject_master`
        WHERE location ='$location' ORDER BY rejectReason ASC" ;
        return $this->db->query($sql)->result();
    }

    public function insertData($data,$location){
      $this->db->trans_start();
      $this->saveHeaderData($data,$location);
      $this->saveGridData($data);
      return $this->db->trans_complete();
  }

  public function saveHeaderData($data,$location){
      $this->lastHeaderSavedId = '';
      $style = $data[0]['style'];
      $scNumber = $data[0]['scNumber'];
      $del_no = $data[0]['delivery'];
      $color = $data[0]['color'];
      $currentDate = date('Y-m-d');

      ///////////////////// check the this style already save ///////////////////////
      $sql = "SELECT id FROM checking_header_tb WHERE style ='$style' AND scNumber='$scNumber' AND deliverNo='$del_no' AND lineNo='$this->team' AND DATE(`dateTime`)  = '$currentDate'";

      //  echo $sql;exit();

      $result = $this->db->query($sql)->result();
      if(empty($result)){
          $data = array(
              'location' => $location,
              'style' => $style,
              'scNumber' => $scNumber,
              'deliverNo' => $del_no,
              'lineNo' =>  $this->team,
              'dateTime' => date('Y-m-d H:i:s')
          );
          $this->db->insert('checking_header_tb', $data);
          $this->lastHeaderSavedId = $this->db->insert_id();
      }else{
          $this->lastHeaderSavedId = $result[0]->id;
      }

  }

  public function saveGridData($data){

      $color = $data[0]['color'];
      $size = $data[0]['size'];
      $btn = $data[0]['btn'];
      $checking_id = $this->lastHeaderSavedId;

      $curDate = date('Y-m-d');

      $sql = "SELECT `id`,`passQty`,`rejectQty`,`remakeQty`,`reRejectQty` FROM checking_grid_tb WHERE color ='$color' AND size='$size' AND chckHeaderId ='$checking_id' AND DATE(`lastModifiedDate`) = '$curDate'";
    
      $result = $this->db->query($sql)->result();

      if(empty($result)){
          $this->saveGridDataNew($color,$size,$btn);
      }else{
          $this->gridSavedId = $result[0]->id;

          $passQty =$result[0]->passQty;
          $rejectQty =$result[0]->rejectQty;
          $remakeQty =$result[0]->remakeQty;
          $reRejectQty =$result[0]->reRejectQty;

          $this->updateGridData($btn,$passQty,$rejectQty,$remakeQty);
      }

      if($btn == 'pass'){
        $this->setPassLog($color,$size);
    }
    if($btn == 'defect'){
        $reject_reason = $data[0]['defectReason'];
        $this->setRejectLog($color,$size,$reject_reason);
    }
    if($btn == 'remake'){
        $this->setPassLog($color,$size);
        $this->setRemakeLog($color,$size);
    }
    // if($btn == 'rereject'){
    //     $this->setReRejectLog();
    // }
  }

  public function saveGridDataNew($color,$size,$btn){

      $data = array(
          'chckHeaderId' => $this->lastHeaderSavedId,
          'color' => $color,
          'size' => $size,
          'lastModifiedDate' => date('Y-m-d H:i:s')
      );

      if($btn == 'pass'){
          $pass_count = 1;
          $data += array(
              'passQty' => $pass_count
          );
      }

      if($btn == 'reject'){
          $reject_count = 1;
          $data += array(
              'rejectQty' => $reject_count
          );
      }

      if($btn == 'remake'){
          $remake_count = 1;
          $reject_count = 1;
          $data += array(
              'remakeQty' => $remake_count,
              'rejectQty' => $reject_count
          );
      }

       $this->db->insert('checking_grid_tb', $data);
       $this->gridSavedId = $this->db->insert_id();

      

  }

  public function updateGridData($btn,$passQty,$rejectQty,$remakeQty){

      $data = array(
          'lastModifiedDate' => date('Y-m-d H:i:s')
      );

      if($btn == 'pass'){
          $data += array(
              'passQty' => ($passQty + 1)
          );
      }
      if($btn == 'defect'){
          $data += array(
              'rejectQty' => ($rejectQty +1)
          );
      }

      if($btn == 'remake'){
          $data += array(
              'remakeQty' => ($remakeQty + 1),
              'rejectQty' => ($rejectQty - 1),
          );
      }

//       if($btn == 'rereject'){
// //            $reReject_count = $this->input->post('rereject_count');
// //            $reject_count = $this->input->post('reject_count');
//           $data += array(
//               'reRejectQty' => ($reRejectQty + 1),
//               'rejectQty' => ($rejectQty +1)
//           );
      // }

      $this->db->where('chckHeaderId',$this->lastHeaderSavedId);
      $this->db->where('id',$this->gridSavedId);
      $this->db->update('checking_grid_tb', $data);
  }

  /////// ********** set log ***********//////

  public function setPassLog($color,$size){
      $header_id = $this->lastHeaderSavedId;
      $grid_id = $this->gridSavedId;
      $data = array(
          'chckHeaderId' => $header_id,
          'chckGridId' => $grid_id,
          'color' => $color,
          'size' => $size,
          'dateTime' => date('Y-m-d H:i:s')
      );
      return $this->db->insert('qc_pass_log', $data);
  }

  public function setRejectLog($color,$size,$reject_reason){
      $header_id = $this->lastHeaderSavedId;
      $grid_id = $this->gridSavedId;

      $data = array(
          'chckHeaderId' => $header_id,
          'chckGridId' => $grid_id,
          'rejectReason' => $reject_reason,
          'color' => $color,
          'size' => $size,
          'dateTime' => date('Y-m-d H:i:s')
      );
      return $this->db->insert('qc_reject_log', $data);
  }

  public function setRemakeLog($color,$size){
      $header_id = $this->lastHeaderSavedId;
      $grid_id = $this->gridSavedId;
      $data = array(
          'chckHeaderId' => $header_id,
          'chckGridId' => $grid_id,
          'color' => $color,
          'size' => $size,
          'dateTime' => date('Y-m-d H:i:s')
      );
      return $this->db->insert('qc_remake_log', $data);

  }

  // public function setReRejectLog(){
  //     $header_id = $this->lastHeaderSavedId;
  //     $grid_id = $this->gridSavedId;
  //     $color = $this->input->post('color');
  //     $size = $this->input->post('size');
  //     $data = array(
  //         'chckHeaderId' => $header_id,
  //         'chckGridId' => $grid_id,
  //         'color' => $color,
  //         'size' => $size,
  //         'dateTime' => date('Y-m-d H:i:s')
  //     );
  //     return $this->db->insert('qc_rereject_log', $data);
  // }




  public function checkOtherPlan($newStyle,$newDelv,$team){
      $date = date('Y-m-d');
      $sql = "SELECT id,style,delivery,feedingHour FROM `day_plan` WHERE `style` ='$newStyle' AND `delivery` ='$newDelv' AND `status` IN ('2','4') AND line ='$team' AND DATE(`createDate`) = '$date'";

      return $this->db->query($sql)->result();
  }

  public function switchStyleStatus($newStyleId,$team){

      $this->db->trans_start();
      $this->changeToStyleHold($team);
      $this->changeToStyleRunn($newStyleId);
      return $this->db->trans_complete();
  }

  public function changeToStyleHold($team){
      $date = date('Y-m-d');
      $sql =  "UPDATE day_plan SET `status`='2' WHERE `status`='1' AND DATE(createDate) ='$date' AND line ='$team'";

      return $this->db->query($sql);
  }

  public function changeToStyleRunn($newStyleId){
      $sql =  "UPDATE day_plan SET `status`='1' WHERE id='$newStyleId'";
      return $this->db->query($sql);
  }

  ///// get check out count for checker app's tile /////
  public function getCountFormLog(){

    $style = $this->input->post('style');
    $date = date('Y-m-d');
    $sql ="SELECT
    (SELECT COALESCE(COUNT(id),0) AS pass FROM `qc_pass_log` WHERE `chckHeaderId` = `checking_header_tb`.`id`) AS passQty
    ,(SELECT COALESCE(COUNT(rejectId),0) FROM `qc_reject_log` WHERE `chckHeaderId` = `checking_header_tb`.`id`  ) - (SELECT COALESCE(COUNT(id),0) FROM `qc_remake_log` WHERE `chckHeaderId` = `checking_header_tb`.`id`) -(SELECT COALESCE(COUNT(id),0) FROM `qc_rereject_log` WHERE `chckHeaderId` = `checking_header_tb`.`id`)  AS defectQty
    ,(SELECT COALESCE(COUNT(id),0) FROM `qc_remake_log` WHERE `chckHeaderId` = `checking_header_tb`.`id`) AS remakeQty
    FROM
    `checking_header_tb`
    LEFT JOIN `qc_pass_log`
    ON (`checking_header_tb`.`id` = `qc_pass_log`.`chckHeaderId`)
    LEFT JOIN `qc_reject_log`
    ON (`checking_header_tb`.`id` = `qc_reject_log`.`chckHeaderId`)
    LEFT JOIN `qc_remake_log`
    ON (`checking_header_tb`.`id` = `qc_remake_log`.`chckHeaderId`)
    WHERE style='$style' AND lineNo='$this->team' AND DATE(`checking_header_tb`.`dateTime`)='$date' GROUP BY style ;";

    return $this->db->query($sql)->result();
  }



  ///// Validate input qty before checkout //////
  public function getInputVsOutBalance($data){

      $style = $data[0]['style'];
      $delivery = $data[0]['delivery'];
      $color = $data[0]['color'];
      $size = $data[0]['size'];

      $sql  = "SELECT
      SUM(t1.`qty`) -  COALESCE(t2.`qty`,0) AS balance
      FROM
      `production_input` t1
      LEFT JOIN view_pass_qty_from_checker_grid t2 ON (t1.`style` = t2.`style`) AND (t1.`delv` = t2.`deliverNo`) AND (t1.`color` = t2.`color`) AND (t1.`size` = t2.`size`)
      WHERE t1.teamId = '$this->team' AND t1.style='$style' AND t1.delv = '$delivery' AND t1.color='$color' AND t1.`size` = '$size' GROUP BY t1.size";

    // echo $sql;

      return $this->db->query($sql)->result();

  }

  public function getFrequentDefectReason(){
        $style = $this->input->get('style');
        $date = date('Y-m-d');

        // echo $style;

        $sql = "SELECT DISTINCT
        `reject_master`.`id`,
        `reject_master`.`rejectReason`
        FROM
        `checking_header_tb`
        INNER JOIN `qc_reject_log`
            ON (
            `checking_header_tb`.`id` = `qc_reject_log`.`chckHeaderId`
            )
        INNER JOIN `reject_master`
            ON (
            `qc_reject_log`.`rejectReason` = `reject_master`.`id`
            )
        WHERE `checking_header_tb`.`lineNo` = '$this->team'
        AND `checking_header_tb`.`style` = '$style'
        AND DATE(
            `checking_header_tb`.`dateTime`
        ) = '$date'";

    return $this->db->query($sql)->result();

  }

}
