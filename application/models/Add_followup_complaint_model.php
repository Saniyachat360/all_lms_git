<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Add_followup_complaint_model extends CI_model {
	function __construct() {
		parent::__construct();
		$this->process_id = $_SESSION['process_id'];
		$this -> location_id = $_SESSION['location_id'];
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');
		$this -> executive_array = array("4", "8", "10", "12", "14");
		$this -> all_array = array("2", "3", "8", "7", "9", "11", "13", "10", "12", "14","16");
		$this -> tl_array = array("2", "5", "7", "9", "11", "13","15");
		$this -> tl_list = '("2","5", "7", "9", "11", "13","15")';
		
		
	}
	//Select All Lead Data
	public function select_lead($id) {
	
		$this -> db -> select('l.*');
		$this -> db -> from('lead_master_complaint l');
		$this -> db -> where('l.complaint_id', $id);
		$query = $this -> db -> get();
	//	echo $this->db->last_query();
		return $query -> result();

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
		$this->db->where('process_id',$this->process_id);
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
	

	
	public function send_sms($contactibility,$contact_no)
	{
			//$contactibility = $this -> input -> post('contactibility');
			$q=$this->db->query("select fname,mobileno from lmsuser where id='$this->user_id'")->result();
			if(count($q)>0)
			{
			if($contactibility=='Connected')
			{
				
					$msg='Hello ,Thank you for your enquiry with Autovista Group . In case of any queries,Please contact '.$q[0]->fname.' on '.$q[0]->mobileno.' or visit our website www.autovista.in';
				
			}
			elseif ($contactibility=='Not Connected') {
				$msg='Hello Greetings from Autovista Group. We are unable to reach you on your number at the moment. In case of any queries,Please contact '.$q[0]->fname.' on '.$q[0]->mobileno.' or visit our website www.autovista.in';
			}
			$request = ""; //initialize the request variable
			$param["user"] = "autovista"; //this is the username of our TM4B account
			$param["password"] = "Autoapi@123"; //this is the password of our TM4B account			
			$param["text"] = $msg; //this is the message that we want to send
			$param["PhoneNumber"] = $contact_no; //these are the recipients of the message			
			$param["sender"] = "ATVSTA";//this is our sender 			
			foreach($param as $key=>$val) //traverse through each member of the param array
			{ 
			  $request.= $key."=".urlencode($val); //we have to urlencode the values
			  $request.= "&"; //append the ampersand (&) sign after each paramter/value pair
			}			
			$request = substr($request, 0, strlen($request)-1); //remove the final ampersand sign from the request			
			//First prepare the info that relates to the connection
			$host = "sms.fortunemicrosystem.com";
			$script = "/sendsms.asp";
			$request_length = strlen($request);
			$method = "POST"; // must be POST if sending multiple messages
			if ($method == "GET") 
			{
			  $script .= "?$request";
			}			
			//Now comes the header which we are going to post. 
			$header = "$method $script HTTP/1.1\r\n";
			$header .= "Host: $host\r\n";
			$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$header .= "Content-Length: $request_length\r\n";
			$header .= "Connection: close\r\n\r\n";
			$header .= "$request\r\n";
			
			//Now we open up the connection
			$socket = @fsockopen($host, 80, $errno, $errstr); 
			if ($socket) //if its open, then...
			{ 
			  fputs($socket, $header); // send the details over
			  while(!feof($socket))
			  {
			    $output[] = fgets($socket); //get the results 
			  }
			  fclose($socket); 
			} 
		}
	}
	//Insert Followup
	function insert_followup() {
			
		$today = date("Y-m-d");
		$time1 = date("h:i:s A");
		$time=date("h:i:s A", strtotime($time1));
		$complaint_id = $this -> input -> post('complaint_id');
		$old_data=$this->db->query("select name,contact_no,email,address from lead_master_complaint where complaint_id='".$complaint_id."'")->result();
		
		//Basic Followup
		$name=$old_data[0]->name;
		$contact_no=$old_data[0]->contact_no;
	
		$alternate_contact=$this->input->post('alternate_contact');
		if($this -> input -> post('activity')=='')
		{
			$activity='';
		}
		else {
			$activity = $this -> input -> post('activity');
		}
		$contactibility = $this -> input -> post('contactibility');
		if($contactibility=='Connected' || $contactibility=='Not Connected')
		{
			$this->send_sms($contactibility,$contact_no);
		}
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
		$reg_no = $this -> input -> post('reg_no');
		$complaint_type = $this -> input -> post('complaint_type');
			$location = $this -> input -> post('location');
		 $comment = addslashes($comment1);

	
		$assign_to_telecaller=$this->user_id;
		//Insert in lead_followup
		$insert = $this -> db -> query("INSERT INTO `lead_followup_complaint`
		(`complaint_id`,  `comment`, `nextfollowupdate`, `nextfollowuptime`, `assign_to`, `date` ,`created_time`,`feedbackStatus`,`nextAction`,`contactibility`,web) 
		VALUES ('$complaint_id','$comment','$followupdate','$followuptime','$assign_to_telecaller','$today','$time','$feedback','$nextaction','$contactibility','1')") or die(mysql_error());
		
		$followup_id = $this->db->insert_id();
		//echo $this->db->last_query();
		
		
		$update = $this -> db -> query("update lead_master_complaint set cse_followup_id='$followup_id',email='$email',alternate_contact_no='$alternate_contact',address='$address',
	nextAction='$nextaction',feedbackStatus='$feedback',reg_no='$reg_no',business_area='$complaint_type',location='$location'
	where complaint_id='$complaint_id'");
		//echo $this->db->last_query();
		
		
	}
		
	
	public function select_contact_details(){
		$query=$this->db->query("SELECT * FROM `tbl_contact_details`");
		return $query->result();
	}
	
//Select All Lead Data
	public function select_followup_lead($enq_id) {
		$this -> db -> select('f.id as followup_id,f.date as c_date,f.comment as f_comment,f.nextfollowupdate,f.nextfollowuptime, 
		f.feedbackStatus,f.nextAction,f.created_time,f.contactibility,	 
		u.fname,u.lname
		 ');
		$this -> db -> from('lead_followup_complaint f');
		$this -> db -> join('lmsuser u', 'u.id=f.assign_to','left');
		//$this -> db -> join('tbl_disposition_status d', 'd.disposition_id=f.disposition', 'left');
		//$this -> db -> join('tbl_status s', 's.status_id=d.status_id', 'left');
		$this -> db -> where('f.complaint_id', $enq_id);
		$this -> db -> order_by('f.id', 'desc');
		$query = $this -> db -> get();
		return $query -> result();

	}
	//Select Location

}
?>
