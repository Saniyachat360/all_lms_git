<?php
defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class Dse extends CI_Controller
{
	public function submit_action() {
        $data['lead'] = $this->Dse_leads_model->getLeads(); 
        $this->load->view('Dse_leads_view', $data);
    }	
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('table', 'form_validation', 'session'));
		$this->load->helper(array('form', 'url'));
		$this->load->model('website_lead_model');
        $this->load->model('Dse_leads_model');      
	}
	public function filter_leads() {
        $filterCriteria = $this->input->post('filterCriteria');
        $filteredLeads = $this->Dse_leads_model->getFilteredLeads($filterCriteria);
        $data['lead'] = $filteredLeads;
        $this->load->view('Dse_leads_view', $data);
    }
	public function session()
	{
		if ($this->session->userdata('username') == "") {
			redirect('login/logout');
		}
	}
	public function dse_view()
	{	
		$this->session();
        $data['leads']= $this->Dse_leads_model->select_lead();
		$this->load->view('include/admin_header.php');
		$this->load->view('Dse_leads_view.php',$data);
		$this->load->view('include/footer.php');
	}
	public function filterSubmissionProcesses1()
	{
		if (!$this->input->post('start_date') || !$this->input->post('end_date') || !$this->input->post('dse_user')) {
			$response = [
				'error' => 'Required fields are missing'
			];
		} else {
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$dse_user = $this->input->post('dse_user');
			$process_id = $this->session->userdata('process_id');
			$process =  $this->Dse_leads_model->getProcessName($process_id);
			$response = $this->Dse_leads_model->displayfiltersubmission($dse_user,$start_date,$end_date,$process);
		}
		if (!is_string($response)) {
			$response = json_encode($response);
		}
		header('Content-Type: application/json');
		echo $response;
	}
}
?>