<?php
/**
 * Created by PhpStorm.
 * User: nirangal
 * Date: 01/22/2019
 * Time: 7:43 PM
 */



class Login_model extends CI_Model{

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

                $ses_user_data = array(
                    'epfNo' => $result2[0]->epfNo,
                    'userName' => $result2[0]->userName,
                    'name' => $result2[0]->name,
                    'designation' =>$result2[0]->designation,
                    'location' => $result2[0]->location,
                    'userGroup' => $result2[0]->userGroup,
                    'id' => $result2[0]->id,
                );
                $this->session->set_userdata('session_user_data', $ses_user_data);
                $this->add_userOnline($user);
                $this->login_log($user);
                return 'ok';exit();
            }else{
                return 'block';exit();
            }
        }else{
            return 'notOk';exit();
        }

    }

    public function add_userOnline($username){
        $this->db->set('online','1');
        $this->db->where('userName',$username);
        $this->db->update("users");
    }

    public function remove_login_time($username){
        $this->db->set('lastlogin',date("Y-m-d H:i:s"));
        $this->db->set('online','0');
        $this->db->where('userName',$username);
        $this->db->update("users");
    }

    public function login_log($username){
        $username	=	htmlentities($username);
        $time		=	htmlentities(date("Y-m-d H:i:s"));
        $ip			=	htmlentities($_SERVER['REMOTE_ADDR']);
        $browser	=	htmlentities($_SERVER['HTTP_USER_AGENT']);

        $data		=	array("userName"=>$username,
            "time"=>$time,
            "ip"=>$ip,
            "user_agent"=>$browser);

        $this->db->insert("login_log",$data);
    }
}