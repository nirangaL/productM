<?php
error_reporting(-1);
ini_set('display_errors', 1);
class Cut_in_model extends CI_model{

  public function saveInput($teamId){
      $style = $this->input->post('style');
      $delv = $this->input->post('delv');
      $color = $this->input->post('color');
      $size = $this->input->post('size');
      $qty = $this->input->post('qty');
      $scNumber = $this->input->post('scNumber');
      $date = date('Y-m-d H:i:s');

      $data = array(
          'teamId'=>$teamId,
          'style'=>$style,
          'scNumber'=>$scNumber,
          'delv'=>$delv,
          'color'=>$color,
          'size'=>$size,
          'qty'=>$qty,
          'createDate'=>$date,
      );

      $this->db->trans_start();
      $this->db->insert('cut_in',$data);
      return $this->db->trans_complete();
  }

  public function getSavedInput($teamId){
      $style = $this->input->post('style');
      $delv = $this->input->post('delv');
      $color = $this->input->post('color');
      $date = date('Y-m-d');

      $sql = "SELECT
        `size`,
        SUM(qty) AS qty
      FROM
        `cut_in`
      WHERE teamId = '$teamId'
        AND style = '$style'
        AND delv = '$delv'
        AND color = '$color'
        AND DATE(createDate) = '$date' GROUP BY `size`";
      return $this->db->query($sql)->result();

  }

  public function savedInputTotal($teamId){
    $style = $this->input->post('style');
    $delv = $this->input->post('delv');

    $sql = "SELECT
      SUM(qty) AS total_input
    FROM
      `cut_in`
    WHERE teamId = '$teamId'
      AND style = '$style'
      AND delv = '$delv'
      GROUP BY delv";

      // echo $sql;

    return $this->db->query($sql)->result();

}

  public function getLastEnterSizeInput($teamId){
      $style = $this->input->post('style');
      $delv = $this->input->post('delv');
      $color = $this->input->post('color');
      $size = $this->input->post('size');
      $date = date('Y-m-d');

      $sql = "SELECT
        id,
        `createDate`,
         qty
      FROM
        `cut_in`
      WHERE teamId = '$teamId'
        AND style = '$style'
        AND delv = '$delv'
        AND color = '$color'
        AND `size` = '$size'
        AND DATE(createDate) = '$date' ORDER BY `size` ASC";
      return $this->db->query($sql)->result();
  }

  public function editInput(){
    $id = $this->input->post('id');
    $qty = $this->input->post('qty');
    $date = date('Y-m-d H:i:s');

    $this->db->trans_start();
    $this->db->set('qty',$qty);
    $this->db->set('editDate',$date);
    $this->db->where('id',$id);
    $this->db->Update('cut_in');
    return $this->db->trans_complete();

  }


}
