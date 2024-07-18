<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class add_followup_model extends CI_model {
	function __construct() {
		parent::__construct();
	}
	public function select_contact_details(){
		$query=$this->db->query("SELECT * FROM `tbl_contact_details`");
		return $query->result();
	}
	//Select All Lead Data
	public function select_lead($enq_id) {
		$this -> db -> select('
		u.fname,u.lname,
		v.variant_id,v.variant_name,m.model_id as new_model_id,m.model_name as new_model_name,
		l.enq_id,name,l.email,l.address,contact_no,enquiry_for,l.created_date,l.buyer_type,l.color,l.km,l.manf_year,l.accidental_claim,l.ownership,l.buy_status,
		l.created_time,l.location,l.eagerness,l.buy_make,l.buy_model,l.reg_no,l.budget_from,l.budget_to,l.days60_booking,
		f.id as followup_id,f.date as c_date,f.contactibility,f.comment as f_comment,f.nextfollowupdate,
		f.td_hv_date,f.feedbackStatus,f.nextAction,
		
		 m1.model_id,m1.model_name,bm1.model_name as buy_model_name,
		 m2.make_id,m2.make_name,bm2.make_name as buy_make_name');
		$this -> db -> from('lead_master l');
		$this -> db -> join('make_models m', 'm.model_id=l.model_id', 'left');
		$this -> db -> join('make_models m1', 'm1.model_id=l.old_model', 'left');
		$this -> db -> join('makes m2', 'm2.make_id=l.old_make', 'left');
		
		$this -> db -> join('make_models bm1', 'bm1.model_id=l.buy_model', 'left');
		$this -> db -> join('makes bm2', 'bm2.make_id=l.buy_make', 'left');
		//$this -> db -> join('lead_followup f', 'f.leadid=l.enq_id', 'left');
		if($_SESSION['role']=='3' || $_SESSION['role']=='2' || $_SESSION['role']=='1'){
		
		$this -> db -> join('lead_followup f', 'f.id=l.cse_followup_id', 'left');
		}
		else{
	
		$this -> db -> join('lead_followup f', 'f.id=l.dse_followup_id', 'left');
		}
		$this -> db -> join('lmsuser u', 'u.id=f.assign_to','left');
		$this -> db -> join('model_variant v', 'v.variant_id=l.variant_id', 'left');
		//$this -> db -> join('tbl_status s', 's.status_id=l.status', 'left');
		//$this -> db -> join('tbl_disposition_status d', 'd.disposition_id=l.disposition', 'left');
		$this -> db -> where('l.enq_id', $enq_id);

		$query = $this -> db -> get();
		return $query -> result();

	}
//Select All Lead Data
	public function select_followup_lead($enq_id) {
		$this -> db -> select('f.id as followup_id,f.date as c_date,f.comment as f_comment,f.nextfollowupdate,
		f.feedbackStatus,f.nextAction,		 u.fname,u.lname
		 ');
		$this -> db -> from('lead_followup f');
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
		$this -> db -> select('location_id,location');
		$this -> db -> from('tbl_location');
		$query = $this -> db -> get();

		return $query -> result();
	}
	//Select Status
	public function select_status() {
		$process_id = $_SESSION['process_id'];
		$this -> db -> select('status_id,status_name');
		$this -> db -> from('tbl_status');
		$this -> db -> where('process_id', $process_id);
		$this -> db -> where('status_name!=','Not Yet');
		$this -> db -> where('status_name!=','Postponed');
		
		$query = $this -> db -> get();
		return $query -> result();
	}
	//Select Group
	function select_group() {
		$this -> db -> select('group_id,group_name');
		$this -> db -> from('tbl_group');
		$query = $this -> db -> get();
		return $query -> result();

	}
//Select feedbackstatus
	function select_feedback_status() {
		
		//$this->db->distinct();
		$this->db->select('feedbackStatusName');
		$this->db->from('tbl_feedback_status');
		$this -> db -> where('fstatus!=', 'Deactive');
		$query = $this->db->get();
		return $query->result();
	
		
	}
	//Select Nextaction Status
	function next_action_status() {
		
		//$this->db->distinct();
		$this->db->select('nextActionName');
		$this->db->from('tbl_nextaction');
		$this -> db -> where('nextActionstatus!=', 'Deactive');
		$query = $this->db->get();
		return $query->result();
	
		
	}

	//Select Disposition using status id
	public function select_disposition_id($status) {
		$this -> db -> select('disposition_id,disposition_name');
		$this -> db -> from('tbl_disposition_status');
		$this -> db -> where('status_id', $status);
		$query = $this -> db -> get();
		return $query -> result();
	}
	//Select lms user
	function lmsuser($location) {
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser l');
		$this -> db -> join('tbl_user_group u', 'u.user_id=l.id');
		$this -> db -> join('tbl_rights r', 'r.user_id=l.id');
		$this -> db -> join('tbl_location l1', 'l1.location_id=l.location', 'left');
		$this -> db -> where('r.form_name', 'Calling Notification');
		$this -> db -> where('r.view', '1');
		$this -> db -> where('status', '1');

		if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2 || $_SESSION['role'] == 3) {
			$a = "(role=2 or role=3 or role=5)";
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
		} elseif ($_SESSION['role'] == 4) {
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
		$this -> db -> where('l1.location', $location);
		$this -> db -> group_by("l.id");
		$this -> db -> order_by("fname", "asc");
		$query = $this -> db -> get();
	//	echo $this -> db -> last_query();
		return $query -> result();
	}
	//Select Model
	function make_models() {
		$this -> db -> select('*');
		$this -> db -> from('make_models');
		$this -> db -> where('make_id', '1');
		$query = $this -> db -> get();
		return $query -> result();
	}
	
	function select_city() {
		
		$this->db->distinct();
		$this->db->select('location');
		$this->db->from('tbl_quotation_name');
		$query = $this->db->get();
		return $query->result();
	
		
	}
	

	
		function select_model_name1($city) {
		
		$this->db->distinct();
		$this->db->select('model_name');
		$this->db->from('tbl_pune_price');
		$this -> db -> where('city', $city);
		//$this -> db -> where('model_name!=','Ciaz');
		$query = $this->db->get();
	   	return $query->result();
		
	}
		
		function select_model_name2($city) {
		
		$this->db->distinct();
		$this->db->select('model_name');
		$this->db->from('tbl_nexa_price');
		$this -> db -> where('city', $city);
		$query = $this->db->get();
	   	return $query->result();
		
	}
	function select_model_name($city) {
		$query=$this->db->query("select * from tbl_quotation_name where location='$city' and status='Active'")->result();
		if(count($query)==1){
			$this->db->distinct();
		$this->db->select('model');
		$this->db->from($query[0]->table_name);
		
		$query1 = $this->db->get()->result();
		}
		else{
			$query1=array();
		}
	   	return $query1;
		
	}
		
function select_description($model_name,$city) {
		
			$query=$this->db->query("select * from tbl_quotation_name where location='$city' and status='Active'")->result();
		if(count($query)==1){
		
		$this->db->select('variant');
		$this->db->from($query[0]->table_name);
		$this->db->where('model',$model_name);
		$select_variant = $this->db->get()->result();
		}else{
			$select_variant=array();
		}
			
	   return $select_variant;
		
	}
	//Select data for qutation send
	function select_quotation($quotation_location, $quotation_model_name, $quotation_description)
	{
			$query=$this->db->query("select * from tbl_quotation_name where location='$quotation_location' and status='Active'")->result();
	
	
		$this->db->select('*');
		$this->db->from($query[0]->table_name);
		if($quotation_model_name!=''){
		$this->db->where('model',$quotation_model_name);
		}
		if($quotation_description!=''){
		$this->db->where('variant',$quotation_description);
		}
		$select_variant = $this->db->get()->result();

		
		echo $this->db->last_query();
		return $select_variant ;
	}
	function select_quotation1($quotation_location, $quotation_model_name, $quotation_description)
	{
			$query=$this->db->query("select * from tbl_quotation_name where location='$quotation_location' and status='Active'")->result();
	$table_name=$query[0]->table_name;
	
		$coloumn_name = $this -> db -> query("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_NAME`='$table_name'") -> result();
	
		
		echo $this->db->last_query();
		return $coloumn_name ;
	}
		function select_offer($quotation_location,$quotation_model_name)
	{
		$this->db->select('max(month) as created_date');
		$this->db->from("tbl_consumer_offer");
		  if($quotation_location=='Pune-PCMC'|| $quotation_location=='Pune-PMC')
			  {
			  	//echo "pune";
			  	
			  	$this->db->where('location','Pune');
				
			  }else{
			  	 	$this->db->where('location','Mumbai');
			  }
			  $this->db->where('model',$quotation_model_name);
		
			$query=$this->db->get()->result();		
		$this->db->select("*");
		$this->db->from("tbl_consumer_offer");
		  if($quotation_location=='Pune-PCMC'|| $quotation_location=='Pune-PMC')
			  {
			  	//echo "pune";
			  	
			  	$this->db->where('location','Pune');
				
			  }else{
			  	 	$this->db->where('location','Mumbai');
			  }
			  $this->db->where('model',$quotation_model_name);
			 $this->db->where('month',$query[0]->created_date);
		$query = $this -> db -> get();
		echo $this->db->last_query();
		return $query -> result();
	}
	
	//select variant from model id
	function select_variant_main() {
		$this -> db -> select('*');
		$this -> db -> from('model_variant');
		
		$query = $this -> db -> get();
		return $query -> result();

	}
	function select_model_main() {
		$this -> db -> select('*');
		$this -> db -> from('make_models');
	
		$query = $this -> db -> get();
		return $query -> result();
	}
	//Select model using make id
	function select_model($make) {
		$this -> db -> select('*');
		$this -> db -> from('make_models');
		$this -> db -> where('make_id', $make);
		$this -> db -> where('status','1');
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
	//select variant from model id
	function select_variant($model) {
		$this -> db -> select('*');
		$this -> db -> from('model_variant');
		$this -> db -> where('model_id', $model);
		$query = $this -> db -> get();
		return $query -> result();

	}
	//Insert Followup
	function insert_followup() {

		$today = date("d-m-Y");
		$today1 = date("Y-m-d");

		$str_today = strtotime($today);

		$time = date("H:i:s A");
		$date = $this -> input -> post('date');
		 $enq_id = $this -> input -> post('booking_id');
		$old_data=$this->db->query("select email,address,model_id,variant_id,buy_status,buyer_type from lead_master where enq_id='".$enq_id."'")->result();
		//print_r($old_data);
		//Basic Followup
		$assign_to_telecaller = $_SESSION['user_id'];
		if($this -> input -> post('activity')=='')
		{
			$activity='';
		}
		else {
			$activity = $this -> input -> post('activity');
		}
		
		 echo $status = $this -> input -> post('status1');
		$eagerness = $this -> input -> post('eagerness');
		$disposition = $this -> input -> post('disposition1');
		
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
		 
		/*$check_status=$this->db->query("select status_name from tbl_status where status_id='$status'")->result();
		 if(($check_status[0]->status_name == 'Live' || $check_status[0]->status_name == 'Postponed' ) && $followupdate =='')
		 {
		 	$tomarrow_date = date('Y-m-d', strtotime(' +1 day'));
			
		 	$followupdate = $tomarrow_date;
			
		 }*/
		 
		 $address1 = $this -> input -> post('address');
		if(!$address1)
		{
			
			 $address1 = $old_data[0]->address;
		
		}
		$address = addslashes($address1);

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
		$book_status = $this -> input -> post('book_status');
		if(!$book_status)
		{
			 $book_status = $old_data[0]->buy_status;
		}
		$buyer_type = $this -> input -> post('buyer_type');
		if(!$buyer_type)
		{
			 $buyer_type = $old_data[0]->buyer_type;
		}
		
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

		//Buy used car Details
		  $buy_make = $this -> input -> post('buy_make');
		  $buy_model = $this -> input -> post('buy_model');
		  $visit_status=$this->input->post('visit_status');
		  $budget_from=$this->input->post('budget_from');
		  $budget_to=$this->input->post('budget_to');
		  $visit_location = $this -> input -> post('visit_location');
		  $visit_booked = $this -> input -> post('visit_booked');
		  $visit_date = $this -> input -> post('visit_date');
		  $sales_status = $this -> input -> post('sales_status');
		  $car_delivered = $this -> input -> post('car_delivered');
		 
		 
		//Transfer Lead
		 $assign_by = $_SESSION['user_id'];
		 $assign = $this -> input -> post('transfer_assign');
		 $tlocation = $this -> input -> post('tlocation');
		 $transfer_reason = $this -> input -> post('transfer_reason');
		 $group_id = $this -> input -> post('group_id');
		 $group_count = count($group_id);
		//print_r($group_id);
		//>60 Days Booking
	
		
		 $days60_booking = $this -> input -> post('days60_booking');
		 
		 //Home visit or Test Drive date
		 $td_hv_date = $this -> input -> post('td_hv_date');
		 
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
		 
		//Insert in lead_followup
		$insert = $this -> db -> query("INSERT INTO `lead_followup`
		(`leadid`, `activity`, `comment`, `nextfollowupdate`,  `assign_to`, `transfer_reason`, `date`,`visit_status` ,`visit_location`,`visit_booked`,`visit_booked_date`,`sale_status`,`car_delivered`,`created_time`,`days60_booking`,`td_hv_date`,`feedbackStatus`,`nextAction`) 
		VALUES ('$enq_id','$activity','$comment','$followupdate','$assign_to_telecaller','$transfer_reason','$today1','$visit_status','$visit_location','$visit_booked','$visit_date','$sales_status','$car_delivered','$time','$days60_booking','$td_hv_date','$feedback','$nextaction')") or die(mysql_error());
 		$followup_id = $this->db->insert_id();
		echo $this->db->last_query();
		//Update Follow up in lead__master
		if($_SESSION['role']==2 || $_SESSION['role']==3){
			$follwup='cse_followup_id='.$followup_id;
		}else{
			$follwup='dse_followup_id='.$followup_id;
		}
		
		$update = $this -> db -> query("update lead_master set $follwup,email='$email',location='$slocation',address='$address',
		model_id='$new_model',variant_id='$new_variant',buy_status='$book_status',buyer_type='$buyer_type',
		old_make='$old_make',old_model='$old_model',color='$color',ownership='$ownership',manf_year='$mfg',km='$km',accidental_claim='$claim',buy_make='$buy_make',buy_model='$buy_model',budget_from='$budget_from',budget_to='$budget_to',days60_booking='$days60_booking',nextAction='$nextaction',feedbackStatus='$feedback' where enq_id='$enq_id'");
		echo $this->db->last_query();
		//Transfer Lead
		if ($assign != '') {
//			if ($group_count == '1') {
			$insertQuery = $this -> db -> query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` ,`transfer_reason`, `location` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $assign . '","' . $assign_by . '","' . $transfer_reason . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
			$transfer_id=$this->db->insert_id();
			echo $this->db->last_query();
			$get_user_role=$this->db->query("select role from lmsuser where id='$assign'")->result();
			
			//Assign CSE To CSE
			if(($get_user_role[0]->role == 2 or $get_user_role[0]->role==3) && $_SESSION['role']==3){
				$assign_user='assign_to_cse='.$assign;
				$assign_date='assign_to_cse_date';
				$user_followup_id='cse_followup_id = 0';
				$assign_by_cse='assign_by_cse='.$assign_by.',';
			}
			//Assign CSE To DSE TL
			if($get_user_role[0]->role == 5 && ($_SESSION['role']==2 || $_SESSION['role']==3)){
				$assign_user='assign_to_dse_tl='.$assign;
				$assign_date='assign_to_dse_tl_date';
				$user_followup_id='dse_followup_id = 0';
				$assign_by_cse='assign_by_cse='.$assign_by.',';
			}
			//Assign  DSE To DSE TL
			if($get_user_role[0]->role == 5 && $_SESSION['role']==4 ){
				$assign_user='assign_to_dse_tl='.$assign;
				$assign_date='assign_to_dse_tl_date';
				$user_followup_id='dse_followup_id = 0,assign_to_dse=0,assign_to_dse_date="0000-00-00"';
				//$user_followup_id='dse_followup_id = 0';
				$assign_by_cse='';
			}
			//Assign DSE TL TO DSE 
			if($get_user_role[0]->role == 4 &&  $_SESSION['role']==5){
				$assign_user='assign_to_dse='.$assign;
				$assign_date='assign_to_dse_date';
				$user_followup_id='dse_followup_id = 0';
				$assign_by_cse='';
			}
			//Assign DSE TL To DSE TL
			if($get_user_role[0]->role == 5 &&  $_SESSION['role']==5){
				$assign_user='assign_to_dse_tl='.$assign;
				$assign_date='assign_to_dse_tl_date';
				$user_followup_id='dse_followup_id = 0';
				$assign_by_cse='';
			}
			
			//Assign DSE  To DSE 
			if($get_user_role[0]->role == 4 &&  $_SESSION['role']==4){
				$assign_user='assign_to_dse='.$assign;
				$assign_date='assign_to_dse_date';
				$user_followup_id='dse_followup_id = 0';
				$assign_by_cse='';
			}

			$update1 = $this -> db -> query("update lead_master set transfer_id='$transfer_id',".$user_followup_id.",".$assign_user.",".$assign_by_cse.$assign_date."='$today1' where enq_id='$enq_id'");
				echo $this->db->last_query();			
			//} 
			/*else {

				
				$insertQuery = $this -> db -> query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to_telecaller` , `assign_by_id` , `transfer_reason`,`location` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $assign . '","' . $assign_by . '","' . $transfer_reason . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
				$transfer_id=$this->db->insert_id();
				$update1 = $this -> db -> query("update lead_master set transfer_id='$transfer_id', assign_to_telecaller='$assign',assignby='$assign_by' ,assign_date='$today1' where enq_id='$enq_id'");
				for ($i = 1; $i < $group_count; $i++) {
					$q = $this -> db -> query("select * from lead_master where enq_id='$enq_id'") -> result();

					 $name = $q[0] -> name;
					$email = $q[0] -> email;
					$contact = $q[0] -> contact_no;

					$insertQuery = $this -> db -> query('INSERT INTO lead_master( `name` , `email` , `contact_no` ,`address`, `enquiry_for`, `created_date` , `created_time` ,`location`,assign_to_telecaller,assignby,assign_date) 
					 VALUES("' . $name . '","' . $email . '","' . $contact . '","' . $address . '","' . $group_id[$i] . '","' . $today1 . '","' . $time . '","' . $showroom_location . '","' . $assign . '","' . $assign_by. '","' . $today1 . '")') or die(mysql_error());
						
					$id1 = $this -> db -> insert_id();
					$insertQuery1 = $this -> db -> query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to_telecaller` , `assign_by_id` ,`transfer_reason`, `location` , `created_date` , `created_time`  ,status)  VALUES("' . $id1 . '","' . $assign . '","' . $assign_by . '","' . $transfer_reason . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")') or die(mysql_error());
					$transfer_id1=$this->db->insert_id();
					$update2 = $this -> db -> query("update lead_master set transfer_id='$transfer_id1' where enq_id='$id1'");
				}
			}*/
		}
		
	
	}
	//Insert Manager Remark
	function insert_remark() {

		
		$today = date("Y-m-d");
		
		
		//add remark 
		$user_id = $_SESSION['user_id'];
		$remark = $this -> input -> post('comment');
		$enq_id = $this -> input -> post('booking_id');
			
		$query=$this -> db -> query("INSERT INTO `tbl_manager_remark`(`remark`, `user_id`, `lead_id`, `created_date`) VALUES ('$remark','$user_id','$enq_id','$today')");
		$remark_id = $this->db->insert_id();
		$update1 = $this -> db -> query("update lead_master set remark_id='$remark_id' where enq_id='$enq_id'");
		
	}	
public function insert_additional_info()
{
	$today=date('Y-m-d');
	$make=$this->input->post('make');
	$model=$this->input->post('model');
	$color=$this->input->post('color');
	$ownership=$this->input->post('ownership');
	$mfg=$this->input->post('mfg');
	$km=$this->input->post('km');
	$claim=$this->input->post('claim');
	$buyer_type=$this->input->post('buyer_type');
	$enq_id=$this->input->post('enq_id');
	$query=$this->db->query("select info_id from tbl_additional_car_info where lead_id='$enq_id' and car_make='$make' and car_model='$model'")->result();
	
	if(count($query)==0)
	{
	$query=$this->db->query("INSERT INTO tbl_additional_car_info(lead_id, buyer_type,car_make, car_model, color, ownership, mfg_year,km,claim,created_date) VALUES ('$enq_id','$buyer_type','$make','$model','$color','$ownership','$mfg','$km','$claim','$today')");
	}
}
public function select_additional_info($enq_id)
{
	$this->db->select("m1.model_name,m.make_name");
	$this->db->from("tbl_additional_car_info a");
	$this->db->join("makes m",'a.car_make=m.make_id');
	$this->db->join("make_models m1",'a.car_model=m1.model_id');
	
	
	$this->db->where('lead_id',$enq_id);
	$query = $this -> db -> get();
		return $query -> result();
}
public function select_dse_data(){
	$this->db->select('id,fname,mobileno');
	$this->db->from('lmsuser');
	$this->db->where('id',$_SESSION['user_id']);
	$query=$this->db->get();
	return $query->result();
}
public function select_next_action()
{
	$feedback=$this->input->post('feedback');
	$this->db->select('feedbackStatusName,nextActionName');
	$this->db->from('tbl_mapNextAction');
	$this->db->where('feedbackStatusName',$feedback);
	$this->db->where('map_next_to_feed_status!=','Deactive');
	$query=$this->db->get();
	return $query->result();

}
}
?>