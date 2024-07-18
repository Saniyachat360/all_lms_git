<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<style>
.ui-timepicker {
   
    text-align: left;
}
.ui-timepicker-container {
	z-index:10000;
}
</style>
<body  class="page-body" >
<div class="container" style="width: 100%;">
	<div class="row">
<div >

		<h1 style="text-align:center;">Follow Up Details</h1> <br/>
                       <p style="text-align:center;"> Name: <b style="font-size: 15px;"><?php echo $lead_detail[0] -> name; ?></b></p>
                       <p style="text-align:center;"> Contact: <b style="font-size: 15px;"><?php echo $lead_detail[0] -> contact_no; ?></b></p>
                       
 	 					<a id="sub" style="margin-top: -50px" target="_blank" class="pull-right"  href="<?php echo site_url(); ?>website_leads/lms_details/<?php echo $lead_detail[0] -> enq_id; ?>/<?php echo $enq; ?>">
						<i class="btn btn-info entypo-doc-text-inv">Customer Details</i>
						</a>
						<?php $insert=$_SESSION['insert'];
						if($insert[36]==1){?>
 	 	<div class="panel panel-primary">
     		<div class="panel-body">
     			<form action="<?php echo site_url(); ?>add_followup_finance/insert_followup" method="post">
					<input type="hidden" name="booking_id" id='enq_id' value="<?php echo $lead_detail[0] -> enq_id; ?>">
                	<input type="hidden" name="phone" value="<?php echo $lead_detail[0] -> contact_no; ?>">
					<input type="hidden" name="loc" value="">
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
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Call Status:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                            <select name="contactibility" id="contactibility" class="form-control"   required >
                                                <option value="">Please Select </option>  
                        <option value="Connected">Connected</option>
                        <option value="Not Connected">Not Connected</option>
                        
                                            </select></div>
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
                                            	<select name="nextAction" id="nextAction" class="form-control" required  onchange='check_nfd(this.value);' >
                                					<option value="">Please Select</option>
                                					<?php
                                				
                                					foreach ($selectNextAction as $row) {?>
														<option value="<?php echo $row -> nextActionName; ?>"><?php echo $row -> nextActionName; ?></option>
													<?php } ?>
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
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Email: </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                             			<input type="text"  placeholder="Enter Email"  name='email'  id="email" class="form-control" value="<?php echo $lead_detail[0] -> email; ?>"/>
                                           		 	</div>
                                       			</div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Address:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <textarea placeholder="Enter Address" name='address' id="location" class="form-control" /><?php echo $lead_detail[0] -> address; ?></textarea>
                                         	</div>
                                      </div>
                        				<input type="hidden" value="<?php echo date("Y-m-d"); ?>" name="date"   class="form-control"  />
                        				 
                                    	<div class="form-group" id='nfdDiv'>
                                    						      <div class="form-group" >
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Follow Up Time:
                                            </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-10">
												  
												  <div class="input-group"> <input class="form-control " required data-template="dropdown" id="timet" name="followuptime" placeholder="Enter Next Follow Up Time" type="text" style="z-index: 0"> <div class="input-group-addon"> <a href="#timet"><i class="entypo-clock"></i></a> </div> </div>

												  
												 
										
                                                               </div>                
									</div>
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Follow Up Date:</label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                	<input type="text"  placeholder="Enter Next Follow Up Date" required id="followupdate" name='followupdate'  class="datett form-control"    />
                                           		</div>
                                            </div>
                                            <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Remark:</label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                		<textarea placeholder="Enter Remark" name='comment'  class="form-control" required /></textarea>
                                           		 </div>
                                            </div>
                                            
                                     	</div>
                                     </div>
                                     </div>
                                       <div class="panel panel-primary">
     		<div class="panel-body">
     			<div class="col-md-6">
                                      <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Loan Type:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                              <select class="form-control" id="loan_type" name="loan_type" onchange='show_loan_details()'>
												<option value="">Please Select</option>		
											
                        	<?php foreach ($select_loan_type as $row) {?>
											<option value="<?php echo $row->loan_name;?>"><?php echo $row->loan_name;?></option>
						            	<?php	} ?>
											</select>
											
										</div>
                                      </div>
                                     </div>
                                        <div class="col-md-6">
                                        	<a href="<?php echo site_url('scripts/show_scripts')?>" target='_blank' class="btn btn-primary col-md-3 col-xs-12 col-sm-12" >Check Script</a>
                                        	<a href="<?php echo site_url('scheme/show_schemes')?>" target='_blank' class="btn btn-primary col-md-offset-1 col-md-3 col-xs-12 col-sm-12" >Check Scheme</a>
                                      	<a href="javascript:;" onclick="jQuery('#send_mail_modal').modal('show', {backdrop: 'static'});" 
                                        	class="btn btn-primary col-md-offset-1 col-md-3 col-xs-12 col-sm-12" >Upload Documents</a>
                                      </div>
     		</div>
     	</div>
       
  
  
  
  
     	                         <script>
     	function show_loan_details()
     	{
     	    all_loan_type_details();
     	   var emp_type=document.getElementById("loan_type").value;
     	 //  alert(emp_type);
     	   if(emp_type=='1')
     	   {
     	        
     	       
     	   }
     	   else if(emp_type=='Home Loan')
     	   {
     	        $("#home_loan_div").show();
     	        
     	        // document.getElementById("monthly_income").disabled = false;
     	   }
     	   else if(emp_type=='Car Loan')
     	   {
     	       $("#car_loan_div").show();
     	   }
     	    else if(emp_type=='Loan Against Property')
     	   {
     	        $("#lap_div").show();
     	   }
     	   else if(emp_type=='Loan Against Car')
     	   {
     	        $("#car_loan_div").show();
     	   }
     	    else if(emp_type=='BTTP')
     	   {
     	        $("#car_loan_div").show();
     	   }
     	}
     	function all_loan_type_details()
     	{
     	    
     	    $("#home_loan_div").hide(); 
     	     $("#lap_div").hide();
     	       $("#car_loan_div").hide();
     	     
     	    
     	}
     	</script>
     	<div class="panel panel-primary" >
     		<div class="panel-body">
     		    <div id='maindiv'>
     		        <div class="col-md-6">
     		        <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Required Loan Amount:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                              <select class="form-control" id="req_loan_amount" name="req_loan_amount" >
												<option value="">Please Select</option>		
												<option value="Upto 5 Lacs">Upto 5 Lacs</option>
													<option value="5 Lacs-10 Lacs">5 Lacs-10 Lacs</option>
                        <option value="10 Lacs-25 Lacs">10 Lacs-25 Lacs</option>
                         <option value="25 Lacs-50 Lacs">25 Lacs-50 Lacs</option>
                          <option value="50 Lacs-1 Cr">50 Lacs-1 Cr</option>
                          <option value="1 Cr-3 Cr">1 Cr-3 Cr</option>
                           <option value="3 Cr-5 Cr">3 Cr-5 Cr</option>
                            <option value="5 Cr+">5 Cr+</option>
                        
											</select>
										</div>
                                      </div>
     		        </div> <div class="col-md-6">
     		        
     		        <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" > City:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                              <input type="text" placeholder="Enter City"  name='city' id="city" class="form-control" />
											
										</div>
                                      </div>
                                      </div>
     		        </div>
     		         <div id='home_loan_div'>
     			<div class="col-md-6">
                                      
                                     
                                        <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Property Type:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                              <select class="form-control" id="property_type_hl" name="property_type_hl" >
												<option value="">Please Select</option>		
												<option value="1 BHK">1 BHK</option>
													<option value="2 BHK">2 BHK</option>
														<option value="3 BHK">3 BHK</option>
															<option value="4 BHK">4 BHK</option>
														<option value="Bunglow">Bunglow</option>
														<option value="Row House">Row House</option>
                        
											</select>
											
										</div>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Property Details:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter Property Details"  name='property_details' id="property_details" class="form-control" />
                                         	</div>
                                      </div>
                                     </div>
                                        <div class="col-md-6">
                                        	 <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Property Cost:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter Property Cost"  name='property_cost' id="property_cost" class="form-control" />
                                         	</div>
                                      </div>
                                       
                                       <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Builder Name:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter Builder Name"  name='builder_name' id="builder_name" class="form-control" />
                                         	</div>
                                      </div>
                                      </div>
                                      </div>
     		    <div id='lap_div'>
     			<div class="col-md-6">
                                      <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Property Location:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                              <input type="text" placeholder="Enter Property Location"  name='property_location' id="property_location" class="form-control" />
											
										</div>
                                      </div>
                                        <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Property Type:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                              <select class="form-control" id="prop_type" name="prop_type" >
												<option value="">Please Select</option>		
												<option value="Industrial">Industrial</option>
													<option value="Commercial">Commercial</option>
														<option value="Plot">Plot</option>
											</select>
										</div>
                                      </div>
                                     </div>
                                        <div class="col-md-6">
                                        	 <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Property Usage:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                  <select class="form-control" id="prop_usage" name="prop_usage" >
												<option value="">Please Select</option>		
												<option value="Self">Self</option>
													<option value="Rented">Rented</option>
														<option value="Vacant">Vacant</option>
                        
											</select>
                                         	</div>
                                      </div>
                                       
                                      
                                      </div>
                                      </div>
                                      <div id='car_loan_div'>
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
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Registration Date:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter Registration Date" name='registration_date' id="registration_date" class="form-control" />
                                         	</div>
                                      </div>
                                      
                                     </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Registration Number:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter Registration No" name='registration_no' id="reg_no" class="form-control" />
                                         	</div>
                                      </div>
                                      </div>
                                      </div>
                                        
     		</div>
     	</div>
     	
     	<div class="panel panel-primary" >
     		<div class="panel-body">
     			<div class="col-md-6">
                                      <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Employment Type:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                              <select class="form-control" id="emp_type" name="emp_type" onchange='show_emp_details()'>
												<option value="">Please Select</option>		
											
                        	<?php foreach ($emp_type as $row) {?>
											<option value="<?php echo $row->e_id;?>"><?php echo $row->e_name;?></option>
						            	<?php	} ?>
											</select>
											
										</div>
                                      </div>
                                      <div class="form-group" id='at_div'>
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Annual Turnover:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                              <select class="form-control" id="annual_turnover" name="annual_turnover" >
												<option value="">Please Select</option>	
												<option value="Upto 5 Lacs">Upto 5 Lacs</option>
													<option value="5 Lacs-10 Lacs">5 Lacs-10 Lacs</option>
                        <option value="10 Lacs-25 Lacs">10 Lacs-25 Lacs</option>
                         <option value="25 Lacs-50 Lacs">25 Lacs-50 Lacs</option>
                          <option value="50 Lacs-1 Cr">50 Lacs-1 Cr</option>
                          <option value="1 Cr-3 Cr">1 Cr-3 Cr</option>
                           <option value="3 Cr-5 Cr">3 Cr-5 Cr</option>
                            <option value="5 Cr+">5 Cr+</option>
											</select>
											
										</div>
                                      </div>
                                      <div class="form-group" id='smode_div'>
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Mode of Salary:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                              <select class="form-control" id="salary_mode" name="salary_mode" onchange='show_bank()' >
												<option value="">Please Select</option>	
												<option value="Bank Transfer">Bank Transfer</option>
												<option value="Cash">Cash</option>
												<option value="Cheque">Cheque</option>
											</select>
											
										</div>
                                      </div>
                                        <div class="form-group" id='bn_div'>
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Bank Name:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                              <select class="form-control" id="salary_bank" name="salary_bank" >
												<option value="">Please Select</option>		
												<?php foreach ($bank as $row) {?>
											<option value="<?php echo $row->bank_name;?>"><?php echo $row->bank_name;?></option>
						            	<?php	} ?>
                        
											</select>
											
										</div>
                                      </div>
                                       <div class="form-group" id='prof_type_div'>
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Profession Type:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                              <select class="form-control" id="prof_type" name="prof_type" >
												<option value="">Please Select</option>		
												<?php foreach ($prof_type as $row) {?>
											<option value="<?php echo $row->p_type_id;?>"><?php echo $row->p_type_name;?></option>
						            	<?php	} ?>
                        
											</select>
											
										</div>
                                      </div>
                                       <div class="form-group" id='employer_div'>
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Employer Name:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter Employer Name"  name='employer' id="employer" class="form-control" />
                                         	</div>
                                      </div>
                                     </div>
                                     <script>
     	function show_emp_details()
     	{
     	    all_emp_type_details();
     	   var emp_type=document.getElementById("emp_type").value;
     	 //  alert(emp_type);
     	   if(emp_type=='1')
     	   {
     	        $("#smode_div").show();
     	        $("#monthly_gross_div").show();
     	        $("#designation_div").show();
     	        $("#employer_div").show();
     	        $("#monthly_net_div").show();
     	          document.getElementById("salary_mode").disabled = false;
     	           document.getElementById("monthly_net").disabled = false;
     	    document.getElementById("monthly_gross").disabled = false;
     	     document.getElementById("designation").disabled = false;
     	    document.getElementById("employer").disabled = false;
     	       
     	   }
     	   else if(emp_type=='3' || emp_type=='6' || emp_type=='7')
     	   {
     	        $("#gross_annual_div").show();
     	         $("#at_div").show();
     	          $("#mon_income_div").show();
     	        document.getElementById("annual_turnover").disabled = false;
     	         document.getElementById("gross_annual").disabled = false;
     	         document.getElementById("monthly_income").disabled = false;
     	   }
     	   else if(emp_type=='4')
     	   {
     	        $("#prof_type_div").show();
     	         $("#cp_years_div").show(); 
     	          $("#at_div").show(); 
     	        document.getElementById("prof_type").disabled = false;
     	         document.getElementById("cp_years").disabled = false;
     	          document.getElementById("annual_turnover").disabled = false;
     	   }
     	    else if(emp_type=='5')
     	   {
     	        $("#designation_div").show();
     	        $("#employer_div").show();
     	       document.getElementById("designation").disabled = false;
     	    document.getElementById("employer").disabled = false;
     	   }
     	}
     	function all_emp_type_details()
     	{
     	    document.getElementById("annual_turnover").disabled = true;
     	    document.getElementById("salary_mode").disabled = true;
     	    document.getElementById("salary_bank").disabled = true;
     	    document.getElementById("prof_type").disabled = true;
     	    document.getElementById("monthly_income").disabled = true;
     	    document.getElementById("gross_annual").disabled = true;
     	    document.getElementById("monthly_net").disabled = true;
     	    document.getElementById("monthly_gross").disabled = true;
     	    document.getElementById("designation").disabled = true;
     	    document.getElementById("employer").disabled = true;
     	    document.getElementById("cp_years").disabled = true;
     	   /* document.getElementById("itr1").disabled = true;
     	    document.getElementById("itr2").disabled = true;
     	    document.getElementById("itr3").disabled = true;
     	    document.getElementById("itr4").disabled = true;*/
     	    $("#at_div").hide(); 
     	     $("#smode_div").hide();
     	      $("#bn_div").hide();
     	       $("#prof_type_div").hide();
     	     $("#mon_income_div").hide();
     	      $("#gross_annual_div").hide();
     	       $("#monthly_net_div").hide();
     	        $("#monthly_gross_div").hide();
     	        $("#designation_div").hide();
     	        $("#employer_div").hide();
     	        $("#cp_years_div").hide();
     	     //    $("#itr_div").hide();
     	          $("#prof_type_div").hide();
     	}
     	function show_bank()
     	{
     	     var emp_type=document.getElementById("salary_mode").value;
     	  
     	   if(emp_type=='Bank Transfer')
     	   {
     	    
     	     $("#bn_div").show();
     	      document.getElementById("salary_bank").disabled = false;
     	   }
     	}
     	</script>
                                        <div class="col-md-6" >
                                        	 <div class="form-group" id='mon_income_div'>
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Monthly Income:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter Monthly Income" onkeypress="return isNumberKey(event)" name='monthly_income' id="monthly_income" class="form-control" />
                                         	</div>
                                      </div>
                                       <div class="form-group" id='gross_annual_div'>
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Gross Annual Profit:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter Gross Annual Profit"  name='gross_annual' id="gross_annual" class="form-control" />
                                         	</div>
                                      </div>
                                      <div class="form-group" id='monthly_net_div'>
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Monthly Net Salary:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter Monthly Net Salary"  name='monthly_net' id="monthly_net" class="form-control" />
                                         	</div>
                                      </div>
                                      <div class="form-group" id='monthly_gross_div'>
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Monthly Gross Salary:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter Monthly Gross Salary"  name='monthly_gross' id="monthly_gross" class="form-control" />
                                         	</div>
                                      </div>
                                     
                                      <div class="form-group" id='designation_div'>
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Designation:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter Designation"  name='designation' id="designation" class="form-control" />
                                         	</div>
                                      </div>
                                       <div class="form-group" id='cp_years_div'>
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Years in Current Profession:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter Years in Current Profession"  name='cp_years' id="cp_years" class="form-control" />
                                         	</div>
                                      </div>
                                       <div class="form-group" id='itr_div'>
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >ITR Available:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="checkbox" name='itr19' id="itr19" class="form-control" />
                                                2018-19
                                                 <input type="checkbox"   name='itr20' id="itr20" class="form-control" />
                                                2019-20
                                                  <input type="checkbox"   name='itr21' id="itr21" class="form-control" />
                                                2020-21
                                                 <input type="checkbox"  name='itr22' id="itr22" class="form-control" />
                                                2021-22
                                         	</div>
                                      </div>
                                      </div>
     		</div>
     	</div>
                                     
   <div class="panel panel-primary">
     		<div class="panel-body">
     			<div class="col-md-6">
     				    <div class="form-group" >
                                    		<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Bank Name: </label>
                                   			<div class="col-md-8 col-sm-8 col-xs-12">
                                            	<select name="bank_name" id="bank_name" class="form-control"  >
                                					<option value="">Please Select</option>
                                				<?php foreach ($bank as $row) {?>
											<option value="<?php echo $row->bank_name;?>"><?php echo $row->bank_name;?></option>
						            	<?php	} ?>
                                					
	                                			</select>
                                            </div>
                                         </div>
                                      
                                     
                                      
                                       <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >ROI:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter ROI" onkeypress="return isNumberKey(event)" name='roi' id="roi" class="form-control" />
                                         	</div>
                                      </div>
                                        
                                      <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Tenure:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter Tenure" onkeypress="return isNumberKey(event)" name='tenure' id="tenure" class="form-control" />
                                         	</div>
                                      </div>
                                       
                                      <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Dealer/DSA:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                             <select class="form-control" id="dealer" name="dealer" >
												<option value="">Please Select</option>	
                                             	<option value="232982-EXCELL TECHNOLOGY VENTURES P LIMITED">232982-EXCELL TECHNOLOGY VENTURES P LIMITED</option>
                                             	<option value="31918-EXCELL AUTOVISTA P LIMITED">31918-EXCELL AUTOVISTA P LIMITED</option>
                                             </select>
                                         	</div>
                                      </div>
                                     </div>
                                        <div class="col-md-6">
                                        	<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >PAN No:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter PAN No"  name='pan' id="pan" class="form-control" />
                                         	</div>
                                      </div>
     						<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >LOS No:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter LOS No" name='los_no' id="los_no" class="form-control" />
                                         	</div>
                                      </div>
                                       <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Amount:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter Loan Amount" onkeypress="return isNumberKey(event)" name='loan_amount' id="loan_amount" class="form-control" />
                                         	</div>
                                      </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >EMI:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter EMI" name='emi' onkeypress="return isNumberKey(event)" id="emi" class="form-control" />
                                         	</div>
                                      </div>
                                        
                                      </div>
     		</div>
     	</div>
     	 <div class="panel panel-primary">
     		<div class="panel-body">
     			<div class="col-md-6">
     			
                                      <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Login Status:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                  <select class="form-control" id="login_status_name" name="loan_status" onchange='show_reject_reason(this.value)'>
												<option value="">Please Select</option>		
												<?php foreach ($select_login_status as $row) {?>
													<option value="<?php echo $row->login_status_name;?>"><?php echo $row->login_status_name;?></option>	
												<?php } ?>
												
												</select>
                                         	</div>
                                      </div>
                                      <div id='r_reason_div'>
                                      <div class="form-group" >
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Reject Reason:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                  <select class="form-control" id="reject_reason" name="reject_reason" >
												<option value="">Please Select</option>		
												<?php foreach ($reject_reason as $row) {?>
													<option value="<?php echo $row->r_reason_name;?>"><?php echo $row->r_reason_name;?></option>	
												<?php } ?>
												
												</select>
                                         	</div>
                                      </div>
                                       <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Reject Date:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                         		<input type="text"  placeholder="Enter Reject Date"  name='reject_date' id="reject_date"  class="datett form-control"  readonly style="background:white; cursor:default;right: 0 !important;" />
                                         
                                         	</div>
                                      </div>
                                      </div>
                                       <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Login Date:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                         		<input type="text"  placeholder="Enter Login Date"  name='login_date' id="login_date"  class="datett form-control"  readonly style="background:white; cursor:default;right: 0 !important;" />
                                         
                                         	</div>
                                      </div>
                                      
                                       <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Approved Date:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                         		<input type="text"  placeholder="Enter Approved Date"  id="approved_date" name='approved_date'  class="datett form-control"  readonly style="background:white; cursor:default;" />
                                         
                                         	</div>
                                      </div>
                                      	<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Pickup Date:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                             
                                         		<input type="text"  placeholder="Enter Pickup Date"  id="pick_up_date" name='pickup_date'  class="datett form-control"  readonly style="background:white; cursor:default;" />
                                         
                                         	</div>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Collection Executive Name:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter Excutive Name" name='excutive_name' id="executive_name" class="form-control" />
                                         	</div>
                                      </div>
                                     </div>
                                     <div class="col-md-6">
                                       <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Disburse Date:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter Disburse Date" name='disburse_date' id="disburse_date" class="datett form-control"   />
                                         		
                                         	</div>
                                      </div>
                                         <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Disburse Amount:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter Disburse Amount " onkeypress="return isNumberKey(event)" name='disburse_amount' id="disburse_amount" class=" form-control" />
                                         	</div>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Payout Percent:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter Payout percent" onkeypress="return isNumberKey(event)" name='payout_percent' id="payout_percent" class="form-control" />
                                         	</div>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Payout Amount:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter Payout Amount" onkeypress="return isNumberKey(event)" name='payout_amount' id="payout_amount" class="form-control" />
                                         	</div>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Processing Fee:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" placeholder="Enter Processing Fee" onkeypress="return isNumberKey(event)" name='process_fee' id="process_fee" class="form-control" />
                                         	</div>
                                      </div>
                                     
                                      
     				</div>
     				</div>
     			</div>
				
     			<!--<h3 class="text-center">Transfer Lead</h3>-->
     				<div class="panel panel-primary">
					
                	<div class="panel-body">
                	   		 <?php $insert= $_SESSION['insert'];
                        if($insert[35]==1)
						{
							if($lead_detail[0]->transfer_process!=''){?>
								<div class="col-md-6">                      		
                        	<div class="form-group">
  								 <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">	Lead Transferred To:&nbsp;&nbsp;&nbsp;     <?php echo  $lead_detail[0]->transfer_process; ?> </label>
                           </div>
                          </div>
							<?php  }else{ ?>
     					<div class="col-md-6">                      		
                        	<div class="form-group">
  								 <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">Click Here To Transfer Lead: </label>
                                 	<div class="col-md-5 col-sm-5 col-xs-12">
                                     	<label class="checkbox-inline "><input type="checkbox" id="transfer" name="transfer" onclick="transfer_lead()" >Yes</label>
                                     	</div>
                                    </div>  
                               </div>
                                    <?php } } ?>
                                  <div class="col-md-6">
                                        		
                                        
                                        
                                      </div>
                               </div>
                              </div-->
                              				<!-- Transfer Div -->
				<div id="tassignto" style="display: none">
					<div class="panel panel-primary">		<h3 class="text-center">Transfer Lead</h3>
                	<div class="panel-body">		
                		<div class="col-md-12">
                						
                 <div class="col-md-6">
    		 			<div class="form-group">
    	                 <label class="control-label col-md-4 col-sm-4 col-xs-12" >Transfer Process:</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                	<select name="tprocess" id="tprocess" class="form-control" required disabled=true  onchange="select_transfer_location()">
                                      <option value="<?php echo $_SESSION['process_id']; ?>"><?php echo $_SESSION['process_name']; ?></option>
                     				<?php foreach($process as $fetch1){ ?>
												<option value="<?php echo $fetch1 -> process_id; ?>"><?php echo $fetch1 -> process_name; ?></option>
                     							 <?php } ?>
                       					</select>
                                   </div>
                             </div>
                         
                        </div>
             
                            <div id="tlocation_div" class="col-md-6" >
                            	
                             	<div class="form-group">
    	                 <label class="control-label col-md-4 col-sm-4 col-xs-12" >Transfer Location:</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                	<select name="tlocation" id="tlocation1" class="form-control" required disabled=true  onchange="select_assign_to()">
                                        <?php if($lead_detail[0]->location != ''){?>
												<option value=" <?php echo $lead_detail[0] -> location; ?>"> <?php echo $lead_detail[0] -> location; ?></option>
										<?php } else{ ?>
												<option value="">Please Select  </option>
										<?php } ?>
									<?php foreach($get_location1 as $fetch1){ ?>
												<option value="<?php echo $fetch1 -> location; ?>"><?php echo $fetch1 -> location; ?></option>
                     							 <?php } ?>
                       					</select>
                                   </div>
                             </div>mo
                               
                                 </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6" >
                                  <div id="assign_div">
                                 <div  class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Transfer To:</label>
                                        <div class="col-md-8 col-sm-8 col-xs-12" style="margin-top: -5px;">
                                           <select name="transfer_assign" id="tassignto1" class="form-control" required disabled=true>
                                         		<option value="">Please Select</option> 
											</select>
                                          </div>
                                      </div>
                               </div>
									</div>
									</div>
							</div>
						</div>
				 </div>
				 	<div class="panel panel-primary">
                	<div class="panel-body">
			
								<div class="col-md-12" style="border: 1px solid #ddd">
							<h3 style="text-align:center">EMI Calculator</h3>
							<div class="col-md-6">
							  <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Loan Amount:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                               <input type="text" id="loanamount" value="400000" class="form-control col-md-8" name="loanamount" maxlength="100" title="Name" placeholder="Amount" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Amount'">
                                         	</div>
                                      </div>
		  <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Rate of Interest(%):</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                           <input type="text" id="interest" value="12.5" class="form-control col-md-8" name="interest" maxlength="10" placeholder="Interest" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Interest'">
</div>
                                      </div>
		

							<div class="col-md-12" style="margin-bottom: 20px">
							<button type="button" onclick="emical()" class="btn btn-primary col-md-offset-4 col-md-4 col-xs-12 col-sm-12" >Calculate EMI</button>
							</div>
							</div>
							<br>
		
							<div class="col-md-offset-1 col-md-4" Style="margin-top:-20px;margin-bottom:10px;">
							<table class="table table-bordered">
    <thead>
      <tr>
        <th>Months</th>
        <th>EMI per Month</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>12</td>
        <td id="monthly1"></td>
      </tr>
      <tr>
        <td>24</td>
        <td id="monthly2"></td>
      </tr>
      <tr>
        <td>36</td>
        <td id="monthly3"></td>
      </tr>
	   <tr>
        <td>48</td>
        <td id="monthly4"></td>
      </tr>
	   <tr>
        <td>60</td>
        <td id="monthly5"></td>
      </tr>
	   <tr>
        <td>72</td>
        <td id="monthly6"></td>
      </tr>
	   <tr>
        <td>84</td>
        <td id="monthly7"></td>
      </tr>
    </tbody>
  </table>
       
	   </div>
	  </div>
	  </div></div>
  
  			<div class="form-group">
      <div class="col-md-2 col-md-offset-5">
          <button type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12">Submit</button>
     </div>
     <div class="col-md-2">
          <button type="reset" class="btn btn-primary col-md-12 col-xs-12 col-sm-12">Reset</button>
     </div>
    </div>
  </div>
</form>
 </div>
 </div>
 <?php } ?> 
  
<?php if($lead_detail[0]->cse_followup_id!='')
{?>
<table class="table table-bordered datatable" id="results"> 
	<thead>
		<tr>
			<th>Follow Up By</th>
      <th>Call Status</th>
			<th>Call Date Time</th>		
			<th>N.F.D.T</th>
			<th>Feedback Status</th>
			<th>Next Action</th>					
			<th>Remark</th>	
		</tr>	
	</thead>
	<tbody>
		<?php foreach($select_followup_lead as $row){ ?>
		<tr>
			<td><?php echo $row -> fname . ' ' . $row -> lname; ?></td>
      <td><?php echo $row -> contactibility; ?></td>
			<td><?php echo $row -> date.' '.$row->created_time; ?></td>
			<td><?php echo $row -> nextfollowupdate.' '.$row->nextfollowuptime ?></td>
			<td><?php echo $row -> feedbackStatus; ?></td>
			<td><?php echo $row -> nextAction; ?></td>
			<td><?php echo $row -> comment; ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php } ?>
</div>
<div class="modal fade " id="send_mail_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3>Upload Documents</h3> </div>
            <div class="modal-body" style=' overflow-x: scroll; height: 500px;'>
                <div class="row">
					<form action="<?php echo site_url();?>add_followup_finance/insert_document" method="POST" enctype="multipart/form-data">
						
						<input type="hidden" name="booking_id" value="<?php echo $lead_detail[0]->enq_id; ?>" />
				 <div class="col-md-12" >
											<div class="panel panel-primary">
				
						<div class="panel-body">
						    <div class='row'>
						    	<div class="col-md-offset-2 col-md-8">
    		 			<div class="form-group">
    	                   <label class="control-label col-md-12 col-sm-12 col-xs-12" > Loan Type: </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <select class="form-control "  name="l_id"  id="l_id" required data-placeholder="Select Template Name"  onchange="show_docs(this.value)">
							<option value="">Please Select</option>
		                  <?php
		                    foreach($select_loan_type as $rowm){    ?>   
		                     <option value="<?php echo $rowm->loan_id;?>"><?php echo $rowm->loan_name;?></option>
		                           <?php } ?> 
                     </select>
                        </div>
                     </div>
                     
                  </div>
                  </div>
                 
                   <div class=''>
                    <div id='mail_desc_div' >
                         <br>
                  <br>
                        
                    
                    </div>
                  </div>
                  <?php if(count($docs_history)>0){?>
                  <div class=''>
                      <h3 >Uploaded Documents</h3>
                      <table class="table table-bordered datatable" id="results"> 
	<thead>
		<tr>
		     <th>Loan</th>
			<th>Document Name</th>
     <th>Document Number</th>
			<th>Document</th>
		</tr>	
	</thead>
	<tbody>
		<?php foreach($docs_history as $row){ ?>
		<tr>
		    <td><?php echo $row -> loan_name; ?></td>
			<td><?php echo $row -> document_name;  ?></td>
      	<td><?php echo $row -> document_number;  ?></td>
       <td><a href='<?php echo base_url()?>/assets/document/<?php echo $row -> document; ?>' target='_blank'><?php echo $row -> document; ?></a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
                      </div>
                      <?php } ?>						    		</div>
					</div>       	</div>
   
       	 <!-- Modal footer -->
      <div class="modal-footer">
      </div>
      </form>
       	</div>
       	</div>
       	</div>
       	</div>
       	</div>
	<!--/div>
		</div>	</div>	</div-->
						      	<!-- Modal -->
       	
	
<script>function show_docs(loan_id){
//	var tprocess = document.getElementById("tprocess").value;
		$.ajax({
		url : '<?php echo site_url('add_followup_finance/show_docs'); ?>',
		type : 'POST',
		data : {'loan_id' : loan_id},
		success : function(result) {
			$("#mail_desc_div").html(result);
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

	function limitlength(obj, length) {
		var maxlength = length
		if (obj.value.length > maxlength)
			obj.value = obj.value.substring(0, maxlength)
	}
// show and hide nfd div
function check_nfd(val) {

if(val=='Lost' || val=='Disbursement')
{
		document.getElementById("followupdate").disabled = true; 
		document.getElementById("timet").disabled = true; 
		nfdDiv.style.display = "none";
}else{
		nfdDiv.style.display = "block";
		document.getElementById("followupdate").disabled = false; 
		document.getElementById("timet").disabled = false; 
	}
}
window.onload= check_values();
function check_values()
{
	//Basic followup

	var email_old='<?php echo $lead_detail[0] -> email; ?>';
	var eagerness_old='<?php echo $lead_detail[0] -> eagerness; ?>';
	var feedbackStatus='<?php echo $lead_detail[0] -> feedbackStatus; ?>';
	var nextAction='<?php echo $lead_detail[0] -> nextAction; ?>'; 
	var bank_name='<?php echo $lead_detail[0] -> bank_name; ?>'; 
	var los_no='<?php echo $lead_detail[0] -> los_no; ?>'; 
	var loan_type='<?php echo $lead_detail[0] -> loan_type; ?>'; 
	var roi='<?php echo $lead_detail[0] -> roi; ?>';
	var tenure='<?php echo $lead_detail[0] -> tenure; ?>'; 
	var dealer='<?php echo $lead_detail[0] -> dealer; ?>';
	var login_status_name='<?php echo $lead_detail[0] -> login_status_name; ?>'; 
	var reg_no='<?php echo $lead_detail[0] -> reg_no; ?>'; 
	var model_name=	'<?php echo $lead_detail[0] -> model_id; ?>'; 		
	var loanamount=	'<?php echo $lead_detail[0] -> loanamount; ?>'; 
	var pick_up_date=	'<?php echo $lead_detail[0] -> pick_up_date; ?>'; 	
	var executive_name=	'<?php echo $lead_detail[0] -> executive_name; ?>';	
	var disburse_amount=	'<?php echo $lead_detail[0] -> disburse_amount; ?>';	
	var disburse_date=	'<?php echo $lead_detail[0] -> disburse_date; ?>';	
	var process_fee=	'<?php echo $lead_detail[0] -> process_fee; ?>';	
	var emi=	'<?php echo $lead_detail[0] -> emi; ?>';	
	var approved_date=	'<?php echo $lead_detail[0] -> approved_date; ?>';	
	var file_login_date=	'<?php echo $lead_detail[0] -> file_login_date; ?>';	
		var alternate_contact=	'<?php echo $lead_detail[0] -> alternate_contact_no; ?>';	
		var req_loan_amount='<?php echo $lead_detail[0] -> req_loan_amount; ?>';
		var property_type_hl='<?php echo $lead_detail[0] -> property_type_hl; ?>';
		var property_details='<?php echo $lead_detail[0] -> property_detail; ?>';
		var property_cost='<?php echo $lead_detail[0] -> property_cost; ?>';
		var builder_name='<?php echo $lead_detail[0] -> builder_name; ?>';
	var prop_type='<?php echo $lead_detail[0] -> property_type_lap; ?>';
	var property_location='<?php echo $lead_detail[0] -> property_location; ?>';
	var prop_usage='<?php echo $lead_detail[0] -> property_usage; ?>';
	var emp_type='<?php echo $lead_detail[0] -> emp_type; ?>';
	var annual_turnover='<?php echo $lead_detail[0] -> annual_turnover; ?>';
	var salary_mode='<?php echo $lead_detail[0] -> salary_mode; ?>';
	var salary_bank='<?php echo $lead_detail[0] -> salary_bank; ?>';
	var prof_type='<?php echo $lead_detail[0] -> prof_type; ?>';
	var employer='<?php echo $lead_detail[0] -> employer_name; ?>';
	var monthly_income='<?php echo $lead_detail[0] -> monthly_income; ?>';
	var gross_annual='<?php echo $lead_detail[0] -> gross_annual_profit; ?>';
		var monthly_net='<?php echo $lead_detail[0] -> monthly_net; ?>';
			var monthly_gross='<?php echo $lead_detail[0] -> monthly_gross; ?>';
				var designation='<?php echo $lead_detail[0] -> designation; ?>';
					var cp_years='<?php echo $lead_detail[0] -> current_prof_yr; ?>';
						var pan='<?php echo $lead_detail[0] -> pan_no; ?>';
						var reject_reason='<?php echo $lead_detail[0] -> reject_reason; ?>';
						var reject_date='<?php echo $lead_detail[0] -> reject_date; ?>';
						var city='<?php echo $lead_detail[0] -> city; ?>';
						var close_status='<?php echo $lead_detail[0] -> close_status; ?>';
						var payout_percent ='<?php echo $lead_detail[0] -> payout_percent; ?>';
							var payout_amount ='<?php echo $lead_detail[0] -> payout_amount; ?>';
								var registration_date ='<?php echo $lead_detail[0] -> registration_date; ?>';
	var itr19='<?php echo $lead_detail[0] -> itr19; ?>';
	var itr20='<?php echo $lead_detail[0] -> itr20; ?>';
	var itr21='<?php echo $lead_detail[0] -> itr21; ?>';
	var itr22='<?php echo $lead_detail[0] -> itr22; ?>';
	 check_nfd(nextAction);
	 if(close_status=='1')
	 {
	     if(reject_reason != '')		{	document.getElementById("reject_reason").value = reject_reason;	}
		        if(reject_date != '')		{	document.getElementById("reject_date").value = reject_date;	}
	 }
	 else
	 {
	     show_reject_reason (login_status_name)
	 }
	  
	 if(itr19 == 'Yes')		{	document.getElementById("itr19").checked = true;	}
	 if(itr20 == 'Yes')		{	document.getElementById("itr20").checked = true;	}
	 if(itr21 == 'Yes')		{	document.getElementById("itr21").checked = true;	}
	 if(itr22 == 'Yes')		{	document.getElementById("itr22").checked = true;	}
	  if(payout_percent != '')		{	document.getElementById("payout_percent").value = payout_percent;	}
	  if(payout_amount != '')		{	document.getElementById("payout_amount").value = payout_amount;	}
	  if(registration_date != '')		{	document.getElementById("registration_date").value = registration_date;	}
	  if(city != '')		{	document.getElementById("city").value = city;	}
	 if(req_loan_amount != '')		{	document.getElementById("req_loan_amount").value = req_loan_amount;	}
	 if(property_type_hl != '')		{	document.getElementById("property_type_hl").value = property_type_hl;	}
	 if(property_details != '')		{	document.getElementById("property_details").value = property_details;	}
	 if(property_cost != '')		{	document.getElementById("property_cost").value = property_cost;	}
	 if(builder_name != '')		{	document.getElementById("builder_name").value = builder_name;	}
	 if(property_location != '')		{	document.getElementById("property_location").value = property_location;	}
	 if(prop_type != '')		{	document.getElementById("prop_type").value = prop_type;	}
	 if(prop_usage != '')		{	document.getElementById("prop_usage").value = prop_usage;	}
	 if(emp_type != '')		{	document.getElementById("emp_type").value = emp_type;	}
	 if(annual_turnover != '')		{	document.getElementById("annual_turnover").value = annual_turnover;	}
	 	 if(salary_mode != '')		{	document.getElementById("salary_mode").value = salary_mode;	}
	 		 if(salary_bank != '')		{	document.getElementById("salary_bank").value = salary_bank;	}
	 	 if(prof_type != '')		{	document.getElementById("prof_type").value = prof_type;	}
	 	 if(employer != '')		{	document.getElementById("employer").value = employer;	}
	 	 if(monthly_income != '')		{	document.getElementById("monthly_income").value = monthly_income;	}	 
		 if(gross_annual != '')		{	document.getElementById("gross_annual").value = gross_annual;	}
		  if(monthly_net != '')		{	document.getElementById("monthly_net").value = monthly_net;	}
		   if(monthly_gross != '')		{	document.getElementById("monthly_gross").value = monthly_gross;	}
		    if(designation != '')		{	document.getElementById("designation").value = designation;	}
		     if(cp_years != '')		{	document.getElementById("cp_years").value = cp_years;	}
		      if(pan != '')		{	document.getElementById("pan").value = pan;	}
		      
		       
	 if(alternate_contact == '')
		{

		document.getElementById("alternate_contact").value = "";

		}else{
		document.getElementById("alternate_contact").value = alternate_contact;
		}
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
		if(nextAction == ''){
			
		document.getElementById("nextAction").value = "";
		}else{
			document.getElementById("nextAction").value = nextAction;
		}
		if(bank_name == ''){
			
		document.getElementById("bank_name").value = "";
		}else{
			document.getElementById("bank_name").value = bank_name;
		}
		if(los_no == ''){
			
		document.getElementById("los_no").value = "";
		}else{
			document.getElementById("los_no").value = los_no;
		}
		if(loan_type == ''){
			
		document.getElementById("loan_type").value = "";
		}else{
			document.getElementById("loan_type").value = loan_type;
		}
		if(roi == ''){
			
		document.getElementById("roi").value = "";
		}else{
			document.getElementById("roi").value = roi;
		}
		if(tenure == ''){
			
		document.getElementById("tenure").value = "";
		}else{
			document.getElementById("tenure").value = tenure;
		}
		if(dealer == ''){
			
		document.getElementById("dealer").value = "";
		}else{
			document.getElementById("dealer").value = dealer;
		}
		if(login_status_name == ''){
			
		document.getElementById("login_status_name").value = "";
		}else{
			document.getElementById("login_status_name").value = login_status_name;
		}
		if(reg_no == ''){
			
		document.getElementById("reg_no").value = "";
		}else{
			document.getElementById("reg_no").value = reg_no;
		}
		if(model_name == 0){
			
		document.getElementById("car_model").value = "";
		}else{
			document.getElementById("car_model").value = model_name;
		}
		if(loanamount == ''){
			
		document.getElementById("loan_amount").value = "";
		}else{
			document.getElementById("loan_amount").value = loanamount;
		}
			if(pick_up_date == '' || pick_up_date == '0000-00-00'){
			
		document.getElementById("pick_up_date").value = "";
		}else{
			document.getElementById("pick_up_date").value = pick_up_date;
		}
		if(executive_name == ''){
			
		document.getElementById("executive_name").value = "";
		}else{
			document.getElementById("executive_name").value = executive_name;
		}
		if(disburse_amount == ''){
			
		document.getElementById("disburse_amount").value = "";
		}else{
			document.getElementById("disburse_amount").value = disburse_amount;
		}
		if(disburse_date == '' || disburse_date == '0000-00-00'){
			
		document.getElementById("disburse_date").value = "";
		}else{
			document.getElementById("disburse_date").value = disburse_date;
		}
		if(process_fee == ''){
			
		document.getElementById("process_fee").value = "";
		}else{
			document.getElementById("process_fee").value = process_fee;
		}
		if(emi == ''){
			
		document.getElementById("emi").value = "";
		}else{
			document.getElementById("emi").value = emi;
		}
		if(approved_date == '' || approved_date == '0000-00-00'){
			
		document.getElementById("approved_date").value = "";
		}else{
			document.getElementById("approved_date").value = approved_date;
		}
		if(file_login_date == '' || file_login_date == '0000-00-00'){
			
		document.getElementById("login_date").value = "";
		}else{
			document.getElementById("login_date").value = file_login_date;
		}
		 show_emp_details();
		 show_loan_details();
		  
		
		}
		
		function check_status (feedbackStatus) {
	
			$.ajax({
				url:"<?php echo site_url();?>add_followup_finance/select_next_action",
				type:"POST",
				data:{feedbackStatus:feedbackStatus},
				success:function(reponse){
					  
					    $('#nextactiondiv').html(reponse);
				}				
			})
				}
					function show_reject_reason (loan_status) {
	
			$.ajax({
				url:"<?php echo site_url();?>add_followup_finance/select_reject_reason",
				type:"POST",
				data:{loan_status:loan_status},
				success:function(reponse){
					  
					    $('#r_reason_div').html(reponse);
				}				
			})
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
	<script>
	function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		// Added to allow decimal, period, or delete
		if (charCode == 110 || charCode == 190 || charCode == 46)
			return true;

		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;

		return true;
	}
		   //For Add Followup View
	//If click on transfer show and hide div
function transfer_lead() {
	if (document.getElementById('transfer').checked == true) {
		
		document.getElementById("tlocation1").disabled = false;
		document.getElementById("tassignto1").disabled = false;
		document.getElementById("tprocess").disabled = false;
		//document.getElementById("transfer_reason").disabled = false;
			$("#tlocation").show();
			$("#tassignto").show();
			$("#tprocess").show();
} else {
	document.getElementById("tlocation1").disabled = true;
	document.getElementById("tassignto1").disabled = true;
	document.getElementById("tprocess").disabled = true;
	//document.getElementById("transfer_reason").disabled = true;
			$("#tlocation").hide();
			$("#tassignto").hide();
			$("#tprocess").hide();
	}
}
//Select user name using location
function select_assign_to()
{
	var tlocation1 = document.getElementById("tlocation1").value;
	var tprocess = document.getElementById("tprocess").value;
	$.ajax({
		url : '<?php echo site_url('add_followup_finance/select_assign_to'); ?>',
		type : 'POST',
		data : {'tlocation1' : tlocation1,'tprocess' : tprocess},
		success : function(result) {
		$("#assign_div").html(result);
	}
	});
}
//Select user name using location
function select_transfer_location()
{
	var tprocess = document.getElementById("tprocess").value;
		$.ajax({
		url : '<?php echo site_url('add_followup_finance/select_transfer_location'); ?>',
		type : 'POST',
		data : {'tprocess' : tprocess},
		success : function(result) {
			$("#tlocation_div").html(result);
		}
	});
}

</script>
	<script>	$(window).on('load', function() {
					
							emical();
					});		
							
							function emical(){
								//alert("hi");
								var amount = document.getElementById('loanamount').value;
								var interest = document.getElementById('interest').value;
								var intr = interest/100/12;
								
								// year is not year its month
								var years = 12;
								var x = Math.pow(1+intr,years);
								var monthly1 = (amount*x*intr)/(x-1);
								var monthly1 = Math.round(monthly1);
								//alert(monthly1);
								
								var years2 = 24;
								var x = Math.pow(1+intr,years2);
								var monthly2 = (amount*x*intr)/(x-1);
								var monthly2 = Math.round(monthly2);
								//alert(monthly2);
								
								var years3 = 36;
								var x = Math.pow(1+intr,years3);
								var monthly3 = (amount*x*intr)/(x-1);
								var monthly3 = Math.round(monthly3);
								//alert(monthly3);
								
								var years4 = 48;
								var x = Math.pow(1+intr,years4);
								var monthly4 = (amount*x*intr)/(x-1);
								var monthly4 = Math.round(monthly4);
								
								var years = 60;
								var x = Math.pow(1+intr,years);
								var monthly5 = (amount*x*intr)/(x-1);
								var monthly5 = Math.round(monthly5);
								
								var years = 72;
								var x = Math.pow(1+intr,years);
								var monthly6 = (amount*x*intr)/(x-1);
								var monthly6 = Math.round(monthly6);
								
								var years = 84;
								var x = Math.pow(1+intr,years);
								var monthly7 = (amount*x*intr)/(x-1);
								var monthly7 = Math.round(monthly7);
								
								document.getElementById('monthly1').innerHTML = monthly1;
								document.getElementById('monthly2').innerHTML = monthly2;
								document.getElementById('monthly3').innerHTML = monthly3;
								document.getElementById('monthly4').innerHTML = monthly4;
								document.getElementById('monthly5').innerHTML = monthly5;
								document.getElementById('monthly6').innerHTML = monthly6;
								document.getElementById('monthly7').innerHTML = monthly7;
								
								
							}</script>
							
	
			