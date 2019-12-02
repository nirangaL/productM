<?php
/**
 * Created by PhpStorm.
 * User: nirangal
 * Date: 01/21/2019
 * Time: 12:44 PM
 */

class User_model extends CI_Model{


    public function getAllUsers(){
        $sql = "SELECT
                `users`.`id`
                , `users`.`epfNo`
                , `users`.`name`
                , `users`.`designation`
                , `user_group`.`userGroup`
                , `location`.`location`
                , `users`.`userName`
                , `users`.`active`
            FROM
                `intranet_db`.`location`
                INNER JOIN `intranet_db`.`users`
                    ON (`location`.`location_id` = `users`.`location`)
                INNER JOIN `intranet_db`.`user_group`
                    ON (`user_group`.`id` = `users`.`userGroup`);";
        return $this->db->query($sql)->result();
    }

    public function getUserGroups(){
        $sql = "SELECT `id`, `userGroup`FROM`intranet_db`.`user_group` WHERE `active`  = 1";
        return $this->db->query($sql)->result();
    }

    public function getCompany(){
        $sql = "SELECT comp_id,company FROM comp_profile WHERE active = 1";
        return $this->db->query($sql)->result();
    }

    public function getLocations(){

        $sql = "SELECT `location_id`,`location` FROM location WHERE active = '1'";
        return $this->db->query($sql)->result();
    }

    public function saveUser(){
        $epfNo = $this->input->post('epfNo');
        $name = $this->input->post('uName');
        $designation = $this->input->post('designation');
        $userGroup = $this->input->post('userGroup');
        $location = $this->input->post('location');
        $userName = $this->input->post('userName');
        $password = sha1($this->input->post('userPassword'));
        $email = $this->input->post('email');
        $activeStatus = $this->input->post('activeStatus');

            $data = array(
                'epfNo' => $epfNo,
                'name' => $name,
                'designation' => $designation,
                'userGroup' => $userGroup,
                'location' =>  $location,
                'userName' =>  $userName,
                'password' =>  $password,
                'email' =>  $email,
                'active' =>  $activeStatus,
                'createDate' =>  date('Y-m-d H:i:s'),
                'createBy' =>  $_SESSION['session_user_data']['userName'],
            );
            $this->db->trans_start();
            $this->db->insert('users', $data);
            return $this->db->trans_complete();
    }

    public function getUserToEdit($userId){
        $sql = "SELECT
              `users`.`id`,
              `users`.`epfNo`,
              `users`.`name`,
              `users`.`designation`,
              `users`.`userName`,
              `users`.`email`,
              `users`.`active`,
              `users`.`userGroup`,
              `users`.`location`
            FROM
              `intranet_db`.`users`
            WHERE `users`.`id` = $userId";
        return $this->db->query($sql)->result();
    }

    public function editUser($userId){

        $epfNo = $this->input->post('epfNo');
        $name = $this->input->post('uName');
        $designation = $this->input->post('designation');
        $userGroup = $this->input->post('userGroup');
        $location = $this->input->post('location');
        $userName = $this->input->post('userName');
        $password = sha1($this->input->post('userPassword'));
        $email = $this->input->post('email');
        $activeStatus = $this->input->post('activeStatus');

        $data = array(
            'epfNo' => $epfNo,
            'name' => $name,
            'designation' => $designation,
            'userGroup' => $userGroup,
            'location' =>  $location,
            'userName' =>  $userName,
            'email' =>  $email,
            'active' =>  $activeStatus,
            'modifyDate' =>  date('Y-m-d H:i:s'),
            'modifyBy' =>  'administrator',
        );

        if($password != '7cfd6ac2d62f078ee8af85075f3327dbda40259c'){
            $data += array('password' => $password);
        }

        $this->db->trans_start();
        $this->db->where('id', $userId);
        $this->db->update('users', $data);
       return $this->db->trans_complete();
    }

    public function deleteUser($userId){
        $this->db->trans_start();
        $this->db->where('id', $userId);
        $this->db->delete('users');
        return $this->db->trans_complete();
    }



}
