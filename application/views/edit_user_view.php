

<script>
$( document ).ready(function() {
   showdiv();
});

$(document).ready(function () {
    $('#checkBtn').click(function() {
      checked = $(" input[class=Checked]:checked").length;
		
      if(!checked) {
        alert("You must check at least one Process .");
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
function showdiv(){
	var role='<?php echo $edit_user[0]->role ?>';
	var role_name='<?php echo $edit_user[0]->role_name ?>';
	 if(role == 4 || role == 14 || role == 8 || role == 10 || role == 12 || role == 16){
	
		document.getElementById("tl").style.display='block';
		
	}else{
	
		document.getElementById("tl").style.display='none';
	
	}
}

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

<script>
function goBack() {
    window.history.back();
}
</script>

     
<script>
function select_tl_name(val)
{
	val1 = val.split("#");
	role= val1[0];	
	if(role == 4 || role == 14 || role == 8 || role == 10 || role == 12 || role == 16)
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
function check_values()
{	var check_role='<?php echo $edit_user[0]->role;?>';
	
	var role='<?php echo $edit_user[0]->role.'#'.$edit_user[0]->role_name;?>';
		if(check_role == 3 || check_role == 4 || check_role == 14 || check_role == 8 || check_role == 10 || check_role == 12 || check_role == 16)
	
			{
				document.getElementById("tl").style.display='block';
	var tl_name='<?php echo $edit_user[0]->tl_id; ?>';
	if(tl_name == '')
			{
			  document.getElementById("tl_name").value = "";
	  
			}else{
				document.getElementById("tl_name").value = tl_name;
			}
	}

			if(role == '')
			{
			  document.getElementById("role").value = "";
	  
			}else{
				document.getElementById("role").value = role;
			}
		 if (document.getElementsByClassName("Checked").checked) {
		if(this.value=='1'){
			 document.getElementById("finance").style.display='block';
			
		}else if(this.value=='2'){
			 document.getElementById("insurance").style.display='block';
		}else if(this.value=='4'){
			 document.getElementById("service").style.display='block';
		}else if(this.value=='5'){
			 document.getElementById("accessories").style.display='block';
		}else if(this.value=='6'){
			 document.getElementById("new_car").style.display='block';
		}else if(this.value=='7'){
			 document.getElementById("used_car").style.display='block';
		}else if(this.value=='8'){
			 document.getElementById("evaluation").style.display='block';
		}		
           
			
		}else{
			if(this.value=='1'){
			 document.getElementById("finance").style.display='none';
			
		}else if(this.value=='2'){
			 document.getElementById("insurance").style.display='none';
		}else if(this.value=='4'){
			 document.getElementById("service").style.display='none';
		}else if(this.value=='5'){
			 document.getElementById("accessories").style.display='none';
		}else if(this.value=='6'){
			 document.getElementById("new_car").style.display='none';
		}else if(this.value=='7'){
			 document.getElementById("used_car").style.display='none';
		}else if(this.value=='8'){
			 document.getElementById("evaluation").style.display='none';
		}			
			
		}	
			
		
  
}
</script>
<script>
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
</script>

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
			//email.focus();
		}
		var no = /^\d{10}$/;

		if (no.test(phone1)) {
			//	return true;
		} else {
			alert("Phone Number must be 10 Digit!");

			return false;
			//phone.focus();
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
<!--<ol class="breadcrumb bc-3" >
	<li>
		<a href="dashboard.php"><i class="fa fa-home"></i>Home</a>
	</li>
	<li class="active">
		<strong>Add New LMS User</strong>
	</li>
</ol>-->
<body onload='check_values()'>
<div class="row" >
		   <h1 style="text-align:center; ">Edit LMS User</h1>
<div class="col-md-12" >

                <form name='submit'action="<?php echo $var1;?>" method="post" onsubmit="return validate_form()">
                
						
                     <div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
					  <div class="panel panel-primary">
   
     <div class="panel-body">
     	
					 		<div class="col-md-12"> 
					 
                         <div class="col-md-6">
                         	<div class="form-group">
                            	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Employee Id: </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                	
                                   <input type="text" required readonly class="form-control" value='<?php echo  $edit_user[0] ->empId;?>' id="empId" name="empId" >
                                     </div>
                          </div>
                             
                                                                 <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name: 
                                            </label>
                                                   <div class="col-md-9 col-sm-9 col-xs-12">
                                                  <input type="text" required  onkeypress="return alpha(event)" autocomplete="off" class="form-control"  value="<?php echo $edit_user[0] ->lname;?>"id="lname" name="lname">
                                            </div>
                                                               </div>
                          
   										  <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name" >Moblie Number:
                                            </label>
                                                  <div class="col-md-9 col-sm-9 col-xs-12">
                                                  <input type="text" onkeyup="return limitlength(this, 10)"  class="form-control" value="<?php echo $edit_user[0] ->mobileno;?>" id="pnum" name="pnum" required>
                                            </div>
                                      </div>
                                      
                                      
                                    
                                      
                                      
                                      
                             
                            
                            
                        
                         </div>
                         <div class="col-md-6">
                         	 <div class="form-group">
							  
					
						 <input type='hidden' name='id' value='<?php echo $edit_user[0] ->id;?>'>		  
							  
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name: 
                                            </label>
                                                   <div class="col-md-9 col-sm-9 col-xs-12">
                                                  <input type="text" required onkeypress="return alpha(event)" autocomplete="off" class="form-control" value="<?php echo $edit_user[0] ->fname;?>" id="fname" name="fname" >
                                            </div>
                                                               </div>
                        
                         <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email:
                                            </label>
                                                  <div class="col-md-9 col-sm-9 col-xs-12">
                                                     <input  type="text" autocomplete="off" class="form-control" value="<?php echo $edit_user[0] ->email;?>" id="email" name="email" >
                                                  
                                            </div>
                                      </div>
                                       <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Role:
                                            </label>
                                                  <div class="col-md-9 col-sm-9 col-xs-12">
                                                  <select name="role" id="role" class="form-control" onchange="return checkeddata()">
                 
                  
				
                 <option value="2#Manager">Manager</option>
                  	<option value="2#Auditor">Auditor</option>    
                 
              		 <option value="13#Finance TL">Finance TL</option>
               		 <option value="14#Finance Executive">Finance Executive</option>
               		
              		  <option value="11#Accessories TL">Accessories TL</option>
               		 <option value="12#Accessories Executive">Accessories Executive</option>
               		
               		 <option value="7#Service TL">Service TL</option>
               		 <option value="8#Service Excecutive">Service Excecutive</option>
               		<option value="15#Evaluation Team Leader">Evaluation Team Leader</option>
					<option value="16#Evaluation Executive">Evaluation Executive</option>
					<!-- Insurancecode -->
												<option value="17#Insurance">Insurance</option>
												<!-- End Insurancecode -->
               		 <option value="2#CSE Team Leader">CSE Team Leader</option>
               		 <option value="3#CSE">CSE</option>
               		 <option value="5#DSE Team Leader">DSE Team Leader</option>
               		 <option value="4#DSE">DSE</option>
               			
                   
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
											
													<input id="<?php echo 'q-'.$i;?>"  type="checkbox" name="process[]" class="Checked" value="<?php echo $row->process_id ;?>" <?php if(isset($edit_process )){ foreach($edit_process as $fetch){if($fetch->process_id == $row->process_id){ ?> checked <?php }} } ?>> <?php echo $row->process_name ;?><br>
											<?php }?>
											</div>
							   </div>
							 
					
							    	  <div class="form-group ">
				 					 <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Location:
                                            </label>
                                            </div>
								<?php $arry= array(); 
								foreach($edit_process as $row){
									array_push($arry,$row->process_id);
									} 
								if(in_array('1',$arry)){?>
										   <div class="form-group" id="finance">
								<?php }else{?>
								 <div class="form-group" id="finance" style="display:none">
								<?php } ?>
                                           	 <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Finance</label>
											<div class="col-md-9 col-sm-9 col-xs-12">
											
											
													<input  type="hidden" id="financeCount" value="<?php echo count($select_finance_location); ?>">
											<?php $i=0; 
											$id=$edit_user[0]->id;
											foreach($select_finance_location as $row) {
												$query_location=$this->db->query("select location_id from tbl_manager_process where user_id='$id' and process_id='1'")->result();
												
												$i++;
												?>
											
													<input id="<?php echo 'a-'.$i;?>" class="finance" type="checkbox" name="finance_location[]" value="<?php echo '1#'.$row->location_id ;?>" <?php foreach($query_location as $fetch){if($fetch->location_id==$row->location_id){ ?> checked <?php } }?> onclick="return checkeddata()"> <?php echo $row->location ;?><br>
											<?php }?>
											</div>
							   </div>
							   
							   <?php	if(in_array('4',$arry)){?>
							    <div class="form-group" id="service">
							   <?php } else{?>
								 <div class="form-group" id="service" style="display:none">
								<?php } ?>
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Service
                                            </label>     
											<div class="col-md-9 col-sm-9 col-xs-12">
										<input  type="hidden" id="serviceCount" value="<?php echo count($select_service_location); ?>">
											<?php $i=0; foreach($select_service_location as $row) {
												$i++;
												$query_location=$this->db->query("select location_id from tbl_manager_process where user_id='$id' and process_id='4'")->result();
												
												?>
											
													<input  id="<?php echo 'b-'.$i;?>" class="service" type="checkbox" name="service_location[]" value="<?php echo '4#'.$row->location_id ;?>" <?php foreach($query_location as $fetch){if($fetch->location_id==$row->location_id){ ?> checked <?php } }?> onclick="return checkeddata()"> <?php echo $row->location ;?><br>
											<?php }?>
											</div>
							   </div>
							   <?php	if(in_array('5',$arry)){?>
							   <div class="form-group" id="accessories" >
							   <?php } else { ?>
							    <div class="form-group" id="accessories" style="display:none">
							   <?php } ?>
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Accessories
                                            </label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<input  type="hidden" id="accessoriesCount" value="<?php echo count($select_accessories_location); ?>">
											<?php $i=0; foreach($select_accessories_location as $row) {
												$i++;
											$query_location=$this->db->query("select location_id from tbl_manager_process where user_id='$id' and process_id='5'")->result();
												
												?>
											
													<input id="<?php echo 'd-'.$i;?>"  class="accessories" type="checkbox" name="accessories_location[]" value="<?php echo '5#'.$row->location_id ;?>" <?php foreach($query_location as $fetch){if($fetch->location_id==$row->location_id){ ?> checked <?php } }?> onclick="return checkeddata()"> <?php echo $row->location ;?><br>
											<?php }?>
											</div>
							   </div>
							     <?php	if(in_array('6',$arry)){?>
							    <div class="form-group" id="new_car">
								 <?php }else{?>
								 <div class="form-group" id="new_car" style="display:none">
								 <?php } ?>
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">New Car
                                            </label>
											<div class="col-md-9 col-sm-9 col-xs-12">
										<input  type="hidden" id="newCarCount" value="<?php echo count($select_new_car_location); ?>">
											<?php $i=0; foreach($select_new_car_location as $row) {
												$i++;
											$query_location=$this->db->query("select location_id from tbl_manager_process where user_id='$id' and process_id='6'")->result();
												
												?>
											
													<input id="<?php echo 'e-'.$i;?>" type="checkbox" class="new_car" name="new_car_location[]" value="<?php echo '6#'.$row->location_id ;?>" <?php foreach($query_location as $fetch){if($fetch->location_id==$row->location_id){ ?> checked <?php } }?> onclick="return checkeddata()"> <?php echo $row->location ;?><br>
											<?php }?>
											</div>
							   </div>
							        <?php	if(in_array('7',$arry)){?>
							     <div class="form-group" id="used_car">
									<?php }else{ ?>  
									 <div class="form-group" id="used_car" style="display:none">
									<?php } ?>
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">POC Sales
                                            </label>
											<div class="col-md-9 col-sm-9 col-xs-12">
											<input  type="hidden" id="usedCarCount" value="<?php echo count($select_used_car_location); ?>">
											<?php $i=0; foreach($select_used_car_location as $row) {
												$i++;
										$query_location=$this->db->query("select location_id from tbl_manager_process where user_id='$id' and process_id='7'")->result();
												
												?>
											
													<input id="<?php echo 'f-'.$i;?>" type="checkbox" class="used_car" name="used_car_location[]" value="<?php echo '7#'.$row->location_id ;?>" <?php foreach($query_location as $fetch){if($fetch->location_id==$row->location_id){ ?> checked <?php } }?> onclick="return checkeddata()"> <?php echo $row->location ;?><br>
											<?php }?>
											</div>
							   </div>
							  
							  <?php	if(in_array('8',$arry)){?>
							     <div class="form-group" id="evaluation">
									<?php }else{ ?>  
									 <div class="form-group" id="evaluation" style="display:none">
									<?php } ?>
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">POC Purchase
                                            </label>
											<div class="col-md-9 col-sm-9 col-xs-12">
											<input  type="hidden" id="evaluationCount" value="<?php echo count($select_evaluation_location); ?>">
											<?php $i=0; foreach($select_evaluation_location as $row) {
												$i++;
										$query_location=$this->db->query("select location_id from tbl_manager_process where user_id='$id' and process_id='8'")->result();
												
												?>
											
													<input id="<?php echo 'g-'.$i;?>" type="checkbox" class="evaluation" name="evaluation_location[]" value="<?php echo '8#'.$row->location_id ;?>" <?php foreach($query_location as $fetch){if($fetch->location_id==$row->location_id){ ?> checked <?php } }?> onclick="return checkeddata()"> <?php echo $row->location ;?><br>
											<?php }?>
											</div>
							   </div>
							 
							     
							  <?php	if(in_array('9',$arry)){?>
							     <div class="form-group" id="evaluation">
									<?php }else{ ?>  
									 <div class="form-group" id="complaint" style="display:none">
									<?php } ?>
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Complaint
                                            </label>
											<div class="col-md-9 col-sm-9 col-xs-12">
											<input  type="hidden" id="complaintCount" value="<?php echo count($select_complaint_location); ?>">
											<?php $i=0; foreach($select_complaint_location as $row) {
												$i++;
										$query_location=$this->db->query("select location_id from tbl_manager_process where user_id='$id' and process_id='9'")->result();
												
												?>
											
													<input id="<?php echo 'h-'.$i;?>" type="checkbox" class="complaint" name="complaint_location[]" value="<?php echo '9#'.$row->location_id ;?>" <?php foreach($query_location as $fetch){if($fetch->location_id==$row->location_id){ ?> checked <?php } }?> onclick="return checkeddata()"> <?php echo $row->location ;?><br>
											<?php }?>
											</div>
							   </div>
							 
               </div>
                         <div class="col-md-6">
                          
                            <div class="form-group" id='tl'>
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Team Leader:
                                            </label>
                                                  <div class="col-md-9 col-sm-9 col-xs-12">
                                                                            <select name="tl_name" id="tl_name" class="form-control" >
 
                
                                                  	<?php foreach ($edit_dse as $row) {?>
                                                  	<option value='<?php echo $row->id;?>'><?php  echo $row->fname.' '.$row->lname;?></option>	
                                                 <?php } ?>
					
                    </select>
                                            </div>
                             </div>
                            
                          
               
                               <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status:
                                            </label>
                                                  <div class="col-md-9 col-sm-9 col-xs-12">
                                                  <input type="radio" name="status" id="status" <?php if($edit_user[0]->status==1)
												  {
												  	?>checked
												  	<?php
												  }?> value="1" required> Active &nbsp;
                                                   <input type="radio" name="status" id="status" <?php if($edit_user[0]->status=='-1')
												  {
												  	?>checked
												  	<?php
												  }?> value="-1"> Deactive
                                            </div>
                                      </div>
                                       <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Cross Lead User
                                            </label>
                                                  <div class="col-md-9 col-sm-9 col-xs-12" style="margin-top: 5px;">
                                                  <input id="cross_lead_user" type="checkbox" name="cross_lead_user" <?php if($edit_user[0]->cross_lead_user==1)
												  { echo 'Checked'; }?>  value="1"> &nbsp;
                                           
                                            </div>
                                      </div>
                                      </div>
									 </div>	
                                 <div class="col-md-12">
							   <div class="col-md-6">
				
                        
                         
                     
                    </div>
                    <div class="form-group col-md-12">
                     <div class="col-md-2 col-md-offset-4">
                    	
						<button type="submit" id="checkBtn" class="btn btn-success col-md-12 col-xs-12 col-sm-12">Update</button>
          
                         </div>
                       
                        <div class="col-md-2">
						
                            	<input type='text' class="btn btn-primary col-md-12 col-xs-12 col-sm-12" value='Cancel' onclick="goBack()">
                        
                        </div>
                    </div>
                   </div>
                  </div>
                </form>
			
            </div>
            

</div>
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
		
	}
					  
}
</script>
