<div class="row" >
	<div class="col-md-12">
		<?php echo $this -> session -> flashdata('message'); ?>
	</div>
	
	<h1 style="text-align:center; ">Edit Map DSE to DSE Team Leader</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary">

			<div class="panel-body">
				<form action="<?php echo site_url()?>/lms_user/update_map_lms" method="post">

					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="col-md-12">
						<?php foreach($edit_map_data as $fetch) 
{
	?>
							<div class="form-group">
   
    <input type="hidden" name='id1' class="form-control" placeholder="Enter Name" value="<?php echo $fetch->map_id ?>"/><br>
  </div>
<?php }	?>				<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">TL Name: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									 
											
 <select onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="tlname" required name="tlname">
 
								 <?php foreach($edit_map_data as $fetch) 
{
	?>
  <option value="<?php echo $fetch->tl_id ?>"> <?php echo $fetch->tlfname ?>  <?php echo $fetch->tllname ?> </option>
 
  <?php
}
?>
 
<?php foreach($tl_data as $row) 
{
	?>
  <option value="<?php echo $row->id ?>"><?php echo $row->fname ?> <?php echo $row->lname ?> </option>
 
  <?php
}
?>
 
</select>
 

								</div>
							</div>

						</div>
					</div>
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">DSE Name: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									
									
 
<select onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="dsename" required name="dsename">
 
 <?php foreach($edit_map_data as $fetch) 
{
	?>
  <option value="<?php echo $fetch->dse_id ?>"> <?php echo $fetch->fname ?>  <?php echo $fetch->lname ?> </option>
 
  <?php
}
?>
												
 
<?php foreach($dse_data as $fetch) 
{
	?>
  <option value="<?php echo $fetch->id ?>"> <?php echo $fetch->fname ?>  <?php echo $fetch->lname ?> </option>
 
  <?php
}
?>
 
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

</div>