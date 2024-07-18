<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class add_dept_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function add_department($dept_name)
	{
		
		$query=$this->db->query("insert into department(`dept_name`)values('$dept_name')");
	
	}
	
	
	public function select_table()
	{
		$this->db->select('*');
		$this->db->from('department');
		$query1 = $this->db->get();
		return $query1->result();
	
		
	}
	
	public function select_dept()
	{
		$this->db->select('*');
		$this->db->from('department');
		$query = $this->db->get();
		return $query->result();
	
		
	}
	
	
		public function edit_dept($id)
	{
		$this->db->select('*');
		$this->db->from('department');
		$this->db->where('dept_id', $id);
		$query = $this->db->get();
		return $query->result();
	
	}
	
	function update_dept($dept_name,$id)
	{
		$this->db->query('update department set dept_name="'.$dept_name.'"  where dept_id="'.$id.'"');
		
	}
	
	
		function del_dept($id)
	{
		$this->db->query("delete from department where dept_id='$id'");
		
	}
	
	
}