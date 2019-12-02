<?php

    class Buyer_info_model extends CI_model{
        
        public function getAllBuyers(){
            $sql="SELECT
            `id`
            , `buyer`
            , `buying_office`
            , `season`
        FROM
             `intranet_db`.`product_bpom_buyer_info` WHERE `delete` = 0";
   return $this->db->query($sql)->result();

        }


        public function buyerSaveAll(){

            $bname = $this->input->post('bname');
            $buyoffname = $this->input->post('buyoffname');
            $seasonname = $this->input->post('seasonname');

            $data = array(
                'buyer' => $bname, 
                'buying_office' => $buyoffname,
                'season' => $seasonname,
                'user_name'=>$this->myConUserName,

            );
            $this->db->trans_start();
            $this->db->insert('product_bpom_buyer_info', $data);
            return $this->db->trans_complete();

        }

        public function deleteBuyer(){
            $buyerId = $this->input->post('buyerId');

            $this->db->trans_start();
             $this->db->set('delete', '1');
              $this->db->where('id', $buyerId);
            $this->db->update('product_bpom_buyer_info');
            return $this->db->trans_complete();

        }

        public function updateBuyer(){
            $buyerId = $this->input->post('id');
            $bname = $this->input->post('bname');
            $buyoffname = $this->input->post('buyoffname');
            $seasonname = $this->input->post('seasonname');

            $this->db->trans_start();
            $this->db->set('buyer', $bname);
            $this->db->set('buying_office', $buyoffname);
            $this->db->set('season', $seasonname);
            $this->db->where('id', $buyerId);
            $this->db->update('product_bpom_buyer_info');
            return $this->db->trans_complete();
        }

    }

?>