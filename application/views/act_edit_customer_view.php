<script>
function goBack() {
    window.history.back();
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
  <h1 style="text-align:center; ">Edit Customer Detail</h1>
<div class="col-md-12" >
 <div class="panel panel-primary">
   
     <div class="panel-body">
                <form name="submit" action="<?php echo site_url();?>edit_customer/update_user" method="post" onsubmit="return validate_form()">
                
						 <?php foreach ($edit_user as $row)
				
						
  {?>
                     <div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                         <div class="col-md-2"></div><div class="col-md-8">
                            
							 <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                                            </label>
                                                   <div class="col-md-9 col-sm-9 col-xs-12">
                                                  <input type="hidden"  onkeypress="return alpha(event)" placeholder="Enter Name"  value="<?php echo $row->enq_id; ?>" autocomplete="off" class="form-control" id="id" name="id" >
                                            </div>
                                                               </div>
							<div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name: 
                                            </label>
                                                   <div class="col-md-9 col-sm-9 col-xs-12">
                                                  <input type="text" onkeypress="return alpha(event)" placeholder="Enter Name"  value="<?php echo $row->name; ?>" autocomplete="off" class="form-control" id="name" name="name" >
                                            </div>
                                                               </div>
                                                                 <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Contact:
                                            </label>
                                                   <div class="col-md-9 col-sm-9 col-xs-12">
                                                  <input type="text" required  onkeypress="return isNumberKey(event)" value="<?php echo $row->contact_no; ?>" onkeyup="return limitlength(this, 10)" placeholder="Enter Contact Number" autocomplete="off" class="form-control" id="contact" name="contact">
                                            </div>
                                                               </div>
                           <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email:
                                            </label>
                                                  <div class="col-md-9 col-sm-9 col-xs-12">
                                                     <input  type="text" autocomplete="off"  class="form-control" value="<?php echo $row->email; ?>" id="email" placeholder="Enter Email ID" name="email" >
                                                  
                                            </div>
                                      </div>

                                     <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Address:
                                            </label>
                                                  <div class="col-md-9 col-sm-9 col-xs-12">
                                                  <textarea rows="2"   autocomplete="off" class="form-control" value="" id="address" name="address" ><?php echo $row->address; ?></textarea>
                                            </div>
                                      </div>
                                      
                                      
                                      
                                      
                             
                            
                            
                        
                         </div><div class="col-md-2"></div>
                         </div>
                             
                               

                         
                  
                    <div class="form-group">
                     <div class="col-md-2 col-md-offset-4">
                    	
						
                    <button type="submit" id="checkBtn" class="btn btn-success col-md-12 col-xs-12 col-sm-12">Update</button>
                         </div>
						 <div class="col-md-2">
									<input type='text' class="btn btn-primary col-md-12 col-xs-12 col-sm-12" value='Cancel' onclick="goBack()">

							</div>
                       
                    </div>
                   </div>
                  </div>
  <?php }?>
				  
                </form>
            </div>