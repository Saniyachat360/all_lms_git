<?php
if (isset($select_leads)) {
	if (count($select_leads) > 0) {
		$evaluation_count = 0;
		$escalation_level_1_count = 0;
		$escalation_level_2_count = 0;
		$escalation_level_3_count = 0;
		foreach ($location_data as $row) {
			$evaluation_count = $evaluation_count + $row['evaluation_count'];
			$escalation_level_1_count = $escalation_level_1_count + $row['escalation_level_1'];
			$escalation_level_2_count = $escalation_level_2_count + $row['escalation_level_2'];
			$escalation_level_3_count = $escalation_level_3_count + $row['escalation_level_3'];
			$id[] = $row['id'];
			$role[] = $row['role'];
		}
		//	print_r($id);
		/*$executive_array=array("3","4","8","10","12","14");
			if(in_array($_SESSION['role'],$executive_array)){*/ ?>
		<script>
			function get_url() {
				var role = new Array;
				var id = new Array;
				<?php foreach ($location_data as $row) { ?>
					role.push(<?php echo $row['role']; ?>);
					id.push(<?php echo $row['id']; ?>);

				<?php } ?>
				var myJSON = JSON.stringify(id);
				var myJSON1 = JSON.stringify(role);

				window.open('<?php echo site_url(); ?>unassign_leads/leads/?id_array=' + myJSON + '&role_array=' + myJSON1);

			}
		</script>
		<div class="col-md-12">
			<table class="table table-bordered datatable" id="table-4">
				<thead>
					<tr>
						<th><b>Sr No.</b></th>
						<th><b>Leads</b></th>

						<th><b>Count
							</b>
						</th>

					</tr>
				</thead>
				<tbody>


					<?php if ($_SESSION['process_id'] == 6 || $_SESSION['process_id'] == 7 || $_SESSION['process_id'] == 8) {
						 ?>
						<tr>
							<td>1</td>
							<td>Evaluations For Today </td>
							<td><?php echo $evaluation_count ?></td>


						</tr>

						<tr>
							<td>2</td>
							<td>Escalation Level 1</td>

							<td><?php echo $escalation_level_1_count; ?>
							</td>

						</tr>
						<tr>
							<td>3</td>
							<td>Escalation Level 2</td>
							<td><?php echo $escalation_level_2_count; ?>
							</td>

						</tr>
						<tr>
							<td>4</td>
							<td>Escalation Level 3</td>

							<td><?php echo $escalation_level_3_count ?>
							</td>

						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	<?php } ?>
<?php //}
} else {
}
//}
?>