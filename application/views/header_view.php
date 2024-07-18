<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>LMS</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css" id="style-resource-4">
</head> 
<body>
	<script  src="<?php echo base_url(); ?>assets/js/jquery-1.11.3.min.js"></script>
	<script  src="<?php echo base_url(); ?>assets/js/bootstrap.js" id="script-resource-3"></script>

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
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Dashboard</a></li>
                <li><a href="#">Calling Task</a></li>
                  <li><a href="#">Tracker</a></li>
                 <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Report <b class="caret"></b></a>
                   <ul class="dropdown-menu">
                        <li><a href="#">Daily Report</a></li>
                         <li class="divider"></li>
                        <li><a href="#">Monthly Report</a></li>
                         <li class="divider"></li>
                        <li><a href="#">Yearly Report</a></li>
                       
                    </ul>
                </li>
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Upload & Download <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Stock</a></li>
                         <li class="divider"></li>
                        <li><a href="#">Price</a></li>
                         <li class="divider"></li>
                        <li><a href="#">Broucher</a></li>
                       
                    </ul>
                </li>
                   <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Lead Management <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Add Leads</a></li>
                         <li class="divider"></li>
                        <li><a href="#">Assign Leads</a></li>
                      
                       
                    </ul>
                </li>
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Master Setup <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Manage</a></li>
                         <li class="divider"></li>
                        <li><a href="#">Rights</a></li>
                      
                       
                    </ul>
                </li>
            </ul>
         <!--   <form class="navbar-form navbar-left">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div>
         </form>-->
            <ul class="nav navbar-nav navbar-right">
            	 <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Notifications <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                    	 <li><a href="#">New Followup</a></li>
                         <li class="divider"></li>
                        <li><a href="#">Todays Followup</a></li>
                         <li class="divider"></li>
                        <li><a href="#">Pending Followup</a></li>
                           <li class="divider"></li>
                        <li><a href="#">Pending Untouch Followup</a></li>
                      
                       
                    </ul>
                </li>
            	 <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">	<strong  style='font-size:14px;color:#fff'> <?php echo  substr($_SESSION['username'], 0, 15);$st =strlen($_SESSION['username']); if($st>15){ echo '..';}?></strong> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Change Password</a></li>
                         <li class="divider"></li>
                        <li><a href="#">Logout</a></li>
                      
                       
                    </ul>
                </li>
            	<!--<li><a href="#">Welcome : 	<strong  style='font-size:14px;color:#fff'><?php echo  substr($_SESSION['username'], 0, 10);$st =strlen($_SESSION['username']); if($st>10){ echo '..';}?></strong></a></li>
                <li><a href="#">Logout</a></li>-->
            </ul>
        </div>
    </nav>
                       