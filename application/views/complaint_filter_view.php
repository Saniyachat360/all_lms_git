<?php
	$page = $this -> uri -> segment(4);
	
	if (isset($page)) {
		$page = $page + 1;
	
	} else {
		$page = 0;
	
	}
	$offset1 = 100 * $page;
	//$query=$sql->result();
	$c = count($select_lead);
	//echo $c;
?>
	<div class="table-responsive"  >	
							<table id="example"  class="table " style="width: 100%" > 		
								<thead>
									<tr>
										<!-- Show Select box if add followup or remark right 1 -->										
										<th>Sr</th>		
										<th>Lead Source</th>									
										<th>Name</th>
										<th>Contact</th>
										<th>Complaint Date</th>
										<th>Service Center</th>
										<th>Customer Remark</th>						
										<th>Feedback Status</th>
										<th>Next Action</th>
										<th>Current User</th>
										<th>Call Date</th>
										<th>N.F.D</th>
										<th>N.F.T</th>
										<th>Remark</th>											
										<th>Action</th>
														
								</tr>
							</thead>
							<tbody>
								<?php
									$i=$offset1;				
									if (!empty($select_lead)) 
									{
										foreach($select_lead as $fetch)
										{						
										
										
											$i++;
											?>
											<tr id='t<?php echo $i; ?>'>
										
											<td><?php echo $i; ?></td>
												<td><?php  if($fetch->lead_source==''){ echo 'Web'; }else{ echo $fetch->lead_source ; } echo '-'.$fetch->business_area; ?></td>						
										<td><b><a href="<?php echo site_url();?>add_followup_complaint/detail/<?php echo $fetch->complaint_id ;?>/<?php echo $enq ;?>"><?php echo $fetch->name; ?></b></td>
										<td><?php echo $fetch->contact_no; ?></td>
										<td><?php echo $fetch->created_date; ?></td>
										<td><?php echo $fetch->service_center; ?></td>
										<td><?php
											$comment = $fetch -> comment;

												$string = strip_tags($comment);

												if (strlen($string) > 20) {

													// truncate string
													$stringCut = substr($string, 0, 20);

													// make sure it ends in a word so assassinate doesn't become ass...
													$string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '... ';
												}
												echo $string;
												?></td>								
										
										<td><?php echo $fetch->feedbackStatus; ?></td>
										<td><?php echo $fetch->nextAction; ?></td>
										<td><?php echo $fetch->cse_name; ?></td>
										<td><?php echo $fetch->date; ?></td>
										<td><?php echo $fetch->nextfollowupdate; ?></td>
										<td><?php echo $fetch->nextfollowuptime; ?></td>
										<td><?php
											$comment = $fetch -> cse_comment;

												$string = strip_tags($comment);

												if (strlen($string) > 20) {

													// truncate string
													$stringCut = substr($string, 0, 20);

													// make sure it ends in a word so assassinate doesn't become ass...
													$string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '... ';
												}
												echo $string;
												?></td>											
									
								<!--<td><?php /*$comment = $fetch -> cse_comment;

												$string = strip_tags($comment);

												if (strlen($string) > 20) {

													// truncate string
													$stringCut = substr($string, 0, 20);

													// make sure it ends in a word so assassinate doesn't become ass...
													$string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '... ';
												}
												echo $string;*/
											 ?></td>
									-->
							
								
								
								 <td><a href="<?php echo site_url();?>manager_remark/leads/<?php echo $fetch->complaint_id ;?>/<?php echo $enq ;?>">Add Auditor Remark</a></td>
										
							</tr>
							<?php } }?>
						</tbody>
					</table>
				</div>