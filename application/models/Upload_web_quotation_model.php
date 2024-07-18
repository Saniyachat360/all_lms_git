<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Upload_web_quotation_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> process_name = $this -> session -> userdata('process_name');

		$this -> process_id = $_SESSION['process_id'];

	}

	public function upload($upload_id, $location, $model_code,  $type, $ex_showroom, $nexa_card, $number_plate, $zero_dep_insurance_with_rti_and_engine_protect, $individual_registration_with_hp, $company_registration_with_hp, $TCS, $fastag_cost, $royal_platinum_ew_price, $individual_on_road_price, $company_on_road_price, $consumer_offer, $rips_support, $exchange_bonus_more_than_7_year, $exchnage_bonus_less_than_7_year) {

		$date = date("Y-m-d");
		//echo $model_code;
		$q = $this -> db -> query("select model_id,variant_id from model_variant where variant_code='$model_code'") -> result();
		echo count($q);
		if (count($q) > 0) {
			$model_id = $q[0] -> model_id;
			$variant_id = $q[0] -> variant_id;
			$check_already=$this->db->query("select * from tbl_variant_onroad where model_code='$model_code' and location='$location'")->result();
			if(count($check_already)>0)
			{
				$quotation_id=$check_already[0]->quotation_id;
				$this->db->query("update tbl_variant_onroad set type='$type',ex_showroom='$ex_showroom',nexa_card='$nexa_card',number_plate='$number_plate',zero_dep_insurance_with_rti_and_engine_protect='$zero_dep_insurance_with_rti_and_engine_protect',
				individual_registration_with_hp='$individual_registration_with_hp',company_registration_with_hp='$company_registration_with_hp',TCS='$TCS',fastag_cost='$fastag_cost',royal_platinum_ew_price='$royal_platinum_ew_price',
				individual_on_road_price='$individual_on_road_price',company_on_road_price='$company_on_road_price',consumer_offer='$consumer_offer',rips_support='$rips_support',exchange_bonus_more_than_7_year='$exchange_bonus_more_than_7_year',exchnage_bonus_less_than_7_year='$exchnage_bonus_less_than_7_year',date='$date' where quotation_id='$quotation_id'");	
			}
			else {
				$query = $this -> db -> query("INSERT INTO `tbl_variant_onroad`(`location`, `model_code`, `model_id`, `variant_id`, `type`, `ex_showroom`, `nexa_card`, `number_plate`, `zero_dep_insurance_with_rti_and_engine_protect`, 
				`individual_registration_with_hp`, `company_registration_with_hp`, `TCS`, `fastag_cost`, `royal_platinum_ew_price`, `individual_on_road_price`, `company_on_road_price`, `consumer_offer`, `rips_support`, `exchange_bonus_more_than_7_year`, `exchnage_bonus_less_than_7_year` ,`date`, `upload_id`) 
			VALUES ('$location','$model_code','$model_id','$variant_id','$type','$ex_showroom','$nexa_card','$number_plate','$zero_dep_insurance_with_rti_and_engine_protect',
			'$individual_registration_with_hp','$company_registration_with_hp','$TCS','$fastag_cost','$royal_platinum_ew_price','$individual_on_road_price','$company_on_road_price','$consumer_offer','$rips_support','$exchange_bonus_more_than_7_year','$exchnage_bonus_less_than_7_year','$date','$upload_id')");
				}
			}
	}
	public function upload_corporate($corporate_name, $date) {
		//$test=$this->escape_str($corporate_name);
		$corporate_name = addslashes($corporate_name);
		$this -> db -> query("INSERT INTO `tbl_corporate`(`corporate_name`,`created_date`) VALUES ('$corporate_name','$date')");
	}
	public function download_old_data()
	{
		
		$this -> db -> select('o.*,m.model_name,v.variant_name');
		$this -> db -> from('tbl_variant_onroad o');
		$this -> db -> join('model_variant v', 'v.variant_id=o.variant_id');
		$this -> db -> join('make_models m', 'm.model_id=o.model_id');
		$this -> db -> order_by('location', 'asc');
		$query = $this -> db -> get();
		return $query -> result();

	
	}
public function last_backup_date()
	{
		
		$this -> db -> select('last_updated');
		$this -> db -> from('tbl_variant_onroad1 o');	
		$this->db->limit('1');	
		$query = $this -> db -> get();
		return $query -> result();

	
	}
public function backup_old_data()
	{
		$date=date('Y-m-d H:i:s');
		$this->db->query("TRUNCATE TABLE tbl_variant_onroad1");
		$this->db->query("INSERT INTO tbl_variant_onroad1 (`location`, `model_code`, `description`, `model_id`, `variant_id`, `type`, `ex_showroom`, `nexa_card`, `number_plate`, `zero_dep_insurance_with_rti_and_engine_protect`, `individual_registration_with_hp`, `company_registration_with_hp`, `TCS`, `fastag_cost`, `royal_platinum_ew_price`, `individual_on_road_price`, `company_on_road_price`, `consumer_offer`, `rips_support`, `exchange_bonus_more_than_7_year`, `exchnage_bonus_less_than_7_year`, `date`,last_updated)
		SELECT `location`, `model_code`, `description`, `model_id`, `variant_id`, `type`, `ex_showroom`, `nexa_card`, `number_plate`, `zero_dep_insurance_with_rti_and_engine_protect`, `individual_registration_with_hp`, `company_registration_with_hp`, `TCS`, `fastag_cost`, `royal_platinum_ew_price`, `individual_on_road_price`, `company_on_road_price`, `consumer_offer`, `rips_support`, `exchange_bonus_more_than_7_year`, `exchnage_bonus_less_than_7_year`, `date`,'$date'
		FROM tbl_variant_onroad");
		if ($this -> db -> affected_rows() > 0) {

				$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Backup Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			} else {
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Backup Not Updated ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			}
	
	}
public function restorebackup()
	{
		$this->db->query("TRUNCATE TABLE tbl_variant_onroad");
		$this->db->query("INSERT INTO tbl_variant_onroad (`location`, `model_code`, `description`, `model_id`, `variant_id`, `type`, `ex_showroom`, `nexa_card`, `number_plate`, `zero_dep_insurance_with_rti_and_engine_protect`, `individual_registration_with_hp`, `company_registration_with_hp`, `TCS`, `fastag_cost`, `royal_platinum_ew_price`, `individual_on_road_price`, `company_on_road_price`, `consumer_offer`, `rips_support`, `exchange_bonus_more_than_7_year`, `exchnage_bonus_less_than_7_year`, `date`)
		SELECT `location`, `model_code`, `description`, `model_id`, `variant_id`, `type`, `ex_showroom`, `nexa_card`, `number_plate`, `zero_dep_insurance_with_rti_and_engine_protect`, `individual_registration_with_hp`, `company_registration_with_hp`, `TCS`, `fastag_cost`, `royal_platinum_ew_price`, `individual_on_road_price`, `company_on_road_price`, `consumer_offer`, `rips_support`, `exchange_bonus_more_than_7_year`, `exchnage_bonus_less_than_7_year`, `date`
		FROM tbl_variant_onroad1");
		if ($this -> db -> affected_rows() > 0) {

				$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Backup Restored Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			} else {
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Backup Not Restored Updated ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			}
	
	}
	public function last_updated_date_performa_offer()
	{
		$this -> db -> select('date');
		$this -> db -> from('tbl_onroad_performa_offer o');	
		$this->db->limit('1');	
		$query = $this -> db -> get();
		return $query -> result();
	}
	public function last_updated_date_performa()
	{
		$this -> db -> select('date');
		$this -> db -> from('tbl_onroad_performa_invoice o');	
		$this->db->limit('1');	
		$query = $this -> db -> get();
		return $query -> result();
	}
	public function upload_onroad_perfoma($location,$model_code,$type,$basic_price,$ex_showroom,$nexa_card,$ins_corp,$zero_dep_insurance_with_rti_and_engine_protect,$individual_registration_with_hp,$company_registration_with_hp,$registration,$fastag_cost,$warranty,$individual_on_road_price,$company_on_road_price) {

		$date = date("Y-m-d");
		//echo $model_code;
		$q = $this -> db -> query("select model_id,variant_id from model_variant where variant_code='$model_code'") -> result();
		echo count($q);
		if (count($q) > 0) {
			$model_id = $q[0] -> model_id;
			$variant_id = $q[0] -> variant_id;
			$check_already=$this->db->query("select * from tbl_onroad_performa_invoice where model_code='$model_code' and location='$location'")->result();
			if(count($check_already)>0)
			{
				$quotation_id=$check_already[0]->quotation_id;
				$this->db->query("update tbl_onroad_performa_invoice set type='$type',ex_showroom='$ex_showroom',nexa_card='$nexa_card',basic_price='$basic_price',zero_dep_insurance_with_rti_and_engine_protect='$zero_dep_insurance_with_rti_and_engine_protect',
				individual_registration_with_hp='$individual_registration_with_hp',company_registration_with_hp='$company_registration_with_hp',registration='$registration',fastag_cost='$fastag_cost',warranty='$warranty',
				individual_on_road_price='$individual_on_road_price',ins_corp='$ins_corp',company_on_road_price='$company_on_road_price',date='$date' where quotation_id='$quotation_id'");	
			}
			else {
				$query = $this -> db -> query("INSERT INTO `tbl_onroad_performa_invoice`(`location`, `model_code`, `model_id`, `variant_id`, `type`, `ex_showroom`, `nexa_card`, `basic_price`, `zero_dep_insurance_with_rti_and_engine_protect`, 
				`individual_registration_with_hp`, `company_registration_with_hp`, `fastag_cost`,  `individual_on_road_price`, `warranty`, `registration` ,`date`,company_on_road_price) 
			VALUES ('$location','$model_code','$model_id','$variant_id','$type','$ex_showroom','$nexa_card','$basic_price','$zero_dep_insurance_with_rti_and_engine_protect',
			'$individual_registration_with_hp','$company_registration_with_hp','$fastag_cost','$individual_on_road_price','$warranty','$registration','$date','$company_on_road_price')");
				}
			}
	}
		public function upload_onroad_perfoma_offer($location,$model_code,$type,$description,$cons_off,$cons_offdlr,$scheme_name,$rips,$dco,$dcodlr,$fame,$finpay,$focdisc,$jol,$joldlr,$rips1,$ripsdlr,$rmk,$rmkdlr,$tyt,$tytdlr,$woi,$woidlr) {

		$date = date("Y-m-d");
		//echo $model_code;
		$q = $this -> db -> query("select model_id,variant_id from model_variant where variant_code='$model_code'") -> result();
		echo count($q);
		if (count($q) > 0) {
			$model_id = $q[0] -> model_id;
			$variant_id = $q[0] -> variant_id;
			$check_already=$this->db->query("select * from tbl_onroad_performa_offer  where model_code='$model_code' and location='$location'")->result();
			if(count($check_already)>0)
			{
				$quotation_id=$check_already[0]->offer_id;
				$this->db->query("update tbl_onroad_performa_offer  set type='$type',cons_off='$cons_off',cons_offdlr='$cons_offdlr',scheme_name='$scheme_name',rips='$rips',dco='$dco',dcodlr='$dcodlr',fame='$fame',finpay='$finpay',focdisc='$focdisc',jol='$jol',joldlr='$joldlr',rips1='$rips1',ripsdlr='$ripsdlr',rmk='$rmk',rmkdlr='$rmkdlr',
					tyt='$tyt',tytdlr='$tytdlr',woi='$woi',woidlr='$woidlr',
				date='$date' where offer_id='$quotation_id'");	
			}
			else {
				$query = $this -> db -> query("INSERT INTO `tbl_onroad_performa_offer`(`location`, `model_code`, `model_id`, `variant_id`, `type`, `description`, `cons_off`, `cons_offdlr`, `scheme_name`, 
				`rips`,`date`,`dco`, `dcodlr`, `fame`, `finpay`, `focdisc`, `jol`, `joldlr`, `rips1`, `ripsdlr`, `rmk`, `rmkdlr`, `tyt`, `tytdlr`, `woi`, `woidlr`) 
			VALUES ('$location','$model_code','$model_id','$variant_id','$type','$description','$cons_off','$cons_offdlr','$scheme_name','$rips','$date','$dco','$dcodlr','$fame','$finpay','$focdisc','$jol','$joldlr','$rips1','$ripsdlr','$rmk','$rmkdlr','$tyt','$tytdlr','$woi','$woidlr')");
				}
			}
	}public function download_old_data_performa()
	{
		
		$this -> db -> select('o.*,m.model_name,v.variant_name');
		$this -> db -> from('tbl_onroad_performa_invoice o');
		$this -> db -> join('model_variant v', 'v.variant_id=o.variant_id');
		$this -> db -> join('make_models m', 'm.model_id=o.model_id');
		$this -> db -> order_by('location', 'asc');
		$query = $this -> db -> get();
		return $query -> result();

	
	}
	public function download_old_data_performa_offer()
	{
		
		$this -> db -> select('o.*,m.model_name,v.variant_name');
		$this -> db -> from('tbl_onroad_performa_offer o');
		$this -> db -> join('model_variant v', 'v.variant_id=o.variant_id');
		$this -> db -> join('make_models m', 'm.model_id=o.model_id');
		$this -> db -> order_by('location', 'asc');
		$query = $this -> db -> get();
		return $query -> result();

	
	}

}
