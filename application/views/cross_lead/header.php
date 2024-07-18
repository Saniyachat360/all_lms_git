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
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-theme.css" id="style-resource-6">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/color.css?version=00001">
		<style>
			.marginBottom-0 {
				margin-bottom: 0;
			}

			.dropdown-submenu {
				position: relative;
			}
			.dropdown-submenu > .dropdown-menu {
				top: 0;
				left: 100%;
				margin-top: -6px;
				margin-left: -1px;
				-webkit-border-radius: 0 6px 6px 6px;
				-moz-border-radius: 0 6px 6px 6px;
				border-radius: 0 6px 6px 6px;
			}
			.dropdown-submenu > a:after {
				display: block;
				content: " ";
				float: right;
				width: 0;
				height: 0;
				border-color: transparent;
				border-style: solid;
				border-width: 5px 0 5px 5px;
				border-left-color: #cccccc;
				margin-top: 5px;
				margin-right: -10px;
			}
			.dropdown-submenu:hover > a:after {
				border-left-color: #555;
			}
			.dropdown-submenu.pull-left {
				float: none;
			}
			.dropdown-submenu.pull-left > .dropdown-menu {
				left: -100%;
				margin-left: 10px;
				-webkit-border-radius: 6px 0 6px 6px;
				-moz-border-radius: 6px 0 6px 6px;
				border-radius: 6px 0 6px 6px;
			}
			.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
				color: black !important;
			}
			
		</style>
	</head>
	<body>
		<script  src="<?php echo base_url('assets/js/jquery-1.11.3.min.js');?>"></script>
		<script  src="https://autovista.in/assets/js/jquery-1.12.2.min.js"></script>
		
		<script>
			(function($) {
				$(document).ready(function() {
					$('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
						event.preventDefault();
						event.stopPropagation();
						$(this).parent().siblings().removeClass('open');
						$(this).parent().toggleClass('open');
					});
				});
			})(jQuery);
		</script>
	
		<nav class="navbar navbar-inverse">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="#" class="navbar-brand" style="font-size:20px ;color:#fff"><b>LMS</b></a>
			</div>
			<!-- Collection of nav links, forms, and other content for toggling -->
			<?php
			//All Rights put from session
			
			$view =$_SESSION['view_cross_lead'] ;
			$insert =$_SESSION['insert_cross_lead'] ;
			//basic details		
			$header_user_id=$_SESSION['user_id'];
			$header_role=$_SESSION['role'];	
			?>
			<div id="navbarCollapse" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">					
		
         
					<!-- Dashboard -->
					<li class="dropdown">
						<a  href="<?php echo site_url(); ?>sign_up/dashboard">Dashboard </a>
					</li>
					<li class="dropdown">
						<a  href="<?php echo site_url(); ?>sign_up/all_lead">My Added Leads </a>
					</li>
					<?php if($insert[0]==1){?>
					<li class="dropdown">
						<a  href="<?php echo site_url(); ?>sign_up/add_new_lead">Add New Lead </a>
					</li>
					<?php } ?>
					<li class="dropdown">
						<a  href="<?php echo site_url(); ?>sign_up/profile">Profile </a>
					</li>

					
					
				</ul>

				<ul class="nav navbar-nav navbar-right">

					<li class="dropdown">
						<a data-toggle="dropdown" class="dropdown-toggle" href="#"> <strong  style='font-size:14px;color:#fff'> <?php echo substr($_SESSION['username'], 0, 15);
						$st = strlen($_SESSION['username']);
						if ($st > 15) { echo '..';	} ?> </strong> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>
								<a href="<?php echo site_url(); ?>change_password"> <i class="entypo-key"></i> Change Password</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="<?php echo site_url('login/logout')?>"> <i class="entypo-logout right"></i>Log Out </a>
							</li>

						</ul>
					</li>

				</ul>
			</div>
		</nav>
		<style>
			@media (min-width: 1200px) {
				.container {
					width: 1300px;
				}
			}
		</style>
		<div class="container">
