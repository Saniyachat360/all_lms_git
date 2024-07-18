<script>
	$(document).ready(function() {
		var table = $('#example').DataTable({

			scrollY: "400px",
			scrollX: true,
			scrollCollapse: true,

			fixedColumns: {
				leftColumns: 0,
				rightColumns: 0
			}
		});
	});
</script>
<script>
	<?php
	$page = $this->uri->segment(4);
	if (isset($page)) {
		$page = $page + 1;
	} else {
		$page = 0;
	}
	$offset1 = 100 * $page;
	//$query=$sql->result();
	echo $c = count($select_lead);
	?>
</script>
<div class="col-md-12">
	<div class="control-group" id="blah" style="margin:0% 30% 1% 50%">

	</div>
	<div class="table-responsive">

		<table id="example" class="table " style="width:auto;" cellspacing="0">



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
					<th>First Call Date</th>
					<th>DMS Enquiry Number</th>
					<th>Fuel Type</th>
					<th>Stock</th>
					<th>Assistance Required </th>
					<th>Booking within Days</th>
					<th>Customer Location</th>
					<th>Lead Assigned Date(CSE)</th>
					<th>Lead Assigned Time(CSE) </th>
					<?php
					// Check New Car / Used Car / Evaluation
					if ($process_id == '6' || $process_id == '7' || $process_id == '8') {
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
						<th>Overdue</th>
						<th>Appointment Type</th>
						<th>Appointment Date</th>
						<th>Appointment Time </th>
						<!--<th>Appointment Address</th>-->
						<th>Appointment Status</th>
						<!--<th>Appointment Rating</th>
							<th>Appointment Feeback</th>
						<th>TD/HV date</th>-->
						<th>Showroom Location</th>
						<?php if ($process_id == 8) { ?>
							<th>Evaluator TL Name</th>

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
							<th>Overdue</th>
						<?php } else { ?>
							<th>DSE TL Name</th>
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
							<th>Overdue</th>
							<?php if ($process_id == 6 || $process_id == 7) { ?>
								<th>EDMS Booking Id</th>
							<?php } ?>
						<?PHP
						}
					}
					// Check Process Finance / Accessories / Service
					if ($process_id == '1' || $process_id == '5' || $process_id == '4') {
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

					<?php if ($process_id == 6) {
					?>
						<th>Interested in Finance </th>
						<th>Interested in Accessories </th>
						<th>Interested in Insurance </th>
						<th>Interested in EW </th>
						<th>Buyer Type</th>
						<th>Model/Variant</th>

					<?php
					}
					if ($process_id == 1) {
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
					<?php }
					if ($process_id == 5) { ?>
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
					if ($process_id == 4) { ?>
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
					<?php }
					if ($process_id == 7) { ?>
						<th>Interested in Finance </th>
						<th>Interested in Accessories </th>
						<th>Interested in Insurance </th>
						<th>Interested in EW </th>
						<th>Buyer Type</th>
						<th>Buy Make/Model</th>
						<th>Budget From</th>
						<th>Budget To</th>
						<th>Exchange Make/Model</th>
						<th>Manufacturing Year</th>
						<th>Ownership</th>
						<th>KM</th>

						<th>Accidental Claim</th>



					<?php }
					if ($process_id == 8) { ?>
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
					<?php } ?>
					<th>Followup Pending</th>
					<th>Call Received from Showroom</th>
					<th>Fake Updation</th>
					<th>Service Feedback</th>

				</tr>

			</thead>
			<tbody>

				<?php
				$i = $offset1;

				if (!empty($select_lead)) {
					// var_dump($select_lead);
					foreach ($select_lead as $fetch) {
						$enq_id = $fetch->enq_id;
						$i++; ?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php
								if ($fetch->lead_source == '') {
									echo "Web  ";
									//.$fetch->enquiry_for;
								}
								/*	else if($fetch->lead_source=='Facebook')
						{
							echo $fetch->enquiry_for;
						}*/ else {
									echo $fetch->lead_source;
								}
								?></td>
							<td><?php echo $fetch->enquiry_for; ?></td>
							<td><b><?php echo $fetch->name; ?></b></td>
							<td><?php echo $fetch->contact_no; ?></td>
							<td><?php echo $fetch->alternate_contact_no; ?></td>
							<td><?php echo $fetch->address; ?></td>
							<td><?php echo $fetch->email; ?></td>
							<td><?php echo $fetch->lead_date; ?></td>
							<td><?php echo $fetch->lead_time; ?></td>
							<?php $query = "SELECT min(date) as first_call_date FROM `lead_followup` where leadid = '$enq_id'";
								  $query = $this->db->query($query);
							      $min_date = $query->result();?>
							<td><?php echo $min_date[0]->first_call_date; ?></td>							
							<td><?php echo $fetch->dms_enq_number; ?></td>
							<td><?php echo $fetch->followup_fuel_type; ?></td>
							<td><?php echo $fetch->followup_stock; ?></td>
							<td><?php echo $fetch->assistance; ?></td>
							<td><?php echo $fetch->days60_booking; ?></td>
							<td><?php echo $fetch->customer_location; ?></td>

							<td><?php echo $fetch->assign_to_cse_date; ?></td>
							<td><?php echo $fetch->assign_to_cse_time; ?></td>
							<?php if ($process_id == 6 || $process_id == 7 || $process_id == 8) { ?>

								<!--- CSE Information -->
								<?php if ($fetch->assign_to_cse == 0) { ?>

									<td><?php echo $fetch->csetl_fname . ' ' . $fetch->csetl_lname; ?></td>

								<?php } else { ?>
									<td><?php echo $fetch->cse_fname . ' ' . $fetch->cse_lname; ?></td>
								<?php } ?>
								<td><?php echo $fetch->cse_date; ?></td>
								<td><?php echo $fetch->cse_time; ?></td>
								<td><?php echo $fetch->csecontactibility; ?></td>
								<td><?php echo $fetch->csefeedback; ?></td>
								<td><?php echo $fetch->csenextAction; ?></td>
								<td><?php echo $fetch->cse_comment; ?></td>
								<td><?php echo $fetch->cse_nfd; ?></td>
								<td><?php echo $fetch->cse_nftime; ?></td>
								<td><?php
									$nfd = $fetch->cse_nfd;
									if ($nfd != '' && $nfd != '0000-00-00') {
										$today = strtotime(date('Y-m-d'));
										$nfd = strtotime($fetch->cse_nfd);
										$overdue = $today - $nfd;
										if ($nfd < $today) {
											echo ($overdue) / 60 / 60 / 24;
										}
									} ?></td>
								<td><?php echo $fetch->appointment_type; ?></td>
								<td><?php echo $fetch->appointment_date; ?></td>
								<td><?php echo $fetch->appointment_time; ?></td>

								<td><?php echo $fetch->appointment_status; ?></td>

								<td><?php echo $fetch->showroom_location; ?></td>

								<!--- dSE Information -->
								<td><?php echo $fetch->dsetl_fname . ' ' . $fetch->dsetl_lname; ?></td>
								<?php if ($fetch->assign_to_dse == 0) { ?>
									<td><?php echo $fetch->dsetl_fname . ' ' . $fetch->dsetl_lname; ?></td>
									<td><?php echo $fetch->assign_to_dse_tl_date; ?></td>
									<td><?php echo $fetch->assign_to_dse_tl_time; ?></td>
								<?php	} else {
									//if($fetch->dse_role ==4 || $fetch->dse_role ==5 || $fetch->dse_role ==15 || $fetch->dse_role ==16){ 
									//echo "snheal";
								?>
									<td><?php echo $fetch->dse_fname . ' ' . $fetch->dse_lname; ?></td>
									<td><?php echo $fetch->assign_to_dse_date; ?></td>
									<td><?php echo $fetch->assign_to_dse_time; ?></td>
									<?php //}else{ 
									?>

								<?php //}
								} ?>

								<td><?php echo $fetch->dse_date; ?></td>
								<td><?php echo $fetch->dse_time; ?></td>
								<td><?php echo $fetch->dsecontactibility; ?></td>

								<td><?php echo $fetch->dsefeedback; ?></td>
								<td><?php echo $fetch->dsenextAction; ?></td>
								<td><?php echo $fetch->dse_comment; ?></td>
								<td><?php echo $fetch->dse_nfd; ?></td>
								<td><?php echo $fetch->dse_nftime; ?></td>
								<td><?php
									$nfd = $fetch->dse_nfd;
									if ($nfd != '' && $nfd != '0000-00-00') {

										$today = strtotime(date('Y-m-d'));
										$nfd = strtotime($fetch->dse_nfd);
										$overdue = $today - $nfd;
										if ($nfd < $today) {
											echo ($overdue) / 60 / 60 / 24;
										}
									} ?></td>
								<?php if ($process_id == 6 || $process_id == 7) { ?>
									<td><?php echo $fetch->edms_booking_id; ?></td>
								<?php } ?>
							<?php }
							if ($process_id == 1 || $process_id == 4 || $process_id == 5) {
							?>
								<td><?php echo $fetch->cse_fname . ' ' . $fetch->cse_lname; ?></td>
								<td><?php echo $fetch->cse_date; ?></td>
								<td><?php echo $fetch->feedbackStatus; ?></td>
								<td><?php echo $fetch->nextAction; ?></td>
								<td><?php echo $fetch->eagerness; ?></td>

								<td><?php echo $fetch->cse_nfd; ?></td>
								<td><?php echo $fetch->cse_nftime; ?></td>
								<td><?php echo $fetch->cse_comment; ?></td>
							<?php
							}

							?>

							<?php if ($process_id == 6) { ?>

								<td><?php echo $fetch->interested_in_finance; ?></td>
								<td><?php echo $fetch->interested_in_accessories; ?></td>
								<td><?php echo $fetch->interested_in_insurance; ?></td>
								<td><?php echo $fetch->interested_in_ew; ?></td>
								<td><?php echo $fetch->buyer_type; ?></td>
								<td><?php echo $fetch->new_model_name . ' ' . $fetch->variant_name; ?></td>

							<?php }
							if ($fetch->process == 'Finance') {
							?>

								<td><?php echo $fetch->model_name; ?></td>
								<td><?php echo $fetch->reg_no; ?></td>
								<td><?php echo $fetch->bank_name; ?></td>

								<td><?php echo $fetch->loan_type; ?></td>

								<td><?php echo $fetch->roi; ?></td>
								<td><?php echo $fetch->los_no; ?></td>
								<td><?php echo $fetch->tenure; ?></td>
								<td><?php echo $fetch->loanamount; ?></td>
								<td><?php echo $fetch->dealer; ?></td>
								<td><?php echo $fetch->executive_name; ?></td>
								<td><?php echo $fetch->pick_up_date; ?></td>
								<td><?php echo $fetch->file_login_date; ?></td>
								<td><?php echo $fetch->login_status_name; ?></td>
								<td><?php echo $fetch->approved_date; ?></td>
								<td><?php echo $fetch->disburse_date; ?></td>
								<td><?php echo $fetch->disburse_amount; ?></td>
								<td><?php echo $fetch->process_fee; ?></td>
								<td><?php echo $fetch->emi; ?></td>
							<?php }
							if ($process_id == 5) { ?>
								<!--<td><?php echo $fetch->cse_fname . ' ' . $fetch->cse_lname; ?></td>
                   	<td><?php echo $fetch->feedbackStatus; ?></td>
					<td><?php echo $fetch->nextAction; ?></td>
					<td><?php echo $fetch->eagerness; ?></td>
					
					<td><?php echo $fetch->cse_nfd; ?></td>
					<td><?php echo $fetch->cse_nftime; ?></td>
					<td><?php echo $fetch->cse_comment; ?></td>-->
								<td><?php echo $fetch->model_name; ?></td>
								<td><?php echo $fetch->reg_no; ?></td>
								<td><?php echo $fetch->accessoires_list; ?></td>
								<td><?php echo $fetch->assessories_price; ?></td>
							<?php }
							if ($process_id == 4) { ?>
								<!--<td><?php echo $fetch->cse_fname . ' ' . $fetch->cse_lname; ?></td>
                   	<td><?php echo $fetch->feedbackStatus; ?></td>
					<td><?php echo $fetch->nextAction; ?></td>
					<td><?php echo $fetch->eagerness; ?></td>
					<td><?php echo $fetch->cse_nfd; ?></td>
					<td><?php echo $fetch->cse_nftime; ?></td>
					<td><?php echo $fetch->cse_comment; ?></td>-->
								<td><?php echo $fetch->model_name; ?></td>
								<td><?php echo $fetch->reg_no; ?></td>
								<td><?php echo $fetch->km; ?></td>
								<td><?php echo $fetch->service_type; ?></td>
								<td><?php echo $fetch->pickup_required; ?></td>
								<td><?php echo $fetch->pick_up_date; ?></td>

							<?php }
							if ($process_id == 7) { ?>
								<td><?php echo $fetch->interested_in_finance; ?></td>
								<td><?php echo $fetch->interested_in_accessories; ?></td>
								<td><?php echo $fetch->interested_in_insurance; ?></td>
								<td><?php echo $fetch->interested_in_ew; ?></td>
								<td><?php echo $fetch->buyer_type; ?></td>
								<td><?php echo $fetch->buy_make_name . ' ' . $fetch->buy_model_name; ?></td>
								<td><?php echo $fetch->budget_from; ?></td>
								<td><?php echo $fetch->budget_to; ?></td>
								<td><?php echo $fetch->make_name . ' ' . $fetch->old_model_name; ?></td>
								<td><?php echo $fetch->manf_year; ?></td>
								<td><?php echo $fetch->ownership; ?></td>
								<td><?php echo $fetch->km; ?></td>

								<td><?php echo $fetch->accidental_claim; ?></td>
							<?php }
							if ($process_id == 8) { ?>
								<td><?php echo $fetch->make_name . ' ' . $fetch->old_model_name; ?></td>
								<td><?php echo $fetch->manf_year; ?></td>
								<td><?php echo $fetch->ownership; ?></td>
								<td><?php echo $fetch->km; ?></td>
								<td><?php echo $fetch->accidental_claim; ?></td>
								<td><?php echo $fetch->evaluation_within_days; ?></td>
								<td><?php echo $fetch->fuel_type; ?></td>
								<td><?php echo $fetch->color; ?></td>
								<td><?php echo $fetch->reg_no; ?></td>
								<td><?php echo $fetch->quotated_price; ?></td>
								<td><?php echo $fetch->expected_price; ?></td>

							<?php } ?>
							<td><?php echo $fetch->followup_pending; ?></td>
							<td><?php echo $fetch->call_received; ?></td>
							<td><?php echo $fetch->fake_updation; ?></td>
							<td><?php echo $fetch->service_feedback; ?></td>
						</tr>
				<?php }
				} ?>

			</tbody>
		</table>

		<!--</div>
-->
	</div>
	<div class="col-md-12" style="margin-top: 20px;">
		<div class="col-md-6" style="font-size: 14px">

			<?php
			$lead_count = count($select_lead);
			// echo $count_total;
			if (isset($count_lead_dse_lc)) {
				$count_lead_dse_lc = $count_lead_dse_lc[0]->count_lead_dse_lc;
			}
			if (isset($count_lead_dse)) {
				$count_lead_dse = $count_lead_dse[0]->count_lead_dse;
			}
			$total_record = 0;
			foreach ($count_lead as $row) {
				$total_record = $total_record + $row->lead_count;
			}
			//$lead_cou = $count_lead_dse_lc+$count_lead_dse;
			echo 'Total Records :';
			echo '<b>' . $total_record . '</b>'; ?>&nbsp;&nbsp;
			<?php echo 'Total Pages :';
			$pages = $total_record / 100;
			echo '<b>' . $total_page = ceil($pages) . '</b>';
			$total_page = intval($total_page);
			?>
		</div>
		<div class="col-md-6  form-group">
			<?php
			$campaign_name = str_replace('#', '%23', $campaign_name);
			$campaign_name = str_replace(' ', '+', $campaign_name);

			if ($c < 100) {
				$last = $page - 2;
				if ($last != -2) {
					echo "<a class='col-md-push-1 col-md-2 btn btn-info'  href=" . site_url() . 'new_tracker/tracker_dse_filter/page/' . $last . '?campaign_name=' . $campaign_name . '&nextaction=' . $nextaction . '&feedback=' . $feedback . '&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">
<i class='fa fa-angle-left'></i>Previous</a>";
					echo "<a class='col-md-pull-3 col-md-1  btn btn-info'  href=" . site_url() . 'new_tracker/tracker_dse_filter?campaign_name=' . $campaign_name . '&nextaction=' . $nextaction . '&feedback=' . $feedback . '&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">First  
<i class='fa fa-angle-right'></i></a>";
					$last1 = $total_page - 2;
					echo "<a class=' col-md-push-5 col-md-1  btn btn-info' href=" . site_url() . 'new_tracker/tracker_dse_filter/page/' . $last1 . '?campaign_name=' . $campaign_name . '&nextaction=' . $nextaction . '&feedback=' . $feedback . '&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">Last  
<i class='fa fa-angle-right'></i></a>";
				}
			} else if ($page == 0) {

				echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px;' href=" . site_url() . 'new_tracker/tracker_dse_filter/page/' . $page . '?campaign_name=' . $campaign_name . '&nextaction=' . $nextaction . '&feedback=' . $feedback . '&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">Next  
<i class='fa fa-angle-right'></i></a>";
				echo "<a class=' col-md-1  btn btn-info'  href=" . site_url() . "new_tracker/leads>First  
<i class='fa fa-angle-right'></i></a>";
				$last1 = $total_page - 2;
				echo "<a class=' col-md-push-6 col-md-1  btn btn-info' href=" . site_url() . 'new_tracker/tracker_dse_filter/page/' . $last1 . '?campaign_name=' . $campaign_name . '&nextaction=' . $nextaction . '&feedback=' . $feedback . '&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">Last  
<i class='fa fa-angle-right'></i></a>";
			} else {

				$last = $page - 2;
				echo " <a class='col-md-push-2 col-md-2 btn btn-info'  href=" . site_url() . 'new_tracker/tracker_dse_filter/page/' . $last . '?campaign_name=' . $campaign_name . '&nextaction=' . $nextaction . '&feedback=' . $feedback . '&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">
<i class='fa fa-angle-left'></i>   Previous   </a> ";
				echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px ;' href=" . site_url() . 'new_tracker/tracker_dse_filter/page/' . $page . '?campaign_name=' . $campaign_name . '&nextaction=' . $nextaction . '&feedback=' . $feedback . '&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">Next  
<i class='fa fa-angle-right'></i></a>";

				echo "<a class='col-md-pull-3 col-md-1  btn btn-info' href=" . site_url() . 'new_tracker/tracker_dse_filter?campaign_name=' . $campaign_name . '&nextaction=' . $nextaction . '&feedback=' . $feedback . '&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">First  
<i class='fa fa-angle-right'></i></a>";
				$last1 = $total_page - 2;
				echo "<a class='  col-md-push-6 col-md-1  btn btn-info'  href=" . site_url() . 'new_tracker/tracker_dse_filter/page/' . $last1 . '?campaign_name=' . $campaign_name . '&nextaction=' . $nextaction . '&feedback=' . $feedback . '&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">Last  
<i class='fa fa-angle-right'></i></a>";
			}

			$page1 = $page + 1;
			?>

			<label class="col-md-pull-1 col-md-2  control-label" style="margin-top: 7px;">Page No</label>
			<input class="col-md-pull-1  col-md-1" type="text" value="<?php echo $page1 ?>" name="pageNo" id="pageNo" style="width: 56px;border-radius:4px;height: 35px">
			<input class="col-md-pull-1  col-md-1  btn btn-danger " style="margin-left: 10px;" type="submit" value="Go" onclick="go_on_page();">
			<script>
				function go_on_page() {
					var pageno = document.getElementById("pageNo").value;
					var total_page = '<?php echo $total_page; ?>';
					if (pageno > total_page) {
						alert('Please Enter Page No. Less Than Total No. of Pages');
						return false;
					} else {
						//	alert(pageno);
						var pageno1 = pageno - 2;
						var campaign_name = '<?php echo $campaign_name; ?>';
						//alert (campaign_name);
						var nextaction = '<?php echo $nextaction; ?>';
						var feedback = '<?php echo $feedback; ?>';
						var fromdate = '<?php echo $fromdate; ?>';
						var todate = '<?php echo $todate; ?>';
						var date_type = '<?php echo $date_type; ?>';

						window.location = "<?php echo site_url(); ?>new_tracker/tracker_dse_filter/page/" + pageno1 + "?campaign_name=" + campaign_name + "&nextaction=" + nextaction + "&feedback=" + feedback + "&fromdate=" + fromdate + "&todate=" + todate + "&date_type=" + date_type;

					}
				}
			</script>

		</div>