<script>
$(document).ready(function() {
		//alert(new Date());
		$('#datett').daterangepicker({
			singleDatePicker : true,
		//	minDate : new Date(),
			format : 'YYYY-MM-DD',
			showDropdowns: true,
			calender_style : "picker_1",
		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
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
	<h1 style="text-align:center; ">Edit Occassion</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary">
			<div class="panel-body">
			    <?php
						foreach($edit_data as $fetch) 
						{?>
				<form action="<?php echo $var; ?>" method="post">
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="col-md-12">
							
						
								<div class="form-group">
								<label class="control-label col-md-2 col-sm-4 col-xs-12" for="first-name">Occassion Name: </label>
								<div class="col-md-8 col-sm-5 col-xs-12">
									<input type="text"  onkeypress="return alpha(event)" placeholder="Enter Occassion Name" autocomplete="off" class="form-control" id="occassion_name" required name="occassion_name"
										value="<?php echo $fetch->name ;?>"
									>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-4 col-xs-12" for="first-name">Occassion Date: </label>
								<div class="col-md-8 col-sm-5 col-xs-12">
									<input type="text"   autocomplete="off" placeholder="Enter Occassion Date"  class="form-control" id="datett" required name="occassion_date" value="<?php echo $fetch->date ;?>">
								</div>
							</div>
								<div class="form-group">
								<label class="control-label col-md-2 col-sm-4 col-xs-12" for="first-name">Description: </label>
								<div class="col-md-8 col-sm-5 col-xs-12">
									 <textarea placeholder="Enter Description" id='description' name='description'  class="form-control" ><?php echo $fetch->description ;?></textarea>
								</div>
							</div>
							
						</div>
					</div>
					<input type="hidden" class="form-control" value="<?php echo $fetch->holiday_id;?>"  name="login_status_id" >
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
		<?php } ?>
	</div>
<?php } ?>
</div>