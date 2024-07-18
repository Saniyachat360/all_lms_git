<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class search_customer_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> process_id = $_SESSION['process_id'];
			$this -> process_name = $_SESSION['process_name'];
		//Select Table
		if ($this -> process_id == 6 || $this -> process_id == 7) {
			$this -> table_name = 'lead_master l';
			$this -> table_name1 = 'lead_followup';
			$this -> table_name2 = 'request_to_lead_transfer';
			$this->selectElement='	l.service_center,l.service_type,l.pickup_required,l.pick_up_date,l.assign_to_dse_date,l.assign_to_dse_time,l.assign_to_dse_tl_date,l.assign_to_dse_tl_time,
			`tloc`.`location` as `showroom_location`, `l`.`assign_to_dse_tl`, `l`.`assign_to_dse`,
				`udse`.`fname` as `dse_fname`, `udse`.`lname` as `dse_lname`, `udse`.`role` as `dse_role`,  `udsetl`.`fname` as `dsetl_fname`, `udsetl`.`lname` as `dsetl_lname`, `udsetl`.`role` as `dsetl_role`,
				`dsef`.`date` as `dse_date`, `dsef`.`nextfollowupdate` as `dse_nfd`,`dsef`.`nextfollowuptime` as `dse_nftime`, `dsef`.`comment` as `dse_comment`, `dsef`.`nextAction` as `dsenextAction`, `dsef`.`feedbackStatus` as `dsefeedback`,`dsef`.`contactibility` as `dsecontactibility`,`dsef`.`created_time` as `dse_time`
				, `m1`.`model_name` as `old_model_name`, `m2`.`make_name`';
		}
		elseif ($this -> process_id == 8) {
			$this -> table_name = 'lead_master_evaluation l';
			$this -> table_name1 = 'lead_followup_evaluation';
				$this -> table_name2 = 'request_to_lead_transfer_evaluation';
			//$this->selectElement='l.assign_to_e_exe as assign_to_dse,l.assign_to_e_tl as assign_to_dse_tl,l.exe_followup_id as dse_followup_id';
			$this->selectElement='l.outright,l.vechicle_sale_category,l.reg_year,l.old_car_owner_name,l.hp,l.financier_name,l.insurance_type,l.insurance_company,l.insurance_validity_date,l.photo_uploaded,l.type_of_vehicle,l.accidental_details,l.accidental_details,l.tyre_conditon,l.engine_work,l.body_work,l.refurbish_cost_battery,l.refurbish_cost_mecahanical,l.refurbish_cost_tyre,l.refurbish_other,l.refurbish_cost_bodyshop,l.price_with_rf_and_commission,l.agent_commision_payable,l.total_rf,l.selling_price,l.expected_date_of_sale,l.bought_at,l.bought_date,l.payment_date,l.payment_mode,l.payment_made_to,
			l.assign_to_e_exe_date as assign_to_dse_date,l.assign_to_e_exe_time as assign_to_dse_time,l.assign_to_e_tl_date as assign_to_dse_tl_date,l.assign_to_e_tl_time as assign_to_dse_tl_time,
			`tloc`.`location` as `showroom_location`,l.assign_to_e_tl as assign_to_dse_tl, `l`.`assign_to_e_exe` as assign_to_dse,`l`.`exe_followup_id` as `dse_followup_id`,
				`udse`.`fname` as `dse_fname`, `udse`.`lname` as `dse_lname`, `udse`.`role` as `dse_role`,  `udsetl`.`fname` as `dsetl_fname`, `udsetl`.`lname` as `dsetl_lname`, `udsetl`.`role` as `dsetl_role`,
				`dsef`.`date` as `dse_date`, `dsef`.`nextfollowupdate` as `dse_nfd`,`dsef`.`nextfollowuptime` as `dse_nftime`, `dsef`.`comment` as `dse_comment`, `dsef`.`nextAction` as `dsenextAction`, `dsef`.`feedbackStatus` as `dsefeedback`,`dsef`.`contactibility` as `dsecontactibility`,`dsef`.`created_time` as `dse_time`
				, `m1`.`model_name` as `old_model_name`, `m2`.`make_name`';
	
		} else {
			$this -> table_name = 'lead_master_all';
			$this -> table_name1 = 'lead_followup_all';
				$this -> table_name2 = 'request_to_lead_transfer_all';
		$this->selectElement='	l.service_center,l.service_type,l.pickup_required,l.pick_up_date,l.assign_to_dse_date,l.assign_to_dse_time,l.assign_to_dse_tl_date,l.assign_to_dse_tl_time,
		`tloc`.`location` as `showroom_location`, csef.file_login_date,csef.login_status_name,csef.approved_date,csef.disburse_date,csef.disburse_amount,csef.process_fee,csef.emi,csef.eagerness,l.bank_name,l.loan_type,l.los_no,l.roi,l.tenure,l.loanamount,l.dealer,l.executive_name';

		}
	}

	public function select_lead_dse() {
		$customer_name = $this -> input -> post('customer_name');
		$reg_no = $this -> input -> post('reg_no');
	
$query = "SELECT 
		GROUP_CONCAT( DISTINCT  a.accessories_name ) as accessoires_list,
		sum(price) as assessories_price,
		m.model_name,
		 `l`.`assistance`,  `l`.`customer_location`,`l`.`days60_booking`,l.evaluation_within_days,l.fuel_type,l.color,l.quotated_price,l.expected_price,
		l.enq_id,l.lead_source,l.enquiry_for,l.process,l.name,l.contact_no,l.alternate_contact_no,l.address,l.email,l.created_date as lead_date,l.created_time as lead_time,l.feedbackStatus,l.nextAction,
		 l.ownership,l.budget_from,l.budget_to,l.accidental_claim,`l`.`assign_by_cse_tl`,`l`.`assign_to_cse`,
		l.reg_no, min(l.created_date) as min_date, max(l.created_date) as max_date ,l.km,`l`.`buyer_type`,  `l`.`manf_year`,l.assign_to_cse_date,l.assign_to_cse_time,
		l.appointment_type,l.appointment_date,l.appointment_time,l.appointment_status,
		l.interested_in_finance,l.interested_in_accessories,l.interested_in_insurance,l.interested_in_ew,
		l.process,
		`ucse`.`fname` as `cse_fname`, `ucse`.`lname` as `cse_lname`, `ucse`.`role` as `cse_role`,`ucsetl`.`fname` as `csetl_fname`, `ucsetl`.`lname` as `csetl_lname`, `ucsetl`.`role` as `csetl_role`,
		". $this->selectElement .",
		
		`v`.`variant_name`,`m`.`model_name` as `new_model_name`,
		
		`csef`.`date` as `cse_date`, `csef`.`nextfollowupdate` as `cse_nfd`,`csef`.`nextfollowuptime` as `cse_nftime`, `csef`.`comment` as `cse_comment`,
		`csef`.`feedbackStatus` as `csefeedback`, `csef`.`nextAction` as `csenextAction`,`csef`.`contactibility` as `csecontactibility`,`csef`.`created_time` as `cse_time`,
		
		ua.fname as auditfname,ua.lname as auditlname,
		
		mr.followup_pending,mr.call_received,mr.fake_updation,mr.service_feedback,mr.remark as auditor_remark,mr.created_date as auditor_date,mr.created_time as auditor_time,mr.call_status as auditor_call_status
		
		FROM " .$this->table_name. " 
		LEFT JOIN " .$this->table_name1. " `csef` ON `csef`.`id`=`l`.`cse_followup_id` 
		LEFT JOIN `lmsuser` `ucse` ON `ucse`.`id`=`l`.`assign_to_cse` 
		LEFT JOIN `lmsuser` `ucsetl` ON `ucsetl`.`id`=`l`.`assign_by_cse_tl`
		LEFT JOIN `tbl_manager_remark` `mr` ON `mr`.`remark_id`=`l`.`remark_id`
		LEFT JOIN `lmsuser` `ua` ON `ua`.`id`=`l`.`auditor_user_id`  
		LEFT JOIN `make_models` `m` ON `m`.`model_id`=`l`.`model_id` 
		LEFT JOIN `model_variant` `v` ON `v`.`variant_id`=`l`.`variant_id` 
		
		
		LEFT JOIN `make_models` `m1` ON `m1`.`model_id`=`l`.`old_model` 
		LEFT JOIN `makes` `m2` ON `m2`.`make_id`=`l`.`old_make`
		LEFT JOIN `accessories_order_list` `a` ON `a`.`enq_id`=`l`.`enq_id`";
		
		if($_SESSION['process_id']==8){
		
		$query=$query." LEFT JOIN " .$this->table_name1. "  dsef ON dsef.id=l.exe_followup_id
		LEFT JOIN `lmsuser` `udse` ON `udse`.`id`=`l`.`assign_to_e_exe` 
		LEFT JOIN `lmsuser` `udsetl` ON `udsetl`.`id`=`l`.`assign_to_e_tl` ";
		
		}else{
		$query=$query." LEFT JOIN " .$this->table_name1. "  `dsef` ON `dsef`.`id`=`l`.`dse_followup_id` 
		LEFT JOIN `lmsuser` `udse` ON `udse`.`id`=`l`.`assign_to_dse` 
		LEFT JOIN `lmsuser` `udsetl` ON `udsetl`.`id`=`l`.`assign_to_dse_tl` ";
		}
		$query=$query."LEFT JOIN `tbl_manager_process` `mp` on `mp`.`user_id` =`udsetl`.`id`
	
		LEFT JOIN `tbl_location` `tloc` ON `tloc`.`location_id`= `mp`.`location_id`";

		/*if($_SESSION['process_id']==8){
			$query = $query . ' where l.evaluation="Yes"';
		}else{
		$query = $query . ' where l.process="' . $this->process_name . '"';
		}*/
		if ($customer_name!='') {
		if (is_numeric($customer_name)) {
				
			$query = $query . ' where contact_no like "' . '%'.$customer_name .'%'. '"';			
		} else {
			$query = $query . ' where name like "' . '%'.$customer_name .'%'. '"';

		}
		}
		if($reg_no!='' && $customer_name!=''){
			$query = $query . ' And reg_no like "' . '%'.$reg_no .'%'. '"';			
		}
		if($reg_no!='' && $customer_name==''){
			$query = $query . ' Where reg_no like "' . '%'.$reg_no .'%'. '"';			
		}
		$query = $query . " group by l.enq_id";
		$query = $query . " order by l.enq_id desc";
		$query = $query . " limit 50";

		$query = $this -> db -> query($query);
		if($_SESSION['user_id']==1){
		//	echo $this->db->last_query();
		}
		
		$query = $query -> result();
		return $query;
		

	}

	public function lc_data_dse() {

		$customer_name = $this -> input -> post('customer_name');
		$this -> db -> select('v.variant_name,
		d.disposition_name,
		s.status_name,
		f.date,f.nextfollowupdate,f.comment,
		u.fname,u.lname,u.role,
		m.model_name as new_model_name,
		m1.model_name as old_model_name,
		m2.make_name,	
		l.transfer_id,l.manf_year,l.color,l.km,l.ownership,l.accidental_claim,l.buy_status,l.buyer_type,l.lead_source,l.location,enq_id,name,l.assign_to_telecaller,l.email,contact_no,l.comment,enquiry_for,l.status,l.created_date ');
		$this -> db -> from('lead_master_lc l');
		$this -> db -> join('tbl_disposition_status d', 'd.disposition_id=l.disposition', 'left');
		$this -> db -> join('lead_followup_lc f', 'f.id=l.followup_id', 'left');
		//$this -> db -> join('request_to_lead_transfer_lc r', 'r.request_id=l.transfer_id', 'left');
		$this -> db -> join('tbl_status s', 's.status_id=l.status', 'left');
		$this -> db -> join('lmsuser u', 'u.id=l.assign_to_telecaller', 'left');
		$this -> db -> join('model_variant v', 'v.variant_id=l.variant_id', 'left');
		$this -> db -> join('make_models m', 'm.model_id=l.model_id', 'left');
		$this -> db -> join('make_models m1', 'm1.model_id=l.old_model', 'left');
		$this -> db -> join('makes m2', 'm2.make_id=l.old_make', 'left');
		if (is_numeric($customer_name)) {
			$this -> db -> where("contact_no LIKE '%$customer_name%'");
		} else {
			$this -> db -> where("name LIKE '%$customer_name%'");
		}
		$this -> db -> limit(50);
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}

	public function lost_data_dse() {
		$customer_name = $this -> input -> post('customer_name');
		$this -> db -> select('v.variant_name,
		d.disposition_name,
		s.status_name,
		f.date,f.nextfollowupdate,f.comment,
		u.fname,u.lname,u.role,
		m.model_name as new_model_name,
		m1.model_name as old_model_name,
		m2.make_name,
		r.assign_to_telecaller,r.assign_by_id,
		l.transfer_id,l.manf_year,l.color,l.km,l.ownership,l.accidental_claim,l.buy_status,l.buyer_type,l.lead_source,l.location,enq_id,name,l.assign_to_telecaller,l.email,contact_no,l.comment,enquiry_for,l.status,l.created_date ');
		$this -> db -> from('lead_master_lost l');
		$this -> db -> join('tbl_disposition_status d', 'd.disposition_id=l.disposition', 'left');
		$this -> db -> join('lead_followup_lost f', 'f.id=l.followup_id', 'left');
		$this -> db -> join('request_to_lead_transfer_lost r', 'r.request_id=l.transfer_id', 'left');
		$this -> db -> join('tbl_status s', 's.status_id=l.status', 'left');
		$this -> db -> join('lmsuser u', 'u.id=l.assign_to_telecaller', 'left');
		$this -> db -> join('model_variant v', 'v.variant_id=l.variant_id', 'left');
		$this -> db -> join('make_models m', 'm.model_id=l.model_id', 'left');
		$this -> db -> join('make_models m1', 'm1.model_id=l.old_model', 'left');
		$this -> db -> join('makes m2', 'm2.make_id=l.old_make', 'left');

		if (is_numeric($customer_name)) {
			$this -> db -> where("contact_no LIKE '%$customer_name%'");
		} else {
			$this -> db -> where("name LIKE '%$customer_name%'");

		}
		$this -> db -> limit(50);

		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}

	public function select_leads_flow($enq_id) {

		$this -> db -> select('u.fname,u.lname,u1.fname as u1name,u1.lname as u1lname,r.created_date');
		$this -> db -> from($this->table_name2.' r');
		$this -> db -> join('lmsuser u', 'u.id=r.assign_to');
		$this -> db -> join('lmsuser u1', 'u1.id=r.assign_by');
		if ('lead_id' != '') {
			$this -> db -> where('lead_id', $enq_id);
		}
		$query = $this -> db -> get();
		$this->db->last_query();
		return $query -> result();
	}

	public function select_leads_flow_lc($enq_id) {

		$this -> db -> select('u.fname,u.lname,u1.fname as u1name,u1.lname as u1lname,r.created_date,r.transfer_reason');
		$this -> db -> from('request_to_lead_transfer_lc r');
		$this -> db -> join('lmsuser u', 'u.id=r.assign_to');
		$this -> db -> join('lmsuser u1', 'u1.id=r.assign_by');

		if ('lead_id' != '') {

			$this -> db -> where('lead_id', $enq_id);

		}

		$query = $this -> db -> get();
		//$this->db->last_query();
		return $query -> result();

	}

	public function select_leads_flow_lost($enq_id) {

		$this -> db -> select('u.fname,u.lname,u1.fname as u1name,u1.lname as u1lname,r.created_date,r.transfer_reason');
		$this -> db -> from('request_to_lead_transfer_lost r');
		$this -> db -> join('lmsuser u', 'u.id=r.assign_to_telecaller');
		$this -> db -> join('lmsuser u1', 'u1.id=r.assign_by_id');

		if ('lead_id' != '') {

			$this -> db -> where('lead_id', $enq_id);

		}

		$query = $this -> db -> get();
		//$this->db->last_query();
		return $query -> result();

	}
/*********************************************** Complaint Function *****************************************************/
public function select_lead_complaint()
	{
			ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 300); //120 seconds
		$customer_name=$this->input->post('customer_name');
		$this->db->select("l.service_center,l.comment,l.business_area,
		l.complaint_id,l.lead_source,l.name,l.contact_no,l.alternate_contact_no,l.address,l.email,l.created_date as lead_date,l.created_time as lead_time,l.feedbackStatus,l.nextAction,
		`l`.`assign_by_cse_tl`,`l`.`assign_to_cse`,
		l.assign_to_cse_date,l.assign_to_cse_time,
		`ucse`.`fname` as `cse_fname`, `ucse`.`lname` as `cse_lname`, `ucse`.`role` as `cse_role`,
		`csef`.`date` as `cse_date`, `csef`.`nextfollowupdate` as `cse_nfd`,`csef`.`nextfollowuptime` as `cse_nftime`, `csef`.`comment` as `cse_comment`, 
		`csef`.`feedbackStatus` as `csefeedback`, `csef`.`nextAction` as `csenextAction`,`csef`.`contactibility` as `csecontactibility`,`csef`.`created_time` as `cse_time`,
		ua.fname as auditfname,ua.lname as auditlname,	
		mr.followup_pending,mr.call_received,mr.fake_updation,mr.service_feedback,mr.remark as auditor_remark,mr.created_date as auditor_date,mr.created_time as auditor_time,mr.call_status as auditor_call_status
		");
		$this->db->from('lead_master_complaint l');
		$this->db->join('lead_followup_complaint csef', 'csef.id=l.cse_followup_id','left'); 
		$this->db->join('lmsuser ucse' ,'ucse.id=l.assign_to_cse','left');
		
		$this->db->join('tbl_manager_remark mr' ,'mr.remark_id=l.remark_id','left');
		$this->db->join('lmsuser ua' ,'ua.id=l.auditor_user_id','left')  ;
		
		if (is_numeric($customer_name)) {
			$this -> db -> where("contact_no LIKE '%$customer_name%'");
		} else {
			$this -> db -> where("name LIKE '%$customer_name%'");

		}
		$this -> db -> limit(50);
		
		$this -> db -> group_by('l.complaint_id');
		
		
	

	

		$query = $this -> db -> get();
	//	echo $this->db->last_query();
		$query = $query -> result();

		return $query;
		
	}
/************************************************************************************************************************/
}
?>