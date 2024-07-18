

<!--<ol class="breadcrumb bc-3" > <li> 
	
		<a href="dashboard_telecaller.php"><i class="fa fa-home"></i>Home</a>
	
	
	
</li><li class="active"> <strong>Today's Follow Ups</strong> </li> </ol>-->
	

    <div class="container " style="width: 100%;">


        <div class="main_container">


                    <div class="row">
                    <div id="abc">
					
                    	
<?php
$today = date('Y-m-d');
$day = date('d-m-Y');
?><script type="text/javascript">
	jQuery(document).ready(function($) {
		var $table4 = jQuery("#table-4");
		$table4.DataTable({
			dom : 'Bfrtip',
			buttons : ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
		});
	});
</script> 
                       <h1 style="text-align:center;">Today's Follow Ups</h1>
                       <div class="table-responsive"  style="overflow-x:auto;"> 
			<table class="table table-bordered datatable table-responsive" id="table-4"> 
					<thead>
						<tr>
							<th>Sr No.</th>
							<th>Interested In</th>
                            <th>Username</th>							
							<th>Contact</th>
							<th>Email</th>
							<th>Lead Date</th>
                            <th>Status</th>
                            <th>Assign By</th>
                           	<th>Comment</th>
								<th>Remark</th>
								
							<th>Action</th>
						</tr>	
					</thead>
					<tbody>
						<?php
						$i=0;
					
						foreach($select_lead as $fetch)
						{
							$enq_id=$fetch->enq_id;
							$i++;
						?>
						<tr>
							<td><?php echo $i; ?></td>
								
								<td><?php echo $fetch -> enquiry_for; ?></td>
								
								
                                <td><b><a href="lms_details.php?id=<?php echo $enq_id; ?>"><?php echo $fetch -> name; ?></a></b></td>
								<td><?php echo $fetch -> contact_no; ?></td>
								<td><?php echo $fetch -> email; ?></td>
								<td><?php echo $fetch -> created_date; ?></td>
								
                                <td>
                                	<?php $status = $fetch -> status;

									if ($status == 1) {
										echo "Not Yet";
									}

									if ($status == 2) {
										echo "Live";
									}
									if ($status == 3) {
										echo "Postpone";
									}
									if ($status == 4) {
										echo "Lost";
									}
									if ($status == 5) {
										echo "Convert";
									}
                                	?>
                                </td>
								<td>
									<?php

									echo $fetch -> fname . " " . $fetch -> lname;
									?>
									
									
								</td>
												<td><?php echo $fetch -> comment; ?></td>
												<td><?php echo $fetch -> fcomment; ?></td>
								
							
								
								<td><a href="<?php echo site_url(); ?>add_followup/detail/<?php echo $fetch->enq_id?>/today_followup">Add Follow Up </a>
												 | <a href="<?php echo site_url(); ?>remove_duplicate/leads/<?php echo $enq_id; ?>/today_followup"  onclick="return confirm('Do you want to delete this record?')">Remove</a></td>

					
						
						</tr>
						<?php } ?>
					</tbody>
					
					
				</table>
				
	
				
				
                
					   </div>

                </div></div>
    </div>
	
</div>

