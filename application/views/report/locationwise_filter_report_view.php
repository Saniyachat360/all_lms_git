	<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
		<?php

	if(count($select_leads)>0){
		
			?>
	<div class="col-md-12" style="overflow-x:scroll">
				<table class="table table-bordered datatable" id="table-4" >
				<thead>
					
					<tr>
				<th rowspan="2">Location Name</th>
				<th rowspan="2">Total Lead Assigned</th>
				<th rowspan="2">AVG Leads Per Month</th>
				<th rowspan="2">Lead assigned MTD</th>
				<th rowspan="2">AVG Leads per Day</th>
				<th rowspan="2">Live</th>
				<th rowspan="2">Lost</th>
				<th rowspan="2">Lost to Co-dealer</th>
				<th rowspan="2">Lost to Co-dealer%</th>
				<th rowspan="2">Bookings</th>
				<th rowspan="2">Conversion %</th>
				<th colspan="3" class="text-center">Escalations</th>
		
				</tr>
				<tr>
				
				<th>Level 1</th>
				<th>Level 2</th>
				<th>Level 3</th>
	
				</tr>
				</thead>
					<tbody>
					
					
			<?php foreach ($select_leads as $row) {?>
				
			
			
				<tr>
				<td><?php echo $row['location'];?></td>
				<td><?php echo $assigned=$row['total_lead_assigned'];?></td>
				<td><?php echo round($row['total_avg_month']);?></td>
				<td><?php echo $assigned_month=$row['total_lead_assigned_month'];?></td>
				<td><?php $day=date('d');
					if($assigned_month>0){
						 $total_day_leads=$assigned_month/$day;
						echo round($total_day_leads);
					}else{
						echo '0';					}?></td>
				<td><?php echo $row['total_live_leads'];?></td>
				<td><?php echo $row['total_lost_leads'];?></td>
				
				<td><?php echo $co_dealer=$row['total_lost_to_co_dealer'];?></td>
				<td><?php if($assigned>0 && $co_dealer>0){
					 $lost_co_dealer=($co_dealer/$assigned)*100; 
					 echo round($lost_co_dealer,2).'%';
				}else{
					 echo '0%'; 
				} 
						?></td>
				<td><?php echo $booking=$row['total_booking'];?></td>
				<td><?php if($assigned>0 && $booking>0){
					 $avg_booking=($booking/$assigned)*100; 
					 echo round($avg_booking,2).'%';
				}else{
					 echo '0%'; 
				} 
						?></td>
				<td><?php echo $row['esculation_level_1'];?></td>
				<td><?php echo $row['esculation_level_2'];?></td>
				<td><?php echo $row['esculation_level_3'];?></td>
				
			</tr>
			<?php } ?>
	
				</tbody>
				
			</table>
			</div>
<?php }else {
	echo "<center>No Leads Found.</center>";
}
	