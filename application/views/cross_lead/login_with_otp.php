<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="" />
		<meta name="author" content="" />

		<title>LMS | Login</title>

		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-icons/entypo/css/entypo.css" id="style-resource-2">

		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css" id="style-resource-4">

		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-forms.css" id="style-resource-7">
		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css" id="style-resource-8">
<style>
	@media only screen and (min-width: 400px) {
  .login-page .login-content {
    width: 350px;
  }
}
</style>
	</head>
	<body class="page-body login-page login-form-fall">
		
		<script>
			function validateForm() {
		
		var empId = document.getElementById("email").value;	
		var mob = document.getElementById("mobileno").value;
		/*var pwd = document.getElementById("password").value;
		var pwd1 = document.getElementById("cpassword").value;*/
		var otp = document.getElementById("otp").value;
		
			
	document.getElementById("email_error").style.display='none';	
	document.getElementById("moblie_error").style.display='none';	
	/*document.getElementById("password_error").style.display='none';	
	document.getElementById("cpassword_error").style.display='none';	*/
	document.getElementById("otp_error").style.display='none';	

		var atpos = empId.indexOf("@");
		var dotpos =empId.lastIndexOf(".");
		if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >=empId.length) {
			document.getElementById("email_error").style.display='block';	
			document.getElementById("email_error").innerHTML="Not a valid e-mail address!";
			return false;
		}
		
		//alert(mob);
		var no = /^\d{10}$/;
		if (no.test(mob)) {
			//return true;
		} else {
		document.getElementById("moblie_error").style.display='block';	
		document.getElementById("moblie_error").innerHTML="Phone Number must be 10 Digit!";
		return false;
		}
		
	
		
	/*	//alert(pwd.length);
		if((pwd.length) < 8){
			document.getElementById("password_error").style.display='block';	
			document.getElementById("password_error").innerHTML="Password must be strong!! ";
			return false;
			}

		if(pwd==pwd1){
		//return true;
		}
		else{
		document.getElementById("cpassword_error").style.display='block';	
		document.getElementById("cpassword_error").innerHTML="password must be same!";
		return false;
		}*/
		var session_otp=document.getElementById("session_otp1").value ;
		
			if(otp != session_otp){
			document.getElementById("otp_error").style.display='block';	
			document.getElementById("otp_error").innerHTML="Not a Valid OTP!";
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
		function send_otp(){
		var no = /^\d{10}$/;
		var moblie_number=document.getElementById('mobileno').value;
		
		document.getElementById("moblie_error").style.display='none';
		
		if (no.test(moblie_number)) {
			//return true;
		} else {
		document.getElementById("moblie_error").style.display='block';	
		document.getElementById("moblie_error").innerHTML="Phone Number must be 10 Digit!";
		return false;
		}
		var email=document.getElementById('email').value;
		document.getElementById("email_error").style.display='none';
			var atpos = email.indexOf("@");
		var dotpos =email.lastIndexOf(".");
		if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >=email.length) {
			document.getElementById("email_error").style.display='block';	
			document.getElementById("email_error").innerHTML="Not a valid e-mail address!";
			return false;
		}
		
		 $.ajax({
		 	url: "<?php echo site_url();?>sign_up/send_otp", 
		 	type:'POST',
		 	data:{'moblie_no':moblie_number,'email':email},
		 	success: function(result){
    $("#otp_div").html(result);        document.getElementById("resendlink").style.display='block';	
    document.getElementById("sendotpdiv").style.display='none';	
  }});
		
	
		}
		function resend_otp(){
		var no = /^\d{10}$/;
		var moblie_number=document.getElementById('mobileno').value;
		document.getElementById("moblie_error").style.display='none';
		var email=document.getElementById('email').value;
		if (no.test(moblie_number)) {
			//return true;
		} else {
		document.getElementById("moblie_error").style.display='block';	
		document.getElementById("moblie_error").innerHTML="Phone Number must be 10 Digit!";
		return false;
		}
		 $.ajax({
		 	url: "<?php echo site_url();?>sign_up/resend_otp", 
		 	type:'POST',
		 	data:{'moblie_no':moblie_number,'email':email},
		 	success: function(result){
    $("#otp_div").html(result); document.getElementById("sendotpdiv").style.display='none';	
  }});
		}
		</script>

		<?php echo $this -> session -> flashdata('message_name'); ?>

		<div class="login-container">
			<div class="login-header login-caret" style="padding: 20px">
				<div class="login-content">
					<a href="#" class="logo"><!--<h1 style="color:white;"><i class="" style="font-size: 26px;"></i>LMS Login</h1>--><!--<img src="<?php echo base_url();?>assets/images/Autovista_white_logo.png">-->
					<p style="color:#fff;font-size: 20px">Login</p> </a>
				

					<?php echo $this -> session -> flashdata('message'); ?>
					<!-- progress bar indicator -->
					<div class="login-progressbar-indicator">
						<h3>43%</h3><span>logging in...</span>
					</div>
				</div>
			</div>
			<div class="login-progressbar">
				<div></div>
			</div>
			<div class="login-form" style="padding: 0px">
				<div class="login-content ">
					<div class="form-login-error">
						<h3>Invalid login</h3>
						<p>
							Enter <strong>demo</strong>/<strong>demo</strong> as login and password.
						</p>
					</div>
					
					<form class="col-md-12" name="f1" action="<?php echo $var;?>"  method="post"  onsubmit="return validateForm()">
						
					
							<div class="form-group col-md-12">
							<div class="input-group " >
								<div class="input-group-addon">
									<i class="entypo-phone"></i>
								</div>
									<input  type="tel" placeholder="Enter Moblie Number" onkeypress="return isNumberKey(event)"  onkeyup="return limitlength(this, 10)" 
									class="form-control" id="mobileno" name="mobileno1" required >
									
							
							</div>
							<div id="moblie_error"  style="color:red;text-align: left;"></div>
							</div>	
					
						<div class="form-group col-md-12">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="entypo-mail"></i>
								</div>
										<input type="email"  placeholder="Enter Email ID" class="form-control" id="email" name="email1"  required >
						
							</div>
                    <div id="email_error"  style="color:red;text-align: left;"></div>
							
						</div>
					
						
							<div class="form-group col-md-4" style="margin-top: 15px;" id='sendotpdiv'>
							
							<a href="#" onclick="send_otp()" style="text-decoration: underline;">Get OTP</a>
								
						</div>
						<div  class="col-md-12" id="otp_div" style="color:#C03C38;font-weight:bold; text-align: left;">
								<input type="tel"   value="<?php if(isset($_SESSION['otp_code'])){ echo $_SESSION['otp_code']; }?>" id="session_otp1"  style="display: none"  class="form-control">
						
							
						</div>
						<div class="col-md-12" id="moblie_error" style="color:red;text-align: left;"></div>
						<div class="clearfix"></div>
							<div class="form-group col-md-8">
							<div class="input-group"  style="width: 200px">
								<div class="input-group-addon">									<i class="entypo-key"></i>								</div>
								<input type="tel"   class="form-control" id="otp" name="otp" placeholder="Enter OTP" required >
							</div>

					
						</div>
						
							<div class="form-group col-md-4" style="margin-top: 15px;">
						
								
								<a href="#" id='resendlink' onclick="resend_otp()" style="text-decoration: underline;display:none">Resend </a>
							
						</div>
						<div class="col-md-12" id="otp_error"  style="color:red;text-align: left;"></div>
						<div class="clearfix"></div>
						<!--div class="form-group col-md-12">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="entypo-key"></i>
								</div>
								<input type="password" autocomplete="off" readonly 
onfocus="this.removeAttribute('readonly');"  class="form-control" id="password" name="password1" placeholder="Enter Password" required >
				
							</div>

						<div id="password_error"  style="color:red;text-align: left;"></div>	
						</div>
						<div class="form-group col-md-12">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="entypo-key"></i>
								</div>
										<input type="password"  class="form-control" id="cpassword" name="cpassword1" placeholder="Enter Confirm Password" required  >
						
							</div>
<div id="cpassword_error"  style="color:red;text-align: left;"></div>
							
						</div-->
						<div class="form-group col-md-12">
							<button type="submit" class="btn btn-primary btn-block btn-login">
								<i class="entypo-login"></i>
								Login
							</button>
						</div>
					
					
					
							
					</form>
			<!--<div class="login-bottom-links">
					<a href="http://demo.neontheme.com/extra/forgot-password/" class="link">Forgot your password?</a> <br /> <a href="#">ToS</a> - <a href="#">Privacy Policy</a>
					</div>-->

				</div>
				
		
			</div>
		</div>
		<div class="col-md-12" style="background-color: #154a87;padding: 25px;text-align: center;margin-top:30px">
	<p style="color:white;">
							©2016 All Rights Reserved by Excell Autovista Pvt Ltd
							</p>
</div>
		<script  src="<?php echo base_url(); ?>assets/js/jquery-1.11.3.min.js"></script>
		<script  src="<?php echo base_url(); ?>assets/js/bootstrap.js" id="script-resource-3"></script>
		<script  src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js" id="script-resource-8"></script>
		<script  src="<?php echo base_url(); ?>assets/js/neon-login.js" id="script-resource-9"></script>
		<!-- JavaScripts initializations and stuff -->
		<!--<script  src="<?php echo base_url(); ?>assets/js/neon-custom.js" id="script-resource-10"></script>-->

	</body>
</html>