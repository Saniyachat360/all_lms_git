<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();
class Add_followup_used_car extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper('form');
		$this -> load -> helper('url');
		$this -> load -> model('Add_followup_used_car_model');
		date_default_timezone_set('Asia/Kolkata');
	}
public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}





//select budget
function select_model_budget()
{
$budget_from=$_POST['budget_from'];
$budget_to=$_POST['budget_to'];
$make=$_POST['make'];
$model=$_POST['model'];
$query=$this->Add_followup_used_car_model->select_model_budget($budget_from,$budget_to,$make,$model);

?>
<style>.button4 {background-color: #e7e7e7; color: black; width: 100%; padding-top: 8px; padding-bottom: 8px; } /* Gray */ </style>

<?php if(count($query)>0){
?>
<br><br><br>
<a class="btn btn-primary" href="<?php echo site_url();?>Poc_stock/budget?from_budget=<?php echo $budget_from;?>&from_budget_to=<?php echo $budget_to;?>&make=<?php echo $make;?>&model=<?php echo $model;?>" target="_blank"><?php echo count($query); ?> Vehicle Found</a>
<?php
}else{
	?>
	<br><br><br>
	<a class="btn btn-default">No Vehicle Found</a>
<?php }
}

	public function detail($id, $path) {
		$this -> session();
		$enq_id = $id;		
		$data['path'] = $path;
		$query = $this -> Add_followup_used_car_model -> select_lead($enq_id);
		//print_r($query);
		$data['lead_detail'] = $query;
		$data['select_group'] = $this -> Add_followup_used_car_model -> select_group();
		$query1 = $this -> Add_followup_used_car_model -> select_location();
		$data['get_location1'] = $query1;
		$data['make_models'] = $this -> Add_followup_used_car_model -> make_models();
		$data['select_followup_lead'] =$q= $this -> Add_followup_used_car_model -> select_followup_lead($enq_id);
		$data['feedback_status'] = $this -> Add_followup_used_car_model -> select_feedback_status();
		$data['next_action_status'] = $this -> Add_followup_used_car_model -> next_action_status();
		//$data['select_city'] = $this -> Add_followup_used_car_model -> select_city();
		$data['model_variant'] = $this -> Add_followup_used_car_model ->select_variant_main();
		$data['make_model'] = $this -> Add_followup_used_car_model ->select_model_main();
		$data['process'] = $this -> Add_followup_used_car_model -> process();
		$data['makes'] = $this -> Add_followup_used_car_model -> makes();
		$data['corporate']=$this-> Add_followup_used_car_model -> corporate();
		$data['evalution_location'] = $this -> Add_followup_used_car_model -> select_evaluation_location();
		$data['duplicate_record']= $this -> Add_followup_used_car_model -> get_duplicate_record($enq_id);
		$data['var'] = site_url('add_followup_used_car/insert_followup');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('add_followup_used_car_view1.php', $data);
		$this -> load -> view('include/footer.php');
	}
	function select_buy_model()
	{
	$make=$_POST['make'];
	$query=$this->Add_followup_used_car_model->select_model($make);
		 ?>
		 <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Car Model:</label>
         <div class="col-md-12 col-sm-12 col-xs-12">
             <select name="buy_model" id="buy_model" onchange="select_budget();" class="form-control" required >
                    <option value="">Please Select  </option>
					<?php foreach($query as $row){?>							
					<option value="<?php echo $row -> model_id; ?>"><?php echo $row -> model_name; ?></option>
                    <?php } ?>
             </select>
        </div>
 <?php
}
function select_model()
{
$make=$_POST['make'];
$query=$this->Add_followup_used_car_model->select_model($make);		 ?>
		 <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name"> Car Model:</label>
         <div class="col-md-12 col-sm-12 col-xs-12">
             <select name="old_model" id="model" class="form-control" required >
                    <option value="">Please Select </option>
					<?php	
					foreach($query as $row){?>							
					<option value="<?php echo $row -> model_id; ?>"><?php echo $row -> model_name; ?></option>
                    <?php } ?>
             </select>
        </div>
 <?php
}






function select_variant()
{
$model=$_POST['model'];
$query=$this->Add_followup_used_car_model->select_variant($model);?>
<label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">New Car Variant:</label>
<div class="col-md-12 col-sm-12 col-xs-12">
	<select name="new_variant" id="new_variant" class="form-control"  >
		<option value="">Please Select  </option>
		<?php	foreach($query as $row){?>
		<option value="<?php echo $row -> variant_id; ?>"><?php echo $row -> variant_name; ?></option>
        <?php } ?>
   </select>
</div>
<?php }
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
			
			
		$get_location1=$this->Add_followup_used_car_model->select_transfer_location($tprocess); ?>
		
		<div class="form-group">
    	                 <label class="control-label col-md-12 col-sm-12 col-xs-12" >Transfer Location:</label>
                              <div class="col-md-12 col-sm-12 col-xs-12">
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
    	                 <label class="control-label col-md-12 col-sm-12 col-xs-12" >Transfer Location:</label>
                              <div class="col-md-12 col-sm-12 col-xs-12">
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
		$select_assign=$this->Add_followup_used_car_model->lmsuser($location,$tprocess);?>
	<!--	<div  class="form-group">
			 <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Transfer To:</label>
                   <div class="col-md-8 col-sm-8 col-xs-12">-->
                        <select name="transfer_assign" id="tassignto1" class="form-control" required >
                              <option value="">Please Select </option> 
                              <?php foreach($select_assign as $row){?>
									<option value="<?php echo $row -> id; ?>"><?php echo $row -> fname . ' ' . $row -> lname; ?> </option> 
							<?php } ?>
                        </select>
				<!--	</div>
				</div>-->
<?php
}
public function select_model_name(){
$city=$this->input->post('city');
$select_model_name=$this->Add_followup_used_car_model->select_model_name($city);?>
	     <select name="model_name" id="model_name" class="form-control" onchange="select_description();" required>
                 <option value="">Please Select  </option>
													
                     			 <?php foreach ($select_model_name as $row) {
                          
                      ?>
                      <option value="<?php echo $row -> model; ?>"><?php echo $row -> model; ?></option>
                      
                      
					  <?php } ?>
                   
               </select>
		
		
	
		
		
<?php
}
public function select_description(){
$model_name=$this->input->post('model_name');
$city=$this->input->post('city');
//echo $model_name;
//echo $city;
$select_description=$this->Add_followup_used_car_model->select_description($model_name,$city);
//	print_r($select_description);	?>
	 <select name="description" id="description" class="form-control" >
          <option value="">Please Select</option> 
			<?php foreach ($select_description as $row) {?>
                  <option value="<?php echo $row -> variant; ?>"><?php echo $row->variant?></option>
					  <?php } ?>
             </select>
		
<?php
}
function insert_followup() {
$query=$this -> Add_followup_used_car_model -> insert_followup();
/*if (!$query) {
$this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Remark Added Successfully...!</strong>');
} else {
$this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Remark Not added ...!</strong>');
}*/
//Send quotation
$email = $this -> input -> post('email');
/*$quotation_location = $this -> input -> post('qlocation');
$quotation_model_name = $this -> input -> post('model_name');
$quotation_description = $this -> input -> post('description');
$phone = $this -> input -> post('phone');
if($quotation_location!='' && $quotation_model_name!='')
{
$this->send_mail($email,$quotation_location, $quotation_model_name, $quotation_description,$phone);
}*/

$nextaction = $this -> input -> post('nextaction');
$feedback = $this -> input -> post('feedback');
$this->db->select('sms');
$this->db->from('tbl_sms');
$this->db->where('nextActionName',$nextaction);
$this->db->where('feedBackStatus',$feedback);
$this->db->where('process_id',$_SESSION['process_id']);
$sms=$this->db->get()->result();
$sms_count=count($sms);

if($sms_count > 0)
{
foreach($sms as $row)
{
$sms1=$row->sms;
echo $sms1;
$phone = $this -> input -> post('phone');
//$this->send_sms($phone,$sms1);
}
//$this->send_sms($disposition,$phone,$sms1);
}
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
redirect('new_lead');
}else if($page_location == 'Transferred '){
//redirect transfer details
redirect('transfer_lead');
}
else if($page_location == 'transfer_report'){
//redirect transfer details
redirect('transfer_report');
}
else if($page_location=='tracker_lead')
{
redirect('tracker/leads');
}
else if($page_location=='call_date_tracker')
{
redirect('tracker/team_leader_leads');
}
else{
//redirect data leads details
redirect('website_leads/telecaller_leads/'.$page_location);
}
}
public function send_sms($phone,$sms1)
{
$request = ""; //initialize the request variable
			$param["user"] = "autovista"; //this is the username of our TM4B account
			$param["password"] = "Autoapi@123"; //this is the password of our TM4B account			
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
}
function insertFollowupThroughAjax() {
$query=$this -> Add_followup_used_car_model -> insert_followup();
if (!$query) {
$this -> session -> set_flashdata('message_ajax', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Remark Added Successfully...!</strong>');
} else {
$this -> session -> set_flashdata('message_ajax', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Remark Not added ...!</strong>');
}
$e=$_POST['loc'];
$enq=str_replace('%20',' ',$e);
$data['enq']=$enq;
if($this->input->post('loc')=='Pending Followup')
{
//get pending attened leads details
$data['select_lead'] = $this -> pending_model -> select_lead();
}
else if($this->input->post('loc')=='Pending New')
{
//get pending Not attened leads details
$data['select_lead'] = $this -> pending_model -> select_lead1();
}
else if($this->input->post('loc')=='Today Followup')
{
//get pending Not attened leads details
$data['select_lead'] = $this -> today_followup_model -> select_lead();
}
else if($this->input->post('loc')=='New')
{
//get New leads details
$data['select_lead']=$this->new_lead_model->select_lead();
}
else if($this->input->post('loc')=='Transferred')
{
///get transfer leads details
$data['select_lead'] = $this -> transfer_lead_model -> select_lead();
}
else
{
//get All data leads details
$data['select_lead']=$this->website_lead_model->select_lead($enq);
}
$data['select_status']=$this->website_lead_model->select_status();
//print_r($data['select_status']);
$data['select_campaign']=$this->website_lead_model->select_campaign();
$data['select_model']=$this->website_lead_model->select_model();
$data['select_make']=$this->website_lead_model->select_make();
$data['select_variant']=$this->website_lead_model->select_variant_new();
$data['get_location1']=$this->website_lead_model->select_location();
$data['select_group']=$this->website_lead_model->select_group();
$this -> load -> view('telecaller_followup_view.php', $data);
}
function insertremark() {
$query=$this -> Add_followup_used_car_model -> insert_remark();
if (!$query) {
$this -> session -> set_flashdata('message_ajax', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Remark Added Successfully...!</strong>');
} else {
$this -> session -> set_flashdata('message_ajax', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Remark Not added ...!</strong>');
}
$e=$_POST['loc'];
$enq=str_replace('%20',' ',$e);
$data['enq']=$enq;
if($this->input->post('loc')=='Pending Live')
{
//get pending attened leads details
$data['select_lead'] = $this -> pending_model -> select_lead();
}
else if($this->input->post('loc')=='Pending New')
{
//get pending Not attened leads details
$data['select_lead'] = $this -> pending_model -> select_lead1();
}
else if($this->input->post('loc')=='Today Followup')
{
//get pending Not attened leads details
$data['select_lead'] = $this -> today_followup_model -> select_lead();
}
else if($this->input->post('loc')=='New')
{
//get New leads details
$data['select_lead']=$this->new_lead_model->select_lead();
}
else if($this->input->post('loc')=='Transferred')
{
///get transfer leads details
$data['select_lead'] = $this -> transfer_lead_model -> select_lead();
}
else
{
//get All data leads details
$data['select_lead']=$this->website_lead_model->select_lead($enq);
}
$this -> load -> view('telecaller_followup_view.php', $data);
}
public function send_mail($email_id,$quotation_location, $quotation_model_name, $quotation_description,$phone)
{
$this->load->helper('path');
$select_data=$this -> Add_followup_used_car_model -> select_quotation($quotation_location, $quotation_model_name, $quotation_description);
$data['select_data']=$select_data;
//$data['select_offer']=$this->Add_followup_used_car_model->select_offer($quotation_location,$quotation_model_name);
$data['select_dse_data']=$this->Add_followup_used_car_model->select_dse_data();
$data['select_contact_details']=$this->Add_followup_used_car_model->select_contact_details();
$data['select_coloumns']=$this->Add_followup_used_car_model->select_quotation1($quotation_location, $quotation_model_name, $quotation_description);
$this->load->view('send_csv_view.php',$data);
//	$this->load->view('send_quotation_view.php',$data);
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
$this->email->to($email_id);
//$this->email->cc($user_email_id);
//$this->email->bcc('snehal@autovista.in,cc1.pune@autovista.in');
$this->email->subject('Maruti '.$quotation_model_name.' Quotation From Autovista');
$body = $this->load->view('send_quotation_view.php',$data,TRUE);
$this->email->message($body);
$this->email->attach('https://autovista.in/call-center/car_quotation.csv');
$this->email->send();
$csv_handler = fopen ('car_quotation.csv','w');
file_put_contents("car_quotation.csv", "");
fclose ($csv_handler);
// Authorisation details.
/*$username = "satyam@autovista.in";
$hash = "58b0ce15875a87f64b38c56b54dd9277a6c4d7e4";
// Config variables. Consult http://api.textlocal.in/docs for more info.
$test = "0";
// Data for text message. This is the text message data.
$sender = "AVTECH"; // This is who the message appears to be from.
$numbers = $phone; // A single number or a comma-seperated list of numbers
$message = "Thank You For Showing Interest in Autovista .";
// 612 chars or less
// A single number or a comma-seperated list of numbers
$message = urlencode($message);
$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
$ch = curl_init('http://api.textlocal.in/send/?');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch); // This is the result from the API
curl_close($ch);*/
}
public function insert_buy_car_data()
{
$this->Add_followup_used_car_model->insert_additional_info();
$enq_id=$this->input->post('enq_id');
$select_data = $this -> Add_followup_used_car_model -> select_additional_info($enq_id);	?>
	 <div class="panel panel-primary">
 							<div class="panel-body">
 								<?php
	foreach($select_data as $fetch){?>
		
<div class='col-md-6'>
	<div class="form-group">
	 	<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Make Name:</label>
	 	<div class="col-md-8 col-sm-8 col-xs-12">
	 		<?php echo $fetch -> make_name; ?>
	 	</div>
</div>
</div>
<div class='col-md-6'>
	<div class="form-group">
	<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Model Name:</label>
		<div class="col-md-8 col-sm-8 col-xs-12">
	 		<?php echo $fetch -> model_name; ?>
	 	</div>
	 </div>
</div>
<?php
	}	?>
</div>
</div>
<?php
}
public function insert_additional_info()
{
$enq_id=$this->input->post('enq_id');
$query = $this -> Add_followup_used_car_model -> select_lead($enq_id);
$lead_detail = $query;
$makes= $this -> Add_followup_used_car_model -> makes();
$this->Add_followup_used_car_model->insert_additional_info();
$select_data = $this -> Add_followup_used_car_model -> select_additional_info($enq_id);	?>
	<h3 class="text-center">Old Car Details</h3>
     			 <div class="panel-body">
                  <div class="col-md-12">
	                	<div class="col-md-6">   
                        	<div class="form-group">
                             <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Car Make: </label>
                             	<div class="col-md-8 col-sm-8 col-xs-12">
                                	<select name="old_make" id="make" class="form-control" required  onchange="select_model();">
                                    
										<option value="">Please Select  </option>
										<?php  foreach($makes as $row){ ?>
										<option value="<?php echo $row -> make_id; ?>"><?php echo $row -> make_name; ?></option>
                     					<?php } ?>
                  						</select>
                                 </div>
                             </div>
                            
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Colour:</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                   <input type="text"  placeholder="Enter Colour" id="color" name='color' onkeypress="return alpha(event)" autocomplete="off"  class=" form-control" required />
                                </div>
                            </div>
                              <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Ownership: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                           <select name="ownership" id="ownership" class="form-control"  >
                            
							<option value="">Please Select  </option>
						
                     		<option value="First">First</option>
                       		<option value="Second">Second</option>
                       		<option value="Third">Third</option>
                        	<option value="More Than Three">More Than Three</option>
                       	</select>
                     	</div>
                     </div>
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Any Assidental Claim: </label>
                         <div class="col-md-8 col-sm-8 col-xs-12">
                            <select name="claim" id="claim" class="form-control"  >
                         
							 <option value="">Please Select  </option>
								
							 <option value="Yes">Yes</option>
                     		<option value="No">No</option>
                     	 	</select>
                          </div>
                        </div>
					</div>
                    <div class="col-md-6">
                     <div class="form-group"  id="model_div">
                               <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Car Model:</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <select name="old_model" id="model" class="form-control" required >
                                    
									<option value="">Please Select  </option>
								
								<?php  foreach($make_model as $row){ ?>
										<option value="<?php echo $row -> model_id; ?>"><?php echo $row -> model_name; ?></option>
                     					<?php } ?>
                      			 </select>
                               </div>
                          	</div>
                     <div class="form-group">
                      <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Manufacturing Year: </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <select name="mfg" id="mfg" class="form-control"  >
                            
							<option value="">Please Select  </option>
								<?php 
									$year=date('Y');
									for ($i=$year;$i>1980;$i--){ ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?> </option>
								<?php } ?>
							</select>
                           </div>
                        </div>
                        <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">KMS: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                              <input type="text"  placeholder="Enter Km" id="km" name='km' onkeypress="return isNumberKey(event)" onkeyup="return limitlength(this, 10)" autocomplete="off" class="form-control"   />
                           </div>
                        </div>
                       
                        <div class="form-group" id='additional_btn'>
                        	<div class="col-md-4 pull-right">
                          <a onclick="insert_additional_info()" class=" col-md-12 col-xs-12 col-sm-12"><u>Add Next Car</u></a>
                         </div>
                         
                        </div>
                      </div>
                   </div>
                   	 	<div class="col-md-12">
                <div class="panel panel-primary">
                	<div class="panel-body">
 							
 								<?php
	foreach($select_data as $fetch){?>
		
<div class='col-md-6'>
	<div class="form-group">
	 	<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Make Name:</label>
	 	<div class="col-md-8 col-sm-8 col-xs-12">
	 		<?php echo $fetch -> make_name; ?>
	 	</div>
</div>
</div>
<div class='col-md-6'>
	<div class="form-group">
	<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Model Name:</label>
		<div class="col-md-8 col-sm-8 col-xs-12">
	 		<?php echo $fetch -> model_name; ?>
	 	</div>
	 </div>
</div>

<?php
	}	?>
 </div>
</div>

                </div>
                </div>
                <?php
				}
				public function select_next_action()
				{
				$next_action_status=$this->Add_followup_used_car_model->select_next_action();	   ?>
	     <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Next Action:
                                            </label>
                                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                                <select name="nextaction" id="nextaction" class="form-control"  onchange='check_disp_name(this.value);' required >
                                            	<option value="">Please Select </option> 
                                            	<?php foreach ($next_action_status as $row13) { ?>
												<option value="<?php echo $row13 -> nextActionName; ?>"><?php echo $row13 -> nextActionName; ?></option>
												<?php } ?>
                                            </select>
                                            </div>
                                            <?php
											}
											}										?>
