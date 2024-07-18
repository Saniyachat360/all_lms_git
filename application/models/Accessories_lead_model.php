<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Accessories_lead_model extends CI_model {
	function __construct() {
		parent::__construct();
		$CI = &get_instance();
//setting the second parameter to TRUE (Boolean) the function will return the database object.
$this->db2 = $CI->load->database('db2', TRUE);
		
	}
	
	// Select All Lead Details
	public function select_lead() {
		
		
		//DSE TL select assign to telecaller function
		if ($_SESSION['role'] == 5) {
			$assign_to_dse = $this -> select_dse_tl_id();
		}
		//Select campaign name using group name
		$st = $this -> checkgroupcampaignname();

		//get filter data
		$filter_status = $this -> input -> post('filter_status');
		$filter_disposition = $this -> input -> post('filter_disposition');
		$filter_fromdate = $this -> input -> post('filter_fromdate');
		$filter_campaign_name = $this -> input -> post('filter_campaign_name');
		//$enq = str_replace('%20', ' ', $enq);
		$assign_to = $this -> input -> post('filter_assign');
		
		//Check assign to telecaller
		if ($_SESSION['role'] != 5) {
			if ($_SESSION['role'] == 3 || $_SESSION['role'] == 4) {
				$assign_to = $_SESSION['user_id'];
			} else {
				$assign_to = $this -> input -> post('filter_assign');
			}
		}

		$view = $_SESSION['view'];
		//Check Add manager remark right
		if ($view[10] == 1) {
			$this -> db -> select('
			u.fname,u.lname,
			r.remark,
			f1.date,f1.nextfollowupdate,f1.comment,
			d.disposition_name,
			s.status_name,
			l.eagerness,l.enq_id,name,l.assign_to_telecaller,l.email,contact_no,enquiry_for,l.status,l.assignby,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km');
		} else {
			$this -> db -> select('
			u.fname,u.lname,
			f1.date,f1.nextfollowupdate,f1.comment,
			d.disposition_name,
			s.status_name,
			l.eagerness,l.enq_id,name,l.assign_to_telecaller,l.email,contact_no,enquiry_for,l.status,l.assignby,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km');
		}
		$this -> db -> from('lead_master l');
		$this -> db -> join('tbl_disposition_status d', 'd.disposition_id=l.disposition', 'left');
		$this -> db -> join('lmsuser u', 'u.id=l.assign_to_telecaller', 'left');
		if ($view[10] == 1) {
			
			$this -> db -> join('tbl_manager_remark r', 'r.remark_id=l.remark_id', 'left');
		}
		$this -> db -> join('tbl_status s', 's.status_id=l.status', 'left');
		//	$this -> db -> join('lead_followup f', 'f.leadid=l.enq_id', 'left');
		$this -> db -> join('lead_followup f1', 'f1.id=l.followup_id', 'left');
		$this -> db -> where('lead_source','Accessories');
		//If select Disposition
		if ($filter_disposition != '') {
			$this -> db -> where('l.disposition', $filter_disposition);

		}
		
		//IF select Status
		if ($filter_status != 0) {
			$this -> db -> where('l.status', $filter_status);
		}

		if ($filter_status == 0) {

			$this -> db -> where('l.status!=', '');
		}
		
		//If select Date
		if ($filter_fromdate != '') {
			$this -> db -> where('l.created_date', $filter_fromdate);

		}

		//Select Assign To
		if ($assign_to != '') {
			$this -> db -> where('assign_to_telecaller', $assign_to);
		}
		//If user DSE Tl
		if ($_SESSION['role'] == 5 && $assign_to == '') {
			$this -> db -> where($assign_to_dse);
		}
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		
		//Limit
		if ($filter_campaign_name == '' && $filter_status == 0 && $filter_fromdate == '') {
			$this -> db -> limit(100);
		}
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}
	public function checkgroupcampaignname() {
		/*---check count as per group & user--*/
		if ($_SESSION['role'] != 1) {

			$user_id = $_SESSION['user_id'];

			$this -> db -> select('c.campaign_name');
			$this -> db -> from('tbl_user_group u');
			$this -> db -> join('tbl_campaign c', 'c.group_id=u.group_id');
			$this -> db -> where('u.user_id', $user_id);
			$query1 = $this -> db -> get() -> result();

			$c = count($query1);
			if (count($query1) > 0) {
				$t = ' ( ';
				for ($i = 0; $i < $c; $i++) {
					if ($i == 0) {
						if ($query1[$i] -> campaign_name == 'New Car') {
							$t = $t . "enquiry_for != 'Used Car'";
						} else {
							$t = $t . "enquiry_for = '" . $query1[$i] -> campaign_name . "'";
						}
					} else {
						$t = $t . " or enquiry_for ='" . $query1[$i] -> campaign_name . "'";
					}
				}
				$t = $t . " or lead_source ='' ";
				$st = $t . ')';

			}

			return $st;
		}

	}
	public function lms_details($enq_id) {
		//Get user all details
		$this -> db -> select('l.eagerness,l.buy_make,l.buy_model,l.budget_to,l.budget_from,l.enq_id,l.name,l.email,l.address,l.location,l.contact_no,l.buy_status,bm1.make_name as buy_make_name,bm2.model_name as buy_model_name,s.status_name,m.model_name as new_model,l.buyer_type ,m1.model_name as old_model,v.variant_name,m2.make_name');
		$this -> db -> from('lead_master l');
		$this -> db -> join('make_models m', 'm.model_id=l.model_id', 'left');
		$this -> db -> join('make_models m1', 'm1.model_id=l.old_model', 'left');
		$this -> db -> join('model_variant v', 'v.variant_id=l.variant_id', 'left');
		$this -> db -> join('makes m2', 'm2.make_id=l.old_make', 'left');
		$this -> db -> join('makes bm1', 'bm1.make_id=l.buy_make', 'left');
		$this -> db -> join('make_models bm2', 'bm2.model_id=l.buy_model', 'left');
		$this -> db -> join('tbl_status s', 's.status_id=l.status', 'left');

		$this -> db -> where('l.enq_id', $enq_id);

		$query = $this -> db -> get();

		return $query -> result();
	}
	public function followup_detail($enq_id) {
		//Get user All Followup Details
		$this -> db -> select('u.fname,u.lname,
		s.status_name,
		d.disposition_name,
		l.location,l.status,l.created_date as lead_date,l.buyer_type,
		f.activity,f.assign_to,f.date as call_date,f.comment,f.nextfollowupdate,f.visit_location,f.visit_status,f.visit_booked,f.visit_booked_date,f.sale_status,f.car_delivered ');
		$this -> db -> from('lead_master l');
		$this -> db -> join('make_models m', 'm.model_id=l.model_id', 'left');
		$this -> db -> join('lead_followup f', 'f.leadid=l.enq_id');
		$this -> db -> join('lmsuser u', 'u.id=f.assign_to', 'left');

		$this -> db -> join('tbl_disposition_status d', 'd.disposition_id=f.disposition', 'left');
		$this -> db -> join('tbl_status s', 's.status_id=d.status_id', 'left');
		$this -> db -> where('f.leadid', $enq_id);
		$this -> db -> order_by('f.id', 'desc');
		$query = $this -> db -> get();
		return $query -> result();

	}
	function select_manager_remark($enq_id) {

		$this -> db -> select('remark ');
		$this -> db -> from('tbl_manager_remark');
		$this -> db -> where('lead_id', $enq_id);
		$this -> db -> order_by('remark_id', 'desc');
		$query = $this -> db -> get();
		//	echo $this->db->last_query();
		return $query -> result();
	}
	public function select_additional_info($enq_id) {
		$this -> db -> select('*');
		$this -> db -> from('tbl_additional_car_info a');
		$this -> db -> join('makes m', 'a.car_make=m.make_id');
		$this -> db -> join('make_models m1', 'a.car_model=m1.model_id');

		$this -> db -> where('lead_id', $enq_id);

		$query = $this -> db -> get();

		return $query -> result();
	}
	public function order_accessories_lead($enq_id) {
		$this -> db -> select('m.enq_id,
						       a.accessories_user_id,a.edbms_no,a.booking_date,a.dse_name,
							   m1.customer_id,m1.accessories_name,m1.qty,m1.price');
		$this -> db -> from('accessories_user a');
		$this -> db -> join('accessories_order_list m1', 'm1.customer_id=a.accessories_user_id');
		$this -> db -> join('lead_master m', 'm.enq_id=m1.enq_id');
		
	//	$this -> db -> join('accessories_order_list ac', 'm.accessories_user_id=m1.customer_id');

		$this -> db -> where('m.enq_id', $enq_id);

		$query = $this -> db -> get();

		return $query -> result();
	}
	
	//For Show CSE New Leads
	public function select_accessories_lead() {
		//$this -> db -> select("*");
		//$this -> db -> from("lead_master");
		//$this -> db -> where("lead_source",'Accessories');
		$this -> db -> select('
			u.fname,u.lname,
			r.remark,
			f1.date,f1.nextfollowupdate,f1.comment,
			d.disposition_name,
			s.status_name,
			l.eagerness,l.enq_id,name,l.assign_to_telecaller,l.email,contact_no,enquiry_for,l.status,l.assignby,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km');
		$this -> db -> from('lead_master l');
		$this -> db -> join('tbl_disposition_status d', 'd.disposition_id=l.disposition', 'left');
		$this -> db -> join('lmsuser u', 'u.id=l.assign_to_telecaller', 'left');
		$this -> db -> join('tbl_manager_remark r', 'r.remark_id=l.remark_id', 'left');
		$this -> db -> join('tbl_status s', 's.status_id=l.status', 'left');
		$this -> db -> join('lead_followup f1', 'f1.id=l.followup_id', 'left');
		$this -> db -> where("lead_source",'Accessories');
		$query = $this -> db -> get();
		
		return $query -> result();

	}
	
	
	public function add_accessories_followup() {
		$this -> db -> select("a.*,l.name,l.contact_no,l.status,l.assignto,l.created_date,l.created_time");
		$this -> db -> from("accessories_user a");
		$this -> db -> join("lead_master l", "l.enq_id=a.enq_id");
		$query = $this -> db -> get();
		
		return $query -> result();

	}
	
	public function select_accessories_lead1($enq_id) {
		
		$this -> db -> select("*");
		$this -> db -> from("lead_master");
		$this -> db -> where("enq_id ", $enq_id);
		$query = $this -> db -> get();
		
		return $query -> result();

	}
	public function select_accessories_order($enq_id) {
		
		$this -> db -> select("l.enq_id,");
		$this -> db -> from("lead_master l");
		$this -> db -> join("lead_master l");
		$this -> db -> from("lead_master l");
		$this -> db -> from("lead_master l");
		$this -> db -> where("enq_id ", $enq_id);
		$query = $this -> db -> get();
		
		return $query -> result();

	}
	//For Show DSE New Leads
	public function select_lead1() {
		$yesterday = date("Y-m-d", strtotime('-1 days'));
		$assign_to = $_SESSION['user_id'];
		$wh="lm.assign_to_telecaller = '$assign_to' AND  lf.assign_to != '$assign_to' "; 
		$this -> db -> select("u.fname,u.lname,
		 lm.buyer_type,lm.model_id,lm.variant_id,lm.buy_status,lf.date,d.disposition_name,
		lm.enq_id,lm.name,lm.status,lm.contact_no,lm.email,lm.enquiry_for,lm.created_date,lm.eagerness,lm.created_time,lm.old_make,lm.old_model,lm.ownership,lm.manf_year,lm.color,lm.km,
		lf.nextfollowupdate,lf.comment ,
		r.remark,
		s.status_name");
		$this -> db -> from("lead_master lm");
		$this -> db -> join("lead_followup lf", "lm.followup_id=lf.id");
		$this -> db -> join("request_to_lead_transfer rt", "rt.request_id=lm.transfer_id");
		//$this -> db -> join("lead_followup lf1", "lm.enq_id=lf1.leadid");		
		$this -> db -> join("tbl_status s", "s.status_id=lm.status", 'left');
		$this -> db -> join("tbl_manager_remark r", "r.remark_id=lm.remark_id", 'left');
		$this -> db -> join("lmsuser u", "u.id=lm.assign_to_telecaller", 'left');
		$this -> db -> join("tbl_disposition_status d", "d.disposition_id=lm.disposition", 'left');
		$this -> db -> where($wh);
		
		//$this -> db -> where('s.status_name', 'Not Yet');
		$this -> db -> where('rt.created_date >=', $yesterday);
		$this -> db -> order_by('lm.enq_id', 'desc');
		$this->db->limit('100');
		$query = $this -> db -> get();
		echo $this->db->last_query();
		return $query -> result();

	}
	

}
?>