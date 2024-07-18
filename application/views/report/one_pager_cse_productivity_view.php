	<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
		<div class="pull-right">
<a href="#" class="pull-right" onClick ="$('#xls_data').tableExport({type:'excel',escape:'false'});"><i class="btn btn-defult entypo-download"></i></a>
      </div></div><?php

	if(count($select_leads)>0){
		
			?>
	<div class="col-md-12" style="overflow-x:scroll">
				<table class="table table-bordered datatable"  id="xls_data">
				<thead>
					
					<tr>
				<th rowspan="2">CSE Name</th>
				<th rowspan="2">Total Called</th>
				<th rowspan="2">Total Connected</th>
				<th rowspan="2">Not Connected</th>
				<th rowspan="2">Connected%</th>
				
				<th rowspan="2">Lead Assigned</th>
				<th colspan="3">Home Visit</th>
				<th colspan="3">Showroom Visit</th>				
				<th colspan="3">Test Drive</th>
				<th colspan="3">Evaluation</th>
				
				
			
				</tr>
				<tr>
				
				<th>Allotted</th>
				<th> Conducted</th>
					<th>Not Conducted</th>
					<th>Allotted</th>
				<th> Conducted</th>
					<th>Not Conducted</th>
					<th>Allotted</th>
				<th> Conducted</th>
					<th>Not Conducted</th>
					<th>Allotted</th>
				<th> Conducted</th>
					<th>Not Conducted</th>
				
	
				</tr>
				</thead>
					<tbody>
					
					
			<?php foreach ($select_leads as $row) {?>
				
			
			
				<tr>
				<td><?php echo $row['cse_fname'].' '.$row['cse_lname'];?></td>
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
				<td><?php echo $row['lead_assigned'];?></td>
				
				
				
				
				<td><?php echo $row['home_visit'];?></td>
				<th><?php echo $row['home_visit_conducted'];?></th>
				<th><?php echo $row['home_visit_not_conducted'];?></th>
				<td><?php echo $row['showroom_visit'];?></td>
				<th><?php echo $row['showroom_visit_conducted'];?></th>
				<th><?php echo $row['showroom_visit_not_conducted'];?></th>
				<td><?php echo $row['test_drive'];?></td>
				<th><?php echo $row['test_drive_conducted'];?></th>
				<th><?php echo $row['test_drive_not_conducted'];?></th>
				<td><?php echo $row['evaluation_allotted'];?></td>
					<th><?php echo $row['evaluation_conducted'];?></th>
				<th><?php echo $row['evaluation_not_conducted'];?></th>
				
				
			
			</tr>
			<?php } ?>
	
				</tbody>
				
			</table>
			</div>
<?php }else {
	echo "<center>No Leads Found.</center>";
}
	