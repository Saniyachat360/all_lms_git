

<script type="text/javascript" class="init">
	$(document).ready(function() {
		$('#example').dataTable({
			"bSort" : false,
			dom : 'Bfrtip',
			buttons : ['csvHtml5']
		});
	}); 
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#myModal').modal({
			backdrop : 'static',
			keyboard : false
		});
	}); 
</script>


<script>
	function validate_form() {

		var phone1 = document.forms["submit"]["pnum"].value;
		var x = document.forms['submit']['email'].value;

		var atpos = x.indexOf("@");
		var dotpos = x.lastIndexOf(".");
		if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {

			alert("Not a valid e-mail address!");
			return false;
			email.focus();
		}
		var no = /^\d{10}$/;

		if (no.test(phone1)) {
			//	return true;
		} else {
			alert("Phone Number must be 10 Digit!");

			return false;
			phone.focus();
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
function get_group()
{
	var process_id=document.getElementById("process_id").value;
	$.ajax({url: "<?php echo site_url();?>add_lms_user/get_group_name",
	type:"POST",
	data:{process_id:process_id}, 
	success: function(result){
        $("#group_div").html(result)
   } });

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

<script type="text/javascript">
         <!--
            function getConfirmation(){
               var retVal = confirm("Do you want to continue ?");
               if( retVal == true ){
                
			return true;
               }
               else{
				   
                return false;
               }
            }
         //-->
      </script>


<div class="row" >
	<div class="col-md-12">
<?php echo $this -> session -> flashdata('message'); ?>
</div>
		   <h1 style="text-align:center; ">Edit Scheme</h1>
<div class="col-md-12" >
 <div class="panel panel-primary">
   
     <div class="panel-body">
                <form action="<?php echo $var;?>" method="post">
                <?php
						foreach($scheme as $fetch) 
						{?>
                     <div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                         <div class="col-md-12">
                         	<div class="form-group">
								<label class="control-label col-md-2 col-sm-4 col-xs-12" for="first-name">Loan Type: </label>
								<div class="col-md-8 col-sm-5 col-xs-12">
								<select name="loan_id" class="form-control" required="" >
								
												
									<option value="<?php echo $fetch->loan_id ;?>"><?php echo $fetch->loan_name ;?></option>
                   		
									<?php foreach ($select_loan_type as $row) {?>
											<option value="<?php echo $row->loan_id;?>"><?php echo $row->loan_name;?></option>
						            	<?php	} ?>
								
                                					        					
														
													                                						
													                                				</select>
								</div>
							</div>
								<div class="form-group">
								<label class="control-label col-md-2 col-sm-4 col-xs-12" for="first-name">Scheme Name: </label>
								<div class="col-md-8 col-sm-5 col-xs-12">
									<input type="text"  onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="scheme_name" required name="scheme_name" value="<?php echo $fetch->scheme_name ;?>">
								</div>
							</div>
                              <div class="form-group">
                                                  <label class="control-label col-md-2 col-sm-4 col-xs-12" for="first-name">Scheme Description: 
                                            </label>
                                                <div class="col-md-8 col-sm-5 col-xs-12">
                                                  <textarea type="text" required onkeypress="return alpha(event)" autocomplete="off" class="form-control" id="scheme"  name="scheme" ><?php echo $fetch->scheme_desc;?> </textarea>
                                            </div>
                                                               </div>
                                                               
                           

                           
                                      <input type="hidden" class="form-control" value="<?php echo $fetch->scheme_id;?>"  name="scheme_id" >
                                      
                             
                            
                            
                        
                         </div>
                        </div>
                          <?php } ?>           
                               

                         
                  
                    <div class="form-group">
                     <div class="col-md-2 col-md-offset-4">
                    	
						
                    <button type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12">Update</button>
                         </div>
                       
                        <div class="col-md-2">
                            <input type='reset' class="btn btn-primary col-md-12 col-xs-12 col-sm-12" value='Cancel' onclick="window.location='<?php echo site_url();?>scheme'">
                        
                        </div>
                    </div>
                   </div>
                  </div>
                </form>
            </div>
            







</div>

<script src="<?php echo base_url();?>assets/ckeditor/ckeditor.js"></script>
    <script>
    
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
	var editor_config = {
    height: "150px"
};

CKEDITOR.replace('scheme', editor_config );
	
	 /*CKEDITOR.replace('product_description');
	 CKEDITOR.replace( 'Resolution', {
        height: 100
    } );
	*/
		
  })
</script> 