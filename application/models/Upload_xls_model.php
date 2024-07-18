<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class upload_xls_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> process_name = $this -> session -> userdata('process_name');
	
		$this -> process_id = $_SESSION['process_id'];
		if ($this -> process_id == 6 || $this -> process_id == 7) {
			$this -> table_name = 'lead_master ';
			$this -> evaluation_name = '';
			$this -> evaluation = '';
		}else if($this -> process_id == 8) 
		{
			$this -> table_name = 'lead_master_evaluation ';
			$this -> evaluation_name = ',evaluation';
			$this -> evaluation = ",'Yes'";
		}
		
		else {
			$this -> table_name = 'lead_master_all ';
		}
	}
public function upload4($name,$lead_source,$contact,$los_number,$loan_amount) {

		$created_date = date("Y-m-d");
		//$created_date = '2017-07-05';
		$str_today = strtotime($created_date);
		$time = date("h:i:s A");
		//$lead_source = $this->input->post('lead_source');
		
		if($lead_source=='Web')
		{
			$lead_source='';
		}
		if ($contact != '') {
			$nextaction="(nextAction !='Close' and nextAction != 'Lost')";
			$this -> db -> select('contact_no');
			$this -> db -> from($this -> table_name);
			$this -> db -> where('contact_no', $contact);
				$this -> db -> where('process', $this -> process_name);
			$this -> db -> where($nextaction);
			//$this -> db -> where('enquiry_for', $campaign_name);
			$query2 = $this -> db -> get() -> result();
			$count = count($query2);

			if ($count > 0) {

				//echo "no already exist";
			} else {
			//	$query=mysql_query("SET CHARACTER SET utf8");
		//		$query =mysql_query("SET SESSION collation_connection ='utf8_general_ci'") ;
				//$query=mysql_set_charset('utf8');
				
				/*if($days == '1_months')
				{
					$days=30;
					
				}
				elseif ($days == '2_months')
				{
					$days=60;
				}
				
				elseif ($days == '3_months.'){
					
					$days= '>60';
				}
				
				else {
					$days='';
				}*/
				if($this->process_id =='8'){
							$query = $this -> db -> query("insert into ".$this -> table_name."(process,`name`,`contact_no`,`email`,`created_date`,`enquiry_for`,`created_time`,`lead_source`,`address`,`days60_booking`,`evaluation`)values('$this->process_name','$name','$contact','$email_id','$created_date','$campaign_name','$time','$lead_source','$address','$days','Yes')");
		
				}else{
				$query = $this -> db -> query("insert into ".$this -> table_name."(process,`name`,`contact_no`,`loanamount`,`created_date`,`los_no`,`created_time`,`lead_source`)values('$this->process_name','$name','$contact','$loan_amount','$created_date','$los_number','$time','$lead_source')");
			//	echo "Inserted";			
			
				}
			}

		}

	}
	public function upload1($name, $email_id, $contact, $campaign_name,$address,$days) {

		$created_date = date("Y-m-d");
		//$created_date = '2017-07-05';
		$str_today = strtotime($created_date);
		$time = date("h:i:s A");
		$lead_source = $this->input->post('lead_source');
		
		if($lead_source=='Web')
		{
			$lead_source='';
		}
		if ($contact != '') {
			$nextaction="(nextAction !='Close' and nextAction != 'Lost')";
			$this -> db -> select('contact_no');
			$this -> db -> from($this -> table_name);
			$this -> db -> where('contact_no', $contact);
				$this -> db -> where('process', $this -> process_name);
			$this -> db -> where($nextaction);
			//$this -> db -> where('enquiry_for', $campaign_name);
			$query2 = $this -> db -> get() -> result();
			$count = count($query2);

			if ($count > 0) {

				//echo "no already exist";
			} else {
			//	$query=mysql_query("SET CHARACTER SET utf8");
		//		$query =mysql_query("SET SESSION collation_connection ='utf8_general_ci'") ;
				//$query=mysql_set_charset('utf8');
				
				if($days == '1_months')
				{
					$days=30;
					
				}
				elseif ($days == '2_months')
				{
					$days=60;
				}
				
				elseif ($days == '3_months.'){
					
					$days= '>60';
				}
				
				else {
					$days='';
				}
				if($this->process_id =='8'){
							$query = $this -> db -> query("insert into ".$this -> table_name."(process,`name`,`contact_no`,`email`,`created_date`,`enquiry_for`,`created_time`,`lead_source`,`address`,`days60_booking`,`evaluation`)values('$this->process_name','$name','$contact','$email_id','$created_date','$campaign_name','$time','$lead_source','$address','$days','Yes')");
		
				}else{
				$query = $this -> db -> query("insert into ".$this -> table_name."(process,`name`,`contact_no`,`email`,`created_date`,`enquiry_for`,`created_time`,`lead_source`,`address`,`days60_booking`)values('$this->process_name','$name','$contact','$email_id','$created_date','$campaign_name','$time','$lead_source','$address','$days')");
			//	echo "Inserted";			
			
				}
			}

		}

	}
public function upload3($name,$email_id,$contact,$address,$lead_date,$cse_name,$cse_date,$disposition,$cse_remark,$cse_nfd,$tdhv_date,$booking_within_days,$dse_call_date,$dse_name,$dse_disposition,$dse_remark,$dse_nfd,$buyer_type,$model,$variant,$old_make,$old_model,$mfg,$lead_source,$campaign_name)
	{
		//new model id
		if($model!='')
		{
		$this -> db -> select('model_id') -> from('make_models') -> where('model_name', $model);
		$query = $this -> db -> get() -> result();
		if(count($query)>0){
		foreach ($query as $row) {

			$new_model_id = $row -> model_id;

			//echo $model_id;
		}
		}else{
			$new_model_id='';
		}
		}else
			{
				$new_model_id='';
			}
			///////////////
			if($variant!=''&& $model!='')
			{
		$this -> db -> select('variant_id');
		$this -> db -> from('model_variant');
		$this -> db -> where('variant_name', $variant);
		$this -> db -> where('model_id', $new_model_id);

		$query = $this -> db -> get() -> result();
		if(count($query)>0){
		foreach ($query as $row) {

			$new_variant_id = $row -> variant_id;

		}
		}else{
			$new_variant_id='';
		}
			}else{
				$new_variant_id='';
			}
			
			if($old_make!='')
		{
		$this -> db -> select('make_id') -> from('makes') -> where('make_name', $old_make);
		$query = $this -> db -> get() -> result();
		foreach ($query as $row) {

			$old_make_id = $row -> make_id;

			//echo $model_id;
		}
		}else{
			$old_make_id=" ";
		}
		if($old_model!='' && $old_make!='')
		{
		$this -> db -> select('model_id') -> from('make_models') -> where('model_name', $old_model)-> where('make_id', $old_make_id);
		$query = $this -> db -> get() -> result();
	if(count($query)>0){
		foreach ($query as $row) {

			$old_model_id = $row -> model_id;

			//echo $model_id;
		}
	}else{
		$old_model_id = '';
	}
		}else{
			$old_model_id = '';
		}
			////////////////////////
		
		//GET CSE And DSE ID and Assign Date
		
		if($dse_name==''){
			//if dse_name blank
			$assign_by_cse_tl=3;
			$assign_to_cse=$cse_name;
			$assign_by_dse=0;
			$assign_to_dse_tl=0;
			$assign_to_dse=0;
			$assign_to_cse_date=$lead_date;	
			$assign_to_dse_tl_date='0000-00-00';
			$assign_to_dse_date='0000-00-00';
		}
else{
	//if dse_name 
	$assign_user=$this->db->query("select role from lmsuser where id='$dse_name'")->result();
	if(count($assign_user)>0){
		//If user dse_tl
		if($assign_user[0]->role==5){
			$assign_by_cse_tl=3;
			$assign_to_dse_tl=$dse_name;
			if($cse_name!=''){
				$assign_by_dse=$cse_name;
				$assign_to_cse=$cse_name;
				$assign_to_cse_date=$lead_date;	
			}else{
				$assign_by_dse=3;echo "<br>";
				$assign_to_cse=0;echo "<br>";
			
				$assign_to_cse_date='0000-00-00';
			}
			if($dse_call_date!='0000-00-00'){
				$assign_to_dse_tl_date=$dse_call_date;
			}else{
				$assign_to_dse_tl_date=$cse_date;
			}
			$assign_to_dse=0;
			$assign_to_dse_date='0000-00-00';
		}
		if($assign_user[0]->role ==4){
			//if user dse
			$get_dse_tl=$this->db->query("select tl_id from tbl_mapdse where dse_id='$dse_name' ")->result();
			$assign_by_cse_tl=3;
		
			 $assign_to_dse_tl=$get_dse_tl[0]->tl_id;
			$assign_to_dse=$dse_name;
			$assign_by_cse_tl=3;
			if($cse_name!=''){
				$assign_to_cse=$cse_name;
				$assign_by_dse=$cse_name;
					$assign_to_cse_date=$lead_date;
				
			}else{
				$assign_to_cse=0;echo "<br>";
				$assign_by_dse=3;echo "<br>";
				$assign_to_cse_date='0000-00-00';
			}
			if($dse_call_date!='0000-00-00'){
				$assign_to_dse_date=$dse_call_date;
				$assign_to_dse_tl_date=$dse_call_date;
			}else{
				$assign_to_dse_date=$cse_date;
				$assign_to_dse_tl_date=$cse_date;
			}
			
			
		}
	}
}

////////////////////////
//Get cse and dse dispotion for next followup and feedback
if($disposition=="Not reachable" || $disposition=="Switched off" || $disposition=="Ringing")
		{
			$nextaction="Follow-up";
			$feedback="Not Connected";
			
			
		}
		else if($disposition=="Evaluation alloted" || $disposition=="Price Quotation required" || $disposition=="Deal" || $disposition=="Callback" || $disposition=="POC")
		{
			
			$nextaction="Follow-up";
			$feedback="Interested";
			
		}
		
		else if($disposition=="Busy")
		{
			$nextaction="Follow-up";
			$feedback="Busy";
			
	
		}
		else if($disposition=="Home Visit")
		{
			$nextaction="Home Visit";
			$feedback="Interested";
			
	
		}
		else if($disposition=="TD allotted")
		{
			$nextaction="Test Drive";
			$feedback="Interested";
			
	
		}
		else if($disposition=="Showroom Visit")
		{
			$nextaction="Showroom Visit";
			$feedback="Interested";
			
	
		}
		else{
			
			$nextaction="Follow-up";
			$feedback="Undecided";
			
			
		}
		if($dse_disposition=="Not reachable" || $dse_disposition=="Switched off" || $dse_disposition=="Ringing")
		{
			
			$dse_nextaction="Follow-up";
			$dse_feedback="Not Connected";
			
		}
		else if($dse_disposition=="Evaluation alloted" || $dse_disposition=="Price Quotation required" || $dse_disposition=="Deal" || $dse_disposition=="Callback" || $dse_disposition=="POC")
		{
			
			
			$dse_nextaction="Follow-up";
			$dse_feedback="Interested";
		}
		
		else if($dse_disposition=="Busy")
		{
			
			$dse_nextaction="Follow-up";
			$dse_feedback="Busy";
	
		}
		else if($dse_disposition=="Home Visit")
		{
			
			$dse_nextaction="Home Visit";
			$dse_feedback="Interested";
	
		}
		else if($dse_disposition=="TD allotted")
		{
			
			$dse_nextaction="Test Drive";
			$dse_feedback="Interested";
	
		}
		else if($dse_disposition=="Showroom Visit")
		{
			
			$dse_nextaction="Showroom Visit";
			$dse_feedback="Interested";
	
		}
		else
		{
			
			$dse_nextaction="Follow-up";
			$dse_feedback="Undecided";
			
		}
		
		echo'name '. $customer_name=$name;echo "<br>";
		echo 'email   '.$email_id;echo "<br>";
		echo 'contact   '.$contact;echo "<br>";
		echo 'lead date   '.$lead_date;echo "<br>";
		echo 'Address   '.$address;echo "<br>";
		echo 'cse call date'.$cse_date;echo "<br>";
		
		echo 'assign_by_cse_tl   '. $assign_by_cse_tl; echo "<br>";
		echo 'assign_to_cse   '. $assign_to_cse; echo "<br>";
		echo 'assign_by_dse   '. $assign_by_dse; echo "<br>";
		echo 'assign_to_dse_tl   '. $assign_to_dse_tl; echo "<br>";
		echo 'assign_to_dse   '. $assign_to_dse; echo "<br>";
		echo 'assign_to_cse_date   '. $assign_to_cse_date; echo "<br>";
		echo 'assign_to_dse_tl_date   '. $assign_to_dse_tl_date; echo "<br>";
		echo 'assign_to_dse_date   '. $assign_to_dse_date; echo "<br>";
		/////////////////////////////////////////
		
					
$query = $this -> db -> query("INSERT INTO lead_master (`name`, `address`, `email`, `contact_no`, `model_id`, `variant_id`, `created_date`, `old_make`, `old_model`, `manf_year`, `days60_booking`,`assign_by_cse_tl` ,`assign_to_cse`, `assign_by_cse`,`assign_to_dse_tl`, `assign_to_dse`, `assign_to_cse_date`, `assign_to_dse_tl_date`, `assign_to_dse_date`, `feedbackStatus`, `nextAction`,`lead_source`,`enquiry_for`) 
	VALUES ('$name', '$address', '$email_id', '$contact', '$new_model_id', '$new_variant_id', '$lead_date', '$old_make_id', '$old_model_id', '$mfg', '$booking_within_days', '$assign_by_cse_tl','$assign_to_cse', '$assign_by_dse','$assign_to_dse_tl', '$assign_to_dse', '$assign_to_cse_date', '$assign_to_dse_tl_date', '$assign_to_dse_date', '$feedback', '$nextaction','$lead_source','$campaign_name')");
		
	echo $this->db->last_query();
		$insert_id = $this -> db -> insert_id();
		if($cse_remark!='')
		{
		$query1 = $this -> db -> query("insert into lead_followup(`comment`,`nextfollowupdate`,`leadid`,`date`,`assign_to`,`days60_booking`,`td_hv_date`,`feedbackStatus`,`nextAction`)
								values('$cse_remark','$cse_nfd','$insert_id','$cse_date','$assign_to_cse','$booking_within_days','$tdhv_date','$feedback','$nextaction')");
		echo $this->db->last_query();
		$insert_id1 = $this -> db -> insert_id();
		$this -> db -> query('update lead_master set cse_followup_id="' . $insert_id1 . '"  where enq_id="' . $insert_id . '"');
		}	
		if($dse_remark!='')
		{
			if($assign_to_dse==0){
			$assign_to_dse=$assign_to_dse_tl;
		}
		$query1 = $this -> db -> query("insert into lead_followup(`comment`,`nextfollowupdate`,`leadid`,`date`,`assign_to`,`days60_booking`,`td_hv_date`,`feedbackStatus`,`nextAction`)
								values('$dse_remark','$dse_nfd','$insert_id','$dse_call_date','$assign_to_dse','$booking_within_days','$tdhv_date','$dse_feedback','$dse_nextaction')");
		echo $this->db->last_query();
		$insert_id1 = $this -> db -> insert_id();
		$this -> db -> query('update lead_master set dse_followup_id="' . $insert_id1 . '"  where enq_id="' . $insert_id . '"');
		
		}
		
		
		
		
		
	}
	
	//public function upload2($name,$email_id,$contact,$location,$lead_date,$assign_to_telecaller,$status,$disposition,$new_model,$new_variant,$buyer_type,$old_make,$old_model,$mfg_yr,$kms,$color,$ownership,$egerness,$created_date_followup,$nfd,$remark,$group_id,$campaign_name)
	public function upload2($name,$email_id,$contact,$address,$lead_date,$cse_name,$cse_date,$disposition,$cse_remark,$cse_nfd,$tdhv_date,$booking_within_days,$dse_call_date,$dse_name,$dse_disposition,$dse_remark,$dse_nfd,$buyer_type,$model,$variant,$old_make,$old_model,$mfg,$lead_source,$campaign_name)
	{
		//$remark=mysql_real_escape_string($remark);
		$assign_by=$_SESSION['user_id'];
		$created_date = date("Y-m-d");
		
		if($this->input->post('lead_source')=='Web')
		{
			$lead_source='';
		}
		else 
		{
			$lead_source = $this->input->post('lead_source');
		}
		$str_today = strtotime($created_date);
		$time = date("H:i:s A");
		if($old_make!='')
		{
		$this -> db -> select('make_id') -> from('makes') -> where('make_name', $old_make);
		$query = $this -> db -> get() -> result();
		foreach ($query as $row) {

			$old_make_id = $row -> make_id;

			//echo $model_id;
		}
		}else{
			$old_make_id=" ";
		}
		if($old_model!='' && $old_make!='')
		{
		$this -> db -> select('model_id') -> from('make_models') -> where('model_name', $old_model)-> where('make_id', $old_make_id);
		$query = $this -> db -> get() -> result();
		foreach ($query as $row) {

			$old_model_id = $row -> model_id;

			//echo $model_id;
		}
		}else{
			$old_model_id = '';
		}
		if($model!='')
		{
		$this -> db -> select('model_id') -> from('make_models') -> where('model_name', $model);
		$query = $this -> db -> get() -> result();
		foreach ($query as $row) {

			$new_model_id = $row -> model_id;

			//echo $model_id;
		}
		}else
			{
				$new_model_id='';
			}
			if($variant!=''&& $model!='')
			{
		$this -> db -> select('variant_id');
		$this -> db -> from('model_variant');
		$this -> db -> where('variant_name', $variant);
		$this -> db -> where('model_id', $new_model_id);

		$query = $this -> db -> get() -> result();

		foreach ($query as $row) {

			$new_variant_id = $row -> variant_id;

		}
			}else{
				$new_variant_id='';
			}
/*
		$this -> db -> select('g.process_id,g.group_id,s.status_name,s.status_id');
		$this -> db -> from('tbl_group g');
		$this -> db -> join('tbl_status s', 's.process_id=g.process_id');
		$this -> db -> where('g.group_id', $group_id);
		$this -> db -> where('s.status_name', $status);

		$query = $this -> db -> get() -> result();

		foreach ($query as $row) {

			$status_id = $row -> status_id;

		}
*/
		/*$this -> db -> select('disposition_id');
		$this -> db -> from('tbl_disposition_status');
		$this -> db -> where('disposition_name', $disposition);
		$this -> db -> where('status_id', $status_id);
		
		$query = $this -> db -> get() -> result();

		foreach ($query as $row) {

			$disposition_id = $row -> disposition_id;

		}
		
		
		//$NFD1 = date('Y-m-d', strtotime(str_replace('/', '-', $NFD)));
		//$NFD2 = date('Y-m-d', strtotime('-1 day', strtotime($NFD1)));
		/*$query = $this -> db -> query("insert into lead_master( `lead_source`,`name`, `email`, `contact_no`, `enquiry_for`, `model_id`, `variant_id`,`buyer_type`, `location`,`assignby`, `assign_to_telecaller`, `created_date`, `assign_date`, `old_make`, `old_model`, `color`, `manf_year`, `ownership`, `km`,`buy_make`,`buy_model`,`budget_from`,`budget_to`)
													values('$lead_source','$name','$email_id','$contact','$campaign_name', '$status_id','$disposition_id','$egerness','','','$buyer_type','$location','$assign_by','$assign_to_telecaller','$lead_date','$lead_date','','','$color','$mfg_yr','$ownership','$kms','$old_make_id','$old_model_id','$budget_from','$budget_to')");
		*/
		
		if($disposition=="Not reachable" || $disposition=="Switched off" || $disposition=="Ringing")
		{
			$nextaction="Follow-up";
			$feedback="Not Connected";
			
			
		}
		else if($disposition=="Evaluation alloted" || $disposition=="Price Quotation required" || $disposition=="Deal" || $disposition=="Callback" || $disposition=="POC")
		{
			
			$nextaction="Follow-up";
			$feedback="Interested";
			
		}
		
		else if($disposition=="Busy")
		{
			$nextaction="Follow-up";
			$feedback="Busy";
			
	
		}
		else if($disposition=="Home Visit")
		{
			$nextaction="Home Visit";
			$feedback="Interested";
			
	
		}
		else if($disposition=="TD allotted")
		{
			$nextaction="Test Drive";
			$feedback="Interested";
			
	
		}
		else if($disposition=="Showroom Visit")
		{
			$nextaction="Showroom Visit";
			$feedback="Interested";
			
	
		}
		else{
			
			$nextaction="Follow-up";
			$feedback="Undecided";
			
			
		}
		if($dse_disposition=="Not reachable" || $dse_disposition=="Switched off" || $dse_disposition=="Ringing")
		{
			
			$dse_nextaction="Follow-up";
			$dse_feedback="Not Connected";
			
		}
		else if($dse_disposition=="Evaluation alloted" || $dse_disposition=="Price Quotation required" || $dse_disposition=="Deal" || $dse_disposition=="Callback" || $dse_disposition=="POC")
		{
			
			
			$dse_nextaction="Follow-up";
			$dse_feedback="Interested";
		}
		
		else if($dse_disposition=="Busy")
		{
			
			$dse_nextaction="Follow-up";
			$dse_feedback="Busy";
	
		}
		else if($dse_disposition=="Home Visit")
		{
			
			$dse_nextaction="Home Visit";
			$dse_feedback="Interested";
	
		}
		else if($dse_disposition=="TD allotted")
		{
			
			$dse_nextaction="Test Drive";
			$dse_feedback="Interested";
	
		}
		else if($dse_disposition=="Showroom Visit")
		{
			
			$dse_nextaction="Showroom Visit";
			$dse_feedback="Interested";
	
		}
		else
		{
			
			$dse_nextaction="Follow-up";
			$dse_feedback="Undecided";
			
		}
		$assign_by_cse=0;
		$assign_to_dse = 0;
		$assign_to_dse_tl= 0;
		$assign_to_cse = 0;
		$call_date_of_dse = '0000-00-00'; 
		$call_date_of_dse_tl='0000-00-00';
		$this -> db -> select('role');
		$this -> db -> from('lmsuser');
		$this -> db -> where('id', $dse_name);
		//$this -> db -> where('status_id', $status_id);
		
		$query = $this -> db -> get() -> result();

		foreach ($query as $row) {

			$role = $row -> role;

		}
		
		if($role=='4'){
				
			$assign_to_dse=$dse_name;
			$call_date_of_dse=$dse_call_date;
			$assign=$dse_name;
			
			$this -> db -> select('tl_id');
		$this -> db -> from('tbl_mapdse');
		$this -> db -> where('dse_id', $dse_name);
		//$this -> db -> group_by('dse_id');
		$query16 = $this -> db -> get();
		$query16 -> result();
			foreach ($query16 as $row) {

			echo $tl_id = $row -> tl_id;

		}
			$assign_to_dse_tl=$tl_id;
			$assign_by_cse=$cse_name;
		}
		if($role=='5'){
				
			$assign_to_dse_tl=$dse_name;
			$call_date_of_dse_tl=$dse_call_date;
			$assign=$dse_name;
		}
		$assign_to_cse=$cse_name;
		
			
		//					$query = $this -> db -> query("INSERT INTO lead_master (`name`, `address`, `email`, `contact_no`, `model_id`, `variant_id`, `created_date`, `created_time`, `old_make`, `old_model`, `manf_year`, `days60_booking`, `assign_to_cse`, `assign_to_dse_tl`, `assign_to_dse`, `assign_to_cse_date`, `assign_to_dse_tl_date`, `assign_to_dse_date`, `feedbackStatus`, `nextAction`,`lead_source`,`enquiry_for`,`assign_by_cse`) 
		//								VALUES ('$name', '$address', '$email_id', '$contact', '$new_model_id', '$new_variant_id', '$lead_date', '$time', '$old_make_id', '$old_model_id', '$mfg', '$booking_within_days', '$assign_to_cse', '$assign_to_dse_tl', '$assign_to_dse', '$cse_date', '$call_date_of_dse_tl', '$call_date_of_dse', '$feedback', '$nextaction','$lead_source','$campaign_name','$cse_name')");
		
		//echo $this->db->last_query();
	//	$insert_id = $this -> db -> insert_id();
	//	if($cse_remark!='')
		//{
	//	$query1 = $this -> db -> query("insert into lead_followup(`comment`,`nextfollowupdate`,`leadid`,`date`,`assign_to`,`days60_booking`,`td_hv_date`,`feedbackStatus`,`nextAction`)
	//							values('$cse_remark','$cse_nfd','$insert_id','$cse_date','$assign_to_cse','$booking_within_days','$tdhv_date','$feedback','$nextaction')");
	//	echo $this->db->last_query();
	//	$insert_id1 = $this -> db -> insert_id();
	//	$this -> db -> query('update lead_master set cse_followup_id="' . $insert_id1 . '"  where enq_id="' . $insert_id . '"');
	//	}	
	//	if($dse_remark!='')
	//	{
	//	$query1 = $this -> db -> query("insert into lead_followup(`comment`,`nextfollowupdate`,`leadid`,`date`,`assign_to`,`days60_booking`,`td_hv_date`,`feedbackStatus`,`nextAction`)
	//							values('$dse_remark','$dse_nfd','$insert_id','$dse_call_date','$assign','$booking_within_days','$tdhv_date','$dse_feedback','$dse_nextaction')");
	//	echo $this->db->last_query();
	//	$insert_id1 = $this -> db -> insert_id();
	//	$this -> db -> query('update lead_master set dse_followup_id="' . $insert_id1 . '"  where enq_id="' . $insert_id . '"');
	//	}

	}

	public function select_grp() {

		$this -> db -> select('*');
		$this -> db -> from('tbl_group');
		if ($_SESSION['role'] != 1) {
			$this -> db -> where('process_id', $_SESSION['process_id']);
		}
		$query1 = $this -> db -> get();
		return $query1 -> result();

	}
	
	
	public function select_lead_source() {

		$this -> db -> select('*');
		$this -> db -> from('lead_source');
		$this->db->where('process_id',$this->process_id);
		$this->db->order_by('lead_source_name','asc');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}
	

	public function select_campaign() {

		$this -> db -> select('*');
		$this -> db -> from('tbl_campaign');
		$this->db->where('process_id',$this->process_id);
		$this->db->order_by('campaign_name','asc');
		$query2 = $this -> db -> get();
		return $query2 -> result();
	}

	public function refresh_campaign($lead_source) {

		$this -> db -> select('*');
		$this -> db -> from('sub_lead_source');
		$this -> db -> where('lead_source_name', $lead_source);
		$this->db->where('process_id',$this->process_id);
		$this->db->where('sub_lead_source_status!=','Deactive');
		$this->db->order_by('sub_lead_source_name','asc');
		$query3 = $this -> db -> get();
		//echo $this->db->last_query();
		return $query3 -> result();

	}
public function upload_poc($name,$contact,$email_id,$make,$model,$fuel_type,$year,$budget,$location,$campaign_name,$lead_source){
	
	
	
	 $arrlength=count($contact);
	
	$created_date=date('Y-m-d');
		$time = date("H:i:s A");
	$group_id=$this->input->post('group_name');
		$lead_source=$this->input->post('lead_source');
for($x = 0; $x < $arrlength; $x++) {
		$nextaction="(nextAction !='Close' and nextAction != 'Lost')";
	$search_query=$this->db->query("select enq_id from ".$this->table_name." where contact_no='$contact[$x]' and process='".$this->process_name."' and ".$nextaction)->result();
	if(count($search_query)>0){}else{
			//new model id
		if($model!='')
		{
		$this -> db -> select('model_id') -> from('make_models') -> where('model_name', $model[$x]);
		$query = $this -> db -> get() -> result();
		if(count($query)>0){
		foreach ($query as $row) {

			$model_id = $row -> model_id;

			//echo $model_id;
		}
		}else{
			$model_id='';
		}
		}else
			{
				$model_id='';
			}
			///////////////
		
			if($make!='')
		{
		$this -> db -> select('make_id') -> from('makes') -> where('make_name', $make[$x]);
		$query = $this -> db -> get() -> result();
		foreach ($query as $row) {

			$make_id = $row -> make_id;

			//echo $model_id;
		}
		}else{
			$make_id=" ";
		}
		
		
	$query = $this -> db -> query("INSERT INTO ".$this -> table_name." (`process`,`name`, `contact_no`, `email`, `old_make`, `old_model`, `fuel_type`, `manf_year`,`budget_from`,`address`,`created_date`,`created_time` ,`lead_source`,`enquiry_for`".$this -> evaluation_name.") 
	VALUES ('".$this -> process_name."','$name[$x]','$contact[$x]','$email_id[$x]','$make_id','$model_id','$fuel_type[$x]','$year[$x]','$budget[$x]','$location[$x]','$created_date','$time','$lead_source','$campaign_name'".$this -> evaluation.")");
		
		
		}
		}
		
}





public function insert_loanakaro($data) {
    echo $data;die;
	return $this->db->insert('lead_master_all', $data);
}


public function upload_leads($name, $lead_source, $contact, $los_number, $loan_amount)
{
    $created_date = date("Y-m-d");
    $time = date("h:i:s A");
    if ($lead_source == 'Web') {
        $lead_source = '';
    }
    if ($contact != '') {
        $nextaction = "(nextAction !='Close' and nextAction != 'Lost')";
        $this->db->select('contact_no');
        $this->db->from($this->table_name);
        $this->db->where('contact_no', $contact);
        $this->db->where('process', $this->process_name);
        $this->db->where($nextaction);
        $query2 = $this->db->get();
        $count = $query2->num_rows();
        if ($count > 0) {
            return 'exists';
        } else {
            $data = array(
                'process' => $this->process_name,
                'name' => $name,
                'contact_no' => $contact,
                'loanamount' => $loan_amount,
                'created_date' => $created_date,
                'los_no' => $los_number,
                'created_time' => $time,
                'lead_source' => $lead_source,
            );
            $this->db->insert($this->table_name, $data);
            return 'inserted';
        }
    }
}







}
