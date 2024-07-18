
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

<h1 style="text-align:center; ">Add Accessories Package</h1>
	<div class="col-md-12" >
			<div class="panel panel-primary">

				<div class="panel-body">
				
					<form action="<?php echo $var; ?>" method="post">

						<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
							
							
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Model Name: </label>
									<div class="col-md-5 col-sm-5 col-xs-12">
									<select name="model_id" id="model_id" class="form-control" required >
										<option value="">Please Select </option>
										<?php foreach($select_model as $row){?>
										<option value="<?php echo $row->model_id ;?>"><?php echo $row->model_name;?> </option>
										<?php } ?>
																				</select>

																				</div>
								</div>
								
									<div class="form-group">
                                            
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Package Name: </label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										
										<input type="text" required placeholder="Enter Package Name"  onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="package_name" name="package_name">
									       
                                            
									
									</div>
									
									
								</div>

								
								
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Package Price: </label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<input type="text" required placeholder="Enter Package Price" onkeypress="return isNumberKey(event)" onkeyup="return limitlength(this, 10)"  autocomplete="off" class="form-control" id="package_price" name="package_price">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Benefit: </label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<input type="text" required placeholder="Enter Benefit" onkeypress="return isNumberKey(event)" onkeyup="return limitlength(this, 10)"  autocomplete="off" class="form-control" id="benefit" name="benefit">
									</div>
								</div>
									<div class="form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Package Total Price: </label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<input type="text" required placeholder="Enter Package Total Price" onkeypress="return isNumberKey(event)" onkeyup="return limitlength(this, 10)"  autocomplete="off" class="form-control" id="package_total_price" name="package_total_price">
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
							<th>Model Name</th>
							<th>Package Name</th>
							<th>Package Price</th>
							<th>Benefit</th>
							<th>Package Total Price</th>
							
							<th>Action</th>
						
						</tr>	
					</thead>
					<tbody>
				
					
					 <?php 
					 $i=0;
						foreach($select_package as $fetch) 
						{
							$i++;
						?>

						<tr>
						
						<td>	<?php echo $i; ?> 		
							</td>
						
						<td>
						<?php echo $fetch -> model_name; ?>
						</td>
						<td>
						<?php echo $fetch -> package_name; ?>
						</td>
							
							<td>
							<?php echo $fetch -> package_price; ?>
							</td>
								<td>
							<?php echo $fetch -> benefit; ?>
							</td>
								<td>
							<?php echo $fetch -> package_total_price; ?>
							</td>
						  
							<td>
							
						
						<a href="<?php echo site_url(); ?>accessories_package/delete_package/<?php echo $fetch -> accessories_package_id; ?>" onclick="return getConfirmation();"> Delete </a>
						
						</a>
							
							</td>
						
						</tr>
						 <?php } ?>
					</tbody>
					
				</table>
				
	
				
				
                        </div>
                       </div>
            
 <script>
 function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		// Added to allow decimal, period, or delete
		if (charCode == 110 || charCode == 190 || charCode == 46)
			return true;

		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;

		return true;
	}

	function limitlength(obj, length) {
		var maxlength = length
		if (obj.value.length > maxlength)
			obj.value = obj.value.substring(0, maxlength)
	}
	 function getConfirmation(){
               var retVal = confirm("Do you want to continue ?");
               if( retVal == true ){
                
			return true;
               }
               else{
				   
                return false;
               }
            }

 </script>
    