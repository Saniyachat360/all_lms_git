<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class telecaller_lead_model extends CI_model {
	function __construct() {
		parent::__construct();
	}

	public function select_lead() {

		$this -> db -> select("l.manual_lead,f.comment as fcomment,u.fname,u.lname,l.manual_lead,l.enq_id,l.name,l.email,l.contact_no,l.enquiry_for,l.status,l.assign_to_telecaller,l.created_date,l.created_time,l.comment");
		$this -> db -> from("lead_master l");
		$this -> db -> join('lmsuser u', 'u.id=l.assign_to_telecaller');
		$this -> db -> join('lead_followup f', 'f.leadid=l.enq_id', 'left');
		if ($_SESSION['role'] == 3) {
			$username = $_SESSION['username'];
			$this -> db -> where('l.manual_lead', $username);
		} else {
			$this -> db -> where('l.manual_lead !=', '');
		}

		$this -> db -> group_by('leadid');
		$this -> db -> order_by('enq_id', 'desc');
		$query = $this -> db -> get();
		return $query -> result();

	}
	
	public function select_campaign()
	{
		
		$this->db->select('DISTINCT (enquiry_for) as enquiry_for ');
		$this->db->from('lead_master');
		$this->db->where('lead_source','Facebook');
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $query->result();
		
		
	}
	
	public function select_disposition()
{
	$status=$this->input->post('status');
	$this->db->select('disposition_name,disposition_id');
   $this->db->from('tbl_disposition_status ');
if($status!=0)
{
$this->db->where('status_id',$status);
}
$this->db->order_by('disposition_name','asc');
$query=$this->db->get();
//echo $this->db->last_query();
				return $query->result();
}

	
	public function select_telecaller()
	{
			$this->db->select('fname,lname,id');
			$this->db->from('lmsuser');
			$this->db->where('role',3);
			$this->db->where('status',1);
			$this->db->order_by('fname','asc');
			$query=$this->db->get();
			return $query->result();			
	}
	
	
	public function select_tl_lead($campaign_name,$lead,$dispostion,$a,$f,$t)
	{
		
		 
		
		$str_fromdate=strtotime($f);
		$str_todate=strtotime($t);
		 
		 
		$this -> db -> select("l.manual_lead,u.fname,u.lname,l.manual_lead,l.enq_id,l.name,l.email,l.contact_no,l.enquiry_for,l.status,l.assign_to_telecaller,l.followupby,l.created_date,l.created_time,l.comment");
		$this -> db -> from("lead_master l");
		$this -> db -> join('lmsuser u', 'u.id=l.assign_to_telecaller');
		
		if($lead != '')
		{
			$this->db->where('l.status',$lead);
			
		}
		if($dispostion != '')
		{
			$this->db->where('l.followup_reason',$dispostion);
			
		}
		if($a != 0)
		{
			$this->db->where('assign_to_telecaller',$a);
			
		}
	
		if($f !='')
		{
			$this->db->where('l.str_to_time_created_date>=',$str_fromdate);
		}
		if($t !='')
		{
			$this->db->where('l.str_to_time_created_date<=',$str_todate);
		}
				
	
		$this -> db -> order_by('enq_id', 'desc');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
		 
		 
		
	}
	
	

}
?>