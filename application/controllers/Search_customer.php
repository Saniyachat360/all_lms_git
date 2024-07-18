<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_customer extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('search_customer_model');

	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function index() {
		
		$this->session();
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('search_customer_view.php');
		$this -> load -> view('include/footer.php');
	}

	public function search() {
		
	$this->session();
	$select_lead=$data['select_lead'] = $this -> search_customer_model -> select_lead_dse();
	$process_id = $_SESSION['process_id'];
	?>
	<script>
	$(document).ready(function() {
		var table = $('#example').DataTable({

			scrollY : "300px",
			scrollX : true,
			scrollCollapse : true,

			fixedColumns : {
				leftColumns : 0,
				rightColumns : 0
			}
		});
	}); 
</script>
		
	<div class="table-responsive" >
			<table id="example"  class="table " style="width:auto;" cellspacing="0"> 
		
		
		
				<thead>
						<tr>
							<tr>
							<th>Sr No.</th>
							<th>Lead Source</th>
							<th>Sub Lead Source</th>
							<th>Customer Name</th>
							<th>Mobile Number</th>
							<th>Alternate Mobile Number</th>
							<th>Address</th>
							<th>Email ID</th>
							<th>Lead Date</th>
							<th>Lead Time</th>
							<th>Assistance Required </th>
							<th>Booking within Days</th>
							<th>Customer Location</th>
							<th>Lead Assigned Date(CSE)</th>
							<th>Lead Assigned Time(CSE) </th>
							<?php 
							// Check New Car / Used Car / Evaluation
							if($process_id=='6' || $process_id=='7' || $process_id=='8' )
							{
								?>
								
							<th>CSE Name</th>
							
							<th>CSE Call Date</th>
								<th>CSE Call Time</th>
								<th>CSE Call Status</th>
							<th>CSE Feedback</th>
							<th>CSE Next Action</th>
							
							<th>CSE Remark</th>	
							<th>CSE NFD</th>
							<th>CSE NFT</th>
							<th>Appointment Type</th>
							<th>Appointment Date</th>
							<th>Appointment Time </th>
						
							<th>Appointment Status</th>							
							
							<!--<th>TD/HV date</th>-->
							<th>Showroom Location</th>
							<?php if($process_id == 8){?>
								<th>Evaluator Name</th>
							<th>Lead Assigned Date(Evaluator)</th>
							<th>Lead Assigned Time(Evaluator)</th>
							<th>Evaluator Call Date</th>
							<th>Evaluator Call Time</th>
							<th>Evaluator Call Status</th>
							<th>Evaluator Feedback</th>
							<th>Evaluator Next Action</th>
							
							<th>Evaluator Remark</th>	
							<th>Evaluator NFD</th>
							<th>Evaluator NFT</th>
							<?php }else { ?>
							<th>DSE Name</th>
							<th>Lead Assigned Date(DSE)</th>
							<th>Lead Assigned Time(DSE)</th>
							<th>DSE Call Date</th>
							<th>DSE Call Time</th>
							<th>DSE Call Status</th>
							<th>DSE Feedback</th>
							<th>DSE Next Action</th>
							
							<th>DSE Remark</th>	
							<th>DSE NFD</th>
							<th>DSE NFT</th>
								<?PHP
							}
								}
								// Check Process Finance / Accessories / Service
								if($process_id== '1' ||$process_id =='5'|| $process_id =='4'){
										?>
									<th>Current User</th>
									<th>Call Date</th>
							<th>Feedback Status</th>
							<th>Next Action</th>
							<th>Eagerness</th>
							<th>NFD</th>
							<th>NFT</th>
							<th>Remark</th>
							<?php	
								}
								
							?>
								
								<?php if($process_id==6)
								{
									?>	
							<th>Interested in Finance </th>	
							<th>Interested in Accessories </th>	
							<th>Interested in Insurance </th>	
							<th>Interested in EW </th>	
							<th>Buyer Type</th>
							<th>Model/Variant</th>
							
									<?php
									}
									if($process_id==1){
								?>
							
							<th>Car Model</th>
							<th>Reg No</th>	
							<th>Bank Name</th>
							<th>Loan Type</th>
							<th>ROI</th>
							<th>LOS No.</th>
							<th>Tenure</th>
							<th>Amount</th>	
							<th>Dealer/DSA</th>
							<th>Collection Executive Name</th>
							<th>Pickup Date</th>
							<th>Login Date</th>
							<th>Loan Status</th>
							<th>Approved Date</th>
							<th>Disburse Date</th>
							<th>Disburse Amount</th>
							<th>Processing Fee</th>
							<th>EMI</th>
							<?php } if($process_id==5){ ?>
							<!--<th>Current User</th>
							<th>Feedback Status</th>
							<th>Next Action</th>
							<th>Eagerness</th>
							<th>NFD</th>
							<th>NFT</th>
							<th>Remark</th>	-->
							<th>Car Model</th>
							<th>Reg No</th>
							<th>Accessories List</th>
							<th>Accessories Price</th>
								<?php }
									if($process_id==4){?>
							<!--<th>Current User</th>
							<th>Feedback Status</th>
							<th>Next Action</th>
							<th>Eagerness</th>
							<th>NFD</th>
							<th>NFT</th>
							<th>Remark</th>	-->
							<th>Car Model</th>
							<th>Reg No</th>
							<th>KM</th>
							<th>Service Type</th>
							<th>Pick up Required</th>
							<th>Pick up Date</th>
							<?php } if($process_id==7){?>
							<th>Interested in Finance </th>	
							<th>Interested in Accessories </th>	
							<th>Interested in Insurance </th>	
							<th>Interested in EW </th>	
							<th>Buyer Type</th>
							<th>Model/Variant</th>
							<th>Exchange Make/Model</th>
							<th>Manufacturing Year</th>
							<th>Ownership</th>
							<th>KM</th>
							<th>Budget From</th>
							<th>Budget To</th>
							<th>Accidental Claim</th>
          					
          					
          
							<?php } if($process_id==8){?>
								<?php if($_SESSION['sub_poc_purchase']==2){?>
										<th>Evaluation No</th>
							<th>Outright/Exchange</th>
							<th>Vehicle Sale Category Customer\Dealer</th>
							<th>Exchange Make</th>
							<th>Exchange Model</th>
							<th>Sub Model</th>
							<th>Manufacturing Year</th>
							<th>Fuel Type</th>
							<th>Color</th>
							<th>Registration No</th>
							<th>Year of Regn</th>
							<th>KM</th>
							<th>Ownership</th>
							<th>Old Car Owner Name</th>
							<th>HP</th>
							<th>Finacier Name</th>
							<th>Insurance Type</th>
							<th>Insurance Co Name</th>
							<th>Insurance Validity date</th>
							<th>Photo Uploaded</th>
							<th>Type of Vehicle - Pvt\T permit</th>
							<th>Vehicle Accidental</th>
							<th>Accidental Details</th>
							<th>Tyre conditon</th>
							<th>Engine work</th>
							<th>body work</th>
							<th>Battery</th>
							<th>Mechanical</th>
							<th>Tyre</th>
							<th>Other</th>
							<th>Price Offered</th>
							<th>Customer Expectation</th>
							<th>Difference</th>
							<th>Refurbish cost Bodyshop</th>	
							<th>Price With RF & commission</th>		
							<th>Agent Commission Payable</th>	
							<th>Total RF</th>
							<th>Expected Selling Price</th>
							<th>Expected Date of Sale</th>
							<th>Bought at Price</th>							
							<th>Bought Date</th>
							<th>Payment date</th>
							<th>Payment mode</th>
							<th>Payment Made to</th>
									<?php }else{?>
									
							<th>Exchange Make/Model</th>
							<th>Manufacturing Year</th>
							<th>Ownership</th>
							<th>KM</th>
							<th>Accidental Claim</th>
							<th>Evaluation within days</th>
							<th>Fuel Type</th>
							<th>Color</th>
							<th>Registration Number</th>
							<th>Quoted Price</th>
							<th>Expected Price</th>
						<?php } } ?>
								<th>Auditor Name</th>	
								<th>Auditor call Date</th>
								<th>Auditor call Time</th>		
								<th>Auditor call Status</th>		
								<th>Followup Pending</th>
								<th>Call Received from Showroom</th>
								<th>Fake Updation</th>
								<th>Service Feedback</th>
								<th>Auditor Remark</th>
								<th>Action</th>
						</tr>	
						
					</thead>
				<tbody>
					
							<?php
$i=0;				
				if (!empty($select_lead)) 
					{
					foreach($select_lead as $fetch)
					{
						  $enq_id=$fetch->enq_id;
							$i++; ?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php
					if ($fetch -> lead_source == '') {
							 echo "Web  ";
							 //.$fetch->enquiry_for;
						} 
					/*	else if($fetch->lead_source=='Facebook')
						{
							echo $fetch->enquiry_for;
						}*/
						 else { echo $fetch -> lead_source;
						}
 ?></td>
 <td><?php echo $fetch -> enquiry_for; ?></td>
 <td><b><?php echo $fetch -> name; ?></b></td>
                    <td><?php echo $fetch -> contact_no; ?></td>
                    <td><?php echo $fetch -> alternate_contact_no; ?></td>
                    <td><?php echo $fetch -> address; ?></td>
                    <td><?php echo $fetch -> email; ?></td>
                    <td><?php echo $fetch -> lead_date; ?></td>
                    <td><?php echo $fetch -> lead_time; ?></td>
					<td><?php echo $fetch -> assistance; ?></td>
 					<td><?php echo $fetch -> days60_booking; ?></td>
 					<td><?php echo $fetch -> customer_location; ?></td>
					
                     <td><?php echo $fetch -> assign_to_cse_date; ?></td>
                      <td><?php echo $fetch -> assign_to_cse_time; ?></td>
                    	<?php if($process_id==6 || $process_id==7 || $process_id==8)
							{ ?>
                   
					<!--- CSE Information -->
					<?php if($fetch->assign_to_cse == 0){?>
					
					<td><?php echo $fetch -> csetl_fname . ' ' . $fetch -> csetl_lname; ?></td>
					
					<?php }else{ ?>
						<td><?php echo $fetch -> cse_fname . ' ' . $fetch -> cse_lname; ?></td>
						<?php } ?>
						<td><?php echo $fetch -> cse_date; ?></td>
						<td><?php echo $fetch -> cse_time; ?></td>
						<td><?php echo $fetch -> csecontactibility; ?></td>
						<td><?php echo $fetch -> csefeedback; ?></td>
						<td><?php echo $fetch -> csenextAction; ?></td>
						<td><?php echo $fetch -> cse_comment; ?></td>
						<td><?php echo $fetch -> cse_nfd; ?></td>
						<td><?php echo $fetch -> cse_nftime; ?></td>
						<td><?php echo $fetch -> appointment_type; ?></td>
						<td><?php echo $fetch -> appointment_date; ?></td>
						<td><?php echo $fetch -> appointment_time; ?></td>
					
						<td><?php echo $fetch -> appointment_status; ?></td>
						
						
						 <td><?php echo $fetch -> showroom_location; ?></td>
						<!--<td><?php echo $fetch -> td_hv_date; ?></td>-->
						<!--- dSE Information -->
						<?php   if($fetch->assign_to_dse == 0){ ?>
						<td><?php echo $fetch -> dsetl_fname . ' ' . $fetch -> dsetl_lname; ?></td>
						<td><?php echo $fetch -> assign_to_dse_tl_date; ?></td>
                      <td><?php echo $fetch -> assign_to_dse_tl_time; ?></td>
						<?php	}else{
								//if($fetch->dse_role ==4 || $fetch->dse_role ==5 || $fetch->dse_role ==15 || $fetch->dse_role ==16){ 
								//echo "snheal";?>
						<td><?php echo $fetch -> dse_fname . ' ' . $fetch -> dse_lname; ?></td>
						<td><?php echo $fetch -> assign_to_dse_date; ?></td>
                      <td><?php echo $fetch -> assign_to_dse_time; ?></td>
						<?php //}else{ ?>
						
						<?php //}
						} ?>
							
					<td><?php echo $fetch -> dse_date; ?></td>
						<td><?php echo $fetch -> dse_time; ?></td>
						<td><?php echo $fetch -> dsecontactibility; ?></td>
						
					<td><?php echo $fetch -> dsefeedback; ?></td>
					<td><?php echo $fetch -> dsenextAction; ?></td>
					<td><?php echo $fetch -> dse_comment; ?></td>
					<td><?php echo $fetch -> dse_nfd; ?></td>	
					<td><?php echo $fetch -> dse_nftime; ?></td>	
					<?php } 
					if($process_id==1 || $process_id == 4|| $process_id == 5) {
										?>
									<td><?php echo $fetch -> cse_fname . ' ' . $fetch -> cse_lname; ?></td>
															<td><?php echo $fetch -> cse_date; ?></td>
                   	<td><?php echo $fetch -> feedbackStatus; ?></td>
					<td><?php echo $fetch -> nextAction; ?></td>
					<td><?php echo $fetch -> eagerness; ?></td>
					
					<td><?php echo $fetch -> cse_nfd; ?></td>
					<td><?php echo $fetch -> cse_nftime; ?></td>
					<td><?php echo $fetch -> cse_comment; ?></td>
					<?php	
						}
					
					
					?>	
					
					<?php if($process_id==6)
					{?> 
						<td><?php echo $fetch -> interested_in_finance; ?></td>
						<td><?php echo $fetch -> interested_in_accessories; ?></td>
						<td><?php echo $fetch -> interested_in_insurance; ?></td>
						<td><?php echo $fetch -> interested_in_ew; ?></td>
					<td><?php echo $fetch -> buyer_type; ?></td>
                    <td><?php echo $fetch -> new_model_name . ' ' . $fetch -> variant_name; ?></td>
          			
                    <?php }
						if($fetch->process=='Finance'){
					?>
					
					<td><?php echo $fetch -> model_name; ?></td>
					<td><?php echo $fetch -> reg_no; ?></td>
					<td><?php echo $fetch -> bank_name; ?></td>
					
					<td><?php echo $fetch -> loan_type; ?></td>
				
					<td><?php echo $fetch -> roi; ?></td>
					<td><?php echo $fetch -> los_no; ?></td>
					<td><?php echo $fetch -> tenure; ?></td>
					<td><?php echo $fetch -> loanamount; ?></td>
					<td><?php echo $fetch -> dealer; ?></td>
					<td><?php echo $fetch -> executive_name; ?></td>
					<td><?php echo $fetch -> pick_up_date; ?></td>
					<td><?php echo $fetch -> file_login_date; ?></td>
					<td><?php echo $fetch -> login_status_name; ?></td>
					<td><?php echo $fetch -> approved_date; ?></td>
					<td><?php echo $fetch -> disburse_date; ?></td>
					<td><?php echo $fetch -> disburse_amount; ?></td>
					<td><?php echo $fetch -> process_fee; ?></td>
					<td><?php echo $fetch -> emi; ?></td>
						<?php } if($process_id ==5){ ?>
					<!--<td><?php echo $fetch -> cse_fname . ' ' . $fetch -> cse_lname; ?></td>
                   	<td><?php echo $fetch -> feedbackStatus; ?></td>
					<td><?php echo $fetch -> nextAction; ?></td>
					<td><?php echo $fetch -> eagerness; ?></td>
					
					<td><?php echo $fetch -> cse_nfd; ?></td>
					<td><?php echo $fetch -> cse_nftime; ?></td>
					<td><?php echo $fetch -> cse_comment; ?></td>-->
					<td><?php echo $fetch -> model_name; ?></td>
					<td><?php echo $fetch -> reg_no; ?></td>
					<td><?php echo $fetch -> accessoires_list; ?></td>
					<td><?php echo $fetch -> assessories_price; ?></td>
					<?php }if($process_id== 4){?>
					<!--<td><?php echo $fetch -> cse_fname . ' ' . $fetch -> cse_lname; ?></td>
                   	<td><?php echo $fetch -> feedbackStatus; ?></td>
					<td><?php echo $fetch -> nextAction; ?></td>
					<td><?php echo $fetch -> eagerness; ?></td>
					<td><?php echo $fetch -> cse_nfd; ?></td>
					<td><?php echo $fetch -> cse_nftime; ?></td>
					<td><?php echo $fetch -> cse_comment; ?></td>-->
					<td><?php echo $fetch -> model_name; ?></td>
					<td><?php echo $fetch -> reg_no; ?></td>
					<td><?php echo $fetch -> km; ?></td>
					<td><?php echo $fetch -> service_type; ?></td>
					<td><?php echo $fetch -> pickup_required; ?></td>
					<td><?php echo $fetch -> pick_up_date; ?></td>
			
					<?php } if($process_id== 7){?>
						<td><?php echo $fetch -> interested_in_finance; ?></td>
						<td><?php echo $fetch -> interested_in_accessories; ?></td>
						<td><?php echo $fetch -> interested_in_insurance; ?></td>
						<td><?php echo $fetch -> interested_in_ew; ?></td>
					<td><?php echo $fetch -> buyer_type; ?></td>
                    <td><?php echo $fetch -> new_model_name . ' ' . $fetch -> variant_name; ?></td>
          			<td><?php echo $fetch -> make_name . ' ' . $fetch -> old_model_name; ?></td>
          			   <td><?php echo $fetch -> manf_year; ?></td>
          			<td><?php echo $fetch -> ownership; ?></td>
                    <td><?php echo $fetch -> km; ?></td>
					<td><?php echo $fetch -> budget_from; ?></td>	
					<td><?php echo $fetch -> budget_to; ?></td>
					<td><?php echo $fetch -> accidental_claim; ?></td>
						<?php } if($process_id==8){?>
							<?php if($_SESSION['sub_poc_purchase']==2){?>
								<td><?php echo $fetch -> enq_id?></td>
						<td><?php echo $fetch -> outright?></td>
						<td><?php echo $fetch -> vechicle_sale_category?></td>	
						<td><?php echo $fetch -> make_name?></td>
						<td><?php echo $fetch -> model_name?></td>		
						<td><?php echo $fetch -> variant_name?></td>
						<td><?php echo $fetch -> manf_year ?></td>
						<td><?php echo $fetch -> fuel_type?></td>
						<td><?php echo $fetch -> color?></td>
						<td><?php echo $fetch -> reg_no?></td>
						<td><?php echo $fetch -> reg_year ?></td>
						<td><?php echo $fetch -> km?></td>
						<td><?php echo $fetch -> ownership?></td>
						<td><?php echo $fetch -> old_car_owner_name?></td>
						<td><?php echo $fetch -> hp ?></td>
						<td><?php echo $fetch -> financier_name?></td>
						<td><?php echo $fetch -> insurance_type?></td>
						<td><?php echo $fetch -> insurance_company?>
						<td><?php echo $fetch -> insurance_validity_date?>
						<td><?php echo $fetch -> photo_uploaded?></td>
						<td><?php echo $fetch -> type_of_vehicle ?></td>
						<td><?php echo $fetch -> accidental_details?></td>
						<td><?php echo $fetch -> accidental_details?></td>
						<td><?php echo $fetch -> tyre_conditon?></td>					
						<td><?php echo $fetch -> engine_work?></td>
						<td><?php echo $fetch -> body_work?></td>
						<td><?php echo $fetch -> refurbish_cost_battery?></td>
						<td><?php echo $fetch -> refurbish_cost_mecahanical?></td>
						<td><?php echo $fetch -> refurbish_cost_tyre?></td>
						<td><?php echo $fetch -> refurbish_other?></td>
						<td><?php echo $fetch -> quotated_price?></td>
						<td><?php echo $fetch -> expected_price?></td>
						<td><?php echo $fetch -> expected_price - $fetch -> quotated_price?></td>
						<td><?php echo $fetch -> refurbish_cost_bodyshop?></td>
						<td><?php echo $fetch -> price_with_rf_and_commission?></td>
						<td><?php echo $fetch -> agent_commision_payable?></td>
						<td><?php echo $fetch -> total_rf?></td>
						<td><?php echo $fetch -> selling_price?></td>
						<td><?php echo $fetch -> expected_date_of_sale?></td>
						<td><?php echo $fetch -> bought_at?></td>
						<td><?php echo $fetch -> bought_date?></td>
						<td><?php echo $fetch -> payment_date?></td>
						<td><?php echo $fetch -> payment_mode?></td>
						<td><?php echo $fetch -> payment_made_to?></td>
								<?php } else {?>
						<td><?php echo $fetch -> make_name . ' ' . $fetch -> old_model_name; ?></td>
							<td><?php echo $fetch -> manf_year; ?></td>
							<td><?php echo $fetch -> ownership; ?></td>
							 <td><?php echo $fetch -> km; ?></td>
							<td><?php echo $fetch -> accidental_claim; ?></td>
							<td><?php echo $fetch -> evaluation_within_days; ?></td>
							<td><?php echo $fetch -> fuel_type; ?></td>
							<td><?php echo $fetch -> color; ?></td>
							<td><?php echo $fetch -> reg_no; ?></td>
							<td><?php echo $fetch -> quotated_price; ?></td>
							<td><?php echo $fetch -> expected_price; ?></td>
								
						<?php } } ?>	
						<td><?php echo $fetch -> auditfname . ' ' . $fetch -> auditlname; ?></td>
					<td><?php echo $fetch -> auditor_date; ?></td>
					<td><?php echo $fetch -> auditor_time; ?></td>
					<td><?php echo $fetch -> auditor_call_status; ?></td>
					<td><?php echo $fetch -> followup_pending; ?></td>	
					<td><?php echo $fetch -> call_received; ?></td>	
					<td><?php echo $fetch -> fake_updation; ?></td>	
					<td><?php echo $fetch -> service_feedback; ?></td>	
					<td><?php echo $fetch -> auditor_remark; ?></td>
					<td><a href="search_customer/leads_flow?id=<?php echo $fetch->enq_id;?>" target="_blank"> Check Flow </a></td>	
						</tr>	
					<?php } } ?>
				
					</tbody>
					</table>
				
		</div>
		<?php
	}
	
	public function leads_flow() {
		$enq_id=$this->input->get('id');
		//echo $enq_id;
		$select_leads_flow=$data['select_leads_flow'] = $this -> search_customer_model -> select_leads_flow($enq_id);
		//$select_leads_flow_lc=$data['select_leads_flow_lc'] = $this -> search_customer_model -> select_leads_flow_lc($enq_id);
		//$select_leads_flow_lost=$data['select_leads_flow_lost'] = $this -> search_customer_model -> select_leads_flow_lost($enq_id);		
		//print_r($select_leads_flow);
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('leads_flow_view.php',$data);
		$this -> load -> view('include/footer.php');
	}
	/****************************** Complaint Functions **************************************************/
	public function search_complaint() {
		
	$this->session();
	$select_lead=$data['select_lead'] = $this -> search_customer_model -> select_lead_complaint();
	$process_id = $_SESSION['process_id'];
	?>
	<script>
	$(document).ready(function() {
		var table = $('#example').DataTable({

			scrollY : "300px",
			scrollX : true,
			scrollCollapse : true,

			fixedColumns : {
				leftColumns : 0,
				rightColumns : 0
			}
		});
	}); 
</script>
		
	<div class="table-responsive" >
			<table id="example"  class="table " style="width:auto;" cellspacing="0"> 
		
		
		
		<thead>
						<tr>
							<tr>
							<th>Sr No.</th>
							<th>Lead Source</th>
							<th>Customer Name</th>
							<th>Mobile Number</th>
							<th>Alternate Mobile Number</th>
							<th>Address</th>
							<th>Email ID</th>
							<th>Lead Date</th>
							<th>Lead Time</th>
							<th>Service Center</th>
							<th>Customer Remark</th>
							<th>Lead Assigned Date</th>
							<th>Lead Assigned Time</th>
							<th>Current User</th>
							<th>Call Date</th>
							<th>Feedback Status</th>
							<th>Next Action</th>
							<th>NFD</th>
							<th>NFT</th>
							<th>Remark</th>
							<th>Auditor Name</th>	
							<th>Auditor call Date</th>
							<th>Auditor call Time</th>		
							<th>Auditor call Status</th>		
							<th>Followup Pending</th>
							<th>Call Received from Showroom</th>
							<th>Fake Updation</th>
							<th>Service Feedback</th>
							<th>Auditor Remark</th>
						</tr>	
						
					</thead>
				<tbody>
					
							<?php
					$i=0;
				
				if (!empty($select_lead)) 
					{
					foreach($select_lead as $fetch)
					{
						 // $enq_id=$fetch->enq_id;
							$i++; ?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php
					if ($fetch -> lead_source == '') {
							 echo "Web - ".$fetch->business_area;
						} 
						
						 else { echo $fetch -> lead_source.' '.$fetch->business_area;
						}
 ?></td>
 <td><b><?php echo $fetch -> name; ?></b></td>
                    <td><?php echo $fetch -> contact_no; ?></td>
                    <td><?php echo $fetch -> alternate_contact_no; ?></td>
                    <td><?php echo $fetch -> address; ?></td>
                    <td><?php echo $fetch -> email; ?></td>
                    <td><?php echo $fetch -> lead_date; ?></td>
                    <td><?php echo $fetch -> lead_time; ?></td>
					
 					<td><?php echo $fetch -> service_center; ?></td>
 					<td><?php echo $fetch -> comment; ?></td>
					
                     <td><?php echo $fetch -> assign_to_cse_date; ?></td>
                      <td><?php echo $fetch -> assign_to_cse_time; ?></td>
                    	
                
					
					<td><?php echo $fetch -> cse_fname . ' ' . $fetch -> cse_lname; ?></td>
					<td><?php echo $fetch -> cse_date; ?></td>
                   	<td><?php echo $fetch -> feedbackStatus; ?></td>
					<td><?php echo $fetch -> nextAction; ?></td>
					
					<td><?php echo $fetch -> cse_nfd; ?></td>
					<td><?php echo $fetch -> cse_nftime; ?></td>
					<td><?php echo $fetch -> cse_comment; ?></td>
					
						
						<td><?php echo $fetch -> auditfname . ' ' . $fetch -> auditlname; ?></td>
					<td><?php echo $fetch -> auditor_date; ?></td>
					<td><?php echo $fetch -> auditor_time; ?></td>
					<td><?php echo $fetch -> auditor_call_status; ?></td>
					<td><?php echo $fetch -> followup_pending; ?></td>	
					<td><?php echo $fetch -> call_received; ?></td>	
					<td><?php echo $fetch -> fake_updation; ?></td>	
					<td><?php echo $fetch -> service_feedback; ?></td>	
					<td><?php echo $fetch -> auditor_remark; ?></td>	
						</tr>	
					<?php } } ?>
				
					</tbody>
					</table>
				
		</div>
		<?php
	}
}
?>	