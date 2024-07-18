<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Add_followup_service_model extends CI_model {
	function __construct() {
		parent::__construct();
		$this->process_id = $_SESSION['process_id'];
		$this -> location_id = $_SESSION['location_id'];
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');
		$this -> executive_array = array("4", "8", "10", "12", "14");
		$this -> all_array = array("2", "3", "8", "7", "9", "11", "13", "10", "12", "14");
		$this -> tl_array = array("2", "5", "7", "9", "11", "13");
		$this -> tl_list = '("2","5", "7", "9", "11", "13")';
	}

	public function select_lead($enq_id) {
		$this -> db -> select('l.enq_id,l.email,l.name,l.contact_no,l.feedbackStatus,l.nextAction,l.transfer_process,l.address,l.cse_followup_id,l.service_center,l.model_id,l.reg_no,l.km,l.service_type,l.pick_up_date,l.pickup_required,f.eagerness,l.mcp_offers,l.mcp_type,l.pickup_time_slot,l.assign_to_dse_tl');
		$this -> db -> from('lead_master_all l');
		$this->db->join('lead_followup_all f','f.id=l.cse_followup_id','left');
		//$this -> db -> where('process', 'Finance');
		$this -> db -> where('l.enq_id', $enq_id);
		
		$query = $this -> db -> get();
	//	echo $this->db->last_query();
		return $query -> result();

	}
	//Select process
	function process() 
	{
		//$this->db->distinct();
		$this->db->select('*');
		$this->db->from('tbl_process');
		$this -> db -> where('process_id!=', '8');
			$this -> db -> where('process_id!=', '9');
		$query = $this->db->get();
		return $query->result();
	
		
	}	
	//Select Location
	public function select_location() {
		$this -> db -> select('p.location_id,l.location');
	//	$this -> db -> from('tbl_location');
		$this -> db -> from('tbl_map_process p');
		$this->db->join('tbl_location l','l.location_id=p.location_id');
		$this->db->where('p.status !=','-1');
		$this->db->where('l.location_status !=','Deactive');
		$this -> db -> where('p.process_id', $this->process_id);
		$query = $this -> db -> get();
			
		return $query -> result();
	}
// Transfer lead location
	function select_transfer_location($tprocess) 
	{
			$this -> db -> select('l.*');
		$this -> db -> from('tbl_location l');
		$this->db->join('tbl_map_process p','p.location_id=l.location_id');
		$this->db->where('process_id',$tprocess);
		$this->db->where('p.status !=','-1');
		$this->db->where('l.location_status !=','Deactive');
		$query = $this->db->get();
		return $query->result();
	
	
	
		
	}
		//Select lms user
	function lmsuser($location,$tprocess) {
		$toLocation = $location;
		$cctprocess=explode("#",$tprocess);
			$tprocess=$cctprocess[0];
			$tprocess_name=$cctprocess[1];
		 $from_user_role = $this -> role;
		$fromUser=$this->user_id;
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser l');
		$this -> db -> join('tbl_manager_process u', 'u.user_id=l.id');
		$this -> db -> join('tbl_rights r', 'r.user_id=l.id');
		$this -> db -> join('tbl_location l1', 'l1.location_id=u.location_id', 'left');
		$this -> db -> where('r.form_name', 'Calling Notification');
		$this -> db -> where('r.view', '1');
		/*if($from_user_role==3)*/
		if($tprocess==$this->process_id)
		{

		if ($from_user_role == 1 || $from_user_role == 2 || $from_user_role == 3) {
				//echo"1";
			$tl_array = array("2", "3", "5","4", "7", "9", "11", "13","15");
			$this -> db -> where_in('role', $tl_array);
			//$k="(role=3 or role IN ('2','5', '7', '9', '11', '13'))";
			//$this -> db -> where($k);
		} elseif (in_array($from_user_role, $this -> tl_array)) {
			$q = $this -> db -> query('select dse_id from tbl_mapdse where tl_id="' . $fromUser . '"') -> result();

			$c = count($q);
			$t = ' ( ';
			if (count($q) > 0) {

				for ($i = 0; $i < $c; $i++) {

					$t = $t . "id = " . $q[$i] -> dse_id . " or ";

				}

			}
			$t = $t . "role in" . $this -> tl_list;
			$st = $t . ')';

			$this -> db -> where($st);
		} elseif (in_array($from_user_role, $this -> executive_array)) {
				//echo"2";
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
				$t = $t . "role in" . $this -> tl_list;
				$st = $t . ')';

				$this -> db -> where($st);

			} else {
				$t = $t . "role in" . $this -> tl_list;
			}
		}
		}
else {
	if ($from_user_role == 1 || $from_user_role == 2 || $from_user_role == 3) {
			//echo"3";
				
			$tl_array = array("2", "3","5","4", "7", "9", "11", "13","15");
			$this -> db -> where_in('role', $tl_array);
			//$k="(role=3 or role IN ('2','5', '7', '9', '11', '13'))";
			//$this -> db -> where($k);
		} elseif (in_array($from_user_role, $this -> tl_array)) {
			
			$t = ' ( ';
			
			$t = $t . "role in" . $this -> tl_list;
			$st = $t . ')';

			$this -> db -> where($st);
		} elseif (in_array($from_user_role, $this -> executive_array)) {
			//	echo"4";
			$q1 = $this -> db -> query('select tl_id from tbl_mapdse where dse_id="' . $fromUser . '"') -> result();
			
			if (count($q1) > 0) {
				$t = ' ( ';
				
				$t = $t . "role in" . $this -> tl_list;
				$st = $t . ')';

				$this -> db -> where($st);

			} else {
				$t = $t . "role in" . $this -> tl_list;
				$this -> db -> where($t);
			}
		}
}
		//$this -> db -> where_in('role',$this->tl_array);
		$this -> db -> where('l.status', '1');
		$this -> db -> where('role !=', '1');
		$this->db->where('l.id !=',$this->user_id);
		$this -> db -> where('u.process_id', $tprocess);
		$this -> db -> where('l1.location', $toLocation);
		$this -> db -> group_by("l.id");
		$this -> db -> order_by("fname", "asc");
		$query = $this -> db -> get();
		
		echo $this -> db -> last_query();
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

	public function select_followup_lead($enq_id)
	{
		$this -> db -> select('u.fname,u.lname,f.date,f.nextfollowupdate,f.feedbackStatus,f.nextAction,f.comment');
		$this -> db -> from('lead_followup_all f');
		$this->db->join('lmsuser u','u.id=f.assign_to');
		$this -> db -> where('leadid', $enq_id);
		$query = $this -> db -> get();
		return $query -> result();
	}
	
	
	public function select_model()
	{
		$this -> db -> select('*');
		$this -> db -> from('make_models');
		$this->db->where('make_id','1');
		$this->db->where('status','1');
		
		$query = $this -> db -> get();
		return $query -> result();
	}
	public function select_feedback_status()
	{
		$this -> db -> select('*');
		$this -> db -> from('tbl_feedback_status');
		$this->db->where('fstatus!=','Deactive');
		$this->db->where('process_id','4');
		
		$query = $this -> db -> get();
		return $query -> result();
	}
	//Select Nextaction Status
	function next_action_status() {
		
		//$this->db->distinct();
		$this->db->select('nextActionName');
		$this->db->from('tbl_nextaction');
		$this -> db -> where('nextActionstatus!=', 'Deactive');
		$this->db->where('process_id','4');
		$query = $this->db->get();
		return $query->result();
	
		
	}
	public function select_next_action($feedbackStatus)
	{
	$this->db->select('nextActionName');
	$this->db->from('tbl_mapNextAction');
	$this->db->where('feedbackStatusName',$feedbackStatus);
	$this->db->where('map_next_to_feed_status!=','Deactive');
	$this->db->where('process_id','4');
	
	$query=$this->db->get();
	return $query->result();
		
	}
	
	public function insert_followup()
	{
	$assign_to=$_SESSION['user_id'];
	$enq_id=$this->input->post('booking_id');
	$email=$this->input->post('email');
	$feedbackstatus=$this->input->post('feedbackstatus');
	$nextAction=$this->input->post('nextAction');
	$eagerness=$this->input->post('eagerness');
	$address=$this->input->post('address');
	$followupdate=$this->input->post('followupdate');
	$comment=$this->input->post('comment');
	echo '<br>';
	$service_center=$this->input->post('service_center');
	$car_model=$this->input->post('car_model');
	$registration_no=$this->input->post('registration_no');
	$km=$this->input->post('km');
	$service_type=$this->input->post('service_type');
	$pick_up=$this->input->post('pick_up');
	$pickup_date=$this->input->post('pickup_date');
	$mcp_offers=$this->input->post('mcp_offers');
	$mcp_type=$this->input->post('mcp_type');
	$pickup_time_slot=$this->input->post('pickup_time_slot');
	$today=date('Y-m-d');
	
	$today1 = date("Y-m-d");
		$time = date("h:i:s A");
		$enq_id = $this -> input -> post('booking_id');
		//echo "enq--id--".$enq_id;
		$old_data=$this->db->query("select *  from lead_master_all where enq_id='".$enq_id."'")->result();
		echo $this->db->last_query();
		//Basic Followup
		$name=$old_data[0]->name;
		$contact_no=$old_data[0]->contact_no;
		$lead_source=$old_data[0]->lead_source;
		$enquiry_for=$old_data[0]->enquiry_for;
		$assign_to_telecaller = $_SESSION['user_id'];
		$alternate_contact=$this->input->post('alternate_contact');
		
		//Insert in lead_followup
			$checktime=date("h:i");
		$checkfollowup=$this->db->query("select id from lead_followup where leadid='$enq_id' and assign_to='$assign_to_telecaller' and date='$today1'
		and comment ='$comment' and contactibility='$contactibility' and created_time like '$checktime%'")->result();
	    if(count($checkfollowup)< 1)
		{
		
		
				 
	$insert_query=$this->db->query("INSERT INTO `lead_followup_all`
	(`leadid`, `assign_to`,  `nextfollowupdate`, `comment`, `eagerness`,  `feedbackStatus`, `nextAction`, `date`, `pick_up_date`,`pick_up_required`,`service_type`) 
	VALUES ('$enq_id','$assign_to','$followupdate','$comment','$eagerness','$feedbackstatus','$nextAction','$today','$pickup_date','$pick_up','$service_type')");
	$followup_id=$this->db->insert_id();
	$update_query=$this->db->query("update lead_master_all set cse_followup_id='$followup_id', email='$email',feedbackStatus='$feedbackstatus',nextAction='$nextAction',address='$address',
	service_center='$service_center',model_id='$car_model',reg_no='$registration_no',service_type='$service_type',pickup_required='$pick_up',pick_up_date='$pickup_date',km='$km',mcp_offers='$mcp_offers',mcp_type='$mcp_type',pickup_time_slot='$pickup_time_slot' where enq_id='$enq_id'");
	
		
	  		//Transfer Lead
		 $assign_by = $_SESSION['user_id'];
		 $assign = $this -> input -> post('transfer_assign');
		 $tlocation = $this -> input -> post('tlocation');
		 $transfer_reason = $this -> input -> post('transfer_reason');
		 $ctprocess=$this->input->post('tprocess');
			
			
		if ($ctprocess != '') {
				
				
			$cctprocess=explode("#",$ctprocess);
			$tprocess=$cctprocess[0];
			$tprocess_name=$cctprocess[1];
			
			$transfer_array=array();
			if($old_data[0]->transfer_process!=''){
				$old_tprocess=json_decode($old_data[0]->transfer_process);
				array_push($transfer_array,$tprocess);
				$transfer_array=array_merge($transfer_array,$old_tprocess);
				
			}else{
				array_push($transfer_array,$tprocess);
			}
			
			$transfer_array=json_encode($transfer_array);
			$process_id=$_SESSION['process_id'];
			$lead_status=$this->input->post('lead_status');
			
			$select_process=$this->db->query("select process_name from tbl_process where process_id='$tprocess'")->result();
			$process_name=$select_process[0]->process_name;
			
			if($assign !=''){
			// Assign User Details
			$get_user_role=$this->db->query("select role from lmsuser where id='$assign'")->result();
			echo $get_user_role[0]->role ;
			//Assign CSE To CSE
			if(($get_user_role[0]->role == 2 or $get_user_role[0]->role==3) && ($_SESSION['role']==3 or $_SESSION['role']==2)){
				$assign_user='assign_to_cse='.$assign;
				$assign_date='assign_to_cse_date';
				$assign_time='assign_to_cse_time';
				$user_followup_id='cse_followup_id = 0';
				$assign_by_cse='assign_by_cse='.$assign_by.',';
			}
			//Assign CSE To DSE TL
			if($get_user_role[0]->role == 5 && ($_SESSION['role']==2 || $_SESSION['role']==3)){
				$assign_user='assign_to_dse_tl='.$assign;
				$assign_date='assign_to_dse_tl_date';
				$assign_time='assign_to_dse_tl_time';
				//$user_followup_id='dse_followup_id = 0';
				$assign_by_cse='assign_by_cse='.$assign_by.',';
				$user_followup_id='dse_followup_id = 0,assign_to_dse=0,assign_to_dse_date="0000-00-00"';
			}
			//Assign CSE To DSE 
			if($get_user_role[0]->role == 4 && ($_SESSION['role']==2 || $_SESSION['role']==3)){
				$get_dse_tl=$this->db->query("select tl_id from tbl_mapdse where dse_id='$assign'")->result();
				if(count($get_dse_tl)>0){
					$tl_id=$get_dse_tl[0]->tl_id;
				}else{
					$tl_id=0;
				}
				$assign_user='assign_to_dse_tl='.$tl_id.',assign_to_dse='.$assign;
				$assign_date='assign_to_dse_date="'.$today1.'",assign_to_dse_tl_date';
				$assign_time='assign_to_dse_time="'.$time.'",assign_to_dse_tl_time';
				$user_followup_id='dse_followup_id = 0';
				$assign_by_cse='assign_by_cse='.$assign_by.',';
			}
			//Assign  DSE To DSE TL
			if($get_user_role[0]->role == 5 && $_SESSION['role']==4 ){
				$assign_user='assign_to_dse_tl='.$assign;
				$assign_date='assign_to_dse_tl_date';
				$assign_time='assign_to_dse_tl_time';
				$user_followup_id='dse_followup_id = 0,assign_to_dse=0,assign_to_dse_date="0000-00-00"';
				//$user_followup_id='dse_followup_id = 0';
				$assign_by_cse='';
			}
			//Assign DSE TL TO DSE 
			if($get_user_role[0]->role == 4 &&  $_SESSION['role']==5){
				$assign_user='assign_to_dse='.$assign;
				$assign_date='assign_to_dse_date';
				$assign_time='assign_to_dse_time';
				$user_followup_id='dse_followup_id = 0';
				$assign_by_cse='';
			}
			//Assign DSE TL To DSE TL
			if($get_user_role[0]->role == 5 &&  $_SESSION['role']==5){
				$assign_user='assign_to_dse_tl='.$assign;
				$assign_date='assign_to_dse_tl_date';
				$assign_time='assign_to_dse_tl_time';
				//$user_followup_id='dse_followup_id = 0';
				$user_followup_id='dse_followup_id = 0,assign_to_dse=0,assign_to_dse_date="0000-00-00"';
				$assign_by_cse='';
			}
			
			
			//Assign DSE  To DSE 
			if($get_user_role[0]->role == 4 &&  $_SESSION['role']==4){
				$assign_user='assign_to_dse='.$assign;
				$assign_date='assign_to_dse_date';
				$assign_time='assign_to_dse_time';
				$user_followup_id='dse_followup_id = 0';
				$assign_by_cse='';
			}

				//Assign Evaluation CSE To DSE TL
			if($get_user_role[0]->role == 15 && ($_SESSION['role']==2 || $_SESSION['role']==3)){
				$assign_user='assign_to_cse='.$old_data[0]->assign_to_cse.',assign_to_e_tl='.$assign;
				$assign_date='assign_to_cse_date="'.$old_data[0]->assign_to_cse_date.'",assign_to_e_tl_date';
				$assign_time='assign_to_cse_time="'.$old_data[0]->assign_to_cse_time.'",assign_to_e_tl_time';
				//$user_followup_id='dse_followup_id = 0';
				$assign_by_cse='assign_by_cse='.$assign_by.',';
				$user_followup_id='exe_followup_id = 0,assign_to_e_exe=0,assign_to_e_exe_date="0000-00-00"';
			}
			//Assign Evaluation CSE To DSE 
			if($get_user_role[0]->role == 16 && ($_SESSION['role']==2 || $_SESSION['role']==3)){
				$get_dse_tl=$this->db->query("select tl_id from tbl_mapdse where dse_id='$assign'")->result();
				if(count($get_dse_tl)>0){
					$tl_id=$get_dse_tl[0]->tl_id;
				}else{
					$tl_id=0;
				}
				$assign_user='assign_to_cse='.$old_data[0]->assign_to_cse.',assign_to_e_tl='.$tl_id.',assign_to_e_exe ='.$assign;
				$assign_date='assign_to_cse_date="'.$old_data[0]->assign_to_cse_date.'",assign_to_e_exe_date="'.$today1.'",assign_to_e_tl_date';
				$assign_time='assign_to_cse_time="'.$old_data[0]->assign_to_cse_time.'",assign_to_e_exe_time ="'.$time.'",assign_to_e_tl_time';
				$user_followup_id='exe_followup_id  = 0';
				$assign_by_cse='assign_by_cse='.$assign_by.',';
			}
			

			if($old_data[0]->assign_by_cse_tl==0){
				$assign_by_cse_tl=$_SESSION['user_id'];
			}else{
				$assign_by_cse_tl=$old_data[0]->assign_by_cse_tl;
			}
			}
			
			if($tprocess=='4'){
			$checkLead =$this->db->query("select enq_id from lead_master_all where contact_no='$contact_no' and process='$process_name' and nextAction!='Close'")->result();
			echo $this->db->last_query();
			if(count($checkLead)>0){
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Already exists in transferred process ...!</strong>');
	
			}else{
			if($lead_status == 'Close'){
				$updated_field="transfer_process='$transfer_array',feedbackStatus='Lead Transfer To Other Process',nextAction ='Close'";
				$update_followup=$this->db->query("UPDATE `lead_followup` SET `feedbackStatus`='Lead Transfer To Other Process',`nextAction`='Close',`nextfollowupdate`='0000-00-00',`nextfollowuptime`='' WHERE id='$followup_id'");
			
			}else{
				$updated_field="transfer_process='$transfer_array'";
			}
			 $update1 = $this->db->query("update lead_master_all set ".$updated_field." where enq_id='$enq_id'");	
				echo $this->db->last_query();
			
			$insert_new_lead =$this->db->query("insert into lead_master_all(process,name,contact_no,email,lead_source,enquiry_for,created_date) values('$process_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today1')");
			$new_enq_id = $this->db->insert_id();
			echo $this->db->last_query();
			echo "update----".$update1;
			
			 $transfer_other_process=$this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead`,`from_process`, `to_process`, `created_date`) 
			VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");
			if($assign !=''){
				$insertQuery =$this->db->query ('INSERT INTO request_to_lead_transfer_all( `lead_id` , `assign_to` , `assign_by` ,`transfer_reason`, `location` , `created_date` , `created_time` ,status)  VALUES("' . $new_enq_id . '","' . $assign . '","' . $assign_by . '","' . $transfer_reason . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
				echo $insertQuery;
				$transfer_id=$this->db->insert_id();
			$update1 =$this->db->query("update lead_master_all set transfer_id='$transfer_id',assign_by_cse_tl='$assign_by_cse_tl',".$user_followup_id.",".$assign_user.",".$assign_by_cse.$assign_date."='$today1',".$assign_time."='$time' where enq_id='$new_enq_id'");
			}
			if($update1){
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Transferred Successfully...!</strong>');
			} else {
			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Not Transferred Successfully ...!</strong>');
			}	
			}
			}
			
			
			
			elseif($tprocess=='1'){
				$checkLead =$this->db->query("select enq_id from lead_master_all where contact_no='$contact_no' and process='$process_name' and nextAction!='Close'")->result();
			echo $this->db->last_query();
			if(count($checkLead)>0){
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Already exists in transferred process ...!</strong>');
	
			}else{
			if($lead_status == 'Close'){
				$updated_field="transfer_process='$transfer_array',feedbackStatus='Lead Transfer To Other Process',nextAction ='Close'";
				$update_followup=$this->db->query("UPDATE `lead_followup` SET `feedbackStatus`='Lead Transfer To Other Process',`nextAction`='Close',`nextfollowupdate`='0000-00-00',`nextfollowuptime`='' WHERE id='$followup_id'");
			
			}else{
				$updated_field="transfer_process='$transfer_array'";
			}
			 $update1 = $this->db->query("update lead_master_all set ".$updated_field." where enq_id='$enq_id'");	
			
			
			$insert_new_lead =$this->db->query("insert into lead_master_all(process,name,contact_no,email,lead_source,enquiry_for,created_date) values('$process_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today1')");
			$new_enq_id = $this->db->insert_id();
			echo $this->db->last_query();
			
			 $transfer_other_process=$this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead`,`from_process`, `to_process`, `created_date`) 
			VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");
			if($assign !=''){
				$insertQuery =$this->db->query ('INSERT INTO request_to_lead_transfer_all( `lead_id` , `assign_to` , `assign_by` ,`transfer_reason`, `location` , `created_date` , `created_time` ,status)  VALUES("' . $new_enq_id . '","' . $assign . '","' . $assign_by . '","' . $transfer_reason . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
				echo $insertQuery;
				$transfer_id=$this->db->insert_id();
			$update1 =$this->db->query("update lead_master_all set transfer_id='$transfer_id',assign_by_cse_tl='$assign_by_cse_tl',".$user_followup_id.",".$assign_user.",".$assign_by_cse.$assign_date."='$today1',".$assign_time."='$time' where enq_id='$new_enq_id'");
			}
			if($update1){
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Transferred Successfully...!</strong>');
			} else {
			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Not Transferred Successfully ...!</strong>');
			}	
			}
			}
			
							
			elseif($tprocess == '7'){
			$checkLead =$this->db->query("select enq_id from lead_master where contact_no='$contact_no' and process='$process_name' and nextAction!='Close'")->result();
			echo $this->db->last_query();
			if(count($checkLead)>0){
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Already exists in transferred process ...!</strong>');
	
			}else{
			if($lead_status == 'Close'){
			    echo "transferarray---".$transfer_array;
				$updated_field="transfer_process='$transfer_array',feedbackStatus='Lead Transfer To Other Process',nextAction ='Close'";
					echo $this->db->last_query();
				$update_followup=$this->db->query("UPDATE `lead_followup` SET `feedbackStatus`='Lead Transfer To Other Process',`nextAction`='Close',`nextfollowupdate`='0000-00-00',`nextfollowuptime`='' WHERE id='$followup_id'");
					echo $this->db->last_query();
			
			
			}else{
				$updated_field="transfer_process='$transfer_array'";
				echo "hiii---".$updated_field;
			}
			 $update1 = $this->db->query("update lead_master_all set ".$updated_field." where enq_id='$enq_id'");	
			 	echo $this->db->last_query();
			
			
			$insert_new_lead =$this->db->query("insert into lead_master(process,name,contact_no,email,lead_source,enquiry_for,created_date) values('$process_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today1')");
			$new_enq_id = $this->db->insert_id();
			echo $this->db->last_query();
			
			 $transfer_other_process=$this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead`,`from_process`, `to_process`, `created_date`) 
			VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");
			if($assign !=''){
				$insertQuery =$this->db->query ('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` ,`transfer_reason`, `location` , `created_date` , `created_time` ,status)  VALUES("' . $new_enq_id . '","' . $assign . '","' . $assign_by . '","' . $transfer_reason . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
				echo $insertQuery;
				$transfer_id=$this->db->insert_id();
			$update1 =$this->db->query("update lead_master set transfer_id='$transfer_id',assign_by_cse_tl='$assign_by_cse_tl',".$user_followup_id.",".$assign_user.",".$assign_by_cse.$assign_date."='$today1',".$assign_time."='$time' where enq_id='$new_enq_id'");
				echo $this->db->last_query();
			//Insert in lead_followup
		$insert = $this -> db -> query("INSERT INTO `lead_followup`(`leadid`,  `comment`, `nextfollowupdate`, `nextfollowuptime`, `assign_to`, `date` ,`created_time`,`feedbackStatus`,`nextAction`,web) 
		VALUES ('$new_enq_id','Lead Transfer','$today1','$time','$assign_by','$today1','$time','Interested','Follow-up','1')") or die(mysql_error());
			echo $this->db->last_query();
			}
			if($update1){
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Transferred Successfully...!</strong>');
			} else {
			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Not Transferred Successfully ...!</strong>');
			}	
			}
				

			
			}
			
			elseif($tprocess == '6'){
			
			$checkLead =$this->db->query("select enq_id from lead_master where contact_no='$contact_no' and process='$process_name' and nextAction!='Close'")->result();
			echo $this->db->last_query();
			if(count($checkLead)>0){
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Already exists in transferred process ...!</strong>');
	
			}else{
			if($lead_status == 'Close'){
				$updated_field="transfer_process='$transfer_array',feedbackStatus='Lead Transfer To Other Process',nextAction ='Close'";
				$update_followup=$this->db->query("UPDATE `lead_followup` SET `feedbackStatus`='Lead Transfer To Other Process',`nextAction`='Close',`nextfollowupdate`='0000-00-00',`nextfollowuptime`='' WHERE id='$followup_id'");
			
			}else{
				$updated_field="transfer_process='$transfer_array'";
			}
			 $update1 = $this->db->query("update lead_master_all set ".$updated_field." where enq_id='$enq_id'");	
			echo $this->db->last_query();
			
			$insert_new_lead =$this->db->query("insert into lead_master(process,name,contact_no,email,lead_source,enquiry_for,created_date) values('$process_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today1')");
			$new_enq_id = $this->db->insert_id();
		
			echo $this->db->last_query();
			echo "lead_transfer--".$update1;
			
			 $transfer_other_process=$this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead`,`from_process`, `to_process`, `created_date`) 
			VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");
			if($assign !=''){
				$insertQuery =$this->db->query ('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` ,`transfer_reason`, `location` , `created_date` , `created_time` ,status)  VALUES("' . $new_enq_id . '","' . $assign . '","' . $assign_by . '","' . $transfer_reason . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
				echo $insertQuery;
				$transfer_id=$this->db->insert_id();
			$update1 =$this->db->query("update lead_master set transfer_id='$transfer_id',assign_by_cse_tl='$assign_by_cse_tl',".$user_followup_id.",".$assign_user.",".$assign_by_cse.$assign_date."='$today1',".$assign_time."='$time' where enq_id='$new_enq_id'");
			}
			if($update1){
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Transferred Successfully...!</strong>');
			} else {
			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Not Transferred Successfully ...!</strong>');
			}	
			}
				

			}
				elseif($tprocess == '8'){
			
			$checkLead =$this->db->query("select enq_id from  lead_master_evaluation where contact_no='$contact_no' and evaluation='Yes' and nextAction!='Close'")->result();
			echo $this->db->last_query();
			if(count($checkLead)>0){
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Already exists in transferred process ...!</strong>');
	
			}else{
			if($lead_status == 'Close'){
				$updated_field="transfer_process='$transfer_array',feedbackStatus='Lead Transfer To Other Process',nextAction ='Close'";
				$update_followup=$this->db->query("UPDATE `lead_followup` SET `feedbackStatus`='Lead Transfer To Other Process',`nextAction`='Close',`nextfollowupdate`='0000-00-00',`nextfollowuptime`='' WHERE id='$followup_id'");
			
			
			}else{
				$updated_field="transfer_process='$transfer_array'";
			}
			 $update1 = $this->db->query("update lead_master set ".$updated_field." where enq_id='$enq_id'");	
			
			
			 $insert_new_lead =$this->db->query("insert into lead_master_evaluation(process,name,contact_no,email,lead_source,enquiry_for,created_date,evaluation) values('$process_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today1','Yes')");
			$new_enq_id = $this->db->insert_id();
			echo $this->db->last_query();
			 $transfer_other_process=$this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead_evaluation`,`from_process`, `to_process`, `created_date`) VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");
			 echo $this->db->last_query();
			
			if($assign !=''){
				$insertQuery =$this->db->query ('INSERT INTO request_to_lead_transfer_evaluation( `lead_id` , `assign_to` , `assign_by` , `location` , `created_date` , `created_time` ,status)  VALUES("' . $new_enq_id . '","' . $assign . '","' . $assign_by . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
				echo $insertQuery;
				$transfer_id=$this->db->insert_id();
				if($get_user_role[0]->role!=3 ){
						//Insert in lead_followup
		$insert = $this -> db -> query("INSERT INTO `lead_followup_evaluation`(`leadid`,  `comment`, `nextfollowupdate`, `nextfollowuptime`, `assign_to`, `date` ,`created_time`,`feedbackStatus`,`nextAction`,web) 
		VALUES ('$new_enq_id','Lead Transfer','$today1','$time','$assign_by','$today1','$time','Interested','Follow-up','1')") or die(mysql_error());
		$new_followup_id=$this->db->insert_id();
			
			$tfolloup_details=" cse_followup_id=".$new_followup_id.",feedbackStatus='Interested',nextAction='Follow-up',";
		
		}else{
			$tfolloup_details='';
		}
			$update1 =$this->db->query("update lead_master_evaluation set".$tfolloup_details." transfer_id='$transfer_id',assign_by_cse_tl='$assign_by_cse_tl',".$user_followup_id.",".$assign_user.",".$assign_by_cse.$assign_date."='$today1',".$assign_time."='$time' where enq_id='$new_enq_id'");
		echo $this->db->last_query();
			}
			if($update1){
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Transferred Successfully...!</strong>');
			} else {
			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Not Transferred Successfully ...!</strong>');
			}	
			}
				
			
			}
			else{
				// check lead already avaliable in that process or not
				$checkLead =$this->db->query("select enq_id from lead_master_all where contact_no='$contact_no' and process='$process_name' and nextAction!='Close'")->result();
			if(count($checkLead)>0){
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Already exists in transferred process ...!</strong>');
	
			}else{
					
				//check old lead want to close or not
					if($lead_status == 'Close'){
						$updated_field="transfer_process='$transfer_array',feedbackStatus='Lead Transfer To Other Process',nextAction ='Close'";
						$update_followup=$this->db->query("UPDATE `lead_followup` SET `feedbackStatus`='Lead Transfer To Other Process',`nextAction`='Close',`nextfollowupdate`='0000-00-00',`nextfollowuptime`='' WHERE id='$followup_id'");
			
			
			}else{
				$updated_field="transfer_process='$transfer_array'";
			}
			 $update1 = $this->db->query("update lead_master set ".$updated_field." where enq_id='$enq_id'");	
			
			// Insert new lead in lead master
			$insert_new_lead = $this -> db -> query("insert into lead_master_all(process,name,contact_no,email,lead_source,enquiry_for,created_date) values('$process_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today1')");
			$new_enq_id = $this->db->insert_id();
			
			//Lead mapping 
			$transfer_other_process=$this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead_all`,`from_process`, `to_process`, `created_date`) 
			VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");
			if($update1){
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Transferred Successfully...!</strong>');
			} else {
			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Not Transferred Successfully ...!</strong>');
			}	
			
}
			
			}	
		}
		}
		 
		 
	
		else{
				// check lead already avaliable in that process or not
				$checkLead =$this->db->query("select enq_id from lead_master_all where contact_no='$contact_no' and process='$process_name' and nextAction!='Close'")->result();
		
			if(count($checkLead)>0){
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Already exists in transferred process ...!</strong>');
			
			}else{
					
				//check old lead want to close or not
					if($lead_status == 'Close'){
						$updated_field="transfer_process='$transfer_array',feedbackStatus='Lead Transfer To Other Process',nextAction ='Close'";
				$update_followup=$this->db->query("UPDATE `lead_followup` SET `feedbackStatus`='Lead Transfer To Other Process',`nextAction`='Close',`nextfollowupdate`='0000-00-00',`nextfollowuptime`='' WHERE id='$followup_id'");
			
			
			}else{
				$updated_field="transfer_process='$transfer_array'";
			}
			 $update1 = $this->db->query("update lead_master set ".$updated_field." where enq_id='$enq_id'");	
			
			// Insert new lead in lead master
			$insert_new_lead = $this -> db -> query("insert into lead_master_all(process,name,contact_no,email,lead_source,enquiry_for,created_date) values('$process_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today1')");
			$new_enq_id = $this->db->insert_id();
			
			//Lead mapping 
			$transfer_other_process=$this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead_all`,`from_process`, `to_process`, `created_date`) 
			VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");
if($update1){
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Transferred Successfully...!</strong>');
			} else {
			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Not Transferred Successfully ...!</strong>');
			}				
}
			
			}	
}
}
?>
