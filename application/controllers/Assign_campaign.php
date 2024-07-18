<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assign_campaign extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('add_campaign_model');

	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function index() {
		$this -> session();

		$query1 = $this -> add_campaign_model -> select_table();
		$data['select_table'] = $query1;

		$query2 = $this -> add_campaign_model -> select_campaign();

		//	print_r($query2);

		$data['select_campaign'] = $query2;

		$query3 = $this -> add_campaign_model -> campaign_table();
		//	print_r($query3);
		$data['campaign_table'] = $query3;

		$data['var'] = site_url('add_campaign/add_campaign');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('add_campaign_view.php', $data);
		$this -> load -> view('include/footer.php');

	}

	public function add_campaign() {

		$grp_id = $this -> input -> post('grp_name');

		$c_name = $this -> input -> post('c_name');

		$query = $this -> add_campaign_model -> add_campaign($grp_id, $c_name);
		//redirect('add_campaign');

	}

	public function edit_campaign() {

		$query1 = $this -> add_campaign_model -> select_table();
		$data['select_table'] = $query1;

		$query2 = $this -> add_campaign_model -> select_campaign();

		$data['select_campaign'] = $query2;
		echo $id = $this -> input -> get('id');

		$query = $this -> add_campaign_model -> edit_campaign($id);
		$data['select_camp'] = $query;

		//print_r($query);

		$data['var1'] = site_url('add_campaign/update_campaign');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('edit_campaign_view', $data);
		$this -> load -> view('include/footer');

	}

	function update_campaign() {

		echo $campaign_id = $this -> input -> post('id');
		echo $grp_id = $this -> input -> post('grp_name');

		echo $c_name = $this -> input -> post('c_name');

		$q = $this -> add_campaign_model -> update_campaign($campaign_id, $grp_id, $c_name);

		redirect('add_campaign');

	}

}
