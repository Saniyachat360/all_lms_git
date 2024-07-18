<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class man_transfer_lead_model extends CI_model {
	function __construct() {
		parent::__construct();
	}

	public function transfered_lead($assign_to1,$enq_id,$user_id)
	{
		
		
		//print_r($enq_id);
		$enq_id_count=count($enq_id);
		
		
		for($i=0;$i<$enq_id_count;$i++)
		{
			$this->db->select("enq_id");
			$this->db->from("lead_master");
			$this->db->where("assign_to_telecaller",$assign_to1);
			$this->db->where("enq_id",$enq_id[$i]);
			$query=$this->db->get()->result();
		//	echo $q=count($query);
		
		if(count($query) > 0)
		{
			
					$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Lead Already Assign ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');	
			
		}
		else
		 {
		$query=$this -> db -> query('update lead_master set assignby="' . $user_id . '" , assign_to_telecaller="' . $assign_to1 . '" where enq_id="' . $enq_id[$i] . '"');
		
		$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Lead Transfered Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
		
		
		$today1 = date("Y-m-d");

	

		$time = date("H:i:s A");
		
		$insertQuery = $this -> db -> query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to_telecaller` , `assign_by_id` ,`created_date` , `created_time` ,status)  
		VALUES("' . $enq_id[$i] . '","' . $assign_to1 . '","' . $user_id . '","' . $today1 . '","' . $time . '","Transfered")');
		 }
	
		}
		

	}
	
	public function select_campaign() {
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



	//Select Status
	function select_status() {
		$process_id = $_SESSION['process_id'];
		$this -> db -> select('s.status_name,s.status_id ');
		$this -> db -> from('tbl_status s');
		$this -> db -> join('tbl_process p', 's.process_id=p.process_id', 'left');
		$this -> db -> where('p.process_id', $process_id);
		$this -> db -> where('status_name !=', 'Not Yet');

		$query = $this -> db -> get();
		//		echo $this->db->last_query();
		return $query -> result();

	}

	//Select Group
	function select_group() {
		$this -> db -> select('group_id,group_name');
		$this -> db -> from('tbl_group');
		$query = $this -> db -> get();
		return $query -> result();

	}
	//Select lead source
	function select_lead_source() {
		$this -> db -> select('*');
		$this -> db -> from('lead_source');
		$query = $this -> db -> get();
		return $query -> result();

	}

	//Select CSE name
	public function select_telecaller() {
			$query = $this -> db -> query("select role_name from lmsuser where role=2") -> result();

		if (isset($query[0])) {$role_name = $query[0] -> role_name;
		}
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser l');
		if ($_SESSION['role'] == 2 && $role_name = 'CSE Team Leader') {
			$this -> db -> where('role', 3);
		}
		if ($_SESSION['role'] == 5) {
			$this -> db -> join('tbl_mapdse md', 'md.dse_id=l.id');
			$this -> db -> where('tl_id', $_SESSION['user_id']);
		}
		$this -> db -> where('role!=', 1);
		$this -> db -> order_by('fname', 'asc');
		$query = $this -> db -> get();
		return $query -> result();
	}

public function select_telecaller_assign() {
			$query = $this -> db -> query("select role_name from lmsuser where role=2") -> result();

		if (isset($query[0])) {$role_name = $query[0] -> role_name;
		}
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser l');
		if ($_SESSION['role'] == 2 && $role_name = 'CSE Team Leader') {
			$role="(role=3 or role=5) and role!=1";
			$this -> db -> where($role);
		}
		if ($_SESSION['role'] == 5) {
			$this -> db -> join('tbl_mapdse md', 'md.dse_id=l.id');
			$this -> db -> where('tl_id', $_SESSION['user_id']);
		}
		if($_SESSION['role']==3){
			$role="(role=3 or role=5 ) and role!=1";
			$this -> db -> where($role);
		}
		if($_SESSION['role']==4){
			$role="role=4 and role!=1";
			$this -> db -> where($role);
		}
		
		
		$this -> db -> order_by('fname', 'asc');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}

	public function select_disposition($status) {

		$this -> db -> select('disposition_name,disposition_id');
		$this -> db -> from('tbl_disposition_status ');
		if ($status != 0) {
			$this -> db -> where('status_id', $status);
		}
		$this -> db -> order_by('disposition_name', 'asc');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function select_dse_tl_id() {
		$assign_to = $_SESSION['user_id'];
		$query = $this -> db -> query("select dse_id from tbl_mapdse where tl_id='$assign_to'") -> result();
		$c = count($query);
			$t = ' ( ';
		if (count($query) > 0) {
		
			foreach ($query as $row) {
				$t = $t . "assign_to_telecaller = " . $row -> dse_id . " or ";

			}
				$t = $t . "  assign_to_telecaller = " . $assign_to;
			
		}else{
			$t = $t . "  assign_to_telecaller = " . $assign_to;
		}
			$at = $t . ')';
		return $at;
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

	public function select_transfer_lead($enq) {
	//echo "hi";
	
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
		$enq = str_replace('%20', ' ', $enq);
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
		
		//If select Disposition
		if ($filter_disposition != '') {
			$this -> db -> where('l.disposition', $filter_disposition);

		}
		//If select Campaign Name
		if ($filter_campaign_name != '' && $filter_campaign_name != 'All') {
			if ($filter_campaign_name == 'Website') {
				$this -> db -> where('lead_source', '');
			} else {
				//echo $enq;
				$name = explode('%23', $filter_campaign_name);
				if ($name[0] == 'Facebook') {
					$this -> db -> where('enquiry_for', $name[1]);
					$this -> db -> where('lead_source', 'Facebook');
				} else {
					$this -> db -> where('lead_source', $name[1]);
				}
			}
		}
		if ($enq == 'All') {
			if ($_SESSION['role'] == 2) {
				$this -> db -> where($st);
			}
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
		else{
				$this -> db -> where('assign_to_telecaller!=', 0);
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

}
