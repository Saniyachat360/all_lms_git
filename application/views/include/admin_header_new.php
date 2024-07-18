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
	<script>
		function change_header_data(x)
		{
			
			$.ajax({
				url:'<?php echo site_url('login/change_header_data')?>',
				type:'POST',
				data:{process_id:x},
				success:function(response)
				{
					if(response !='')
					{
						alert(response);
					}					
					window.location.replace("<?php echo site_url('notification');?>");
				
				}
				});

				}
				function change_header_data1(x)
		{
			$.ajax({
				url:'<?php echo site_url('login/change_header_data1')?>',
				type:'POST',
				data:{sub_poc_purchase:x},
				success:function(response)
				{					
					window.location.replace("<?php echo site_url('notification');?>");
				
				}
			});
		}
		
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
			$form_name = $_SESSION['form_name'];
			//$controller_name = $_SESSION['controller_name'];
			$view = $_SESSION['view'];
			$insert = $_SESSION['insert'];
			if(isset($_SESSION['view_complaint']))
			{
				$view_complaint = $_SESSION['view_complaint'];
			}
			else {
				$view_complaint='';
			}
			if(isset($_SESSION['view_report']))
			{
				$view_report = $_SESSION['view_report'];
			}
			else {
				$view_report='';
			}
							
			$header_process_id=$_SESSION['process_id'];
			$header_process_name=$_SESSION['process_name'];
			$header_location_id=$_SESSION['location_id'];
			$header_location=$_SESSION['location'];
			$header_user_id=$_SESSION['user_id'];
			$header_role=$_SESSION['role'];
			$daily_from_date = date('Y-m-d');
			$daily_to_date = date('Y-m-d');
			$monthly_from_date = date('Y-m-01');
			$monthly_to_date = date('Y-m-31');
	
		
			?>
			<div id="navbarCollapse" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					
				<li>
				<div class="form-group" style="margin-top: 12px;margin-bottom: 0px; margin-right: 7px;">
                	<select class="filter_s col-md-12 col-xs-12 form-control"  onchange="change_header_data(this.value)" style="font-size: 12px;padding:6px 0px;">
						<option value="<?php echo $header_process_id; ?>"><?php  echo $header_process_name; ?></option>
						 <?php
							
							$query1 = $this->db->query("select p.process_id ,p.process_name 
									from lmsuser l 
									Left join tbl_manager_process mp on mp.user_id=l.id 
									Left join tbl_process p on p.process_id=mp.process_id
									where mp.user_id='$header_user_id' and mp.process_id !='$header_process_id' group by p.process_id order by FIELD(p.process_id, '6', '7','8','9', '1', '4', '5')")->result();
									
								foreach($query1 as $row){?>
									<option value="<?php echo $row -> process_id; ?>"><?php  echo $row -> process_name; ?></option>
								<?php 		}
							?>		
                    </select>
               </div>
               </li>   
                <?php if($header_process_id==8)
               {
               	?>
               	  <li>
               	 <div class="form-group" style="margin-top: 12px;margin-bottom: 0px;"> 
             	<select class="filter_s col-md-12 col-xs-12 form-control"  onchange="change_header_data1(this.value)" style="font-size: 12px;padding:6px 0px;">
						<?php if(isset($_SESSION['sub_poc_purchase']))
						{
							
							if($_SESSION['sub_poc_purchase']==2)
							{
								?>
								<option value="2">POC Purchase Tracking</option>
								<?php	
							}
							else {
								?>
								<option value="1">POC Purchase </option>
								<?php
							}
							
						}?>
						
						<option value="1">POC Purchase</option>							
						<option value="2">POC Purchase Tracking</option>
								
                    </select>
              </div>
               </li>  
               	<?php
               }         
			/* check rights of these four menus    process_id=>array_possition */
		$tracker_array = array(6=>13,7=>28,1=>38,4=>46,5=>54,8=>74);	
		$new_lead_array = array(6=>1,7=>22,1=>32,4=>40,5=>48, 8=>68);
		$assign_lead_array = array(6=>4,7=>23,1=>33,4=>41,5=>49,8=>69);
		$assign_transferred_lead_array = array(6=>17, 7=>24,1=>34,4=>42,5=>50,8=>70);		
		
		foreach($tracker_array as $key=>$value){
			//echo $value;
		if($key == $header_process_id){
				$rightarray[]= $value;		
			}
		}
		foreach($new_lead_array as $key=>$value){
		if($key == $header_process_id){
		
				$rightarray[]= $value;		
			}
		}
		foreach($assign_lead_array as $key=>$value){
		if($key == $header_process_id){
		
				$rightarray[]= $value;		
			}
		}
		foreach($assign_transferred_lead_array as $key=>$value){
		if($key == $header_process_id){
		
				$rightarray[]= $value;		
			}
		}
		if(isset($rightarray))
		{
			$t1=count($rightarray);
			for($j=0;$j<$t1;$j++)
			{
				 $viewvalue=$rightarray[$j];
				//echo"<br>";
				if(isset($view[$viewvalue]))
				{ 
					//	echo $view[$viewvalue];
					//echo"<br>";
						$namearray[]=$view[$viewvalue];	
				}else{
					$namearray=array(0,0,0,0);	
				}
			}
		}
//print_r($rightarray);	

			
			?>	
					<!-- Dashboard -->
					<li class="dropdown">
						<a  href="<?php echo site_url(); ?>notification">Dashboard </a>
					</li>

					<!-- Calling task notification -->

					<?php if(isset($view[15]) && $_SESSION['role']!=1){
					if($view[15]==1 ){?>
					<li class="dropdown">
						<?php if($header_process_id == 9) {?>
							<a  href="<?php echo site_url(); ?>website_leads/complaint">Calling task </a>
							<?php }else {?>
							<a  href="<?php echo site_url(); ?>new_lead">Calling task </a>
							<?php } ?>
					</li>
					<?php }else{ ?>
					<li class="dropdown">
						<?php if($header_process_id == 9) {?>
							<a  href="<?php echo site_url(); ?>website_leads/complaint">Calling task </a>
							<?php }else {?>
							<a  href="<?php echo site_url(); ?>website_leads/telecaller_leads">Calling task </a>
							<?php } ?>
					</li>
					<?php } }
					if($_SESSION['role']==1){ ?>
					<li class="dropdown">
							<?php if($header_process_id == 9) {?>
							<a  href="<?php echo site_url(); ?>website_leads/complaint">Calling task </a>
							<?php }else {?>
							<a  href="<?php echo site_url(); ?>website_leads/telecaller_leads">Calling task </a>
							<?php } ?>
					</li>
					<?php } ?>
					<?php 
					/*
					if(isset($view[13]))
					{
						if(($view[13]==1 && $header_process_id==6))
						{	$v13=1;	}
					}
					if(isset($view[28]))
					{
						if(($view[28]==1 && $header_process_id==7))
						{ $v13=1; }
					}
					if(isset($view[38]))
					{
						if(($view[38]==1 && $header_process_id==1))
						{ $v13=1;	}
					}
					if(isset($view[46]))
					{
						if(($view[46]==1 && $header_process_id==4))
						{ $v13=1;	}
					}
					if(isset($view[54]))
					{
						if(($view[54]==1 && $header_process_id==5))
						{$v13=1; }
					}*/
					?>
					
					
					<?php 
					if(isset($namearray))
							{
								if($namearray[0]==1) {
									?>	
					<!--- Tracker -->
					<li class="dropdown">
						
							<a  href="<?php echo site_url(); ?>new_tracker/leads">Tracker </a>
							
					</li>
					<?php
								}
							}else if(isset($view_complaint['4']))
							{
							
							if($view_complaint[4]==1 && $header_process_id==9)
								{						
							?>
					
					<!--- Tracker -->
					<li class="dropdown">						
							<a  href="<?php echo site_url(); ?>new_tracker/leads">Tracker </a>
					</li>
					<?php } 
					}?>
					<!-- Report -->
					<?php if(!empty($view_report)){ ?>
					<li class="dropdown">
						<a data-toggle="dropdown" class="dropdown-toggle" href="#">Report <b class="caret"></b></a>
						<ul class="dropdown-menu">
			
							<?php /*if(isset($view[61]))
							{ 
							if(($view[61]==1))
							{	*/					
							?>
						<!--	<li>
								<a href="<?php echo site_url(); ?>lead_report">Lead Report</a>
							</li>
							<li class="divider"></li> -->
							<?php // } } ?>
							<?php /* if(isset($view[60]))
							{
								if(($view[60]==1))
							{ 
								*/					
							?>	
						<!--	<li>
								<a href="<?php echo site_url(); ?>dsewise_dashboard">DSE Wise Report</a>
							</li>
								<li class="divider"></li>-->
						<?php 
							/*}
							 } */ ?>
							 <?php 
					if(($header_process_id==6 ||$header_process_id==7 || $header_process_id==8) )
					{  ?>
						<!-- Source Wise -->
						<?php if(isset($view_report[0]) && isset($view_report[10]) && isset($view_report[20])){
						 	if(($view_report[0]==1  && $header_process_id==6) || ($view_report[10]==1 && $header_process_id==7) || ($view_report[10]==1 && $header_process_id==7)|| ($view_report[20]==1 && $header_process_id==8)){ ?>
						 	<li><a href="<?php echo site_url(); ?>reports/lead_sourcewise">Source Wise</a></li>
						 	<li class="divider"></li>
						 <?php } } ?>
						 
						 <!-- CSE Report -->
						 	<?php if(($view_report[1]==1 && $header_process_id==6)|| ($view_report[2]==1 && $header_process_id==6) || ($view_report[11]==1  && $header_process_id==7)||($view_report[12]==1   && $header_process_id==7) || ($view_report[21]==1  && $header_process_id==8)||($view_report[22]==1   && $header_process_id==8)){?>			
								<li class="dropdown dropdown-submenu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">CSE Reports</a>
								<ul class="dropdown-menu">
										 <?php if(isset($view_report[1]) && isset($view_report[11]) && isset($view_report[21])){
						 	if(($view_report[1]==1  && $header_process_id==6) || ($view_report[11]==1 && $header_process_id==7)|| ($view_report[21]==1 && $header_process_id==8)){ ?>
						 <li><a href="<?php echo site_url(); ?>CSE_reports"><span class="title">Productivity</span></a></li>
						<li class="divider"></li>
						 <?php } } ?>
						 	 <?php if(isset($view_report[2]) && isset($view_report[12]) && isset($view_report[22])){
						 	if(($view_report[2]==1  && $header_process_id==6) || ($view_report[12]==1 && $header_process_id==7)|| ($view_report[22]==1 && $header_process_id==8)){ ?>
						<li>
									<a href="<?php echo site_url(); ?>reports/cse_performance"><span class="title">Performance</span></a>
									</li>
						 <?php } } ?>	
									</ul>
								</li>
								<li class="divider"></li>
								<?php } ?>
								
								<!-- Location Wise -->
								 <?php if(isset($view_report[3]) && isset($view_report[13]) && isset($view_report[23])){
						 	if(($view_report[3]==1  && $header_process_id==6) || ($view_report[13]==1 && $header_process_id==7)|| ($view_report[23]==1 && $header_process_id==8)){ ?>
							<li><a href="<?php echo site_url(); ?>reports/locationwise_report">Location Wise</a></li>
						<li class="divider"></li>
						 <?php } } ?>
						 
						 <!-- Appointment -->
								 <?php if(isset($view_report[4]) && isset($view_report[14]) && isset($view_report[24])){
						 	if(($view_report[4]==1  && $header_process_id==6) || ($view_report[14]==1 && $header_process_id==7)| ($view_report[24]==1 && $header_process_id==8)){ ?>
					<li><a href="<?php echo site_url(); ?>CSE_reports/appointment_report">Appointment</a></li>
					<li class="divider"></li>
						 <?php } } ?>
						 
						<!-- DSE Report -->			
								<?php if(($view_report[5]==1  && $header_process_id==6) || ($view_report[15]==1 && $header_process_id==7) || ($view_report[6]==1  && $header_process_id==6) || ($view_report[16]==1 && $header_process_id==7)|| ($view_report[25]==1  && $header_process_id==8) || ($view_report[26]==1 && $header_process_id==8)){  ?>
								<li class="dropdown dropdown-submenu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">DSE Reports</a>
								<ul class="dropdown-menu">
									 <?php if(isset($view_report[5]) && isset($view_report[15]) && isset($view_report[25])){
						 	if(($view_report[5]==1  && $header_process_id==6) || ($view_report[15]==1 && $header_process_id==7)|| ($view_report[25]==1 && $header_process_id==8)){ ?>
						<li>
									<a href="<?php echo site_url(); ?>new_reports/productivity_report"><span class="title">Productivity</span></a>
									</li>
									<li class="divider"></li>
						 <?php } } ?>
									<?php if(isset($view_report[6]) && isset($view_report[16]) && isset($view_report[26])){
						 	if(($view_report[6]==1  && $header_process_id==6) || ($view_report[16]==1 && $header_process_id==7) || ($view_report[26]==1 && $header_process_id==8)){ ?>
					<li>
									<a href="<?php echo site_url(); ?>new_reports/performance_report"><span class="title">Performance</span></a>
									</li>
									<li class="divider"></li>
						 <?php } } ?>
									
									</ul>
								</li>
								<li class="divider"></li>
								<?php } ?>
						<?php
					}
					?>
					<?php if(isset($view_report[7]) && isset($view_report[17]) && isset($view_report[27])){
						 	if(($view_report[7]==1  && $header_process_id==6) || ($view_report[17]==1 && $header_process_id==7) || ($view_report[27]==1 && $header_process_id==8)){ ?>
					<li>
									<a href="<?php echo site_url(); ?>one_pager_report"><span class="title">One Pager Report</span></a>
									</li>
									<li class="divider"></li>
						 <?php } } ?>
									
					<!-- Add DSE Daily Report -->
						<?php 
						if($header_process_id !=9)
						{
						 if(isset($view_report[8]) && isset($view_report[18]) && isset($view_report[28]))
							{
								if(($view_report[8]==1  && $header_process_id==6) || ($view_report[18]==1  && $header_process_id==7) || ($view_report[28]==1  && $header_process_id==8)) { ?>
								<li>
									<a href="<?php echo site_url(); ?>dse_daily_reporting">Add DSE Daily Reporting</a>
								</li>
								<li class="divider"></li>
								<?php } 
							} ?>
							
							<!-- DSE Daily Report -->
							<?php
							if(isset($view_report[9]) && isset($view_report[19]) && isset($view_report[29]))
							{
								if(($view_report[9]==1 && $header_process_id==6) || ($view_report[19]==1 && $header_process_id==7) || ($view_report[29]==1 && $header_process_id==8))	{ 	 ?>
								<li>
									<a href="<?php echo site_url(); ?>dse_daily_reporting/show_data">View DSE Daily Reporting</a>
								</li>
								<?php } 
							}
						} ?>
						
								
								 	
						
				
						</ul>
					</li>
					
					<?php } ?>
					
					<?php
					if($header_process_id !=9)
					{
					if(isset($view[11]) || isset($view[20]) || isset($view[30]) || isset($view[66]) )
					{
			if($view[11]==1 || $view[20]==1 || $view[30]==1 || $view[66]==1){
				?>
					<!-- Upload -->
					<li class="dropdown">
						<a data-toggle="dropdown" class="dropdown-toggle" href="#">Upload <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php if($view[11]==1){	?>
							<li>
								<a href="<?php echo site_url(); ?>upload_xls"><span class="title">Lead</span></a>
							</li>
							<li class="divider"></li>
							<?php } ?>
							<?php 
							if(isset($view[30]) || isset($view[66]))
							{
							if($view[30]==1 || $view[66]==1){	?>
							<li>
								<a href="<?php echo site_url(); ?>upload_xls1"><span class="title">Stock </span></a>
							</li>
							<li class="divider"></li>
							<?php } } ?>
							<?php if($view[20]==1){	?>
							<li>
								<a href="<?php echo site_url(); ?>upload_brochure"><span class="title">Brochure</span></a>
							</li>
							<li class="divider"></li>
							<?php } ?>
							<?php if(isset($view[20]))
							{
							if($view[20]==1){	?>
							<li>
								<a href="<?php echo site_url(); ?>upload_quotation"><span class="title">Quotation</span></a>
							</li>
							<li class="divider"></li>
								<li class="dropdown dropdown-submenu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Accessories</a>
								<ul class="dropdown-menu">
									<li>
									<a href="<?php echo site_url(); ?>accessories_package"><span class="title">Accessories Package</span></a>
									</li>
									<li class="divider"></li>
									<li>
									<a href="<?php echo site_url(); ?>accessories_package/items"><span class="title">Package Items</span></a>
									</li>
									</ul>
								</li>
								<?php } } ?>
						</ul>
					</li>
					<?php } } }?>
					
					<!-- Lead Management -->
					<li class="dropdown">
						<a data-toggle="dropdown" class="dropdown-toggle" href="#">Lead Management <b class="caret"></b></a>
						<ul class="dropdown-menu">

							<!-- Add New Leads -->
							
						<?php /*if(isset($view[1]) || isset($view[22]) || isset($view[32])|| isset($view[40]) || isset($view[48]))
						{ 
							if(($view[1]==1 && $header_process_id==6) || ($view[22]==1 && $header_process_id==7) || ($view[32]==1 && $header_process_id==1) || ($view[40]==1 && $header_process_id==4) || ($view[48]==1 && $header_process_id==5))
							{	*/
							if(isset($namearray))
							{
								if($namearray[1]==1) {					
							?>	
							<li><a href="<?php echo site_url(); ?>add_new_customer"><span class="title">Add New Lead</span></a>
							</li>
							<li class="divider"></li>
							<?php }
							} 
							else if(isset($view_complaint['0']))
							{
							if($view_complaint[0]==1 && $header_process_id==9)
							{
								?>
								<li>
								
								<a href="<?php echo site_url(); ?>add_new_customer"><span class="title">Add New Complaint</span></a>
								
								
							</li>
							<li class="divider"></li>
							<?php
							}}
							?>
							
							<!-- Assign Leads -->
							
							
								<?php if(isset($namearray))
							{
								if($namearray[2]==1) {
									?>	
									<li>
										
								<a href="<?php echo site_url(); ?>assign_leads"><span class="title">Assign New Leads</span></a>
								
									
									</li>
									<li class="divider"></li>
									<?php 
								}}
										
								else if(isset($view_complaint['1']))
							{if($view_complaint[1]==1 && $header_process_id==9){					
										?>	
									<li>
										
								<a href="<?php echo site_url(); ?>assign_leads/complaint"><span class="title">Assign Complaints</span></a>
								
									
									</li>
									<li class="divider"></li>
									<?php } }
									
									/* if(isset($view[17]) || isset($view[24]) || isset($view[34])|| isset($view[42]) || isset($view[50]))
									{ 
										if(($view[17]==1 && $header_process_id==6) || ($view[24]==1 && $header_process_id==7) || ($view[34]==1 && $header_process_id==1) || ($view[42]==1 && $header_process_id==4) || ($view[50]==1 && $header_process_id==5))
										{*/	
									if($header_process_id !=9)
									{
										if($namearray[3]==1){			
										?>	
									<li>
										<a href="<?php echo site_url(); ?>Assign_transferred/admin"><span class="title">Assign Transferred Leads</span></a>
									</li>
									<!--<li class="divider"></li>
									<li>
									<a href="<?php echo site_url(); ?>manually_transfer_lead/telecaller_leads"><span class="title">Manually Leads</span></a>
									</li>
									<li class="divider"></li>-->
									<?php } } ?>
						</ul>
					</li>

					<!-- Master -->
					<?php 
					
						if($view[0]==1 || $view[2]==1 || $view[3]==1 || $view[5]==1 || $view[6]==1 || $view[7]==1 || $view[8]==1 || $view[14]==1 || $view[62]==1){?>

					<li class="dropdown">
						<a data-toggle="dropdown" class="dropdown-toggle" href="#">Master <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<!-- Add Location -->
							<?php 
							if(isset($view[0]))
							{
							if($view[0]==1){
							?>
							<li>
							<a href="<?php echo site_url(); ?>add_location"><span class="title">Add Location</span></a>

							</li>
							
							<li class="divider"></li>
							<li>
							<a href="<?php echo site_url(); ?>add_process"><span class="title">Add Process</span></a>

							</li>
							
							<li class="divider"></li>
							<?php } } 
							
							if(isset($view[3]))
							{
							if($view[3]==1){
							?>
							<li>
							<a href="<?php echo site_url(); ?>Link_process_location"><span class="title">Map Location to Process</span></a>

							</li>
							
							<li class="divider"></li>
							
							<?php } } ?>
							<!-- Add Group -->
							<?php if($view[5]==1){
							?>
							<li>
								<a href="<?php echo site_url(); ?>add_leadsource"><span class="title">Add Lead Source</span></a>
							</li>
							<li class="divider"></li>


							<?php } ?>
							<?php if($view[5]==1){
							?>
							<li>
								<a href="<?php echo site_url(); ?>add_leadsource/add_sub_lead_source"><span class="title">Add Sub Lead Source</span></a>
							</li>
							<li class="divider"></li>


							<?php } ?>
							<!-- Add User -->
							<?php if($view[2]==1){
							?>
							<li>
							<a href="<?php echo site_url(); ?>add_lms_user"><span class="title">Add User</span></a>
							</li>
							<li class="divider"></li>
							<?php } ?>

							<!-- Add Rights -->
							<?php if($view[8]==1){
							?>
							<!--<li>
							<a href="<?php echo site_url(); ?>add_right"><span class="title">Add User Rights</span></a>
							</li>-->
							<li class="dropdown dropdown-submenu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Add User Rights</a>
								<ul class="dropdown-menu">
									<li>
									<a href="<?php echo site_url(); ?>add_right"><span class="title">All Rights</span></a>
									</li>
									<li class="divider"></li>
									<li><a href="<?php echo site_url(); ?>add_right/complaint"><span class="title">Complaint Rights</span></a></li>
									<li class="divider"></li>
									<li><a href="<?php echo site_url(); ?>add_rights_report"><span class="title">Report Rights</span></a></li>
									
									</ul>
								</li>
							<li class="divider"></li>
							<?php } ?>

						<!-- Add Default Call Center TL -->
							<?php if($view[21]==1){
							?>
							
							<li>
							<a href="<?php echo site_url(); ?>add_call_center_tl"><span class="title">Add Default Call Center TL</span></a>
							</li>
							<li class="divider"></li>
							<?php } ?>

							<!-- Add Status -->
							<?php if($view[6]==1){
							?>
							
							<!-- Add Feedback Status-->
							<li>
							<a href="<?php echo site_url(); ?>Feedback_status"><span class="title">Add Feedback Status</span></a>
							</li>
							<li class="divider"></li>

							<?php } ?>

							<!-- Add Disposition -->
							<?php if($view[7]==1){
							?>
							
							<li>
							<a href="<?php echo site_url(); ?>Next_action"><span class="title">Add Next Action Status</span></a>
							</li>
							<li class="divider"></li>
							<?php } 
							if(isset($view[14]))
							{
							if($view[14]==1){
							?>
							
							<li>
							<a href="<?php echo site_url(); ?>map_next_action_to_feedback"><span class="title">Map Next Action</span></a>
							</li>
							<li class="divider"></li>
							<?php  } } ?>
							<?php
							if(isset($view[62]))
							{
							if($view[62]==1){
							?>
								<li>
							<a href="<?php echo site_url(); ?>add_sms"><span class="title">Add SMS</span></a>

							</li>
							<?php } } ?>
							
						<?php if($view[19]==1){?>
								<li class="divider"></li>
								<li>
							<a href="<?php echo site_url(); ?>add_lms_user/download_lms_user"><span class="title">Download User Details</span></a>
							</li>
							<?php } ?>
							

							
						</ul>
					</li>
					<?php  }   ?>
					<!-- Search Customer -->
					<li class="dropdown">
						<a data-toggle="dropdown" class="dropdown-toggle" href="#">Customer Operation <b class="caret"></b></a>

						<ul class="dropdown-menu">
							<!-- Customer  Operation -->
						
							<?php 
							if(isset($view[56]))
							{
							if($view[56]==1){
							?>
							<li>
								<a href="<?php echo site_url(); ?>search_customer"><span class="title">Search Customer</span></a>
							</li>
							<li class="divider"></li>
							<?php  } } ?>
							<?php 
							if($header_process_id !=9)
							{
							if(isset($view[57]))
							{
							if($view[57]==1){
							?>
							
							<li>
								<a href="<?php echo site_url(); ?>edit_customer"><span class="title">Edit Customer</span></a>
							</li>
							<li class="divider"></li>
							<?php }  }
							}?>
							<?php 
							if(isset($view[31]))
							{
							if($view[31]==1 && $header_process_id==7){
								?>
								<li>
						<a  href="<?php echo site_url(); ?>used_car_stock/with_model"><span class="title">POC Stock</span></a>
					</li>
					
								<?php
							}
							}
							if(isset($view[67]))
							{
							if($view[67]==1 && $header_process_id==6){
								?>
								<li>
					<a href="<?php echo site_url(); ?>New_car_stock/with_model"><span class="title">New Car Stock</span></a>
					</li>
						
								<?php
							}
							}
							?>
							<?php if(($_SESSION['role']==1 || $_SESSION['role']==2) && $_SESSION['process_name']=='New Car'){?>
								<li class="divider"></li>
								<li>
								<a href="<?php echo site_url(); ?>duplicate_lead_tracker/leads"><span class="title">Duplicate Lead Tracker</span></a>
							</li>
							<?php } ?>
						</ul>
					</li>
						
					<?php
					/* $id=$_SESSION['user_id'];
					 $querym=$this->db->query("select role_name from lmsuser where id = '$id'")->result();
					 if(($_SESSION['role']==1) || ($_SESSION['role']==2 && $querym[0]->role_name=='Manager'))
					 {*/?>
					 <!--<li>
					 <a href="<?php echo site_url(); ?>send_bulk_sms"><span class="title">Send Bulk SMS</span></a>

					 </li>-->
					 <?php //} 
 ?>

					<!-- Script -->
					<?php /* if($_SESSION['role'] !=1) {?>
						 <li>
						 <a href="<?php echo site_url(); ?>CSE_Scripts"><span class="title">Script</span></a>
						 </li>
						 <?php } */
 ?>

				

				</ul>

				<ul class="nav navbar-nav navbar-right">

					<li class="dropdown">
						<a data-toggle="dropdown" class="dropdown-toggle" href="#"> <strong  style='font-size:14px;color:#fff'> <?php echo substr($_SESSION['username'], 0, 15);
						$st = strlen($_SESSION['username']);
						if ($st > 15) { echo '..';
						}
 ?> </strong> <b class="caret"></b></a>
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
