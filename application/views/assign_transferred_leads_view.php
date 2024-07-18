<body>
<script>
	function select_cse()
	{
			var location= document.getElementById("user_location").value;
		
			$.ajax({
				url:'<?php echo site_url('assign_transferred/select_cse')?>',
				type:'POST',
				data:{location:location},
				success:function(response)
				{$("#leaddiv").html(response);}
				});

				}
		
</script>
<div class="row" >
	<div class="col-md-12">
		<?php echo $this->session->flashdata('msg');?>
	</div>
	<h1 style="text-align:center; ">Assign Transferred Leads</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary">
			<div class="panel-body">
				<form name="myform" action="<?php echo $var1; ?>" method="post" >
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="col-md-6">
							<!-- <div class="form-group">
                         		<label class="control-label col-md-3 col-sm-3 col-xs-4" for="first-name">Location </label>
								<div class="col-md-9 col-sm-9 col-xs-8">
									<select name="location" id="user_location" class="form-control" required onchange="select_cse()">
										<option value="">Please Select</option>
                    					<?php foreach($location as $row){?>
										<option value="<?php echo $row->location_id;?>"><?php echo $row->location;?></option>
										<?php } ?>
                   					</select>
								</div>
							</div>-->
							<div id="leaddiv" class="form-group">
                                    <?php                    	
									if(count($user_name)>0)
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
			
			}
			?>
								</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
                            <label class="control-label col-md-7 col-sm-7 col-xs-12" for="first-name"> Total (<?php  echo $all_count[0] -> acount; ?>)</label>
							</div>
							<?php 
								$assign_to=$_SESSION['user_id'];	
								$role=$_SESSION['role'];
								/*if($role==5)
								{
									$assign="assign_to_dse_tl=".$assign_to." and assign_to_dse='0'";									
								}
								elseif($role==4)
								{
									$assign="assign_to_dse=".$assign_to;
								}
								elseif($role==2 || $role==3 || $role==1)
								{*/
									$assign="assign_to_cse=".$assign_to." and assign_to_dse_tl=0";
								//}							
								$web_query = $this->db->query("select lead_source,enquiry_for,count(lead_source) as wcount from lead_master where ".$assign." AND nextAction != 'Close' and process='".$_SESSION['process_name']."' group by lead_source ") ->result();
								
								//echo $this->db->last_query();
								$i=0;
								foreach ($web_query as $row) 
								{
									$i++;
									?>
							 		<div class="form-group">                                                               	
										<label class="control-label col-md-7 col-sm-7 col-xs-12" for="first-name">
										<input type='radio'id="web-<?php echo $i ;?>" name='leads1' value="<?php if($row->lead_source==''){echo 'Web'; }else{ echo $row->lead_source ;}?>" onclick="get_web('web_count-<?php echo $i;?>','web-<?php echo $i ;?>','w_count-<?php echo $i;?>');"> <?php if($row->lead_source==''){echo 'Web'; }else{ echo $row->lead_source ;}?> (<?php echo $row->wcount; ?>)</label>
										<div class="col-md-3 col-sm-3 col-xs-12">
										
											<input type='text' id='web_count-<?php echo $i;?>' name='lead_count1' class="form-control" onblur="check_count('w_count-<?php echo $i;?>','web_count-<?php echo $i;?>')" disabled>
										
											<input type='hidden' id="w_count-<?php echo $i;?>" name='web_count' disabled class="form-control" value="<?php  echo $row -> wcount; ?>">
										</div>
									</div>
								<?php } ?>
										
								<input type='hidden' id='all_count' name='all_count' class="form-control" value="<?php echo count($web_query);?>" >
                                                               	
									
										
									
								
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
	<script src="<?php echo base_url();?>assets/js/campaign.js"></script>
