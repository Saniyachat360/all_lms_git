
<script>
	$(document).ready(function() {
		var table = $('#example').DataTable({

			scrollY : "400px",
			//scrollX : true,
			//scrollCollapse : true,

			fixedColumns : {
				//leftColumns : 5,
				//rightColumns : 1
			}
		});
	});
</script>

<div class="row" >
<?php echo $this -> session -> flashdata('message'); ?>
<?php $insert=$_SESSION['insert'];
if($insert[5]==1)
{?>
<h1 style="text-align:center; ">Add Campaign</h1>
	<div class="col-md-12" >
			<div class="panel panel-primary">

				<div class="panel-body">
				
					<form action="<?php echo $var; ?>" method="post">

						<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
							
							
							<div class="col-md-12">
								
								
									<div class="form-group">
                                            
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Group Name: </label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										
										
									       
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="process_name" name="group_id" required>
												 <option value=""> Please Select </option>
											<?php foreach ($select_grp as $fetch) {
											?>	
											
													 <option value="<?php echo $fetch -> group_id; ?>"><?php echo $fetch -> group_name; ?></option>
                                             <?php } ?>
                                             	
                                               
                                                </select>
										
									
									</div>
									
									
								</div>

								
								
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Campaign Name: </label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<input type="text" required onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="name" name="campaign_name">
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
	         

<div class="col-md-12">
<div class="table-responsive">
	<?php
	$modify = $_SESSION['modify'];
	$delete = $_SESSION['delete'];
	$form_name = $_SESSION['form_name'];
	 ?>
				<table id="example"  class="table " style="width:auto;" cellspacing="0"> 
					<thead>
						<tr>
							<th>Sr No.</th>
							<th>Group Name</th>
							<th>Campaign Name</th>
							<?php if($modify[5]==1 || $delete[5]==1) {?>
							<th>Action</th>
						<?php } ?>
							
						</tr>	
					</thead>
					<tbody>
				
					
					 <?php 
					 $i=0;
						foreach($select_campaign as $fetch) 
						{
							$i++;
						?>

						<tr>
						
						<td>	<?php echo $i; ?> 		
							</td>
						
						
						<td>
						<?php echo $fetch -> group_name; ?>
						</td>
							
							<td>
							<?php echo $fetch -> campaign_name; ?>
							</td>
								
						   <?php if($modify[5]==1 || $delete[5]==1)  {?>
							<td>
								<?php if($modify[5]==1) {?>
						<a href="<?php echo site_url(); ?>add_campaign/edit_campaign/<?php echo $fetch -> campaign_id; ?>">Edit </a> &nbsp;&nbsp;
						<?php }
							if($delete[5]==1) {
						?>
						<a href="<?php echo site_url(); ?>add_campaign/delete_campaign/<?php echo $fetch -> campaign_id; ?>" onclick="return getConfirmation();"> Delete </a>
						<?php } ?>
						</a>
							
							</td>
								<?php } ?>
						
						</tr>
						 <?php } ?>
					</tbody>
					
				</table>
				
	
				
				
                        </div>
                       </div>
            
 <script src="<?php echo base_url(); ?>assets/js/campaign.js"></script>                
	
    