<script>
	$(document).ready(function() {
		var table = $('#example').DataTable({

			scrollY : "400px",
			scrollX : true,
			scrollCollapse : true,

			fixedColumns : {
				leftColumns : 0,
				rightColumns : 0
			}
		});
	}); 
</script>
<div class="row" >
	<div class="col-md-12">
		<?php echo $this -> session -> flashdata('message'); ?>
	</div>
	<?php $insert=$_SESSION['insert'];
	if($insert[5]==1)
	{?>
	<h1 style="text-align:center; ">Add Lead Source</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary">
			<div class="panel-body">
				<form action="<?php echo $var; ?>" method="post">
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Process: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
								<select name="process_id" class="form-control" required="" >
                         						<option value="<?php echo $_SESSION['process_id'] ;?>"><?php echo $_SESSION['process_name'] ;?></option>
									
                                					                                					
														
													                                						
													                                				</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Lead Source: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<input type="text"  onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="leadsource" required name="leadsource">
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
		?>
		<div class="table-responsive"  >
			<table id="example"  class="table " style="width: 100%" > 
			<thead>
				<tr>
					<th>Sr No.</th>
					<th>Lead Source Name</th>
					<th>Process Name</th>
					<?php if($modify[5]==1 || $delete[5]==1) {?>
					<th>Action</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php
				$i=0;
				foreach($select_leadsource as $fetch)
				{
				$i++;
				?>

				<tr>
					<td> <?php echo $i; ?> </td>
					<td>
						<?php echo $fetch -> lead_source_name; ?>
					</td>
					<td>
						<?php echo $fetch -> process_name; ?>
					</td>
						<?php
					if($fetch->leadsourceStatus=='Deactive')
					{
						?>
						<td>
							Deactive
						</td>
						<?php
						
						
					}
					else {
					if($modify[5]==1 || $delete[5]==1)  {
					?>
					<td>
					<?php if($modify[5]==1) {
					?>
					<a href="<?php echo site_url(); ?>Add_leadsource/edit_leadsource/<?php echo $fetch -> id; ?>">Edit </a> &nbsp;&nbsp;
					<?php }
						if($delete[5]==1) {
					?>
					<a onclick="return getConfirmation();" href="<?php echo site_url(); ?>Add_leadsource/delete_leadsource/<?php echo $fetch -> id; ?>">Delete </a>
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
<script src="<?php echo base_url(); ?>assets/js/campaign.js"></script>