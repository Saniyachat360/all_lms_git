<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

	public function login_form1() {
		$username = $this -> input -> post('username');
		$password = $this -> input -> post('password');

		$query = $this -> login_model -> form_submit1($username, $password);
		print_r($query);
		if (count($query) == 1) {
			$id = $query[0] -> id;
			$process_id = $query[0] -> process_id;
			$fname = $query[0] -> fname;
			$lname = $query[0] -> lname;
			$username = $fname . ' ' . $lname;
			$this -> session -> set_userdata('user_id', $id);
			$this -> session -> set_userdata('process_id', $process_id);
			$this -> session -> set_userdata('username', $username);
			$this -> session -> set_userdata('location_id', $query[0] -> location_id);
			$this -> session -> set_userdata('location', $query[0] -> location);
			$this -> session -> set_userdata('role', $query[0] -> role);
			$this -> session -> set_userdata('role_name', $query[0] -> role_name);
			$this -> session -> set_userdata('process_name', $query[0] -> process_name);

			$query1 = $this -> login_model -> update_status($id, $process_id);
			

		
			//Set Rights in session
			$get_rights = $this -> login_model -> get_right($id);
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
				$_SESSION['form_name'] = $form_name1;
				$_SESSION['controller_name'] = $controller_name1;
				$_SESSION['view'] = $view1;
				$_SESSION['insert'] = $insert1;
				$_SESSION['modify'] = $modify1;
				$_SESSION['delete'] = $delete1;
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
				$_SESSION['view_complaint'] = $view1_complaint;
				$_SESSION['insert_complaint'] = $insert1_complaint;
				$_SESSION['modify_complaint'] = $modify1_complaint;
				$_SESSION['delete_complaint'] = $delete1_complaint;
				
			}
			redirect('notification');
			} else {
				$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong>Error...!</strong> Please Contact to Admin for Rights.</div>');
				redirect('login');
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

	function change_header_data1()
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
