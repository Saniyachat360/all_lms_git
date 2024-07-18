<script>
	function validate_form() {
		var new_pwd = document.forms["change_password"]["new_pwd"].value;
		var c_pwd = document.forms["change_password"]["c_pwd"].value;
		if(c_pwd!=new_pwd)
		{
			alert("New Password & Confirm Password Should Be Same");
			return false;
		}
		if(new_pwd.length<7){
			alert("New Password Must be 7 character");
			return false;
		}
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


	
</script>




<!--<ol class="breadcrumb bc-3" > <li> <a href="index.php"><i class="fa fa-home"></i>Home</a> </li><li class="active"> <strong>Change Password </strong> </li> </ol>-->
	
	

  <div class="container body" style="width: 100%;">


       
<div class="container" >
	<div class="col-md-12" >
		<h1 style="text-align:center;">Change Password</h1>
		<div class="panel panel-primary">

			<div class="panel-body">
				<?php
						echo $this->session->flashdata('message_name');
				?>
				<form name="change_password" action="<?php echo $var;?>" method="post" onsubmit="return validate_form();">

					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
					
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-md-offset-1 col-xs-12" >Old Password: </label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input type="password" required autocomplete="off" class="form-control"  onkeyup="return limitlength(this, 15)" name="old_pwd" >
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-md-offset-1 col-xs-12" >New Password: </label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input  type="password" onkeyup="return limitlength(this, 15)" autocomplete="off"class="form-control" id="email" name="new_pwd" required>

								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-md-offset-1 col-xs-12" >Confirm Password: </label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input  type="password" autocomplete="off" onkeyup="return limitlength(this, 15)" class="form-control" id="email" name="c_pwd" required>

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
				</form>
			</div>
		</div>
	</div>
</div>
</div>
</div>