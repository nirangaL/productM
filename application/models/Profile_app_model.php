<?php

class Profile_app_model extends CI_model{

    public function getCompany(){
        $sql = "SELECT * FROM comp_profile WHERE active = '1'";
        return $this->db->query($sql)->result();
    }

    public function getLocations(){
        $comp_id = $this->input->post('comp_id');
        $sql = "SELECT * FROM location WHERE comp_id = '$comp_id' AND active = '1'";
        return $this->db->query($sql)->result();
    }

    public function getTeams(){
        $comp_id = $this->input->post('comp_id');
        $loca_id = $this->input->post('loca_id');
        $sql = "SELECT * FROM prod_line WHERE comp_id = '$comp_id' AND location_id ='$loca_id' AND active = '1'";
        return $this->db->query($sql)->result();
    }
}