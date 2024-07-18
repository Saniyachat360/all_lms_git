<div class="container " style="width: 100%;">
	<div class="row">
		<div id="abc">
			<h1 style="text-align:center;">Add Auditor Remark</h1>
				<br>
				 <div style="margin-bottom: 40px;">
                       <div class="col-md-3"></div>
                       <div class="col-md-3" style="text-align:center;"> Name: <b style="font-size: 15px;"><?php echo $select_lead[0] -> name; ?></b></div>
                       <div class="col-md-3" style="text-align:center;">Contact: <b style="font-size: 15px;"><?php echo $select_lead[0] -> contact_no; ?></b></div>
 					<div class="col-md-3"></div>
 					</div>
			<div class="panel panel-primary">
 
     <div class="panel-body">
			      
                   <form action="<?php echo $var;?>" method="post">
                	<input type="hidden" name="booking_id" value="<?php echo $id; ?>">
						
							<input type="hidden" name="enq" value="<?php echo $enq; ?>">
                     <div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                         <div class="col-md-12">
                              
                     

                                  
                                      
                                      
                                       <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Followup Pending: 
                                            </label>
                                                   <div class="col-md-5 col-sm-5 col-xs-12">
                                                       <select name="followup_pending" class="form-control" required>
                                                       	<option value="">Please Select</option>
                                		<option value="Yes">Yes</option>
                                		<option value="No">No</option>
                                	
                                </select>
                                            </div>
                                                               </div>
									<div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Call Received from Showroom: 
                                            </label>
                                                   <div class="col-md-5 col-sm-5 col-xs-12">
                                                       <select name="call_received" class="form-control" required>
                                                       	<option value="">Please Select </option>
                                		<option value="Yes">Yes</option>
                                		<option value="No">No</option>
                                </select>
                                            </div>
                                                               </div>
															   
										<div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Fake Updation: 
                                            </label>
                                                   <div class="col-md-5 col-sm-5 col-xs-12">
                                                       <select name="fake_updation" class="form-control" required>
                                                       	<option value="">Please Select</option>
                                		<option value="Yes">Yes</option>
                                		<option value="No">No</option>
                                </select>
                                            </div>
                                                               </div>
															   	<div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Service Feedback: 
                                            </label>
                                                   <div class="col-md-5 col-sm-5 col-xs-12">
                                                       <select name="service_feedback" class="form-control" required>
                                                       	<option value="">Please Select</option>
                                		<option value="Excellent">Excellent</option>
                                		<option value="Good">Good</option>
                                		<option value="Bad">Bad</option>
                                		
                                </select>
                                            </div>
                                                               </div>
       					  
                           <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Remark:
                                            </label>
                                                  <div class="col-md-5 col-sm-5 col-xs-12">
                                                <textarea placeholder="Remark" name='comment' required class="form-control" /></textarea>
                                            </div>
                                                               </div>
													   
									



                              
                        </div>
                         
                     
                    </div>
                    <div class="form-group">
                     <div class="col-md-2 col-md-offset-3">
                    	
						
                    <button type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12">Submit</button>
                         </div>
                       
                        <div class="col-md-2">
                        	<input type='reset' class="btn btn-primary col-md-12 col-xs-12 col-sm-12" value='Reset'>
                           
                        </div>
                    </div>
                    
                </form>
             </div>
            </div>
        					
	
            </div>
        
       	<script type="text/javascript">
	jQuery(document).ready(function($) {
		var $table4 = jQuery("#table-4");
		$table4.DataTable({
			dom : 'Bfrtip',
			buttons : ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
		});
	});
</script> 

<div class="col-md-12 table-responsive"  style="overflow-x:auto;">
	<h3>Follow up Details</h3>
<table class="table table-responsive table-bordered datatable" id="results"> 
					<thead>
						<tr>
							
							<th>Sr No</th>
						<!--	<th>Location</th>-->
							<th>Follow Up By</th>
							<th>Call Date</th>		
							<th>N.F.D</th>
							
							<th>Feedback Status</th>
							<th>Next Action</th>
							<?php /* if($select_lead[0]->buyer_type=='Buy Used Car')
							{?>
							<th>Visit Location</th>
							<th>Visit Booked</th>
							<th>Visit Date</th>
							<th>Sales Status</th>
							<th>Car Delivered </th>					
							<?php } */?>
							<th>Remark</th>	
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
							<td><?php echo $row -> call_date; ?></td>
							<td><?php echo $row -> nextfollowupdate ?></td>
							
							<td><?php echo $row -> feedbackStatus; ?></td>
							<td><?php echo $row -> nextAction; ?></td>
							<?php /*if($select_lead[0]->buyer_type=='Buy Used Car')
							{?>
								<td><?php echo $row->visit_location;?></td>
								<td><?php echo $row->visit_booked;?></td>
								<td><?php echo $row->visit_booked_date;?></td>
								<td><?php echo $row->sale_status;?></td>
								<td><?php echo $row->car_delivered;?></td>
								<?php }*/?>
							<td><?php echo $row ->comment; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>

		
                        </div>
                      
              
			            
  <script>
	jQuery(document).ready(function() {
		$('#results').DataTable();
	});
</script>
        
<?php $view=$_SESSION['view'];
/*if($view[10]==1)
{*/
	if(count($remark_detail)>0)
	{
?>
<br><br>


<div class="col-md-12">
<h3>Auditor Remark Details</h3>
	<table class="table table-bordered datatable" id="table-4"> 
					<thead>
						<tr>
							<th>Sr No.</th>
							
							<th>Followup By</th>
							<th>Followup Date</th>
							<th>Pending Followup</th>
							<th>Call Received from Showroom</th>	
							<th>Fake Updation</th>				
							<th>Service Feedback</th>
							<th>Remark</th>
                            
						</tr>	
					</thead>
					<tbody>
						<?php
						
					$i=0;
						foreach($remark_detail as $fetch)
						{
							
							$i++;
						?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $fetch->fname.' '.$fetch->lname; ?> </td>
							<td><?php echo $fetch->created_date; ?> </td>
							<td> <?php echo $fetch->followup_pending;?></td>
							<td><?php echo $fetch->call_received; ?></td>
							<td> <?php  echo $fetch->fake_updation; ?></td>
                            <td><?php echo $fetch->service_feedback ;?></td>	
							<td><?php echo $fetch->remark ;?></td>	
								
                               
						</tr>
						<?php } ?>
					</tbody>
					
					
				</table>


		
                   
                      
                    </div> 
       <?php	} 
//} 
?>      
</div>
		</div>
		</div>

		
   