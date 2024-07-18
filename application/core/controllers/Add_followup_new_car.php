<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_followup_new_car extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper('form');
		$this -> load -> helper('url');
		$this -> load -> model('Add_followup_new_car_model');
		date_default_timezone_set('Asia/Kolkata');
		

	}
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	public function detail($id, $path) {
		$this -> session();
		$enq_id = $id;
		$data['path'] = $path;
		//Get Previous Followup Details
		$data['lead_detail']= $query = $this -> Add_followup_new_car_model -> select_lead($enq_id);
		//print_r($data['lead_detail']);
		
		//Get select box values
		$data['make_models'] = $this -> Add_followup_new_car_model -> make_models();
		$data['model_variant'] = $this -> Add_followup_new_car_model ->select_variant_main();
		$data['feedback_status'] = $this -> Add_followup_new_car_model -> select_feedback_status();
		$data['next_action_status'] = $this -> Add_followup_new_car_model -> next_action_status();
		$data['process'] = $this -> Add_followup_new_car_model -> process();
		$data['corporate'] = $this -> Add_followup_new_car_model -> corporate();
		$data['get_location1'] = $query1 = $this -> Add_followup_new_car_model -> select_location();
		$data['evalution_location'] = $this -> Add_followup_new_car_model -> select_evaluation_location();
		$data['select_city'] = $this -> Add_followup_new_car_model -> select_city();
		$data['select_followup_lead'] =$q= $this -> Add_followup_new_car_model -> select_followup_lead($enq_id);
		$data['makes'] = $this -> Add_followup_new_car_model -> makes();
		
		$data['var'] = site_url('add_followup_new_car/insert_followup');
		
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('Add_followup_new_car_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
function select_model()
{
$make=$_POST['make'];
$query=$this->Add_followup_new_car_model->select_model($make);		 ?>
		 <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Car Model:</label>
         <div class="col-md-8 col-sm-8 col-xs-12">
             <select name="old_model" id="model" class="form-control" required >
                    <option value="">Please Select  </option>
					<?php	foreach($query as $row){?>							
					<option value="<?php echo $row -> model_id; ?>"><?php echo $row -> model_name; ?></option>
                    <?php } ?>
             </select>
        </div>
 <?php
}
	/**** Next Action using feedback *****/
	//Filter for select next action from feedback_status
	public function select_next_action()
{
	$next_action_status=$this->Add_followup_new_car_model->select_next_action();
	   ?>
	     <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Action:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <select name="nextaction" id="nextaction" class="form-control"  onchange='check_disp_name(this.value);' required >
                                            	<option value="">Please Select </option> 
                                            	<?php foreach ($next_action_status as $row13) { ?>
												<option value="<?php echo $row13 -> nextActionName; ?>"><?php echo $row13 -> nextActionName; ?></option>
												<?php } ?>
                                            </select>
                                            </div>
                                            <?php
	
}
	/****Buy Car Details Div *****/
// Filter for select variant using model name
function select_variant()
{
	$model=$_POST['model'];
	$query=$this->Add_followup_new_car_model->select_variant($model);
?>
<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">New Car Variant:</label>
<div class="col-md-8 col-sm-8 col-xs-12">
	<select name="new_variant" id="new_variant" class="form-control"  >
		<option value="">Please Select  </option>
		<?php	foreach($query as $row){?>
		<option value="<?php echo $row -> variant_id; ?>"><?php echo $row -> variant_name; ?></option>
        <?php } ?>
   </select>
</div>
<?php }
	/**** Transfer Div Details *****/
// Transfer Location
function select_transfer_location()
{
	$tprocess=$this->input->post('tprocess');
	$user_id=$this -> session -> userdata('user_id');
	 $check_user_process12 = $this->db->query("select p.process_id
									from lmsuser l 
									Left join tbl_manager_process mp on mp.user_id=l.id 
									Left join tbl_process p on p.process_id=mp.process_id
									where mp.user_id='$user_id' and mp.process_id ='$tprocess' ");
									
	
	$check_user_process1=$check_user_process12->result();

		if(($check_user_process12->num_rows())> 0){
			
			
		$get_location1=$this->Add_followup_new_car_model->select_transfer_location($tprocess); ?>
		
		<div class="form-group">
    	                 <label class="control-label col-md-4 col-sm-4 col-xs-12" >Transfer Location:</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                	<select name="tlocation" id="tlocation1" class="form-control"    onchange="select_assign_to()">
                                        <option value="">Please Select </option>  
									<?php foreach($get_location1 as $fetch1){ ?>
												<option value="<?php echo $fetch1 -> location; ?>"><?php echo $fetch1 -> location; ?></option>
                     							 <?php } ?>
                       					</select>
                                   </div>
                             </div>
                             <?php
		}else{?>
			<div class="form-group" style="display: none">
    	                 <label class="control-label col-md-4 col-sm-4 col-xs-12" >Transfer Location:</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                	<select name="tlocation" id="tlocation1" class="form-control"    onchange="select_assign_to()">
                                        <option value="">Please Select </option>  
								
                       					</select>
                                   </div>
                             </div>
			<?php
			
}
}
// Select Transfer user name using Transfer Location
public function select_assign_to(){
		$location=$this->input->post('tlocation1');
		$tprocess=$this->input->post('tprocess');
		$select_assign=$this->Add_followup_new_car_model->lmsuser($location,$tprocess);?>
	<!--	<div  class="form-group">
			 <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Transfer To:</label>
                   <div class="col-md-8 col-sm-8 col-xs-12">-->
                        <select name="transfer_assign" id="tassignto1" class="form-control"  >
                              <option value="">Please Select </option> 
                              <?php foreach($select_assign as $row){?>
									<option value="<?php echo $row -> id; ?>"><?php echo $row -> fname . ' ' . $row -> lname; ?> </option> 
							<?php } ?>
                        </select>
				<!--	</div>
				</div>-->
<?php
}
// Select Transfer user name using Transfer Location
public function select_assign_to_evaluation(){
		$location=$this->input->post('tlocation1');
		$tprocess=$this->input->post('tprocess');
		$select_assign=$this->Add_followup_new_car_model->lmsuser($location,$tprocess);
		//print_r($select_assign); ?>
	<!--	<div  class="form-group">
			 <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Transfer To:</label>
                   <div class="col-md-8 col-sm-8 col-xs-12">-->
                        <select name="evaluation_assign_to" id="evaluation_assign_to" class="form-control"  >
                              <option value="">Please Select </option> 
                              <?php foreach($select_assign as $row){?>
									<option value="<?php echo $row -> id; ?>"><?php echo $row -> fname . ' ' . $row -> lname; ?> </option> 
							<?php } ?>
                        </select>
				<!--	</div>
				</div>-->
<?php
}
	/**** Send Quotation Div *****/
//Select Model Name using Send Quotation location 
public function select_model_name(){
		$city=$this->input->post('city');
		$select_model_name=$this->Add_followup_new_car_model->select_model_name($city);
	?>
	 <select name="model_id" id="model_name" class="form-control" onchange="select_description();" required>
      <option value="">Please Select  </option>
		<?php foreach ($select_model_name as $row) { ?>
        <option value="<?php echo $row->model_id;?>"><?php echo $row->model;?></option>
        <?php } ?>
        </select>
	<?php
}
//Select Description Using Model name in send quotation
public function select_description(){
		
		$model_name=$this->input->post('model_name');
		$city=$this->input->post('city');
		
		//echo $model_name;
		//echo $city;
	
	$select_description=$this->Add_followup_new_car_model->select_description($model_name,$city);
	$check_accessories=$this->Add_followup_new_car_model->check_accessories($model_name);
	
//	print_r($select_description);
	?>
	   <div class="col-md-6">
                       <div  class="form-group">
                           <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Description:</label>
						   <div class="col-md-8 col-sm-8 col-xs-12" id="">
	 <select name="description" id="description"  class="form-control" >
          <option value="">Please Select</option> 
			<?php foreach ($select_description as $row) {?>
                  <option value="<?php echo $row->variant;?>"><?php echo $row->variant?></option>
					  <?php } ?>
             </select> 
			 </div>
		</div>
		</div>
	<div class="col-md-6">
    		 			<div class="form-group">
	  <label class="control-label col-md-4 col-sm-4 col-xs-12" > Accessories Package: </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
	 <select name="accessories_package_name" id="package"  class="form-control" >
          <option value="">Please Select</option> 
			<?php foreach ($check_accessories as $row) {?>
                  <option value="<?php echo $row->accessories_package_id;?>"><?php echo $row->package_name?></option>
					  <?php } ?>
             </select>
		</div>
		</div>
		</div>
<?php
}
public function check_accessories(){
		
		$model_name=$this->input->post('model_name');
		
		
		//echo $model_name;
		//echo $city;
	
	$check_accessories=$this->Add_followup_new_car_model->check_accessories($model_name);
	
//	print_r($select_description);
	?>
	<div class="col-md-6">
    		 			<div class="form-group">
	  <label class="control-label col-md-4 col-sm-4 col-xs-12" > Accessories Package: </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
	 <select name="package" id="package"  class="form-control" >
          <option value="">Please Select</option> 
			<?php foreach ($check_accessories as $row) {?>
                  <option value="<?php echo $row->accessories_package_id;?>"><?php echo $row->package_name?></option>
					  <?php } ?>
             </select>
		</div>
		</div>
		</div>
<?php
}

// Insert New Car Followup Details
function insert_followup() {
	//$query1=$this -> Add_followup_new_car_model -> send_sms();
	$query=$this -> Add_followup_new_car_model -> insert_followup();
	
	if (!$query) {
			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Followup Added Successfully...!</strong>');
			} else {
			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Followup Not added ...!</strong>');
			}
	
	//Send quotation 
	$customer_name = $this -> input -> post('customer_name');
	$email = $this -> input -> post('email');
	$quotation_location = $this -> input -> post('qlocation');
	$quotation_model_name = $this -> input -> post('model_id');
	$quotation_description = $this -> input -> post('description');
	$accessories_package_name = $this -> input -> post('accessories_package_name');
	$phone = $this -> input -> post('phone');
	$new_model=$this->input->post('new_model');
	$brochure=$this->input->post('brochure');
	if (isset($brochure)) {
    $brochure='Checked';
}else{
	 $brochure='Not Checked';
}
	if($quotation_model_name!='' ||  $brochure == 'Checked')
	{
		$this->send_mail($email,$customer_name,$quotation_location, $quotation_model_name, $quotation_description,$accessories_package_name,$phone,$new_model,$brochure);
	}
	$a = $_POST['loc'];
	$page_location=str_replace('%20',' ',$a);
	/*if ($page_location == 'Pending Followup') {
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
	else if($page_location == 'Home Visit Today'){
	//redirect new assign lead details
	redirect('home_visit/leads');
	}
else if($page_location == 'Showroom Visit Today'){
	//redirect new assign lead details
	redirect('showroom_visit/leads');
	}else if($page_location == 'Test Drive Today'){
	//redirect new assign lead details
	redirect('test_drive/leads');
	}
	else if($page_location == 'Evaluation Today'){
	//redirect new assign lead details
	redirect('evaluation/leads');
	}
	else{
		//redirect data leads details
	redirect('website_leads/telecaller_leads/'.$page_location);
	}
*/
	
	}

	
//Send Quotation mail to used 
  public function send_mail($email,$customer_name,$quotation_location, $quotation_model_name, $quotation_description,$accessories_package_name,$phone,$new_model,$brochure)
  {
  	$this->load->helper('path');
 	$select_data=$data['select_data']=$this -> Add_followup_new_car_model -> select_quotation_data($quotation_location, $quotation_model_name, $quotation_description,$accessories_package_name);
 	$data['customer_name']=$customer_name;
	$data['quotation_location']=$quotation_location;	
	$data['model_id']=$quotation_model_name;	
	$data['accessories_package_name']=$accessories_package_name;
	//$this->load->view('new_send_quotation_view.php',$data);
	
 	$config = Array(       
          'mailtype'  => 'html'
         );
   	$this->load->library('email', $config);
 	$id=$_SESSION['user_id'];
 	$query=$this->db->query("select email from lmsuser where id='$id'")->result();
 	$user_email_id=$query[0]->email;
	if($user_email_id=='admin@autovista.in')
	{
		$user_email_id='jamil@autovista.in';
	}
	$this->email->from('info@autovista.in', 'Autovista.in');
	$this->email->to($email);
	//$this->email->cc($user_email_id);
	$this->email->bcc('snehal@autovista.in');	
	if(isset($select_data[0]->model)){
	$this->email->subject('Maruti '.$select_data[0]->model.' Quotation From Autovista');
	$body = $this->load->view('new_send_quotation_view.php',$data,TRUE);
	$this->email->message($body);  
	}
	
	//$this->email->attach('https://autovista.in/all_lms/car_quotation.csv');
	if($brochure=='Checked'){
		$select_brochure=$this->Add_followup_new_car_model->select_brochure($new_model);
		if($quotation_model_name == ''){
			$this->email->subject('Maruti '.$select_brochure[0]->model_name.' Brochure From Autovista');
			$msg='Dear '.$customer_name.'<br><br>'.'Maruti '.$select_brochure[0]->model_name.' Brochure';
			$this->email->message($msg);  
		}
		 $this->email->attach('https://autovista.in/assets/Brochure/'.$select_brochure[0]->brochure);
		
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
function send_quot (){
	$data['model_id']='1';
	$data['customer_name']='Test';
	$quotation_model_name=$data['model_name']='Alto K10';
	$quotation_description=$data['variant_id']='407';
	$quotation_location=$data['location']='Pune';
	$select_data=$this -> Add_followup_new_car_model -> select_quotation_data($quotation_location, $quotation_model_name, $quotation_description);
 	$data['select_data']=$select_data;
	
	$this->load->view('new_send_quotation_view.php',$data);
	
	
}
public function insert_escalation_detail(){
	$id=$this->input->post('booking_id');
	$path=$this->input->post('path');
	$escalation_type=$this->input->post('escalation_type');
	$this -> Add_followup_new_car_model -> insert_escalation_detail();
	
	$this->send_escalation_mail($id,$escalation_type);
	if($_SESSION['process_id']=='6')
	{
		redirect('add_followup_new_car/detail/'.$id.'/'.$path);
	}
	elseif ($_SESSION['process_id']=='7') {
		redirect('add_followup_used_car/detail/'.$id.'/'.$path);
	}
	
}
public function insert_escalation_resolve_detail(){
	$id=$this->input->post('booking_id');
	$path=$this->input->post('path');
	$escalation_type=$this->input->post('resolved_escalation_type');
	
	$this -> Add_followup_new_car_model -> insert_escalation_resolve_detail();
	
	//$this->send_escalation_mail($id,$escalation_type);
	if($_SESSION['process_id']=='6')
	{
		redirect('add_followup_new_car/detail/'.$id.'/'.$path);
	}
	elseif ($_SESSION['process_id']=='7') {
		redirect('add_followup_used_car/detail/'.$id.'/'.$path);
	}
	
}

	//Send Quotation mail to used 
  public function send_escalation_mail($enq_id,$escalation_type)
  {
	 
	 $query=$this->Add_followup_new_car_model -> get_escalation_detail($enq_id);
	 $data['query']=$query;
	 echo $csetl_email= $query[0]->csetl_email;
	echo $dsetl_email=$query[0]->dsetl_email;
	echo $gm_email=$query[0]->gm_email;
	echo $sm_email=$query[0]->sm_email;
	
	//"pereira_irwin@autovista.in","shaikh.hafiz@autovista.in",'$csetl_email','$dsetl_email','$gm_email','$sm_email'
  	$this->load->helper('path');
 	$config = Array(       
          'mailtype'  => 'html'
         );
   	$this->load->library('email', $config);
	$this->email->from('info@autovista.in', 'Autovista.in');
	if($escalation_type=='Escalation Level 1')
	{
		//$this->email->to("jamil@autovista.in");
		if($_SESSION['process_id']=='7')
		{
		$this->email->to("pereira_irwin@autovista.in,samarth.sharma@autovista.in,vishal12.autovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
		}
		else 
		{
			$this->email->to("pereira_irwin@autovista.in,shaikh.hafiz@autovista.in,vishal12.autovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
		}
	}
	elseif($escalation_type=='Escalation Level 2')
	{
		//$this->email->to("jamil.shaikh50@gmail.com");
		if($_SESSION['process_id']=='7')
		{
		$this->email->to("pereira_irwin@autovista.in,samarth.sharma@autovista.in,anuj.agarwal@autovista.in,vishal12.autovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
		}else
		{
			$this->email->to("pereira_irwin@autovista.in,shaikh.hafiz@autovista.in,amitesh.agrawal@autovista.in,vishal12.autovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
		}
	}
	elseif($escalation_type=='Escalation Level 3')
	{
		if($_SESSION['process_id']=='7')
		{
		$this->email->to("pereira_irwin@autovista.in,samarth.sharma@autovista.in,anuj.agarwal@autovista.in,vishal12.autovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
		}
		else
		{
			$this->email->to("pereira_irwin@autovista.in,shaikh.hafiz@autovista.in,amitesh.agrawal@autovista.in,vishal12.autovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
		}
	}
	else {
		$this->email->to("jamil@autovista.in");
	}
	
	$this->email->bcc('snehal@autovista.in,jamil@autovista.in');
	$this->email->subject("LMS Escalation (".$escalation_type.")");
	 $data['enq_id']=$enq_id;
	  $data['escalation_type']=$escalation_type;
	$body =$this->load->view('send_evaluation_mail_view.php',$data,true);
	$this->email->message($body);  
	$this->email->send();
   }	
}
?>
