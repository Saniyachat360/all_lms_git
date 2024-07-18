<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_out_report extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->today = date('Y-m-d');
		$this->load->library(array('table', 'form_validation', 'session'));
		$this->load->helper(array('form', 'url'));
		$this->load->model(array('Login_out_report_model'));
	}

	public function session()
	{
		if ($this->session->userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function users()
	{
		$this->session();

		$data['select_users'] = $this->Login_out_report_model->select_users();
		$this->load->view('include/admin_header.php');
		$this->load->view('report/Login_out_report_view.php', $data);
		$this->load->view('include/footer.php');
	}

	public function filter_daily()
	{
		$this->session();

		$type = $this->input->post('type');
		$id = $this->input->post('user_name');

		if ($type == 'Daily') {
			$sd = $this->today;
			$ed = $this->today;
		} elseif ($type == 'Weekly') {
			$monday = strtotime("last monday");
			$monday = date('w', $monday) == date('w') ? $monday + 7 * 86400 : $monday;
			$sunday = strtotime(date("Y-m-d", $monday) . " +6 days");
			$sd = date("Y-m-d", $monday);
			$ed = date("Y-m-d", $sunday);
		} elseif ($type == 'Monthly') {
			$sd = date('Y-m-01');
			$ed = date('Y-m-t');
		} elseif ($type == 'Custom') {
			$sd = $this->input->post('from_date');
			$ed = $this->input->post('to_date');
		}

		// echo $type;
		// echo $id;
		// echo $sd;
		// echo $ed;
		// die;
		$data['select_user'] = $this->Login_out_report_model->filter_daily($sd, $ed, $id, $type);
		$data['sd'] = $sd;
		$data['ed'] = $ed;
		// print_r($data);
		// die;
		
		$this->load->view('report/Login_out_filter_report_view.php', $data);
		$this->load->view('include/footer.php');
	}
}
