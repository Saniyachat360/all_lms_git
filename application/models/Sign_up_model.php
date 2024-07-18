<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class sign_up_model extends CI_Model {
	public function __construct() {
	parent::__construct();
	date_default_timezone_set("Asia/Kolkata");	
		$this->today=date('Y-m-d');
		$this->time=date("h:i:s A");
	
	}	

	
	public function login_with_otp_user()
	{
	$empId=$this -> input->post('empId');	
	$fname=$this -> input->post('fname');
	$lname=$this -> input->post('lname');
	$email=$this -> input->post('email1');
	$mobileno=$this -> input->post('mobileno1');
	$password=$this -> input->post('password1');
	$otp=$this -> input->post('otp');
	if($otp !=$_SESSION['otp_code'])
	{
	    	$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> OTP not Matched  ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			redirect('sign_up/login_with_otp'); 
	}
	$l=0;
	$today=date('Y-m-d');
	//$updated_by=$_SESSION['user_id'];
	//role_id:17
	$role_name="cross_lead_user";
	
		$query=$this->db->query("select email,id from lmsuser where mobileno='$mobileno' ")->result();

		
		if(count($query)>0)
		{
		    echo "al";
		/*	if($query->role=='17')
			{*/
			$query1=$this->db->query("select id,email from lmsuser where mobileno='$mobileno'  AND status='-1'")->result();
			 if(count($query1)>0)
			 {
			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> This Number is Already Registered ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
		redirect('sign_up/login_with_otp'); 
			// $this->db->query("update lmsuser set status='1' where email='$email' AND status='-1' ");
			 
			 }
			 else{
			     echo "correct user";
			     $l=$query[0]->id;
	 
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> This Mail id is Already Registred ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			//	redirect('sign_up'); 
			 }
	/*		}
		else
			{
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> This Mail id is Already Registred ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
				redirect('sign_up'); 
			}*/
		} 
			 
	 else {
				$maxEmpId=$this->db->query("SELECT  empId FROM lmsuser s
	   JOIN (SELECT MAX(id) AS mid FROM lmsuser GROUP BY id) max  ON s.id = max.mid order by s.id desc limit 1")->result();
	   
	   $maxId=substr($maxEmpId[0]->empId,5);
										$maxIdNew=$maxId+1;
										if(strlen($maxIdNew)<2)
										{
											$maxIdNew="AVLMS00".$maxIdNew;
										}
										elseif(strlen($maxIdNew)<3)
										{
											 $maxIdNew="AVLMS0".$maxIdNew;
										}
										else 
										{
											$maxIdNew="AVLMS".$maxIdNew;
										}
										/*if($fname=='')
										{*/
										    $fname='Unknown';
										//
			$this->db->query("insert into  lmsuser (empId,fname,lname,email,mobileno,password,status,role,role_name,date,is_active) 
			value('$maxIdNew','$fname','$lname','$email','$mobileno','$maxIdNew','1','17','Cross Lead User', '$today','Offline')");
			$user_id = $this -> db -> insert_id();
	
			$this->db->query("insert into tbl_rights_cross_lead (user_id,`form_name`,`view`, `insert`, `modify`,`updated_date`) value('$user_id','Add new lead','1','1','1','$today')");
			$this->db->query("insert into tbl_rights_cross_lead (user_id,`form_name`,`view`, `insert`, `modify`,`updated_date`) value('$user_id','Add escalation','1','1','1','$today')");
			$this->db->query("insert into tbl_rights_cross_lead (user_id,`form_name`,`view`, `insert`, `modify`,`updated_date`) value('$user_id','reports','1','1','1','$today')");
	
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Sign up Successfully Please Login ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			$l=$user_id;
			//redirect('login');
			
		  }
	
		return $l;
	
		}
		
			public function insert_user()
	{
	$empId=$this -> input->post('empId');	
	$fname=$this -> input->post('fname');
	$lname=$this -> input->post('lname');
	$email=$this -> input->post('email1');
	$mobileno=$this -> input->post('mobileno1');
	$password=$this -> input->post('password1');
	$today=date('Y-m-d');
	//$updated_by=$_SESSION['user_id'];
	//role_id:17
	$role_name="cross_lead_user";
	
		$query=$this->db->query("select email from lmsuser where email='$email' ")->result();

		
		if(count($query)>0)
		{
			if($query->role=='17')
			{
			$query1=$this->db->query("select email from lmsuser where email='$email'  AND status='-1'")->result();
			 if(count($query1)>0)
			 {
			 
			 $this->db->query("update lmsuser set status='1' where email='$email' AND status='-1' ");
			 
			 }
			 else{
	 
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> This Mail id is Already Registred ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
				redirect('sign_up'); 
			 }
			}
		else
			{
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> This Mail id is Already Registred ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
				redirect('sign_up'); 
			}
		} 
			 
	 else {
			
										
			$this->db->query("insert into   lmsuser (empId,fname,lname,email,mobileno,password,status,role,role_name,date,is_active) value('$empId','$fname','$lname','$email','$mobileno','$password','1','17','Cross Lead User', '$today','Offline')");
			$user_id = $this -> db -> insert_id();
	
			$this->db->query("insert into tbl_rights_cross_lead (user_id,`form_name`,`view`, `insert`, `modify`,`updated_date`) value('$user_id','Add new lead','1','1','1','$today')");
			$this->db->query("insert into tbl_rights_cross_lead (user_id,`form_name`,`view`, `insert`, `modify`,`updated_date`) value('$user_id','Add escalation','1','1','1','$today')");
			$this->db->query("insert into tbl_rights_cross_lead (user_id,`form_name`,`view`, `insert`, `modify`,`updated_date`) value('$user_id','reports','1','1','1','$today')");
	
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>  Sign up Successfully Please Login ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			redirect('login');		
		  }
	
		
	
		}
public function update_profile()
{
    	$id=$this -> input->post('id');	
	$fname=$this -> input->post('fname');
	$lname=$this -> input->post('lname');
	$this->db->query("update lmsuser set fname='$fname',lname='$lname' where id='$id'");
	if( $this->db->affected_rows() > 0){
					$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
	
			 }else{
			 	$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>  Not Updated Successfully  ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			
			 }
}
	public function maxEmpId() {
		$this -> db -> select_max('empId');
		$this -> db -> from('lmsuser');
		//	$this -> db -> where('empId','');
		$query = $this -> db -> get();
		return $query -> result();

	}
public function select_process()
{
	$order="process_id='6' desc, process_id asc";
	$this -> db -> select('*');
		$this -> db -> from('tbl_process');
	$this->db->where('process_id!=','9');
	$this->db->order_by($order);
	$query = $this -> db -> get();
		return $query -> result();
}
public function user_detail()
{
    $cross_lead_user_id = $_SESSION['user_id'];

	$this -> db -> select('*');
		$this -> db -> from('lmsuser');
	$this->db->where('id',$cross_lead_user_id);

	$query = $this -> db -> get();
		return $query -> result();
}
	function lead_source() {
		$process_id = $this -> input -> post('process_id');
		$this -> db -> select('*');
		$this -> db -> from('lead_source');
		$this -> db -> where('process_id', $process_id);
		$this -> db -> where("leadsourceStatus !=", "Deactive");
		$this -> db -> order_by("lead_source_name", "asc");
		$query = $this -> db -> get();
		return $query -> result();

	}
public function sub_lead_source()
{
	$lead_source=$this->input->post('lead_source');
	$process_id=$this->input->post('process_id');
	$query=$this->db->query("select sub_lead_source_id,sub_lead_source_name  from  sub_lead_source where lead_source_name ='$lead_source' and process_id='$process_id' and sub_lead_source_status !='Deactive' ")->result();
	return $query;
	
}
public function add_customer() {
			echo $process_id=$this->input->post('process_id');
			$lead_source='Cross Lead';
			$fname=$this->input->post('fname');
			$email=$this->input->post('email');
			$address=$this->input->post('address');
			$pnum=$this->input->post('pnum');
			$comment=$this->input->post('comment');
			$loan_type=$this->input->post('loan_type');
			if($fname==''){
				$fname='Unknown';
			}
		$checkProcessName = $this -> db -> query("select process_name from tbl_process where process_id='$process_id'") -> result();
	
		if (count($checkProcessName) > 0) {
			$process = $checkProcessName[0] -> process_name;
		} else {
			
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Error Found ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}
		if ($process_id == 6 || $process_id == 7) {
			$table_name = 'lead_master';
		
		} else if ($process_id == 8) {
			$table_name = 'lead_master_evaluation';
		}else{
			$table_name = 'lead_master_all';
		}

	$nextaction="(nextAction !='Close' and nextAction != 'Lost')";
		$this -> db -> select("*");
		$this -> db -> from($table_name);
		$this -> db -> where('process', $process);
		$this -> db -> where('contact_no', $pnum);
		$this -> db -> where($nextaction);
		$query = $this -> db -> get() -> result();
		echo $this->db->last_query();
		if (count($query) > 0) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Customer Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
		} else {

			$today = date("Y-m-d");

			$time = date("h:i:s A");

			$cross_lead_user_id = $_SESSION['user_id'];
			if($process=='POC Purchase'){
				$purchase_field=", evaluation";
				$purchase_field1=", 'Yes'";
			}else{
				$purchase_field="";
				$purchase_field1='';
			}
				$query = $this -> db -> query("insert into " . $table_name . "	(process,`lead_source`,`name`,`email`,`address`,`contact_no`,`comment`,`created_date`,`created_time`,`cross_lead_user_id`,`web`".$purchase_field.")
				values('$process','$lead_source','$fname','$email','$address','$pnum','$comment','$today','$time','$cross_lead_user_id','1'".$purchase_field1.")"); 
				$enq_id=$this->db->insert_id();
				if($process=='Finance')
			{
				$this->db->query("update lead_master_all set loan_type='$loan_type' where enq_id='$enq_id'");
			}
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Customer Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}

	}
public function select_contact() {
//$process=$_SESSION['process_name'];
$id=$_SESSION['user_id'];
		if($process=='New Car' || $process=='POC Sales' )	{
		$table_name='lead_master';
		$ftable_name='lead_followup';
	}else if($process=='POC Purchase'){
		$table_name='lead_master_evaluation';
		$ftable_name='lead_followup_evaluation';
	}else{
		$table_name='lead_master_all';
		$ftable_name='lead_followup_all';
	}
	
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(6);
		
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}		if($process=='POC Purchase'){
		$this -> db -> select('
			ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
			l.process,l.nextAction,l.feedbackStatus,l.days60_booking,
			l.assign_by_cse_tl,l.assign_to_cse,l.cse_followup_id,l.lead_source,l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km
			,l.assign_to_e_exe as assign_to_dse,l.assign_to_e_tl as assign_to_dse_tl,l.exe_followup_id as dse_followup_id,l.cross_lead_escalation_remark');
		}else{
				$this -> db -> select('
			ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
			l.process,l.nextAction,l.feedbackStatus,l.days60_booking,
			l.assign_by_cse_tl,l.assign_to_cse,l.cse_followup_id,l.lead_source,l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km
			,l.assign_to_dse,l.assign_to_dse_tl,l.dse_followup_id,l.cross_lead_escalation_remark');
			
		}
		$this -> db -> from($table_name.' l');
		$this -> db -> join($ftable_name.' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');	
			if($process=='POC Purchase'){
		$this -> db -> join( 'lead_followup f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		}else{
			$this -> db -> join( 'lead_followup f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		}
		$this -> db -> join('tbl_manager_process mp', 'mp.user_id=udsetl.id', 'left');		
		
		$this -> db -> where('l.process', $process);	
		
		$this->db->where('cross_lead_user_id',$id);
	
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		//Limit
		$this -> db -> limit($rec_limit, $offset);
		$query1 = $this -> db -> get()-> result();
		echo $this->db->last_query();				
		return $query1;
	}


public function select_lead($process_id=null) {
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
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
			l.process,l.nextAction,l.feedbackStatus,l.days60_booking,
			l.assign_by_cse_tl,l.assign_to_cse,l.cse_followup_id,l.lead_source,l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km
			,l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id,l.cross_lead_escalation_remark');
		$this -> db -> from('lead_master l');
		$this -> db -> join('lead_followup f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');	
		$this -> db -> join( 'lead_followup f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> join('tbl_manager_process mp', 'mp.user_id=udsetl.id', 'left');		$process_name = $this -> input -> post('process_id');				
		/*if($process_name==''){
				$this -> db -> where('l.process', $process_id);
		}else{
			$this -> db -> where('l.process', $process_name);	
		}*/
		//if search contact no
		if (!empty($_POST['contact_no'])) {
			$contact = $this -> input -> post('contact_no');
			$this -> db -> where("l.contact_no  LIKE '%$contact%'");
		}
		$this->db->where('cross_lead_user_id',$_SESSION['user_id']);
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		//Limit
		//$this -> db -> limit($rec_limit, $offset);
		$query1 = $this -> db -> get()-> result();
	//	echo $this->db->last_query();				
		return $query1;
	}

	// Select All Lead Details
	public function select_lead_count($process_id=null) {
		
		ini_set('memory_limit', '-1');

		$this -> db -> select('count(enq_id) as count_lead');

		$this -> db -> from('lead_master l');
		$process_name = $this -> input -> post('process_id');	
		if($process_name==''){
				$this -> db -> where('l.process', $process_id);
		}else{
			$this -> db -> where('l.process', $process_name);	
		}
	
		/*if($this->process_id==8)
		{
			if($_SESSION['sub_poc_purchase']==2)
			{
				$this -> db -> where('l.nextAction_for_tracking', 'Evaluation Done');
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.tracking_followup_id', 'left');
			}
			else {
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
			}*	
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
			$this -> db -> join('tbl_manager_process mp', 'mp.user_id=udsetl.id', 'left');
			$this -> db -> where('l.evaluation', 'Yes');
			
		}*/
		//else {
		
		//	$this -> db -> where('l.process', $this -> process_name);
	//	}
			
	
		
		//if search contact no
		if (!empty($_POST['contact_no'])) {
			$contact = $this -> input -> post('contact_no');
			$this -> db -> where("l.contact_no  LIKE '%$contact%'");
		}
		$this->db->where('cross_lead_user_id',$_SESSION['user_id']);

		

		
		$query = $this -> db -> get();
	//	echo $this->db->last_query();
		return $query -> result();


	}
public function select_lead_poc_purchase() {

		ini_set('memory_limit', '-1');

		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
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
			l.process,l.nextAction,l.feedbackStatus,l.days60_booking,
			l.assign_by_cse_tl,l.assign_to_cse,l.cse_followup_id,l.lead_source,l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km
			,l.assign_to_e_tl as assign_to_dse_tl,assign_to_e_exe as assign_to_dse,l.exe_followup_id as dse_followup_id,l.cross_lead_escalation_remark');

		$this -> db -> from('lead_master_evaluation l');
		$this -> db -> join('lead_followup_evaluation f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');		
		
			
		/*if($this->process_id==8)
		{
			if($_SESSION['sub_poc_purchase']==2)
			{
				$this -> db -> where('l.nextAction_for_tracking', 'Evaluation Done');
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.tracking_followup_id', 'left');
			}
			else {
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
			}*	
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
			$this -> db -> join('tbl_manager_process mp', 'mp.user_id=udsetl.id', 'left');
			$this -> db -> where('l.evaluation', 'Yes');
			
		}*/
		//else {
			$this -> db -> join( 'lead_followup_evaluation f2', 'f2.id=l.exe_followup_id', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
			$this -> db -> join('tbl_manager_process mp', 'mp.user_id=udsetl.id', 'left');
	//		$this -> db -> where('l.process', $this -> process_name);
	//	}
		//		$process_name = $this -> input -> post('process_id');	
	//	$this -> db -> where('l.process', $process_name);
		$this -> db -> where('l.evaluation', 'Yes');
	
		
		//if search contact no
		if (!empty($_POST['contact_no'])) {
			$contact = $this -> input -> post('contact_no');
			$this -> db -> where("l.contact_no  LIKE '%$contact%'");
		}
		$this->db->where('cross_lead_user_id',$_SESSION['user_id']);

		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');

		//Limit
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
	//	echo $this->db->last_query();
		return $query -> result();

	}

	// Select All Lead Details
	public function select_lead_poc_purchase_count() {
		
		ini_set('memory_limit', '-1');

		$this -> db -> select('count(enq_id) as count_lead');

		$this -> db -> from('lead_master_evaluation l');
		$process_name = $this -> input -> post('process_id');	
		$this -> db -> where('l.process', $process_name);
		$this -> db -> where('l.evaluation', 'Yes');
		/*if($this->process_id==8)
		{
			if($_SESSION['sub_poc_purchase']==2)
			{
				$this -> db -> where('l.nextAction_for_tracking', 'Evaluation Done');
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.tracking_followup_id', 'left');
			}
			else {
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
			}*	
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
			$this -> db -> join('tbl_manager_process mp', 'mp.user_id=udsetl.id', 'left');
			$this -> db -> where('l.evaluation', 'Yes');
			
		}*/
		//else {
		
		//	$this -> db -> where('l.process', $this -> process_name);
	//	}
			
	
		
		//if search contact no
		if (!empty($_POST['contact_no'])) {
			$contact = $this -> input -> post('contact_no');
			$this -> db -> where("l.contact_no  LIKE '%$contact%'");
		}
		$this->db->where('cross_lead_user_id',$_SESSION['user_id']);

		

		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();


	}
public function select_lead_all() {

		ini_set('memory_limit', '-1');

		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
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
			l.process,l.nextAction,l.feedbackStatus,l.days60_booking,
			l.assign_by_cse_tl,l.assign_to_cse,l.cse_followup_id,l.lead_source,l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km
			,l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id,l.cross_lead_escalation_remark');

		$this -> db -> from('lead_master_all l');
		$this -> db -> join('lead_followup_all f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');		
		/*if($this->process_id==8)
		{
			if($_SESSION['sub_poc_purchase']==2)
			{
				$this -> db -> where('l.nextAction_for_tracking', 'Evaluation Done');
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.tracking_followup_id', 'left');
			}
			else {
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
			}*	
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
			$this -> db -> join('tbl_manager_process mp', 'mp.user_id=udsetl.id', 'left');
			$this -> db -> where('l.evaluation', 'Yes');
			
		}*/
		//else {
			$this -> db -> join( 'lead_followup_all f2', 'f2.id=l.dse_followup_id', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
			$this -> db -> join('tbl_manager_process mp', 'mp.user_id=udsetl.id', 'left');
	//		$this -> db -> where('l.process', $this -> process_name);
	//	}
			
		//$process_name = $this -> input -> post('process_id');	
	//	$this -> db -> where('l.process', $process_name);
		
		//if search contact no
		if (!empty($_POST['contact_no'])) {
			$contact = $this -> input -> post('contact_no');
			$this -> db -> where("l.contact_no  LIKE '%$contact%'");
		}
		$this->db->where('cross_lead_user_id',$_SESSION['user_id']);

		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');

		//Limit
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	// Select All Lead Details
	public function select_lead_all_count() {
		
		ini_set('memory_limit', '-1');

		$this -> db -> select('count(enq_id) as count_lead');

		$this -> db -> from('lead_master_all l');
	
		/*if($this->process_id==8)
		{
			if($_SESSION['sub_poc_purchase']==2)
			{
				$this -> db -> where('l.nextAction_for_tracking', 'Evaluation Done');
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.tracking_followup_id', 'left');
			}
			else {
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
			}*	
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
			$this -> db -> join('tbl_manager_process mp', 'mp.user_id=udsetl.id', 'left');
			$this -> db -> where('l.evaluation', 'Yes');
			
		}*/
		//else {
		
		//	$this -> db -> where('l.process', $this -> process_name);
	//	}
			
		$process_name = $this -> input -> post('process_id');	
		$this -> db -> where('l.process', $process_name);
		
		//if search contact no
		if (!empty($_POST['contact_no'])) {
			$contact = $this -> input -> post('contact_no');
			$this -> db -> where("l.contact_no  LIKE '%$contact%'");
		}
		$this->db->where('cross_lead_user_id',$_SESSION['user_id']);

		

		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();


	}
	public function lms_details($id,$process_id) {
		if($process_id=='6' || $process_id=='7' ){
			$table_name='lead_master';
		}else if($process_id=='8'){
			$table_name='lead_master_evaluation';
		}else{
			$table_name='lead_master_all';
		}
		//Get user all details
		if($process_id=='6' || $process_id=='7' ){
			$this -> db -> select('l.enq_id,l.name,l.email,l.alternate_contact_no,l.contact_no,l.address,l.comment,l.feedbackStatus,l.nextAction,l.eagerness,
		l.service_type,l.service_center,l.km,l.pick_up_date,l.pickup_required,l.buyer_type,l.color,l.manf_year,l.ownership,l.accidental_claim,
		l.budget_from,l.budget_to,l.quotated_price,l.evaluation_within_days,expected_price,l.fuel_type,l.reg_no,
		l.appointment_type,l.appointment_date,l.appointment_time,l.appointment_address,l.appointment_status,l.appointment_rating,l.appointment_feedback,
		l.interested_in_finance,l.interested_in_accessories,l.interested_in_insurance,l.interested_in_ew,l.customer_occupation,l.customer_corporate_name,l.customer_designation,
		m1.model_name as old_model,
		m2.make_name as old_make,
		bm1.make_name as buy_make,
		bm2.model_name as buy_model,
		m.model_name,
		v.variant_name,l.esc_level1,l.esc_level2,l.esc_level3,l.esc_level1_remark,l.esc_level2_remark,l.esc_level3_remark,l.esc_level1_resolved,
		l.esc_level2_resolved,l.esc_level3_resolved,l.esc_level1_resolved_remark,l.esc_level2_resolved_remark,l.esc_level3_resolved_remark');
		}else if($process_id=='8'){
				$this -> db -> select('
		m2.make_id as old_make_id,m2.make_name as old_make_name,
		m1.model_id as old_model_id,m1.model_name as old_model_name,
		v1.variant_id as old_variant_id,v1.variant_name as old_variant_name,
		
		l.quotated_price,l.evaluation_within_days,l.comment,l.enq_id,name,l.email,l.address,l.alternate_contact_no,l.contact_no,l.comment,l.enquiry_for,l.created_date,l.created_time,l.process,l.assign_to_e_tl,l.assign_to_e_exe,l.assign_by_cse_tl,l.assign_to_cse,l.buyer_type,l.feedbackStatus,l.nextAction,
		l.old_make,l.old_model,l.old_variant,l.fuel_type,l.reg_no,l.reg_year,l.manf_year,l.color,l.ownership,l.km,l.type_of_vehicle,l.outright,l.old_car_owner_name,l.photo_uploaded,l.hp,l.financier_name,l.accidental_claim,l.accidental_details,l.insurance_type,l.insurance_company,l.insurance_validity_date,l.tyre_conditon,l.engine_work,l.body_work,l.vechicle_sale_category,l.refurbish_cost_bodyshop,l.refurbish_cost_mecahanical,l.refurbish_cost_tyre,l.refurbish_other,l.total_rf,l.price_with_rf_and_commission,l.expected_price,l.selling_price,l.bought_at,l.bought_date,l.payment_date,l.payment_mode,l.payment_made_to,
		l.esc_level1 ,l.esc_level1_remark,l.esc_level2 ,l.esc_level2_remark ,l.esc_level3 ,esc_level3_remark,esc_level1_resolved,esc_level2_resolved,esc_level3_resolved,esc_level1_resolved_remark,esc_level2_resolved_remark,esc_level3_resolved_remark');
			}else{
		$this -> db -> select('l.enq_id,l.name,l.email,l.comment,l.alternate_contact_no,l.contact_no,l.address,,l.feedbackStatus,l.nextAction,l.eagerness,
		l.service_type,l.service_center,l.km,l.pick_up_date,l.pickup_required,l.buyer_type,
		l.bank_name,l.loan_type,l.reg_no,l.roi,l.los_no,l.tenure,l.loanamount,l.dealer,
		m.model_name,l.esc_level1,l.esc_level2,l.esc_level3,l.esc_level1_remark,l.esc_level2_remark,l.esc_level3_remark,l.esc_level1_resolved,
		l.esc_level2_resolved,l.esc_level3_resolved,l.esc_level1_resolved_remark,l.esc_level2_resolved_remark,l.esc_level3_resolved_remark');
		}
		$this -> db -> from($table_name.' l');
		//$this -> db -> join($this->table_name1.' f', 'f.id=l.cse_followup_id', 'left');
		$this -> db -> join('make_models m', 'm.model_id=l.model_id', 'left');
		$this -> db -> join('make_models m1', 'm1.model_id=l.old_model', 'left');
		$this -> db -> join('model_variant v', 'v.variant_id=l.variant_id', 'left');
		if($process_id=='8'){
			$this -> db -> join('model_variant v1', 'v1.variant_id=l.old_variant', 'left');
			}
		$this -> db -> join('makes m2', 'm2.make_id=l.old_make', 'left');
		$this -> db -> join('makes bm1', 'bm1.make_id=l.buy_make', 'left');
		$this -> db -> join('make_models bm2', 'bm2.model_id=l.buy_model', 'left');
		//$this -> db -> join('tbl_status s', 's.status_id=l.status', 'left');

		$this -> db -> where('l.enq_id', $id);
		$query = $this -> db -> get();
		return $query -> result();
	}
public function followup_detail($id,$process_id) {
	if($process_id=='6' || $process_id=='7' ){
			$table_name='lead_master';
		$table_name1="lead_followup";
		}else if($process_id=='8'){
			$table_name='lead_master_evaluation';
			$table_name1="lead_followup_evaluation";
		}else{
			$table_name='lead_master_all';
			$table_name1="lead_followup_all";
		}
		//Get user All Followup Details
			if($process_id=='6' || $process_id=='7'){
				$this -> db -> select('u.fname,u.lname,
		f.contactibility,f.feedbackStatus,f.nextAction,f.assign_to,f.date as call_date,f.created_time,f.nextfollowuptime,f.comment,f.nextfollowupdate,f.pick_up_date,f.visit_status,f.visit_location,f.visit_booked,f.visit_booked_date,f.sale_status,f.car_delivered,f.escalation_type,f.escalation_remark,f.appointment_type,f.appointment_status,f.appointment_date,f.appointment_time');
			
				}else if($process_id=='8'){
						$this -> db -> select('u.fname,u.lname,	f.id as followup_id,f.created_time,f.comment,f.date as call_date,f.contactibility,f.comment as f_comment,f.nextfollowupdate,f.nextfollowuptime,f.feedbackStatus,f.nextAction,f.appointment_type,f.appointment_status,f.appointment_date,f.appointment_time' );
		
			}else{
		$this -> db -> select('u.fname,u.lname,
		f.contactibility,f.feedbackStatus,f.nextAction,f.created_time,f.nextfollowuptime,f.assign_to,f.date as call_date,f.comment,f.nextfollowupdate,f.pick_up_date,f.executive_name,f.login_status_name,f.disburse_amount,f.disburse_date,f.process_fee,f.emi,f.approved_date,f.file_login_date,f.appointment_type,f.appointment_status,f.appointment_date,f.appointment_time');
			}
		$this -> db -> from($table_name.' l');
		$this -> db -> join('make_models m', 'm.model_id=l.model_id', 'left');
		$this -> db -> join($table_name1.' f', 'f.leadid=l.enq_id');
		$this -> db -> join('lmsuser u', 'u.id=f.assign_to', 'left');

		$this -> db -> where('f.leadid', $id);
		$this -> db -> order_by('f.id', 'desc');
		$query = $this -> db -> get();
		return $query -> result();

	}
function select_manager_remark($id) {

		$this -> db -> select('remark ');
		$this -> db -> from('tbl_manager_remark');
		$this -> db -> where('lead_id', $id);
		$this -> db -> order_by('remark_id', 'desc');
		$query = $this -> db -> get();
		//	echo $this->db->last_query();
		return $query -> result();
	}
	public function select_accessories_list($enq_id) {
		$this -> db -> select('*');
		$this -> db -> from('accessories_order_list a ');
		$this -> db -> join('make_models m', 'm.model_id=a.model');
		$this -> db -> where('enq_id', $enq_id);
		$this -> db -> where('a.status!=', '-1');
		$query = $this -> db -> get();
		return $query -> result();
	}
	public function insert_escalation()
	{
		$remark=$this->input->post('cross_lead_escalation_remark');
			$enq_id=$this->input->post('enq_id');
			$process_id=$this->input->post('process_name');
		if($process_id=='New Car' || $process_id=='POC Sales' ){
			$table_name='lead_master';
		
		}else if($process_id=='POC Purchase'){
			$table_name='lead_master_evaluation';
			
		}else{
			$table_name='lead_master_all';
		
		}
		
		
		$query=$this->db->query("update ".$table_name." set cross_lead_escalation_remark='$remark' where enq_id='$enq_id'");
		
		if( $this->db->affected_rows() > 0){
					$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>Escalation Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
	
			 }else{
			 	$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Escalation Not Added Successfully  ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			
			 }
		} 
	
		
}

		
?>