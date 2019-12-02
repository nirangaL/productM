<?php

class Worker_hourly_out_model extends CI_model{

    public function getEmps($teamId){
        $date = date('Y-m-d');
        $hour = $this->input->post('hour');

        $sql = "SELECT
                  worker_in_team.id,
                  emp_no,
                  `emp_details`.`emp_name`
                FROM
                  `worker_in_team`
                  LEFT JOIN `emp_details` ON worker_in_team.`empTbId` = `emp_details`.`id`
                WHERE DATE(createDateTime) = '$date'
                  AND worker_in_team.id NOT IN (
                    (SELECT
                      workerInTeamTblId
                    FROM
                      `worker_hourly_out`
                    WHERE `hour` = '$hour'
                      AND DATE(createdTime) = '$date' AND teamId='$teamId')
                  ) AND teamId = '$teamId' AND workerOut ='0'";

        return $this->db->query($sql)->result();
    }

    public function getSavedHourlyData($teamID){
        $hour = $this->input->post('hour');
        $date = date('Y-m-d');
        $sql = "SELECT
                  `worker_hourly_out`.id
                , `emp_details`.`epf_no`
                , `emp_details`.`emp_name`
                , `dep_style_operation_smv`.`operation`
                , `worker_hourly_out`.`hour`
                , `worker_hourly_out`.`qty`
                , `worker_in_team`.`teamId`
            FROM
                `worker_in_team`
                INNER JOIN `emp_details`
                    ON (`worker_in_team`.`empTbId` = `emp_details`.`id`)
                INNER JOIN `worker_hourly_out`
                    ON (`worker_hourly_out`.`workerInTeamTblId` = `worker_in_team`.`id`)
                INNER JOIN `dep_style_operation_smv`
                    ON (`worker_in_team`.`operation_id` = `dep_style_operation_smv`.`id`) WHERE `worker_in_team`.`teamId` ='$teamID' AND `hour`='$hour' AND DATE(createdTime)='$date' ORDER BY id DESC";
        return $this->db->query($sql)->result();
    }


    public function setWorkerHourlyOut($teamId){

        $workerInTeamTblId = $this->input->post('workerInTeamTblId');
        $hour = $this->input->post('hour');
        $qty = $this->input->post('qty');
        $date = date("Y-m-d H:i:s");


        $data = array(
            'workerInTeamTblId'=>$workerInTeamTblId,
            'teamId'=>$teamId,
            'hour'=>$hour,
            'qty'=>$qty,
            'createdTime' => $date,
        );

        $this->db->trans_start();
        $this->db->insert('worker_hourly_out',$data);
        return $this->db->trans_complete();
    }

    public function editEmpQty(){
        $id = $this->input->post('id');
        $qty = $this->input->post('qty');
        $date = date("Y-m-d H:i:s");

        $this->db->trans_start();
        $this->db->set('qty',$qty);
        $this->db->set('editTime',$date);
        $this->db->where('id',$id);
        $this->db->update('worker_hourly_out');
        return $this->db->trans_complete();
    }
}
