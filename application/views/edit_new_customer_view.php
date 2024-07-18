
<script>
	function validate_form() {
		//alert("hii");
		var dept_count = ($('[name="dept[]"]:checked').length);
		//alert(dept_count);

		var phone1 = document.forms["submit"]["pnum"].value;
		var x = document.forms['submit']['email'].value;
		if (x != '') {
			var atpos = x.indexOf("@");
			var dotpos = x.lastIndexOf(".");
			if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {

				alert("Not a valid e-mail address!");
				return false;
				email.focus();
			}
		}
		var no = /^\d{10}$/;

		if (no.test(phone1)) {
			//	return true;
		} else {
			alert("Phone Number must be 10 Digit!");

			return false;
			phone1.focus();
		}
		if (dept_count == 0) {
			alert("Please Select Atleast One Department");
			return false;
		}

	}

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

	function alpha(e) {
		var k;
		document.all ? k = e.keyCode : k = e.which;
		return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
	}


	$(document).ready(function() {
		$("#fname").keypress(function(event) {
			var inputValue = event.which;
			// allow letters and whitespaces only.
			if ((inputValue > 47 && inputValue < 58) && (inputValue != 32)) {
				event.preventDefault();
			}
		});
	});

</script>


<script>	function select_loc()
		{
			
			var location= document.getElementById("location").value;
		//alert(location);
				
			$.ajax({
				url:'<?php echo site_url('add_new_customer/select_loc')?>
				',
				type:'POST',
				data:{location:location},
				success:function(response)
				{$("#csediv").html(response);}
				});

				}
				
</script>


<div class="row" >
	<div class="col-md-12" >
		
		<h1 style="text-align:center;">Edit New Customer Lead Details</h1>
		<div class="panel panel-primary">

			<div class="panel-body">
				
				<form name="submit" action="<?php echo $var1;?>" method="post" >




					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						
							<?php foreach ($edit_customer as $fetch) {
											?>	
									
						<input type='hidden' name='enq_id' value='<?php echo $fetch ->enq_id;?>'>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" >Name: </label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<input type="text" required onkeypress="return alpha(event)"   class="form-control" id="fname"  value="<?php echo $fetch->name;?>" name="fname" >
								</div>
								
                                             
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" >Email: </label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<input  type="text" class="form-control" id="email" name="email" value="<?php echo $fetch->email;?>">

								</div>
							</div>
						

					
	<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" >Moblie Number: </label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<input type="text" onkeypress="return isNumberKey(event)" onkeyup="return limitlength(this, 10)" class="form-control" id="pnum" value="<?php echo $fetch->contact_no;?>" name="pnum" required>
								</div>
							</div>
							
								<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" >Address: </label>
								<div class="col-md-9 col-sm-9 col-xs-12">
										<textarea placeholder="Address" name='address' value="<?php echo $fetch->address;?>" class="form-control" /><?php echo $fetch->address;?>
									</textarea>
								</div>
							</div>
							

						</div>
						<div class="col-md-6">

						
						<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" >Location: </label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									
									
									
									<select name="location" id="location" class="form-control" onchange='select_loc()'>
										
										<option value="<?php echo $fetch->location_id;?>"><?php echo $fetch->location;?></option>
										
											<?php 
										foreach($select_location as $row)
										{
											?>
									
											<option value="<?php echo $row->location_id;?>"><?php echo $row->location;?></option>
											<?php
										}
										?>
																		</select>
								</div>
							</div>

							
							<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" >Assign To: </label>
									<div class="col-md-9 col-sm-9 col-xs-12" id="csediv">
										<select name="assign" id="assign" class="form-control">
										
											
							                      <option   value="<?php echo $fetch->id;?>" > <?php echo $fetch->fname;?><?php echo " ", $fetch->lname;?> </option>
					
                
												
										</select>
									</div>
								</div>
							
							
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" >Comment: </label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<textarea name='comment' value="<?php echo $fetch->comment;?>" class="form-control"><?php echo $fetch->comment;?></textarea>
								</div>
							</div>

						</div>

				
					
				<div class="col-md-12 form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" >Group: </label>
								<div class="col-md-9 col-sm-9 col-xs-12" >
								
						<?php $dept = $fetch->enquiry_for;
						
						?>
								<input type="checkbox" name="dept[]" value="New Car" <?php if (preg_match("/New Car/", "$dept")) { echo "checked";} else {echo "";} ?> />
								<label for="size1">New Car</label>
							
								<input type="checkbox" name="dept[]" value="Used Car" <?php if (preg_match("/Used Car/", "$dept")) { echo "checked";} else {echo "";} ?> />
								<label for="size1">Used Car</label>
							
								<input type="checkbox" name="dept[]" value="Insurance" <?php if (preg_match("/Insurance/", "$dept")) { echo "checked";} else {echo "";} ?> />
								<label for="size1">Insurance</label>
							
								<input type="checkbox" name="dept[]" value="Finance" <?php if (preg_match("/Finance/", "$dept")) { echo "checked";} else {echo "";} ?> />
								<label for="size1">Finance</label>
							
							<input type="checkbox" name="dept[]" value="Finance" <?php if (preg_match("/Service/", "$dept")) { echo "checked";} else {echo "";} ?> />
								<label for="size1">Service</label>
									
								
								</div>
							</div>
							  <?php } ?>
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
				</form>
			</div>
		</div>
	</div>
	
	
	
</div>

