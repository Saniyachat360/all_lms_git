<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Add_followup_evaluation_tracking_model extends CI_model {
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
	
	
	

	
	//Select All Lead Data
	public function select_lead($enq_id) {
		$this -> db -> select('
		u.fname,u.lname,
		m.make_id as old_make_id,m.make_name as old_make_name,
		m1.model_id as old_model_id,m1.model_name as old_model_name,
		v.variant_id as old_variant_id,v.variant_name as old_variant_name,
	
		f.id as followup_id,f.date as c_date,f.contactibility,f.comment as f_comment,f.nextfollowupdate,f.nextfollowuptime,f.feedbackStatus,f.nextAction,f.appointment_type,f.appointment_status,f.appointment_date,f.appointment_time,f.appointment_address ,
		
		l.enq_id,name,l.email,l.address,l.alternate_contact_no,l.contact_no,l.comment,l.enquiry_for,l.created_date,l.created_time,l.process,l.assign_to_e_tl,l.assign_to_e_exe,l.assign_by_cse_tl,l.assign_to_cse,
		l.old_make,l.old_model,l.old_variant,l.fuel_type,l.reg_no,l.reg_year,l.manf_year,l.color,l.ownership,l.km,l.type_of_vehicle,l.outright,l.old_car_owner_name,l.photo_uploaded,l.hp,l.financier_name,l.accidental_claim,l.accidental_details,l.insurance_type,l.insurance_company,l.insurance_validity_date,l.tyre_conditon,l.engine_work,l.body_work,l.vechicle_sale_category,l.refurbish_cost_bodyshop,l.refurbish_cost_mecahanical,l.refurbish_cost_tyre,l.refurbish_other,l.total_rf,l.price_with_rf_and_commission,l.expected_price,l.selling_price,l.bought_at,l.bought_date,l.payment_date,l.payment_mode,l.payment_made_to,l.agent_name,l.agent_commision_payable,l.expected_date_of_sale,l.refurbish_cost_battery,
		l.esc_level1 ,l.esc_level1_remark,l.esc_level2 ,l.esc_level2_remark ,l.esc_level3 ,esc_level3_remark,esc_level1_resolved,esc_level2_resolved,esc_level3_resolved,esc_level1_resolved_remark,esc_level2_resolved_remark,esc_level3_resolved_remark');
		$this -> db -> from('lead_master_evaluation l');
		$this -> db -> join('makes m', 'm.make_id=l.old_make', 'left');
		$this -> db -> join('make_models m1', 'm1.model_id=l.old_model', 'left');
		$this -> db -> join('model_variant v', 'v.variant_id=l.old_variant', 'left');
		
		if($_SESSION['role']=='3' || $_SESSION['role']=='2') {
		$this -> db -> join('lead_followup_evaluation f', 'f.id=l.cse_followup_id', 'left');
		}elseif($_SESSION['role']=='15' || $_SESSION['role']=='16'|| $_SESSION['role']=='1' ){
			if($_SESSION['sub_poc_purchase']==2){
				$this -> db -> join('lead_followup_evaluation f', 'f.id=l.tracking_followup_id ', 'left');
			}else{
				$this -> db -> join('lead_followup_evaluation f', 'f.id=l.exe_followup_id ', 'left');
			}
		
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
		$old_data=$this->db->query("select name,contact_no,lead_source,enquiry_for,email,address,model_id,variant_id,buy_status,buyer_type,assign_by_cse_tl,assign_to_cse,assign_to_cse_date,assign_to_cse_time,transfer_process  from  lead_master_evaluation where enq_id='".$enq_id."'")->result();
		$name=$old_data[0]->name;
		$contact_no=$old_data[0]->contact_no;
		$lead_source=$old_data[0]->lead_source;
		$enquiry_for=$old_data[0]->enquiry_for;
		$assign_to_telecaller = $_SESSION['user_id'];
		$alternate_contact=$this->input->post('alternate_contact');
		$contactibility = $this -> input -> post('contactibility');
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
		 $old_variant = $this -> input -> post('old_variant');
		 $fuel_type = $this -> input -> post('fuel_type');
		 $registration_no = $this -> input -> post('registration_no');
		 $reg_year = $this -> input -> post('reg_year');
		 $mfg = $this -> input -> post('mfg');
		 $color = $this -> input -> post('color');
		 $ownership = $this -> input -> post('ownership');
		 $km = $this -> input -> post('km');
		 
		 $type_of_vehicle = $this -> input -> post('type_of_vehicle');
		 $outright = $this -> input -> post('outright');
		 $old_car_owner_name = $this -> input -> post('old_car_owner_name');
		 $photo_uploaded = $this -> input -> post('photo_uploaded');
		 $hp = $this -> input -> post('hp');
		 $financier_name = $this -> input -> post('financier_name');
		 $claim = $this -> input -> post('claim');
		 $accidental_details = $this -> input -> post('accidental_details');
		 $insurance_type = $this -> input -> post('insurance_type');
		 $insurance_company= $this -> input -> post('insurance_company');
		 $insurance_validity_date= $this -> input -> post('insurance_validity_date');
		 
		 $tyre_conditon= $this -> input -> post('tyre_conditon');
		 $engine_work= $this -> input -> post('engine_work');
		 $body_work= $this -> input -> post('body_work');
		 $vechicle_sale_category= $this -> input -> post('vechicle_sale_category');
		 $refurbish_cost_bodyshop= $this -> input -> post('refurbish_cost_bodyshop');
		 $refurbish_cost_mecahanical= $this -> input -> post('refurbish_cost_mecahanical');
		 $refurbish_cost_tyre= $this -> input -> post('refurbish_cost_tyre');
		 $refurbish_other= $this -> input -> post('refurbish_other');
		 
		 $total_rf= $this -> input -> post('total_rf');
		 $price_with_rf_and_commission= $this -> input -> post('price_with_rf_and_commission');
		 $expected_price= $this -> input -> post('expected_price');
		 $selling_price= $this -> input -> post('selling_price');
		 $bought_at= $this -> input -> post('bought_at');
		 $bought_date= $this -> input -> post('bought_date');
		 $payment_date= $this -> input -> post('payment_date');
		 $payment_mode= $this -> input -> post('payment_mode');
		 $payment_made_to= $this -> input -> post('payment_made_to');
		
		
			 $refurbish_cost_battery= $this -> input -> post('refurbish_cost_battery');
			  $agent_name= $this -> input -> post('agent_name');
			   $agent_commision_payable= $this -> input -> post('agent_commision_payable');
			    $refurbish_cost_battery= $this -> input -> post('refurbish_cost_battery');
				 $expected_date_of_sale= $this -> input -> post('expected_date_of_sale');


		//Appointment
		$appointment_type = $this->input->post('appointment_type');
		$appointment_date = $this->input->post('appointment_date');
		$appointment_time = $this->input->post('appointment_time');
		$appointment_status = $this->input->post('appointment_status');
	
		 
		
	
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
			if($_SESSION['sub_poc_purchase']==2)
			{
			$follwup='tracking_followup_id ='.$followup_id;
		
			}else{
			$follwup='exe_followup_id ='.$followup_id;
			
			}
			
		}
	$update = $this -> db -> query("update lead_master_evaluation set email='$email',alternate_contact_no='$alternate_contact',address='$address',".$follwup.",
		 appointment_type='$appointment_type',appointment_date='$appointment_date',appointment_time='$appointment_time',appointment_status='$appointment_status',
			`old_make`='$old_make',`old_model`='$old_model',`old_variant`='$old_variant',`fuel_type`='$fuel_type',`reg_no`='$registration_no',`reg_year`='$reg_year',
		 	`manf_year`='$mfg',`color`='$color',`ownership`='$ownership',`km`='$km',`type_of_vehicle`='$type_of_vehicle',`outright`='$outright',`old_car_owner_name`='$old_car_owner_name',
		 	`photo_uploaded`='$photo_uploaded',`hp`='$hp',`financier_name`='$financier_name',`accidental_claim`='$claim',`accidental_details`='$accidental_details',`insurance_type`='$insurance_type',`insurance_company`='$insurance_company',`insurance_validity_date`='$insurance_validity_date',
		 	`tyre_conditon`='$tyre_conditon',`engine_work`='$engine_work',`body_work`='$body_work',`vechicle_sale_category`='$vechicle_sale_category',`refurbish_cost_bodyshop`='$refurbish_cost_bodyshop',
		 	`refurbish_cost_mecahanical`='$refurbish_cost_mecahanical',`refurbish_cost_tyre`='$refurbish_cost_tyre',`refurbish_other`='$refurbish_other',
		 	`total_rf`='$total_rf',`price_with_rf_and_commission`='$price_with_rf_and_commission',`expected_price`='$expected_price',
		 	`selling_price`='$selling_price',`bought_at`='$bought_at',`bought_date`='$bought_date',`payment_date`='$payment_date',`payment_mode`='$payment_mode',`payment_made_to`='$payment_made_to' ,`refurbish_cost_battery`='$refurbish_cost_battery',`agent_name`='$agent_name',`agent_commision_payable`='$agent_commision_payable',`expected_date_of_sale`='$expected_date_of_sale' where enq_id='$enq_id'");
		//echo $this->db->last_query();
		
		if($update){
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Followup Added Successfully...!</strong>');
			} else {
			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Followup Not added ...!</strong>');
			}
		
		}
	

	}
		

//Select All Lead Data
	public function select_followup_lead($enq_id) {
		$this -> db -> select('f.id as followup_id,f.date as c_date,f.comment as f_comment,f.nextfollowupdate,f.nextfollowuptime, 
		f.feedbackStatus,f.nextAction,f.created_time,f.contactibility,	 
		u.fname,u.lname,f.appointment_type,appointment_date,appointment_time,appointment_status
		 ');
		$this -> db -> from('lead_followup_evaluation f');
		$this -> db -> join('lmsuser u', 'u.id=f.assign_to','left');
		$this -> db -> where('f.leadid', $enq_id);
		$this -> db -> order_by('f.id', 'desc');
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
	//Select model using make id
	function select_variant($model) {
		$this -> db -> select('*');
		$this -> db -> from('model_variant');
		$this -> db -> where('model_id', $model);
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
        $esc_level="esc_level1_resolved ='Yes'";
        $esc_remark="esc_level1_resolved_remark  = '".$escalation_remark."'";
    }
    elseif($escalation_type=='Escalation Level 2')
    {
        $esc_level="esc_level2_resolved ='Yes'";
        $esc_remark="esc_level2_resolved_remark = '".$escalation_remark."'";
    }
    elseif ($escalation_type=='Escalation Level 3') {
        $esc_level="esc_level2_resolved ='Yes'";
        $esc_remark="esc_level3_resolved_remark = '".$escalation_remark."'";
    }
    else {
        $esc_level='';
        $esc_remark='';
    }
    $update1 = $this -> db -> query("update lead_master_evaluation set ".$esc_level.",".$esc_remark." where enq_id='$enq_id'");
   
}

}
?>
