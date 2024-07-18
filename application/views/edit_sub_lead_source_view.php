


<div class="row" >
	<div class="col-md-12">
<?php echo $this -> session -> flashdata('message'); ?>
</div>
		   <h1 style="text-align:center; ">Edit Lead Source</h1>
<div class="col-md-12" >
 <div class="panel panel-primary">
   
     <div class="panel-body">
                <form action="<?php echo $var;?>" method="post">
                <?php
						foreach($select_sub_lead_source as $fetch) 
						{?>
							<input type="hidden" value="<?php echo $fetch->sub_lead_source_id; ?>" name="sub_lead_source_id">
                     <div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                         <div class="col-md-12">
                         	<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Process: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
								<select name="process_id" class="form-control" required="" >
									<?php if($fetch->process_id!=''){?>
												
									<option value="<?php echo $fetch->process_id ;?>"><?php echo $fetch->process_name ;?></option>
                   		
									<?php }else{ ?>
												<option value="<?php echo $_SESSION['process_id'] ;?>"><?php echo $_SESSION['process_name'] ;?></option>
									<?php } ?>
								
                                					        					
														
													                                						
													                                				</select>
								</div>
							</div>
                          		<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Lead Source: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
							<select name="lead_source_name" class="form-control" required=""  >
							
												
									<option value="<?php echo $fetch->lead_source_name ;?>"><?php echo $fetch->lead_source_name ;?></option>
                   		
								
								<?php foreach ($select_lead_source as $row) {?>
											<option value="<?php echo $row->lead_source_name;?>"><?php echo $row->lead_source_name;?></option>
									
                                			
							<?php	} ?>
                         						                                					
														
													                                						
													                                				</select>	</div>
							</div>
								<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Sub Lead Source: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
							<input type="text" name="sub_lead_source" class="form-control" required=""  value="<?php echo $fetch->sub_lead_source_name;?>">
								</div>
							</div>
                                                               
                           

                           
                                      
                                      
                             
                            
                            
                        
                         </div>
                        </div>
                          <?php } ?>           
                               

                         
                  
                    <div class="form-group">
                     <div class="col-md-2 col-md-offset-4">
                    	
						
                    <button type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12">Update</button>
                         </div>
                       
                        <div class="col-md-2">
                            <input type='reset' class="btn btn-primary col-md-12 col-xs-12 col-sm-12" value='Cancel' onclick="window.location='<?php echo site_url();?>add_leadsource/add_sub_lead_source'">
                        
                        </div>
                    </div>
                   </div>
                  </div>
                </form>
            </div>
            







</div>

