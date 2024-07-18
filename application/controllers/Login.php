<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();

class login extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper('form');
		$this -> load -> helper('url');
		$this -> load -> model('login_model');
		date_default_timezone_set('Asia/Kolkata');		
	}

	public function index() {
		$data['var'] = site_url('login/login_form1');
		$this -> load -> view('login_view.php', $data);
	}

	public function test12() {
		$data['var'] = site_url('login/login_form1');
		$this -> load -> view('login_view.php', $data);
	}

	/*public function login_form() {
		$username = $this -> input -> post('username');
		$password = $this -> input -> post('password');

		$query = $this -> login_model -> form_submit($username, $password);
		if (count($query) == 1) {
			$id = $query[0] -> id;
			$location = $query[0] -> location;
			$role = $query[0] -> role;
			$department = $query[0] -> department;
			$fname = $query[0] -> fname;
			$lname = $query[0] -> lname;
			$username = $fname . ' ' . $lname;
			$this -> session -> set_userdata('user_id', $id);
			$this -> session -> set_userdata('role', $role);
			$this -> session -> set_userdata('department', $department);
			$this -> session -> set_userdata('username', $username);
			$this -> session -> set_userdata('location', $location);
			
				redirect('notification');
			
		} else {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>Error...!</strong> pls Check UserId Or password..</div>');
			redirect('login');
		}

	}*/

	public function login_form1($id=null) {
	    if(isset($id))
	    {
	         $q=$this->db->query("select * from lmsuser where id='$id'")->result();
	         $username = $q[0]->email;
	    	$password = $q[0]->password;
	    }else
	    {
    		$username = $this -> input -> post('username');
    		$password = $this -> input -> post('password');
	    }
		$select_user=$this->db->query("select * from lmsuser where email='$username' and password='$password' and status=1 limit 1")->result();
		if (count($select_user) == 1) {
			
		if($select_user[0]->role=='17'){
				$id = $select_user[0] -> id;
		$get_rights_cross_lead = $this -> login_model -> get_rights_cross_lead($id);
			
			if (count($get_rights_cross_lead) >1) {
				
		
			$fname = $select_user[0] -> fname;
			$lname = $select_user[0] -> lname;
			$username = $fname . ' ' . $lname;
			$process_id='';
	
			$this -> session -> set_userdata('user_id', $id);
			$this -> session -> set_userdata('username', $username);
			$this -> session -> set_userdata('role', $select_user[0] -> role);
			$this -> session -> set_userdata('role_name', $select_user[0] -> role_name);
			
			$query1 = $this -> login_model -> update_status($id, $process_id);
			
				foreach ($get_rights_cross_lead as $row) {
					//$form_name1[] = $row -> form_name;
					//$controller_name1[] = $row -> controller_name;
					$view1_cross_lead[] = $row -> view;
					$insert1_cross_lead[] = $row -> insert;
					$modify1_cross_lead[] = $row -> modify;
					$delete1_cross_lead[] = $row -> delete;
				}
				$_SESSION['view_cross_lead'] = $view1_cross_lead;
				$_SESSION['insert_cross_lead'] = $insert1_cross_lead;
				$_SESSION['modify_cross_lead'] = $modify1_cross_lead;
				$_SESSION['delete_cross_lead'] = $delete1_cross_lead;
				
			}
			redirect('sign_up/dashboard');
		}else{

		$query = $this -> login_model -> form_submit1($username, $password);
		//print_r($query);
		if (count($query) == 1) {
			$id = $query[0] -> id;
			$process_id = $query[0] -> process_id;
		 	$fname = $query[0] -> fname;
			$lname = $query[0] -> lname;
			$username = $fname . ' ' . $lname;
			
			//start dialer code
			$agent_username = $query[0]->agent_username;
			$agent_password = $query[0]->agent_password;
			// Store data in session
			$this->session->set_userdata('agent_username', $agent_username);
			$this->session->set_userdata('agent_password', $agent_password);
			//eof dialer code
			
			$this -> session -> set_userdata('user_id', $id);
			$this -> session -> set_userdata('process_id', $process_id);
			$this -> session -> set_userdata('cross_lead_user', $query[0] -> cross_lead_user);
			$this -> session -> set_userdata('username', $username);
			$this -> session -> set_userdata('location_id', $query[0] -> location_id);
			$this -> session -> set_userdata('location', $query[0] -> location);
			$this -> session -> set_userdata('role', $query[0] -> role);
			$this -> session -> set_userdata('role_name', $query[0] -> role_name);
		 	$this -> session -> set_userdata('process_name', $query[0] -> process_name);			
			$this -> session -> set_userdata('sub_poc_purchase', '1');
			$query1 = $this -> login_model -> update_status($id, $process_id);
			 echo $this->session->userdata('role_name');
echo	$this -> session -> userdata('username');
		
			//Set Rights in session
			$get_rights = $this -> login_model -> get_right($id);
		echo	count($get_rights) ;
			if (count($get_rights) >= 76) {
				foreach ($get_rights as $row) {
					$form_name1[] = $row -> form_name;
					$controller_name1[] = $row -> controller_name;
					$view1[] = $row -> view;
					$insert1[] = $row -> insert;
					$modify1[] = $row -> modify;
					$delete1[] = $row -> delete;

				}
				//print_r($form_name1);
					$this -> session -> set_userdata('form_name',$form_name1);
						$this -> session -> set_userdata('controller_name', $controller_name1);
							$this -> session -> set_userdata('view', $view1);
								$this -> session -> set_userdata('insert', $insert1);
									$this -> session -> set_userdata('modify', $modify1);
										$this -> session -> set_userdata('delete', $delete1);
								//	$k=	$this -> session -> userdata('view');
									//print_r($k);


			/*	$_SESSION['form_name'] = $form_name1;
				$_SESSION['controller_name'] = $controller_name1;
				$_SESSION['view'] = $view1;
				$_SESSION['insert'] = $insert1;
				$_SESSION['modify'] = $modify1;
				$_SESSION['delete'] = $delete1;*/
			$get_rights_financef = $this -> login_model -> get_rights_financef($id);
			if (count($get_rights_financef) >1) {
				foreach ($get_rights_financef as $rowf) {
					//$form_name1[] = $row -> form_name;
					//$controller_name1[] = $row -> controller_name;
					$view1_finance[] = $rowf -> view;
					$insert1_finance[] = $rowf -> insert;
					$modify1_finance[] = $rowf -> modify;
					$delete1_finance[] = $rowf -> delete;
				}
				$this -> session -> set_userdata('view_finance', $view1_finance);
				$this -> session -> set_userdata('insert_finance', $insert1_finance);
				$this -> session -> set_userdata('modify_finance', $modify1_finance);
				$this -> session -> set_userdata('delete_finance', $delete1_finance);
			}
			$get_rights_complaint = $this -> login_model -> get_rights_complaint($id);
			if (count($get_rights_complaint) >1) {
				foreach ($get_rights_complaint as $row) {
					//$form_name1[] = $row -> form_name;
					//$controller_name1[] = $row -> controller_name;
					$view1_complaint[] = $row -> view;
					$insert1_complaint[] = $row -> insert;
					$modify1_complaint[] = $row -> modify;
					$delete1_complaint[] = $row -> delete;
				}
				$this -> session -> set_userdata('view_complaint', $view1_complaint);
				$this -> session -> set_userdata('insert_complaint', $insert1_complaint);
				$this -> session -> set_userdata('modify_complaint', $modify1_complaint);
				$this -> session -> set_userdata('delete_complaint', $delete1_complaint);
			}
			$get_rights_report = $this -> login_model -> get_rights_report($id);
			if (count($get_rights_report) >1) {
				foreach ($get_rights_report as $row) {
					
					$view1_report[] = $row -> view;					
				}
				/*$_SESSION['view_report'] = $view1_report;*/
				$this -> session -> set_userdata('view_report', $view1_report);
			}
			$get_rights_purchase_tracking = $this -> login_model -> get_rights_purchase_tracking($id);
			if (count($get_rights_purchase_tracking) >1) {
				foreach ($get_rights_purchase_tracking as $row) {
					$view1_purchase_tracking[] = $row -> view;
					$insert1_purchase_tracking[] = $row -> insert;					
				}
			/*	$_SESSION['view_poc_purchase_tracking'] = $view1_purchase_tracking;
				$_SESSION['insert_poc_purchase_tracking'] = $insert1_purchase_tracking;*/
				$this -> session -> set_userdata('view_poc_purchase_tracking', $view1_purchase_tracking);
										$this -> session -> set_userdata('insert_poc_purchase_tracking', $insert1_purchase_tracking);
			}
			redirect('notification');
			} else {
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>Error...!</strong> Please Contact to Admin for Rights.</div>');
				redirect('login');
			}
		}
		}
		} else {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>Error...!</strong> please Check UserId Or password..</div>');
			redirect('login');
		}

	}
	function change_header_data()
	{
		$process_id=$this->input->post('process_id');
	//echo $_SESSION['location_id'];
		$q=$this->db->query('select process_name from tbl_manager_process p join tbl_process p1 on p1.process_id=p.process_id where p.process_id="'.$process_id.'" and p.location_id="'.$_SESSION['location_id'].'" and p.user_id="'.$_SESSION['user_id'].'"')->result();
		//echo $this->db->last_query();
		if(count($q)>0)
		{
			//echo $t='Location p';
			$this -> session -> set_userdata('process_name', $q[0] -> process_name);
			$this -> session -> set_userdata('process_id', $process_id);
		}
		else {
			$this -> db -> select('p.process_id,p.location_id,p1.process_name,l.location');
			$this -> db -> from('tbl_manager_process p');
			$this->db->join('tbl_process p1','p1.process_id=p.process_id');
			$this->db->join('tbl_location l','l.location_id=p.location_id');
			//$this -> db -> where('p.location_id', $_SESSION['location_id']);
			$this -> db -> where('p.process_id', $process_id);
			$this -> db -> where('p.user_id', $_SESSION['user_id']);
			$query = $this -> db -> get()->result();
			if(count($query)>0)
			{
				//echo $t='Location p1';
				$this -> session -> set_userdata('process_name', $query[0] -> process_name);
				$this -> session -> set_userdata('location_id', $query[0] -> location_id);
				$this -> session -> set_userdata('location', $query[0] -> location);
				$this -> session -> set_userdata('process_id', $process_id);
				
			}
			else 
			{
				echo 'Redirected to default Process';
				$this -> db -> select('p.process_id,p.location_id,p1.process_name,l.location');
				$this -> db -> from('tbl_manager_process p');
				$this->db->join('tbl_process p1','p1.process_id=p.process_id');
				$this->db->join('tbl_location l','l.location_id=p.location_id');
				$this -> db -> where('p.user_id', $_SESSION['user_id']);
				$query = $this -> db -> get()->result();
				$this -> session -> set_userdata('process_name', $query[0] -> process_name);
				$this -> session -> set_userdata('location_id', $query[0] -> location_id);
				$this -> session -> set_userdata('location', $query[0] -> location);
				$this -> session -> set_userdata('process_id', $query[0] ->process_id);
				
			}
		}
		
		
	}

	/*function change_header_data1()
	{
		$location_id=$this->input->post('location_id');
		$this -> db -> select('p.process_id,p.location_id,p1.process_name,l.location');
		$this -> db -> from('tbl_manager_process p');
		$this->db->join('tbl_process p1','p1.process_id=p.process_id');
		$this->db->join('tbl_location l','l.location_id=p.location_id');
		$this -> db -> where('p.location_id', $location_id);
		$this -> db -> where('p.process_id', $_SESSION['process_id']);
		$this -> db -> where('p.user_id', $_SESSION['user_id']);
		$query = $this -> db -> get()->result();
		//echo $this->db->last_query();
		if(count($query)>0)
		{
			//echo $t='Location p2';
			$this -> session -> set_userdata('location_id', $query[0] -> location_id);
			$this -> session -> set_userdata('location', $query[0] -> location);
		}
		else {
				echo 'Redirected to default Process';
				$this -> db -> select('p.process_id,p.location_id,p1.process_name,l.location');
				$this -> db -> from('tbl_manager_process p');
				$this->db->join('tbl_process p1','p1.process_id=p.process_id');
				$this->db->join('tbl_location l','l.location_id=p.location_id');
				$this -> db -> where('p.user_id', $_SESSION['user_id']);
				$query = $this -> db -> get()->result();
				$this -> session -> set_userdata('process_name', $query[0] -> process_name);
				$this -> session -> set_userdata('location_id', $query[0] -> location_id);
				$this -> session -> set_userdata('location', $query[0] -> location);
				$this -> session -> set_userdata('process_id', $query[0] ->process_id);
		}
		
		
	}*/
function change_header_data1()
	{
		$sub_poc_purchase=$this->input->post('sub_poc_purchase');
		$this -> session -> set_userdata('sub_poc_purchase', $sub_poc_purchase);
	}
	/*function logout() {
		//$this->login_model->change_status();
		$this -> session -> unset_userdata($var);
		$this -> session -> sess_destroy();
		redirect('login');

	}*/

	function logout() {

		$this -> login_model -> change_status();
		//	$this -> session -> unset_userdata($var);
		$this -> session -> sess_destroy();
		redirect('login');

	}

}
