<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Link_process_location_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> process_id = $_SESSION['process_id'];
	}

public function select_process(){
	$this->db->select('process_id,process_name');
	$this->db->from('tbl_process');
	$query=$this->db->get();
	return $query->result();
}
public function select_location(){
	$this->db->select('location_id,location');
	$this->db->from('tbl_location');
	$this -> db -> where('location_status!=','Deactive');
	$query=$this->db->get();
	return $query->result();
}
public function select_table($map_id){
	//echo $map_id=$this->input->get('map_id');
	$this->db->select('m.map_id,m.process_id,m.gm_email,m.sm_email,m.location_id,p.process_name,l.location,m.status');
	$this->db->from('tbl_map_process m');
	$this->db->join('tbl_process p','p.process_id=m.process_id');
	$this->db->join('tbl_location l','l.location_id=m.location_id');
	if($map_id!=''){
		$this->db->where('map_id',$map_id);
	}
	$this->db->where('m.process_id',$this->process_id);
	//$this->db->where('status',1);
	$query=$this->db->get();
	//echo $this->db->last_query();
	return $query->result();
}


public function insert_link_process_location(){
	$process_id=$this->input->post('process_id');
	$location_id=$this->input->post('location_id');
	$gm_email=$this->input->post('gm_email');
	$sm_email=$this->input->post('sm_email');
	$date=date('Y-m-d');
	$user_id=$_SESSION['user_id'];
	$this->db->select('map_id');
	$this->db->from('tbl_map_process');
	$this->db->where('process_id',$process_id);
	$this->db->where('location_id',$location_id);
	$this->db->where('status',1);
	$query=$this->db->get()->result();
	if(count($query)>0){
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Location Already Mapped to this Process ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

	}else{
	$query=$this->db->query("INSERT INTO `tbl_map_process`(`process_id`, `location_id`,`status`,`sm_email`,`gm_email`,`updated_date`,`updated_by_id`) VALUES ('$process_id','$location_id','1','$sm_email','$gm_email','$date','$user_id')");
		$getAdminProcessquery=$this->db->query("select tbl_id from tbl_manager_process where process_id='$process_id' and location_id='$location_id' and user_id='1' and status!='-1'")->result();
		if(count($getAdminProcessquery)>0){
			
		}else{
			$this->db->query("INSERT INTO tbl_manager_process(`location_id`,`process_id`,`user_id`,`status`,`updated_date`,`updated_by_id`) values('$location_id','$process_id','1','1','$date','$user_id')");
		}
		
	$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Location Mapped Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

	}
	}
	public function edit_link_process_location($map_id){
		$date=date('Y-m-d');
	$user_id=$_SESSION['user_id'];
	$process_id=$this->input->post('process_id');
	$location_id=$this->input->post('location_id');
	$gm_email=$this->input->post('gm_email');
	$sm_email=$this->input->post('sm_email');
	$map_id=$this->input->post('map_id');
	$this->db->select('map_id');
	$this->db->from('tbl_map_process');
	$this->db->where('process_id',$process_id);
	$this->db->where('location_id',$location_id);
	$this->db->where('gm_email',$gm_email);
	$this->db->where('sm_email',$sm_email);
	$this->db->where('status',1);
	$query=$this->db->get()->result();
	if(count($query)>0){
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Location Already Mapped to this Process ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

	}else{
	$query=$this->db->query("UPDATE `tbl_map_process` SET `process_id`='$process_id',`location_id`='$location_id',`updated_date`='$date',`gm_email`='$gm_email',`sm_email`='$sm_email',`updated_by_id`='$updated_by_id',`status`='1' WHERE map_id='$map_id'");
	$getAdminProcessquery=$this->db->query("select tbl_id from tbl_manager_process where process_id='$process_id' and location_id='$location_id' and user_id='1' and status!='-1'")->result();
		if(count($getAdminProcessquery)>0){
			
		}else{
			$this->db->query("INSERT INTO tbl_manager_process(`location_id`,`process_id`,`user_id`,`status`,`updated_date`,`updated_by_id`) values('$location_id','$process_id','1','1','$date','$user_id')");
		}
	$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Location Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

	}
	}
	public function delete_link_process_location($map_id){
		$date=date('Y-m-d');
		$user_id=$_SESSION['user_id'];
	$query=$this->db->query("UPDATE `tbl_map_process` SET `status`='-1',`updated_date`='$date',`updated_by_id`='$user_id' WHERE map_id='$map_id'");
	if($this->db->affected_rows())
	{
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Mapped Location Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

	}else{
		$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>   Mapped Location Not Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

	}
	}
	
}
?>
