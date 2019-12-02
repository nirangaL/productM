<?php

class Monthly_efficiency_model extends CI_model{

    public function getLocation(){
        $sql = "SELECT * FROM `location` WHERE active = '1'";
        return $this->db->query($sql)->result();
    }

}