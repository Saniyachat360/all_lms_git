
<script>
function show_script (val) {
  //alert(val);
  var loan_id = val;
  $.ajax({
	url : '<?php echo site_url('scripts/show_script'); ?>',
	type : 'POST',
	data : {
	'loan_id' : loan_id,

	},
	success : function(result) {
	$("#script_div").html(result);
	}
	});
}
</script>
<div class="row" >
	<div class="col-md-12">
		<?php echo $this -> session -> flashdata('message'); ?>
	</div>
	<?php /*$insert=$_SESSION['insert'];
	if($insert[5]==1)
	{*/?>
	<h1 style="text-align:center; "> Scripts</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary">
			<div class="panel-body">
				
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Loan Type: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
								<select name="loan_id" class="form-control" required="" onchange="show_script(this.value);">
								    <option value="">Please Select </option>
                         					<?php foreach ($select_loan_type as $row) {?>
											<option value="<?php echo $row->loan_id;?>"><?php echo $row->loan_name;?></option>
						            	<?php	} ?>
									
                                					                                					
														
													                                						
													                                				</select>
								</div>
							</div>
							<div id='script_div'>
							
						</div>
						</div>
					</div>
					<!--div class="form-group">
						<div class="col-md-2 col-md-offset-4">
							<button type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12">
								Submit
							</button>
						</div>
						<div class="col-md-2">
							<input type='reset' class="btn btn-primary col-md-12 col-xs-12 col-sm-12" value='Reset'>
						</div>
					</div-->
			</div>
		</div>
		<!--/form-->
	</div>
<?php //}
?>
</div>