<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="<?php echo base_url();?>assets/js/campaign.js?v=00001" ></script>
<style>
.ui-timepicker {
   
    text-align: left;
}
.ui-timepicker-container {
	z-index:10000;
}
</style>
<div class="container" style="width: 100%;">
	<div class="row">
		<h1 style="text-align:center;">Follow Details</h1> <br/>
                       <p style="text-align:center;"> Name: <b style="font-size: 15px;"><?php if(isset($lead_detail[0] -> name)){ echo $lead_detail[0] -> name; } ?></b></p>
                       <p style="text-align:center;">Contact: <b style="font-size: 15px;"><?php if(isset($lead_detail[0] -> contact_no)){ echo $lead_detail[0] -> contact_no; }?></b></p>
 	 					<a id="sub" style="margin-top: -50px" target="_blank" class="pull-right"  href="<?php echo site_url(); ?>website_leads/lms_details/<?php if(isset($lead_detail[0] -> enq_id)){ echo $lead_detail[0] -> enq_id; } ?>/<?php echo $enq; ?>">
						<i class="btn btn-info entypo-doc-text-inv">Customer Details</i>
						</a>
		<?php $insert=$_SESSION['insert'];
		if($insert[44]==1){?>
 	 	<div class="panel panel-primary">
     		<div class="panel-body">
     			<form action="<?php echo site_url(); ?>add_followup_service/insert_followup" method="post">
					<input type="hidden" name="booking_id" id='enq_id' value="<?php if(isset($lead_detail[0] -> enq_id)){ echo $lead_detail[0] -> enq_id; } ?>">
                	<input type="hidden" name="phone" value="<?php if(isset($lead_detail[0] -> contact_no)){ echo $lead_detail[0] -> contact_no; } ?>">
					<input type="hidden" name="loc" value="">
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<!-- Basic Followup -->
                     	 <div class="panel panel-primary">
 							<div class="panel-body">
                         		<div class="col-md-6">
                         	   		 <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Email: </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                             			<input type="text"  placeholder="Enter Email"  name='email'  id="email" class="form-control" value="<?php  if(isset($lead_detail[0] -> email)){ echo $lead_detail[0] -> email; } ?>"/>
                                           		 	</div>
                                       			</div>
                                      <div class="form-group">
                                    	<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">FeedBack Status: </label>
                                   		<div class="col-md-8 col-sm-8 col-xs-12">
                                        		<select name="feedbackstatus" id="feedbackStatus" class="form-control" required onchange='check_status(this.value);'>
                                					<option value="">Please Select</option>
                                					<?php foreach ($select_feedback_status as $row) {?>
                                						<option value="<?php echo $row->feedbackStatusName;?>"><?php echo $row->feedbackStatusName;?> </option>
														
													<?php } ?>
                                				</select>
                                          	</div>
                                    	</div>
                                 
                 						<div class="form-group" id="nextactiondiv">
                                    		<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Action: </label>
                                   			<div class="col-md-8 col-sm-8 col-xs-12">
                                            	<select name="nextAction" id="nextAction" class="form-control" required   onchange='check_nfd(this.value);'>
                                					  <?php  if($lead_detail[0]->nextAction !='')
                                       {
                                       	?>
                                       	<option value="<?php echo $lead_detail[0]-> nextAction; ?>"><?php echo $lead_detail[0] -> nextAction; ?></option>
                                       <?php
                                       }else
                                       {
                                       	?>
                                       		<option value="">Please Select  </option>
                                       	<?php
                                       }?>
                                					<?php
                                				/*
                                					foreach ($selectNextAction as $row) {?>
														<option value="<?php echo $row -> nextActionName; ?>"><?php echo $row -> nextActionName; ?></option>
													<?php } */?>
	                                			</select>
                                            </div>
                                         </div>
                                     
                                        <div class="form-group">
                      						<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Eagerness: </label>
                                       	<div class="col-md-8 col-sm-8 col-xs-12">
											<select class="form-control" id="eagerness" name="eagerness" required>
												<option value="">Please Select</option>		
												<option value="HOT">HOT</option>		
												<option value="WARM">WARM</option>		
												<option value="COLD">COLD</option>		
											</select>		
										</div>				
									</div>
								</div>
                               	<div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Address:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <textarea placeholder="Enter Address" name='address' id="location" class="form-control" /><?php if(isset($lead_detail[0] -> address)){ echo $lead_detail[0] -> address; } ?></textarea>
                                         	</div>
                                      </div>
                        				<input type="hidden" value="<?php echo date("Y-m-d"); ?>" name="date"   class="form-control"  />
                        				   <div  id='nfd' style="display:block">
                                    	<div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Follow Up Date:</label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                	<input type="text"  placeholder="Enter Next Follow Up Date" name='followupdate' id='datett'  class="datett form-control" required  style="background:white; cursor:default;" />
                                           		</div>
                                            </div>
                                            	     <div class="form-group" >
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Follow Up Time:
                                            </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-10">
												  
												  <div class="input-group"> <input class="form-control " required data-template="dropdown" id="timet" name="followuptime" placeholder="Enter Next Follow Up Time" type="text"> <div class="input-group-addon"> <a href="#timet"><i class="entypo-clock"></i></a> </div> </div>

												  
												
                                                	</div>	               </div>                
									</div>	
                                            <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Remark:</label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                		<textarea placeholder="Enter Remark" name='comment' required class="form-control" /></textarea>
                                           		 </div>
                                            </div>
                                            
                                     	</div>
                                     </div>
                                     </div>
                                     
   <div class="panel panel-primary">
     		<div class="panel-body">
     			<div class="col-md-6">
     				    <div class="form-group" >
                                    		<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Service Center: </label>
                                   			<div class="col-md-8 col-sm-8 col-xs-12">
                                            	<select name="service_center" id="service_center" class="form-control"  >
                                					<option value="">Please Select</option>
                                					<option value="Mumbai">Mumbai</option>
                                					<option value="Pune">Pune</option>
                                					<option value="Thane">Thane</option>
                                					<option value="Kalina">Kalina</option>
                                          <option value="Kharghar">Kharghar</option>
                                          <option value="Thane">Thane</option>
                                          <option value="Baner">Baner</option>
                                          <option value="Wadki">Wadki</option>
                                          <option value="Uruli_Kanchan">Uruli Kanchan</option>
                                          <option value="Shikrapur">Shikrapur</option>
                                          <option value="Roha">Roha</option>
	                                			</select>
                                            </div>
                                         </div>
                                      
                                    
                                        	<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Registration Number:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter Registration No" name='registration_no' id="reg_no" class="form-control" />
                                         	</div>
                                      </div>
                                       <script>
                                       function check_mcp_offers()
                                       {
                                          var v=document.getElementById("service_type").value;
                                         // alert(v);
                                          if(v=='MCP'){
                                            document.getElementById("mcpdiv").style.display="block";
                                          }else{
                                            document.getElementById("mcpdiv").style.display="none";
                                          }
                                       }
                                       </script>
                                        
                                      <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Service Type:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                              <select class="form-control" id="service_type" name="service_type" onchange='check_mcp_offers()' >
                      												<option value="">Please Select</option>		
                      												<option value="Body Shop">Body Shop</option>		
                      												<option value="Service">Service</option>	
                      													<option value="Body Shop + Service">Body Shop + Service</option>		
                                                <option value="MCP">MCP</option>  	
                      												  <option value="Other">Other</option>	
                                                <option value="1st Free Service">1st Free Service</option>  
                                                <option value="2nd Free Service">2nd Free Service</option>  
                                                <option value="3rd Free Service">3rd Free Service</option>  
                                                <option value="Paid">Paid</option>  
                                                <option value="Paid+Bodyshop">Paid+Bodyshop</option>  
                                                <option value="Running Repair">Running Repair</option>  
												
											</select>		
										</div>
                                      </div>
                                      <div id='mcpdiv' style='display:none'>
                                      <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >MCP Offers:</label>
                                          <div class="col-md-8 col-sm-8 col-xs-12">
                                              <select class="form-control" id="mcp_offers" name="mcp_offers" >
                        <option value="">Please Select</option>   
                        <option value="Insulation from Price Inflation">Insulation from Price Inflation</option>    
                        <option value="Enhances Resale Value">Enhances Resale Value</option>  
                          <option value="Periodic checks for Safe & comfort drive">Periodic checks for Safe & comfort drive</option>    
                          <option value="Instant alerts for peace of mind">Instant alerts for peace of mind</option>    
                        <option value="Special priviledge offers like Free Pickup & drop & Free emergency road Services">Special priviledge offers like Free Pickup & drop & Free emergency road Services</option>  
                         <option value="Hassle Free service at all our outlets">Hassle Free service at all our outlets</option>  
                       
                      </select>   
                    </div>
                                      </div>
                                   <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >MCP Types:</label>
                                          <div class="col-md-8 col-sm-8 col-xs-12">
                                              <select class="form-control" id="mcp_type" name="mcp_type">
                        <option value="">Please Select</option>   
                        <option value="Economy">Economy</option>    
                        <option value="Executive">Executive</option>  
                          <option value="Premium">Premium</option>    
                           
                        
                      </select>   
                    </div>
                                      </div>
                                </div>
                                      <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Pickup Required:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                             <select class="form-control" id="pickup_required" name="pick_up" >
												<option value="">Please Select</option>	
                                             	<option value="Yes">Yes</option>
                                             	<option value="No">No</option>
                                             </select>
                                         	</div>
                                      </div>
                                     </div>
                                        <div class="col-md-6">
                                        	  <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Car Model:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <select class="form-control" id="car_model" name="car_model" >
												<option value="">Please Select</option>		
												<?php foreach ($select_model as $row) {?>
													<option value="<?php echo $row->model_id;?>"><?php echo $row->model_name;?></option>	
												<?php } ?>
												
												</select>
                                         	</div>
                                      </div>
                                       <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Kilometer:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter KM" name='km' id="km" class="form-control" /></textarea>
                                         	</div>
                                      </div>
     					
                                         	<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Pickup Date:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                             
                                         		<input type="text"  placeholder="Enter Pickup Date"  id="pick_up_date" name='pickup_date'  class="datett form-control"  readonly style="background:white; cursor:default;" />
                                         
                                         	</div>
                                      </div> 
                                      <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Pickup Time Slot:</label>
                                          <div class="col-md-8 col-sm-8 col-xs-12">
                                              <select class="form-control" id="pickup_time_slot" name="pickup_time_slot" >
                        <option value="">Please Select</option>   
                        <option value="Morning between 8am to 11am">Morning between 8am to 11am</option>    
                        <option value="Afternoon between 12 to 2pm">Afternoon between 12 to 2pm</option>  
                          <option value="Evening  between 3 to 5pm">Evening  between 3 to 5pm</option>    
                           
                        
                      </select>   
                    </div>
                                      </div>
                                   
                                        
                                      </div>
     		</div>
     	</div>
     	   <!-- Transfer and send quotation -->
      
				<div class="panel panel-primary">
					<!--<h3 class="text-center">Transfer Lead</h3>-->
                	<div class="panel-body">
                		 <?php $insert= $_SESSION['insert'];
                        if($insert[43]==1)
						{ ?>
						    <div class="col-md-4">                      		
                        	<div class="form-group">
  								 <label class="control-label col-md-8 col-sm-8 col-xs-12" for="first-name">Click Here To Transfer Lead: </label>
                                 	<div class="col-md-4 col-sm-4 col-xs-12">
                                     	<label class="checkbox-inline "><input type="checkbox" id="transfer" name="transfer" onclick="transfer_lead()" > &nbsp;Yes</label>
                                     	</div>
                                    </div>  
                               </div>
                               
                               	<div id="tassignto" style="display: none">
                               			<div class="col-md-12">  
                               				<div class="col-md-4">  
                               					<div class="form-group">
                        		
                        		<?php
                        		 if($lead_detail[0]->assign_to_dse_tl!=0){
                        			?>
  								 <label  style="color:#FF0000;"  class="col-md-12">	Lead Already Transferred  To Showroom  </label>
  									<?php  }?>		
  									<?php 
  									
  									if($lead_detail[0]->transfer_process!=''){?>
  							
                     				<label style="color:#FF0000;"  class="col-md-12"> Lead Transferred To	<?php  
                     				$transfer_process_data=json_decode($lead_detail[0]->transfer_process);
									for($i=0;$i<count($transfer_process_data);$i++){
										$tdata=$transfer_process_data[$i];
											 $query_data=$this->db->query("select process_name from tbl_process where process_id IN('$tdata')");
										
											foreach($query_data->result() as $row){
												echo $row->process_name.' ';
											}
									}
										 ?>  </label>
                     				<?php }else{
                     					$transfer_process_data='';
                     			
  								 	  }?>		   
                           </div>
                               				</div>  
                               				<div class="col-md-4"> 
                               					<div class="form-group">
                               					    	
                               					    	
                               					    	
    	                 <label class="col-md-12 col-sm-12 col-xs-12" >Transfer Process:</label>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                	<select name="tprocess" id="tprocess" class="form-control" required  disabled=true  onchange="select_transfer_location()">
                                      <option value="">Please Select </option>
                     				<?php 
                     				if($lead_detail[0]->transfer_process!=''){
                     					 $transfer_process_data=json_decode($lead_detail[0]->transfer_process);
                     				}else{
                     					$transfer_process_data='';
                     				}
                     				foreach($process as $fetch1)
                     				{
                     				    	if($transfer_process_data !=''){
                             					if(!in_array($fetch1 ->process_id, $transfer_process_data) && $fetch1->process_id !=9){ ?>
        												<option value="<?php echo $fetch1 ->process_id.'#'.$fetch1 ->process_name; ?>"><?php echo $fetch1 -> process_name; ?></option>
            									<?php 
            									 }
    									   }
    									 else
    									 {
        									 if($fetch1->process_id !=9){ ?>
        												<option value="<?php echo $fetch1 ->process_id.'#'.$fetch1 ->process_name; ?>"><?php echo $fetch1 -> process_name; ?></option>
        									<?php  }
    									 }
									 }?>
                       					</select>
                                   </div>
                             </div>
                              <div id="tlocation_div"  >
                            	
                             	<div class="form-group">
    	                 <label class="col-md-12 col-sm-12 col-xs-12" >Transfer Location:</label>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                	<select name="tlocation" id="tlocation1" class="form-control" required  disabled=true  onchange="select_assign_to()">
                                        <?php /*if($lead_detail[0]->location != ''){?>
												<option value=" <?php echo $lead_detail[0] -> location; ?>"> <?php echo $lead_detail[0] -> location; ?></option>
										<?php } else{ */?>
												<option value="">Please Select  </option>
										<?php //} ?>
									<!--<?php foreach($get_location1 as $fetch1){ ?>
												<option value="<?php echo $fetch1 -> location; ?>"><?php echo $fetch1 -> location; ?></option>
                     							 <?php } ?>-->
                       					</select>
                                   </div>
                             </div>
                             
                               
                                 </div>
                               					</div>  
                               					<div class="col-md-4">  
                               						 <div  id="tassign_div">
                                 
                                 <div  class="form-group">
                                    <label class="col-md-12 col-sm-12 col-xs-12" for="first-name">Transfer To:</label>
                                        <div class="col-md-12 col-sm-12 col-xs-12" id="assign_div">
                                           <select name="transfer_assign" id="tassignto1" required class="form-control"  disabled=true>
                                         		<option value="">Please Select</option> 
											</select>
                                          </div>
                                      </div>
                              
									</div>
									
                                 
                                 <div  class="form-group" id="lead_status">
                                    <label class="col-md-12 col-sm-12  col-xs-12" for="first-name">Current Process Lead Status:</label>
                                        <div class="col-md-12 col-sm-12  col-xs-12" >
                                        	 <input type="radio" value="Close" id="lead_status1" disabled=true required name="lead_status"> Close &nbsp;&nbsp;
							<input type="radio" value="Continue" id="lead_status2" required disabled=true name="lead_status"> Continue<br>
         
                                          </div>
                                      </div>
                               
								
									
                               						</div> 
                               				</div>
							
                	
                			
							
						<div id="evaluation_location"></div><div id="evaluation_assign_to"></div>
						

				 </div>
                                    <?php  } ?>
                                
                              
                               </div>
                              </div>
               <!-- Send Quotation div --
            <div id="quotation1"  style="display: none">
            	<div class="panel panel-primary">	<h3 class="text-center">Send Quotation</h3>
                	<div class="panel-body">
              	<div class="col-md-6">
    		 			<div class="form-group">
    	                   <label class="control-label col-md-4 col-sm-4 col-xs-12" > Location: </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                             <select name="qlocation" id="qlocation" class="form-control" required disabled=true onchange="select_model_name();">
                          	 	 <option value="">Please Select  </option>
										 <?php foreach ($select_city as $row) {?>
                      			<option value="<?php echo $row->location;?>"><?php echo $row->location;?></option>
								  <?php } ?>
                     		</select>
                        </div>
                     </div>
                     
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
    	                 <label class="control-label col-md-4 col-sm-4 col-xs-12" >Model Name: </label>
                       <div class="col-md-8 col-sm-8 col-xs-12" id="model_name_div">
                          <select name="model_id" id="model_name" class="form-control" required disabled=true>
                              <option value="">Please Select  </option>
							</select>
                         </div>
                        </div>
                   </div>
				   <div id="description_div">
                   <div class="col-md-6">
                       
                          <div  class="form-group">
                           <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Description:</label>
                            	<div class="col-md-8 col-sm-8 col-xs-12" id="">
                                    <select name="description" id="description" class="form-control"  disabled=true>
                                         <option value="">Please Select</option> 
									</select>
                           		</div>
                            </div>
                          </div>
                        </div>
                     
                        <div id='checkprize_div'>
                        	</div>
					</div>
					</div>
					</div>
					<!-- Transfer Div -->
					
			
           </div>
       
            <div class="form-group">
             	<div class="col-md-2 col-md-offset-5">
                  <button type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12">Submit</button>
                 </div>
                 <div class="col-md-2">
                    <button type="reset" class="btn btn-primary col-md-12 col-xs-12 col-sm-12">Reset</button>
                 </div>
            </div>
            
</form>
    </div>
    </div>
    <?php } ?>
  </div>
  </div>
  
<?php if(isset($lead_detail[0] -> cse_followup_id)){  if($lead_detail[0]->cse_followup_id!='')
{?>
<table class="table table-bordered datatable" id="results"> 
	<thead>
		<tr>
			<th>Follow Up By</th>
			<th>Call Date</th>		
			<th>N.F.D</th>
			<th>Feedback Status</th>
			<th>Next Action</th>					
			<th>Remark</th>	
		</tr>	
	</thead>
	<tbody>
		<?php foreach($select_followup_lead as $row){ ?>
		<tr>
			<td><?php echo $row -> fname . ' ' . $row -> lname; ?></td>
			<td><?php echo $row -> date; ?></td>
			<td><?php echo $row -> nextfollowupdate ?></td>
			<td><?php echo $row -> feedbackStatus; ?></td>
			<td><?php echo $row -> nextAction; ?></td>
			<td><?php echo $row -> comment; ?></td>
		</tr>
<?php } }?>
	</tbody>
</table>
<?php } ?>


<script>
window.onload= check_values();
function check_values()
{
	//Basic followup

	var email_old='<?php echo $lead_detail[0] -> email; ?>';
	var eagerness_old='<?php echo $lead_detail[0] -> eagerness; ?>';
	var feedbackStatus='<?php echo $lead_detail[0] -> feedbackStatus; ?>';
	var nextAction='<?php echo $lead_detail[0] -> nextAction; ?>'; 
		var service_center='<?php echo $lead_detail[0] -> service_center; ?>'; 
	var model_name=	'<?php echo $lead_detail[0] -> model_id; ?>'; 		
	var reg_no='<?php echo $lead_detail[0] -> reg_no; ?>'; 
	var km='<?php echo $lead_detail[0] -> km; ?>'; 
	var service_type='<?php echo $lead_detail[0] -> service_type; ?>'; 
	var pick_up_date=	'<?php echo $lead_detail[0] -> pick_up_date; ?>'; 	
	var pickup_required='<?php echo $lead_detail[0] -> pickup_required; ?>'; 
  var mcp_offers='<?php echo $lead_detail[0] -> mcp_offers; ?>'; 
  var mcp_type='<?php echo $lead_detail[0] -> mcp_type; ?>'; 
  var pickup_time_slot='<?php echo $lead_detail[0] -> pickup_time_slot; ?>'; 


		if(email_old == '')
		{

		document.getElementById("email").value = "";

		}else{
		document.getElementById("email").value = email_old;
		}
		if(eagerness_old == '')
		{

		document.getElementById("eagerness").value = "";

		}else{
		document.getElementById("eagerness").value = eagerness_old;
		}
		if(feedbackStatus == ''){
			
		document.getElementById("feedbackStatus").value = "";
		}else{
			document.getElementById("feedbackStatus").value = feedbackStatus;
		}
		/*if(nextAction == ''){
			
		document.getElementById("nextAction").value = "";
		}else{
			document.getElementById("nextAction").value = nextAction;
		}*/
		
		if(service_center == ''){
			
		document.getElementById("service_center").value = "";
		}else{
			document.getElementById("service_center").value = service_center;
		}
		if(model_name == 0){
			
		document.getElementById("car_model").value = "";
		}else{
			document.getElementById("car_model").value = model_name;
		}
		
		if(reg_no == ''){
			
		document.getElementById("reg_no").value = "";
		}else{
			document.getElementById("reg_no").value = reg_no;
		}
	
		
		if(km == ''){
			
		document.getElementById("km").value = "";
		}else{
			document.getElementById("km").value = km;
		}
			if(km == ''){	
		document.getElementById("km").value = "";
		}else{
			document.getElementById("km").value = km;
		}
			if(service_type == ''){
			
		document.getElementById("service_type").value = "";
		}else{
			document.getElementById("service_type").value = service_type;
       if(service_type=='MCP'){
          document.getElementById("mcpdiv").style.display="block";
        }else{
          document.getElementById("mcpdiv").style.display="none";
        }
		}
    if(mcp_offers != ''){
      
    document.getElementById("mcp_offers").value = mcp_offers;
    }
    if(pickup_time_slot != ''){
      
    document.getElementById("pickup_time_slot").value = pickup_time_slot;
    }
    if(mcp_type != ''){
      
    document.getElementById("mcp_type").value = mcp_type;
    }
	
			if(pick_up_date == ''){
			
		document.getElementById("pick_up_date").value = "";
		}else{
			document.getElementById("pick_up_date").value = pick_up_date;
		}
	
		if(pickup_required == ''){
			
		document.getElementById("pickup_required").value = "";
		}else{
			document.getElementById("pickup_required").value = pickup_required;
		}
		 var nfdDiv = document.getElementById("nfd");
			
			if(nextAction=='Close' || nextAction=='Service Done'){
			
		
				
					document.getElementById("datett").disabled = true; 
					document.getElementById("timet").disabled = true; 
						nfdDiv.style.display = "none";
			}else{
		
				nfdDiv.style.display = "block";
				 document.getElementById("datett").disabled = false; 
				document.getElementById("timet").disabled = false; 
			}
		
		}
		
		function check_status (feedbackStatus) {
	
			$.ajax({
				url:"<?php echo site_url();?>add_followup_service/select_next_action",
				type:"POST",
				data:{feedbackStatus:feedbackStatus},
				success:function(reponse){
					  
					    $('#nextactiondiv').html(reponse);
				}				
			})
				}
				//Select user name using location
function select_transfer_location()
{
	var ctprocess= document.getElementById("tprocess").value;
	var a =ctprocess.split("#");
	var tprocess= a[0];
	var tprocess_name= a[1];
		
		<?php $user_id=$this->session->userdata('user_id');
        $check_user_process_transfer = $this->db->query("select p.process_id
									from lmsuser l 
									Left join tbl_manager_process mp on mp.user_id=l.id 
									Left join tbl_process p on p.process_id=mp.process_id
									where mp.user_id='$user_id'  group by p.process_id")->result(); 
								?>
		var cupt = new Array();
    <?php foreach($check_user_process_transfer as $row){ ?>
        cupt.push('<?php echo $row->process_id; ?>');
    <?php } ?>
				
						var cupt_count=cupt.length;
						for(var i=0;i<=cupt_count;i++){
							
					if(cupt[i] == tprocess){
								document.getElementById("lead_status1").disabled = true; 
		document.getElementById("lead_status2").disabled = true; 
			document.getElementById("lead_status").style.display ="none"; 
		document.getElementById("tlocation_div").style.display ='block'; 
		document.getElementById("tassign_div").style.display ='block'; 
		document.getElementById("tlocation1").disabled = false; 
		document.getElementById("tassignto1").disabled = false; 
			 break;
		
	}	else{
		document.getElementById("lead_status").style.display ='block'; 
				document.getElementById("lead_status1").disabled = false; 
		document.getElementById("lead_status2").disabled = false; 
		document.getElementById("tassignto1").disabled = true; 
	}	
						}
				
			
	
		$.ajax({
		url : '<?php echo site_url('add_followup_service/select_transfer_location'); ?>',
		type : 'POST',
		data : {'tprocess' : ctprocess},
		success : function(result) {
		   	$("#tassign_div").css("display", "none");
			$("#tlocation_div").html(result);
		
		}
	});
	
}
//Select user name using location
function select_assign_to()
{
	var tlocation1 = document.getElementById("tlocation1").value;
	var tprocess = document.getElementById("tprocess").value;
	$.ajax({
		url : '<?php echo site_url('add_followup_service/select_assign_to'); ?>',
		type : 'POST',
		data : {'tlocation1' : tlocation1,'tprocess' : tprocess},
		success : function(result) {
		$("#tassign_div").css("display", "block");
		$("#assign_div").html(result);
	}
	});
}
</script>

<script type="text/javascript">
        var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        function IsNumeric(e) {
           //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
     
               return false;
    }
        }
         </script>   
            <script>   
        function check_nfd(val) {
		//alert("hi");
		var nextaction = document.getElementById("nextaction").value;
		//alert(nextaction);
		var nfdDiv = document.getElementById("nfd");
		if(nextaction=='Close' || nextaction=='Service Done'){
		
		
	 document.getElementById("datett").disabled = true; 
		  document.getElementById("timet").disabled = true; 
		   nfdDiv.style.display = "none";
	}
	
	else{
	
		nfdDiv.style.display = "block";
		 document.getElementById("datett").disabled = false; 
		  document.getElementById("timet").disabled = false; 
	}
	
		}

    </script>     
    <?php
  /*  $count=-4;
    for ($i=0; $i<5; $i++) {
    	
		for ($j=1; $j<5; $j++) {
			echo $count=$count+5;
		}
			echo "<br>";
			$count=$count-(5*4)+1;
	}
	$count=0;
   for ($char = 'AA'; $char <= 'Z'; $char++) {
    echo $char . "-".$count=$count+1;
	   echo"<br>";
}*/
    ?>    