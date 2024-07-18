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
	<h1 style="text-align:center; ">Edit Login Status</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary">
			<div class="panel-body">
			    <?php
						foreach($l_status as $fetch) 
						{?>
				<form action="<?php echo $var; ?>" method="post">
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="col-md-12">
							
						
								<div class="form-group">
								<label class="control-label col-md-2 col-sm-4 col-xs-12" for="first-name">Login Status: </label>
								<div class="col-md-8 col-sm-5 col-xs-12">
									<input type="text"  onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="reason_name" required name="reason_name"
										value="<?php echo $fetch->login_status_name ;?>"
									>
								</div>
							</div>
							
						</div>
					</div>
					<input type="hidden" class="form-control" value="<?php echo $fetch->login_status_id;?>"  name="login_status_id" >
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