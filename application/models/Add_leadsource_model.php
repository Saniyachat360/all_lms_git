<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Add_leadsource_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function insert_leadsource($leadsource, $leadsource_value,$process_id) {

		$q = $this -> db -> query('select * from lead_source where lead_source_name="' . $leadsource . '" and process_id="'. $process_id .'" ') -> result();
		//print_r($q);

		if (count($q) > 0) {

			$query1=$this->db->query("select lead_source_name from  lead_source where lead_source_name='$leadsource'  AND process_id ='$process_id' AND leadsourceStatus='Deactive'")->result();
			 if(count($query1)>0)
			 {
			 
			 $query=$this->db->query("update lead_source set leadsourceStatus='Active' where lead_source_name='$leadsource'  AND process_id ='$process_id'  AND leadsourceStatus='Deactive' ");
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Leadsource Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			 
			 }
			else {
				
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Leadsource Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');	
			}
		} else {

			$query = $this -> db -> query("insert into lead_source (`lead_source_name`,`lead_source_value`,`process_id`,`leadsourceStatus`)values('$leadsource','$leadsource_value','$process_id','Active')");

			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Leadsource Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}
	}

	public function select_leadsource() {
		$this -> db -> select('l.lead_source_name,l.id,p.process_name,l.leadsourceStatus');
		$this -> db -> from('lead_source l');
		$this->db->join('tbl_process p','p.process_id=l.process_id','left');
		//$this -> db -> where('leadsourceStatus!=', 'Deactive');
		$this -> db -> where('p.process_id',$_SESSION['process_id']);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function edit_leadsource($id) {
		$this -> db -> select('l.lead_source_name,l.id,p.process_name,p.process_id');
		$this -> db -> from('lead_source l');
		$this->db->join('tbl_process p','p.process_id=l.process_id','left');
		$this -> db -> where('l.id', $id);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function edit_new_leadsource($leadsource, $leadsource_value, $id,$process_id) {

		$q = $this -> db -> query('select * from lead_source where lead_source_name="' . $leadsource . '" and process_id="'.$process_id.'"and (leadsourceStatus=" " || leadsourceStatus="Active")') -> result();

		//	print_r($q);

		if (count($q) > 0) {

			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Leadsource Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {

			$this -> db -> query('update lead_source set lead_source_name="' . $leadsource . '", lead_source_value ="' . $leadsource_value . '",process_id="'.$process_id.'"  where id="' . $id . '"');
			if ($this -> db -> affected_rows() > 0) {

				$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Leadsource Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			} else {
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Leadsource Not Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			}

		}
	}

	public function delete_leadsource($id) {

		$this -> db -> query('update lead_source set leadsourceStatus="Deactive" where id="' . $id . '"');
		if ($this -> db -> affected_rows() > 0) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Leadsource Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Leadsource Not Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}

	}

	public function select_table() {
		$this -> db -> select('u.fname,u.lname,u.mobileno,u.email,u.id,u.role,l.location,p.process_name');
		$this -> db -> from('lmsuser u');
		$this -> db -> join('tbl_location l', 'l.location_id=u.location');
		$this -> db -> join('tbl_process p', 'p.process_id=u.process_id');
		$this -> db -> where('u.id !=', '0');

		$this -> db -> where('status', '1');
		$query1 = $this -> db -> get();
		return $query1 -> result();

	}
public function select_process()
{
		$this -> db -> select('process_id,process_name');
		$this -> db -> from('tbl_process');
		$query1 = $this -> db -> get();
		return $query1 -> result();
}
public function select_sub_leadsource($id=null)
{
	
	$this -> db -> select('l.sub_lead_source_id,l.lead_source_name ,l.sub_lead_source_name,l.sub_lead_source_status,p.process_name,l.sub_lead_source_status');
		$this -> db -> from('sub_lead_source l');
		$this->db->join('tbl_process p','p.process_id=l.process_id','left');
		//$this -> db -> where('sub_lead_source_status!=', 'Deactive');
		$this -> db -> where('p.process_id',$_SESSION['process_id']);
		if($id!=''){
		$this -> db -> where('l.sub_lead_source_id',$id);	
		}
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
}
public function insert_sub_lead_source()
{
		$lead_source_name=$this->input->post('lead_source_name');
		$sub_lead_source=$this->input->post('sub_lead_source');
		$process_id=$this->input->post('process_id');
	
		$q = $this -> db -> query('select * from sub_lead_source where lead_source_name="' . $lead_source_name . '" and process_id="'. $process_id .'"and sub_lead_source_name="'. $sub_lead_source .'" and sub_lead_source_status="Active"') -> result();
		//echo $this->db->last_query();	
		//print_r($q);

		if (count($q) > 0) {

			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Sub Lead Source Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {
	$q1 = $this -> db -> query("select * from sub_lead_source where lead_source_name='$lead_source_name' and process_id='$process_id'and sub_lead_source_name='$sub_lead_source' and sub_lead_source_status='Deactive'") -> result();
	//echo $this->db->last_query();
	if (count($q1) > 0) {
		
		$this->db->query("update sub_lead_source set sub_lead_source_status='Active' where lead_source_name='$lead_source_name' and process_id='$process_id' and sub_lead_source_name='$sub_lead_source'");
		$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Sub Lead Source Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			
	}else{
	
		$insert=$this->db->query("INSERT INTO `sub_lead_source`( `lead_source_name`, `sub_lead_source_name`, `process_id`, `sub_lead_source_status`) 
			VALUES ('$lead_source_name','$sub_lead_source','$process_id','Active')");
	
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Sub Lead Source Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
		
	}
			
		}
	
}
public function edit_new_sub_lead_source()
{
		$lead_source_name=$this->input->post('lead_source_name');
		$sub_lead_source=$this->input->post('sub_lead_source');
		$process_id=$this->input->post('process_id');
		$sub_lead_source_id=$this->input->post('sub_lead_source_id');
	
		$q = $this -> db -> query('select * from sub_lead_source where lead_source_name="' . $lead_source_name . '" and process_id="'. $process_id .'"and sub_lead_source_name="'. $sub_lead_source .'" and sub_lead_source_status="Active"') -> result();
		//echo $this->db->last_query();	
		//print_r($q);

		if (count($q) > 0) {

			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Sub Lead Source Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {

			$insert=$this->db->query("UPDATE `sub_lead_source` SET `lead_source_name`='$lead_source_name',`sub_lead_source_name`='$sub_lead_source',`process_id`='$process_id',`sub_lead_source_status`='Active' WHERE sub_lead_source_id='$sub_lead_source_id'");
	
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Sub Lead Source Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}
}
public function delete_sub_lead_source($id)
{
		$insert=$this->db->query("UPDATE `sub_lead_source` SET `sub_lead_source_status`='Deactive' WHERE sub_lead_source_id='$id'");
	//echo $this->db->last_query();	
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Sub Lead Source Delete Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
	
}

}
