<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.timepicker.min.css">
<style>
	.ui-timepicker {

		text-align: left;
	}

	.ui-timepicker-container {
		z-index: 10000;
	}

	label {
		margin-top: 10px;
	}

	.form-group {
		margin-bottom: 0px;
	}
</style>
<script>
	$(document).ready(function() {
		//alert(new Date());
		$('#datett').daterangepicker({
			singleDatePicker: true,
			minDate: new Date(),
			format: 'YYYY-MM-DD',
			showDropdowns: true,
			calender_style: "picker_1",
		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});
		$('#appointment_date').daterangepicker({
			singleDatePicker: true,
			minDate: new Date(),
			format: 'YYYY-MM-DD',
			showDropdowns: true,
			calender_style: "picker_1",
		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});

	});

	function check_appointment_details() {

		var appointment_type = document.getElementById("appointment_type").value;

		if (appointment_type != '') {
			document.getElementById("appointment_time").required = true;
			document.getElementById("appointment_date").required = true;
			document.getElementById("appointment_status").required = true;
		} else {
			document.getElementById("appointment_time").value = "";
			document.getElementById("appointment_time").value = "";
			document.getElementById("appointment_date").value = "";
			document.getElementById("appointment_status").value = "";

			document.getElementById("appointment_time").required = false;
			document.getElementById("appointment_date").required = false;
			document.getElementById("appointment_status").required = false;
		}

	}
	//Select user name using location
	function select_transfer_location() {
		var ctprocess = document.getElementById("tprocess").value;
		var a = ctprocess.split("#");
		var tprocess = a[0];
		var tprocess_name = a[1];

		if (ctprocess != '') {
			document.getElementById("buyer_type").required = true;
			document.getElementById("new_model").required = true;
			document.getElementById("new_variant").required = true;
		} else {
			document.getElementById("buyer_type").value = "";
			document.getElementById("new_model").value = "";
			document.getElementById("new_variant").value = "";
		}


		//	var old_tprocess="<?php // echo $lead_detail[0]->transfer_process 
								?>";
		var old_dse_tl_id = "<?php echo $lead_detail[0]->assign_to_dse_tl; ?>";
		var lead_process = "<?php echo $lead_detail[0]->process; ?>";
		<?php $user_id = $this->session->userdata('user_id');
		$check_user_process_transfer = $this->db->query("select p.process_id
									from lmsuser l 
									Left join tbl_manager_process mp on mp.user_id=l.id 
									Left join tbl_process p on p.process_id=mp.process_id
									where mp.user_id='$user_id'  group by p.process_id")->result();
		?>
		var cupt = new Array();
		<?php foreach ($check_user_process_transfer as $row) { ?>
			cupt.push('<?php echo $row->process_id; ?>');
		<?php } ?>

		var cupt_count = cupt.length;
		for (var i = 0; i <= cupt_count; i++) {

			if (cupt[i] == tprocess) {
				document.getElementById("lead_status1").disabled = true;
				document.getElementById("lead_status2").disabled = true;
				document.getElementById("lead_status").style.display = "none";
				document.getElementById("tlocation_div").style.display = 'block';
				document.getElementById("tassign_div").style.display = 'block';
				document.getElementById("tlocation1").disabled = false;
				document.getElementById("tassignto1").disabled = false;
				break;

			} else {
				document.getElementById("lead_status").style.display = 'block';
				document.getElementById("lead_status1").disabled = false;
				document.getElementById("lead_status2").disabled = false;
				document.getElementById("tassignto1").disabled = true;
			}
		}





		/*	if(old_tprocess == tprocess_name){
				alert("Lead already transfer Same Process");
				document.getElementById("tlocation1").disabled = true; 
				document.getElementById("tassignto1").disabled = true; 
				return false;
			}
			else */
		/*	if(old_dse_tl_id!=0 && tprocess_name == lead_process){
				alert("Lead already transfer to DSE TL Showroom");
				document.getElementById("tlocation1").disabled = true; 
				document.getElementById("tassignto1").disabled = true; 
				document.getElementById("tlocation_div").style.display ='none'; 
				document.getElementById("tassign_div").style.display ='none'; 
				document.getElementById("lead_status").style.display ='none'; 
				document.getElementById("tprocess").value="";
				return false;
			}*/

		$.ajax({
			url: '<?php echo site_url('add_followup_new_car/select_transfer_location'); ?>',
			type: 'POST',
			data: {
				'tprocess': tprocess
			},
			success: function(result) {
				$("#tassign_div").css("display", "none");
				$("#tlocation_div").html(result);

			}
		});

	}
	//Select user name using location
	function select_assign_to() {
		var tlocation1 = document.getElementById("tlocation1").value;
		var tprocess = document.getElementById("tprocess").value;
		$.ajax({
			url: '<?php echo site_url('add_followup_new_car/select_assign_to'); ?>',
			type: 'POST',
			data: {
				'tlocation1': tlocation1,
				'tprocess': tprocess
			},
			success: function(result) {
				$("#tassign_div").css("display", "block");
				$("#assign_div").html(result);
			}
		});
	}
</script>
<script>
	function call_status_nfd(val) {
		var nfdDiv = document.getElementById("nfd");
		if (val == 'Not Connected') {
			document.getElementById("datett").disabled = true;
			document.getElementById("timet").disabled = true;
			nfdDiv.style.display = "none";
		} else {
			nfdDiv.style.display = "block";
			document.getElementById("datett").disabled = false;
			document.getElementById("timet").disabled = false;
		}
	}
</script>
<script>
	//Select variant name using model 
	function select_variant() {
		var model = document.getElementById("new_model").value;

		$.ajax({
			url: '<?php echo site_url('add_followup_new_car/select_variant'); ?>',
			type: 'POST',
			data: {
				'model': model,
			},
			success: function(result) {
				$("#variant").html(result);
			}
		});
	}
	//Select model name usign make id
	function select_model() {
		var make = document.getElementById("make").value;
		$.ajax({
			url: '<?php echo site_url('add_followup_new_car/select_model'); ?>',
			type: 'POST',
			data: {
				'make': make,
			},
			success: function(result) {
				$("#model_div").html(result);
			}
		});
	}
	// Get Next Action from Feed back status
	function select_feedback(val) {
		//alert(val);
		var feedback = val;
		$.ajax({
			url: '<?php echo site_url('add_followup_new_car/select_next_action'); ?>',
			type: 'POST',
			data: {
				'feedback': feedback,

			},
			success: function(result) {
				$("#nextactiondiv").html(result);
			}
		});
	}
	// show and hide nfd div
	function check_nfd(val) {
		var nextaction = document.getElementById("nextaction").value;
		var call_status = document.getElementById("contactibility").value;
		var nfdDiv = document.getElementById("nfd");
		if (nextaction == 'Close' || nextaction == 'Booked From Autovista' || nextaction == 'Lead Transfer') {
			document.getElementById("datett").disabled = true;
			document.getElementById("timet").disabled = true;
			nfdDiv.style.display = "none";
		} else {
			nfdDiv.style.display = "block";
			document.getElementById("datett").disabled = false;
			document.getElementById("timet").disabled = false;
		}


		if (nextaction == 'Booked From Autovista') {
			document.getElementById("edms_booking_no").disabled = false;
			edms_booking_noDiv.style.display = "block";
		} else {
			document.getElementById("edms_booking_no").disabled = true;
			edms_booking_noDiv.style.display = "none";
		}
	}
	// Using next action show and hide div
	function check_disp_name(val) {
		var nextaction = document.getElementById("nextaction").value;
		check_nfd(val);
		var hiddenDiv = document.getElementById("Test_Home");
		if (nextaction == 'Home Visit' || nextaction == 'Test Drive') {
			hiddenDiv.style.display = "block";
		} else {

			hiddenDiv.style.display = "none";
		}

	}
</script>
<script>
	function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		// Added to allow decimal, period, or delete
		if (charCode == 110 || charCode == 190 || charCode == 46)
			return true;

		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;

		return true;
	}

	function limitlength(obj, length) {
		var maxlength = length
		if (obj.value.length > maxlength)
			obj.value = obj.value.substring(0, maxlength)
	}


	function send_brochure() {
		var model = document.getElementById("new_model").value;
		if (model == '') {
			alert("Please Select Model");
		}
	}

	//Select user name using location
	function select_assign_to1() {
		var evaluation_location = document.getElementById("evaluation_location").value;
		var evaluation_process = document.getElementById("evaluation_process").value;
		$.ajax({
			url: '<?php echo site_url('add_followup_new_car/select_assign_to_evaluation'); ?>',
			type: 'POST',
			data: {
				'tlocation1': evaluation_location,
				'tprocess': evaluation_process
			},
			success: function(result) {
				$("#evaluation_assign_div").html(result);
			}
		});
	}

	function select_model_name() {
		var city = document.getElementById("qlocation").value;
		$.ajax({
			url: '<?php echo site_url('add_followup_new_car/select_model_name'); ?>',
			type: 'POST',
			data: {
				'city': city,
			},
			success: function(result) {
				$("#model_name_div").html(result);
			}
		});
	}
	// For select Qutation description
	function select_description() {
		var model_name = document.getElementById("model_name").value;
		var city = document.getElementById("qlocation").value;
		$.ajax({
			url: '<?php echo site_url('add_followup_new_car/select_description'); ?>',
			type: 'POST',
			data: {
				'model_name': model_name,
				'city': city,
			},
			success: function(result) {
				$("#description_div").html(result);
			}
		});
	}

	// For select Qutation description
	function check_accessories() {
		var model_name = document.getElementById("model_name").value;
		var city = document.getElementById("qlocation").value;
		var description = document.getElementById("description").value;
		$.ajax({
			url: '<?php echo site_url('add_followup_new_car/check_accessories'); ?>',
			type: 'POST',
			data: {
				'model_name': model_name,
				'city': city,
				'description': description
			},
			success: function(result) {
				$("#checkprize_div").html(result);
			}
		});
	}

	function insert_make_model() {
		var make = document.getElementById("buy_make").value;
		var model = document.getElementById("buy_model").value;
		var enq_id = document.getElementById("enq_id").value;
		var buyer_type = document.getElementById("buyer_type").value;

		if (make == '') {
			alert("Please select make");
			return false;
		}
		if (model == '') {
			alert("Please select model");
			return false;
		}
		$.ajax({
			url: '<?php echo site_url('add_followup_new_car/insert_buy_car_data'); ?>',

			type: 'POST',
			data: {
				'make': make,
				'model': model,
				'enq_id': enq_id,
				'buyer_type': buyer_type
			},
			success: function(result) {
				$("#replace_data").html(result);
			}
		});
	}


	function send_quotation() {

		if (document.getElementById('quotation').checked == true) {
			document.getElementById("qlocation").disabled = false;
			document.getElementById("description").disabled = false;
			document.getElementById("model_name").disabled = false;

			$("#quotation1").show();
		} else {
			document.getElementById("qlocation").disabled = true;
			document.getElementById("description").disabled = true;
			document.getElementById("model_name").disabled = true;

			$("#quotation1").hide();
		}

	}

	function showDiv() {
		if (document.getElementById('interested_in_finance').value == 'Yes') {
			document.getElementById('financeDiv').style.display = "block";
		} else {
			document.getElementById('financeDiv').style.display = "none";
		}
	}
</script>
<script>
	//Show pervious data in text box
	function check_values() {
		//Basic followup
		var email_old = '<?php echo $lead_detail[0]->email; ?>';
		var alternate_contact = '<?php echo $lead_detail[0]->alternate_contact_no; ?>';
		var feedbackStatus = '<?php echo $lead_detail[0]->feedbackStatus; ?>';
		var nextAction = '<?php echo $lead_detail[0]->nextAction; ?>';
		var tdhvdate = '<?php echo $lead_detail[0]->td_hv_date; ?>';
		var days60_booking = '<?php echo $lead_detail[0]->days60_booking; ?>';
		var dms_enq_number_old = '<?php echo $lead_detail[0]->dms_enq_number; ?>';

		//Buyer Details
		var buyer_type = '<?php echo $lead_detail[0]->buyer_type; ?>';

		//New Car Details
		var new_model_old = '<?php echo $lead_detail[0]->new_model_id; ?>';
		//var new_variant_old='<?php echo $lead_detail[0]->variant_id; ?>';

		//Exchange Details
		var old_make = '<?php echo $lead_detail[0]->old_make; ?>';
		//var old_model='<?php echo $lead_detail[0]->old_model; ?>';
		var ownership = '<?php echo $lead_detail[0]->ownership; ?>';
		var mfg = '<?php echo $lead_detail[0]->manf_year; ?>';
		var km = '<?php echo $lead_detail[0]->km; ?>';


		//Appointment Details
		var appointment_type = '<?php echo $lead_detail[0]->appointment_type; ?>';
		var appointment_status = '<?php echo $lead_detail[0]->appointment_status; ?>';
		var appointment_date = '<?php echo $lead_detail[0]->appointment_date; ?>';
		var appointment_rating = '<?php echo $lead_detail[0]->appointment_rating; ?>';
		var appointment_time = '<?php echo $lead_detail[0]->appointment_time; ?>';
		var appointment_feedback = '<?php echo $lead_detail[0]->appointment_feedback; ?>';
		var appointment_address = '<?php echo $lead_detail[0]->appointment_address; ?>';

		//Interested In
		var interested_in_finance = '<?php echo $lead_detail[0]->interested_in_finance; ?>';
		var interested_in_accessories = '<?php echo $lead_detail[0]->interested_in_accessories; ?>';
		var interested_in_insurance = '<?php echo $lead_detail[0]->interested_in_insurance; ?>';
		var interested_in_ew = '<?php echo $lead_detail[0]->interested_in_ew; ?>';

		//stock and fuel type
		var followup_stock = '<?php echo $lead_detail[0]->followup_stock; ?>';
		var followup_fuel_type = '<?php echo $lead_detail[0]->followup_fuel_type; ?>';


		//Corporate details
		var customer_occupation = '<?php echo $lead_detail[0]->customer_occupation; ?>';
		var customer_designation = '<?php echo $lead_detail[0]->customer_designation; ?>';
		var customer_corporate_name = '<?php echo $lead_detail[0]->customer_corporate_name; ?>';

		var hiddenDiv = document.getElementById("Test_Home");

		//Basic Details
		if (email_old == '') {

			document.getElementById("email").value = "";

		} else {
			document.getElementById("email").value = email_old;
		}

		if (dms_enq_number_old == '') {

			document.getElementById("dms_enq_number").value = "";

		} else {
			document.getElementById("dms_enq_number").value = dms_enq_number_old;
		}


		if (alternate_contact == '') {

			document.getElementById("alternate_contact").value = "";

		} else {
			document.getElementById("alternate_contact").value = alternate_contact;
		}
		if (feedbackStatus == '') {
			document.getElementById("feedback").value = "";

		} else {
			document.getElementById("feedback").value = feedbackStatus;
		}
		if (nextAction == '') {
			document.getElementById("nextaction").value = "";

		} else {
			document.getElementById("nextaction").value = nextAction;
		}
		if (days60_booking == '') {
			document.getElementById("days60_booking").value = "";

		} else {
			document.getElementById("days60_booking").value = days60_booking;
		}



		var nfdDiv = document.getElementById("nfd");

		if (nextAction == 'Close' || nextAction == 'Booked From Autovista' || nextAction == 'Lead Transfer') {



			document.getElementById("datett").disabled = true;
			document.getElementById("timet").disabled = true;
			nfdDiv.style.display = "none";
		} else {

			nfdDiv.style.display = "block";
			document.getElementById("datett").disabled = false;
			document.getElementById("timet").disabled = false;
		}


		//Buyer Type
		if (buyer_type == '') {
			document.getElementById("buyer_type").value = "";

		} else {
			document.getElementById("buyer_type").value = buyer_type;

		}

		// New Car
		if (new_model_old == '' || new_model_old == 0) {

			document.getElementById("new_model").value = "";

		} else {
			document.getElementById("new_model").value = new_model_old;
		}

		// Exchange Car 
		if (old_make == '') {
			document.getElementById("make").value = "";

		} else {
			document.getElementById("make").value = old_make;

		}

		if (ownership == '') {
			document.getElementById("ownership").value = "";

		} else {
			document.getElementById("ownership").value = ownership;

		}
		if (mfg == '') {
			document.getElementById("mfg").value = "";

		} else {
			document.getElementById("mfg").value = mfg;

		}

		if (km == '') {
			document.getElementById("km").value = "";

		} else {
			document.getElementById("km").value = km;

		}


		//Interested In
		if (interested_in_finance == 'Yes') {
			document.getElementById("interested_in_finance1").checked = true;
		} else if (interested_in_finance == 'No') {
			document.getElementById("interested_in_finance2").checked = true;
		}
		if (interested_in_insurance == 'Yes') {
			document.getElementById("interested_in_insurance1").checked = true;
		} else if (interested_in_insurance == 'No') {
			document.getElementById("interested_in_insurance2").checked = true;
		}
		if (interested_in_accessories == 'Yes') {
			document.getElementById("interested_in_accessories1").checked = true;
		} else if (interested_in_accessories == 'No') {
			document.getElementById("interested_in_accessories2").checked = true;
		}
		if (interested_in_ew == 'Yes') {
			document.getElementById("interested_in_ew1").checked = true;
		} else if (interested_in_ew == 'No') {
			document.getElementById("interested_in_ew2").checked = true;
		}

		//saniya code
		if (followup_fuel_type == 'CNG') {
			document.getElementById("followup_fuel_type1").checked = true;
		} else if (followup_fuel_type == 'Petrol') {
			document.getElementById("followup_fuel_type2").checked = true;
		}
		if (followup_stock == 'Yes') {
			document.getElementById("followup_stock1").checked = true;
		} else if (followup_stock == 'No') {
			document.getElementById("followup_stock2").checked = true;
		}
		//eof saniya

		// Appointment Type
		if (appointment_type == '') {
			document.getElementById("appointment_type").value = "";

		} else {
			document.getElementById("appointment_type").value = appointment_type;
		}
		if (appointment_status == '') {
			document.getElementById("appointment_status").value = "";

		} else {
			document.getElementById("appointment_status").value = appointment_status;
		}
		if (appointment_date == '') {
			document.getElementById("appointment_date").value = "";

		} else {
			document.getElementById("appointment_date").value = appointment_date;
		}
		/*	if(appointment_rating == '')
			{
			  document.getElementById("appointment_rating").value = "";
	  
			}else{
				document.getElementById("appointment_rating").value = appointment_rating;
			}*/
		if (appointment_time == '') {
			document.getElementById("appointment_time").value = "";

		} else {
			document.getElementById("appointment_time").value = appointment_time;
		}
	}
</script>

<body class="page-body" onload="check_buyer('<?php echo $lead_detail[0]->buyer_type; ?>');check_values(); ">
	<div class="container " style="width: 100%;">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-body">
					<div id="abc">
						<?php $today = date('d-m-Y'); ?>

						<br />
						<div style="margin-bottom: 40px;">
							<div class="col-md-3">
								<h1>Follow Up Details</h1>
							</div>
							<div class="col-md-3">Name: <b style="font-size: 15px;"><?php echo $lead_detail[0]->name; ?></b></div>
							<div class="col-md-3">Contact: <b style="font-size: 15px;"><?php echo $lead_detail[0]->contact_no; ?></b></div>
							<?php
							$email = $lead_detail[0]->email;
							if ($email == '') { ?>
							<?php
							} else {
							?>
							<div class="col-md-3">Email: <b style="font-size: 15px;"><?php echo $lead_detail[0]->email; ?></b></div><br>
							<?php
							}
							?>

							<?php
							$reg_no = $lead_detail[0]->reg_no;
							if ($reg_no == '') { ?>
							<?php
							} else {
							?>
								<div class="col-md-3">Registration No: <b style="font-size: 15px;"><?php echo $lead_detail[0]->reg_no; ?></b></div>
							<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<form action="<?php echo $var; ?>" method="post">
			<div class="container " style="width: 100%;">
				<div class="row">
					<div id="abc">
						<div class="col-md-12"><?php echo $this->session->flashdata('message'); ?></div>
						<?php $today = date('d-m-Y'); ?>

						<?php //$insert = $_SESSION['insert'];
						//if ($insert[9] == 1) { ?>



							<div class="panel panel-primary">
								<div class="panel-body">

									<input type="hidden" name="booking_id" id='enq_id' value="<?php echo $lead_detail[0]->enq_id; ?>">
									<input type="hidden" name="phone" value="<?php echo $lead_detail[0]->contact_no; ?>">
									<input type="hidden" name="loc" value="<?php echo $path; ?>">


									<input type="hidden" value="<?php echo date("Y-m-d"); ?>" name="date" class="form-control" style="background:white; cursor:default;" />


									<div id="demo-form2" data-parsley-validate class="">
										<!-- Basic Followup -->


										<!--new other details-->
										<div class="panel panel-primary">
											<h3 class="text-center"></h3>
											<div class="panel-body">

												<div class="col-md-12 col-sm-12 col-xs-12">
													<div class="col-md-4 col-sm-12 col-xs-12">


														<div class="form-group">
															<label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Location
															</label>
															<div class="col-md-12 col-sm-12 col-xs-12">
																<select name="customer_location" id="customer_location" class="form-control">
																
																<option value="Mumbai"<?=$lead_detail[0]->customer_location == 'Mumbai' ? ' selected="selected"' : '';?>>Mumbai</option>
																<option value="Pune"<?=$lead_detail[0]->customer_location == 'Pune' ? ' selected="selected"' : '';?>>Pune</option>

																</select>
															</div>
														</div>

														
														<div id='nfd' style="display:block">
															<div class="form-group">
																<label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Follow Up Date & Time:
																</label>
																<div class="col-md-6 col-sm-6 col-xs-12">
																	<input type="text" placeholder="Enter Next Follow Up Date" id="datett" autocomplete="off" name='followupdate' class="form-control" required tabindex="7" style="cursor:default;" />

																</div>
																<div class="col-md-6 col-sm-6 col-xs-12">

																	<input class="form-control " data-template="dropdown" id="timet" autocomplete="off" name="followuptime" placeholder="Enter Next Follow Up Time" required type="text" tabindex="8">



																</div>
															</div>

														</div>

														<div id="nextactiondiv" class="form-group">
															<label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Call Status:
															</label>
															<div class="col-md-12 col-sm-12 col-xs-12">
																<select name="contactibility" id="contactibility" class="form-control" required tabindex="4">
																	<option value="">Please Select </option>
																	<option value="Connected">Connected</option>
																	<option value="Not Connected">Not Connected</option>

																</select>
															</div>
														</div>

													</div>
													<div class="col-md-4">


														

														<div class="form-group">
															<label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Types
															</label>
															<div class="col-md-12 col-sm-12 col-xs-12">
																<select name="insurance_type" id="insurance_type" class="form-control" required>
																	
																	<option value="1st Year"<?=$lead_detail[0]->insurance_type == '1st Year' ? ' selected="selected"' : '';?>>1st Year</option>
																	<option value="2nd Year"<?=$lead_detail[0]->insurance_type == '2nd Year' ? ' selected="selected"' : '';?>>2nd Year</option>
																	<option value="Non Mi"<?=$lead_detail[0]->insurance_type == 'Non Mi' ? ' selected="selected"' : '';?>>Non Mi</option>
																	<option value="Advance Calling"<?=$lead_detail[0]->insurance_type == 'Advance Calling' ? ' selected="selected"' : '';?>>Advance Calling</option>
																</select>
															</div>
														</div>

														<div id="nextactiondiv" class="form-group">
															<label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Calling Remark:
															</label>
															<div class="col-md-12 col-sm-12 col-xs-12">
																<textarea name="calling_remark" class="form-control" placeholder="Remark" required></textarea>
															</div>
														</div>

														

													</div>
												</div>
											</div>
										</div>



									</div>

									<div class="form-group">
										<div class="col-md-2 col-md-offset-5">
											<button type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12">Submit</button>
										</div>
										<div class="col-md-2">
											<button type="reset" class="btn btn-primary col-md-12 col-xs-12 col-sm-12">Reset</button>
										</div>
									</div>

		</form>
	</div>

	</div>
	<!---send quotation-->

<?php //} ?>
<?php if (count($select_followup_lead) > 0) { ?>
	<div class="col-md-12 table-responsive" style="overflow-x:scroll">
		<table class="table table-bordered datatable" id="results1">

			<thead>
				<tr>
					<th>Sr No</th>

					<th>Follow Up By</th>
					<th>Call Status</th>
					<th>Call Date Time</th>

					<!-- <th>Types</th> -->
					<th>Caling Remark</th>

					<th>N.F.D.T.</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 0;
				foreach ($select_followup_lead as $row) {

					$i++;

				?>
					<tr>
						<td><?php echo $i; ?></td>

						<td><?php echo $row->fname . ' ' . $row->lname; ?></td>
						<td><?php echo $row->contactibility; ?></td>
						<td><?php echo $row->c_date . ' ' . $row->created_time; ?></td>
						<!-- <td><?php echo  $row->insurance_type; ?></td> -->
						<td><?php echo $row->calling_remark ?></td>

						<td><?php echo $row->nextfollowupdate . ' ' . $row->nextfollowuptime ?></td>


					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php }  ?>





<div class="row">
	<div class="col-md-12">
		<?php if (isset($lead_detail[0]->esc_level1)) {
			if ($lead_detail[0]->esc_level1 == 'Yes' || $lead_detail[0]->esc_level2 == 'Yes' || $lead_detail[0]->esc_level3 == 'Yes') { ?>

				<h3 class="text-center">Escalation Details</h3>
				<div class="col-md-6" style="margin-top:20px">

					<div class="panel panel-primary">

						<div class="panel-body">

							<?php if (isset($lead_detail[0]->esc_level1)) {
								if ($lead_detail[0]->esc_level1 == 'Yes' || $lead_detail[0]->esc_level2 == 'Yes' || $lead_detail[0]->esc_level3 == 'Yes') { ?>
									<h4 style='text-align: center'>Escalation Done</h4>
								<?php } else { ?>

							<?php }
							} ?>

							<div class="table-responsive" style="overflow-x:scroll">
								<table class="table ">

									<?php if (isset($lead_detail[0]->esc_level1)) {
										if ($lead_detail[0]->esc_level1 == 'Yes') { ?>
											<tr>
												<th>Escalation Level 1</th>
												<td><?php if (isset($lead_detail[0]->esc_level1)) {
														echo $lead_detail[0]->esc_level1_remark;
													} ?></td>
											</tr>
									<?php }
									} ?>

									<?php if (isset($lead_detail[0]->esc_level2)) {
										if ($lead_detail[0]->esc_level2 == 'Yes') { ?>
											<tr>
												<th>Escalation Level 2</th>
												<td><?php if (isset($lead_detail[0]->esc_level1)) {
														echo $lead_detail[0]->esc_level2_remark;
													} ?></td>
											</tr>
									<?php }
									} ?>

									<?php if (isset($lead_detail[0]->esc_level3)) {
										if ($lead_detail[0]->esc_level3 == 'Yes') { ?>
											<tr>
												<th>Escalation Level 3</th>
												<td><?php if (isset($lead_detail[0]->esc_level3)) {
														echo $lead_detail[0]->esc_level3_remark;
													} ?></td>
											</tr>
									<?php }
									} ?>
								</table>
							</div>
						</div>


					</div>
				</div>

				<div class="col-md-6" style="margin-top:20px">
					<div class="panel panel-primary">
						<div class="panel-body">

							<?php if (isset($lead_detail[0]->esc_level1_resolved)) {
								if ($lead_detail[0]->esc_level1_resolved == 'Yes' || $lead_detail[0]->esc_level2_resolved == 'Yes' || $lead_detail[0]->esc_level3_resolved == 'Yes') { ?>
									<h4 style='text-align: center'>Resolved Escalation</h4>
								<?php } else { ?>
									<h4> </h4>
							<?php }
							} ?>
							<?php if (isset($lead_detail[0]->esc_level1_resolved)) {
								if ($lead_detail[0]->esc_level1_resolved == 'Yes' || $lead_detail[0]->esc_level2_resolved == 'Yes' || $lead_detail[0]->esc_level3_resolved == 'Yes') { ?>

									<div class="table-responsive" style="overflow-x:scroll">
										<table class="table ">

											<?php if (isset($lead_detail[0]->esc_level1_resolved)) {
												if ($lead_detail[0]->esc_level1_resolved == 'Yes') { ?>
													<tr>
														<th>Escalation Level 1</th>
														<!--<td><?php if (isset($lead_detail[0]->esc_level1)) {
																	echo $lead_detail[0]->esc_level1;
																} ?></td>-->
														<td><?php if (isset($lead_detail[0]->esc_level1_resolved)) {
																echo $lead_detail[0]->esc_level1_resolved_remark;
															} ?></td>
													</tr>
											<?php }
											} ?>

											<?php if (isset($lead_detail[0]->esc_level2_resolved)) {
												if ($lead_detail[0]->esc_level2_resolved == 'Yes') { ?>
													<tr>
														<th>Escalation Level 2</th>
														<!--<td><?php if (isset($lead_detail[0]->esc_level2)) {
																	echo $lead_detail[0]->esc_level2;
																} ?></td>-->
														<td><?php if (isset($lead_detail[0]->esc_level1_resolved)) {
																echo $lead_detail[0]->esc_level2_resolved_remark;
															} ?></td>
													</tr>
											<?php }
											} ?>

											<?php if (isset($lead_detail[0]->esc_level3_resolved)) {
												if ($lead_detail[0]->esc_level3_resolved == 'Yes') { ?>
													<tr>
														<th>Escalation Level 3</th>
														<!--<td><?php if (isset($lead_detail[0]->esc_level3)) {
																	echo $lead_detail[0]->esc_level3;
																} ?></td>-->
														<td><?php if (isset($lead_detail[0]->esc_level3_resolved)) {
																echo $lead_detail[0]->esc_level3_resolved_remark;
															} ?></td>
													</tr>
											<?php }
											} ?>
										</table>
									</div>
							<?php }
							} ?>
						</div>


					</div>
				</div>
		<?php }
		} ?>
	</div>
</div>














</div>
</div>
</div>
<!-- Modal -->
<!-- Modal -->


<!--- New Quotation -->
<div class="modal fade " id="send_quotation_modal1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3>Send Quotation</h3>
			</div>
			<div class="modal-body">
				<div class="row">
					<form action="<?php echo site_url(); ?>add_followup_new_car/show_quotation" method="POST">
						<input type="hidden" name="customer_name" value="<?php echo $lead_detail[0]->name; ?>" />

						<input type="hidden" name="path" value="<?php echo $path; ?>" />
						<input type="hidden" name="booking_id" value="<?php echo $lead_detail[0]->enq_id; ?>" />
						<div class="col-md-12">
							<div class="panel panel-primary">

								<div class="panel-body">

									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-12 col-sm-12 col-xs-12"> Location: </label>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<select name="quotation_location" id="quotation_location" class="form-control" required onchange="select_quotation_model_name();">
													<option value="">Please Select </option>
													<?php foreach ($quotation_location as $row) { ?>
														<option value="<?php echo $row->location; ?>"><?php echo $row->location; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>

									</div>
									<div id="quotation_model_name_div">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-12 col-sm-12 col-xs-12">Model: </label>
												<div class="col-md-12 col-sm-12 col-xs-12">
													<select name="qutotation_model" id="qutotation_model" class="form-control" required>
														<option value="">Please Select </option>

													</select>
												</div>
											</div>
										</div>
									</div>

									<div id="quotation_variant_name_div">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-12 col-sm-12 col-xs-12">Variant: </label>
												<div class="col-md-12 col-sm-12 col-xs-12">
													<select name="quotation_variant" id="quotation_variant" class="form-control" required>
														<option value="">Please Select </option>

													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-12 col-sm-12 col-xs-12">Customer Type: </label>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<select name="customer_type" id="customer_type" class="form-control" required onchange="select_quotation_onroad_price()" required>
													<option value="">Please Select </option>
													<option value="individual">Individual </option>
													<option value="corporate">Corporate </option>

												</select>
											</div>
										</div>
									</div>
									<div class="col-md-12" id="quotation_on_road_price_div" style="padding-left:0px;padding-right:0px">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-12 col-sm-12 col-xs-12">Ex Showroom: </label>
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input type="text" name="ex_showroom" class="form-control" onkeypress="return onlyNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-12 col-sm-12 col-xs-12">On Road Price: </label>
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input type="text" name="on_road_price_1" class="form-control" onkeypress="return onlyNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-12 col-sm-12 col-xs-12">Extended Warranty </label>
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input type="text" name="ew" class="form-control" onkeypress="return onlyNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-12 col-sm-12 col-xs-12">RTO Tax & Other Charges </label>
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input type="text" name="rto" class="form-control" onkeypress="return onlyNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-12 col-sm-12 col-xs-12">Registration </label>
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input type="text" name="registration" class="form-control" onkeypress="return onlyNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-12 col-sm-12 col-xs-12">Insurance </label>
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input type="text" name="insurance" class="form-control" onkeypress="return onlyNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-12 col-sm-12 col-xs-12">Auto Card </label>
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input type="text" name="auto_card" class="form-control" onkeypress="return onlyNumberKey(event)">
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-12 col-sm-12 col-xs-12">Consumer Offer </label>
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input type="text" name="consumer_offer" class="form-control" onkeypress="return onlyNumberKey(event)">
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-12 col-sm-12 col-xs-12">Corporate Offer </label>
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input type="text" name="corporate_offer" class="form-control" onkeypress="return onlyNumberKey(event)">
												</div>
											</div>
										</div>

									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-12 col-sm-12 col-xs-12">Additional Offer: </label>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="qutotation_additional_offer" id="qutotation_additional_offer" class="form-control" placeholder="Additional Offer" onkeypress="return onlyNumberKey(event)">
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-12 col-sm-12 col-xs-12">Accessories: </label>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="qutotation_accessories" id="qutotation_accessories" class="form-control" placeholder="Accessories" value="20000" onkeypress="return onlyNumberKey(event)">

											</div>
										</div>


									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-12 col-sm-12 col-xs-12">Buyer Type: </label>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<select name="qutotation_buyer" id="qutotation_buyer" class="form-control" required onchange="select_buyer_data()">
													<option value="">Please Select </option>
													<option value="First">First </option>
													<option value="Exchange">Exchange </option>

												</select>
											</div>
										</div>


									</div>
									<div class="col-md-6" style="margin-top: 10px;display:none" id="qutotation_exchange_make_div">
										<div class="form-group">
											<label class="control-label col-md-12 col-sm-12 col-xs-12">Exchange Make: </label>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="qutotation_exchange_make" id="qutotation_exchange_make" class="form-control" placeholder="Exchange Make">
											</div>
										</div>
									</div>

									<!--<div id="qutotation_exchange_model_div"></div>
				    <div id="qutotation_exchange_variant_div"></div>-->
									<div class="col-md-6" style="margin-top: 10px;display:none" id="qutotation_exchange_model_div">
										<div class="form-group">
											<label class="control-label col-md-12 col-sm-12 col-xs-12">Exchange Model: </label>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="qutotation_exchange_model" id="qutotation_exchange_model" class="form-control" placeholder="Exchange Model">
											</div>
										</div>
									</div>
									<div class="col-md-6" style="margin-top: 10px;display:none" id="qutotation_exchange_bonus_div">
										<div class="form-group">
											<label class="control-label col-md-12 col-sm-12 col-xs-12">Exchange Bouns: </label>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="qutotation_exchange_bouns" id="qutotation_exchange_bouns" class="form-control" placeholder="Exchange Bouns" onkeypress="return onlyNumberKey(event)">
											</div>
										</div>
									</div>

									<div class="col-md-12">

										<label class="control-label col-md-12 col-sm-12 col-xs-12">Finance Scheme: </label>

									</div>
									<div class="col-md-12" style="margin-top: 10px">
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-3"> </label>


											<label class="control-label col-md-3 col-sm-3 col-xs-3">SCHEME-I </label>
											<label class="control-label col-md-3 col-sm-3 col-xs-3">SCHEME-II </label>
											<label class="control-label col-md-3 col-sm-3 col-xs-3">SCHEME-III </label>
										</div>
									</div>
									<div class="col-md-12" style="margin-top: 10px">
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-3">Bank Name: </label>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="bank_name_1" class="form-control" placeholder="Bank Name">
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="bank_name_2" class="form-control" placeholder="Bank Name">
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="bank_name_3" class="form-control" placeholder="Bank Name">
											</div>
										</div>
									</div>
									<br>
									<div class="col-md-12" style="margin-top: 10px">
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-3">Tenure in Months: </label>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="tenure_1" class="form-control" placeholder="Tenure" onkeypress="return onlyNumberKey(event)">
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="tenure_2" class="form-control" placeholder="Tenure" onkeypress="return onlyNumberKey(event)">
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="tenure_3" class="form-control" placeholder="Tenure" onkeypress="return onlyNumberKey(event)">
											</div>
										</div>
									</div>
									<br>

									<div class="col-md-12" style="margin-top: 10px">
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-3">Loan Amount: </label>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="loan_amount_1" class="form-control" placeholder="Loan Amount" onkeypress="return onlyNumberKey(event)">
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="loan_amount_2" class="form-control" placeholder="Loan Amount" onkeypress="return onlyNumberKey(event)">
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="loan_amount_3" class="form-control" placeholder="Loan Amount" onkeypress="return onlyNumberKey(event)">
											</div>
										</div>
									</div>
									<div class="col-md-12" style="margin-top: 10px">
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-3">Margin Money: </label>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="margin_money_1" class="form-control" placeholder="Margin Money" onkeypress="return onlyNumberKey(event)">
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="margin_money_2" class="form-control" placeholder="Margin Money" onkeypress="return onlyNumberKey(event)">
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="margin_money_3" class="form-control" placeholder="Margin Money" onkeypress="return onlyNumberKey(event)">
											</div>
										</div>
									</div>
									<div class="col-md-12" style="margin-top: 10px">
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-3">Advance EMI: </label>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="adv_emi_1" class="form-control" placeholder="Advance EMI" onkeypress="return onlyNumberKey(event)">
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="adv_emi_2" class="form-control" placeholder="Advance EMI" onkeypress="return onlyNumberKey(event)">
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="adv_emi_3" class="form-control" placeholder="Advance EMI" onkeypress="return onlyNumberKey(event)">
											</div>
										</div>
									</div>
									<div class="col-md-12" style="margin-top: 10px">
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-3">Processing Fees: </label>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="processing_fee_1" class="form-control" placeholder="Processing Fees" onkeypress="return onlyNumberKey(event)">
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="processing_fee_2" class="form-control" placeholder="Processing Fees" onkeypress="return onlyNumberKey(event)">
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="processing_fee_3" class="form-control" placeholder="Processing Fees" onkeypress="return onlyNumberKey(event)">
											</div>
										</div>
									</div>
									<div class="col-md-12" style="margin-top: 10px">
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-3">Stamp Duty: </label>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="stamp_duty_1" class="form-control" placeholder="Stamp Duty" onkeypress="return onlyNumberKey(event)">
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="stamp_duty_2" class="form-control" placeholder="Stamp Duty" onkeypress="return onlyNumberKey(event)">
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="stamp_duty_3" class="form-control" placeholder="Stamp Duty" onkeypress="return onlyNumberKey(event)">
											</div>
										</div>
									</div>
									<div class="col-md-12" style="margin-top: 10px">
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-3">Down Payment: </label>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="down_payment_1" class="form-control" placeholder="Down Payment" onkeypress="return onlyNumberKey(event)">
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="down_payment_2" class="form-control" placeholder="Down Payment" onkeypress="return onlyNumberKey(event)">
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="down_payment_3" class="form-control" placeholder="Down Payment" onkeypress="return onlyNumberKey(event)">
											</div>
										</div>
									</div>
									<div class="col-md-12" style="margin-top: 10px">
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-3">EMI Per Month: </label>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="emi_per_month_1" class="form-control" placeholder="EMI Per Month" onkeypress="return onlyNumberKey(event)">
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="emi_per_month_2" class="form-control" placeholder="EMI Per Month" onkeypress="return onlyNumberKey(event)">
											</div>
											<div class="col-md-3 col-sm-3 col-xs-3" style="padding: 0px 5px 0px 0px;">

												<input type="text" name="emi_per_month_3" class="form-control" placeholder="EMI Per Month" onkeypress="return onlyNumberKey(event)">
											</div>
										</div>
									</div>
									<div class="col-md-12" style="margin-top: 10px">
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-3">Remark: </label>
											<div class="col-md-6 col-sm-6 col-xs-6" style="padding: 0px 5px 0px 0px;">

												<textarea name="quotation_remark" class="form-control" placeholder="Remark"></textarea>

											</div>
										</div>
									</div>


									<input type="hidden" name="page_path" value="<?php echo $path; ?>">
									<input type="hidden" name="quotation_enq_id" value="<?php echo $lead_detail[0]->enq_id ?>">

								</div>
							</div>
						</div>



				</div>

				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Submit </button>

				</div>
				</form>
			</div>
		</div>
	</div>
	<!---/send quotation-->
	<script>
		function onlyNumberKey(evt) {

			// Only ASCII charactar in that range allowed 
			var ASCIICode = (evt.which) ? evt.which : evt.keyCode
			if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
				return false;
			return true;
		}
	</script>
	<script>
		function select_quotation_onroad_price() {
			var quotation_location = document.getElementById("quotation_location").value;
			var qutotation_model = document.getElementById("qutotation_model").value;
			var quotation_variant = document.getElementById("quotation_variant").value;
			var customer_type = document.getElementById("customer_type").value;
			//alert(qutotation_model);
			if (quotation_location == '' || qutotation_model == '' || quotation_variant == '') {
				document.getElementById("customer_type").value = '';
				alert("Please First select location,model and variant");
				return false;
			}
			$.ajax({
				url: '<?php echo site_url('add_followup_new_car/select_quotation_onroad_price'); ?>',
				type: 'POST',
				data: {
					'quotation_location': quotation_location,
					'qutotation_model': qutotation_model,
					'quotation_variant': quotation_variant,
					'customer_type': customer_type
				},
				success: function(result) {
					$("#quotation_on_road_price_div").html(result);
				}
			});

		}

		function select_buyer_data() {

			var qutotation_buyer = document.getElementById("qutotation_buyer").value;

			if (qutotation_buyer == 'Exchange') {

				document.getElementById('qutotation_exchange_make_div').style.display = 'block';
				document.getElementById('qutotation_exchange_model_div').style.display = 'block';
				document.getElementById('qutotation_exchange_bonus_div').style.display = 'block';

			} else {
				document.getElementById('qutotation_exchange_make_div').style.display = 'none';
				document.getElementById('qutotation_exchange_model_div').style.display = 'none';
				document.getElementById('qutotation_exchange_bonus_div').style.display = 'none';

			}


		}

		function select_quotation_model_name() {
			var quotation_location = document.getElementById("quotation_location").value;
			$.ajax({
				url: '<?php echo site_url('add_followup_new_car/select_quotation_model_name'); ?>',
				type: 'POST',
				data: {
					'quotation_location': quotation_location
				},
				success: function(result) {
					$("#quotation_model_name_div").html(result);
				}
			});
		}

		function select_quotation_variant_name() {
			var qutotation_model = document.getElementById("qutotation_model").value;
			var quotation_location = document.getElementById("quotation_location").value;
			$.ajax({
				url: '<?php echo site_url('add_followup_new_car/select_quotation_variant_name'); ?>',
				type: 'POST',
				data: {
					'qutotation_model': qutotation_model,
					'quotation_location': quotation_location
				},
				success: function(result) {
					$("#quotation_variant_name_div").html(result);
				}
			});
		}
	</script>