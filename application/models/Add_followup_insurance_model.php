<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Add_followup_insurance_model extends CI_model
{
	

	function __construct()
	{
		parent::__construct();
		$this->process_id = $_SESSION['process_id'];
		$this->location_id = $_SESSION['location_id'];
		$this->role = $this->session->userdata('role');
		$this->user_id = $this->session->userdata('user_id');
		$this->executive_array = array("4", "8", "10", "12", "14");
		$this->all_array = array("2", "3", "8", "7", "9", "11", "13", "10", "12", "14", "16");
		$this->tl_array = array("2", "5", "7", "9", "11", "13", "15");
		$this->tl_list = '("2","5", "7", "9", "11", "13","15")';
	}

	//Select feedbackstatus
	function select_feedback_status()
	{

		//$this->db->distinct();
		$this->db->select('feedbackStatusName');
		$this->db->from('tbl_feedback_status');
		$this->db->where('process_id', $this->process_id);
		$this->db->where('fstatus!=', 'Deactive');
		$query = $this->db->get();
		return $query->result();
	}

	//Map Nextaction and Feedbackstatus
	public function select_next_action()
	{
		$feedback = $this->input->post('feedback');
		$this->db->select('feedbackStatusName,nextActionName');
		$this->db->from('tbl_mapNextAction');
		$this->db->where('feedbackStatusName', $feedback);
		$this->db->where('map_next_to_feed_status!=', 'Deactive');
		$this->db->where('process_id', $_SESSION['process_id']);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	//Select Nextaction Status
	function next_action_status()
	{
		//$this->db->distinct();
		$this->db->select('nextActionName');
		$this->db->from('tbl_nextaction');
		$this->db->where('process_id', $this->process_id);
		$this->db->where('nextActionstatus!=', 'Deactive');
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

	
	
	//Select All Lead Data
	public function select_lead($enq_id)
	{
		$this->db->select('
		u.fname,u.lname,
		v.variant_id,v.variant_name,l.customer_location,l.insurance_type,
		m.model_id as new_model_id,m.model_name as new_model_name,
		m1.model_name as old_model_name,l.process,l.followup_fuel_type,l.followup_stock,f.teams,
		l.reg_no,l.enq_id,name,l.email,l.address,l.alternate_contact_no,l.dms_enq_number,l.contact_no,l.transfer_process	,l.comment,enquiry_for,l.created_date,l.created_time,l.location,l.eagerness,l.days60_booking,l.buyer_type,l.color,l.km,l.manf_year,l.accidental_claim,l.ownership,l.old_make,l.old_model,l.assign_to_dse_tl,
		f.id as followup_id,f.date as c_date,f.contactibility,f.comment as f_comment,f.nextfollowupdate,f.nextfollowuptime,
		f.feedbackStatus,f.nextAction,l.appointment_type,l.appointment_status,l.appointment_date,f.appointment_time,f.appointment_address,l.customer_occupation,l.customer_designation,l.customer_corporate_name,l.interested_in_finance,l.interested_in_accessories,l.interested_in_insurance,l.interested_in_ew,l.esc_level1 ,l.esc_level1_remark,l.esc_level2 ,l.esc_level2_remark ,l.esc_level3 ,esc_level3_remark,l.evaluation_location,
		esc_level1_resolved ,esc_level2_resolved,esc_level3_resolved,esc_level1_resolved_remark ,esc_level2_resolved_remark ,esc_level3_resolved_remark ');
		$this->db->from('lead_master_insurance l');
		$this->db->join('make_models m', 'm.model_id=l.model_id', 'left');
		$this->db->join('model_variant v', 'v.variant_id=l.variant_id', 'left');
		$this->db->join('make_models m1', 'm1.model_id=l.old_model', 'left');
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '2' || $_SESSION['role'] == '1') {
			$this->db->join('lead_followup_insurance f', 'f.id=l.cse_followup_id', 'left');
		} else {
			$this->db->join('lead_followup_insurance f', 'f.id=l.dse_followup_id', 'left');
		}
		$this->db->join('lmsuser u', 'u.id=f.assign_to', 'left');
		$this->db->where('l.enq_id', $enq_id);

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	
	//Insert Followup
	function insert_followup()
	{
		$today1 = date("Y-m-d");
		$time = date("h:i:s A");
		$enq_id = $this->input->post('booking_id');
		$old_data = $this->db->query("select name,dms_enq_number,contact_no,lead_source,enquiry_for,email,address,model_id,variant_id,buy_status,buyer_type,quotation_sent,evaluation_location,assign_by_cse_tl,assign_to_cse,assign_to_cse_date,assign_to_cse_time,transfer_process,edms_booking_id,visitor_number  from lead_master where enq_id='" . $enq_id . "'")->result();
		//print_r($old_data);
		//Basic Followup
		$name = $old_data[0]->name;
		$contact_no = $old_data[0]->contact_no;
		$lead_source = $old_data[0]->lead_source;
		$enquiry_for = $old_data[0]->enquiry_for;
		$dms_enq_number = $old_data[0]->dms_enq_number;
		$assign_to_telecaller = $_SESSION['user_id'];
		$alternate_contact = $this->input->post('alternate_contact');
		if ($this->input->post('activity') == '') {
			$activity = '';
		} else {
			$activity = $this->input->post('activity');
		}
		$contactibility = $this->input->post('contactibility');
		if ($contactibility == 'Connected' || $contactibility == 'Not Connected') {
			//$this->send_sms($contactibility,$contact_no);
		}


		$feedback = $this->input->post('feedback');
		$nextaction = $this->input->post('nextaction');

		$dms_enq_number = $this->input->post('dms_enq_number');
		if (!$dms_enq_number) {
			if ($old_data[0]->dms_enq_number != null) {
				$dms_enq_number = $old_data[0]->dms_enq_number;
			}
		}

		$email = $this->input->post('email');
		if (!$email) {
			if ($old_data[0]->email != null) {
				$email = $old_data[0]->email;
			}
		}
		$showroom_location = $this->input->post('showroom_location');
		$followupdate = $this->input->post('followupdate');
		$followuptime = $this->input->post('followuptime');
		if ($followupdate == '') {
			if ($nextaction == 'Close' || $nextaction == 'Booked From Autovista' || $nextaction == 'Lead Transfer') {
				$followupdate = '0000-00-00';
				$followuptime = '00:00:00';
			} else {
				$tomarrow_date = date('Y-m-d', strtotime(' +1 day'));

				$followupdate = $tomarrow_date;
				$followuptime = '11:00:00';
			}
		}

		/*if($contactibility=='Not Connected')
		{
			 if($nextaction=='Close' || $nextaction=='Booked From Autovista' || $nextaction=='Lead Transfer'){
		 	$followupdate='0000-00-00';
					$followuptime='00:00:00';
				 }else{
				 	$tomarrow_date = date('Y-m-d', strtotime(' +1 day'));
					
				 	$followupdate = $tomarrow_date;
					$followuptime='11:00:00 AM';
				 }				
		}*/
		$address1 = $this->input->post('address');
		if (!$address1) {

			$address1 = $old_data[0]->address;
		}
		$address = addslashes($address1);

		//New Car Details
		$new_model = $this->input->post('new_model');
		if (!$new_model) {
			$new_model = $old_data[0]->model_id;
		}
		$new_variant = $this->input->post('new_variant');
		if (!$new_variant) {
			$new_variant = $old_data[0]->variant_id;
		}
		$book_status = $this->input->post('book_status');
		if (!$book_status) {
			$book_status = $old_data[0]->buy_status;
		}
		$buyer_type = $this->input->post('buyer_type');
		if (!$buyer_type) {
			$buyer_type = $old_data[0]->buyer_type;
		}

		$comment1 = $this->input->post('comment');
		$comment = addslashes($comment1);

		//Exchange Car Details

		$old_make = $this->input->post('old_make');
		$old_model = $this->input->post('old_model');
		$color = $this->input->post('color');
		$ownership = $this->input->post('ownership');
		$mfg = $this->input->post('mfg');
		$km = $this->input->post('km');
		$claim = $this->input->post('claim');

		//Transfer Lead
		$assign_by = $_SESSION['user_id'];
		$assign = $this->input->post('transfer_assign');
		$tlocation = $this->input->post('tlocation');
		$transfer_reason = $this->input->post('transfer_reason');

		//>60 Days Booking
		$days60_booking = $this->input->post('days60_booking');


		//Showroom Location 
		if ($this->input->post('tlocation') != '') {
			$slocation = $this->input->post('tlocation');
		} else {
			$getlocation = $this->db->query("select location from lead_master where enq_id='$enq_id'")->result();
			if (count($getlocation) > 0) {
				$slocation = $getlocation[0]->location;
			} else {
				$slocation = '';
			}
		}

		//Appointment
		$appointment_type = $this->input->post('appointment_type');
		$appointment_date = $this->input->post('appointment_date');
		$appointment_time = $this->input->post('appointment_time');
		$appointment_status = $this->input->post('appointment_status');


		//interested In
		$interested_in_finance = $this->input->post('interested_in_finance');
		$interested_in_accessories = $this->input->post('interested_in_accessories');
		$interested_in_insurance = $this->input->post('interested_in_insurance');
		$interested_in_ew = $this->input->post('interested_in_ew');
		$customer_occupation = $this->input->post('customer_occupation');
		$customer_designation = $this->input->post('customer_designation');
		$customer_corporate_name = $this->input->post('customer_corporate_name');

		//SANIYA code
		$followup_fuel_type = $this->input->post('followup_fuel_type');
		$followup_stock = $this->input->post('followup_stock');
		//eof 

		$teams = $this->input->post('teams');
		$calling_remark = $this->input->post('calling_remark');
		$contactibility = $this->input->post('contactibility');



		//Insert in lead_followup
		$checktime = date("h:i");
		$checkfollowup = $this->db->query("select id from lead_followup_insurance where leadid='$enq_id' and assign_to='$assign_to_telecaller' and date='$today1'
		and comment ='$comment' and contactibility='$contactibility' and created_time like '$checktime%'")->result();
		if (count($checkfollowup) < 1) {
			$insert = $this->db->query("INSERT INTO `lead_followup_insurance`
		(`leadid`,`teams`,`calling_remark`, `comment`, `nextfollowupdate`, `nextfollowuptime`, `assign_to`, `date` ,`created_time`,`feedbackStatus`,`nextAction`,`contactibility`,`appointment_type`,`appointment_date`,`appointment_time`,`appointment_status`,web) 
		VALUES ('$enq_id','$teams','$calling_remark','$comment','$followupdate','$followuptime','$assign_to_telecaller','$today1','$time','$feedback','$nextaction','$contactibility','$appointment_type','$appointment_date','$appointment_time','$appointment_status','1')") or die(mysql_error());


			$followup_id = $this->db->insert_id();
		
			//Update Follow up in lead__master
			if ($_SESSION['role'] == 2 || $_SESSION['role'] == 3) {
				$follwup = 'cse_followup_id=' . $followup_id;
			} else {
				$follwup = 'dse_followup_id=' . $followup_id;
			}
			if (!$appointment_type) {
				if (isset($old_data[0]->appointment_type)) {
					$appointment_type = $old_data[0]->appointment_type;
				} else {
					$appointment_type = '';
				}
			}
			if (!$appointment_date) {
				if (isset($old_data[0]->appointment_date)) {
					$appointment_date = $old_data[0]->appointment_date;
				} else {
					$appointment_date = '';
				}
			}
			if (!$appointment_time) {
				if (isset($old_data[0]->appointment_time)) {
					$appointment_time = $old_data[0]->appointment_time;
				} else {
					$appointment_time = '';
				}
			}

			if (!$appointment_status) {
				if (isset($old_data[0]->appointment_status)) {
					$appointment_status = $old_data[0]->appointment_status;
				} else {
					$appointment_status = '';
				}
			}


			$qlocation = $this->input->post('qlocation');
			if ($qlocation != '') {
				$quotation_sent = 'Yes';
			} else {
				$old_quotation_sent = $old_data[0]->quotation_sent;
				if ($old_quotation_sent != '') {
					$quotation_sent = $old_quotation_sent;
				} else {
					$quotation_sent = '';
				}
			}

			$evaluation_location = $this->input->post('evaluation_location');
			if ($evaluation_location == '') {
				$evaluation_location = $old_data[0]->evaluation_location;
			}
			$edms_booking_id = $this->input->post('edms_booking_id');
			if (!$edms_booking_id) {
				$edms_booking_id = $old_data[0]->edms_booking_id;
			}
			$customer_name = $this->input->post('customer_name');
			
			// echo "Customer name in model: ". $customer_name;
			// exit;
			$customer_location = $this->input->post('customer_location');
			
			if (!$customer_location) {
				if ($old_data[0]->customer_location != null) {
					$email = $old_data[0]->customer_location;
				}
			}
			$insurance_type  = $this->input->post('insurance_type');
			
			if (!$insurance_type) {
				if ($old_data[0]->insurance_type != null) {
					$email = $old_data[0]->insurance_type;
				}
			}

			$update = $this->db->query("update lead_master_insurance set $follwup,customer_location='$customer_location',insurance_type='$insurance_type',location='$slocation',address='$address',
		model_id='$new_model',variant_id='$new_variant',buyer_type='$buyer_type', dms_enq_number = '$dms_enq_number',
		old_make='$old_make',old_model='$old_model',color='$color',ownership='$ownership',manf_year='$mfg',km='$km',accidental_claim='$claim',days60_booking='$days60_booking',nextAction='$nextaction',feedbackStatus='$feedback', 
		appointment_type='$appointment_type',appointment_date='$appointment_date',
		appointment_time='$appointment_time',appointment_status='$appointment_status',
		interested_in_finance='$interested_in_finance',interested_in_accessories='$interested_in_accessories',interested_in_insurance='$interested_in_insurance',interested_in_ew='$interested_in_ew',followup_stock='$followup_stock',followup_fuel_type='$followup_fuel_type',
		customer_occupation='$customer_occupation',customer_corporate_name='$customer_corporate_name',customer_designation='$customer_designation',evaluation_location='$evaluation_location',edms_booking_id='$edms_booking_id' where enq_id='$enq_id'");

			if ($update) {
				$this->session->set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Followup Added Successfully...!</strong>');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Followup Not added ...!</strong>');
			}

			 echo $this->db->last_query();
			


			
		}
	}

	//Insert Followup
	


	

	//Select All Lead Data
	public function select_followup_lead($enq_id)
	{
		$this->db->select('f.id as followup_id,f.date as c_date,i.insurance_type,f.teams,f.calling_remark,f.comment as f_comment,f.nextfollowupdate,f.nextfollowuptime, 
		f.feedbackStatus,f.nextAction,f.created_time,f.contactibility,f.appointment_type,f.appointment_date,f.appointment_time,f.appointment_status , 	 
		u.fname,u.lname
		 ');
		$this->db->from('lead_followup_insurance f');
		$this->db->join('lmsuser u', 'u.id=f.assign_to', 'left');
		$this->db->join('lead_master_insurance i', 'i.enq_id=f.leadid', 'left');
		//$this -> db -> join('tbl_disposition_status d', 'd.disposition_id=f.disposition', 'left');
		//$this -> db -> join('tbl_status s', 's.status_id=d.status_id', 'left');
		$this->db->where('f.leadid', $enq_id);
		$this->db->order_by('f.id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}
	//Select Location
	public function select_location()
	{
		$this->db->select('p.location_id,l.location');
		//	$this -> db -> from('tbl_location');
		$this->db->from('tbl_map_process p');
		$this->db->join('tbl_location l', 'l.location_id=p.location_id');
		$this->db->where('p.process_id', $this->process_id);
		$this->db->where('p.status !=', '-1');
		$this->db->where('l.location_status !=', 'Deactive');
		$query = $this->db->get();

		return $query->result();
	}


	


	
}
