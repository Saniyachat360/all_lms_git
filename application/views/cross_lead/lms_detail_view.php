
<?php 

//print_r($details);
$buyer_type=$details[0]->buyer_type;	?>

   


                    <div class="row">
                    <div id="abc">
<?php
$today = date('d-m-Y');
?>

             <div class="container">
   <h1 class="text-center">Customer Follow Up Details</h1>
 
                 <br>
                       <br/>
                      
                    
					  
					   <div class="panel panel-primary">
    
     <div class="panel-body">
					  <div class="col-md-6">
					  
					  <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Name: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->name; ?></b>
                                            </div>
                                                               </div>
                                                               <br>
                                                                 <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Email: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->email; ?></b>
                                            </div>
                                                               </div>
                                                               <br>
                                                               <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Alternate Contact: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->alternate_contact_no; ?></b>
                                            </div>
                                                               </div>
                                                               <br>
                                                    	<div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name"> Feed Back Status: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->feedbackStatus; ?></b>
                                            </div>
                                                           </div><br>   
														   <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Buyer Type: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->buyer_type; ?></b>
                                            </div>
                                                           </div><br>   
                                                           </div>
                                                            <div class="col-md-6">
										
										
										 <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Contact: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->contact_no; ?></b>
                                            </div>
                                                               </div>
											<br>				   
											 <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Address: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->address; ?></b>
                                            </div>
                                                               </div>
											<br>	

               									
											 <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Next Action: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->nextAction; ?></b>
                                            </div>
                                                               </div>
                                                               <br>	
                                                                <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">My Comment:
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->comment; ?></b>
                                            </div>
                                                               </div>
                  <br>
                  </div>
               </div></div>
			         	
					
	
				<?php if($process_name=='New Car' || $process_name=='POC Sales')
					{?>
						<h3 class="text-center">New Car Details</h3>
						<div class="panel panel-primary">
							<div class="panel-body">
                                <div class="col-md-6">  
									<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Model Name:</label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <b style="font-size: 16px;"><?php echo $details[0]->model_name; ?></b>
                                        </div>
                                    </div>
                                    <br>
								</div>
				   
								<div class="col-md-6">  
   									<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name"> Variant Name: </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <b style="font-size: 16px;"><?php echo $details[0]->variant_name; ?></b>
                                        </div>
                                    </div>
                                    <br>
								</div>
							</div>
						</div>
				  
						<h3 class="text-center">Old Car Details</h3>
						<div class="panel panel-primary">
							<div class="panel-body">
                                <div class="col-md-6">  
									<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name"> Old Make Name: </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <b style="font-size: 16px;"><?php echo $details[0]->old_make; ?></b>
                                        </div>
                                    </div>
									<br>
				 
									<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name"> Ownership: </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <b style="font-size: 16px;"><?php echo $details[0]->ownership; ?></b>
                                        </div>
                                    </div>
                                    <br>
				    
									<div class="form-group">
										<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name"> Accidental Claim: </label>
										<div class="col-md-8 col-sm-8 col-xs-12">
                                            <b style="font-size: 16px;"><?php echo $details[0]->accidental_claim; ?></b>
										</div>
									</div>
									<br>
								</div>
				    
								<div class="col-md-6">  
   									<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name"> Old Model Name: </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <b style="font-size: 16px;"><?php echo $details[0]->old_model; ?></b>
                                        </div>
                                    </div>
                                    <br>
				  	
									<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name"> MFG Year: </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <b style="font-size: 16px;"><?php echo $details[0]->manf_year; ?></b>
										</div>
                                    </div>
                                    <br>
									
				  				  	<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name"> KMS: </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <b style="font-size: 16px;"><?php echo $details[0]->km; ?></b>
                                        </div>
                                    </div>
									<br>
								</div>
							</div>
						</div>
				  
						<h3 class="text-center">Other Details</h3>
						<div class="panel panel-primary">
							<div class="panel-body">
                                <div class="col-md-6">  
   									<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Interested in Finance: </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <b style="font-size: 16px;"><?php echo $details[0]->interested_in_finance; ?></b>
                                        </div>
                                    </div>
                                    <br>
				  
									<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Interested in Accessories: </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <b style="font-size: 16px;"><?php echo $details[0]->interested_in_accessories; ?></b>
										</div>
                                    </div>
                                    <br>
								</div>
				    
								<div class="col-md-6">  
									<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name"> Interested in Insurance: </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <b style="font-size: 16px;"><?php echo $details[0]->interested_in_insurance; ?></b>
                                        </div>
                                    </div>
									<br>
				  	
									<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Interested in EW: </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <b style="font-size: 16px;"><?php echo $details[0]->interested_in_ew; ?></b>
                                        </div>
                                    </div>
									<br>
								</div>
							</div>
						</div>
				  
						<h3 class="text-center">Finance Details</h3>
						<div class="panel panel-primary">
							<div class="panel-body">
                                <div class="col-md-6">  
									<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Customer Type: </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <b style="font-size: 16px;"><?php echo $details[0]->customer_occupation; ?></b>
                                        </div>
                                    </div>
									<br>
				 
									<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Customer Designation: </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <b style="font-size: 16px;"><?php echo $details[0]->customer_designation; ?></b>
                                        </div>
									</div>
                                    <br>
								</div>
				   
								<div class="col-md-6">  
   									<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Corporate Name: </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <b style="font-size: 16px;"><?php echo $details[0]->customer_corporate_name; ?></b>
                                        </div>
                                    </div>
                                   <br>
								</div>
							</div>
						</div>
				  
				  
				<?php } ?>
												  	
				
				<?php if($process_name=='POC Sales')
					{?>
						<h3 class="text-center">Buy Used Car Details</h3>
						<div class="panel panel-primary">
							<div class="panel-body">
                                <div class="col-md-6">  
									<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Car Make: </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <b style="font-size: 16px;"><?php echo $details[0]->buy_make; ?></b>
                                        </div>
                                    </div>
									<br>
				 
									<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Budget From: </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <b style="font-size: 16px;"><?php echo $details[0]->budget_from; ?></b>
                                        </div>
									</div>
                                    <br>
								</div>
				   
								<div class="col-md-6">  
   									<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Car Model: </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <b style="font-size: 16px;"><?php echo $details[0]->buy_model; ?></b>
                                        </div>
                                    </div>
									<br>
									
									<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Budget To: </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <b style="font-size: 16px;"><?php echo $details[0]->budget_to; ?></b>
                                        </div>
                                    </div>
                                   <br>
								</div>
							</div>
						</div>
				<?php } ?>
				
			
												
               	<?php if($process_name=='Finance' && $process_id =='1')
												{?>
											  <h3 class="text-center">Loan Details</h3>
                     <div class="panel panel-primary">
    
     <div class="panel-body">
                                                           <div class="col-md-6">  
   											<div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name"> Model Name: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->model_name; ?></b>
                                            </div>
                                                               </div>
                                                           
                  <br>
                  <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Loan Type: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->loan_type; ?></b>
                                            </div>
                                                               </div>
                                                           
                  <br>
                    <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">ROI: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->roi; ?></b>
                                            </div>
                                                               </div>
                                                           
                  <br>
                  <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Tenure: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->tenure; ?></b>
                                            </div>
                                                               </div>
                                                           
                  <br>
                  
 
  <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Dealer/DSA: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->dealer; ?></b>
                                            </div>
                                                               </div>
                                                           
                  <br>
                            </div>

 									 
              <div class="col-md-6">
									   
	 <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Bank Name: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->bank_name; ?></b>
                                            </div>
                                                               </div>
                  <br>
                  <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Registration No: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->reg_no; ?></b>
                                            </div>
                                                               </div>
                  <br>
                                     <div class="form-group col-md-12">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">LOS No: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->los_no; ?></b>
                                            </div>
                                                               </div>
                                                           
                  <br>
                   <div class="form-group col-md-12">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Amount: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->loanamount; ?></b>
                                            </div>
                                                               </div>
                                                           
                  <br>
                                       
                                                <input type="hidden" value="<?php echo date("Y-m-d"); ?>" name="date"   class="form-control" style="background:white; cursor:default;" />
                                    
                            
                 				       
                                      <br>
                                  
                                      
                                      <br>
                             

                            
  
                  <br>

                 				
                                
                                     
                                      <br>
                                     
                         </div>
					  </div>
					  </div>
					 <?php } ?> 
					     	<?php if($process_name=='Service' && $process_id=='4')
												{?>
													    <div class="panel panel-primary">
    
     <div class="panel-body">
				<div class="col-md-6">
									   
	 							<div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Service Center:
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->service_center; ?></b>
                                            </div>
                                         </div>
                                                               
                  									<br>
                  	 					<div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Car Model:
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->model_name; ?></b>
                                            </div>
                                       </div>
                                       	<br>
                                       <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Registration No: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->reg_no; ?></b>
                                            </div>
                                                               </div>
                                                               	<br>
                                                               	   <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Pick up Required: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->pickup_required; ?></b>
                                            </div>
                                                               </div >
                                                               </div>
                                     <div class="col-md-6">
                                     	<div class="form-group">
                                                 <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Service Type: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->service_type; ?></b>
                                            </div>
                                                               </div>
                                                               <br>
                                       	<div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Kilometer:
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->km; ?></b>
                                            </div>
                                       </div>
                 	<br>
                					<div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Pick up date: 
                                            </label>
                                                   <div class="col-md-8 col-sm-8 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $details[0]->pick_up_date; ?></b>
                                            </div>
                                                               </div >
                  <br>
                
                  <br></div>
                  </div>
                 </div>
                  </div>
													<?php } ?>
					  
				
				
				
				<?php if($process_id=='8')
					{?>
						<h3 class="text-center">Evaluation Details</h3>
						<div class="panel panel-primary">
						<div class="panel-body">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Car Make: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->old_make_name; ?></b>
                                </div>
                            </div>
							<br>
							
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Old Variant Name: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->old_variant_name; ?></b>
                                </div>
                            </div>
							<br>
							
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Ownership: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->ownership; ?></b>
                                </div>
                            </div>
							<br>
							
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Any Accidental Claim: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->accidental_claim; ?></b>
                                </div>
                            </div>
							<br>
							
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Evaluation within days: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->evaluation_within_days; ?></b>
                                </div>
                            </div>
							<br>
							
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Color: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->color; ?></b>
                                </div>
                            </div>
							<br>
							
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Quoted Price: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->quotated_price; ?></b>
                                </div>
                            </div>
							<br>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Car Model: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->old_model_name; ?></b>
                                </div>
                            </div>
							<br>
							
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Manufacturing Year: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->manf_year; ?></b>
                                </div>
                            </div>
							<br>
							
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">KMS: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->km; ?></b>
                                </div>
                            </div>
							<br>
							
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Fuel Type: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->fuel_type; ?></b>
                                </div>
                            </div>
							<br>
							
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Registration No.: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->reg_no; ?></b>
                                </div>
                            </div>
							<br>
							
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Expected Price: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->expected_price; ?></b>
                                </div>
                            </div>
							<br>
						</div>
					</div>	
			
							
					
					<div class="panel-body">
						<div class="col-md-6">  
   							<div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Type of Vehicle: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->type_of_vehicle; ?></b>
								</div>
                            </div>	
							<br>															   

							<div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Old Car Owner Name: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->old_car_owner_name; ?></b>
                                </div>
                            </div>
                            <br>
																
							<div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">HP: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->hp; ?></b>
                                </div>
                            </div>
                            <br>
							
							<div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Insurance Type: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->insurance_type; ?></b>
                                </div>
                            </div>
                            <br>
															   
							<div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Insurance Validity date: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->insurance_validity_date; ?></b>
                                </div>
							</div>
							<br>	

							<div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Engine work: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->engine_work; ?></b>
                                </div>
                            </div>
							<br>	

							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Vehicle Sale Category: </label>
								<div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->vechicle_sale_category; ?></b>
                                </div>
                            </div>
							<br>				

							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Selling Price: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->selling_price; ?></b>
                                </div>
							</div>
							<br>	

							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Bought Date: </label>
								<div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->bought_date; ?></b>
                                </div>
                            </div>
                            <br>	

							<div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Payment mode: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->payment_mode; ?></b>
                                </div>
                            </div>
                            <br>	
							
							<div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Payment date:</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->payment_date; ?></b>
                                </div>
                            </div>
                            <br>

							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Payment Made to: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->payment_made_to; ?></b>
                                </div>
                            </div>
							<br>		
							
							<div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Refurbish Other: </label>
								<div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->refurbish_other; ?></b>
                                </div>
							</div>
                            <br>

							<div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Refurbish cost Mecahanical: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->refurbish_cost_mecahanical; ?></b>
                                </div>
                            </div>
                            <br>
                        </div>
                                                                
						
						<div class="col-md-6">  
   							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name"> Registration Year: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
									<b style="font-size: 16px;"><?php echo $details[0]->reg_year; ?></b>
                                </div>
                            </div>	
							<br>															   

							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name"> Outright\Exchange: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->outright; ?></b>
								</div>
                            </div>
                            <br>
							
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Image Uploaded: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->photo_uploaded; ?></b>
                                </div>
                            </div>
                            <br>
							
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Finacier Name: </label>
									<div class="col-md-8 col-sm-8 col-xs-12">
                                        <b style="font-size: 16px;"><?php echo $details[0]->financier_name; ?></b>
                                    </div>
                            </div>
                            <br>
							
							<div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Accidental Details: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->accidental_details; ?></b>
                                </div>
							</div>
							<br>
																
							<div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Insurance company: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->insurance_company; ?></b>
								</div>
							</div>
                            <br>		

							<div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Tyre conditon: </label>
								<div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->tyre_conditon; ?></b>
                                </div>
							</div>
                            <br>

							<div class="form-group">
                                <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Body work: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->body_work; ?></b>
                                </div>
                            </div>
                            <br>

							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Refurbish cost Bodyshop: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
									<b style="font-size: 16px;"><?php echo $details[0]->refurbish_cost_bodyshop; ?></b>
                                </div>
                            </div>
                            <br>

							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Refurbish cost Tyre: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->refurbish_cost_tyre; ?></b>
                                </div>
							</div>
                            <br>

							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Total RF: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->total_rf; ?></b>
                                </div>
                            </div>
                            <br>

							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Price (RF & commission): </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->price_with_rf_and_commission; ?></b>
								</div>
                            </div>
                            <br>

							<div class="form-group">
								<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Bought at Price: </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <b style="font-size: 16px;"><?php echo $details[0]->bought_at; ?></b>
                                </div>
                            </div>
                            <br>
						</div>										
					</div>
					 <?php } ?>
					</div>
             
			
			</div>
			<?php if($process_name=='Accessories' && $process_id=='5' )
												{
													 if(isset($select_accessories_list)){?>
			<div class="col-md-12">
	<h3>Accessories List</h3>
            
             </div>   
             <br>   <br><br>       
             <div class="col-md-12">           
<table class="table table-bordered datatable" id="results"> 
	<thead>
		<tr>
			<th>Sr No</th>
			<th>AccessoriesName</th>
			<th>Model</th>		
			<th>Quantity</th>
			<th>Price</th>
			<th>Date</th>					
		
		</tr>	
	</thead>
	<tbody class="detail">
		<?php $i=0; 
		
			foreach($select_accessories_list as $row){ $i++;?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row -> accessories_name; ?></td>
			<td><?php echo $row -> model_name; ?></td>
			<td><?php echo $row -> qty ?></td>
			<td><?php echo $row -> price; ?></td>
			<td><?php echo $row -> created_date; ?></td>
		
		</tr>
		<?php } ?>
	</tbody>
</table>

</div>    
<?php } } ?> 
			 <script>
	jQuery(document).ready(function() {
		$('#results1').DataTable();
	});
</script>

  <script>
	jQuery(document).ready(function() {
		$('#results').DataTable();
	});
</script>
       

<div class="row">
			<div class="col-md-12">
	<h3>Follow up Details</h3>
	</div>
<div class="col-md-12 table-responsive" style="overflow-x:scroll">           
<table class="table table-bordered datatable" id="results1"> 
					<thead>
						<tr>
							
							<th>Sr No</th>
						<!--	<th>Location</th>-->
							<th>Follow Up By</th>
							<th>Call Status</th>
							<th>Call Date</th>		
							<th>Call Time</th>		
						
							<th>Feedback Status</th>
							<th>Next Action</th>
							<th>N.F.D.T.</th>
							<th>Appointment Type</th>	
							<th>Appointment Date Time</th>	
							<th>Appointment Status </th>	
							<th>Remark</th>
							<?php if($process_name=='Finance')
												{?>
							<th>Pickup Date</th>
							<th>Collection Executive Name</th>
							<th>Login Date</th>
							<th>Login Status</th>
							<th>Approved Date</th>
							<th>Disburse Date</th>
							<th>Disburse Amount</th>
							<th>Processing Fee</th>
							<th>EMI</th>
							<?php } ?>
								<?php /*if($process_name=='New Car' || $process_name=='Used Car')
												{?>
							<th>Escalation Type</th>
							<th>Escalation Remark</th>
												<?php } */?>
								<?php /*if($buyer_type=='Exchange With Old Car' || $buyer_type=='Buy Used Car')
												{?>
							<th>Visit Status</th>
							<th>Visit Location</th>
							<th>Visit Booked </th>
							<th>Visit Booked Date</th>
							<th>Sale Status </th>
							<th>Car Delivered</th>
												<?php } */?>
						</tr>	
					</thead>
					<tbody>
						<?php
					$i=0;	//print_r($followup_detail);
						foreach($followup_detail as $row)
						{
							
							
						$i++;
						?>
						<tr>
							
							<td><?php echo $i; ?></td>
							<!--<td><?php echo $row -> location; ?></td>-->
							<td><?php echo $row -> fname . ' ' . $row -> lname; ?></td>
							<td><?php echo $row -> contactibility; ?></td>
							<td><?php echo $row -> call_date; ?></td>
							<td><?php echo $row -> created_time ; ?></td>
							<td><?php echo $row -> feedbackStatus; ?></td>
							<td><?php echo $row -> nextAction; ?></td>
							
							<td><?php echo $row -> nextfollowupdate .' '.$row -> nextfollowuptime ?></td>
								<td><?php echo $row -> appointment_type ?></td>
								<td><?php echo $row -> appointment_date.' '.$row -> appointment_time  ?></td>
								<td><?php echo $row -> appointment_status ?></td>
							<td><?php echo $row ->comment; ?></td>
							<?php if($process_name=='Finance')
												{?>
							<td><?php echo $row ->pick_up_date; ?></td>
							<td><?php echo $row ->executive_name; ?></td>
							<td><?php echo $row ->file_login_date; ?></td>
							<td><?php echo $row ->login_status_name; ?></td>
							<td><?php echo $row ->approved_date; ?></td>
							<td><?php echo $row ->disburse_date; ?></td>
							<td><?php echo $row ->disburse_amount; ?></td>
							<td><?php echo $row ->process_fee; ?></td>
							<td><?php echo $row ->emi; ?></td>
						<?php } ?>
								<?php /* if($process_name=='New Car' || $process_name=='Used Car')
												{?>
							<td><?php echo $row -> escalation_type; ?></td>
							<td><?php echo $row -> escalation_remark; ?></td>
												<?php } */?>
							<?php /*if($buyer_type=='Exchange With Old Car' || $buyer_type=='Buy Used Car')
												{?>
											<td><?php echo $row ->visit_status; ?></td>
											<td><?php echo $row ->visit_location; ?></td>
											<td><?php echo $row ->visit_booked; ?></td>
											<td><?php echo $row ->visit_booked_date; ?></td>
											<td><?php echo $row ->sale_status; ?></td>
												<td><?php echo $row ->car_delivered; ?></td>
							
												<?php } */?>
							
							
						
						</tr>
						<?php } ?>
					</tbody>
				</table>

		
                        </div>
                      
                    </div> 
                    					<div class="row">
					<?php if(isset($details[0]->esc_level1)){
										if($details[0]->esc_level1=='Yes' || $details[0]->esc_level2=='Yes' || $details[0]->esc_level3=='Yes'){ ?>

					        <h3 class="text-center">Escalation Details</h3>
						<div class="col-md-6" style="margin-top:20px">
						
							<div class="panel panel-primary" >
							
								<div class="panel-body" >
				 	
									<?php if(isset($details[0]->esc_level1)){
										if($details[0]->esc_level1=='Yes' || $details[0]->esc_level2=='Yes' || $details[0]->esc_level3=='Yes'){ ?>
										<h4 style='text-align: center'>Escalation Done</h4>
										<?php }else{ ?>
											
									<?php } } ?>
						
									<div class="table-responsive" style="overflow-x:scroll">
										<table class="table ">
						
										<?php if(isset($details[0]->esc_level1)){
											if($details[0]->esc_level1=='Yes'){ ?>
											<tr>
												<th>Escalation Level 1</th>
												<td><?php if(isset($details[0]->esc_level1)){ echo $details[0]->esc_level1_remark; } ?></td>
											</tr>
										<?php } } ?>
										
										<?php if(isset($details[0]->esc_level2)){
											if($details[0]->esc_level2=='Yes'){ ?>
											<tr>
												<th>Escalation Level 2</th>
												<td><?php if(isset($details[0]->esc_level1)){ echo $details[0]->esc_level2_remark; } ?></td>
											</tr>
										<?php } } ?>
										
										<?php if(isset($details[0]->esc_level3)){
											if($details[0]->esc_level3=='Yes'){ ?>
											<tr>
												<th>Escalation Level 3</th>
												<td><?php if(isset($details[0]->esc_level3)){ echo $details[0]->esc_level3_remark; } ?></td>
											</tr>
										<?php } } ?>
										</table>
									</div>
								</div>
										
								
							</div>
						</div>
						 
						 
						<div class="col-md-6" style="margin-top:20px">
                    		<div class="panel panel-primary">
								<div class="panel-body">
				 	
									<?php if(isset($details[0]->esc_level1_resolved)){
									if($details[0]->esc_level1_resolved=='Yes' || $details[0]->esc_level2_resolved=='Yes' || $details[0]->esc_level3_resolved=='Yes'){ ?>
									<h4 style='text-align: center'>Resolved Escalation</h4>
									<?php }else{ ?>
										<h4> </h4>
									<?php } } ?>
									<?php if(isset($lead_detail[0]->esc_level1_resolved)){
									if($details[0]->esc_level1_resolved=='Yes' || $details[0]->esc_level2_resolved=='Yes' || $details[0]->esc_level3_resolved=='Yes'){ ?>
								
									<div class="table-responsive" style="overflow-x:scroll">
										<table class="table ">
						
											<?php if(isset($details[0]->esc_level1_resolved)){
											if($details[0]->esc_level1_resolved=='Yes'){ ?>
											<tr>
												<th>Escalation Level 1</th>
												<!--<td><?php if(isset($lead_detail[0]->esc_level1)){ echo $lead_detail[0]->esc_level1; } ?></td>-->
												<td><?php if(isset($details[0]->esc_level1_resolved)){ echo $details[0]->esc_level1_resolved_remark; } ?></td>
											</tr>
											<?php } } ?>
							 
											<?php if(isset($details[0]->esc_level2_resolved)){
											if($details[0]->esc_level2_resolved=='Yes'){ ?>
											<tr>
												<th>Escalation Level 2</th>
												<!--<td><?php if(isset($lead_detail[0]->esc_level2)){ echo $lead_detail[0]->esc_level2; } ?></td>-->
												<td><?php if(isset($details[0]->esc_level1_resolved)){ echo $details[0]->esc_level2_resolved_remark; } ?></td>
											</tr>
											<?php } } ?>
							 
											<?php if(isset($details[0]->esc_level3_resolved)){
											if($details[0]->esc_level3_resolved=='Yes'){ ?>
											<tr>
												<th>Escalation Level 3</th>
												<!--<td><?php if(isset($lead_detail[0]->esc_level3)){ echo $lead_detail[0]->esc_level3; } ?></td>-->
												<td><?php if(isset($details[0]->esc_level3_resolved)){ echo $details[0]->esc_level3_resolved_remark; } ?></td>
											</tr>
											<?php } } ?>
										</table>
									</div>
									<?php }} ?>
								</div>
										
								
							</div>
						</div>
						<?php } } ?>
					</div>
				
				
				
             
  <script>
	jQuery(document).ready(function() {
		$('#results1').DataTable();
	});
</script>
       
