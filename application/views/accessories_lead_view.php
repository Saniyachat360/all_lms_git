<script>  
jQuery(document).ready(function(){
 $('#results').DataTable();});
</script>		

			<!--- Fetch Table Data -->
			<div class="col-md-12">
			<?php echo $this -> session -> flashdata('message'); ?>
			</div>
			<h1 class="text-center">Accessories Leads</h1>
		   	<div class="row">
				<div class="col-md-12" >
					<div class="table-responsive"  style="overflow-x:auto;">
						<table class="result table table-bordered datatable table-responsive" id="results">
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
								<th>Status</th>
								<th>Disposition</th>
								<th>Call Date</th>
								<th>N.F.D</th>
								
								<?php
								$view=$_SESSION['view'];
								if($_SESSION['role']==2 || $_SESSION['role']==1 || $_SESSION['role']==5)
								{?>
								<th>Assign To</th>
								<?php } ?>
								<th>Remark</th>
								<?php
								if($view[10]==1)
								{?>
								<th>Manager Remark</th>
								<?php } ?>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=0;
							foreach($select_lead as $fetch){
							$enq_id=$fetch->enq_id;
							$status = $fetch->status;
							$i++;
						
							
							?>
							<tr id='t<?php echo $i; ?>'>
								<input type="hidden" value="<?php echo count($select_lead); ?>" id="lead_count">
								<input type="hidden" value="<?php echo $fetch->enquiry_for; ?>" id="select_enq">
								<!-- Add Followup Select Box -->
								<?php
								if($insert[9]==1 || $insert[10]==1 ){?>
								<!--<td>
									<?php 	$data_array=array($fetch->buyer_type,$fetch->model_id,$fetch->variant_id,$fetch->buy_status,$fetch->old_make,$fetch->old_model,$fetch->ownership,$fetch->manf_year,$fetch->color,$fetch->km,$fetch->eagerness);
									 $data_array2 = implode(",", $data_array);?>
									<input type="checkbox" id="<?php echo $i; ?>" name="assignlead"  onclick="get_followup('<?php echo $enq_id; ?>','<?php echo $i; ?>','t<?php echo $i; ?>','<?php   echo $data_array2; ?>');">
								</td>-->
								<?php } ?>
								
								<td><?php echo $i; ?></td>
								<td><?php echo $fetch -> enquiry_for; ?></td>
								<!--<?php if($enq=='Transferred')
								{?>
									<td><?php echo $fetch -> transfer_by_fname.' '.$fetch->transfer_by_lname; ?></td>
									<?php } ?>--->
								<td><b><a href="<?php echo site_url(); ?>accessories_lead/lms_details/<?php echo $enq_id; ?>" title="Customer Follow Up Details"><?php echo $fetch -> name;
								if($fetch->eagerness=='HOT')
								{?>
									<span class="label label-danger"><?php echo $fetch->eagerness;?></span>
									<?php }else if($fetch->eagerness=='WARM'){?><span class="label label-warning"><?php echo $fetch->eagerness;?></span><?php }
								else{?><span class="label label-success"><?php echo $fetch->eagerness;?></span> <?php }
								?></a></b>
								</td>
								<td><?php echo $fetch -> contact_no; ?></td>
								<td><?php echo $fetch -> created_date; ?></td>
								<td><?php echo $fetch -> status_name; ?></td>
								<td><?php echo $fetch -> disposition_name; ?></td>
								<td><?php echo $fetch -> date; ?></td>
								<td><?php echo $fetch -> nextfollowupdate; ?></td>
								<?php
								if($_SESSION['role']==2 || $_SESSION['role']==1 || $_SESSION['role']==5)
								{?>
								<td><?php echo $fetch->fname.' '.$fetch->lname;?></td>
								<?php } ?>
								<td><?php $comment = $fetch -> comment;

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
								if($view[10]==1)
								{?>
								<td><?php $manager_comment= $fetch->remark;
									$string1 = strip_tags($manager_comment);

												if (strlen($string1) > 20) {

													// truncate string
													$stringCut = substr($string1, 0, 20);

													// make sure it ends in a word so assassinate doesn't become ass...
													$string1 = substr($stringCut, 0, strrpos($stringCut, ' ')) . '... ';
												}
												echo $string1;?></td>
								<?php } ?>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	
	<!-- /page content -->
 	
<script type="text/javascript" src="<?php echo base_url();?>assets/js/cse_lms.js"></script>