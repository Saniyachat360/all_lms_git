<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Map_next_action_to_feedback extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
		$this->load->model('Map_next_action_to_feedback_model');
		
	}
	
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	
	public function index() 
	{
		$this->session();
		//$data['select_next_action_status']=$this->Map_next_action_to_feedback_model->select_next_action_status();
		//$data['select_feedback_status']=$this->Map_next_action_to_feedback_model->select_feedback_status();
			$data['select_process']=$this->Map_next_action_to_feedback_model->select_process();
		$process_id=$_SESSION['process_id'];
		$data['select_next_action_status']=$this->Map_next_action_to_feedback_model->select_next_action_status($process_id);
		$data['select_feedback_status']=$this->Map_next_action_to_feedback_model->select_feedback_status($process_id);
		$data['map_nxta_to_feed']=$this->Map_next_action_to_feedback_model->map_nxta_to_feed($process_id);
		$data['var']=site_url('Map_next_action_to_feedback/insert_map_next_action_to_feedback_status');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('map_next_action_to_feedback_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	public function insert_map_next_action_to_feedback_status()
	{
		
		//$naction_name=$this->input->post('naction_name');
		//echo $feedback=$this->input->post('feedback');
	$this->Map_next_action_to_feedback_model->insert_map_next_action_to_feedback_status();
		redirect('Map_next_action_to_feedback');
		
	}
	public function edit_next_action_status($id)
	{
		$data['select_next_action_status']=$q=$this->next_action_model->edit_next_action_status($id);
		//print_r($q);
		$data['var']=site_url('Map_next_action_to_feedback/edit_new_next_action_status');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('edit_new_next_action_status_view.php',$data);
		$this->load->view('include/footer.php');
	}
	public function edit_new_next_action_status()
	{
		$naction_name = $this -> input -> post('naction_name');
		$naction_id = $this -> input -> post('naction_id');
		
		$this->next_action_model->edit_new_next_action_status($naction_id,$naction_name);
		redirect('Map_next_action_to_feedback');
	}
	public function delete_next_action_to_feedback_status($id)
	{
		$this->Map_next_action_to_feedback_model->delete_next_action_to_feedback_status($id);
		redirect('Map_next_action_to_feedback');
	}
	
	
	public function searchlocation()
	{
		$data['map_nxta_to_feed']=$this->Map_next_action_to_feedback_model->searchlocation();
		$this -> load -> view('serching_map_next_action_to_feedback_view.php',$data);
	}
public function select_status()
{
	$process_id=$this->input->post('process_id');

	$select_next_action_status=$this->Map_next_action_to_feedback_model->select_next_action_status($process_id);
	$select_feedback_status=$this->Map_next_action_to_feedback_model->select_feedback_status($process_id);

?>
<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Feedback Status: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
								<select type="text" class="form-control" id="feedback" name="feedback" required><span class="glyphicon">&#xe252;</span>
                                            <option value="">Please Select</option> 
											<?php
											
											foreach($select_feedback_status as $row)
											{
												
											?>
											 <option value="<?php echo $row -> feedbackStatusName; ?>"><?php echo $row ->feedbackStatusName; ?></option> 
											
											<?php } ?>
											</select>   

								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Action Status: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<select type="text" class="form-control" id="nextaction" name="nextaction" required ><span class="glyphicon">&#xe252;</span>
                                            <option value="">Please Select</option> 
											<?php
											
											foreach($select_next_action_status as $row)
											{
												
											?>
											 <option value="<?php echo $row -> nextActionName; ?>"><?php echo $row ->nextActionName; ?></option> 
											
											<?php } ?>
											</select> 

								</div>
							</div>
							<?php
	}
}

	
?>