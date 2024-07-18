<script>
	$(document).ready(function() {
		var table = $('#example').DataTable({

			scrollY : "400px",
			//scrollX : true,
			//scrollCollapse : true,

			fixedColumns : {
				//leftColumns : 5,
				//rightColumns : 1
			}
		});
	});
</script>
<div class="row" >
	<div class="col-md-12">
		<?php echo $this -> session -> flashdata('message'); ?>
	</div>
	<?php $insert=$_SESSION['insert'];
	if($insert[6]==1)
	{?>
	<h1 style="text-align:center; ">Add Feedback Status</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary">

			<div class="panel-body">
				<form action="<?php echo $var; ?>" method="post">

					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="col-md-12">
								<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Process Name: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<select name="process_id" class="form-control" required="" >
										<option value="<?php echo $_SESSION['process_id'];?>"><?php echo  $_SESSION['process_name'];?></option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Feedback Status: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<input type="text"  onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="fstatus_name" required name="fstatus_name">

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
<div class="row" >
	<div class="col-md-12">
		<?php
		$modify = $_SESSION['modify'];
		$delete = $_SESSION['delete'];
		$form_name = $_SESSION['form_name'];
		?>
		<table id="example"  class="table " style="width:auto;" cellspacing="0">
			<thead>
				<tr>
					<th><b>Sr No.</b></th>

					<th><b>Feedback Status</b></th>
					<th><b>Process Name</b></th>
					<?php if($modify[6]==1 || $delete[6]==1) {?>
					<th><b>Action</b></th>

					<?php } ?>
				</tr>
			</thead>

			<tbody>

				<?php
				$i=0;
				foreach($select_feedback_status as $fetch)
				{
				$i++;
				?>

				<tr>

					<td> <?php echo $i; ?> </td>

					<td>
					<?php echo $fetch -> feedbackStatusName; ?>
					</td>
					<td>
					<?php echo $fetch -> process_name; ?>
					</td>
				<?php if($fetch->fstatus != 'Deactive'){?>
					<?php if($modify[6]==1 || $delete[6]==1)  {
					?>
					<td>
					<?php if($modify[6]==1) {
					?>
					<a href="<?php echo site_url(); ?>Feedback_status/edit_feedback_status/<?php echo $fetch -> feedbackStatusId; ?>">Edit </a> &nbsp;&nbsp;
					<?php }
						if($delete[6]==1) {
					?>
					<a onclick="return getConfirmation();" href="<?php echo site_url(); ?>Feedback_status/delete_feedback_status/<?php echo $fetch -> feedbackStatusId; ?>">Delete </a>
					<?php } ?>
					</td>
					<?php } 
				}else{?>
						<td> Deactive </td>
						<?php }?>
				</tr>
				<?php } ?>
			</tbody>

		</table>

	</div>

</div>

<script src="<?php echo base_url(); ?>assets/js/campaign.js"></script>