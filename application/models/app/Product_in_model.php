<?php

class Product_in_model extends CI_model{

  public function getStyle($teamId){
    $date = date('Y-m-d');
    $sql = "SELECT
        style,
        balanceQty,
        scNumber
        FROM
      (SELECT
        style,
        balanceQty,
        scNumber
      FROM
        (SELECT
          style,
          COALESCE(SUM(qty) - SUM(aqty)) AS balanceQty,
          scNumber
        FROM
          (SELECT
            style,
            SUM(qty) AS qty,
            '0' AS aqty,
            scNumber
          FROM
            cut_in
          WHERE teamId = '$teamId'
          GROUP BY style
          UNION
          ALL
          SELECT
            style,
            '0' AS qty,
            SUM(qty) AS aqty,
            scNumber
          FROM
            `production_input`
          WHERE teamId = '$teamId'
          GROUP BY style) t1
        GROUP BY style) t2
      WHERE balanceQty > 0 UNION ALL
      SELECT style,'0',scNumber FROM `production_input` WHERE DATE(createDate) = '$date' AND teamId = '$teamId' GROUP BY style) t3 GROUP BY style";

    return $this->db->query($sql)->result();

    }

  public function getDelivery($teamId){

    $style = $this->input->post('style');

    $sql = "SELECT
                delv,
                scNumber,
                balanceQty
                FROM (SELECT
                delv,
                scNumber,
                balanceQty
              FROM
                (SELECT
                  delv,
                  scNumber,
                  COALESCE(SUM(qty) - SUM(aqty)) AS balanceQty
                FROM
                  (SELECT
                    delv,
                    scNumber,
                    SUM(qty) AS qty,
                    '0' AS aqty
                  FROM
                    cut_in
                  WHERE teamId = '$teamId'
                    AND style = '$style'
                  GROUP BY delv
                  UNION
                  ALL
                  SELECT
                    delv,
                    scNumber,
                    '0' AS qty,
                    SUM(qty) AS aqty
                  FROM
                    `production_input`
                  WHERE teamId = '$teamId'
                    AND style = '$style'
                  GROUP BY delv) t1
                GROUP BY delv) t2
              WHERE balanceQty > 0 UNION ALL SELECT delv,scNumber,'0' FROM `production_input` WHERE DATE(createDate) = '2019-05-15' AND teamId = '$teamId' AND style='$style' GROUP BY delv) t3 GROUP BY delv";

    return $this->db->query($sql)->result();
  }

  public function getColor($teamId){
    $style = $this->input->post('style');
    $delv = $this->input->post('delv');
    $sql = "SELECT
            color,
            balanceQty
            FROM (SELECT
            color,
            balanceQty
          FROM
            (SELECT
              color,
              COALESCE(SUM(qty) - SUM(aqty)) AS balanceQty
            FROM
              (SELECT
                color,
                SUM(qty) AS qty,
                '0' AS aqty
              FROM
                cut_in
              WHERE teamId = '$teamId'
                AND style = '$style'
                AND delv = '$delv'
              GROUP BY color
              UNION
              ALL
              SELECT
                color,
                '0' AS qty,
                SUM(qty) AS aqty
              FROM
                `production_input`
              WHERE teamId = '$teamId'
                AND style = '$style'
                AND delv = '$delv'
              GROUP BY color) t1
            GROUP BY color) t2
          WHERE balanceQty > 0 UNION ALL SELECT color,'0' FROM `production_input` WHERE DATE(createDate) = '2019-05-15' AND teamId = '$teamId' AND style='$style' AND delv='$delv' GROUP BY color) t3 GROUP BY color";

    return $this->db->query($sql)->result();
  }

  public function getSize($teamId){
    $style = $this->input->post('style');
    $delv = $this->input->post('delv');
    $color = $this->input->post('color');
    $sql = "SELECT
            size,
            balanceQty
            FROM
            (SELECT
              size,
              COALESCE(SUM(qty) -SUM(aqty)) AS balanceQty
            FROM
              (SELECT
                size,
                SUM(qty) AS qty,
                '0' AS aqty
              FROM
                cut_in WHERE teamId = '$teamId' AND style = '$style' AND delv = '$delv' AND color='$color'
              GROUP BY size
              UNION
              ALL
              SELECT
                size,
                '0' AS qty,
                SUM(qty) AS aqty
              FROM
                `production_input` WHERE teamId = '$teamId' AND style = '$style' AND delv = '$delv' AND color='$color'
              GROUP BY size) t1 GROUP BY size) t2
              WHERE balanceQty > 0";

    return $this->db->query($sql)->result();
  }

  public function getBalance($teamId){
    $style = $this->input->post('style');
    $delv = $this->input->post('delv');
    $color = $this->input->post('color');
    $size = $this->input->post('size');
    $sql = "SELECT
            size,
            balanceQty
            FROM
            (SELECT
              size,
              COALESCE(SUM(qty) -SUM(aqty)) AS balanceQty
            FROM
              (SELECT
                size,
                SUM(qty) AS qty,
                '0' AS aqty
              FROM
                cut_in WHERE teamId = '$teamId' AND style = '$style' AND delv = '$delv' AND color='$color' AND size = '$size'
              GROUP BY size
              UNION
              ALL
              SELECT
                size,
                '0' AS qty,
                SUM(qty) AS aqty
              FROM
                `production_input` WHERE teamId = '$teamId' AND style = '$style' AND delv = '$delv' AND color='$color' AND size = '$size'
              GROUP BY size) t1 GROUP BY size) t2
              WHERE balanceQty > 0";

    return $this->db->query($sql)->result();
  }

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
      $this->db->insert('production_input',$data);
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
          `production_input`
        WHERE teamId = '$teamId'
          AND style = '$style'
          AND delv = '$delv'
          AND color = '$color'
          AND DATE(createDate) = '$date' GROUP BY `size`";
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
          `production_input`
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
      $this->db->Update('production_input');
      return $this->db->trans_complete();
    }

}
