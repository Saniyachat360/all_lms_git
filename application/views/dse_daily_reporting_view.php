<script>
	function validate_form() {
		var new_pwd = document.forms["change_password"]["new_pwd"].value;
		var c_pwd = document.forms["change_password"]["c_pwd"].value;
		if(c_pwd!=new_pwd)
		{
			alert("New Password & Confirm Password Should Be Same");
			return false;
		}
	}

	function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		// Added to allow decimal, period, or delete
		if (charCode == 110 || charCode == 190 || charCode == 46)
			return true;

		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;

		return true;
	}

	function limitlength(obj, length) {
		var maxlength = length
		if (obj.value.length > maxlength)
			obj.value = obj.value.substring(0, maxlength)
	}

	function alpha(e) {
		var k;
		document.all ? k = e.keyCode : k = e.which;
		return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
	}


	$(document).ready(function() {
		$("#fname").keypress(function(event) {
			var inputValue = event.which;
			// allow letters and whitespaces only.
			if ((inputValue > 47 && inputValue < 58) && (inputValue != 32)) {
				event.preventDefault();
			}
		});
	});

</script>




<!--<ol class="breadcrumb bc-3" > <li> <a href="index.php"><i class="fa fa-home"></i>Home</a> </li><li class="active"> <strong>Change Password </strong> </li> </ol>-->
	
	

  <div class="container body" style="width: 100%;">


       
<div class="container" >
	<div class="col-md-12" >
		<h1 style="text-align:center;">DSE Daily Reporting</h1>
		<div class="panel panel-primary">

			<div class="panel-body">
			<div class="col-md-12">
		<?php echo $this -> session -> flashdata('message'); ?>
	</div>
				<form name="" action="<?php echo $var;?>" method="post" onsubmit="return validate_form();">

					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
					<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-md-offset-1 col-xs-12" >Date : </label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input type="text" required  placeholder="Enter Date"  class="datett form-control" id="fname" name="user_date" >
								</div>
									
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-md-offset-1 col-xs-12" >Enquiry: </label>
								<div class="col-md-2 col-sm-2 col-xs-12">
									<input type="text" required  onkeyup="return limitlength(this, 15)" onkeypress="return isNumberKey(event)" placeholder="Enter Count" autocomplete="off" class="form-control" id="fname" name="enquiry_count" >
								</div>
									<div class="col-md-4 col-sm-4 col-xs-12">
									<textarea class="form-control" placeholder="Enter Remark" name="enquiry_remark" required></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-md-offset-1 col-xs-12" >Walk-In : </label>
								<div class="col-md-2 col-sm-2 col-xs-12">
									<input type="text" required  onkeyup="return limitlength(this, 15)" onkeypress="return isNumberKey(event)" placeholder="Enter Count" autocomplete="off" class="form-control" id="fname" name="walk_in_count" >
								</div>
									<div class="col-md-4 col-sm-4 col-xs-12">
									<textarea class="form-control" placeholder="Enter Remark" name="walk_in_remark" required></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-md-offset-1 col-xs-12" >Home Visit: </label>
								<div class="col-md-2 col-sm-2 col-xs-12">
									<input type="text" required  onkeyup="return limitlength(this, 15)" onkeypress="return isNumberKey(event)" placeholder="Enter Count" autocomplete="off" class="form-control" id="fname" name="home_visit_count" >
								</div>
									<div class="col-md-4 col-sm-4 col-xs-12">
									<textarea class="form-control" name="home_visit_remark" placeholder="Enter Remark" required></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-md-offset-1 col-xs-12" >Test Drive: </label>
								<div class="col-md-2 col-sm-2 col-xs-12">
									<input type="text" required  onkeyup="return limitlength(this, 15)" onkeypress="return isNumberKey(event)" placeholder="Enter Count" autocomplete="off" class="form-control" id="fname" name="test_drive_count" >
								</div>
									<div class="col-md-4 col-sm-4 col-xs-12">
									<textarea class="form-control" placeholder="Enter Remark" name="test_drive_remark" required></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-md-offset-1 col-xs-12" >Booking: </label>
								<div class="col-md-2 col-sm-2 col-xs-12">
									<input type="text" required  onkeyup="return limitlength(this, 15)" onkeypress="return isNumberKey(event)" placeholder="Enter Count" onkeypress="return isNumberKey(event)" autocomplete="off" class="form-control" id="fname" name="booking_count" >
								</div>
									<div class="col-md-4 col-sm-4 col-xs-12">
									<textarea class="form-control" placeholder="Enter Remark" name="booking_remark" required></textarea>
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-md-offset-1 col-xs-12" >Gate Pass Issue: </label>
								<div class="col-md-2 col-sm-2 col-xs-12">
									<input type="text" required  onkeyup="return limitlength(this, 15)" onkeypress="return isNumberKey(event)" placeholder="Enter Count" onkeypress="return isNumberKey(event)" autocomplete="off" class="form-control" id="fname" name="gatepass_count" >
								</div>
									<div class="col-md-4 col-sm-4 col-xs-12">
									<textarea class="form-control" placeholder="Enter Remark" name="gatepass_remark" required></textarea>
								</div>
							</div>
							
						
					<div class="form-group" style="margin-bottom:30px">
								<label class="control-label col-md-2 col-sm-2 col-md-offset-1 col-xs-12" >Delivery: </label>
							<div class="col-md-2 col-sm-2 col-xs-12">
									<input type="text" required  onkeyup="return limitlength(this, 15)" onkeypress="return isNumberKey(event)" placeholder="Enter Count" autocomplete="off" class="form-control" id="fname" name="delivery_count" >
								</div>
									<!--<div class="col-md-4 col-sm-4 col-xs-12">
									<textarea class="form-control" placeholder="Enter Remark" name="delivery_remark" required></textarea>
								</div>-->
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
				</form>
			</div>
		</div>
	</div>
</div>
</div>
</div>