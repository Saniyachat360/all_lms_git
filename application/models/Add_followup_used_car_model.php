<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Add_followup_used_car_model extends CI_model {
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
	function process() 
	{
		//$this->db->distinct();
		$this->db->select('*');
		$this->db->from('tbl_process');
		//$this -> db -> where('nextActionstatus!=', 'Deactive');
		$query = $this->db->get();
		return $query->result();
	}	

	function select_transfer_location($tprocess) 
	{
		$this -> db -> select('l.*');
		$this -> db -> from('tbl_location l');
		$this->db->join('tbl_map_process p','p.location_id=l.location_id');
		$this->db->where('p.status !=','-1');
		$this->db->where('l.location_status !=','Deactive');
		$this->db->where('process_id',$tprocess);
		$query = $this->db->get();
		return $query->result();
		
	}
		public function select_contact_details() {
		$query = $this -> db -> query("SELECT * FROM `tbl_contact_details`");
		return $query -> result();
	}	//Select All Lead Data
	public function select_lead($enq_id) {
		$this -> db -> select('
		u.fname,u.lname,
		v.variant_id,v.variant_name,m.model_id as new_model_id,m.model_name as new_model_name,l.assign_to_dse_tl,l.transfer_process,l.process,
		l.enq_id,name,l.email,l.address,l.alternate_contact_no,l.contact_no,l.transfer_process,l.comment,enquiry_for,l.created_date,l.buyer_type,l.color,l.km,l.manf_year,l.accidental_claim,l.ownership,l.buy_status,
		l.created_time,l.location,l.eagerness,l.buy_make,l.buy_model,l.reg_no,l.budget_from,l.budget_to,l.days60_booking,l.appointment_type,l.appointment_date,l.appointment_time,l.appointment_address,l.appointment_status,l.appointment_rating,l.appointment_feedback,l.interested_in_finance,l.interested_in_accessories,l.interested_in_insurance,l.interested_in_ew,l.customer_occupation,l.customer_corporate_name,l.customer_designation,
		f.id as followup_id,f.activity,f.date as c_date,f.contactibility,f.comment as f_comment,f.nextfollowupdate,f.nextfollowuptime,f.visit_location,f.visit_booked,f.visit_status,f.visit_booked_date,f.sale_status,f.car_delivered,
		f.td_hv_date,f.feedbackStatus,f.nextAction,l.esc_level1,l.esc_level1_remark ,l.esc_level2,l.esc_level2_remark ,l.esc_level3,l.esc_level3_remark ,
		
		 m1.model_id,m1.model_name,bm1.model_name as buy_model_name,
		 m2.make_id,m2.make_name,bm2.make_name as buy_make_name,
		 esc_level1_resolved ,esc_level2_resolved,esc_level3_resolved,esc_level1_resolved_remark ,esc_level2_resolved_remark ,esc_level3_resolved_remark ');
		$this -> db -> from('lead_master l');
		$this -> db -> join('make_models m', 'm.model_id=l.model_id', 'left');
		$this -> db -> join('make_models m1', 'm1.model_id=l.old_model', 'left');
		$this -> db -> join('makes m2', 'm2.make_id=l.old_make', 'left');
		$this -> db -> join('make_models bm1', 'bm1.model_id=l.buy_model', 'left');
		$this -> db -> join('makes bm2', 'bm2.make_id=l.buy_make', 'left');
		//$this -> db -> join('lead_followup f', 'f.leadid=l.enq_id', 'left');
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '2' || $_SESSION['role'] == '1') {
			$this -> db -> join('lead_followup f', 'f.id=l.cse_followup_id', 'left');
		} else {
			$this -> db -> join('lead_followup f', 'f.id=l.dse_followup_id', 'left');
		}
		$this -> db -> join('lmsuser u', 'u.id=f.assign_to', 'left');
		$this -> db -> join('model_variant v', 'v.variant_id=l.variant_id', 'left');
		$this -> db -> where('l.enq_id', $enq_id);
		$query = $this -> db -> get();
			echo $this->db->last_query();
		return $query -> result();
	}	//Select All Lead Data
	public function select_followup_lead($enq_id) {
		$this -> db -> select('f.id as followup_id,f.date as c_date,f.comment as f_comment,f.nextfollowupdate,f.nextfollowuptime, 
		f.feedbackStatus,f.nextAction,f.contactibility,f.created_time,f.appointment_type,f.appointment_date,f. 	appointment_time,f.appointment_status ,		 
		u.fname,u.lname
		 ');
		$this -> db -> from('lead_followup f');
		$this -> db -> join('lmsuser u', 'u.id=f.assign_to', 'left');
		$this -> db -> where('f.leadid', $enq_id);
		$this -> db -> order_by('f.id', 'desc');
		$query = $this -> db -> get();
		return $query -> result();
	}	//Select Location
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
	}	//Select Group
	function select_group() {
		$this -> db -> select('group_id,group_name');
		$this -> db -> from('tbl_group');
		$query = $this -> db -> get();
		return $query -> result();
	}	//Select feedbackstatus
	function select_feedback_status() {
		//$this->db->distinct();
		$this -> db -> select('feedbackStatusName');
		$this -> db -> from('tbl_feedback_status');
		$this -> db -> where('process_id', '7');
		$this -> db -> where('fstatus!=', 'Deactive');
		$query = $this -> db -> get();
		return $query -> result();
	}	//Select Nextaction Status
	function next_action_status() {
		//$this->db->distinct();
		$this -> db -> select('nextActionName');
		$this -> db -> from('tbl_nextaction');
		$this -> db -> where('nextActionstatus!=', 'Deactive');
		$this -> db -> where('process_id', '7');
		$query = $this -> db -> get();
		return $query -> result();
	}	//Select lms user
	/*function lmsuser($location) {
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
		//echo $this -> db -> last_query();
		return $query -> result();
	}*/	//Select Model
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
		//echo $this -> db -> last_query();
		return $query -> result();
		
	}
	function make_models() {
		$this -> db -> select('*');
		$this -> db -> from('make_models');
		$this -> db -> where('make_id', '1');		$this -> db -> where('status', '1');
		$query = $this -> db -> get();
		return $query -> result();
	}	function select_city() {
		$this->db->distinct();
		$this->db->select('location');
		$this->db->from('tbl_quotation');
		
		$query = $this->db->get();
		return $query->result();
	}	function select_model_name1($city) {
		$this -> db -> distinct();
		$this -> db -> select('model_name');
		$this -> db -> from('tbl_pune_price');
		$this -> db -> where('city', $city);
		//$this -> db -> where('model_name!=','Ciaz');
		$query = $this -> db -> get();
		return $query -> result();
	}	function select_model_name2($city) {
		$this -> db -> distinct();
		$this -> db -> select('model_name');
		$this -> db -> from('tbl_nexa_price');
		$this -> db -> where('city', $city);
		$query = $this -> db -> get();
		return $query -> result();
	}	function select_model_name($city) {
		$query = $this -> db -> query("select * from tbl_quotation_name where location='$city' and status='Active'") -> result();
		if (count($query) == 1) {
			$this -> db -> distinct();
			$this -> db -> select('model');
			$this -> db -> from($query[0] -> table_name);
			$query1 = $this -> db -> get() -> result();
		} else {
			$query1 = array();
		}
		return $query1;
	}	function select_description($model_name, $city) {
		$query = $this -> db -> query("select * from tbl_quotation_name where location='$city' and status='Active'") -> result();
		if (count($query) == 1) {
			$this -> db -> select('variant');
			$this -> db -> from($query[0] -> table_name);
			$this -> db -> where('model', $model_name);
			$select_variant = $this -> db -> get() -> result();
		} else {
			$select_variant = array();
		}
		return $select_variant;
	}	//Select data for qutation send
	function select_quotation($quotation_location, $quotation_model_name, $quotation_description) {
		$query = $this -> db -> query("select * from tbl_quotation_name where location='$quotation_location' and status='Active'") -> result();
		$this -> db -> select('*');
		$this -> db -> from($query[0] -> table_name);
		if ($quotation_model_name != '') {
			$this -> db -> where('model', $quotation_model_name);
		}
		if ($quotation_description != '') {
			$this -> db -> where('variant', $quotation_description);
		}
		$select_variant = $this -> db -> get() -> result();
		echo $this -> db -> last_query();
		return $select_variant;
	}	function select_quotation1($quotation_location, $quotation_model_name, $quotation_description) {
		$query = $this -> db -> query("select * from tbl_quotation_name where location='$quotation_location' and status='Active'") -> result();
		$table_name = $query[0] -> table_name;
		$coloumn_name = $this -> db -> query("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_NAME`='$table_name'") -> result();
		echo $this -> db -> last_query();
		return $coloumn_name;
	}	function select_offer($quotation_location, $quotation_model_name) {
		$this -> db -> select('max(month) as created_date');
		$this -> db -> from("tbl_consumer_offer");
		if ($quotation_location == 'Pune-PCMC' || $quotation_location == 'Pune-PMC') {
			//echo "pune";
			$this -> db -> where('location', 'Pune');
		} else {
			$this -> db -> where('location', 'Mumbai');
		}
		$this -> db -> where('model', $quotation_model_name);
		$query = $this -> db -> get() -> result();
		$this -> db -> select("*");
		$this -> db -> from("tbl_consumer_offer");
		if ($quotation_location == 'Pune-PCMC' || $quotation_location == 'Pune-PMC') {
			//echo "pune";
			$this -> db -> where('location', 'Pune');
		} else {
			$this -> db -> where('location', 'Mumbai');
		}
		$this -> db -> where('model', $quotation_model_name);
		$this -> db -> where('month', $query[0] -> created_date);
		$query = $this -> db -> get();
		echo $this -> db -> last_query();
		return $query -> result();
	}	//select variant from model id
	function select_variant_main() {
		$this -> db -> select('*');
		$this -> db -> from('model_variant');
		$this -> db -> where('is_active!=', '-1');
		$query = $this -> db -> get();
		return $query -> result();
	}	function select_model_main() {
		$this -> db -> select('*');
		$this -> db -> from('make_models');
		$query = $this -> db -> get();
		return $query -> result();
	}	//Select model using make id
	function select_model($make) {
		$this -> db -> select('*');
		$this -> db -> from('make_models');
		$this -> db -> where('make_id', $make);
		$query = $this -> db -> get();
		return $query -> result();
	}	



		//select budget
		function select_model_budget($budget_from,$budget_to,$make,$model) {
		
		$q = $this->db->query("SELECT model_name FROM `make_models` WHERE model_id='$model'")->result();

		if(count($q)>0)
		{
			$modelname = $q[0]->model_name; 
		}
		else
		{
			$modelname = "";
		}

		$q1 = $this->db->query("SELECT created_date FROM `tbl_stock_in_hand_poc` ORDER BY created_date desc")->result();

		if(count($q1)>0)
		{
			$created_date = $q1[0]->created_date; 
		}
		else
		{
			$created_date = "";
		}

		$this -> db -> select('*');
		$this -> db -> from('tbl_stock_in_hand_poc');
		if($make!='')
		{
		$this -> db -> where('make', $make);
		}

		if($budget_from!='')
		{
		$this -> db -> where('expt_selling_price >=', $budget_from);
		}
		
		if($budget_to!='')
		{
		$this->db->where('expt_selling_price <=', $budget_to);
		}
		//created max date 
		if($created_date!='')
		{
		$this->db->where('created_date', $created_date);
		}

		//like query for modelname
		if($modelname!='')
		{
		$this->db->like('model', $modelname);
		}


		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
		}


		function stock_poc_budget() {		
		$this -> db -> select('*');
		$this -> db -> from('tbl_stock_in_hand_poc');
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
	}	//select variant from model id
	function select_variant($model) {
		$this -> db -> select('*');
		$this -> db -> from('model_variant');
		$this -> db -> where('model_id', $model);
		$this -> db -> where('is_active!=', '-1');
		$query = $this -> db -> get();
		return $query -> result();
	}	//Insert Followup
	function insert_followup() {
		$today = date("d-m-Y");
		$today1 = date("Y-m-d");
		$str_today = strtotime($today);
		$time = date("h:i:s A");
		$date = $this -> input -> post('date');
		$enq_id = $this -> input -> post('booking_id');
		$alternate_contact=$this->input->post('alternate_contact');
			$old_data=$this->db->query("select name,contact_no,lead_source,enquiry_for,email,address,model_id,variant_id,buy_status,buyer_type,quotation_sent,evaluation_location,assign_by_cse_tl,assign_to_cse,assign_to_cse_date,assign_to_cse_time,transfer_process  from lead_master where enq_id='".$enq_id."'")->result();
	//print_r($old_data);
		//Basic Followup
		$name=$old_data[0]->name;
		$contact_no=$old_data[0]->contact_no;
		$lead_source=$old_data[0]->lead_source;
		$enquiry_for=$old_data[0]->enquiry_for;
		$assign_to_telecaller = $_SESSION['user_id'];
		if ($this -> input -> post('activity') == '') {
			$activity = '';
		} else {
			$activity = $this -> input -> post('activity');
		}
		$contactibility = $this -> input -> post('contactibility');
		if($contactibility=='Connected' || $contactibility=='Not Connected')
		{
			//$this->send_sms($contactibility,$contact_no);
		}
		echo $status = $this -> input -> post('status1');
		$eagerness = $this -> input -> post('eagerness');
		$disposition = $this -> input -> post('disposition1');
		$feedback = $this -> input -> post('feedback');
		$nextaction = $this -> input -> post('nextaction');
		$email = $this -> input -> post('email');
		if (!$email) {
			if ($old_data[0] -> email != null) {
				$email = $old_data[0] -> email;
			}
		}
		$showroom_location = $this -> input -> post('showroom_location');
		$followupdate = $this -> input -> post('followupdate');
		if ($nextaction == 'Close') {
			$followupdate = '0000-00-00';
		}
		/*$check_status=$this->db->query("select status_name from tbl_status where status_id='$status'")->result();
		 if(($check_status[0]->status_name == 'Live' || $check_status[0]->status_name == 'Postponed' ) && $followupdate =='')
		 {
		 $tomarrow_date = date('Y-m-d', strtotime(' +1 day'));
		 $followupdate = $tomarrow_date;
		 }*/
		$address1 = $this -> input -> post('address');
		if (!$address1) {
			$address1 = $old_data[0] -> address;
		}
		$address = addslashes($address1);
		//New Car Details
		$new_model = $this -> input -> post('new_model');
		if (!$new_model) {
			$new_model = $old_data[0] -> model_id;
		}
		$new_variant = $this -> input -> post('new_variant');
		if (!$new_variant) {
			$new_variant = $old_data[0] -> variant_id;
		}
		$book_status = $this -> input -> post('book_status');
		if (!$book_status) {
			$book_status = $old_data[0] -> buy_status;
		}
		$buyer_type = $this -> input -> post('buyer_type');
		if (!$buyer_type) {
			$buyer_type = $old_data[0] -> buyer_type;
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
		$visit_status = $this -> input -> post('visit_status');
		$budget_from = $this -> input -> post('budget_from');
		$budget_to = $this -> input -> post('budget_to');
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
		$evaluation_location=$this->input->post('evaluation_location');
		//$group_count = count($group_id);
		//print_r($group_id);
		//>60 Days Booking
		$days60_booking = $this -> input -> post('days60_booking');
		//Home visit or Test Drive date
		$td_hv_date = $this -> input -> post('td_hv_date');
		//Showroom Location
		if ($this -> input -> post('tlocation') != '') {
			$slocation = $this -> input -> post('tlocation');
		} else {
			$getlocation = $this -> db -> query("select location from lead_master where enq_id='$enq_id'") -> result();
			if (count($getlocation) > 0) {
				$slocation = $getlocation[0] -> location;
			} else {
				$slocation = '';
			}
		}   
		$followuptime = $this->input->post('followuptime');
		$contactibility=$this->input->post('contactibility');
		 //Appointment
		   $appointment_type = $this->input->post('appointment_type');
		 $appointment_date = $this->input->post('appointment_date');
		 echo $appointment_time = $this->input->post('appointment_time');
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
		
		// Corporate customer
		$customer_occupation=$this->input->post('customer_occupation');
		$customer_designation=$this->input->post('customer_designation');
		$customer_corporate_name=$this->input->post('customer_corporate_name');
		
		
		//Insert in lead_followup
			$checktime=date("h:i");
		$checkfollowup=$this->db->query("select id from lead_followup where leadid='$enq_id' and assign_to='$assign_to_telecaller' and date='$today1'
		and comment ='$comment' and contactibility='$contactibility' and created_time like '$checktime%'")->result();
		if(count($checkfollowup)< 1)
		{
			
		$insert = $this -> db -> query("INSERT INTO `lead_followup`
		(`leadid`, `activity`, `comment`, `nextfollowupdate`,  `assign_to`, `transfer_reason`, `date`,`visit_status` ,`visit_location`,`visit_booked`,`visit_booked_date`,`sale_status`,`car_delivered`,`created_time`,`days60_booking`,`td_hv_date`,`feedbackStatus`,`nextAction`,`contactibility`,`nextfollowuptime`
		,`appointment_type`,`appointment_date`,`appointment_time`,`appointment_address`,`appointment_status`,`appointment_rating`,`appointment_feedback`,`escalation_type`,`escalation_remark`,web) 
		VALUES ('$enq_id','$activity','$comment','$followupdate','$assign_to_telecaller','$transfer_reason','$today1','$visit_status','$visit_location','$visit_booked','$visit_date','$sales_status','$car_delivered','$time','$days60_booking','$td_hv_date','$feedback','$nextaction','$contactibility'
		,'$followuptime','$appointment_type','$appointment_date','$appointment_time','$appointment_address','$appointment_status','$appointment_rating','$appointment_feedback','$escalation_type','$escalation_remark','1')") or die(mysql_error());
		$followup_id = $this -> db -> insert_id();
		echo $this -> db -> last_query();
		//Update Follow up in lead__master
		if ($_SESSION['role'] == 2 || $_SESSION['role'] == 3) {
			$follwup = 'cse_followup_id=' . $followup_id;
		} else {
			$follwup = 'dse_followup_id=' . $followup_id;
		}
		$update = $this -> db -> query("update lead_master set $follwup,email='$email',alternate_contact_no='$alternate_contact',location='$slocation',address='$address',
		model_id='$new_model',variant_id='$new_variant',buy_status='$book_status',buyer_type='$buyer_type',
		old_make='$old_make',old_model='$old_model',color='$color',ownership='$ownership',manf_year='$mfg',km='$km',accidental_claim='$claim',buy_make='$buy_make',buy_model='$buy_model',budget_from='$budget_from',budget_to='$budget_to',days60_booking='$days60_booking',nextAction='$nextaction',feedbackStatus='$feedback' ,
		appointment_type='$appointment_type',appointment_date='$appointment_date',
		appointment_time='$appointment_time',appointment_address='$appointment_address',appointment_status='$appointment_status',
		appointment_rating='$appointment_rating',appointment_feedback='$appointment_feedback',interested_in_finance='$interested_in_finance',interested_in_accessories='$interested_in_accessories',interested_in_insurance='$interested_in_insurance',interested_in_ew='$interested_in_ew',customer_occupation='$customer_occupation',customer_corporate_name='$customer_corporate_name',customer_designation='$customer_designation',evaluation_location='$evaluation_location',web=1 where enq_id='$enq_id'");
		echo $this -> db -> last_query();
	//Transfer Lead
			$ctprocess=$this->input->post('tprocess');
			
			
		if ($ctprocess != '') {
			$lead_status=$this->input->post('lead_status');	
				
			$cctprocess=explode("#",$ctprocess);
			$tprocess=$cctprocess[0];
			$tprocess_name=$cctprocess[1];
			
			$transfer_array=array();
			if($old_data[0]->transfer_process!=''){
				array_push($transfer_array,$tprocess);
				$old_tprocess=json_decode($old_data[0]->transfer_process);
				
				$transfer_array=array_merge($transfer_array,$old_tprocess);
				
			}else{
				array_push($transfer_array,$tprocess);
			}
			
			$transfer_array=json_encode($transfer_array);
			$process_id=$_SESSION['process_id'];
			
			
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
			
			if($tprocess=='7'){
				//$insertQuery = $this -> db -> query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` ,`transfer_reason`, `location` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $assign . '","' . $assign_by . '","' . $transfer_reason . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
				$insertQuery =$this->db->query ('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` ,`transfer_reason`, `location` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $assign . '","' . $assign_by . '","' . $transfer_reason . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
				echo $insertQuery;
				$transfer_id=$this->db->insert_id();
		
			//$update1 = $this -> db -> query("update lead_master set transfer_id='$transfer_id',assign_by_cse_tl='$assign_by_cse_tl',".$user_followup_id.",".$assign_user.",".$assign_by_cse.$assign_date."='$today1',".$assign_time."='$time' where enq_id='$enq_id'");
			 $update1 =$this->db->query("update lead_master set transfer_id='$transfer_id',assign_by_cse_tl='$assign_by_cse_tl',".$user_followup_id.",".$assign_user.",".$assign_by_cse.$assign_date."='$today1',".$assign_time."='$time' where enq_id='$enq_id'");
				if($update1){
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Transferred Successfully...!</strong>');
			} else {
			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Not Transferred Successfully ...!</strong>');
			}			
			//	echo $this->db->last_query();	
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
			 $update1 = $this->db->query("update lead_master set ".$updated_field." where enq_id='$enq_id'");	
			
			
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
			}
			if($update1){
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Transferred Successfully...!</strong>');
			} else {
			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Not Transferred Successfully ...!</strong>');
			}	
			}
				

			
			}
				elseif($tprocess == '8'){

			$checkLead =$this->db->query("select enq_id from lead_master_evaluation where contact_no='$contact_no' and evaluation='Yes' and nextAction!='Close'")->result();
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
			//echo $this->db->last_query();
			 $transfer_other_process=$this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead_evaluation`,`from_process`, `to_process`, `created_date`) VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");
			 echo $this->db->last_query();
			
			if($assign !=''){
				$insertQuery =$this->db->query ('INSERT INTO request_to_lead_transfer_evaluation( `lead_id` , `assign_to` , `assign_by` ,`transfer_reason`, `location` , `created_date` , `created_time` ,status)  VALUES("' . $new_enq_id . '","' . $assign . '","' . $assign_by . '","' . $transfer_reason . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
				echo $insertQuery;
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

	}	//Insert Manager Remark
	function insert_remark() {
		$today = date("Y-m-d");
		//add remark
		$user_id = $_SESSION['user_id'];
		$remark = $this -> input -> post('comment');
		$enq_id = $this -> input -> post('booking_id');
		$query = $this -> db -> query("INSERT INTO `tbl_manager_remark`(`remark`, `user_id`, `lead_id`, `created_date`) VALUES ('$remark','$user_id','$enq_id','$today')");
		$remark_id = $this -> db -> insert_id();
		$update1 = $this -> db -> query("update lead_master set remark_id='$remark_id' where enq_id='$enq_id'");
	}	public function insert_additional_info() {
		$today = date('Y-m-d');
		$make = $this -> input -> post('make');
		$model = $this -> input -> post('model');
		$color = $this -> input -> post('color');
		$ownership = $this -> input -> post('ownership');
		$mfg = $this -> input -> post('mfg');
		$km = $this -> input -> post('km');
		$claim = $this -> input -> post('claim');
		$buyer_type = $this -> input -> post('buyer_type');
		$enq_id = $this -> input -> post('enq_id');
		$query = $this -> db -> query("select info_id from tbl_additional_car_info where lead_id='$enq_id' and car_make='$make' and car_model='$model'") -> result();
		if (count($query) == 0) {
			$query = $this -> db -> query("INSERT INTO tbl_additional_car_info(lead_id, buyer_type,car_make, car_model, color, ownership, mfg_year,km,claim,created_date) VALUES ('$enq_id','$buyer_type','$make','$model','$color','$ownership','$mfg','$km','$claim','$today')");
		}
	}	public function select_additional_info($enq_id) {
		$this -> db -> select("m1.model_name,m.make_name");
		$this -> db -> from("tbl_additional_car_info a");
		$this -> db -> join("makes m", 'a.car_make=m.make_id');
		$this -> db -> join("make_models m1", 'a.car_model=m1.model_id');
		$this -> db -> where('lead_id', $enq_id);
		$query = $this -> db -> get();
		return $query -> result();
	}	public function select_dse_data() {
		$this -> db -> select('id,fname,mobileno');
		$this -> db -> from('lmsuser');
		$this -> db -> where('id', $_SESSION['user_id']);
		$query = $this -> db -> get();
		return $query -> result();
	}	
	public function select_next_action() {
		$feedback = $this -> input -> post('feedback');
		$this -> db -> select('feedbackStatusName,nextActionName');
		$this -> db -> from('tbl_mapNextAction');
		$this -> db -> where('feedbackStatusName', $feedback);
		$this -> db -> where('map_next_to_feed_status!=', 'Deactive');
		$this -> db -> where('process_id', '7');
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
	function select_evaluation_location(){
	$this -> db -> select('p.location_id,l.location');
	//	$this -> db -> from('tbl_location');
		$this -> db -> from('tbl_map_process p');
		$this->db->join('tbl_location l','l.location_id=p.location_id');
			$this->db->where('p.status !=','-1');
		$this->db->where('l.location_status !=','Deactive');
		$this -> db -> where('p.process_id', 8);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
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
	
	public function send_sms($contactibility,$contact_no)
	{
			//$contactibility = $this -> input -> post('contactibility');
			$q=$this->db->query("select fname,mobileno from lmsuser where id='$this->user_id'")->result();
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
	'user' => 'atvsta',
    'password' => 'atvsta',
    'senderid' => 'ATVSTA',
	'channel'=>'Trans',
	'DCS'=>'0',
	'flashsms'=>'0',
	'route'=>'46',
	'number'=>$contact_no,
	'text'=>$msg
	
);

//merge API url and parameters
$apiUrl = "http://smslogin.ismsexpert.com/api/mt/SendSMS?";
//$apiUrl = "http://domain.ismsexpert.com/api/mt/SendSMS?";
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
public function get_duplicate_record($enq_id)
{
	$getmoblienumberquery=$this->db->query("select contact_no from lead_master where enq_id='$enq_id'")->result();
	if(count($getmoblienumberquery)>0){
		$contact_no=$getmoblienumberquery[0]->contact_no;
	$query=$this->db->query("select enq_id from lead_master where contact_no='$contact_no' and enq_id!='$enq_id' and process='POC Sales'")->result();
		
	}else{
		$query='';
		
	}
	return $query;
	
	
}
}
?>