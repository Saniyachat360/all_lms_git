<script>
	
	$(document).ready(function() {
		
		
		var table = $('#example').DataTable({
			searching:false,
				scrollY : "400px",
				scrollX : true,
			scrollCollapse : true,

			fixedColumns : {
				leftColumns : 0,
				rightColumns : 0
			}
		});
	
});	
</script>

<?php

$page = $this->uri->segment(4);
if (isset($page)) {
	$page = $page + 1;

} else {
	$page = 0;

}
$offset1 = 100 * $page;
//$query=$sql->result();
$c = count($select_lead);
		?>


<?php
$today = date('d-m-Y');
?>

<hr>
<div class="control-group" id="blah" style="margin:0% 30% 1% 50%"></div>

					<div class="table-responsive" >
						<table id="example"  class="table " style="width: 100%" > 
		
						<thead>
							<tr>
								<!-- Show Select box if add followup or remark right 1 -->
								<?php $insert=$_SESSION['insert'];
								if($insert[9]==1 || $insert[10]==1 )
								{?>
								<!--<th> </th>-->
								<?php } ?>
								<th>Sr</th>
								<th>Interested In</th>
								
								<th>Name</th>
								<th>Contact</th>
								<th>Lead Date</th>
							<?php	if($_SESSION['role'] ==3 && $enq =='New')
								{
								}
									else
									{?>
							<th>Feedback Status</th>
								<th>Next Action</th>
								
								<th>Current User</th>
								<th>Call Date</th>
								<th>N.F.D</th>
								<th>N.F.T</th>	
								
								<?php
								$view=$_SESSION['view'];
								if($_SESSION['role']==2 || $_SESSION['role']==1 || $_SESSION['role']==5)
								{?>
								<!--<th>Assign To</th>-->
								<?php } ?>
								<th>Remark</th>
								<?php } ?>
								<?php
									$view=$_SESSION['view'];
								 if($view[10]==1){?>
								<th>Action</th>
								 <?php } ?>		
							</tr>
						</thead>
						<tbody>
								<?php
					$i=$offset1;
				
				if (!empty($select_lead)) 
					{
					foreach($select_lead as $fetch)
					{
						//print_r($fetch);
						  $enq_id=$fetch->enq_id;
						  	
							$i++; ?>
							
						
						
							<tr id='t<?php echo $i; ?>'>
								<input type="hidden" value="<?php echo count($select_lead); ?>" id="lead_count">
								<input type="hidden" value="<?php echo $fetch->enquiry_for; ?>" id="select_enq">
								
								
								<td><?php echo $i; ?></td>
								<td>	<?php if($fetch->lead_source == '')
												{
												  $lead_source= "Web - ".$fetch->enquiry_for; 
												}
												elseif($fetch->lead_source == 'Facebook')
												{
								 					$lead_source= $fetch->enquiry_for;
												}
												else
												{
													 $lead_source=$fetch->lead_source;
												}?><?php echo $lead_source; ?></td>
								
								<td><b>	<?php if($_SESSION['process_id']==5)
												{
													?><a href="<?php echo site_url(); ?>add_followup_accessories/detail/<?php echo $enq_id; ?>/<?php echo $enq;?> " title="Customer Follow Up Details"><?php
												}
												else if($_SESSION['process_id']==4)
												{
													?><a href="<?php echo site_url(); ?>add_followup_service/detail/<?php echo $enq_id; ?>/<?php echo $enq;?> " title="Customer Follow Up Details"><?php
												}
											/*	else if($_SESSION['process_id']=='Insurance')
												{
													?><a href="<?php echo site_url(); ?>add_followup_insurance/detail/<?php echo $enq_id; ?>/<?php echo $enq;?> " title="Customer Follow Up Details"><?php
												}*/
												else if($_SESSION['process_id']==1)
												{
													?><a href="<?php echo site_url(); ?>add_followup_finance/detail/<?php echo $enq_id; ?>/<?php echo $enq;?> " title="Customer Follow Up Details"><?php
												}
												else if($_SESSION['process_id']==6)
												{
													?><a href="<?php echo site_url(); ?>add_followup_new_car/detail/<?php echo $enq_id; ?>/<?php echo $enq;?> " title="Customer Follow Up Details"><?php
												}
												else if($_SESSION['process_id']==7)
												{
													?><a href="<?php echo site_url(); ?>add_followup_used_car/detail/<?php echo $enq_id; ?>/<?php echo $enq;?> " title="Customer Follow Up Details"><?php
												}
												else if($_SESSION['process_id']==8)
												{
													?><a href="<?php echo site_url(); ?>add_followup_evaluation/detail/<?php echo $enq_id; ?>/<?php echo $enq;?> " title="Customer Follow Up Details"><?php
												}
												else
												{
													?><a href="<?php echo site_url(); ?>add_followup/detail/<?php echo $enq_id; ?>/<?php echo $enq;?> " title="Customer Follow Up Details"><?php
												}
												?>
												<?php echo $fetch -> name;
								if($fetch->days60_booking=='90' || $fetch->days60_booking=='>60')
								{?>
									<span class="label label-success"><?php echo $fetch->days60_booking;?>&nbsp;Days</span>
									<?php }
									else if($fetch->days60_booking=='30'){?><span class="label label-danger"><?php echo $fetch->days60_booking;?>&nbsp;Days</span><?php }
									else if($fetch->days60_booking=='60'){?><span class="label label-warning"><?php echo $fetch->days60_booking;?>&nbsp;Days</span><?php }
									
								else{?><span class="label label-success"><?php echo $fetch->days60_booking;?></span> <?php }
								
								if($enq !="New Lead" && $enq!="Pending Not Attended")
				{//echo "(" . $fetch -> fcount . ")";
								}?></a></b>
								</td>
								<td><?php echo $fetch -> contact_no; ?></td>
								<td><?php echo $fetch -> created_date; ?></td>
								<?php	if($_SESSION['role'] ==3 && $enq =='New')
								{
									}
									else
									{?>
								
								<td><?php echo $fetch -> feedbackStatus; ?></td>
								<td><?php echo $fetch -> nextAction; ?></td>
								<?php if($fetch->assign_to_dse!=0){?>
									<td><?php echo $fetch -> dse_fname.' '.$fetch -> dse_lname; ?></td>
								<?php }elseif($fetch->assign_to_dse_tl!=0 && $fetch->assign_to_dse==0){ ?>
									<td><?php echo $fetch -> dsetl_fname.' '.$fetch -> dsetl_lname; ?></td>
									<?php }elseif($fetch->assign_to_dse_tl==0 && $fetch->assign_to_dse==0){ ?>
									<td><?php echo $fetch -> cse_fname.' '.$fetch -> cse_lname; ?></td>
									<?php }else{ ?>
										<td><?php echo $fetch -> csetl_fname.' '.$fetch -> csetl_lname; ?></td>
								<?php } ?>
								<?php  if($fetch->dse_followup_id == 0){?>
								<td><?php echo $fetch -> cse_date; ?></td>
								<td><?php echo $fetch -> cse_nfd; ?></td>
									<td><?php echo $fetch -> cse_nftime; ?></td>
								<td><?php $comment = $fetch -> cse_comment;

												$string = strip_tags($comment);

												if (strlen($string) > 20) {

													// truncate string
													$stringCut = substr($string, 0, 20);

													// make sure it ends in a word so assassinate doesn't become ass...
													$string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '... ';
												}
												echo $string;
											 ?></td>
											 <?php }else{ ?>
											 	<td><?php echo $fetch -> dse_date; ?></td>
								<td><?php echo $fetch -> dse_nfd; ?></td>
								<td><?php echo $fetch -> dse_nftime; ?></td>
								<td><?php $comment = $fetch -> dse_comment;

												$string = strip_tags($comment);

												if (strlen($string) > 20) {

													// truncate string
													$stringCut = substr($string, 0, 20);

													// make sure it ends in a word so assassinate doesn't become ass...
													$string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '... ';
												}
												echo $string;
											 ?></td>
								<?php
								}
											 } ?>
							 <?php if($view[10]==1){?>
								 <td><a href="<?php echo site_url();?>manager_remark/leads/<?php echo $fetch->enq_id ;?>/<?php echo $enq ;?>">Add Auditor Remark</a></td>
											 <?php } ?>
								
							</tr>
							<?php } }?>
						</tbody>
					</table>
				</div>