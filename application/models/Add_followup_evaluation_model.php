<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Add_followup_evaluation_model extends CI_model {
	function __construct() {
		parent::__construct();
		$this->process_id = $_SESSION['process_id'];
		$this -> location_id = $_SESSION['location_id'];
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');
		$this -> executive_array = array("4", "8", "10", "12", "14","16");
		$this -> all_array = array("2", "3", "8", "7", "9", "11", "13", "10", "12", "14");
		$this -> tl_array = array("2", "5", "7", "9", "11", "13","15");
		$this -> tl_list = '("2","5", "7", "9", "11", "13","15")';
	}

	//Select feedbackstatus
	function select_feedback_status() {
		
		//$this->db->distinct();
		$this->db->select('feedbackStatusName');
		$this->db->from('tbl_feedback_status');
		$this->db->where('process_id',$this->process_id);
		$this -> db -> where('fstatus!=', 'Deactive');
		$query = $this->db->get();
		return $query->result();
		
	}

	
	//Map Nextaction and Feedbackstatus
	public function select_next_action()
	{
		$feedback=$this->input->post('feedback');
		$this->db->select('feedbackStatusName,nextActionName');
		$this->db->from('tbl_mapNextAction');
		$this->db->where('feedbackStatusName',$feedback);
		$this->db->where('map_next_to_feed_status!=','Deactive');
		$this->db->where('process_id',$_SESSION['process_id']);
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	//Select Nextaction Status
	function next_action_status() 
	{
		//$this->db->distinct();
		$this->db->select('nextActionName');
		$this->db->from('tbl_nextaction');
		$this->db->where('process_id',$this->process_id);
		$this -> db -> where('nextActionstatus!=', 'Deactive');
		$query = $this->db->get();
		return $query->result();	
	}
	//Select process
	function process() 
	{
		//$this->db->distinct();
		$this->db->select('*');
		$this->db->from('tbl_process');
		//$this -> db -> where('nextActionstatus!=', 'Deactive');
		$query = $this->db->get();
		return $query->result();	
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
	//	echo $this->db->last_query();
		return $query->result();
	
	
		
	}
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
			$tl_array = array("2", "3", "5","4", "7", "9", "11", "13","15","16");
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
		
	//	if($_SESSION['user_id']=='553'){
	//	echo $this -> db -> last_query();
	//	}
		return $query -> result();
		
	}

	//Select All Lead Data
	public function select_lead($enq_id) {
		$this -> db -> select('
		u.fname,u.lname,
		v.variant_id,v.variant_name,
		m.model_id as new_model_id,m.model_name as new_model_name,
		m1.model_name as old_model_name,
		l.enq_id,name,l.email,l.address,l.alternate_contact_no,l.contact_no,l.transfer_process	,l.comment,enquiry_for,l.created_date,l.created_time,l.location,l.days60_booking,l.buyer_type,l.color,l.km,l.manf_year,l.accidental_claim,l.fuel_type,l.color,l.evaluation_within_days,l.ownership,l.old_make,l.old_model,l.assign_to_e_tl,l.process,l.reg_no,l.quotated_price,l.expected_price,l.assign_to_e_tl ,l. 	assign_to_e_exe ,
		f.id as followup_id,f.date as c_date,f.contactibility,f.comment as f_comment,f.nextfollowupdate,f.nextfollowuptime,
		f.feedbackStatus,f.nextAction,f.appointment_type,f.appointment_status,f.appointment_date,f.appointment_time,l.customer_occupation,l.customer_designation,l.customer_corporate_name,l.interested_in_finance,l.interested_in_accessories,l.interested_in_insurance,l.interested_in_ew,l.esc_level1 ,l.esc_level1_remark,l.esc_level2 ,l.esc_level2_remark ,l.esc_level3 ,esc_level3_remark,esc_level1_resolved,esc_level2_resolved,esc_level3_resolved,esc_level1_resolved_remark,esc_level2_resolved_remark,esc_level3_resolved_remark   ');
		$this -> db -> from('lead_master_evaluation l');
		$this -> db -> join('make_models m', 'm.model_id=l.model_id', 'left');
		$this -> db -> join('model_variant v', 'v.variant_id=l.variant_id', 'left');
		$this -> db -> join('make_models m1', 'm1.model_id=l.old_model', 'left');
		if($_SESSION['role']=='3' || $_SESSION['role']=='2' || $_SESSION['role']=='1'){
		$this -> db -> join('lead_followup_evaluation f', 'f.id=l.cse_followup_id', 'left');
		}elseif($_SESSION['role']=='15' || $_SESSION['role']=='16' ){
		$this -> db -> join('lead_followup_evaluation f', 'f.id=l.exe_followup_id ', 'left');
		}
		else{
		$this -> db -> join('lead_followup_evaluation f', 'f.id=l.dse_followup_id', 'left');
		}
		$this -> db -> join('lmsuser u', 'u.id=f.assign_to','left');
		$this -> db -> where('l.enq_id', $enq_id);

		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}


	//Insert Followup
	function insert_followup() {

	
		$today1 = date("Y-m-d");
		$time = date("h:i:s A");
		$enq_id = $this -> input -> post('booking_id');
		echo $enq_id;
	$old_data=$this->db->query("select name,contact_no,lead_source,enquiry_for,email,address,model_id,variant_id,buy_status,buyer_type,assign_by_cse_tl,assign_to_cse,assign_to_cse_date,assign_to_cse_time,transfer_process ,evaluation_tracking_date 
	from lead_master_evaluation where enq_id='".$enq_id."'")->result();
		$name=$old_data[0]->name;
		$contact_no=$old_data[0]->contact_no;
		$lead_source=$old_data[0]->lead_source;
		$enquiry_for=$old_data[0]->enquiry_for;
		$assign_to_telecaller = $_SESSION['user_id'];
		
		$alternate_contact=$this->input->post('alternate_contact');
		
		if($this -> input -> post('activity')=='')
		{
			$activity='';
		}
		else {
			$activity = $this -> input -> post('activity');
		}
		
		$contactibility = $this -> input -> post('contactibility');
	/*	if($contactibility=='Connected' || $contactibility=='Not Connected')
		{
			$this->send_sms($contactibility,$contact_no);
		}*/
	
		$feedback = $this -> input -> post('feedback');
		$nextaction = $this -> input -> post('nextaction');
		
		$email = $this -> input -> post('email');
		if(!$email)
		{
			if($old_data[0]->email!=null)
			{
			 $email = $old_data[0]->email;
			}
		}
		
		$showroom_location = $this -> input -> post('showroom_location');
		 
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
		 
		$address1 = $this -> input -> post('address');
		if(!$address1)
		{
			
			 $address1 = $old_data[0]->address;
		
		}
		$address = addslashes($address1);

		$comment1 = $this -> input -> post('comment');
		 $comment = addslashes($comment1);

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
		 $registration_no=$this->input->post('registration_no');
		 $quotated_price=$this->input->post('quotated_price');
		$expected_price=$this->input->post('expected_price');
		 
		//Transfer Lead
		 $assign_by = $_SESSION['user_id'];
		 $assign = $this -> input -> post('transfer_assign');
		 $tlocation = $this -> input -> post('tlocation');
		 $transfer_reason = $this -> input -> post('transfer_reason');
	
		 
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
	
		//Insert in lead_followup
				$checktime=date("h:i");
		$checkfollowup=$this->db->query("select id from lead_followup_evaluation where leadid='$enq_id' and assign_to='$assign_to_telecaller' and date='$today1'
		and comment ='$comment' and contactibility='$contactibility' and created_time like '$checktime%'")->result();
		if(count($checkfollowup)< 1)
		{
		$insert = $this -> db -> query("INSERT INTO `lead_followup_evaluation`
		(`leadid`,`comment`, `nextfollowupdate`, `nextfollowuptime`, `assign_to`,`date`,`created_time`,`feedbackStatus`,`nextAction`,`contactibility`
		,`appointment_type`,`appointment_date`,`appointment_time`,`appointment_status`) 
		VALUES ('$enq_id','$comment','$followupdate','$followuptime','$assign_to_telecaller','$today1','$time','$feedback','$nextaction','$contactibility'
		,'$appointment_type','$appointment_date','$appointment_time','$appointment_status')") or die(mysql_error());
		
		$followup_id = $this->db->insert_id();
		
	
		if(!$appointment_type)
		{
			if(isset($old_data[0]->appointment_type)){
			$appointment_type = $old_data[0]->appointment_type;
			}else{
				$appointment_type='';
			}
		}
		if(!$appointment_date)
		{
			if(isset($old_data[0]->appointment_date)){
			$appointment_date = $old_data[0]->appointment_date;
				}else{
				$appointment_date='';
			}
		}
		if(!$appointment_time)
		{
			if(isset($old_data[0]->appointment_time)){
			$appointment_time = $old_data[0]->appointment_time;
			}else{
				$appointment_time='';
			}
		}
		
		if(!$appointment_status)
		{
			if(isset($old_data[0]->appointment_status)){
			$appointment_status = $old_data[0]->appointment_status;
			}else{
				$appointment_status='';
			}
		}

		//Update Follow up in lead__master
		if($_SESSION['role']==2 || $_SESSION['role']==3){
			$follwup='cse_followup_id='.$followup_id;
		}else{
			$follwup='exe_followup_id ='.$followup_id;
		}

		// Evaluation Done Date
		if(($old_data[0]->evaluation_tracking_date)=='' || ($old_data[0]->evaluation_tracking_date) == '0000-00-00' ){
			if($nextaction=='Evaluation Done'){
				$tracking_date=",evaluation_tracking_date='".$today1."'";
				$tracking_nextAction=",nextAction_for_tracking='".$nextaction."'";
			}
			else{
				$tracking_date="";
				$tracking_nextAction="";
			
			}
		}else{
				$tracking_date="";
				$tracking_nextAction="";
		}
		

		$update = $this -> db -> query("update lead_master_evaluation set email='$email',alternate_contact_no='$alternate_contact',location='$slocation',address='$address',".$follwup.",
		old_make='$old_make',old_model='$old_model',color='$color',ownership='$ownership',manf_year='$mfg',km='$km',accidental_claim='$claim',evaluation_within_days='$evaluation_within_days',fuel_type='$fuel_type',
		nextAction='$nextaction',feedbackStatus='$feedback',reg_no='$registration_no', 	expected_price ='$expected_price', 	quotated_price =' 	$quotated_price ',
		appointment_type='$appointment_type',appointment_date='$appointment_date',appointment_time='$appointment_time',appointment_status='$appointment_status',
		interested_in_finance='$interested_in_finance',interested_in_accessories='$interested_in_accessories',interested_in_insurance='$interested_in_insurance',interested_in_ew='$interested_in_ew',
		customer_occupation='$customer_occupation',customer_corporate_name='$customer_corporate_name',customer_designation='$customer_designation'".$tracking_date.$tracking_nextAction." where enq_id='$enq_id'");
		echo $this->db->last_query();
		
		if($update){
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Followup Added Successfully...!</strong>');
			} else {
			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Followup Not added ...!</strong>');
			}
		
		
		
		//Transfer Lead
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
			
		//	$select_process=$this->db->query("select process_name from tbl_process where process_id='$tprocess'")->result();
		//	$process_name=$select_process[0]->process_name;
			
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
			if($tprocess == '8'){
				
			$insertQuery =$this->db->query ('INSERT INTO request_to_lead_transfer_evaluation( `lead_id` , `assign_to` , `assign_by` , `location` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $assign . '","' . $assign_by  . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
			$transfer_id=$this->db->insert_id();
			$update1 =$this->db->query("update lead_master_evaluation set transfer_id='$transfer_id',assign_by_cse_tl='$assign_by_cse_tl',".$user_followup_id.",".$assign_user.",".$assign_by_cse.$assign_date."='$today1',".$assign_time."='$time' where enq_id='$enq_id'");
				
				
				if($update1){
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Transferred Successfully...!</strong>');
			} else {
			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Not Transferred Successfully ...!</strong>');
			}	
		
			}
			else if($tprocess=='6'){
			//$insertQuery = $this -> db -> query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` ,`transfer_reason`, `location` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $assign . '","' . $assign_by . '","' . $transfer_reason . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
			$checkLead =$this->db->query("select enq_id from lead_master where contact_no='$contact_no' and process='$tprocess_name' and nextAction!='Close'")->result();
			echo $this->db->last_query();
			if(count($checkLead)>0){
					 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Already exists in transferred process ...!</strong>');
	
			}else{
			if($lead_status == 'Close'){
				$updated_field="transfer_process='$transfer_array',feedbackStatus='Lead Transfer To Other Process',nextAction ='Close'";
				
			
			}else{
				$updated_field="transfer_process='$transfer_array'";
			}
			 $update1 = $this->db->query("update lead_master_evaluation set ".$updated_field." where enq_id='$enq_id'");	
			$insert_new_lead =$this->db->query("insert into lead_master(process,name,contact_no,email,lead_source,enquiry_for,created_date) values('$tprocess_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today1')");
			$new_enq_id = $this->db->insert_id();
			echo $this->db->last_query();
			 $transfer_other_process=$this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead`,`from_process`, `to_process`, `created_date`) VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");
			if($assign !=''){
				$insertQuery =$this->db->query ('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` , `location` , `created_date` , `created_time` ,status)  VALUES("' . $new_enq_id . '","' . $assign . '","' . $assign_by . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
				echo $insertQuery;
				$transfer_id=$this->db->insert_id();
			$update1 =$this->db->query("update lead_master set transfer_id='$transfer_id',assign_by_cse_tl='$assign_by_cse_tl',".$user_followup_id.",".$assign_user.",".$assign_by_cse.$assign_date."='$today1',".$assign_time."='$time' where enq_id='$new_enq_id'");
			}
			//echo $this->db->last_query();
					if($update1){
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Transferred Successfully...!</strong>');
			} else {
			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Not Transferred Successfully ...!</strong>');
			}	
			}
			//}
			

			}
							
			elseif($tprocess == '7'){
				
			
		
			
			$checkLead =$this->db->query("select enq_id from lead_master where contact_no='$contact_no' and process='$tprocess_name' and nextAction!='Close'")->result();
			echo $this->db->last_query();
			if(count($checkLead)>0){
					 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Already exists in transferred process ...!</strong>');
	
			}else{
			if($lead_status == 'Close'){
				$updated_field="transfer_process='$transfer_array',feedbackStatus='Lead Transfer To Other Process',nextAction ='Close'";
				
			
			}else{
				$updated_field="transfer_process='$transfer_array'";
			}
			 $update1 = $this->db->query("update lead_master_evaluation set ".$updated_field." where enq_id='$enq_id'");	
			
			
			$insert_new_lead =$this->db->query("insert into lead_master(process,name,contact_no,email,lead_source,enquiry_for,created_date) values('$tprocess_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today1')");
			$new_enq_id = $this->db->insert_id();
			echo $this->db->last_query();
			
			 $transfer_other_process=$this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead`,`from_process`, `to_process`, `created_date`) VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");
			if($assign !=''){
				$insertQuery =$this->db->query ('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` , `location` , `created_date` , `created_time` ,status)  VALUES("' . $new_enq_id . '","' . $assign . '","' . $assign_by  . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
				echo $insertQuery;
				$transfer_id=$this->db->insert_id();
			$update1 =$this->db->query("update lead_master set transfer_id='$transfer_id',assign_by_cse_tl='$assign_by_cse_tl',".$user_followup_id.",".$assign_user.",".$assign_by_cse.$assign_date."='$today1',".$assign_time."='$time' where enq_id='$new_enq_id'");
			}
			echo $this->db->last_query();
				
			}
					if($update1){
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Transferred Successfully...!</strong>');
			} else {
			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Not Transferred Successfully ...!</strong>');
			}	
			}
		
			else{
				// check lead already avaliable in that process or not
				$checkLead =$this->db->query("select enq_id from lead_master_all where contact_no='$contact_no' and process='$tprocess_name' and nextAction!='Close'")->result();
			if(count($checkLead)>0){
					 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Already exists in transferred process ...!</strong>');
	
			}else{
					
				//check old lead want to close or not
					if($lead_status == 'Close'){
						$updated_field="transfer_process='$transfer_array',feedbackStatus='Lead Transfer To Other Process',nextAction ='Close'";
				
			
			}else{
				$updated_field="transfer_process='$transfer_array'";
			}
			 $update1 = $this->db->query("update lead_master_evaluation set ".$updated_field." where enq_id='$enq_id'");	
			
			// Insert new lead in lead master
			$insert_new_lead = $this -> db -> query("insert into lead_master_all(process,name,contact_no,email,lead_source,enquiry_for,created_date) values('$tprocess_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today1')");
			$new_enq_id = $this->db->insert_id();
			
			//Lead mapping 
			$transfer_other_process=$this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead_all`,`from_process`, `to_process`, `created_date`) 
			VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");
			}
			if($update1){
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Transferred Successfully...!</strong>');
			} else {
			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Not Transferred Successfully ...!</strong>');
			}	
			}	

		}
	
	}
	}
		

//Select All Lead Data
	public function select_followup_lead($enq_id) {
		$this -> db -> select('f.id as followup_id,f.date as c_date,f.comment as f_comment,f.nextfollowupdate,f.nextfollowuptime, 
		f.feedbackStatus,f.nextAction,f.created_time,f.contactibility,f.appointment_type,f.appointment_date,f. 	appointment_time,f.appointment_status ,	 
		u.fname,u.lname
		 ');
		$this -> db -> from('lead_followup_evaluation f');
		$this -> db -> join('lmsuser u', 'u.id=f.assign_to','left');
		//$this -> db -> join('tbl_disposition_status d', 'd.disposition_id=f.disposition', 'left');
		//$this -> db -> join('tbl_status s', 's.status_id=d.status_id', 'left');
		$this -> db -> where('f.leadid', $enq_id);
		$this -> db -> order_by('f.id', 'desc');
		$query = $this -> db -> get();
		return $query -> result();

	}
	//Select Location
	public function select_location() {
		$this -> db -> select('p.location_id,l.location');
	//	$this -> db -> from('tbl_location');
		$this -> db -> from('tbl_map_process p');
		$this->db->join('tbl_location l','l.location_id=p.location_id');
		$this -> db -> where('p.process_id', $this->process_id);
		$query = $this -> db -> get();
			
		return $query -> result();
	}

	

	//Select model using make id
	function select_model($make) {
		$this -> db -> select('*');
		$this -> db -> from('make_models');
		$this -> db -> where('make_id', $make);
		$query = $this -> db -> get();
		return $query -> result();
	}
	//select make 
	function makes() {
		$this -> db -> select('*');
		$this -> db -> from('makes');
		$this -> db -> where('is_active', '1');
		$query = $this -> db -> get();
		return $query -> result();
	}


	function corporate() 
	{
		$this->db->select('*');
		$this->db->from('tbl_corporate');
		$query = $this->db->get();
		return $query->result();
	
		
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
    $update1 = $this -> db -> query("update lead_master_evaluation set ".$esc_level.",".$esc_remark." where enq_id='$enq_id'");
   
}
function insert_escalation_resolve_detail()
{
    $enq_id = $this -> input -> post('booking_id');    
     //escalation
    $escalation_type = $this->input->post('resolved_escalation_type');
    $escalation_remark = $this->input->post('resolved_escalation_remark');
   if($escalation_type=='Escalation Level 1')
    {
        $esc_level="esc_level1_resolved='Yes'";
        $esc_remark="esc_level1_resolved_remark= '".$escalation_remark."'";
    }
    elseif($escalation_type=='Escalation Level 2')
    {
        $esc_level="esc_level2_resolved='Yes'";
        $esc_remark="esc_level2_resolved_remark= '".$escalation_remark."'";
    }
    elseif ($escalation_type=='Escalation Level 3') {
        $esc_level="esc_level3_resolved='Yes'";
        $esc_remark="esc_level3_resolved_remark= '".$escalation_remark."'";
    }
    else {
        $esc_level='';
        $esc_remark='';
    }
    $update1 = $this -> db -> query("update lead_master_evaluation set ".$esc_level.",".$esc_remark." where enq_id='$enq_id'");
   
}
}
?>
