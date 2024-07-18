<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
		 <div class="pull-right">
<a href="#" class="pull-right" onClick ="$('#xls_data').tableExport({type:'excel',escape:'false'});"><i class="btn btn-defult entypo-download"></i></a>
      </div></div>
		<?php 
		if(count($select_leads)>0){?>
		<div class="col-md-12" style="overflow-x:scroll">
			<table class="table table-bordered datatable" id="xls_data" >
				<thead>
					<tr>
				<th>CSE Name</th>
				<th>Lead Assigned</th>
				<th>New</th>
				<th>Pending New</th>
				<th>Pending Followup</th>
				<th>Live</th>
				<th>Lost</th>
				<th>Booked</th>
				<th>Conversion%</th>
				</tr>
				</thead>
				<tbody>
			<?php foreach ($select_leads as $row) {?>
				<tr>

				<td><?php echo $row['cse_fname'] . ' ' . $row['cse_lname']; ?></td>

			<td><?php echo $row['assign_lead']; ?> </td>
			<td><?php echo $row['new_leads']; ?> </td>

					<td><?php echo $row['pending_new_leads']; ?></td>

					<td><?php echo $row['pending_followup_leads']; ?></td>
					<td><?php echo $row['live_leads']; ?></td>
			<td><?php echo $row['close_leads']; ?></td>
			<td><?php echo $row['booked_leads']; ?></td>
				
				

				<td><?php
	if ($row['assign_lead'] == 0) {
		echo "0.00%";
	} else {
		$t = ($row['booked_leads'] / $row['assign_lead']) * 100;
		echo number_format($t, 2);
		echo "%";
	}
	?></td>
			</tr>

			<?php } ?>
				</tbody>
			</table>

			</div>

<?php }else {
	echo "<center>No Leads Found.</center>";
	}