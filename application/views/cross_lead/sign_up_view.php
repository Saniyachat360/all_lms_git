<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="" />
		<meta name="author" content="" />
		<title>LMS </title>
		<link href="<?php echo base_url(); ?>assets/css/new/jquery.dataTables.min.css" type="text/css" rel="stylesheet" media="all" />
		<link href="<?php echo base_url(); ?>assets/css/new/fixedColumns.dataTables.min.css" type="text/css" rel="stylesheet" media="all" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-icons/entypo/css/entypo.css" id="style-resource-2">
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>assets/css/new/custom.css"/>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css" id="style-resource-4">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-core.css" id="style-resource-5">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-theme.css" id="style-resource-6"><script type="text/javascript">
		function validateForm() {
			//alert ("hi");
		
		var empId = document.getElementById("email").value;	
		var mob = document.getElementById("mobileno").value;
		var pwd = document.getElementById("password").value;
		var pwd1 = document.getElementById("cpassword").value;
			
		
		var atpos = empId.indexOf("@");
		var dotpos =empId.lastIndexOf(".");
		if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >=empId.length) {
			alert("Not a valid e-mail address!");
			return false;
		}
			
		//alert(mob);
		var no = /^\d{10}$/;
		if (no.test(mob)) {
			//return true;
		} else {
			alert("Phone Number must be 10 Digit!");

			return false;
		}
		
	
		
		//alert(pwd.length);
		if((pwd.length) < 8){
			alert("Password must be strong!! ");
			return false;
			}

		if(pwd==pwd1){
		return true;
		}
		else{
		alert("password must be same!");
		return false;
		}
	}
	
	function limitlength(obj, length) {
		var maxlength = length
		if (obj.value.length > maxlength)
			obj.value = obj.value.substring(0, maxlength)
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
		
		
</script>
	  
  

	<div class="row"  role="dialog"  >
		<div class="col-md-12">
			<?php echo $this -> session -> flashdata('message'); ?>
		</div>
		
		<div class="col-md-12" >
		
		<h1 style="text-align:center;">Sign Up</h1>
		
		<div class="panel panel-primary">

			<div class="panel-body">
				<form name='get_form1' action="<?php echo site_url();?>sign_up/insert_user" method="post" onsubmit=" return validateForm()">

					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
					
					
							<div class="form-group">
                            	<label class="control-label col-md-4 col-sm-4 col-xs-12" >User Id: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<?php if(isset($maxEmpId))
										{
											$maxId=substr($maxEmpId[0]->empId,5);
											$maxIdNew=$maxId+1;
											if(strlen($maxIdNew)<2)
											{
												$maxIdNew="AVLMS00".$maxIdNew;
											}
											elseif(strlen($maxIdNew)<3)
											{
												 $maxIdNew="AVLMS0".$maxIdNew;
											}
											else 
											{
												$maxIdNew="AVLMS".$maxIdNew;
											}
										}
										else 
										{
											$maxIdNew="AVLMS001";
										}
                                   ?>

									<input type="text" required readonly="" class="form-control" value="<?php echo $maxIdNew;?>" id="empId" name="empId">
                             
								</div>
							</div> 
						
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" > First Name: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<input type="text" placeholder="Enter First Name" class="form-control" id="fname" name="fname" required >
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" > Last Name: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<input type="text"  placeholder="Enter Last Name" class="form-control" id="lname" name="lname" required >
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" >Email: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<input type="email"  placeholder="Enter Email ID" class="form-control" id="email" name="email1"  required >
								</div>
							</div>

					
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" >Contact No.: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<input  type="tel" placeholder="Enter Moblie Number" onkeypress="return isNumberKey(event)"  onkeyup="return limitlength(this, 10)" class="form-control" id="mobileno" name="mobileno1" required >
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" >Password:</label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									
									<input type="password" autocomplete="off" readonly 
onfocus="this.removeAttribute('readonly');"  class="form-control" id="password" name="password1" placeholder="Enter Password" required  style="background-color: #fff;">
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" > Confirm Password:</label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<input type="password"  class="form-control" id="cpassword" name="cpassword1" placeholder="Enter Confirm Password" required  autocomplete="off" readonly 
onfocus="this.removeAttribute('readonly');">
								</div>
							</div>
							
							
							
							<div class="form-group">
								<div class="col-md-2 col-md-offset-4">
									<button type="submit" id="checkBtn" class="btn btn-success col-md-12 col-xs-12 col-sm-12">Submit</button>
								</div>
								
								<div class="col-md-2">
									<input type="reset" class="btn btn-primary col-md-12 col-xs-12 col-sm-12" value="Reset">
								</div>
							</div>
					</div>
				</form>	
			</div>
		</div>
		</div>
	</div>

	
	
	
	

                    
	



