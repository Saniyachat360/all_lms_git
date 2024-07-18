<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Escalation_model extends CI_Model {
	public $process_name;
	public $role;
	public $user_id;
	public 	$location;
	public function __construct() {
		parent::__construct();
		//Session Values
		$this->today=date('Y-m-d');
		$this->process_name=$this->session->userdata('process_name');
		 $this->role=$this->session->userdata('role');
		$this->user_id=$this->session->userdata('user_id');
		$this->process_id=$this->session->userdata('process_id');
		$this->location=$this->session->userdata('location');
		$this->location_id=$this->session->userdata('location_id');
		//Select Table
		if ($this -> process_id == 6 || $this -> process_id == 7) {
			$this -> table_name = 'lead_master';
			$this -> table_name1 = 'lead_followup';
			$this->table_name2='tbl_escalation';
			$this->selectElement='l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id';
		}
		elseif ($this -> process_id == 8) {
			$this -> table_name = 'lead_master_evaluation';
			$this -> table_name1 = 'lead_followup_evaluation';
			$this->table_name2='tbl_escalation';
			$this->selectElement='l.assign_to_e_exe as assign_to_dse,l.assign_to_e_tl as assign_to_dse_tl,l.exe_followup_id as dse_followup_id';
			
		} else {
			$this -> table_name = 'lead_master_all';
			$this -> table_name1 = 'lead_followup_all';
			$this->table_name2='tbl_escalation_all';		
			$this->selectElement='l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id';
		}
		//Select Table 
	/*	if($this->process_id==6 || $this->process_id==7)
		{
			$this->table_name='lead_master';
			$this->table_name1='lead_followup';		
			
							
		}
		else
		{
			$this->table_name='lead_master_all';		
			$this->table_name1='lead_followup_all';	
			$this->table_name2='tbl_escalation_all';		
				
		}*/
		//Excecutive array
		
		$this->tl_role=array("CSE Team Leader","DSE Team Leader","Service TL","Insurance TL","Accessories TL","Finance TL","Evaluation Team Leader");
		$this->executive_role=array("CSE","DSE","Service Excecutive","Insurance Executive","Accessories Executive","Finance Executive","Evaluation Executive");
	}
public function select_default_close_lead_status()
	{
		$status_query=$this->db->query("select nextActionName from tbl_add_default_close_lead_status where process_id='$this->process_id'")->result();
		if(count($status_query)>0)
		{
			$default_close_lead_status=$status_query[0]->nextActionName;
			//echo $default_close_lead_status;
			$default_close_lead_status=json_decode($default_close_lead_status);
			return $default_close_lead_status;
		}		
	}
	//Get Location Of User
	public function select_location() {

	
		$this -> db -> select('l.location_id,l.location');
		$this -> db -> from('tbl_location l');
		$this->db->join('tbl_manager_process p','p.location_id=l.location_id');
		$this->db->where('p.process_id',$this->process_id);
		$this -> db -> where('p.user_id', $this->user_id);
		$this -> db -> where('p.status !=','-1');
			/*if($this->role !='1' && $this->role !='2')
			{*/
				
		//$this -> db -> where('l.location_id', $this->location_id);
	//	}
		//$this->db->group_by('l.location_id');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}
	
	public function location_data($location_name){
			$user=$this->input->post('user');
			$select_role=array("3","4","8","10","12","14","16");
			$this -> db -> select('u.id,u.fname,u.lname,u.location ,u.role,l.location as location_name');
			$this -> db -> from('lmsuser u');
			$this->db->join('tbl_manager_process p','p.user_id=u.id');
			$this->db->join('tbl_location l','l.location_id=p.location_id');
			$this->db->join('tbl_mapdse m','m.dse_id=u.id','left');
		
			$this -> db -> where('p.location_id', $location_name);
			
			$this -> db -> where('p.process_id', $this->process_id);
			$this -> db -> where('u.status', 1);
		
				if(in_array($this->role,$select_role)){
					$this->db->where('id',$this->user_id);
				}else{
					if($user=='DSE'){
					
					if(in_array($_SESSION['role_name'],$this->tl_role)){
					$this->db->where('m.tl_id',$this->user_id);
					}else{
						$this->db->where_in('role_name',$this->executive_role);
					}
					
					}else{
						
					if(in_array($_SESSION['role_name'],$this->tl_role)){
					$this->db->where('id',$this->user_id);
					}else{
						$this->db->where_in('role_name',$this->tl_role);
					}
					}
			}
		$this -> db -> group_by('u.id');
		$this -> db -> order_by('u.fname', 'asc');
			$query = $this -> db -> get() ;
			if($this->user_id=='538')
			{
				//echo $this->db->last_query();
			}

			//
			$query=$query-> result();
			//print_r($query);
			if(count($query)>0){
			foreach($query as $row){
			
					if($_SESSION['process_id']==6 ||$_SESSION['process_id']==7 || $_SESSION['process_id']==8)
					{
						//echo "hhhhhhhhhhhh";
				$escalation_level_1=$this -> escalation_level_1($row -> id,$row->role);
				$escalation_level_2=$this -> escalation_level_2($row -> id,$row->role);
				$escalation_level_3=$this -> escalation_level_3($row -> id,$row->role);
				$con = 'f.appointment_type="Evaluation Allotted"';
				$con1='Evaluation Allotted';
				$evaluation_count = $this -> check_count($con1,$con, $row -> id,$row->role);
					}
					else {
					$escalation_level_1=0;	
					$escalation_level_2=0;
					$escalation_level_3=0;
					$evaluation_count=0;
					}
				
				$select_leads[] = array('id'=>$row -> id,'role'=>$row->role, 'location_name'=>$row->location_name,'fname' => $row -> fname, 'lname' => $row -> lname, 'evaluation_count' => $evaluation_count,
				'escalation_level_1' => $escalation_level_1, 'escalation_level_2' => $escalation_level_2	, 'escalation_level_3' => $escalation_level_3);
			
			}
			}else{
				//$select_leads[] = array('id'=>'','role'=>'', 'location_name'=>'','fname' => '', 'lname' => '', 'unassigned_leads' => '',  'new_leads' => '','call_today' => '', 'pending_new_leads' => '', 'pending_followup' => '');
			$select_leads = array();
				
			}
			return	$select_leads;
	}
public function check_count($con1,$con,$id,$role) {

		
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as call_today');
		$this -> db -> from($this->table_name.' ln');
		if($_SESSION['process_id']==8){
				if($_SESSION['sub_poc_purchase']==2){
					$this -> db -> where('ln.nextAction_for_tracking', 'Evaluation Done');
				}
			$this -> db -> where('ln.evaluation', 'Yes');
		}else
		{
			$this -> db -> where('ln.process', $this->process_name);
		}
		//$this -> db -> join($this->table_name1.' f','f.leadid=ln.enq_id');
		if($role == '5')
		{
			$this -> db -> join($this->table_name1.' f','f.id=ln.dse_followup_id');
			$this -> db -> where('ln.assign_to_dse_tl',$id);
		}
		elseif($role == '4')
		{
			$this -> db -> join($this->table_name1.' f','f.id=ln.dse_followup_id');
			$this -> db -> where('ln.assign_to_dse_tl!=',0);
			$this -> db -> where('ln.assign_to_dse', $id);
		}elseif($role == '15')
		{
			$this -> db -> join($this->table_name1.' f','f.id=ln.exe_followup_id');
			$this -> db -> where('ln.assign_to_e_tl',$id);
		}
		elseif($role == '16')
		{
			$this -> db -> join($this->table_name1.' f','f.id=ln.exe_followup_id');
			$this -> db -> where('ln.assign_to_e_tl!=',0);
			$this -> db -> where('ln.assign_to_e_exe', $id);
		}
		elseif (in_array($role,$this->executive_array)) {
			$this -> db -> join($this->table_name1.' f','f.id=ln.cse_followup_id');
			$this -> db -> where('ln.assign_to_cse', $id);
			//$this -> db -> where('ln.assign_to_dse_tl',0);
		}elseif(in_array($role,$this->tl_array)){
			$this -> db -> join($this->table_name1.' f','f.id=ln.cse_followup_id');
			$this -> db -> where('assign_by_cse_tl', $id);
		}
		$this -> db -> where($con);
	//	$this -> db -> where('ln.process', $this->process_name);
		/*if($con1=='Home Visit')
		{
			$this -> db -> where('f.td_hv_date', $this->today);
		}
		else {*/
			$this -> db -> where('f.appointment_date', $this->today);
		//}
		//$this -> db -> where('f.td_hv_date', $this->today);
		//$this -> db -> where('ln.nextAction!=', "Close");	
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_call_today = $query1[0] -> call_today;
		return $total_call_today;
	}
public function escalation_level_1($id,$role){
		
	//$today=date('Y-m-d');
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(distinct(enq_id)) as new_leads');
		$this -> db -> from($this->table_name.' ln');
		//$this -> db -> join($this->table_name1.' f','f.leadid=ln.enq_id','left');
		if($_SESSION['process_id']==8){
			if($_SESSION['sub_poc_purchase']==2)
			{
					$this -> db -> where('ln.nextAction_for_tracking', 'Evaluation Done');
			
			}
		
			$this -> db -> where('ln.evaluation', 'Yes');
		}else
		{
			$this -> db -> where('ln.process', $this->process_name);
		}
		$this -> db -> where('esc_level1', "Yes");
		if($role == '5')
		{
			$this -> db -> where('ln.assign_to_dse_tl',$id);
		}
		elseif($role == '4')
		{
			$this -> db -> where('ln.assign_to_dse_tl!=',0);
			$this -> db -> where('ln.assign_to_dse', $id);
		}
		elseif($role == '15')
		{
			$this -> db -> where('ln.assign_to_e_tl',$id);
		}
		elseif($role == '16')
		{
			$this -> db -> where('ln.assign_to_e_tl!=',0);
			$this -> db -> where('ln.assign_to_e_exe', $id);
		}
		elseif (in_array($role,$this->executive_array)) {
			$this -> db -> where('ln.assign_to_cse', $id);
		}elseif(in_array($role,$this->tl_array)){
			$this -> db -> where('assign_by_cse_tl', $id);
		}
		
		$this -> db -> where('ln.esc_level1_resolved', " ");
		$default_close_lead_status=$this->select_default_close_lead_status();
		if(isset($default_close_lead_status))
		{
			$this->db->where_not_in('ln.nextAction',array_values($default_close_lead_status));			
		}
		/*$this -> db -> where('ln.nextAction!=', "Close");
		$this -> db -> where('ln.nextAction!=', "Booked From Autovista");*/
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		
		$total_new_lead = $query1[0] -> new_leads;
		return $total_new_lead;
		}
	public function escalation_level_2($id,$role){
		
	//$today=date('Y-m-d');
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(distinct(enq_id)) as new_leads');
		$this -> db -> from($this->table_name.' ln');
		//$this -> db -> join($this->table_name1.' f','f.leadid=ln.enq_id');
	if($_SESSION['process_id']==8){
		if($_SESSION['sub_poc_purchase']==2)
			{
			$this -> db -> where('ln.nextAction_for_tracking', 'Evaluation Done');
			
			}
		
			$this -> db -> where('ln.evaluation', 'Yes');
		}else
		{
			$this -> db -> where('ln.process', $this->process_name);
		}
		$this -> db -> where('esc_level2', "Yes");
		if($role == '5')
		{
			$this -> db -> where('ln.assign_to_dse_tl',$id);
		}
		elseif($role == '4')
		{
			$this -> db -> where('ln.assign_to_dse_tl!=',0);
			$this -> db -> where('ln.assign_to_dse', $id);
		}elseif($role == '15')
		{
			$this -> db -> where('ln.assign_to_e_tl',$id);
		}
		elseif($role == '16')
		{
			$this -> db -> where('ln.assign_to_e_tl!=',0);
			$this -> db -> where('ln.assign_to_e_exe', $id);
		}
		elseif (in_array($role,$this->executive_array)) {
			$this -> db -> where('ln.assign_to_cse', $id);
		}elseif(in_array($role,$this->tl_array)){
			$this -> db -> where('assign_by_cse_tl', $id);
		}
		
		$this -> db -> where('ln.esc_level2_resolved', " ");
		$default_close_lead_status=$this->select_default_close_lead_status();
		if(isset($default_close_lead_status))
		{
			$this->db->where_not_in('ln.nextAction',array_values($default_close_lead_status));			
		}
	/*	$this -> db -> where('ln.nextAction!=', "Close");
		$this -> db -> where('ln.nextAction!=', "Booked From Autovista");*/
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_new_lead = $query1[0] -> new_leads;
		return $total_new_lead;
		}
public function escalation_level_3($id,$role){
		
	//$today=date('Y-m-d');
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(distinct(enq_id)) as new_leads');
		$this -> db -> from($this->table_name.' ln');
		//$this -> db -> join($this->table_name1.' f','f.leadid=ln.enq_id');
			if($this->process_id==8){
				if($_SESSION['sub_poc_purchase']==2)
			{
				$this -> db -> where('ln.nextAction_for_tracking', 'Evaluation Done');
			
			}
		
			$this -> db -> where('ln.evaluation', 'Yes');
		}else{
		$this -> db -> where('ln.process', $this->process_name);
		}
		$this -> db -> where('esc_level3', "Yes");
		if($role == '5')
		{
			$this -> db -> where('ln.assign_to_dse_tl',$id);
		}
		elseif($role == '4')
		{
			$this -> db -> where('ln.assign_to_dse_tl!=',0);
			$this -> db -> where('ln.assign_to_dse', $id);
		}elseif($role == '15')
		{
			$this -> db -> where('ln.assign_to_e_tl',$id);
		}
		elseif($role == '16')
		{
			$this -> db -> where('ln.assign_to_e_tl!=',0);
			$this -> db -> where('ln.assign_to_e_exe', $id);
		}
		elseif (in_array($role,$this->executive_array)) {
			$this -> db -> where('ln.assign_to_cse', $id);
		}elseif(in_array($role,$this->tl_array)){
			$this -> db -> where('assign_by_cse_tl', $id);
		}
		
		$this -> db -> where('ln.esc_level3_resolved', " ");
		$default_close_lead_status=$this->select_default_close_lead_status();
		if(isset($default_close_lead_status))
		{
			$this->db->where_not_in('ln.nextAction',array_values($default_close_lead_status));			
		}
	/*	$this -> db -> where('ln.nextAction!=', "Close");
		$this -> db -> where('ln.nextAction!=', "Booked From Autovista");*/
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_new_lead = $query1[0] -> new_leads;
		return $total_new_lead;
		}
	

}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	//select new lead count
	/*public function location_wise_data($location_name) {
	
		if ($location_name != 38) {

			//DSE
			$this -> db -> select('u.id,u.fname,u.lname,u.location ,u.role,l.location as location_name');
			$this -> db -> from('lmsuser u');
			$this->db->join('tbl_location l','l.location_id=u.location');
			$this -> db -> where('u.location', $location_name);
			$this -> db -> where('status', 1);
			
			if($this->role == '4' || $this->role == '5')
			{
			
				$this -> db -> where('id', $this->user_id);
			}
		
				
			else{
			$this -> db -> where('role', 5);
			$this -> db -> where('role_name', 'DSE Team Leader');
			}
			$query = $this -> db -> get() -> result();
			echo $this->db->last_query();
			if (count($query) > 0) {
				foreach ($query as $row) {
						$unassigned_leads = $this -> unassigned_leads1($row -> id);
					$new_leads = $this -> new_leads1($row -> id);
				
					$call_today = $this -> call_today1($row -> id);
					echo $pending_new_leads = $this -> pending_new_leads1($row -> id);
					$pending_followup = $this -> pending_followup1($row -> id);
					$select_leads[] = array('id'=>$row -> id,'location_name'=>$row->location_name,'fname' => $row -> fname, 'lname' => $row -> lname, 'new_leads' => $new_leads, 'unassigned_leads' => $unassigned_leads, 'call_today' => $call_today, 'pending_new_leads' => $pending_new_leads, 'pending_followup' => $pending_followup);
				}
			}else{
				$select_leads[]=array();
			}
		} else {
				//Without DSE And DSE TL
			//CSE
			$this -> db -> select('u.id,u.fname,u.lname,u.location ,u.role,l.location as location_name');
			$this -> db -> from('lmsuser u');
			$this->db->join('tbl_location l','l.location_id=u.location');
			$this->db->join('tbl_manager_process p','p.user_id=u.id');
			
			$this -> db -> where('p.process_id', $this->process_id);
			$this -> db -> where('u.location', $location_name);
			$this -> db -> where('status', 1);
			$this->executive_array2=array("3","7","9","10","11","12","13","14");
				if (in_array($this->role,$this->executive_array2)) {
					$this->db->where('id',$this->user_id);
				}else{
					$this->db->where_in('role_name',$this->tl_role);
				}
			$query = $this -> db -> get() -> result();
			//echo $this->db->last_query();
				if (count($query) > 0) {
				foreach ($query as $row) {
			$unassigned_leads = $this -> unassigned_leads_cse($row->id,$location_name);
			$new_leads = $this -> new_leads_cse($location_name);
			$call_today = $this -> call_today_cse($location_name);
			$pending_new_leads = $this -> pending_new_leads_cse($location_name);
			$pending_followup = $this -> pending_followup_cse($location_name);
			$select_leads[] = array('id'=>$row->id,'location_name'=>$row->location_name,'fname' => $row->fname, 'lname' => $row->lname, 'new_leads' => $new_leads, 'unassigned_leads' => $unassigned_leads, 'call_today' => $call_today, 'pending_new_leads' => $pending_new_leads, 'pending_followup' => $pending_followup);

		}
				}else{
					$select_leads[]=array('id'=>'','location_name'=>'','fname' => '', 'lname' => '', 'new_leads' => '', 'unassigned_leads' => '', 'call_today' => '', 'pending_new_leads' => '', 'pending_followup' => '');

				}
		}
		
		return $select_leads;

	}
	
	
	
	/////////////////////////////// All Users And Role except DSE and DSE TL ////////////////////////////////////////////
public function unassigned_leads_cse($id,$location_name) {
		$this -> db -> select('count(enq_id) as unassign');
		$this -> db -> from($this->table_name.' ln');
		$this -> db -> where('assign_by_cse_tl', 0);
		if (in_array($this->role,$this->executive_array)) {
				$this -> db -> where('ln.assign_to_cse', $this->user_id);
		}
		$this -> db -> where('ln.process', $this->process_name);
		$this -> db -> where('ln.nextAction!=', "Close");
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_unassigned = $query1[0] -> unassign;
		return $total_unassigned;

	}

	public function unassigned_leads1($id) {
		$this -> db -> select('count(enq_id) as unassign');
		$this -> db -> from($this->table_name.' ln');
		$this -> db -> where('ln.assign_to_dse_tl!=', '0');
		$this -> db -> where('ln.assign_to_dse_date', '0000-00-00');
		$this -> db -> where('ln.process', $this->process_name);
		if($this->role == '4')
			{
			
			$this -> db -> where('ln.assign_to_dse', $this->user_id);
			}
		if($this->role == '5')
			{
		
			$this -> db -> where('ln.assign_to_dse_tl',$this->user_id);
			}	
			
		else
			{
			
			$this -> db -> where('ln.assign_to_dse_tl', $id);
			}
		
		//$this -> db -> where('ln.assign_to_dse_tl', $id);
		$this -> db -> where('ln.nextAction!=', "Close");
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_unassigned = $query1[0] -> unassign;
		return $total_unassigned;

	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function new_leads_cse($location_name) {
		$today = date('Y-m-d');
		$yesterday = date("Y-m-d", strtotime('-1 days'));
		$this -> db -> select('count(ln.enq_id) as newlead');
		$this -> db -> from($this->table_name.' ln');
		$this -> db -> join('lmsuser u', 'u.id=ln.assign_to_cse');
		$this -> db -> where('ln.cse_followup_id', '0');
		$this -> db -> where('ln.assign_to_cse_date', $today);
		$this -> db -> where('u.location', $location_name);
		if (in_array($this->role,$this->executive_array)) {
			$this -> db -> where('ln.assign_to_cse', $this->user_id);
		}
		$this -> db -> where('ln.process', $this->process_name);
		$query1 = $this -> db -> get();
		//echo $this->db->last_query();
		$query = $query1 -> result();
		$total_new_lead = $query[0] -> newlead;
		//echo $total_new_lead;
		return $total_new_lead;

	}

	public function call_today_cse($location_name) {

		$today = date('Y-m-d');
		$this -> db -> select('count(lm.id) as calltoday');
		$this -> db -> from($this->table_name.' ln');
		$this -> db -> join($this->table_name1.' lm', 'lm.id=ln.cse_followup_id');
		$this -> db -> join('lmsuser u', 'u.id=lm.assign_to','left');
		$this -> db -> where('lm.nextfollowupdate', $today);
		$this -> db -> where('u.location', $location_name);
			$this -> db -> where('ln.assign_to_dse_tl', 0);
		if (in_array($this->role,$this->executive_array)) {
			
			//$cse_id=$_SESSION['user_id'];
			$this -> db -> where('ln.assign_to_cse', $this->user_id);
			
			// if u dont want to show transferred leads.
          //  $this -> db -> where('ln.assign_to_dse_tl',0);
			}
		$this -> db -> where('ln.process', $this->process_name);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_call_today = $query1[0] -> calltoday;
		return $total_call_today;

	}

	public function pending_new_leads_cse($location_name) {
		$today = date('Y-m-d');
		$yesterday = date("Y-m-d", strtotime('-1 days'));
		$this -> db -> select('count(ln.enq_id) as pendingnewlead');
		$this -> db -> from($this->table_name.' ln');
		$this -> db -> join('lmsuser u', 'u.id=ln.assign_to_cse');
		$this -> db -> where('ln.cse_followup_id', '0');
		$this -> db -> where('ln.assign_to_cse_date <=', $yesterday);
		$this -> db -> where('u.location', $location_name);
		// check process
			$this -> db -> where('ln.process',$this->process_name);
			$this -> db -> where('ln.assign_to_dse_tl', 0);
	if (in_array($this->role,$this->executive_array)) {
			
			//$cse_id=$_SESSION['user_id'];
			$this -> db -> where('ln.assign_to_cse', $this->user_id);
			// if u dont want to show transferred leads.
         //   $this -> db -> where('ln.assign_to_dse_tl',0);
			}
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_pending_new = $query1[0] -> pendingnewlead;
		return $total_pending_new;
	}

	public function pending_followup_cse($location_name) 	
	{

		$today = date('Y-m-d');
		$this -> db -> select('count(distinct lm.id) as pedingnewfollowup');
		$this -> db -> from($this->table_name.' l');
		$this -> db -> join($this->table_name1.' lm', 'l.cse_followup_id=lm.id');
		$this -> db -> join('lmsuser u', 'u.id=l.assign_to_cse');
		$this -> db -> where('lm.nextfollowupdate<', $today);
		$this -> db -> where('lm.nextfollowupdate!=', '0000-00-00');
		$this -> db -> where('u.location', $location_name);
		// check process
			$this -> db -> where('l.process',$this->process_name);
		$this -> db -> where('l.assign_to_dse_tl', 0);
		if (in_array($this->role,$this->executive_array)) 
			{
			
			$this -> db -> where('l.assign_to_cse', $this->user_id);
			// if u dont want to show transferred leads.
            $this -> db -> where('l.assign_to_dse_tl',0);
			}

		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_pending_followup = $query1[0] -> pedingnewfollowup;
		return $total_pending_followup;

	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
/////////////////////////////  DSE OR DSE TL ONLY /////////////////////////////////////////// 
		





	public function new_leads1($tl_id) {
		$today = date('Y-m-d');
		$yesterday = date("Y-m-d", strtotime('-1 days'));
		$this -> db -> select('count(ln.enq_id) as newlead');
		$this -> db -> from('lead_master ln');
		$this -> db -> where('ln.dse_followup_id', '0');
		$this -> db -> where('ln.assign_to_dse_date ', $today);
		$this -> db -> where('ln.process', $this->process_name);
		if($this->role == '4')
			{
			//$dse_id=$_SESSION['user_id'];
			$this -> db -> where('ln.assign_to_dse', $this->user_id);
			}
			if($this->role == '5')
			{
			//$dse_id=$_SESSION['user_id'];
			$this -> db -> where('ln.assign_to_dse_tl', $this->role);
			}
			else
			{
				if($this->role != '4')
			{
			//$dse_id=$_SESSION['user_id'];
			$this -> db -> where('ln.assign_to_dse_tl', $tl_id);
			}
			}
			//echo $tl_id;
		
		
		//$this -> db -> where('ln.assign_to_dse_tl', $tl_id);

		$query1 = $this -> db -> get();
		//echo $this->db->last_query();
		$query = $query1 -> result();
		$total_new_lead = $query[0] -> newlead;
		//echo $total_new_lead;
		return $total_new_lead;

	}

	
	public function call_today1($id) {

		$today = date('Y-m-d');
		$this -> db -> select('count(lm.id) as calltoday');
		$this -> db -> from($this->table_name.' ln');
		$this -> db -> join($this->table_name1.' lm', 'lm.id=ln.dse_followup_id');
		$this -> db -> where('lm.nextfollowupdate', $today);
	$this -> db -> where('ln.process', $this->process_name);
		if($this->role == '4')
			{
			//$dse_id=$_SESSION['user_id'];
			$this -> db -> where('ln.assign_to_dse', $this->user_id);
			}
			
		if($this->role == '5')
			{
			//$dse_id=$_SESSION['user_id'];
			$this -> db -> where('ln.assign_to_dse_tl', $this->user_id);
			}
			
		else
			{
				if($this->role!=4){
					//$dse_id=$_SESSION['user_id'];
			$this -> db -> where('ln.assign_to_dse_tl', $id);
				}
			
			}
		
		
		//$this -> db -> where('ln.assign_to_dse_tl', $id);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_call_today = $query1[0] -> calltoday;
		return $total_call_today;

	}

	public function pending_new_leads1($id)
	{
		echo $id;
		$today = date('Y-m-d');
		$yesterday = date("Y-m-d", strtotime('-1 days'));
		$this -> db -> select('count(ln.enq_id) as pendingnewlead');
		$this -> db -> from($this->table_name.' ln');
		$this -> db -> where('ln.dse_followup_id', '0');
		// check process
			$this -> db -> where('ln.process',$this->process_name);
		
		if($this->role == '4')
		{
			//$dse_id=$_SESSION['user_id'];
			$this -> db -> where('ln.assign_to_dse', $this->user_id);
			$this -> db -> where('ln.assign_to_dse_date <=', $yesterday);
		}
		else if($this->role == '5')
		{
			//$dse_id=$_SESSION['user_id'];
			$this -> db -> where('ln.assign_to_dse_tl', $this->user_id);
			$this -> db -> where('ln.assign_to_dse_tl_date <=', $yesterday);
		}
		else
		{
			if($this->role != '4')
			{
				$this -> db -> where('ln.assign_to_dse_tl', $id);
				$this -> db -> where('ln.assign_to_dse_tl_date <=', $yesterday);
			}
		}
		//$this -> db -> where('ln.assign_to_dse_tl', $id);
		$query = $this -> db -> get();
		echo $this->db->last_query();
		$query1 = $query -> result();
		$total_pending_new = $query1[0] -> pendingnewlead;
		return $total_pending_new;
	}

	public function pending_followup1($id) {

		$today = date('Y-m-d');
		$this -> db -> select('count(lm.id) as pedingnewfollowup');
		$this -> db -> from($this->table_name.' l');
		$this -> db -> join($this->table_name1.' lm', 'l.dse_followup_id=lm.id');
		$this -> db -> where('lm.nextfollowupdate<', $today);
		$this -> db -> where('lm.nextfollowupdate!=', '0000-00-00');
		// check process
			$this -> db -> where('l.process',$this->process_name);
		if($this->role == '4')
		{
			
			$this -> db -> where('l.assign_to_dse', $this->user_id);
		}
		else if($this->role == '5')
		{
			//$dse_id=$_SESSION['user_id'];
			$this -> db -> where('l.assign_to_dse_tl', $this->user_id);
		}
		else
		{
			$this -> db -> where('l.assign_to_dse_tl', $id);
		}		
		//$this -> db -> where('l.assign_to_dse_tl', $id);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_pending_followup = $query1[0] -> pedingnewfollowup;
		return $total_pending_followup;
	}


}*/
