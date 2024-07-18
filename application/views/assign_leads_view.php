<body>
<script>
				function select_cse()
		{
			var location= document.getElementById("user_location").value;
		
			$.ajax({
				url:'<?php echo site_url('assign_leads/select_cse')?>',
				type:'POST',
				data:{location:location},
				success:function(response)
				{$("#leaddiv").html(response);}
				});

				}
		
	</script>
	<?php 
	$insert=$this->session->userdata('insert');
	$header_process_id=$this->session->userdata('process_id');
	$rightElementValue=0;
	$headingElementValue="Assign Leads";
	if($header_process_id==9)
	{
		if(isset($insert[77]))
		{
			if($insert[77]==1)
			{
				$rightElementValue=1;
				$headingElementValue="Assign Complaints";
			}
		} 
	}
	elseif(($insert[4]==1 && $header_process_id==6) || ($insert[23]==1 && $header_process_id==7) || ($insert[33]==1 && $header_process_id==1) || ($insert[41]==1 && $header_process_id==4) || ($insert[49]==1 && $header_process_id==5) || ($insert[69]==1 && $header_process_id==8))
	{
			$rightElementValue=1;
	}	
	if($rightElementValue==1)
	{
							
										?>
		<div class="row" >
			<div class="col-md-12">
				<?php echo $this->session->flashdata('msg');?>
			</div>
		<h1 style="text-align:center; "><?php echo $headingElementValue;?></h1>
		<div class="col-md-12" >
			<div class="panel panel-primary">

				<div class="panel-body">
					
					<form name="myform" action="<?php echo $var1; ?>" method="post" >

						<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
								<div class="col-md-6">
						 <div class="form-group">
                                                               	
									<label class="control-label col-md-3 col-sm-3 col-xs-4" for="first-name">
										 Location </label>
									<div class="col-md-9 col-sm-9 col-xs-8">
										<select name="location" id="user_location" class="form-control" required onchange="select_cse()">
								
										
                     
                      <option value="">Please Select</option>
                     <?php				
													foreach($location as $row)
													{
														?>
											 <option value="<?php echo $row->location_id;?>"><?php echo $row->location;?></option>
											 
											 <?php } ?>
                   
                 
										</select>
									
									</div>
								</div>
								<div id="leaddiv" class="form-group">
                                    <?php                    	
								/*	if(count($user_name)>0)
		{
			?>
				<label class="control-label col-md-3 col-sm-3 col-xs-4" for="first-name"> Assign To</label>
				<div class="col-md-9 col-sm-9 col-xs-8">
					<?php
					$i=0;
				foreach($user_name as $row)
				{
					$i++;
					?>
					<input type="checkbox" id="cse_name" name="cse_name[]" value='<?php echo $row -> id; ?>'>
					<?php echo $row -> fname . " " . $row -> lname; ?>
					<br>
					<?php } ?>
			</div>
			<?php
			}
			else {
			?>
			<label class="control-label col-md-3 col-sm-3 col-xs-4" for="first-name"> </label>
			<div class="col-md-9 col-sm-9 col-xs-8">
				No Records Found
			</div>
			<?php
			
			}*/
			?>
								</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
                                                               	
									<label class="control-label col-md-7 col-sm-7 col-xs-12" for="first-name">
										 Total (<?php  echo $all_count[0] -> acount; ?>)</label>
								
								</div>
								<?php 
											$i=0;
											foreach ($leads as $row) {
												 
												$i++;
										
												?>
							 <div class="form-group">
                                                               	
									<label class="control-label col-md-7 col-sm-7 col-xs-12" for="first-name">
										<input type='radio'id="web-<?php echo $i ;?>" name='leads1' value="<?php 
										if($row->lead_source==''){echo 'Web'; }else{ echo $row->lead_source ;}?>" onclick="get_web('web_count-<?php echo $i;?>','web-<?php echo $i ;?>','w_count-<?php echo $i;?>');"> <?php if($row->lead_source==''){echo 'Web'; }else{ echo $row->lead_source ;}?> (<?php echo $row->wcount; ?>)</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
										
										<input type='text' id='web_count-<?php echo $i;?>' name='lead_count1' class="form-control" onblur="check_count('w_count-<?php echo $i;?>','web_count-<?php echo $i;?>')" disabled>
										
									<input type='hidden' id="w_count-<?php echo $i;?>" name='web_count' disabled class="form-control" value="<?php  echo $row -> wcount; ?>">
									</div>
								</div>
								<?php } ?>
										
								<input type='hidden' id='all_count' name='all_count' class="form-control" value="<?php echo count($leads);?>" >
                                 
								
								</div>
						
						
						<div class="form-group">
							<div class="col-md-2 col-md-offset-5">

								<button type="submit" id="submit_data" class="btn btn-success col-md-12 col-xs-12 col-sm-12" onClick="return validate_button()">
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
<?php  } ?>
	<script src="<?php echo base_url();?>assets/js/campaign.js"></script>
