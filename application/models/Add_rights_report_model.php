<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class add_rights_report_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> process_id = $this -> session -> userdata('process_id');
		$this -> user_id = $this -> session -> userdata('user_id');
	}

	public function select_location() {
		//	$user_id = $this -> input -> post('user_name');
		$this -> db -> select('*');
		$this -> db -> from('tbl_location l');
		$this -> db -> join('tbl_manager_process p', 'p.location_id=l.location_id');
		$this -> db -> where('process_id', $this -> process_id);
		$this -> db -> where('user_id', $this -> user_id);
		$this -> db -> where('p.status !=', '-1');  
		$this -> db -> where('l.location_status !=', 'Deactive');
		$this -> db -> order_by('l.location', 'asc'); 
		$query = $this -> db -> get();
		return $query -> result();
	}
	public function checkUser() {
		 $locationId = $this -> input -> post('locationId');
		 $process_id=$_SESSION['process_id'];
		/* $where="(l.process_id='$process_id' or m.process_id='$process_id')";	*/
		$this -> db -> select('l.fname,l.lname,l.id');
		$this -> db -> from('lmsuser l');
		$this -> db -> join('tbl_manager_process m', 'm.user_id=l.id','left');
		//$this -> db -> join('tbl_rights r','r.user_id=l.id','left');
		$this -> db -> where('m.location_id', $locationId);
		$this -> db -> where('m.process_id',$_SESSION['process_id']);
	//	$this -> db -> where($where);
		$this -> db -> where('role!=', '1');
		$this -> db -> where('m.status!=', '-1');
		$this -> db -> where('l.status!=', '-1');
		$this -> db -> group_by('l.id');
		$this -> db -> order_by('fname', 'asc');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
	

	public function checkRights() {
		$id = $this -> input -> post('username');
		$this -> db -> select('u.fname,u.lname,u.email,u.mobileno,r.right_id,r.view,r.insert,r.modify,r.delete,r.form_name,u.id');
		$this -> db -> from('tbl_rights_report r');
		$this -> db -> join('lmsuser u', 'u.id=r.user_id');

		$this -> db -> where('user_id', $id);
		$this -> db -> order_by('right_id', 'asc');
		$query = $this -> db -> get();
		return $query -> result();
	}

	public function copy_user_rights() {
		$this -> db -> select('u.fname,u.lname,u.id');
		$this -> db -> from('tbl_rights_report r');
		$this -> db -> join('lmsuser u', 'u.id=r.user_id');
		$this -> db -> join('tbl_manager_process m', 'm.user_id=u.id', 'left');
		$this -> db -> where('m.process_id', $_SESSION['process_id']);

		$this -> db -> where('role!=', '1');
		$this -> db -> where('m.status!=', '-1');
		$this -> db -> group_by('r.user_id');
		$this -> db -> order_by('fname', 'asc');
		$query = $this -> db -> get();
		//	echo $this->db->last_query();
		return $query -> result();
	}

	public function cpyRights() {
		$id = $this -> input -> post('cpyuser');
		$this -> db -> select('u.fname,u.lname,u.email,u.mobileno,r.right_id,r.view,r.insert,r.modify,r.delete,r.form_name,u.id');
		$this -> db -> from('tbl_rights_report r');
		$this -> db -> join('lmsuser u', 'u.id=r.user_id');

		$this -> db -> where('user_id', $id);
		$this -> db -> order_by('right_id', 'asc');
		$query = $this -> db -> get();
		return $query -> result();
	}

	public function insert_rights_report()
	{
		$user_id = $this->input->post('username');
		$qy = $this->db->query("delete from tbl_rights_report where user_id='$user_id'"); 

		$form_data_array = array(
			'form_sourcewise_report', 'form_cse_productivity_report', 'form_cse_performance_report', 'form_locationwise_report', 'form_appointment_report', 'form_dse_productivity_report', 'form_dse_performance_report', 'form_one_pager_report', 'form_add_dse_daily_reporting', 'form_view_dse_daily_reporting',
			'pform_sourcewise_report', 'pform_cse_productivity_report', 'pform_cse_performance_report', 'pform_locationwise_report', 'pform_appointment_report', 'pform_dse_productivity_report', 'pform_dse_performance_report', 'pform_one_pager_report', 'pform_add_dse_daily_reporting', 'pform_view_dse_daily_reporting',
			'cform_sourcewise_report', 'cform_cse_productivity_report', 'cform_cse_performance_report', 'cform_locationwise_report', 'cform_appointment_report', 'cform_dse_productivity_report', 'cform_dse_performance_report', 'cform_one_pager_report', 'cform_add_dse_daily_reporting', 'cform_view_dse_daily_reporting',


			// Break Time report rights code to insert 
			'form_view_break_time_reporting', 'pform_view_break_time_reporting', 'cform_view_break_time_reporting',

			// login logout report right code to insert
			'form_login_logout_reporting', 'pform_login_logout_reporting', 'cform_login_logout_reporting'
		);

		$view_data_array = array(
			'sourcewise_report_view', 'cse_productivity_report_view', 'cse_performance_report_view', 'locationwise_report_view', 'appointment_report_view', 'dse_productivity_report_view', 'dse_performance_report_view', 'one_pager_report_view', 'add_dse_daily_reporting_view', 'send_message_to_dse_view',
			'psourcewise_report_view', 'pcse_productivity_report_view', 'pcse_performance_report_view', 'plocationwise_report_view', 'pappointment_report_view', 'pdse_productivity_report_view', 'pdse_performance_report_view', 'pone_pager_report_view', 'padd_dse_daily_reporting_view', 'psend_message_to_dse_view',
			'csourcewise_report_view', 'ccse_productivity_report_view', 'ccse_performance_report_view', 'clocationwise_report_view', 'cappointment_report_view', 'cdse_productivity_report_view', 'cdse_performance_report_view', 'cone_pager_report_view', 'cadd_dse_daily_reporting_view', 'csend_message_to_dse_view',

			// Break Time report rights code to insert
			'break_time_view', 'pbreak_time_view', 'cbreak_time_view',

			// login logout report right code to insert
			'login_logout_view', 'plogin_logout_view', 'clogin_logout_view'
		);

		$view_data_array1 = array(
			'sourcewise_report_view1', 'cse_productivity_report_view1', 'cse_performance_report_view1', 'locationwise_report_view1', 'appointment_report_view1', 'dse_productivity_report_view1', 'dse_performance_report_view1', 'one_pager_report_view1', 'add_dse_daily_reporting_view1', 'send_message_to_dse_view1',
			'psourcewise_report_view1', 'pcse_productivity_report_view1', 'pcse_performance_report_view1', 'plocationwise_report_view1', 'pappointment_report_view1', 'pdse_productivity_report_view1', 'pdse_performance_report_view1', 'pone_pager_report_view1', 'padd_dse_daily_reporting_view1', 'psend_message_to_dse_view1',

			// Break Time report rights code to insert
			'break_time_view1', 'pbreak_time_view1', 'cbreak_time_view1',

			// login logout report right code to insert
			'login_logout_view1', 'plogin_logout_view1', 'clogin_logout_view1'
		);

		$insert_data_array = array(
			'sourcewise_report_insert', 'cse_productivity_report_insert', 'cse_performance_report_insert', 'locationwise_report_insert', 'appointment_report_insert', 'dse_productivity_report_insert', 'dse_performance_report_insert', 'one_pager_report_insert', 'add_dse_daily_reporting_insert', 'send_message_to_dse_insert',
			'psourcewise_report_insert', 'pcse_productivity_report_insert', 'pcse_performance_report_insert', 'plocationwise_report_insert', 'pappointment_report_insert', 'pdse_productivity_report_insert', 'pdse_performance_report_insert', 'pone_pager_report_insert', 'padd_dse_daily_reporting_insert', 'psend_message_to_dse_insert',
			'csourcewise_report_insert', 'ccse_productivity_report_insert', 'ccse_performance_report_insert', 'clocationwise_report_insert', 'cappointment_report_insert', 'cdse_productivity_report_insert', 'cdse_performance_report_insert', 'cone_pager_report_insert', 'cadd_dse_daily_reporting_insert', 'csend_message_to_dse_insert',

			// Break Time report rights code to insert
			'break_time_insert', 'pbreak_time_insert', 'cbreak_time_insert',

			// login logout report right code to insert
			'login_logout_insert', 'plogin_logout_insert', 'clogin_logout_insert'
		);

		$insert_data_array1 = array(
			'sourcewise_report_insert1', 'cse_productivity_report_insert1', 'cse_performance_report_insert1', 'locationwise_report_insert1', 'appointment_report_insert1', 'dse_productivity_report_insert1', 'dse_performance_report_insert1', 'one_pager_report_insert1', 'add_dse_daily_reporting_insert1', 'send_message_to_dse_insert1', 'break_time_insert1', 'login_logout_insert1',
			'psourcewise_report_insert1', 'pcse_productivity_report_insert1', 'pcse_performance_report_insert1', 'plocationwise_report_insert1', 'pappointment_report_insert1', 'pdse_productivity_report_insert1', 'pdse_performance_report_insert1', 'pone_pager_report_insert1', 'padd_dse_daily_reporting_insert1', 'psend_message_to_dse_insert1', 'pbreak_time_insert1',  'plogin_logout_insert1',
			'csourcewise_report_insert1', 'ccse_productivity_report_insert1', 'ccse_performance_report_insert1', 'clocationwise_report_insert1', 'cappointment_report_insert1', 'cdse_productivity_report_insert1', 'cdse_performance_report_insert1', 'cone_pager_report_insert1', 'cadd_dse_daily_reporting_insert1', 'csend_message_to_dse_insert1', 'cbreak_time_insert1', 'clogin_logout_insert1',
			// Break Time report rights code to insert
			'break_time_insert1', 'pbreak_time_insert1', 'cbreak_time_insert1',

			// login logout report right code to insert
			'login_logout_insert1', 'plogin_logout_insert1', 'clogin_logout_insert1'
		);

		$process_array = array(
			'6', '6', '6', '6', '6', '6', '6', '6', '6', '6',
			'7', '7', '7', '7', '7', '7', '7', '7', '7', '7',
			'8', '8', '8', '8', '8', '8', '8', '8', '8', '8',
			// break time process wise
			'6', '7', '8',
			// login logout process wise
			'6', '7', '8'
		);

		$form_count = count($form_data_array);
		for ($i = 0; $i < $form_count; $i++) {
			//Form
			$form_array[] = $this -> input -> post($form_data_array[$i]);
			//View
			if (($this -> input -> post($view_data_array[$i])) == '') {

				$view_array[] = $this -> input -> post($view_data_array1[$i]);
			} else {

				$view_array[] = $this -> input -> post($view_data_array[$i]);
			}
			//Insert
			if (($this -> input -> post($insert_data_array[$i])) == '') {

				$insert_array[] = $this -> input -> post($insert_data_array1[$i]);
			} else {

				$insert_array[] = $this -> input -> post($insert_data_array[$i]);
			}

		}
		$date = date('Y-m-d');
		$updated_by_id = $_SESSION['user_id'];
		for ($i = 0; $i < $form_count; $i++) {
			$query = $this -> db -> query("INSERT INTO `tbl_rights_report`(`user_id`, `form_name`,`view`, `insert`, `modify`, `delete`,`process_id`,`updated_date`,`updated_by_id`) VALUES ('$user_id','$form_array[$i]','$view_array[$i]','$insert_array[$i]','$modify_array[$i]','$delete_array[$i]','$process_array[$i]','$date','$updated_by_id')");
			echo $this -> db -> last_query();
		}
		if ($query) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Rights added Successfully ...!</strong>');

		} else {
			//$this -> db -> where('user_id', $user_id);

			$this -> session -> set_flashdata('message', '<div class="alert alert-danger">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Right Not added ...!</strong>');

		}

	}

}
