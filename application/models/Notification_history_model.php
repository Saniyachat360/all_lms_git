<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_history_model extends CI_model {

	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this -> today = date('Y-m-d');
		$this -> time = date('h:i:s A');
		$this -> user_id = $this -> session -> userdata('user_id');
			$this -> role_id = $this -> session -> userdata('role_id');
	}
	public function insert_notification($notification_name,$notification_url,$n_user_id)
	{
		/*$time1 = strtotime($this->time);
		   $startTime = date("h:i:s A", strtotime('-30 minutes', $time1));
		$q=$this->db->query("select * from tbl_notifications where notification_name='$notification_name' and notification_created_date='$this->today'  and notification_created_time > '$startTime'")->result();
		if(count($q)<1)
		{	*/
			$this->db->query("INSERT INTO `tbl_notifications`(`notification_name`, `notification_status`, `notification_url`,notification_created_date,user_id,notification_created_time) 
				VALUES ('$notification_name','-1','$notification_url','$this->today','$n_user_id','$this->time') ");
		//}
	}
	public function change_status_and_redirect()
	{
			$notification_id=$this->input->post('id');
			$this->db->query("update `tbl_notifications` set notification_status='1' where notification_id='$notification_id'");
	}
	public function notification_leads_count($startTime,$endTime) {
		

		$this -> db -> select('count(u.company_id) as count_lead');
		$this -> db -> from('tbl_company u');
		$this -> db -> join('tbl_followup f', 'f.followup_id=u.last_followup_id', 'left');
		$this -> db -> where('company_status', '1');		
		if($this -> role_id=='5' || $this -> role_id=='4' || $this -> role_id=='3')
		{
			$this -> db -> where('u.assign_to_lam',$this->user_id);
		}
		$this -> db -> where('f.nfd',$this->today);	
		$this -> db -> where('f.nft >',$startTime);	
			$this -> db -> where('f.nft <',$endTime);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
	public function remove_old_notification()
	{		
			$query = $this->db->query("INSERT INTO `tbl_notifications_old`(`notification_id`, `user_id`, `notification_name`, `notification_url`, `notification_status`, `notification_type`, `notification_created_date`, `notification_created_time`) 
                           SELECT `notification_id`, `user_id`, `notification_name`, `notification_url`, `notification_status`, `notification_type`, `notification_created_date`, `notification_created_time`
                           FROM tbl_notifications
                           WHERE user_id='$this->user_id' order by notification_id desc limit 100,100");

			$q1=$this->db->query("select notification_id from  tbl_notifications  WHERE user_id='$this->user_id' order by notification_id desc limit 100,100")->result();
			if(count($q1)>0)
			{
				foreach($q1 as $row)
				{
					$notification_id=$row->notification_id;
					$this->db->query("delete from  tbl_notifications  WHERE notification_id='$notification_id'");
				}
			}
		
	}
	public function calling_task_pending_notification()
	{
		$type=$this->input->post('type');
		$this->calling_task_pending_notification_insert('new_calls','New assigned call','n'.$type);		
		$this->calling_task_pending_notification_insert('todays_calls','Todays followup','t'.$type);
		$this->calling_task_pending_notification_insert('pending_new_calls','Missed new call','pn'.$type);
		$this->calling_task_pending_notification_insert('pending_calls','Missed followup','p'.$type);
	}
	public function calling_task_pending_notification_insert($filter_data,$notification_name,$type)
	{
		//echo $type;
		$this -> db -> select('count(u.company_id) as count_lead');
		$this -> db -> from('tbl_company u');
		$this -> db -> join('tbl_followup f', 'f.followup_id=u.last_followup_id', 'left');
		$this -> db -> where('u.assign_to_lam',$this->user_id);
		$this -> db -> where('company_status', '1');
		$this -> db -> where("u.dnd!=", 1);		
		if($filter_data=='new_calls'){		
			$this -> db -> where('u.assign_to_lam_date',$this->today);
			$this -> db -> where('u.last_followup_id',0);		
		}
		elseif($filter_data=='todays_calls'){				
		$this -> db -> where('f.nfd',$this->today);					
		}
		elseif($filter_data == 'pending_calls'){
			$this -> db -> where('f.nfd <',$this->today);
		}
		elseif($filter_data=='pending_new_calls'){
		
			$this -> db -> where('u.assign_to_lam_date <',$this->today);
			$this -> db -> where('u.last_followup_id',0);	
			$this -> db -> where('u.assign_to_lam_date !=', '0000-00-00');
		}
		$query = $this -> db -> get()->result();
		//echo $this->db->last_query();
		$count_lead = $query[0] -> count_lead;
		if($count_lead > 0)
		{
				$q=$this->db->query("select * from tbl_notifications where notification_type='$type' and user_id='$this->user_id' and notification_created_date='$this->today'")->result();
			if(count($q)<1)
			{
				if($count_lead>1)
				{
					$s='s';
				}else{$s='';}
				$notification_name=$count_lead.' '.$notification_name.$s.' in queue';
				$notification_url='calling_task/'.$filter_data;
				$this->db->query("INSERT INTO `tbl_notifications`(`notification_name`, `notification_status`, `notification_url`,notification_created_date,user_id,notification_created_time,notification_type) 
					VALUES ('$notification_name','-1','$notification_url','$this->today','$this->user_id','$this->time','$type') ");
			}
		}
	}
}