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
	if($insert[7]==1)
	{?>
	<h1 style="text-align:center; ">Add Default Close Lead Status</h1>
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
								<option value="<?php echo $_SESSION['process_id'];?>"><?php echo $_SESSION['process_name'];?></option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Action Status: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
								<select type="text" class="form-control" id="naction_name" name="naction_name" required ><span class="glyphicon">&#xe252;</span>
                                            <option value="">Please Select</option> 
											<?php
											
											foreach($select_next_action_status as $row)
											{
												
											?>
											 <option value="<?php echo $row -> nextActionName; ?>"><?php echo $row ->nextActionName; ?></option> 
											
											<?php } ?>
											</select> 

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

					<th><b>Next Action</b></th>
					<th><b>Process Name</b></th>
					<?php if($modify[7]==1 || $delete[7]==1) {?>
					<th><b>Action</b></th>

					<?php } ?>
				</tr>
			</thead>

			<tbody>

				<?php
				
				if(count($select_defult_close_lead_status)>0){
                $select_status=json_decode($select_defult_close_lead_status[0]->nextActionName); 
				//print_r($select_status);
				$j=0;
				for($i=0;$i<count($select_status);$i++)
				{
				$j++;
				?>

				<tr>

					<td> <?php echo $j; ?> </td>

					<td>
					<?php echo $select_status[$i]; ?>
					</td>
					<td>
					<?php echo $select_defult_close_lead_status[0] -> process_name; ?>
					</td>
					
					<?php	
					if($select_defult_close_lead_status[0]->default_close_lead_status=='Deactive')
					{
						?>
						<td>
						Deactive
						</td>
						<?php
					}
					else {


					if($modify[7]==1 || $delete[7]==1)  {
					?>
					<td>
									<?php 
						if($delete[7]==1) {
					?>
					<a onclick="return getConfirmation();" href="<?php echo site_url(); ?>Add_default_close_lead_status/delete_deafault_close_lead_status/<?php echo $select_defult_close_lead_status[0] -> default_close_lead_id; ?>/<?php echo $select_status[$i];?>">Delete </a>
					<?php } ?>
					</td>
					<?php } } ?>
				</tr>
				<?php } }?>
			</tbody>

		</table>

	</div>

</div>

<script src="<?php echo base_url(); ?>assets/js/campaign.js"></script>