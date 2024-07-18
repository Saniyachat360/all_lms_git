<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_followup_evaluation_tracking extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper('form');
		$this -> load -> helper('url');
		$this -> load -> model('Add_followup_evaluation_tracking_model');
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
		$data['lead_detail']= $query = $this -> Add_followup_evaluation_tracking_model -> select_lead($enq_id);
	
		//Show all Previous Followup
		$data['select_followup_lead'] =$q= $this -> Add_followup_evaluation_tracking_model -> select_followup_lead($enq_id);
	
		//Get select box values
		$data['feedback_status'] = $this -> Add_followup_evaluation_tracking_model -> select_feedback_status();
		$data['next_action_status'] = $this -> Add_followup_evaluation_tracking_model -> next_action_status();
		$data['makes'] = $this -> Add_followup_evaluation_tracking_model -> makes();
		$data['var'] = site_url('add_followup_evaluation_tracking/insert_followup');
		
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('add_followup_evaluation_tracking_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
	public function detail1($id, $path) {
		$this -> session();
		$enq_id = $id;
		$data['path'] = $path;
		
		//Get Previous Followup Details
		$data['lead_detail']= $query = $this -> Add_followup_evaluation_tracking_model -> select_lead($enq_id);
	
		//Show all Previous Followup
		$data['select_followup_lead'] =$q= $this -> Add_followup_evaluation_tracking_model -> select_followup_lead($enq_id);
	
		//Get select box values
		$data['feedback_status'] = $this -> Add_followup_evaluation_tracking_model -> select_feedback_status();
		$data['next_action_status'] = $this -> Add_followup_evaluation_tracking_model -> next_action_status();
		$data['makes'] = $this -> Add_followup_evaluation_tracking_model -> makes();
		$data['var'] = site_url('add_followup_evaluation_tracking/insert_followup');
		
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('add_followup_evaluation_tracking_view1.php', $data);
		$this -> load -> view('include/footer.php');
	}
function select_model()
{
$make=$_POST['make'];
$query=$this->Add_followup_evaluation_tracking_model->select_model($make);		 ?>
		 <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name"> Car Model:</label>
         <div class="col-md-12 col-sm-12 col-xs-12">
             <select name="old_model" id="model" class="form-control" required  onchange="select_variant();" >
                    <option value="">Please Select  </option>
					<?php	foreach($query as $row){?>							
					<option value="<?php echo $row -> model_id; ?>"><?php echo $row -> model_name; ?></option>
                    <?php } ?>
             </select>
        </div>
 <?php
}
function select_variant()
{
$model=$_POST['model'];
$query=$this->Add_followup_evaluation_tracking_model->select_variant($model);		 ?>
		 <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name"> Car Vaiant:</label>
         <div class="col-md-12 col-sm-12 col-xs-12">
             <select name="old_variant" id="variant" class="form-control" required  >
                    <option value="">Please Select  </option>
					<?php	foreach($query as $row){?>							
					<option value="<?php echo $row -> variant_id; ?>"><?php echo $row -> variant_name; ?></option>
                    <?php } ?>
             </select>
        </div>
 <?php
}
	/**** Next Action using feedback *****/
	//Filter for select next action from feedback_status
	public function select_next_action()
{
	$next_action_status=$this->Add_followup_evaluation_tracking_model->select_next_action();
	   ?>
	     <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Next Action:
                                            </label>
                                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                                <select name="nextaction" id="nextaction" class="form-control"  onchange='check_nfd(this.value);' required >
                                            	<option value="">Please Select </option> 
                                            	<?php foreach ($next_action_status as $row13) { ?>
												<option value="<?php echo $row13 -> nextActionName; ?>"><?php echo $row13 -> nextActionName; ?></option>
												<?php } ?>
                                            </select>
                                            </div>
                                            <?php
	
}
	
public function insert_escalation_detail(){
	$id=$this->input->post('booking_id');
	$path=$this->input->post('path');
	$this -> Add_followup_evaluation_tracking_model -> insert_escalation_detail();
	
		redirect('add_followup_evaluation_tracking/detail/'.$id.'/'.$path);
	
	
	
	
}
public function insert_escalation_resolve_detail(){
	$id=$this->input->post('booking_id');
	$path=$this->input->post('path');
	$this -> Add_followup_evaluation_tracking_model -> insert_escalation_resolve_detail();
	
		redirect('add_followup_evaluation_tracking/detail/'.$id.'/'.$path);
	
	
	
	
}

// Insert New Car Followup Details
function insert_followup() {

	$query=$this -> Add_followup_evaluation_tracking_model -> insert_followup();


	$a = $_POST['loc'];
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
	else{
		//redirect data leads details
	redirect('website_leads/telecaller_leads/'.$page_location);
	}

	
	}

	
//Send Quotation mail to used 
  public function send_mail($email,$customer_name,$quotation_location, $quotation_model_name, $quotation_description,$accessories_package_name,$phone,$new_model,$brochure)
  {
  	$this->load->helper('path');
 	$select_data=$data['select_data']=$this -> Add_followup_evaluation_tracking_model -> select_quotation_data($quotation_location, $quotation_model_name, $quotation_description,$accessories_package_name);
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
	$this->email->from('support@autovista.in', 'Autovista.in');
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
		$select_brochure=$this->Add_followup_evaluation_tracking_model->select_brochure($new_model);
		if($quotation_model_name == ''){
			$this->email->subject('Maruti '.$select_brochure[0]->model_name.' Brochure From Autovista');
			$this->email->message('Maruti '.$select_brochure[0]->model_name.' Brochure');  
		}
		 $this->email->attach('https://autovista.in/assets/Brochure/'.$select_brochure[0]->brochure);
		
	}
	
	$this->email->send();
	//$csv_handler = fopen ('car_quotation.csv','w');
	//file_put_contents("car_quotation.csv", "");
   //fclose ($csv_handler);
  // echo $this->email->print_debugger();
   
   }	
   



}
?>
