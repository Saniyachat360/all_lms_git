<script>
	$(document).ready(function() {
		var table = $('#example').DataTable({
			searching: false, 
			scrollY : "400px",
			scrollX : true,
			scrollCollapse : true,

			fixedColumns : {
				leftColumns : 0,
				rightColumns : 0
			}
		});
	});
</script>
<div class="control-group" id="campaign_loader" style="margin:0% 20% 1% 32%"></div>

<div class="col-md-12">
		
		<div class="table-responsive" >
		<table id="example"  class="table " style="width:auto;" cellspacing="0">
			<thead>
				<tr>
					<th>Sr No.</th>
					
					<th>Dse Name</th>
					<th>Pending New</th>
					<th>Pending Followup</th>
					<th>Booked From Autovista</th>
					<th>Home Visit</th>
					
					<th>Showroom Visit</th>
					
					<th>Evaluation Allotted</th>
					
					<th>Test Drive</th>
					<th>Follow up</th>
					<th>Undecided</th>
					<th>Deal</th>
					<th>Not Interested</th>
					<!--<th>Already Booked From Us</th>-->
					<th>Lost to Co-dealer</th>
					<th>Lost to Competitor Brand</th>
					<th>Color and Model Availability</th>
					<th>Budget Issue</th>
					<th>Plan cancelled</th>
				</tr>
			</thead>
<?php

//print_r($dsename);
	$con=count($dsename);
	if($con < 1){
		
	}
	else{
				$i=0;
				foreach($dsename as $fetch)
				{
				$i++;
				$dse_id=$fetch['dse_id'];
				//echo $fromdate;
				//echo $todate;
				?>
			<tbody>
			
				<td><?php echo $i; ?></td>
				<td><?php echo $fetch['fname'].' '.$fetch['lname']; ?></td>
				<td><a href="<?php echo site_url('Dsewise_dashboard_download_tracker/leads/?dse_id='.$dse_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=pending_new');?>"><?php echo $fetch['pending_new']; ?></a></td>
				<td><a href="<?php echo site_url('Dsewise_dashboard_download_tracker/leads/?dse_id='.$dse_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=pending_followup');?>"><?php echo $fetch['pending_followup']; ?></a></td>
				<td><a href="<?php echo site_url('Dsewise_dashboard_download_tracker/leads/?dse_id='.$dse_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=booked_count');?>"><?php echo $fetch['booked_count']; ?></a></td>
				<td><a href="<?php echo site_url('Dsewise_dashboard_download_tracker/leads/?dse_id='.$dse_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=home_visit_count');?>"><?php echo $fetch['home_visit_count']; ?></a></td>
				<td><a href="<?php echo site_url('Dsewise_dashboard_download_tracker/leads/?dse_id='.$dse_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=showroom_visit_count');?>"><?php echo $fetch['showroom_visit_count']; ?></a></td>
				<td><a href="<?php echo site_url('Dsewise_dashboard_download_tracker/leads/?dse_id='.$dse_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=evaluation_count');?>"><?php echo $fetch['evaluation_count']; ?></a></td>
				<td><a href="<?php echo site_url('Dsewise_dashboard_download_tracker/leads/?dse_id='.$dse_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=test_drive_count');?>"><?php echo $fetch['test_drive_count']; ?></a></td>
				<td><a href="<?php echo site_url('Dsewise_dashboard_download_tracker/leads/?dse_id='.$dse_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=follow_up_count');?>"><?php echo $fetch['follow_up_count']; ?></a></td>
				<td><a href="<?php echo site_url('Dsewise_dashboard_download_tracker/leads/?dse_id='.$dse_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=undecided_count');?>"><?php echo $fetch['undecided_count']; ?></a></td>
				<td><a href="<?php echo site_url('Dsewise_dashboard_download_tracker/leads/?dse_id='.$dse_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=deal_count');?>"><?php echo $fetch['deal_count']; ?></a></td>
				<td><a href="<?php echo site_url('Dsewise_dashboard_download_tracker/leads/?dse_id='.$dse_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=not_interested_count');?>"><?php echo $fetch['not_interested_count']; ?></a></td>
				<!--<td><a href="<?php echo site_url('Dsewise_dashboard_download_tracker/leads/?dse_id='.$dse_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=already_booked_with_autovista_count');?>"><?php echo $fetch['already_booked_with_autovista_count']; ?></a></td>-->
				<td><a href="<?php echo site_url('Dsewise_dashboard_download_tracker/leads/?dse_id='.$dse_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=lost_to_co_dealer_count');?>"><?php echo $fetch['lost_to_co_dealer_count']; ?></a></td>
				<td><a href="<?php echo site_url('Dsewise_dashboard_download_tracker/leads/?dse_id='.$dse_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=lost_to_competition_brand_count');?>"><?php echo $fetch['lost_to_competition_brand_count']; ?></a></td>
				<td><a href="<?php echo site_url('Dsewise_dashboard_download_tracker/leads/?dse_id='.$dse_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=color_model_availability_count');?>"><?php echo $fetch['color_model_availability_count']; ?></a></td>
				<td><a href="<?php echo site_url('Dsewise_dashboard_download_tracker/leads/?dse_id='.$dse_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=low_budget_count');?>"><?php echo $fetch['low_budget_count']; ?></a></td>
				<td><a href="<?php echo site_url('Dsewise_dashboard_download_tracker/leads/?dse_id='.$dse_id.'&fromdate='.$fromdate.'&todate='.$todate.'&source=plan_cancelled_count');?>"><?php echo $fetch['plan_cancelled_count']; ?></a></td>
				
			</tbody>
<?php } 
 }?>
		</table>
		</div>
	</div>
	