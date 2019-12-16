<?php
/**
 * Created by PhpStorm.
 * User: nirangal
 * Date: 01/23/2019
 * Time: 9:45 AM
 */


class Style_model extends CI_Model{

    private $location;

    public function __construct(){
        parent::__construct();
        if(isset($_SESSION['session_user_data'])){
            $this->location = $_SESSION['session_user_data']['location'];
        }

    }

    public function getStyle(){
        $sql = "SELECT
                  `id`,
                  `styleNo`,
                  `scNumber`
                FROM
                  `intranet_db`.`style_Info`
                GROUP BY `scNumber`
                ORDER BY `timeStamp` DESC";
        return $this->db->query($sql)->result();
    }

    public function getDelivery(){
        $styleNo  = $this->input->post('style');
        $sql = "SELECT
                  `deliveryNo`,
                  scNumber,
                  styleNo
                FROM
                  `intranet_db`.`style_Info`
                WHERE `styleNo` = '$styleNo'
                GROUP BY scNumber,deliveryNo
                ORDER BY `timeStamp` DESC";

        return $this->db->query($sql)->result();
    }

    public function getColor(){
        $styleNo  = $this->input->post('style');
        $delv  = $this->input->post('delv');
        $sql = "SELECT
                  garmentColour as color,
                  orderQty
                FROM
                  `intranet_db`.`style_Info`
                WHERE `styleNo` = '$styleNo' AND deliveryNo ='$delv'
                GROUP BY scNumber,deliveryNo
                ORDER BY `timeStamp` DESC";

        return $this->db->query($sql)->result();
    }

    public function getSize(){
        $styleNo  = $this->input->post('style');
        $delv  = $this->input->post('delv');

        $sql = "SELECT
                  size
                FROM
                  `intranet_db`.`style_Info`
                WHERE `styleNo` = '$styleNo' AND deliveryNo ='$delv'
                GROUP BY size
                ORDER BY `size` ASC";

        return $this->db->query($sql)->result();
    }

    public function getOrderQty(){
        $styleNo  = $this->input->post('style');
        $deliveryNo  = $this->input->post('deliveryNo');

        $sql = "SELECT
                  `deliveryNo`,
                  orderQty,
                  styleNo,
                  scNumber
                FROM
                  `intranet_db`.`style_Info`
                WHERE `deliveryNo` = '$deliveryNo'
                 AND styleNo = '$styleNo'
                GROUP BY scNumber,deliveryNo
                ORDER BY `timeStamp` DESC";
        return $this->db->query($sql)->result();
    }


    public function getProcessedStyle(){
        $sql = "SELECT
                  `id`,
                  `style`,
                  `scNumber`
                FROM
                  `intranet_db`.`checking_header_tb`
                GROUP BY `scNumber`
                ORDER BY `dateTime` DESC";
        return $this->db->query($sql)->result();
    }

    public function getProcessedDelivery(){
        $styleNo  = $this->input->post('style');
        $sql = "SELECT
                  `delivery`  AS `deliverNo`
                FROM
                  `intranet_db`.checking_grid_tb
                WHERE `style` = '$styleNo'
                GROUP BY scNumber,
                  deliverNo
                ORDER BY `dateTime` DESC";

        return $this->db->query($sql)->result();
    }

    public function getStyleProcessedTeam(){
        $style  = $this->input->post('style');
        $delivery  = $this->input->post('delivery');

        $sql = "SELECT
                    `prod_line`.`line_id`
                    , `prod_line`.`line`
                    , `checking_header_tb`.`style`
                    , `checking_header_tb`.`deliverNo`
                    , `location`.`location`
                FROM
                    `intranet_db`.`prod_line`
                    INNER JOIN `intranet_db`.`checking_header_tb` 
                        ON (`prod_line`.`line_id` = `checking_header_tb`.`lineNo`)
                    INNER JOIN `intranet_db`.`location` 
                        ON (`prod_line`.`location_id` = `location`.`location_id`)
                        WHERE `checking_header_tb`.`style`='$style' AND  `checking_header_tb`.`deliverNo` = '$delivery' GROUP BY line" ;
        return $this->db->query($sql)->result();
    }
}