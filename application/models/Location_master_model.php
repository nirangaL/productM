<?php

class Location_master_model extends CI_model{

    public function getCountry(){
        $sql = "SELECT * FROM country ";
        return $this->db->query($sql)->result();
    }

    public function getPhoneCode(){
        $country = $this->input->post('countryId');
        $sql = "SELECT phoneCode FROM country WHERE id='$country'";
        return $this->db->query($sql)->result();
    }

    public function getLocation($location = ''){
        if($location == '1'){
            $sql = "SELECT * FROM location";
        } else{
            $sql = "SELECT * FROM location WHERE location_id = '$location';";
        }

        return $this->db->query($sql)->result();
    }

    public function getLocationToUpdate($locationId){
        $sql = "SELECT location.*,country.id as countryId FROM location LEFT JOIN country ON `location`.`country` = country.`id` WHERE location_id = '$locationId' ";
        return $this->db->query($sql)->result();
    }

    public function insertLocation(){
        $location = $this->input->post('name');
        $address = $this->input->post('address');
        $country = $this->input->post('country');
        $phone = $this->input->post('phone');
        $active = $this->input->post('status');

        $data = array(
            'location' => $location,
            'address'=> $address,
            'phone' => $phone,
            'country' => $country,
            'comp_id' => $this->getCompany(),
            'active' =>$active
        );

        $this->db->trans_start();
        $this->db->insert('location',$data);
        return $this->db->trans_complete();exit();

    }

    public function updateLocation($locationId){
        $location = $this->input->post('name');
        $address = $this->input->post('address');
        $country = $this->input->post('country');
        $phone = $this->input->post('phone');
        $active = $this->input->post('status');

        $data = array(
            'location' => $location,
            'address'=> $address,
            'phone' => $phone,
            'country' => $country,
            'active' =>$active
        );

        $this->db->trans_start();
        $this->db->set($data);
        $this->db->where('location_id',$locationId);
        $this->db->update('location');
        return $this->db->trans_complete();exit();
    }

    public function getCompany(){
        $sql = "SELECT comp_id FROM comp_profile WHERE active = '1'";
        $result = $this->db->query($sql)->result();

        return $result[0]->comp_id;
    }

}