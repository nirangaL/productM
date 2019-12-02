<?php

class Tv_login_model extends CI_model{

    public function checkUser(){
        $userName = $this->input->post('userName');
        $password = $this->input->post('password');

        $this->db->select('id,userName,active');
        $this->db->from('users');
        $this->db->where('userName', $userName);
        $this->db->where('password', sha1($password));
        $query = $this->db->get();

        if($query->num_rows() == 1){
            $result = $query->result();
            $user=$result[0]->userName;

            if($result[0]->active=='1'){

                $sql = "SELECT
                      epfNo,
                      `name`,
                      `designation`,
                      userGroup,
                      location,
                      userName
                    FROM
                      `users`
                    WHERE userName = '$user'";

                $result2 = $this->db->query($sql)->result();
                return $result2;exit();
            }else{
                return 'block';exit();
            }
        }else{
            return 'notOk';exit();
        }

    }

}