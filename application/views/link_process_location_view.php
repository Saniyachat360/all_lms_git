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
	if($insert[3]==1)
	{?>
	<h1 style="text-align:center; ">Map Location to Process</h1>
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
								<option value="">Please Select</option>
								<option value="<?php echo $_SESSION['process_id'];?>"><?php echo  $_SESSION['process_name'];?></option>
												
									<?php /*foreach($select_process as $row) {?>
                         						<option value="<?php echo $row->process_id ;?>"><?php echo $row->process_name;?></option>
									<?php }*/ ?>
                                					                                					
														
													                                						
													                                				</select>
								</div>
							</div>
								
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Location: </label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<select name="location_id" class="form-control" required="" >
											<option value="">Please Select</option>
											<?php foreach($select_location as $row) {?>
												<option value="<?php echo $row->location_id ;?>"><?php echo $row->location;?></option>
											<?php } ?>                                					
										</select>
									</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">GM Email: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
										<input onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="sm_email" name="gm_email" type="email">				
										
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">SM Email: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<input onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="sm_email" name="sm_email" type="email">				
														
													                                						
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
		?>
		<div class="table-responsive"  >
			<table id="example"  class="table " style="width: 100%" > 
			<thead>
				<tr>
					<th>Sr No.</th>
					<th>Process </th>
					<th>Location</th>
					<th>GM Mail ID</th>
					<th>SM Mail ID</th>
					
					<?php if($modify[3]==1 || $delete[3]==1) {?>
					<th>Action</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php
				$i=0;
				foreach($select_table as $fetch)
				{
				$i++;
				?>

				<tr>
					<td> <?php echo $i; ?> </td>
					<td>
						<?php echo $fetch -> process_name; ?>
					</td>
					<td>
						<?php echo $fetch -> location; ?>
					</td>
					<td>
						<?php echo $fetch -> gm_email; ?>
					</td>
					<td>
						<?php echo $fetch -> sm_email; ?>
					</td>
					<?php
					if($fetch->status=='-1')
					{
						?>
						<td>
							Deactive
						</td>
						<?php
						
						
					}
					else {
					
					if($modify[3]==1 || $delete[3]==1)  {
					?>
					<td>
					<?php if($modify[3]==1) {
					?>
					<a href="<?php echo site_url(); ?>Link_process_location/link_process_location/<?php echo $fetch -> map_id; ?>">Edit </a> &nbsp;&nbsp;
					<?php }
						if($delete[3]==1) {
					?>
					<a onclick="return getConfirmation();" href="<?php echo site_url(); ?>Link_process_location/delete_link_process_location/<?php echo $fetch -> map_id; ?>">Delete </a>
					<?php } ?>
					</td>
					<?php } }?>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
</div>

<script>
function getConfirmation(){
               var retVal = confirm("Do you want to continue ?");
               if( retVal == true ){
                
			return true;
               }
               else{
				   
             return false;
               }
            }
</script>