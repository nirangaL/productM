<?php

class Team_time_model extends CI_Model{

    public function saveTeamTime(){
        $line = $this->input->post('line');
        $date = date('Y-m-d H-m-s');

        $firstHStart = $this->input->post('1hStart');
        $firstHEnd = $this->input->post('1hEnd');

        $secondHStart = $this->input->post('2hStart');
        $secondHEnd = $this->input->post('2hEnd');

        $thirdHStart = $this->input->post('3hStart');
        $thirdHEnd = $this->input->post('3hEnd');

        $fourthHStart = $this->input->post('4hStart');
        $fourthHEnd = $this->input->post('4hEnd');

        $fifthHStart = $this->input->post('5hStart');
        $fifthHEnd = $this->input->post('5hEnd');

        $sixthHStart = $this->input->post('6hStart');
        $sixthHEnd = $this->input->post('6hEnd');

        $seventhHStart = $this->input->post('7hStart');
        $seventhHEnd = $this->input->post('7hEnd');

        $eighthHStart = $this->input->post('8hStart');
        $eighthHEnd = $this->input->post('8hEnd');

        $ninthHStart = $this->input->post('9hStart');
        $ninthHEnd = $this->input->post('9hEnd');

        $tenthHStart = $this->input->post('10hStart');
        $tenthHEnd = $this->input->post('10hEnd');

        $eleventhHStart = $this->input->post('11hStart');
        $eleventhHEnd = $this->input->post('11hEnd');

        $twelfthHStart = $this->input->post('12hStart');
        $twelfthHEnd = $this->input->post('12hEnd');

        $thirteenthHStart = $this->input->post('13hStart');
        $thirteenthHEnd = $this->input->post('13hEnd');

        $fourteenthHStart = $this->input->post('14hStart');
        $fourteenthHEnd = $this->input->post('14hEnd');

        $data = array(
            'lineId'=>$line,
            '1hStart'=>$firstHStart,
            '1hEnd'=>$firstHEnd,
            '2hStart'=>$secondHStart,
            '2hEnd'=>$secondHEnd,
            '3hStart'=>$thirdHStart,
            '3hEnd'=>$thirdHEnd,
            '4hStart'=>$fourthHStart,
            '4hEnd'=>$fourthHEnd,
            '5hStart'=>$fifthHStart,
            '5hEnd'=>$fifthHEnd,
            '6hStart'=>$sixthHStart,
            '6hEnd'=>$sixthHEnd,
            '7hStart'=>$seventhHStart,
            '7hEnd'=>$seventhHEnd,
            '8hStart'=>$eighthHStart,
            '8hEnd'=>$eighthHEnd,
            '9hStart'=>$ninthHStart,
            '9hEnd'=>$ninthHEnd,
            '10hStart'=>$tenthHStart,
            '10hEnd'=>$tenthHEnd,
            '11hStart'=>$eleventhHStart,
            '11hEnd'=>$eleventhHEnd,
            '12hStart'=>$twelfthHStart,
            '12hEnd'=>$twelfthHEnd,
            '13hStart'=>$thirteenthHStart,
            '13hEnd'=>$thirteenthHEnd,
            '14hStart'=>$fourteenthHStart,
            '14hEnd'=>$fourteenthHEnd,
            'lastModifiedDate'=> $date,
            'lastModifiedBy'=>$_SESSION['session_user_data']['userName']
        );
        $this->db->trans_start();
        $this->db->insert('team_time', $data);
        return $this->db->trans_complete();

    }

    public function getTeamTime(){
        $location = $_SESSION['session_user_data']['location'];

        $sql  = "SELECT
                    `team_time`.`id`
                    ,`prod_line`.`line`
                    , `team_time`.`lastModifiedDate`
                    , `team_time`.`lastModifiedBy`
                    , `location`.`location`
                FROM
                    `intranet_db`.`prod_line`
                    INNER JOIN `intranet_db`.`team_time` 
                        ON (`prod_line`.`line_id` = `team_time`.`lineId`)
                    INNER JOIN `intranet_db`.`location` 
                        ON (`prod_line`.`location_id` = `location`.`location_id`)
                        WHERE `location`.`location_id` = '$location'";

        return $this->db->query($sql)->result();

    }

    public function getTeamTimeTOEdit($teamTimeid){
        $sql = "SELECT * FROM `team_time` WHERE id='$teamTimeid'";

        return $this->db->query($sql)->result();
    }

    public function editTeamTime($temaTimeId){
//        $line = $this->input->post('line');
        $date = date('Y-m-d H-m-s');

        $firstHStart = $this->input->post('1hStart');
        $firstHEnd = $this->input->post('1hEnd');

        $secondHStart = $this->input->post('2hStart');
        $secondHEnd = $this->input->post('2hEnd');

        $thirdHStart = $this->input->post('3hStart');
        $thirdHEnd = $this->input->post('3hEnd');

        $fourthHStart = $this->input->post('4hStart');
        $fourthHEnd = $this->input->post('4hEnd');

        $fifthHStart = $this->input->post('5hStart');
        $fifthHEnd = $this->input->post('5hEnd');

        $sixthHStart = $this->input->post('6hStart');
        $sixthHEnd = $this->input->post('6hEnd');

        $seventhHStart = $this->input->post('7hStart');
        $seventhHEnd = $this->input->post('7hEnd');

        $eighthHStart = $this->input->post('8hStart');
        $eighthHEnd = $this->input->post('8hEnd');

        $ninthHStart = $this->input->post('9hStart');
        $ninthHEnd = $this->input->post('9hEnd');

        $tenthHStart = $this->input->post('10hStart');
        $tenthHEnd = $this->input->post('10hEnd');

        $eleventhHStart = $this->input->post('11hStart');
        $eleventhHEnd = $this->input->post('11hEnd');

        $twelfthHStart = $this->input->post('12hStart');
        $twelfthHEnd = $this->input->post('12hEnd');

        $thirteenthHStart = $this->input->post('13hStart');
        $thirteenthHEnd = $this->input->post('13hEnd');

        $fourteenthHStart = $this->input->post('14hStart');
        $fourteenthHEnd = $this->input->post('14hEnd');

        $data = array(
            '1hStart'=>$firstHStart,
            '1hEnd'=>$firstHEnd,
            '2hStart'=>$secondHStart,
            '2hEnd'=>$secondHEnd,
            '3hStart'=>$thirdHStart,
            '3hEnd'=>$thirdHEnd,
            '4hStart'=>$fourthHStart,
            '4hEnd'=>$fourthHEnd,
            '5hStart'=>$fifthHStart,
            '5hEnd'=>$fifthHEnd,
            '6hStart'=>$sixthHStart,
            '6hEnd'=>$sixthHEnd,
            '7hStart'=>$seventhHStart,
            '7hEnd'=>$seventhHEnd,
            '8hStart'=>$eighthHStart,
            '8hEnd'=>$eighthHEnd,
            '9hStart'=>$ninthHStart,
            '9hEnd'=>$ninthHEnd,
            '10hStart'=>$tenthHStart,
            '10hEnd'=>$tenthHEnd,
            '11hStart'=>$eleventhHStart,
            '11hEnd'=>$eleventhHEnd,
            '12hStart'=>$twelfthHStart,
            '12hEnd'=>$twelfthHEnd,
            '13hStart'=>$thirteenthHStart,
            '13hEnd'=>$thirteenthHEnd,
            '14hStart'=>$fourteenthHStart,
            '14hEnd'=>$fourteenthHEnd,
            'lastModifiedDate'=> $date,
            'lastModifiedBy'=>$_SESSION['session_user_data']['userName']
        );
        $this->db->trans_start();

        $this->db->set($data);
        $this->db->where('id',$temaTimeId);
        $this->db->replace('team_time');
        return $this->db->trans_complete();

    }


}