<?php

class Incentive_model extends CI_model{

    private $lineNo;
    private $location;

    function __construct()
    {
        parent::__construct();
        $this->load->helper('cookie');
    }

   public function getRange($locationId){
     $sql =   "SELECT
     id,
     startSmv,
     endSmv,
     location.`location`
     FROM
     `incentive_ladder_h`
     INNER JOIN `location`
     ON (
       `incentive_ladder_h`.`location` = ``.`location_id`
     )
     WHERE incentive_ladder_h.location = '$locationId'";

  return $this->db->query($sql)->result();
    }

   public function checkOutSmvRange($location){
        $startSmv = (Int)$this->input->post('startSmv') + 1;
        $endSmv = (Int)$this->input->post('endSmv') -1;

        $sql = "SELECT
                id,
                startSmv,
                endSmv
              FROM
                incentive_ladder_h
              WHERE startSmv BETWEEN '$startSmv'
                  AND '$endSmv'
                OR endSmv BETWEEN '$startSmv'
                  AND '$endSmv'
                AND `location` = '$location'
              GROUP BY startSmv";
        return $this->db->query($sql)->result();
   }


   public function setIncentiveRenge($location){
     $rowCount = $this->input->post('tblRowCount');
     $startSmv = $this->input->post('startSmv');
     $endSmv = $this->input->post('endSmv');

     $hData =   array(
       'location' => $location,
       'startSmv' => $startSmv,
       'endSmv' => $endSmv,
       'createBy' => $_SESSION['session_user_data']['userName'],
     );
     $this->db->trans_start();
     $this->db->insert('incentive_ladder_h',$hData);
     $insertHederId = $this->db->insert_id();

     for($i=1;$i<$rowCount;$i++){

       $efficiency = $this->input->post('efficiency'.$i);
       $base_amount = $this->input->post('baseAmount'.$i);
       $incre_percent = $this->input->post('increPercent'.$i);
       $incre_amount = $this->input->post('increAmount'.$i);

     if( $efficiency ==''){
        $efficiency =  0;
     }
     if( $base_amount ==''){
        $base_amount =  0;
     }
     if( $incre_percent ==''){
        $incre_percent =  0;
     }
     if( $incre_amount ==''){
        $incre_amount =  0;
     }

       $data = array(
         'headerId'=>$insertHederId,
         'day'=>$this->input->post('day'.$i),
         'efficiency'=>$efficiency,
         'base_amount'=>$base_amount,
          'incre_percent'=>$incre_percent,
         'incre_amount'=>$incre_amount,
         'decre_amount'=>0,
       );
       $this->db->insert('incentive_ladder_g',$data);
     }
     return $this->db->trans_complete();
   }

   public function getIncentiveRangeToEdit($id){
     $sql = "SELECT
     t2.`id`,
     t2.`startSmv`,
     t2.`endSmv`,
     t1.`day`,
     t1.`efficiency`,
     t1.`base_amount`,
     t1.`incre_percent`,
     t1.`incre_amount`
     FROM
     `incentive_ladder_g` t1
     INNER JOIN `incentive_ladder_h` t2
     ON (t1.`headerId` = t2.`id`) WHERE t2.`id` = '$id'";

     return $this->db->query($sql)->result();
   }

   public function editIncentiveRenge($id){
     $rowCount = $this->input->post('tblRowCount');
     $startSmv = $this->input->post('startSmv');
     $endSmv = $this->input->post('endSmv');

     $hData =   array(
       'startSmv' => $startSmv,
       'endSmv' => $endSmv,
       'createBy' => $_SESSION['session_user_data']['userName'],
     );
     $this->db->trans_start();
     $this->db->where('id',$id);
     $this->db->update('incentive_ladder_h',$hData);

     $this->db->where('headerId',$id);
     $this->db->delete('incentive_ladder_g');

     for($i=1;$i<$rowCount;$i++){

       $efficiency = $this->input->post('efficiency'.$i);
       $base_amount = $this->input->post('baseAmount'.$i);
       $incre_percent = $this->input->post('increPercent'.$i);
       $incre_amount = $this->input->post('increAmount'.$i);

     if( $efficiency ==''){
        $efficiency =  0;
     }
     if( $base_amount ==''){
        $base_amount =  0;
     }
     if( $incre_percent ==''){
        $incre_percent =  0;
     }
     if( $incre_amount ==''){
        $incre_amount =  0;
     }

       $data = array(
         'headerId'=>$id,
         'day'=>$this->input->post('day'.$i),
         'efficiency'=>$efficiency,
         'base_amount'=>$base_amount,
          'incre_percent'=>$incre_percent,
         'incre_amount'=>$incre_amount,
         'decre_amount'=>0,
       );
       $this->db->insert('incentive_ladder_g',$data);
     }
     return $this->db->trans_complete();
   }

}
