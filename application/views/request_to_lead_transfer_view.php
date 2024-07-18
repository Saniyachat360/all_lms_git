<script>  
jQuery(document).ready(function(){
 $('#results').DataTable();});
</script>	
<div id="" class="container body" style="width: 100%;">

	<div class="main_container">


			<h1 style="text-align:center;">Transferred Leads</h1>

		   
				<div class="col-md-12" >
					<div class="table-responsive"  style="overflow-x:auto;">
				<table class="table-responsive table table-bordered datatable" id="results"> 
					<thead>
						<tr>
							<th>Sr No.</th>
							<th>Interested In</th>
							<th>Name</th>
							<th>Contact No.</th>
							<th>Email</th>
							<th>Comment</th>
							<th>Transfer Date</th>
					
							 <th>Transfer To</th>	
							<th>Transfer Location</th>
							<th>Transfer Reason</th>
							 <!--<th>Assign To</th>-->		
							  		<th>Lead status </th>	
							  		<th>Disposition</th>
							  		<th>Remark </th>
							  	<!--<th>Request status </th>-->			
                          </th>
							
						
                            
						</tr>	
					</thead>
					<tbody>
						<?php
						$i=0;
						
							
					foreach($select_lead as $fetch)
						{
							/*$lead_id=$fetch['lead_id'];
							$user_id=$fetch['assign_by'];
						$query3 = mysql_query("select * from lead_master where enq_id='$lead_id' ") or die(mysql_error());
									$fetch1 = mysql_fetch_array($query3);*/
							$i++;
						?>
						<tr>
							<td><?php echo $i; ?></td>
								<td><?php echo $fetch->enquiry_for; ?></td>
                                <td><b><a href="lms_details.php?id=<?php echo $fetch->enq_id; ?>"><?php echo $fetch->name; ?></a></b></td>
								<td><?php echo $fetch->contact_no; ?></td>
								<td><?php echo $fetch->email; ?></td>
								<td><?php echo $fetch->comment; ?></td>
								<td><?php echo $fetch->created_date;?></td>
								
								 
								
							<td>
								 <?php
									
									/*$tl_name=$fetch['tl_name'];
									
									$query3 = mysql_query("select * from lmsuser where id='$tl_name' ") or die(mysql_error());
									$fetch2 = mysql_fetch_array($query3);*/
									echo $fetch->fname . ' ' . $fetch->lname ;
					
						?></td>
							<td><?php echo $fetch->location;?></td>
								<td><?php echo $fetch->transfer_reason;?></td>
						<!--<td>
								 <?php
									
									
									echo $fetch1['fname1'] . ' ' . $fetch1['lname1'] ;
					
						?></td>-->
								
                              
                                <td>
                                	<?php echo $fetch->status_name;

									?>
						
							</td>
							<td><?php echo $fetch->disposition_name;?></td>
							 <td>
									<?php 
								//	$query = $this->db->query("select comment from lead_followup where leadid='$enq_id'  order by id desc limit 1")->result();
						
									echo $fetch->comment;
									?>
								</td>
								<!--<td><?php echo $fetch1['r_status'];?></td>-->
                               
						</tr>
						<?php } ?>
					</tbody>
					
					
				</table>
				
	
				
				
                        </div>
                      
                    </div> 
              
            </div>
        </div>