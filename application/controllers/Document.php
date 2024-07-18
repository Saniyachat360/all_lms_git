<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
		$this->load->model('document_model');
		
	}
	
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	
	public function index() 
	{
		$this->session();
    	$query1=$this->document_model->select_document();
		$data['select_document']=$query1;
			$data['select_loan_type']=$this->document_model->select_loan_type();
	//	$data['select_loan_type']=$this->scheme_model->select_loan_type();
	$query2=$this->document_model->select_table_data();
	//	print_r ($query2);
		$data['select_table_data']=$query2;
		$data['var']=site_url('document/insert_document');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('document_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	public function insert_document()
	{
		
	//	$leadsource=$this->input->post('leadsource');
		$document=$this->input->post('document');
		$loan_id=$this->input->post('loan_id');
		print_r($loan_id);
	//	$leadsource_value="Manual%23".$leadsource_val;
		//echo $location_name;
		$this->document_model->insert_document($document);
		
		//redirect('document');
		
	}
		public function map_document() 
	{
		$this->session();
    	$query1=$this->document_model->document_list();
		$data['select_document']=$query1;
		$data['select_loan_type']=$this->document_model->select_loan_type();
			$data['map_list']=$this->document_model->map_list();
		$data['var']=site_url('document/insert_map_document');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('document_map_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	public function insert_map_document()
	{
		
	//	$leadsource=$this->input->post('leadsource');
		$document_id=$this->input->post('document_id');
		$loan_id=$this->input->post('loan_id');
	//	$leadsource_value="Manual%23".$leadsource_val;
		//echo $location_name;
		$this->document_model->insert_map_document($document_id, $loan_id);
		
	//	redirect('document/map_document');
		
	}
	public function edit_document($id)
	{
		$data['document']=$this->document_model->edit_document($id);
			$data['select_loan_type']=$this->document_model->select_loan_type();
		$data['var']=site_url('document/update_document');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('document_edit_view.php',$data);
		$this->load->view('include/footer.php');
	}
	public function update_document()
	{
		$document_id=$this->input->post('document_id');
		$document=$this->input->post('document');
		$loan_id=$this->input->post('loan_id');
		$this->document_model->update_document($document,$document_id,$loan_id);
		redirect('document');
	}
	public function delete_document($id)
	{
		$this->document_model->delete_document($id);
		redirect('document');
	}

	

	}
?>
