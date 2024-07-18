<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class transfer_lead_model extends CI_model {
	function __construct() {
		parent::__construct();
	}
public function transfer_telecaller()
	{
		
		$this -> db -> select('fname,lname,id');
		$this -> db -> from('lmsuser ');
		//$this->db->where('role',3);
		$this->db->where('status',1);
		$this->db->order_by('fname','asc');
		$query=$this->db->get();
		return $query->result();
			}
	public function select_lead() {
		//Get Transfer  Leads
		$status=$this->input->post('status');
		$transfer_to=$this->input->post('transfer_to');
		$transfer_from=$this->input->post('transfer_from');
		$date_to=$this->input->post('todate');
		$date_from=$this->input->post('fromdate');
		$assign_to = $_SESSION['user_id'];
		$this -> db -> select("u.fname,u.lname,
		u1.fname as transfer_by_fname,u1.lname as transfer_by_lname,lm.eagerness,
		 lm.buyer_type,lm.model_id,lm.variant_id,lm.buy_status,lf.date,d.disposition_name,
		lm.enq_id,lm.name,lm.status,lm.contact_no,lm.email,lm.assignby,lm.enquiry_for,lm.created_date,lm.created_time,lm.old_make,lm.old_model,lm.ownership,lm.manf_year,lm.color,lm.km,
		lf.nextfollowupdate,lf.comment ,
		r.remark,
		s.status_name");
		$this -> db -> from("lead_master lm");
		$this -> db -> join("lead_followup lf", "lm.followup_id=lf.id",'left');
		$this -> db -> join("request_to_lead_transfer rt", "rt.request_id=lm.transfer_id",'left');
		$this -> db -> join("tbl_status s", "s.status_id=lm.status", 'left');
		$this -> db -> join("tbl_manager_remark r", "r.remark_id=lm.remark_id", 'left');
		$this -> db -> join("lmsuser u", "u.id=lm.assign_to_telecaller");
		$this -> db -> join("lmsuser u1", "u1.id=lm.assignby");
		$this -> db -> join("tbl_disposition_status d", "d.disposition_id=lm.disposition", 'left');
		$this -> db -> where("rt.assign_to_telecaller=", $assign_to);
		if($status!=0)
		{
			$this->db->where('lm.status',$status);
		}
		if($transfer_from!='')
			{
					$this->db->where('lm.assignby',$transfer_from);
			}
			if($date_from!='' && $date_to!='' )
			{
					$this->db->where('rt.created_date>=',$date_from);
					$this->db->where('rt.created_date<=',$date_to);
					
			}
	
		$this -> db -> group_by('lf.leadid');
		$this -> db -> order_by('lf.id', 'desc');
		$this->db->limit(100);
		$query = $this -> db -> get();
		return $query -> result();
		
	}
}
?>