	<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
		<div class="pull-right">
<a href="#" class="pull-right" onClick ="$('#xls_data').tableExport({type:'excel',escape:'false'});"><i class="btn btn-defult entypo-download"></i></a>
      </div></div>
		<?php

	if(!empty($select_leads)){
	
			?>
	<div class="col-md-12" style="overflow-x:scroll">
				<table class="table table-bordered datatable"  id="xls_data" >
				<thead>
					
					<tr>
					<th >Location</th>	
				<th >DSE Name</th>
				<th >Total Called</th>
				<th >Total Connected</th>
				<th >Not Connected</th>
				<th >Connected%</th>
				
				<th >Lead Assigned</th>
				<th >Booked</th>
			<th >Conversion%</th>
			
			<th >Home Visit Allotted</th>
			<th >Home Visit Conducted</th>
			<th >Home Visit Not Conducted</th>
				<th >Showroom Visit Allotted</th>
				<th >Showroom Visit Conducted</th>		
				<th >Showroom Visit Not Conducted</th>						
				<th >Test Drive Allotted</th>
				<th >Test Drive Conducted</th>
				<th >Test Drive Not Conducted</th>
				<th >Evaluation Allotted</th>
				<th >Evaluation Conducted</th>
				<th >Evaluation Not Conducted</th>
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
				<td><?php echo $total_call=$row['total_call'];?> </td>
				<td><?php echo $connected=$row['total_connected'];?></td>
				<td><?php echo $row['total_not_connected'];?></td>
				<td><?php if($connected!=0 && $total_call!=0){
					$total_connect=($connected/$total_call)*100; 
								echo  round($total_connect, 2).'%';
				}else{
					echo '0%';
				} ?></td>
			<td><a target='_blank' href="<?php echo site_url('op_dse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=assign_leads');?>">
					
					<?php echo $assigned=$row['lead_assigned'];?> </a></td>
				<td><a target='_blank' href="<?php echo site_url('op_dse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=total_booked_leads');?>">
				
					<?php echo $booked=$row['booked'];?>
					</a></td>
			<td><?php if($booked>0 && $assigned>0){
				$total_book=($booked/$assigned)*100; 
					echo  round($total_book, 2).'%';
			}else{
					echo '0%';
				}?></td>
				<td><a target='_blank' href="<?php echo site_url('op_dse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=home_visit_leads');?>">
				
					<?php echo $row['home_visit'];?></a></td>
				<th><a target='_blank' href="<?php echo site_url('op_dse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=home_visit_conducted_leads');?>">
				
					<?php echo $row['home_visit_conducted'];?></a></th>
				<th><a target='_blank' href="<?php echo site_url('op_dse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=home_visit_not_conducted_leads');?>">
				<?php echo $row['home_visit_not_conducted'];?></a></th>
				<td><a target='_blank' href="<?php echo site_url('op_dse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=showroom_visit_leads');?>">
				
					<?php echo $row['showroom_visit'];?></a></td>
				<th><a target='_blank' href="<?php echo site_url('op_dse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=showroom_visit_conducted_leads');?>">
				
					<?php echo $row['showroom_visit_conducted'];?></a></th>
				<th><a target='_blank' href="<?php echo site_url('op_dse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=showroom_visit_not_conducted_leads');?>">
				
					<?php echo $row['showroom_visit_not_conducted'];?></a></th>
				<td><a target='_blank' href="<?php echo site_url('op_dse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=test_drive_leads');?>">
				
					<?php echo $row['test_drive'];?></a></td>
				<th><a target='_blank' href="<?php echo site_url('op_dse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=test_drive_conducted_leads');?>">
				<?php echo $row['test_drive_conducted'];?></a></th>
				<th><a target='_blank' href="<?php echo site_url('op_dse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=test_drive_not_conducted_leads');?>">
				<?php echo $row['test_drive_not_conducted'];?></a></th>
				<td><a target='_blank' href="<?php echo site_url('op_dse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=evaluation_allotted_leads');?>">
				<?php echo $row['evaluation_allotted'];?></a></td>
					<th><a target='_blank' href="<?php echo site_url('op_dse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=evaluation_conducted_leads');?>">
				<?php echo $row['evaluation_conducted'];?></a></th>
				<th><a target='_blank' href="<?php echo site_url('op_dse_productivity_tracker/leads/?from_date='.$from_date.'&to_date='.$to_date.'&dse_id='.$dse_id.'&source=evaluation_not_conducted_leads');?>">
				<?php echo $row['evaluation_not_conducted'];?></a></th>
				
				<!--<td><?php echo $row['evaluation_allotted'];?></td>
				<td><?php echo $row['test_drive'];?></td>
				<td><?php echo $row['home_visit'];?></td>
				<td><?php echo $row['showroom_visit'];?></td>-->
				
			</tr>
			<?php } ?>
	
				</tbody>
				
			</table>
			</div>
<?php }else {
	
	echo "<center>No Leads Found.</center>";
}
	