<?php
defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class Source extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('table', 'form_validation', 'session'));
		$this->load->helper(array('form', 'url'));
		$this->load->model('SourceModel');
	}

	public function session()
	{
		if ($this->session->userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function source_view()
	{
		$this->session();
		$data['sources'] = $this->SourceModel->select_source();
		$this->load->view('include/admin_header.php');
		$this->load->view('source_view.php', $data);
		$this->load->view('include/footer.php');
	}

	public function filterSubmissionProcesses()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->form_validation->set_rules('source', 'Source', 'required');
			$this->form_validation->set_rules('fromdate', 'Start Date', 'required');
			$this->form_validation->set_rules('todate', 'End Date', 'required');

			if ($this->form_validation->run() == false) {
				$errors = $this->form_validation->error_array();
				$response = ['success' => false, 'errors' => $errors];
			} else {
				$start_date = $this->input->post('fromdate');
				$end_date = $this->input->post('todate');
				$start_date_timestamp = strtotime($start_date);
				$end_date_timestamp = strtotime($end_date);
				if ($start_date_timestamp >= $end_date_timestamp) {
					$errors = ['Invalid date range. Start date must be before end date.'];
					$response = ['success' => false, 'errors' => $errors];
				} else {
					$process_id = $this->session->userdata('process_id');
					$process =  $this->SourceModel->getProcessName($process_id);
					$source = $this->input->post('source');
					$lead_count = $this->SourceModel->getLeadCount($process, $source, $start_date, $end_date);
					$connected_count = $this->SourceModel->getConnectedCount($process, $source, $start_date, $end_date);
					$interested_count = $this->SourceModel->getInterestedCount($process, $source, $start_date, $end_date);
					$test_drive_count = $this->SourceModel->getTestDriveCount($process, $source, $start_date, $end_date);
					$booked_count = $this->SourceModel->getBookedCount($process, $source, $start_date, $end_date);
					$dates = $this->datesBetween($start_date, $end_date);
					$results = [];
					foreach ($dates as $date) {
						$result = ['date' => $date];
						$result['lead_count'] = $this->getCountByDate($lead_count, $date, 'lead_count');
						$result['connected_count'] = $this->getCountByDate($connected_count, $date, 'connected_count');
						$result['interested_count'] = $this->getCountByDate($interested_count, $date, 'interested_count');
						$result['testdrive_count'] = $this->getCountByDate($test_drive_count, $date, 'testdrive_count');
						$result['booked_count'] = $this->getCountByDate($booked_count, $date, 'booked_count');
						$results[] = $result;
					}
					$response = [
						'success' => true,
						'results' => $results,
						'dates' => $dates
					];
				}
			}
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($response));
		}
	}



	private function getCountByDate($array, $targetDate, $countType)
	{
		foreach ($array as $item) {
			if ($item['date'] == $targetDate) {
				return $item[$countType];
			}
		}
		return 'NA';
	}

	private function datesBetween($start_date, $end_date)
	{
		$start = new DateTime($start_date);
		$end = new DateTime($end_date);
		$interval = new DateInterval('P1D');
		$period = new DatePeriod($start, $interval, $end);
		$dates = [];
		foreach ($period as $date) {
			$dates[] = $date->format('Y-m-d');
		}
		$dates[] = $end->format('Y-m-d');
		return $dates;
	}
}
