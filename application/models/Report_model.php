<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class report_model extends CI_model {
	function __construct() {
		parent::__construct();
	}
public function select_cse()
{
	
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser l');
		$this -> db -> join('tbl_user_group u', 'u.user_id=l.id');
		$this -> db -> where('role', 3);
		$this -> db -> order_by('fname', 'asc');
		$this->db->group_by('l.id');
		$query = $this -> db -> get();
		return $query -> result();
}
public function select_fresh_lead()
{
	$cse_name=$this->input->post('cse_name');
	$fromdate=$this->input->post('fromdate');
	$todate=$this->input->post('todate');
	if($fromdate=='')
	{
		$fromdate=date('Y-m-d');
	}
	else {
		$fromdate=$this->input->post('fromdate');
	}
	if($todate=='')
	{
		$todate=date('Y-m-d');
	}
	else {
		$todate=$this->input->post('todate');
	}
	
	
	
	$this -> db -> select('count(enq_id) as fresh_lead_count,l.created_date');
		$this -> db -> from('lead_master l');
		$this->db->where('l.created_date>=',$fromdate);
		$this->db->where('l.created_date<=',$todate);
		if($cse_name!='')
		{
		$this->db->where('l.assign_to_telecaller',$cse_name);
		}	
		$this->db->group_by('l.created_date');	
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
}
public function select_pending_lead()
{
	$fromdate=date('2017-02-03');
	$todate=date('2017-02-04');
	$this -> db -> select('count(l.enq_id) as pending_lead_count');
		$this -> db -> from('lead_master l');
		$this -> db -> join('lead_followup f','f.leadid=l.enq_id');
		$this -> db -> where("f.nextfollowupdate!=", '0000-00-00');
		$this -> db -> where("f.nextfollowupdate <", $fromdate);
		//$this -> db -> where("lf.nextfollowupdate >", $todate);
		$this->db->group_by('f.nextfollowupdate');		
		$query = $this -> db -> get();
		echo $this->db->last_query();
		return $query -> result();
}
public function select_followup_lead()
{
	$fromdate=date('2017-02-03');
	$todate=date('2017-02-04');
	$this -> db -> select('count(l.enq_id) as followup_lead_count');
		$this -> db -> from('lead_master l');
		$this -> db -> join('lead_followup f','f.leadid=l.enq_id');
		$this->db->where('f.nextfollowupdate>=',$fromdate);
		$this->db->where('f.nextfollowupdate<=',$todate);	
		$this->db->group_by('f.nextfollowupdate');		
		$query = $this -> db -> get();
		echo $this->db->last_query();
		return $query -> result();
}


}
?>