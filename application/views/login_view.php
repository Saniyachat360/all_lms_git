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

	</head>
	<body class="page-body login-page login-form-fall">
		
		<script>
			function submitdata() {

				var a = document.forms["f1"]["username"].value;
				var atpos = a.indexOf("@");
				var dotpos = a.lastIndexOf(".");
				if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= a.length) {

					document.getElementById('name').innerHTML = "<font color='red'>Not a valid e-mail address!</font>";

					f1.username.focus();
					return false;
				}

				var pwd = document.forms["f1"]["password"].value;

				if (pwd == '') {

					document.getElementById('pwd').innerHTML = "<font color='red'>Password field is required.</font>";

					f1.password.focus();
					return false;
				}

			}
		</script>

	
		<?php echo $this -> session -> flashdata('message_name'); ?>



		<div class="login-container">
			<div class="login-header login-caret" style="padding: 20px">
				<div class="" style="text-align: center;padding-top: 23px;">
					<a href="#" class="logo"><!--<h1 style="color:white;"><i class="" style="font-size: 26px;"></i>LMS Login</h1>--><img src="<?php echo base_url();?>assets/images/LMS Logo.PNG"> </a>
					<p class="description" style="color:#fff">
						Dear User, Log in to Access the Admin Area of Lead Management System!
					</p>
<div class="login-content">
					<?php echo $this -> session -> flashdata('message'); ?></div>
					<!-- progress bar indicator -->
					<div class="login-progressbar-indicator">
						<h3>43%</h3><span>logging in...</span>
					</div>
				</div>
			</div>
			<div class="login-progressbar">
				<div></div>
			</div>
			<div class="login-form" style="padding: 30px;padding-bottom: 0px">
				<div class="login-content">
					<div class="form-login-error">
						<h3>Invalid login</h3>
						<p>
							Enter <strong>demo</strong>/<strong>demo</strong> as login and password.
						</p>
					</div>
					
					<form name="f1" method="post"  action="<?php echo $var; ?>" onsubmit="return submitdata()">
						
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="entypo-user"></i>
								</div>

								<input type="text" class="form-control" id ="username" name="username"  placeholder="Username" autocomplete="off" required/>

							</div>
							<div id="name" style="margin-top:10px;"></div>

						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="entypo-key"></i>
								</div>
								<input type="password" class="form-control" id="password" name="password"  placeholder="Password" autocomplete="off" />

							</div>

							<div id="pwd" style="margin-top:10px;"></div>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-block btn-login">
								<i class="entypo-login"></i>
								Login
							</button>
						</div>
					
						<div class="form-group col-md-5"  style="padding: 0px">
							<a href="<?php echo site_url(); ?>forgot_password" class="f12">Forgot Password?</a>
						</div>
						<div class="form-group col-md-7" style="padding: 0px">
								<!--a href="<?php echo site_url();?>sign_up" style="color:#444;font-size: 17px" >
							
							
	Sign up for Cross Lead <i class="entypo-right-open"></i>
							</a-->
							<a href="<?php echo site_url();?>sign_up/login_with_otp" style="color:#444;font-size: 17px" >
							
							
	Login with OTP <i class="entypo-right-open"></i>
							</a>
						</div>
					<!--	<div class="login-bottom-links">
							<a href="<?php echo site_url();?>sign_up" style="color:#fff;font-size: 17px" >
							
							
	Sign up for Cross Lead <i class="entypo-right-open"></i>
							</a>
					</div>-->
						<!--<div class="login-bottom-links">
							<a href="<?php echo site_url();?>sign_up" style="color:#fff;font-size: 17px" >
							
							
	Sign up for Cross Lead <i class="entypo-right-open"></i>
							</a>
						</div>-->
					
							
					</form>
			<!--<div class="login-bottom-links">
					<a href="http://demo.neontheme.com/extra/forgot-password/" class="link">Forgot your password?</a> <br /> <a href="#">ToS</a> - <a href="#">Privacy Policy</a>
					</div>-->

				</div>
				
		
			</div>
		</div>
		<div style="background-color: #154a87;padding: 25px;text-align: center; position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;">
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