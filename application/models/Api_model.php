<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class api_model extends CI_model {
	function __construct() {
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");	
		$this->today=date('Y-m-d');
		$this->time=date("h:i:s A");
	}
	public function select_table($process_id)
	{
		
		if ($process_id == 6 || $process_id == 7) {
			
			$lead_master_table = 'lead_master';
			$lead_followup_table = 'lead_followup';
			$request_to_lead_transfer_table = 'request_to_lead_transfer';
			$selectElement='`tloc`.`location` as `showroom_location`, `l`.`assign_to_dse_tl`, `l`.`assign_to_dse`,l.assign_to_dse_date,l.assign_to_dse_time,l.assign_to_dse_tl_date,l.assign_to_dse_tl_time,
				`udse`.`fname` as `dse_fname`, `udse`.`lname` as `dse_lname`, `udse`.`role` as `dse_role`,  `udsetl`.`fname` as `dsetl_fname`, `udsetl`.`lname` as `dsetl_lname`, `udsetl`.`role` as `dsetl_role`,
					`dsef`.`date` as `dse_date`, `dsef`.`nextfollowupdate` as `dse_nfd`,`dsef`.`nextfollowuptime` as `dse_nftime`, `dsef`.`comment` as `dse_comment`, `dsef`.`td_hv_date`, `dsef`.`nextAction` as `dsenextAction`, `dsef`.`feedbackStatus` as `dsefeedback`,`dsef`.`contactibility` as `dsecontactibility`,`dsef`.`created_time` as `dse_time`
			, `m1`.`model_name` as `old_model_name`, `m2`.`make_name`';
			$selectElement1='l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id,l.esc_level1,l.esc_level1_remark,l.esc_level2,l.esc_level2_remark,l.esc_level3,l.esc_level3_remark,l.esc_level1_resolved ,l.esc_level2_resolved,l.esc_level3_resolved,esc_level1_resolved_remark,esc_level2_resolved_remark,esc_level3_resolved_remark,l.alternate_contact_no';
			
		} 
		elseif ($process_id == 8) {
			$lead_master_table = 'lead_master';
			$lead_followup_table = 'lead_followup';
			$request_to_lead_transfer_table = 'request_to_lead_transfer';
			$selectElement='`tloc`.`location` as `showroom_location`, l.assign_to_e_exe as assign_to_dse,l.assign_to_e_tl as assign_to_dse_tl,l.assign_to_e_exe_date as assign_to_dse_date,l.assign_to_e_exe_time as assign_to_dse_time,l.assign_to_e_tl_date as assign_to_dse_tl_date,l.assign_to_e_tl_time as assign_to_dse_tl_time,
				`udse`.`fname` as `dse_fname`, `udse`.`lname` as `dse_lname`, `udse`.`role` as `dse_role`,  `udsetl`.`fname` as `dsetl_fname`, `udsetl`.`lname` as `dsetl_lname`, `udsetl`.`role` as `dsetl_role`,
					`dsef`.`date` as `dse_date`, `dsef`.`nextfollowupdate` as `dse_nfd`,`dsef`.`nextfollowuptime` as `dse_nftime`, `dsef`.`comment` as `dse_comment`, `dsef`.`td_hv_date`, `dsef`.`nextAction` as `dsenextAction`, `dsef`.`feedbackStatus` as `dsefeedback`,`dsef`.`contactibility` as `dsecontactibility`,`dsef`.`created_time` as `dse_time`
			, `m1`.`model_name` as `old_model_name`, `m2`.`make_name`';
			$selectElement1='l.assign_to_e_exe as assign_to_dse,l.assign_to_e_tl as assign_to_dse_tl,l.exe_followup_id as dse_followup_id,l.esc_level1,l.esc_level1_remark,l.esc_level2,l.esc_level2_remark,l.esc_level3,l.esc_level3_remark,l.alternate_contact_no,l.reg_no,l.quotated_price,l.expected_price';
		}
		else {
			
			$lead_master_table = 'lead_master_all';
			$lead_followup_table = 'lead_followup_all';
			$request_to_lead_transfer_table = 'request_to_lead_transfer_all';
			$selectElement='csef.file_login_date,csef.login_status_name,csef.approved_date,csef.disburse_date,csef.disburse_amount,csef.process_fee,csef.emi,csef.eagerness,l.bank_name,l.loan_type,l.los_no,l.roi,l.tenure,l.loanamount,l.dealer,l.executive_name,l.alternate_contact_no';
			$selectElement1='l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id';
		}
	
		return array( 'lead_master_table'=>$lead_master_table,'lead_followup_table'=>$lead_followup_table,'request_to_lead_transfer_table'=>$request_to_lead_transfer_table,'select_element'=>$selectElement,'select_element1'=>$selectElement1) ;
		
	}
	//Spiner
	function select_lead_source($process_id) {
			
		$this->db->select('*');
		$this->db->from('lead_source');
		$this->db->where('process_id',$process_id);
		$query=$this->db->get();	
		return $query->result();
		

	}
public function select_user($process_id)
	{
		$where="(l.process_id='$process_id' or m.process_id='$process_id')";	
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser l');
	
		$this -> db -> join('tbl_rights r', 'r.user_id=l.id');
	//	$this -> db -> join('tbl_manager_process m', 'm.user_id=l.id','left');
		$this -> db -> where('r.form_name', 'Calling Notification');
		$this -> db -> where('l.process_id',$process_id);
			$this -> db -> where('l.role !=', '2');
		$this -> db -> where('r.view', '1');
		$this -> db -> where('status', '1');
		//$this -> db -> where($where);
		$this -> db -> group_by("l.id");
		$this -> db -> order_by("fname", "asc");
		$query = $this -> db -> get();
		//echo $this -> db -> last_query();
		return $query -> result();
	
	}
	
	//Select feedback
	function select_feedback($process_id) {
		$this -> db -> select('*');
		$this -> db -> from('tbl_feedback_status');
		$this -> db -> where('fstatus!=', 'Deactive');
		$this -> db -> where('process_id', $process_id);
		$query = $this -> db -> get();
		//	echo $this->db->last_query();
		return $query -> result();

	}

	public function select_next_action_feedback($process_id,$feedback){
		//$process_id = $_SESSION['process_id'];
		$this -> db -> select('*');
		$this -> db -> from('tbl_mapNextAction');
		$this -> db -> where('map_next_to_feed_status!=', 'Deactive');
		$this -> db -> where('process_id', $process_id);
		if($feedback!=''){
		$this -> db -> where('feedbackStatusName', $feedback);
		}
		$query = $this -> db -> get();
		//	echo $this->db->last_query();
		return $query -> result();
		
	}
	public function select_model($make_id)
	{
		if($make_id=='')
		{
			$make_id=1;
		}
		$this -> db -> select('make_id,model_id,model_name');
		$this -> db -> from('make_models');
		$this -> db -> where('make_id', $make_id);
		$this->db->where('status!=','-1');
		
		$query = $this -> db -> get();
		return $query -> result();
	}
	public function select_make() {
		$this -> db -> select('make_id,make_name');
		$this -> db -> from('makes');
			$this->db->where('is_active ','1');
		$query = $this -> db -> get();
		return $query -> result();
	}
	function model_variant($model_id) {
		$this -> db -> select('variant_id,variant_name');
		$this -> db -> from('model_variant');
		$this -> db -> where('model_id', $model_id);
		$query = $this -> db -> get();
		return $query -> result();
	}
	
		public function select_login_status()
	{
		$this -> db -> select('login_status_name');
		$this -> db -> from('tbl_loginstatus');
		$this -> db -> where('status!=', '-1');
		$query = $this -> db -> get();
		return $query -> result();
	}
	public function select_accessories()
	{
		$this -> db -> select('*');
		$this -> db -> from('accessories');
		$this->db->where('status!=','-1');
		$query = $this -> db -> get();
		return $query -> result();
	}
	public function select_accessories_car_model()
	{
		$this -> db -> select('model_id,model_name');
		$this -> db -> from('make_models');
		$this->db->where('status!=','-1');
		$this->db->where('make_id','1');
		$this->db->or_where('model_id','159');
		$query = $this -> db -> get();
		return $query -> result();
	}
	
	// Get Location spinner
	public function select_location($process_id,$role,$location_id,$user_id)
	{
		/*$this -> db -> select('l.location_id,l.location');
		$this -> db -> from('tbl_location l');
		$this->db->join('tbl_manager_process p','p.location_id=l.location_id');
		$this->db->where('p.process_id',$process_id);
			if($role !='1' && $role !='2')
			{
				
		$this -> db -> where('l.location_id', $location_id);
		}
		$this->db->group_by('l.location_id');
		$query = $this -> db -> get();*/
		
		
		$this -> db -> select('l.location_id,l.location');
		$this -> db -> from('tbl_location l');
		$this->db->join('tbl_manager_process p','p.location_id=l.location_id');
		$this->db->where('p.status !=','-1');
		$this->db->where('l.location_status !=','Deactive');
		$this->db->where('p.process_id',$process_id);
		
		$this -> db -> where('p.user_id', $user_id);
			
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
	////////////////////////////////////////////////////////////////////////////////////////////////
	//Login lms user
	public function login_form($username, $password) {
		$order=" FIELD(p.process_id,'6', '7','8', '1', '4', '5','9')";
		$this -> db -> select('role,role_name,id,fname,lname,p1.process_id,p1.process_name,p.location_id as location_id,l.location');
		$this -> db -> from('lmsuser u');
		
		$this -> db -> join('tbl_manager_process p','p.user_id=u.id');
		$this -> db -> join('tbl_process p1','p1.process_id=p.process_id');
		
		$this -> db -> join('tbl_location l','l.location_id=p.location_id');
		
		$this -> db -> where('email', $username);
		$this -> db -> where('password', $password);
		$this -> db -> where('u.status', 1);
		$this->db->order_by($order);
		$this -> db -> limit(1);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}
	public function select_user_all_process($user_id)
	{
			$order=" FIELD(process_id,'6', '7', '1', '4', '5','9')";
			$query1 = $this->db->query("select p.process_id ,p.process_name 
									from lmsuser l 
									Left join tbl_manager_process mp on mp.user_id=l.id 
									Left join tbl_process p on p.process_id=mp.process_id
									where mp.user_id='$user_id' group by p.process_id order by FIELD(p.process_id, '6', '7','8', '1', '4', '5','9')")->result();
		
		foreach ($query1 as $row) {
			$location=$this->select_user_all_location($user_id,$row->process_id);
			$select_data[]=array('process_id'=>$row->process_id,'process_name'=>$row->process_name,'location'=>$location);
			
		}
return $select_data;	
}
public function select_user_all_location($user_id,$process_id)
{
		$query1 = $this->db->query("select l.location_id ,l.location 
									from lmsuser u
									Left join tbl_manager_process p on u.id=p.user_id
									Left join tbl_location l on p.location_id=l.location_id
									where p.user_id='$user_id' and p.process_id='".$process_id."' group by l.location_id")->result();
									//echo $this->db->last_query();
	return $query1;
}
public function get_right($id) {
		$this -> db -> select('right_id,user_id,process_id,form_name,view');
		$this -> db -> from('tbl_rights');
		$this -> db -> where('user_id', $id);
		$query = $this -> db -> get();
		return $query -> result();
		
	}
	public function get_rights_cross_lead($id) {
		$this -> db -> select('*');
		$this -> db -> from('tbl_rights_cross_lead');
		$this -> db -> where('user_id', $id);
		$query = $this -> db -> get();
		return $query -> result();
	}
	/////////////////////////////////////////////////////////////////////////
	
	
	//Change Password
	function change_password($old_pwd, $new_pwd,$user_id){

		$this -> db -> select('*');
		$this -> db -> from('lmsuser');
		$this -> db -> where('password', $old_pwd);
		$this -> db -> where('id', $user_id);
		$query = $this -> db -> get() -> result();

		if (count($query) > 0) {

			$this -> db -> query('update lmsuser set password="' . $new_pwd . '" where id="' . $user_id . '"');

			if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Data successfully Inserted.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}

		} else {

				$response["success"] = 0;
			$response["message"] = "Old password Not match.";
			echo json_encode($response);

		}

	

	}
	///////////////////////Dashboard Count////////////////////////////
	public function dashboard_count($process_name_seesion,$location_name_select,$process_id_session,$role_session,$user_id_session) {
			//Excecutive array
			$tl_role=array("CSE Team Leader","DSE Team Leader","Service TL","Insurance TL","Accessories TL","Finance TL");
			//Get Table Name
			$table=$this->select_table($process_id_session);
			
			$this -> db -> select('u.id,u.fname,u.lname,u.location ,u.role,l.location as location_name');
			$this -> db -> from('lmsuser u');
			$this->db->join('tbl_manager_process p','p.user_id=u.id');
			$this->db->join('tbl_location l','l.location_id=p.location_id');
		
			$this -> db -> where('p.location_id', $location_name_select);
			$this -> db -> where('p.process_id', $process_id_session);
			$this -> db -> where('u.status', 1);
			if($role_session!='1' && $role_session!='2'){
			
					$this->db->where('id',$user_id_session);
			}else{
					$this->db->where_in('role_name',$tl_role);
			}
			$query = $this -> db -> get() -> result();
			//echo $this->db->last_query();
			if(count($query)>0){
			foreach($query as $row){
	
				$unassigned_leads = $this -> unassigned_leads($row -> id,$row->role,$process_name_seesion,$table['lead_master_table'],$user_id_session);
				$new_leads=$this -> new_leads($row -> id,$row->role,$process_name_seesion,$table['lead_master_table'],$user_id_session);
				$call_today=$this -> call_today($row -> id,$row->role,$process_name_seesion,$table['lead_master_table'],$table['lead_followup_table'],$user_id_session);
				$pending_new_leads=$this -> pending_new($row -> id,$row->role,$process_name_seesion,$table['lead_master_table'],$user_id_session);
				$pending_followup=$this ->pending_followup($row -> id,$row->role,$process_name_seesion,$table['lead_master_table'],$table['lead_followup_table'],$user_id_session);
				$select_leads[] = array('id'=>$row -> id,'role'=>$row->role, 'location_name'=>$row->location_name,'fname' => $row -> fname, 'lname' => $row -> lname, 'unassigned_leads' => $unassigned_leads,  'new_leads' => $new_leads,'call_today' => $call_today, 'pending_new_leads' => $pending_new_leads, 'pending_followup' => $pending_followup);
			
			}
			}else{
				
				$select_leads = array();
				
			}
			 		return	$select_leads;

	}
		
	public function unassigned_leads($table_id,$table_role,$process_name_seesion,$table_name,$user_id_session){
		// Executive Role id
		$executive_array=array("3","8","10","12","14");
		// TL role Id
		$tl_array=array("2","7","9","11","13");
		//$table=$this->select_table($process_id_session);
			
		$this -> db -> select('count(enq_id) as unassign');
		$this -> db -> from($table_name.' ln');
		$this -> db -> where('ln.process', $process_name_seesion);
		$this -> db -> where('ln.nextAction!=', "Close");
		//DSE TL
		if($table_role == '5')
		{
			$this -> db -> where('ln.assign_to_dse_tl',$table_id);
			$this -> db -> where('ln.assign_to_dse', 0);
		}
		//DSE Executive
		elseif($table_role == '4')
		{
			$this -> db -> where('ln.assign_to_dse_tl',0);
			$this -> db -> where('ln.assign_to_dse', $user_id_session);
		}
		//CSE Executive
		elseif (in_array($table_role,$executive_array)) {
			$this -> db -> where('assign_by_cse_tl', 0);
			$this -> db -> where('ln.assign_to_cse', $user_id_session);
		}
		//TL 
		elseif(in_array($table_role,$tl_array)){
			$this -> db -> where('assign_by_cse_tl', 0);
		}
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_unassigned = $query1[0] -> unassign;
		return $total_unassigned;
	}	
	public function new_leads($table_id,$table_role,$process_name_seesion,$table_name,$user_id_session){
		
		$today=date('Y-m-d');
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as new_leads');
		$this -> db -> from($table_name.' ln');
		$this -> db -> where('ln.process', $process_name_seesion);
		$this -> db -> where('ln.nextAction!=', "Close");
		
		if($table_role == '5')
		{
			$this -> db -> where('dse_followup_id', 0);
			$this -> db -> where('ln.assign_to_dse_tl',$table_id);
			$this -> db -> where('ln.assign_to_dse_date', $today);
		}
		elseif($table_role == '4')
		{
			$this -> db -> where('dse_followup_id', 0);
			$this -> db -> where('ln.assign_to_dse_tl!=',0);
			$this -> db -> where('ln.assign_to_dse', $user_id_session);
			$this -> db -> where('ln.assign_to_dse_date', $today);
		}
		elseif (in_array($table_role,$this->executive_array)) {
			$this -> db -> where('cse_followup_id', 0);
			$this -> db -> where('ln.assign_to_cse', $user_id_session);
			$this -> db -> where('ln.assign_to_cse_date', $today);
		}elseif(in_array($table_role,$this->tl_array)){
			$this -> db -> where('assign_by_cse_tl', $table_id);
			$this -> db -> where('ln.assign_to_dse_tl',0);
			$this -> db -> where('ln.assign_to_cse_date', $today);
			$this -> db -> where('cse_followup_id',0);
		}
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_new_lead = $query1[0] -> new_leads;
		return $total_new_lead;
	}
	public function call_today($table_id,$table_role,$process_name_seesion,$table_name,$table_name1,$user_id_session){
		//echo $table_name1;
		$today=date('Y-m-d');
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as call_today');
		$this -> db -> from($table_name.' ln');
		if($table_role == '5')
		{
			$this -> db -> join($table_name1.' f','f.id=ln.dse_followup_id');
			$this -> db -> where('ln.assign_to_dse_tl',$table_id);
		}
		elseif($table_role == '4')
		{
			$this -> db -> join($table_name1.' f','f.id=ln.dse_followup_id');
			$this -> db -> where('ln.assign_to_dse_tl!=',0);
			$this -> db -> where('ln.assign_to_dse', $user_id_session);
		}
		elseif (in_array($table_role,$executive_array)) {
				$this -> db -> join($table_name1.' f','f.id=ln.cse_followup_id');
			//$this -> db -> join($table_name1.' f','f.id=ln.cse_followup_id');
			$this -> db -> where('ln.assign_to_cse', $user_id_session);
			$this -> db -> where('ln.assign_to_dse_tl',0);
		}elseif(in_array($table_role,$tl_array)){
			$this -> db -> join($table_name1.' f','f.id=ln.cse_followup_id');
			$this -> db -> where('assign_by_cse_tl', $table_id);
		}
		$this -> db -> where('ln.process', $process_name_seesion);
		$this -> db -> where('f.nextfollowupdate', $today);
		$this -> db -> where('ln.nextAction!=', "Close");	
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_call_today = $query1[0] -> call_today;
		return $total_call_today;
	}
public function pending_new($table_id,$table_role,$process_name_seesion,$table_name,$user_id_session){
		
		$today=date('Y-m-d');
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as pending_new');
		$this -> db -> from($table_name.' ln');
		$this -> db -> where('ln.process', $process_name_seesion);
		$this -> db -> where('ln.nextAction!=', "Close");
		
		if($table_role == '5')
		{
			$this -> db -> where('dse_followup_id', 0);
			$this -> db -> where('ln.assign_to_dse_tl',$table_id);
			$this -> db -> where('ln.assign_to_dse_date <', $today);
		}
		elseif($table_role == '4')
		{
			$this -> db -> where('ln.dse_followup_id', 0);
			$this -> db -> where('ln.assign_to_dse_tl!=',0);
			$this -> db -> where('ln.assign_to_dse', $user_id_session);
			$this -> db -> where('ln.assign_to_dse_date <', $today);
		}
		elseif (in_array($table_role,$this->executive_array)) {
			
			$this -> db -> where('cse_followup_id', 0);
			$this -> db -> where('ln.assign_to_cse',$user_id_session);
			$this -> db -> where('ln.assign_to_cse_date < ', $today);
		}
		elseif(in_array($table_role,$this->tl_array)) {
			$this -> db -> where('ln.assign_to_dse_tl', 0);
			$this -> db -> where('assign_by_cse_tl', $table_id);
			$this -> db -> where('ln.assign_to_cse_date < ', $today);
			$this -> db -> where('cse_followup_id', 0);
		}
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_pending_new = $query1[0] -> pending_new;
		return $total_pending_new;
	}
public function pending_followup($table_id,$table_role,$process_name_seesion,$table_name,$table_name1,$user_id_session){
		
		$today=date('Y-m-d');
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as call_today');
		$this -> db -> from($table_name.' ln');
		if($table_role == '5')
		{
			$this -> db -> join($table_name1.' f','f.id=ln.dse_followup_id');
			$this -> db -> where('ln.assign_to_dse_tl',$table_id);
		}
		elseif($table_role == '4')
		{
			$this -> db -> join($table_name1.' f','f.id=ln.dse_followup_id');
			$this -> db -> where('ln.assign_to_dse_tl!=',0);
			$this -> db -> where('ln.assign_to_dse', $user_id_session);
		}
		elseif (in_array($table_role,$executive_array)) {
			$this -> db -> join($table_name1.' f','f.id=ln.cse_followup_id');
			$this -> db -> where('ln.assign_to_cse', $user_id_session);
			$this -> db -> where('ln.assign_to_dse_tl',0);
		}elseif(in_array($table_role,$tl_array)){
			$this -> db -> join($table_name1.' f','f.id=ln.cse_followup_id');
			$this -> db -> where('assign_by_cse_tl', $table_id);
			$this -> db -> where('ln.assign_to_dse_tl',0);
		}
		$this -> db -> where('ln.process', $process_name_seesion);
		$this -> db -> where('f.nextfollowupdate <', $today);
		$this -> db -> where('f.nextfollowupdate!=', '0000-00-00');
		$this -> db -> where('ln.nextAction!=', "Close");	
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_call_today = $query1[0] -> call_today;
		return $total_call_today;
	}
//////////////////////////////////////////////////////////////////////////
	
	//Add New Customer
	public function select_user_for_new_customer($location, $process_id,$role_session,$user_id_session) {
		$all_array = array("2", "3", "5", "7", "9", "11", "13","15");
		$tl_array = array("2", "5", "7", "9", "11", "13","15");
			$executive_array = array("4", "8", "10", "12", "14","16");
			$tl_list = '("2","5", "7", "9", "11", "13","15")';
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser l');
		$this -> db -> join('tbl_manager_process u', 'u.user_id=l.id');
		$this -> db -> join('tbl_rights r', 'r.user_id=l.id');
		$this -> db -> where('r.form_name', 'Calling Notification');
		$this -> db -> where('r.view', '1');
		$this -> db -> where('l.status', '1');
		$this -> db -> where('u.process_id', $process_id);

		if ($role_session == 1 || $role_session == 2 || $role_session == 3) 
		{
			$this -> db -> where_in('role', $all_array);

		} elseif (in_array($role_session, $tl_array)) 
		{
			$q = $this -> db -> query('select dse_id from tbl_mapdse where tl_id="' . $user_id_session . '"') -> result();
			$c = count($q);
			$t = ' ( ';
			if (count($q) > 0) {
				for ($i = 0; $i < $c; $i++) {
					$t = $t . "id = " . $q[$i] -> dse_id . " or ";
				}
			}
			$t = $t . "role in" . $tl_list;
			$st = $t . ')';
			$this -> db -> where($st);
			}
			elseif (in_array($role_session, $executive_array)) {
			$q1 = $this -> db -> query('select tl_id from tbl_mapdse where dse_id="' . $user_id_session . '"') -> result();
			if (count($q1) > 0) {
				$q = $this -> db -> query('select dse_id from tbl_mapdse where tl_id="' . $q1[0] -> tl_id . '"') -> result();
				$c = count($q);
				$t = ' ( ';
				if (count($q) > 0) {
					for ($i = 0; $i < $c; $i++) {
						$t = $t . "id = " . $q[$i] -> dse_id . " or ";
					}

				}
				$t = $t . "role in" . $tl_list;
				$st = $t . ')';

				$this -> db -> where($st);

			} else {
				$t = $t . "role in" . $tl_list;
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
	public function add_customer($fname,$email,$address,$contact_no,$comment,$assign,$lead_source,$assignby,$username,$process_id,$location,$role_session,$user_id_session,$sub_lead_source){
	
	//Get Table Name
	$table=$this->select_table($process_id);	
	
	$executive_array = array("3", "8", "10", "12", "14");	
			$tl_array = array("2", "5", "7", "9", "11", "13");
	
	//Check Process Name	
	$checkProcessName = $this -> db -> query("select process_name from tbl_process where process_id='$process_id'") -> result();
	
	if (count($checkProcessName) > 0) {
			$process_name_select = $checkProcessName[0] -> process_name;
		} else {
			// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";
	}
		
		//Check User Already avaliable in db or not	
		$nextaction="(nextaction!='Close' or nextaction!='Lost')";
		$this -> db -> select("*");
		$this -> db -> from($table['lead_master_table']);
		$this -> db -> where('process', $process_name_select);
		$this -> db -> where('contact_no', $contact_no);
		$this -> db -> where($nextaction);
		$query = $this -> db -> get() -> result();

		if (count($query) > 0) {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Customer Already Exists.";

				// echoing JSON response
				echo json_encode($response);
		} else {

			$today = date("Y-m-d");

			$time = date("h:i:s A");

			$assign_date = date('Y-m-d');
			$assigntoCSEDate = $assign_date;
			$assigntoDSETLDate = $assign_date;
			$assigntoDSEDate = $assign_date;
			$assigntoCSETime = $time;
			$assigntoDSETLTime = $time;
			$assigntoDSETime = $time;
			$assignByCSE = 0;
			$assigntoDSETL = 0;
			$assigntoDSE = 0;
			$get_role = $this -> db -> query("select role,token from lmsuser where id='$assign'") -> result();
			 $assign_user_role = $get_role[0] -> role;
 			$tokens=$get_role[0] -> token;
 			$msg='New Lead Assigned';
			$this->send_notification($tokens,$msg);
			if ($assign_user_role == 5) {
				//CSETL,CSE,Process TL,process Executove,DSETL,DSE
				if ($role_session == 2 ||$role_session == 3) {
					$assignbyCSETL = $user_id_session;
					$assigntoCSE = $user_id_session;
					$assignByCSE = $user_id_session;
				} else {
				$getDefaultTl=$this->db->query("select call_center_tl_id from tbl_default_call_center_tl where process_id='$process_id' and status=1")->result();
					if(count($getDefaultTl) >0)
					{
						$assignbyCSETL = $getDefaultTl[0]->call_center_tl_id;
						$assigntoCSE = $getDefaultTl[0]->call_center_tl_id;
						$assignByCSE = $getDefaultTl[0]->call_center_tl_id;
					}
					else {
						$assignbyCSETL = 3;
						$assigntoCSE = 3;
						$assignByCSE = 3;
					}
				}
				$assigntoDSETL = $assign;
				$assigntoDSE = 0;
				$assigntoDSEDate = 0;
					$assigntoDSETime = 0;

			} elseif ($assign_user_role == 4) {
				if ($role_session == 4) {
					$checkDSETL = $this -> db -> query("select tl_id from tbl_mapdse where dse_id='$assign'") -> result();
					if (count($checkDSETL) > 0) {
						$assigntoDSETL = $checkDSETL[0] -> tl_id;
					} else {
						$assigntoDSETL = $assign_user_role;
					}
				} else {
					$assigntoDSETL = $user_id_session;
				}
				$getDefaultTl=$this->db->query("select call_center_tl_id from tbl_default_call_center_tl where process_id='$process_id' and status=1")->result();
					if(count($getDefaultTl) >0)
					{
						$assignbyCSETL = $getDefaultTl[0]->call_center_tl_id;
						$assigntoCSE = $getDefaultTl[0]->call_center_tl_id;
						$assignByCSE = $getDefaultTl[0]->call_center_tl_id;
					}
					else {
						$assignbyCSETL = 3;
						$assigntoCSE = 3;
						$assignByCSE = 3;
					}
				$assigntoDSE = $assign;
				
				

			} elseif (in_array($assign_user_role, $tl_array)) {
				// CSETL,CSE,ProcessTl,Process Executive,DSETl,DSE
				$assignbyCSETL = $assign;
				$assigntoCSE = $assign;
				$assigntoDSETLDate = 0;
				$assigntoDSEDate = 0;
				$assigntoDSETLTime = 0;
				$assigntoDSETime = 0;
			} elseif (in_array($assign_user_role, $executive_array)) {
				//Team Member,Team TL
				if ($role_session != 3) {
					
					$checkProcessTL = $this -> db -> query("select tl_id from tbl_mapdse where dse_id='$assign'") -> result();
					if (count($checkProcessTL) > 0) {
						$assignbyCSETL = $checkProcessTL[0] -> tl_id;
					} else {
						$assignbyCSETL = $user_id_session;
					}
				} else {
					$assignbyCSETL = $user_id_session;
				}
				$assigntoCSE = $assign;

				$assigntoDSETLDate = 0;
				$assigntoDSEDate = 0;
				$assigntoDSETLTime = 0;
				$assigntoDSETime = 0;
			}

			$username = $username;

			$query = $this -> db -> query("insert into " . $table['lead_master_table'] . "	(process,`lead_source`,`enquiry_for`,`manual_lead`,`name`,`email`,`address`,`contact_no`,`created_date`,`created_time`,	assign_by_cse_tl,assign_to_cse,assign_to_cse_date,assign_by_cse,assign_to_dse_tl,assign_to_dse_tl_date,assign_to_dse,assign_to_dse_date,assign_to_cse_time,assign_to_dse_tl_time,assign_to_dse_time,app)
				values('$process_name_select','$lead_source','$sub_lead_source','$username','$fname','$email','$address','$contact_no','$today','$time',	'$assignbyCSETL','$assigntoCSE','$assigntoCSEDate','$assignByCSE','$assigntoDSETL','$assigntoDSETLDate','$assigntoDSE','$assigntoDSEDate','$assigntoCSETime','$assigntoDSETLTime','$assigntoDSETime','1')");
			//echo $this -> db -> last_query();
			$enq_id = $this -> db -> insert_id();

			$insertQuery1 = $this -> db -> query("INSERT INTO " . $table['request_to_lead_transfer_table']  . "( `lead_id` , `assign_to` , `assign_by` , `location` , `created_date` , `created_time`  ,status)  VALUES('$enq_id','$assign','$user_id_session',' $location ','$assign_date','$time','Transfered')") or die(mysql_error());
			$transfer_id = $this -> db -> insert_id();
			$query = $this -> db -> query("update " . $table['lead_master_table'] . " set transfer_id='$transfer_id' where enq_id='$enq_id'");
			// }

			//$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Customer Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Data successfully Inserted.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}
		}
	
				
			
			
		}
		public function add_customer_evaluation($fname,$email,$address,$contact_no,$comment,$assign,$lead_source,$assignby,$username,$process_id,$location,$role_session,$user_id_session,$sub_lead_source)
		{
		
		$nextaction="(nextAction !='Close' and nextAction != 'Lost')";
		$this -> db -> select("*");
		$this -> db -> from('lead_master');
		//$this -> db -> where('process', $process);
		$this -> db -> where('contact_no', $contact_no);
		$this -> db -> where($nextaction);
		$query = $this -> db -> get() -> result();
		//echo $this->db->last_query();
		if (count($query) > 0) {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Customer Already Exists.";

				// echoing JSON response
				echo json_encode($response);
		}else{
		
		
		$date=date('Y-m-d');
		$time = date("H:i:s A");
		$checkProcessName = $this -> db -> query("select process_name from tbl_process where process_id='$process_id'") -> result();
		//print_r($checkProcessName);
		if (count($checkProcessName) > 0) {
			$process = $checkProcessName[0] -> process_name;
		} else {
		
			// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Error Found.";

				// echoing JSON response
				echo json_encode($response);

		}
		$check_role=$this->db->query("select role from lmsuser where id='$assign'")->result();
		if(count($check_role)>0){
				if($check_role[0]->role == 15){
					$evaluation_tl=$assign;
					$evaluation_tl_date=$date;
					$evaluation_tl_time=$time;
					$evaluation_cse='';
					$evaluation_cse_date='';
					$evaluation_cse_time='';
				}else{
					$tl_id=$this->db->query("select tl_id from tbl_mapdse where dse_id='$assign'")->result();
					if(count($tl_id)>0){
							$evaluation_tl=$tl_id[0]->tl_id;
							$evaluation_tl_date=$date;
							$evaluation_tl_time=$time;
							$evaluation_cse=$assign;
							$evaluation_cse_date=$date;
							$evaluation_cse_time=$time;
					}else{
						
			// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Error Found.";

				// echoing JSON response
				echo json_encode($response);
						}
					
				
				}
		
		
			}else{
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Error Found ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			}
	
		
		
		$query = $this -> db -> query("insert into lead_master	(process,`lead_source`,`enquiry_for`,`manual_lead`,`name`,`email`,`address`,`contact_no`,`created_date`,`created_time`,`assign_to_e_tl`,`assign_to_e_tl_date`,`assign_to_e_tl_time`,`assign_to_e_exe`,`assign_to_e_exe_date`,`assign_to_e_exe_time`,`evaluation`,app )
				values('$process','$lead_source','$sub_lead_source','$username','$fname','$email','$address','$contact_no','$date','$time','$evaluation_tl','$evaluation_tl_date','$evaluation_tl_time','$evaluation_cse','$evaluation_cse_date','$evaluation_cse_time','Yes','1')");
		if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Data successfully Inserted.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}
		}
	}

///////////////////////////////////////////////////////////////	
//Tracker search
public function select_lead_tracker($process_name,$process_id,$campaign_name,$feedback_name,$nextaction_name,$date_type,$fromdate,$todate,$role_session,$role_name_session,$user_id,$page) {
	 $table=$this->select_table($process_id);	
	 
	 $executive_array=array("3","8","10","12","14");	
	 $tl_array=array("2","7","9","11","13");
	ini_set('memory_limit', '-1');
		
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		//Filter Condition
		$today = date('Y-m-d');
		//Campaign
		if ($campaign_name != '' && $campaign_name != 'All') {
			if ($campaign_name == 'Website') {
				$lead_info = "lead_source=''";
			} else {
				$name = explode('%23', $campaign_name);
				if (isset($name[1])) {
					if ($name[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name[1] . "'";
					}
				}
				$name1 = explode('#', $campaign_name);
				if (isset($name1[1])) {
					if ($name1[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name1[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name1[1] . "'";
					}
				}

			}
		}
		//Feddback
		if ($feedback_name != '') {
			$feedback = "l.feedbackStatus='" . $feedback_name . "'";
		}
		// Next Action
		if ($nextaction_name != '') {
			$nextaction = "l.nextaction='" .$nextaction_name . "'";
		}

		// Date
	
		if ($fromdate == '' && $todate != '') {
			$fromdate1 = $today;
		} else {
			//echo "2";
			$fromdate1 =$fromdate;
		}
		if ($todate == '' && $fromdate != '') {
			//echo "3";
			$todate1 = $today;
		} else {
			//echo "4";
			$todate1 = $todate;
		}
		
		

		if ($date_type == 'Lead') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "l.created_date>='" . $fromdate1 . "' and l.created_date<='" . $todate1 . "'";
			}
		}
		if ($date_type == 'CSE') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "csef.date>= '" . $fromdate1 . "' and csef.date<= '" . $todate1 . "' and csef.date!='0000-00-00'";

			}
		}
		if($date_type=='DSE'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "dsef.date>= '". $fromdate1 ."' and dsef.date<= '".$todate1."' and dsef.date!='0000-00-00'";
			
		}
		}
		if($date_type=='DSEAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_dse_date>= '". $fromdate ."' and l.assign_to_dse_date<= '".$todate."' and l.assign_to_dse_date!='0000-00-00'";
			
		}
		}
		if($date_type=='DSETLAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_dse_tl_date>= '". $fromdate ."' and l.assign_to_dse_tl_date<= '".$todate."' and l.assign_to_dse_tl_date!='0000-00-00'";
			
		}
		}
			if($process_id==8){
				if($date_type=='DSE'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "dsef.date>= '". $fromdate ."' and dsef.date<= '".$todate."' and dsef.date!='0000-00-00'";
			
		}
		}
			if($date_type=='DSEAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_e_exe_date>= '". $fromdate ."' and l.assign_to_e_exe_date<= '".$todate."' and l.assign_to_e_exe_date!='0000-00-00'";
			
		}
		}
		if($date_type=='DSETLAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_e_tl_date >= '". $fromdate ."' and l.assign_to_e_tl_date <= '".$todate."' and l.assign_to_e_tl_date !='0000-00-00'";
			
		}
		}
		}
	//User

		if ($role_session == 5 ) {

			
			$username = "assign_to_dse_tl ='" . $user_id . "'";

		}
		elseif ($role_session == 4 ) {

			
			$username = "assign_to_dse ='" . $user_id . "'";

		}
		elseif ($role_session == 15 ) {

			
			$username = "assign_to_e_tl  ='" . $user_id . "'";

		}
		elseif ($role_session == 16 ) {

			
			$username = " 	assign_to_e_exe  ='" . $user_id . "'";

		}
		elseif (in_array($role_session,$executive_array)) {
			$username = "assign_to_cse ='" . $user_id . "'";
		}
		elseif (in_array($role_session,$tl_array)) {
	if($role_name_session!='Manager' && $role_name_session!='Auditor'){
			$username = "assign_by_cse_tl ='" . $user_id . "'";
			}

		}


		

		$query = "SELECT 
		GROUP_CONCAT( DISTINCT  a.accessories_name ) as accessoires_list,
		sum(price) as assessories_price,
		m.model_name,
		l.service_center,l.service_type,l.pickup_required,l.pick_up_date, `l`.`assistance`,  `l`.`customer_location`,`l`.`days60_booking`,
		l.enq_id,l.lead_source,l.enquiry_for,l.process,l.name,l.contact_no,l.alternate_contact_no,l.address,l.email,l.created_date as lead_date,l.created_time as lead_time,l.feedbackStatus,l.nextAction,
		 l.ownership,l.budget_from,l.budget_to,l.accidental_claim,`l`.`assign_by_cse_tl`,`l`.`assign_to_cse`,
		l.reg_no, min(l.created_date) as min_date, max(l.created_date) as max_date ,l.km,`l`.`buyer_type`,  `l`.`manf_year`,l.assign_to_cse_date,l.assign_to_cse_time,
		l.appointment_type,l.appointment_date,l.appointment_time,l.appointment_address,l.appointment_status,l.appointment_rating,l.appointment_feedback,l.evaluation_within_days,l.fuel_type,l.color,
		l.interested_in_finance,l.interested_in_accessories,l.interested_in_insurance,l.interested_in_ew,
		`ucse`.`fname` as `cse_fname`, `ucse`.`lname` as `cse_lname`, `ucse`.`role` as `cse_role`,`ucsetl`.`fname` as `csetl_fname`, `ucsetl`.`lname` as `csetl_lname`, `ucsetl`.`role` as `csetl_role`,
		". $table['select_element'] .",".$table['select_element1'].",
		`v`.`variant_name`,`m`.`model_name` as `new_model_name`,
		`csef`.`date` as `cse_date`, `csef`.`nextfollowupdate` as `cse_nfd`,`csef`.`nextfollowuptime` as `cse_nftime`, `csef`.`comment` as `cse_comment`, `csef`.`td_hv_date`, 
		`csef`.`feedbackStatus` as `csefeedback`, `csef`.`nextAction` as `csenextAction`,`csef`.`contactibility` as `csecontactibility`,`csef`.`created_time` as `cse_time`,
		ua.fname as auditfname,ua.lname as auditlname,
		mr.followup_pending,mr.call_received,mr.fake_updation,mr.service_feedback,mr.remark as auditor_remark,mr.created_date as auditor_date,mr.created_time as auditor_time,mr.call_status as auditor_call_status
		
		FROM " .$table['lead_master_table']. "`l` 
		LEFT JOIN " .$table['lead_followup_table']. " `csef` ON `csef`.`id`=`l`.`cse_followup_id`  
		LEFT JOIN `tbl_manager_remark` `mr` ON `mr`.`remark_id`=`l`.`remark_id`
		LEFT JOIN `lmsuser` `ucse` ON `ucse`.`id`=`l`.`assign_to_cse` 
		LEFT JOIN `lmsuser` `ucsetl` ON `ucsetl`.`id`=`l`.`assign_by_cse_tl`
		LEFT JOIN `lmsuser` `ua` ON `ua`.`id`=`l`.`auditor_user_id`  
		LEFT JOIN `make_models` `m` ON `m`.`model_id`=`l`.`model_id` 
		LEFT JOIN `model_variant` `v` ON `v`.`variant_id`=`l`.`variant_id` 
		LEFT JOIN `make_models` `m1` ON `m1`.`model_id`=`l`.`old_model` 
		LEFT JOIN `makes` `m2` ON `m2`.`make_id`=`l`.`old_make`
		LEFT JOIN `accessories_order_list` `a` ON `a`.`enq_id`=`l`.`enq_id`";
		if($process_id==8){
		
		$query=$query." LEFT JOIN " .$table['lead_followup_table']. "  dsef ON dsef.id=l.exe_followup_id
		LEFT JOIN `lmsuser` `udse` ON `udse`.`id`=`l`.`assign_to_e_exe` 
		LEFT JOIN `lmsuser` `udsetl` ON `udsetl`.`id`=`l`.`assign_to_e_tl` ";
		
		}else{
		$query=$query." LEFT JOIN " .$table['lead_followup_table']. "  `dsef` ON `dsef`.`id`=`l`.`dse_followup_id` 
		LEFT JOIN `lmsuser` `udse` ON `udse`.`id`=`l`.`assign_to_dse` 
		LEFT JOIN `lmsuser` `udsetl` ON `udsetl`.`id`=`l`.`assign_to_dse_tl` ";
		}
		$query=$query."LEFT JOIN `tbl_manager_process` `mp` on `mp`.`user_id` =`udsetl`.`id`
		LEFT JOIN `tbl_location` `tloc` ON `tloc`.`location_id`= `mp`.`location_id`";

		
		
		if (isset($alldate)) {

			$query = $query . ' where ' . $alldate;
		}
		if (isset($feedback)) {
			$query = $query . ' And ' . $feedback;
		}
		if (isset($nextaction)) {
			$query = $query . ' And ' . $nextaction;
		}
		if (isset($lead_info)) {
			$query = $query . ' And ' . $lead_info;
		}
		if (isset($username)) {
			$query = $query . ' And ' . $username;
		}
		if($process_id==8){
		$query = $query . "And l.evaluation = 'Yes' ";
		}else{
			$query = $query . 'And l.process="' . $process_name . '"';
		}
		if($role_name_session=='Manager'){
			$get_location=$this->db->query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$user_id'")->result();
			$location=array();
			if(count($get_location)>0 ){
		
				foreach ($get_location as $row) {
						$location[]=$row->location_id;
					}
				 $location_id = implode(",",$location);
  		
  			
				if(!in_array(38,$location))
				{
	
					$query=$query.'And mp.location_id in ('.$location_id.')';
					}
				}
		}
		$query = $query . " group by l.enq_id";
		$query = $query . " order by l.enq_id desc";
		$query=$query." limit ".$offset .",".$rec_limit."";

		$query = $this -> db -> query($query);
		//echo $this->db->last_query();
		$query = $query -> result();

		return $query;



	}
	//Tracker search count
	public function select_lead_tracker_count($process_name,$process_id,$campaign_name,$feedback_name,$nextaction_name,$date_type,$fromdate,$todate,$role_session,$role_name_session,$user_id,$page) {
	$table=$this->select_table($process_id);	
	 
	 $executive_array=array("3","8","10","12","14");	
	 $tl_array=array("2","7","9","11","13");
	ini_set('memory_limit', '-1');
		
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		//Filter Condition
		$today = date('Y-m-d');
		//Campaign
		if ($campaign_name != '' && $campaign_name != 'All') {
			if ($campaign_name == 'Website') {
				$lead_info = "lead_source=''";
			} else {
				$name = explode('%23', $campaign_name);
				if (isset($name[1])) {
					if ($name[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name[1] . "'";
					}
				}
				$name1 = explode('#', $campaign_name);
				if (isset($name1[1])) {
					if ($name1[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name1[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name1[1] . "'";
					}
				}

			}
		}
		//Feddback
		if ($feedback_name != '') {
			$feedback = "l.feedbackStatus='" . $feedback_name . "'";
		}
		// Next Action
		if ($nextaction_name != '') {
			$nextaction = "l.nextaction='" .$nextaction_name . "'";
		}

		// Date
	
		if ($fromdate == '' && $todate != '') {
			$fromdate1 = $today;
		} else {
			//echo "2";
			$fromdate1 =$fromdate;
		}
		if ($todate == '' && $fromdate != '') {
			//echo "3";
			$todate1 = $today;
		} else {
			//echo "4";
			$todate1 = $todate;
		}
		
		

		if ($date_type == 'Lead') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "l.created_date>='" . $fromdate1 . "' and l.created_date<='" . $todate1 . "'";
			}
		}
		if ($date_type == 'CSE') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "csef.date>= '" . $fromdate1 . "' and csef.date<= '" . $todate1 . "' and csef.date!='0000-00-00'";

			}
		}
		if($date_type=='DSE'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "dsef.date>= '". $fromdate1 ."' and dsef.date<= '".$todate1."' and dsef.date!='0000-00-00'";
			
		}
		}
		if($date_type=='DSEAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_dse_date>= '". $fromdate ."' and l.assign_to_dse_date<= '".$todate."' and l.assign_to_dse_date!='0000-00-00'";
			
		}
		}
		if($date_type=='DSETLAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_dse_tl_date>= '". $fromdate ."' and l.assign_to_dse_tl_date<= '".$todate."' and l.assign_to_dse_tl_date!='0000-00-00'";
			
		}
		}

	//User

		if ($role_session == 5 ) {

			
			$username = "assign_to_dse_tl ='" . $user_id . "'";

		}
		elseif ($role_session == 4 ) {

			
			$username = "assign_to_dse ='" . $user_id . "'";

		}
		elseif ($role_session == 15 ) {

			
			$username = "assign_to_e_tl  ='" . $user_id . "'";

		}
		elseif ($role_session == 16 ) {

			
			$username = " 	assign_to_e_exe  ='" . $user_id . "'";

		}
		elseif (in_array($role_session,$executive_array)) {
			$username = "assign_to_cse ='" . $user_id . "'";
		}
		elseif (in_array($role_session,$tl_array)) {
if($role_name_session!='Manager' && $role_name_session!='Auditor'){
			$username = "assign_by_cse_tl ='" . $user_id . "'";
}

		}


		

		$query = "SELECT count(distinct(l.enq_id)) as lead_count
		FROM " .$table['lead_master_table']. "`l` 
		LEFT JOIN " .$table['lead_followup_table']. " `csef` ON `csef`.`id`=`l`.`cse_followup_id`  
		LEFT JOIN `tbl_manager_remark` `mr` ON `mr`.`remark_id`=`l`.`remark_id`
		LEFT JOIN `lmsuser` `ucse` ON `ucse`.`id`=`l`.`assign_to_cse` 
		LEFT JOIN `lmsuser` `ucsetl` ON `ucsetl`.`id`=`l`.`assign_by_cse_tl`
		LEFT JOIN `lmsuser` `ua` ON `ua`.`id`=`l`.`auditor_user_id`  
		LEFT JOIN `make_models` `m` ON `m`.`model_id`=`l`.`model_id` 
		LEFT JOIN `model_variant` `v` ON `v`.`variant_id`=`l`.`variant_id` 
		LEFT JOIN `make_models` `m1` ON `m1`.`model_id`=`l`.`old_model` 
		LEFT JOIN `makes` `m2` ON `m2`.`make_id`=`l`.`old_make`
		LEFT JOIN `accessories_order_list` `a` ON `a`.`enq_id`=`l`.`enq_id`";
		if($process_id==8){
		
		$query=$query." LEFT JOIN " .$table['lead_followup_table']. "  dsef ON dsef.id=l.exe_followup_id
		LEFT JOIN `lmsuser` `udse` ON `udse`.`id`=`l`.`assign_to_e_exe` 
		LEFT JOIN `lmsuser` `udsetl` ON `udsetl`.`id`=`l`.`assign_to_e_tl` ";
		
		}else{
		$query=$query." LEFT JOIN " .$table['lead_followup_table']. "  `dsef` ON `dsef`.`id`=`l`.`dse_followup_id` 
		LEFT JOIN `lmsuser` `udse` ON `udse`.`id`=`l`.`assign_to_dse` 
		LEFT JOIN `lmsuser` `udsetl` ON `udsetl`.`id`=`l`.`assign_to_dse_tl` ";
		}
		$query=$query."LEFT JOIN `tbl_manager_process` `mp` on `mp`.`user_id` =`udsetl`.`id`
		LEFT JOIN `tbl_location` `tloc` ON `tloc`.`location_id`= `mp`.`location_id`";

		
		
		if (isset($alldate)) {

			$query = $query . ' where ' . $alldate;
		}
		if (isset($feedback)) {
			$query = $query . ' And ' . $feedback;
		}
		if (isset($nextaction)) {
			$query = $query . ' And ' . $nextaction;
		}
		if (isset($lead_info)) {
			$query = $query . ' And ' . $lead_info;
		}
		if (isset($username)) {
			$query = $query . ' And ' . $username;
		}
		if($process_id==8){
		$query = $query . "And l.evaluation = 'Yes' ";
		}else{
			$query = $query . 'And l.process="' . $process_name . '"';
		}
				if($role_name_session=='Manager'){
			$get_location=$this->db->query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$user_id'")->result();
			$location=array();
			if(count($get_location)>0 ){
		
				foreach ($get_location as $row) {
						$location[]=$row->location_id;
					}
				 $location_id = implode(",",$location);
  		
  			
				if(!in_array(38,$location))
				{
	
					$query=$query.'And mp.location_id in ('.$location_id.')';
					}
				}
		}
		//$query = $query . " group by l.enq_id";
		

		$query = $this -> db -> query($query);
		//echo $this->db->last_query();
		$query = $query -> result();

		return $query;



	}
	/////////////////////////////////////////////////////////////////////
	//Calling Notification
	
	//New Lead 
	public function select_new_lead($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page)
{	
	
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		ini_set('memory_limit', '-1');
		$table=$this->select_table($process_id_session);	
		$rec_limit = 100;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$today=date('Y-m-d');
		if($user_id=='')    {         $userid=$user_id_session;       }
		else {	 $userid=$user_id;	}
		 if($role=='')
        {
            $role=$role_session;
        }
		//Get user id and role from dashboard
		//$getUserid = $this -> input -> get('id');
       // $userid=$getUserid;
       //ucse.fname as cse_fname,ucse.lname as cse_lname,
		//	udse.fname as dse_fname,udse.lname as dse_lname,
		//	ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
		//	udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
		//	f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
		//	f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
		$selectElement=$table['select_element1'];
		$this -> db -> select('l.assign_to_dse,l.assign_to_dse_tl,l.assign_to_cse,l.assign_by_cse_tl,l.cse_followup_id,l.dse_followup_id,l.lead_source,l.eagerness,l.enq_id,name,l.address,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km,l.feedbackStatus,l.nextAction,l.	days60_booking,'.$selectElement);
		
		$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join($table['lead_followup_table'].' f1', 'f1.id=l.cse_followup_id', 'left');
				$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		if($process_id_session == 8){
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe ', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl ', 'left');
			$this -> db -> where('l.evaluation', 'Yes');
		}else{
			$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.dse_followup_id', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
			$this -> db -> where('l.process', $process_name_session);
		}
		
	
		
	
		$this -> db -> where('l.nextAction!=', "Close");
		
		//If role DSE TL and Dashboard id blank(for calling task)
		if ($role == '5' && $user_id=='') {
			
			$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse',$userid);
			$this -> db -> where('l.assign_to_dse_date', $this->today);
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '5' && $user_id!='')
		{
				
			$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse_tl',$userid);
			$this -> db -> where('l.assign_to_dse_date', $this->today);
	
        }
		//If role DSE 
		elseif($role == '4')
		{
			
			$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse_tl!=',0);
			$this -> db -> where('l.assign_to_dse', $userid);
			$this -> db -> where('l.assign_to_dse_date', $this->today);
		}
		if ($role == '15' && $user_id=='') {
				$this -> db -> where('l.exe_followup_id', 0);
			$this -> db -> where('l.assign_to_e_exe',$userid);
			$this -> db -> where('l.assign_to_e_exe_date', $today);
			
        }
			//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '15' && $user_id!='')
		{
			$this -> db -> where('l.exe_followup_id', 0);
			$this -> db -> where('l.assign_to_e_tl',$userid);
			$this -> db -> where('l.assign_to_e_exe_date', $today);
	
        }
		//If role DSE 
		elseif($role == '16')
		{
			$this -> db -> where('assign_to_e_exe', $userid);
			$this -> db -> where('assign_to_e_exe_date ', $today);
			$this -> db -> where('exe_followup_id', 0);
			$this -> db -> where('l.assign_to_e_tl!=',0);
		}
		// If role all executive
		elseif (in_array($role,$executive_array)) {
			$this -> db -> where('l.cse_followup_id', 0);
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('l.assign_to_cse_date', $this->today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		
		elseif(in_array($role,$tl_array) && $user_id==''){
          $this -> db -> where('l.cse_followup_id', 0);
		  	$this -> db -> where('l.assign_to_dse_tl',0);
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('l.assign_to_cse_date', $this->today);
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
        $this -> db -> where('l.cse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse_tl',0);
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			$this -> db -> where('l.assign_to_cse_date', $this->today);
        }
		if(!empty($contact_no)){
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		$this->db->group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		
		$this -> db -> limit($rec_limit,$offset);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
}
//New Lead Count
public function select_new_lead_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page){
			
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		$table=$this->select_table($process_id_session);	
			
		$today=date('Y-m-d');
	
        if($user_id=='')
        {
            $userid=$user_id_session;
        }else{
			$userid=$user_id;
		}
      
        if($role=='')
        {
            $role=$role_session;
        }
		
		$this -> db -> select('count(enq_id) as count_lead');
		$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join($table['lead_followup_table'].' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		if($process_id_session == 8){
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
			
		}else{
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> where('l.process', $process_name_session);
		
		}
		
		$this -> db -> where('l.nextAction!=', "Close");
		
		//If role DSE TL and Dashboard id blank(for calling task)
		if ($role == '5' && $user_id=='') {
			$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse',$user_id_session);
			$this -> db -> where('l.assign_to_dse_date', $today);
        }
			//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '5' && $user_id!='')
		{
			$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse_tl',$userid);
			$this -> db -> where('l.assign_to_dse_date', $today);
	
        }
		//If role DSE 
		elseif($role == '4')
		{
			
			$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse_tl!=',0);
			$this -> db -> where('l.assign_to_dse', $userid);
			$this -> db -> where('l.assign_to_dse_date', $today);
		}
		if ($role == '15' && $user_id=='') {
				$this -> db -> where('l.exe_followup_id', 0);
			$this -> db -> where('l.assign_to_e_exe',$userid);
			$this -> db -> where('l.assign_to_e_exe_date', $today);
			
        }
			//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '15' && $user_id!='')
		{
			$this -> db -> where('l.exe_followup_id', 0);
			$this -> db -> where('l.assign_to_e_tl',$userid);
			$this -> db -> where('l.assign_to_e_exe_date', $today);
	
        }
		//If role DSE 
		elseif($role == '16')
		{
			$this -> db -> where('assign_to_e_exe', $userid);
			$this -> db -> where('assign_to_e_exe_date ', $today);
			$this -> db -> where('exe_followup_id', 0);
			$this -> db -> where('l.assign_to_e_tl!=',0);
		}
		// All Executive
		elseif (in_array($role,$executive_array)) {
			$this -> db -> where('l.cse_followup_id', 0);
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('l.assign_to_cse_date', $today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		elseif(in_array($role,$tl_array) && $user_id==''){
          $this -> db -> where('l.cse_followup_id', 0);
		  	$this -> db -> where('l.assign_to_dse_tl',0);
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('l.assign_to_cse_date', $today);
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
        $this -> db -> where('l.cse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse_tl',0);
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			$this -> db -> where('l.assign_to_cse_date', $today);
        }
		if(!empty($contact_no)){
				
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		
		$this -> db -> order_by('l.enq_id', 'desc');
	
		$query = $this -> db -> get();
		//	echo $this->db->last_query();
		return $query -> result();

	}
	// Unassign leads 
	public function select_unassigned_lead($role,$user_id,$user_id_session,$process_name_session,$process_id_session,$contact_no,$page) {

	$executive_array=array("3","8","10","12","14");
	$tl_array=array("2","7","9","11","13");
	$table=$this->select_table($process_id_session);	
	
	ini_set('memory_limit', '-1');

	$rec_limit = 100;
	if (isset($page)) {
		$page = $page + 1;
		$offset = $rec_limit * $page;
	} else {
		$page = 0;
		$offset = 0;
	}
	
	$this -> db -> select('ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
			l.days60_booking,
			l.assign_by_cse_tl,l.assign_to_cse,l.assign_to_dse,assign_to_dse_tl,l.cse_followup_id,l.dse_followup_id,l.lead_source,l.eagerness,l.enq_id,name,l.address,l.email,contact_no,enquiry_for,l.created_date,l.nextAction,l.feedbackStatus,'.$table['select_element1']);

		$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join($table['lead_followup_table'].' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		if($process_id_session == 8){
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
			
		}else{
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> where('l.process', $process_name_session);
		
		}
		
		//$this->db->where('l.process',$process_name_session);
		$this -> db -> where('l.nextAction!=', "Close");
		if ($role == '5' && $user_id=='') {
            $this -> db -> where('l.assign_to_dse_tl',$user_id_session);
			$this -> db -> where('l.assign_to_dse', 0);
        }
		elseif($role == '5' && $user_id!='')
		{
			$this -> db -> where('l.assign_to_dse_tl',$user_id);
			$this -> db -> where('l.assign_to_dse', 0);
        }
		
		elseif($role == '4')
		{
			$this -> db -> where('l.assign_to_dse_tl',0);
			$this -> db -> where('l.assign_to_dse', $user_id_session);
		}
		else if ($role == '15' && $user_id=='') {
            $this -> db -> where('l.assign_to_e_tl',$user_id_session);
			$this -> db -> where('l.assign_to_e_exe ', 0);
        }
		elseif($role == '15' && $user_id!='')
		{
			$this -> db -> where('l.assign_to_e_tl',$user_id);
			$this -> db -> where('l.assign_to_e_exe ', 0);
        }
		
		elseif($role == '16')
		{
			$this -> db -> where('l.assign_to_e_tl',0);
			$this -> db -> where('l.assign_to_e_exe ', $user_id_session);
		}
		
		elseif (in_array($role,$executive_array)) {
		
			$this -> db -> where('l.assign_by_cse_tl', 0);
			$this -> db -> where('l.assign_to_cse', $user_id_session);
		
		}elseif(in_array($role,$tl_array) && $user_id==''){
           $this -> db -> where('l.assign_by_cse_tl', 0);
        }
		elseif(in_array($role,$tl_array) && $user_id !=''){
         $this -> db -> where('l.assign_by_cse_tl', 0);
        }
			$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit,$offset);
		$query = $this -> db -> get();
//		echo $this->db->last_query();
		return $query -> result();

	}
	//Count of unassigned leads 
	public function select_unassigned_lead_count($role,$user_id,$user_id_session,$process_name_session,$process_id_session,$contact_no,$page){
	
	$executive_array=array("3","8","10","12","14");
	$tl_array=array("2","7","9","11","13");
	$table=$this->select_table($process_id_session);

	

		$this -> db -> select('count(enq_id) as count_lead');

		$this -> db -> from($table['lead_master_table'] . ' l');
		$this -> db -> join($table['lead_followup_table'] .' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		if($process_id_session == 8){
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
			
		}else{
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> where('l.process', $process_name_session);
		
		}
		$this -> db -> where('l.nextAction!=', "Close");
		if ($role == '5' && $user_id=='') {
            $this -> db -> where('l.assign_to_dse_tl',$user_id_session);
			$this -> db -> where('l.assign_to_dse', 0);
        }
		elseif($role == '5' && $user_id!='')
		{
			$this -> db -> where('l.assign_to_dse_tl',$user_id);
			$this -> db -> where('l.assign_to_dse', 0);
        }
		
		elseif($role == '4')
		{
			$this -> db -> where('l.assign_to_dse_tl',0);
			$this -> db -> where('l.assign_to_dse', $user_id_session);
		}
		else if ($role == '15' && $user_id=='') {
            $this -> db -> where('l.assign_to_e_tl',$user_id_session);
			$this -> db -> where('l.assign_to_e_exe ', 0);
        }
		elseif($role == '15' && $user_id!='')
		{
			$this -> db -> where('l.assign_to_e_tl',$user_id);
			$this -> db -> where('l.assign_to_e_exe ', 0);
        }
		
		elseif($role == '16')
		{
			$this -> db -> where('l.assign_to_e_tl',0);
			$this -> db -> where('l.assign_to_e_exe ', $user_id_session);
		}
		
		
		elseif (in_array($role,$executive_array)) {
		
			$this -> db -> where('l.assign_by_cse_tl', 0);
			$this -> db -> where('l.assign_to_cse', $user_id_session);
		
		}elseif(in_array($role,$tl_array) && $user_id==''){
           $this -> db -> where('l.assign_by_cse_tl', 0);
        }
		elseif(in_array($role,$tl_array) && $user_id !=''){
         $this -> db -> where('l.assign_by_cse_tl', 0);
        }
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
	public function select_today_followup_lead($role,$user_id,$user_id_session,$process_name_session,$process_id_session,$contact_no,$page)
{
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		ini_set('memory_limit', '-1');
		$table=$this->select_table($process_id_session);	
		$rec_limit = 100;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$today=date('Y-m-d');
		$this -> db -> select('
			ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
			l.assign_to_dse,l.assign_to_dse_tl,l.assign_to_cse,l.assign_by_cse_tl,l.cse_followup_id,l.dse_followup_id,l.lead_source,l.eagerness,l.enq_id,name,l.address,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km,l.feedbackStatus,l.nextAction,l.	days60_booking,'.$table['select_element1']);
		
		$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join($table['lead_followup_table'].' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		if($process_id_session==8){
			$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.exe_followup_id', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl ', 'left');
			$this -> db -> where('l.evaluation', 'Yes');
		}else{
			$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.dse_followup_id', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
			$this -> db -> where('l.process', $process_name_session);
		}
		
		$this -> db -> where('l.nextAction!=', "Close");
			$this -> db -> where('l.nextAction!=', "Lost");	
		
		//If role DSE TL and Dashboard id blank(for calling task)
		if ($role == '5' && $user_id=='') {
			$this -> db -> where('l.assign_to_dse',$user_id_session);
			$this -> db -> where('f2.nextfollowupdate', $today);
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '5' && $user_id!='')
		{
			$this -> db -> where('l.assign_to_dse_tl',$user_id);
			$this -> db -> where('f2.nextfollowupdate', $today);	
        }
		//If role DSE 
		elseif($role == '4')
		{
			$this -> db -> where('l.assign_to_dse_tl!=',0);
			$this -> db -> where('l.assign_to_dse', $user_id_session);
			$this -> db -> where('f2.nextfollowupdate', $today);
		}else if ($role == '15' && $user_id=='') {
			$this -> db -> where('l.assign_to_e_exe',$user_id_session);
			$this -> db -> where('f2.nextfollowupdate', $today);
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '15' && $user_id!='')
		{
			$this -> db -> where('l.assign_to_e_tl',$user_id);
			$this -> db -> where('f2.nextfollowupdate', $today);	
        }
		//If role DSE 
		elseif($role == '16')
		{
			$this -> db -> where('l.assign_to_e_tl!=',0);
			$this -> db -> where('l.assign_to_e_exe',$user_id_session);
			$this -> db -> where('f2.nextfollowupdate', $today);
		}
		
		// If role all executive
		elseif (in_array($role,$executive_array)) {
			$this -> db -> where('l.assign_to_cse', $user_id_session);
			$this -> db -> where('l.assign_to_dse_tl',0);
			$this -> db -> where('f1.nextfollowupdate', $today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		elseif(in_array($role,$tl_array) && $user_id==''){
			$this -> db -> where('l.assign_to_cse', $user_id_session);
			$this -> db -> where('f1.assign_to', $user_id_session);
			$this -> db -> where('f1.nextfollowupdate', $today);
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
			$this -> db -> where('l.assign_by_cse_tl', $user_id);
			$this -> db -> where('f1.nextfollowupdate', $today);
        }
		if(!empty($contact_no)){
				
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		////////////// Time Filter ///////////////////
		$times = strtotime(date("H:i")) + 60*60;
		$timet = date("H:i:s", $times); 
		$times1 = strtotime(date("H:i")) - 60*60;
		$timet1 = date("H:i:s", $times1);
		if($this->input->post('name')=='current')
		{
			if ($role == 4 ||$role == 5 ||  $role==16) 
			{
				$this->db->where('f2.nextfollowuptime>=',$timet1);
				$this->db->where('f2.nextfollowuptime<=',$timet);
				$this->db->where('f2.nextfollowuptime!=','');
			}
			else
			{
				$this->db->where('f1.nextfollowuptime>=',$timet1);
				$this->db->where('f1.nextfollowuptime<=',$timet);
				$this->db->where('f1.nextfollowuptime!=','');
			}
			
		}
		$this->db->group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		
		$this -> db -> limit($rec_limit,$offset);
		
		$query = $this -> db -> get();
		
		//echo $this->db->last_query();
		return $query -> result();
}
	public function select_today_followup_lead_count($role,$user_id,$user_id_session,$process_name_session,$process_id_session,$contact_no,$page){
		//Today followup Leads
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		ini_set('memory_limit', '-1');
		$table=$this->select_table($process_id_session);	
		$today=date('Y-m-d');
		$this -> db -> select('count(enq_id) as count_lead');
		$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join($table['lead_followup_table'].' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		if($process_id_session==8){
			$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.exe_followup_id', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl ', 'left');
			$this -> db -> where('l.evaluation', 'Yes');
		}else{
			$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.dse_followup_id', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
			$this -> db -> where('l.process', $process_name_session);
		}
		
		
	
		$this -> db -> where('l.nextAction!=', "Close");
			$this -> db -> where('l.nextAction!=', "Lost");	
		
		//If role DSE TL and Dashboard id blank(for calling task)
		if ($role == '5' && $user_id=='') {
			$this -> db -> where('l.assign_to_dse',$user_id_session);
			$this -> db -> where('f2.nextfollowupdate', $today);
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '5' && $user_id!='')
		{
			$this -> db -> where('l.assign_to_dse_tl',$user_id);
			$this -> db -> where('f2.nextfollowupdate', $today);	
        }
		//If role DSE 
		elseif($role == '4')
		{
			$this -> db -> where('l.assign_to_dse_tl!=',0);
			$this -> db -> where('l.assign_to_dse', $user_id_session);
			$this -> db -> where('f2.nextfollowupdate', $today);
		}
		else if ($role == '15' && $user_id=='') {
			$this -> db -> where('l.assign_to_e_exe ',$user_id_session);
			$this -> db -> where('f2.nextfollowupdate', $today);
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '15' && $user_id!='')
		{
			$this -> db -> where('l.assign_to_e_tl ',$user_id);
			$this -> db -> where('f2.nextfollowupdate', $today);	
        }
		//If role DSE 
		elseif($role == '16')
		{
			$this -> db -> where('l.assign_to_e_tl!=',0);
			$this -> db -> where('l.assign_to_e_exe ', $user_id_session);
			$this -> db -> where('f2.nextfollowupdate', $today);
		}
		
		// If role all executive
		elseif (in_array($role,$executive_array)) {
			$this -> db -> where('l.assign_to_cse', $user_id_session);
			$this -> db -> where('l.assign_to_dse_tl',0);
			$this -> db -> where('f1.nextfollowupdate', $today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		elseif(in_array($role,$tl_array) && $user_id==''){
			$this -> db -> where('l.assign_to_cse', $user_id_session);
			$this -> db -> where('f1.assign_to', $user_id_session);
			$this -> db -> where('f1.nextfollowupdate', $today);
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
			$this -> db -> where('l.assign_by_cse_tl', $user_id);
			$this -> db -> where('f1.nextfollowupdate', $today);
        }
		if(!empty($contact_no)){
				
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		////////////// Time Filter ///////////////////
		$times = strtotime(date("H:i")) + 60*60;
		$timet = date("H:i:s", $times); 
		$times1 = strtotime(date("H:i")) - 60*60;
		$timet1 = date("H:i:s", $times1);
		if($this->input->post('name')=='current')
		{
			if ($role == 4 ||$role == 5 || $role== 16) 
			{
				$this->db->where('f2.nextfollowuptime>=',$timet1);
				$this->db->where('f2.nextfollowuptime<=',$timet);
				$this->db->where('f2.nextfollowuptime!=','');
			}
			else
			{
				$this->db->where('f1.nextfollowuptime>=',$timet1);
				$this->db->where('f1.nextfollowuptime<=',$timet);
				$this->db->where('f1.nextfollowuptime!=','');
			}
			
		}
		
		$this -> db -> order_by('l.enq_id', 'desc');
		
		
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}

	//Pending not attend leads for cse
	public function select_pending_new_lead($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page)
{
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		ini_set('memory_limit', '-1');
		$table=$this->select_table($process_id_session);	
		$rec_limit = 100;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		if($user_id=='')    {         $userid=$user_id_session;       }
		else {	 $userid=$user_id;	}
		 if($role=='')
        {
            $role=$role_session;
        }
		//$today=date('Y-m-d');
		$this -> db -> select('
			ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
			l.assign_to_dse,l.assign_to_dse_tl,l.assign_to_cse,l.assign_by_cse_tl,l.cse_followup_id,l.dse_followup_id,l.lead_source,l.eagerness,l.enq_id,name,l.address,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km,l.feedbackStatus,l.nextAction,l.	days60_booking,'.$table['select_element1']);
		
		$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join($table['lead_followup_table'].' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		if($process_id_session == 8){
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> where('l.evaluation','Yes');
		}else{
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> where('l.process', $process_name_session);
		}
		
		//$this -> db -> where('l.nextAction!=', "Close");
		
		//If role DSE TL and Dashboard id blank(for calling task)
		if ($role == '5' && $user_id=='') {
			
			$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse',$userid);
			$this -> db -> where('l.assign_to_dse_date <', $this->today);
			$this -> db -> where('l.assign_to_dse_date !=', '0000-00-00');
			
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '5' && $user_id!='')
		{
			$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse_tl',$userid);
			$this -> db -> where('l.assign_to_dse_date <', $this->today);
			$this -> db -> where('l.assign_to_dse_date !=', '0000-00-00');
			
	
        }
		//If role DSE 
		elseif($role == '4')
		{
			
			$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse_tl!=',0);
			$this -> db -> where('l.assign_to_dse', $userid);
			$this -> db -> where('l.assign_to_dse_date <', $this->today);
			$this -> db -> where('l.assign_to_dse_date !=', '0000-00-00');
		}else if ($role == '15' && $user_id=='') {
			
			$this -> db -> where('l.exe_followup_id', 0);
			$this -> db -> where('l.assign_to_e_exe',$userid);
			$this -> db -> where('l.assign_to_e_exe_date <', $this->today);
			$this -> db -> where('l.assign_to_e_exe_date !=', '0000-00-00');
			
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '15' && $user_id!='')
		{
			$this -> db -> where('l.exe_followup_id', 0);
			$this -> db -> where('l.assign_to_e_tl',$userid);
			$this -> db -> where('l.assign_to_e_exe_date <', $this->today);
			$this -> db -> where('l.assign_to_e_exe_date !=', '0000-00-00');
			
	
        }
		//If role DSE 
		elseif($role == '16')
		{
			
			$this -> db -> where('l.exe_followup_id', 0);
			$this -> db -> where('l.assign_to_e_tl!=',0);
			$this -> db -> where('l.assign_to_e_exe', $userid);
			$this -> db -> where('l.assign_to_e_exe_date <', $this->today);
			$this -> db -> where('l.assign_to_e_exe_date !=', '0000-00-00');
		}
		
		
		// If role all executive
		elseif (in_array($role,$executive_array)) {
			$this -> db -> where('l.cse_followup_id', 0);
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('l.assign_to_cse_date <', $this->today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		elseif(in_array($role,$tl_array) && $user_id==''){
          $this -> db -> where('l.cse_followup_id', 0);
		   $this -> db -> where('l.assign_to_dse_tl',0);
			$this -> db -> where('l.assign_to_cse',$userid);
			$this -> db -> where('l.assign_to_cse_date <', $this->today);
			
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
        $this -> db -> where('l.cse_followup_id', 0);
		  $this -> db -> where('l.assign_to_dse_tl', 0);
		
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			$this -> db -> where('l.assign_to_cse_date <', $this->today);
			
        }
		if(!empty($contact_no)){
				
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		$this->db->group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		
		$this -> db -> limit($rec_limit,$offset);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
}

	public function select_pending_new_lead_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page) {
		//Pending Not Attened Leads
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		ini_set('memory_limit', '-1');
		$table=$this->select_table($process_id_session);	
		$rec_limit = 100;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		if($user_id=='')    {         $userid=$user_id_session;       }
		else {	 $userid=$user_id;	}
		 if($role=='')
        {
            $role=$role_session;
        }
		//$today=date('Y-m-d');
			$this -> db -> select('count(enq_id) as count_lead');
				$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join($table['lead_followup_table'].' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		if($process_id_session == 8){
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> where('l.evaluation','Yes');
		}else{
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> where('l.process', $process_name_session);
		}
		//$this -> db -> where('l.nextAction!=', "Close");
		
		//If role DSE TL and Dashboard id blank(for calling task)
		if ($role == '5' && $user_id=='') {
			
			$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse',$userid);
			$this -> db -> where('l.assign_to_dse_date <', $this->today);
			$this -> db -> where('l.assign_to_dse_date !=', '0000-00-00');
			
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '5' && $user_id!='')
		{
			$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse_tl',$userid);
			$this -> db -> where('l.assign_to_dse_date <', $this->today);
			$this -> db -> where('l.assign_to_dse_date !=', '0000-00-00');
			
	
        }
		//If role DSE 
		elseif($role == '4')
		{
			
			$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse_tl!=',0);
			$this -> db -> where('l.assign_to_dse', $userid);
			$this -> db -> where('l.assign_to_dse_date <', $this->today);
			$this -> db -> where('l.assign_to_dse_date !=', '0000-00-00');
		}
		else if ($role == '15' && $user_id=='') {
			
			$this -> db -> where('l.exe_followup_id', 0);
			$this -> db -> where('l.assign_to_e_exe',$userid);
			$this -> db -> where('l.assign_to_e_exe_date <', $this->today);
			$this -> db -> where('l.assign_to_e_exe_date !=', '0000-00-00');
			
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '15' && $user_id!='')
		{
			$this -> db -> where('l.exe_followup_id', 0);
			$this -> db -> where('l.assign_to_e_tl',$userid);
			$this -> db -> where('l.assign_to_e_exe_date <', $this->today);
			$this -> db -> where('l.assign_to_e_exe_date !=', '0000-00-00');
			
	
        }
		//If role DSE 
		elseif($role == '16')
		{
			
			$this -> db -> where('l.exe_followup_id', 0);
			$this -> db -> where('l.assign_to_e_tl!=',0);
			$this -> db -> where('l.assign_to_e_exe', $userid);
			$this -> db -> where('l.assign_to_e_exe_date <', $this->today);
			$this -> db -> where('l.assign_to_e_exe_date !=', '0000-00-00');
		}
		
		// If role all executive
		elseif (in_array($role,$executive_array)) {
			$this -> db -> where('l.cse_followup_id', 0);
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('l.assign_to_cse_date <', $this->today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		elseif(in_array($role,$tl_array) && $user_id==''){
          $this -> db -> where('l.cse_followup_id', 0);
		  $this -> db -> where('l.assign_to_dse_tl',0);
			$this -> db -> where('l.assign_to_cse',$userid);
			$this -> db -> where('l.assign_to_cse_date <', $this->today);
			
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
        $this -> db -> where('l.cse_followup_id', 0);
		 $this -> db -> where('l.assign_to_dse_tl', 0);
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			$this -> db -> where('l.assign_to_cse_date <', $this->today);
			
        }
		if(!empty($contact_no)){
				
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		
		$this -> db -> order_by('l.enq_id', 'desc');
		
		$this -> db -> limit($rec_limit,$offset);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}
		// Pending attended live leads for cse and dse
	public function select_pending_followup_lead($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page)
{
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		ini_set('memory_limit', '-1');
		$table=$this->select_table($process_id_session);	
		$rec_limit = 100;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		if($user_id=='')    {         $userid=$user_id_session;       }
		else {	 $userid=$user_id;	}
		 if($role=='')
        {
            $role=$role_session;
        }
		//$today=date('Y-m-d');
		$this -> db -> select('
			ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
			l.assign_to_dse,l.assign_to_dse_tl,l.assign_to_cse,l.assign_by_cse_tl,l.cse_followup_id,l.dse_followup_id,l.lead_source,l.eagerness,l.enq_id,name,l.address,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km,l.feedbackStatus,l.nextAction,l.	days60_booking,'.$table['select_element1']);
		
		$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join($table['lead_followup_table'].' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		if($process_id_session==8){
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.exe_followup_id', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');	
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
			$this -> db -> where('l.evaluation', 'Yes');
	}else{
			$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.dse_followup_id', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
			$this -> db -> where('l.process', $process_name_session);
		}
		
	
		$this -> db -> where('l.nextAction!=', "Close");
		
		//If role DSE TL and Dashboard id blank(for calling task)
		if ($role == '5' && $user_id=='') {
			
			
			$this -> db -> where('l.assign_to_dse',$userid);
				$this -> db -> where("f2.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f2.nextfollowupdate <", $this->today);
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '5' && $user_id!='')
		{
				
		
			$this -> db -> where('l.assign_to_dse_tl',$userid);
			$this -> db -> where("f2.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f2.nextfollowupdate <", $this->today);
	
        }
		//If role DSE 
		elseif($role == '4')
		{
			$this -> db -> where('l.assign_to_dse_tl!=',0);
			$this -> db -> where('l.assign_to_dse', $userid);
			$this -> db -> where("f2.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f2.nextfollowupdate <", $this->today);
		}
		elseif ($role == '15' && $user_id=='') {
			
			
			$this -> db -> where('l.assign_to_e_exe',$userid);
			$this -> db -> where("f2.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f2.nextfollowupdate <", $this->today);
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '15' && $user_id!='')
		{
				
		
			$this -> db -> where('l.assign_to_e_tl',$userid);
			$this -> db -> where("f2.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f2.nextfollowupdate <", $this->today);
	
        }
		//If role DSE 
		elseif($role == '16')
		{
			$this -> db -> where('l.assign_to_e_tl!=',0);
			$this -> db -> where('l.assign_to_e_exe', $userid);
			$this -> db -> where("f2.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f2.nextfollowupdate <", $this->today);
		}
		// If role all executive
		elseif (in_array($role,$executive_array)) {
		$this -> db -> where('l.assign_to_cse', $userid);
			// if u dont want to show transferred leads.
			$this -> db -> where('l.assign_to_dse_tl', 0);
			$this -> db -> where("f1.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f1.nextfollowupdate <", $this->today);
			
			
		}
		//If role is all TL and dashboard id is blank(for calling task)
		elseif(in_array($role,$tl_array) && $user_id==''){
			$this -> db -> where('l.assign_to_cse',$userid);
			$this -> db -> where('l.assign_to_dse_tl', 0);
			$this -> db -> where("f1.nextfollowupdate!=", '0000-00-00');			
			$this -> db -> where("f1.nextfollowupdate <", $this->today);
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
    
			$this -> db -> where('l.assign_to_dse_tl', 0);
			$this -> db -> where("f1.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f1.nextfollowupdate <", $this->today);	  
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			
        }
		if(!empty($contact_no)){
				
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		$this->db->group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		
		$this -> db -> limit($rec_limit,$offset);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
}

	public function select_pending_followup_lead_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page) {
		//Pending Attened Leads
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		ini_set('memory_limit', '-1');
		$table=$this->select_table($process_id_session);	
		$rec_limit = 100;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		if($user_id=='')    {         $userid=$user_id_session;       }
		else {	 $userid=$user_id;	}
		 if($role=='')
        {
            $role=$role_session;
        }
	//	$today=date('Y-m-d');
			$this -> db -> select('count(enq_id) as count_lead');	
		$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join($table['lead_followup_table'].' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
	if($process_id_session==8){
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.exe_followup_id', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');	
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
			$this -> db -> where('l.evaluation', 'Yes');
	}else{
			$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.dse_followup_id', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
			$this -> db -> where('l.process', $process_name_session);
		}
		
		$this -> db -> where('l.nextAction!=', "Close");
		
		//If role DSE TL and Dashboard id blank(for calling task)
		if ($role == '5' && $user_id=='') {
			
			
			$this -> db -> where('l.assign_to_dse',$userid);
				$this -> db -> where("f2.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f2.nextfollowupdate <", $this->today);
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '5' && $user_id!='')
		{
				
		
			$this -> db -> where('l.assign_to_dse_tl',$userid);
			$this -> db -> where("f2.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f2.nextfollowupdate <", $this->today);
	
        }
		//If role DSE 
		elseif($role == '4')
		{
			$this -> db -> where('l.assign_to_dse_tl!=',0);
			$this -> db -> where('l.assign_to_dse', $userid);
			$this -> db -> where("f2.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f2.nextfollowupdate <", $this->today);
		}
			elseif ($role == '15' && $user_id=='') {
			
			
			$this -> db -> where('l.assign_to_e_exe',$userid);
			$this -> db -> where("f2.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f2.nextfollowupdate <", $this->today);
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '15' && $user_id!='')
		{
				
		
			$this -> db -> where('l.assign_to_e_tl',$userid);
			$this -> db -> where("f2.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f2.nextfollowupdate <", $this->today);
	
        }
		//If role DSE 
		elseif($role == '16')
		{
			$this -> db -> where('l.assign_to_e_tl!=',0);
			$this -> db -> where('l.assign_to_e_exe', $userid);
			$this -> db -> where("f2.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f2.nextfollowupdate <", $this->today);
		}
		// If role all executive
		elseif (in_array($role,$executive_array)) {
		$this -> db -> where('l.assign_to_cse', $userid);
			// if u dont want to show transferred leads.
			$this -> db -> where('l.assign_to_dse_tl', 0);
			$this -> db -> where("f1.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f1.nextfollowupdate <", $this->today);
			
			
		}
		//If role is all TL and dashboard id is blank(for calling task)
		elseif(in_array($role,$tl_array) && $user_id==''){
			$this -> db -> where('l.assign_to_cse',$userid);
			$this -> db -> where('l.assign_to_dse_tl', 0);
			$this -> db -> where("f1.nextfollowupdate!=", '0000-00-00');			
			$this -> db -> where("f1.nextfollowupdate <", $this->today);
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
    
			$this -> db -> where('l.assign_to_dse_tl', 0);
			$this -> db -> where("f1.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f1.nextfollowupdate <", $this->today);	  
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			
        }
		if(!empty($contact_no)){
				
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		//$this->db->group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		
		$this -> db -> limit($rec_limit,$offset);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		
		return $query -> result();

	}
	
		
	
	
		// Select All Lead Details
	public function select_all_followup_lead($role,$process_name,$user_id,$contact_no,$page,$process_id,$role_name){
		
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		ini_set('memory_limit', '-1');
		$table=$this->select_table($process_id);	
		$rec_limit = 100;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select('
			ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
			l.nextAction,l.feedbackStatus,l.days60_booking, 
			l.assign_by_cse_tl,l.assign_to_cse,l.cse_followup_id,l.lead_source,l.eagerness,l.enq_id,name,l.address,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km,'.$table['select_element1']);
		$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join($table['lead_followup_table'].' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		if($process_id==8)
		{
			$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.exe_followup_id', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
			$this -> db -> where('l.evaluation', 'Yes');
		}
		else 
		{
			$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.dse_followup_id', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
			$this -> db -> where('l.process', $process_name);
		}
		//if search contact no
		if(!empty($contact_no)){
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		//If user DSE Tl
		if ($role == 5) {
			$this -> db -> where('assign_to_dse_tl', $user_id);
		} elseif ($role == 4) {
			$this -> db -> where('assign_to_dse', $user_id);
		} 
		elseif ($role == 15) {
			$this -> db -> where('assign_to_e_tl', $user_id);
		}
		elseif ($role == 16) {
			$this -> db -> where('assign_to_e_exe', $user_id);
		}elseif (in_array($role, $executive_array)) {
			$this -> db -> where('assign_to_cse', $user_id);
		} elseif (in_array($role, $tl_array)) {
			$w="(assign_by_cse_tl='$user_id' or assign_by_cse_tl=0)";
			$this -> db -> where($w);
			//$this -> db -> where('assign_by_cse_tl', $user_id);
		}
		if($role_name =='Manager'){
			$get_location=$this->db->query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$user_id'")->result();
			$location=array();
			if(count($get_location)>0 ){
		
				foreach ($get_location as $row) {
						$location[]=$row->location_id;
					}
				 $location_id = implode(",",$location);
  		
  			
				if(!in_array(38,$location))
					{
						$where='mp.location_id in ('.$location_id.')';
					$this -> db -> where($where);
					//$query=$query.'And  in ('.$location_id.')';
					}
				}
		}
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		//Limit
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		
		return $query -> result();

	}
	// Select All Lead Details
	public function select_all_followup_lead_count($role,$process_name,$user_id,$contact_no,$page,$process_id,$role_name){
		
		
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		ini_set('memory_limit', '-1');
		$table=$this->select_table($process_id);	
		
	$this -> db -> select('count(enq_id) as count_lead');
	$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join($table['lead_followup_table'].' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		if($process_id==8)
		{
			$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.exe_followup_id', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
			$this -> db -> where('l.evaluation', 'Yes');
		}
		else 
		{
			$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.dse_followup_id', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
			$this -> db -> where('l.process', $process_name);
		}
		//if search contact no
		if(!empty($contact_no)){
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		//If user DSE Tl
		if ($role == 5) {
			$this -> db -> where('assign_to_dse_tl', $user_id);
		} elseif ($role == 4) {
			$this -> db -> where('assign_to_dse', $user_id);
		} 
		elseif ($role == 15) {
			$this -> db -> where('assign_to_e_tl', $user_id);
		}
		elseif ($role == 16) {
			$this -> db -> where('assign_to_e_exe', $user_id);
		}elseif (in_array($role, $executive_array)) {
			$this -> db -> where('assign_to_cse', $user_id);
		} elseif (in_array($role, $tl_array)) {
			$w="(assign_by_cse_tl='$user_id' or assign_by_cse_tl=0)";
			$this -> db -> where($w);
			//$this -> db -> where('assign_by_cse_tl', $user_id);
		}
		if($role_name =='Manager'){
			$get_location=$this->db->query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$user_id'")->result();
			$location=array();
			if(count($get_location)>0 ){
		
				foreach ($get_location as $row) {
						$location[]=$row->location_id;
					}
				 $location_id = implode(",",$location);
  		
  			
				if(!in_array(38,$location))
					{
						$where='mp.location_id in ('.$location_id.')';
					$this -> db -> where($where);
					//$query=$query.'And  in ('.$location_id.')';
					}
				}
		}
		$this -> db -> order_by('l.enq_id', 'desc');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////
	/* Insert Finance Followup */
	public function insert_finace_followup()
	{
	 $assign_to=$this->input->post('user_id');
	 $enq_id=$this->input->post('booking_id');
	 $email=$this->input->post('email');
	 $feedbackstatus=$this->input->post('feedbackstatus');
	 $nextAction=$this->input->post('nextAction');
	 $eagerness=$this->input->post('eagerness');
	 $address=$this->input->post('address');
	 $followupdate=$this->input->post('followupdate');
	 $comment=$this->input->post('comment');
	//echo '<br>';
	 $bank_name=$this->input->post('bank_name');
	 $loan_type=$this->input->post('loan_type');
	 $roi=$this->input->post('roi');
	 $tenure=$this->input->post('tenure');
	 $dealer=$this->input->post('dealer');
	 $car_model=$this->input->post('car_model');
	 $registration_no=$this->input->post('registration_no');
	 $los_no=$this->input->post('los_no');
	 $loanamount=$this->input->post('loan_amount');
	//echo '<br>';
	 $pickup_date=$this->input->post('pickup_date');
	 $excutive_name=$this->input->post('excutive_name');
	 $loan_status=$this->input->post('loan_status');
	 $login_date=$this->input->post('login_date');
	 $approved_date=$this->input->post('approved_date');
	 $disburse_date=$this->input->post('disburse_date');
	 $disburse_amount=$this->input->post('disburse_amount');
	 $process_fee=$this->input->post('process_fee');
	 $emi=$this->input->post('emi');

	
	$today=date('Y-m-d');
	
	$insert_query=$this->db->query("INSERT INTO `lead_followup`(`leadid`, `assign_to`,  `nextfollowupdate`, `comment`, `eagerness`,  `feedbackStatus`, `nextAction`, `date`, `pick_up_date`, `executive_name`, `login_status_name`, `disburse_amount`, `disburse_date`, `process_fee`, `emi`, `approved_date`, `file_login_date`) 
	VALUES ('$enq_id','$assign_to','$followupdate','$comment','$eagerness','$feedbackstatus','$nextAction','$today','$pickup_date','$excutive_name','$loan_status','$disburse_amount','$disburse_date','$process_fee','$emi','$approved_date','$login_date')");
	$followup_id=$this->db->insert_id();
	$update_query=$this->db->query("update lead_master set cse_followup_id='$followup_id', email='$email',feedbackStatus='$feedbackstatus',nextAction='$nextAction',address='$address',bank_name='$bank_name',model_id='$car_model',loan_type='$loan_type',	reg_no='$registration_no',roi='$roi',los_no='$los_no',tenure='$tenure',loanamount='$loanamount',dealer='$dealer',login_status_name='$loan_status' where enq_id='$enq_id'");
	if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Data successfully Inserted.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}
	}
	///////////////////////////////
	/* Insert Service Followup */
	public function insert_service_followup()
	{
	 $assign_to=$this->input->post('user_id');
	 $enq_id=$this->input->post('booking_id');
	 $email=$this->input->post('email');
	 $feedbackstatus=$this->input->post('feedbackstatus');
	 $nextAction=$this->input->post('nextAction');
	 $eagerness=$this->input->post('eagerness');
	 $address=$this->input->post('address');
	 $followupdate=$this->input->post('followupdate');
	 $comment=$this->input->post('comment');
	//echo '<br>';
	 $service_center=$this->input->post('service_center');
	 $car_model=$this->input->post('car_model');
	 $registration_no=$this->input->post('registration_no');
	 $km=$this->input->post('km');
	 $service_type=$this->input->post('service_type');
	 $pick_up=$this->input->post('pick_up');
	 $pickup_date=$this->input->post('pickup_date');
	$today=date('Y-m-d');
	
	$insert_query=$this->db->query("INSERT INTO `lead_followup`
	(`leadid`, `assign_to`,  `nextfollowupdate`, `comment`, `eagerness`,  `feedbackStatus`, `nextAction`, `date`, `pick_up_date`,`pick_up_required`,`service_type`) 
	VALUES ('$enq_id','$assign_to','$followupdate','$comment','$eagerness','$feedbackstatus','$nextAction','$today','$pickup_date','$pick_up','$service_type')");
	$followup_id=$this->db->insert_id();
	$update_query=$this->db->query("update lead_master set cse_followup_id='$followup_id', email='$email',feedbackStatus='$feedbackstatus',nextAction='$nextAction',address='$address',
	service_center='$service_center',model_id='$car_model',reg_no='$registration_no',service_type='$service_type',pickup_required='$pick_up',pick_up_date='$pickup_date',km='$km' where enq_id='$enq_id'");
	if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Data successfully Inserted.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}
	
	}
	///////////////////////////////
	/* Insert Accessories Followup */
	public function insert_accessories_followup()
{
	echo $assign_to=$this->input->post('user_id');
	echo $enq_id=$this->input->post('booking_id');
	echo $email=$this->input->post('email');
	echo $feedbackstatus=$this->input->post('feedbackstatus');
	echo $nextAction=$this->input->post('nextAction');
	echo $eagerness=$this->input->post('eagerness');
	echo $address=$this->input->post('address');
	echo $followupdate=$this->input->post('followupdate');
	echo $comment=$this->input->post('comment');
	echo '<br>';
	//print_r($this->input->post('accessories_id'));
	//print_r($this->input->post('model_id'));
	//print_r($this->input->post('quantity'));
	//print_r($this->input->post('price'));
	//print_r($this->input->post('date'));
	$today=date('Y-m-d');
	
	
		
	/*for($i=0;$i<count($accessories_id_combine);$i++){
	$accessories=explode('#', $accessories_id_combine[$i]);
		
	$accessories_id[]=$accessories[0];
	$accessories_name[]=$accessories[1];
	}*/
	$insert_query=$this->db->query("INSERT INTO `lead_followup`(`leadid`,`comment`, `nextfollowupdate`,`eagerness`, `assign_to`,`date`,`feedbackStatus`, `nextAction`) 
	VALUES ('$enq_id','$comment','$followupdate','$eagerness','$assign_to','$today','$feedbackstatus','$nextAction')");
	echo $this->db->last_query();
	$followup_id=$this->db->insert_id();
	$update_query=$this->db->query("update lead_master set cse_followup_id='$followup_id', email='$email',feedbackStatus='$feedbackstatus',nextAction='$nextAction',address='$address',eagerness='$eagerness' where enq_id='$enq_id'");
	echo $this->db->last_query();
	$accessories_id=json_decode($this->input->post('accessories_id'));
	$accessories_name=json_decode($this->input->post('accessories_name'));
	$model_id=json_decode($this->input->post('model_id'));
	$quantity=json_decode($this->input->post('quantity'));
	$price=json_decode($this->input->post('price'));
	$date=json_decode($this->input->post('date'));
	for($i=0;$i<count($accessories_id);$i++){
	$data=array(
	'accessories_id'=>$accessories_id[$i],
	'accessories_name'=>$accessories_name[$i],
	'model'=>$model_id[$i],
	'customer_id'=>$this->input->post('customer_id'),
	'qty'=>$quantity[$i],
	'price'=>$price[$i],
	'enq_id'=>$enq_id,
	'created_date'=>$date[$i]);
	$this->db->insert('accessories_order_list',$data);
	echo $this->db->last_query();
	}
	if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Data successfully Inserted.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}
}
public function send_sms($user_id,$contactibility,$contact_no)
	{
			//$contactibility = $this -> input -> post('contactibility');
			$q=$this->db->query("select fname,mobileno from lmsuser where id='$user_id'")->result();
			if(count($q)>0)
			{
			if($contactibility=='Connected')
			{
				
					$msg='Hello,Thank you for your enquiry with Autovista Group.In case of any queries,Please contact '.$q[0]->fname.' on '.$q[0]->mobileno.' or visit our website www.autovista.in';
				
			}
			elseif ($contactibility=='Not Connected') {
				$msg='Hello Greetings from Autovista Group. We are unable to reach you on your number at the moment.In case of any queries,Please contact '.$q[0]->fname.' on '.$q[0]->mobileno.' or visit our website www.autovista.in';
			}
			
			//request parameters array
$sendsms =""; //initialize the sendsms variable
$requestParams = array(
	'user' => 'ATVSTA',
    'password' => 'ATVSTA',
    'senderid' => 'ATVSTA',
	'channel'=>'Trans',
	'DCS'=>'0',
	'flashsms'=>'0',
	'route'=>'1',
	'number'=>$contact_no,
	'text'=>$msg
	
);

//merge API url and parameters
$apiUrl = "http://domain.ismsexpert.com/api/mt/SendSMS?";
foreach($requestParams as $key => $val){
    $apiUrl .= $key.'='.urlencode($val).'&';
}
$apiUrl = rtrim($apiUrl, "&");

//API call
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_exec($ch);
curl_close($ch);
			

		}
	}
public function insert_new_car_followup()
{
	
		$today = date("Y-m-d");
		$time = date("h:i:s A");
		 $enq_id = $this -> input -> post('booking_id');		
		$old_data=$this->db->query("select name,contact_no,lead_source,enquiry_for,alternate_contact_no,email,address,model_id,variant_id,feedbackStatus,nextAction,appointment_type,
		buyer_type,old_make,old_model,ownership,manf_year,km,accidental_claim,customer_occupation,customer_designation,customer_corporate_name,appointment_date,appointment_time,appointment_status,interested_in_finance,interested_in_accessories,interested_in_insurance,interested_in_ew,quotation_sent from lead_master where enq_id='".$enq_id."'")->result();
		
		//print_r($old_data);
		//Basic Followup
		$name=$old_data[0]->name;
		$contact_no=$old_data[0]->contact_no;
		$lead_source=$old_data[0]->lead_source;
		$enquiry_for=$old_data[0]->enquiry_for;
		$days60_booking = $this -> input -> post('days60_booking');
		$contactibility = $this -> input -> post('contactibility');
		//$td_hv_date = $this -> input -> post('td_hv_date');
		
		
		$feedback = $this -> input -> post('feedback');
		if(!$feedback)
		{
			$feedback = $old_data[0]->feedbackStatus;
		}
		$nextaction = $this -> input -> post('nextaction');
		if(!$nextaction)
		{
			$nextaction = $old_data[0]->nextAction;
		}
		 $alternate_contact=$this->input->post('alternate_contact');
		 if(!$alternate_contact)
		{
			$alternate_contact = $old_data[0]->alternate_contact_no;
		}
		$email = $this -> input -> post('email');
		if(!$email)
		{
			if($old_data[0]->email!=null)
			{
			 $email = $old_data[0]->email;
			}
		}
		 $address1 = $this -> input -> post('address');
		if(!$address1)
		{
			 $address1 = $old_data[0]->address;
		}
		$address = addslashes($address1);
		 $followupdate = $this -> input -> post('followupdate');
		 $followuptime = $this -> input -> post('followuptime');
		 if($followupdate=='')
		 {
		 	if($nextaction=='Close' || $nextaction=='Booked From Autovista' || $nextaction=='Done'){
		 	$followupdate='0000-00-00';
			$followuptime='00:00:00';
		 }else{
		 	$tomarrow_date = date('Y-m-d', strtotime(' +1 day'));			
		 	$followupdate = $tomarrow_date;
			$followuptime='11:00:00';
		 }
		 }
		//New Car Details
		$new_model = $this -> input -> post('new_model');
		if(!$new_model)
		{
			 $new_model = $old_data[0]->model_id;
		}
		 $new_variant = $this -> input -> post('new_variant');
		if(!$new_variant)
		{
			 $new_variant = $old_data[0]->variant_id;
		}
		$comment1 = $this -> input -> post('comment');
		$comment = addslashes($comment1);
		 //session value
		 $assign_by = $this->input->post('user_id');
		 $role = $this->input->post('role');
		 $process_id = $this->input->post('process_id');
		//Transfer Lead
		 $assign = $this -> input -> post('transfer_assign');
		 $tlocation = $this -> input -> post('tlocation');
		 //Showroom Location 
		 if($this -> input -> post('tlocation')!=''){
		 	$slocation= $this -> input -> post('tlocation');
		 }else{
		 	$getlocation=$this->db->query("select location from lead_master where enq_id='$enq_id'")->result();
			if(count($getlocation)>0){
				$slocation=$getlocation[0]->location;
			}else{
				$slocation='';
			}
		 }
			if($contactibility=='Connected' || $contactibility=='Not Connected')
		{
			//$this->send_sms($assign_by,$contactibility,$contact_no);
		}
		 $appointment_type = $this->input->post('appointment_type');
		 $appointment_date = $this->input->post('appointment_date');
		 $appointment_time = $this->input->post('appointment_time');		 
		 $appointment_status = $this->input->post('appointment_status');		
		  //escalation
		 $escalation_type = $this->input->post('escalation_type');
		 $escalation_remark = $this->input->post('escalation_remark');
		 
		 //interested In
		 $interested_in_finance=$this->input->post('interested_in_finance');
		$interested_in_accessories=$this->input->post('interested_in_accessories');
		$interested_in_insurance=$this->input->post('interested_in_insurance');
		$interested_in_ew=$this->input->post('interested_in_ew');
		//Insert in lead_followup
		$insert = $this -> db -> query("INSERT INTO `lead_followup`
		(`leadid`, `comment`, `nextfollowupdate`, `nextfollowuptime`, `assign_to`,`date`,`created_time`,`days60_booking`,`feedbackStatus`,`nextAction`,`contactibility`
		,`appointment_type`,`appointment_date`,`appointment_time`,`appointment_status`,app) 
		VALUES ('$enq_id','$comment','$followupdate','$followuptime','$assign_by','$today','$time','$days60_booking','$feedback','$nextaction','$contactibility'
		,'$appointment_type','$appointment_date','$appointment_time','$appointment_status','1')") or die(mysql_error());
		$followup_id = $this->db->insert_id();
		// $this->db->last_query();
		//Update Follow up in lead__master
	
		if($role==2 || $role==3){
			$followup='cse_followup_id='.$followup_id;
		}else{
			$followup='dse_followup_id='.$followup_id;
		}
		if(!$appointment_type)
		{
			$appointment_type = $old_data[0]->appointment_type;
		}
		if(!$appointment_date)
		{
			$appointment_date = $old_data[0]->appointment_date;
		}
		if(!$appointment_time)
		{
			$appointment_time = $old_data[0]->appointment_time;
		}
		
		if(!$appointment_status)
		{
			$appointment_status = $old_data[0]->appointment_status;
		}
		
		if(!$interested_in_finance)
		{
			$interested_in_finance = $old_data[0]->interested_in_finance;
		}
		if(!$interested_in_accessories)
		{
			$interested_in_accessories = $old_data[0]->interested_in_accessories;
		}
		if(!$interested_in_insurance)
		{
			$interested_in_insurance = $old_data[0]->interested_in_insurance;
		}
		if(!$interested_in_ew)
		{
			$interested_in_ew = $old_data[0]->interested_in_ew;
		}
		
		$buyer_type=$this->input->post('buyer_type');
		$old_make=$this->input->post('old_make');
		$old_model=$this->input->post('old_model');
		$ownership=$this->input->post('ownership');
		$mfg=$this->input->post('mfg');
		$km=$this->input->post('km');
		$claim=$this->input->post('claim');
		
		$customer_occupation=$this->input->post('customer_occupation');
		$customer_designation=$this->input->post('customer_designation');
		$customer_corporate_name=$this->input->post('customer_corporate_name');
		
		if(!$buyer_type)
		{
			$buyer_type = $old_data[0]->buyer_type;
		}
			if(!$old_make)
		{
			$old_make = $old_data[0]->old_make;
		}
			if(!$old_model)
		{
			$old_model = $old_data[0]->old_model;
		}
			if(!$ownership)
		{
			$ownership = $old_data[0]->ownership;
		}
			if(!$mfg)
		{
			$mfg = $old_data[0]->manf_year;
		}
			if(!$km)
		{
			$km = $old_data[0]->km;
		}
			if(!$claim)
		{
			$claim = $old_data[0]->accidental_claim;
		}
			if(!$customer_occupation)
		{
			$customer_occupation = $old_data[0]->customer_occupation;
		}
			if(!$customer_designation)
		{
			$customer_designation = $old_data[0]->customer_designation;
		}
			if(!$customer_corporate_name)
		{
			$customer_corporate_name = $old_data[0]->customer_corporate_name;
		}
		$qlocation=$this->input->post('qlocation');
		
			if($qlocation!=''){
				$quotation_sent='Yes';
			}else{
				$old_quotation_sent=$old_data[0]->quotation_sent;
				if($old_quotation_sent!=''){
					$quotation_sent=$old_quotation_sent;
				}else{
					$quotation_sent='';
				}
				
			}
		
		$update = $this -> db -> query("update lead_master set $followup,email='$email',alternate_contact_no='$alternate_contact',location='$slocation',address='$address',
		model_id='$new_model',variant_id='$new_variant',buyer_type='$buyer_type',
		old_make='$old_make',old_model='$old_model',ownership='$ownership',manf_year='$mfg',km='$km',accidental_claim='$claim',
		days60_booking='$days60_booking',nextAction='$nextaction',feedbackStatus='$feedback', 
		appointment_type='$appointment_type',appointment_date='$appointment_date',
		appointment_time='$appointment_time',appointment_status='$appointment_status',
		interested_in_finance='$interested_in_finance',interested_in_accessories='$interested_in_accessories',interested_in_insurance='$interested_in_insurance',interested_in_ew='$interested_in_ew'
		,customer_occupation='$customer_occupation',customer_corporate_name='$customer_corporate_name',customer_designation='$customer_designation', quotation_sent='$quotation_sent' where enq_id='$enq_id'");
		//	 $this->db->last_query();
		//Transfer Lead
		
		if ($assign != '') {
			$tprocess=$this->input->post('tprocess');
			$select_process=$this->db->query("select process_name from tbl_process where process_id='$tprocess'")->result();
			$process_name=$select_process[0]->process_name;
			
			// Assign User Details
			$get_user_role=$this->db->query("select role from lmsuser where id='$assign'")->result();
			
			//Assign CSE To CSE
			if(($get_user_role[0]->role == 2 or $get_user_role[0]->role==3) && $role==3){
				$assign_user='assign_to_cse='.$assign;
				$assign_date='assign_to_cse_date';
				$user_followup_id='cse_followup_id = 0';
				$assign_by_cse='assign_by_cse='.$assign_by.',';
			}
			//Assign CSE To DSE TL
			if($get_user_role[0]->role == 5 && ($role==2 || $role==3)){
				$assign_user='assign_to_dse_tl='.$assign;
				$assign_date='assign_to_dse_tl_date';
				$user_followup_id='dse_followup_id = 0';
				$assign_by_cse='assign_by_cse='.$assign_by.',';
			}
			//Assign  DSE To DSE TL
			if($get_user_role[0]->role == 5 && $role==4 ){
				$assign_user='assign_to_dse_tl='.$assign;
				$assign_date='assign_to_dse_tl_date';
				$user_followup_id='dse_followup_id = 0,assign_to_dse=0,assign_to_dse_date="0000-00-00"';
				//$user_followup_id='dse_followup_id = 0';
				$assign_by_cse='';
			}
			//Assign DSE TL TO DSE 
			if($get_user_role[0]->role == 4 &&  $role==5){
				$assign_user='assign_to_dse='.$assign;
				$assign_date='assign_to_dse_date';
				$user_followup_id='dse_followup_id = 0';
				$assign_by_cse='';
			}
			//Assign DSE TL To DSE TL
			if($get_user_role[0]->role == 5 &&  $role==5){
				$assign_user='assign_to_dse_tl='.$assign;
				$assign_date='assign_to_dse_tl_date';
				$user_followup_id='dse_followup_id = 0';
				$assign_by_cse='';
			}
			
			//Assign DSE  To DSE 
			if($get_user_role[0]->role == 4 &&  $role==4){
				$assign_user='assign_to_dse='.$assign;
				$assign_date='assign_to_dse_date';
				$user_followup_id='dse_followup_id = 0';
				$assign_by_cse='';
			}
			
			if($tprocess=='6'){
				$insertQuery = $this -> db -> query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` , `location` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $assign . '","' . $assign_by . '","' . $tlocation . '","' . $today . '","' . $time . '","Transfered")');
			$transfer_id=$this->db->insert_id();
			//$this->db->last_query();		

			$update1 = $this -> db -> query("update lead_master set transfer_id='$transfer_id',".$user_followup_id.",".$assign_user.",".$assign_by_cse.$assign_date."='$today' where enq_id='$enq_id'");
			
				}
elseif($tprocess == '7'){
	
	$checkUserProcess=$this->db->query("select process_id from tbl_manager_process where user_id='$assign_by' and process_id='7'")->result();
			
			if(count($checkUserProcess)>0)
			{
				$update1 = $this -> db -> query("update lead_master set process='POC Sales' where enq_id='$enq_id'");
				//echo $this->db->last_query();
			
				$insertQuery = $this -> db -> query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` , `location` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $assign . '","' . $assign_by . '","' . $tlocation . '","' . $today . '","' . $time . '","Transfered")');
			$transfer_id=$this->db->insert_id();
			//$this->db->last_query();		

			$update1 = $this -> db -> query("update lead_master set transfer_id='$transfer_id',".$user_followup_id.",".$assign_user.",".$assign_by_cse.$assign_date."='$today' where enq_id='$enq_id'");
			
			}else{
					$update1 = $this -> db -> query("update lead_master set transfer_process='$process_name' where enq_id='$enq_id'");
			$insert_new_lead = $this -> db -> query("insert into lead_master(process,name,contact_no,email,lead_source,enquiry_for,created_date,app) values('$process_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today','1')");
			$new_enq_id = $this->db->insert_id();
			$transfer_other_process=$this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead`,`from_process`, `to_process`, `created_date`) 
			VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today')");
		
			}
	}
else {
	$update1 = $this -> db -> query("update lead_master set transfer_process='$process_name' where enq_id='$enq_id'");
			$insert_new_lead = $this -> db -> query("insert into lead_master_all(process,name,contact_no,email,lead_source,enquiry_for,created_date,app) values('$process_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today','1')");
			$new_enq_id = $this->db->insert_id();
			$transfer_other_process=$this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead_all`,`from_process`, `to_process`, `created_date`) 
			VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today')");	
}
		
		
		}
		$evaluation_assign_to=$this->input->post('evaluation_assign_to');
		if($evaluation_assign_to !='')
		{
			$evaluation_location=$this->input->post('evaluation_location');
			$insertQuery = $this -> db -> query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` , `location` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $evaluation_assign_to . '","' . $assign_by . '","' . $evaluation_location . '","' . $today . '","' . $time . '","Transfered")');
			$transfer_id=$this->db->insert_id();
			$update1 = $this -> db -> query("update lead_master set transfer_id='$transfer_id',evaluation='Yes',assign_to_e_tl='$evaluation_assign_to',assign_to_e_tl_date='$today',assign_to_e_tl_time='$time' where enq_id='$enq_id'");
	}
	if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Data successfully Inserted.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}
	
}
function select_quotation_data($quotation_location, $quotation_model_name, $quotation_description,$accessories_package_name)
	{
			if($accessories_package_name!=''){
		$this->db->select('q.*,l.*,m.model_name as quot_model');
			}else{
			$this->db->select('q.*,m.model_name as quot_model');	
			}
	$this->db->from('tbl_quotation q');
	if($accessories_package_name!=''){
	$this->db->join('tbl_accessories_package_lms l','l.model_id=q.model_id');
	}
	$this->db->join('make_models m','m.model_id=q.model_id');
	$this->db->where('q.location',$quotation_location);
	$this->db->where('q.model_id',$quotation_model_name);
	if($quotation_description!=''){
	$this->db->where('q.variant',$quotation_description);
	}
	if($accessories_package_name!=''){
	$this->db->where('l.accessories_package_id',$accessories_package_name);
	}
	$query=$this->db->get();
	//echo $this->db->last_query();
	return $query->result();
	}
	function select_brochure($model){
		$this->db->select('brochure,model_name');
		$this->db->from('make_models');
		$this->db->where('model_id',$model);
		$query=$this->db->get();
		return $query -> result();

	}
	function corporate() 
	{
		$this->db->select('*');
		$this->db->from('tbl_corporate');
		$query = $this->db->get();
		return $query->result();
	
		
	}	
public function insert_evaluation_followup()
{
	
		$today = date("Y-m-d");
		$time = date("h:i:s A");
		 $enq_id = $this -> input -> post('booking_id');		
		$old_data=$this->db->query("select name,contact_no,lead_source,enquiry_for,alternate_contact_no,email,address,model_id,variant_id,feedbackStatus,nextAction,appointment_type,
		appointment_date,appointment_time,appointment_address,appointment_status,appointment_rating,appointment_feedback,interested_in_finance,interested_in_accessories,interested_in_insurance,interested_in_ew from lead_master where enq_id='".$enq_id."'")->result();
	
		//print_r($old_data);
		//Basic Followup
		$name=$old_data[0]->name;
		$contact_no=$old_data[0]->contact_no;
		$lead_source=$old_data[0]->lead_source;
		$enquiry_for=$old_data[0]->enquiry_for;
		$days60_booking = $this -> input -> post('days60_booking');
		$contactibility = $this -> input -> post('contactibility');
		$td_hv_date = $this -> input -> post('td_hv_date');
		$feedback = $this -> input -> post('feedback');
		if(!$feedback)
		{
			$feedback = $old_data[0]->feedbackStatus;
		}
		$nextaction = $this -> input -> post('nextaction');
		if(!$nextaction)
		{
			$nextaction = $old_data[0]->nextAction;
		}
		 $alternate_contact=$this->input->post('alternate_contact');
		 if(!$alternate_contact)
		{
			$alternate_contact = $old_data[0]->alternate_contact_no;
		}
		$email = $this -> input -> post('email');
		if(!$email)
		{
			if($old_data[0]->email!=null)
			{
			 $email = $old_data[0]->email;
			}
		}
		 $address1 = $this -> input -> post('address');
		if(!$address1)
		{
			 $address1 = $old_data[0]->address;
		}
		$address = addslashes($address1);
		 $followupdate = $this -> input -> post('followupdate');
		 $followuptime = $this -> input -> post('followuptime');
		 if($followupdate=='')
		 {
		 	if($nextaction=='Close' || $nextaction=='Booked From Autovista' || $nextaction=='Done'){
		 	$followupdate='0000-00-00';
			$followuptime='00:00:00';
		 }else{
		 	$tomarrow_date = date('Y-m-d', strtotime(' +1 day'));			
		 	$followupdate = $tomarrow_date;
			$followuptime='11:00:00';
		 }
		 }
		//New Car Details
		$new_model = $this -> input -> post('new_model');
		if(!$new_model)
		{
			 $new_model = $old_data[0]->model_id;
		}
		 $new_variant = $this -> input -> post('new_variant');
		if(!$new_variant)
		{
			 $new_variant = $old_data[0]->variant_id;
		}
		$comment1 = $this -> input -> post('comment');
		$comment = addslashes($comment1);
		 //session value
		 $assign_by = $this->input->post('user_id');
		 $role = $this->input->post('role');
		 $process_id = $this->input->post('process_id');
		 //Exchange Car Details

		 $old_make = $this -> input -> post('old_make');
		 $old_model = $this -> input -> post('old_model');
		 $color = $this -> input -> post('color');
		 $ownership = $this -> input -> post('ownership');
		 $mfg = $this -> input -> post('mfg');
		 $km = $this -> input -> post('km');
		 $claim = $this -> input -> post('claim');
		 $evaluation_within_days = $this -> input -> post('evaluation_within_days');
		 $fuel_type = $this -> input -> post('fuel_type');
		 $color = $this -> input -> post('color');
		  $registration_no = $this -> input -> post('registration_no');
		 $quotated_price = $this -> input -> post('quoted_price');
		 $expected_price = $this -> input -> post('expected_price');
		 
		//Transfer Lead
		 $assign = $this -> input -> post('transfer_assign');
		 $tlocation = $this -> input -> post('tlocation');
		 //Showroom Location 
		 if($this -> input -> post('tlocation')!=''){
		 	$slocation= $this -> input -> post('tlocation');
		 }else{
		 	$getlocation=$this->db->query("select location from lead_master where enq_id='$enq_id'")->result();
			if(count($getlocation)>0){
				$slocation=$getlocation[0]->location;
			}else{
				$slocation='';
			}
		 }
		 	if($contactibility=='Connected' || $contactibility=='Not Connected')
		{
			//$this->send_sms($assign_by,$contactibility,$contact_no);
		}
		 $appointment_type = $this->input->post('appointment_type');
		 $appointment_date = $this->input->post('appointment_date');
		 $appointment_time = $this->input->post('appointment_time');
		 $appointment_address = $this->input->post('appointment_address');
		 $appointment_status = $this->input->post('appointment_status');
		 $appointment_rating = $this->input->post('appointment_rating');
		 $appointment_feedback = $this->input->post('appointment_feedback');
		  //escalation
		 $escalation_type = $this->input->post('escalation_type');
		 $escalation_remark = $this->input->post('escalation_remark');
		 
		 //interested In
		 $interested_in_finance=$this->input->post('interested_in_finance');
		$interested_in_accessories=$this->input->post('interested_in_accessories');
		$interested_in_insurance=$this->input->post('interested_in_insurance');
		$interested_in_ew=$this->input->post('interested_in_ew');
		//Insert in lead_followup
		$insert = $this -> db -> query("INSERT INTO `lead_followup`
		(`leadid`, `comment`, `nextfollowupdate`, `nextfollowuptime`, `assign_to`,`date`,`created_time`,`days60_booking`,`td_hv_date`,`feedbackStatus`,`nextAction`,`contactibility`
		,`appointment_type`,`appointment_date`,`appointment_time`,`appointment_address`,`appointment_status`,`appointment_rating`,`appointment_feedback`) 
		VALUES ('$enq_id','$comment','$followupdate','$followuptime','$assign_by','$today','$time','$days60_booking','$td_hv_date','$feedback','$nextaction','$contactibility'
		,'$appointment_type','$appointment_date','$appointment_time','$appointment_address','$appointment_status','$appointment_rating','$appointment_feedback')") or die(mysql_error());
		$followup_id = $this->db->insert_id();
		// $this->db->last_query();
		//Update Follow up in lead__master
		/*if($role==2 || $role==3){
			$followup='cse_followup_id='.$followup_id;
		}else{
			$followup='dse_followup_id='.$followup_id;
		}*/
		if(!$appointment_type)
		{
			$appointment_type = $old_data[0]->appointment_type;
		}
		if(!$appointment_date)
		{
			$appointment_date = $old_data[0]->appointment_date;
		}
		if(!$appointment_time)
		{
			$appointment_time = $old_data[0]->appointment_time;
		}
		if(!$appointment_address)
		{
			$appointment_address = $old_data[0]->appointment_address;
		}
		if(!$appointment_status)
		{
			$appointment_status = $old_data[0]->appointment_status;
		}
		if(!$appointment_rating)
		{
			$appointment_rating = $old_data[0]->appointment_rating;
		}
		if(!$appointment_feedback)
		{
			$appointment_feedback = $old_data[0]->appointment_feedback;
		}
		if(!$interested_in_finance)
		{
			$interested_in_finance = $old_data[0]->interested_in_finance;
		}
		if(!$interested_in_accessories)
		{
			$interested_in_accessories = $old_data[0]->interested_in_accessories;
		}
		if(!$interested_in_insurance)
		{
			$interested_in_insurance = $old_data[0]->interested_in_insurance;
		}
		if(!$interested_in_ew)
		{
			$interested_in_ew = $old_data[0]->interested_in_ew;
		}
		
		
		$update = $this -> db -> query("update lead_master set exe_followup_id='$followup_id',email='$email',alternate_contact_no='$alternate_contact',address='$address',
		old_make='$old_make',old_model='$old_model',color='$color',ownership='$ownership',manf_year='$mfg',km='$km',accidental_claim='$claim',evaluation_within_days='$evaluation_within_days',fuel_type='$fuel_type',reg_no='$registration_no',quotated_price='$quotated_price',expected_price='$expected_price',
		appointment_type='$appointment_type',appointment_date='$appointment_date',
		appointment_time='$appointment_time',appointment_address='$appointment_address',appointment_status='$appointment_status',
		appointment_rating='$appointment_rating',appointment_feedback='$appointment_feedback',interested_in_finance='$interested_in_finance',interested_in_accessories='$interested_in_accessories',interested_in_insurance='$interested_in_insurance',interested_in_ew='$interested_in_ew'  where enq_id='$enq_id'");
	//	 $this->db->last_query();
		//Transfer Lead
		
		
		$evaluation_assign_to=$this->input->post('evaluation_assign_to');
		if($evaluation_assign_to !='')
		{
			$evaluation_location=$this->input->post('evaluation_location');
			$insertQuery = $this -> db -> query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` , `location` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $evaluation_assign_to . '","' . $assign_by . '","' . $evaluation_location . '","' . $today . '","' . $time . '","Transfered")');
			$transfer_id=$this->db->insert_id();
			$update1 = $this -> db -> query("update lead_master set transfer_id='$transfer_id',evaluation='Yes',assign_to_e_tl='$evaluation_assign_to',assign_to_e_tl_date='$today',assign_to_e_tl_time='$time' where enq_id='$enq_id'");
	}
	if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Data successfully Inserted.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}
	
}


public function insert_used_car_followup()
{
	
		$today = date("Y-m-d");
		$time = date("h:i:s A");
		
		$enq_id = $this -> input -> post('booking_id');		
		$old_data=$this->db->query("select name,contact_no,lead_source,enquiry_for,alternate_contact_no,email,address,model_id,variant_id,feedbackStatus,nextAction,buyer_type
		,appointment_type,old_make,old_model,ownership,manf_year,km,accidental_claim,customer_occupation,customer_designation,customer_corporate_name,appointment_date,appointment_time,appointment_address,appointment_status,appointment_rating,appointment_feedback,interested_in_finance,interested_in_accessories,interested_in_insurance,interested_in_ew
		 from lead_master where enq_id='".$enq_id."'")->result();
		$name=$old_data[0]->name;
		$contact_no=$old_data[0]->contact_no;
		$lead_source=$old_data[0]->lead_source;
		$enquiry_for=$old_data[0]->enquiry_for;
		$days60_booking = $this -> input -> post('days60_booking');
		$contactibility = $this -> input -> post('contactibility');
		$td_hv_date = $this -> input -> post('td_hv_date');
		$feedback = $this -> input -> post('feedback');
		if(!$feedback)
		{
			$feedback = $old_data[0]->feedbackStatus;
		}
		$nextaction = $this -> input -> post('nextaction');
		if(!$nextaction)
		{
			$nextaction = $old_data[0]->nextAction;
		}
		 $alternate_contact=$this->input->post('alternate_contact');
		 if(!$alternate_contact)
		{
			$alternate_contact = $old_data[0]->alternate_contact_no;
		}
		$email = $this -> input -> post('email');
		if(!$email)
		{
			if($old_data[0]->email!=null)
			{
			 $email = $old_data[0]->email;
			}
		}
		 $address1 = $this -> input -> post('address');
		if(!$address1)
		{
			 $address1 = $old_data[0]->address;
		}
		$address = addslashes($address1);
		 $followupdate = $this -> input -> post('followupdate');
		 $followuptime = $this -> input -> post('followuptime');
		 if($followupdate=='')
		 {
		 	if($nextaction=='Close' || $nextaction=='Booked From Autovista' || $nextaction=='Done'){
		 	$followupdate='0000-00-00';
			$followuptime='00:00:00';
		 }else{
		 	$tomarrow_date = date('Y-m-d', strtotime(' +1 day'));			
		 	$followupdate = $tomarrow_date;
			$followuptime='11:00:00';
		 }
		 }
		 $buyer_type = $this -> input -> post('buyer_type');
		if (!$buyer_type) {
			$buyer_type = $old_data[0] -> buyer_type;
		}
		//New Car Details
		$new_model = $this -> input -> post('new_model');
		if(!$new_model)
		{
			 $new_model = $old_data[0]->model_id;
		}
		 $new_variant = $this -> input -> post('new_variant');
		if(!$new_variant)
		{
			 $new_variant = $old_data[0]->variant_id;
		}
		//Exchange Car Details
		$old_make = $this -> input -> post('old_make');
		$old_model = $this -> input -> post('old_model');
		$ownership = $this -> input -> post('ownership');
		$mfg = $this -> input -> post('mfg');
		$km = $this -> input -> post('km');
		$claim = $this -> input -> post('claim');
		//Buy used car Details
		$buy_make = $this -> input -> post('buy_make');
		$buy_model = $this -> input -> post('buy_model');
		$visit_status = $this -> input -> post('visit_status');
		$budget_from = $this -> input -> post('budget_from');
		$budget_to = $this -> input -> post('budget_to');
		$comment1 = $this -> input -> post('comment');
		$comment = addslashes($comment1);
		 //session value
		 $assign_by = $this->input->post('user_id');
		 $role = $this->input->post('role');
		 $process_id = $this->input->post('process_id');
		//Transfer Lead
		 $assign = $this -> input -> post('transfer_assign');
		 $tlocation = $this -> input -> post('tlocation');
		 //Showroom Location 
		 if($this -> input -> post('tlocation')!=''){
		 	$slocation= $this -> input -> post('tlocation');
		 }else{
		 	$getlocation=$this->db->query("select location from lead_master where enq_id='$enq_id'")->result();
			if(count($getlocation)>0){
				$slocation=$getlocation[0]->location;
			}else{
				$slocation='';
			}
		 }
		 
		if($contactibility=='Connected' || $contactibility=='Not Connected')
		{
			//$this->send_sms($assign_by,$contactibility,$contact_no);
		}
		 //Appointment
		   $appointment_type = $this->input->post('appointment_type');
		 $appointment_date = $this->input->post('appointment_date');
		  $appointment_time = $this->input->post('appointment_time');
	
		 $appointment_status = $this->input->post('appointment_status');
		 
		
		 
		 //interested In
		 $interested_in_finance=$this->input->post('interested_in_finance');
		$interested_in_accessories=$this->input->post('interested_in_accessories');
		$interested_in_insurance=$this->input->post('interested_in_insurance');
		$interested_in_ew=$this->input->post('interested_in_ew');
		$customer_occupation=$this->input->post('customer_occupation');
		$customer_designation=$this->input->post('customer_designation');
		$customer_corporate_name=$this->input->post('customer_corporate_name');
		 if(!$appointment_type)
		{
			$appointment_type = $old_data[0]->appointment_type;
		}
		if(!$appointment_date)
		{
			$appointment_date = $old_data[0]->appointment_date;
		}
		if(!$appointment_time)
		{
			$appointment_time = $old_data[0]->appointment_time;
		}
		
		if(!$appointment_status)
		{
			$appointment_status = $old_data[0]->appointment_status;
		}
		
		if(!$interested_in_finance)
		{
			$interested_in_finance = $old_data[0]->interested_in_finance;
		}
		if(!$interested_in_accessories)
		{
			$interested_in_accessories = $old_data[0]->interested_in_accessories;
		}
		if(!$interested_in_insurance)
		{
			$interested_in_insurance = $old_data[0]->interested_in_insurance;
		}
		if(!$interested_in_ew)
		{
			$interested_in_ew = $old_data[0]->interested_in_ew;
		}
		if(!$customer_occupation)
		{
			$customer_occupation = $old_data[0]->customer_occupation;
		}
			if(!$customer_designation)
		{
			$customer_designation = $old_data[0]->customer_designation;
		}
			if(!$customer_corporate_name)
		{
			$customer_corporate_name = $old_data[0]->customer_corporate_name;
		}
		if(!$buyer_type)
		{
			$buyer_type = $old_data[0]->buyer_type;
		}
			if(!$old_make)
		{
			$old_make = $old_data[0]->old_make;
		}
			if(!$old_model)
		{
			$old_model = $old_data[0]->old_model;
		}
			if(!$ownership)
		{
			$ownership = $old_data[0]->ownership;
		}
			if(!$mfg)
		{
			$mfg = $old_data[0]->manf_year;
		}
			if(!$km)
		{
			$km = $old_data[0]->km;
		}
			if(!$claim)
		{
			$claim = $old_data[0]->accidental_claim;
		}
		 
		//Insert in lead_followup
		$insert = $this -> db -> query("INSERT INTO `lead_followup`
		(`leadid`, `comment`, `nextfollowupdate`, `nextfollowuptime`, `assign_to`,`date`,`created_time`,`days60_booking`,`td_hv_date`,`feedbackStatus`,`nextAction`,`contactibility`,`appointment_type`,`appointment_date`,`appointment_time`,`appointment_address`,`appointment_status`,`appointment_rating`,`appointment_feedback`,app) 
		VALUES ('$enq_id','$comment','$followupdate','$followuptime','$assign_by','$today','$time','$days60_booking','$td_hv_date','$feedback','$nextaction','$contactibility','$appointment_type','$appointment_date','$appointment_time','$appointment_address','$appointment_status','$appointment_rating','$appointment_feedback','1')") or die(mysql_error());
		$followup_id = $this->db->insert_id();
		 $this->db->last_query();
		//Update Follow up in lead__master
		if($role==2 || $role==3){
			$followup='cse_followup_id='.$followup_id;
		}else{
			$followup='dse_followup_id='.$followup_id;
		}
		
		$update = $this -> db -> query("update lead_master set $followup,email='$email',alternate_contact_no='$alternate_contact',address='$address',
		model_id='$new_model',variant_id='$new_variant',buyer_type='$buyer_type',
		old_make='$old_make',old_model='$old_model',ownership='$ownership',manf_year='$mfg',km='$km',accidental_claim='$claim',buy_make='$buy_make',buy_model='$buy_model',budget_from='$budget_from',budget_to='$budget_to',days60_booking='$days60_booking',nextAction='$nextaction',feedbackStatus='$feedback' ,
				appointment_type='$appointment_type',appointment_date='$appointment_date',
		appointment_time='$appointment_time',appointment_status='$appointment_status',
		interested_in_finance='$interested_in_finance',interested_in_accessories='$interested_in_accessories',interested_in_insurance='$interested_in_insurance',interested_in_ew='$interested_in_ew'
		,customer_occupation='$customer_occupation',customer_corporate_name='$customer_corporate_name',customer_designation='$customer_designation' where enq_id='$enq_id'");
		 $this->db->last_query();
		//Transfer Lead
		
		if ($assign != '') {
			$today1 = date("Y-m-d");
			$tprocess=$this->input->post('tprocess');
			$select_process=$this->db->query("select process_name from tbl_process where process_id='$tprocess'")->result();
			$process_name=$select_process[0]->process_name;
			
			// Assign User Details
			$get_user_role=$this->db->query("select role from lmsuser where id='$assign'")->result();
			//Assign CSE To CSE
			if(($get_user_role[0]->role == 2 or $get_user_role[0]->role==3) && ($role==3 || $role==2)){
				$assign_user='assign_to_cse='.$assign;
				$assign_date='assign_to_cse_date';
				$assign_time='assign_to_cse_time';
				$user_followup_id='cse_followup_id = 0';
				$assign_by_cse='assign_by_cse='.$assign_by.',';
			}
			//Assign CSE To DSE TL
			if($get_user_role[0]->role == 5 && ($role==2 || $role==3)){
				$assign_user='assign_to_dse_tl='.$assign;
				$assign_date='assign_to_dse_tl_date';
				$assign_time='assign_to_dse_tl_time';
				$user_followup_id='dse_followup_id = 0';
				$assign_by_cse='assign_by_cse='.$assign_by.',';
			}
			//Assign  DSE To DSE TL
			if($get_user_role[0]->role == 5 && $role=4 ){
				$assign_user='assign_to_dse_tl='.$assign;
				$assign_date='assign_to_dse_tl_date';
				$assign_time='assign_to_dse_tl_time';
				$user_followup_id='dse_followup_id = 0,assign_to_dse=0,assign_to_dse_date="0000-00-00"';
				//$user_followup_id='dse_followup_id = 0';
				$assign_by_cse='';
			}
			//Assign DSE TL TO DSE 
			if($get_user_role[0]->role == 4 &&  $role==5){
				$assign_user='assign_to_dse='.$assign;
				$assign_date='assign_to_dse_date';
				$assign_time='assign_to_dse_time';
				$user_followup_id='dse_followup_id = 0';
				$assign_by_cse='';
			}
			//Assign DSE TL To DSE TL
			if($get_user_role[0]->role == 5 &&  $role==5){
				$assign_user='assign_to_dse_tl='.$assign;
				$assign_date='assign_to_dse_tl_date';
				$assign_time='assign_to_dse_tl_time';
				$user_followup_id='dse_followup_id = 0';
				$assign_by_cse='';
			}
			
			
			//Assign DSE  To DSE 
			if($get_user_role[0]->role == 4 &&  $role==4){
				$assign_user='assign_to_dse='.$assign;
				$assign_date='assign_to_dse_date';
				$assign_time='assign_to_dse_time';
				$user_followup_id='dse_followup_id = 0';
				$assign_by_cse='';
			}
			
			

			if($tprocess=='7'){
				$insertQuery = $this -> db -> query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` , `location` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $assign . '","' . $assign_by . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
			$transfer_id=$this->db->insert_id();
			//echo $this->db->last_query();
			

			$update1 = $this -> db -> query("update lead_master set transfer_id='$transfer_id',".$user_followup_id.",".$assign_user.",".$assign_by_cse.$assign_date."='$today1',".$assign_time."='$time' where enq_id='$enq_id'");
				//echo $this->db->last_query();	
			}
							
			elseif($tprocess == '6'){
				
			
			$checkUserProcess=$this->db->query("select process_id from tbl_manager_process where user_id='$assign_by' and process_id='6'")->result();
			
			if(count($checkUserProcess)>0)
			{
				$update1 = $this -> db -> query("update lead_master set process='New Car' where enq_id='$enq_id'");
				//echo $this->db->last_query();
			
			$insertQuery = $this -> db -> query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` , `location` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $assign . '","' . $assign_by  . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
			$transfer_id=$this->db->insert_id();
			//echo $this->db->last_query();
			

			$update1 = $this -> db -> query("update lead_master set transfer_id='$transfer_id',".$user_followup_id.",".$assign_user.",".$assign_by_cse.$assign_date."='$today1',".$assign_time."='$time' where enq_id='$enq_id'");
				//echo $this->db->last_query();
			}else{
			
			$update1 = $this -> db -> query("update lead_master set transfer_process='$process_name' where enq_id='$enq_id'");
			$insert_new_lead = $this -> db -> query("insert into lead_master(process,name,contact_no,email,lead_source,enquiry_for,created_date,app) values('$process_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today1','1')");
			$new_enq_id = $this->db->insert_id();
			$transfer_other_process=$this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead_all`,`from_process`, `to_process`, `created_date`) 
			VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");
			}
			
			}
			else{
				
			$update1 = $this -> db -> query("update lead_master set transfer_process='$process_name' where enq_id='$enq_id'");
			$insert_new_lead = $this -> db -> query("insert into lead_master_all(process,name,contact_no,email,lead_source,enquiry_for,created_date,app) values('$process_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today1','1')");
			$new_enq_id = $this->db->insert_id();
			$transfer_other_process=$this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead_all`,`from_process`, `to_process`, `created_date`) 
			VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");
				
		
			}

	
			
		}
		
	$evaluation_assign_to=$this->input->post('evaluation_assign_to');
		if($evaluation_assign_to !='')
		{
			$evaluation_location=$this->input->post('evaluation_location');
			$insertQuery = $this -> db -> query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` , `location` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $evaluation_assign_to . '","' . $assign_by . '","' . $evaluation_location . '","' . $today . '","' . $time . '","Transfered")');
			$transfer_id=$this->db->insert_id();
			$update1 = $this -> db -> query("update lead_master set transfer_id='$transfer_id',evaluation='Yes',assign_to_e_tl='$evaluation_assign_to',assign_to_e_tl_date='$today',assign_to_e_tl_time='$time' where enq_id='$enq_id'");
	}
if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Data successfully Inserted.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}
}





function insert_escalation_detail()
{
	$enq_id = $this -> input -> post('booking_id');	
	 //escalation
	$escalation_type = $this->input->post('escalation_type');
	$escalation_remark = $this->input->post('escalation_remark');
	if($escalation_type=='Escalation Level 1')
	{
		$esc_level="esc_level1='Yes'";
		$esc_remark="esc_level1_remark= '".$escalation_remark."'";
	}
	elseif($escalation_type=='Escalation Level 2')
	{
	$esc_level="esc_level2='Yes'";
		$esc_remark="esc_level2_remark= '".$escalation_remark."'";
	}
	elseif ($escalation_type=='Escalation Level 3') {
		$esc_level="esc_level3='Yes'";
		$esc_remark="esc_level3_remark= '".$escalation_remark."'";
	}
	else {
		$esc_level='';
		$esc_remark='';
	}
	$update1 = $this -> db -> query("update lead_master set ".$esc_level.",".$esc_remark." where enq_id='$enq_id'");
	if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Data successfully Inserted.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}		
}

//get send escalation mail detail

function get_escalation_detail($enq_id,$process_id) {
		
		$this->db->select('gm_email,sm_email,name,contact_no,l1.location,esc_level1_remark,esc_level2_remark,esc_level3_remark, f.comment as cse_remark,f1.comment as dse_remark,ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,ucsetl.email as csetl_email,ucse.fname as cse_fname,ucse.lname as cse_lname,udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,udsetl.email as dsetl_email,udse.fname as dse_fname,udse.lname as dse_lname');
		$this->db->from('lead_master l');
		$this->db->join('lead_followup f','f.id=l.cse_followup_id ','left');
		if($process_id==8)
		{
			$this->db->join('lead_followup f1','f1.id=l.exe_followup_id ','left');
			$this->db->join('lmsuser udsetl','udsetl.id=l.assign_to_e_tl','left');
			$this->db->join('tbl_manager_process p','p.user_id=l.assign_to_e_tl','left');
			$this->db->join('lmsuser udse','udse.id=l.assign_to_e_exe','left');
		}
		else
		{
			$this->db->join('lead_followup f1','f1.id=l.dse_followup_id ','left');
			$this->db->join('lmsuser udsetl','udsetl.id=l.assign_to_dse_tl','left');
			$this->db->join('tbl_manager_process p','p.user_id=l.assign_to_dse_tl','left');
			$this->db->join('lmsuser udse','udse.id=l.assign_to_dse','left');
		}
		
		$this->db->join('lmsuser ucse','ucse.id=l.assign_to_cse','left');
		$this->db->join('tbl_mapdse mp','mp.dse_id=l.assign_to_cse','left');
		$this->db->join('lmsuser ucsetl','ucsetl.id=mp.tl_id','left');
		
		$this->db->join('tbl_map_process p1','p1.location_id=p.location_id','left');
		$this->db->join('tbl_location l1','l1.location_id=p1.location_id','left');
		
		$this -> db -> where('p.process_id', $process_id);
		$this -> db -> where('p1.process_id', $process_id);
		$this->db->where('l.enq_id',$enq_id);
		
		$query = $this->db->get();
		
		return $query->result();
	
		
	}

///////////////////////////////////////////////////////////////////
/* Search By Name and contact Number */
public function search_by_name_contact($customer_name,$process_name,$process_id) {
	 $table=$this->select_table($process_id);		
/*$query = "SELECT 
		GROUP_CONCAT( DISTINCT  a.accessories_name ) as accessoires_list,
		sum(price) as assessories_price,
		m.model_name,
		l.service_center,l.service_type,l.pickup_required,l.pick_up_date, `l`.`assistance`,  `l`.`customer_location`,`l`.`days60_booking`,
		l.enq_id,l.lead_source,l.enquiry_for,l.process,l.name,l.contact_no,l.address,l.email,l.created_date as lead_date,l.feedbackStatus,l.nextAction,
		 l.ownership,l.budget_from,l.budget_to,l.accidental_claim,`l`.`assign_by_cse_tl`,`l`.`assign_to_cse`,
		l.reg_no, min(l.created_date) as min_date, max(l.created_date) as max_date ,l.km,`l`.`buyer_type`,  `l`.`manf_year`,
		`ucse`.`fname` as `cse_fname`, `ucse`.`lname` as `cse_lname`, `ucse`.`role` as `cse_role`,`ucsetl`.`fname` as `csetl_fname`, `ucsetl`.`lname` as `csetl_lname`, `ucsetl`.`role` as `csetl_role`,
		". $table['select_element'] .",
		`v`.`variant_name`,`m`.`model_name` as `new_model_name`,
		`csef`.`date` as `cse_date`, `csef`.`nextfollowupdate` as `cse_nfd`,`csef`.`nextfollowuptime` as `cse_nftime`, `csef`.`comment` as `cse_comment`, `csef`.`td_hv_date`, 
		`csef`.`feedbackStatus` as `csefeedback`, `csef`.`nextAction` as `csenextAction`,
		ua.fname as auditfname,ua.lname as auditlname,
		mr.followup_pending,mr.call_received,mr.fake_updation,mr.service_feedback,mr.remark as auditor_remark,mr.created_date as auditor_date
		FROM " .$table['lead_master_table']. "`l` */
		$query = "SELECT 
		GROUP_CONCAT( DISTINCT  a.accessories_name ) as accessoires_list,
		sum(price) as assessories_price,
		m.model_name,
		l.service_center,l.service_type,l.pickup_required,l.pick_up_date, `l`.`assistance`,  `l`.`customer_location`,`l`.`days60_booking`,
		l.enq_id,l.lead_source,l.enquiry_for,l.process,l.name,l.contact_no,l.alternate_contact_no,l.address,l.email,l.created_date as lead_date,l.created_time as lead_time,l.feedbackStatus,l.nextAction,
		 l.ownership,l.budget_from,l.budget_to,l.accidental_claim,`l`.`assign_by_cse_tl`,`l`.`assign_to_cse`,
		l.reg_no, min(l.created_date) as min_date, max(l.created_date) as max_date ,l.km,`l`.`buyer_type`,  `l`.`manf_year`,l.assign_to_cse_date,l.assign_to_cse_time,l.assign_to_dse_date,l.assign_to_dse_time,l.assign_to_dse_tl_date,l.assign_to_dse_tl_time,
		l.appointment_type,l.appointment_date,l.appointment_time,l.appointment_address,l.appointment_status,l.appointment_rating,l.appointment_feedback,
		l.interested_in_finance,l.interested_in_accessories,l.interested_in_insurance,l.interested_in_ew,
		`ucse`.`fname` as `cse_fname`, `ucse`.`lname` as `cse_lname`, `ucse`.`role` as `cse_role`,`ucsetl`.`fname` as `csetl_fname`, `ucsetl`.`lname` as `csetl_lname`, `ucsetl`.`role` as `csetl_role`,
		". $table['select_element'] .",
		`v`.`variant_name`,`m`.`model_name` as `new_model_name`,
		`csef`.`date` as `cse_date`, `csef`.`nextfollowupdate` as `cse_nfd`,`csef`.`nextfollowuptime` as `cse_nftime`, `csef`.`comment` as `cse_comment`, `csef`.`td_hv_date`, 
		`csef`.`feedbackStatus` as `csefeedback`, `csef`.`nextAction` as `csenextAction`,`csef`.`contactibility` as `csecontactibility`,`csef`.`created_time` as `cse_time`,
		ua.fname as auditfname,ua.lname as auditlname,
		mr.followup_pending,mr.call_received,mr.fake_updation,mr.service_feedback,mr.remark as auditor_remark,mr.created_date as auditor_date,mr.created_time as auditor_time,mr.call_status as auditor_call_status
		FROM " .$table['lead_master_table']. "`l` 
		LEFT JOIN " .$table['lead_followup_table']. " `csef` ON `csef`.`id`=`l`.`cse_followup_id` 
		LEFT JOIN " .$table['lead_followup_table']. "  `dsef` ON `dsef`.`id`=`l`.`dse_followup_id` 
		LEFT JOIN `tbl_manager_remark` `mr` ON `mr`.`remark_id`=`l`.`remark_id`
		LEFT JOIN `lmsuser` `ucse` ON `ucse`.`id`=`l`.`assign_to_cse` 
		LEFT JOIN `lmsuser` `ucsetl` ON `ucsetl`.`id`=`l`.`assign_by_cse_tl`
		LEFT JOIN `lmsuser` `ua` ON `ua`.`id`=`l`.`auditor_user_id`  
		LEFT JOIN `make_models` `m` ON `m`.`model_id`=`l`.`model_id` 
		LEFT JOIN `model_variant` `v` ON `v`.`variant_id`=`l`.`variant_id` 
		LEFT JOIN `lmsuser` `udse` ON `udse`.`id`=`l`.`assign_to_dse` 
		LEFT JOIN `lmsuser` `udsetl` ON `udsetl`.`id`=`l`.`assign_to_dse_tl` 
		LEFT JOIN `tbl_location` `tloc` ON `tloc`.`location_id`= `udsetl`.`location`
		LEFT JOIN `make_models` `m1` ON `m1`.`model_id`=`l`.`old_model` 
		LEFT JOIN `makes` `m2` ON `m2`.`make_id`=`l`.`old_make`
		LEFT JOIN `accessories_order_list` `a` ON `a`.`enq_id`=`l`.`enq_id`";
		$query = $query . ' where l.process="' . $process_name . '"';
		
		if (is_numeric($customer_name)) {
				
			$query = $query . ' And contact_no like "' . '%'.$customer_name .'%'. '"';			
		} else {
			$query = $query . ' And name like "' . '%'.$customer_name .'%'. '"';

		}
		$query = $query . " group by l.enq_id";
		$query = $query . " order by l.enq_id desc";
		$query = $query . " limit 50";

		$query = $this -> db -> query($query);
		//echo $this->db->last_query();
		$query = $query -> result();
		return $query;
		

	}
	public function searchCustomer_flow($enq_id,$process_id)
{
	 $table=$this->select_table($process_id);	
		$this -> db -> select('u.fname,u.lname,u1.fname as u1name,u1.lname as u1lname,r.created_date');
		$this -> db -> from($table['request_to_lead_transfer_table'].' r');
		$this -> db -> join('lmsuser u', 'u.id=r.assign_to');
		$this -> db -> join('lmsuser u1', 'u1.id=r.assign_by');
		if ('lead_id' != '') {
			$this -> db -> where('lead_id', $enq_id);
		}
		$query = $this -> db -> get();
		//$this->db->last_query();
		return $query -> result();
}
	// fetch customer details for edit
	public function edit_customer($id,$process_id) {
		 $table=$this->select_table($process_id);		
		$this -> db -> select('*');
		$this -> db -> from($table['lead_master_table']);		
		$this -> db -> where('enq_id', $id);
		$query = $this -> db -> get();
		// $this->db->last_query();
		return $query -> result();

	}
	// update customer details 
	function update_customer($id,$process_id,$user_id,$name,$contact,$email,$address) 
	{
		 $table=$this->select_table($process_id);	
		$today=date('Y-m-d');
		$query=$this -> db -> query('update '.$table['lead_master_table'].'  set name="' . $name . '",contact_no="' . $contact . '",email="' . $email . '",address="' . $address . '" ,last_edited_by="' . $user_id . '" ,last_edited_date="' . $today . '"  where enq_id="' . $id . '"');
		if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Data successfully Updated.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}
	}
	////////////////////////////////////////////////////////////////////
	/* customer details */
	 public function customer_details($id,$process_id) {
	 	$table=$this->select_table($process_id);	
		//Get user all details
		if($process_id=='6' || $process_id=='7'){
			$this -> db -> select('l.enq_id,l.name,l.email,l.contact_no,l.alternate_contact_no,l.address,,l.feedbackStatus,l.nextAction,l.eagerness,
		l.service_type,l.service_center,l.km,l.pick_up_date,l.pickup_required,l.buyer_type,l.color,l.manf_year,l.ownership,l.accidental_claim,
		l.budget_from,l.budget_to,l.assign_by_cse_tl,l.assign_to_cse,assign_to_dse_tl , l.assign_to_dse, 
		l.appointment_type,l.appointment_date,l.appointment_time,l.appointment_address,l.appointment_status,l.appointment_rating,l.appointment_feedback,
		l.interested_in_finance,l.interested_in_accessories,l.interested_in_insurance,l.interested_in_ew,l.customer_occupation,l.customer_corporate_name,l.customer_designation,l.days60_booking,
		ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
		m1.model_name as old_model,
		m2.make_name as old_make,
		bm1.make_name as buy_make,
		bm2.model_name as buy_model,
		m.model_name,
		v.variant_name,
		csef.date as cse_call_date,csef.created_time as cse_call_time,csef.contactibility as cse_contactibility,csef.comment as cse_remark,csef.nextfollowupdate as cse_nfd , csef.nextfollowuptime as cse_nft,
		
		dsef.date as dse_call_date,dsef.created_time as dse_call_time,dsef.contactibility as dse_contactibility,dsef.comment as dse_remark,dsef.nextfollowupdate as dse_nfd , dsef.nextfollowuptime as dse_nft');
		}elseif($process_id ==8){
				$this -> db -> select('l.enq_id,l.name,l.email,l.contact_no,l.alternate_contact_no,l.address,,l.feedbackStatus,l.nextAction,l.eagerness,
		l.buyer_type,l.budget_from,l.budget_to,l.assign_by_cse_tl,l.assign_to_cse,l.assign_to_e_tl as assign_to_dse_tl , l.assign_to_e_exe as assign_to_dse, 
		l.appointment_type,l.appointment_date,l.appointment_time,l.appointment_address,l.appointment_status,l.appointment_rating,l.appointment_feedback,
		l.interested_in_finance,l.interested_in_accessories,l.interested_in_insurance,l.interested_in_ew,l.customer_occupation,l.customer_corporate_name,l.customer_designation,l.days60_booking,l.reg_no,l.quotated_price,l.expected_price,
		ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
		m1.model_name as old_model,
		m2.make_name as old_make,
		bm1.make_name as buy_make,
		bm2.model_name as buy_model,
		m.model_name,
		v.variant_name,
		csef.date as cse_call_date,csef.created_time as cse_call_time,csef.contactibility as cse_contactibility,csef.comment as cse_remark,csef.nextfollowupdate as cse_nfd , csef.nextfollowuptime as cse_nft,
		
		dsef.date as dse_call_date,dsef.created_time as dse_call_time,dsef.contactibility as dse_contactibility,dsef.comment as dse_remark,dsef.nextfollowupdate as dse_nfd , dsef.nextfollowuptime as dse_nft');
	
		}else{
		$this -> db -> select('l.enq_id,l.name,l.email,l.contact_no,l.alternate_contact_no,l.address,,l.feedbackStatus,l.nextAction,l.eagerness,
		l.service_type,l.service_center,l.km,l.pick_up_date,l.pickup_required,l.buyer_type,
		l.bank_name,l.loan_type,l.reg_no,l.roi,l.los_no,l.tenure,l.loanamount,l.dealer,l.assign_by_cse_tl,l.assign_to_cse,assign_to_dse_tl , l.assign_to_dse, 
		
		ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
		csef.date as cse_call_date,csef.comment as cse_remark,csef.nextfollowupdate as cse_nfd , csef.nextfollowuptime as cse_nft,m.model_name');
		}
		$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join($table['lead_followup_table'].' csef', 'csef.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		if($process_id == 8){
			$this -> db -> join($table['lead_followup_table'].' dsef', 'dsef.id=l.exe_followup_id', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl ', 'left');
			
		}else{
			$this -> db -> join($table['lead_followup_table'].' dsef', 'dsef.id=l.dse_followup_id', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		}
		
		$this -> db -> join('make_models m', 'm.model_id=l.model_id', 'left');
		$this -> db -> join('make_models m1', 'm1.model_id=l.old_model', 'left');
		$this -> db -> join('model_variant v', 'v.variant_id=l.variant_id', 'left');
		$this -> db -> join('makes m2', 'm2.make_id=l.old_make', 'left');
		$this -> db -> join('makes bm1', 'bm1.make_id=l.buy_make', 'left');
		$this -> db -> join('make_models bm2', 'bm2.model_id=l.buy_model', 'left');
		//$this -> db -> join('tbl_status s', 's.status_id=l.status', 'left');
		$this -> db -> where('l.enq_id', $id);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
	 /////////////////////////////////////////////////////////////////
	 /* Followup Details */
	 public function followup_details($id,$process_id) {
	 		$table=$this->select_table($process_id);	
		//Get user All Followup Details
		if($process_id=='6' || $process_id=='7' || $process_id=8){
				$this -> db -> select('u.fname,u.lname,
		f.feedbackStatus,f.nextAction,f.contactibility,f.created_time as call_time,f.nextfollowuptime,f.assign_to,f.date as call_date,f.comment,f.nextfollowupdate,f.pick_up_date,f.visit_status,f.visit_location,f.visit_booked,f.visit_booked_date,f.sale_status,f.car_delivered,f.escalation_type,f.escalation_remark,');
		
			}else{
		$this -> db -> select('u.fname,u.lname,
		f.feedbackStatus,f.nextAction,f.contactibility,f.assign_to,f.date as call_date,f.comment,f.nextfollowupdate,f.pick_up_date,f.executive_name,f.login_status_name,f.disburse_amount,f.disburse_date,f.process_fee,f.emi,f.approved_date,f.file_login_date');
			}
		$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join('make_models m', 'm.model_id=l.model_id', 'left');
		$this -> db -> join($table['lead_followup_table'].' f', 'f.leadid=l.enq_id', 'left');
		$this -> db -> join('lmsuser u', 'u.id=f.assign_to', 'left');
		$this -> db -> where('f.leadid', $id);
		$this -> db -> order_by('f.id', 'desc');
		$query = $this -> db -> get();
		return $query -> result();

	}
	  /////////////////////////////////////////////////////////////////
	 /* Accessories list */
	 public function select_accessories_list($enq_id)
	{
		$this -> db -> select('*');
		$this -> db -> from('accessories_order_list a ');
		$this->db->join('make_models m','m.model_id=a.model');
		$this -> db -> where('enq_id', $enq_id);
		$this->db->where('a.status!=','-1');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}

function poc_stock_color(){
		$table_name='tbl_stock_in_hand_poc';
		$max_date=$this->max_date($table_name);
		$this -> db -> select('DISTINCT(color)');
		$this -> db -> from('tbl_stock_in_hand_poc');
		$this -> db -> where('created_date', $max_date);
		$query= $this -> db -> get() -> result();
		return $query;
	}
function poc_stock_fuel_type(){
		$table_name='tbl_stock_in_hand_poc';
		$max_date=$this->max_date($table_name);
		$this -> db -> select('DISTINCT(fuel_type)');
		$this -> db -> from('tbl_stock_in_hand_poc');
		$this -> db -> where('created_date', $max_date);
		$this -> db -> where('fuel_type!=', '');
		$query= $this -> db -> get() -> result();
		return $query;
	}
	function max_date($table_name){
		$this -> db -> select_max('upload_id');
		$this -> db -> from($table_name);
		$max_date1 = $this -> db -> get() -> result();
		foreach ($max_date1 as $row) {
			$max_date = $row -> upload_id;
		}
		return $max_date;
}
function poc_stock_make(){
		$table_name='tbl_stock_in_hand_poc';
		$max_date=$this->max_date($table_name);
		$this -> db -> select('DISTINCT(make_name),make_id');
		$this -> db -> from('tbl_stock_in_hand_poc p');
		$this->db->join('makes m','m.make_id=p.make');
		$this -> db -> where('upload_id', $max_date);
		
		$query= $this -> db -> get();
		//echo $this->db->last_query();
		$query=$query-> result();
		return $query;
	}
function poc_stock_model($make_id){
		$table_name='tbl_stock_in_hand_poc';
		$max_date=$this->max_date($table_name);
		$this -> db -> select('DISTINCT(submodel) as model');
		$this -> db -> from('tbl_stock_in_hand_poc');
		$this -> db -> where('upload_id', $max_date);
			$this -> db -> where('make', $make_id);
		
		$query= $this -> db -> get() -> result();
		return $query;
	}
	function poc_stock_location(){
		$table_name='tbl_stock_in_hand_poc';
		$max_date=$this->max_date($table_name);
		$this -> db -> select('DISTINCT(stock_location)');
		$this -> db -> from('tbl_stock_in_hand_poc');
		$this -> db -> where('upload_id', $max_date);
		
		$query= $this -> db -> get() -> result();
		return $query;
	}
	function new_stock_model(){
		$table_name='tbl_stock_in_hand_new';
		$max_date=$this->max_date($table_name);
		$this -> db -> select('DISTINCT(submodel) as model');
		$this -> db -> from('tbl_stock_in_hand_new');
		$this -> db -> where('upload_id', $max_date);
		//	$this -> db -> where('make', 1);
		
		$query= $this -> db -> get() -> result();
		return $query;
	}
	function new_stock_location(){
		$table_name='tbl_stock_in_hand_new';
		$max_date=$this->max_date($table_name);
		$this -> db -> select('DISTINCT(assigned_location)');
		$this -> db -> from('tbl_stock_in_hand_new');
		$this -> db -> where('upload_id', $max_date);
		
		$query= $this -> db -> get() -> result();
		return $query;
	}
	
function poc_stock($make_id,$model,$fuel_type,$stock_location,$ageing,$color,$mfg_yr) {

		$this -> db -> select_max('created_date');
		$this -> db -> from('tbl_stock_in_hand_poc');
		$max_date1 = $this -> db -> get() -> result();
		foreach ($max_date1 as $row) {
			$max_date = $row -> created_date;

		}
		$this -> db -> select('mk.make_name,st.submodel,st.color,st.fuel_type,st.owner,st.mfg_year,st.odo_meter,st.mileage,st.insurance_type,st.insurance_expiry_date,st.category,st.vehicle_status,st.stock_location,st.expt_selling_price,st.stock_ageing,st.total_landing_cost,st.created_date');
		$this -> db -> from('tbl_stock_in_hand_poc st');
		$this -> db -> join('makes mk', 'mk.make_id=st.make');
		
		$this -> db -> where('created_date', $max_date);
		
		if($make_id!=''){
			$this -> db -> where('make', $make_id);
		}

		if($model!=''){
			$this -> db -> where('st.submodel', $model);
		}
		if($fuel_type!=''){
			$this -> db -> where('st.fuel_type', $fuel_type);
		}
		if($stock_location!=''){
			$this -> db -> where('st.stock_location', $stock_location);
		}
		if($ageing!=''){
			$this -> db -> where('st.stock_ageing', $ageing);
		}
		if($color!=''){
			$this -> db -> where('st.color', $color);
		}

		if($mfg_yr!=''){
			$this -> db -> where('st.mfg_year', $mfg_yr);
		}

		$query = $this -> db -> get();
		return $query -> result();
	}

	function new_stock_fuel_type(){
		$table_name='tbl_stock_in_hand_new';
		$max_date=$this->max_date($table_name);
		$this -> db -> select('DISTINCT(fuel_type)');
		$this -> db -> from('tbl_stock_in_hand_new');
		$this -> db -> where('created_date', $max_date);
		$this -> db -> where('fuel_type!=', '');
		$query= $this -> db -> get() -> result();
		return $query;
	}
	function new_stock_color(){
		$table_name='tbl_stock_in_hand_new';
		$max_date=$this->max_date($table_name);
		$this -> db -> select('DISTINCT(color)');
		$this -> db -> from('tbl_stock_in_hand_new');
		$this -> db -> where('created_date', $max_date);
		$query= $this -> db -> get() -> result();
		return $query;
	}
	function new_car_stock($model_id,$fuel_type,$location,$color,$ageing) {

		$this -> db -> select_max('created_date');
		$this -> db -> from('tbl_stock_in_hand_new');
		$max_date1 = $this -> db -> get() -> result();
		foreach ($max_date1 as $row) {
			$max_date = $row -> created_date;
		}
		$this -> db -> select('st.submodel,st.color,st.fuel_type,st.vehicle_status,st.assigned_location,st.ageing,st.created_date,st.created_date,m.model_name');
		$this -> db -> from('tbl_stock_in_hand_new st');
		$this -> db -> join('make_models m', 'm.model_id=st.model');
	
		$this -> db -> where('created_date', $max_date);
	
		if($model_id!=''){
		$this -> db -> where('model', $model_id);
		}
		if($fuel_type!=''){
		$this -> db -> where('st.fuel_type', $fuel_type);
		}
		if($location!=''){
			$this -> db -> where('st.assigned_location', $location);
		}
		if($color!=''){
			$this -> db -> where('st.color', $color);
		}
		if($ageing!=''){
			$this -> db -> where('st.ageing', $ageing);
		}
		$query = $this -> db -> get();
		return $query -> result();
	}

	function quotation_location() {
		
		$this->db->distinct();
		$this->db->select('location');
		$this->db->from('tbl_quotation');
		$query = $this->db->get();
		return $query->result();
	}
	function quotation_model_name($quotation_location) {
			$this->db->select_max('upload_id');
		$this->db->from('tbl_quotation');
		$query = $this -> db -> get()->result();
			
	//	$query=$this->db->query("select * from tbl_quotation_name where location='$quotation_location' and status='Active'")->result();
		if(count($query)==1){
			$this->db->distinct();
		$this->db->select('model_id,model');
		$this->db->from('tbl_quotation');
		$this -> db -> where('upload_id', $query[0]->upload_id);
		$this -> db -> where('location', $quotation_location);
		$query1 = $this->db->get()->result();
		}
		else{
			$query1=array();
		}
	   	return $query1;
		
	}
	function quotation_description($quotation_location,$quotation_model_name) {
		$this->db->select_max('upload_id');
		$this->db->from('tbl_quotation');
		$query = $this -> db -> get()->result();
			//$query=$this->db->query("select * from tbl_quotation_name where location='$quotation_location' and status='Active'")->result();
		if(count($query)==1){
		
		$this->db->select('variant');
		$this->db->from('tbl_quotation');
		$this -> db -> where('upload_id', $query[0]->upload_id);
		$this -> db -> where('location', $quotation_location);
		$this->db->where('model_id',$quotation_model_name);
		$select_variant = $this->db->get()->result();
		}else{
			$select_variant=array();
		}
			
	   return $select_variant;
		
	}
	function accessories_package($quotation_model_name) {
			$query=$this->db->query("select max(upload_id) as upload_id from tbl_accessories_package_lms where model_id='$quotation_model_name'")->result();
	
		if(isset($query[0]->upload_id)){
		$this->db->select('package_name');
		$this->db->from('tbl_accessories_package_lms');
		$this -> db -> where('upload_id', $query[0]->upload_id);
		
		$this->db->where('model_id',$quotation_model_name);
		$select_variant = $this->db->get();
		//echo $this->db->last_query();
		$select_variant=$select_variant->result();
		}else{
			$select_variant=array();
		}
			
	   return $select_variant;
		
	}
function all_process() {
			
		$this->db->select('*');
		$this->db->from('tbl_process');
		$query=$this->db->get();	
		return $query->result();

	}
function evaluation_process_removed() {
			
		$this->db->select('*');
		$this->db->from('tbl_process');
		$this->db->where('process_id !=','8');
		$query=$this->db->get();	
		return $query->result();

	}
	function select_transfer_location($transfer_process) 
	{
		$this -> db -> select('l.*');
		$this -> db -> from('tbl_location l');
		$this->db->join('tbl_map_process p','p.location_id=l.location_id');
		$this->db->where('p.status !=','-1');
		$this->db->where('l.location_status !=','Deactive');
		$this->db->where('process_id',$transfer_process);
		$query = $this->db->get();
		return $query->result();
		
	}
	function select_transfer_to_user($transfer_process,$transfer_location,$role,$user_id,$session_process)
	{
		$tprocess=$transfer_process;
		$toLocation = $transfer_location;
		 $from_user_role = $role;
		$fromUser=$user_id;
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser l');
		$this -> db -> join('tbl_manager_process u', 'u.user_id=l.id');
		$this -> db -> join('tbl_rights r', 'r.user_id=l.id');
		$this -> db -> join('tbl_location l1', 'l1.location_id=u.location_id', 'left');
		$this -> db -> where('r.form_name', 'Calling Notification');
		$this -> db -> where('r.view', '1');
		/*if($from_user_role==3)*/
		$tl_array = array("2", "5", "7", "9", "11", "13","15");
		$tl_list = '("2","5", "7", "9", "11", "13","15")';
		$executive_array = array("4", "8", "10", "12", "14", "16");
		if($tprocess==$session_process)
		{
		if ($from_user_role == 1 || $from_user_role == 2 || $from_user_role == 3) {
				
			$tl_array1 = array("2", "3", "5", "7", "9", "11", "13","15");
			$this -> db -> where_in('role', $tl_array1);
			//$k="(role=3 or role IN ('2','5', '7', '9', '11', '13'))";
			//$this -> db -> where($k);
		} elseif (in_array($from_user_role, $tl_array)) {
			$q = $this -> db -> query('select dse_id from tbl_mapdse where tl_id="' . $fromUser . '"') -> result();

			$c = count($q);
			$t = ' ( ';
			if (count($q) > 0) {

				for ($i = 0; $i < $c; $i++) {

					$t = $t . "id = " . $q[$i] -> dse_id . " or ";

				}

			}
			$t = $t . "role in" . $tl_list;
			$st = $t . ')';

			$this -> db -> where($st);
		} elseif (in_array($from_user_role, $executive_array)) {
			$q1 = $this -> db -> query('select tl_id from tbl_mapdse where dse_id="' . $fromUser . '"') -> result();
			
			if (count($q1) > 0) {
				
				$q = $this -> db -> query('select dse_id from tbl_mapdse where tl_id="' . $q1[0] -> tl_id . '"') -> result();
				$c = count($q);
				$t = ' ( ';
				if (count($q) > 0) {

					for ($i = 0; $i < $c; $i++) {

						$t = $t . "id = " . $q[$i] -> dse_id . " or ";

					}

				
				}
				$t = $t . "role in" . $tl_list;
				$st = $t . ')';

				$this -> db -> where($st);

			} else {
				$t = $t . "role in" . $tl_list;
			}
		}
		}
else {
	if ($from_user_role == 1 || $from_user_role == 2 || $from_user_role == 3) {
				
			$tl_array = array("2", "5", "7", "9", "11", "13","15");
			$this -> db -> where_in('role', $tl_array);
			//$k="(role=3 or role IN ('2','5', '7', '9', '11', '13'))";
			//$this -> db -> where($k);
		} elseif (in_array($from_user_role, $tl_array)) {
			
			$t = ' ( ';
			
			$t = $t . "role in" . $tl_list;
			$st = $t . ')';

			$this -> db -> where($st);
		} elseif (in_array($from_user_role, $executive_array)) {
			$q1 = $this -> db -> query('select tl_id from tbl_mapdse where dse_id="' . $fromUser . '"') -> result();
			
			if (count($q1) > 0) {
				$t = ' ( ';
				
				$t = $t . "role in" . $tl_list;
				$st = $t . ')';

				$this -> db -> where($st);

			} else {
				$t = $t . "role in" . $tl_list;
				$this -> db -> where($t);
			}
		}
}
		//$this -> db -> where_in('role',$this->tl_array);
		$this -> db -> where('l.status', '1');
		$this -> db -> where('role !=', '1');
		$this->db->where('l.id !=',$user_id);
		$this -> db -> where('u.process_id', $tprocess);
		$this -> db -> where('l1.location_id', $toLocation);
		$this -> db -> group_by("l.id");
		$this -> db -> order_by("fname", "asc");
		$query = $this -> db -> get();
		//echo $this -> db -> last_query();
		return $query -> result();
		
	}
public function insert_dse_daily_report($user_date,$time,$location_id,$user_id,$enquiry_count,$enquiry_remark,$walk_in_count,$walk_in_remark,$home_visit_count,$home_visit_remark,$test_drive_count,$test_drive_remark,$booking_count,$booking_remark,$gatepass_count,$gatepass_remark,$evaluation_count,$evaluation_remark,$delivery_count)

		{
		$update=$this->db->query("update tbl_dse_daily_traking set status=0  where user_id='$user_id' and report_date='$user_date'");
		
			
		$query=$this->db->query("INSERT INTO `tbl_dse_daily_traking`(`walk_in_count`, `walk_in_remark`, `home_visit_count`, `home_visit_remark`, `booking_count`, `booking_remark`, `test_drive_count`, `test_drive_remark`, `delivery_count`, `enquiry_count`, `enquiry_remark`,`gatepass_count`,`gatepass_remark`,`evaluation_count`,`evaluation_remark`,`user_id`,`location_id`,`report_date`,`report_time`,`status`) 
		VALUES ('$walk_in_count','$walk_in_remark','$home_visit_count','$home_visit_remark','$booking_count','$booking_remark','$test_drive_count','$test_drive_remark','$delivery_count','$enquiry_count','$enquiry_remark','$gatepass_count','$gatepass_remark','$evaluation_count','$evaluation_remark','$user_id','$location_id','$user_date','$time','1')");
		
		if ($this -> db -> affected_rows() > 0) {
  			$response["success"] = 1;
			$response["message"] = "Data successfully Inserted.";
			// echoing JSON response
			echo json_encode($response);
			} else {
			// failed to insert row
			$response["success"] = 0;
			$response["message"] = "Oops! An error occurred.";
			// echoing JSON response
			echo json_encode($response);

			}
		}
		public function daily_tracker_show_data($location_id,$from_date,$status)
		{
			$today=date('Y-m-d');
			$location_id=$this->input->post('location_id');
			$from_date=$this->input->post('fromdate');
			$status=$this->input->post('status');
			
			$this->db->select('d.*,u.fname,u.lname');
			$this->db->from('tbl_dse_daily_traking d');
			$this->db->join('lmsuser u','u.id=d.user_id');
			
			if($location_id!=''){
				$this->db->where('location_id',$location_id);
			}if($this->input->post('role')==4 || $this->input->post('role')==5){
				$this->db->where('location_id',$this->input->post('location'));
			}
			if($from_date!=''){
				$this->db->where('report_date',$from_date);
			}else{
					$this->db->where('d.report_date',$today);
			}
			if($status!='All'){
				$this->db->where('d.status',1);
			}
			if($this->input->post('role')==3 || $this->input->post('role')==4){
				$this->db->where('d.user_id',$this->input->post('user_id'));
			}
	
			$query=$this->db->get();
			//echo $this->db->last_query();
			return $query->result();
			
		}
public function daliy_dse_tracker_location($role,$location)
{
	$this->db->select('*');
			$this->db->from('tbl_location');
			if($role==3 || $role==5|| $role==4){
				$this->db->where('location_id',$location);
			}
			$query=$this->db->get();
			return $query->result();
}
public function daily_dse_tracker_check_time($user_id)
{
		$today=date('Y-m-d');
		$query=$this->db->query("select report_time,user_id from tbl_dse_daily_traking where report_date='$today' and user_id='$user_id' and status=1");
		return $query->result();
}
	public function message_list($user_id) {
		$this -> db -> select('h.message_id,message,u.fname,u.lname');
		$this -> db -> from('tbl_home_message h');
		$this -> db -> join('lmsuser u', 'u.id=h.user_id');
		$this -> db -> where('h.user_id', $user_id);
		
		$this->db->where ('message_status !=','-1');
		
		$query = $this -> db -> get()->result();
		if(count($query)>0)
		{
			foreach($query as $row){
				$this->db->select('l.location,m.tl,m.dse');
				$this->db->from('tbl_home_message_location m');
				$this -> db -> join('tbl_location l','l.location_id=m.location_id');
				$this->db->where('message_id',$row->message_id);
				$query_location=$this -> db -> get()->result();
				$select_data[]=array('message_id'=>$row->message_id,'message'=>$row->message,'location'=>$query_location);
			}
		}
		else
			{
			$select_data=array();	
			}
		return $select_data;
	}
	
	public function message_home($location) {
			
	$this->db->select('m.*,l.*,u.fname,u.lname');
	$this->db->from('tbl_home_message m');
	$this->db->join('tbl_home_message_location l','l.message_id=m.message_id');
	$this->db->join('lmsuser u','u.id=m.user_id','left');
	$this->db->where('l.location_id',$location);
			$this->db->where ('message_status !=','-1');
			$this->db->order_by('m.message_id','desc');
		//$this -> db -> where('h.user_id', $user_id);
		$query = $this -> db -> get();
		return $query -> result();

	}

	function message_insert($message,$user_id,$location,$tl,$dse) {
		
		$q=$this->db->query("select * from tbl_home_message where user_id='$user_id' and message='$message'")->result();
		//echo $this->db->last_query();
		 count($q);
		if(count($q) > 0)
		{
			$response["success"] = 1;
				$response["message"] = "Already Inserted.";
				// echoing JSON response
				echo json_encode($response);
		}
		else
		{
			$today = date("Y-m-d");

		//add remark

		$query = $this -> db -> query("INSERT INTO `tbl_home_message`(`message`, `user_id`, `created_date`) VALUES ('$message','$user_id','$today')");
		 $message_id = $this -> db -> insert_id();
		 $c=count($location);
		if($c>0)
		{
			for($i=0;$i<$c;$i++)
			{
				if($tl[$i] ==0 &&  $dse[$i] ==0)
				{
					
				}
				else {
					$query = $this -> db -> query("INSERT INTO `tbl_home_message_location`(`message_id`, `location_id`, `tl`, `dse`) VALUES ('$message_id','$location[$i]','$tl[$i]','$dse[$i]')");
		
				}
			}				
		}		
		if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Data successfully Inserted.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";
				// echoing JSON response
				echo json_encode($response);
			}
		}
		

	}
function message_delete($message_id) {
		 $c=count($message_id);	
		for($i=0;$i<$c;$i++)
			{
			$query = $this -> db -> query("update `tbl_home_message` set message_status='-1' where message_id='$message_id[$i]'");
			}		
		if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Successfully Deleted.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";
				// echoing JSON response
				echo json_encode($response);
			}
		
		

	}
	function process_all_location($process_id) {
		$this -> db -> select('l.*');
		$this -> db -> from('tbl_location l');
		$this->db->join('tbl_map_process p','p.location_id=l.location_id');
		$this->db->where('p.status !=','-1');
		$this->db->where('l.location_status !=','Deactive');
		$this->db->where('process_id',$process_id);
		$query = $this -> db -> get();
		return $query -> result();

	}
	function assign_new_leads_all_count($process_id,$process_name) {
		 $table=$this->select_table($process_id);		
		$this -> db -> select('count(enq_id)as acount');
		$this -> db -> from($table['lead_master_table']);
		$this -> db -> where('assign_by_cse_tl', '0');
		$this -> db -> where('process', $process_name);
		$query = $this -> db -> get();
		return $query -> result();
	}
	function assign_new_leads_source($process_id,$process_name)
	{
		$table=$this->select_table($process_id);	
		$this -> db -> select('lead_source,enquiry_for,count(lead_source) as wcount ');
		$this -> db -> from($table['lead_master_table']);
		$this -> db -> where('assign_by_cse_tl', '0');
		$this -> db -> where('process', $process_name);
		$this -> db -> group_by('lead_source');
		$query = $this -> db -> get();
		return $query -> result();
	}
function assign_new_lead_assign_user($location,$process_id,$role,$user_id) 
{
	$all_array = array("2","3","5", "7", "9", "11", "13");
	$tl_array = array("2","5", "7", "9", "11", "13");
		$tl_list='("2","5", "7", "9", "11", "13")';
		$executive_array = array("4", "8", "10", "12", "14");
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser l');
		//$this -> db -> join('tbl_user_group u', 'u.user_id=l.id');
		$this -> db -> join('tbl_manager_process u', 'u.user_id=l.id');
		$this -> db -> join('tbl_rights r', 'r.user_id=l.id');
		$this -> db -> where('r.form_name', 'Calling Notification');
		$this -> db -> where('r.view', '1');
		$this -> db -> where('l.status', '1');
		$this -> db -> where('u.process_id', $process_id);

		if ($role == 1 || $role == 2 || $role== 3) {
		//	echo "hi";
			//$a = "(role=2 or role=3 or role=5)";
			$this -> db -> where_in('role', $all_array);
			
		} elseif (in_array($role, $tl_array)) {
			$q = $this -> db -> query('select dse_id from tbl_mapdse where tl_id="' . $user_id . '"') -> result();
			
			$c = count($q);
			$t = ' ( ';
			if (count($q) > 0) {

				for ($i = 0; $i < $c; $i++) {

					$t = $t . "id = " . $q[$i] -> dse_id . " or ";

				}

			}
			$t = $t . "role in".$tl_list;
			$st = $t . ')';
			
			$this -> db -> where($st);
		} elseif (in_array($role, $executive_array)) {
			$q1 = $this -> db -> query('select tl_id from tbl_mapdse where dse_id="' . $user_id . '"') -> result();
			if (count($q1) > 0) {
				$q = $this -> db -> query('select dse_id from tbl_mapdse where tl_id="' . $q1[0] -> tl_id . '"') -> result();
				$c = count($q);
				$t = ' ( ';
				if (count($q) > 0) {

					for ($i = 0; $i < $c; $i++) {

						$t = $t . "id = " . $q[$i] -> dse_id . " or ";

					}

				}
				$t = $t . "role in".$tl_list;
				$st = $t . ')';

				$this -> db -> where($st);

			} else {
				$t = $t . "role in".$tl_list;
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
	function assign_new_lead_update() {
		$process_name = $this -> input -> post('process_name');
		$process_id= $this -> input -> post('process_id');
	 $table=$this->select_table($process_id);		
		
		$assign_by = $this -> input -> post('user_id');
		$assign_date = date('Y-m-d');
			$cse_name = json_decode($_POST['cse_name']);
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

					$query = $this -> db -> query("select enq_id from ".$table['lead_master_table']." where lead_source='$web_lead_name' and assign_by_cse_tl='0' and process='" . $process_name . "' limit $assign_count_reminder ") -> result();
					//echo $this->db->last_query();

				} else {
					echo "Facebook";
					$query = $this -> db -> query("select enq_id from ".$table['lead_master_table']." where enquiry_for='$facebook_lead_name' and lead_source='Facebook' and process='" . $process_name. "' and assign_by_cse_tl='0' limit $assign_count_reminder ") -> result();
					//	echo $this->db->last_query();

				}
			} else {
				if ($web_lead_count != '') {

					$query = $this -> db -> query("select enq_id from ".$table['lead_master_table']." where lead_source='$web_lead_name' and assign_by_cse_tl='0' and process='" . $process_name . "' limit $assign_count1 ") -> result();
					//	echo $this->db->last_query();

				} else {
					//echo"Facebook";
					$query = $this -> db -> query("select enq_id from ".$table['lead_master_table']." where enquiry_for='$facebook_lead_name' and lead_source='Facebook' and process='" . $process_name . "' and assign_by_cse_tl='0' limit  $assign_count1") -> result();
					//echo $this->db->last_query();

				}
			}
			//echo $cse_name[$i];
			foreach ($query as $row) {
				$enq_id = $row->enq_id;
				$this->db->select('u.role');
				$this->db->from('lmsuser u');
				$this->db->where('id',$cse_name[$i]);				
				$queryu=$this->db->get()->result();
				//print_r($queryu);
				if($queryu[0]->role==4 or $queryu[0]->role==5){
					$time = date("h:i:s A");
					$insertQuery1 = $this -> db -> query('INSERT INTO '.$table["request_to_lead_transfer_table"].' ( `lead_id` , `assign_to` , `assign_by` ,  `created_date` , `created_time`  ,status)  VALUES("' . $enq_id. '","' . $cse_name[$i] . '","' . $assign_by . '","' . $assign_date . '","' . $time . '","Transfered")') or die(mysql_error());
					$transfer_id=$this->db->insert_id();
				
				$this->db->query ("update ".$table['lead_master_table']." set transfer_id='$transfer_id', assign_by_cse_tl='$assign_by',assign_by_cse='$assign_by',assign_to_dse_tl_date='$assign_date',assign_to_dse_tl='$cse_name[$i]' where enq_id='$enq_id'");
			//	echo $this->db->last_query();
				}
				else {
					
				$this -> db -> query("update ".$table['lead_master_table']." set  assign_by_cse_tl='$assign_by',assign_to_cse_date='$assign_date',assign_to_cse='$cse_name[$i]' where enq_id='$enq_id'");
				}

			}
		}
if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Data successfully Updated.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}

	}
	function from_location($process_id,$user_id) {

		$this -> db -> select('l.*');
		$this -> db -> from('tbl_location l');
		$this->db->join('tbl_manager_process p','p.location_id=l.location_id');
		$this->db->where('process_id',$process_id);
		$this->db->where('user_id',$user_id);
		/*if ($_SESSION['role'] == '4' || $this->role=='5' || $this->role==3) {
			$this -> db -> where('l.location_id', $this->location_id);
		}*/
		
		$query = $this -> db -> get();
		//	echo $this->db->last_query();
		return $query -> result();

	}
	function to_location($process_id) {

		$this -> db -> select('l.*');
		$this -> db -> from('tbl_location l');
		$this->db->join('tbl_map_process p','p.location_id=l.location_id');
		$this->db->where('p.status !=','-1');
		$this->db->where('l.location_status !=','Deactive');
		$this->db->where('process_id',$process_id);
		$query = $this -> db -> get();
			//echo $this->db->last_query();
		return $query -> result();

	}
		function assign_transferred_lead_from_user($location,$process_id,$role,$user_id) {
		
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser l');
		$this -> db -> join('tbl_manager_process u', 'u.user_id=l.id');
		$this -> db -> join('tbl_rights r', 'r.user_id=l.id');
		$this -> db -> where('r.form_name', 'Calling Notification');
		$this -> db -> where('r.view', '1');
		$this -> db -> where('l.status', '1');
		$this -> db -> where('role !=', '1');
		$this -> db -> where('u.process_id', $process_id);
		$this -> db -> where('u.location_id', $location);
		$executive_array = array("4","3","8", "10", "12", "14", "16");
		if(in_array($role, $executive_array))
		{
			$this->db->where('l.id',$user_id);
		}
		$this -> db -> group_by("l.id");
		$this -> db -> order_by("fname", "asc");
		$query = $this -> db -> get();
		//	echo $this -> db -> last_query();
		return $query -> result();

	}
		function assign_transferred_leads_all_count($process_id,$process_name,$assign_to,$all_array) 
		{
			
		 $table=$this->select_table($process_id);	
		
		/*if ($assign_to == '') {
			$assign_to = $user_id;
			$role = $role;
		} else {*/
			$checkRole = $this -> db -> query("select role from lmsuser where id='$assign_to'") -> result();
			$role = $checkRole[0] -> role;
		//}

		if ($role == 5) {
			$assign = "assign_to_dse_tl=" . $assign_to . " and (assign_to_dse='' || assign_to_dse=" . $assign_to . ")";
		} elseif ($role == 4) {
			$assign = "assign_to_dse=" . $assign_to;
		}elseif ($role == 15) {
			$assign = "assign_to_e_tl=" . $assign_to . " and (assign_to_e_exe='' || assign_to_e_exe=" . $assign_to . ")";
		} elseif ($role == 16) {
			$assign = "assign_to_e_exe=" . $assign_to;
		} elseif (in_array($role, $all_array)) {
			$assign = "assign_to_cse=" . $assign_to . " and assign_to_dse_tl=0";
		}
		$this -> db -> select('count(enq_id)as acount');
		$this -> db -> from($table['lead_master_table']);
		$this -> db -> where($assign);
		
		if($process_id==8){
			$this -> db -> where('evaluation','Yes');
		}else{
			$this -> db -> where('nextAction!=', 'Close');
		$this -> db -> where('nextAction!=', 'Booked From Autovista');
		$this -> db -> where('process', $process_name);
		}
		$query = $this -> db -> get();
	//	echo $this->db->last_query();
		return $query -> result();

	}

	function assign_transferred_leads_source($process_id,$process_name,$assign_to,$all_array) {
		 $table=$this->select_table($process_id);	
			$checkRole = $this -> db -> query("select role from lmsuser where id='$assign_to'") -> result();
			$role = $checkRole[0] -> role;

		if ($role == 5) {
			$assign = "assign_to_dse_tl=" . $assign_to . " and (assign_to_dse='' || assign_to_dse=" . $assign_to . ")";
		} elseif ($role == 4) {
			$assign = "assign_to_dse=" . $assign_to;
		}elseif ($role == 15) {
			$assign = "assign_to_e_tl=" . $assign_to . " and (assign_to_e_exe='' || assign_to_e_exe=" . $assign_to . ")";
		} elseif ($role == 16) {
			$assign = "assign_to_e_exe=" . $assign_to;
		} elseif (in_array($role, $all_array)) {
			$assign = "assign_to_cse=" . $assign_to . " and assign_to_dse_tl=0";
		}
		$nextaction = "(nextaction !='Close' or nextaction !='Booked From Autovista')";
		$this -> db -> select('lead_source,enquiry_for,count(lead_source) as wcount');
			$this -> db -> from($table['lead_master_table']);
		$this -> db -> where($assign);
		//$this -> db -> where($nextaction);
		if($process_id==8){
			$this -> db -> where('evaluation', 'Yes');
		}else{
		$this -> db -> where('nextAction!=', 'Close');
		$this -> db -> where('nextAction!=', 'Booked From Autovista');
		$this -> db -> where('process', $process_name);
		}
		$this -> db -> group_by('lead_source');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
	function assign_transferred_lead_to_user($toLocation,$fromUser,$process_id) {
		
		$get_role = $this -> db -> query("select role from lmsuser where id='$fromUser'") -> result();
		$from_user_role = $get_role[0] -> role;
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser l');
		$this -> db -> join('tbl_manager_process u', 'u.user_id=l.id');
		$this -> db -> join('tbl_rights r', 'r.user_id=l.id');
		$this -> db -> where('r.form_name', 'Calling Notification');
		$this -> db -> where('r.view', '1');
		/*if($from_user_role==3)*/
			$tl_array = array("2", "5", "7", "9", "11", "13","15");
			$tl_list = '("2","5", "7", "9", "11", "13","15")';
			$executive_array = array("4", "8", "10", "12", "14","16");
		if ($from_user_role == 1 || $from_user_role == 2 || $from_user_role == 3) {
			$tl_array1 = array("2", "3", "5", "7", "9", "11", "13","15");
			$this -> db -> where_in('role', $tl_array1);
			
		} elseif (in_array($from_user_role, $tl_array)) {
			$q = $this -> db -> query('select dse_id from tbl_mapdse where tl_id="' . $fromUser . '"') -> result();

			$c = count($q);
			$t = ' ( ';
			if (count($q) > 0) {

				for ($i = 0; $i < $c; $i++) {

					$t = $t . "id = " . $q[$i] -> dse_id . " or ";

				}

			}
			$t = $t . "role in" . $tl_list;
			$st = $t . ')';

			$this -> db -> where($st);
		} elseif (in_array($from_user_role, $executive_array)) {
			$q1 = $this -> db -> query('select tl_id from tbl_mapdse where dse_id="' . $fromUser . '"') -> result();
			if (count($q1) > 0) {
				$q = $this -> db -> query('select dse_id from tbl_mapdse where tl_id="' . $q1[0] -> tl_id . '"') -> result();
				$c = count($q);
				$t = ' ( ';
				if (count($q) > 0) {

					for ($i = 0; $i < $c; $i++) {

						$t = $t . "id = " . $q[$i] -> dse_id . " or ";
					}
				}
				$t = $t . "role in" . $tl_list;
				$st = $t . ')';

				$this -> db -> where($st);

			} else {
				$t = $t . "role in" . $tl_list;
			}
		}
		$this -> db -> where('l.status', '1');
		$this -> db -> where('role !=', '1');
		$this->db->where('l.id !=',$fromUser);
		$this -> db -> where('u.process_id', $process_id);
		$this -> db -> where('u.location_id', $toLocation);
		//$this -> db -> where('location !=',0);
		$this -> db -> group_by("l.id");
		$this -> db -> order_by("fname", "asc");
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}
	public function assign_transferred_lead_update()
	{
		$process_id= $this -> input -> post('process_id');
		$process_name = $this -> input -> post('process_name');
		$table=$this->select_table($process_id);	
		$assign_by = $this -> input -> post('fromUser');
		$today = date('Y-m-d');
		$time = date("h:i:s A");
		
		$cse_name = json_decode($_POST['cse_name']);
		$cse_count = count($cse_name);
		$web_lead_name = $this -> input -> post('leads1');
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
			$all_array = array("2", "3", "8", "7", "9", "11", "13", "10", "12", "14");
			for ($i = 0; $i < $cse_count; $i++) {
				$assign_to=$cse_name[$i];
				$assign = "assign_to_cse=" . $assign_by . " and assign_to_dse_tl=0";
				
				if ($assignByRole == 5) {
					$assign = "assign_to_dse_tl=" . $assign_by . " and (assign_to_dse='' || assign_to_dse=" . $assign_by . ")";
				} elseif ($assignByRole == 4) {
					$assign = "assign_to_dse=" . $assign_by;
				} elseif (in_array($assignByRole, $all_array)) {
					$assign = "assign_to_cse=" . $assign_by . " and assign_to_dse_tl=0";
				}

				$this -> db -> select('enq_id');
				//$this -> db -> from($this -> table_name);
				$this -> db -> from($table['lead_master_table']);
				$this -> db -> where($assign);
				$this -> db -> where('lead_source', $web_lead_name);
				$this -> db -> where('nextAction!=', 'Close');
				$this -> db -> where('nextAction!=', 'Booked From Autovista');
				$this -> db -> where('process', $process_name);
				if ($i == 0) {
					$this -> db -> limit($assign_count_reminder);
				} else {
					$this -> db -> limit( $assign_count1);
				}
				$query = $this -> db -> get() -> result();
				

				foreach ($query as $row) {
					 $enq_id = $row -> enq_id;
					//echo "<br>";
					$insertQuery = $this -> db -> query('INSERT INTO '.$table["request_to_lead_transfer_table"].'( `lead_id` , `assign_to` , `assign_by` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $assign_to . '","' . $assign_by . '","' . $today . '","' . $time . '","Transfered")');
					$transfer_id = $this -> db -> insert_id();
					$selectRole = $this -> db -> query("select role from lmsuser where id='$assign_to'") -> result();
					//	print_r($selectRole);
					$tl_array = array("2", "7", "9", "11", "13");
					$executive_array = array("3","4", "8", "10", "12", "14");
					$assignToRole = $selectRole[0] -> role;
					$assignByCSETL = '';
					$assignByCSE = '';
					$assignToCSE = '';
					$assignToDSETL = '';
					$assignToDSE = '';
					$assignToCSEDate = '';
					$assignToDSETLDate = '';
					$assignToDSEDate = '';
					 $assignToRole;
					
					 $assignByRole;
					//print_r ($this -> tl_array);
					if ($assignToRole == 5) {
						if ($assignByRole == 2 || $assignByRole == 3 || $assignByRole == 1) {
							$assignByCSE = ",assign_by_cse='$assign_by'";
							$assignToDSETL = ",assign_to_dse_tl='$assign_to'";
							$assignToDSETLDate = ",assign_to_dse_tl_date='$today'";
						} elseif ($assignByRole == 4) {
							//echo "  4";							
							$assignToDSE = ",assign_to_dse='$assign_to'";
							$assignToDSEDate = ",assign_to_dse_date='$today'";
							
						}
						elseif ($assignByRole == 5)
						{
							$assignToDSETL = ",assign_to_dse_tl='$assign_to'";
							$assignToDSETLDate = ",assign_to_dse_tl_date='$today'";
						}
					} elseif ($assignToRole == 4) {
						//echo "5 to  4";			
						$assignToDSE = ",assign_to_dse='$assign_to'";
						$assignToDSEDate = ",assign_to_dse_date='$today'";
					} 
					elseif (in_array($assignToRole,$tl_array)) {
						//echo "testdata1";
						$assignToCSE = ",assign_to_cse='$assign_to'";
						$assignToCSEDate = ",assign_to_cse_date='$today'";
					} elseif (in_array($assignToRole,$executive_array)) {
							//echo "testdata";
						if (in_array($assignByRole, $tl_array)) {
							//echo "testdata2222";
							$assignByCSETL = ",assign_by_cse_tl='$assign_by'";
						}
						//echo "testdata23423423";
						$assignToCSE = ",assign_to_cse='$assign_to'";
						$assignToCSEDate = ",assign_to_cse_date='$today'";

					}
					$update1 = $this -> db -> query("update ".$table['lead_master_table']." set transfer_id='$transfer_id'
			" . $assignByCSETL .  $assignByCSE .  $assignToCSE . $assignToDSETL .  $assignToDSE . $assignToCSEDate . $assignToDSETLDate . $assignToDSEDate . "
			 where enq_id='$enq_id'");
			//echo $this->db->last_query();
					
				}
			}
		}
	if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Data successfully Updated.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}
	}
	function insertToken($mobileNumber, $token,$user_id) {
		
		$q=$this->db->query("select * from lmsuser where id='$user_id' and token='$token'")->result();
		//echo $this->db->last_query();
		 count($q);
		if(count($q) > 0)
		{
			$response["success"] = 1;
			$response["message"] = "Already Registered.";
			// echoing JSON response
			echo json_encode($response);
		}
		else
		{
			$query = $this -> db -> query("update lmsuser set token='$token' where id='$user_id'");
			if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Device Successfully Registered.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";
				// echoing JSON response
				echo json_encode($response);
			}
		}
	}
	public function send_notification($tokens,$msg)
	{
		//push notification
			$ch = curl_init("https://fcm.googleapis.com/fcm/send");
		    $header=array('Content-Type: application/json',"Authorization: key=AIzaSyDsLDz-pXM3_Y24LjKP_t51jTGgnk5AbHE ");
		    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//$tokens='AAAAPCYSOXM:APA91bGDCVNARh3dwbZZsVtJJwEI0Pm1MaG21rXiezO_4Rm6I7AA_IKn81sCK7YYXqv8PU6w7_pU85OK6ziATByO9ioGCg5yz5caQtDN_ZcWYlVWKGgcCI8wKaCbiqEO5EaqQEPppMBU';
		
		$token=json_encode($tokens);
		//$msg='New lead Assigned from LMS';
		$msg=json_encode($msg);
		
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \"notification\": {\"title\": \"LMS autovista.in\", \"text\":$msg}, \"to\" :$token }");
		  //finally executing the curl request 
		        $result = curl_exec($ch);
		        if ($result === FALSE) {
		            die('Curl failed: ' . curl_error($ch));
		        }		 
		        //Now close the connection
		        curl_close($ch);
					 
		        //and return the result 
		       //return $result;
	}
	/*public function poc_stock_count(){
		$make=$this->input->post('make');
		$stock_location=$this->input->post('stock_location');
		$model=$this->input->post('model');
		$this->db->select_max('upload_id');
		$this->db->from('tbl_stock_in_hand_poc');
		$max_id1 = $this -> db -> get()->result();
		
		foreach($max_id1 as $row)
		{
			$upload_id = $row->upload_id;
			
		}	
		$this -> db -> select('mk.make_name,st.submodel,count(st.submodel) as model_count');
		$this -> db -> from('tbl_stock_in_hand_poc st');		
		$this -> db -> join('makes mk', 'mk.make_id=st.make');
		$this -> db -> where('upload_id', $upload_id);
		if($make!=''){
			$this -> db -> where('make', $make);
		}
			if($model!=''){
			$this -> db -> where('submodel', $model);
		}
			if($stock_location!=''){
			$this -> db -> where('stock_location', $stock_location);
		}
		$this->db->group_by('st.submodel');
		$query = $this -> db -> get() -> result();
		if(count($query)>0){
		foreach($query as $row){
			$a1=1;
			$a2=2;
			$a3=3;
			$a4=4;
			$mfg_year_1=$this->select_old_stock_mfg_year($row->submodel,$upload_id,$a1,$make,$model,$stock_location);
			$mfg_year_2=$this->select_old_stock_mfg_year($row->submodel,$upload_id,$a2,$make,$model,$stock_location);
			$mfg_year_3=$this->select_old_stock_mfg_year($row->submodel,$upload_id,$a3,$make,$model,$stock_location);
			$mfg_year_4=$this->select_old_stock_mfg_year($row->submodel,$upload_id,$a4,$make,$model,$stock_location);
		
			$owner_1=$this->select_old_stock_owner($row->submodel,$upload_id,$a1,$make,$model,$stock_location);
			$owner_2=$this->select_old_stock_owner($row->submodel,$upload_id,$a2,$make,$model,$stock_location);
			$owner_3=$this->select_old_stock_owner($row->submodel,$upload_id,$a3,$make,$model,$stock_location);
			
			$ageing_1=$this->select_ageing($row->submodel,$upload_id,$a1,$make,$model,$stock_location);
			$ageing_2=$this->select_ageing($row->submodel,$upload_id,$a2,$make,$model,$stock_location);
			$ageing_3=$this->select_ageing($row->submodel,$upload_id,$a3,$make,$model,$stock_location);
			$ageing_4=$this->select_ageing($row->submodel,$upload_id,$a4,$make,$model,$stock_location);
			
			$price_1=$this->select_price($row->submodel,$upload_id,$a1,$make,$model,$stock_location);
			$price_2=$this->select_price($row->submodel,$upload_id,$a2,$make,$model,$stock_location);
			$price_3=$this->select_price($row->submodel,$upload_id,$a3,$make,$model,$stock_location);
			
			
			$select_data[]=array('make_name'=>$row->make_name,'submodel'=>$row->submodel,'model_count'=>$row->model_count,'mfg_year_1'=>$mfg_year_1,'mfg_year_2'=>$mfg_year_2,'mfg_year_3'=>$mfg_year_3,'mfg_year_4'=>$mfg_year_4,'owner_1'=>$owner_1,'owner_2'=>$owner_2,'owner_3'=>$owner_3
			,'ageing_1'=>$ageing_1,'ageing_2'=>$ageing_2,'ageing_3'=>$ageing_3,'ageing_4'=>$ageing_4,'price_1'=>$price_1,'price_2'=>$price_2,'price_3'=>$price_3);
		}
		}else{
			$select_data=array();
		}
		return $select_data;
	}*/
	public function poc_stock_count($make,$model,$stock_location,$mfg_year,$owner,$ageing,$price){
		
		
		//Check max upload date
		$this->db->select_max('upload_id');
		$this->db->from('tbl_stock_in_hand_poc');
		$max_id1 = $this -> db -> get()->result();
		
		foreach($max_id1 as $row)
		{
			$upload_id = $row->upload_id;
			
		}	
		
		$this -> db -> select('mk.make_name,st.submodel,count(st.submodel) as model_count');
		$this -> db -> from('tbl_stock_in_hand_poc st');		
		$this -> db -> join('makes mk', 'mk.make_id=st.make');
		$this -> db -> where('upload_id', $upload_id);
		//Get Make
		if($make!=''){
			$this -> db -> where('mk.make_name', $make);
		}
		//Get Model
		if($model!=''){
			$this -> db -> where('submodel', $model);
		}
		//Get stock Location
		if($stock_location!=''){
			$this -> db -> where('stock_location', $stock_location);
		}
		//Get mfg year
		if($mfg_year==1)
		{
			$this->db->where('st.mfg_year <',2010);
		}
		if($mfg_year==2)
		{
			$this->db->where('st.mfg_year <=',2012);
			$this->db->where('st.mfg_year >=',2010);
		}
		if($mfg_year==3)
		{
			$this->db->where('st.mfg_year <=',2015);
			$this->db->where('st.mfg_year >=',2012);
		}
		if($mfg_year==4)
		{
				$this->db->where('st.mfg_year >',2015);
		}
		//Get Owner
		if($owner==1)
		{
			$this->db->where('st.owner ',1);
		}
		if($owner==2)
		{
			$this->db->where('st.owner ',2);
		}
		if($owner==3)
		{
			$this->db->where('st.owner >',2);
		}
		//Get Ageing
		if($ageing==1)
		{
			$this->db->where('st.ageing <',15);	
		}
		if($ageing==2)
		{
			$this->db->where('st.ageing <=',30);
			$this->db->where('st.ageing >=',15);
		}
		if($ageing==3)
		{
			$this->db->where('st.ageing <=',60);
			$this->db->where('st.ageing >=',31);
		}
		if($ageing==4)
		{
			$this->db->where('st.ageing >',60);
		}
		//Get Prie
		if($price==1)
		{
			$this->db->where('st.expt_selling_price <','200000');	
		}
		if($price==2)
		{
			$this->db->where('st.expt_selling_price <=',500000);
			$this->db->where('st.expt_selling_price >=',200000);
		}
		if($price==3)
		{
			$this->db->where('st.expt_selling_price >',500000);
		}
		$this->db->group_by('st.submodel');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query=$query-> result();
		
		return $query;
	}

	public function poc_stock_list(){
		$make=$this->input->post('make');
		$model=$this->input->post('model');
		$stock_location=$this->input->post('stock_location');
		
		$mfg_year=$this->input->post('mfg_year');
		
		
		$owner=$this->input->post('owner');
		
		
		$ageing=$this->input->post('ageing');
		
		
		$price=$this->input->post('price');
		
		
		$this->db->select_max('upload_id');
		$this->db->from('tbl_stock_in_hand_poc');
		$max_id1 = $this -> db -> get()->result();
		foreach($max_id1 as $row)
		{
			$upload_id = $row->upload_id;
		}	
		$this -> db -> select('mk.make_name,st.submodel,st.color,st.fuel_type,st.owner,st.mfg_year,st.odo_meter,st.mileage,st.insurance_type,st.insurance_expiry_date,st.category,st.vehicle_status,st.stock_location,st.expt_selling_price,st.stock_ageing,st.total_landing_cost,st.created_date');
		$this -> db -> from('tbl_stock_in_hand_poc st');		
		$this -> db -> join('makes mk', 'mk.make_id=st.make');
	
		$this -> db -> where('upload_id', $upload_id);
		
		//Get Make
		if($make!=''){
			$this -> db -> where('mk.make_name', $make);
		}
		//Get Model
		if($model!=''){
			$this -> db -> where('submodel', $model);
		}
		//Get stock Location
		if($stock_location!=''){
			$this -> db -> where('stock_location', $stock_location);
		}
		//Get mfg year
		if($mfg_year==1)
		{
			$this->db->where('st.mfg_year <',2010);
		}
		if($mfg_year==2)
		{
			$this->db->where('st.mfg_year <=',2012);
			$this->db->where('st.mfg_year >=',2010);
		}
		if($mfg_year==3)
		{
			$this->db->where('st.mfg_year <=',2015);
			$this->db->where('st.mfg_year >=',2012);
		}
		if($mfg_year==4)
		{
				$this->db->where('st.mfg_year >',2015);
		}
		//Get Owner
		if($owner==1)
		{
			$this->db->where('st.owner ',1);
		}
		if($owner==2)
		{
			$this->db->where('st.owner ',2);
		}
		if($owner==3)
		{
			$this->db->where('st.owner >',2);
		}
		//Get Ageing
		if($ageing==1)
		{
			$this->db->where('st.ageing <',15);	
		}
		if($ageing==2)
		{
			$this->db->where('st.ageing <=',30);
			$this->db->where('st.ageing >=',15);
		}
		if($ageing==3)
		{
			$this->db->where('st.ageing <=',60);
			$this->db->where('st.ageing >=',31);
		}
		if($ageing==4)
		{
			$this->db->where('st.ageing >',60);
		}
		//Get Prie
		if($price==1)
		{
			$this->db->where('st.expt_selling_price <','200000');	
		}
		if($price==2)
		{
			$this->db->where('st.expt_selling_price <=',500000);
			$this->db->where('st.expt_selling_price >=',200000);
		}
		if($price==3)
		{
			$this->db->where('st.expt_selling_price >',500000);
		}

		$query = $this -> db -> get();
	
	//echo $this->db->last_query();
		return $query -> result();
	}
	/*public function new_stock_count(){
		$assigned_location=$this->input->post('assigned_location');
		$model=$this->input->post('model');
		
		$this->db->select_max('upload_id');
		$this->db->from('tbl_stock_in_hand_new');
		$max_id1 = $this -> db -> get()->result();
	
		foreach($max_id1 as $row)
		{
		 	$upload_id = $row->upload_id;
			
		}	
	
		$this -> db -> select('count(st.submodel) as model_count,st.submodel,model_name,assigned_location');
		$this -> db -> from('tbl_stock_in_hand_new st');		
		$this -> db -> join('make_models mk', 'mk.model_id=st.model','left');
		$this -> db -> where('upload_id', $upload_id);
			if($model!=''){
			$this -> db -> where('submodel',$model);
		}
			if($assigned_location!=''){
			$this -> db -> where('st.assigned_location', $assigned_location);
		}
	
		$this->db->group_by('st.submodel');
		$query1 = $this -> db -> get()-> result();
	
		
		
		if(count($query1)>0){
		foreach($query1 as $row){
		
			$a1=1;
			$a2=2;
			$a3=3;
			$a4=4;
			$vehicle_status_1=$this->select_new_stock_vehicle_status($row->submodel,$upload_id,$a1,$assigned_location);
			$vehicle_status_2=$this->select_new_stock_vehicle_status($row->submodel,$upload_id,$a2,$assigned_location);
		
			$ageing_1=$this->select_new_stock_ageing($row->submodel,$upload_id,$a1,$assigned_location);
			$ageing_2=$this->select_new_stock_ageing($row->submodel,$upload_id,$a2,$assigned_location);
			$ageing_3=$this->select_new_stock_ageing($row->submodel,$upload_id,$a3,$assigned_location);
			$ageing_4=$this->select_new_stock_ageing($row->submodel,$upload_id,$a4,$assigned_location);
			
			$price_1=$this->select_new_stock_price($row->submodel,$upload_id,$a1,$assigned_location);
			$price_2=$this->select_new_stock_price($row->submodel,$upload_id,$a2,$assigned_location);
			$price_3=$this->select_new_stock_price($row->submodel,$upload_id,$a3,$assigned_location);
			$price_4=$this->select_new_stock_price($row->submodel,$upload_id,$a4,$assigned_location);
			
			
			
			$select_data[]=array('model_name'=>$row->model_name,'assigned_location'=>$assigned_location,'submodel'=>$row->submodel,'model_count'=>$row->model_count,'vehicle_status_1'=>$vehicle_status_1,'vehicle_status_2'=>$vehicle_status_2,'ageing_1'=>$ageing_1,'ageing_2'=>$ageing_2,'ageing_3'=>$ageing_3,'ageing_4'=>$ageing_4,'price_1'=>$price_1,'price_2'=>$price_2,'price_3'=>$price_3,'price_4'=>$price_4);
		
		}
		}else{
			$select_data=array();
		}
		return $select_data;
	}*/
	public function new_stock_count(){
		$assigned_location=$this->input->post('assigned_location');
		$model=$this->input->post('model');
		
		$vehicle_status=$this->input->post('vehicle_status');
		$ageing=$this->input->post('ageing');
		$price=$this->input->post('price');
	
		//Select max upload date 
		$this->db->select_max('upload_id');
		$this->db->from('tbl_stock_in_hand_new');
		$max_id1 = $this -> db -> get()->result();
	
		foreach($max_id1 as $row)
		{
		 	$upload_id = $row->upload_id;
			
		}	
	
		$this -> db -> select('count(st.submodel) as model_count,st.submodel,model_name,assigned_location');
		$this -> db -> from('tbl_stock_in_hand_new st');		
		$this -> db -> join('make_models mk', 'mk.model_id=st.model','left');
		$this -> db -> where('upload_id', $upload_id);
		
		//Get model 
		if($model!=''){
			$this -> db -> where('submodel',$model);
		}
		
		//Get assigned location
		if($assigned_location!=''){
			$this -> db -> where('st.assigned_location', $assigned_location);
		}
		//Get vehicle status
		if($vehicle_status==1)
		{
			$this->db->where('st.vehicle_status ','FREE');
		}
		if($vehicle_status==2)
		{
			$this->db->where('st.vehicle_status ','BLOCKED');
		}
		//Get ageing
		if($ageing==1)
		{
			$this->db->where('st.ageing <',15);	
		}
		if($ageing==2)
		{
			$this->db->where('st.ageing <=',30);
			$this->db->where('st.ageing >=',15);
		}
		if($ageing==3)
		{
			$this->db->where('st.ageing <=',60);
			$this->db->where('st.ageing >=',31);
		}
		if($ageing==4)
		{
			$this->db->where('st.ageing >',60);
		}
		if($price==1)
		{
			$this->db->where('st.purchase_price <','400000');	
		}
		if($price==2)
		{
			$this->db->where('st.purchase_price <=',600000);
			$this->db->where('st.purchase_price >=',400000);
		}
		if($price==3)
		{
			$this->db->where('st.purchase_price <=',800000);
			$this->db->where('st.purchase_price >=',600000);
		}
		if($price==4)
		{
			
			$this->db->where('st.purchase_price >=',800000);
		}
		$this->db->group_by('st.submodel');
		$query1 = $this -> db -> get();
		//echo $this->db->last_query();
		$query1=$query1-> result();
	
		return $query1;
	}
/*	function select_new_stock_vehicle_status($submodel,$upload_id,$filterElement,$assigned_location){
		$this -> db -> select('count(id) as vehicle_status');
		$this -> db -> from('tbl_stock_in_hand_new st');		
		if($filterElement==1)
		{
			$this->db->where('st.vehicle_status ','FREE');
		}
		elseif($filterElement==2)
		{
			$this->db->where('st.vehicle_status ','BLOCKED');
		}
		
		if($assigned_location!=''){
			$this -> db -> where('assigned_location', $assigned_location);
		}
		$this->db->where('st.submodel',$submodel);
		$this -> db -> where('upload_id', $upload_id);
			$query = $this -> db -> get()->result();
		$tcount=$query[0]->vehicle_status;
	//	echo $this->db->last_query();
		return $tcount; 
	}
	function select_new_stock_ageing($submodel,$upload_id,$filterElement,$assigned_location)
	{
		$this -> db -> select('count(id) as ageing');
		$this -> db -> from('tbl_stock_in_hand_new st');		
		
		$this->db->where('st.submodel',$submodel);
		$this -> db -> where('upload_id', $upload_id);
		if($filterElement==1)
		{
			$this->db->where('st.ageing <',15);	
		}
		elseif($filterElement==2)
		{
			$this->db->where('st.ageing <=',30);
			$this->db->where('st.ageing >=',15);
		}
		elseif($filterElement==3)
		{
			$this->db->where('st.ageing <=',60);
			$this->db->where('st.ageing >=',31);
		}
		elseif($filterElement==4)
		{
			$this->db->where('st.ageing >',60);
		}
		if($assigned_location!=''){
			$this -> db -> where('assigned_location', $assigned_location);
		}
		$query = $this -> db -> get()->result();
		$tcount=$query[0]->ageing;
		//echo $this->db->last_query();
		return $tcount; 
	}
	function select_new_stock_price($submodel,$upload_id,$filterElement,$assigned_location)
	{
		$this -> db -> select('count(id) as price');
		$this -> db -> from('tbl_stock_in_hand_new st');		
		
		$this->db->where('st.submodel',$submodel);
		$this -> db -> where('upload_id', $upload_id);
		if($filterElement==1)
		{
			$this->db->where('st.purchase_price <','400000');	
		}
		elseif($filterElement==2)
		{
			$this->db->where('st.purchase_price <=',600000);
			$this->db->where('st.purchase_price >=',400000);
		}
		elseif($filterElement==3)
		{
			$this->db->where('st.purchase_price <=',800000);
			$this->db->where('st.purchase_price >=',600000);
		}
		elseif($filterElement==4)
		{
			
			$this->db->where('st.purchase_price >=',800000);
		}
		if($assigned_location!=''){
			$this -> db -> where('assigned_location', $assigned_location);
		}
		$query = $this -> db -> get()->result();
		$tcount=$query[0]->price;
		//echo $this->db->last_query();
		return $tcount; 
	}*/
	function new_stock_list()
	{
		$assigned_location=$this->input->post('assigned_location');
		$model=$this->input->post('model');
		
		$vehicle_status=$this->input->post('vehicle_status');
		$ageing=$this->input->post('ageing');
		$price=$this->input->post('price');
	
		$this->db->select_max('upload_id');
		$this->db->from('tbl_stock_in_hand_new');
		$max_id1 = $this -> db -> get()->result();
		foreach($max_id1 as $row)
		{
			$upload_id = $row->upload_id;
		}	
		$this -> db -> select('mk.model_name,st.submodel,st.color,st.fuel_type,st.vehicle_status,st.assigned_location,st.ageing,st.created_date');
		$this -> db -> from('tbl_stock_in_hand_new st');		
		$this -> db -> join('make_models mk', 'mk.model_id=st.model');
	
		$this -> db -> where('upload_id', $upload_id);
		
		//Get model 
		if($model!=''){
			$this -> db -> where('submodel',$model);
		}
		
		//Get assigned location
		if($assigned_location!=''){
			$this -> db -> where('st.assigned_location', $assigned_location);
		}
		//Get vehicle status
		if($vehicle_status==1)
		{
			$this->db->where('st.vehicle_status ','FREE');
		}
		if($vehicle_status==2)
		{
			$this->db->where('st.vehicle_status ','BLOCKED');
		}
		//Get ageing
		if($ageing==1)
		{
			$this->db->where('st.ageing <',15);	
		}
		if($ageing==2)
		{
			$this->db->where('st.ageing <=',30);
			$this->db->where('st.ageing >=',15);
		}
		if($ageing==3)
		{
			$this->db->where('st.ageing <=',60);
			$this->db->where('st.ageing >=',31);
		}
		if($ageing==4)
		{
			$this->db->where('st.ageing >',60);
		}
		if($price==1)
		{
			$this->db->where('st.purchase_price <','400000');	
		}
		if($price==2)
		{
			$this->db->where('st.purchase_price <=',600000);
			$this->db->where('st.purchase_price >=',400000);
		}
		if($price==3)
		{
			$this->db->where('st.purchase_price <=',800000);
			$this->db->where('st.purchase_price >=',600000);
		}
		if($price==4)
		{
			
			$this->db->where('st.purchase_price >=',800000);
		}

		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
	/****************************************************************************/
	/********************* New Dashboard(with TL,Executive button) ****************************************/
	public function new_dashboard()
	{
			//post_values
			$user=$this->input->post('user_type');
			$location_name=$this->input->post('location_name');
			$process_id=$this->input->post('process_id');
			$user_id=$this->input->post('user_id');
			$role=$this->input->post('role');
			$role_name=$this->input->post('role_name');
			$process_name=$this->input->post('process_name');
			// Array values
			$select_role=array("3","4","8","10","12","14","16");
			$tl_role=array("CSE Team Leader","DSE Team Leader","Service TL","Insurance TL","Accessories TL","Finance TL","Evaluation Team Leader");
			$executive_role=array("CSE","DSE","Service Excecutive","Insurance Executive","Accessories Executive","Finance Executive","Evaluation Executive");
			
			$this -> db -> select('u.id,u.fname,u.lname,u.location ,u.role,l.location as location_name');
			$this -> db -> from('lmsuser u');
			$this->db->join('tbl_manager_process p','p.user_id=u.id');
			$this->db->join('tbl_location l','l.location_id=p.location_id');
			$this->db->join('tbl_mapdse m','m.dse_id=u.id','left');
		
			$this -> db -> where('p.location_id', $location_name);
			$this -> db -> where('p.process_id', $process_id);
			$this -> db -> where('u.status', 1);
		
			if(in_array($role,$select_role)){
					$this->db->where('id',$user_id);
			}else{
					if($user=='DSE'){
					
					if(in_array($role_name,$tl_role)){
					$this->db->where('m.tl_id',$user_id);
					}else{
						$this->db->where_in('role_name',$executive_role);
					}
					
					}else{
						
					if(in_array($role_name,$tl_role)){
					$this->db->where('id',$user_id);
					}else{
						$this->db->where_in('role_name',$tl_role);
					}
					}
				}
			$query = $this -> db -> get() ;
			//echo $this->db->last_query();
			$query=$query-> result();
			//print_r($query);
			if(count($query)>0){
				if($user =='')
			{
				$unassigned_leads_count=0;
				$new_leads_count=0;
				$call_today_leads_count=0;
				$pending_new_leads_count=0;
				$pending_followup_leads_count=0;
				$home_visit_count1=0;
				$test_drive_count1=0;
				$showroom_visit_count1=0;
				$evaluation_count1=0;
				$escalation_level_1_count=0;
				$escalation_level_2_count=0;
				$escalation_level_3_count=0;
			}
			foreach($query as $row){
			//	echo $row->id. 'role '.$row->role;
				$unassigned_leads = $this -> unassigned_leads_new($row -> id,$row->role,$process_name,$process_id);
				$new_leads=$this -> new_leads_new($row -> id,$row->role,$process_name,$process_id);
				$call_today=$this -> call_today_new($row -> id,$row->role,$process_name,$process_id);
				$pending_new_leads=$this -> pending_new_leads_new($row -> id,$row->role,$process_name,$process_id);
				$pending_followup=$this -> pending_followup_new($row -> id,$row->role,$process_name,$process_id);
				$con = 'f.appointment_type="Home Visit"';
				$con1='Home Visit';
				$home_visit_count = $this -> check_count($con1,$con, $row -> id,$row->role,$process_name,$process_id);
				
				$con = 'f.appointment_type="Test Drive"';
				$con1='Test Drive';
				$test_drive_count = $this -> check_count($con1,$con, $row -> id,$row->role,$process_name,$process_id);
				$con = 'f.appointment_type="Showroom Visit"';
				$con1='Showroom Visit';
				$showroom_visit_count = $this -> check_count($con1,$con, $row -> id,$row->role,$process_name,$process_id);
				$con = 'f.appointment_type="Evaluation Allotted"';
				$con1='Evaluation Allotted';
				$evaluation_count = $this -> check_count($con1,$con, $row -> id,$row->role,$process_name,$process_id);
				
				
				$escalation_level_1=$this -> escalation_level_1($row -> id,$row->role,$process_name,$process_id);
				$escalation_level_2=$this -> escalation_level_2($row -> id,$row->role,$process_name,$process_id);
				$escalation_level_3=$this -> escalation_level_3($row -> id,$row->role,$process_name,$process_id);
				if($user !='')
				{
					$select_leads[] = array('id'=>$row -> id,'role'=>$row->role, 'location_name'=>$row->location_name,'fname' => $row -> fname, 'lname' => $row -> lname, 'unassigned_leads' => $unassigned_leads,  'new_leads' => $new_leads,'call_today' => $call_today, 'pending_new_leads' => $pending_new_leads, 'pending_followup' => $pending_followup, 
				'evaluation_count' => $evaluation_count,'test_drive_count' => $test_drive_count,'home_visit_count' => $home_visit_count,'showroom_visit_count' => $showroom_visit_count,
				'escalation_level_1' => $escalation_level_1,'escalation_level_2' => $escalation_level_2,'escalation_level_3' => $escalation_level_3);
			
				}
				else {
					
					if($row->location_name=='Pune Call Center'){
					$unassigned_leads_count=$unassigned_leads; 
				 }else{
					$unassigned_leads_count=$unassigned_leads_count+$unassigned_leads;
				 }
					
					$new_leads_count=$new_leads_count+$new_leads;
					$call_today_leads_count=$call_today_leads_count+$call_today;
					$pending_new_leads_count=$pending_new_leads_count+$pending_new_leads;
					$pending_followup_leads_count=$pending_followup_leads_count+$pending_followup;
					$home_visit_count1=$home_visit_count1+$home_visit_count;
					$test_drive_count1=$test_drive_count1+$test_drive_count;
					$showroom_visit_count1=$showroom_visit_count1+$showroom_visit_count;
					$evaluation_count1=$evaluation_count1+$evaluation_count;
					$escalation_level_1_count=$escalation_level_1_count+$escalation_level_1;
					$escalation_level_2_count=$escalation_level_2_count+$escalation_level_2;
					$escalation_level_3_count=$escalation_level_3_count+$escalation_level_3;
			
				}
				
			}
			if($user =='')
			{
			$select_leads[] = array('unassigned_leads' => $unassigned_leads_count,  'new_leads' => $new_leads_count,'call_today' => $call_today_leads_count, 'pending_new_leads' => $pending_new_leads_count, 'pending_followup' => $pending_followup_leads_count, 
				'evaluation_count' => $evaluation_count1,'test_drive_count' => $test_drive_count1,'home_visit_count' => $home_visit_count1,'showroom_visit_count' => $showroom_visit_count1,
				'escalation_level_1' => $escalation_level_1_count,'escalation_level_2' => $escalation_level_2_count,'escalation_level_3' => $escalation_level_3_count);
			}
			}else{
				$select_leads = array();
				
			}
			 		return	$select_leads;
	}
public function check_count($con1,$con,$id,$role,$process_name,$process_id){
		//echo $id;
		$table=$this->select_table($process_id);
		
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as call_today');
		$this -> db -> from($table['lead_master_table'].' ln');
		if($role == '5')
		{
			$this -> db -> join($table['lead_followup_table'].' f','f.id=ln.dse_followup_id');
			$this -> db -> where('ln.assign_to_dse_tl',$id);
		}
		elseif($role == '4')
		{
			$this -> db -> join($table['lead_followup_table'].' f','f.id=ln.dse_followup_id');
			//$this -> db -> where('ln.assign_to_dse_tl!=',0);
			$this -> db -> where('ln.assign_to_dse', $id);
		}
elseif($role == '15')
		{
			$this -> db -> join($table['lead_followup_table'].' f','f.id=ln.exe_followup_id');
			$this -> db -> where('ln.assign_to_e_tl',$id);
		}
		elseif($role == '16')
		{
			$this -> db -> join($table['lead_followup_table'].' f','f.id=ln.exe_followup_id');
			$this -> db -> where('ln.assign_to_e_tl!=',0);
			$this -> db -> where('ln.assign_to_e_exe', $id);
		}
		elseif (in_array($role,$this->executive_array)) {
			$this -> db -> join($table['lead_followup_table'].' f','f.id=ln.cse_followup_id');
			$this -> db -> where('ln.assign_to_cse', $id);
			//$this -> db -> where('ln.assign_to_dse_tl',0);
		}elseif(in_array($role,$this->tl_array)){
			$this -> db -> join($table['lead_followup_table'].' f','f.id=ln.cse_followup_id');
			$this -> db -> where('assign_by_cse_tl', $id);
		}
		$this -> db -> where($con);
		if($process_id==8){
			$this -> db -> where('ln.evaluation', 'Yes');
		}else{
		$this -> db -> where('ln.process', $process_name);
		}
		//$this -> db -> where('ln.process', $process_name);
		/*if($con1=='Home Visit')
		{
			$this -> db -> where('f.td_hv_date', $this->today);
		}
		else {*/
			$this -> db -> where('f.appointment_date', $this->today);
		//}
		//$this -> db -> where('f.nextfollowupdate', $today);
		//$this -> db -> where('ln.nextAction!=', "Close");	
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_call_today = $query1[0] -> call_today;
		return $total_call_today;
	}
public function escalation_level_1($id,$role,$process_name,$process_id){
	$table=$this->select_table($process_id);
		$today=date('Y-m-d');
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(distinct (enq_id)) as new_leads');
		$this -> db -> from($table['lead_master_table'].' ln');
		
		if($process_id==8){
			$this -> db -> where('ln.evaluation', 'Yes');
		}else{
		$this -> db -> where('ln.process', $process_name);
		}
		//$this -> db -> where('ln.process', $process_name);
		$this -> db -> where('ln.esc_level1 ', "Yes");
		
		if($role == '5')
		{
			$this -> db -> where('ln.assign_to_dse_tl',$id);
		}
		elseif($role == '4')
		{
			$this -> db -> where('ln.assign_to_dse_tl!=',0);
			$this -> db -> where('ln.assign_to_dse', $id);
		}
		if($role == '15')
		{
			$this -> db -> where('ln.assign_to_e_tl',$id);
		}
		elseif($role == '16')
		{
			$this -> db -> where('ln.assign_to_e_tl!=',0);
			$this -> db -> where('ln.assign_to_e_exe ', $id);
		}
		elseif (in_array($role,$this->executive_array)) {
			$this -> db -> where('ln.assign_to_cse', $id);
		}elseif(in_array($role,$this->tl_array)){
			$this -> db -> where('assign_by_cse_tl', $id);
		}
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_new_lead = $query1[0] -> new_leads;
		return $total_new_lead;
}
public function escalation_level_2($id,$role,$process_name,$process_id){
	$table=$this->select_table($process_id);
		$today=date('Y-m-d');
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(distinct (enq_id)) as new_leads');
		$this -> db -> from($table['lead_master_table'].' ln');
		
		if($process_id==8){
			$this -> db -> where('ln.evaluation', 'Yes');
		}else{
		$this -> db -> where('ln.process', $process_name);
		}
		//$this -> db -> where('ln.process', $process_name);
		$this -> db -> where('ln.esc_level2 ', "Yes");
		
		if($role == '5')
		{
			$this -> db -> where('ln.assign_to_dse_tl',$id);
		}
		elseif($role == '4')
		{
			$this -> db -> where('ln.assign_to_dse_tl!=',0);
			$this -> db -> where('ln.assign_to_dse', $id);
		}
		else if($role == '15')
		{
			$this -> db -> where('ln.assign_to_e_tl ',$id);
		}
		elseif($role == '16')
		{
			$this -> db -> where('ln.assign_to_e_tl !=',0);
			$this -> db -> where('ln.assign_to_e_exe ', $id);
		}
		elseif (in_array($role,$this->executive_array)) {
			$this -> db -> where('ln.assign_to_cse', $id);
		}elseif(in_array($role,$this->tl_array)){
			$this -> db -> where('assign_by_cse_tl', $id);
		}
		$query = $this -> db -> get();
		$query1 = $query -> result();
		$total_new_lead = $query1[0] -> new_leads;
		return $total_new_lead;
}
public function escalation_level_3($id,$role,$process_name,$process_id){
	$table=$this->select_table($process_id);
		$today=date('Y-m-d');
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(distinct (enq_id)) as new_leads');
		$this -> db -> from($table['lead_master_table'].' ln');
		
		if($process_id==8){
			$this -> db -> where('ln.evaluation', 'Yes');
		}else{
		$this -> db -> where('ln.process', $process_name);
		}
		//$this -> db -> where('ln.process', $process_name);
			$this -> db -> where('ln.esc_level3 ', "Yes");
		
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
			$this -> db -> where('ln.assign_to_e_tl ',$id);
		}
		elseif($role == '16')
		{
			$this -> db -> where('ln.assign_to_e_tl !=',0);
			$this -> db -> where('ln.assign_to_e_exe ', $id);
		}
		elseif (in_array($role,$this->executive_array)) {
			$this -> db -> where('ln.assign_to_cse', $id);
		}elseif(in_array($role,$this->tl_array)){
			$this -> db -> where('assign_by_cse_tl', $id);
		}
		$query = $this -> db -> get();
		$query1 = $query -> result();
		$total_new_lead = $query1[0] -> new_leads;
		return $total_new_lead;
}
		public function unassigned_leads_new($id,$role,$process_name,$process_id){
		$table=$this->select_table($process_id);
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as unassign');
		$this -> db -> from($table['lead_master_table'].' ln');
		if($process_id==8){
			$this -> db -> where('ln.evaluation', 'Yes');
		}else{
		$this -> db -> where('ln.process', $process_name);
		}
	
		$this -> db -> where('ln.nextAction!=', "Close");
		if($role == '5')
		{
			$this -> db -> where('ln.assign_to_dse_tl',$id);
			$this -> db -> where('ln.assign_to_dse', 0);
		}
		elseif($role == '4')
		{
			$this -> db -> where('ln.assign_to_dse_tl',0);
			$this -> db -> where('ln.assign_to_dse', $id);
		}
	elseif($role == '15')
		{
			$this -> db -> where('ln.assign_to_e_tl',$id);
			$this -> db -> where('ln.assign_to_e_exe', 0);
		}
		elseif($role == '16')
		{
			$this -> db -> where('ln.assign_to_e_tl',0);
			$this -> db -> where('ln.assign_to_e_exe', $id);
		}
		elseif (in_array($role,$this->executive_array)) {
			$this -> db -> where('assign_by_cse_tl', 0);
			$this -> db -> where('ln.assign_to_cse', $id);
		}elseif(in_array($role,$this->tl_array)){
			$this -> db -> where('assign_by_cse_tl', 0);
		
			
		}
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_unassigned = $query1[0] -> unassign;
		return $total_unassigned;
	}
	public function new_leads_new($id,$role,$process_name,$process_id){
		$table=$this->select_table($process_id);
		$today=date('Y-m-d');
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as new_leads');
		$this -> db -> from($table['lead_master_table'].' ln');
		
		if($process_id==8){
			$this -> db -> where('ln.evaluation', 'Yes');
		}else{
		$this -> db -> where('ln.process', $process_name);
		}
		$this -> db -> where('ln.nextAction!=', "Close");
		
		if($role == '5')
		{
			$this -> db -> where('dse_followup_id', 0);
			$this -> db -> where('ln.assign_to_dse_tl',$id);
			$this -> db -> where('ln.assign_to_dse_date', $today);
		}
		elseif($role == '4')
		{
			$this -> db -> where('dse_followup_id', 0);
			$this -> db -> where('ln.assign_to_dse_tl!=',0);
			$this -> db -> where('ln.assign_to_dse', $id);
			$this -> db -> where('ln.assign_to_dse_date', $today);
		}
		elseif($role == '15')
		{
			$this -> db -> where('exe_followup_id', 0);
			$this -> db -> where('ln.assign_to_e_tl',$id);
			$this -> db -> where('ln.assign_to_e_exe_date', $today);
		}
		elseif($role == '16')
		{
			$this -> db -> where('exe_followup_id', 0);
			$this -> db -> where('ln.assign_to_e_tl!=',0);
			$this -> db -> where('ln.assign_to_e_exe', $id);
			$this -> db -> where('ln.assign_to_e_exe_date', $today);
		}
		elseif (in_array($role,$this->executive_array)) {
			$this -> db -> where('cse_followup_id', 0);
			$this -> db -> where('ln.assign_to_cse', $id);
			$this -> db -> where('ln.assign_to_cse_date', $today);
		}elseif(in_array($role,$this->tl_array)){
			$this -> db -> where('assign_by_cse_tl', $id);
			$this -> db -> where('ln.assign_to_dse_tl',0);
			$this -> db -> where('ln.assign_to_cse_date', $today);
			$this -> db -> where('cse_followup_id', 0);
		}
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_new_lead = $query1[0] -> new_leads;
		return $total_new_lead;
	}
	public function call_today_new($id,$role,$process_name,$process_id){
		//echo $role;
		$table=$this->select_table($process_id);
		$today=date('Y-m-d');
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as call_today');
		$this -> db -> from($table['lead_master_table'].' ln');
		if($role == '5')
		{
			$this -> db -> join($table['lead_followup_table'].' f','f.id=ln.dse_followup_id');
			$this -> db -> where('ln.assign_to_dse_tl',$id);
		}
		elseif($role == '4')
		{
			$this -> db -> join($table['lead_followup_table'].' f','f.id=ln.dse_followup_id');
			$this -> db -> where('ln.assign_to_dse_tl!=',0);
			$this -> db -> where('ln.assign_to_dse', $id);
		}
		elseif($role == '15')
		{
			$this -> db -> join($table['lead_followup_table'].' f','f.id=ln.exe_followup_id');
			$this -> db -> where('ln.assign_to_e_tl',$id);
		}
		elseif($role == '16')
		{
			$this -> db -> join($table['lead_followup_table'].' f','f.id=ln.exe_followup_id');
			$this -> db -> where('ln.assign_to_e_tl!=',0);
			$this -> db -> where('ln.assign_to_e_exe', $id);
		}
		elseif (in_array($role,$this->executive_array)) {
			$this -> db -> join($table['lead_followup_table'].' f','f.id=ln.cse_followup_id');
			$this -> db -> where('ln.assign_to_cse', $id);
			$this -> db -> where('ln.assign_to_dse_tl',0);
		}elseif(in_array($role,$this->tl_array)){
			$this -> db -> join($table['lead_followup_table'].' f','f.id=ln.cse_followup_id');
			$this -> db -> where('assign_by_cse_tl', $id);
		}
		if($process_id==8){
			$this -> db -> where('ln.evaluation', 'Yes');
		}else{
		$this -> db -> where('ln.process', $process_name);
		}
	//	$this -> db -> where('ln.process', $process_name);
		$this -> db -> where('f.nextfollowupdate', $today);
		$this -> db -> where('ln.nextAction!=', "Close");	
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_call_today = $query1[0] -> call_today;
		return $total_call_today;
	}
public function pending_new_leads_new($id,$role,$process_name,$process_id){
		
		$today=date('Y-m-d');
		$table=$this->select_table($process_id);
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as pending_new');
		$this -> db -> from($table['lead_master_table'].' ln');
		if($process_id==8){
			$this -> db -> where('ln.evaluation', 'Yes');
		}else{
		$this -> db -> where('ln.process', $process_name);
		}
		
		//$this -> db -> where('ln.nextAction!=', "Close");
		
		if($role == '5')
		{
			$this -> db -> where('dse_followup_id', 0);
			$this -> db -> where('ln.assign_to_dse_tl',$id);
			$this -> db -> where('ln.assign_to_dse_tl_date <', $today);
			$this -> db -> where('ln.assign_to_dse_tl_date!=', '0000-00-00');
		}
		elseif($role == '4')
		{
			$this -> db -> where('ln.dse_followup_id',0);
			$this -> db -> where('ln.assign_to_dse_tl!=',0);
			$this -> db -> where('ln.assign_to_dse', $id);
			$this -> db -> where('ln.assign_to_dse_date <', $today);
			$this -> db -> where('ln.assign_to_dse_date!=', '0000-00-00');
		}
		elseif($role == '15')
		{
			$this -> db -> where('exe_followup_id', 0);
			$this -> db -> where('ln.assign_to_e_tl',$id);
			$this -> db -> where('ln.assign_to_e_exe_date <', $today);
			$this -> db -> where('ln.assign_to_e_exe_date!=', '0000-00-00');
		}
		elseif($role == '16')
		{
			$this -> db -> where('ln.exe_followup_id',0);
			$this -> db -> where('ln.assign_to_e_tl!=',0);
			$this -> db -> where('ln.assign_to_e_exe', $id);
			$this -> db -> where('ln.assign_to_e_exe_date <', $today);
			$this -> db -> where('ln.assign_to_e_exe_date!=', '0000-00-00');
		}
		elseif (in_array($role,$this->executive_array)) {
			
			$this -> db -> where('cse_followup_id', 0);
			$this -> db -> where('ln.assign_to_cse', $id);
			$this -> db -> where('ln.assign_to_cse_date < ', $today);
			$this -> db -> where('ln.assign_to_cse_date!=', '0000-00-00');
		}
		elseif(in_array($role,$this->tl_array)) {
			$this -> db -> where('ln.assign_to_dse_tl', 0);
			$this -> db -> where('assign_by_cse_tl', $id);
			$this -> db -> where('ln.assign_to_cse_date < ', $today);
			$this -> db -> where('ln.assign_to_cse_date!=', '0000-00-00');
			$this -> db -> where('cse_followup_id', 0);
		}
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_pending_new = $query1[0] -> pending_new;
		return $total_pending_new;
	}
public function pending_followup_new($id,$role,$process_name,$process_id){
		//echo $id;
		//echo $role;
		$today=date('Y-m-d');
		$table=$this->select_table($process_id);
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as call_today');
		$this -> db -> from($table['lead_master_table'].' ln');
		if($role == '5')
		{
			$this -> db -> join($table['lead_followup_table'].' f','f.id=ln.dse_followup_id');
			$this -> db -> where('ln.assign_to_dse_tl',$id);
		}
		elseif($role == '4')
		{
			$this -> db -> join($table['lead_followup_table'].' f','f.id=ln.dse_followup_id');
			$this -> db -> where('ln.assign_to_dse_tl!=',0);
			$this -> db -> where('ln.assign_to_dse', $id);
		}
elseif($role == '15')
		{
			$this -> db -> join($table['lead_followup_table'].' f','f.id=ln.exe_followup_id');
			$this -> db -> where('ln.assign_to_e_tl',$id);
		}
		elseif($role == '16')
		{
			$this -> db -> join($table['lead_followup_table'].' f','f.id=ln.exe_followup_id');
			$this -> db -> where('ln.assign_to_e_tl!=',0);
			$this -> db -> where('ln.assign_to_e_exe', $id);
		}
		elseif (in_array($role,$this->executive_array)) {
			$this -> db -> join($table['lead_followup_table'].' f','f.id=ln.cse_followup_id');
			$this -> db -> where('ln.assign_to_cse', $id);
			$this -> db -> where('ln.assign_to_dse_tl',0);
		}elseif(in_array($role,$this->tl_array)){
			$this -> db -> join($table['lead_followup_table'].' f','f.id=ln.cse_followup_id');
			$this -> db -> where('assign_by_cse_tl', $id);
			$this -> db -> where('ln.assign_to_dse_tl',0);
		}
	if($process_id==8){
			$this -> db -> where('ln.evaluation', 'Yes');
		}else{
		$this -> db -> where('ln.process', $process_name);
		}
		$this -> db -> where('f.nextfollowupdate <', $today);
		$this -> db -> where('f.nextfollowupdate!=', '0000-00-00');
		$this -> db -> where('ln.nextAction!=', "Close");	
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_call_today = $query1[0] -> call_today;
		return $total_call_today;
	}
	/********************* daily productivity report(with TL,Executive button) ****************************************/
	public function daily_productivity_report()
	{
			//post_values
			$user=$this->input->post('user_type');
			$location_name=$this->input->post('location_name');
			$process_id=$this->input->post('process_id');
			$user_id=$this->input->post('user_id');
			$role=$this->input->post('role');
			$role_name=$this->input->post('role_name');
			$process_name=$this->input->post('process_name');
			// Array values
			$select_role=array("3","4","8","10","12","14");
			$tl_role=array("CSE Team Leader","DSE Team Leader","Service TL","Insurance TL","Accessories TL","Finance TL");
			$executive_role=array("CSE","DSE","Service Excecutive","Insurance Executive","Accessories Executive","Finance Executive");
			
			$this -> db -> select('u.id,u.fname,u.lname,u.location ,u.role,l.location as location_name');
			$this -> db -> from('lmsuser u');
			$this->db->join('tbl_manager_process p','p.user_id=u.id');
			$this->db->join('tbl_location l','l.location_id=p.location_id');
			$this->db->join('tbl_mapdse m','m.dse_id=u.id','left');
		
			$this -> db -> where('p.location_id', $location_name);
			$this -> db -> where('p.process_id', $process_id);
			$this -> db -> where('u.status', 1);
		
			if(in_array($role,$select_role)){
					$this->db->where('id',$user_id);
			}else{
					if($user=='DSE'){
					
					if(in_array($role_name,$tl_role)){
					$this->db->where('m.tl_id',$user_id);
					}else{
						$this->db->where_in('role_name',$executive_role);
					}
					
					}else{
						
					if(in_array($role_name,$tl_role)){
					$this->db->where('id',$user_id);
					}else{
						$this->db->where_in('role_name',$tl_role);
					}
					}
				}
			$query = $this -> db -> get() ;
			//echo $this->db->last_query();
			$query=$query-> result();
			//print_r($query);
			if(count($query)>0){
			foreach($query as $row){
			
				$escalation_level_1=$this -> total_called($row -> id,$row->role,$process_name,$process_id);
				$escalation_level_2=$this -> escalation_level_1($row -> id,$row->role,$process_name,$process_id);
				$escalation_level_3=$this -> escalation_level_1($row -> id,$row->role,$process_name,$process_id);
				$select_leads[] = array('id'=>$row -> id,'role'=>$row->role, 'location_name'=>$row->location_name,'fname' => $row -> fname, 'lname' => $row -> lname, 
				'total_called' => $escalation_level_1,'total_connected' => $escalation_level_2,'total_not_connected' => $escalation_level_3);
			
			}
			}else{
				//$select_leads[] = array('id'=>'','role'=>'', 'location_name'=>'','fname' => '', 'lname' => '', 'unassigned_leads' => '',  'new_leads' => '','call_today' => '', 'pending_new_leads' => '', 'pending_followup' => '');
			$select_leads = array();
				
			}
			 		return	$select_leads;
	}
	public function total_called($id,$role,$process_name,$process_id){
		//echo $id;
		//echo $role;
		$today=date('Y-m-d');
		$table=$this->select_table($process_id);
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as call_today');
		$this -> db -> from($table['lead_master_table'].' ln');
		if($role == '5')
		{
			$this -> db -> join($table['lead_followup_table'].' f','f.id=ln.dse_followup_id');
			$this -> db -> where('ln.assign_to_dse_tl',$id);
		}
		elseif($role == '4')
		{
			$this -> db -> join($table['lead_followup_table'].' f','f.id=ln.dse_followup_id');
			$this -> db -> where('ln.assign_to_dse_tl!=',0);
			$this -> db -> where('ln.assign_to_dse', $id);
		}
		elseif (in_array($role,$this->executive_array)) {
			$this -> db -> join($table['lead_followup_table'].' f','f.id=ln.cse_followup_id');
			$this -> db -> where('ln.assign_to_cse', $id);
			$this -> db -> where('ln.assign_to_dse_tl',0);
		}elseif(in_array($role,$this->tl_array)){
			$this -> db -> join($table['lead_followup_table'].' f','f.id=ln.cse_followup_id');
			$this -> db -> where('assign_by_cse_tl', $id);
			$this -> db -> where('ln.assign_to_dse_tl',0);
		}
		$this -> db -> where('ln.process', $process_name);
		$this -> db -> where('f.date ', $this->today);
		/*$this -> db -> where('f.nextfollowupdate!=', '0000-00-00');
		$this -> db -> where('ln.nextAction!=', "Close");*/	
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_call_today = $query1[0] -> call_today;
		return $total_call_today;
	}
	
	public function select_home_visit_today($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page)
{	
	
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		ini_set('memory_limit', '-1');
		$table=$this->select_table($process_id_session);	
		$rec_limit = 100;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		if($user_id=='')    {         $userid=$user_id_session;       }
		else {	 $userid=$user_id;	}
		 if($role=='')
        {
            $role=$role_session;
        }
		$this -> db -> select('
			ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
			l.assign_to_dse,l.assign_to_dse_tl,l.assign_to_cse,l.assign_by_cse_tl,l.cse_followup_id,l.dse_followup_id,l.lead_source,l.eagerness,l.enq_id,name,l.address,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km,l.feedbackStatus,l.nextAction,l.	days60_booking,l.esc_level1,l.esc_level1_remark,l.esc_level2,l.esc_level2_remark,l.esc_level3,l.esc_level3_remark');
		
		$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join($table['lead_followup_table'].' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.dse_followup_id', 'left');
		
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		
		$this -> db -> where('l.process', $process_name_session);
	//	$this -> db -> where('l.nextAction', "Home Visit");
		
		//If role DSE TL and Dashboard id blank(for calling task)
		if ($role == '5' && $user_id=='') {
			
			//$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse',$userid);
			$this -> db -> where('f2.appointment_type',"Home Visit");
			$this -> db -> where('f2.appointment_date', $this->today);
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '5' && $user_id!='')
		{
			$this -> db -> where('l.assign_to_dse_tl',$userid);
			$this -> db -> where('f2.appointment_type',"Home Visit");
			$this -> db -> where('f2.appointment_date', $this->today);
        }
		//If role DSE 
		elseif($role == '4')
		{
			$this -> db -> where('l.assign_to_dse', $userid);
			$this -> db -> where('f2.appointment_type',"Home Visit");
			$this -> db -> where('f2.appointment_date', $this->today);
		}
		
		// If role all executive
		elseif (in_array($role,$executive_array)) {
		
			$this -> db -> where('l.assign_to_cse', $userid);
				$this -> db -> where('f1.appointment_type',"Home Visit");
			$this -> db -> where('f1.appointment_date', $this->today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		
		elseif(in_array($role,$tl_array) && $user_id==''){
        
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('f1.appointment_type',"Home Visit");
			$this -> db -> where('f1.appointment_date', $this->today);
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
      
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			$this -> db -> where('f1.appointment_type',"Home Visit");
			$this -> db -> where('f1.appointment_date', $this->today);
        }
		if(!empty($contact_no)){
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		$this->db->group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		
		$this -> db -> limit($rec_limit,$offset);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
}
//New Lead Count
public function select_home_visit_today_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page){
			
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		$table=$this->select_table($process_id_session);	
        if($user_id=='')    {         $userid=$user_id_session;       }
		else {	 $userid=$user_id;	}
		 if($role=='')
        {
            $role=$role_session;
        }
		$this -> db -> select('count(enq_id) as count_lead');
		$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join($table['lead_followup_table'].' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.dse_followup_id', 'left');
		
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> where('l.process', $process_name_session);
		//$this -> db -> where('l.nextAction', "Home Visit");
		
		//If role DSE TL and Dashboard id blank(for calling task)
		if ($role == '5' && $user_id=='') {
			
			//$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse',$userid);
		$this -> db -> where('f2.appointment_type',"Home Visit");
			$this -> db -> where('f2.appointment_date', $this->today);
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '5' && $user_id!='')
		{
			$this -> db -> where('l.assign_to_dse_tl',$userid);
			$this -> db -> where('f2.appointment_type',"Home Visit");
			$this -> db -> where('f2.appointment_date', $this->today);
        }
		//If role DSE 
		elseif($role == '4')
		{
			$this -> db -> where('l.assign_to_dse', $userid);
			$this -> db -> where('f2.appointment_type',"Home Visit");
			$this -> db -> where('f2.appointment_date', $this->today);
		}
		
		// If role all executive
		elseif (in_array($role,$executive_array)) {
		
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('f1.appointment_type',"Home Visit");
			$this -> db -> where('f1.appointment_date', $this->today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		
		elseif(in_array($role,$tl_array) && $user_id==''){
        
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('f1.appointment_type',"Home Visit");
			$this -> db -> where('f1.appointment_date', $this->today);
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
      
			$this -> db -> where('l.assign_by_cse_tl', $userid);
		$this -> db -> where('f1.appointment_type',"Home Visit");
			$this -> db -> where('f1.appointment_date', $this->today);
        }
		if(!empty($contact_no)){
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		$this -> db -> order_by('l.enq_id', 'desc');
	
		$query = $this -> db -> get();
		//	echo $this->db->last_query();
		return $query -> result();

	}
public function select_test_drive_today($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page)
{	
	
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		ini_set('memory_limit', '-1');
		$table=$this->select_table($process_id_session);	
		$rec_limit = 100;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		if($user_id=='')    {         $userid=$user_id_session;       }
		else {	 $userid=$user_id;	}
		 if($role=='')
        {
            $role=$role_session;
        }
		$this -> db -> select('
			ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
			l.assign_to_dse,l.assign_to_dse_tl,l.assign_to_cse,l.assign_by_cse_tl,l.cse_followup_id,l.dse_followup_id,l.lead_source,l.eagerness,l.enq_id,name,l.address,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km,l.feedbackStatus,l.nextAction,l.	days60_booking,l.esc_level1,l.esc_level1_remark,l.esc_level2,l.esc_level2_remark,l.esc_level3,l.esc_level3_remark');
		
		$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join($table['lead_followup_table'].' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.dse_followup_id', 'left');
		
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		
		$this -> db -> where('l.process', $process_name_session);
		//$this -> db -> where('l.nextAction', "Test Drive");
		
		//If role DSE TL and Dashboard id blank(for calling task)
		if ($role == '5' && $user_id=='') {
			
			//$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse',$userid);
			$this -> db -> where('f2.appointment_type',"Test Drive");
			$this -> db -> where('f2.appointment_date', $this->today);
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '5' && $user_id!='')
		{
			$this -> db -> where('l.assign_to_dse_tl',$userid);
			$this -> db -> where('f2.appointment_type',"Test Drive");
			$this -> db -> where('f2.appointment_date', $this->today);
        }
		//If role DSE 
		elseif($role == '4')
		{
			$this -> db -> where('l.assign_to_dse', $userid);
			$this -> db -> where('f2.appointment_type',"Test Drive");
			$this -> db -> where('f2.appointment_date', $this->today);
		}
		
		// If role all executive
		elseif (in_array($role,$executive_array)) {
		
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('f1.appointment_type',"Test Drive");
			$this -> db -> where('f1.appointment_date', $this->today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		
		elseif(in_array($role,$tl_array) && $user_id==''){
        
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('f1.appointment_type',"Test Drive");
			$this -> db -> where('f1.appointment_date', $this->today);
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
      
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			$this -> db -> where('f1.appointment_type',"Test Drive");
			$this -> db -> where('f1.appointment_date', $this->today);
        }
		if(!empty($contact_no)){
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		$this->db->group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		
		$this -> db -> limit($rec_limit,$offset);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
}
//Test drive today Count
public function select_test_drive_today_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page){
			
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		$table=$this->select_table($process_id_session);	
       if($user_id=='')    {         $userid=$user_id_session;       }
		else {	 $userid=$user_id;	}
		 if($role=='')
        {
            $role=$role_session;
        }
		$this -> db -> select('count(enq_id) as count_lead');
		$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join($table['lead_followup_table'].' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.dse_followup_id', 'left');
		
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> where('l.process', $process_name_session);
		//$this -> db -> where('l.nextAction', "Test Drive");
		
		//If role DSE TL and Dashboard id blank(for calling task)
		if ($role == '5' && $user_id=='') {
			
			//$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse',$userid);
			$this -> db -> where('f2.appointment_type',"Test Drive");
			$this -> db -> where('f2.appointment_date', $this->today);
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '5' && $user_id!='')
		{
			$this -> db -> where('l.assign_to_dse_tl',$userid);
			$this -> db -> where('f2.appointment_type',"Test Drive");
			$this -> db -> where('f2.appointment_date', $this->today);
        }
		//If role DSE 
		elseif($role == '4')
		{
			$this -> db -> where('l.assign_to_dse', $userid);
			$this -> db -> where('f2.appointment_type',"Test Drive");
			$this -> db -> where('f2.appointment_date', $this->today);
		}
		
		// If role all executive
		elseif (in_array($role,$executive_array)) {
		
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('f1.appointment_type',"Test Drive");
			$this -> db -> where('f1.appointment_date', $this->today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		
		elseif(in_array($role,$tl_array) && $user_id==''){
        
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('f1.appointment_type',"Test Drive");
			$this -> db -> where('f1.appointment_date', $this->today);
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
      
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			$this -> db -> where('f1.appointment_type',"Test Drive");
			$this -> db -> where('f1.appointment_date', $this->today);
        }
		if(!empty($contact_no)){
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		$this -> db -> order_by('l.enq_id', 'desc');
	
		$query = $this -> db -> get();
		//	echo $this->db->last_query();
		return $query -> result();

	}
	public function select_showroom_visit_today($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page)
{	
	
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		ini_set('memory_limit', '-1');
		$table=$this->select_table($process_id_session);	
		$rec_limit = 100;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		if($user_id=='')    {         $userid=$user_id_session;       }
		else {	 $userid=$user_id;	}
		 if($role=='')
        {
            $role=$role_session;
        }
		$this -> db -> select('
			ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
			l.assign_to_dse,l.assign_to_dse_tl,l.assign_to_cse,l.assign_by_cse_tl,l.cse_followup_id,l.dse_followup_id,l.lead_source,l.eagerness,l.enq_id,name,l.address,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km,l.feedbackStatus,l.nextAction,l.	days60_booking,l.esc_level1,l.esc_level1_remark,l.esc_level2,l.esc_level2_remark,l.esc_level3,l.esc_level3_remark');
		
		$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join($table['lead_followup_table'].' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.dse_followup_id', 'left');
		
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		
		$this -> db -> where('l.process', $process_name_session);
		//$this -> db -> where('l.nextAction', "Showroom Visit");
		
		//If role DSE TL and Dashboard id blank(for calling task)
		if ($role == '5' && $user_id=='') {
			
			//$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse',$userid);
			$this -> db -> where('f2.appointment_type',"Showroom Visit");
			$this -> db -> where('f2.appointment_date', $this->today);
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '5' && $user_id!='')
		{
			$this -> db -> where('l.assign_to_dse_tl',$userid);
			$this -> db -> where('f2.appointment_type',"Showroom Visit");
			$this -> db -> where('f2.appointment_date', $this->today);
        }
		//If role DSE 
		elseif($role == '4')
		{
			$this -> db -> where('l.assign_to_dse', $userid);
			$this -> db -> where('f2.appointment_type',"Showroom Visit");
			$this -> db -> where('f2.appointment_date', $this->today);
		}
		
		// If role all executive
		elseif (in_array($role,$executive_array)) {
		
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('f1.appointment_type',"Showroom Visit");
			$this -> db -> where('f1.appointment_date', $this->today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		
		elseif(in_array($role,$tl_array) && $user_id==''){
        
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('f1.appointment_type',"Showroom Visit");
			$this -> db -> where('f1.appointment_date', $this->today);
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
      
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			$this -> db -> where('f1.appointment_type',"Showroom Visit");
			$this -> db -> where('f1.appointment_date', $this->today);
        }
		if(!empty($contact_no)){
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		$this->db->group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');		
		$this -> db -> limit($rec_limit,$offset);		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
}
//Test drive today Count
public function select_showroom_visit_today_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page){
			
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		$table=$this->select_table($process_id_session);	
        if($user_id=='')
        {
            $userid=$user_id_session;
        }
		else {
			 $userid=$user_id;
		}
		 if($role=='')
        {
            $role=$role_session;
        }
		$this -> db -> select('count(enq_id) as count_lead');
		$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join($table['lead_followup_table'].' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.dse_followup_id', 'left');
		
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> where('l.process', $process_name_session);
		//$this -> db -> where('l.nextAction', "Showroom Visit");
		
		//If role DSE TL and Dashboard id blank(for calling task)
		if ($role == '5' && $user_id=='') {
			
			//$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse',$userid);
			$this -> db -> where('f2.appointment_type',"Showroom Visit");
			$this -> db -> where('f2.appointment_date', $this->today);
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '5' && $user_id!='')
		{
			$this -> db -> where('l.assign_to_dse_tl',$userid);
			$this -> db -> where('f2.appointment_type',"Showroom Visit");
			$this -> db -> where('f2.appointment_date', $this->today);
        }
		//If role DSE 
		elseif($role == '4')
		{
			$this -> db -> where('l.assign_to_dse', $userid);
			$this -> db -> where('f2.appointment_type',"Showroom Visit");
			$this -> db -> where('f2.appointment_date', $this->today);
		}
		
		// If role all executive
		elseif (in_array($role,$executive_array)) {
		
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('f1.appointment_type',"Showroom Visit");
			$this -> db -> where('f1.appointment_date', $this->today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		
		elseif(in_array($role,$tl_array) && $user_id==''){
        
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('f1.appointment_type',"Showroom Visit");
			$this -> db -> where('f1.appointment_date', $this->today);
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
      
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			$this -> db -> where('f1.appointment_type',"Showroom Visit");
			$this -> db -> where('f1.appointment_date', $this->today);
        }
		if(!empty($contact_no)){
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		$this -> db -> order_by('l.enq_id', 'desc');
		$query = $this -> db -> get();
		//	echo $this->db->last_query();
		return $query -> result();
	}
	public function select_evaluation_today($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page)
{	
	
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		ini_set('memory_limit', '-1');
		$table=$this->select_table($process_id_session);	
		$rec_limit = 100;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		if($user_id=='')
        {
            $userid=$user_id_session;
        }
		else {
			 $userid=$user_id;
		}
		 if($role=='')
        {
            $role=$role_session;
        }
		$this -> db -> select('
			ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
			l.assign_to_dse,l.assign_to_dse_tl,l.assign_to_cse,l.assign_by_cse_tl,l.cse_followup_id,l.dse_followup_id,l.lead_source,l.eagerness,l.enq_id,name,l.address,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km,l.feedbackStatus,l.nextAction,l.	days60_booking,l.esc_level1,l.esc_level1_remark,l.esc_level2,l.esc_level2_remark,l.esc_level3,l.esc_level3_remark');
		
		$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join($table['lead_followup_table'].' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.dse_followup_id', 'left');
		
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		
		$this -> db -> where('l.process', $process_name_session);
		//$this -> db -> where('l.nextAction', "Evaluation Allotted");
		
		//If role DSE TL and Dashboard id blank(for calling task)
		if ($role == '5' && $user_id=='') {
			
			//$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse',$userid);
			$this -> db -> where('f2.appointment_type',"Evaluation Allotted");
			$this -> db -> where('f2.appointment_date', $this->today);
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '5' && $user_id!='')
		{
			$this -> db -> where('l.assign_to_dse_tl',$userid);
			$this -> db -> where('f2.appointment_type',"Evaluation Allotted");
			$this -> db -> where('f2.appointment_date', $this->today);
        }
		//If role DSE 
		elseif($role == '4')
		{
			$this -> db -> where('l.assign_to_dse', $userid);
			$this -> db -> where('f2.appointment_type',"Evaluation Allotted");
			$this -> db -> where('f2.appointment_date', $this->today);
		}
		
		// If role all executive
		elseif (in_array($role,$executive_array)) {
		
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('f1.appointment_type',"Evaluation Allotted");
			$this -> db -> where('f1.appointment_date', $this->today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		
		elseif(in_array($role,$tl_array) && $user_id==''){
        
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('f1.appointment_type',"Evaluation Allotted");
			$this -> db -> where('f1.appointment_date', $this->today);
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
      
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			$this -> db -> where('f1.appointment_type',"Evaluation Allotted");
			$this -> db -> where('f1.appointment_date', $this->today);
        }
		if(!empty($contact_no)){
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		$this->db->group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');		
		$this -> db -> limit($rec_limit,$offset);		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
}
//Test drive today Count
public function select_evaluation_today_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page){
			
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		$table=$this->select_table($process_id_session);	
        if($user_id=='')
        {
            $userid=$user_id_session;
        }
		else {
			 $userid=$user_id;
		}
		 if($role=='')
        {
            $role=$role_session;
        }
		$this -> db -> select('count(enq_id) as count_lead');
		$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join($table['lead_followup_table'].' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.dse_followup_id', 'left');
		
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> where('l.process', $process_name_session);
		//$this -> db -> where('l.nextAction', "Evaluation Allotted");
		
		//If role DSE TL and Dashboard id blank(for calling task)
		if ($role == '5' && $user_id=='') {
			
			//$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse',$userid);
			$this -> db -> where('f2.appointment_type',"Evaluation Allotted");
			$this -> db -> where('f2.appointment_date', $this->today);
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '5' && $user_id!='')
		{
			$this -> db -> where('l.assign_to_dse_tl',$userid);
			$this -> db -> where('f2.appointment_type',"Evaluation Allotted");
			$this -> db -> where('f2.appointment_date', $this->today);
        }
		//If role DSE 
		elseif($role == '4')
		{
			$this -> db -> where('l.assign_to_dse', $userid);
			$this -> db -> where('f2.appointment_type',"Evaluation Allotted");
			$this -> db -> where('f2.appointment_date', $this->today);
		}
		
		// If role all executive
		elseif (in_array($role,$executive_array)) {
		
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('f1.appointment_type',"Evaluation Allotted");
			$this -> db -> where('f1.appointment_date', $this->today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		
		elseif(in_array($role,$tl_array) && $user_id==''){
        
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('f1.appointment_type',"Evaluation Allotted");
			$this -> db -> where('f1.appointment_date', $this->today);
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
      
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			$this -> db -> where('f1.appointment_type',"Evaluation Allotted");
			$this -> db -> where('f1.appointment_date', $this->today);
        }
		if(!empty($contact_no)){
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		$this -> db -> order_by('l.enq_id', 'desc');
		$query = $this -> db -> get();
		//	echo $this->db->last_query();
		return $query -> result();
	}
	public function select_escalation($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page,$feedback)
{	
	
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		ini_set('memory_limit', '-1');
		$table=$this->select_table($process_id_session);	
		$rec_limit = 100;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		
		if($user_id=='')
        {
            $userid=$user_id_session;
        }
		else {
			 $userid=$user_id;
		}
		 if($role=='')
        {
            $role=$role_session;
        }
		$this -> db -> select('
			ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
			l.assign_to_dse,l.assign_to_dse_tl,l.assign_to_cse,l.assign_by_cse_tl,l.cse_followup_id,l.dse_followup_id,l.lead_source,l.eagerness,l.enq_id,name,l.address,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km,l.feedbackStatus,l.nextAction,l.	days60_booking,l.esc_level1,l.esc_level1_remark,l.esc_level2,l.esc_level2_remark,l.esc_level3,l.esc_level3_remark');
		
		$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join($table['lead_followup_table'].' f1', 'f1.id=l.cse_followup_id', 'left');
	
	//	$this -> db -> join($table['lead_followup_table'].' f', 'f.leadid=l.enq_id');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		if($process_id_session==8){
		
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
		}else{
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> where('l.process', $process_name_session);
		}
		
	//	$this -> db -> where('f.feedbackStatus', $feedback);
			$this -> db -> where($feedback, 'Yes');
		//If role DSE TL and Dashboard id blank(for calling task)
		if ($role == '5' && $user_id=='') {
			
			//$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse',$userid);
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '5' && $user_id!='')
		{
			$this -> db -> where('l.assign_to_dse_tl',$userid);
        }
		//If role DSE 
		elseif($role == '4')
		{
			$this -> db -> where('l.assign_to_dse', $userid);
		}
		elseif ($role == '15' && $user_id=='') {
			
			//$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_e_exe',$userid);
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '15' && $user_id!='')
		{
			$this -> db -> where('l.assign_to_e_tl',$userid);
        }
		//If role DSE 
		elseif($role == '16')
		{
			$this -> db -> where('l.assign_to_e_exe', $userid);
		}
		
		// If role all executive
		elseif (in_array($role,$executive_array)) {
		
			$this -> db -> where('l.assign_to_cse', $userid);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		
		elseif(in_array($role,$tl_array) && $user_id==''){
        
			$this -> db -> where('l.assign_to_cse', $userid);
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
      
			$this -> db -> where('l.assign_by_cse_tl', $userid);
        }
		if(!empty($contact_no)){
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		$this->db->group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');		
		$this -> db -> limit($rec_limit,$offset);		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
		
}
//Test drive today Count
public function select_escalation_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page,$feedback){
			
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		$table=$this->select_table($process_id_session);	
        if($user_id=='')
        {
            $userid=$user_id_session;
        }
		else {
			 $userid=$user_id;
		}
        if($role=='')
        {
            $role=$role_session;
        }
		$this -> db -> select('count(distinct(enq_id)) as count_lead');
		$this -> db -> from($table['lead_master_table'].' l');
		$this -> db -> join($table['lead_followup_table'].' f1', 'f1.id=l.cse_followup_id', 'left');
		//$this -> db -> join($table['lead_followup_table'].' f', 'f.leadid=l.enq_id');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		if($process_id_session==8){
		
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
		}else{
		$this -> db -> join($table['lead_followup_table'].' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> where('l.process', $process_name_session);
		}
		
	//	$this -> db -> where('f.feedbackStatus', $feedback);
			$this -> db -> where($feedback, 'Yes');
		//If role DSE TL and Dashboard id blank(for calling task)
		if ($role == '5' && $user_id=='') {
			
			//$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_dse',$userid);
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '5' && $user_id!='')
		{
			$this -> db -> where('l.assign_to_dse_tl',$userid);
        }
		//If role DSE 
		elseif($role == '4')
		{
			$this -> db -> where('l.assign_to_dse', $userid);
		}
		elseif ($role == '15' && $user_id=='') {
			
			//$this -> db -> where('l.dse_followup_id', 0);
			$this -> db -> where('l.assign_to_e_exe',$userid);
        }
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '15' && $user_id!='')
		{
			$this -> db -> where('l.assign_to_e_tl',$userid);
        }
		//If role DSE 
		elseif($role == '16')
		{
			$this -> db -> where('l.assign_to_e_exe', $userid);
		}
		
		// If role all executive
		elseif (in_array($role,$executive_array)) {
		
			$this -> db -> where('l.assign_to_cse', $userid);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		
		elseif(in_array($role,$tl_array) && $user_id==''){
        
			$this -> db -> where('l.assign_to_cse', $userid);
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
      
			$this -> db -> where('l.assign_by_cse_tl', $userid);
        }
		if(!empty($contact_no)){
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		$this -> db -> order_by('l.enq_id', 'desc');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
	function customer_corporate_name() 
	{
		$this->db->select('*');
		$this->db->from('tbl_corporate');
		$query = $this->db->get();
		return $query->result();
	}
	function get_app_version() 
	{
		$this->db->select('*');
		$this->db->from('tbl_android_app_version');
		$query = $this->db->get();
		return $query->result();
	}
	function update_app_version($version_code, $version_name,$id)
	{
		$query = $this -> db -> query("update tbl_android_app_version set version_code='$version_code',version_name='$version_name' where id='$id'");
			if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Successfully Updated.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";
				// echoing JSON response
				echo json_encode($response);
			}
	}
	public function insert_auditor_remark() {
		$today = date("Y-m-d");
		$time = date("H:i:s A");
		$process_id_session = $this -> input -> post('process_id_session');
		$table=$this->select_table($process_id_session);	
		$assign=$this -> input -> post('user_id');
		$followup_pending = $this -> input -> post('followup_pending');
		$call_received = $this -> input -> post('call_received');
		$fake_updation = $this -> input -> post('fake_updation');
		$service_feedback = $this -> input -> post('service_feedback');
		$comment = $this -> input -> post('comment');
		$enq_id = $this -> input -> post('booking_id');
		if($process_id_session==9){
			$insert = $this -> db -> query("INSERT INTO tbl_manager_remark(`complaint_id`, `user_id`, `followup_pending`, `call_received`, `fake_updation`, `service_feedback`, `remark`, `created_date`, `created_time`)VALUES ('$enq_id','$assign','$followup_pending','$call_received','$fake_updation','$service_feedback','$comment','$today','$time')") or die(mysql_error());
		$insert_id = $this -> db -> insert_id();
		$update = $this -> db -> query("update lead_master_complaint set auditor_user_id='$assign',remark_id='$insert_id' where complaint_id='$enq_id'") or die(mysql_error());
			
		}else{
		
		$insert = $this -> db -> query("INSERT INTO ".$table['request_to_lead_transfer_table']."(`lead_id`, `user_id`, `followup_pending`, `call_received`, `fake_updation`, `service_feedback`, `remark`, `created_date`, `created_time`)VALUES ('$enq_id','$assign','$followup_pending','$call_received','$fake_updation','$service_feedback','$comment','$today','$time')") or die(mysql_error());
		$insert_id = $this -> db -> insert_id();
		$update = $this -> db -> query("update ".$table['lead_master_table']." set auditor_user_id='$assign',remark_id='$insert_id' where enq_id='$enq_id'") or die(mysql_error());
			
		}
		if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Successfully Updated.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";
				// echoing JSON response
				echo json_encode($response);
			}
	}
	public function auditor_remark_detail() {
			
		$process_id_session = $this -> input -> post('process_id_session');
		$table=$this->select_table($process_id_session);	
		$enq_id = $this -> input -> post('booking_id');	
		$this -> db -> select('r.remark_id,r.lead_id,r.user_id,r.followup_pending,r.call_received,r.fake_updation,r.service_feedback,r.remark,r.created_date,u.fname,u.lname');
		if($process_id_session==9){
			$this -> db -> from('tbl_manager_remark r');
			$this -> db -> join('lmsuser u', 'u.id=r.user_id');
			$this -> db -> where('complaint_id', $enq_id);
		}
		else
		{
		$this -> db -> from($table['request_to_lead_transfer_table'].' r');	
		$this -> db -> join('lmsuser u', 'u.id=r.user_id');
		$this -> db -> where('lead_id', $enq_id);
		}		
		$this -> db -> order_by('remark_id', 'desc');
		$query = $this -> db -> get();
		return $query -> result();
	}
		public function forgot_pwd($email)
	{
		
			
		
				$this->db->select('*');
				$this->db->from('lmsuser');
				
				$this->db->where('email',$email);		
				$query = $this->db->get()->result();
				
			//print_r($query);
		if(count($query)>0)
		{
				
			$email1=$query[0]->email;
			 $fname=$query[0]->fname;
			
			if ($email1 == $email)
			
			{
				
				$password = $query[0]->empId;
				
				$msg="Dear " .$fname.",\n\nYour New Password is:".$password. "\n\nThanks and regards,\nTeam Autovista"; 
 
		//	echo $msg;		

 

			
 					$this->db->query('update lmsuser set password="'.$password.'" where email="'.$email.'"');
				$response["success"] = 1;
				$response["message"] = "New Password Successfully Updated.";
				// echoing JSON response
				echo json_encode($response);
			
				 	$this->email->from('info@autovista.in', 'Admin');
					$this->email->to($email); 
					$this->email->subject('New Password');
					$this->email->message($msg);	
					$this->email->send();
 
			
			}
			
			
		}	
		else {
			
	
				$response["success"] = 0;
				$response["message"] = "Please Enter Correct Mail ID.";
				// echoing JSON response
				echo json_encode($response);
			
		
		}
	
	
	
	}
	public function my_profile($user_id)
	{
		//$this->db->query("select empId,fname,lname,mobileno , 	email ,role, 	role_name , 	process_id , 	date  from lmsuser join tbl_manager_process mp on mp.")
		$this->db->select('u.empId,u.fname,u.lname,u.mobileno ,u.email ,u.role,u.role_name,u.date,p.process_id,GROUP_CONCAT(DISTINCT p.process_name) as process_name,GROUP_CONCAT(DISTINCT l.location) as location');
		$this->db->from('lmsuser u');
		$this->db->join('tbl_manager_process mp','u.id=mp.user_id');
		$this->db->join('tbl_location l','l.location_id=mp.location_id');
		$this->db->join('tbl_process p','p.process_id=mp.process_id');		
		$this->db->where('u.id',$user_id);
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $query->result();
		
	}
	public function insert_user_map_location($user_id,$role_id,$role_name,$latitude,$logitude) {
		$created_date = date("Y-m-d");
		$time = date("H:i:s A");
		$check_user=$this->db->query("select mapping_id from tbl_map_user_location where user_id='$user_id'")->result();
		if(count($check_user)>0){
			$insert = $this -> db -> query("UPDATE `tbl_map_user_location` SET `latitude`='$latitude',`longitude`='$logitude',`last_updated_date`='$created_date' WHERE user_id='$user_id'") or die(mysql_error());
	
		}else{
		$insert = $this -> db -> query("INSERT INTO `tbl_map_user_location`(`user_id`, `role_id`, `role_name`, `latitude`, `longitude`, `created_date`) 
		VALUES ('$user_id','$role_id','$role_name','$latitude','$logitude','$created_date')") or die(mysql_error());
	
		}
		
		if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Successfully Updated.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";
				// echoing JSON response
				echo json_encode($response);
			}
	}
public function select_user_map_location($location_id,$process_id) {
	$this->db->select('u.fname,u.lname,u.mobileno,u.role,u.role_name,l.latitude,l.longitude');
			$this->db->from('lmsuser u');
			$this->db->join('tbl_manager_process mp','u.id=mp.user_id');
			$this->db->join('tbl_map_user_location l','l.user_id=u.id');	
			$this->db->where('mp.location_id',$location_id);
			$this->db->where('mp.process_id',$process_id);
			$this -> db -> group_by('u.id');
			$query=$this->db->get();
			//echo $this->db->last_query();
			return $query->result();
	}
	function select_sub_lead_source($process_id,$lead_source_name) {
			
		$this->db->select('sub_lead_source_id,sub_lead_source_name');
		$this->db->from('sub_lead_source');
		$this->db->where('lead_source_name',$lead_source_name);
		$this->db->where('sub_lead_source_status','Active');
		$this->db->where('process_id',$process_id);
		$query=$this->db->get();	
		return $query->result();
		

	}
	public function all_user_details()
	{
	ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> input -> post('page');
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$process_array=array();				
		$location_array=array();		
		$process=$this->select_process();				
		foreach ($process as $row) {
			array_push($process_array,$row->process_id);
			$query=$this->select_map_location($row->process_id);
				foreach ($query as $row) {
					array_push($location_array,$row->location_id);
				}
			
		}
		$this -> db -> select('u.fname,u.lname,u.mobileno,u.email,u.password,u.id,u.role,group_concat(distinct(l.location)) as location,group_concat(distinct(p.process_name)) as process_name,u.role_name,empId,u.status');
		$this -> db -> from('lmsuser u');
		$this -> db -> join('tbl_manager_process m', 'm.user_id=u.id','left');
		$this -> db -> join('tbl_location l', 'l.location_id=m.location_id','left');
		$this -> db -> join('tbl_process p', 'p.process_id=m.process_id','left');
		$this -> db -> where('u.id !=', '0');
		$name = $this -> input -> post('userName');
		if (isset($name)) {
		$this -> db -> where("CONCAT(u.fname, ' ', u.lname) LIKE '%$name%' ");
		}
		
		$this -> db -> where('u.role !=', 1);
	
		if($this->input->get('id')=='' && $name==''){
		$this -> db -> limit($rec_limit, $offset);
			}
		$this -> db -> group_by('u.id');
		$query1 = $this -> db -> get();
	//	echo $this->db->last_query();
		return $query1 -> result();
		
	}
//For select all Process
	public function select_process() {
	$userId=$this->input->post('user_id');
	$order=" FIELD(process_id,'6', '7', '1', '4', '5')";
	$query1 = $this->db->query("select p.process_id ,p.process_name 
									from lmsuser l 
									Left join tbl_manager_process mp on mp.user_id=l.id 
									Left join tbl_process p on p.process_id=mp.process_id
									where mp.user_id='$userId' group by p.process_id order by FIELD(p.process_id, '6', '7', '8','1', '4', '5')");
		return $query1 -> result();

	}
// Select Location using process Id
	public function select_map_location($id) {
		$userId=$this->input->post('user_id');
		$this -> db -> select('m.location_id,m.process_id,l.location');
		$this -> db -> from('tbl_manager_process m');
		$this->db->join('tbl_location l','l.location_id=m.location_id');
		if ($id!='') {
			$this -> db -> where('process_id', $id);
		}
		if($userId!=1){
		$this -> db -> where('user_id', $_SESSION['user_id']);
		}
		$this->db->group_by('l.location_id');
		$this->db->where('m.status !=','-1');
		$this->db->where('l.location_status !=','Deactive');
		$this->db->order_by('l.location','asc');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}
			public function count_lmsuser() {
		$process_array=array();				
		$location_array=array();		
		$process=$this->select_process();				
		foreach ($process as $row) {
			array_push($process_array,$row->process_id);
			$query=$this->select_map_location($row->process_id);
				foreach ($query as $row) {
					array_push($location_array,$row->location_id);
				}
			
		}
		$this -> db -> select('count(id) as lmscount');
		$this -> db -> from('lmsuser u');
		$this -> db -> join('tbl_manager_process m', 'm.user_id=u.id','left');
		$this -> db -> join('tbl_location l', 'l.location_id=m.location_id','left');
		$this -> db -> join('tbl_process p', 'p.process_id=m.process_id','left');
		$this -> db -> where('u.id !=', '0');
		$name = $this -> input -> post('userName');
		if (isset($name)) {
		$this -> db -> where("CONCAT(u.fname, ' ', u.lname) LIKE '%$name%' ");
		}
		
		$this -> db -> where('u.role !=', 1);
	
		
		$query1 = $this -> db -> get();
		return $query1 -> result();

	}
			function insert_resolved_escalation_detail()
{
	  $enq_id = $this -> input -> post('booking_id');    
     //escalation
    $resolved_escalation_type = $this->input->post('resolved_escalation_type');
    $resolved_escalation_remark = $this->input->post('resolved_escalation_remark');
    if($resolved_escalation_type=='Escalation Level 1')
    {
        $resolved_esc_level="esc_level1_resolved ='Yes'";
        $resolved_esc_remark="esc_level1_resolved_remark= '".$resolved_escalation_remark."'";
    }
    elseif($resolved_escalation_type=='Escalation Level 2')
    {
        $resolved_esc_level="esc_level2_resolved ='Yes'";
        $resolved_esc_remark="esc_level2_resolved_remark= '".$resolved_escalation_remark."'";
    }
    elseif ($resolved_escalation_type=='Escalation Level 3') {
        $resolved_esc_level="esc_level3_resolved ='Yes'";
        $resolved_esc_remark="esc_level3_resolved_remark= '".$resolved_escalation_remark."'";
    }
    else {
        $resolved_esc_level='';
        $resolved_esc_remark='';
    }
    $update1 = $this -> db -> query("update lead_master set ".$resolved_esc_level.",".$resolved_esc_remark." where enq_id='$enq_id'");
   
	
	if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Data successfully Inserted.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}		
}
}
?>
