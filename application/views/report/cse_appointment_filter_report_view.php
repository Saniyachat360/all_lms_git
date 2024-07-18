	<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
		<?php

	if(count($select_leads)>0){
		
			?>
	<div class="col-md-12">
				<table class="table table-bordered datatable" id="table-4">
				<thead>
					
					<tr>
				<th rowspan="2" class="text-center">Location</th>
				<th colspan="3" class="text-center">Home Visit</th>
				<th colspan="3" class="text-center">Showroom Visit</th>
				<th colspan="3" class="text-center">Test Drive</th>
				<th colspan="3" class="text-center">Evaluation Allotted</th>
				
				</tr>
				<tr>
				
				<th>Alloted</th>
				<th>Conducted</th>
				<th>Not Conducted</th>
				<th>Alloted</th>
				<th>Conducted</th>
				<th>Not Conducted</th>
				<th>Alloted</th>
				<th>Conducted</th>
				<th>Not Conducted</th>
				<th>Alloted</th>
				<th>Conducted</th>
				<th>Not Conducted</th>
				
	
				</tr>
				</thead>
					<tbody>
					
					
			<?php 
			foreach ($select_leads as $row) {?>
				
			
			
			<tr>
				<th><?php echo $row['location'];?></th>
				<th><?php echo $row['home_visit_allocated'];?></th>
				<th><?php echo $row['home_visit_conducted'];?></th>
				<th><?php echo $row['home_visit_not_conducted'];?></th>
				
				<th><?php echo $row['showroom_visit_allocated'];?></th>
				<th><?php echo $row['showroom_visit_conducted'];?></th>
				<th><?php echo $row['showroom_visit_not_conducted'];?></th>
				
				<th><?php echo $row['test_drive_allocated'];?></th>
				<th><?php echo $row['test_drive_conducted'];?></th>
				<th><?php echo $row['test_drive_not_conducted'];?></th>
				
				<th><?php echo $row['evaluation_allocated'];?></th>
				<th><?php echo $row['evaluation_conducted'];?></th>
				<th><?php echo $row['evaluation_not_conducted'];?></th>
				
	
				</tr>
			<?php } ?>
	
				</tbody>
				
			</table>
			</div>
<?php }else { 
}
	