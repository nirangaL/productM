<?php
/**
 * Created by PhpStorm.
 * User: nirangal
 * Date: 01/23/2019
 * Time: 9:22 AM
 */

class ProducLine_model extends CI_Model{

    private $location;

    public function __construct(){
        parent::__construct();

        $this->location = $_SESSION['session_user_data']['location'];
    }

    public function getProdcLine(){

        $sql = "SELECT
                  `line_id`,
                  `line`,
                  `location_id`
                FROM
                  `intranet_db`.`prod_line`
                WHERE `active` = 1 AND `location_id` = '$this->location'
                ORDER BY `line` ASC";

        return $this->db->query($sql)->result();

    }
}