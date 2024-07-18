<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script>


function select_campaign()
	{
	var lead_source=document.getElementById("lead_source").value;
	
	$.ajax({
			url : '<?php echo site_url('upload_xls/select_campaign'); ?>',
			type : 'POST',
			data : {'lead_source' : lead_source,

			},
			success : function(result) {
			$("#disposition_div").html(result);
			}
			});	
		}
		function select_group(val)
	{
		
		if(val=='Facebook')
		{
			/*document.getElementById("group_div").style.display="block";
			document.getElementById('group_name').disabled = false;*/
			document.getElementById("campaign_div").style.display="block";
			document.getElementById('campaign_name').disabled = false;
		}else if(val=='')
		{
			/*document.getElementById("group_div").style.display="none";
			document.getElementById('group_name').disabled = true;*/
			document.getElementById("campaign_div").style.display="none";
			document.getElementById('campaign_name').disabled = true;
			}else{
			/*document.getElementById("group_div").style.display="block";
			document.getElementById('group_name').disabled = false;*/
			document.getElementById("campaign_div").style.display="none";
			document.getElementById('campaign_name').disabled = true;
		}
		
		if(val=='Carwale')
		{
			document.getElementById("group_div").style.display="block";
			document.getElementById('group_name').disabled = false;
			//document.getElementById("campaign_div").style.display="block";
			//document.getElementById('campaign_name').disabled = false;
		}
}
		
</script>
<div class="row" style="margin-left:0px;margin-right: 0px;">
		<div class="col-md-12" >
				<div class="col-md-12">
				<?php echo $this->session->flashdata('msg');?>
				<?php  $msg_error = $this->session->flashdata('msg_error'); if(isset($msg_error)){?>
				<div class="alert alert-danger text-center col-md-offset-3 col-md-8">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>
				<p style="text-align:left">Error found in <?php
$t=15;
for($i=0;$i<count($msg_error);$i++){ ?><?php 
echo $msg_error[$i];
if(count($msg_error)-1 == $i){}else{ echo ','; }


if($t==$i){
	echo "<br>";
	$t=$t+15;
}
 } ?></p></strong></div>
				<?php } ?>
			</div>
				<h1 style="text-align:center;">Upload Excel Leads</h1>
			    
                    
                     <div class="row">
                    <div id="abc">

            <div class="col-md-8">          
 <div class="panel panel-primary">
    
     <div class="panel-body">
     
              <form name='import' action="<?php echo $var; ?>" method="post"  enctype="multipart/form-data">
              
						
                     	
						
                     <div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                     	
                     	
									<div class="form-group">
                                            
									<label class="control-label col-md-4 col-sm-4 col-xs-12" >Lead Source: </label>
										<div class="col-md-5 col-sm-5 col-xs-12" >
											<select name="lead_source" id="lead_source" class="form-control" onchange="select_campaign(this.value);" required>
												<option value="">Please Select </option>
												<?php 
												
												foreach($select_lead_source as $fetch)
												{
												
												?>
												
												<option value="<?php echo $fetch ->lead_source_name;?>"><?php echo $fetch ->lead_source_name;?></option>
												
												<?php }
												
												?>
													<option value="Facebook">Facebook</option>
												<!--	<option value="Facebook">Facebook</option>
												<option value="Others">Others</option>
												<option value="Web">Web </option>
												<option value="Facebook">Facebook</option>
												<option value="Email">Email </option>
												<option value="Zendesk">Zendesk </option>
												<option value="IBC">IBC</option>
												<option value="GSC">GSC</option>
												<option value="Carwale">Carwale</option>
												<option value="Others">Others</option>-->
												
											</select>
											</div>
										</div>

									<!--<div id="group_div" class="form-group" style="display: none">
                                            
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Group Name: </label>
									<div class="col-md-5 col-sm-5 col-xs-12">
								
									       
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="group_name" name="group_name"   onchange="select_campaign();" required disabled>
												 <option value=""> Please Select </option>
											
												<?php
										
										foreach($select_grp as $fetch)
										{
																				
										?>
													
													 <option value="<?php echo $fetch -> group_id; ?>"><?php echo $fetch -> group_name; ?></option>
                                             		<?php
										}
								?>
							
                                               
                                                </select>
								
									</div>
									
									
								</div>-->

                     	
                     	
                     		
														<div id="campaign_div" class="form-group" >
                                            
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Sub Lead Source: </label>
									<div class="col-md-5 col-sm-5 col-xs-12" id="disposition_div">
										
										
									       
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="campaign_name" name="campaign_name"  >
                                              	 <option value=""> Please Select </option>
											
                                              	<?php /*
                                              	
                                              	foreach($select_campaign as $fetch)
												{
													
												
                                              	?>
												
											
													 <option value="<?php echo $fetch -> campaign_name; ?>"><?php echo $fetch->campaign_name;?></option>
                                             
                                             <?php
                                               } */ ?>
                                                </select>
										
									
									</div>
									
									
								</div>


                  
                     
                      
                <!--         
                     <input type='file' name='file' /><br />
<input type='submit' name='submit' value='Submit' />-->
  <div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12"></label>
								<div class="col-md-5 col-sm-5 col-xs-12">
										<label class="control-label "><font color="red">Please upload only .xls file</font></label>
								</div>
							</div>
    <div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Upload File:</label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<input type="file"  class="btn btn-info"  name="file" id="file" required  >
								</div>
							</div>
<div class="form-group">
						<div class="col-md-2 col-md-offset-4">

							<button type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12">
								Submit
							</button>
						</div>

						<div class="col-md-2">
							<input type='reset' class="btn btn-primary col-md-12 col-xs-12 col-sm-12" value='Reset'>
						</div>
					</div>
</div>
</form>

                    </div>
                    
                    </div>
                    </div>
                    <div class="col-md-4">
                     <div class="panel panel-primary">
    
     <div class="panel-body">
     	<a href="<?php echo base_url();?>upload_poc_xls_format.xls" class="btn btn-info">New Lead Upload Format</a><br><br>
     		<!--<a href="<?php echo base_url();?>upload_followup_xls_format.xls" class="btn btn-primary">Followup Leads Upload Format</a>-->
     </div>
     </div>
      </div>              
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    </div>
             

                        </div>
                      
                    </div> 
	
	
               
            </div>

