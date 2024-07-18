<script>
$(document).ready(function () {
    $('#checkBtn').click(function() {
      checked = $(" input[class=Checked]:checked").length;
	
      if(!checked) {
        alert("You must check at least one Process.");
        return false;
      }
        process=$("input[class=Checked]:checked").val();
     if(process == 1){
    
 		checked1 = $("input:checkbox[class=finance]:checked").length;
 		 if(!checked1) {
        alert("You must check at least one location .");
        return false;
      }
    }else if(process == 4){
    
    	 checked2 = $("input:checkbox[class=service]:checked").length;

      if(!checked2) {
    
        alert("You must check at least one location .");
        return false;
      }
      }else if(process == 5){
      
    	 checked3 = $("input:checkbox[class=accessories]:checked").length;

      if(!checked3) {
     
        alert("You must check at least one location .");
        return false;
      }
      }else if(process == 6){
      	
    	 checked4 = $("input:checkbox[class=new_car]:checked").length;

      if(!checked4) {
        alert("You must check at least one location .");
        return false;
      }
      }else if(process == 7){
      
    	 checked5 = $("input[class=used_car]:checked").length;

      if(!checked5) {
        alert("You must check at least one location .");
        return false;
      }
    }
    else if(process == 8){
      
    	 checked8 = $("input[class=evaluation]:checked").length;

      if(!checked8) {
        alert("You must check at least one location .");
        return false;
      }
     }
       else if(process == 9){
      
    	 checked9 = $("input[class=complaint]:checked").length;

      if(!checked9) {
        alert("You must check at least one location .");
        return false;
      }
    }
    });
});
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

</script>
<script>
function select_tl_name(val)
{
	val1 = val.split("#");
	role= val1[0];	
	if(role == 3 || role == 4 || role == 12 || role == 8 || role == 10 || role == 14 || role == 16)
	{
		document.getElementById("tl").style.display='block';
	
		$.ajax({url: "<?php echo site_url();?>add_lms_user/get_tl_name",
		type:"POST",
		data:{role:role}, 
		success: function(result){
        $("#tl").html(result)
   } });
	}
	else{
		
		document.getElementById("tl").style.display='none';
		
	}
}
</script>
<div class="row" >
	<div class="col-md-12">
		<?php echo $this -> session -> flashdata('message'); ?>
	</div>
	<?php $insert=$_SESSION['insert'];
	if($insert[2]==1)
	{?>
	<h1 style="text-align:center; ">Add New LMS User</h1>
	<div class="col-md-12" >
		
				<form name="submit" action="<?php echo $var;?>" method="post" onsubmit="return validate_form()">           
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="panel panel-primary">
   							<div class="panel-body">
						<div class="col-md-12">
                         <div class="col-md-6">
                         	<div class="form-group">
                            	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Employee Id: </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                	<?php if(isset($maxEmpId) )
                                	{
                                        $maxId=substr($maxEmpId[0]->empId,5);
										$maxIdNew=$maxId+1;
										if(strlen($maxIdNew)<2)
										{
											$maxIdNew="AVLMS00".$maxIdNew;
										}
										elseif(strlen($maxIdNew)<3)
										{
											 $maxIdNew="AVLMS0".$maxIdNew;
										}
										else 
										{
											$maxIdNew="AVLMS".$maxIdNew;
										}
									}
									else 
									{
										$maxIdNew="AVLMS001";
									}
                                   ?>
                                   <input type="text" required readonly class="form-control" value='<?php echo $maxIdNew;?>' id="empId" name="empId" >
                                   <input type="hidden"  class="form-control" value='<?php echo $maxIdNew;?>' id="password" name="password" >
                              </div>
                          </div>
                         
                                                                 <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name: 
                                            </label>
                                                   <div class="col-md-9 col-sm-9 col-xs-12">
                                                  <input type="text" required  onkeypress="return alpha(event)" placeholder="Enter Last Name" autocomplete="off" class="form-control" id="lname" name="lname">
                                            </div>
                                                               </div>
                         
									<div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Moblie Number:
                                            </label>
                                                  <div class="col-md-9 col-sm-9 col-xs-12">
                                                  <input type="text" onkeyup="return limitlength(this, 10)" placeholder="Enter Moblie Number" class="form-control" id="pnum" name="pnum" required>
                                            </div>
                                      </div>
                               
                                        
                                 </div>
                                 <div class="col-md-6">
                                 	 <div class="form-group">
                               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name: 
                                            </label>
                                                   <div class="col-md-9 col-sm-9 col-xs-12">
                                                  <input type="text" required onkeypress="return alpha(event)" placeholder="Enter First Name" autocomplete="off" class="form-control" id="fname" name="fname" >
                                            </div>
                                                               </div>
                                                                 <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email:
                                            </label>
                                                  <div class="col-md-9 col-sm-9 col-xs-12">
                                                     <input  type="text" autocomplete="off" required class="form-control" id="email" placeholder="Enter Email ID" name="email" >
                                                  
                                            </div>
                                      </div>
                                      
                                            <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Role:</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <select name="role" required id="role" class="form-control" onchange="return checkeddata()" >
												<option value="">Please Select </option>
											
												<option value="2#Manager">Manager</option>
													<option value="2#Auditor">Auditor</option>
												<?php 
												 foreach($select_process as $row) {
												 if ($row->process_id==1){?>
												<option value="13#Finance TL">Finance TL</option>
												<option value="14#Finance Executive">Finance Executive</option>
												<?php } ?>
               		 
												<?php if ($row->process_id==5){?>
												<option value="11#Accessories TL">Accessories TL</option>
												<option value="12#Accessories Executive">Accessories Executive</option>
												<?php } ?>
												
												<?php if ($row->process_id==4){  ?>
												<option value="7#Service TL">Service TL</option>
												<option value="8#Service Excecutive">Service Excecutive</option>
								<?php }
												if($row->process_id==8){ ?>
												 <option value="15#Evaluation Team Leader">Evaluation Team Leader</option>
												<option value="16#Evaluation Executive">Evaluation Executive</option>
												 	
											<?php 	 }
											// Insurancecode
													if ($row->process_id == 10) { ?>
														<option value="18#Insurance">Insurance</option>
												<?php 	 }
												} ?>
												<!-- End Insurancecode -->
												
												 }?>
												
												
											
											<?php 
												 foreach($select_process as $row) {
												 	
													 if ($row->process_id==6){?>
												
												<option value="2#CSE Team Leader">CSE Team Leader</option>
												<option value="3#CSE">CSE</option>
												<option value="5#DSE Team Leader">DSE Team Leader</option>
												<option value="4#DSE">DSE</option>
											
											<?php break;
												 } else if($row->process_id==7){ ?>
												 <option value="2#CSE Team Leader">CSE Team Leader</option>
												<option value="3#CSE">CSE</option>
												<option value="5#DSE Team Leader">DSE Team Leader</option>
												<option value="4#DSE">DSE</option>
												 	
											<?php break;	 
												 }
												/* else */
												  } ?>	
												</select>
											</div>
                                      </div>
                                 </div>
                                 </div>
                                 </div>
                                 </div>
                                 	<div class="panel panel-primary">
   							<div class="panel-body">
						<div class="col-md-12">
                          
									   <div class="col-md-6">
											
                                        <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Process:
                                            </label>
											<div class="col-md-9 col-sm-9 col-xs-12">
													<input type="hidden" id="processCount" value="<?php echo count($select_process); ?>">
											<?php $i=0; foreach($select_process as $row) { $i++; ?>
											
													<input id="<?php echo 'q-'.$i;?>" type="checkbox" name="process[]" class="Checked" value="<?php echo $row->process_id ;?>">    <?php echo $row->process_name ;?><br>
											<?php }?>
											</div>
							   </div>
							 
							   
							    	  <div class="form-group ">
				 					 <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Location:
                                            </label>
                                            </div>
                                        <div class="form-group" id="finance" style="display:none">
                                        
											 <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Finance</label>
                                            
											<div class="col-md-9 col-sm-9 col-xs-12">
												
												<input  type="hidden" id="financeCount" value="<?php echo count($select_finance_location); ?>">
											<?php $i=0; foreach($select_finance_location as $row) {
												$i++;
												?>
											
													<input id="<?php echo 'a-'.$i;?>" class="finance" type="checkbox" name="finance_location[]" value="<?php echo '1#'.$row->location_id ;?>" onclick="return checkeddata()">   <?php echo $row->location ;?><br>
											<?php }?>
											</div>
							   </div>
							  
							    <div class="form-group" id="service" style="display:none">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Service
                                            </label>     
											<div class="col-md-9 col-sm-9 col-xs-12">
											<input  type="hidden" id="serviceCount" value="<?php echo count($select_service_location); ?>">
											<?php $i=0;
											foreach($select_service_location as $row) {
												$i++;
												 ?>
											
													<input id="<?php echo 'b-'.$i;?>" class="service" type="checkbox" name="service_location[]" value="<?php echo '4#'.$row->location_id ;?>" onclick="return checkeddata()">    <?php echo $row->location ;?><br>
											<?php }?>
											</div>
							   </div>
							   <div class="form-group" id="accessories" style="display:none">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Accessories
                                            </label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<input  type="hidden" id="accessoriesCount" value="<?php echo count($select_accessories_location); ?>">
											<?php $i=0; 
											foreach($select_accessories_location as $row) {
												$i++;
											 ?>
											
													<input id="<?php echo 'd-'.$i;?>" class="accessories" type="checkbox" name="accessories_location[]" value="<?php echo '5#'.$row->location_id ;?>" onclick="return checkeddata()">   <?php echo $row->location ;?><br>
											<?php }?>
											</div>
							   </div>
							    <div class="form-group" id="new_car" style="display:none">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">New Car
                                            </label>
											<div class="col-md-9 col-sm-9 col-xs-12">
											<input  type="hidden" id="newCarCount" value="<?php echo count($select_new_car_location); ?>">
											<?php $i=0; foreach($select_new_car_location as $row) {
												$i++;
											?>
											
													<input id="<?php echo 'e-'.$i;?>" type="checkbox" class="new_car" name="new_car_location[]" value="<?php echo '6#'.$row->location_id ;?>" onclick="return checkeddata()">     <?php echo $row->location ;?><br>
											<?php }?>
											</div>
							   </div>
							     <div class="form-group" id="used_car" style="display:none">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">POC Sales
                                            </label>
											<div class="col-md-9 col-sm-9 col-xs-12">
											<input  type="hidden" id="usedCarCount" value="<?php echo count($select_used_car_location); ?>">
											<?php $i=0; foreach($select_used_car_location as $row) {
												$i++;
										 ?>
											
													<input id="<?php echo 'f-'.$i;?>" type="checkbox" class="used_car" name="used_car_location[]" value="<?php echo '7#'.$row->location_id ;?>" onclick="return checkeddata()">    <?php echo $row->location ;?><br>
											<?php }?>
											</div>
							   </div>
							    <div class="form-group" id="evaluation" style="display:none">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">POC Purchase
                                            </label>
											<div class="col-md-9 col-sm-9 col-xs-12">
											<input  type="hidden" id="evaluationCount" value="<?php echo count($select_evaluation_location); ?>">
											<?php $i=0; foreach($select_evaluation_location as $row) {
												$i++;
										 ?>
											
													<input id="<?php echo 'g-'.$i;?>" type="checkbox" class="evaluation" name="evaluation_location[]" value="<?php echo '8#'.$row->location_id ;?>" onclick="return checkeddata()">    <?php echo $row->location ;?><br>
											<?php }?>
											</div>
							   </div>
							      <div class="form-group" id="complaint" style="display:none">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Complaint
                                            </label>
											<div class="col-md-9 col-sm-9 col-xs-12">
											<input  type="hidden" id="complaintCount" value="<?php echo count($select_complaint_location); ?>">
											<?php $i=0; foreach($select_complaint_location as $row) {
												$i++;
										 ?>
											
													<input id="<?php echo 'h-'.$i;?>" type="checkbox" class="complaint" name="complaint_location[]" value="<?php echo '9#'.$row->location_id ;?>" onclick="return checkeddata()">    <?php echo $row->location ;?><br>
											<?php }?>
											</div>
							   </div>
							   <!-- Insurancecode -->
									<?php if ($row->process_id == 10) { ?>
										<div class="form-group" id="insurance" style="display:none">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Insurance
											</label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<input type="hidden" id="insuranceCount" value="<?php echo count($select_insurance_location); ?>">
												<?php $i = 0;
												foreach ($select_insurance_location as $row) {
													$i++;
												?>
													<input id="<?php echo 'e-' . $i; ?>" type="checkbox" class="insurance" name="insurance_location[]" value="<?php echo '6#' . $row->location_id; ?>" onclick="return checkeddata()"> <?php echo $row->location; ?><br>
												<?php } ?>
											</div>
										</div>
									<?php } ?>
									<!-- End Insurance -->
							   </div>
							
							<div class="col-md-6">
								  <div id="tl" class="form-group" style="display: none"></div>
                                    <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status:
                                            </label>
                                                  <div class="col-md-9 col-sm-9 col-xs-12">
                                                  <input type="radio" name="status" id="status" value="1" required> Active &nbsp;
                                                   <input type="radio" name="status" id="status" value="-1"> Deactive
                                            </div>
                                      </div>
                                       <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Cross Lead User:
                                            </label>
                                                  <div class="col-md-9 col-sm-9 col-xs-12" style="margin-top: 5px;">
                                                  <input id="cross_lead_user" type="checkbox" name="cross_lead_user"  value="1"> &nbsp;
                                           
                                            </div>
                                      </div>
							</div>
							  </div>
						
						</div>
							  
                    <div class="form-group col-md-12">
                     <div class="col-md-2 col-md-offset-4">
                    	
						
                    <button type="submit" id="checkBtn" class="btn btn-success col-md-12 col-xs-12 col-sm-12">Submit</button>
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
<?php } ?>
<script>
 $(document).ready(function() {
 	
    $(".Checked").click(function() {
        if (this.checked) {
		if(this.value=='1'){
			 document.getElementById("finance").style.display='block';
			 $( ".finance" ).prop( "disabled", false );
		}else if(this.value=='2'){
			 document.getElementById("insurance").style.display='block';
			  $( ".insurance" ).prop( "disabled", false );
		}else if(this.value=='4'){
			 document.getElementById("service").style.display='block';
			   $( ".service" ).prop( "disabled", false );
		}else if(this.value=='5'){
			 document.getElementById("accessories").style.display='block';
			  $( ".accessories" ).prop( "disabled", false );
		}else if(this.value=='6'){
			 document.getElementById("new_car").style.display='block';
			 $( ".new_car" ).prop( "disabled", false );
		}else if(this.value=='7'){
			 document.getElementById("used_car").style.display='block';
			  $( ".used_car" ).prop( "disabled", false );
		}		
         else if(this.value=='8'){
			 document.getElementById("evaluation").style.display='block';
			  $( ".evaluation" ).prop( "disabled", false );
		}
		 else if(this.value=='9'){
			 document.getElementById("complaint").style.display='block';
			  $( ".complaint" ).prop( "disabled", false );
		}
		  
			
		}else{
			if(this.value=='1'){
			 document.getElementById("finance").style.display='none';
			 $( ".finance" ).prop( "disabled", true );
			
		}else if(this.value=='2'){
			 document.getElementById("insurance").style.display='none';
			  $( ".insurance" ).prop( "disabled", true );
		}else if(this.value=='4'){
			 document.getElementById("service").style.display='none';
			   $( ".service" ).prop( "disabled", true );
		}else if(this.value=='5'){
			 document.getElementById("accessories").style.display='none';
			    $( ".accessories" ).prop( "disabled", true );
		}else if(this.value=='6'){
			 document.getElementById("new_car").style.display='none';
			   $( ".new_car" ).prop( "disabled", true );
		}else if(this.value=='7'){
			 document.getElementById("used_car").style.display='none';
			   $( ".used_car" ).prop( "disabled", true );
		}
		else if(this.value=='8'){
			 document.getElementById("evaluation").style.display='none';
			   $( ".evaluation" ).prop( "disabled", true );
		}		
		 else if(this.value=='9'){
			 document.getElementById("complaint").style.display='none';
			  $( ".complaint" ).prop( "disabled", true );
		}
		  	
		}
    });
});
function checkeddata(){
	 var location = new Array();
	
				//optionVal.push(checkedValue);
				var p=document.getElementById("processCount").value;
				
				for(var i=1; i<=p ;i++){
				
					
				if(document.getElementById('q-'+i).checked == true){
				
					if(document.getElementById("q-"+i).value == 1){
						
						var c=document.getElementById("financeCount").value;
						var s='a';
					}
					else if(document.getElementById("q-"+i).value == 4){
						var c=document.getElementById("serviceCount").value;
						var s='b';
					}
					else if(document.getElementById("q-"+i).value == 5){
						var c=document.getElementById("accessoriesCount").value;
						var s='d';
					}
					else if(document.getElementById("q-"+i).value == 6){
						var c=document.getElementById("newCarCount").value;
						var s='e';
					}
					else if(document.getElementById("q-"+i).value == 7){
						var c=document.getElementById("usedCarCount").value;
						var s='f';
					}
					else if(document.getElementById("q-"+i).value == 8){
						var c=document.getElementById("evaluationCount").value;
						var s='g';
					}
					else if(document.getElementById("q-"+i).value == 9){
						var c=document.getElementById("complaintCount").value;
						var s='h';
					}
						// Insurancecode
				else if (document.getElementById("q-" + i).value == 10) {
					var c = document.getElementById("insuranceCount").value;
					var s = 'i';
				}
				// End Insurancecode
				}
				}
		
				 for(var i=1;i<=c;i++)
				 {
				
				 	if(document.getElementById(s+'-'+i).checked == true)
					  {
					  	var a=document.getElementById(s+'-'+i).value;
					  		val1 = a.split("#");
					  		val3= val1[1];	
					  		location.push(val3);
					 
					  }
					 
				 }
				 var val=document.getElementById('role').value;
				if(val==''){
					alert('Please Select Role');
				}
				 	val1 = val.split("#");
				 	role= val1[0];	
				
				if(role == 3 || role == 4 || role == 12 || role == 8 || role == 10 || role == 14 || role == 16)
			{
		document.getElementById("tl").style.display='block';
		
		
	
		$.ajax({url: "<?php echo site_url();?>add_lms_user/get_tl_name",
		type:"POST",
		data:{role:role,location:location}, 
		success: function(result){
        $("#tl").html(result)
   } });
	}
	else{
		
		document.getElementById("tl").style.display='none';
		document.getElementById("tl_name").disabled =true;
		
	}
					  
}
</script>
<script>  
jQuery(document).ready(function(){
 $('#results').DataTable();});
</script>		
<script>
	$(document).ready(function() {
			if($("#example").width()>1308){
		var table = $('#example').DataTable({
			searching:false,
				scrollY : "400px",
				scrollX : true,
			scrollCollapse : true,

			fixedColumns : {
				leftColumns : 0,
				rightColumns : 0
			}
		});
		}else{
				var table = $('#example').DataTable({
				searching:false,
				scrollY : "400px",
				scrollX : false,
			scrollCollapse : true,

			fixedColumns : {
				leftColumns : 0,
				rightColumns : 0
			}
		});
				
			}
	}); 
</script>
<script><?php
$page = $this -> uri -> segment(4);
if (isset($page)) {
	$page = $page + 1;

} else {
	$page = 0;

}
$offset1 = 100 * $page;
//$query=$sql->result();
echo $c = count($select_table);
		?></script>
<div class="panel panel-primary">

			<div class="panel-body">
<div class="col-md-offset-8 col-md-4">
	<div class="form-group">
							
								<div class="col-md-7 col-xs-12">
									<input type="text"  placeholder="Search user"  autocomplete="off" class="form-control col-md-4 col-xs-12" id='userName'  required >
	</div>
<a class="btn btn-success col-md-2 col-xs-12"  onclick="searchuser()" ><i class="entypo-search"></i></a>
		<a class="btn btn-primary col-md-offset-1 col-md-2 col-xs-12" onclick='reset()' ><i class="entypo-ccw"></i></a>

	</div>
		
	</div>
	<br><br>		
		<div id="searchuserDiv">
	<div class="table-responsive"  style="overflow-x:auto;">
	<?php 
	 $modify=$_SESSION['modify'];
	 $delete=$_SESSION['delete'];  
	 $form_name=$_SESSION['form_name'];  
	 ?>
	<table id="example"  class="table " style="width:auto;" cellspacing="0">
				<thead> 
					<tr> 
							<th>Sr No.</th>
							<th> Emp Id</th>
							<th> Name</th>
							<th>Email Id</th>				
                            <th>Contact</th>		
							
						<th>Role</th>
							<th>TL Name</th>
							<th>Process</th>
							
							<th>Location</th>
							
							<th>Status</th>
							<?php if($modify[2]==1 || $delete[2]==1)  {?>
							<th>Action</th>
							<?php }?>
							
 </tr>
</thead> 


<tbody>


					 <?php 
					 $i=$offset1;
						foreach($select_table as $fetch) 
						{
							$i++;
						?>

						<tr>
						
						<td>	<?php echo $i;
									?> 		
							</td>
						
						
						<td>
							<?php echo $fetch ->empId;
							?>
							</td>
							<td>
							<?php echo $fetch ->fname.' '.$fetch->lname ;
							?>
							</td>
								
							<td>
							<?php echo $fetch ->email;
							?>
							</td>	
						
							<td>
							<?php echo $fetch ->mobileno;
							?>
							</td>
								<td>
							
							
							<?php echo $fetch ->role_name;
							
							?>
							
							
							</td>
									
								<td>
							<?php echo $fetch->tl_fname.' '.$fetch->tl_lname;
							?>
							</td>				
						
									
					
							<td>
							<?php echo $fetch->process_name;
							?>
							</td>			
										
							<td>
							<?php echo $fetch ->location;
							?>
							</td>	
									
						
							<td>
							
							
							<?php 
							
							if ($fetch->status == 1) {
											echo 'Active';
										} elseif ($fetch->status == 2) {
											echo 'View Only';

										} elseif($fetch->status==-1) {
											echo 'Deactive';
										} 
							
							
							?>
							
							
							</td>
												
					
                               
						
							
					   <?php if($modify[2]==1 || $delete[2]==1)  {
						    	
									?>
									
							
							<td>
								<?php if($modify[2]==1) {?>
								<a href="<?php echo site_url();?>add_lms_user/edit_user?id=<?php echo $fetch ->id;?>">Edit </a> &nbsp;&nbsp;
								<?php }   ?>
								
							</td>
							
							<?php 
								
							} ?>
							
						
						</tr>
						 <?php }?>
					</tbody>
 
 </table> 
 
<div class="col-md-12" style="margin-top: 20px;">
<div class="col-md-6" style="font-size: 14px">

   <?php echo 'Total Records :';
  // echo count($count_data);
   echo '<b>'.$total_record =count($count_data).'</b>';
			//foreach ($count_data as $booking) {echo '<b>'.$total_record = $booking -> lmscount.'</b>';
			//}
		?>
   &nbsp;&nbsp;
  
     <?php echo 'Total Pages :';
	 	 $pages = ceil((int)($total_record)/100);

	 	//echo $pages='10';
		$total_page = ceil((int)($pages));
		echo '<b>'.$total_page .'</b>';
/*if($_SESSION['role']=='1')
{
	echo "hi";
	 $total_record;
	 	echo  $k = ceil($total_record)/100;

echo $total_page = ceil($pages);	
}*/


 ?>
  
    </div>

<div class="col-md-6  form-group">
 
     
		
	<?php	
	
	if ($c < 100) {
	$last = $page - 2;
	if ($last != -2) {
		echo "<a class='col-md-push-1 col-md-2 btn btn-info'  href=" . site_url() . "Add_lms_user/paging_next/page/$last>
<i class='fa fa-angle-left'></i>   Previous   </a>";
		echo "<a class='col-md-pull-3 col-md-1  btn btn-info'  href=" . site_url() . "Add_lms_user/paging_next>First  
<i class='fa fa-angle-right'></i></a>";
		$last1 = $total_page - 2;
		echo "<a class=' col-md-push-5 col-md-1  btn btn-info' href=" . site_url() . "Add_lms_user/paging_next/page/$last1>Last  
<i class='fa fa-angle-right'></i></a>";
	}
} else if ($page == 0) {
	echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px;' href=" . site_url() . "Add_lms_user/paging_next/page/$page>Next  
<i class='fa fa-angle-right'></i></a>";
	echo "<a class=' col-md-1  btn btn-info'  href=" . site_url() . "Add_lms_user/paging_next>First  
<i class='fa fa-angle-right'></i></a>";
	$last1 = $total_page - 2;
	echo "<a class='  col-md-push-6 col-md-1  btn btn-info'  href=" . site_url() . "Add_lms_user/paging_next/page/$last1>Last  
<i class='fa fa-angle-right'></i></a>";
} else {
	$last = $page - 2;
	echo " <a class='col-md-push-2 col-md-2 btn btn-info'  href=" . site_url() . "Add_lms_user/paging_next/page/$last>
<i class='fa fa-angle-left'></i>   Previous   </a> ";
	echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px ;' href=" . site_url() . "Add_lms_user/paging_next/page/$page>Next  
<i class='fa fa-angle-right'></i></a>";

	echo "<a class='col-md-pull-3 col-md-1  btn btn-info' href=" . site_url() . "Add_lms_user/paging_next>First  
<i class='fa fa-angle-right'></i></a>";
	$last1 = $total_page - 2;
	echo "<a class='  col-md-push-6 col-md-1  btn btn-info'  href=" . site_url() . "Add_lms_user/paging_next/page/$last1>Last  
<i class='fa fa-angle-right'></i></a>";

}

$page1 = $page + 1;
		?>

       <label class="col-md-pull-1 col-md-2  control-label" style="margin-top: 7px;" >Page No</label>
         <input class="col-md-pull-1  col-md-1" type="text" value="<?php echo $page1?>" name="pageNo" id="pageNo" style="width: 56px;border-radius:4px;height: 35px">
         <input class="col-md-pull-1  col-md-1  btn btn-danger "  style="margin-left: 10px;" type="submit" value="Go" onclick="go_on_page();">
        </div>
        
        </div>
        </div>
        
        <script>
         							function go_on_page(){
         		var pageno= document.getElementById("pageNo").value;
				var total_page='<?php echo $total_page ?>';
				//alert(total_page);
         	//alert(pageno);
			if(pageno > total_page){
			alert('Please select page No. less than total page');
			return false;
			}
         		var pageno1=pageno-2;
         		window.location="<?php echo site_url(); ?>Add_lms_user/paging_next/page/"+pageno1;
         	
         	
         	}
         </script>
<script src="<?php echo base_url();?>assets/js/campaign.js"></script>

<script>	
	function searchuser()
	{
		var userName=document.getElementById("userName").value;		
		$.ajax(
			{
				url: "<?php echo site_url();?>add_lms_user/searchuser",
		type:"POST",
		data:{userName:userName}, 
		success: function(result){
        $("#searchuserDiv").html(result)
   } });
	}
	function reset()
	{
		window.location="<?php echo site_url('add_lms_user')?>";
	}
	
</script>

