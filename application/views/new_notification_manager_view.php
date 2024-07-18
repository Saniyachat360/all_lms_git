<?php
		if(isset($select_leads)){if(count($select_leads)>0){
			$unassigned_leads_count=0;
			$new_leads_count=0;
			$call_today_leads_count=0;
			$pending_new_leads_count=0;
			$pending_followup_leads_count=0;
			$home_visit_count=0;
			$test_drive_count=0;
			$showroom_visit_count=0;
			$evaluation_count=0;
			$escalation_level_1_count=0;
			$escalation_level_2_count=0;
			$escalation_level_3_count=0;
			 foreach ($location_data as $row) {
				 
			 if($row['location_name']=='Pune Call Center'){
					$unassigned_leads_count=$row['unassigned_leads']; 
				 }else{
					 $unassigned_leads_count=$unassigned_leads_count+$row['unassigned_leads'];
				 }
			$new_leads_count=$new_leads_count+$row['new_leads'];
			$call_today_leads_count=$call_today_leads_count+$row['call_today'];
			$pending_new_leads_count=$pending_new_leads_count+$row['pending_new_leads'];
			$pending_followup_leads_count=$pending_followup_leads_count+$row['pending_followup'];
			$home_visit_count=$home_visit_count+$row['home_visit_count'];
			$test_drive_count=$test_drive_count+$row['test_drive_count'];
			$showroom_visit_count=$showroom_visit_count+$row['showroom_visit_count'];
			$evaluation_count=$evaluation_count+$row['evaluation_count'];
			$escalation_level_1_count=$escalation_level_1_count+$row['escalation_level_1'];
			$escalation_level_2_count=$escalation_level_2_count+$row['escalation_level_2'];
			$escalation_level_3_count=$escalation_level_3_count+$row['escalation_level_3'];
			$id[]=$row['id'];
			$role[]=$row['role'];
			}
		//	print_r($id);
			/*$executive_array=array("3","4","8","10","12","14");
			if(in_array($_SESSION['role'],$executive_array)){*/ ?>
			<script>
			function get_url(){
				var role=new Array;
				var id=new Array;
				<?php  foreach ($location_data as $row) { ?>
					role.push(<?php echo $row['role'] ;?>);
					id.push(<?php echo $row['id'] ;?>);
					
				<?php } ?>
				var myJSON = JSON.stringify(id);
				var myJSON1 = JSON.stringify(role);
				
			window.open('<?php echo site_url();?>unassign_leads/leads/?id_array='+myJSON+'&role_array='+myJSON1);
					
			}
		</script>
	<div class="col-md-12">
				<table class="table table-bordered datatable" id="table-4">
				<thead>
					<tr>
							<th><b>Sr No.</b></th>
							<th><b>Leads</b></th>

							<th><b>Count
								</b>
							</th>
						
					</tr>
				</thead>
				<tbody>
					
					<tr>
						<td>1</td>
						<td>Unassigned Leads</td>
					
						<td><?php echo $unassigned_leads_count; ?>
							
						</td>
						
					</tr>
					
					<tr>
						<td>2</td>
						<td>New Leads</td>
		
						
		
						<td><?php echo $new_leads_count; ?>
							
						</td>
		
						
					</tr>
					<tr>
						<td>3</td>
						<td>Call Today Leads</td>
		
						
		
						<td><?php echo $call_today_leads_count; ?></td>
						
		
					
					</tr>
					<tr>
						<td>4</td>
						<td>Pending New Leads</td>
		
						
		
						<td><?php echo $pending_new_leads_count; ?></td>
						
		
					
					</tr>
					<tr>
						<td>5</td>
						<td>Pending Followup Leads</td>
		
					
		
						<td><?php echo $pending_followup_leads_count; ?></td>
				
					</tr>
						<?php if($_SESSION['process_id']==6 ||$_SESSION['process_id']==7 ||$_SESSION['process_id']==8)
					{
						if($_SESSION['process_id']!=8 ){?>
					<tr>
						<td>6</td>
						<td>Home Visits For Today </td>
		
						
		
						<td><?php echo $home_visit_count ?></td>
						
		
						
					</tr>
					<tr>
						<td>7</td>
						<td>Showroom Visits For Today </td>
			<td><?php echo $showroom_visit_count ?></td>
					
					</tr>
					<tr>
						<td>8</td>
						<td>Test Drives For Today </td>
		
						<td><?php echo $test_drive_count ?></td>
						
					</tr>
						<?php } ?>
					<tr>
						<td>9</td>
						<td>Evaluations For Today </td>
			<td><?php echo $evaluation_count ?></td>
						
		
					</tr>
		
					<tr>
						<td>10</td>
						<td>Escalation Level 1</td>		
						
						<td><?php echo $escalation_level_1_count; ?>
						</td>		
						
					</tr>
					<tr>
						<td>11</td>
						<td>Escalation Level 2</td>		
						<td><?php echo $escalation_level_2_count; ?>
						</td>		
						
					</tr>
					<tr>
						<td>12</td>
						<td>Escalation Level 3</td>		
						
						<td><?php echo $escalation_level_3_count ?>
						</td>		
						
					</tr>
					<?php } ?>
				</tbody>
			</table>
			</div>
			<?php } ?>
<?php //}
} else { 
}
//}?>
	