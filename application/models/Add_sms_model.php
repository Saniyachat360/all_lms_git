<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class add_sms_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function select_feedback_status() {

		$this -> db -> select('feedbackStatusName,feedbackStatusId');
		$this -> db -> from('tbl_feedback_status');
		$this -> db -> where('process_id',$_SESSION['process_id']);
		$query = $this -> db -> get();
		return $query -> result();

	}
	
	
	public function select_next_action($feedback_status) {

		$this -> db -> select('nextActionName');
		$this -> db -> from('tbl_mapNextAction');
		$this -> db -> where('feedbackStatusName',$feedback_status);
		$this -> db -> where('process_id',$_SESSION['process_id']);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function add_sms($next_action,$sms,$feedback_status) {
		
			$next_action_count = count($next_action);
			
		for ($i = 0; $i < $next_action_count; $i++) {
		
		$this->db->select('nextActionName,sms');
		$this->db->from('tbl_sms');
		$this->db->where('nextActionName',$next_action[$i]);
		$this->db->where('feedBackStatus',$feedback_status);
		$this->db->where('sms',$sms);
		$this->db->where('status','1');
		$query1=$this->db->get()->result();
	}
		$count=count($query1);
		//echo $count;

		if($count > 0)
		{
		$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> SMS Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
		}
		else
		{
			
		$next_action_count = count($next_action);
			$process_id=$_SESSION['process_id'];
		for ($i = 0; $i < $next_action_count; $i++) {
			
	$query=$this->db->query("insert into tbl_sms(`feedBackStatus`,`nextActionName`,`sms`,`process_id`,`status`)values('$feedback_status','$next_action[$i]','$sms','$process_id','1')");
	$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> SMS Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');	
		}
	}
	}
	
		public function edit_sms($id)
	{
		$this->db->select('s.sms,s.sms_id,s.feedBackStatus,s.nextActionName');
		$this->db->from('tbl_sms s');
		$this->db->where('s.sms_id', $id);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	
	}
	
		public function update_sms($sms_id,$next_action,$feedback_status,$sms)
	{
		
		
		$this->db->select('sms_id');
		$this->db->from('tbl_sms');
		$this->db->where('nextActionName',$next_action);
		$this->db->where('feedBackStatus',$feedback_status);
		$this->db->where('sms',$sms);
		$this->db->where('status','1');
		$query1=$this->db->get()->result();
		$process_id=$_SESSION['process_id'];
		$count=count($query1);
		
		if (count($query1) > 0)
		{
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> SMS Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
		}
		else{
			
		$this -> db -> query('update tbl_sms set feedBackStatus="' . $feedback_status . '" ,nextActionName="' . $next_action . '",process_id="' . $process_id . '", sms="' . $sms . '" where sms_id="' . $sms_id . '"');
		if ($this -> db -> affected_rows() > 0) {

				$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> SMS Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			} else {
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> SMS Not Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			}
		}
		
	}
		public function del_sms($sms_id)
	{
		
		
		$this -> db -> query("update tbl_sms set status='-1' where sms_id='$sms_id'");
		
		if ($this -> db -> affected_rows() > 0) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> SMS Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		} else {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> SMS Not Deleted Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}
		
		
	
	}
	public function select_table() {

	$this->db->select('s.sms,s.sms_id,s.nextActionName,s.feedBackStatus');
	$this->db->from('tbl_sms s');
	$this->db->where('status','1');
	$this->db->where('process_id',$_SESSION['process_id']);
	//$this->db->join('tbl_disposition_status d','d.disposition_id = s.disposition_id');
	$query=$this->db->get();
	return $query->result();
	
	}
	
}
