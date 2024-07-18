<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class add_new_customer_model extends CI_Model {
	public $process_name;
	public $role;
	public $user_id;
	public $table_name;
	public $executive_array;
	public $tl_array;
	public $tl_list;
	public function __construct() {
		parent::__construct();
		$this -> process_name = $this -> session -> userdata('process_name');
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');
		$this -> process_id = $_SESSION['process_id'];
		if ($this -> process_id == 6 || $this -> process_id == 7) {
			$this -> table_name = 'lead_master';
			$this -> table_name1 = 'request_to_lead_transfer';
			$this -> table_name2 = 'lead_followup';
		} else {
			$this -> table_name = 'lead_master_all';
			$this -> table_name1 = 'request_to_lead_transfer_all';
			$this -> table_name2 = 'lead_followup_all';

		}
		$this -> executive_array = array("4", "8", "10", "12", "14" , "16");
		$this -> all_array = array("2", "3", "5", "7", "9", "11", "13","15");
		$this -> tl_array = array("2", "5", "7", "9", "11", "13","15");
		$this -> tl_list = '("2","5", "7", "9", "11", "13","15")';
		/*if (in_array($this->role,$this->executive_array)) {
		 $this -> db -> where('assign_to_cse', $this->user_id);*/
	}

	/*public function add_customer($fname, $email, $address, $pnum, $comment, $assign, $dept, $lead_source, $sub_lead_source,$process_id, $transfer_location) {
		$checkProcessName = $this -> db -> query("select process_name from tbl_process where process_id='$process_id'") -> result();
		//print_r($checkProcessName);
		if (count($checkProcessName) > 0) {
			$process = $checkProcessName[0] -> process_name;
		} else {
			echo "hi";
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Error Found ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}
		if ($process_id == 6 || $process_id == 7) {
			$table_name = 'lead_master';
			$table_name1 = 'request_to_lead_transfer';
		} else {
			$table_name = 'lead_master_all';
			$table_name1 = 'request_to_lead_transfer_all';
		}
	$executive_array = array("3", "8", "10", "12", "14");
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

			$time = date("H:i:s A");

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
			$get_role = $this -> db -> query("select role from lmsuser where id='$assign'") -> result();
			echo $assign_user_role = $get_role[0] -> role;

			if ($assign_user_role == 5) {
				//CSETL,CSE,Process TL,process Executove,DSETL,DSE
				if ($this -> role == 2 || $this -> role == 3) {
					
				
					$assignbyCSETL = $this -> user_id;
					$assigntoCSE = $this -> user_id;
					$assignByCSE = $this -> user_id;
				
				} else {
					$assignbyCSETL = 3;
					$assigntoCSE = 3;
					$assignByCSE = 3;
				}
				$assigntoDSETL = $assign;
				$assigntoDSE = 0;
				$assigntoDSEDate = 0;
				$assigntoDSETime = 0;
				

			} elseif ($assign_user_role == 4) {
				if ($this -> role == 4) {
					$checkDSETL = $this -> db -> query("select tl_id from tbl_mapdse where dse_id='$assign'") -> result();
					if (count($checkDSETL) > 0) {
						$assigntoDSETL = $checkDSETL[0] -> tl_id;
					} else {
						$assigntoDSETL = $this -> user_id;
					}
				} else {
					$assigntoDSETL = $this -> user_id;
				}
				$assignbyCSETL = 3;
				$assigntoCSE = 3;
				$assignByCSE = 3;
				$assigntoDSE = $assign;

			} elseif (in_array($assign_user_role, $this -> tl_array)) {
				// CSETL,CSE,ProcessTl,Process Executive,DSETl,DSE
				$assignbyCSETL = $assign;
				$assigntoCSE = $assign;
				$assigntoDSETLDate = 0;
				$assigntoDSEDate = 0;
				$assigntoDSETLTime = 0;
				$assigntoDSETime = 0;
			} elseif (in_array($assign_user_role, $executive_array)) {
				//Team Member,Team TL
			
					$checkProcessTL = $this -> db -> query("select tl_id from tbl_mapdse where dse_id='$assign'") -> result();
					if (count($checkProcessTL) > 0) {
						$assignbyCSETL = $checkProcessTL[0] -> tl_id;
					} else {
						$assignbyCSETL = $this -> user_id;
					}
				
				$assigntoCSE = $assign;

				$assigntoDSETLDate = 0;
				$assigntoDSEDate = 0;
				$assigntoDSETLTime = 0;
				$assigntoDSETime = 0;
			}

			$username = $_SESSION['username'];
			
			$query = $this -> db -> query("insert into " . $table_name . "	(process,`lead_source`,`manual_lead`,`name`,`email`,`address`,`contact_no`,`created_date`,`created_time`,	assign_by_cse_tl,assign_to_cse,assign_to_cse_date,assign_by_cse,assign_to_dse_tl,assign_to_dse_tl_date,assign_to_dse,assign_to_dse_date,assign_to_cse_time,assign_to_dse_tl_time,assign_to_dse_time,web)
				values('$process','$lead_source','$username','$fname','$email','$address','$pnum','$today','$time',	'$assignbyCSETL','$assigntoCSE','$assigntoCSEDate','$assignByCSE','$assigntoDSETL','$assigntoDSETLDate','$assigntoDSE','$assigntoDSEDate','$assigntoCSETime','$assigntoDSETLTime','$assigntoDSETime','1')"); 
			echo $this -> db -> last_query();
			$enq_id = $this -> db -> insert_id();

			$insertQuery1 = $this -> db -> query("INSERT INTO " . $table_name1 . "( `lead_id` , `assign_to` , `assign_by` , `location` , `created_date` , `created_time`  ,status)  VALUES('$enq_id','$assign ','$this->user_id','$transfer_location ',' $assign_date  ','$time ','Transfered')") or die(mysql_error());
			$transfer_id = $this -> db -> insert_id();
			$query = $this -> db -> query("update " . $table_name . " set transfer_id='$transfer_id' where enq_id='$enq_id'");
			// }

			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Customer Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}

	}*/
		public function add_customer($fname, $email, $address, $pnum, $comment, $assign, $dept, $lead_source,$sub_lead_source, $process_id, $transfer_location,$process) {
		    $enq_id=0;
		
		if ($process_id == 6 || $process_id == 7) {
			$table_name = 'lead_master';
			$table_name1 = 'request_to_lead_transfer';
		} else {
			$table_name = 'lead_master_all';
			$table_name1 = 'request_to_lead_transfer_all';
		}
	$executive_array = array("3", "8", "10", "12", "14");
	$nextaction="(nextAction !='Close' and nextAction != 'Lost')";
		$this -> db -> select("*");
		$this -> db -> from($table_name);
		$this -> db -> where('process', $process);
		$this -> db -> where('contact_no', $pnum);
	//	$this -> db -> where('name', 'dtty');
		$this -> db -> where($nextaction);
		$query = $this -> db -> get() -> result();
		echo $this->db->last_query();
		if (count($query) > 0) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Customer Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
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
			$get_role = $this -> db -> query("select role from lmsuser where id='$assign'") -> result();
			echo $assign_user_role = $get_role[0] -> role;

			if ($assign_user_role == 5) {
				//CSETL,CSE,Process TL,process Executove,DSETL,DSE
				if ($this -> role == 2 || $this -> role == 3) {
					
				
					$assignbyCSETL = $this -> user_id;
					$assigntoCSE = $this -> user_id;
					$assignByCSE = $this -> user_id;
				
				} else {
					$getDefaultTl=$this->db->query("select call_center_tl_id from tbl_default_call_center_tl where process_id='$this->process_id' and status=1")->result();
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
				if ($this -> role == 4) {
					$checkDSETL = $this -> db -> query("select tl_id from tbl_mapdse where dse_id='$assign'") -> result();
					if (count($checkDSETL) > 0) {
						$assigntoDSETL = $checkDSETL[0] -> tl_id;
					} else {
						$assigntoDSETL = $this -> user_id;
					}
				} else {
					$assigntoDSETL = $this -> user_id;
				}
				$getDefaultTl=$this->db->query("select call_center_tl_id from tbl_default_call_center_tl where process_id='$this->process_id' and status=1")->result();
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

			} elseif (in_array($assign_user_role, $this -> tl_array)) {
				// CSETL,CSE,ProcessTl,Process Executive,DSETl,DSE
				$assignbyCSETL = $assign;
				$assigntoCSE = $assign;
				$assigntoDSETLDate = 0;
				$assigntoDSEDate = 0;
				$assigntoDSETLTime = 0;
				$assigntoDSETime = 0;
			} elseif (in_array($assign_user_role, $executive_array)) {
				//Team Member,Team TL
			
					$checkProcessTL = $this -> db -> query("select tl_id from tbl_mapdse where dse_id='$assign'") -> result();
					if (count($checkProcessTL) > 0) {
						$assignbyCSETL = $checkProcessTL[0] -> tl_id;
					} else {
						$assignbyCSETL = $this -> user_id;
					}
				
				$assigntoCSE = $assign;

				$assigntoDSETLDate = 0;
				$assigntoDSEDate = 0;
				$assigntoDSETLTime = 0;
				$assigntoDSETime = 0;
			}

			$username = $_SESSION['username'];
			
			$query = $this -> db -> query("insert into " . $table_name . "	(process,`lead_source`,`enquiry_for`,`manual_lead`,`name`,`email`,`address`,`contact_no`,`comment`,`created_date`,`created_time`,	assign_by_cse_tl,assign_to_cse,assign_to_cse_date,assign_by_cse,assign_to_dse_tl,assign_to_dse_tl_date,assign_to_dse,assign_to_dse_date,assign_to_cse_time,assign_to_dse_tl_time,assign_to_dse_time,web)
				values('$process','$lead_source','$sub_lead_source','$username','$fname','$email','$address','$pnum','$comment','$today','$time',	'$assignbyCSETL','$assigntoCSE','$assigntoCSEDate','$assignByCSE','$assigntoDSETL','$assigntoDSETLDate','$assigntoDSE','$assigntoDSEDate','$assigntoCSETime','$assigntoDSETLTime','$assigntoDSETime','1')"); 
			echo $this -> db -> last_query();
			$enq_id = $this -> db -> insert_id();
			if($assign !=$this->user_id)
			{
				$insertQuery1 = $this -> db -> query("INSERT INTO " . $table_name1 . "( `lead_id` , `assign_to` , `assign_by` , `location` , `created_date` , `created_time`)  VALUES('$enq_id','$assign ','$this->user_id','$transfer_location ',' $assign_date  ','$time')") or die(mysql_error());
				$transfer_id = $this -> db -> insert_id();
				$query = $this -> db -> query("update " . $table_name . " set transfer_id='$transfer_id' where enq_id='$enq_id'");
			}
        return $enq_id;
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Customer Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}

	}
public function add_customer_evaluation_new($fname, $email, $address, $pnum, $comment, $assign, $dept, $lead_source,$sub_lead_source, $process_id, $transfer_location) {
		$checkProcessName = $this -> db -> query("select process_name from tbl_process where process_id='$process_id'") -> result();
		print_r($checkProcessName);
		if (count($checkProcessName) > 0) {
			$process = $checkProcessName[0] -> process_name;
		} else {
			echo "hi";
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Error Found ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}
		
	$executive_array = array("3", "8", "10", "12", "14");
	$nextaction="(nextAction !='Close' and nextAction != 'Lost')";
		$this -> db -> select("*");
		$this -> db -> from('lead_master_evaluation');
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
			$get_role = $this -> db -> query("select role from lmsuser where id='$assign'") -> result();
			echo $assign_user_role = $get_role[0] -> role;

			if ($assign_user_role == 15) {
				//CSETL,CSE,Process TL,process Executove,DSETL,DSE
				if ($this -> role == 2 || $this -> role == 3) {
					
				
					$assignbyCSETL = $this -> user_id;
					$assigntoCSE = $this -> user_id;
					$assignByCSE = $this -> user_id;
				
				} else {
					$getDefaultTl=$this->db->query("select call_center_tl_id from tbl_default_call_center_tl where process_id='$this->process_id' and status=1")->result();
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
				

			} elseif ($assign_user_role == 16) {
				if ($this -> role == 16) {
					$checkDSETL = $this -> db -> query("select tl_id from tbl_mapdse where dse_id='$assign'") -> result();
					if (count($checkDSETL) > 0) {
						$assigntoDSETL = $checkDSETL[0] -> tl_id;
					} else {
						$assigntoDSETL = $this -> user_id;
					}
				} else {
					$assigntoDSETL = $this -> user_id;
				}
				$getDefaultTl=$this->db->query("select call_center_tl_id from tbl_default_call_center_tl where process_id='$this->process_id' and status=1")->result();
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

			} elseif (in_array($assign_user_role, $this -> tl_array)) {
				// CSETL,CSE,ProcessTl,Process Executive,DSETl,DSE
				$assignbyCSETL = $assign;
				$assigntoCSE = $assign;
				$assigntoDSETLDate = 0;
				$assigntoDSEDate = 0;
				$assigntoDSETLTime = 0;
				$assigntoDSETime = 0;
			} elseif (in_array($assign_user_role, $executive_array)) {
				//Team Member,Team TL
			
					$checkProcessTL = $this -> db -> query("select tl_id from tbl_mapdse where dse_id='$assign'") -> result();
					if (count($checkProcessTL) > 0) {
						$assignbyCSETL = $checkProcessTL[0] -> tl_id;
					} else {
						$assignbyCSETL = $this -> user_id;
					}
				
				$assigntoCSE = $assign;

				$assigntoDSETLDate = 0;
				$assigntoDSEDate = 0;
				$assigntoDSETLTime = 0;
				$assigntoDSETime = 0;
			}

			$username = $_SESSION['username'];
			
			$query = $this -> db -> query("insert into lead_master_evaluation(evaluation,process,`lead_source`,`enquiry_for`,`manual_lead`,`name`,`email`,`address`,`contact_no`,`comment`,`created_date`,`created_time`,	assign_by_cse_tl,assign_to_cse,assign_to_cse_date,assign_by_cse,assign_to_e_tl,assign_to_e_tl_date,assign_to_e_exe,assign_to_e_exe_date,assign_to_cse_time,assign_to_e_tl_time,assign_to_e_exe_time,web)
				values('Yes','$process','$lead_source','$sub_lead_source','$username','$fname','$email','$address','$pnum','$comment','$today','$time',	'$assignbyCSETL','$assigntoCSE','$assigntoCSEDate','$assignByCSE','$assigntoDSETL','$assigntoDSETLDate','$assigntoDSE','$assigntoDSEDate','$assigntoCSETime','$assigntoDSETLTime','$assigntoDSETime','1')"); 
			echo $this -> db -> last_query();
			$enq_id = $this -> db -> insert_id();
			if($assign !=$this->user_id)
			{
				$insertQuery1 = $this -> db -> query("INSERT INTO request_to_lead_transfer_evaluation( `lead_id` , `assign_to` , `assign_by` , `location` , `created_date` , `created_time`)  VALUES('$enq_id','$assign ','$this->user_id','$transfer_location ',' $assign_date  ','$time')") or die(mysql_error());
				$transfer_id = $this -> db -> insert_id();
				$query = $this -> db -> query("update lead_master_evaluation set transfer_id='$transfer_id' where enq_id='$enq_id'");
			}

			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Customer Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}

	}
	public function add_customer_evaluation($fname, $email, $address, $pnum, $comment, $assign, $dept,$lead_source,$sub_lead_source,$process_id,$location){
		$nextaction="(nextAction !='Close' and nextAction != 'Lost')";
		$this -> db -> select("*");
		$this -> db -> from('lead_master');
		//$this -> db -> where('process', $process);
		$this -> db -> where('contact_no', $pnum);
		$this -> db -> where($nextaction);
		$query = $this -> db -> get() -> result();
		echo $this->db->last_query();
		if (count($query) > 0) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Customer Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
		} else {
		
		
		
		$date=date('Y-m-d');
		$time = date("h:i:s A");
		$checkProcessName = $this -> db -> query("select process_name from tbl_process where process_id='$process_id'") -> result();
		//print_r($checkProcessName);
		if (count($checkProcessName) > 0) {
			$process = $checkProcessName[0] -> process_name;
		} else {
		
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Error Found ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

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
							$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Error Found ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
						}
					
				
				}
		
		
			}else{
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Error Found ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			}
		$username = $_SESSION['username'];
		
		
		$query = $this -> db -> query("insert into lead_master	(process,`lead_source`,`enquiry_for`,`manual_lead`,`name`,`email`,`address`,`contact_no`,`comment`,`created_date`,`created_time`,`assign_to_e_tl`,`assign_to_e_tl_date`,`assign_to_e_tl_time`,`assign_to_e_exe`,`assign_to_e_exe_date`,`assign_to_e_exe_time`,`evaluation` ,web)
				values('$process','$lead_source','$sub_lead_source','$username','$fname','$email','$address','$pnum','$comment','$date','$time','$evaluation_tl','$evaluation_tl_date','$evaluation_tl_time','$evaluation_cse','$evaluation_cse_date','$evaluation_cse_time','Yes','1')");
		//	echo $this -> db -> last_query();
		}
	}
	public function select_lms_user($process_id) {
		$where = "(l.process_id='$process_id' or m.process_id='$process_id')";
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser l');

		$this -> db -> join('tbl_rights r', 'r.user_id=l.id');
		//	$this -> db -> join('tbl_manager_process m', 'm.user_id=l.id','left');
		$this -> db -> where('r.form_name', 'Calling Notification');
		$this -> db -> where('l.process_id', $process_id);
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

	public function select_user($location, $process_id) {
		$location = $this -> input -> post('location');
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser l');
		//$this -> db -> join('tbl_user_group u', 'u.user_id=l.id');
		$this -> db -> join('tbl_manager_process u', 'u.user_id=l.id');
		$this -> db -> join('tbl_rights r', 'r.user_id=l.id');
		$this -> db -> where('r.form_name', 'Calling Notification');
		$this -> db -> where('r.view', '1');
		$this -> db -> where('l.status', '1');
		$this -> db -> where('u.process_id', $process_id);

		if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2 || $_SESSION['role'] == 3) {
			//	echo "hi";
			//$a = "(role=2 or role=3 or role=5)";
			$this -> db -> where_in('role', $this -> all_array);

		} elseif (in_array($this -> role, $this -> tl_array)) {
			$q = $this -> db -> query('select dse_id from tbl_mapdse where tl_id="' . $_SESSION['user_id'] . '"') -> result();

			$c = count($q);
			$t = ' ( ';
			if (count($q) > 0) {

				for ($i = 0; $i < $c; $i++) {

					$t = $t . "id = " . $q[$i] -> dse_id . " or ";

				}

			}
			$t = $t . "role in" . $this -> tl_list;
			$st = $t . ')';
			/*$k=array();
			 for ($i = 0; $i < $c; $i++) {
			 array_push($k,$q[$i] -> dse_id);
			 //	$t = $t . "id = " . $q[$i] -> dse_id . " or ";
			 }
			 print_r($k);
			 $this -> db -> where_in('l.id',$k);
			 $this -> db -> where_in('role', $this -> tl_array);*/
			$this -> db -> where($st);
		} elseif (in_array($this -> role, $this -> executive_array)) {
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
				$t = $t . "role in" . $this -> tl_list;
				$st = $t . ')';

				$this -> db -> where($st);

			} else {
				$t = $t . "role in" . $this -> tl_list;
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

	public function select_dept() {
		$this -> db -> select('*');
		$this -> db -> from('department');
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

	function select_process() {

		/*$this -> db -> select('*');
		$this -> db -> from('tbl_process');

		$query = $this -> db -> get();*/
		$this -> db -> select('distinct(p.process_id) as process_id,p1.process_name');
			$this -> db -> from('tbl_manager_process p');
			$this->db->join('tbl_process p1','p1.process_id=p.process_id');
			//$this->db->join('tbl_location l','l.location_id=p.location_id');
			//$this -> db -> where('p.location_id', $_SESSION['location_id']);
			//$this -> db -> where('p.process_id', $process_id);
			$this -> db -> where('p.user_id', $this->user_id);
			$query = $this -> db -> get();
		return $query -> result();

	}

	public function select_location() {
		$process_id = $this -> input -> post('process_id');
		if($process_id=='')
		{
			$process_id=$this->process_id;
		}
		
		/*$this -> db -> select('*');
		$this -> db -> from('tbl_location');*/
		$this -> db -> select('p.location_id,l.location');
				$this -> db -> from('tbl_map_process p');
			
				$this->db->join('tbl_location l','l.location_id=p.location_id');
				//$this -> db -> where('p.user_id', $this->user_id);
				
					$this -> db -> where('p.process_id', $process_id);
				$this->db->where('p.status !=','-1');
		$this->db->where('l.location_status !=','Deactive');
		$this->db->order_by('l.location','asc');
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function select_location1($location) {
		$this -> db -> select('*');
		$this -> db -> from('tbl_location');
		$this -> db -> where('location_id', $location);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function select_customer() {

		$this -> db -> select('l.enq_id,l.name,l.feedbackStatus,l.nextAction,l.manual_lead,l.email,l.address,l.contact_no,l.enquiry_for,l.lead_source,l.address,l.created_date,f1.date,f1.nextfollowupdate,f1.comment as remark,l.location,u.fname,u.lname');
		$this -> db -> from('lead_master l');

		$this -> db -> join('lmsuser u', 'u.id=l.assign_to_cse');
		//$this -> db -> join('tbl_status s', 's.status_id=l.status');
		//$this -> db -> join('tbl_disposition_status d', 'd.disposition_id=l.disposition', 'left');
		$this -> db -> join('lead_followup f1', 'f1.id=l.cse_followup_id', 'left');

		//if ($_SESSION['role'] == '3') {
		$this -> db -> where('manual_lead', $_SESSION['username']);
		//	}
		$this -> db -> where('manual_lead!=', '');
		$this -> db -> order_by('enq_id', 'desc');
		$this -> db -> limit(100);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function edit_customer($id) {

		$this -> db -> select('l.enq_id,l.name,l.manual_lead,l.email,l.address,l.contact_no,l.enquiry_for,u.id,l.address,t.location,t.location_id,l.assign_to_telecaller,l.comment,u.fname,u.lname');
		$this -> db -> from('lead_master l');
		$this -> db -> join('lmsuser u', 'u.id=l.assign_to_telecaller');
		$this -> db -> join('tbl_location t', 'u.location=t.location_id');

		$this -> db -> where('enq_id', $id);

		$query = $this -> db -> get();
		return $query -> result();

		//echo $this->db->last_query();

	}

	public function update_grp($enq_id, $fname, $email, $pnum, $address, $assign, $location, $comment, $dept) {

		$count = count($dept);
		for ($i = 0; $i < $count; $i++) {
			$department = $dept[$i];
			if ($i == 0) {
				$this -> db -> query('update lead_master set name="' . $fname . '",email="' . $email . '",address="' . $address . '",contact_no="' . $pnum . '",enquiry_for="' . $department . '",assign_to_telecaller="' . $assign . '",comment="' . $comment . '" where enq_id="' . $enq_id . '"');

			} else {
				$today = date("Y-m-d");
				//$str_today = strtotime($today);

				if (function_exists('date_default_timezone_set')) {
					date_default_timezone_set("Asia/Kolkata");
				}
				$time = date("H:i:s A");
				$assign_date = date('Y-m-d');

				if ($assign == '') {
					$assignby = '';

				} else {
					$assignby = $_SESSION['user_id'];

				}

				$username = $_SESSION['username'];

				$query = $this -> db -> query("insert into lead_master(`manual_lead`,`name`,`email`,`address`,`contact_no`,`enquiry_for`,`assignby`,`comment`,`created_date`,`created_time`,`assign_to_telecaller`,assign_date)values
				('$username','$fname','$email','$address','$pnum','$department','$assignby','$comment','$today','$time','$assign','$assign_date')");

			}

		}

	}

	//	$query = $this->db->get();

	//	echo $this->db->last_query();

	function del_customer($enq_id) {
		$this -> db -> query("delete from lead_master where enq_id='$enq_id'");

	}

	public function select_contact() {

		$pnum = $this -> input -> post('pnum');
		$this -> db -> select('
		l.enq_id,l.lead_source,l.name,l.contact_no,l.email,l.created_date,l.location,l.buyer_type,l.manf_year,l.days60_booking,
		m2.make_name,
		m.model_name as new_model_name,
		m1.model_name as old_model_name,
		v.variant_name,
	csef.date as cse_call_date,csef.nextfollowupdate as cse_nfd,csef.comment as cse_comment,csef.nextAction as cse_nextaction,csef.feedbackStatus as cse_feedbackStatus,csef.td_hv_date as cse_td_hv_date,
	dsef.date as dse_call_date,dsef.nextfollowupdate as dse_nfd,dsef.comment as dse_comment,dsef.nextAction as dse_nextaction,dsef.feedbackStatus as dse_feedbackStatus,dsef.td_hv_date as dse_td_hv_date,
	cseu.fname as cse_fname,cseu.lname as cse_lname,
	dseu.fname as dse_fname,dseu.lname as dse_lname,
	');
		$this -> db -> from($this -> table_name.' l');

		$this -> db -> join($this->table_name2 .' csef', 'csef.id=l.cse_followup_id', 'left');
		$this -> db -> join($this->table_name2 .' dsef', 'dsef.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser cseu', 'cseu.id=l.assign_to_cse', 'left');
		
		$this -> db -> join('lmsuser dseu', 'dseu.id=l.assign_to_dse', 'left');
		$this -> db -> join('model_variant v', 'v.variant_id=l.variant_id', 'left');
		$this -> db -> join('make_models m', 'm.model_id=l.model_id', 'left');
		$this -> db -> join('make_models m1', 'm1.model_id=l.old_model', 'left');
		$this -> db -> join('makes m2', 'm2.make_id=l.old_make', 'left');

		$this -> db -> where("contact_no", $pnum);

		//$this -> db -> limit(50);

		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}
/*********************************************** Complaint Function ***************************************************/
	public function add_customer_complaint($fname, $email, $address, $pnum, $comment, $assign, $dept,$lead_source,$process_id,$location){
		
	
		
		$date=date('Y-m-d');
		$time = date("h:i:s A");
		
		$check_role=$this->db->query("select role from lmsuser where id='$assign'")->result();
	
					if($check_role[0]->role==2){
							$cse_tl=$assign;
							$cse=$assign;
							$cse_date=$date;
							$cse_time=$time;
					}else{
					$tl_id=$this->db->query("select tl_id from tbl_mapdse where dse_id='$assign'")->result();
					if(count($tl_id)>0){
							$cse_tl=$tl_id[0]->tl_id;
							 $cse=$assign;
							$cse_date=$date;
							$cse_time=$time;
					}else{
							$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Error Found ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
						}
					
				
				}
		
		
			
		$username = $_SESSION['username'];
		
		
		$query = $this -> db -> query("insert into lead_master_complaint	(`lead_source`,`manual_lead`,`name`,`email`,`address`,`contact_no`,`comment`,`created_date`,`created_time`,`assign_by_cse_tl`,`assign_to_cse`,`assign_to_cse_date`,`assign_to_cse_time`,`web` )
				values('$lead_source','$username','$fname','$email','$address','$pnum','$comment','$date','$time','$cse_tl','$cse','$cse_date','$cse_time','1')");
			//echo $this -> db -> last_query();
			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Customer Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
	}
/*********************************************************************************************************************/
public function sub_lead_source()
{
	$lead_source=$this->input->post('lead_source');
	$process_id=$this->input->post('process_id');
	$query=$this->db->query("select sub_lead_source_id,sub_lead_source_name  from  sub_lead_source where lead_source_name ='$lead_source' and process_id='$process_id' and sub_lead_source_status !='Deactive' ")->result();
	return $query;
	
}

}
