<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Upload_exshowroom_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> process_name = $this -> session -> userdata('process_name');

		$this -> process_id = $_SESSION['process_id'];

	}
    public function last_backup_date()
	{
		
		$this -> db -> select('last_updated');
		$this -> db -> from('tbl_variant_onroad1 o');	
		$this->db->limit('1');	
		$query = $this -> db -> get();
		return $query -> result();

	
	}
	public function upload_exshowroom($location,$model_code,$type,$exshowroom_mumbai,$exshowroom_pune,$exshowroom_new_mumbai,$exshowroom_thane) {
echo "hi";
		$date = date("Y-m-d");
		//echo $model_code;
		$q = $this -> db -> query("select model_id,variant_id from model_variant where variant_code='$model_code'") -> result();
		echo count($q);
		if (count($q) > 0) {
		echo	$model_id = $q[0] -> model_id;
			$variant_id = $q[0] -> variant_id;
			/*$check_already=$this->db->query("select * from tbl_onroad_performa_invoice where model_code='$model_code' and location='$location'")->result();
			if(count($check_already)>0)
			{*/
				
				$this->db->query("update model_variant set ex_showroom_price='$exshowroom_mumbai',ex_showroom_navi_mumbai_price='$exshowroom_new_mumbai',ex_showroom_pune_price='$exshowroom_pune',ex_showroom_thane_price='$exshowroom_thane',last_updated_date='$date' where variant_code='$model_code'");
			/*}
			else {
				$query = $this -> db -> query("INSERT INTO `tbl_onroad_performa_invoice`(`location`, `model_code`, `model_id`, `variant_id`, `type`, `ex_showroom`, `nexa_card`, `basic_price`, `zero_dep_insurance_with_rti_and_engine_protect`, 
				`individual_registration_with_hp`, `company_registration_with_hp`, `fastag_cost`,  `individual_on_road_price`, `warranty`, `registration` ,`date`,company_on_road_price) 
			VALUES ('$location','$model_code','$model_id','$variant_id','$type','$ex_showroom','$nexa_card','$basic_price','$zero_dep_insurance_with_rti_and_engine_protect',
			'$individual_registration_with_hp','$company_registration_with_hp','$fastag_cost','$individual_on_road_price','$warranty','$registration','$date','$company_on_road_price')");
				}*/
			}
	}
}