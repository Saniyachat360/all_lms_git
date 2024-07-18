
<?php

foreach ($details as $fetch) {
	$contact = $fetch -> contact_no;
	$name = $fetch -> name;
	$status = $fetch -> status_name;
	$new_model = $fetch -> new_model;
	$new_variant = $fetch -> variant_name;
	$old_model = $fetch -> old_model;
	$old_make = $fetch -> make_name;
	$buy_status = $fetch -> buy_status;
	$buyer_type = $fetch -> buyer_type;
	$email = $fetch -> email;
	$address = $fetch -> address;
	$location = $fetch -> location;
	$buy_make = $fetch -> buy_make_name;
	$buy_model = $fetch -> buy_model_name;
	$eagerness=$fetch->eagerness;
}
                                	?>

   


                    <div class="row">
                    <div id="abc">
<?php
$today = date('d-m-Y');
?>
<script>
	function get_detail_followup()
{
	alert("hii");
	var t=<?php echo $enq;?>
	var a=<?php echo $details[0]->enq_id?>;
	alert(t);
	window.open ("<?php echo site_url();?>accessories_add_followup/detail/<?php echo $details[0]->enq_id?>/<?php echo $enq ;?>",'_self');
}
</script>
             <div class="container">
   <h1 class="text-center">Customer Follow Up Details</h1>
   <?php $insert=$_SESSION['insert'];
   if($insert[9]==1)
   
{?>                       <a id="sub" href="<?php echo site_url();?>accessories_add_followup/detail/<?php echo $details[0]->enq_id?>" class="pull-right" style="margin-top:-40px" >
			<i class="btn btn-info entypo-doc-text-inv">Add Follow up</i>
</a>
<?php } ?>
  </div>                    <br>
                       <br/>
                      
                    
					  
					   <div class="panel panel-primary">
    
     <div class="panel-body">
					  <div class="col-md-6">
					  
					  <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name: 
                                            </label>
                                                   <div class="col-md-9 col-sm-9 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $name; ?></b>
                                            </div>
                                                               </div>
                                                               <br>
                                                                 <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email: 
                                            </label>
                                                   <div class="col-md-9 col-sm-9 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $email; ?></b>
                                            </div>
                                                               </div>
                                                               <br>
                                                               
                                                               <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Eagerness: 
                                            </label>
                                                   <div class="col-md-9 col-sm-9 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $eagerness; ?></b>
                                            </div>
                                                               </div>
                                                               <br>
                                                                    
                                                              <!--   <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Buyer Type:
                                            </label>
                                                  <div class="col-md-9 col-sm-9 col-xs-12">
                                          
										  <b style="font-size: 16px;"><?php echo $buyer_type; ?></b>
										  
                                            </div>
                                      </div>-->
                                      <br>
            <?php if ($buyer_type =='First' ||  $buyer_type =='Exchange' || $buyer_type=='Additional')
		{?>							            
   <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">New Model: 
                                            </label>
                                                   <div class="col-md-9 col-sm-9 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $new_model; ?></b>
                                            </div>
                                                               </div>
                                                               <?php } ?>
                  <br>
  <?php if($buyer_type=='Exchange' || $buyer_type=='Sell Used Car' || $buyer_type=='Exchange With Old Car' || $buyer_type=='Additional')
									  {?>
   <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Old Make: 
                                            </label>
                                                   <div class="col-md-9 col-sm-9 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $old_make; ?></b>
                                            </div>
                                                               </div>
                  <br>
<?php } ?>
 <?php if($buyer_type=='Buy Used Car'|| $buyer_type=='Exchange With Old Car')
									  {?>
   <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Buy Make: 
                                            </label>
                                                   <div class="col-md-9 col-sm-9 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $buy_make; ?></b>
                                            </div>
                                                               </div>
                  <br>
<?php } ?>
                                   
                                      </div>
									    <div class="col-md-6">
										
										
										 <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Contact: 
                                            </label>
                                                   <div class="col-md-9 col-sm-9 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $contact; ?></b>
                                            </div>
                                                               </div>
											<br>				   
											 <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Address: 
                                            </label>
                                                   <div class="col-md-9 col-sm-9 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $address; ?></b>
                                            </div>
                                                               </div>
											<br>				   
                                     <!--<div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Location: 
                                            </label>
                                                   <div class="col-md-9 col-sm-9 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $location; ?></b>
                                            </div>
                                                               </div>
                                                               <br>-->
                                       
                                                <input type="hidden" value="<?php echo date("Y-m-d"); ?>" name="date"   class="form-control" style="background:white; cursor:default;" />
                                    
                              <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status: 
                                            </label>
                                                   <div class="col-md-9 col-sm-9 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $status; ?></b>
                                            </div>
                                                               </div>
                  <br>
                                
                                      <!-- <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Booked:
                                            </label>
                                                  <div class="col-md-9 col-sm-9 col-xs-12">
                                       <b style="font-size: 16px;"><?php echo $buy_status; ?></b>
                                            </div>
                                      </div>-->
                                      <br>
                                                 <?php if ($buyer_type =='First' ||  $buyer_type =='Exchange' || $buyer_type=='Additional'){?>		
                                      <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">New  Variant:
                                            </label>
                                                  <div class="col-md-9 col-sm-9 col-xs-12">
                                       <b style="font-size: 16px;"><?php echo $new_variant; ?></b>
                                            </div>
                                      </div>
                                      <?php } ?>
                                      <br>
                                      <?php if($buyer_type=='Exchange' || $buyer_type=='Sell Used Car'  || $buyer_type=='Exchange With Old Car' || $buyer_type=='Additional')
									  {?>
                                       <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Old Model :
                                            </label>
                                                  <div class="col-md-9 col-sm-9 col-xs-12">
                                       <b style="font-size: 16px;"><?php echo $old_model; ?></b>
                                            </div>
                                      </div>
                                      <br>
                                <?php } ?>

                               <?php if($buyer_type=='Buy Used Car' || $buyer_type=='Exchange With Old Car')
									  {?>
   <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Buy Model: 
                                            </label>
                                                   <div class="col-md-9 col-sm-9 col-xs-12">
                                                <b style="font-size: 16px;"><?php echo $buy_model; ?></b>
                                            </div>
                                                               </div>
                  <br>
<?php } ?>    
                         </div>
					  </div>
					  </div>
					  
					  
					</div>
			
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
<!----------------------------------------------------------Accessories Detail------------------------------------>
      
<div class="row">
<div class="col-md-12 table-responsive"  style="overflow-x:auto;">
	<h3>Accessories Details</h3>
<table class="table table-responsive table-bordered datatable" id="results"> 
					<thead>
					
						<tr>
							
							<th>Sr No.</th>
							<th>EDBMS No.</th>
							<th>Booking Date</th>
							<th>DSE Name</th>
							<th>Accessories Name</th>
							<th>Quantity</th>
							<th>Price</th>
							
						</tr>	
					</thead>
					<tbody>
						<?php
						$z=0;
						foreach($order_accessories_lead as $row)
						{
							
							
						$z++;
						?>
						<tr>
							
							<td><?php echo $z; ?></td>
							<td><?php echo $row -> edbms_no; ?></td>
							<td><?php echo $row -> booking_date; ?></td>
							<td><?php echo $row -> dse_name; ?></td>
							<td><?php echo $row -> accessories_name; ?></td>
							<td><?php echo $row -> qty; ?></td>
							<td><?php echo $row -> price; ?></td>
							
						</tr>
						<?php } ?>
					</tbody>
				</table>

		
                        </div>
                      
                    </div> 
             

	  
<!------------------------------------------------------------End-------------------------------------------------->
<div class="row">
<div class="col-md-12 table-responsive"  style="overflow-x:auto;">
	<h3>Follow up Details</h3>
<table class="table table-responsive table-bordered datatable" id="results"> 
					<thead>
						<tr>
							
							<th>Activity</th>
							<th>Location</th>
							<th>Follow Up By</th>
							<th>Call Date</th>		
							<th>N.F.D</th>
							<th>Status</th>
							<th>Disposition</th>
							<?php if($buyer_type=='Buy Used Car')
							{?>
							<th>Visit Location</th>
							<th>Visit Booked</th>
							<th>Visit Date</th>
							<th>Sales Status</th>
							<th>Car Delivered </th>					
							<?php } ?>
							<th>Remark</th>	
						</tr>	
					</thead>
					<tbody>
						<?php
						//print_r($followup_detail);
						foreach($followup_detail as $row)
						{
							$activity=$row->activity;
							
						
						?>
						<tr>
							
							<td><?php echo $activity; ?></td>
							<td><?php echo $row -> location; ?></td>
							<td><?php echo $row -> fname . ' ' . $row -> lname; ?></td>
							<td><?php echo $row -> call_date; ?></td>
							<td><?php echo $row -> nextfollowupdate ?></td>
							<td><?php echo $row -> status_name; ?></td>
							<td><?php echo $row -> disposition_name; ?></td>
							<?php if($buyer_type=='Buy Used Car')
							{?>
								<td><?php echo $row->visit_location;?></td>
								<td><?php echo $row->visit_booked;?></td>
								<td><?php echo $row->visit_booked_date;?></td>
								<td><?php echo $row->sale_status;?></td>
								<td><?php echo $row->car_delivered;?></td>
								<?php }?>
							<td><?php echo $row ->comment; ?></td>
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
       
<?php $view=$_SESSION['view'];
if($view[10]==1)
{
	if(count($remark_detail)>0)
	{
?>
<br><br>
<h3>Manager Remark Details</h3>
<div class="row">
<div class="col-md-12">
<table class="table table-bordered datatable" id="results1"> 
					<thead>
						<tr>
							
							<th>Sr No.</th>
							<th>Manager Remark</th>
							
						</tr>	
					</thead>
					<tbody>
						<?php
						$i=0;
						foreach($remark_detail as $row)
						{
							
							
						$i++;
						?>
						<tr>
							
							<td><?php echo $i; ?></td>
							<td><?php echo $row -> remark; ?></td>

						</tr>
						<?php } ?>
					</tbody>
				</table>

		
                        </div>
                      
                    </div> 
       <?php	} } ?>      


