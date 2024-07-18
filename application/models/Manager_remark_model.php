<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class manager_remark_model extends CI_model {
	function __construct() {
		parent::__construct();
		$this -> process_name = $this -> session -> userdata('process_name');
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');
		$this -> process_id = $_SESSION['process_id'];
		if ($this -> process_id == 6 || $this -> process_id == 7 || $this->process_id==9) {
			$this -> table_name = 'lead_master l';
			$this -> table_name4 = 'lead_master';
			$this -> table_name1 = 'lead_followup f';
			$this -> table_name2 = 'tbl_manager_remark r';
			$this -> table_name3 = 'tbl_manager_remark';
		} else if( $this->process_id==8 ){
			$this -> table_name = 'lead_master_evaluation l';
			$this -> table_name4 = 'lead_master_evaluation';
			$this -> table_name1 = 'lead_followup_evaluation f';
			$this -> table_name2 = 'tbl_manager_remark_evaluation r';
			$this -> table_name3 = 'tbl_manager_remark_evaluation';
		}
		else{
			$this -> table_name = 'lead_master_all l';
			$this -> table_name4 = 'lead_master_all';
			$this -> table_name1 = 'lead_followup_all f';
			$this -> table_name2 = 'tbl_manager_remark_all r';
			$this -> table_name3 = 'tbl_manager_remark_all';
		}
	}

	public function select_lead($id) {

		$this -> db -> select('name,contact_no');
		if($_SESSION['process_id']==9){
			$this -> db -> from('lead_master_complaint');
			$this -> db -> where('complaint_id', $id);
		}else{
				$this -> db -> from($this -> table_name4);
				$this -> db -> where('enq_id', $id);
		}
	
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function select_remark($id) {

		$this -> db -> select('r.remark_id,r.lead_id,r.user_id,r.followup_pending,r.call_received,r.fake_updation,r.service_feedback,r.remark,r.created_date,u.fname,u.lname');
		$this -> db -> from($this -> table_name2);
		$this -> db -> join('lmsuser u', 'u.id=r.user_id');
			if($_SESSION['process_id']==9){
					$this -> db -> where('complaint_id', $id);
			}else{
					$this -> db -> where('lead_id', $id);
			}
	
		$this -> db -> order_by('remark_id', 'desc');
		$query = $this -> db -> get();
		return $query -> result();
	}

	public function followup_detail($id) {
		//Get user All Followup Details
		$this -> db -> select('u.fname,u.lname,
		
		l.location,l.created_date as lead_date,f.feedbackStatus,f.nextAction,
		f.assign_to,f.date as call_date,f.comment,f.nextfollowupdate ');
	
			if($_SESSION['process_id']==9){
		$this -> db -> from('lead_master_complaint l');
		$this -> db -> join('lead_followup_complaint f', 'f.complaint_id=l.complaint_id');
		$this -> db -> join('lmsuser u', 'u.id=f.assign_to', 'left');

		$this -> db -> where('f.complaint_id', $id);
		}else{
		$this -> db -> from($this -> table_name);
		$this -> db -> join($this -> table_name1, 'f.leadid=l.enq_id');
		$this -> db -> join('make_models m', 'm.model_id=l.model_id', 'left');
		$this -> db -> join('lmsuser u', 'u.id=f.assign_to', 'left');

		$this -> db -> where('f.leadid', $id);
		}
		$this -> db -> order_by('f.id', 'desc');
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function insert_remark() {
		$today = date("Y-m-d");
		$time = date("H:i:s A");
		$assign = $this -> user_id;
		$followup_pending = $this -> input -> post('followup_pending');
		$call_received = $this -> input -> post('call_received');
		$fake_updation = $this -> input -> post('fake_updation');
		$service_feedback = $this -> input -> post('service_feedback');
		$comment = $this -> input -> post('comment');
		$enq_id = $this -> input -> post('booking_id');
		if($_SESSION['process_id']==9){
			$insert = $this -> db -> query("INSERT INTO tbl_manager_remark(`complaint_id`, `user_id`, `followup_pending`, `call_received`, `fake_updation`, `service_feedback`, `remark`, `created_date`, `created_time`)VALUES ('$enq_id','$assign','$followup_pending','$call_received','$fake_updation','$service_feedback','$comment','$today','$time')") or die(mysql_error());
		$insert_id = $this -> db -> insert_id();
		$update = $this -> db -> query("update lead_master_complaint set auditor_user_id='$assign',remark_id='$insert_id' where complaint_id='$enq_id'") or die(mysql_error());
			
		}else{
		$insert = $this -> db -> query("INSERT INTO ".$this -> table_name3."(`lead_id`, `user_id`, `followup_pending`, `call_received`, `fake_updation`, `service_feedback`, `remark`, `created_date`, `created_time`)VALUES ('$enq_id','$assign','$followup_pending','$call_received','$fake_updation','$service_feedback','$comment','$today','$time')") or die(mysql_error());
		$insert_id = $this -> db -> insert_id();
		$update = $this -> db -> query("update ".$this -> table_name4." set auditor_user_id='$assign',remark_id='$insert_id' where enq_id='$enq_id'") or die(mysql_error());
			
		}
	}

}
?>