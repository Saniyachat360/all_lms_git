<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Customer_quotation_model extends CI_model {
	function __construct() {
		parent::__construct();
	
		
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