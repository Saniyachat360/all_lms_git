<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class manager_remark extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('manager_remark_model');
		date_default_timezone_set("Asia/Kolkata");

	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function leads($id, $enq) {

		$data['select_lead'] = $this -> manager_remark_model -> select_lead($id);
		$data['followup_detail'] = $this -> manager_remark_model -> followup_detail($id);
		$data['remark_detail'] = $this -> manager_remark_model -> select_remark($id);

		$data['enq'] = $enq;
		$data['id'] = $id;
		$data['var'] = site_url() . 'manager_remark/insert_remark';
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('add_remark_view.php', $data);
		$this -> load -> view('include/footer.php');

	}

	public function insert_remark() {
		$query = $this -> manager_remark_model -> insert_remark();
		if (!$query) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Remark Added Successfully...!</strong>');
		} else {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Remark Not added ...!</strong>');
		}
		$enq = $this -> input -> post('enq');
		if($_SESSION['process_id']==9){
				if ($enq == 'New') {
			$url = 'new_lead/complaint/';

		} else if ($enq == 'Pending New') {
			$url = 'pending/complaint_not_attended/';

		} else if ($enq == 'Pending Followup') {
			$url = 'pending/complaint_attended/';

		} else if ($enq == 'Today Followup') {
			$url = 'today_followup/complaint/';

		} else if ($enq == 'Unassigned') {
			$url = 'unassign_leads/complaint/';

		} else {
			$url = 'website_leads/complaint/';

		}
		}else{
				if ($enq == 'New') {
			$url = 'new_lead/leads/';

		} else if ($enq == 'Pending New') {
			$url = 'pending/telecaller_leads_not_attended/';

		} else if ($enq == 'Pending Followup') {
			$url = 'pending/telecaller_leads/';

		} else if ($enq == 'Today Followup') {
			$url = 'today_followup/leads/';

		} else if ($enq == 'Unassigned') {
			$url = 'unassign_leads/leads/';

		} else {
			$url = 'website_leads/telecaller_leads/';

		}
		}
	
		redirect($url);
	}

}
?>