 <script>
		function select_nextaction() {
	
	
	var feedback_status = document.getElementById("feedbackstatus").value;
	

		$.ajax({
			url : '<?php echo site_url('add_sms/select_next_action_edit'); ?>',
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
//if($insert[16]==1)
//{?>
		<h1 style="text-align:center; ">Edit SMS </h1>
		<div class="col-md-12" >
			<div class="panel panel-primary">

					<form action= "<?php echo $var1;?>" method="post">
				<div class="panel-body">

						<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
							
							
							<div class="col-md-12">

								 <div class="form-group">
                                     
									 <?php									

									 foreach( $edit_sms as $row)
									 {
										 
									?>
									
                                      	<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">FeedBack Status: </label>
                                               <div class="col-md-5 col-sm-5 col-xs-12">
                                              <select class="filter_s form-control" id="feedbackstatus" name="feedback_status" required onchange="select_nextaction();">
										
											
													 <option value="<?php echo $row->feedBackStatus;?>"><?php echo $row->	feedBackStatus;?></option>
													 	 <?php  
													 			 foreach ($select_feedback_status as $row1) {
                          
                      ?>
                      <option value="<?php echo $row1 -> feedbackStatusName; ?>"><?php echo $row1 -> feedbackStatusName; ?></option>
					  <?php } ?>			 
                                        </select>
										  </div>
								
                                            </div>
							
									<div class="form-group">
                                          	<input type='hidden' name='id' value='<?php echo $row ->sms_id;?>'>	  
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Action: </label>
									<div  class="col-md-5 col-sm-5 col-xs-12"  id="disposition_div">
									
									         <select class="filter_s form-control" required name="next_action" >
										
										<option value="<?php echo $row->nextActionName;?>"><?php echo $row->nextActionName;?></option>
                                        </select>	
										
									
							</div>
									

							</div>
						
							
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">SMS: </label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<textarea type="text" required onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="sms" name="sms"><?php echo $row->sms;?></textarea>
									</div>
								</div>

							</div>
							
 <?php  }
									 
									 ?>
						</div>
						<div class="form-group">
							<div class="col-md-2 col-md-offset-4">

								<button type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12">
									Update
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
    <?php // } ?>
                    </div> 
	

	
  <script src="<?php echo base_url(); ?>assets/js/campaign.js"></script>    