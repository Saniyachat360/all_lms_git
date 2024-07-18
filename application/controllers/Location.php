<?php
defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class Location extends CI_Controller
{
   
	public function submit_action() {
        $data['lead'] = $this->Location_model->getLeads(); 
        $this->load->view('Location_view', $data);
    }
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('table', 'form_validation', 'session'));
		$this->load->helper(array('form', 'url'));
		$this->load->model('website_lead_model');
        $this->load->model('Location_model');      
	}
	public function filter_leads() {
        $filterCriteria = $this->input->post('filterCriteria');
        $filteredLeads = $this->Leads_model->getFilteredLeads($filterCriteria);
        $data['lead'] = $filteredLeads;
        $this->load->view('Location_view', $data);
    }
	public function session()
	{
		if ($this->session->userdata('username') == "") {
			redirect('login/logout');
		}
	}
	
	
	
	public function front_view()
	{	
	    
		$this->session();
        $data['leads']= $this->Location_model->select_lead();
		$this->load->view('include/admin_header.php');
		$this->load->view('location_view.php',$data);
		$this->load->view('include/footer.php');
	}
	
	public function filterSubmissionProcesses1()
	{
		
		if (!$this->input->post('start_date') || !$this->input->post('end_date') || !$this->input->post('location')) {
			$response = [
				'error' => 'Required fields are missing'
			];
		} else {
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$location = $this->input->post('location');
			$process = $this->input->post('process');
			
			$response = $this->Location_model->displayfiltersubmission($location,$start_date,$end_date,$process);
			
		}
		if (!is_string($response)) {
			$response = json_encode($response);
		}
		header('Content-Type: application/json');
		echo $response;
	}
}
?>