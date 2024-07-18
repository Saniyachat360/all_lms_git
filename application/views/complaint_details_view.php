<div class="row">
     <div id="abc">
<?php
$today = date('d-m-Y');
?>
<script>
	function get_detail_followup()
{
	alert("hii");
	var t='<?php echo $enq;?>';
	var a='<?php echo $select_data[0]->enq_id?>';
	//alert(t);
	window.open ("<?php echo site_url();?>add_followup_accessories/detail/"+a+"/"+t,'_self');
}
</script>
             <div class="container">
   <h1 class="text-center">Customer Follow Up Details</h1>
   <?php $insert=$_SESSION['insert'];
   if($insert[9]==1)
   
{?>                       <a id="sub" href="<?php echo site_url();?><?php echo 'add_followup_complaint/detail/'.$details[0]->complaint_id.'/'. $enq ;?>" class="pull-right" style="margin-top:-40px" >
			<i class="btn btn-info entypo-doc-text-inv">Add Follow up</i>
</a>
<?php } ?>
  </div>                    <br>
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
                   
                  </div>
               </div></div>
			         <div class="panel panel-primary">
    
     <div class="panel-body">
						<div class="form-group">
                                                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Customer Comment: 
                                            </label>
                                                   <div class="col-md-10 col-sm-10 col-xs-12">
                                                <?php echo $details[0]->comment; ?>
                                            </div>
                                                               </div>
                  <br>				
							</div></div>				
 			
	
			</div>

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
								<th>N.F.D</th>
								<th>N.F.T</th>
							<th>Remark</th>
							<?php if($_SESSION['process_name']=='Finance')
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
								<?php /*if($_SESSION['process_name']=='New Car' || $_SESSION['process_name']=='Used Car')
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
							<td><?php echo $row -> nextfollowupdate ?></td>
								<td><?php echo $row -> nextfollowuptime  ?></td>
							
							<td><?php echo $row ->comment; ?></td>
							<?php if($_SESSION['process_name']=='Finance')
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
								<?php /* if($_SESSION['process_name']=='New Car' || $_SESSION['process_name']=='Used Car')
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
             
  <script>
	jQuery(document).ready(function() {
		$('#results1').DataTable();
	});
</script>
       
