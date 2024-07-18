<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Assign_cse_transfer_model extends CI_model {
	function __construct() {
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->today = date('Y-m-d');
		$this->time=date("h:i:s A");
		$this -> process_id = $_SESSION['process_id'];
		$this -> process_name = $_SESSION['process_name'];
		$this -> location_id = $_SESSION['location_id'];
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');
		$this -> executive_array = array("4", "8", "10", "12", "14", "16");
		$this -> all_array = array("1","2", "3", "8", "7", "9", "11", "13", "10", "12", "14");
		$this -> tl_array = array("2", "5", "7", "9", "11", "13", "15");
		$this -> tl_list = '("2","5", "7", "9", "11", "13", "15")';
		//$this->tl_list=""
		if ($this -> process_id == 6 || $this -> process_id == 7 || $this -> process_id == 8) {
			$this -> table_name = 'lead_master';
				$this -> table_name2 = 'lead_followup';
			$this -> table_name1 = 'request_to_lead_transfer';
		} else {
			$this -> table_name = 'lead_master_all';
			$this -> table_name2 = 'lead_followup_all';
			
			$this -> table_name1 = 'request_to_lead_transfer_all';
		}
	}
/*************************** From User *************************************/
	function select_fromuser() {
		// $location = $this -> input -> post('location');
		
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser l');
		$this -> db -> join('tbl_manager_process u', 'u.user_id=l.id');
		$this -> db -> join('tbl_rights r', 'r.user_id=l.id');
		$this -> db -> where('r.form_name', 'Calling Notification');
		$this -> db -> where('r.view', '1');
		$this -> db -> where('l.status', '1');
		$this -> db -> where('role !=', '1');
		$this -> db -> where('u.process_id', $this -> process_id);
		$this -> db -> where('u.location_id', 38);
		$executive_array = array("4","3","8", "10", "12", "14", "16");
		if(in_array($_SESSION['role'], $executive_array))
		{
			$this->db->where('l.id',$this->user_id);
		}
		$this -> db -> group_by("l.id");
		$this -> db -> order_by("fname", "asc");
		$query = $this -> db -> get();
			//echo $this -> db -> last_query();
		return $query -> result();

	}
	/******************************************************************/
	/************* To Location and To User ************************************/
	function to_location() {
		$lead_send_from=$this->input->post('lead_send_from');
		$this -> db -> select('l.*');
		$this -> db -> from('tbl_location l');
		$this->db->join('tbl_map_process p','p.location_id=l.location_id');
		$this->db->where('process_id',$this->process_id);
		$this->db->where('p.status !=','-1');
		if($lead_send_from !='')
		{
			if($lead_send_from=='showroom_sent')
			{
				$this->db->where('l.location_id','38');
			}
		}
		$this->db->where('l.location_status !=','Deactive');
		$this->db->order_by('l.location','asc');
		$query = $this -> db -> get();
			//echo $this->db->last_query();
		return $query -> result();

	}


	function select_touser() {
		$toLocation = $this -> input -> post('toLocation');
		$fromUser = $this -> input -> post('fromUser');
		$get_role = $this -> db -> query("select role from lmsuser where id='$fromUser'") -> result();
		 $from_user_role = $get_role[0] -> role;

		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser l');
		$this -> db -> join('tbl_manager_process u', 'u.user_id=l.id');
		$this -> db -> join('tbl_rights r', 'r.user_id=l.id');
		$this -> db -> where('r.form_name', 'Calling Notification');
		$this -> db -> where('r.view', '1');
		/*if($from_user_role==3)*/
	
			$tl_array = array("2", "3", "5", "7", "9", "11", "13","15");
			$this -> db -> where_in('role', $tl_array);
			//$k="(role=3 or role IN ('2','5', '7', '9', '11', '13'))";
			//$this -> db -> where($k);
		
		//$this -> db -> where_in('role',$this->tl_array);
		$this -> db -> where('l.status', '1');
		$this -> db -> where('role !=', '1');
		$this->db->where('l.id !=',$fromUser);
		$this -> db -> where('u.process_id', $this -> process_id);
		$this -> db -> where('u.location_id', $toLocation);
		$this -> db -> group_by("l.id");
		$this -> db -> order_by("fname", "asc");
		$query = $this -> db -> get();
		//echo $this -> db -> last_query();
		return $query -> result();

	}
/**********************************************************************/
/************************ Get Source Count and Name****************************/
	function all_count_admin() {
		$assign_to = $this -> input -> post('fromUser');
		$lead_send_from=$this->input->post('lead_send_from');
		if ($assign_to == '') {
			$assign_to = $this -> user_id;
			$role = $this -> role;
		} else {
			$checkRole = $this -> db -> query("select role from lmsuser where id='$assign_to'") -> result();
			$role = $checkRole[0] -> role;
		}

		/*if ($role == 5) {
			$assign = "assign_to_dse_tl=" . $assign_to . " and (assign_to_dse='' || assign_to_dse=" . $assign_to . ")";
		} elseif ($role == 4) {
			$assign = "assign_to_dse=" . $assign_to;
		} 
		elseif ($role == 15) {
			$assign = "assign_to_e_tl=" . $assign_to . " and (assign_to_e_exe='' || assign_to_e_exe=" . $assign_to . ")";
		} elseif ($role == 16) {
			$assign = "assign_to_e_exe=" . $assign_to;
		}
		else*/
		

		$this -> db -> select('count(enq_id)as acount');
		$this -> db -> from($this -> table_name);
		
		//$this -> db -> where($nextaction);
		if($this->process_id==8)
		{
			$this -> db -> where('evaluation','Yes');	
			if (in_array($role, $this -> all_array)) {
			if($lead_send_from=='showroom_sent')
			{
				$assign = "assign_to_cse=" . $assign_to . " and assign_to_e_tl!=0";
			}else
				{
					$assign = "assign_to_cse=" . $assign_to . " and assign_to_e_tl=0";
				}
			
			}
		}
		else {
			$this -> db -> where('process', $this->process_name);	
			if (in_array($role, $this -> all_array)) {
			if($lead_send_from=='showroom_sent')
			{
				$assign = "assign_to_cse=" . $assign_to . " and assign_to_dse_tl!=0";
			}else
				{
					$assign = "assign_to_cse=" . $assign_to . " and assign_to_dse_tl=0";
				}
			
		}			
			
		}
		$this -> db -> where($assign);
		$this -> db -> where('nextAction!=', 'Booked From Autovista');
		$this -> db -> where('nextAction!=', 'Close');
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		//$query=$this->db->query("select count(enq_id) as acount from lead_master where '$assign' and ('$nextaction') ");
		return $query -> result();

	}
	function campaign_name() {
		$assign_to = $this -> input -> post('fromUser');
			$lead_send_from=$this->input->post('lead_send_from');
		if ($assign_to == '') {
			$assign_to = $this -> user_id;
			$role = $this -> role;
		} else {
			$checkRole = $this -> db -> query("select role from lmsuser where id='$assign_to'") -> result();
			$role = $checkRole[0] -> role;
		}

		/*if ($role == 5) {
			$assign = "assign_to_dse_tl=" . $assign_to . " and (assign_to_dse='' || assign_to_dse=" . $assign_to . ")";
		} elseif ($role == 4) {
			$assign = "assign_to_dse=" . $assign_to;
		} elseif (in_array($role, $this -> all_array)) {
			$assign = "assign_to_cse=" . $assign_to . " and assign_to_dse_tl=0";
		}
		elseif ($role == 15) {
			$assign = "assign_to_e_tl=" . $assign_to . " and (assign_to_e_exe='' || assign_to_e_exe=" . $assign_to . ")";
		} elseif ($role == 16) {
			$assign = "assign_to_e_exe=" . $assign_to;
		}
		else*/
		
		
		
		$this -> db -> select('lead_source,enquiry_for,count(lead_source) as wcount');
		$this -> db -> from($this -> table_name);
		if($this->process_id==8)
		{
			$this -> db -> where('evaluation','Yes');
			if (in_array($role, $this -> all_array)) {
			if($lead_send_from=='showroom_sent')
			{
				$assign = "assign_to_cse=" . $assign_to . " and assign_to_e_tl!=0";
			}else
				{
					$assign = "assign_to_cse=" . $assign_to . " and assign_to_e_tl=0";
				}
		}	
		}
		else {
			
			$this -> db -> where('process', $this->process_name);
			if (in_array($role, $this -> all_array)) {
			if($lead_send_from=='showroom_sent')
			{
				$assign = "assign_to_cse=" . $assign_to . " and assign_to_dse_tl!=0";
			}else
				{
					$assign = "assign_to_cse=" . $assign_to . " and assign_to_dse_tl=0";
				}
		}
		}
		$this -> db -> where($assign);
		//$this -> db -> where($nextaction);
		
		$this -> db -> where('nextAction!=', 'Close');
			$this -> db -> where('nextAction!=', 'Booked From Autovista');
		
		$this -> db -> group_by('lead_source');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
/************************************************************/
/********************* Status Wise Leads **********************/
function new_lead_counts() {
		$today=date('Y-m-d');
		$assign_to = $this -> input -> post('fromUser');
		$lead_send_from=$this->input->post('lead_send_from');
		if ($assign_to == '') {
			$assign_to = $this -> user_id;
			$role = $this -> role;
		} else {
			$checkRole = $this -> db -> query("select role from lmsuser where id='$assign_to'") -> result();
			$role = $checkRole[0] -> role;
		}
		
		
		$this -> db -> select('count(enq_id) as count_lead');
		$this -> db -> from($this -> table_name . ' l');
		if($this->process_id==8)
		{			
			$this -> db -> where('l.evaluation', 'Yes');
			if ($role == '3' || $role=='2' || $role=='1') 
			{
				if($lead_send_from=='showroom_sent')
				{
					$this -> db -> where('l.assign_to_e_tl !=', 0);						
				}
				else
				{
					$this -> db -> where('l.assign_to_e_tl', 0);
				}
			}
		}
		else 
		{
			$this -> db -> where('l.process', $this -> process_name);
			if ($role == '3' || $role=='2' || $role=='1') 
			{
				if($lead_send_from=='showroom_sent')
				{
					$this -> db -> where('l.assign_to_dse_tl !=', 0);						
				}
				else
				{
					$this -> db -> where('l.assign_to_dse_tl', 0);
				}
			}
		}
		if ($role == '3' || $role=='2' || $role=='1') 
		{
			$this -> db -> where('l.cse_followup_id', 0);
			$this -> db -> where('l.assign_to_cse', $assign_to);
			$this -> db -> where('l.assign_to_cse_date', $today);
					
		}
		$this -> db -> where('l.nextAction!=', "Close");
		$this -> db -> where('nextAction!=', 'Booked From Autovista');
		//DSE TL and DSE
		/*if ($role == '5' || $role == '4') {
			$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse',$assign_to);
			$this -> db -> where('l.assign_to_dse_date', $today);
        }
		
		//If role Evaluation TL and Evaluator
		else if ($role == '15' || $role == '16') {
			$this -> db -> where('l.exe_followup_id', 0);
			$this -> db -> where('l.assign_to_e_exe',$assign_to);
			$this -> db -> where('l.assign_to_e_exe_date', $today);
        }
		//If role CSE TL and CSE
		else
		*/
	
		$this -> db -> order_by('l.enq_id', 'desc');
	
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function today_followup_lead_counts() {
		//Today followup Leads
		$today = date('Y-m-d');
		
		$assign_to = $this -> input -> post('fromUser');
		$lead_send_from=$this->input->post('lead_send_from');
		// Get From user Role using id
		if ($assign_to == '') {
			$assign_to = $this -> user_id;
			$role = $this -> role;
		} else {
			$checkRole = $this -> db -> query("select role from lmsuser where id='$assign_to'") -> result();
			$role = $checkRole[0] -> role;
		}
		
		
		$nextfollowupdate = ("lf.nextfollowupdate = '$today'" or "lf.nextfollowupdate = '$day'");
		
		$this -> db -> select('count( distinct enq_id) as count_lead');
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name2 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		
		if($this->process_id==8)
		{
			$this -> db -> join($this -> table_name2 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		
			$this -> db -> where('l.evaluation', 'Yes');
			if ($role == '3' || $role=='2' || $role=='1') 
			{
				if($lead_send_from=='showroom_sent')
				{
					$this -> db -> where('l.assign_to_e_tl !=', 0);						
				}
				else
				{
					$this -> db -> where('l.assign_to_e_tl', 0);
				}
			}
		}
		else {
			$this -> db -> join($this -> table_name2 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		
			$this -> db -> where('l.process', $this -> process_name);
			if ($role == '3' || $role=='2' || $role=='1') 
			{
				if($lead_send_from=='showroom_sent')
				{
					$this -> db -> where('l.assign_to_dse_tl !=', 0);						
				}
				else
				{
					$this -> db -> where('l.assign_to_dse_tl', 0);
				}
			}
		}
		
		//If role DSE TL and Dashboard id blank(for calling task)
		/*if ($role == '5' || $role=='4') {
			//$this -> db -> join($this->table_name1.' f','f.id=ln.dse_followup_id');
			$this -> db -> where('l.assign_to_dse',$assign_to);
				$this -> db -> where('f2.nextfollowupdate', $today);
		}
		
		//If role DSE TL and Dashboard id blank(for calling task)
		elseif ($role == '15' || $role == '16') {
			$this -> db -> where('l.assign_to_e_tl!=',0);
			$this -> db -> where('l.assign_to_e_exe',$assign_to);
			$this -> db -> where('f2.nextfollowupdate', $today);
		}
		
		//If role is all Excecutive and dashboard id is blank(for calling task)
		else*/
		if ($role == '3' || $role == '2' || $role == '1') {
			
			$this -> db -> where('l.assign_to_cse',$assign_to);
		//	$this -> db -> where('l.assign_to_dse_tl',0);
			$this -> db -> where('f1.nextfollowupdate', $today);
		}
	
	
		$this -> db -> where('l.nextAction!=', "Close");
		$this -> db -> where('l.nextAction!=', 'Booked From Autovista');
		
		$query = $this -> db -> get();
	//	echo $this->db->last_query();
		return $query -> result();



	}
 public function pending_new_lead_counts()
{
		
		// Get From user Id
		$assign_to = $this -> input -> post('fromUser');
		$lead_send_from=$this->input->post('lead_send_from');
		// Get From user Role using id
		if ($assign_to == '') {
			$assign_to = $this -> user_id;
			$role = $this -> role;
		} else {
			$checkRole = $this -> db -> query("select role from lmsuser where id='$assign_to'") -> result();
			$role = $checkRole[0] -> role;
		}
		
		$this -> db -> select('count(distinct enq_id) as count_lead');
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name2 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		
		if($this->process_id==8)
		{
			$this -> db -> join($this -> table_name2 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		
			$this -> db -> where('l.evaluation', 'Yes');
			if ($role == '3' || $role=='2' || $role=='1') 
			{
				if($lead_send_from=='showroom_sent')
				{
					$this -> db -> where('l.assign_to_e_tl !=', 0);						
				}
				else
				{
					$this -> db -> where('l.assign_to_e_tl', 0);
				}
			}
		}
		else {
			$this -> db -> join($this -> table_name2 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		
			$this -> db -> where('l.process', $this -> process_name);
			if ($role == '3' || $role=='2' || $role=='1') 
			{
				if($lead_send_from=='showroom_sent')
				{
					$this -> db -> where('l.assign_to_dse_tl !=', 0);						
				}
				else
				{
					$this -> db -> where('l.assign_to_dse_tl', 0);
				}
			}
		}

		/*if ($role == 4 || $role == 5) {
			$this -> db -> where('l.dse_followup_id= ', '0');
			$this -> db -> where('l.assign_to_dse_tl!=', 0);
			$this -> db -> where('l.assign_to_dse_date <', $this -> today);
			$this -> db -> where('l.assign_to_dse_date!=', '0000-00-00');
			$this -> db -> where('l.assign_to_dse', $assign_to);
			//$this -> db -> group_by('l.enq_id');
		}
		elseif ($role == '16' || $role == '15') {
			$this -> db -> where('l.exe_followup_id= ', '0');
			$this -> db -> where('l.assign_to_e_tl!=', 0);
			$this -> db -> where('l. assign_to_e_exe_date   <', $this -> today);
			$this -> db -> where('l. assign_to_e_exe_date  !=', '0000-00-00');
			$this -> db -> where('assign_to_e_exe', $assign_to);
			//$this -> db -> group_by('l.enq_id');
		}else
		 * */if ($role == '2' || $role == '3' || $role == '1') {
			$this -> db -> where('l.cse_followup_id', 0);
			$this -> db -> where("l.assign_to_cse=", $assign_to);			
			
			$this -> db -> where('l.assign_to_cse_date < ', $this -> today);
			$this -> db -> where('l.assign_to_cse_date!=', '0000-00-00');
			//$this -> db -> group_by('l.enq_id');
		}
		$query = $this -> db -> get();
		//echo $this -> db -> last_query();
		return $query -> result();
	
}
 public function pending_followup_lead_counts()
{
		// Get From user Id
		$assign_to = $this -> input -> post('fromUser');
		$lead_send_from=$this->input->post('lead_send_from');
		// Get From user Role using id
		if ($assign_to == '') {
			$assign_to = $this -> user_id;
			$role = $this -> role;
		} else {
			$checkRole = $this -> db -> query("select role from lmsuser where id='$assign_to'") -> result();
			$role = $checkRole[0] -> role;
		}
		$this -> db -> select('count(distinct enq_id) as count_lead');
	
			$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name2 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		
		if($this->process_id==8)
		{
			$this -> db -> join($this -> table_name2 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		
			$this -> db -> where('l.evaluation', 'Yes');
			if ($role == '3' || $role=='2' || $role=='1') 
			{
				if($lead_send_from=='showroom_sent')
				{
					$this -> db -> where('l.assign_to_e_tl !=', 0);						
				}
				else
				{
					$this -> db -> where('l.assign_to_e_tl', 0);
				}
			}
		}
		else {
			$this -> db -> join($this -> table_name2 . ' f2', 'f2.id=l.dse_followup_id', 'left');
			
			$this -> db -> where('l.process', $this -> process_name);
			if ($role == '3' || $role=='2' || $role=='1') 
			{
				if($lead_send_from=='showroom_sent')
				{
					$this -> db -> where('l.assign_to_dse_tl !=', 0);						
				}
				else
				{
					$this -> db -> where('l.assign_to_dse_tl', 0);
				}
			}
		}

		$this -> db -> where('l.nextAction!=', "Close");
		/*if ($role == 4 || $role == 5) {
			//$dse_id = $_SESSION['user_id'];
			$this -> db -> where("l.assign_to_dse=", $assign_to);
			$this -> db -> where("f2.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f2.nextfollowupdate <", $this -> today);
			
		} 
		elseif ($role == 15 || $role== 16) {
			$this -> db -> where('assign_to_e_exe', $assign_to);
			$this -> db -> where("f2.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f2.nextfollowupdate <", $this -> today);
			//$this -> db -> group_by('f2.leadid');
			
		}else*/if ($role == 2 || $role== 3 || $role== 1) {

			$this -> db -> where("l.assign_to_cse=", $assign_to);
			//$this -> db -> where("l.assign_to_dse_tl=", 0);
			$this -> db -> where("f1.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f1.nextfollowupdate <", $this -> today);
			
		} 
		
		$this -> db -> order_by('l.enq_id', 'desc');
	
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	
}
/**********************************************************************************/


/************************** Assign Source Wise Lead *********************/
	function assign_data_source() {

		echo $assign_by = $this -> input -> post('fromUser');
		//$today = date('Y-m-d');
		//$time = date("H:i:s A");
		$lead_send_from=$this->input->post('lead_send_from');
		$cse_name = $this -> input -> post('cse_name');
		$cse_count = count($cse_name);
		$web_lead_name = $this -> input -> post('leads1');
		$lead_send = $this -> input -> post('lead_send');
		if (isset($web_lead_name)) {

			if ($this -> input -> post('lead_count1') == '') {
				$lead_count = $this -> input -> post('web_count');
				//$web_lead_count = $this -> input -> post('web_count');

			} else {
				//echo"<br>";
				$lead_count = $this -> input -> post('lead_count1');
				///$web_lead_count = $this -> input -> post('lead_count1');
				//echo"<br>";
			}

		} else {
			$lead_count = '';
		}
		if ($web_lead_name == 'Web') {

			$web_lead_name = '';
		}

		$assign_count = $lead_count % $cse_count;
		if ($assign_count == 0)//check remainder
		{
			$assign_count1 = $lead_count / $cse_count;
			$assign_count_reminder = $assign_count1;
		} else {
			$lead_count = $lead_count - $assign_count;
			$assign_count1 = $lead_count / $cse_count;
			$assign_count_reminder = $assign_count1 + $assign_count;
		}
		if ($lead_count != '') {
			$checkRole = $this -> db -> query("select role from lmsuser where id='$assign_by' ") -> result();
			$assignByRole = $checkRole['0'] -> role;
			
			for ($i = 0; $i < $cse_count; $i++) {
				$assign_to=$cse_name[$i];
				$assign = "assign_to_cse=" . $assign_by . " and assign_to_dse_tl=0";

				/*if ($assignByRole == 5) {
					$assign = "assign_to_dse_tl=" . $assign_by . " and (assign_to_dse='' || assign_to_dse=" . $assign_by . ")";
				} elseif ($assignByRole == 4) {
					$assign = "assign_to_dse=" . $assign_by;
				}
				elseif ($assignByRole == 15) {
					$assign = "assign_to_e_tl=" . $assign_by . " and (assign_to_e_exe='' || assign_to_e_exe=" . $assign_by . ")";
				} elseif ($assignByRole == 16) {
					$assign = "assign_to_e_exe=" . $assign_by;
				}
				 else*/
				 
				 
				
				$this -> db -> select('enq_id');
				$this -> db -> from($this -> table_name);
				
				$this -> db -> where('lead_source', $web_lead_name);
				
					$this -> db -> where('nextAction!=', 'Close');
				$this -> db -> where('nextAction!=', 'Booked From Autovista');
				if($this->process_id==8)
				{
					$this -> db -> where('evaluation', 'Yes');
					if (in_array($assignByRole, $this -> all_array)) {
				 	if($lead_send_from=='showroom_sent')
					{
						$assign = "assign_to_cse=" . $assign_by . " and assign_to_e_tl!=0";
					}else
						{
							$assign = "assign_to_cse=" . $assign_by . " and assign_to_e_tl=0";
						}
				}
				}
				else
					{
						
				$this -> db -> where('process', $this->process_name);
				if (in_array($assignByRole, $this -> all_array)) {
				 	if($lead_send_from=='showroom_sent')
					{
						$assign = "assign_to_cse=" . $assign_by . " and assign_to_dse_tl!=0";
					}else
						{
							$assign = "assign_to_cse=" . $assign_by . " and assign_to_dse_tl=0";
						}
				}
					}
					$this -> db -> where($assign);
				if ($i == 0) {
					$this -> db -> limit($assign_count_reminder);
				} else {
					$this -> db -> limit( $assign_count1);
				}
				$query = $this -> db -> get() -> result();
			

				foreach ($query as $row) {
					 $enq_id = $row -> enq_id;
					//echo "<br>";
					$insertQuery = $this -> db -> query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $assign_to . '","' . $assign_by . '","' . $this->today . '","' . $this->time . '","Transfered")');
					//echo $this->db->last_query();
					$transfer_id = $this -> db -> insert_id();
					$selectRole = $this -> db -> query("select role from lmsuser where id='$assign_to'") -> result();
					//	print_r($selectRole);
					 $assignToRole = $selectRole[0] -> role;
					
					$assignByCSETL = '';
					$assignByCSE = '';
					$assignToCSE = '';
					$assignToCSEDate = '';
					$assignToCSETime = '';
					$this -> tl_array = array("2", "7", "9", "11", "13"); 
					if($this->process_id==8)
					{
						$this -> executive_array = array("3","16", "8", "10", "12", "14");						
						$assignToETL = '';
						$assignToETLDate = '';
						$assignToETLTime = '';
						$assignToEExe = '';
						$assignToEExeDate = '';
						$assignToEExeTime = '';
						if ($assignToRole == 15) {
						
						if ($assignByRole == 2 || $assignByRole == 3 || $assignByRole == 1) {
							$assignByCSE = ",assign_by_cse='$assign_by'";
							$assignToETL = ",assign_to_e_tl='$assign_to'";
							$assignToETLDate = ",assign_to_e_tl_date='$this->today'";
							$assignToETLTime = ",assign_to_e_tl_time='$this->time'";
						} 
					}
						if($lead_send =='Continue with old Followup'){
							
							if (in_array($assignToRole,$this->tl_array)) {
						
						$assignByCSETL = ",assign_by_cse_tl='$assign_to'";
						$assignToCSE = ",assign_to_cse='$assign_to'";
			
					} elseif (in_array($assignToRole,$this->executive_array)) {
					
						$get_cse_tl_id=$this->db->query("select tl_id from tbl_mapdse where dse_id='$assign_to'")->result();
						if(isset($get_cse_tl_id[0]->tl_id)){
							$tl_id=$get_cse_tl_id[0]->tl_id;
							$assignByCSETL=",assign_by_cse_tl='$tl_id'";
						}
						 $assignToCSE = ",assign_to_cse='$assign_to'";
					
						}
					
						}else{
						
				if (in_array($assignToRole,$this->tl_array)) {
					
							$assignByCSETL = ",assign_by_cse_tl='$assign_to'";
						$assignToCSE = ",assign_to_cse='$assign_to'";
						$assignToCSEDate = ",assign_to_cse_date='$this->today'";
						$assignToCSETime = ",assign_to_cse_time='$this->time'";
					} elseif (in_array($assignToRole,$this->executive_array)) {
							
						$get_cse_tl_id=$this->db->query("select tl_id from tbl_mapdse where dse_id='$assign_to'")->result();
						if(isset($get_cse_tl_id[0]->tl_id)){
							$tl_id=$get_cse_tl_id[0]->tl_id;
							$assignByCSETL=",assign_by_cse_tl='$tl_id'";
						}
						$assignToCSE = ",assign_to_cse='$assign_to'";
						$assignToCSEDate = ",assign_to_cse_date='$this->today'";
						$assignToCSETime = ",assign_to_cse_time='$this->time'";

					}
					}
						
					$update1 = $this -> db -> query("update ".$this->table_name." set transfer_id='$transfer_id'
			" . $assignByCSETL .  $assignByCSE .  $assignToCSE . $assignToETL . $assignToCSEDate . $assignToETLDate .$assignToCSETime . $assignToETLTime . "
			 where enq_id='$enq_id'");
			echo $this->db->last_query();
						
						/*if ($assignToRole == 16) {
							$assignToEExe = ",assign_to_e_exe='$assign_to'";
							$assignToEExeDate = ",assign_to_e_exe_date='$this->today'";
							$assignToEExeTime = ",assign_to_e_exe_time='$this->time'";
						}
						elseif ($assignToRole == 15) {
							if ($assignByRole == 15)
							{
								$assignToETL = ",assign_to_e_tl='$assign_to'";
								$assignToETLDate = ",assign_to_e_tl_date='$this->today'";
								$assignToETLTime = ",assign_to_e_tl_time='$this->time'";
							}
							elseif ($assignByRole == 16){
								$assignToEExe = ",assign_to_e_exe='$assign_to'";
								$assignToEExeDate = ",assign_to_e_exe_date='$this->today'";
								$assignToEExeTime = ",assign_to_e_exe_time='$this->time'";
							}
						}*/
					/*	$update1 = $this -> db -> query("update ".$this->table_name." set transfer_id='$transfer_id'
			"  . $assignToETL .  $assignToEExe .  $assignToETLDate . $assignToEExeDate . $assignToETLTime . $assignToEExeTime . "
			 where enq_id='$enq_id'");*/
		//	echo $this->db->last_query();
						
					}
					else {
						
					
					$this -> executive_array = array("3","4", "8", "10", "12", "14");
					
					
					$assignToDSETL = '';
					$assignToDSE = '';
					
					$assignToDSETLDate = '';
					$assignToDSETLTime = '';
					$assignToDSEDate = '';
					$assignToDSETime = '';
					$followup_id='';
					echo $assignToRole;
					echo "<br>";
					echo $assignByRole;
					//print_r ($this -> tl_array);
				
					if ($assignToRole == 5) {
						
						if ($assignByRole == 2 || $assignByRole == 3 || $assignByRole == 1) {
							$assignByCSE = ",assign_by_cse='$assign_by'";
							$assignToDSETL = ",assign_to_dse_tl='$assign_to'";
							$assignToDSETLDate = ",assign_to_dse_tl_date='$this->today'";
							$assignToDSETLTime = ",assign_to_dse_tl_time='$this->time'";
						} 
					}
						if($lead_send =='Continue with old Followup'){
							
							if (in_array($assignToRole,$this->tl_array)) {
						
						$assignByCSETL = ",assign_by_cse_tl='$assign_to'";
						$assignToCSE = ",assign_to_cse='$assign_to'";
			
					} elseif (in_array($assignToRole,$this->executive_array)) {
					
						$get_cse_tl_id=$this->db->query("select tl_id from tbl_mapdse where dse_id='$assign_to'")->result();
						if(isset($get_cse_tl_id[0]->tl_id)){
							$tl_id=$get_cse_tl_id[0]->tl_id;
							$assignByCSETL=",assign_by_cse_tl='$tl_id'";
						}
						 $assignToCSE = ",assign_to_cse='$assign_to'";
					
						}
					
						}else{
						
				if (in_array($assignToRole,$this->tl_array)) {
					
							$assignByCSETL = ",assign_by_cse_tl='$assign_to'";
						$assignToCSE = ",assign_to_cse='$assign_to'";
						$assignToCSEDate = ",assign_to_cse_date='$this->today'";
						$assignToCSETime = ",assign_to_cse_time='$this->time'";
					} elseif (in_array($assignToRole,$this->executive_array)) {
							
						$get_cse_tl_id=$this->db->query("select tl_id from tbl_mapdse where dse_id='$assign_to'")->result();
						if(isset($get_cse_tl_id[0]->tl_id)){
							$tl_id=$get_cse_tl_id[0]->tl_id;
							$assignByCSETL=",assign_by_cse_tl='$tl_id'";
						}
						$assignToCSE = ",assign_to_cse='$assign_to'";
						$assignToCSEDate = ",assign_to_cse_date='$this->today'";
						$assignToCSETime = ",assign_to_cse_time='$this->time'";

					}
					}
					$update1 = $this -> db -> query("update ".$this->table_name." set transfer_id='$transfer_id'
			" .$followup_id. $assignByCSETL .  $assignByCSE .  $assignToCSE . $assignToDSETL .  $assignToDSE . $assignToCSEDate . $assignToDSETLDate . $assignToDSEDate . $assignToCSETime . $assignToDSETLTime . $assignToDSETime . "
			 where enq_id='$enq_id'");
			echo $this->db->last_query();
			
				}	
				}
			
		}

	}
	}
/**********************************************************************************************************/
/*********************************** Assign Leads status wise ****************************************/
function assign_data_status() {

		 $assign_by = $this -> input -> post('fromUser');
		 $cse_name = $this -> input -> post('cse_name');
		 $lead_send_from=$this->input->post('lead_send_from');
		 $cse_count = count($cse_name);
		 $web_lead_name = $this -> input -> post('leads1');
		 $lead_type = $this -> input -> post('lead_type');
		 $lead_send=$this->input->post('lead_send');

		if (isset($web_lead_name)) {

			if ($this -> input -> post('lead_count1') == '') {
		
				$lead_count = $this -> input -> post('web_count');
		} else {
			
				$lead_count = $this -> input -> post('lead_count1');
				
			}

		} else {
			$lead_count = '';
		}
	
		
		$assign_count = $lead_count % $cse_count;
		if ($assign_count == 0)//check remainder
		{
			$assign_count1 = $lead_count / $cse_count;
			$assign_count_reminder = $assign_count1;
		} else {
			$lead_count = $lead_count - $assign_count;
			$assign_count1 = $lead_count / $cse_count;
			$assign_count_reminder = $assign_count1 + $assign_count;
		}
		
	
		if ($lead_count != '') {
			$checkRole = $this -> db -> query("select role from lmsuser where id='$assign_by' ") -> result();
			$assignByRole = $checkRole['0'] -> role;
			
			for ($i = 0; $i < $cse_count; $i++) {
				$assign_to=$cse_name[$i];
				$today = date('Y-m-d');
				$lead_send_from=$this->input->post('lead_send_from');
				
			if($lead_type!=''){
				
			if($web_lead_name=='New Lead'){
			
// New Lead

	$this -> db -> select('enq_id');
		$this -> db -> from($this -> table_name . ' l');
		if($this->process_id==8)
		{			
			$this -> db -> where('l.evaluation', 'Yes');
			if ($assignByRole == '3' || $assignByRole=='2' || $assignByRole=='1') 
			{
				if($lead_send_from=='showroom_sent')
				{
					$this -> db -> where('l.assign_to_e_tl !=', 0);						
				}
				else
				{
					$this -> db -> where('l.assign_to_e_tl', 0);
				}
			}
		}
		else 
		{
			$this -> db -> where('l.process', $this -> process_name);
			if ($assignByRole == '3' || $assignByRole=='2' || $assignByRole=='1') 
			{
				if($lead_send_from=='showroom_sent')
				{
					$this -> db -> where('l.assign_to_dse_tl !=', 0);						
				}
				else
				{
					$this -> db -> where('l.assign_to_dse_tl', 0);
				}
			}
		}
		if ($assignByRole == '3' || $assignByRole=='2' || $assignByRole=='1') 
		{
			$this -> db -> where('l.cse_followup_id', 0);
			$this -> db -> where('l.assign_to_cse', $assign_by);
			$this -> db -> where('l.assign_to_cse_date', $today);
					
		}
	
		$this -> db -> order_by('l.enq_id', 'desc');
	if ($i == 0) {
					$this -> db -> limit($assign_count_reminder);
				} else {
					$this -> db -> limit( $assign_count1);
				}
		$query = $this -> db -> get();
	
		$query=$query->result();

}elseif($web_lead_name == 'Today Followup Lead'){

// Today Followup

		$nextfollowupdate = ("lf.nextfollowupdate = '$today'" or "lf.nextfollowupdate = '$day'");
		$this -> db -> select('enq_id');
		$this -> db -> from($this -> table_name . ' l');
				$this -> db -> join($this -> table_name2 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		if($this->process_id==8)
		{
			$this -> db -> join($this -> table_name2 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		
			$this -> db -> where('l.evaluation', 'Yes');
			if ($assignByRole == '3' || $assignByRole=='2' || $assignByRole=='1') 
			{
				if($lead_send_from=='showroom_sent')
				{
					$this -> db -> where('l.assign_to_e_tl !=', 0);						
				}
				else
				{
					$this -> db -> where('l.assign_to_e_tl', 0);
				}
			}
		}
		else {
			$this -> db -> join($this -> table_name2 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		
			$this -> db -> where('l.process', $this -> process_name);
			if ($assignByRole == '3' || $assignByRole=='2' || $assignByRole=='1') 
			{
				if($lead_send_from=='showroom_sent')
				{
					$this -> db -> where('l.assign_to_dse_tl !=', 0);						
				}
				else
				{
					$this -> db -> where('l.assign_to_dse_tl', 0);
				}
			}
		}
		

		if ($assignByRole == '3' || $assignByRole == '2' || $assignByRole == '1') {
			
			$this -> db -> where('l.assign_to_cse',$assign_by);
		//	$this -> db -> where('l.assign_to_dse_tl',0);
			$this -> db -> where('f1.nextfollowupdate', $today);
		}
	

	
		$this -> db -> where('l.nextAction!=', "Close");	
		$this -> db -> where('l.nextAction!=', "Lost");	
		if ($i == 0) {
					$this -> db -> limit($assign_count_reminder);
				} else {
					$this -> db -> limit( $assign_count1);
				}
		$query = $this -> db -> get();
		
		$query=$query -> result();
		}elseif($web_lead_name=='Pending New Lead'){

//Pending new
	$this -> db -> select('enq_id');
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name2 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		
			if($this->process_id==8)
		{
			$this -> db -> join($this -> table_name2 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		
			$this -> db -> where('l.evaluation', 'Yes');
			if ($assignByRole == '3' || $assignByRole=='2' || $assignByRole=='1') 
			{
				if($lead_send_from=='showroom_sent')
				{
					$this -> db -> where('l.assign_to_e_tl !=', 0);						
				}
				else
				{
					$this -> db -> where('l.assign_to_e_tl', 0);
				}
			}
		}
		else {
			$this -> db -> join($this -> table_name2 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		
			$this -> db -> where('l.process', $this -> process_name);
			if ($assignByRole == '3' || $assignByRole=='2' || $assignByRole=='1') 
			{
				if($lead_send_from=='showroom_sent')
				{
					$this -> db -> where('l.assign_to_dse_tl !=', 0);						
				}
				else
				{
					$this -> db -> where('l.assign_to_dse_tl', 0);
				}
			}
		}

if ($assignByRole == '2' || $assignByRole == '3' || $assignByRole == '1') {
			$this -> db -> where('l.cse_followup_id', 0);
			$this -> db -> where("l.assign_to_cse=", $assign_by);			
			
			$this -> db -> where('l.assign_to_cse_date < ', $this -> today);
			$this -> db -> where('l.assign_to_cse_date!=', '0000-00-00');
			//$this -> db -> group_by('l.enq_id');
		}
		
		$this -> db -> order_by('l.enq_id', 'desc');
	if ($i == 0) {
					$this -> db -> limit($assign_count_reminder);
				} else {
					$this -> db -> limit( $assign_count1);
				}
		$query = $this -> db -> get();
		
		$query=$query -> result();

}
elseif($web_lead_name == 'Pending Followup Lead'){

	
//Pending new
	$this -> db -> select('enq_id');
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name2 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		
		if($this->process_id==8)
		{
			$this -> db -> join($this -> table_name2 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		
			$this -> db -> where('l.evaluation', 'Yes');
			if ($assignByRole == '3' || $assignByRole=='2' || $assignByRole=='1') 
			{
				if($lead_send_from=='showroom_sent')
				{
					$this -> db -> where('l.assign_to_e_tl !=', 0);						
				}
				else
				{
					$this -> db -> where('l.assign_to_e_tl', 0);
				}
			}
		}
		else {
			$this -> db -> join($this -> table_name2 . ' f2', 'f2.id=l.dse_followup_id', 'left');
			
			$this -> db -> where('l.process', $this -> process_name);
			if ($assignByRole == '3' || $assignByRole=='2' || $assignByRole=='1') 
			{
				if($lead_send_from=='showroom_sent')
				{
					$this -> db -> where('l.assign_to_dse_tl !=', 0);						
				}
				else
				{
					$this -> db -> where('l.assign_to_dse_tl', 0);
				}
			}
		}

		$this -> db -> where('l.nextAction!=', "Close");
		if ($assignByRole == 2 || $assignByRole== 3 || $assignByRole== 1) {

			$this -> db -> where("l.assign_to_cse=", $assign_by);
			$this -> db -> where("f1.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f1.nextfollowupdate <", $this -> today);
			
		} 
		
		
		$this -> db -> order_by('l.enq_id', 'desc');
	if ($i == 0) {
					$this -> db -> limit($assign_count_reminder);
				} else {
					$this -> db -> limit( $assign_count1);
				}
		$query = $this -> db -> get();

		$query=$query -> result();

}
}
			foreach ($query as $row) {
					
					 $enq_id = $row -> enq_id;
					
					$insertQuery = $this -> db -> query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $assign_to . '","' . $assign_by . '","' . $this->today . '","' . $this->time . '","Transfered")');
					$transfer_id = $this -> db -> insert_id();
					$selectRole = $this -> db -> query("select role from lmsuser where id='$assign_to'") -> result();
							//	print_r($selectRole);
					$assignToRole = $selectRole[0] -> role;
	
					$this -> tl_array = array("2", "7", "9", "11", "13");
					$this -> executive_array = array("3","4", "8", "10", "12", "14");
					
					$assignByCSETL = '';
					$assignByCSE = '';
					$assignToCSE = '';
					$assignToDSETL = '';
					$assignToDSE = '';
					$assignToCSEDate = '';
					$assignToCSETime = '';
					$assignToDSETLDate = '';
					$assignToDSETLTime = '';
					$assignToDSEDate = '';
					$assignToDSETime = '';
					$followup_id='';
					
					if ($assignToRole == 5) {
						if ($assignByRole == 2 || $assignByRole == 3 || $assignByRole == 1) {
							$assignByCSE = ",assign_by_cse='$assign_by'";
							$assignToDSETL = ",assign_to_dse_tl='$assign_to'";
							$assignToDSETLDate = ",assign_to_dse_tl_date='$this->today'";
							$assignToDSETLTime = ",assign_to_dse_tl_time='$this->time'";
						} 
					}
					if($lead_send='Continue with old Followup'){
							if (in_array($assignToRole,$this->tl_array)) {
						//echo "testdata1";
						$assignByCSETL = ",assign_by_cse_tl='$assign_to'";
						$assignToCSE = ",assign_to_cse='$assign_to'";
					
					} elseif (in_array($assignToRole,$this->executive_array)) {
						$get_cse_tl_id=$this->db->query("select tl_id from tbl_mapdse where dse_id='$assign_to'")->result();
						if(isset($get_cse_tl_id[0]->tl_id)){
							$tl_id=$get_cse_tl_id[0]->tl_id;
							$assignByCSETL=",assign_by_cse_tl='$tl_id'";
						}
						$assignToCSE = ",assign_to_cse='$assign_to'";
						

					}
					}
					else{
					if (in_array($assignToRole,$this->tl_array)) {
						//echo "testdata1";
						$assignToCSE = ",assign_to_cse='$assign_to'";
						$assignToCSEDate = ",assign_to_cse_date='$this->today'";
						$assignToCSETime = ",assign_to_cse_time='$this->time'";
					} elseif (in_array($assignToRole,$this->executive_array)) {
							//echo "testdata";
						if (in_array($assignByRole, $this -> tl_array)) {
							//echo "testdata2222";
							$assignByCSETL = ",assign_by_cse_tl='$assign_by'";
						}
						//echo "testdata23423423";
						$assignToCSE = ",assign_to_cse='$assign_to'";
						$assignToCSEDate = ",assign_to_cse_date='$this->today'";
						$assignToCSETime = ",assign_to_cse_time='$this->time'";

					}
					}
					$update1 = $this -> db -> query("update ".$this->table_name." set transfer_id='$transfer_id'
			" .$followup_id. $assignByCSETL .  $assignByCSE .  $assignToCSE . $assignToDSETL .  $assignToDSE . $assignToCSEDate . $assignToDSETLDate . $assignToDSEDate . $assignToCSETime . $assignToDSETLTime . $assignToDSETime . "
			 where enq_id='$enq_id'");
			//echo $this->db->last_query();
				
				}
			}
			}

		}
		
	
/*********************************** With Followup *******************************************/

}
?>
