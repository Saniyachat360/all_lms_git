<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
    class dse_daily_reporting_model extends CI_Model 
	{
		public function __construct()
		{
			parent::__construct();
		}
		
				public function insert_data()
		{
			$user_date=date('Y-m-d');
			$time = date("H:i:s A");
			$user_id=$_SESSION['user_id'];
			$location_id=$_SESSION['location_id'];
			$query=$this->db->query("update tbl_dse_daily_traking set status=0  where user_id='$user_id' and report_date='$user_date'");
		
			/*if(count(traking_id)>0){
				echo $status=1;
			*/
			
			//$user_date=$this->input->post('user_date');
			
			
			$enquiry_count=$this->input->post('enquiry_count');
			$enquiry_remark=$this->input->post('enquiry_remark');
			
			$walk_in_count=$this->input->post('walk_in_count');
			$walk_in_remark=$this->input->post('walk_in_remark');
			
			$home_visit_count=$this->input->post('home_visit_count');
			$home_visit_remark=$this->input->post('home_visit_remark');
			
			$test_drive_count=$this->input->post('test_drive_count');
			$test_drive_remark=$this->input->post('test_drive_remark');
			
			$booking_count=$this->input->post('booking_count');
			$booking_remark=$this->input->post('booking_remark');
			
			$gatepass_count=$this->input->post('gatepass_count');
			$gatepass_remark=$this->input->post('gatepass_remark');
			
			$evaluation_count=$this->input->post('evaluation_count');
			$evaluation_remark=$this->input->post('evaluation_remark');
			
			$delivery_count=$this->input->post('delivery_count');
			$delivery_remark=$this->input->post('delivery_remark');
			
		
			//echo $location_id;
			
		$query=$this->db->query("INSERT INTO `tbl_dse_daily_traking`(`walk_in_count`, `walk_in_remark`, `home_visit_count`, `home_visit_remark`, `booking_count`, `booking_remark`, `test_drive_count`, `test_drive_remark`, `delivery_count`, `delivery_remark`, `enquiry_count`, `enquiry_remark`,`gatepass_count`,`gatepass_remark`,`evaluation_count`,`evaluation_remark`,`user_id`,`location_id`,`report_date`,`report_time`,`status`) 
		VALUES ('$walk_in_count','$walk_in_remark','$home_visit_count','$home_visit_remark','$booking_count','$booking_remark','$test_drive_count','$test_drive_remark','$delivery_count','$delivery_remark','$enquiry_count','$enquiry_remark','$gatepass_count','$gatepass_remark','$evaluation_count','$enquiry_remark','$user_id','$location_id','$user_date','$time','1')");
		//echo $this->db->last_query();
		if ($this -> db -> affected_rows() > 0) {

				$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Report Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
			} else {
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Repoet Not Updated Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

			}
		}
		
		public function show_data()
		{
			$today=date('Y-m-d');
			$location_id=$this->input->post('location_id');
			$from_date=$this->input->post('fromdate');
			$status=$this->input->post('status');
			
			$this->db->select('d.*,u.fname,u.lname');
			$this->db->from('tbl_dse_daily_traking d');
			$this->db->join('lmsuser u','u.id=d.user_id');
			if($_SESSION['role']==4 || $_SESSION['role']==5){
				$this->db->where('location_id',$_SESSION['location_id']);
			}else if($location_id!=''){
				
				$this->db->where('location_id',$location_id);
			}
			if($from_date!=''){
				$this->db->where('report_date',$from_date);
			}else{
					$this->db->where('d.report_date',$today);
			}
			if($status!='All'){
				$this->db->where('d.status',1);
			}
			if($_SESSION['role']==3 || $_SESSION['role']==4){
				$this->db->where('d.user_id',$_SESSION['user_id']);
			}
	
			$query=$this->db->get();
			//echo $this->db->last_query();
			return $query->result();
			
		}
		public function select_location()
		{
			$this -> db -> select('l.location_id,l.location');
		$this -> db -> from('tbl_location l');
		$this->db->join('tbl_manager_process p','p.location_id=l.location_id');
		$this->db->where('p.process_id',$_SESSION['process_id']);
		$this -> db -> where('p.user_id', $_SESSION['user_id']);
			/*$this->db->select('*');
			$this->db->from('tbl_location');
			if($_SESSION['role']==3 || $_SESSION['role']==5|| $_SESSION['role']==4){
				$this->db->where('location_id',$_SESSION['location_id']);
			}*/
			$query=$this->db->get();
			//echo $this->db->last_query();
			return $query->result();
		}
	}
?>
