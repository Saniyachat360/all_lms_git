<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_cron_model extends CI_model {
	function __construct() {
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");	
		$this->today=date('Y-m-d');
		$this->time=date("h:i:s A");
	}
	public function select_table($process_id)
	{
		
		if ($process_id == 6 || $process_id == 7) {
			
			$lead_master_table = 'lead_master';
			$lead_followup_table = 'lead_followup';
			$request_to_lead_transfer_table = 'request_to_lead_transfer';
			
			} 
		elseif ($process_id == 8) {
			$lead_master_table = 'lead_master';
			$lead_followup_table = 'lead_followup';
			$request_to_lead_transfer_table = 'request_to_lead_transfer';
			}
		else {
			
			$lead_master_table = 'lead_master_all';
			$lead_followup_table = 'lead_followup_all';
			$request_to_lead_transfer_table = 'request_to_lead_transfer_all';
			}
	
		return array( 'lead_master_table'=>$lead_master_table,'lead_followup_table'=>$lead_followup_table,'request_to_lead_transfer_table'=>$request_to_lead_transfer_table) ;
		
	}

	function check_type($process_id,$sms_type) {
			
		$this->db->select('*');
		$this->db->from('tbl_sms_template');
		$this->db->where('process_id',$process_id);
		$this->db->where('status','1');
		$this->db->where('sms_type',$sms_type);
		$query=$this->db->get();	
		return $query->result();
	}
	function check_type_occassion($process_id,$sms_type,$date) {
			
		$this->db->select('m.*');
		$this->db->from('tbl_sms_template m');
		$this->db->join('tbl_holiday a','a.holiday_id=m.holiday_id');
		$this->db->where('m.process_id',$process_id);
		$this->db->where('m.status','1');
		$this->db->where('m.sms_type',$sms_type);
		$this->db->where('a.date',$date);
			$this->db->where('a.status','1');
		$query=$this->db->get();	
		return $query->result();
	}
	public function check_type_occassion_mail($process_id,$sms_type,$type,$date) 
	 {	
		$this -> db -> select('	GROUP_CONCAT( DISTINCT  a.attachment_name ) as attachment_list,m.*');
		$this -> db -> from('tbl_mail_template m');
		$this->db->join('tbl_mail_attachment a','a.t_id=m.t_id','left');
		$this->db->join('tbl_holiday a1','a1.holiday_id=m.holiday_id');
	//	$this->db->join('tbl_sms_type m2','m2.stype_name=m.sms_type');
			$this -> db -> where('m.process_id',$process_id);
			//$this -> db -> where('email',1);
			$this -> db -> where('type ',$type);
			$this->db->where('sms_type',$sms_type);
				$this->db->where('a1.date',$date);
				$this->db->where('a1.status','1');
		$this->db->group_by('t_id');
		 $this -> db -> order_by('t_id ','desc');

		$query = $this -> db -> get();		
	//	echo $this->db->last_query();
		return $query -> result();

	}
	 public function check_type_mail($process_id,$sms_type,$type) 
	 {	
		$this -> db -> select('	GROUP_CONCAT( DISTINCT  a.attachment_name ) as attachment_list,m.*');//m&m1 are the table name

		$this -> db -> from('tbl_mail_template m');
		$this->db->join('tbl_mail_attachment a','a.t_id=m.t_id','left');
	//	$this->db->join('tbl_sms_type m2','m2.stype_name=m.sms_type');
			$this -> db -> where('m.process_id',$process_id);
			//$this -> db -> where('email',1);
			$this -> db -> where('type ',$type);
			$this->db->where('sms_type',$sms_type);
		$this->db->group_by('t_id');
		 $this -> db -> order_by('t_id ','desc');

		$query = $this -> db -> get();		
	//	echo $this->db->last_query();
		return $query -> result();

	}
	public function check_lead_data($process_id,$process_name,$created_date,$enq_id,$booking_date=null,$delivery_date=null){
	    echo $created_date;
		$table=$this->select_table($process_id);
		$this -> db -> select('contact_no,name,email,enq_id,email1');
		$this -> db -> from($table['lead_master_table'].' ln');
		if($process_id==8){
			if($sub_poc_purchase_session==2)
			{
				$this -> db -> where('ln.nextAction_for_tracking', 'Evaluation Done');
			
			}
			$this -> db -> where('ln.evaluation', 'Yes');
		}else{
		$this -> db -> where('ln.process', $process_name);
		}
		if($created_date !='')
		{echo "hi";
		    $this -> db -> where('ln.created_date', $created_date);
		}
		if($enq_id !='')
		{
		    $this -> db -> where('ln.enq_id', $enq_id);
		}
		if(isset($booking_date))
		{
		    if($booking_date !=''){
		    $this -> db -> where('ln.created_date', $booking_date);
		    }
		}
		if(isset($delivery_date))
		{
		    $this -> db -> where('ln.delivery_date', $delivery_date);
		}
		$this->db->order_by('ln.enq_id','desc');
		$query = $this -> db -> get();
		echo $this->db->last_query();
		return $query -> result();
	}
	
}