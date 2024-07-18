<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class today_followup extends CI_Controller {
	public $process_name;
	public $role;
	public $user_id;
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model(array('today_followup_model'));
		$this -> process_name = $this -> session -> userdata('process_name');
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');
		date_default_timezone_set("Asia/Kolkata");
		

	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function index() {
		$this -> session();
		$data['enq'] = "Today Followup";
		$data['select_lead'] = $this -> today_followup_model -> select_lead_location($this -> role, $this -> process_name, $this -> user_id);
		$data['today_count_lead'] = $this -> today_followup_model -> select_lead_count_location($this -> role, $this -> process_name, $this -> user_id);
		$data['id'] = $this -> input -> get('id');
		$data['role'] = $this -> input -> get('role');
		$data['name']=$this -> input -> get('name');
		
		$this -> load -> view('include/admin_header.php');
		if ($this -> input -> get('id') == '') {
			$this -> load -> view('notification_view.php', $data);
		}
		$this -> load -> view('telecaller_lms_view.php', $data);
		$this -> load -> view('include/footer.php');
	}

	public function leads() {
		$this -> session();
		$data['enq'] = "Today Followup";
		//get pending attened leads details
	
			$data['select_lead'] = $this -> today_followup_model -> select_lead_location();
			$t = $data['today_count_lead'] = $this -> today_followup_model -> select_lead_count_location();

			$data['id'] = $this -> input -> get('id');
		$data['role'] = $this -> input -> get('role');

		$this -> load -> view('include/admin_header.php');
		if ($this -> input -> get('id') == '') {
			$this -> load -> view('notification_view.php', $data);
		}
		$this -> load -> view('telecaller_lms_view.php', $data);
		$this -> load -> view('include/footer.php');
	}

	public function search_today() {
		$this -> session();
		$data['enq'] = "Today Followup";
		//get pending attened leads details
		//if ($this -> input -> get('id') != '') {

			$data['select_lead'] = $this -> today_followup_model -> select_lead_location();
			$t = $data['today_count_lead'] = $this -> today_followup_model -> select_lead_count_location();

			$data['id'] = $this -> input -> get('id');
		/*} else {

			$data['select_lead'] = $this -> today_followup_model -> select_lead($this -> role, $this -> process_name, $this -> user_id);
			$data['today_count_lead'] = $this -> today_followup_model -> select_lead_count($this -> role, $this -> process_name, $this -> user_id);
			$data['id'] = '';
		}*/

		$this -> load -> view('telecaller_followup_view.php', $data);

	}
public function complaint() {
		$this -> session();
		$data['enq'] = "Today Followup";
		$data['select_lead'] = $this -> today_followup_model -> select_lead_complaint($this -> role, $this -> process_name, $this -> user_id);
		$data['today_count_lead'] = $this -> today_followup_model -> select_lead_count_complaint($this -> role, $this -> process_name, $this -> user_id);
		$data['id'] = $this -> input -> get('id');
		$data['role'] = $this -> input -> get('role');
		$data['name']=$this -> input -> get('name');
		
		$this -> load -> view('include/admin_header.php');
		if ($this -> input -> get('id') == '') {
			$this -> load -> view('notification_view.php', $data);
		}
		$this -> load -> view('complaint_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
public function search_complaint() {

		$this -> session();
	$data['enq'] = "Today Followup";
		$data['select_lead'] = $this -> today_followup_model -> select_lead_complaint($this -> role, $this -> process_name, $this -> user_id);
		$data['today_count_lead'] = $this -> today_followup_model -> select_lead_count_complaint($this -> role, $this -> process_name, $this -> user_id);
		
		
	$this -> load -> view('complaint_filter_view.php', $data);

	}

}
?>