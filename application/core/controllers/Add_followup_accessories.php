<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_followup_accessories extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper('form');
		$this -> load -> helper('url');
		$this -> load -> model('Add_followup_accessories_model');
		date_default_timezone_set('Asia/Kolkata');

	}

	public function detail($enq_id,$enq) {
		$data['enq_id']=$enq_id;
		$data['enq']=$enq;
		$lead_details=$data['lead_detail'] = $this -> Add_followup_accessories_model -> select_lead($enq_id);
		if(isset($lead_details[0]->feedbackStatus)){
		$data['select_nextaction']=$this->Add_followup_accessories_model->select_next_action($lead_details[0]->feedbackStatus);
		}
		$data['select_followup_lead']=$this->Add_followup_accessories_model -> select_followup_lead($enq_id);
		$data['select_accessories_list']=$this->Add_followup_accessories_model -> select_accessories_list($enq_id);
		$data['select_accessories']=$this->Add_followup_accessories_model->select_accessories();
		$data['select_model']=$this->Add_followup_accessories_model->select_model();
		$data['select_feedback_status']=$this->Add_followup_accessories_model->select_feedback_status();
		$data['process'] = $this -> Add_followup_accessories_model -> process();
		$data['get_location1'] = $query1 = $this -> Add_followup_accessories_model -> select_location();
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('Add_followup_accessories_view.php',$data);
		$this -> load -> view('include/footer.php');
	}
	public function select_next_action()
	{
		$feedbackStatus=$this->input->post('feedbackStatus');
		$selectNextAction=$this->Add_followup_accessories_model->select_next_action($feedbackStatus);
		?>
		<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Action: </label>
                                   			<div class="col-md-8 col-sm-8 col-xs-12">
                                            	<select name="nextAction" class="form-control" required >
                                					<option value="">Please Select</option>
                                					<?php foreach ($selectNextAction as $row) {?>
														<option value="<?php echo $row -> nextActionName; ?>"><?php echo $row -> nextActionName; ?></option>
													<?php } ?>
	                                			</select>
                                            </div>
 <?php
	}
	public function delete_accessories($purchase_id,$enq_id,$enq)
	{
		$this->Add_followup_accessories_model -> delete_accessories($purchase_id);
		redirect('add_followup_accessories/detail/'.$enq_id.'/'.$enq);
	}
	
	public function insert_followup()
	{
		$this->Add_followup_accessories_model -> insert_followup();
		echo $a = $_POST['loc'];
		 $page_location=str_replace('%20',' ',$a);
		
		
		if ($page_location == 'Pending Followup') {
			//redirect pending attended details
		redirect('pending/telecaller_leads');
		} elseif ($page_location == 'Pending New') {
			//redirect pending not attended details
		redirect('pending/telecaller_leads_not_attended');
		} elseif ($page_location == 'Today Followup') {
			//redirect today followup details
		redirect('today_followup');
		} else if($page_location == 'New'){
			//redirect new assign lead details
		redirect(new_lead);
		}
		else {
			redirect('website_leads/telecaller_leads/'.$page_location);
		}
		
	}
	public function lms_details($enq_id,$enq)
	{
		$data['enq']=$enq;
		$data['select_data']=$this->Add_followup_accessories_model->select_customer_details($enq_id);
		$this -> load -> view('include/admin_header.php',$data);
		$this -> load -> view('lms_detail_view.php',$data);
		$this -> load -> view('include/footer.php');
	}
}
?>
