	<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
		<div class="pull-right">
<a href="#" class="pull-right" onClick ="$('#xls_data').tableExport({type:'excel',escape:'false'});"><i class="btn btn-defult entypo-download"></i></a>
      </div></div>
		<?php

	if(count($select_leads)>0){
		
			?>
	<div class="col-md-12" style="overflow-x:scroll">
				<table class="table table-bordered datatable"  id="xls_data" >
				<thead>
										<tr>
				<th >DSE Name</th>
				<th >Total Called</th>
				<th >Total Connected</th>
				<th >Not Connected</th>
				<th >Connected%</th>				
				<th >Lead Assigned</th>
				<th >Booked</th>
			<th >Conversion%</th>
				<th >Evaluation Conducted</th>
				<th >Test Drive Conducted</th>
				<th >Home Visit Conducted</th>
				<th >Showroom Visit Conducted</th>
				
				</tr>
			
				</thead>
					<tbody>
					
					
			<?php foreach ($select_leads as $row) {?>
				
			
			
				<tr>
				<td><?php echo $row['dse_fname'].' '.$row['dse_lname'];?></td>
				<td><?php echo $total_call=$row['total_call'];?> </td>
				<td><?php echo $connected=$row['total_connected'];?></td>
				<td><?php echo $row['total_not_connected'];?></td>
				<td><?php if($connected!=0 && $total_call!=0){
					$total_connect=($connected/$total_call)*100; 
								echo  round($total_connect, 2).'%';
				}else{
					echo '0%';
				} ?></td>
			
				<td><?php echo $assigned=$row['lead_assigned'];?></td>
				<td><?php echo $booked=$row['booked'];?></td>
			<td><?php if($booked>0 && $assigned>0){
				$total_book=($booked/$assigned)*100; 
					echo  round($total_book, 2).'%';
			}else{
					echo '0%';
				}?></td>
				<td><?php echo $row['evaluation_allotted'];?></td>
				<td><?php echo $row['test_drive'];?></td>
				<td><?php echo $row['home_visit'];?></td>
				<td><?php echo $row['showroom_visit'];?></td>
				
			</tr>
			<?php } ?>
	
				</tbody>
				
			</table>
			</div>
<?php }else {
	echo "<center>No Leads Found.</center>";
}
	