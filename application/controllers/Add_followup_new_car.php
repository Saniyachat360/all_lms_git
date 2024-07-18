<?php
defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class Add_followup_new_car extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('table', 'form_validation', 'session'));
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->model('Add_followup_new_car_model');
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
		$data['lead_detail'] = $query = $this->Add_followup_new_car_model->select_lead($enq_id);
		//print_r($data['lead_detail']);

		//Get select box values
		$data['make_models'] = $this->Add_followup_new_car_model->make_models();
		$data['model_variant'] = $this->Add_followup_new_car_model->select_variant_main();
		$data['feedback_status'] = $this->Add_followup_new_car_model->select_feedback_status();
		$data['next_action_status'] = $this->Add_followup_new_car_model->next_action_status();
		$data['process'] = $this->Add_followup_new_car_model->process();
		$data['corporate'] = $this->Add_followup_new_car_model->corporate();
		$data['get_location1'] = $query1 = $this->Add_followup_new_car_model->select_location();
		$data['evalution_location'] = $this->Add_followup_new_car_model->select_evaluation_location();
		$data['select_city'] = $this->Add_followup_new_car_model->select_city();
		$data['select_followup_lead'] = $q = $this->Add_followup_new_car_model->select_followup_lead($enq_id);
		$data['makes'] = $this->Add_followup_new_car_model->makes();
		$data['duplicate_record'] = $this->Add_followup_new_car_model->get_duplicate_record($enq_id);
		$data['quotation_download'] = $this->Add_followup_new_car_model->select_quotation_download($enq_id);

		$data['quotation_location'] = $this->Add_followup_new_car_model->quotation_location();

		$data['var'] = site_url('add_followup_new_car/insert_followup');

		$this->load->view('include/admin_header.php');
		$this->load->view('Add_followup_new_car_view1.php', $data);
		$this->load->view('include/footer.php');
	}
	public function detail1($id, $path)
	{
		$this->session();
		$enq_id = $id;
		$data['path'] = $path;
		//Get Previous Followup Details
		$data['lead_detail'] = $query = $this->Add_followup_new_car_model->select_lead($enq_id);
		//print_r($data['lead_detail']);

		//Get select box values
		$data['make_models'] = $this->Add_followup_new_car_model->make_models();
		$data['model_variant'] = $this->Add_followup_new_car_model->select_variant_main();
		$data['feedback_status'] = $this->Add_followup_new_car_model->select_feedback_status();
		$data['next_action_status'] = $this->Add_followup_new_car_model->next_action_status();
		$data['process'] = $this->Add_followup_new_car_model->process();
		$data['corporate'] = $this->Add_followup_new_car_model->corporate();
		$data['get_location1'] = $query1 = $this->Add_followup_new_car_model->select_location();
		$data['evalution_location'] = $this->Add_followup_new_car_model->select_evaluation_location();
		$data['select_city'] = $this->Add_followup_new_car_model->select_city();
		$data['select_followup_lead'] = $q = $this->Add_followup_new_car_model->select_followup_lead($enq_id);
		$data['makes'] = $this->Add_followup_new_car_model->makes();
		$data['duplicate_record'] = $this->Add_followup_new_car_model->get_duplicate_record($enq_id);
		$data['var'] = site_url('add_followup_new_car/insert_followup');
		$this->load->view('include/admin_header.php');
		$this->load->view('Add_followup_new_car_view1.php', $data);
		$this->load->view('include/footer.php');
	}
	function select_model()
	{
		$make = $_POST['make'];
		$query = $this->Add_followup_new_car_model->select_model($make);		 ?>
		<label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name"> Car Model:</label>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<select name="old_model" id="model" class="form-control" required>
				<option value="">Please Select </option>
				<?php foreach ($query as $row) { ?>
					<option value="<?php echo $row->model_id; ?>"><?php echo $row->model_name; ?></option>
				<?php } ?>
			</select>
		</div>
	<?php
	}
	/**** Next Action using feedback *****/
	//Filter for select next action from feedback_status
	public function select_next_action()
	{
		$next_action_status = $this->Add_followup_new_car_model->select_next_action();
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
	function select_variant()
	{
		$model = $_POST['model'];
		$query = $this->Add_followup_new_car_model->select_variant($model);
	?>
		<label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">New Car Variant:</label>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<select name="new_variant" id="new_variant" class="form-control" required>
				<option value="">Please Select </option>
				<?php foreach ($query as $row) { ?>
					<option value="<?php echo $row->variant_id; ?>"><?php echo $row->variant_name; ?></option>
				<?php } ?>
			</select>
		</div>
		<?php }
	/**** Transfer Div Details *****/
	// Transfer Location
	function select_transfer_location()
	{
		$tprocess = $this->input->post('tprocess');
		$user_id = $this->session->userdata('user_id');
		$check_user_process12 = $this->db->query("select p.process_id
									from lmsuser l 
									Left join tbl_manager_process mp on mp.user_id=l.id 
									Left join tbl_process p on p.process_id=mp.process_id
									where mp.user_id='$user_id' and mp.process_id ='$tprocess' ");


		$check_user_process1 = $check_user_process12->result();

		if (($check_user_process12->num_rows()) > 0) {


			$get_location1 = $this->Add_followup_new_car_model->select_transfer_location($tprocess); ?>

			<div class="form-group">
				<label class="control-label col-md-12 col-sm-12 col-xs-12">Transfer Location:</label>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<select name="tlocation" id="tlocation1" class="form-control" required onchange="select_assign_to()">
						<option value="">Please Select </option>
						<?php foreach ($get_location1 as $fetch1) { ?>
							<option value="<?php echo $fetch1->location; ?>"><?php echo $fetch1->location; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		<?php
		} else { ?>
			<div class="form-group" style="display: none">
				<label class="control-label col-md-12 col-sm-12 col-xs-12">Transfer Location:</label>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<select name="tlocation" id="tlocation1" class="form-control" onchange="select_assign_to()">
						<option value="">Please Select </option>

					</select>
				</div>
			</div>
		<?php

		}
	}
	// Select Transfer user name using Transfer Location
	public function select_assign_to()
	{
		$location = $this->input->post('tlocation1');
		$tprocess = $this->input->post('tprocess');
		$select_assign = $this->Add_followup_new_car_model->lmsuser($location, $tprocess); ?>
		<!--	<div  class="form-group">
			 <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Transfer To:</label>
                   <div class="col-md-8 col-sm-8 col-xs-12">-->
		<select name="transfer_assign" required id="tassignto1" class="form-control">
			<option value="">Please Select </option>
			<?php foreach ($select_assign as $row) { ?>
				<option value="<?php echo $row->id; ?>"><?php echo $row->fname . ' ' . $row->lname; ?> </option>
			<?php } ?>
		</select>
		<!--	</div>
				</div>-->
	<?php
	}
	// Select Transfer user name using Transfer Location
	public function select_assign_to_evaluation()
	{
		$location = $this->input->post('tlocation1');
		$tprocess = $this->input->post('tprocess');
		$select_assign = $this->Add_followup_new_car_model->lmsuser($location, $tprocess);
		//print_r($select_assign); 
	?>
		<!--	<div  class="form-group">
			 <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Transfer To:</label>
                   <div class="col-md-8 col-sm-8 col-xs-12">-->
		<select name="evaluation_assign_to" id="evaluation_assign_to" class="form-control">
			<option value="">Please Select </option>
			<?php foreach ($select_assign as $row) { ?>
				<option value="<?php echo $row->id; ?>"><?php echo $row->fname . ' ' . $row->lname; ?> </option>
			<?php } ?>
		</select>
		<!--	</div>
				</div>-->
	<?php
	}


	public function check_accessories()
	{

		$model_name = $this->input->post('model_name');


		//echo $model_name;
		//echo $city;

		$check_accessories = $this->Add_followup_new_car_model->check_accessories($model_name);

		//	print_r($select_description);
	?>
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4 col-xs-12"> Accessories Package: </label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<select name="package" id="package" class="form-control">
						<option value="">Please Select</option>
						<?php foreach ($check_accessories as $row) { ?>
							<option value="<?php echo $row->accessories_package_id; ?>"><?php echo $row->package_name ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
	<?php
	}

// 	// Insert New Car Followup Details
	function insert_followup()
	{
		$this->session();
		//$query1=$this -> Add_followup_new_car_model -> send_sms();
		$query = $this->Add_followup_new_car_model->insert_followup();

		/*if (!$query) {
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Followup Added Successfully...!</strong>');
			} else {
			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Followup Not added ...!</strong>');
			}*/

		//Send quotation 

		$customer_name = $this->input->post('customer_name');
		$email = $this->input->post('email');
		$quotation_location = $this->input->post('qlocation');
		$quotation_model_name = $this->input->post('model_id');
		$quotation_description = $this->input->post('description');
		$accessories_package_name = $this->input->post('accessories_package_name');
		$phone = $this->input->post('phone');
		$new_model = $this->input->post('new_model');
		$brochure = $this->input->post('brochure');
		$new_model = $this->input->post('new_model');
		$whatsap = $this->input->post('whatsapp');
		$sms = $this->input->post('sms');
		$rm_name = $this->session->userdata('username');
		$username = $this->session->userdata('username');
		$trans_id = $this->input->post('transfer_assign');
		
		
			if ($trans_id != '' && $whatsap == 'on') {
			$this->Add_followup_new_car_model->whatsapp_sms1($customer_name, $phone, $new_model, $rm_name, $trans_id);
		} else {
			if ($whatsap == 'on') {
				$this->Add_followup_new_car_model->whatsapp_sms($customer_name, $phone, $new_model, $rm_name);
			}
		}
		
		//send sms
		
		if ($sms == 'on') {
			$this -> Add_followup_new_car_model -> send_sms_calling_task($customer_name,$phone,$new_model,$username);
		}
		
		
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




    // Insert New Car Followup Details
// 	function insert_followup()
// 	{
// 		$this->session();

// 		//Send quotation 

// 		$customer_name = $this->input->post('customer_name');
// 		$email = $this->input->post('email');
// 		$phone = $this->input->post('phone');
// 		$new_model = $this->input->post('new_model');
// 		$quotation_location = $this->input->post('qlocation');
// 		$quotation_model_name = $this->input->post('model_id');
// 		$quotation_description = $this->input->post('description');
// 		$accessories_package_name = $this->input->post('accessories_package_name');
// 		$brochure = $this->input->post('brochure');
// 		$whatsap = $this->input->post('whatsapp');
// 		$trans_id = $this->input->post('transfer_assign');
// 		$username = $this->session->userdata('username');
// 		$rm_name = $this->session->userdata('username');



// 		if ($trans_id != '' && $whatsap == 'on') {
// 			$this->Add_followup_new_car_model->whatsapp_sms1($customer_name, $phone, $new_model, $trans_id);
// 		} else {
// 			if ($whatsap == 'on') {
// 				$this->Add_followup_new_car_model->whatsapp_sms($customer_name, $phone, $new_model, $rm_name);
// 			}
// 		}


//         // send sms
// 		$sms = $this->input->post('sms');
// 		if ($sms == 'on') {
// 			$this -> Add_followup_new_car_model -> send_sms_calling_task($customer_name,$phone,$new_model,$username);
// 		}


// 		if (isset($brochure)) {
// 			$brochure = 'Checked';
// 		} else {
// 			$brochure = 'Not Checked';
// 		}
// 		if ($quotation_model_name != '' ||  $brochure == 'Checked') {
// 			$this->send_mail($email, $customer_name, $quotation_location, $quotation_model_name, $quotation_description, $accessories_package_name, $phone, $new_model, $brochure);
// 		}


// 		$a = $_POST['loc'];
// 		$page_location = str_replace('%20', ' ', $a);
// 		if ($page_location == 'Pending Followup') {
// 			//redirect pending attended details
// 			redirect('pending/telecaller_leads');
// 		} elseif ($page_location == 'Pending New') {
// 			//redirect pending not attended details
// 			redirect('pending/telecaller_leads_not_attended');
// 		} elseif ($page_location == 'Today Followup') {
// 			//redirect today followup details
// 			redirect('today_followup');
// 		} else if ($page_location == 'New') {
// 			//redirect new assign lead details
// 			redirect('new_lead');
// 		} else if ($page_location == 'Home Visit Today') {
// 			//redirect new assign lead details
// 			redirect('home_visit/leads');
// 		} else if ($page_location == 'Showroom Visit Today') {
// 			//redirect new assign lead details
// 			redirect('showroom_visit/leads');
// 		} else if ($page_location == 'Test Drive Today') {
// 			//redirect new assign lead details
// 			redirect('test_drive/leads');
// 		} else if ($page_location == 'Evaluation Today') {
// 			//redirect new assign lead details
// 			redirect('evaluation/leads');
// 		} else {
// 			redirect('website_leads/telecaller_leads/' . $page_location);
// 		}
// 	}
    
    
    

	//Send Quotation mail to used 
	public function send_mail($email, $customer_name, $quotation_location, $quotation_model_name, $quotation_description, $accessories_package_name, $phone, $new_model, $brochure)
	{
		$this->load->helper('path');
		if ($quotation_model_name != '') {
			$select_data = $data['select_data'] = $this->Add_followup_new_car_model->select_quotation_data($quotation_location, $quotation_model_name, $quotation_description, $accessories_package_name);
		}
		$data['customer_name'] = $customer_name;
		$data['quotation_location'] = $quotation_location;
		$data['model_id'] = $quotation_model_name;
		$data['accessories_package_name'] = $accessories_package_name;
		//$this->load->view('new_send_quotation_view.php',$data);

		$config = array(
			'mailtype'  => 'html'
		);
		$this->load->library('email', $config);
		$id = $_SESSION['user_id'];
		$query = $this->db->query("select email from lmsuser where id='$id'")->result();
		$user_email_id = $query[0]->email;
		if ($user_email_id == 'admin@autovista.in') {
			$user_email_id = 'jamil@autovista.in';
		}
		$this->email->from('websupport@autovista.in', 'Autovista.in');
		$this->email->to($email);
		//$this->email->cc($user_email_id);
		//$this->email->bcc('snehal@autovista.in');	
		if ($quotation_model_name != '') {
			$this->email->subject('Maruti ' . $select_data[0]->model . ' Quotation From Autovista');
			$body = $this->load->view('new_send_quotation_view.php', $data, TRUE);
			$this->email->message($body);
		}

		//$this->email->attach('https://autovista.in/all_lms/car_quotation.csv');
		if ($brochure == 'Checked') {
			$select_brochure = $this->Add_followup_new_car_model->select_brochure($new_model);
			if ($quotation_model_name == '') {
				$this->email->subject('Maruti ' . $select_brochure[0]->model_name . ' Brochure From Autovista');
				$msg = 'Dear ' . $customer_name . '<br><br>' . 'Maruti ' . $select_brochure[0]->model_name . ' Brochure';
				$this->email->message($msg);
			}
			$this->email->attach('https://autovista.in/assets/Brochure/' . $select_brochure[0]->brochure);
		}

		$this->email->send();
		//$csv_handler = fopen ('car_quotation.csv','w');
		//file_put_contents("car_quotation.csv", "");
		//fclose ($csv_handler);
		// echo $this->email->print_debugger();

	}

	/*public function send_sms($disposition,$phone,$sms1)
  	{
  		$request = ""; //initialize the request variable
		$param["user"] = "autovista"; //this is the username of our TM4B account
		$param["password"] = "asd456"; //this is the password of our TM4B account

		$param["text"] = $sms1; //this is the message that we want to send
		$param["PhoneNumber"] = $phone; //these are the recipients of the message

		$param["sender"] = "ATVSTA";//this is our sender 

		foreach($param as $key=>$val) //traverse through each member of the param array
		{ 
  			$request.= $key."=".urlencode($val); //we have to urlencode the values
  			$request.= "&"; //append the ampersand (&) sign after each paramter/value pair
		}
		$request = substr($request, 0, strlen($request)-1); //remove the final ampersand sign from the request

		//First prepare the info that relates to the connection
		$host = "sms.fortunemicrosystem.com";
		$script = "/sendsms.asp";
		$request_length = strlen($request);
		$method = "POST"; // must be POST if sending multiple messages
		if ($method == "GET") 
		{
  			$script .= "?$request";
		}

		//Now comes the header which we are going to post. 
		$header = "$method $script HTTP/1.1\r\n";
		$header .= "Host: $host\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: $request_length\r\n";
		$header .= "Connection: close\r\n\r\n";
		$header .= "$request\r\n";

		//Now we open up the connection
		$socket = @fsockopen($host, 80, $errno, $errstr); 
		if ($socket) //if its open, then...
		{ 
  			fputs($socket, $header); // send the details over
  			while(!feof($socket))
  			{
    			$output[] = fgets($socket); //get the results 
  			}
  			fclose($socket); 
		} 
		print_r($output);
}*/
	function send_quot()
	{
		//$quotation_location=$data['model_id']='1';
		$data['customer_name'] = 'Test';
		$quotation_model_name = $data['model_name'] = 'Alto K10';
		$quotation_description = $data['variant_id'] = '407';
		$quotation_location = $data['location'] = 'Pune';
		$select_data = $this->Add_followup_new_car_model->select_quotation_data($quotation_location, $quotation_model_name, $quotation_description);
		$data['select_data'] = $select_data;

		$this->load->view('new_send_quotation_view.php', $data);
	}
	//Send Quotation mail to used 
	public function send_quotation()
	{
		$this->load->helper('path');

		// Get Form Data
		$email = $this->input->post('email');
		$customer_name = $data['customer_name'] = $this->input->post('customer_name');
		$quotation_location = $data['quotation_location'] = $this->input->post('qlocation');
		$quotation_model_name = $data['model_name'] = $this->input->post('model_id');
		$quotation_description = $data['variant_id'] = $this->input->post('description');
		$finance_data = $data['finance_data'] = $this->input->post('finance_data');
		$path = $this->input->post('path');
		$enq_id = $this->input->post('booking_id');
		$quotation_type = $data['type'] = $this->input->post('quotation_type');
		$accessories_package_name = '';

		$data['select_data'] = $select_data = $this->Add_followup_new_car_model->select_quotation_data($quotation_location, $quotation_model_name, $quotation_description, $accessories_package_name);

		$this->load->view('new_send_quotation_view.php', $data);
		$config = array(
			'mailtype'  => 'html'
		);

		$this->load->library('email', $config);
		$id = $_SESSION['user_id'];
		$query = $this->db->query("select email from lmsuser where id='$id'")->result();
		$user_email_id = $query[0]->email;
		if ($user_email_id == 'admin@autovista.in') {
			$user_email_id = 'jamil@autovista.in';
		}
		$this->email->from('lmssupport@autovista.in', 'Autovista.in');

		$this->email->to($email);
		$this->email->to('jamil.shaikh50@gmail.com');
		//$this->email->cc($user_email_id);
		//$this->email->bcc('snehal@autovista.in');	

		if (isset($select_data[0]->model)) {
			$this->email->subject('Maruti ' . $select_data[0]->model . ' Quotation From Autovista');
			$body = $this->load->view('new_send_quotation_view.php', $data, TRUE);
			$this->email->message($body);
		}
		$this->email->send();




		redirect('add_followup_new_car/detail/' . $enq_id . '/' . $path);
	}
	public function insert_escalation_detail()
	{
		$this->session();
		$id = $this->input->post('booking_id');
		$path = $this->input->post('path');
		$escalation_type = $this->input->post('escalation_type');
		$this->Add_followup_new_car_model->insert_escalation_detail();

		$this->send_escalation_mail($id, $escalation_type);
		if ($_SESSION['process_id'] == '6') {
			redirect('add_followup_new_car/detail/' . $id . '/' . $path);
		} elseif ($_SESSION['process_id'] == '7') {
			redirect('add_followup_used_car/detail/' . $id . '/' . $path);
		}
	}
	public function insert_escalation_resolve_detail()
	{
		$this->session();
		$id = $this->input->post('booking_id');
		$path = $this->input->post('path');
		$escalation_type = $this->input->post('resolved_escalation_type');

		$this->Add_followup_new_car_model->insert_escalation_resolve_detail();

		//$this->send_escalation_mail($id,$escalation_type);
		if ($_SESSION['process_id'] == '6') {
			redirect('add_followup_new_car/detail/' . $id . '/' . $path);
		} elseif ($_SESSION['process_id'] == '7') {
			redirect('add_followup_used_car/detail/' . $id . '/' . $path);
		}
	}

	//Send Quotation mail to used 
	public function send_escalation_mail($enq_id, $escalation_type)
	{

		$query = $this->Add_followup_new_car_model->get_escalation_detail($enq_id);
		$data['query'] = $query;
		echo $csetl_email = $query[0]->csetl_email;
		echo $dsetl_email = $query[0]->dsetl_email;
		echo $gm_email = $query[0]->gm_email;
		echo $sm_email = $query[0]->sm_email;

		//"pereira_irwin@autovista.in","shaikh.hafiz@autovista.in",'$csetl_email','$dsetl_email','$gm_email','$sm_email'
		$this->load->helper('path');
		$config = array(
			'mailtype'  => 'html'
		);
		$this->load->library('email', $config);
		$this->email->from('websupport@autovista.in', 'Autovista.in');
		if ($escalation_type == 'Escalation Level 1') {
			//$this->email->to("jamil@autovista.in");
			if ($_SESSION['process_id'] == '7') {
				$this->email->to("pereira_irwin@autovista.in,samarth.sharma@autovista.in,vishal12.autovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
			} else {
				$this->email->to("pereira_irwin@autovista.in,shaikh.hafiz@autovista.in,vishal12.autovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
			}
		} elseif ($escalation_type == 'Escalation Level 2') {
			//$this->email->to("jamil.shaikh50@gmail.com");
			if ($_SESSION['process_id'] == '7') {
				$this->email->to("pereira_irwin@autovista.in,samarth.sharma@autovista.in,anuj.agarwal@autovista.in,vishal12.autovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
			} else {
				$this->email->to("pereira_irwin@autovista.in,shaikh.hafiz@autovista.in,amitesh.agrawal@autovista.in,vishal12.autovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
			}
		} elseif ($escalation_type == 'Escalation Level 3') {
			if ($_SESSION['process_id'] == '7') {
				$this->email->to("pereira_irwin@autovista.in,samarth.sharma@autovista.in,anuj.agarwal@autovista.in,vishal12.autovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
			} else {
				$this->email->to("pereira_irwin@autovista.in,shaikh.hafiz@autovista.in,amitesh.agrawal@autovista.in,vishal12.autovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
			}
		} else {
			$this->email->to("jamil@autovista.in");
		}

		$this->email->bcc('jamil@autovista.in');
		$this->email->subject("LMS Escalation (" . $escalation_type . ")");
		$data['enq_id'] = $enq_id;
		$data['escalation_type'] = $escalation_type;
		$body = $this->load->view('send_evaluation_mail_view.php', $data, true);
		$this->email->message($body);
		$this->email->send();
	}
	public function duplicate_record_details($enq_id)
	{
		$this->session();
		$data['lead_details'] = $this->Add_followup_new_car_model->duplicate_record_details($enq_id);
		$data['enq_id'] = $enq_id;
		$this->load->view('include/admin_header.php');
		$this->load->view('duplicate_record_detail_view.php', $data);
		$this->load->view('include/footer.php');
	}




	public function quote()
	{
		//$this -> session();

		$this->load->view('include/admin_header.php');
		$this->load->view('quotation_view.php');
		$this->load->view('include/footer.php');
	}
	/**** Send Quotation Div *****/
	//Select Model Name using Send Quotation location 
	public function select_model_name()
	{
		$city = $this->input->post('city');
		$select_model_name = $this->Add_followup_new_car_model->select_model_name($city);
	?>
		<select name="model_id" id="model_name" class="form-control" onchange="select_description();" required>
			<option value="">Please Select </option>
			<?php foreach ($select_model_name as $row) { ?>
				<option value="<?php echo $row->model_id; ?>"><?php echo $row->model_name; ?></option>
			<?php } ?>
		</select>
	<?php
	}
	//Select Description Using Model name in send quotation
	public function select_description()
	{

		$model_name = $this->input->post('model_name');
		$city = $this->input->post('city');

		//echo $model_name;
		//echo $city;

		$select_description = $this->Add_followup_new_car_model->select_description($model_name, $city);

		//	print_r($select_description);
	?>
		<select name="description" id="description" class="form-control">
			<option value="">Please Select</option>
			<?php foreach ($select_description as $row) { ?>
				<option value="<?php echo $row->variant_id; ?>"><?php echo $row->variant_name ?></option>
			<?php } ?>
		</select>


	<?php
	}
	//Send Quotation mail to used 
	public function send_quotation_from_header()
	{
		$this->load->helper('path');

		// Get Form Data
		$email = $this->input->post('email');
		$page_path = $this->input->post('page_path');
		$enq_id = $this->input->post('enq_id');
		$customer_name = $data['customer_name'] = $this->input->post('customer_name');
		$quotation_location = $data['quotation_location'] = $this->input->post('qlocation');
		$quotation_model_name = $data['model_name'] = $this->input->post('model_id');
		$quotation_description = $data['variant_id'] = $this->input->post('description');
		$finance_data = $data['finance_data'] = $this->input->post('finance_data');
		$quotation_type = $data['type'] = $this->input->post('quotation_type');

		$this->Add_followup_new_car_model->insert_header_quotation($quotation_location, $quotation_model_name, $quotation_description, $email, $customer_name, $quotation_type, $finance_data);

		$data['select_data'] = $select_data = $this->Add_followup_new_car_model->select_quotation_data($quotation_location, $quotation_model_name, $quotation_description);

		$this->load->view('new_send_quotation_view.php', $data);
		$config = array(
			'mailtype'  => 'html'
		);

		$this->load->library('email', $config);
		$id = $_SESSION['user_id'];
		$query = $this->db->query("select email from lmsuser where id='$id'")->result();
		$user_email_id = $query[0]->email;
		if ($user_email_id == 'admin@autovista.in') {
			$user_email_id = 'jamil@autovista.in';
		}
		$this->email->from('websupport@autovista.in', 'Autovista.in');
		$this->email->to($email);
		$this->email->bcc('jamil@autovista.in');
		if (isset($select_data[0]->model_id)) {
			$this->email->subject('Maruti ' . $select_data[0]->model_name . ' Quotation From Autovista');
			$body = $this->load->view('new_send_quotation_view.php', $data, TRUE);
			$this->email->message($body);
		}
		$this->email->send();
		//  echo $this->email->print_debugger();

		if ($page_path != '') {
			redirect('add_followup_new_car/detail/' . $enq_id . '/' . $page_path);
		} else {
			redirect('notification');
		}
	}
	/********************* New quotation Data ***********************************/
	public function select_quotation_model_name()
	{
		$select_quotation_model_name = $this->Add_followup_new_car_model->select_quotation_model_name();
	?>
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label col-md-12 col-sm-12 col-xs-12">Model: </label>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<select name="qutotation_model" id="qutotation_model" class="form-control" onchange="select_quotation_variant_name()" required>
						<option value="">Please Select </option>
						<?php foreach ($select_quotation_model_name as $row) { ?>
							<option value="<?php echo $row->model_id; ?>"><?php echo $row->model_name; ?></option>
						<?php } ?>

					</select>
				</div>
			</div>
		</div>
	<?php
	}
	public function select_quotation_variant_name()
	{
		$select_quotation_variant_name = $this->Add_followup_new_car_model->select_quotation_variant_name();
	?>
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label col-md-12 col-sm-12 col-xs-12">Variant: </label>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<select name="quotation_variant" id="quotation_variant" class="form-control" required>
						<option value="">Please Select </option>
						<?php foreach ($select_quotation_variant_name as $row) { ?>
							<option value="<?php echo $row->variant_id; ?>"><?php echo $row->variant_name; ?></option>
						<?php } ?>

					</select>
				</div>
			</div>
		</div>
	<?php
	}
	public function select_quotation_onroad_price()
	{
		$select_quotation_onroad_price = $this->Add_followup_new_car_model->select_quotation_onroad_price();
		$select_quotation_offer = $this->Add_followup_new_car_model->select_quotation_offer();
		$customer_type = $this->input->post('customer_type');
		if (isset($select_quotation_onroad_price)) {
			$quotation_id = $select_quotation_onroad_price[0]->quotation_id;
			if ($customer_type == 'individual') {
				$price = $select_quotation_onroad_price[0]->individual_on_road_price;
				$rto = $select_quotation_onroad_price[0]->individual_registration_with_hp;
				$insurance = $select_quotation_onroad_price[0]->zero_dep_insurance_with_rti_and_engine_protect;
				$auto_card = $select_quotation_onroad_price[0]->nexa_card;
				$registration = $select_quotation_onroad_price[0]->registration;
				$ex_showroom = $select_quotation_onroad_price[0]->ex_showroom;

				$name = "Individual";

				$ew = $select_quotation_onroad_price[0]->warranty;
				if (isset($select_quotation_offer[0])) {
					$consumer_offer = $select_quotation_offer[0]->cons_off;
					$quotation_offer_id = $select_quotation_offer[0]->offer_id;
				} else {
					$consumer_offer = "";
					$quotation_offer_id = "";
				}
				$corporate_offer = "";
			} else if ($customer_type == 'corporate') {
				$price = $select_quotation_onroad_price[0]->company_on_road_price;
				$rto = $select_quotation_onroad_price[0]->company_registration_with_hp;
				$insurance = $select_quotation_onroad_price[0]->ins_corp;
				$auto_card = $select_quotation_onroad_price[0]->nexa_card;
				$registration = $select_quotation_onroad_price[0]->registration;
				$ex_showroom = $select_quotation_onroad_price[0]->ex_showroom;
				$ew = $select_quotation_onroad_price[0]->warranty;
				if (isset($select_quotation_offer[0])) {
					$consumer_offer = $select_quotation_offer[0]->cons_off;
					$quotation_offer_id = $select_quotation_offer[0]->offer_id;
				} else {
					$consumer_offer = "";
					$quotation_offer_id = "";
				}
				$corporate_offer = "";
			} else {
				$price = '';
				$ew = '';
				$quotation_offer_id = "";
				$rto = '';
				$insurance = '';
				$auto_card = '';
				$registration = '';
				$ex_showroom = '';
				$corporate_offer = "";
				$consumer_offer = "";
			}
		} else {
			$price = '';
			$ew = '';
			$rto = '';
			$insurance = '';
			$auto_card = '';
			$registration = '';
			$ex_showroom = '';
			$quotation_id = '';
			$corporate_offer = "";
			$consumer_offer = "";
			$quotation_offer_id = "";
		}
	?>
		<input type="hidden" name="quotation_invoice_id" class="form-control" value="<?php echo $quotation_id; ?>">
		<input type="hidden" name="quotation_offer_id" class="form-control" value="<?php echo $quotation_offer_id; ?>">
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label col-md-12 col-sm-12 col-xs-12">Ex Showroom: </label>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<input type="text" name="ex_showroom" class="form-control" value="<?php echo $ex_showroom; ?>" onkeypress="return onlyNumberKey(event)">
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label col-md-12 col-sm-12 col-xs-12">On Road Price: </label>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<input type="text" name="on_road_price_1" class="form-control" value="<?php echo $price; ?>" onkeypress="return onlyNumberKey(event)">
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label col-md-12 col-sm-12 col-xs-12">Extended Warranty </label>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<input type="text" name="ew" class="form-control" value="<?php echo $ew; ?>" onkeypress="return onlyNumberKey(event)">
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label col-md-12 col-sm-12 col-xs-12">RTO Tax & Other Charges </label>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<input type="text" name="rto" class="form-control" value="<?php echo $rto; ?>" onkeypress="return onlyNumberKey(event)">
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label col-md-12 col-sm-12 col-xs-12">Registration </label>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<input type="text" name="registration" class="form-control" value="<?php echo $registration; ?>" onkeypress="return onlyNumberKey(event)">
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label col-md-12 col-sm-12 col-xs-12">Insurance </label>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<input type="text" name="insurance" class="form-control" value="<?php echo $insurance; ?>" onkeypress="return onlyNumberKey(event)">
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label col-md-12 col-sm-12 col-xs-12">Auto Card </label>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<input type="text" name="auto_card" class="form-control" value="<?php echo $auto_card; ?>" onkeypress="return onlyNumberKey(event)">
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label col-md-12 col-sm-12 col-xs-12">Consumer Offer </label>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<input type="text" name="consumer_offer" class="form-control" value="<?php echo $consumer_offer; ?>" onkeypress="return onlyNumberKey(event)">
				</div>
			</div>
		</div>
		<?php if ($customer_type == 'corporate') { ?>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-12 col-sm-12 col-xs-12">Corporate Offer </label>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<input type="text" name="corporate_offer" class="form-control" value="<?php echo $corporate_offer; ?>" onkeypress="return onlyNumberKey(event)">
					</div>
				</div>
			</div>
		<?php } ?>
<?php }


	public function show_quotation()
	{
		$quotation_sent_id = $this->Add_followup_new_car_model->insert_quotation_data();
		redirect("new_quotation_send/pdf_format/" . $quotation_sent_id);
		//$data['quotation_data']=$this->Add_followup_new_car_model->select_quotation_sent_data($quotation_sent_id);
		//$data['quotation_finance_data']=$this->Add_followup_new_car_model->select_finance_quotation($quotation_sent_id);
	}


	
}
?>