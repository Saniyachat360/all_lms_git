<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class assign_leads_model extends CI_model {
	public $process_name;
	public $role;
	public $user_id;
	public $table_name;
	public $executive_array;
	public $tl_array;
	public $tl_list;
	function __construct() {
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->time=date("h:i:s A");
		$this -> process_name = $this -> session -> userdata('process_name');
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');
		$this -> process_id = $_SESSION['process_id'];
		if ($this -> process_id == 6 || $this -> process_id == 7) {
			$this -> table_name = 'lead_master l';
			$this -> transfer_table_name = 'request_to_lead_transfer';
		}
		elseif($this->process_id==8)
		{
			$this -> table_name = 'lead_master_evaluation l';
			$this -> transfer_table_name = 'request_to_lead_transfer_evaluation';
		} else {
			$this -> table_name = 'lead_master_all l';
			$this -> transfer_table_name = 'request_to_lead_transfer_all';
		}
		$this -> executive_array = array("4", "8", "10", "12", "14");
		$this -> all_array = array("2","3","5", "7", "9", "11", "13","15");
		$this -> tl_array = array("2","5", "7", "9", "11", "13","15");
		$this->tl_list='("2","5", "7", "9", "11", "13","15")';
		
	}
	function all_count() {
		$this -> db -> select('count(enq_id)as acount');
		$this -> db -> from($this -> table_name);
		if($_SESSION['process_id']==8){
			$this -> db -> where('evaluation', 'Yes');
		
		}else{
		$this -> db -> where('process', $this->process_name);
	
		}
		
			$this -> db -> where('assign_by_cse_tl', '0');
		$query = $this -> db -> get();
		return $query -> result();
	}
	function all_count_loan() {
		$this -> db -> select('count(enq_id)as acount');
		$this -> db -> from($this -> table_name);
		if($_SESSION['process_id']==8){
			$this -> db -> where('evaluation', 'Yes');
		
		}else{
		$this -> db -> where('process', $this->process_name);
	
		}
			$this -> db -> where('loan_type !=', '0');
		$this -> db -> where('loan_type !=', '');
			$this -> db -> where('assign_by_cse_tl', '0');
		$query = $this -> db -> get();
		return $query -> result();
	}
	
	

	function dse_name() {
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser');
		$this -> db -> where('role', '3');
		$this -> db -> where('status', '1');
		$this -> db -> where('location', '1');
		$this -> db -> order_by('fname', 'asc');
		$query = $this -> db -> get();
		return $query -> result();

	}

	function location() {
		$this -> db -> select('l.*');
		$this -> db -> from('tbl_location l');
		$this->db->join('tbl_map_process p','p.location_id=l.location_id');
		$this->db->where('process_id',$this->process_id);
		$this->db->where('p.status !=','-1');
		$this->db->where('l.location_status !=','Deactive');
		$this->db->order_by('l.location','asc');
		$query = $this -> db -> get();
		return $query -> result();

	}

	function leads() {
		$this -> db -> select('lead_source,enquiry_for,count(lead_source) as wcount ');
		$this -> db -> from($this -> table_name);
		if($_SESSION['process_id']==8){
			$this -> db -> where('evaluation','Yes');
				}else{
			$this -> db -> where('process', $_SESSION['process_name']);
		
		}
		$this -> db -> where('assign_by_cse_tl', '0');
		$this -> db -> group_by('lead_source');
		$query = $this -> db -> get();
		//echo  $this->db->last_query();
		return $query -> result();

	}
		function leads_sublead() {
		$this -> db -> select('lead_source,enquiry_for,count(lead_source) as wcount ');
		$this -> db -> from($this -> table_name);
		if($_SESSION['process_id']==8){
			$this -> db -> where('evaluation','Yes');
				}else{
			$this -> db -> where('process', $_SESSION['process_name']);
		
		}
		$where="lead_source like '%Facebook%'";
		$this -> db -> where('assign_by_cse_tl', '0');
		$this->db->where($where);
		$this -> db -> group_by('enquiry_for');
		$query = $this -> db -> get();
	//	echo  $this->db->last_query();
		return $query -> result();

	}
	function all_count_sublead() {
		$this -> db -> select('count(enq_id)as acount');
		$this -> db -> from($this -> table_name);
		if($_SESSION['process_id']==8){
			$this -> db -> where('evaluation', 'Yes');
		
		}else{
		$this -> db -> where('process', $this->process_name);
	
		}
		$where="lead_source like '%Facebook%'";
		$this -> db -> where('assign_by_cse_tl', '0');
		$this->db->where($where);
		$query = $this -> db -> get();
		return $query -> result();
	}
	function leads_loan() {
		$this -> db -> select('loan_type,enquiry_for,count(loan_type) as wcount ');
		$this -> db -> from($this -> table_name);
	
		$this -> db -> where('process', $_SESSION['process_name']);
		$this -> db -> where('assign_by_cse_tl', '0');
		$this -> db -> where('loan_type !=', '0');
		$this -> db -> where('loan_type !=', '');
		$this -> db -> group_by('loan_type');
		$query = $this -> db -> get();
		//echo  $this->db->last_query();
		return $query -> result();

	}
	 function select_user() {
		$location = $this -> input -> post('location');
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser l');
		//$this -> db -> join('tbl_user_group u', 'u.user_id=l.id');
		$this -> db -> join('tbl_manager_process u', 'u.user_id=l.id');
		$this -> db -> join('tbl_rights r', 'r.user_id=l.id');
		$this -> db -> where('r.form_name', 'Calling Notification');
		$this -> db -> where('r.view', '1');
		$this -> db -> where('l.status', '1');
		$this -> db -> where('u.process_id', $this->process_id);

		if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2 || $_SESSION['role'] == 3) {
			//echo "1";
		//	echo "hi";
			//$a = "(role=2 or role=3 or role=5)";
			$this -> db -> where_in('role', $this -> all_array);
			
		} elseif (in_array($this -> role, $this -> tl_array)) {
				//echo "2";
			$q = $this -> db -> query('select dse_id from tbl_mapdse where tl_id="' . $_SESSION['user_id'] . '"') -> result();
		
			$c = count($q);
			$t = ' ( ';
			if (count($q) > 0) {

				for ($i = 0; $i < $c; $i++) {

					$t = $t . "id = " . $q[$i] -> dse_id . " or ";

				}

			}
			$t = $t . "role in".$this->tl_list;
			$st = $t . ')';
			
			$this -> db -> where($st);
		} elseif (in_array($this -> role, $this -> executive_array)) {
				//echo "3";
			$q1 = $this -> db -> query('select tl_id from tbl_mapdse where dse_id="' . $_SESSION['user_id'] . '"') -> result();
			if (count($q1) > 0) {
				//	echo "4";
				$q = $this -> db -> query('select dse_id from tbl_mapdse where tl_id="' . $q1[0] -> tl_id . '"') -> result();
				$c = count($q);
				$t = ' ( ';
				if (count($q) > 0) {

					for ($i = 0; $i < $c; $i++) {

						$t = $t . "id = " . $q[$i] -> dse_id . " or ";

					}

				}
				$t = $t . "role in".$this->tl_list;
				$st = $t . ')';

				$this -> db -> where($st);

			} else {
					//echo "5";
				$t = $t . "role in".$this->tl_list;
			}
		}
		$this -> db -> where('role !=', '1');
		$this -> db -> where('u.location_id', $location);
		$this -> db -> group_by("l.id");
		$this -> db -> order_by("fname", "asc");
		$query = $this -> db -> get();
		//echo $this -> db -> last_query();
		return $query -> result();

	}
	
	function select_cse() {
		$location = $this -> input -> post('location');
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser l');
		$this -> db -> join('tbl_manager_process u', 'u.user_id=l.id','left');
		$this -> db -> join('tbl_rights r', 'r.user_id=l.id');
		$this -> db -> where('r.form_name', 'Calling Notification');
		$this -> db -> where('r.view', '1');
		$this -> db -> where('status', '1');
		$this -> db -> where('u.process_id',$_SESSION['process_id']);
		
		if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2 || $_SESSION['role'] == 3) {
			$a = "(role=2 or role=3 or role=5 )";
			$this -> db -> where($a);
		} elseif ($_SESSION['role'] == 5) {
			$q = $this -> db -> query('select dse_id from tbl_mapdse where tl_id="' . $_SESSION['user_id'] . '"') -> result();
			$c = count($q);
			$t = ' ( ';
			if (count($q) > 0) {

				for ($i = 0; $i < $c; $i++) {

					$t = $t . "id = " . $q[$i] -> dse_id . " or ";

				}

			}
			$t = $t . "role = 5";
			$st = $t . ')';

			$this -> db -> where($st);
		}
		
 elseif ($_SESSION['role'] == 4) {
			$q1 = $this -> db -> query('select tl_id from tbl_mapdse where dse_id="' . $_SESSION['user_id'] . '"') -> result();
			if (count($q1) > 0) {
				$q = $this -> db -> query('select dse_id from tbl_mapdse where tl_id="' . $q1[0] -> tl_id . '"') -> result();
				$c = count($q);
				$t = ' ( ';
				if (count($q) > 0) {

					for ($i = 0; $i < $c; $i++) {

						$t = $t . "id = " . $q[$i] -> dse_id . " or ";

					}

				}
				$t = $t . "role = 5";
				$st = $t . ')';

				$this -> db -> where($st);

			} else {
				$this -> db -> where('role', '5');
			}
		}

		$this -> db -> where('role !=', '1');
		$this -> db -> where('location', $location);
		$this -> db -> group_by("l.id");
		$this -> db -> order_by("fname", "asc");
		$query = $this -> db -> get();
		//	echo $this -> db -> last_query();
		return $query -> result();
	}


	
	function assign_data() {

		$assign_by = $_SESSION['user_id'];
		$assign_date = date('Y-m-d');
		$cse_name = $this -> input -> post('cse_name');
		$cse_count = count($cse_name);
		
		 $web_lead_name = $this -> input -> post('leads1');
		if (isset($web_lead_name)) {

			if ($this -> input -> post('lead_count1') == '') {

				$lead_count = $this -> input -> post('web_count');
				$web_lead_count = $this -> input -> post('web_count');

			} else {
				
				$lead_count = $this -> input -> post('lead_count1');
				$web_lead_count = $this -> input -> post('lead_count1');
				
			}

		} else {
			$web_lead_count = '';
		}
		/*$facebook_lead_name = $this -> input -> post('leads2');
		if (isset($facebook_lead_name)) {
			if ($this -> input -> post('lead_count2') == '') {
			
				$lead_count = $this -> input -> post('campaign_count');
				$facebook_lead_count = $this -> input -> post('campaign_count');

			} else {
			
				$lead_count = $this -> input -> post('lead_count2');
				$facebook_lead_count = $this -> input -> post('lead_count2');
			}
		}
	*/
		if ($web_lead_name == 'Web') {

			$web_lead_name = '';
		}

		$assign_count = $lead_count % $cse_count;
		if ($assign_count == 0)//check remainder
		{

			$assign_count1 = $lead_count / $cse_count;
			$assign_count_reminder = $assign_count1;
		} else {
			echo $lead_count;
			$lead_count = $lead_count - $assign_count;
			$assign_count1 = $lead_count / $cse_count;
			$assign_count_reminder = $assign_count1 + $assign_count;
		}
        $lead_type = $this -> input -> post('lead_type');
		for ($i = 0; $i < $cse_count; $i++) {
			if ($i == 0) {
			    if($lead_type=='2'){
			        		$query = $this -> db -> query("select enq_id from ".$this -> table_name." where loan_type='$web_lead_name'  and assign_by_cse_tl='0' and process='" . $_SESSION['process_name'] . "' limit $assign_count_reminder ") -> result();
			
			    }
			    else if($lead_type=='3'){
			        		$query = $this -> db -> query("select enq_id from ".$this -> table_name." where enquiry_for='$web_lead_name'  and assign_by_cse_tl='0' and process='" . $_SESSION['process_name'] . "' and lead_source like '%Facebook%' limit $assign_count_reminder ") -> result();
			
			    }else{
					$query = $this -> db -> query("select enq_id from ".$this -> table_name." where lead_source='$web_lead_name' and assign_by_cse_tl='0' and process='" . $_SESSION['process_name'] . "' limit $assign_count_reminder ") -> result();
					//echo $this->db->last_query();
			    }
			} else {
				  if($lead_type=='2'){
			        $query = $this -> db -> query("select enq_id from ".$this -> table_name." where loan_type='$web_lead_name' and assign_by_cse_tl='0' and process='" . $_SESSION['process_name'] . "' limit $assign_count1 ") -> result();
				
			    }else if($lead_type=='3'){
			        $query = $this -> db -> query("select enq_id from ".$this -> table_name." where enquiry_for='$web_lead_name' and assign_by_cse_tl='0' and process='" . $_SESSION['process_name'] . "' and lead_source like '%Facebook%' limit $assign_count1 ") -> result();
				
			    }
			    
			    else{
					$query = $this -> db -> query("select enq_id from ".$this -> table_name." where lead_source='$web_lead_name' and assign_by_cse_tl='0' and process='" . $_SESSION['process_name'] . "' limit $assign_count1 ") -> result();
					//	echo $this->db->last_query();
			    }
			}
			foreach ($query as $row) 
			{
				 $enq_id = $row->enq_id;
				
				$this->db->select('u.role,l.location');
				$this->db->from('lmsuser u');
				$this->db->join('tbl_manager_process m','m.user_id=u.id');
				$this->db->join('tbl_location l','l.location_id=m.location_id');
				$this->db->where('id',$cse_name[$i]);
				$query1=$this->db->get()->result();
				echo $query1[0]->role;
				if(isset($query1[0]->role)){
				if($query1[0]->role==4 or $query1[0]->role==5){
					$time = date("H:i:s A");
					$insertQuery1 = $this -> db -> query('INSERT INTO '.$this -> transfer_table_name.'( `lead_id` , `assign_to` , `assign_by` , `location` , `created_date` , `created_time`  ,status)  VALUES("' . $enq_id. '","' . $cse_name[$i] . '","' . $assign_by . '","'. $query1[0]->location . '","' . $assign_date . '","' . $time . '","Transfered")') or die(mysql_error());
					$transfer_id=$this->db->insert_id();
				
				$this->db->query ("update ".$this->table_name." set transfer_id='$transfer_id', assign_by_cse_tl='$assign_by',assign_by_cse='$assign_by',assign_to_dse_tl_date='$assign_date',assign_to_dse_tl_time='$this->time',assign_to_dse_tl='$cse_name[$i]' where enq_id='$enq_id'");
				//echo $this->db->last_query();
				}
				else {
					
				
				$this->db->query ("update ".$this->table_name." set  assign_by_cse_tl='$assign_by',assign_to_cse_date='$assign_date',assign_to_cse_time='$this->time',assign_to_cse='$cse_name[$i]' where enq_id='$enq_id'");
			
				}
				
				}	
			}
		}

	}
function assign_data_evaluation() {

		$assign_by = $_SESSION['user_id'];
		$assign_date = date('Y-m-d');
		$cse_name = $this -> input -> post('cse_name');
		$cse_count = count($cse_name);
		
		 $web_lead_name = $this -> input -> post('leads1');
		if (isset($web_lead_name)) {

			if ($this -> input -> post('lead_count1') == '') {

				$lead_count = $this -> input -> post('web_count');
				$web_lead_count = $this -> input -> post('web_count');

			} else {
				
				$lead_count = $this -> input -> post('lead_count1');
				$web_lead_count = $this -> input -> post('lead_count1');
				
			}

		} else {
			$web_lead_count = '';
		}
		$facebook_lead_name = $this -> input -> post('leads2');
		if (isset($facebook_lead_name)) {
			if ($this -> input -> post('lead_count2') == '') {
			
				$lead_count = $this -> input -> post('campaign_count');
				$facebook_lead_count = $this -> input -> post('campaign_count');

			} else {
			
				$lead_count = $this -> input -> post('lead_count2');
				$facebook_lead_count = $this -> input -> post('lead_count2');
			}
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
			echo $lead_count;
			$lead_count = $lead_count - $assign_count;
			$assign_count1 = $lead_count / $cse_count;
			$assign_count_reminder = $assign_count1 + $assign_count;
		}

		for ($i = 0; $i < $cse_count; $i++) {
			if ($i == 0) {
				if ($web_lead_count != '') {

					$query = $this -> db -> query("select enq_id from ".$this -> table_name." where lead_source='$web_lead_name' and  	assign_to_e_tl ='0' and evaluation='Yes' limit ".$assign_count_reminder ."") -> result();
					//echo $this->db->last_query();

				} else {
					echo "Facebook";
					$query = $this -> db -> query("select enq_id from ".$this -> table_name." where enquiry_for='$facebook_lead_name' and lead_source='Facebook' and  evaluation='Yes'  and  	assign_to_e_tl ='0' limit ".$assign_count_reminder ."") -> result();
					//	echo $this->db->last_query();

				}
			} else {
				if ($web_lead_count != '') {

					$query = $this -> db -> query("select enq_id from ".$this -> table_name." where lead_source='$web_lead_name' and  	assign_to_e_tl ='0' and  evaluation='Yes' limit ". $assign_count1 ."") -> result();
					//	echo $this->db->last_query();

				} else {
					//echo"Facebook";
					$query = $this -> db -> query("select enq_id from ".$this -> table_name." where enquiry_for='$facebook_lead_name' and lead_source='Facebook' and  evaluation='Yes' and  assign_to_e_tl ='0' limit ". $assign_count1."") -> result();
					//echo $this->db->last_query();

				}
			}

			foreach ($query as $row) 
			{
				$enq_id = $row->enq_id;
				
				$this->db->select('u.role,l.location');
				$this->db->from('lmsuser u');
				$this->db->join('tbl_location l','l.location_id=u.location');
				$this->db->where('id',$cse_name[$i]);
				$query=$this->db->get()->result();
				
				$this->db->query ("update lead_master set  assign_to_e_tl='$assign_by',assign_to_e_tl_date='$assign_date',assign_to_e_tl_time='$this->time',assign_to_e_exe_date ='$assign_date',assign_to_e_exe_time ='$this->time',assign_to_e_exe='$cse_name[$i]' where enq_id='$enq_id'");
			
			
			echo $this->db->last_query();	
						
			}
		}

	}
	function complaint_leads() {
		$this -> db -> select('lead_source,count(lead_source) as wcount ');
		$this -> db -> from('lead_master_complaint');
		
		$this -> db -> where('assign_by_cse_tl', '0');
		
		$this -> db -> group_by('lead_source');
		$query = $this -> db -> get();
		//echo  $this->db->last_query();
		return $query -> result();

	}
	function complaint_all_count() {
		$this -> db -> select('count(complaint_id)as acount');
		$this -> db -> from('lead_master_complaint');
		$this -> db -> where('assign_by_cse_tl', '0');
		$query = $this -> db -> get();
		return $query -> result();
	}
	function assign_data_complaint() {

		$assign_by = $_SESSION['user_id'];
		$assign_date = date('Y-m-d');
		$cse_name = $this -> input -> post('cse_name');
		$cse_count = count($cse_name);
		
		 $web_lead_name = $this -> input -> post('leads1');
		if (isset($web_lead_name)) {

			if ($this -> input -> post('lead_count1') == '') {

				$lead_count = $this -> input -> post('web_count');
				$web_lead_count = $this -> input -> post('web_count');

			} else {
				
				$lead_count = $this -> input -> post('lead_count1');
				$web_lead_count = $this -> input -> post('lead_count1');
				
			}

		} else {
			$web_lead_count = '';
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
			echo $lead_count;
			$lead_count = $lead_count - $assign_count;
			$assign_count1 = $lead_count / $cse_count;
			$assign_count_reminder = $assign_count1 + $assign_count;
		}

		for ($i = 0; $i < $cse_count; $i++) {
			if ($i == 0) {
			

					$query = $this -> db -> query("select complaint_id from lead_master_complaint where lead_source='$web_lead_name' and assign_by_cse_tl='0'  limit $assign_count_reminder ") -> result();
		} else {
				
					$query = $this -> db -> query("select complaint_id from lead_master_complaint where lead_source='$web_lead_name' and assign_by_cse_tl='0'  limit $assign_count1 ") -> result();
				}

			foreach ($query as $row) 
			{
				 $complaint_id = $row->complaint_id;
				
				$this->db->query ("update lead_master_complaint set  assign_by_cse_tl='$assign_by',assign_to_cse_date='$assign_date',assign_to_cse_time='$this->time',assign_to_cse='$cse_name[$i]' where complaint_id='$complaint_id'");
			
			}
		}

	}
function assign_data_evaluation_data() {

		$assign_by = $_SESSION['user_id'];
		$assign_date = date('Y-m-d');
		$cse_name = $this -> input -> post('cse_name');
		$cse_count = count($cse_name);
		
		 $web_lead_name = $this -> input -> post('leads1');
		if (isset($web_lead_name)) {

			if ($this -> input -> post('lead_count1') == '') {

				$lead_count = $this -> input -> post('web_count');
				$web_lead_count = $this -> input -> post('web_count');

			} else {
				
				$lead_count = $this -> input -> post('lead_count1');
				$web_lead_count = $this -> input -> post('lead_count1');
				
			}

		} else {
			$web_lead_count = '';
		}
		/*$facebook_lead_name = $this -> input -> post('leads2');
		if (isset($facebook_lead_name)) {
			if ($this -> input -> post('lead_count2') == '') {
			
				$lead_count = $this -> input -> post('campaign_count');
				$facebook_lead_count = $this -> input -> post('campaign_count');

			} else {
			
				$lead_count = $this -> input -> post('lead_count2');
				$facebook_lead_count = $this -> input -> post('lead_count2');
			}
		}
	*/
		if ($web_lead_name == 'Web') {

			$web_lead_name = '';
		}

		$assign_count = $lead_count % $cse_count;
		if ($assign_count == 0)//check remainder
		{

			$assign_count1 = $lead_count / $cse_count;
			$assign_count_reminder = $assign_count1;
		} else {
			//echo $lead_count;
			$lead_count = $lead_count - $assign_count;
			$assign_count1 = $lead_count / $cse_count;
			$assign_count_reminder = $assign_count1 + $assign_count;
		}

		for ($i = 0; $i < $cse_count; $i++) {
			if ($i == 0) {
			

					$query = $this -> db -> query("select enq_id from ".$this -> table_name." where lead_source='$web_lead_name' and assign_by_cse_tl='0' and evaluation='Yes' limit $assign_count_reminder ") -> result();
					//echo $this->db->last_query();

				
			} else {
				
					$query = $this -> db -> query("select enq_id from ".$this -> table_name." where lead_source='$web_lead_name' and assign_by_cse_tl='0' and evaluation='Yes' limit $assign_count1 ") -> result();
					//	echo $this->db->last_query();

			
			}

			foreach ($query as $row) 
			{
				 $enq_id = $row->enq_id;
				
				$this->db->select('u.role,l.location');
				$this->db->from('lmsuser u');
				$this->db->join('tbl_manager_process m','m.user_id=u.id');
				$this->db->join('tbl_location l','l.location_id=m.location_id');
				$this->db->where('id',$cse_name[$i]);
				$query1=$this->db->get()->result();
			//	echo $query1[0]->role;
				if(isset($query1[0]->role)){
				if($query1[0]->role==16 or $query1[0]->role==15){
					$time = date("H:i:s A");
					$insertQuery1 = $this -> db -> query('INSERT INTO '.$this -> transfer_table_name.'( `lead_id` , `assign_to` , `assign_by` , `location` , `created_date` , `created_time`  ,status)  VALUES("' . $enq_id. '","' . $cse_name[$i] . '","' . $assign_by . '","'. $query1[0]->location . '","' . $assign_date . '","' . $time . '","Transfered")') or die(mysql_error());
					$transfer_id=$this->db->insert_id();
				
				$this->db->query ("update ".$this->table_name." set transfer_id='$transfer_id', assign_by_cse_tl='$assign_by',assign_by_cse='$assign_by',assign_to_e_tl_date='$assign_date', assign_to_e_tl_time ='$this->time',assign_to_e_tl='$cse_name[$i]' where enq_id='$enq_id'");
				//echo $this->db->last_query();
				}
				else {
					
				
				$this->db->query ("update ".$this->table_name." set  assign_by_cse_tl='$assign_by',assign_to_cse_date='$assign_date',assign_to_cse_time='$this->time',assign_to_cse='$cse_name[$i]' where enq_id='$enq_id'");
			//echo $this->db->last_query();
			
				}
				
				}	
			}
		}

	}
}
?>