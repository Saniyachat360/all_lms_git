<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login_history_model extends CI_model {

	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this -> today = date('Y-m-d');
		$this -> time = date('h:i:s A');
		$this->process_id = $this -> session -> userdata('process_id');
		$this -> location_id = $this -> session -> userdata('location_id');
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');
	}

	public function users() {

		$this -> db -> select('fname,lname,id');
		$this -> db -> from('lmsuser u');
	/*	if($this->role_id =='3')
		{
			$this -> db -> join('tbl_map_user mu','mu.exe_id=u.user_id','left');
			$this -> db -> where('mu.tl_id', $this -> user_id);
		}
		if($this->role_id =='5' || $this->role_id =='4')
		{
			$this -> db -> where('u.user_id', $this -> user_id);
		}*/
		$this -> db -> where('role !=', '1');
		$this -> db -> where('status', '1');
		$this -> db -> order_by('fname', 'ASC');
		$query = $this -> db -> get();
		return $query -> result();
	}

	public function summery_counts($sd, $ed) {

		$user_name = $this -> input -> post('user_id');
		$this -> db -> select('u.fname,u.lname,u.id,u3.logout_time,u3.login_time,u3.login_date,u.role');
		$this -> db -> from('tbl_login_history u3');
		$this -> db -> join('lmsuser u', 'u.id=u3.user_id');
		$this -> db -> join('tbl_manager_process m', 'm.user_id=u.id');
		if($this->role =='3')
		{
			$this -> db -> join('tbl_map_user mu','mu.exe_id=u.user_id','left');
			$this -> db -> where('mu.tl_id', $this -> user_id);
		}
		if ($user_name != '') {
			if (!in_array("ALL", $user_name)) {
				$this -> db -> where_in('u3.user_id', array_values($user_name));
			}
		}
		
		
		$this -> db -> where('u3.login_date >=', $sd);
		$this -> db -> where('u3.login_date <=', $ed);

		$this -> db -> where('u.status', '1');
		$this -> db -> where('m.process_id', $this->process_id);
		$this -> db -> where('u.role!=', '1');
		
		if ($this -> role == '5' || $this -> role == '4') {
			$this -> db -> where('u.id', $this -> user_id);
		}
        	$this -> db -> group_by('u3.user_id');
		$query = $this -> db -> get() -> result();
		if (count($query) > 0) {
			foreach ($query as $row) {
				$first_call = $this -> call_time($row -> id, $row -> role,$row -> login_date, 'first');
				$last_call = $this -> call_time($row -> id, $row -> role, $row -> login_date, 'last');

				$select_leads[] = array('user_name' => $row -> fname.' '.$row->lname, 'logout_time' => $row -> logout_time, 'login_date' => $row -> login_date, 'login_time' => $row -> login_time, 'first_call' => $first_call, 'last_call' => $last_call);
			}
		} else {
			$select_leads[] = '';

		}
		return $select_leads;

	}

	public function call_time($user_id, $role_id, $sd, $type) {

		$this -> db -> select('created_time');
		$this -> db -> from('lead_followup f');

		if ($type == 'first') {
			$this -> db -> where('f.date', $sd);
			$this -> db -> where('f.created_time!=', '');
			$this -> db -> order_by('f.id', 'asc');
		} else {
			$this -> db -> where('f.date ', $sd);
			$this -> db -> where('f.created_time!=', '');
			$this -> db -> order_by('f.id', 'desc');
		}
		$this -> db -> where('f.assign_to', $user_id);
		$this -> db -> limit('1');
		$query = $this -> db -> get();

		$query1 = $query -> result();
		if (count($query1) > 0) {
			$total_unassigned = $query1[0] -> created_time;
		} else {
			$total_unassigned = '';
		}
	/*	if($role_id!=5)
		{
			$this -> db -> select('created_time');
			$this -> db -> from('tbl_appointment f');
	
			if ($type == 'first') {
				$this -> db -> where('f.created_date', $sd);
				$this -> db -> where('f.created_time!=', '');
				$this -> db -> order_by('f.appointment_id', 'asc');
			} else {
				$this -> db -> where('f.created_date ', $sd);
				$this -> db -> where('f.created_time!=', '');
				$this -> db -> order_by('f.appointment_id', 'desc');
			}
			$this -> db -> where('f.user_id', $user_id);
			$this -> db -> limit('1');
			$query3 = $this -> db -> get();
	
			$query2 = $query3 -> result();
			if (count($query2) > 0) {
				$total_unassigned1 = $query2[0] -> created_time;
			} else {
				$total_unassigned1 = '';
			}
			/*if($this->user_id==1)
			{*
				//echo $type; print_r($query1);
			 //print_r($query2);
			
				
				
				if($total_unassigned!=''){$a=strtotime($total_unassigned);}else{$a=$total_unassigned;}
				if($total_unassigned1!=''){$a1=strtotime($total_unassigned1);}else{$a1=$total_unassigned1;}	
				if ($type == 'first') {
					if($a=='')
					{
						$total_unassigned=$total_unassigned1;
					}
						elseif($a1=='')
					{
						$total_unassigned=$total_unassigned;
					}		
					elseif($a1 < $a)
						{
							 $total_unassigned=$total_unassigned1;
						}
						
				}
				else {
					
					if($a1 > $a )
						{
							 $total_unassigned=$total_unassigned1;
						}
				}
				 //echo "<br>";
			//}
			
		}*/
		
		
		return $total_unassigned;
	}

}
