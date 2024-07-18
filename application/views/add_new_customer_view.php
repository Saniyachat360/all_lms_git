<script>	
function select_cse()
{
	var location= document.getElementById("location1").value;
	var process_id= document.getElementById("process_id").value;
	$.ajax({
				url:'<?php echo site_url('add_new_customer/select_cse')?>
				',
				type:'POST',
				data:{location:location,process_id:process_id},
				success:function(response)
				{$("#csediv").html(response);}
				});

				}		
				
function select_lead_source()
{
	var process_id= document.getElementById("process_id").value;
	$.ajax({
				url:'<?php echo site_url('add_new_customer/lead_source')?>
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
				url:'<?php echo site_url('add_new_customer/sub_lead_source')?>
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
				url:'<?php echo site_url('add_new_customer/select_contact')?>
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
		 <?php $insert=$_SESSION['insert'];
		 $header_process_id=$_SESSION['process_id'];
		 $rightElementValue=0;
	$headingElementValue="Add New Customer Lead Details";
	if($header_process_id==9)
	{
		if(isset($insert[76]))
		{
			if($insert[76]==1)
			{
				$rightElementValue=1;
				$headingElementValue="Add New Customer Complaint Details";
			}
		} 
	}
	elseif(($insert[1]==1 && $header_process_id==6) || ($insert[22]==1 && $header_process_id==7) || ($insert[32]==1 && $header_process_id==1) || ($insert[40]==1 && $header_process_id==4) || ($insert[48]==1 && $header_process_id==5) || ($insert[68]==1 && $header_process_id==8))
	{
		$rightElementValue=1;
	}
	if($rightElementValue==1)
	{
	?> 
	<div class="col-md-12" >
		
				<h1 style="text-align:center;"><?php echo $headingElementValue;?></h1>
		<div class="panel panel-primary">

			<div class="panel-body">
				<form name="submit" action="<?php echo $var;?>" method="post" onsubmit="return validate_form()" >

					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						
						<div class="col-md-12">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" >Name: </label>
								<div class="col-md-9 col-sm-9 col-xs-12">
										
									<input type="text" required onkeypress="return alpha(event)"   placeholder="Enter Name" class="form-control" id="fname" name="fname">
								</div>
							</div>
							
						

					
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" >Contact No.: </label>
								<div class="col-md-7 col-sm-7 col-xs-12">
									<input type="text" onkeypress="return isNumberKey(event)" placeholder="Enter Moblie Number" onkeyup="return limitlength(this, 10)" class="form-control" id="pnum" name="pnum" required>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-12">
									<i class="btn btn-info  entypo-search" onclick="return duplicate_conatct()"></i>
								
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" >Email: </label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									
									<input type="text" class="form-control" id="email1" name="email" placeholder="Enter Email ID" >
									

								</div>
							</div>
							
								<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" >Address:</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
										<textarea name='address' class="form-control"></textarea>
									
								</div>
							</div>
							
								
							

						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" >Process: </label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<select name="process_id" id="process_id" class="form-control" required onchange='select_lead_source()'>
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
							<div id='lead_sourceDiv'>
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
						<?php $data_array=array('3','4','8','10','12','14','16');
											if(in_array($_SESSION['role'],$data_array)){}else{?>
											<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" >Location: </label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<select name="location1" id="location1" class="form-control" required onchange='select_cse()'>
										<option value="">Please Select </option>
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
							
							<?php } ?>
							</div>
							
							<div id='csediv'>
	<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" >Assign To: </label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<select name="assign" id="assign" class="form-control" required >
										
											<?php
											$data_array=array('3','4','8','10','12','14','16');
											if(in_array($_SESSION['role'],$data_array)){ 
											 ?>
													<option value="<?php echo $_SESSION['user_id'] ;?>"> <?php echo $_SESSION['username'] ;?> </option>
							                      
											<?php }else{								?>
											  <option value=""> Please Select </option>
											<?php } ?>
											
                
												
										</select>
									</div>
								</div>
								</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" >Comment: </label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<textarea name='comment'  class="form-control" ></textarea>
								</div>
							</div>

						</div>
						
						</div>


				<!--<div class="row">

					<div class="form-group">
						
								<label class="control-label col-md-2 col-sm-2 col-xs-12" >Group Name: </label>
						
								<div class="col-md-10 col-sm-10 col-xs-12" >
								
						
								

									<label class="checkbox-inline"><input type="checkbox" name="dept[]" value="New Car">New Car </label>
									<label class="checkbox-inline"><input type="checkbox" name="dept[]" value="Used Car" >Used Car </label>
									<!--<label class="checkbox-inline"><input type="checkbox" name="dept[]" value="Insurance">Insurance </label>
									<label class="checkbox-inline"><input type="checkbox" name="dept[]" value="Finance">Finance </label>
									<label class="checkbox-inline"><input type="checkbox" name="dept[]" value="Service">Service </label>
								--</div>
							</div>
					
				</div>-->
			
			
			
					
	</div>
	

	
					<div class="form-group">
						<div class="col-md-2 col-md-offset-4">

							<button type="submit" id="checkBtn" class="btn btn-success col-md-12 col-xs-12 col-sm-12">
								Submit
							</button>
						</div>

						<div class="col-md-2">
							<input type='reset' class="btn btn-primary col-md-12 col-xs-12 col-sm-12" value='Reset'>
						</div>
					</div>
						<?php $process_id=$this->session->userdata('process_id');?>
							<?php if($process_id == 1){?>
							<div class="col-md-2">
							<a href= "<?php echo site_url('Upload_xls/upload_excell'); ?>" id="checkBtn" class="btn btn-info col-md-12 col-xs-12 col-sm-12">
									Upload Excell
							</a>
							</div>
							<?php } ?>
				</form>
			</div>
		</div>
	</div>
	<?php } ?>
	</div>
	
	<div id="duplicate">
         	
         	
         </div>  
	
<?php
	$modify = $_SESSION['modify'];
	$delete = $_SESSION['delete'];
	$form_name = $_SESSION['form_name'];
	 ?>
	
<?php
	
	if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2)
	 {
		
			
		
	} 
	else
	 {
			
		?>	

                        <?php
		}
	
	
	?>	
	
                    
	
	<script src="<?php echo base_url();?>assets/js/campaign.js"></script>


