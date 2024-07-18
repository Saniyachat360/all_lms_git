
<div class="row" style="margin-left:0px;margin-right: 0px;">
		<div class="col-md-12" >
				<div class="col-md-12">
				<?php echo $this->session->flashdata('msg');?>
			</div>
			
			
			<div class="row">
				<div id="abc">
					
					<div class="col-md-8">          
				<h1 style="text-align:center;">Upload Leads</h1>
 <div class="panel panel-primary">
    
     <div class="panel-body">
     
              <form name='import' action="<?php echo site_url('Upload_xls/excell_leads'); ?>" method="post"  enctype="multipart/form-data">
              
						
                     	
						
                     <div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                     	
                     	
									<div class="form-group">

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
                        <div class="col-md-2">
                        <a href= "<?php echo site_url('add_new_customer'); ?>" class="btn btn-success col-md-12 col-xs-12 col-sm-12">
								Back
                                    </a>						</div>
					</div>
</div>
</form>

                    </div>
                    
                    </div>
     
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    </div>
             

                        </div>
                      
                    </div> 
	
	
               
            </div>

