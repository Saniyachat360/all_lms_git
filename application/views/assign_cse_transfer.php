<body>
<script>
	function select_fromuser()
	{
		var location= document.getElementById("fromLocation").value;
		document.getElementById("leadsdiv").style.display='none';
		$.ajax({
				url:'<?php echo site_url('assign_cse_transfer/select_fromuser')?>',
				type:'POST',
				data:{location:location},
				success:function(response)
				{
					$("#fromuserdiv").html(response);
					var elements = document.getElementById("toLocation").options;

				    for(var i = 0; i < elements.length; i++){
				      elements[i].selected = false;
				    }
				  
				}
		});

	}
	function display_div()
	{
		document.getElementById("leadsdiv").style.display='none';
		document.getElementById("lead_type").value='';
					
	}
	function checkLeads()
	{
		var fromUser= document.getElementById("fromUser").value;
		var lead_type= document.getElementById("lead_type").value;
		var lead_send_from= document.getElementById("lead_send_from").value;			
		document.getElementById("leadsdiv").style.display='block';
		select_to_location();
		if(lead_send_from=='showroom_sent'){
			document.getElementById("lead_send1").disabled = true;			
		}else{
			document.getElementById("lead_send1").disabled = false;
		}
		
		$.ajax({
				url:'<?php echo site_url('Assign_cse_transfer/checkLeads')?>',
				type:'POST',
				data:{fromUser:fromUser,lead_type:lead_type,lead_send_from:lead_send_from},
				success:function(response)
				{$("#leadsdiv").html(response);
				var elements = document.getElementById("toLocation").options;

				    for(var i = 0; i < elements.length; i++){
				      elements[i].selected = false;
				    }				
				}
			});

	}
	function select_to_location()
	{
		var lead_send_from= document.getElementById("lead_send_from").value;
		$.ajax({
				url:'<?php echo site_url('Assign_cse_transfer/select_to_location')?>',
				type:'POST',
				data:{lead_send_from:lead_send_from},
				success:function(response)
				{
					$("#to_location_div").html(response);
				}
		});
					
	}
	function select_touser()
	{
		var toLocation= document.getElementById("toLocation").value;
		var fromUser= document.getElementById("fromUser").value;
		var all_count= document.getElementById("all_count").value;			
		if(toLocation != 38){
			document.getElementById("lead_send1").checked = true;
			document.getElementById("lead_send2").disabled = true;
		}
		else
		{
			var lead_send_from= document.getElementById("lead_send_from").value;	
			if(lead_send_from=='showroom_sent')
			{
				document.getElementById("lead_send1").disabled = true;
				document.getElementById("lead_send2").checked = true;			
			}else
			{
				document.getElementById("lead_send1").disabled = false;
			}					
			document.getElementById("lead_send2").disabled = false;
			
		}
		if(fromUser =='')
		{
			alert("Please select From Location User first");
			return false;
		}
		else
		{
			$.ajax({
			url:'<?php echo site_url('assign_cse_transfer/select_touser')?>',
			type:'POST',
			data:{toLocation:toLocation,fromUser:fromUser},
			success:function(response)
			{$("#touserdiv").html(response);}
			});
		}
	}
	</script>
	<script>
	function get_status (value) {
			  if(value=='new_lead')
			  {
			  	document.getElementById("new_lead").disabled =false;
			  	document.getElementById("today_followup_lead").disabled =true;
			  	document.getElementById("pending_new_lead").disabled =true;
			  	document.getElementById("pending_followup_lead").disabled =true;
			  }else if(value=='today_followup_lead'){
			  	document.getElementById("new_lead").disabled =true;
			  	document.getElementById("today_followup_lead").disabled =false;
			  	document.getElementById("pending_new_lead").disabled =true;
			  	document.getElementById("pending_followup_lead").disabled =true;
			}else if(value=='pending_new_lead'){
					document.getElementById("new_lead").disabled =true;
			  	document.getElementById("today_followup_lead").disabled =true;
			  	document.getElementById("pending_new_lead").disabled =false;
			  	document.getElementById("pending_followup_lead").disabled =true;

			}else if(value=='pending_followup_lead'){
				document.getElementById("new_lead").disabled =true;
			  	document.getElementById("today_followup_lead").disabled =true;
			  	document.getElementById("pending_new_lead").disabled =true;
			  	document.getElementById("pending_followup_lead").disabled =false;
			}
			}
			</script>
	<?php
		$insert=$_SESSION['insert'];
		$header_process_id=$_SESSION['process_id'];
		if(isset($insert[17]) || isset($insert[24]) || isset($insert[34])|| isset($insert[42]) || isset($insert[50]) || isset($insert[70]))
		{ 
			if(($insert[17]==1 && $header_process_id==6) || ($insert[24]==1 && $header_process_id==7) ||($insert[70]==1 && $header_process_id==8) || ($insert[34]==1 && $header_process_id==1) || ($insert[42]==1 && $header_process_id==4) || ($insert[50]==1 && $header_process_id==5))
			{						
				?>	
		<div class="row" >
			<div class="col-md-12">
				<?php echo $this->session->flashdata('msg');?>
			</div>
		<h1 style="text-align:center; ">Call Center Transfer Leads</h1>
		<div class="col-md-12" >
			<div class="panel panel-primary">

				<div class="panel-body">
					
					<form name="myform" action="<?php echo $var1; ?>" method="post" >

						<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
								<div class="col-md-6">
									<div class="form-group">
                                                               	
									<label class="control-label col-md-offset-3 col-md-5 col-sm-5 col-xs-9" for="first-name">
										 From Location </label>
									
								</div>
						 <div class="form-group">
                                                               	
									<label class="control-label col-md-3 col-sm-3 col-xs-4" for="first-name">
										 Location </label>
									<div class="col-md-9 col-sm-9 col-xs-8">
										<select name="fromLocation" id="fromLocation" class="form-control" required onchange="select_fromuser()">
										  <option value="38">Pune Call Center</option>
										</select>
									
									</div>
								</div>
								<div id="fromuserdiv" >
                                <div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-4" for="first-name"> From User</label>
				<div class="col-md-9 col-sm-9 col-xs-8">
					<select name="fromUser" id="fromUser" class="form-control" required onchange="checkLeads()">
                      <option value="">Please Select</option>
                      <?php foreach ($select_user as $row) { ?>
                          <option value="<?php echo $row->id ;?>"><?php echo $row->fname.' '.$row->lname ;?></option>
                     <?php  } ?>
					</select>
			</div>
			</div>
			
                                
		
								</div>
								 <div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-4" for="first-name">  Lead Send From </label>
				<div class="col-md-9 col-sm-9 col-xs-8">
					<select name="lead_send_from" id="lead_send_from" class="form-control" required onchange="checkLeads()">
                      <option value="">Please Select</option>
                      <option value="cse_live">CSE Live Leads</option>
                      <option value="showroom_sent">CSE Showroom Sent Leads</option>
					</select>
			</div>
			</div>
								  <div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-4" for="first-name"> Lead Type</label>
				<div class="col-md-9 col-sm-9 col-xs-8">
					<select name="lead_type" id="lead_type" class="form-control" required onchange="checkLeads()">
                      <option value="">Please Select</option>
                      <option value="source">Source Wise</option>
                      <option value="status">Status Wise</option>
					</select>
			</div>
			</div>
		
								<div id="leadsdiv" >
									<input type='hidden' id='all_count'  class="form-control"  >
                               
             </div>
								</div>
								<div class="col-md-6">
									
							
									<div class="form-group">
                                                               	
									<label class="control-label col-md-offset-3 col-md-5 col-sm-5 col-xs-9" for="first-name">
										 To Location </label>
									
								</div>
						 <div class="form-group" id="to_location_div">
                                                               	
									<label class="control-label col-md-3 col-sm-3 col-xs-4" for="first-name">
										 Location </label>
									<div class="col-md-9 col-sm-9 col-xs-8">
										<select name="toLocation" id="toLocation" class="form-control" required onchange="select_touser()">
                     						 <option value="">Please Select</option>
                     <?php				
													foreach($to_location as $row)
													{
														?>
											 <option value="<?php echo $row->location_id;?>"><?php echo $row->location;?></option>
											 
											 <?php } ?>
                   
                 
										</select>
									
									</div>
								</div>
								 <div class="form-group" id="lead_send">
				<label class="control-label col-md-3 col-sm-3 col-xs-4" for="first-name"> Lead Send </label>
				<div class="col-md-9 col-sm-9 col-xs-8">
				<div class="radio">
  <label><input type="radio" name="lead_send" id="lead_send1" value="As A New Lead">As A New Lead</label>
 <label> <input type="radio" name="lead_send" id="lead_send2" value="Continue with old Followup">Continue with old Followup</label>

</div>

			</div>
			</div>
								<div id="touserdiv" >
                                 
                                
		
								</div>
									
								</div>
						
						<div class="form-group">
							<div class="col-md-2 col-md-offset-5">
								
								<button type="submit" id="submit_data" class="btn btn-success col-md-12 col-xs-12 col-sm-12" onClick="return validate_transferred_button()">
									Submit
								</button>
							</div>

							<div class="col-md-2">
								<input type='reset' class="btn btn-primary col-md-12 col-xs-12 col-sm-12" value='Reset'>

							</div>
						</div>
						
				</div>
			</div>
			</form>
		</div>

		
	</div>
</div>
<?php }} ?>
	<script src="<?php echo base_url();?>assets/js/campaign.js"></script>
