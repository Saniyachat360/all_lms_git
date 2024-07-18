<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<style>
.ui-timepicker {
   
    text-align: left;
}
.ui-timepicker-container {
	z-index:10000;
}
</style>

<script>
		// Get Next Action from Feed back status
function select_feedback (val) {
  //alert(val);
  var feedback = val;
  $.ajax({
	url : '<?php echo site_url('add_followup_complaint/select_next_action'); ?>',
	type : 'POST',
	data : {
	'feedback' : feedback,

	},
	success : function(result) {
	$("#nextactiondiv").html(result);
	}
	});
}

function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		// Added to allow decimal, period, or delete
		if (charCode == 110 || charCode == 190 || charCode == 46)
			return true;

		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;

		return true;
	}
	
//Show pervious data in text box
function check_values()
{
	//Basic followup
	var email_old='<?php echo $lead_detail[0]->email;?>';

	var feedbackStatus='<?php echo $lead_detail[0]->feedbackStatus;?>';
	var nextAction='<?php echo $lead_detail[0]->nextAction;?>';
		var reg_no='<?php echo $lead_detail[0]->reg_no;?>';
		var complaint_type='<?php echo $lead_detail[0]->business_area;?>';
		var location='<?php echo $lead_detail[0]->location;?>';
	//Basic Details
	if(email_old == '')
			{
			
			  document.getElementById("email").value = "";
	  
			}else{
				document.getElementById("email").value = email_old;
			}

if(reg_no == '')
			{
			
			  document.getElementById("reg_no").value = "";
	  
			}else{
				document.getElementById("reg_no").value = reg_no;
			}

	if(feedbackStatus == '')
			{
			  document.getElementById("feedback").value = "";
	  
			}else{
				document.getElementById("feedback").value = feedbackStatus;
			}	
		if(nextAction == '')
			{
			  document.getElementById("nextaction").value = "";
	  
			}else{
				document.getElementById("nextaction").value = nextAction;
			}	
			if(complaint_type == '')
			{
			  document.getElementById("complaint_type").value = "";
	  
			}else{
				document.getElementById("complaint_type").value = complaint_type;
			}	
				if(location == '')
			{
			  document.getElementById("location").value = "";
	  
			}else{
				document.getElementById("location").value = location;
			}	
			
			
			
						
						
}
</script>
<body class="page-body" onload="check_values(); ">
<div class="container " style="width: 100%;">
	<div class="row">
		<div id="abc">
<?php $today = date('d-m-Y'); ?>
                       <h1 style="text-align:center;">Follow Up Details</h1>
                        
                       <br/>
                       <div style="margin-bottom: 40px;">
                       <div class="col-md-3"></div>
                       <div class="col-md-3" style="text-align:center;"> Name: <b style="font-size: 15px;"><?php echo $lead_detail[0] -> name; ?></b></div>
                       <div class="col-md-3" style="text-align:center;">Contact: <b style="font-size: 15px;"><?php echo $lead_detail[0] -> contact_no; ?></b></div>
 					<div class="col-md-3"></div>
 					</div>
 	 <a id="sub" style="margin-top: -50px" class="pull-right"  href="<?php echo site_url();?>website_leads/complaint_details/<?php echo $lead_detail[0] -> complaint_id; ?>/<?php echo $path;?>">
	
<i class="btn btn-info entypo-doc-text-inv">Customer Details</i>
</a>
<?php $insert=$_SESSION['insert'];
if($insert[78]==1){?>
 	 <div class="panel panel-primary">
     	<div class="panel-body">
     		 <div class="panel panel-primary">
 							<div class="panel-body">
     		<div class="col-md-12">
     			<h4 style="font-weight: bold">Customer Complaint</h4>
     			<?php echo $lead_detail[0]->comment ;?>
     		</div>
     		</div>
     		</div>
     		<form action="<?php echo $var; ?>" method="post">
                	<input type="hidden" name="complaint_id" id='complaint_id' value="<?php echo $lead_detail[0] -> complaint_id; ?>">
                	<input type="hidden" name="phone" value="<?php echo $lead_detail[0]->contact_no;?>">
					<input type="hidden" name="loc" value="<?php echo $path; ?>">
						<input type="hidden" name="customer_name" id='customer_name' value="<?php echo $lead_detail[0] -> name; ?>">
					
					<input type="hidden" value="<?php echo date("Y-m-d"); ?>" name="date"   class="form-control" style="background:white; cursor:default;" />
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<!-- Basic Followup -->
                     	  <div class="panel panel-primary">
 							<div class="panel-body">
                         		<div class="col-md-6">
                         	   	<div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Alternate Contact No:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <input placeholder="Enter Contact Number" onkeypress="return isNumberKey(event)" onkeyup="return limitlength(this, 10)" name="alternate_contact" id="alternate_contact" class="form-control" type="text">
                                            </div>
                                        </div>
                                      
										
                                          <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" >Call Status:         </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <select name="contactibility" id="contactibility" class="form-control" required >
                                                <option value="">Please Select </option> 	
												<option value="Connected">Connected</option>
												<option value="Not Connected">Not Connected</option>
												
                                            </select>
                                            </div>
											
                                         </div>
                                         <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Feedback Status:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <select name="feedback" id="feedback" class="form-control" required onchange="select_feedback(this.value);">
                                                <option value="">Please Select </option> 	
                                            	<!--<option value="<?php echo $lead_detail[0] -> feedbackStatus; ?>"><?php echo $lead_detail[0] -> feedbackStatus; ?></option>
												--><?php foreach ($feedback_status as $row1) { ?>
												<option value="<?php echo $row1 -> feedbackStatusName; ?>"><?php echo $row1 -> feedbackStatusName; ?></option>
												<?php } ?>
                                            </select>
                                            </div>
                                         </div>
                                     <script>
                                     	function hide_nfd(next_action)
                                     	{
                                     		if(next_action=='Close' ||next_action=='Complaint Closed'){
                                     				document.getElementById("datett").disabled = true; 
												document.getElementById("timet").disabled = true; 
													nfd.style.display = "none";
													}else{
														nfd.style.display = "block";
												document.getElementById("datett").disabled = false; 
												document.getElementById("timet").disabled = false; 
                                     		}
                                     	}
                                     </script>
                                         <div id="nextactiondiv" class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Action:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <select name="nextaction" id="nextaction" class="form-control"  onchange='hide_nfd(this.value);' required >
                                            	<?php if(isset($lead_detail[0] -> nextAction)){if($lead_detail[0] -> nextAction==''){?>
												<option value="">Please Select </option>
												<?php } else{ ?>
                                            	<option value="<?php echo $lead_detail[0] -> nextAction; ?>"><?php echo $lead_detail[0] -> nextAction; ?></option>
												<?php } }else{?>
												<option value="">Please Select </option>
												<?php } ?> 
												
                                            	
                                            </select>
                                            </div>
                                      
                                 
                              
                       
                         </div>
                           
                                        
                                         <div  class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Complaint type:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <select name="complaint_type" id="complaint_type" class="form-control"  >
                                            	<option value="">Please Select </option>
												<option value="Sales">Sales</option>
												<option value="Used Car">Used Car </option>
												<option value="Service">Service </option>
												
												
                                            	
                                            </select>
                                            </div>
                                       
                                      
                         </div>
                           <div  class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Complaint location:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <select name="location" id="location" class="form-control"  >
                                            	<option value="">Please Select </option>
                                            	<option value="Kharghar Showroom">Kharghar Showroom</option>												<option value="Bandra Showroom">Bandra Showroom</option>												<option value="Malad Showroom">Malad Showroom</option>
                                            	<option value="Thane Nexa">Thane Nexa</option>
                                            	<option value="Nexa Baner Showroom">Nexa Baner Showroom</option>
                                            	<option value="Pune Magarpatta">Pune Magarpatta</option>
                                            	
                                            	<option value="Kharghar Workshop">Kharghar Workshop</option>
												<option value="Kalina Workshop">Kalina Workshop</option>
												<option value="Taloja Workshop">Taloja Workshop</option>
												<option value="Baner Workshop">Baner Workshop</option>
												<option value=">Pune Wadki<">Pune Wadki</option>
												<option value="POC Mumbai">POC Mumbai</option>
												<option value="POC Pune">POC Pune</option>
											
												
                                            	
                                            </select>
                                            </div>
                                       
                                      
                         </div>
                         </div>
                         
                         <div class="col-md-6">
                         	  <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Email:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text"  placeholder="Enter Email"  name='email'  id="email" class="form-control"/>
                                            </div>
                                        </div>
						<div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" >Address:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                  	<textarea placeholder="Enter Address" name='address' id="location" class="form-control" /><?php echo $lead_detail[0] -> address; ?></textarea>
                                          
                                            </div>
                                      </div>
											<div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Registration No:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <input placeholder="Enter Registration Number"  onkeyup="return limitlength(this, 10)" name="reg_no" id="reg_no" class="form-control" type="text">
                                            </div>
                                        </div>
              
                                   
                             					<div  id='nfd' style="display:block">
                              <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Follow Up Date:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text"  placeholder="Enter Next Follow Up Date" id="datett" name='followupdate'  class="datett form-control" required  style="background:white; cursor:default;" />
                                           
                                            </div>
                                                               </div>
											      <div class="form-group" >
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Follow Up Time:
                                            </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-10">
												  
												  <div class="input-group"> <input class="form-control "  data-template="dropdown" id="timet" name="followuptime" placeholder="Enter Next Follow Up Time" type="text"> <div class="input-group-addon"> <a href="#timet"><i class="entypo-clock"></i></a> </div> </div>

		
                                                               </div>                
									</div>				   
                                            
									</div>
                                                            
									 
     										
									
     
                                     <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Remark:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <textarea placeholder="Enter Remark" name='comment'  class="form-control" required /></textarea>
                                            </div>
                                                               </div>
                                     
                                     
									  
                                      
                           
                                                              </div>
                                                              
                                                             </div>
                                                             </div>
               <!-- -->
            




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
<?php if(count($select_followup_lead)>0)
{?>
	<table class="table datatable" id="results"> 
					<thead>
						<tr>
							<th>Sr No</th>
						
							<th>Follow Up By</th>
							<th>Call Status</th>		
							<th>Call Date</th>
							<th>Call Time</th>									
								<th>Feedback Status</th>
							<th>Next Action</th>	
						
							<th>N.F.D</th>
							<th>N.F.T</th>									
							<th>Remark</th>	
						<!--	<th>Escalation Type</th>
						<th>Escalation Remark</th>	-->							
						</tr>	
					</thead>
					<tbody>
						<?php
						$i=0;
						foreach($select_followup_lead as $row)
						{
							
							$i++;
						
						?>
						<tr>
						<td><?php echo $i ;?></td>
					
							<td><?php echo $row -> fname . ' ' . $row -> lname; ?></td>
							<td><?php echo $row -> contactibility; ?></td>
							<td><?php echo $row -> c_date; ?></td>
							<td><?php echo $row -> created_time; ?></td>
							<td><?php echo  $row  -> feedbackStatus; ?></td>
							<td><?php echo   $row  -> nextAction; ?></td>
							
							
							<td><?php echo $row -> nextfollowupdate ?></td>
								<td><?php echo $row -> nextfollowuptime ?></td>
							<td><?php echo $row -> f_comment; ?></td>
							<!--<td><?php echo $row -> escalation_type ; ?></td>
							<td><?php echo $row -> escalation_remark; ?></td>-->
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php }  ?>
				</div>
			</div> 
	 </div>
       	<!-- Modal -->
			<div class="modal fade" id="modal-6">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3>Escalation Details</h3> </div>
            <div class="modal-body">
                <div class="row">
				
				 <div class="col-md-12 " >
				 	
						<?php if(isset($lead_detail[0]->esc_level1)){
							 if($lead_detail[0]->esc_level1=='Yes' || $lead_detail[0]->esc_level2=='Yes' || $lead_detail[0]->esc_level3=='Yes'){ ?>
			<h4>Escalation Done</h4>
							 <?php }else{ ?>
			<h4>Escalation Not Done Yet </h4>
						<?php } } ?>
						<div class="table-responsive" style="overflow-x:scroll">
					<table class="table ">
						
						<?php if(isset($lead_detail[0]->esc_level1)){
							 if($lead_detail[0]->esc_level1=='Yes'){ ?>
										<tr>
										<th>Escalation Level 1</th>
										<!--<td><?php if(isset($lead_detail[0]->esc_level1)){ echo $lead_detail[0]->esc_level1; } ?></td>-->
										<td><?php if(isset($lead_detail[0]->esc_level1)){ echo $lead_detail[0]->esc_level1_remark; } ?></td>
										</tr>
							 <?php } } ?>
							 <?php if(isset($lead_detail[0]->esc_level2)){
							 if($lead_detail[0]->esc_level2=='Yes'){ ?>
										<tr>
										<th>Escalation Level 2</th>
										<!--<td><?php if(isset($lead_detail[0]->esc_level2)){ echo $lead_detail[0]->esc_level2; } ?></td>-->
										<td><?php if(isset($lead_detail[0]->esc_level1)){ echo $lead_detail[0]->esc_level2_remark; } ?></td>
										</tr>
							 <?php } } ?>
							  <?php if(isset($lead_detail[0]->esc_level3)){
							 if($lead_detail[0]->esc_level3=='Yes'){ ?>
										<tr>
										<th>Escalation Level 3</th>
										<!--<td><?php if(isset($lead_detail[0]->esc_level3)){ echo $lead_detail[0]->esc_level3; } ?></td>-->
										<td><?php if(isset($lead_detail[0]->esc_level3)){ echo $lead_detail[0]->esc_level3_remark; } ?></td>
										
										</tr>
							  <?php } } ?>
										</table>
										</div>
										</div>
										<br><br><br>
										<div class="col-md-12" style="margin-top:20px">
										
                    <div class="col-md-6">
					<form action="<?php echo site_url();?>add_followup_new_car/insert_escalation_detail" method="post">
                       <input type="hidden" name="booking_id" value="<?php echo $lead_detail[0]->enq_id ?>">
					   <input type="hidden" name="path" value="<?php echo $path ;?>">
					   <div class="form-group">
                            <label for="field-1" class="control-label">Escalation Type</label>
                           <select name="escalation_type" id="escalation_type" class="form-control" required>
                                       
										<option value="">Please Select  </option>
                      					<option value="Escalation Level 1">Escalation Level 1</option>
                      					<option value="Escalation Level 2">Escalation Level 2</option>
                      					<option value="Escalation Level 3">Escalation Level 3</option>
                       					
                   					</select>
                                   </div>
                               </div>
                      <div class="col-md-6">
                           	 <div class="form-group" >
                                   <label for="field-1" class="control-label">Escalation Remark:</label>
                                      
                                                <textarea placeholder="Enter Remark" id='escalation_remark' name='escalation_remark'  class="form-control"  required /></textarea>
                                          
                                </div>
                             
						  </div>
                    </div>
                    
                </div>
				</div>
                
               
                
           
            <div class="modal-footer">
               
                <button type="submit" class="btn btn-info">Submit</button>
				 <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
			</form>
        </div>
    </div>
</div>		
<script src="<?php echo base_url();?>assets/js/campaign.js" ></script>					