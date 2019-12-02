<?php

class Time_template_model extends CI_Model{

    public function saveTimeTemplate(){
        $line = $this->input->post('line');
        $date = date('Y-m-d H-m-s');

        $tCode = $this->input->post('tcode');
        $tName = $this->input->post('tName');
        $location = $_SESSION['session_user_data']['location'];

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
            'templateCode'=>$tCode,
            'templateName'=>$tName,
            'location_id'=>$location,
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
        $this->db->insert('time_template', $data);
        return $this->db->trans_complete();

    }

    public function getTimeTemplate(){
        $location = $_SESSION['session_user_data']['location'];

        $sql  = "SELECT id,`templateCode`,`templateName`,`lastModifiedBy`,lastModifiedDate FROM `time_template` WHERE `location_id` = '$location'";

        return $this->db->query($sql)->result();

    }

    public function getTimeTempEdit($timeTempId){
        $sql = "SELECT * FROM `time_template` WHERE id='$timeTempId'";

        return $this->db->query($sql)->result();
    }

    public function editTimeTemp($timeTempId){
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
        $this->db->where('id',$timeTempId);
        $this->db->update('time_template');
        return $this->db->trans_complete();

    }

    public function checkTemplateCode(){

        $tCode = $this->input->post('tCode');
        $sql = "SELECT templateCode FROM time_template WHERE templateCode = '$tCode'";

        return $this->db->query($sql)->result();
    }
    public function checkTemplateName(){

        $tName = $this->input->post('tName');
        $sql = "SELECT templateName FROM time_template WHERE templateName = '$tName'";

        return $this->db->query($sql)->result();
    }


}