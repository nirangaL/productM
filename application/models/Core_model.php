<?php

// Importent class
// This class use library/Production_dashboard_library.php file 
// This model use for every production dashboard,Team Dashbord
// Do not delete 


class Core_model extends CI_Model{

    public function getRuleStatus($team,$rule){
        $sql = "SELECT ".$rule." AS rule FROM rules_master WHERE team = '$team'";
        return $this->db->query($sql)->result();
    }
}