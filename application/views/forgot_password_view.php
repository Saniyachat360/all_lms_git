
	
	<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="" />
		<meta name="author" content="" />

		<title>LMS </title>

		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-icons/entypo/css/entypo.css" id="style-resource-2">

		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css" id="style-resource-4">

		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-forms.css" id="style-resource-7">
		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css" id="style-resource-8">

	</head>
	<body class="page-body login-page login-form-fall">

		<?php echo $this -> session -> flashdata('message_name'); ?>

		<div class="login-container" style="margin-bottom: 124px;">
			<div class="login-header login-caret" style="padding: 20px">
				<div class="login-content">
					<a href="#" class="logo"><!--<h1 style="color:white;"><i class="" style="font-size: 26px;"></i>LMS Login</h1>-->
						<!--<img src="<?php echo base_url();?>assets/images/Autovista_white_logo.png">-->
						<p style="color:#fff;font-size: 20px">Forgot Password</p> </a>
					
					<?php echo $this -> session -> flashdata('message'); ?>
					
				</div>
			</div>
			<div class="login-progressbar">
				<div></div>
			</div>
			<div class="login-form" >
				<div class="login-content">
					
						<form action="<?php echo $var;?>" method="post">
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="entypo-mail"></i>
								</div>
										<input type="email"  placeholder="Enter Your Registered Email ID" class="form-control" id="email" name="email"  autocomplete="off"  required >
						<div id="email_error" style="color:red"></div>
							</div>

							
						</div>					
						<div class="form-group">
							<button type="submit" class="btn btn-success btn-block btn-login">
								<i class="entypo-login"></i>
								Submit
							</button>
						</div>
					</form>
			

				</div>
				
		
			</div>
		</div>
		<div style="background-color: #373e4a;padding: 25px;text-align: center">
	<p style="color:white;">
								©2016 All Rights Reserved by autovista
							</p>
</div>
		<script  src="<?php echo base_url(); ?>assets/js/jquery-1.11.3.min.js"></script>
		<script  src="<?php echo base_url(); ?>assets/js/bootstrap.js" id="script-resource-3"></script>
		<script  src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js" id="script-resource-8"></script>
		<script  src="<?php echo base_url(); ?>assets/js/neon-login.js" id="script-resource-9"></script>
	

	</body>
</html>
    