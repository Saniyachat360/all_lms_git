<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scheme extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
		$this->load->model('scheme_model');
		
	}
	
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	
	public function index() 
	{
		$this->session();
    	$query1=$this->scheme_model->select_scheme();
		$data['select_scheme']=$query1;
		$data['select_loan_type']=$this->scheme_model->select_loan_type();
		$data['var']=site_url('scheme/insert_scheme');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('scheme_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	public function insert_scheme()
	{
		
	//	$leadsource=$this->input->post('leadsource');
		$script=$this->input->post('scheme');
		$loan_id=$this->input->post('loan_id');
	//	$leadsource_value="Manual%23".$leadsource_val;
		//echo $location_name;
		$this->scheme_model->insert_scheme($script,$loan_id);
		
		redirect('scheme');
		
	}
	public function edit_scheme($id)
	{
		$data['scheme']=$this->scheme_model->edit_scheme($id);
		$data['select_loan_type']=$this->scheme_model->select_loan_type();
		$data['var']=site_url('scheme/update_scheme');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('scheme_edit_view.php',$data);
		$this->load->view('include/footer.php');
	}
	public function update_scheme()
	{
		$script_id=$this->input->post('scheme_id');
		$script=$this->input->post('scheme');
		$loan_id=$this->input->post('loan_id');
		$this->scheme_model->update_scheme($script,$loan_id,$script_id);
		redirect('scheme');
	}
	public function delete_scheme($id)
	{
		$this->scheme_model->delete_scheme($id);
		redirect('scheme');
	}
	public function show_schemes() 
	{
		$this->session();
		$data['select_loan_type']=$this->scheme_model->select_loan_type();
		$this->load->view('include/admin_header.php');
		$this -> load -> view('scheme_show_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	public function show_scheme()
	{
	    	$loan_id=$this->input->post('loan_id');
	    		$script=$this->scheme_model->show_scheme($loan_id);
	    		if(count($script)>0){
	    		    $i=0;
	    		    foreach($script as $row){ $i++;
	    		?>
	    		<div class='col-md-offset-2 col-md-8'>
	    		    	<p><b><?php echo  $i.'> '.$row->scheme_name;?></b></p>
	    		<p><?php echo $row->scheme_desc;?></p>
	    			<hr style='border-top: 1px solid #524a4a;'>
	    		</div>
	    	
	    		<?php } }else{
	    		    
	    		    ?>
	    		<div class='col-md-offset-2 col-md-8'>
	    		<p>No Scheme Added </p>
	    		</div>
	    		<?php 
	    		}
	    	
	}
	

	}
?>
