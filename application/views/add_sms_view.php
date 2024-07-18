 <script>
		function select_nextaction() {
	
	
	var feedback_status = document.getElementById("feedbackstatus").value;
	

		$.ajax({
			url : '<?php echo site_url('add_sms/select_next_action'); ?>',
			type : 'POST',
			data : {'feedback_status' : feedback_status,

			},
			success : function(result) {
			$("#disposition_div").html(result);
		}
			});
			
			}
</script> 
<div class="row" >
		<?php echo $this -> session -> flashdata('message'); ?>
		<?php $insert=$_SESSION['insert'];
		if($insert[62]==1)
{?>
		<h1 style="text-align:center; ">Add SMS </h1>
		<div class="col-md-12" >
			<div class="panel panel-primary">

					<form name="form" action= "<?php echo $var;?>" method="post">
				<div class="panel-body">

						<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
							
							
							<div class="col-md-12">

								 <div class="form-group">
                                     
                                      	<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Feedback Status: </label>
                                               <div class="col-md-5 col-sm-5 col-xs-12">
                                              <select class="filter_s form-control" id="feedbackstatus"  name="feedback_status" required onchange="select_nextaction();">
										
											
													 <option value="">Please Select</option>
													 
													 			 <?php  
													 			 foreach ($select_feedback_status as $row) {
                          
                      ?>
                      <option value="<?php echo $row -> feedbackStatusName; ?>"><?php echo $row -> feedbackStatusName; ?></option>
					  <?php } ?>
													 
                                        </select>
										  </div>
                                            </div>
							
									<div class="form-group">
                                            
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Action: </label>
									<div  class="col-md-5 col-sm-5 col-xs-12"  id="disposition_div">
									
									          <select class="filter_s form-control"  name="disposition" required>
										
											
													 <option value="">Please Select</option>
                                        </select>	
										
									
							</div>
							</div>
						
							
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">SMS: </label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<textarea type="text" required onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="sms" name="sms"></textarea>
									</div>
								</div>

							</div>
							

						</div>
						<div class="form-group">
							<div class="col-md-2 col-md-offset-4">

								<button type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12">
									Submit
								</button>
							</div>

							<div class="col-md-2">
								<input type='reset' class="btn btn-primary col-md-12 col-xs-12 col-sm-12" value='Reset'>

							</div>
						</div>
				</div>
			</div>
			</form>
		</div>
    <?php } ?>
                    </div> 
	

<div class="row" >
	<div class="col-md-12">
	
		<?php
$modify = $_SESSION['modify'];
$delete = $_SESSION['delete'];
$form_name = $_SESSION['form_name'];
	 ?>
	
					<div class="table-responsive"  >
			<table id="example"  class="table " style="width: 100%" >  
			<thead>
						<tr>
							<th>Sr No.</th>
							<th>Feedback Status</th>
							<th>Next Action</th>
							
							<th>SMS </th>
						<?php if($modify[62]==1 || $delete[62]==1)  {?>
							<th>Action</th>
					<?php  } ?>
							
						</tr>	
					</thead>
					<tbody>
				
					 <?php 
					 $i=0;
						foreach($select_table as $fetch) 
						{
							$i++;
						?>
				
						<tr>
								
						<td><?php echo $i; ?></td>
						<td><?php echo $fetch ->feedBackStatus ?></td>
						<td><?php echo $fetch ->nextActionName; ?></td>
						<td><?php echo $fetch ->sms; ?></td>
						<?php if($modify[62]==1 || $delete[62]==1)  {?>
						<td><?php if($modify[62]==1) {?><a href="<?php echo site_url(); ?>add_sms/edit_sms?id=<?php echo $fetch -> sms_id; ?>">Edit</a> &nbsp;&nbsp;
						<?php } if($delete[62]==1) { ?>
						<a href="<?php echo site_url(); ?>add_sms/del_sms?id=<?php echo $fetch -> sms_id; ?>" onclick="return getConfirmation();"> Delete </a>
						<?php } ?>	
						</td><?php } ?>	              
						 </tr>
						 <?php } ?>
						 
					
					</tbody>
				</table>
			</div>
			</div>
			</div>
			<script>
	$(document).ready(function() {
		var table = $('#example').DataTable({

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
<script src="<?php echo base_url(); ?>assets/js/campaign.js"></script>