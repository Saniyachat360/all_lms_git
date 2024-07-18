<script>	
	function show_product()
	{
		var process_id= document.getElementById("process_id").value;
		//alert(process_id);
		if(process_id=='1')
		{
				document.getElementById("loantypediv").style.display = "block";
		}
		else
		{
document.getElementById("loantypediv").style.display = "none";
		}
	}	
				
function select_lead_source()
{
	var process_id= document.getElementById("process_id").value;
	$.ajax({
				url:'<?php echo site_url('sign_up/lead_source')?>
				',
				type:'POST',
				data:{process_id:process_id},
				success:function(response)
				{$("#lead_sourceDiv").html(response);}
				});

				}				
			function select_sub_lead_source()
{
	var lead_source= document.getElementById("lead_source").value;
	var process_id= document.getElementById("process_id").value;
	$.ajax({
				url:'<?php echo site_url('sign_up/sub_lead_source')?>
				',
				type:'POST',
				data:{lead_source:lead_source,process_id:process_id},
				success:function(response)
				{$("#sub_lead_sourceDiv").html(response);}
				});

				}				
						
				
	function duplicate_conatct()
{
	//alert ("hi");
	
	var pnum= document.getElementById("pnum").value;
	
	if (pnum==''){
		
		alert('Please Enter Contact No.');
		
		return false;
	}
	else if (pnum.length!=10){
		
		alert ('Enter Valid Number');
		return false;
	}
	
	else{
		
		
		
		$.ajax({
				url:'<?php echo site_url('sign_up/select_contact')?>
				',
				type:'POST',
				data:{pnum:pnum},
				success:function(response)
				{$("#duplicate").html(response);}
				});
		
		
		
		//return true;
		
	}
		}	
		function dup_conatct(){
			alert('hi');
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
      
      <script type="text/javascript">
/*$(document).ready(function () {
    $('#checkBtn').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one checkbox.");
        return false;
      }

    });
});
*/
</script>
      
<div class="row" >
		<div class="col-md-12">
<?php echo $this -> session -> flashdata('message'); ?>
</div>
		 <?php /*$insert=$_SESSION['insert_cross_lead'];
				$rightElementValue=0;*/
	$headingElementValue="Add Cross Lead Details";
	
	?> 
	<div class="col-md-12" >
		
				<h1 style="text-align:center;"><?php echo $headingElementValue;?></h1>
		<div class="panel panel-primary">

			<div class="panel-body">
				<form name="submit" action="<?php echo $var;?>" method="post" onsubmit="return validate_form()" >

					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						
						<div class="col-md-12">
						
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" >Name: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
										
									<input type="text"  onkeypress="return alpha(event)"   placeholder="Enter Name" class="form-control" id="fname" name="fname">
								</div>
							</div>
							
						

					
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" >Contact No.: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<input type="text" onkeypress="return isNumberKey(event)" placeholder="Enter Moblie Number" onkeyup="return limitlength(this, 10)" class="form-control" id="pnum" name="pnum" required>
								</div>
								
							</div>
							
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" >Email: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									
									<input type="text" class="form-control" id="email1" name="email" placeholder="Enter Email ID" >
									

								</div>
							</div>
							
								<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" >Address:</label>
								<div class="col-md-5 col-sm-5 col-xs-12">
										<textarea name='address' class="form-control"></textarea>
									
								</div>
							</div>
							
								
							

						
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" >Product: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<select name="process_id" id="process_id" class="form-control" required
									 onchange="show_product()"><!--'-->										
										<option value="">Please Select </option>
										<?php 
										foreach($select_process as $row)
										{
											?>
											<option value="<?php echo $row->process_id;?>"><?php echo $row->process_name;?></option>
											<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group" id='loantypediv' style='display:none' >
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Loan Type:</label>
                                         	<div class="col-md-5 col-sm-5 col-xs-12">
                                              <select class="form-control" id="loan_type" name="loan_type" >
												<option value="">Please Select</option>		
												<option value="Preapproved">Preapproved</option>		
												<option value="Top up">Top up</option>		
												<option value="Refinance">Refinance</option>	
												<option value="BTTP">BTTP</option>	
												<option value="Sale Purchase">Sale Purchase</option>
												<option value="Home Loan">Home Loan</option>
                        <option value="Personal Loan">Personal Loan</option> 	
												<option value="New car loan">New car loan</option>	
                        <option value="Used car loan">Used car loan</option>  
                         
                        <option value="Loan against car">Loan against car</option>  
                        <option value="Loan against property">Loan against property</option> 	
											</select>		
										</div>
                                      </div>
							
						<!--	<div id='lead_sourceDiv'>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" >Lead Source: </label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<select name="lead_source" id="lead_source" class="form-control" required onchange='select_sub_lead_source()'>
										<option value="">Please Select </option>
										
										
										
									
									</select>
								</div>
							</div>
							</div>
							
							<div id='sub_lead_sourceDiv'>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" >Sub Lead Source: </label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<select name="lead_source" id="lead_source" class="form-control" >
										<option value="">Please Select </option>
										
										
										
									
									</select>
								</div>
							</div>
			
							</div>-->
		
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" >Comment: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<textarea name='comment'  class="form-control" ></textarea>
								</div>
							</div>

						</div>
						
						</div>


			
			
			
					
	</div>
					<div class="form-group col-md-12">
						<div class="col-md-2 col-md-offset-4">

							<button type="submit" id="checkBtn" class="btn btn-success col-md-12 col-xs-12 col-sm-12">
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
	
	<div id="duplicate">
         	
         	
         </div>  
	

                    
	
	<script src="<?php echo base_url();?>assets/js/campaign.js"></script>


