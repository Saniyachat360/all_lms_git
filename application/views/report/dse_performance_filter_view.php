<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
 <div class="pull-right">
<a href="#" class="pull-right" onClick ="$('#xls_data').tableExport({type:'excel',escape:'false'});"><i class="btn btn-defult entypo-download"></i></a>
      </div></div>
		<?php
if(isset($select_leads)){
	if(count($select_leads)>0){
		
			?>
	<div class="col-md-12" style="overflow-x:scroll">
				<table class="table table-bordered datatable"  id="xls_data" >
				<thead>
					<tr>
						<th>Location</th>
				<th>DSE Name</th>
				<th>Lead Assigned</th>
				<th>New</th>
				<th>Pending New</th>
				<th>Pending Followup</th>
				<th>Live</th>
				<th>Total Lost</th>
				<th>Lost to co-dealer</th>
				<th>Lost other</th>
				<th>Booked</th>
				<th>Conversion%</th>
				<th>Escalation Level 1</th>
				<th>Escalation Resolved</th>
				<th>Escalation Level 2</th>
				<th>Escalation Resolved</th>
				<th>Escalation Level 3</th>
				<th>Escalation Resolved</th>
				</tr>
				
				</thead>
					<tbody>
					
					
			<?php foreach ($select_leads as $row) {?>
				
			

				<tr>
					<td><?php
			
				 echo $row['location'];?></td>
				<td><?php
				$dse_id=$row['dse_id'];
				 echo $row['dse_fname'].' '.$row['dse_lname'];?></td>
				<td><a target='_blank' href="<?php echo site_url('op_dse_performance_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=assign_leads');?>">
					
					<?php echo $assign_leads=$row['assign_lead'];?> </a></td>
				<td><a target='_blank' href="<?php echo site_url('op_dse_performance_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=new_leads');?>">
					<?php echo $row['new_leads'];?></a></td>
				<td><a target='_blank' href="<?php echo site_url('op_dse_performance_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=pending_new_leads');?>">
					<?php echo $row['pending_new_leads'];?></a></td>
					<td><a target='_blank' href="<?php echo site_url('op_dse_performance_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=pending_followup_leads');?>">
					<?php echo $row['pending_followup_leads'];?></a></td>
					<td><a target='_blank' href="<?php echo site_url('op_dse_performance_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=live_leads');?>">
					
						<?php echo $row['live_leads'];?></a></td>
					<td><a target='_blank' href="<?php echo site_url('op_dse_performance_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=lost_leads');?>">
					
						<?php echo $row['total_lost_leads'];?></a></td>
					<td><a target='_blank' href="<?php echo site_url('op_dse_performance_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=lost_to_codealer_leads');?>">
					
						<?php echo $row['co_dealer_lost_leads'];?></a></td>
					<td><a target='_blank' href="<?php echo site_url('op_dse_performance_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=lost_to_other_leads');?>">
					
						<?php echo $row['other_lost_leads'];?></a></td>
				<td>
					<a target='_blank' href="<?php echo site_url('op_dse_performance_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=booked_leads');?>">
					<?php echo $booked_leads=$row['booked_leads'];?></a></td>
				<td><?php if($assign_leads>0 && $booked_leads>0){
					$conversion=($booked_leads/$assign_leads)*100;
					echo $conversion.'%';
				}else{
					echo '0%';
				}?></td>
				<td><a target='_blank' href="<?php echo site_url('op_dse_performance_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=esc_level1_leads');?>">
					<?php echo $row['esc_level1_leads'];?></a>
					</td>
				<td><a target='_blank' href="<?php echo site_url('op_dse_performance_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=esc_level1_resolved_leads');?>">
					<?php echo $row['esc_level1_resolved_leads'];?></a></td>
				<td><a target='_blank' href="<?php echo site_url('op_dse_performance_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=esc_level2_leads');?>">
					<?php echo $row['esc_level2_leads'];?></a></td>
				<td><a target='_blank' href="<?php echo site_url('op_dse_performance_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=esc_level2_resolved_leads');?>">
					<?php echo $row['esc_level2_resolved_leads'];?></a></td>
				<td><a target='_blank' href="<?php echo site_url('op_dse_performance_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=esc_level3_leads');?>">
					<?php echo $row['esc_level3_leads'];?></a></td>
				<td><a target='_blank' href="<?php echo site_url('op_dse_performance_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=esc_level3_resolved_leads');?>">
					<?php echo $row['esc_level3_resolved_leads'];?></a></td>
			</tr>
			<?php } ?>
	
				</tbody>
				
			</table>
			</div>
<?php }else {
	echo "<center>No Leads Found.</center>"; 
}}?>