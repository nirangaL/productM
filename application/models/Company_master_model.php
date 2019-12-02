<?php

class Company_master_model extends CI_model{

    public function getCompany($comp_id=''){
        if($comp_id==''){
            $sql = "SELECT `comp_profile`.*,country.country AS countryName,country.phoneCode  FROM `comp_profile` LEFT JOIN country ON `comp_profile`.`country` = country.`id` WHERE active = '1'";
        } else{
            $sql = "SELECT comp_profile.*,`country`.`id` AS countryId FROM `comp_profile` LEFT JOIN country ON `comp_profile`.`country` = country.`id`  WHERE comp_id='$comp_id' AND active = '1'";
        }

        return $this->db->query($sql)->result();
    }

    public function getCountry(){
        $sql = "SELECT * FROM country ";
        return $this->db->query($sql)->result();
    }

    public function getPhoneCode(){
        $country = $this->input->post('countryId');
        $sql = "SELECT phoneCode FROM country WHERE id='$country'";
        return $this->db->query($sql)->result();
    }

    public function updateCompany($comp_id){
        $company = $this->input->post('cName');
        $address = $this->input->post('cAddress');
        $country = $this->input->post('cCountry');
        $phone = $this->input->post('phone');
        $web = $this->input->post('web');
        $email = $this->input->post('email1');
        $email2 = $this->input->post('email2');

        $data = array(
            'company' => $company,
            'address'=> $address,
            'phone' => $phone,
            'email' =>$email,
            'email2'=> $email2,
            'web' => $web,
            'country' => $country,
            'active' =>'1'
        );

        $this->db->trans_start();
            $this->db->set($data);
            $this->db->where('comp_id',$comp_id);
            $this->db->update('comp_profile');
        return $this->db->trans_complete();exit();

    }
}