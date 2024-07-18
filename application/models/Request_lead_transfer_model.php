<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class request_lead_transfer_model extends CI_model {
	function __construct()
	{
		parent::__construct();
	}
	public function select_transfer_lead()
	{	
		$assign_to=$_SESSION['user_id'];
					
						$this->db->select('d.disposition_name,s.status_name,f.comment,m.*,u.fname,t.transfer_reason,u.lname,t.location,m.comment,t.created_date,t.status as r_status ');
						$this->db->from('request_to_lead_transfer t');
						$this->db->join('lead_master m','m.enq_id=t.lead_id');
						$this->db->join('lmsuser u','u.id=t.assign_by_id');
						$this->db->join('lead_followup f','f.leadid=m.enq_id','left');
						$this->db->join('tbl_status s','s.status_id=m.status','left');
						$this->db->join('tbl_disposition_status d','d.disposition_id=m.disposition','left');
						$this->db->where('t.assign_to_telecaller=',$assign_to);
						$this->db->order_by('t.request_id','desc');				
						$this->db->group_by('m.enq_id');		
	
	$query=$this->db->get();
//echo $this->db->last_query();
				return $query->result();
					
		
		
		

	}
	}
?>