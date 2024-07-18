<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class sign_up extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('sign_up_model');
		$this -> load -> model('cross_lead_dashboard_model');
	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function index() {

		$data['maxEmpId'] = $this -> sign_up_model -> maxEmpId();
		$data['var'] = site_url('sign_up/insert_user');
		//$this -> load -> view('include/admin_header.php');
		$this -> load -> view('cross_lead/sign_up_view1.php', $data);

	}
		public function login_with_otp() {

		$data['maxEmpId'] = $this -> sign_up_model -> maxEmpId();
		$data['var'] = site_url('sign_up/login_with_otp_user');
		//$this -> load -> view('include/admin_header.php');
		$this -> load -> view('cross_lead/login_with_otp.php', $data);

	}
		public function login_with_otp_user() {
	echo	$t=$this -> sign_up_model -> login_with_otp_user();
		if($t!=0)
		{
		    echo "login";
		    redirect('login/login_form1/'.$t);
		}
	}

	public function insert_user() {
		$this -> sign_up_model -> insert_user();
	}

	public function dashboard() {
		$this -> session();
		$data['cross_lead_dashboard'] = $this -> cross_lead_dashboard_model -> cross_lead_dashboard();
		if ($_SESSION['role'] == 17) {
			$this -> load -> view('cross_lead/header.php');
		} else {
			$this -> load -> view('include/admin_header.php');
		}
		$this -> load -> view('cross_lead/dashboard_view.php', $data);
		$this -> load -> view('include/footer.php');
	}

	public function dashboard_show_data($id, $process, $name) {
	$this -> session();		
	$data['process'] = $process = str_replace('%20', ' ', $process);
		$data['id'] = $id;
		$data['name'] = $name;
		$data['select_lead'] = $this -> cross_lead_dashboard_model -> select_lead($id, $process, $name);
		$data['all_count_lead'] = $this -> cross_lead_dashboard_model -> select_lead_count($id, $process, $name);
		if ($_SESSION['role'] == 17) {
			$this -> load -> view('cross_lead/header.php');
		} else {
			$this -> load -> view('include/admin_header.php');
		}
		$this -> load -> view('cross_lead/dashboard_detail_view.php', $data);
		$this -> load -> view('include/footer.php');

	}



	public function add_new_lead() {
		$this -> session();
		$data['select_process'] = $this -> sign_up_model -> select_process();
		$data['var'] = site_url('sign_up/add_user');
		if ($_SESSION['role'] == 17) {			$this -> load -> view('cross_lead/header.php');
		} else {
			$this -> load -> view('include/admin_header.php');
		}
		$this -> load -> view('cross_lead/add_new_customer_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
	public function profile() {
		$this -> session();
		$data['user_detail'] = $this -> sign_up_model -> user_detail();
		$data['var'] = site_url('sign_up/update_profile');
		if ($_SESSION['role'] == 17) {			$this -> load -> view('cross_lead/header.php');
		} else {
			$this -> load -> view('include/admin_header.php');
		}
		$this -> load -> view('cross_lead/profile_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
    	public function update_profile() {
		$this -> session();
		$this -> sign_up_model -> update_profile();
		redirect('sign_up/profile');
	}

	public function add_user() {
		$this -> session();
		$this -> sign_up_model -> add_customer();
		redirect('sign_up/add_new_lead');
	}

	public function all_lead() {
		$this -> session();
		$process_name = 'New car';

		$select_lead1 = $this -> sign_up_model -> select_lead();
		$all_count_lead = $this -> sign_up_model -> select_lead_count();

		$select_lead2 = $this -> sign_up_model -> select_lead_poc_purchase();
		$all_count_lead = $this -> sign_up_model -> select_lead_poc_purchase_count();

		$select_lead3 = $this -> sign_up_model -> select_lead_all();
		$all_count_lead = $this -> sign_up_model -> select_lead_all_count();

		$select_lead = array_merge($select_lead1, $select_lead2, $select_lead3);

		$data['select_lead'] = $select_lead;
		$data['all_count_lead'] = count($select_lead);
		$data['select_process'] = $this -> sign_up_model -> select_process();
		if ($_SESSION['role'] == 17) {
			$this -> load -> view('cross_lead/header.php');
		} else {
			$this -> load -> view('include/admin_header.php');
		}

		$this -> load -> view('cross_lead/all_lead_view.php', $data);
		$this -> load -> view('include/footer.php');
	}

	public function lms_details($id, $process_name) {
		$this -> session();
		$enq_id = $id;
		$process_name = str_replace('%20', ' ', $process_name);
		$data['process_name'] = $process_name;
		$query = $this -> db -> query("select process_id from tbl_process where process_name='$process_name'") -> result();
		$process_id = $data['process_id'] = $query[0] -> process_id;
		$data['details'] = $this -> sign_up_model -> lms_details($enq_id, $process_id);
		$data['followup_detail'] = $this -> sign_up_model -> followup_detail($enq_id, $process_id);
		$data['remark_detail'] = $this -> sign_up_model -> select_manager_remark($enq_id);
		//$data['select_additional_info']=$this->website_lead_model->select_additional_info($enq_id);
		$data['select_accessories_list'] = $this -> sign_up_model -> select_accessories_list($enq_id);
		if ($_SESSION['role'] == 17) {			$this -> load -> view('cross_lead/header.php');
		} else {			$this -> load -> view('include/admin_header.php');
		}
		$this -> load -> view('cross_lead/lms_detail_view.php', $data);
		$this -> load -> view('include/footer.php');
	}

	public function insert_escalation_detail() {
		$this -> sign_up_model -> insert_escalation();
		redirect('sign_up/all_lead');
	}

	public function send_otp() {
		$today=date('Y-m-d');
		$moblie_number = $this -> input -> post('moblie_no');
			$email = $this -> input -> post('email');
		$query = $this -> db -> query("select * from mobile_numbers where mobile_number='$moblie_number' and date='$today'") -> result();
		if(count($query)>3)
		{
			echo "Todays OTP quota is finished.Try again after 24 hours";
		}
		else {			
		
		if (count($query) > 0) {
			$code = $query[0] -> verification_code;
		} else {
			$generator = "1357902468";
			$code = "";
			for ($i = 1; $i <= 4; $i++) {
				$code .= substr($generator, (rand() % (strlen($generator))), 1);
			}
		}
		$data = $this -> db -> query("insert into mobile_numbers (mobile_number,verification_code,date) value('$moblie_number','$code','$today')");
	
	//	$msg = $code . ' is Your SECRET One Time Password (OTP) for LMS Login';
//$msg="Your OTP for Autovista VMS login :-".$code;
$msg="Hello User your OTP is - ".$code;
		//request parameters array
		$sendsms = "";
		//initialize the sendsms variable
		$requestParams = array('user' => 'atvsta', 'password' => 'atvsta', 'senderid' => 'ATVSTA', 'channel' => 'Trans', 'DCS' => '0', 'flashsms' => '0', 'route' => '46', 'number' => $moblie_number, 'text' => $msg);

		//merge API url and parameters
		$apiUrl = "http://smslogin.ismsexpert.com/api/mt/SendSMS?";
		//$apiUrl = "http://domain.ismsexpert.com/api/mt/SendSMS?";
		foreach ($requestParams as $key => $val) {
			$apiUrl .= $key . '=' . urlencode($val) . '&';
		}
		$apiUrl = rtrim($apiUrl, "&");

		//API call
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $apiUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		curl_exec($ch);
		curl_close($ch);
	
		$config = Array('mailtype' => 'html');
		$this -> load -> library('email', $config);
		$this -> email -> from('support@autovista.in', 'Admin');
		$this -> email -> to($email);
		$this -> email -> subject('LMS Login OTP Details');
	//	$body = $this -> load -> view('send_mail_view.php', TRUE);
	$body="Dear User,<br><br> Your OTP for LMS login is ".$code.". <br><br><br><br> Thanks & Regards,<br>Team Autovista";
		$this -> email -> message($body);
		$this -> email -> send();

		$this -> session -> set_userdata('otp_code', $code);
		echo "OTP Send Successfully <input type='tel'   value='" . $_SESSION['otp_code'] . "' id='session_otp1'  style='display: none' >";
		}
	}

	public function resend_otp() {
		$today=date('Y-m-d');
		$moblie_number = $this -> input -> post('moblie_no');
        
			$email = $this -> input -> post('email');
		$query = $this -> db -> query("select * from mobile_numbers where mobile_number='$moblie_number' and date='$today'") -> result();
		if(count($query)>3)
		{
			echo "Todays OTP quota is finished.Try again after 24 hours";
		}
		else {	
		if (count($query) > 0) {
			$code = $query[0] -> verification_code;
		}
		else {
			$generator = "1357902468";
			$code = "";
			for ($i = 1; $i <= 4; $i++) {
				$code .= substr($generator, (rand() % (strlen($generator))), 1);
			}
		}
		$data = $this -> db -> query("insert into mobile_numbers (mobile_number,verification_code,date) value('$moblie_number','$code','$today')");
	
	//	$msg = $code . ' is Your SECRET One Time Password (OTP) for LMS Login';
//	$msg="Your OTP for Autovista VMS login :-".$code;
	$msg="Hello User your OTP is - ".$code;

		//request parameters array
		$sendsms = "";
		//initialize the sendsms variable
		$requestParams = array('user' => 'atvsta', 'password' => 'atvsta', 'senderid' => 'ATVSTA', 'channel' => 'Trans', 'DCS' => '0', 'flashsms' => '0', 'route' => '46', 'number' => $moblie_number, 'text' => $msg);

		//merge API url and parameters
		$apiUrl = "http://smslogin.ismsexpert.com/api/mt/SendSMS?";
		//$apiUrl = "http://domain.ismsexpert.com/api/mt/SendSMS?";
		foreach ($requestParams as $key => $val) {
			$apiUrl .= $key . '=' . urlencode($val) . '&';
		}
		$apiUrl = rtrim($apiUrl, "&");

		//API call
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $apiUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		curl_exec($ch);
		curl_close($ch);
			$config = Array('mailtype' => 'html');
		$this -> load -> library('email', $config);
		$this -> email -> from('support@autovista.in', 'Admin');
		$this -> email -> to($email);
		$this -> email -> subject('LMS Login OTP Details');
	//	$body = $this -> load -> view('send_mail_view.php', TRUE);
	$body="Dear User,<br><br> Your OTP for LMS login is ".$code.". <br><br><br><br> Thanks & Regards,<br>Team Autovista";
		$this -> email -> message($body);
		$this -> email -> send();
		$this -> session -> set_userdata('otp_code', $code);
		echo "OTP Resend Successfully <input type='tel'   value='" . $_SESSION['otp_code'] . "' id='session_otp1'  style='display: none' >";
		}
	}
	public function lead_source()
	{
			$lead_source = $this -> sign_up_model -> lead_source(); ?>
				<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" >Lead Source: </label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<select name="lead_source" id="lead_source" class="form-control" required onchange='select_sub_lead_source()'>
										<option value="">Please Select </option>
										<?php foreach ($lead_source as $lead_source) { ?>
											<option value="<?php echo $lead_source -> lead_source_name; ?>"><?php echo $lead_source -> lead_source_name; ?></option>
										<?php } ?>
										
										
									
									</select>
								</div>
							</div>
			<?php

			}
				public function sub_lead_source()
			{
			$sub_lead_source = $this -> sign_up_model -> sub_lead_source(); ?>
			<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" >Sub Lead Source: </label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<select name="sub_lead_source" id="sub_lead_source" class="form-control" >
									
										<option value="">Please Select </option>
										
											<?php foreach ($sub_lead_source as $row) { ?>
											<option value="<?php echo $row -> sub_lead_source_name; ?>"><?php echo $row -> sub_lead_source_name; ?></option>
										<?php } ?>
										
										
									
									</select>
								</div>
							</div>
			<?php
			}
				public function select_contact()
			{
			$select_lead=$this -> sign_up_model -> select_contact();
			if (count($select_lead)>0)
			{	?>
	
	<div id="duplicate" ><div class="table-responsive"  style="overflow-x:auto;">
	<table class="table table-bordered datatable table-responsive" id="table-4"> 
		
				<thead>
					
						<tr>
							
						
							<th><b>Sr No.</b></th>
							<th><b>Lead Source</b></th>
							<th><b>Customer Name</b></th>
							<th><b>Mobile Number</b></th>
							<th><b>Email ID</b></th>
							<th><b>Lead Date</b></th>
							<!--<th><b>Showroom Location</b></th>-->
							
							<th><b>CSE Name</b></th>
							<th><b>CSE Call Date</b></th>
							
							<th><b>CSE Feedback</b></th>
							<th><b>CSE Next Action</b></th>
							<th><b>CSE Remark</b></th>	
							<th><b>CSE NFD</b></th>
							<th><b>CSE TD/HV Date</b></th>
							
							<th><b>Booking within Days</b></th>
							
							<th><b>DSE Name</b></th>
							<th><b>DSE Call Date</b></th>
							
							<th><b>DSE Feedback</b></th>
							<th><b>DSE Next Action</b></th>
							<th><b>DSE Remark</b></th>	
							<th><b>DSE NFD</b></th>
							<th><b>DSE TD/HV Date</b></th>
								
						
							
							<th><b>Buyer Type</b></th>
							<th><b>Model/Variant</b></th>
							<th><b>Exchange Make/Model</b></th>
							<th><b>Manufacturing Year</b></th>
							
						
							
							
					
							</tr>
					
						
						
						
					</thead>
							<tbody>
				
							<?php
					$i=0;
					
					foreach($select_lead as $fetch)
					{
						 $enq_id=$fetch->enq_id;
							$i++; ?>
							<tr>
					<td><?php echo $i; ?></td>
					<td><?php
					if ($fetch -> lead_source == '') {
						echo "Website";
					} else {
						echo $fetch -> lead_source;
					}					?></td>
					<td><b><?php echo $fetch -> name; ?></b></td>
                    <td><?php echo $fetch -> contact_no; ?>
                    	<a href="<?php site_url(); ?>search_customer/leads_flow?id=<?php echo $fetch -> enq_id; ?>" target="_blank"> Check Flow </a> 
                    	
                    </td>
                    <td><?php echo $fetch -> email; ?></td>
                     <td><?php echo $fetch -> created_date; ?></td>
                     <!--<td><?php echo $fetch -> location; ?></td>-->
							
							 <!--- CSE Information -->
							<td><?php echo $fetch -> cse_fname . ' ' . $fetch -> cse_lname; ?></td>
							<td><?php echo $fetch -> cse_call_date; ?></td>
							
							<td><?php echo $fetch -> cse_feedbackStatus; ?></td>
							<td><?php echo $fetch -> cse_nextaction; ?></td>
							<td><?php echo $fetch -> cse_comment; ?></td>
							<td><?php echo $fetch -> cse_nfd; ?></td>
							<th><?php echo $fetch -> cse_td_hv_date; ?></th>
							
							<td><?php echo $fetch -> days60_booking; ?></td>
							
							  <!--- DSE Information -->
 							<td><?php echo $fetch -> dse_fname . ' ' . $fetch -> dse_lname; ?></td>
							<td><?php echo $fetch -> dse_call_date; ?></td>
							
							<td><?php echo $fetch -> dse_feedbackStatus; ?></td>
							<td><?php echo $fetch -> dse_nextaction; ?></td>
							<td><?php echo $fetch -> dse_comment; ?></td>
							<td><?php echo $fetch -> dse_nfd; ?></td>
							<th><?php echo $fetch -> dse_td_hv_date; ?></th>
							 <!-- Car Information -->
					
                  	<td><?php echo $fetch -> buyer_type; ?></td>
                    <td><?php echo $fetch -> new_model_name . ' ' . $fetch -> variant_name; ?></td>
          			 <td><?php echo $fetch -> make_name . ' ' . $fetch -> old_model_name; ?></td>
                    <td><?php echo $fetch -> manf_year; ?></td>
                
				
				
							
						</tr>	
					<?php } ?>
						
					</tbody>
					
					</table>
					</div></div>
	
	<?php
	}
	}
		public function all_lead_filter()
	{
	$this->session();
	$select_lead1 = $this -> sign_up_model -> select_lead();
	$all_count_lead = $this -> sign_up_model -> select_lead_count();

	$select_lead2 = $this -> sign_up_model -> select_lead_poc_purchase();
	$all_count_lead = $this -> sign_up_model -> select_lead_poc_purchase_count();
	
	$select_lead3 = $this -> sign_up_model -> select_lead_all();
	$all_count_lead = $this -> sign_up_model -> select_lead_all_count();
	
	$select_lead=array_merge($select_lead1,$select_lead2,$select_lead3);

	$select_lead =$select_lead;
	$all_count_lead = count($select_lead);
	$page = $this -> uri -> segment(4);
	if (isset($page)) {
	$page = $page + 1;
	} else {
	$page = 0;
	}
	$offset1 = 100 * $page;
	//$query=$sql->result();
	$c = count($select_lead);
	//echo $c;?>
	
	<div class="table-responsive"  >	
							<table id="example"  class="table " style="width: 100%" > 		
								<thead>
									<tr>
										<!-- Show Select box if add followup or remark right 1 -->										
									<th>Sr</th>										<th>Process</th>														<th>Name</th>										<th>Contact</th>										<th>Lead Date</th>											<th>Feedback Status</th>										<th>Next Action</th>										<!--<th>Current User</th>										<th>Call Date</th>										<th>N.F.D.T.</th>	-->										<th>Remark</th>																	<th>Action</th>	
								</tr>
							</thead>
							<tbody>
								<?php
									$i=$offset1;				
									if (!empty($select_lead)) 
									{
										foreach($select_lead as $fetch)
										{						
										 	$enq_id=$fetch->enq_id;
										
											$i++;
											?>
											<tr id='t<?php echo $i; ?>'>
											<input type="hidden" value="<?php echo count($select_lead); ?>" id="lead_count">
											<input type="hidden" value="<?php echo $fetch -> enquiry_for; ?>" id="select_enq">
											<td><?php echo $i; ?></td>
											<td>												<?php echo $fetch -> process; ?>											</td>
											<td><a href="<?php echo site_url(); ?>sign_up/lms_details/<?php echo $fetch -> enq_id; ?>/<?php echo $fetch -> process; ?>" target="_blank"><b><?php echo $fetch -> name; ?></b></a></td>
											<td><?php echo $fetch -> contact_no; ?></td>
											<td><?php echo $fetch -> created_date; ?></td>
											<td><?php echo $fetch -> feedbackStatus; ?></td>
											<td><?php echo $fetch -> nextAction; ?></td>
											
										<?php /* if($fetch->assign_to_dse!=0){?>
												 <td><?php echo $fetch -> dse_fname . ' ' . $fetch -> dse_lname; ?></td>
												 <?php }elseif($fetch->assign_to_dse_tl!=0 && $fetch->assign_to_dse==0){ ?>
												 <td><?php echo $fetch -> dsetl_fname . ' ' . $fetch -> dsetl_lname; ?></td>
												 <?php }elseif($fetch->assign_to_dse_tl==0 && $fetch->assign_to_dse==0){ ?>
												 <td><?php echo $fetch -> cse_fname . ' ' . $fetch -> cse_lname; ?></td>
												 <?php }else{ ?>
												 <td><?php echo $fetch -> csetl_fname . ' ' . $fetch -> csetl_lname; ?></td>
												 <?php } */
											?>
							
											<?php  if($fetch->dse_followup_id == 0){?>
											<!--<td><?php echo $fetch -> cse_date; ?></td>
											<td><?php echo $fetch -> cse_nfd; ?></td>
											<td><?php echo $fetch -> cse_nftime; ?></td>-->
											<td><?php $comment = $fetch -> cse_comment;
												$string = strip_tags($comment);
												if (strlen($string) > 20) {
													// truncate string
													$stringCut = substr($string, 0, 20);
													// make sure it ends in a word so assassinate doesn't become ass...
													$string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '... ';
												}
												echo $string;
											 ?></td>
											 <?php }else{ ?>
											 <!--	<td><?php echo $fetch -> dse_date; ?></td>
												<td><?php echo $fetch -> dse_nfd; ?></td>
												<td><?php echo $fetch -> dse_nftime; ?></td>-->
												<td><?php $comment = $fetch -> dse_comment;
													$string = strip_tags($comment);
													if (strlen($string) > 20) {
														// truncate string
														$stringCut = substr($string, 0, 20);
														// make sure it ends in a word so assassinate doesn't become ass...
														$string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '... ';
													}
													echo $string;
											 ?></td>
								<?php } ?>
							 <td>	<a href="#"  data-toggle="modal" data-target="#modal-6" onclick ="get_modal_data('<?php echo $fetch -> enq_id; ?>','<?php echo $fetch -> process; ?>','<?php echo $fetch -> cross_lead_escalation_remark; ?>')" >Add Escalation</a>
								</td>
								
							</tr>
							<?php } } ?>
						</tbody>
					</table>
				</div>
		
	<div class="col-md-12" style="margin-top: 20px;">
<div class="col-md-6" style="font-size: 14px">

   <?php $url = 'sign_up/all_lead/';
$total_record = $all_count_lead;
//$lead_cou = $count_lead_dse_lc+$count_lead_dse;
echo 'Total Records :';
echo '<b>' . $total_record . '</b>';
//print_r($count_lead);
		?>
   &nbsp;&nbsp;
  
     <?php echo 'Total Pages :';
	$pages = $total_record / 100;
	echo '<b>' . $total_page = ceil($pages) . '</b>';
 ?>
 
    </div>

<div class="col-md-6  form-group">
 
     
	
		
	<?php
	if ($c < 100) {
		$last = $page - 2;
		if ($last != -2) {
			//echo "1";
			echo "<a class='col-md-push-1 col-md-2 btn btn-info'  href=" . site_url() . $url . "page/" . $last . ">
<i class='fa fa-angle-left'></i>   Previous   </a>";
			echo "<a class='col-md-pull-3 col-md-1  btn btn-info'  href=" . site_url() . $url . ">First  
<i class='fa fa-angle-right'></i></a>";
			$last1 = $total_page - 2;
			echo "<a class=' col-md-push-5 col-md-1  btn btn-info' href=" . site_url() . $url . "page/" . $last1 . ">Last  
<i class='fa fa-angle-right'></i></a>";
		}
	} else if ($page == 0) {
		//echo"2";
		echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px;' href=" . site_url() . $url . "page/" . $page . ">Next  
<i class='fa fa-angle-right'></i></a>";
		echo "<a class=' col-md-1  btn btn-info'  href=" . site_url() . ">First  
<i class='fa fa-angle-right'></i></a>";
		$last1 = $total_page - 2;
		echo "<a class=' col-md-push-6 col-md-1  btn btn-info' href=" . site_url() . $url . "page/" . $last1 . ">Last  
<i class='fa fa-angle-right'></i></a>";
	} else {
		//echo "3";
		$last = $page - 2;
		echo " <a class='col-md-push-2 col-md-2 btn btn-info'  href=" . site_url() . $url . "page/" . $last . ">
<i class='fa fa-angle-left'></i>   Previous   </a> ";
		echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px ;' href=" . site_url() . $url . "page/" . $page . ">Next  
<i class='fa fa-angle-right'></i></a>";
		echo "<a class='col-md-pull-3 col-md-1  btn btn-info' href=" . site_url() . $url . ">First  
<i class='fa fa-angle-right'></i></a>";
		$last1 = $total_page - 2;
		echo "<a class='  col-md-push-6 col-md-1  btn btn-info'  href=" . site_url() . $url . "page/" . $last1 . ">Last  
<i class='fa fa-angle-right'></i></a>";
	}
	$page1 = $page + 1;
		?>
		

       <label class="col-md-pull-1 col-md-2  control-label" style="margin-top: 7px;" >Page No</label>
         <input class="col-md-pull-1  col-md-1" type="text" value="<?php echo $page1?>" name="pageNo" id="pageNo" style="width: 56px;border-radius:4px;height: 35px">
         <input class="col-md-pull-1  col-md-1  btn btn-danger "  style="margin-left: 10px;" type="submit" value="Go" onclick="go_on_page();">
        
    	</div>
		</div>
	</div>    
        <?php
		}	

}
?>
