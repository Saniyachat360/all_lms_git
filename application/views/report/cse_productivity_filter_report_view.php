

<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
		<div class= "col-md-12">
<a href="#" class="pull-right" onClick ="$('#xls_data').tableExport({type:'excel',escape:'false'});"><i class="btn btn-defult entypo-download"></i></a>
      </div></div><?php

	if(count($select_leads)>0){
		
			?>
	<div class="col-md-12" style="overflow-x:scroll">
				<table class="table table-bordered datatable"  id="xls_data">
			
					<tr>
				<td>CSE Name</td>
				<td >Total Called</td>
				<td >Total Connected</td>
				<td >Not Connected</td>
				<td >Connected%</td>
				
				<td >Lead Assigned</td>
				<td >Sent  to Showroom</td>
				<td >Home Visit Allotted</td>
				<td >Home Visit Conducted</td>
				<td >Home Visit Not Conducted</td>
				<td >Showroom Visit Allotted</td>
				<td >Showroom Visit Conducted</td>
				<td >Showroom Visit Not Conducted</td>				
				<td >Test Drive Allotted</td>
				<td >Test Drive Conducted</td>
				<td >Test Drive Not Conducted</td>
				<td >Evaluation Allotted</td>
				<td >Evaluation Conducted</td>
				<td >Evaluation Not Conducted</td>
				
				
			
				</tr>
				
				
					
			<?php foreach ($select_leads as $row) {?>
				
			
			
				<tr>
				<td><?php 
				$cse_id=$row['cse_id'];
				echo $row['cse_fname'].' '.$row['cse_lname'];?></td>
				<td><?php echo $total_call=$row['total_call'];?> </td>
				<td><?php echo $connected=$row['total_connected'];?></td>
				<td><?php echo $row['total_not_connected'];?></td>
				
				<td><?php if($connected!=0 && $total_call!=0){
					$total_connect=($connected/$total_call)*100; 
								echo  round($total_connect, 2).'%';
				}else{
					echo '0%';
				} ?></td>
				<!--<td></td>
				<td></td>-->
				
				<td>
					<a target='_blank' href="<?php echo site_url('op_cse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&cse_id='.$cse_id.'&source=lead_assigned');?>">
						<?php echo $row['lead_assigned'];?>
					</a>
				</td>
				<td>	<a target='_blank' href="<?php echo site_url('op_cse_performance_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&cse_id='.$cse_id.'&source=sent_to_showroom_leads');?>">
			<?php echo $row['sent_to_showroom_leads']; ?>
			</a></td>
				<td>
					<a target='_blank' href="<?php echo site_url('op_cse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&cse_id='.$cse_id.'&source=home_visit');?>">
						<?php echo $row['home_visit'];?>
					</a>
				</td>
				
				<td>
					<a target='_blank' href="<?php echo site_url('op_cse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&cse_id='.$cse_id.'&source=home_visit_conducted');?>">
						<?php echo $row['home_visit_conducted'];?>
					</a>
				</td>
				
				<td>
					<a target='_blank' href="<?php echo site_url('op_cse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&cse_id='.$cse_id.'&source=home_visit_not_conducted');?>">
						<?php echo $row['home_visit_not_conducted'];?>
					</a>
				</td>
				
				<td>					
					<a target='_blank' href="<?php echo site_url('op_cse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&cse_id='.$cse_id.'&source=showroom_visit');?>">
						<?php echo $row['showroom_visit'];?>
					</a>
				</td>
				
				<td>
					<a target='_blank' href="<?php echo site_url('op_cse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&cse_id='.$cse_id.'&source=showroom_visit_conducted');?>">
						<?php echo $row['showroom_visit_conducted'];?>
					</a>
				</td>
				
				<td>
					<a target='_blank' href="<?php echo site_url('op_cse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&cse_id='.$cse_id.'&source=showroom_visit_not_conducted');?>">
						<?php echo $row['showroom_visit_not_conducted'];?>
					</a>
				</td>
				
				<td>
					<a target='_blank' href="<?php echo site_url('op_cse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&cse_id='.$cse_id.'&source=test_drive');?>">
						<?php echo $row['test_drive'];?>
					</a>
				</td>
				
				<td>
					<a target='_blank' href="<?php echo site_url('op_cse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&cse_id='.$cse_id.'&source=test_drive_conducted');?>">
						<?php echo $row['test_drive_conducted'];?>
					</a>
				</td>
				
				<td>
					<a target='_blank' href="<?php echo site_url('op_cse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&cse_id='.$cse_id.'&source=test_drive_not_conducted');?>">
						<?php echo $row['test_drive_not_conducted'];?>
					</a>
				</td>
				
				<td>
					<a target='_blank' href="<?php echo site_url('op_cse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&cse_id='.$cse_id.'&source=evaluation_allotted');?>">
						<?php echo $row['evaluation_allotted'];?>
					</a>
				</td>
				
				<td>
					<a target='_blank' href="<?php echo site_url('op_cse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&cse_id='.$cse_id.'&source=evaluation_conducted');?>">
						<?php echo $row['evaluation_conducted'];?>
					</a>
				</td>
				
				<td>
					<a target='_blank' href="<?php echo site_url('op_cse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&cse_id='.$cse_id.'&source=evaluation_not_conducted');?>">
						<?php echo $row['evaluation_not_conducted'];?>
					<a>
				</td>
				
				
			
			</tr>
			<?php } ?>
	
			
				
			</table>
			</div>
<?php }else {
	echo "<center>No Leads Found.</center>";
}
	?>