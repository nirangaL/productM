<?php

class Qc_checker_model extends CI_Model{

    public  $lastHeaderSavedId;
    public  $gridSavedId;
    public  $location;
    public $lineNo;

    private $accellarDb;


    function __construct()
    {
        parent::__construct();
        $this->accellarDb = $this->load->database('accellardb',TRUE);
        $this->load->helper('cookie');

        $this->lineNo = get_cookie('line');
        $this->location = get_cookie('location');
    }

    public function getStyle(){
        $result = $this->db->query("SELECT styleNo FROM `style_Info` GROUP BY styleNo")->result();
        return $result;
    }

    public function getStyleSCNumDelNums(){

        $styleName = $this->input->post('styleName');

        $result = $this->db->query("SELECT scNumber,deliveryNo,deliveryType FROM `style_Info` WHERE styleNo = '$styleName' GROUP BY deliveryNo")->result();
        return $result;
    }

    public function getStyleColor(){

        $styleName = $this->input->post('styleName');
        $deliNo = $this->input->post('deliNo');

        $result = $this->db->query("SELECT garmentColour FROM `style_Info` WHERE styleNo = '$styleName' AND deliveryNo = '$deliNo' GROUP BY garmentColour")->result();
        return $result;
    }

    public function getStyleSize(){
        $styleName = $this->input->post('styleName');
        $result = $this->db->query("SELECT `size` FROM `style_Info` WHERE styleNo = '$styleName' GROUP BY size")->result();
        return $result;
    }

    public function insertData(){
        $this->db->trans_start();
        $this->saveHeaderData();
        $this->saveGridData();
        return $this->db->trans_complete();
    }

    public function saveHeaderData(){
        $this->lastHeaderSavedId = '';

        $style = $this->input->post('style');
        $sc_no = $this->input->post('sc_no');
        $del_no = $this->input->post('del_no');
        $del_Type = $this->input->post('del_type');
        $line_no =  $this->lineNo;
        $currentDate = date('Y-m-d');
        ///////////////////// check the this style already save ///////////////////////

        $sql = "SELECT id FROM checking_header_tb WHERE style ='$style' AND scNumber='$sc_no' AND deliverNo='$del_no' AND deliveryType = '$del_Type'  AND lineNo='$line_no' AND DATE(`dateTime`)  = '$currentDate'";

        $result = $this->db->query($sql)->result();
        if(empty($result)){
            $data = array(
                'scNumber' => $sc_no,
                'location' => $this->location,
                'style' => $style,
                'deliverNo' => $del_no,
                'deliveryType' => $del_Type,
                'lineNo' =>  $line_no,
                'dateTime' => date('Y-m-d H:i:s')
            );
             $this->db->insert('checking_header_tb', $data);
            $this->lastHeaderSavedId = $this->db->insert_id();
        }else{
            $this->lastHeaderSavedId = $result[0]->id;
        }

    }

    public function saveGridData(){
        $color = $this->input->post('color');
        $size = $this->input->post('size');
        $checking_id = $this->lastHeaderSavedId;

        $curDate = date('Y-m-d');

        $sql = "SELECT `id`,`passQty`,`rejectQty`,`remakeQty`,`reRejectQty` FROM checking_grid_tb WHERE color ='$color' AND size='$size' AND chckHeaderId ='$checking_id' AND DATE(`lastModifiedDate`) = '$curDate'";
        $result = $this->db->query($sql)->result();

        if(empty($result)){
            $this->saveGridDataNew();
        }else{
            $this->gridSavedId = $result[0]->id;

            $passQty =$result[0]->passQty;
            $rejectQty =$result[0]->rejectQty;
            $remakeQty =$result[0]->remakeQty;
            $reRejectQty =$result[0]->reRejectQty;

            $this->updateGridData($passQty,$rejectQty,$remakeQty,$reRejectQty);
        }
    }

    public function saveGridDataNew(){
        $color = $this->input->post('color');
        $size = $this->input->post('size');
        $status = $this->input->post('status');

        $data = array(
            'chckHeaderId' => $this->lastHeaderSavedId,
            'color' => $color,
            'size' => $size,
            'lastModifiedDate' => date('Y-m-d H:i:s')
        );

        if($status == 'pass'){
            $pass_count = 1;
            $data += array(
                'passQty' => $pass_count
            );
        }

        if($status == 'reject'){
            $reject_count = 1;
            $data += array(
                'rejectQty' => $reject_count
            );
        }

        if($status == 'remake'){
            $remake_count = 1;
            $reject_count = 1;
            $data += array(
                'remakeQty' => $remake_count,
                'rejectQty' => $reject_count
            );
        }

//        if($status == 'rereject'){
//            $reReject_count = 1;
//            $reject_count = 1;
//            $data += array(
//                'reRejectQty' => $reReject_count,
//                'rejectQty' => $reject_count
//            );
//        }

         $this->db->insert('checking_grid_tb', $data);
         $this->gridSavedId = $this->db->insert_id();

        if($status == 'pass'){
            $this->setPassLog();
        }
        if($status == 'reject'){
            $this->setRejectLog();
        }
        if($status == 'remake'){
            $this->setRemakeLog();
        }
        if($status == 'rereject'){
            $this->setReRejectLog();
        }


    }

    public function updateGridData($passQty,$rejectQty,$remakeQty,$reRejectQty){

        $status = $this->input->post('status');
        $data = array(
            'lastModifiedDate' => date('Y-m-d H:i:s')
        );

        if($status == 'pass'){
            $data += array(
                'passQty' => ($passQty + 1)
            );
        }
        if($status == 'reject'){
            $data += array(
                'rejectQty' => ($rejectQty +1)
            );
        }

        if($status == 'remake'){

            $reReject_count = $this->input->post('rereject_count');
            $data += array(
                'remakeQty' => ($remakeQty + 1),
                'rejectQty' => ($rejectQty - 1),
                'reRejectQty' => $reReject_count
            );
        }

        if($status == 'rereject'){
//            $reReject_count = $this->input->post('rereject_count');
//            $reject_count = $this->input->post('reject_count');
            $data += array(
                'reRejectQty' => ($reRejectQty + 1),
                'rejectQty' => ($rejectQty +1)
            );
        }

        $this->db->where('chckHeaderId',$this->lastHeaderSavedId);
        $this->db->where('id',$this->gridSavedId);
        $this->db->update('checking_grid_tb', $data);

        if($status == 'pass'){
         $this->setPassLog();
        }
        if($status == 'reject'){
            $this->setRejectLog();
        }
        if($status == 'remake'){
            $this->setRemakeLog();
        }
        if($status == 'rereject'){
            $this->setReRejectLog();
        }
    }

    /////// ********** set log ***********//////

    public function setPassLog(){
        $header_id = $this->lastHeaderSavedId;
        $grid_id = $this->gridSavedId;
        $color = $this->input->post('color');
        $size = $this->input->post('size');
        $data = array(
            'chckHeaderId' => $header_id,
            'chckGridId' => $grid_id,
            'color' => $color,
            'size' => $size,
            'dateTime' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('qc_pass_log', $data);
    }

    public function setRejectLog(){
        $header_id = $this->lastHeaderSavedId;
        $grid_id = $this->gridSavedId;
        $color = $this->input->post('color');
        $size = $this->input->post('size');
        $reject_reason = $this->input->post('reject_reason');
        $reject_remark = $this->input->post('reject_remark');

        $data = array(
            'chckHeaderId' => $header_id,
            'chckGridId' => $grid_id,
            'rejectReason' => $reject_reason,
            'rejectRemark' => $reject_remark,
            'color' => $color,
            'size' => $size,
            'dateTime' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('qc_reject_log', $data);
    }

    public function setRemakeLog(){
        $header_id = $this->lastHeaderSavedId;
        $grid_id = $this->gridSavedId;
        $color = $this->input->post('color');
        $size = $this->input->post('size');
        $data = array(
            'chckHeaderId' => $header_id,
            'chckGridId' => $grid_id,
            'color' => $color,
            'size' => $size,
            'dateTime' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('qc_remake_log', $data);

    }

    public function setReRejectLog(){
        $header_id = $this->lastHeaderSavedId;
        $grid_id = $this->gridSavedId;
        $color = $this->input->post('color');
        $size = $this->input->post('size');
        $data = array(
            'chckHeaderId' => $header_id,
            'chckGridId' => $grid_id,
            'color' => $color,
            'size' => $size,
            'dateTime' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('qc_rereject_log', $data);

    }

    public function saveCount($teamId){
        $style = $this->input->post('style');
        $delv= $this->input->post('delv');
        $color = $this->input->post('color');
        $passCount = $this->input->post('passCount');
        $rejectCount = $this->input->post('rejectCount');
        $remakeCount = $this->input->post('remakeCount');
        $rerejectCount = $this->input->post('rerejectCount');

        $data = array(
            'teamId'=>$teamId,
            'style'=>$style,
            'delv'=>$delv,
            'color'=>$color,
            'passCount'=>$passCount,
            'reworkCount'=>$rejectCount,
            'remakeCount'=>$remakeCount,
            'reReReworkCount'=>$rerejectCount,
            'dateTime'=>date('Y-m-d H:i:s'),
        );

        $this->db->trans_start();
        $this->db->insert('qc_app_count',$data);
       return $this->db->trans_complete();

    }

    /////// ********** ending set log ***********//////
    public function getCount($teamId){
        $style = $this->input->post('styleName');
        $del_no = $this->input->post('deliNo');
        $date = date('Y-m-d');

        $sql = "SELECT
                  `id`,
                  `passCount`,
                  `reworkCount`,
                  `remakeCount`,
                  `reReReworkCount`,
                  `dateTime`
                FROM
                  `intranet_db`.`qc_app_count`
                WHERE teamId = '$teamId'
                  AND style = '$style'
                  AND delv = '$del_no'
                  AND DATE(`dateTime`) = '$date' ORDER By id DESC";

       $result =  $this->db->query($sql)->result();
       return $result;
    }

    public function getRejectReson(){
        $sql = "SELECT * FROM `reject_master`";
        $result =  $this->db->query($sql)->result();
        return $result;
    }

    public function getRunningStyleData(){
        $lineNo = $this->lineNo;
        $today = date('Y-m-d');

        $sql = "SELECT
                      `day_plan`.`id`
                    , `day_plan`.`line`
                    , `day_plan`.`style`
                    , `day_plan`.`scNumber`
                    , `day_plan`.`delivery`
                    , `day_plan`.`orderQty`
                    , `day_plan`.`planQty`
                    , `day_plan`.`hrs`
                    , `day_plan`.`smv`
                    , `day_plan`.`noOfwokers`
                    , `day_plan`.`location`
                    , prod_line.`line` AS lineName
                    , `day_plan`.`createDate`
                    , SUM(`checking_grid_tb`.`passQty`) AS actualQty
                FROM
                    `intranet_db`.`checking_header_tb`
                    INNER JOIN `intranet_db`.`day_plan`
                        ON (`checking_header_tb`.`style` = `day_plan`.`style`) AND (`checking_header_tb`.`deliverNo` = `day_plan`.`delivery`)
                    INNER JOIN `intranet_db`.`checking_grid_tb`
                        ON (`checking_header_tb`.`id` = `checking_grid_tb`.`chckHeaderId`)
                    INNER JOIN `intranet_db`.`prod_line`
                    ON (`checking_header_tb`.`lineNo` = `prod_line`.`line_id`)
                        WHERE day_plan.line = '$lineNo' AND day_plan.status ='1' AND DATE(`checking_header_tb`.`dateTime`) = DATE(day_plan.createDate) AND DATE(day_plan.createDate) = '$today'";

        return $this->db->query($sql)->result();

    }

    public function getTeam(){
        $teamId = $this->input->post('team_id');

        $sql = "SELECT line FROM prod_line WHERE line_id = '$teamId'";

        return $this->db->query($sql)->result();

    }

    public function checkOtherPlan($newStyle,$newDelv){
        $date = date('Y-m-d');
        $sql = "SELECT id,style,delivery,feedingHour FROM `day_plan` WHERE `style` ='$newStyle' AND `delivery` ='$newDelv' AND `status` IN ('2','4') AND line ='$this->lineNo' AND DATE(`createDate`) = '$date'";

        return $this->db->query($sql)->result();
    }

    public function switchStyleStatus($prevStyle,$prevDelv,$newStyleId){

        $this->db->trans_start();
        $this->changeToStyleHold($prevStyle,$prevDelv);
        $this->changeToStyleRunn($newStyleId);
        return $this->db->trans_complete();
    }

    public function changeToStyleHold($prevStyle,$prevDelv){
        $date = date('Y-m-d');
        // $sql =  "UPDATE day_plan SET `status`='2' WHERE style='$prevStyle' AND delivery='$prevDelv' AND DATE(createDate) ='$date' AND line ='$this->lineNo'";
        $sql =  "UPDATE day_plan SET `status`='2' WHERE `status`='1' AND DATE(createDate) ='$date' AND line ='$this->lineNo'";
        return $this->db->query($sql);
    }

    public function changeToStyleRunn($newStyleId){
        $sql =  "UPDATE day_plan SET `status`='1' WHERE id='$newStyleId'";
        return $this->db->query($sql);
    }

    public function getCountFormLog(){
      $teamId = $this->lineNo;
      $style = $this->input->post('style');
      $date = date('Y-m-d');
      $sql ="SELECT
      `checking_header_tb`.`lineNo`
      , `checking_header_tb`.`style`
      ,(SELECT COALESCE(COUNT(id),0) AS pass FROM `qc_pass_log` WHERE `chckHeaderId` = `checking_header_tb`.`id`) AS passQty
      ,(SELECT COALESCE(COUNT(rejectId),0) FROM `qc_reject_log` WHERE `chckHeaderId` = `checking_header_tb`.`id`  ) - (SELECT COALESCE(COUNT(id),0) FROM `qc_remake_log` WHERE `chckHeaderId` = `checking_header_tb`.`id`) -(SELECT COALESCE(COUNT(id),0) FROM `qc_rereject_log` WHERE `chckHeaderId` = `checking_header_tb`.`id`)  AS rejectQty
      ,(SELECT COALESCE(COUNT(id),0) FROM `qc_remake_log` WHERE `chckHeaderId` = `checking_header_tb`.`id`) AS remakeQty
      ,(SELECT COALESCE(COUNT(id),0) FROM `qc_rereject_log` WHERE `chckHeaderId` = `checking_header_tb`.`id`) AS rerejectQty
      FROM
      `checking_header_tb`
      LEFT JOIN `qc_pass_log`
      ON (`checking_header_tb`.`id` = `qc_pass_log`.`chckHeaderId`)
      LEFT JOIN `qc_reject_log`
      ON (`checking_header_tb`.`id` = `qc_reject_log`.`chckHeaderId`)
      LEFT JOIN `qc_remake_log`
      ON (`checking_header_tb`.`id` = `qc_remake_log`.`chckHeaderId`)
      LEFT JOIN `qc_rereject_log`
      ON (`checking_header_tb`.`id` = `qc_rereject_log`.`chckHeaderId`) WHERE style='$style' AND lineNo='$teamId' AND DATE(`checking_header_tb`.`dateTime`)='$date' GROUP BY style ;";

      return $this->db->query($sql)->result();
    }


}
