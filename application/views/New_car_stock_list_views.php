

<!-- date script -->

<!--Filter Ends-->

	<div class="row" >
	
		<h1 style="text-align:center; ">New Car Stock Vehicle Detail</h1>
		 </div> 
	

<div class="col-md-12" id="table_stock">
	
				<table class="table table-bordered datatable" id="results"> 
					<thead>
						<tr>
							<th>Sr No.</th>
							<th>Model</th>
							<th>Sub Model</th>
							<th>Color</th>
							<th>Fuel Type</th>
							<th>Vehicle Status</th>
							<th>Location</th>
							<th>Ageing</th>
							<th>Last Updated</th>
						</tr>	
					</thead>
					<tbody>
				
					 <?php 
					 $i=0;
						foreach($select_stock as $fetch) 
						{
							$i++;
						?>
						
						
						<tr>
						<td>	
						<?php echo $i; ?> 		
						
						</td>
							<td><?php echo $fetch -> model_name; ?></td>
						
							<td><?php echo $fetch -> submodel; ?></td>
						
						<td><?php echo $fetch -> color; ?></td>
						
						
							<td><?php echo $fetch -> fuel_type; ?></td>
								
								<td><?php echo $fetch -> vehicle_status; ?></td>  
							<td><?php echo $fetch -> assigned_location; ?></td> 
							<td><?php echo $fetch -> ageing; ?></td>   
							<td><?php echo $fetch -> created_date; ?></td>                   
						 </tr>
						 
						 	 <?php } ?>
						 
					
					</tbody>
				</table>
			</div>

	
  <script src="<?php echo base_url(); ?>assets/js/campaign.js"></script>   
