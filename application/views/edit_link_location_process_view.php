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
	if($insert[0]==1)
	{?>
	<h1 style="text-align:center; ">Edit Link Process Location</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary">
			<div class="panel-body">
				<form action="<?php echo $var; ?>" method="post">
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="col-md-12">
							<input type="hidden" name="map_id" value="<?php if(isset($select_table[0]->map_id)){ echo $select_table[0]->map_id ; }?> ">
							
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Process: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
								<select name="process_id" class="form-control" required="" >
								<option value="<?php if(isset($select_table[0]->process_id)){ echo $select_table[0]->process_id ; }?>"><?php if(isset($select_table[0]->process_name)){  echo $select_table[0]->process_name; }?></option>
								
									<?php /*foreach($select_process as $row) {?>
                         						<option value="<?php echo $row->process_id ;?>"><?php echo $row->process_name;?></option>
									<?php }*/ ?>
                                					                                					
														
													                                						
													                                				</select>
								</div>
							</div><div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Location: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
										<select name="location_id" class="form-control" required="" >
										<option value="<?php if(isset($select_table[0]->location_id)){ echo $select_table[0]->location_id ; }?>"><?php if(isset($select_table[0]->location)){  echo $select_table[0]->location; }?></option>
										<?php foreach($select_location as $row) {?>
                         						<option value="<?php echo $row->location_id ;?>"><?php echo $row->location;?></option>
									
	<?php } ?>                                					
														
													                                						
													                                				</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">GM Email: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
										<input onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="sm_email" name="gm_email" type="email" value="<?php  if(isset($select_table[0]->gm_email)){ echo $select_table[0]->gm_email; }?>">				
										
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">SM Email: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<input onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="sm_email" name="sm_email" type="email" value="<?php  if(isset($select_table[0]->sm_email)){ echo $select_table[0]->sm_email; }?>">				
														
													                                						
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
