<?php

class Style_info_model extends CI_model{

	public function getBuyers(){
		$sql = "SELECT
						  t1.buyer
						FROM
						  `temp_accller_view` t1
						GROUP BY t1.`buyer`";
		return $this->db->query($sql)->result();
	}

	public function getSeasonModel(){
		$buyer_name = $this->input->post('mod_name_buyer');
		$sql = "SELECT
							t1.`season`
						FROM
						`temp_accller_view` t1
						WHERE t1.buyer = '$buyer_name'
						GROUP BY t1.`season`";
		return $this->db->query($sql)->result();
	}

	public function getStyle(){
		$buyer = $this->input->post('buyer');
		$season = $this->input->post('season');

			$sql = "SELECT
				t1.`style`
			FROM
			`temp_accller_view` t1
			WHERE t1.buyer = '$buyer' AND t1.season = '$season'
			GROUP BY t1.`style`";
		return $this->db->query($sql)->result();
	}

	public function getSC_and_Delivery(){
		$style_name = $this->input->post('style_name_view');
		$sql = "SELECT
						  t1.`sc`,
						  t1.`po`,
						  t1.`merchant`,
							t1.`csrNo`
						FROM
						  `temp_accller_view` t1
						  WHERE style='$style_name'
						GROUP BY t1.`po`";
		return $this->db->query($sql)->result();
	}

	public function getDelvDateAndColor(){
		$style_name = $this->input->post('style_name_view');
		$po = $this->input->post('po');
		$sql = "SELECT
						  t1.`delvDate`,
						  t1.`delvType`,
						  t1.`color`
						FROM
						  `temp_accller_view` t1
						  WHERE t1.style= '$style_name' AND t1.po = '$po'
						GROUP BY t1.`color`";
		return $this->db->query($sql)->result();
	}

	public function getSizeAndOrderQty(){
		$style_name = $this->input->post('style_name_view');
		$po = $this->input->post('po');
		$color = $this->input->post('color');
		$sql = "SELECT
						  t1.`size`,
						  t1.`orderQty`
						FROM
						  `temp_accller_view` t1
						  LEFT JOIN `product_bpom_style_info` t2
						    ON t1.`id` = t2.`accellar_id`
						WHERE (t2.`accellar_id` IS NULL OR t2.`delete_rec` != '0' OR t2.`delete_rec` IS NULL)
						  AND t1.style= '$style_name' AND t1.po = '$po' AND t1.color ='$color'
						GROUP BY t1.`size`";
		// echo $sql;exit();

		return $this->db->query($sql)->result();
	}

	public function getQtyAndAccellerId(){
		$style_name = $this->input->post('style_name_view');
		$po = $this->input->post('po');
		$color = $this->input->post('color');
		$size = $this->input->post('size');
		$sql = "SELECT
					  t1.`size`,
					  t1.`qty`,
					  t1.`id`
					FROM
					  `temp_accller_view` t1
					  LEFT JOIN `product_bpom_style_info` t2
					    ON t1.`id` = t2.`accellar_id`
					WHERE (t2.`accellar_id` IS NULL OR t2.`delete_rec` != '0' OR t2.`delete_rec` IS NULL)
					  AND t1.style= '$style_name' AND t1.po = '$po' AND t1.color ='$color' AND t1.size ='$size'";

		return $this->db->query($sql)->result();
	}
	// ----------------------------------------------------------- Save Style -------------------------------------------------------------------------------------

	public function insertStyleData(){

		$accellar_id = $this->input->post('accllerId');
		$buyer = $this->input->post('buyer');
		$season = $this->input->post('season');
		$s_name = $this->input->post('s_name');
		$sc = $this->input->post('sc');
		$po = $this->input->post('po');
		$color = $this->input->post('color');
		$colorOrderQty = $this->input->post('orderQty');
		$size = $this->input->post('size');
		$qty = $this->input->post('qty');
		$delvDate = $this->input->post('delDate');
		$delType = $this->input->post('delType');
		$csrNo = $this->input->post('csrNo');
		$merchant = $this->input->post('merchant');
		$user = $this->myConUserName;

		$data = array(
    'accellar_id'=> $accellar_id,
    'buyer'=>$buyer,
    'season'=>$season,
    'style_name'=>$s_name,
    'sc'=>$sc,
    'po'=>$po,
    'color'=>$color,
    'colorOrderQty'=>$colorOrderQty,
    'size'=>$size,
    'qty'=>$qty,
    'delvDate'=>$delvDate,
    'delType'=>$delType,
    'csrNo'=>$csrNo,
    'merchant'=>$merchant,
    'delete_rec'=>'0',
    'user_name'=>$user,
		);

		if($this->checkAlreadyExist($accellar_id)){
			$this->db->trans_start();
			$this->db->where('accellar_id',$accellar_id);
			$this->db->update('product_bpom_style_info', $data);
			return $this->db->trans_complete();
		}else{
			$this->db->trans_start();
			$this->db->insert('product_bpom_style_info', $data);
			return $this->db->trans_complete();
		}


	}

	public function getTableData(){
		$style = $this->input->post('style');
		$po = $this->input->post('po');
		$sql = "SELECT * FROM `product_bpom_style_info` WHERE `delete_rec` ='0' AND style_name='$style' AND po = '$po'";
		return $this->db->query($sql)->result();
	}

	public function deleteRow(){
	$id = $this->input->post('id');
	$user = $this->myConUserName;
	$this->db->trans_start();
		$this->db->set('delete_rec','1');
		$this->db->set('delete_user',$user);
		$this->db->where('id',$id);
	$this->db->update('product_bpom_style_info');
	return $this->db->trans_complete();
	}

	public function checkAlreadyExist($accellar_id){
		$sql = "SELECT accellar_id FROM `product_bpom_style_info` WHERE accellar_id='$accellar_id' AND delete_rec ='1'";
		return $this->db->query($sql)->result();
	}

}

?>
