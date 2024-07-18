
<div class="row" >
	<div class="col-md-12">
		<?php echo $this -> session -> flashdata('message'); ?>
	</div>
	<?php $insert=$_SESSION['insert'];
	if($insert[0]==1)
	{?>
	<h1 style="text-align:center; ">Update Brochure</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary">

			<div class="panel-body">
				<form action="<?php echo $var; ?>" method="post" enctype="multipart/form-data">

					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Model: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<select name="model" id="model" class="form-control" required >
                     
                      <option value="<?php echo $model[0]->model_id?>"><?php echo $model[0]->model_name?></option>
                      	</select>
								</div>
							</div>
							 <div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"></label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<p>Already Uploaded file: <?php echo $model[0]->brochure?></p>
								</div>
							</div>
 <div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Upload File:</label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<input type="file"  class="btn btn-info"  name="file" id="file" required  >
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