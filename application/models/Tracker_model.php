<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class tracker_model extends CI_model {
	function __construct() {
		parent::__construct();
	}

	function checkUserRights() {
		if ($_SESSION['role'] != 1) {
			//$process_id = $_SESSION['process_id'];
			$user_id = $_SESSION['user_id'];
			$this -> db -> select('g.group_id');
			$this -> db -> from('tbl_group g');
			$this -> db -> join('tbl_user_group u', 'u.group_id=g.group_id');
			$this -> db -> where('u.user_id', $user_id);
			$query1 = $this -> db -> get() -> result();
			$c = count($query1);
			if (count($query1) > 0) {
				$t = ' ( ';
				for ($i = 0; $i < $c; $i++) {
					if ($i == 0) {

						$t = $t . "group_id = '" . $query1[$i] -> group_id . "'";

					} else {
						$t = $t . " or group_id ='" . $query1[$i] -> group_id . "'";
					}
				}
				$st = $t . ')';

			}
			return $st;
		}
	}

	//Select Status
	function select_status() {
		$process_id = $_SESSION['process_id'];
		$this -> db -> select('s.status_name,s.status_id ');
		$this -> db -> from('tbl_status s');
		$this -> db -> join('tbl_process p', 's.process_id=p.process_id', 'left');
		$this -> db -> where('p.process_id', $process_id);
		$query = $this -> db -> get();
		//	echo $this->db->last_query();
		return $query -> result();

	}

	function select_lead_source() {
			
		$this->db->select('*');
		$this->db->from('lead_source');
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $query->result();
		

	}
	public function select_telecaller() {
		$st = $this -> checkUserRights();
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser l');
		$this -> db -> join('tbl_user_group u', 'u.user_id=l.id');
		$this -> db -> where('role', 3);
		if ($_SESSION['role'] != 1) {
			$this -> db -> where($st);
		}

		$this -> db -> group_by('l.id');
		$this -> db -> order_by('fname', 'asc');

		$query = $this -> db -> get();
		return $query -> result();

	}

	public function select_disposition() {
		$status_id = $this -> input -> post('status');
		$this -> db -> select('disposition_name,disposition_id');
		$this -> db -> from('tbl_disposition_status');
		if ($status_id != 0) {
			$this -> db -> where('status_id', $status_id);
		}
		$this -> db -> order_by('disposition_name', 'asc');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}

	function select_campaign() {
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
				$st = $t . ')';

			}
			$st;
		}

		$this -> db -> select('enquiry_for');
		$this -> db -> from('lead_master u');
		$this -> db -> join('tbl_campaign c', 'c.campaign_name=u.enquiry_for');
		$this -> db -> where('lead_source', 'Facebook');
		if ($_SESSION['role'] != 1) {
			$this -> db -> where($st);
		}
		$this -> db -> group_by('u.enquiry_for');
		$query = $this -> db -> get();
		return $query -> result();

	}

	/*public function select_campaign()
	 {
	 $this->db->select('DISTINCT (enquiry_for) as enquiry_for');
	 $this->db->from('lead_master');
	 $this->db->where('lead_source','Facebook');
	 $this->db->order_by('enquiry_for','asc');
	 $query=$this->db->get();
	 return $query->result();
	 }*/
	public function select_lead() {
		$today = date('Y-m-d');
		$status = $this -> input -> post('status');
		$fromdate = $this -> input -> post('fromdate');
		$todate = $this -> input -> post('todate');
		$campaign_name = $this -> input -> post('campaign_name');
		$dispostion = $this -> input -> post('dispostion');

		if ($_SESSION['role'] == 3 || $_SESSION['role'] == 4 ) {
					
		
			$assign_to = $_SESSION['user_id'];
		}

elseif ($_SESSION['role'] == 5 ) {
	
					$assign_to = $_SESSION['user_id'];
					$this->db->select('*');
					$this->db->from('tbl_mapdse');
					$this->db->where('tl_id',$assign_to);
					$q=$this->db->get()->result();
				//	echo $this->db->last_query();					
}

 else {
			$assign_to = $this -> input -> post('assign_to');
		}
		$this -> db -> select('v.variant_name,
	d.disposition_name,
	s.status_name,
	f.date,f.nextfollowupdate,f.comment,
	u.fname,u.lname,
	m.model_name as new_model_name,
	m1.model_name as old_model_name,
	m2.make_name,
	l.manf_year,l.color,l.km,l.ownership,l.accidental_claim,l.buy_status,l.buyer_type,l.lead_source,l.location,enq_id,name,l.assign_to_telecaller,l.email,contact_no,l.comment,enquiry_for,l.status,l.created_date ');
		$this -> db -> from('lead_master l');
		$this -> db -> join('tbl_disposition_status d', 'd.disposition_id=l.disposition', 'left');
		$this -> db -> join('lead_followup f', 'f.id=l.followup_id', 'left');
		$this -> db -> join('tbl_status s', 's.status_id=l.status', 'left');
		$this -> db -> join('lmsuser u', 'u.id=l.assign_to_telecaller', 'left');
		$this -> db -> join('model_variant v', 'v.variant_id=l.variant_id', 'left');
		$this -> db -> join('make_models m', 'm.model_id=l.model_id', 'left');
		$this -> db -> join('make_models m1', 'm1.model_id=l.old_model', 'left');
		$this -> db -> join('makes m2', 'm2.make_id=l.old_make', 'left');
		if ($dispostion != '') {	$this -> db -> where('l.disposition', $dispostion);

		}
		if ($campaign_name != '' && $campaign_name!='All' ){
			if ($campaign_name == 'Website') {
				$this -> db -> where('lead_source', '');
			} else {
				$name = explode('%23', $campaign_name);
				if ($name[0] == 'Facebook') {
					$this -> db -> where('enquiry_for', $name[1]);
					$this -> db -> where('lead_source', 'Facebook');
				} else {
					$this -> db -> where('lead_source', $name[1]);
				}
			}
		}

		/*	if ($campaign_name != '' && $campaign_name != 'Website' && $campaign_name != 'All' && $campaign_name != 'IBC' && $campaign_name != 'Carwale' && $campaign_name != 'GSC' && $campaign_name != 'Zendesk' && $campaign_name != 'Nexa Pune Web') {
		 $this -> db -> where('enquiry_for', $campaign_name);
		 $this -> db -> where('lead_source', 'Facebook');

		 }
		 if ($campaign_name == 'Website') {
		 $this -> db -> where('lead_source', '');

		 }
		 if ($campaign_name == 'IBC' || $campaign_name == 'Carwale' || $campaign_name == 'GSC' || $campaign_name == 'Zendesk' || $campaign_name == 'Nexa Pune Web') {
		 $this -> db -> where('lead_source', $campaign_name);
		 }
		 */
		if ($status != 0) {
			$this -> db -> where('l.status', $status);
		}

		if ($status == 0) {
			$st = "(l.status=1 or l.status=2 or l.status=3 or l.status=4 or l.status=5)";
			$this -> db -> where($st);
		}
		if ($fromdate != '') {
			$this -> db -> where('f.date', $fromdate);
			//	$this->db->where('l.created_date<=',$todate);
		} else {
			$this -> db -> where('f.date', $today);

		}
if ($_SESSION['role'] == 5) {
				
				$dse_id_count=count($q);
				$dse_id_count;
				
				if (count($q) > 0) {
					
				$t = ' ( ';
				for ($i = 0; $i < $dse_id_count; $i++) {
					if ($i == 0) {
						
						   $t = $t . "l.assign_to_telecaller = '" . $q[$i] -> dse_id . "'";
						
					} else {
						
						 $t = $t . " or l.assign_to_telecaller = '" . $q[$i] -> dse_id . "'";
						
					}
				}
				
				  $t=$t . "or l.assign_to_telecaller = '" . $_SESSION['user_id']."'";
                 
				 
				$st = $t . ')';

			}
			$st;
					
			$this -> db -> where($st);
		
			}
elseif ($assign_to != 0) {
			$this -> db -> where('assign_to_telecaller', $assign_to);
		}
		
			
		
		
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		if ($status == 0 && $fromdate == '' && $todate == '') {
			$this -> db -> limit(50);
		}
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	

	public function lc_data() {

		$today = date('Y-m-d');
		$status = $this -> input -> post('status');
		$fromdate = $this -> input -> post('fromdate');
		$todate = $this -> input -> post('todate');
		$campaign_name = $this -> input -> post('campaign_name');
		$dispostion = $this -> input -> post('dispostion');

		if ($_SESSION['role'] == 3 || $_SESSION['role'] == 4) {
			$assign_to = $_SESSION['user_id'];
		} 
		elseif ($_SESSION['role'] == 5 ) {
	
					$assign_to = $_SESSION['user_id'];
					$this->db->select('*');
					$this->db->from('tbl_mapdse');
					$this->db->where('tl_id',$assign_to);
					$q=$this->db->get()->result();
					}
		
		else {
			$assign_to = $this -> input -> post('assign_to');
		}
		$this -> db -> select('v.variant_name,
	d.disposition_name,
	s.status_name,
	f.date,f.nextfollowupdate,f.comment,
	u.fname,u.lname,
	m.model_name as new_model_name,
	m1.model_name as old_model_name,
	m2.make_name,
	l.manf_year,l.color,l.km,l.ownership,l.accidental_claim,l.buy_status,l.buyer_type,l.lead_source,l.location,enq_id,name,l.assign_to_telecaller,l.email,contact_no,l.comment,enquiry_for,l.status,l.created_date ');
		$this -> db -> from('lead_master_lc l');
		$this -> db -> join('tbl_disposition_status d', 'd.disposition_id=l.disposition', 'left');
		$this -> db -> join('lead_followup_lc f', 'f.id=l.followup_id', 'left');
		$this -> db -> join('tbl_status s', 's.status_id=l.status', 'left');
		$this -> db -> join('lmsuser u', 'u.id=l.assign_to_telecaller', 'left');
		$this -> db -> join('model_variant v', 'v.variant_id=l.variant_id', 'left');
		$this -> db -> join('make_models m', 'm.model_id=l.model_id', 'left');
		$this -> db -> join('make_models m1', 'm1.model_id=l.old_model', 'left');
		$this -> db -> join('makes m2', 'm2.make_id=l.old_make', 'left');
		if ($dispostion != '') {	$this -> db -> where('l.disposition', $dispostion);

		}
		if ($campaign_name != '' && $campaign_name!='All' ) {
			if ($campaign_name == 'Website') {
				$this -> db -> where('lead_source', '');
			} else {
				$name = explode('%23', $campaign_name);
				if ($name[0] == 'Facebook') {
					$this -> db -> where('enquiry_for', $name[1]);
					$this -> db -> where('lead_source', 'Facebook');
				} else {
					$this -> db -> where('lead_source', $name[1]);
				}
			}
		}
		/*if ($campaign_name != '' && $campaign_name != 'Website' && $campaign_name != 'All' && $campaign_name != 'IBC' && $campaign_name != 'Carwale' && $campaign_name != 'GSC' && $campaign_name != 'Zendesk' && $campaign_name != 'Nexa Pune Web') {
		 $this -> db -> where('enquiry_for', $campaign_name);
		 $this -> db -> where('lead_source', 'Facebook');

		 }
		 if ($campaign_name == 'Website') {
		 $this -> db -> where('lead_source', '');

		 }
		 if ($campaign_name == 'IBC' || $campaign_name == 'Carwale' || $campaign_name == 'GSC' || $campaign_name == 'Zendesk' || $campaign_name == 'Nexa Pune Web') {
		 $this -> db -> where('lead_source', $campaign_name);
		 }*/

		if ($status != 0) {
			$this -> db -> where('l.status', $status);
		}

		if ($status == 0) {
			$st = "(l.status=1 or l.status=2 or l.status=3 or l.status=4 or l.status=5)";
			$this -> db -> where($st);
		}
		if ($fromdate != '') {
			$this -> db -> where('f.date', $fromdate);
			//	$this->db->where('l.created_date<=',$todate);
		} else {
			$this -> db -> where('f.date', $today);

		}


	if ($_SESSION['role'] == 5) {
				
				$dse_id_count=count($q);
				$dse_id_count;
				
				if (count($q) > 0) {
					
				$t = ' ( ';
				for ($i = 0; $i < $dse_id_count; $i++) {
					if ($i == 0) {
						
						   $t = $t . "l.assign_to_telecaller = '" . $q[$i] -> dse_id . "'";
						
					} else {
						
						 $t = $t . " or l.assign_to_telecaller = '" . $q[$i] -> dse_id . "'";
						
					}
				}
				
				  $t=$t . "or l.assign_to_telecaller = '" . $_SESSION['user_id']."'";
                 
				 
				$st = $t . ')';

			}
			$st;
					
			$this -> db -> where($st);
		
			}


		if ($assign_to != 0) {
			$this -> db -> where('assign_to_telecaller', $assign_to);
		}
		
		
		
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		if ($status == 0 && $fromdate == '' && $todate == '') {
			$this -> db -> limit(50);
		}
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function reopen($enq_id) {

		$query2 = $this -> db -> query("INSERT INTO lead_master(`enq_id`, `followup_id`, `remark_id`, `transfer_id`, `lead_source`, `manual_lead`, `name`, `address`, `email`, `contact_no`, `enquiry_for`, `enquiry_source`, `page_path`, `status`, `disposition`, `model_id`, `variant_id`, `buy_status`, `buyer_type`, `location`, `comment`, `assignby`, `assign_to_telecaller`, `created_date`, `created_time`, `assign_date`, `old_make`, `old_model`, `color`, `manf_year`, `ownership`, `km`, `accidental_claim`, `package_type`, `pick_up_date`, `package_price`, `reg_no`, `fuel_type`, `loan_amnt`, `make_id`, `refname`, `add_date`, `evaluation_sheet_sr_no`, `stock_location`, `engine_no`, `chasis_no`, `reg_date`, `current_milage`, `quoted_price`, `difference_price`, `insurance_company`, `insurance_type`, `car_loan`, `insurance_no`, `insurance_date`, `new_car_customer_name`, `new_car_customer_mobile_no`, `service_date`)
		SELECT `enq_id`, `followup_id`, `remark_id`, `transfer_id`, `lead_source`, `manual_lead`, `name`, `address`, `email`, `contact_no`, `enquiry_for`, `enquiry_source`, `page_path`, `status`, `disposition`, `model_id`, `variant_id`, `buy_status`, `buyer_type`, `location`, `comment`, `assignby`, `assign_to_telecaller`, `created_date`, `created_time`, `assign_date`, `old_make`, `old_model`, `color`, `manf_year`, `ownership`, `km`, `accidental_claim`, `package_type`, `pick_up_date`, `package_price`, `reg_no`, `fuel_type`, `loan_amnt`, `make_id`, `refname`, `add_date`, `evaluation_sheet_sr_no`, `stock_location`, `engine_no`, `chasis_no`, `reg_date`, `current_milage`, `quoted_price`, `difference_price`, `insurance_company`, `insurance_type`, `car_loan`, `insurance_no`, `insurance_date`, `new_car_customer_name`, `new_car_customer_mobile_no`, `service_date`
		FROM lead_master_lc WHERE enq_id = '$enq_id'");
		$query=$this->db->query("INSERT INTO `lead_followup`(`id`, `leadid`, `activity`, `comment`, `nextfollowupdate`, `nextfollowuptime`, `contactibility`, `eagerness`, `assign_to`, `disposition`, `transfer_reason`, `date`, `visit_status`, `visit_location`, `visit_booked`, `visit_booked_date`, `sale_status`, `car_delivered`, `created_time`)
		SELECT `id`, `leadid`, `activity`, `comment`, `nextfollowupdate`, `nextfollowuptime`, `contactibility`, `eagerness`, `assign_to`, `disposition`, `transfer_reason`, `date`, `visit_status`, `visit_location`, `visit_booked`, `visit_booked_date`, `sale_status`, `car_delivered`, `created_time` FROM `lead_followup_lc` WHERE leadid='$enq_id'");
		$query1=$this->db->query("INSERT INTO `request_to_lead_transfer`(`request_id`, `lead_id`, `assign_to_telecaller`, `assign_by_id`, `location`, `created_date`, `created_time`, `status`, `transfer_reason`)
		SELECT `request_id`, `lead_id`, `assign_to_telecaller`, `assign_by_id`, `location`, `created_date`, `created_time`, `status`, `transfer_reason` FROM `request_to_lead_transfer_lc` WHERE lead_id='$enq_id'");
		$del = $this -> db -> query("delete from lead_master_lc where enq_id='$enq_id'");
		$del = $this -> db -> query("delete from lead_followup_lc where leadid='$enq_id'");
		$del = $this -> db -> query("delete from request_to_lead_transfer_lc  where lead_id='$enq_id'");

	}


public function map_dse(){
		$assign_to = $_SESSION['user_id'];
		$query = $this -> db -> query("select dse_id from tbl_mapdse where tl_id='$assign_to'") -> result();
		$c = count($query);
		$t = ' ( ';
		if (count($query) > 0) {
			
			foreach ($query as $row) {
				$t = $t . "l.assign_to_telecaller = " . $row -> dse_id . " or ";

			}
		$t = $t . "l.assign_to_telecaller = " . $assign_to;
			
		}else{
		$t = $t . "l.assign_to_telecaller = " . $assign_to;
		}
			$st = $t . ')';
		return $st;
	}

	public function select_lead_dse() {

		//$lead_date=$this->input->post('lead_date');

		$today = date('Y-m-d');
		$status = $this -> input -> post('status');
		if ($this -> input -> post('fromdate') == '' && $this -> input -> post('todate') != '') {
			//echo "1";
			$fromdate = $today;
		} else {
			//echo "2";
			$fromdate = $this -> input -> post('fromdate');
		}
		if ($this -> input -> post('todate') == '' && $this -> input -> post('fromdate') != '') {
			//echo "3";
			$todate = $today;
		} else {
			//echo "4";
			$todate = $this -> input -> post('todate');
		}

		//$fromdate = $this -> input -> post('fromdate');
		//$todate = $this -> input -> post('todate');
		$campaign_name = $this -> input -> post('campaign_name');
		$dispostion = $this -> input -> post('dispostion');

		if ($_SESSION['role'] == 3 || $_SESSION['role'] == 4) {
			//echo "2";
			$cse = $_SESSION['user_id'];
			$assign_to = "l.assign_to_telecaller = '$cse'";
		} else if ($_SESSION['role'] == 5) {
			//echo "5";
			$assign_to = $this -> map_dse();

		} else {
			//echo "other";
			$cse = $this -> input -> post('assign_to');
			$assign_to = "l.assign_to_telecaller='$cse' ";
		}
		$this -> db -> select('v.variant_name,
	d.disposition_name,
	s.status_name,
	f.date,f.nextfollowupdate,f.comment,
	u.fname,u.lname,u.role,
	m.model_name as new_model_name,
	m1.model_name as old_model_name,
	m2.make_name,
	r.assign_to_telecaller,r.assign_by_id,f.td_hv_date,
	l.transfer_id,l.manf_year,l.color,l.km,l.ownership,l.accidental_claim,l.buy_status,l.buyer_type,l.lead_source,l.location,enq_id,name,l.assign_to_telecaller,l.email,contact_no,l.address,l.days60_booking,l.comment,enquiry_for,l.status,l.created_date ');
		$this -> db -> from('lead_master l');
		$this -> db -> join('tbl_disposition_status d', 'd.disposition_id=l.disposition', 'left');
		$this -> db -> join('lead_followup f', 'f.id=l.followup_id', 'left');
		$this -> db -> join('request_to_lead_transfer r', 'r.request_id=l.transfer_id', 'left');
		$this -> db -> join('tbl_status s', 's.status_id=l.status', 'left');
		$this -> db -> join('lmsuser u', 'u.id=l.assign_to_telecaller', 'left');
		$this -> db -> join('model_variant v', 'v.variant_id=l.variant_id', 'left');
		$this -> db -> join('make_models m', 'm.model_id=l.model_id', 'left');
		$this -> db -> join('make_models m1', 'm1.model_id=l.old_model', 'left');
		$this -> db -> join('makes m2', 'm2.make_id=l.old_make', 'left');
		if ($dispostion != '') {	$this -> db -> where('l.disposition', $dispostion);

		}

		if ($campaign_name != '' && $campaign_name != 'All') {
			if ($campaign_name == 'Website') {
				$this -> db -> where('lead_source', '');
			} else {
				$name = explode('%23', $campaign_name);
				if ($name[0] == 'Facebook') {
					$this -> db -> where('enquiry_for', $name[1]);
					$this -> db -> where('lead_source', 'Facebook');
				} else {
					$this -> db -> where('lead_source', $name[1]);
				}
			}
		}

		if ($status != 0) {
			$this -> db -> where('l.status', $status);
		}

		if ($status == 0) {
			//my comment
			//$st = "(l.status =1 or l.status=2 or l.status=3 or l.status=4 or l.status=5)";
			//$this -> db -> where($st);
		}

		if ($fromdate != '' && $todate != '') {
			$this -> db -> where('l.created_date>=', $fromdate);
			$this -> db -> where('l.created_date<=', $todate);
		}
		//else {
		//$this -> db -> where('f.date', $today);

		//}
		if ($_SESSION['role'] == 5) {
			$this -> db -> where($assign_to);
		}
		if ($_SESSION['role'] == 3 || $_SESSION['role'] == 4) {
			$this -> db -> where($assign_to);
		}
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		if ($campaign_name == '' && $status == 0 && $fromdate == '' && $todate == '') {
			$this -> db -> limit(50);
		}
		$query = $this -> db -> get()->result();
		
		if(count($query)>0){
		foreach ($query as $row) {
		 $ass_to_telecaller=$row->assign_to_telecaller;
			$assign_by_id=$row->assign_by_id;
			$enq_id=$row->enq_id;
			if($row->lead_source == '')
						{
						 $lead_source= "Web"; 
						}
						elseif($row->lead_source == 'Facebook')
						{
	 						$lead_source= $row->enquiry_for;
					}elseif($row->lead_source == 'Carwale')
						{
	 						$lead_source=$row->enquiry_for;
						}
						else
						{
							 $lead_source=$row->lead_source;
						}
				 if($row->transfer_id != 0  )
					{
						
						$get_cse_name = $this ->get_cse_name($enq_id);
						if(count($get_cse_name)>0  ){
					 	 $cse_fname= $get_cse_name[0]->cse_fname; 
					 	 $cse_lname = $get_cse_name[0]->cse_lname; 
						}
						else{
							
						$cse_fname= ""; 
					 	$cse_lname = ""; 
						}
						$get_cse_data = $this ->get_cse_data($enq_id,$assign_by_id);
				 		if(count($get_cse_data)>0 ){
						 $cse_date= $get_cse_data[0]->date; 
						 $cse_disposition=$get_cse_data[0]->disposition_name ; 
				 		$cse_comment=$get_cse_data[0]->comment; 
				 		$cse_nfd=$get_cse_data[0]->nextfollowupdate;
				//	print_r($get_cse_data);
					}
						else{
						 $cse_date= ""; 
						 $cse_disposition="" ; 
				 		$cse_comment=""; 
				 		$cse_nfd="";
						}
					 }else{
						if($row->transfer_id==0  &&  ($row->role==3 or $row->role==2)){
								
							 $cse_fname=$row->fname; 
							 $cse_lname=$row->lname; 
							 $cse_date= $row->date; 
				 			$cse_disposition=$row->disposition_name ; 
				 			$cse_comment=$row->comment; 
				 			$cse_nfd=$row->nextfollowupdate;
						 }else{
						 	
							$cse_fname="";
							$cse_lname="";
							$cse_date= ""; 
				 			$cse_disposition="" ; 
				 			$cse_comment=""; 
				 			$cse_nfd="";
						} 
					 }
			 if($row->transfer_id!=0 && ($row->role==4 || $row->role==5))
					{
						$get_dse_name = $this ->get_dse_name($enq_id);
						if(count($get_dse_name)>0){
					 	$dse_fname= $get_dse_name[0]->dse_fname; 
					 	$dse_lname = $get_dse_name[0]->dse_lname; 
						}
						else{
							$dse_fname="";
							$dse_lname="";
							
						} 
						$get_dse_data = $this ->get_dse_data($enq_id,$ass_to_telecaller);
				 		if(count($get_dse_data)>0){
						 $dse_date= $get_dse_data[0]->date; 
						 $dse_disposition=$get_dse_data[0]->disposition_name ; 
				 		$dse_comment=$get_dse_data[0]->comment; 
				 		$dse_nfd=$get_dse_data[0]->nextfollowupdate;
				//	print_r($get_cse_data);
					}
						else{
							
							$dse_date= ""; 
				 			$dse_disposition="" ; 
				 			$dse_comment=""; 
				 			$dse_nfd="";
						} 
					 }else{
						if($row->transfer_id==0 && ($row->role==4 || $row->role==5)){
							 $dse_fname=$row->fname; 
							 $dse_lname=$row->lname; 
							 $dse_date= $row->date; 
				 			$dse_disposition=$row->disposition_name ; 
				 			$dse_comment=$row->comment; 
				 			$dse_nfd=$row->nextfollowupdate;
						 }else{
							$dse_fname="";
							$dse_lname="";
							$dse_date= ""; 
				 			$dse_disposition="" ; 
				 			$dse_comment=""; 
				 			$dse_nfd="";
						} 
					 }
			$select_lead_tracker[]=array('enq_id'=>$enq_id,'lead_source'=>$lead_source,'enquiry_for'=>$row->enquiry_for,'address'=>$row->address,'days60_booking'=>$row->days60_booking,'td_hv_date'=>$row->td_hv_date,'custmer_name'=>$row->name,'contact_no'=>$row->contact_no,'email'=>$row->email,'lead_date'=>$row->created_date,'showroom_location'=>$row->location,'cse_fname'=>$cse_fname,'cse_lname'=>$cse_lname,'dse_fname'=>$dse_fname,'cse_date'=>$cse_date,'cse_disposition'=> $cse_disposition,'cse_nfd'=>$cse_nfd,'cse_comment'=>$cse_comment,'dse_lname'=>$dse_lname,'dse_date'=>$dse_date,'dse_disposition'=> $dse_disposition,'dse_nfd'=>$dse_nfd,'dse_comment'=>$dse_comment,'status_name'=>$row->status_name,'buyer_type'=>$row->buyer_type,'new_model_name'=>$row->new_model_name,'variant_name'=>$row->variant_name,'make_name'=>$row->make_name,'old_model_name'=>$row->old_model_name,'manf_year'=>$row->manf_year,'color'=>$row->color,'km'=>$row->km,'ownership'=>$row->ownership,'accidental_claim'=>$row->accidental_claim,'buy_status'=>$row->buy_status);
				}
				}else{
					//$select_lead_tracker[]=array('enq_id'=>'','lead_source'=>'','enquiry_for'=>'','custmer_name'=>'','contact_no'=>'','email'=>'','lead_date'=>'','showroom_location'=>'','cse_fname'=>'','cse_lname'=>'','dse_fname'=>'','cse_date'=>'','cse_disposition'=>'','cse_nfd'=>'','cse_comment'=>'','dse_lname'=>'','dse_date'=>'','dse_disposition'=>'','dse_nfd'=>'','dse_comment'=>'','status_name'=>'','buyer_type'=>'','new_model_name'=>'','variant_name'=>'','make_name'=>'','old_model_name'=>'' , 'manf_year'=>'' , 'color'=>'','km'=>'','ownership'=>'','accidental_claim'=> '','buy_status'=>'');
			$select_lead_tracker=array();
				}
		
		
		return $select_lead_tracker;

	}
public function get_cse_name($enq_id){
	$query=$this->db->query("select role from request_to_lead_transfer r left join lmsuser u on  r.assign_to_telecaller=u.id where lead_id='$enq_id'  order by request_id desc limit 1 ")->result();
	   if(isset($query[0]->role)){
	   	if($query[0]->role==3 or $query[0]->role==2){
	   		
	   		$query_cse1=$this->db->query("SELECT l.lname as cse_lname,l.fname as cse_fname , l.role as role
	   	 from request_to_lead_transfer r 
	   	 join lmsuser l on  r.assign_to_telecaller=l.id  
	   	 where  lead_id='$enq_id' and (role = 3 or role=2) order by request_id desc limit 1 ");
	   	}
	   	if($query[0]->role==4 or $query[0]->role==5){
	   		$query_cse1=$this->db->query("SELECT l.lname as cse_lname,l.fname as cse_fname , l.role as role
	   	 from request_to_lead_transfer r 
	   	 join lmsuser l on  r.assign_by_id=l.id  
	   	 where  lead_id='$enq_id' and (role = 3 or role=2) order by request_id desc limit 1 ");
	   	}
	   }else{
	   		$query_cse1=$this->db->query("select role from request_to_lead_transfer r left join lmsuser u on  r.assign_to_telecaller=u.id where lead_id='$enq_id'  order by request_id desc limit 1 ")->result();
		
	   }
      //  echo $this->db->last_query();
	 return $query_cse1->result();
		
	 }
public function get_cse_data($enq_id,$assign_by_id){
		$query_cse=$this->db->query("SELECT d.disposition_name,f.comment,f.date,f.nextfollowupdate 
		FROM  lead_followup f 
		LEFT JOIN tbl_disposition_status d ON d.disposition_id =f.disposition 
		join request_to_lead_transfer r on r.assign_by_id=f.assign_to  
		join lmsuser l on  r.assign_by_id=l.id 
		where f.leadid='$enq_id'  and  (role = 3 or role=2) ORDER BY f.id DESC  limit 1");
                  
                 //echo $this->db->last_query();
	 return $query_cse->result();
		
	 }
public function get_dse_name($enq_id){
	
     $query_dse1=$this->db->query("SELECT l.lname as dse_lname,l.fname as dse_fname 
     from request_to_lead_transfer r 
     join lmsuser l on  r.assign_to_telecaller=l.id  
     where  lead_id='$enq_id' and (role = 4 or role=5) order by request_id desc");
               
                 	 //echo $this->db->last_query();
	 return $query_dse1->result();
		
	 }
public function get_dse_data($enq_id,$assign_to_telecaller){
	  $query_dse=$this->db->query("SELECT d.disposition_name,f.comment,f.date,f.nextfollowupdate 
	  FROM  lead_followup f  
	  JOIN tbl_disposition_status d ON d.disposition_id =f.disposition
	  JOIN request_to_lead_transfer r on r.assign_to_telecaller=f.assign_to   
	   JOIN lmsuser l on  r.assign_to_telecaller=l.id  
	  where f.leadid='$enq_id'  and assign_to='$assign_to_telecaller' and (role = 4 or role=5) ORDER BY f.id DESC  limit 1");
                  
     //echo $this->db->last_query();
	 return $query_dse->result();
		
	 }
	public function lc_data_dse() {
		$today = date('Y-m-d');
		$status = $this -> input -> post('status');
		if ($this -> input -> post('fromdate') == '' && $this -> input -> post('todate') != '') {
			//echo "1";
			$fromdate = $today;
		} else {
			//echo "2";
			$fromdate = $this -> input -> post('fromdate');
		}
		if ($this -> input -> post('todate') == '' && $this -> input -> post('fromdate') != '') {
			//echo "3";
			$todate = $today;
		} else {
			//echo "4";
			$todate = $this -> input -> post('todate');
		}

		//$fromdate = $this -> input -> post('fromdate');
		//$todate = $this -> input -> post('todate');
		$campaign_name = $this -> input -> post('campaign_name');
		$dispostion = $this -> input -> post('dispostion');

		if ($_SESSION['role'] == 3 || $_SESSION['role'] == 4) {
			//echo "2";
			$cse = $_SESSION['user_id'];
			$assign_to = "l.assign_to_telecaller = '$cse'";
		} else if ($_SESSION['role'] == 5) {
			//	echo "5";
			$assign_to = $this -> map_dse();

		} else {
			//echo "other";
			$cse = $this -> input -> post('assign_to');
			$assign_to = "l.assign_to_telecaller='$cse' ";
		}
		$this -> db -> select('v.variant_name,
	d.disposition_name,
	s.status_name,
	f.date,f.nextfollowupdate,f.comment,
	u.fname,u.lname,u.role,
	m.model_name as new_model_name,
	m1.model_name as old_model_name,
	m2.make_name,
	r.assign_to_telecaller,r.assign_by_id,f.td_hv_date,
	l.transfer_id,l.manf_year,l.color,l.km,l.ownership,l.accidental_claim,l.buy_status,l.buyer_type,l.lead_source,l.location,enq_id,name,l.assign_to_telecaller,l.email,l.address,l.days60_booking,contact_no,l.comment,enquiry_for,l.status,l.created_date ');
		$this -> db -> from('lead_master_lc l');
		$this -> db -> join('tbl_disposition_status d', 'd.disposition_id=l.disposition', 'left');
		$this -> db -> join('lead_followup_lc f', 'f.id=l.followup_id', 'left');
		$this -> db -> join('request_to_lead_transfer_lc r', 'r.request_id=l.transfer_id', 'left');
		$this -> db -> join('tbl_status s', 's.status_id=l.status', 'left');
		$this -> db -> join('lmsuser u', 'u.id=l.assign_to_telecaller', 'left');
		$this -> db -> join('model_variant v', 'v.variant_id=l.variant_id', 'left');
		$this -> db -> join('make_models m', 'm.model_id=l.model_id', 'left');
		$this -> db -> join('make_models m1', 'm1.model_id=l.old_model', 'left');
		$this -> db -> join('makes m2', 'm2.make_id=l.old_make', 'left');
		if ($dispostion != '') {	$this -> db -> where('l.disposition', $dispostion);

		}
		if ($campaign_name != '' && $campaign_name != 'All') {
			if ($campaign_name == 'Website') {
				$this -> db -> where('lead_source', '');
			} else {
				$name = explode('%23', $campaign_name);
				if ($name[0] == 'Facebook') {
					$this -> db -> where('enquiry_for', $name[1]);
					$this -> db -> where('lead_source', 'Facebook');
				} else {
					$this -> db -> where('lead_source', $name[1]);
				}
			}
		}

		if ($status != 0) {
			$this -> db -> where('l.status', $status);
		}

		if ($status == 0) {
			$st = "(l.status=1 or l.status=2 or l.status=3 or l.status=4 or l.status=5)";
			$this -> db -> where($st);
		}

		if ($fromdate != '' && $todate != '') {
			$this -> db -> where('l.created_date>=', $fromdate);
			$this -> db -> where('l.created_date<=', $todate);
		}
		//else {
		//$this -> db -> where('f.date', $today);

		//}

		if ($_SESSION['role'] == 5) {
			$this -> db -> where($assign_to);
		}
		if ($_SESSION['role'] == 3 || $_SESSION['role'] == 4) {
			$this -> db -> where($assign_to);
		}
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		if ($campaign_name == '' && $status == 0 && $fromdate == '' && $todate == '') {
			$this -> db -> limit(50);
		}
		$query = $this -> db -> get()->result();
		//echo $this->db->last_query();
		if(count($query)>0){
		foreach ($query as $row) {
		 $ass_to_telecaller=$row->assign_to_telecaller;
			$assign_by_id=$row->assign_by_id;
			$enq_id=$row->enq_id;
			if($row->lead_source == '')
						{
						 $lead_source= "Web"; 
						}
						elseif($row->lead_source == 'Facebook')
						{
	 						$lead_source= $row->enquiry_for;
					}elseif($row->lead_source == 'Carwale')
						{
	 						$lead_source=$row->enquiry_for;
						}
						else
						{
							 $lead_source=$row->lead_source;
						}
				 if($row->transfer_id != 0  )
					{
						
						$get_cse_name = $this ->get_cse_name_lc($enq_id);
						if(count($get_cse_name)>0  ){
					 	 $cse_fname= $get_cse_name[0]->cse_fname; 
					 	 $cse_lname = $get_cse_name[0]->cse_lname; 
						}
						else{
							
						$cse_fname= ""; 
					 	$cse_lname = ""; 
						}
						$get_cse_data = $this ->get_cse_data_lc($enq_id,$assign_by_id);
				 		if(count($get_cse_data)>0 ){
						 $cse_date= $get_cse_data[0]->date; 
						 $cse_disposition=$get_cse_data[0]->disposition_name ; 
				 		$cse_comment=$get_cse_data[0]->comment; 
				 		$cse_nfd=$get_cse_data[0]->nextfollowupdate;
				//	print_r($get_cse_data);
					}
						else{
						 $cse_date= ""; 
						 $cse_disposition="" ; 
				 		$cse_comment=""; 
				 		$cse_nfd="";
						}
					 }else{
						if($row->transfer_id==0  &&  ($row->role==3 or $row->role==2)){
								
							 $cse_fname=$row->fname; 
							 $cse_lname=$row->lname; 
							 $cse_date= $row->date; 
				 			$cse_disposition=$row->disposition_name ; 
				 			$cse_comment=$row->comment; 
				 			$cse_nfd=$row->nextfollowupdate;
						 }else{
						 	
							$cse_fname="";
							$cse_lname="";
							$cse_date= ""; 
				 			$cse_disposition="" ; 
				 			$cse_comment=""; 
				 			$cse_nfd="";
						} 
					 }
			 if($row->transfer_id!=0 && ($row->role==4 || $row->role==5))
					{
						$get_dse_name = $this ->get_dse_name_lc($enq_id);
						if(isset($get_dse_name[0])){
					 	$dse_fname= $get_dse_name[0]->dse_fname; 
					 	$dse_lname = $get_dse_name[0]->dse_lname; 
						}
						else{
							$dse_fname= ""; 
					 	$dse_lname = ""; 
						}
						$get_dse_data = $this ->get_dse_data_lc($enq_id,$ass_to_telecaller);
				 		if(isset($get_dse_data[0])){
						 $dse_date= $get_dse_data[0]->date; 
						 $dse_disposition=$get_dse_data[0]->disposition_name ; 
				 		$dse_comment=$get_dse_data[0]->comment; 
				 		$dse_nfd=$get_dse_data[0]->nextfollowupdate;
				//	print_r($get_cse_data);
					}else{
						 $dse_date=""; 
						 $dse_disposition=""; 
				 		$dse_comment=""; 
				 		$dse_nfd="";
					}
					 }else{
						if($row->transfer_id==0 && ($row->role==4 || $row->role==5)){
							 $dse_fname=$row->fname; 
							 $dse_lname=$row->lname; 
							 $dse_date= $row->date; 
				 			$dse_disposition=$row->disposition_name ; 
				 			$dse_comment=$row->comment; 
				 			$dse_nfd=$row->nextfollowupdate;
						 }else{
							$dse_fname="";
							$dse_lname="";
							$dse_date= ""; 
				 			$dse_disposition="" ; 
				 			$dse_comment=""; 
				 			$dse_nfd="";
						} 
					 }
			$select_lead_tracker[]=array('enq_id'=>$enq_id,'lead_source'=>$lead_source,'address'=>$row->address,'days60_booking'=>$row->days60_booking,'td_hv_date'=>$row->td_hv_date,'enquiry_for'=>$row->enquiry_for,'custmer_name'=>$row->name,'contact_no'=>$row->contact_no,'email'=>$row->email,'lead_date'=>$row->created_date,'showroom_location'=>$row->location,'cse_fname'=>$cse_fname,'cse_lname'=>$cse_lname,'dse_fname'=>$dse_fname,'cse_date'=>$cse_date,'cse_disposition'=> $cse_disposition,'cse_nfd'=>$cse_nfd,'cse_comment'=>$cse_comment,'dse_lname'=>$dse_lname,'dse_date'=>$dse_date,'dse_disposition'=> $dse_disposition,'dse_nfd'=>$dse_nfd,'dse_comment'=>$dse_comment,'status_name'=>$row->status_name,'buyer_type'=>$row->buyer_type,'new_model_name'=>$row->new_model_name,'variant_name'=>$row->variant_name,'make_name'=>$row->make_name,'old_model_name'=>$row->old_model_name,'manf_year'=>$row->manf_year,'color'=>$row->color,'km'=>$row->km,'ownership'=>$row->ownership,'accidental_claim'=>$row->accidental_claim,'buy_status'=>$row->buy_status);
				}
				}else{
					//$select_lead_tracker[]=array('enq_id'=>'','lead_source'=>'','enquiry_for'=>'','custmer_name'=>'','contact_no'=>'','email'=>'','lead_date'=>'','showroom_location'=>'','cse_fname'=>'','cse_lname'=>'','dse_fname'=>'','cse_date'=>'','cse_disposition'=>'','cse_nfd'=>'','cse_comment'=>'','dse_lname'=>'','dse_date'=>'','dse_disposition'=>'','dse_nfd'=>'','dse_comment'=>'','status_name'=>'','buyer_type'=>'','new_model_name'=>'','variant_name'=>'','make_name'=>'','old_model_name'=>'' , 'manf_year'=>'' , 'color'=>'','km'=>'','ownership'=>'','accidental_claim'=> '','buy_status'=>'');
			$select_lead_tracker=array();
				}
		
		
		return $select_lead_tracker;

	}
public function get_cse_name_lc($enq_id){
	  $query=$this->db->query("select role from request_to_lead_transfer_lc r left join lmsuser u on  r.assign_to_telecaller=u.id where lead_id='$enq_id' order by request_id desc limit 1  ")->result();
	   	if(isset($query[0]->role)){
	   	if($query[0]->role==3 or $query[0]->role==2){
	   		
	   		$query_cse1=$this->db->query("SELECT l.lname as cse_lname,l.fname as cse_fname , l.role as role
	   	 from request_to_lead_transfer_lc r 
	   	 join lmsuser l on  r.assign_to_telecaller=l.id  
	   	 where  lead_id='$enq_id' and (role = 3 or role=2) order by request_id desc limit 1 ");
	   	}
	   	if($query[0]->role==4 or $query[0]->role==5){
	   		$query_cse1=$this->db->query("SELECT l.lname as cse_lname,l.fname as cse_fname , l.role as role
	   	 from request_to_lead_transfer_lc r 
	   	 join lmsuser l on  r.assign_by_id=l.id  
	   	 where  lead_id='$enq_id' and (role = 3 or role=2) order by request_id desc limit 1 ");
	   	}
		}
        //echo $this->db->last_query();
	 return $query_cse1->result();
		
	 }
public function get_cse_data_lc($enq_id,$assign_by_id){
	   $query_cse=$this->db->query("SELECT d.disposition_name,f.comment,f.date,f.nextfollowupdate 
     FROM  lead_followup_lc f 
     LEFT JOIN tbl_disposition_status d ON d.disposition_id =f.disposition 
     JOIN request_to_lead_transfer_lc r ON r.assign_by_id=f.assign_to  
     JOIN lmsuser l ON r.assign_by_id=l.id 
      
     WHERE f.leadid='$enq_id'   AND (role = 3 OR role=2) 
     ORDER BY f.id DESC  limit 1");
                  
                 //echo $this->db->last_query();
	 return $query_cse->result();
		
	 }
public function get_dse_name_lc($enq_id){
      $query_dse1=$this->db->query("SELECT l.lname as dse_lname,l.fname as dse_fname 
	  FROM request_to_lead_transfer_lc r 
	  JOIN lmsuser l  ON  r.assign_to_telecaller=l.id  
	  WHERE lead_id='$enq_id'  ORDER BY request_id desc");
                   
               
                 	 //echo $this->db->last_query();
	 return $query_dse1->result();
		
	 }
public function get_dse_data_lc($enq_id,$assign_to_telecaller){
	 
	   $query_dse=$this->db->query("SELECT d.disposition_name,f.comment,f.date,f.nextfollowupdate 
	   FROM  lead_followup_lc f  
	   JOIN tbl_disposition_status d ON d.disposition_id =f.disposition  
	   WHERE f.leadid='$enq_id'  AND assign_to='$assign_to_telecaller' ORDER BY f.id DESC  limit 1");
                 
                 
                  
     //echo $this->db->last_query();
	 return $query_dse->result();
		
	 }


}
?>