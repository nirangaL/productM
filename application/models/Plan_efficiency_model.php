<?php
/**
 * Created by PhpStorm.
 * User: nirangal
 * Date: 01/23/2019
 * Time: 8:32 AM
 */

error_reporting(-1);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');
class Plan_efficiency_model extends CI_Model{
    private $location;

    public function __construct(){
        parent::__construct();
        $this->location = $_SESSION['session_user_data']['location'];
        $this->userName = $_SESSION['session_user_data']['userName'];
    }

    public function getAllEfficiency(){
        $sql="SELECT * FROM mst_plan_eff WHERE location = '$this->location'";
        return $this->db->query($sql)->result();
    }

    public function savePlanEfficiency(){
        $day = $this->input->post('day');
        $efficiency = $this->input->post('efficiency');

        $data = array(
            'day' => $day,
            'efficiency' => $efficiency,
            'location' => $this->location,
            'createBy' =>  $this->userName,
            'createDate' => date('Y-m-s H:i:s')
        );

        $this->db->trans_start();
        $this->db->insert('mst_plan_eff', $data);
        return $this->db->trans_complete();
    }

    public function getPlanEffToEdit($id){
        $sql = "SELECT * FROM mst_plan_eff WHERE id='$id'";
        return $this->db->query($sql)->result();
    }


    public function editPlanEfficiency($id){
        $day = $this->input->post('day');
        $efficiency = $this->input->post('efficiency');

        $data = array(
            'day' => $day,
            'efficiency' => $efficiency,
            'location' => $this->location,
            'createBy' =>  $this->userName,
            'createDate' => date('Y-m-s H:i:s')
        );

        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->update('mst_plan_eff', $data);
        return $this->db->trans_complete();
    }

    public function getDayPlanEff($day){
        $sql = "SELECT `day`, efficiency FROM `mst_plan_eff` WHERE `day` = '$day'";

        return $this->db->query($sql)->result();
    }

    public function getLasDayPlanEff(){
        $sql = "SELECT `day`, efficiency FROM `mst_plan_eff` ORDER BY `day` DESC LIMIT 0,1";
        return $this->db->query($sql)->result();
    }


}