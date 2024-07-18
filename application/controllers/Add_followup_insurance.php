<?php
defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class Add_followup_insurance extends CI_Controller
{


	function __construct()
	{
		parent::__construct();
		$this->load->library(array('table', 'form_validation', 'session'));
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->model('Add_followup_insurance_model');
		//date_default_timezone_set('Asia/Kolkata');
		date_default_timezone_set('Asia/Calcutta');
	}
	public function session()
	{
		if ($this->session->userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function detail($id, $path)
	{
		$this->session();
		$enq_id = $id;
		$data['path'] = $path;

		//Get Previous Followup Details
		$data['lead_detail'] = $query = $this->Add_followup_insurance_model->select_lead($enq_id);
		//print_r($data['lead_detail']);

		//Get select box values
		
		
		$data['feedback_status'] = $this->Add_followup_insurance_model->select_feedback_status();
		$data['next_action_status'] = $this->Add_followup_insurance_model->next_action_status();
		$data['process'] = $this->Add_followup_insurance_model->process();

		$data['get_location1'] = $query1 = $this->Add_followup_insurance_model->select_location();
		$data['select_followup_lead'] = $q = $this->Add_followup_insurance_model->select_followup_lead($enq_id);
		$data['var'] = site_url('add_followup_insurance/insert_followup');

		$this->load->view('include/admin_header.php');
		$this->load->view('Add_followup_insurance_view.php', $data);
		$this->load->view('include/footer.php');
	}
	public function detail1($id, $path)
	{
		$this->session();
		$enq_id = $id;
		$data['path'] = $path;
		//Get Previous Followup Details
		$data['lead_detail'] = $query = $this->Add_followup_insurance_model->select_lead($enq_id);
		//print_r($data['lead_detail']);

		//Get select box values
		
		
		$data['feedback_status'] = $this->Add_followup_insurance_model->select_feedback_status();
		$data['next_action_status'] = $this->Add_followup_insurance_model->next_action_status();
		$data['process'] = $this->Add_followup_insurance_model->process();

		$data['get_location1'] = $query1 = $this->Add_followup_insurance_model->select_location();


		$data['select_followup_lead'] = $q = $this->Add_followup_insurance_model->select_followup_lead($enq_id);


		$data['var'] = site_url('add_followup_new_car/insert_followup');
		$this->load->view('include/admin_header.php');
		$this->load->view('Add_followup_insurance_view.php', $data);
		$this->load->view('include/footer.php');
	}
	
	/**** Next Action using feedback *****/
	//Filter for select next action from feedback_status
	public function select_next_action()
	{
		$next_action_status = $this->Add_followup_insurance_model->select_next_action();
	?>
		<label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Next Action:
		</label>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<select name="nextaction" id="nextaction" class="form-control" onchange='check_nfd(this.value);' required>
				<option value="">Please Select </option>
				<?php foreach ($next_action_status as $row13) { ?>
					<option value="<?php echo $row13->nextActionName; ?>"><?php echo $row13->nextActionName; ?></option>
				<?php } ?>
			</select>
		</div>
	<?php

	}
	/****Buy Car Details Div *****/
	// Filter for select variant using model name
	
	
	

	// Insert New Car Followup Details
	function insert_followup()
	{
		$this->session();
		//$query1=$this -> Add_followup_insurance_model -> send_sms();
		$query = $this->Add_followup_insurance_model->insert_followup();

		/*if (!$query) {
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Followup Added Successfully...!</strong>');
			} else {
			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Followup Not added ...!</strong>');
			}*/

		//Send quotation 

		$customer_name = $this->input->post('customer_name');
		// echo "customer Name: ". $customer_name;
		// exit;

		$email = $this->input->post('email');
		$quotation_location = $this->input->post('qlocation');
		$quotation_model_name = $this->input->post('model_id');
		$quotation_description = $this->input->post('description');
		$accessories_package_name = $this->input->post('accessories_package_name');
		$phone = $this->input->post('phone');
		$new_model = $this->input->post('new_model');
		$brochure = $this->input->post('brochure');
		if (isset($brochure)) {
			$brochure = 'Checked';
		} else {
			$brochure = 'Not Checked';
		}
		if ($quotation_model_name != '' ||  $brochure == 'Checked') {
			$this->send_mail($email, $customer_name, $quotation_location, $quotation_model_name, $quotation_description, $accessories_package_name, $phone, $new_model, $brochure);
		}
		$a = $_POST['loc'];
		$page_location = str_replace('%20', ' ', $a);
		if ($page_location == 'Pending Followup') {
			//redirect pending attended details
			redirect('pending/telecaller_leads');
		} elseif ($page_location == 'Pending New') {
			//redirect pending not attended details
			redirect('pending/telecaller_leads_not_attended');
		} elseif ($page_location == 'Today Followup') {
			//redirect today followup details
			redirect('today_followup');
		} else if ($page_location == 'New') {
			//redirect new assign lead details
			redirect('new_lead');
		} else if ($page_location == 'Home Visit Today') {
			//redirect new assign lead details
			redirect('home_visit/leads');
		} else if ($page_location == 'Showroom Visit Today') {
			//redirect new assign lead details
			redirect('showroom_visit/leads');
		} else if ($page_location == 'Test Drive Today') {
			//redirect new assign lead details
			redirect('test_drive/leads');
		} else if ($page_location == 'Evaluation Today') {
			//redirect new assign lead details
			redirect('evaluation/leads');
		} else {
			//redirect data leads details
			/*if($_SESSION['user_id']==1)
		{

		}else
		{*/
			redirect('website_leads/telecaller_leads/' . $page_location);
			//}

		}
	}


	
	
}
?>