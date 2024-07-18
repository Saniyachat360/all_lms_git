<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Add_followup_finance_model extends CI_model {
	function __construct() {
		parent::__construct();
		$this->process_id = $this -> session -> userdata('process_id');
		$this -> location_id = $this -> session -> userdata('location_id');
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');
		$this -> executive_array = array("4", "8", "10", "12", "14");
		$this -> all_array = array("2", "3", "8", "7", "9", "11", "13", "10", "12", "14");
		$this -> tl_array = array("2", "5", "7", "9", "11", "13");
		$this -> tl_list = '("2","5", "7", "9", "11", "13")';
		date_default_timezone_set('Asia/Kolkata');
		$this->time=date("h:i:s A");
	}


	public function select_lead($enq_id) {
		$this -> db -> select('f1.*,l.*,f.pick_up_date,f.executive_name,f.disburse_amount,f.disburse_date,f.process_fee,f.emi,f.approved_date,f.file_login_date,f2.close_status');
		$this -> db -> from('lead_master_all l');
		$this->db->join('lead_followup_all f','f.id=l.cse_followup_id','left');
		$this->db->join('lead_followup_finance f1','f1.enq_id=l.enq_id','left');
		$this->db->join('tbl_loginstatus f2','f2.login_status_name=l.login_status_name','left');
		
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
		//$this -> db -> where('nextActionstatus!=', 'Deactive');
		$query = $this->db->get();
		return $query->result();
	
		
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
// Transfer lead location
	function select_transfer_location($tprocess) 
	{
			$this -> db -> select('l.*');
		$this -> db -> from('tbl_location l');
		$this->db->join('tbl_map_process p','p.location_id=l.location_id');
		$this->db->where('process_id',$tprocess);
		$query = $this->db->get();
		return $query->result();
	
	
		
	}
		//Select lms user
	function lmsuser($location,$tprocess) {
		$toLocation = $location;
		
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
				
			$tl_array = array("2", "3", "5", "7", "9", "11", "13");
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
				
			$tl_array = array("2", "5", "7", "9", "11", "13");
			$this -> db -> where_in('role', $tl_array);
			//$k="(role=3 or role IN ('2','5', '7', '9', '11', '13'))";
			//$this -> db -> where($k);
		} elseif (in_array($from_user_role, $this -> tl_array)) {
			
			$t = ' ( ';
			
			$t = $t . "role in" . $this -> tl_list;
			$st = $t . ')';

			$this -> db -> where($st);
		} elseif (in_array($from_user_role, $this -> executive_array)) {
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
	//	echo $this -> db -> last_query();
		return $query -> result();
		
	}
	public function select_login_status($loan_status=null)
	{
		$this -> db -> select('login_status_name,close_status');
		$this -> db -> from('tbl_loginstatus');
		if(isset($loan_status))
		{
		    $this -> db -> where('login_status_name', $loan_status);
		}
		$this -> db -> where('status!=', '-1');
		$query = $this -> db -> get();
		return $query -> result();
	}
	public function select_followup_lead($enq_id)
	{
		$this -> db -> select('f.*,u.fname,u.lname');
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
		$this->db->where('status!=','-1');
		
		$query = $this -> db -> get();
		return $query -> result();
	}
	public function select_feedback_status()
	{
		$this -> db -> select('*');
		$this -> db -> from('tbl_feedback_status');
		$this->db->where('fstatus!=','Deactive');
		$this->db->where('process_id','1');
		
		$query = $this -> db -> get();
		return $query -> result();
	}
	//Select Nextaction Status
	function next_action_status() {
		
		//$this->db->distinct();
		$this->db->select('nextActionName');
		$this->db->from('tbl_nextaction');
		$this -> db -> where('nextActionstatus!=', 'Deactive');
		$this->db->where('process_id','1');
		$query = $this->db->get();
		return $query->result();
	
		
	}
	public function select_next_action($feedbackStatus)
	{
	$this->db->select('nextActionName');
	$this->db->from('tbl_mapNextAction');
	$this->db->where('feedbackStatusName',$feedbackStatus);
	$this->db->where('map_next_to_feed_status!=','Deactive');
	$this->db->where('process_id','1');
	
	$query=$this->db->get();
	return $query->result();
		
	}
	
	public function insert_followup()
	{
		 $enq_id = $this -> input -> post('booking_id');
		$old_data=$this->db->query("select name,contact_no,lead_source,enquiry_for,email,address,model_id,variant_id,buy_status,buyer_type from lead_master_all where enq_id='".$enq_id."'")->result();
		//print_r($old_data);
		//Basic Followup
		$name=$old_data[0]->name;
		$contact_no=$old_data[0]->contact_no;
		$lead_source=$old_data[0]->lead_source;
		$enquiry_for=$old_data[0]->enquiry_for;
		$assign_to_telecaller = $_SESSION['user_id'];
		$time = date("H:i:s A");
		$alternate_contact_no=$this->input->post('alternate_contact');
	echo $assign_to=$_SESSION['user_id'];

	echo $email=$this->input->post('email');
	echo $feedbackstatus=$this->input->post('feedbackstatus');
	echo $nextAction=$this->input->post('nextAction');
	echo $eagerness=$this->input->post('eagerness');
	echo $address=$this->input->post('address');
	echo $followupdate=$this->input->post('followupdate');
	$followuptime=$this->input->post('followuptime');
	$contactibility = $this -> input -> post('contactibility');
		
	 if($followupdate=='')
		 {
		 	 if($nextAction=='Lost' || $nextAction=='Disbursement'){
		 	$followupdate='0000-00-00';
			$followuptime='00:00:00';
		 }else{
		 	$tomarrow_date = date('Y-m-d', strtotime(' +1 day'));
			
		 	$followupdate = $tomarrow_date;
			$followuptime='11:00:00';
		 }
		 }
		 
	echo $comment1=$this->input->post('comment');
			 $comment = addslashes($comment1);

	echo '<br>';
	echo $bank_name=$this->input->post('bank_name');
	echo $loan_type=$this->input->post('loan_type');
	echo $roi=$this->input->post('roi');
	echo $tenure=$this->input->post('tenure');
	echo $dealer=$this->input->post('dealer');
	echo $car_model=$this->input->post('car_model');
	echo $registration_no=$this->input->post('registration_no');
	echo $los_no=$this->input->post('los_no');
	echo $loanamount=$this->input->post('loan_amount');
	echo '<br>';
	echo $pickup_date=$this->input->post('pickup_date');
	echo $excutive_name=$this->input->post('excutive_name');
	echo $loan_status=$this->input->post('loan_status');
	echo $login_date=$this->input->post('login_date');
	echo $approved_date=$this->input->post('approved_date');
	echo $disburse_date=$this->input->post('disburse_date');
	echo $disburse_amount=$this->input->post('disburse_amount');
	echo $process_fee=$this->input->post('process_fee');
	echo $emi=$this->input->post('emi');
	//Transfer Lead
		 $assign_by = $_SESSION['user_id'];
		 $assign = $this -> input -> post('transfer_assign');
		 $tlocation = $this -> input -> post('tlocation');
		 $transfer_reason = $this -> input -> post('transfer_reason');
	
	$today=date('Y-m-d');
	
	$insert_query=$this->db->query("INSERT INTO `lead_followup_all`(`leadid`, `assign_to`,  `nextfollowupdate`,`nextfollowuptime`,`comment`, `eagerness`,  `feedbackStatus`, `nextAction`, `date`, `pick_up_date`, `executive_name`, `login_status_name`, `disburse_amount`, `disburse_date`, `process_fee`, `emi`, `approved_date`, `file_login_date`,created_time,contactibility) 
	VALUES ('$enq_id','$assign_to','$followupdate','$followuptime','$comment','$eagerness','$feedbackstatus','$nextAction','$today','$pickup_date','$excutive_name','$loan_status','$disburse_amount','$disburse_date','$process_fee','$emi','$approved_date','$login_date','$this->time','$contactibility')");
	$followup_id=$this->db->insert_id();
	$update_query=$this->db->query("update lead_master_all set cse_followup_id='$followup_id', 	alternate_contact_no='$alternate_contact_no',email='$email',eagerness	='$eagerness',feedbackStatus='$feedbackstatus',nextAction='$nextAction',address='$address',bank_name='$bank_name',model_id='$car_model',loan_type='$loan_type',	reg_no='$registration_no',roi='$roi',los_no='$los_no',tenure='$tenure',loanamount='$loanamount',dealer='$dealer',login_status_name='$loan_status' where enq_id='$enq_id'");
	$req_loan_amount=$this->input->post('req_loan_amount');
	$property_type_hl=$this->input->post('property_type_hl');
	$property_details=$this->input->post('property_details');
	$property_cost=$this->input->post('property_cost');
	$builder_name=$this->input->post('builder_name');
	$property_location=$this->input->post('property_location');
	$prop_type=$this->input->post('prop_type');
	$prop_usage=$this->input->post('prop_usage');
	$emp_type=$this->input->post('emp_type');
	$annual_turnover=$this->input->post('annual_turnover');
	$salary_mode=$this->input->post('salary_mode');
		$salary_bank=$this->input->post('salary_bank');
			$prof_type=$this->input->post('prof_type');
				$employer=$this->input->post('employer');
					$monthly_income=$this->input->post('monthly_income');
						$gross_annual=$this->input->post('gross_annual');
	$monthly_net=$this->input->post('monthly_net');
	$monthly_gross=$this->input->post('monthly_gross');
	$designation=$this->input->post('designation');
	$cp_years=$this->input->post('cp_years');
	$pan=$this->input->post('pan');
	$city=$this->input->post('city');
		$reject_reason=$this->input->post('reject_reason');
			$reject_date=$this->input->post('reject_date');
			$payout_percent=$this->input->post('payout_percent');
			$payout_amount=$this->input->post('payout_amount');
			$registration_date=$this->input->post('registration_date');
				$itr19=$this->input->post('itr19');
					$itr20=$this->input->post('itr20');
					$itr21=$this->input->post('itr21');
					$itr22=$this->input->post('itr22');
					if($itr19=='on'){$itr19='Yes';}else{ $itr19='No'; }
					if($itr20=='on'){$itr20='Yes';}else{ $itr20='No'; }
					if($itr21=='on'){$itr21='Yes';}else{ $itr21='No'; }
					if($itr22=='on'){$itr22='Yes';}else{ $itr22='No'; }
	$fquery=$this->db->query("select * from lead_followup_finance where enq_id='$enq_id'")->result();
	if(count($fquery)>0)
	{
	    $update_query=$this->db->query("update lead_followup_finance set req_loan_amount='$req_loan_amount', 
	    property_type_hl='$property_type_hl',property_detail='$property_details',property_cost	='$property_cost',builder_name='$builder_name',property_location='$property_location',
	    property_type_lap='$prop_type',property_usage='$prop_usage',emp_type='$emp_type',annual_turnover='$annual_turnover'
	    ,itr19='$itr19',itr20='$itr20',itr21='$itr21',itr22='$itr22',city='$city',payout_percent='$payout_percent',payout_amount='$payout_amount',registration_date='$registration_date'
	    ,salary_mode='$salary_mode',salary_bank='$salary_bank',prof_type='$prof_type',employer_name='$employer',monthly_income='$monthly_income',reject_reason='$reject_reason'
	    ,gross_annual_profit='$gross_annual',monthly_net='$monthly_net',monthly_gross='$monthly_gross',designation='$designation',current_prof_yr='$cp_years',pan_no='$pan',reject_date='$reject_date'
	    where enq_id='$enq_id'");
	}
	else
	{
    	$insert_query=$this->db->query("INSERT INTO `lead_followup_finance`(`enq_id`, `req_loan_amount`,  `property_type_hl`,property_detail,property_cost,builder_name,property_location,property_type_lap,
    property_usage,emp_type,annual_turnover,salary_mode,salary_bank,prof_type,employer_name,monthly_income,gross_annual_profit,monthly_net,monthly_gross,designation,
    current_prof_yr,pan_no,reject_reason,reject_date,itr19,itr20,itr21,itr22,city,payout_percent,payout_amount,registration_date) 
    	VALUES ('$enq_id','$req_loan_amount','$property_type_hl','$property_details','$property_cost','$builder_name','$property_location','$prop_type',
    	'$prop_usage','$emp_type','$annual_turnover','$salary_mode','$salary_bank','$prof_type','$employer','$monthly_income','$gross_annual','$monthly_net','$monthly_gross','$designation'
    	,'$cp_years','$pan','$reject_reason','$reject_date','$itr19','$itr20','$itr21','$itr22','$city','$payout_percent','$payout_amount','$registration_date')");

	}
	//Transfer Lead
		
		if ($assign != '') {
			
			$tprocess=$this->input->post('tprocess');
			$process_id=$_SESSION['process_id'];
			$today1 = date("Y-m-d");
			$select_process=$this->db->query("select process_name from tbl_process where process_id='$tprocess'")->result();
			$process_name=$select_process[0]->process_name;
			if($tprocess ==6 || $tprocess ==7){
				$table='lead_master';
			}else{
				$table='lead_master_all';
			}
			$check_record=$this->db->query("select contact_no from $table where process='$process_name' and contact_no='$contact_no'")->result();
			if(count($check_record)>0){
				$this -> session -> set_flashdata('msg1', '<div class="alert alert-danger"><strong>Customer Already In Followup ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
				
			}else{
			if($tprocess!=$process_id){
			if($tprocess==7 || $tprocess==6){
			$update1 = $this -> db -> query("update lead_master_all set transfer_process='$process_name' where enq_id='$enq_id'");
			$insert_new_lead = $this -> db -> query("insert into lead_master(process,name,contact_no,email,lead_source,enquiry_for,created_date) values('$process_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today1')");
			$new_enq_id = $this->db->insert_id();
			$transfer_other_process=$this->db->query("INSERT INTO `tbl_maplead`(`from_lead_all`, `to_lead`,`from_process`, `to_process`, `created_date`) 
			VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");

			}else{
				
			$update1 = $this -> db -> query("update lead_master_all set transfer_process='$process_name' where enq_id='$enq_id'");
			$insert_new_lead = $this -> db -> query("insert into lead_master_all(process,name,contact_no,email,lead_source,enquiry_for,created_date) values('$process_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today1')");
			$new_enq_id = $this->db->insert_id();
			$transfer_other_process=$this->db->query("INSERT INTO `tbl_maplead`(`from_lead_all`, `to_lead_all`,`from_process`, `to_process`, `created_date`) 
			VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");
				
			}
						}	else{
			
			
//			if ($group_count == '1') {
			$insertQuery = $this -> db -> query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` ,`transfer_reason`, `location` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $assign . '","' . $assign_by . '","' . $transfer_reason . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
			$transfer_id=$this->db->insert_id();
			echo $this->db->last_query();
			$get_user_role=$this->db->query("select role from lmsuser where id='$assign'")->result();
			
			//Assign CSE To CSE
			if(($get_user_role[0]->role == 13 or $get_user_role[0]->role==14) && $_SESSION['role']==14){
				$assign_user='assign_to_cse='.$assign;
				$assign_date='assign_to_cse_date';
				$user_followup_id='cse_followup_id = 0';
				$assign_by_cse='assign_by_cse='.$assign_by.',';
			}
		
			//Assign DSE TL To DSE TL
		if(($get_user_role[0]->role == 13 or $get_user_role[0]->role==14) && $_SESSION['role']==13){
				$assign_user='assign_to_cse='.$assign;
				$assign_date='assign_to_cse_date';
				$user_followup_id='cse_followup_id = 0';
				$assign_by_cse='';
			}
			
			

			$update1 = $this -> db -> query("update lead_master_all set transfer_id='$transfer_id',".$user_followup_id.",".$assign_user.",".$assign_by_cse.$assign_date."='$today1' where enq_id='$enq_id'");
				echo $this->db->last_query();			
			
		}
		}
		}
	
	}
	public function select_loan_type()
{
		$this -> db -> select('*');
		$this -> db -> from('tbl_loan');
		$this -> db -> where('loan_status', '1');
		$query1 = $this -> db -> get();
		return $query1 -> result();
}
	public function reject_reason()
{
		$this -> db -> select('*');
		$this -> db -> from('tbl_reject_reason');
		$this -> db -> where('status', '1');
		$query1 = $this -> db -> get();
		return $query1 -> result();
}
	public function emp_type()
{
		$this -> db -> select('*');
		$this -> db -> from('tbl_employment_type');
		$this -> db -> where('status', '1');
		$query1 = $this -> db -> get();
		return $query1 -> result();
}
public function prof_type()
{
		$this -> db -> select('*');
		$this -> db -> from('tbl_professional_type');
		$this -> db -> where('status', '1');
		$query1 = $this -> db -> get();
		return $query1 -> result();
}
    public function bank()
    {
    		$this -> db -> select('*');
    		$this -> db -> from('tbl_bank');
    		$this -> db -> where('status', '1');
    		$query1 = $this -> db -> get();
    		return $query1 -> result();
    }
    public function show_docs($loan_id) {
		$this -> db -> select('l.*');
		$this -> db -> from('tbl_document l');
			$this -> db -> join('tbl_document_map a','a.document_id=l.document_id','left');
			//$this->db->join('tbl_loan p','p.loan_id=a.loan_id','left');
			$this -> db -> where('l.status', '1');
		$this -> db -> where('a.loan_id', $loan_id);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}
	public function docs_history($enq_id) {
		$this -> db -> select('l.*,a.document_name,p.loan_name');
		$this -> db -> from('lead_document_finance l');
			$this -> db -> join('tbl_document a','a.document_id=l.document_id','left');
			$this->db->join('tbl_loan p','p.loan_id=l.loan_id','left');
		//	$this -> db -> where('l.status', '1');
		$this -> db -> where('l.enq_id', $enq_id);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}
	public function insert_document()
	{
	    	echo $enq_id=$this->input->post('booking_id');
	    		echo $loan_id=$this->input->post('l_id');
	    	echo $c=$this->input->post('doc_count');
	    	$target_dir1 = "./assets/document/";
	    	for($i=1;$i<=$c;$i++)
	    	{
	    	    echo $doc_id=$this->input->post('docid-'.$i);
	    	    $doc_number=$this->input->post('docn-'.$i);
	    	    if($doc_id !=''){
			$target_file1 = $target_dir1 . basename($enq_id.$doc_id.$_FILES["doc-".$i]["name"]);
			if (move_uploaded_file($_FILES["doc-".$i]["tmp_name"], $target_file1)) {
			$a_name=  $enq_id.$doc_id.$_FILES["doc-".$i]["name"];
			}else{
			    $a_name='';
			}
			if($doc_number !=''){
			
	    	        $q=$this->db->query("select * from lead_document_finance where enq_id='$enq_id' and document_id='$doc_id' and loan_id='$loan_id'")->result();
	    	        if(count($q)>0)
	    	        {
	    	            if($a_name=='')
	    	            {
	    	                $a_name=$q[0]->document;
	    	            }
	    	            $this->db->query("update lead_document_finance set  document='$a_name',document_number='$doc_number' where enq_id='$enq_id' and document_id='$doc_id' and loan_id='$loan_id'");
	    	        }
	    	        else{
	    	        	
	    	    	$insert_query=$this->db->query("INSERT INTO `lead_document_finance`(`enq_id`, `document_id`,  `loan_id`,document,document_number) 
	VALUES ('$enq_id','$doc_id','$loan_id','$a_name','$doc_number')");
			}
	    	        }
	    	    }

	    	}
	}

}
?>
