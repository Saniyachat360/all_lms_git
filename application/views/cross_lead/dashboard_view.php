 <div class="row" id="leaddiv">
	<div id='replacediv'>
			<h1 style="text-align:center;">Dashboard</h1>	
			</div>
			</div>		
			<div class="row">
		  	<div class="panel panel-primary">
				<div class="panel-body">
<div class="table-responsive"  >	
							<table id="example"  class="table " style="width: 100%" > 		
								<thead>
									<tr>
										<!-- Show Select box if add followup or remark right 1 -->						
									
										<th>Process</th>													
										<th>Live Leads</th>
										<th>Converted Leads</th>	
										<th>Lost Leads</th>
										<th>Total Leads</th>									
										</tr>
							</thead>
							<tbody>
								<?php foreach ($cross_lead_dashboard as $row) {?>
									
								
								<tr>
										<td><?php echo $row['process'];?></td>													
										<th><a href="<?php echo site_url();?>sign_up/dashboard_show_data/<?php echo $row['user_id'];?>/<?php echo $row['process'];?>/live" style="cursor: pointer"><?php echo $row['live_lead'];?></a></th>
										<th><a href="<?php echo site_url();?>sign_up/dashboard_show_data/<?php echo $row['user_id'];?>/<?php echo $row['process'];?>/converted" style="cursor: pointer"><?php echo $row['converted_lead'];?></a></th>	
										<th><a href="<?php echo site_url();?>sign_up/dashboard_show_data/<?php echo $row['user_id'];?>/<?php echo $row['process'];?>/lost" style="cursor: pointer"><?php echo $row['lost_leads'];?></a></th>
										<th><a href="<?php echo site_url();?>sign_up/dashboard_show_data/<?php echo $row['user_id'];?>/<?php echo $row['process'];?>/total" style="cursor: pointer"><?php echo $row['total_leads'];?></a></th>		
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
		