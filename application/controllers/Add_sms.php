<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_sms extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('add_sms_model');

	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function index() {
		
		$this->session();
		
		$test=$data['select_feedback_status'] = $this -> add_sms_model -> select_feedback_status();
	
		$data['select_table'] = $this -> add_sms_model -> select_table();
		$data['var'] = site_url('add_sms/add_sms');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('add_sms_view.php',$data);
		$this -> load -> view('include/footer.php');

	}
	
	
	public function add_sms() {

	$next_action=$this->input->post('next_action');
	$feedback_status=$this->input->post('feedback_status');
	$sms=$this->input->post('sms');
	$query=$this->add_sms_model->add_sms($next_action,$sms,$feedback_status);
	redirect("add_sms");
	
	}
	
	
	public function edit_sms() {

		$this->session();
		$id = $this -> input -> get('id');
		$data['select_feedback_status'] = $this -> add_sms_model -> select_feedback_status();
		$query = $this -> add_sms_model -> edit_sms($id);
		$data['edit_sms']=$query;	
		
		$data['var1'] = site_url('add_sms/update_sms');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('edit_sms_view',$data);
		$this -> load -> view('include/footer');

	}
	
	function update_sms() {
	
	$sms_id=$this->input->post('id');
	$next_action=$this->input->post('next_action');
	$feedback_status=$this->input->post('feedback_status');
	$sms=$this->input->post('sms');
	$query=$this->add_sms_model->update_sms($sms_id,$next_action,$feedback_status,$sms);
		redirect('add_sms');
	}
	
function del_sms() {
	
	$sms_id = $this -> input -> get('id');
	
	$query=$this->add_sms_model->del_sms($sms_id);
		redirect('add_sms');
	}

	public function select_next_action()	{
			
			
		$feedback_status=$this->input->post('feedback_status');			
		//echo $status_id;
		
		
		
		$query=$this->add_sms_model->select_next_action($feedback_status);
		$data['select_next_action']=$query;	
		//print_r($query);		
		?>         	                  
			<select class="filter_s form-control" required multiple="multiple" name="next_action[]" >
				
				<?php foreach($query as $fetch) {			?>	
				<option value="<?php echo $fetch->nextActionName;?>"><?php echo $fetch->nextActionName;?></option>
	            <?php } ?>
	         </select>
		<?php		
		
	}
public function select_next_action_edit()	{
			
			
		$feedback_status=$this->input->post('feedback_status');			
		//echo $status_id;
		
		
		
		$query=$this->add_sms_model->select_next_action($feedback_status);
		$data['select_next_action']=$query;	
		//print_r($query);		
		?>         	                  
			<select class="filter_s form-control" required  name="next_action" >
				
				<?php foreach($query as $fetch) {			?>	
				<option value="<?php echo $fetch->nextActionName;?>"><?php echo $fetch->nextActionName;?></option>
	            <?php } ?>
	         </select>
		<?php		
		
	}
	
}
