<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/datatables/datatables.css" id="style-resource-1">
			<script type="text/javascript">
	jQuery(document).ready(function($) {
		var $table4 = jQuery("#table-4");
		$table4.DataTable({
			dom : 'Bfrtip',
			buttons : ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
		});
	}); 
</script> 
<div class="row">
<h1 style="text-align:center; ">Transfered Lead Details </h1>
<div id="leaddiv" class="col-md-12" >
		<div class="table-responsive" id="replace_table"  style="overflow-x:auto;">
	<table class="table table-bordered datatable table-responsive" id="table-4"> 
		
				<thead>
						<tr>
						
							<th>Sr No.</th>
							<th>Assign To </th>
							<th>Assign By</th>
							<th>Transfer Date</th>
						<!--	<th>Transfer Reason</th>-->
							
						</tr>
						
					</thead>
					<tbody>
	
					<?php $i=0;
					
					foreach($select_leads_flow as $fetch)
					{
						
							$i++; ?>
							<tr>
					<td><?php echo $i; ?></td>
			
					<td><?php echo $fetch->fname;?> <?php echo $fetch->lname;?></td>
					<td><?php echo $fetch->u1name;?> <?php echo $fetch->u1lname;?></td>
					<td><?php echo $fetch->created_date;?></td>
					<!--<td><?php echo $fetch->transfer_reason;?></td>-->
					<?php } ?>
				</tr>
					<?php $i=count($select_leads_flow);
					
					/*foreach($select_leads_flow_lc as $fetch)
					{
						
							$i++; ?>
							<tr>
					<td><?php echo $i; ?></td>
			
					<td><?php echo $fetch->fname;?> <?php echo $fetch->lname;?></td>
					<td><?php echo $fetch->u1name;?> <?php echo $fetch->u1lname;?></td>
					<td><?php echo $fetch->created_date;?></td>
					<td><?php echo $fetch->transfer_reason;?></td>
					<?php } ?>
				</tr>
					<?php $i1=count($select_leads_flow);
							$i2=count($select_leads_flow);
					$i=$i1+$i2;
					foreach($select_leads_flow_lost as $fetch)
					{
						
							$i++; ?>
							<tr>
					<td><?php echo $i; ?></td>
			
					<td><?php echo $fetch->fname;?> <?php echo $fetch->lname;?></td>
					<td><?php echo $fetch->u1name;?> <?php echo $fetch->u1lname;?></td>
					<td><?php echo $fetch->created_date;?></td>
					<td><?php echo $fetch->transfer_reason;?></td>
					<?php } */?>
				</tr>
					</tbody>
					</table>
					</div>
					</div>
					</div>