<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class add_campaign_model extends CI_model {
	function __construct() {
		parent::__construct();
	}

	
	public function select_table()
	{
			$this->db->select('group_id,group_name');
			$this->db->from('tbl_group');
			$query1=$this->db->get();
			 $this->db->last_query();
			return $query1->result();	
		 $this->db->last_query();
		
		
	}
	
	public function select_campaign()
	{
		
		$this->db->select('DISTINCT (enquiry_for) as enquiry_for ');
		$this->db->from('lead_master');
		$this->db->where('lead_source','Facebook');
		$query2=$this->db->get();
		//echo $this->db->last_query();
		return $query2->result();
		
		
	}
	
	public function campaign_table()

	{
		
		$this->db->select('g.group_name,c.group_id,c.campaign_name,c.campaign_id');
		$this->db->from('tbl_campaign c');
		$this->db->join('tbl_group g','c.group_id=g.group_id');
		$query=$this->db->get();
	
//echo $this->db->last_query();	
		return $query->result();
		
	}
	
		
	
	
	
	public function add_campaign($grp_id,$c_name)
	{
		
	$query=$this->db->query("insert into tbl_campaign(`group_id`,`campaign_name`)values('$grp_id','$c_name')");
	

	}

	public function edit_campaign($id)
	{
		
		$this->db->select('c.group_id,g.group_name,c.campaign_name,c.campaign_id');
		$this->db->from('tbl_campaign c');
		$this->db->join('tbl_group g','c.group_id=g.group_id');
		$this->db->where('c.campaign_id',$id);
		$query=$this->db->get();
		
		//echo $this->db->last_query();
		
		return $query->result();	
		 
		
		
	
	}
	
	
	
	public function update_campaign($campaign_id,$grp_id,$c_name)
	{
		
	
		 
		$this->db->query('update tbl_campaign set campaign_name="'.$c_name.'" ,group_id="'.$grp_id.'"  where campaign_id="'.$campaign_id.'"');	
		
	
	}
	
	
	
	
	
}

