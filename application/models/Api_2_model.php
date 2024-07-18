<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_2_model extends CI_model {
	function __construct() {
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");	
		$this->today=date('Y-m-d');
		$this->time=date("h:i:s A");
	}



function quotation_location() {
		$this->db->select('location');
	$this->db->from('tbl_onroad_performa_invoice');
	$this->db->group_by('location');
	$query=$this->db->get();
	return $query->result();
	}
	function quotation_location1() {
		$this->db->distinct();
		$this->db->select('location');
		$this->db->from('tbl_variant_onroad');
		$query = $this->db->get();
		return $query->result();
	/*	$this->db->distinct();
		$this->db->select('location');
		$this->db->from('tbl_quotation');
		$query1 = $this->db->get()->result();
		// send select location default from database
		$this->db->distinct();
		$this->db->select('location');
		$this->db->from('tbl_quotation1');
		$query2 = $this->db->get()->result();
		$query3 = array_merge($query2, $query1);
		return $query3;*/
	}
	function quotation_model_name($quotation_location) {
			//$quotation_location = $this -> input -> post('quotation_location');
	$this->db->select('*');
	$this->db->from('tbl_onroad_performa_invoice op');
	$this->db->join('make_models m','m.model_id=op.model_id');
	$this->db->where('op.location',$quotation_location);
	$this->db->group_by('op.model_id');
	$query=$this->db->get();
	return $query->result();
		
	}
	

	function quotation_description($quotation_location,$quotation_model_name) {
	
	$this->db->select('*');
	$this->db->from('tbl_onroad_performa_invoice op');
	$this->db->join('model_variant v','v.variant_id=op.variant_id');
	$this->db->where('op.model_id',$quotation_model_name);
	$this->db->where('op.location',$quotation_location);
	$this->db->group_by('op.variant_id');
	$query=$this->db->get();
	return $query->result();
		
	}
	public function select_quotation_onroad_price(){
$qutotation_model = $this -> input -> post('qmodel_id');
 $quotation_location = $this -> input -> post('qlocation');
$quotation_variant = $this -> input -> post('qvariant_id');
	$this->db->select('*');
	$this->db->from('tbl_onroad_performa_invoice op');

	$this->db->where('op.model_id',$qutotation_model);
	$this->db->where('op.variant_id',$quotation_variant);
	$this->db->where('op.location',$quotation_location);
	$query=$this->db->get();
	return $query->result();
}
public function select_quotation_offer(){
$qutotation_model = $this -> input -> post('qmodel_id');
$quotation_location = $this -> input -> post('qlocation');
$quotation_variant = $this -> input -> post('qvariant_id');
	$this->db->select('cons_off,offer_id');
	$this->db->from('tbl_onroad_performa_offer op');

	$this->db->where('op.model_id',$qutotation_model);
	$this->db->where('op.variant_id',$quotation_variant);
	$this->db->where('op.location',$quotation_location);
	$query=$this->db->get();
	return $query->result();
}
public function insert_quotation_data(){
	$today=date('Y-m-d');
	
	// Set Quotation ID
	$maxEmpId=$this->db->query("select customer_quotation_id as empId from tbl_quotation_sent order by quotation_sent_id DESC limit 1")->result();
	//$maxEmpId="MS12222";
	if(isset($maxEmpId) )
                                	{
                                        $maxId=substr($maxEmpId[0]->empId,2);
										//$maxId=substr($maxEmpId,2);
										$maxIdNew=$maxId+1;
										if(strlen($maxIdNew)<2)
										{
											$maxIdNew="MS0000".$maxIdNew;
										}
										elseif(strlen($maxIdNew)<3)
										{
											 $maxIdNew="MS000".$maxIdNew;
										}
										elseif(strlen($maxIdNew)<4)
										{
											 $maxIdNew="MS00".$maxIdNew;
										}
										elseif(strlen($maxIdNew)<5)
										{
											 $maxIdNew="MS0".$maxIdNew;
										}										
										else 
										{
											$maxIdNew="MS".$maxIdNew;
										}
									}
									else 
									{
										$maxIdNew="MS00001";
										
									}
	$quotation_location=$this->input->post('qlocation');
	$qutotation_model=$this->input->post('qmodel_id');
	$quotation_variant=$this->input->post('qvariant_id');	
	$qutotation_buyer=$this->input->post('buyer_type');	
	$qutotation_exchange_make=$this->input->post('old_make');
	$qutotation_exchange_model=$this->input->post('old_model');	
	$on_road_price_1=$this->input->post('on_road_price');	
	$quotation_remark=$this->input->post('remark');	
	$enq_id=$this->input->post('booking_id');
	$user_id=$this->input->post('user_id');	
	$exchange_bonus=$this->input->post('exchange_bonus');
	$additional_offer=$this->input->post('additional_offer');
	$quotation_invoice_id=$this->input->post('quotation_id');
	$quotation_offer_id=$this->input->post('offer_id');
	$customer_type=$this->input->post('customer_type');	
		$consumer_offer=$this->input->post('consumer_offer');
		$corporate_offer=$this->input->post('corporate_offer');
	$qutotation_accessories=$this->input->post('accessories');
	$ew=$this->input->post('warranty');
	$rto=$this->input->post('rto');
	$registration=$this->input->post('registration');
	$auto_card=$this->input->post('auto_card');
	$insurance=$this->input->post('insurance');
	$ex_showroom=$this->input->post('ex_showroom');
	$confirmation_code = rand(0, 10000);
	
	$this->db->query("INSERT INTO `tbl_quotation_sent`(`quotation_invoice_id`,`customer_quotation_id`,`quotation_offer_id`,`lead_id`, `user_id`,`location`, `model_id`, `variant_id`, `buyer_type`, `old_make`, `old_model`,`remark`,`exchange_bonus`,`additional_offer`,`customer_type`, `on_road_price`, `corporate_offer`, `consumer_offer`,`accessories`, `quotation_sent_date`,warranty,confirmation_code,rto,registration
		,auto_card,insurance,ex_showroom) 
	VALUES ('$quotation_invoice_id','$maxIdNew','$quotation_offer_id','$enq_id','$user_id','$quotation_location','$qutotation_model','$quotation_variant','$qutotation_buyer','$qutotation_exchange_make','$qutotation_exchange_model','$quotation_remark','$exchange_bonus','$additional_offer','$customer_type','$on_road_price_1','$corporate_offer','$consumer_offer','$qutotation_accessories','$today','$ew','$confirmation_code','$rto','$registration','$auto_card','$insurance','$ex_showroom')");
	$quotation_sent_id=$this->db->insert_id();
	$bank_name = json_decode($_POST['bank_name']);
	$scheme_type = json_decode($_POST['scheme_type']);
	$tenure = json_decode($_POST['tenure']);
	$loan_amount = json_decode($_POST['loan_amount']);
	$margin_money = json_decode($_POST['margin_money']);
	$adv_emi = json_decode($_POST['advance_emi']);
	$processing_fee = json_decode($_POST['processing_fee']);
	$stamp_duty = json_decode($_POST['stamp_duty']);
	$down_payment = json_decode($_POST['down_payment']);
	$emi_per_month = json_decode($_POST['emi_per_month']);



	$bank_count = count($bank_name);

	for($i=0;$i<$bank_count;$i++){
	//$bank_name = $this->input->post('bank_name_'.$i);
	/*$tenure = $this->input->post('tenure_'.$i);
	$loan_amount = $this->input->post('loan_amount_'.$i);
	$margin_money = $this->input->post('margin_money_'.$i);
	$adv_emi = $this->input->post('adv_emi_'.$i);
	$processing_fee = $this->input->post('processing_fee_'.$i);
	$stamp_duty =  $this->input->post('stamp_duty_'.$i);
	$down_payment =  $this->input->post('down_payment_'.$i);
	$emi_per_month =  $this->input->post('emi_per_month_'.$i);*/
	$this->db->query("INSERT INTO `tbl_quotation_finance_scheme`(`quotation_sent_id`, `scheme_type`, `bank_name`, `tenure`, `loan_amount`, `margin_money`, `advance_emi`, `processing_fee`, `stamp_duty`, `emi_per_month`, `down_payment`) 
	VALUES ('$quotation_sent_id','$scheme_type[$i]','$bank_name[$i]','$tenure[$i]','$loan_amount[$i]','$margin_money[$i]','$adv_emi[$i]','$processing_fee[$i]','$stamp_duty[$i]','$emi_per_month[$i]','$down_payment[$i]')");
}

//return $quotation_sent_id;
if ($this -> db -> affected_rows() > 0) {
				$response["success"] = '1';
				$response["quotation_sent_id"] = $quotation_sent_id;
				$response["confirmation_code"] =$confirmation_code;
				$response["message"] = "Data successfully Updated.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = '0';
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}
			//return $quotation_sent_id;

}
public function select_quotation_sent_data($quotation_id){
	$this->db->select('qs.ex_showroom,op.company_registration_with_hp,op.zero_dep_insurance_with_rti_and_engine_protect,op.individual_registration_with_hp,op.ins_corp,qs.registration,qs.auto_card,qs.warranty,qs.quotation_sent_id,qs.lead_id,qs.customer_quotation_id,qs.user_id,qs.confirmation_code,qs.location,qs.buyer_type,qs.old_make,qs.old_model`,qs.remark,qs.exchange_bonus,qs.additional_offer,v.variant_name,m.model_name,qf.cons_off,qf.cons_offdlr,qs.customer_type,qs.on_road_price,l.enq_id,l.name,l.contact_no,l.address,l.email,qs.corporate_offer,l1.fname,l1.lname,qs.accessories,qs.consumer_offer,qs.rto,qs.insurance');
	$this->db->from('tbl_quotation_sent qs');
	$this->db->join('tbl_onroad_performa_invoice op','op.quotation_id=qs.quotation_invoice_id');
	$this->db->join('tbl_onroad_performa_offer qf','qf.offer_id=qs.quotation_offer_id','left');
	$this->db->join('lead_master l','l.enq_id=qs.lead_id');
	$this->db->join('lmsuser l1','l1.id=l.assign_to_dse','left');
	$this->db->join('model_variant v','qs.variant_id=v.variant_id');
	$this->db->join('make_models m','qs.model_id=m.model_id');
	$this->db->where('qs.quotation_sent_id',$quotation_id);
	
	$query=$this->db->get();
	return $query->result();
	
}
public function select_finance_quotation($quotation_id){
	$this->db->select('*');
	$this->db->from('tbl_quotation_finance_scheme qs');
	$this->db->where('quotation_sent_id',$quotation_id);
	$query=$this->db->get();
	return $query->result();
	
}
}