<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scripts extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
		$this->load->model('scripts_model');
		
	}
	
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	
	public function index() 
	{
		$this->session();
    	$query1=$this->scripts_model->select_script();
		$data['select_script']=$query1;
		$data['select_loan_type']=$this->scripts_model->select_loan_type();
		$data['var']=site_url('scripts/insert_script');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('scripts_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	public function insert_script()
	{
		
	//	$leadsource=$this->input->post('leadsource');
		$script=$this->input->post('script');
		$loan_id=$this->input->post('loan_id');
	//	$leadsource_value="Manual%23".$leadsource_val;
		//echo $location_name;
		$this->scripts_model->insert_script($script,$loan_id);
		
		redirect('scripts');
		
	}
	public function edit_script($id)
	{
		$data['script']=$this->scripts_model->edit_script($id);
		$data['select_loan_type']=$this->scripts_model->select_loan_type();
		$data['var']=site_url('scripts/update_scripts');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('scripts_edit_view.php',$data);
		$this->load->view('include/footer.php');
	}
	public function update_scripts()
	{
		$script_id=$this->input->post('script_id');
		$script=$this->input->post('script');
		$loan_id=$this->input->post('loan_id');
		$this->scripts_model->update_scripts($script,$loan_id,$script_id);
		redirect('scripts');
	}
	public function delete_script($id)
	{
		$this->scripts_model->delete_script($id);
		redirect('scripts');
	}
	public function show_scripts() 
	{
		$this->session();
		$data['select_loan_type']=$this->scripts_model->select_loan_type();
		$this->load->view('include/admin_header.php');
		$this -> load -> view('script_show_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	public function show_script()
	{
	    	$loan_id=$this->input->post('loan_id');
	    		$script=$this->scripts_model->show_script($loan_id);
	    		if(count($script)>0){
	    		?>
	    		<div class='col-md-offset-2 col-md-8'>
	    		<p><?php echo $script[0]->script_desc;?></p>
	    		</div>
	    		<?php }else{
	    		    
	    		    ?>
	    		<div class='col-md-offset-2 col-md-8'>
	    		<p>No Script Added </p>
	    		</div>
	    		<?php 
	    		}
	    	
	}
	

	}
?>
