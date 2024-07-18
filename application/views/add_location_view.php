<?php //phpinfo()
?>

<script>
	$(document).ready(function() {
		var table = $('#example').DataTable({

			scrollY: "400px",
			//scrollX : true,
			//scrollCollapse : true,

			fixedColumns: {
				//leftColumns : 5,
				//rightColumns : 1
			}
		});
	});
</script>
<div class="row">
	<div class="col-md-12">
		<?php echo $this->session->flashdata('message'); ?>
	</div>
	<?php $insert = $_SESSION['insert'];
	if ($insert[0] == 1) { ?>
		<h1 style="text-align:center; ">Add Location</h1>
		<div class="col-md-12">
			<div class="panel panel-primary">

				<div class="panel-body">
					<form action="<?php echo $var; ?>" method="post">

						<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="city">City: </label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<select class="form-control" id="city" name="city" required>
											<option value="">Select City</option>
											<option value="Pune">Pune</option>
											<option value="Mumbai">Mumbai</option>
										</select>
									</div>
								</div>
							</div>
						</div>

						<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Location: </label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<input type="text" onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="location" required name="location_name">

									</div>
								</div>

							</div>
						</div>

						<div class="form-group">
							<div class="col-md-2 col-md-offset-4">

								<button type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12">
									Submit
								</button>
							</div>

							<div class="col-md-2">
								<input type='reset' class="btn btn-primary col-md-12 col-xs-12 col-sm-12" value='Reset'>

							</div>
						</div>
				</div>
			</div>
			</form>
		</div>
	<?php } ?>
</div>
<div class="row">
	<div class="col-md-12">
		<?php
		$modify = $_SESSION['modify'];
		$delete = $_SESSION['delete'];
		$form_name = $_SESSION['form_name'];
		?>
		<div class="table-responsive">
			<table id="example" class="table " style="width:auto;" cellspacing="0">
				<thead>
					<tr>
						<th>Sr No.</th>

						<th>Location</th>
						<?php if ($modify[0] == 1 || $delete[0] == 1) { ?>
							<th>Action</th>

						<?php } ?>
					</tr>
				</thead>

				<tbody>

					<?php
					$i = 0;
					foreach ($select_location as $fetch) {
						$i++;
					?>

						<tr>

							<td> <?php echo $i; ?> </td>

							<td>
								<?php echo $fetch->location; ?>
							</td>

							<?php
							if ($fetch->location_status == 'Deactive') {
							?>
								<td>
									Deactive
								</td>
								<?php
							} else {


								if ($modify[0] == 1 || $delete[0] == 1) {
								?>
									<td>
										<?php if ($modify[0] == 1) {
										?>
											<a href="<?php echo site_url(); ?>add_location/edit_location/<?php echo $fetch->location_id; ?>">Edit </a> &nbsp;&nbsp;
										<?php }
										if ($delete[0] == 1) {
										?>
											<a onclick="return getConfirmation();" href="<?php echo site_url(); ?>add_location/delete_location/<?php echo $fetch->location_id; ?>">Delete </a>
										<?php } ?>
									</td>
							<?php }
							} ?>
						</tr>
					<?php } ?>
				</tbody>

			</table>
		</div>
	</div>

</div>