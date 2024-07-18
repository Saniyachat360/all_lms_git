
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
	function get_accessories_item(){
		var accessories_package_id=document.getElementById('accessories_package_id').value;
		$.ajax({
				url:'<?php echo site_url();?>accessories_package/get_accessories_item',
				type:'POST',
				data:{accessories_package_id:accessories_package_id},
				success:function(response)
				{
					$("#accessories_table_div").html(response);
				
				}
				});
	}
</script>

<div class="row" >
<?php echo $this -> session -> flashdata('message'); ?>
	<h1 style="text-align:center;">Upload & Search Accessories Package Itmes</h1>
		<div class="panel panel-primary">
			<div class="panel-body">
				<form name='import' action="<?php echo $var; ?>" method="post"  enctype="multipart/form-data">
				
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
					<div class="col-md-offset-2 col-md-10">
						<div class="form-group col-md-8 ">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Accessories Package Name:</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<select name="package_id" id="accessories_package_id" class="form-control" required >
										<option value="">Please Select </option>
										<?php foreach($select_package as $row){?>
										<option value="<?php echo $row->accessories_package_id ;?>"><?php echo $row->package_name;?> </option>
										<?php } ?>
																				</select>
																				
							</div>
						</div>
						<div class="col-md-2">

								<a  class="btn btn-success col-md-6 col-xs-6 col-sm-6" onclick="get_accessories_item()"><i class="entypo-search"></i>

								</a>
							</div>
					</div>
						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12"></label>
							<div class="col-md-5 col-sm-5 col-xs-12">
								<label class="control-label "><font color="red">Please upload only .xls file</font></label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Upload File:</label>
							<div class="col-md-5 col-sm-5 col-xs-12">
								<input type="file"  class="btn btn-info"  name="file" id="file" required  >
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
				</form>
			</div>
		</div>
	</div>
</div>              
                    
                    
           

<div id="accessories_table_div">
<!--<div class="col-md-12" >
<div class="table-responsive">

				<table id="example"  class="table " style="width:auto;" cellspacing="0"> 
					<thead>
						<tr>
							<th>Sr No.</th>
							<th>Model Name</th>
							<th>Variant Name</th>
							<th>Accessories Name</th>
							<th>Price</th>
						
							
							<th>Action</th>
						
						</tr>	
					</thead>
					<tbody>
				
					
					 <?php 
					 $i=0;
						foreach($select_package_item as $fetch) 
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
						<?php echo $fetch -> variant_name; ?>
						</td>
							
							<td>
							<?php echo $fetch -> accessories_name; ?>
							</td>
								<td>
							<?php echo $fetch -> price; ?>
							</td>
							
							<td>
							
						
						<a href="<?php echo site_url(); ?>accessories_package/delete_package/<?php echo $fetch -> package_item_id; ?>" onclick="return getConfirmation();"> Delete </a>
						
						</a>
							
							</td>
						
						</tr>
						 <?php } ?>
					</tbody>
					
				</table>
				
	
				
				
                        </div>
                       </div>-->
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
    