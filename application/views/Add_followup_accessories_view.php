<div class="container" style="width: 100%;">
	<div class="row">
		<h1 style="text-align:center;">Follow Details</h1> <br/>
                       <p style="text-align:center;"> Name: <b style="font-size: 15px;"><?php if(isset($lead_detail[0] -> name)){ echo $lead_detail[0] -> name; } ?></b></p>
                       <p style="text-align:center;">Contact: <b style="font-size: 15px;"><?php if(isset($lead_detail[0] -> contact_no)){ echo $lead_detail[0] -> contact_no; } ?></b></p>
 	 					<a id="sub" style="margin-top: -50px" class="pull-right" target="_blank" href="<?php echo site_url(); ?>website_leads/lms_details/<?php if(isset($lead_detail[0] -> enq_id)){ echo $lead_detail[0] -> enq_id; } ?>/<?php echo $enq; ?>">
						<i class="btn btn-info entypo-doc-text-inv">Customer Details</i>
						</a>
 	 <?php $insert=$_SESSION['insert'];
	 if($insert[52]==1){?>
 	 	<div class="panel panel-primary">
     		<div class="panel-body">
     			<form action="<?php echo site_url(); ?>add_followup_accessories/insert_followup" method="post">
					<input type="hidden" name="booking_id" id='enq_id' value="<?php if(isset($lead_detail[0] -> enq_id)){ echo $lead_detail[0] -> enq_id; } ?>">
                	<input type="hidden" name="phone" value="<?php if(isset($lead_detail[0] -> contact_no)){ echo $lead_detail[0] -> contact_no;} ?>">
						<input type="hidden" name="loc" value="<?php echo $enq; ?>">
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<!-- Basic Followup -->
                     	 <div class="panel panel-primary">
 							<div class="panel-body">
                         		<div class="col-md-6">
                         	   		 <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Email: </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                             			<input type="text"  placeholder="Enter Email"  name='email'  id="email" class="form-control" value="<?php if(isset($lead_detail[0] -> email)){  echo $lead_detail[0] -> email; } ?>"/>
                                           		 	</div>
                                       			</div>
                                      <div class="form-group">
                                    	<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">FeedBack Status: </label>
                                   		<div class="col-md-8 col-sm-8 col-xs-12">
                                        		<select name="feedbackstatus" id="feedback" class="form-control" required onchange='check_status(this.value);'>
                                					<option value="">Please Select</option>
                                					<?php foreach ($select_feedback_status as $row) {?>
                                						<option value="<?php echo $row->feedbackStatusName;?>"><?php echo $row->feedbackStatusName;?> </option>
														
													<?php } ?>
                                				</select>
                                          	</div>
                                    	</div>
                 						<div class="form-group" id="nextactiondiv">
                                    		<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Action: </label>
                                   			<div class="col-md-8 col-sm-8 col-xs-12">
                                            	<select name="nextAction" id="nextaction" class="form-control" required >
                                					<option value="">Please Select</option>
                                					<?php foreach ($select_nextaction as $row ) {?>
															<option value="<?php echo $row -> nextActionName; ?>"><?php echo $row -> nextActionName; ?></option>
												<?php	} ?>
 	                                			</select>
                                            </div>
                                         </div>
                                        <div class="form-group">
                      						<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Eagerness: </label>
                                       	<div class="col-md-8 col-sm-8 col-xs-12">
											<select class="form-control" id="eagerness" name="eagerness" required>
												<option value="">Please Select</option>		
												<option value="HOT">HOT</option>		
												<option value="WARM">WARM</option>		
												<option value="COLD">COLD</option>		
											</select>		
										</div>				
									</div>
								</div>
                               	<div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Address:</label>
                                         	<div class="col-md-8 col-sm-8 col-xs-12">
                                                <textarea placeholder="Enter Address" name='address' id="location" class="form-control" /><?php if(isset($lead_detail[0] -> address)){ echo $lead_detail[0] -> address; } ?></textarea>
                                         	</div>
                                      </div>
                        				<input type="hidden" value="<?php echo date("Y-m-d"); ?>" name="date"   class="form-control"  />
                                    	<div class="form-group" id='nfd'>
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Follow Up Date:</label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                	<input type="text"  placeholder="Enter Next Follow Up Date" id="datett" name='followupdate'  class="datett form-control" required readonly style="background:white; cursor:default;" />
                                           		</div>
                                            </div>
                                            <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Remark:</label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                		<textarea placeholder="Enter Remark" name='comment'  class="form-control" /></textarea>
                                           		 </div>
                                            </div>
                                     	</div>
                                     </div>
            						<div class="col-md-12">
            							

 	<input type="hidden" value="<?php if(isset( $select_accessories_list[0]->customer_id)){ echo $select_accessories_list[0]->customer_id ; }?>" name="customer_id" >
	<div class="col-md-12">
	 <label class="col-md-6 col-sm-12 col-xs-12">Accessoires List:</label>
             <a id="add" class="btn btn-success col-md-2 col-xs-2 col-sm-2 pull-right">Add</a>        
             </div>   
             <br>   <br><br>       
             <div class="col-md-12">           
<table class="table table-bordered datatable" id="results"> 
	<thead>
		<tr>
			<th>Sr No</th>
			<th>AccessoriesName</th>
			<th>Model</th>		
			<th>Quantity</th>
			<th>Price</th>
			<th>Date</th>					
			<th>Action</th>
		</tr>	
	</thead>
	<tbody class="detail">
	 <?php if(isset($select_accessories_list[0])){ ?>
		<?php $i=0; foreach($select_accessories_list as $row){ $i++;?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row -> accessories_name; ?></td>
			<td><?php echo $row -> model_name; ?></td>
			<td><?php echo $row -> qty ?></td>
			<td><?php echo $row -> price; ?></td>
			<td><?php echo $row -> created_date; ?></td>
			<td> <a href="<?php echo site_url();?>add_followup_accessories/delete_accessories/<?php echo  $row->purchase_id ?>/<?php echo  $enq_id ?>/<?php echo  $enq ?>">Delete</a></td>
			
		</tr>
		
		<?php } ?>
		<?php } ?>
	</tbody>
</table>
</div>     

</div>
  <!-- Transfer and send quotation -->
      
				<div class="panel panel-primary">
					<!--<h3 class="text-center">Transfer Lead</h3>-->
                	<div class="panel-body">
                		 <?php $insert= $_SESSION['insert'];
                        if($insert[51]==1)
						{
							if($lead_detail[0]->transfer_process!=''){?>
								<div class="col-md-6">                      		
                        	<div class="form-group">
  								 <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">	Lead Transferred To:&nbsp;&nbsp;&nbsp;     <?php echo  $lead_detail[0]->transfer_process; ?> </label>
                           </div>
                          </div>
							<?php  }else{ ?>
     					<div class="col-md-6">                      		
                        	<div class="form-group">
  								 <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">Click Here To Transfer Lead: </label>
                                 	<div class="col-md-5 col-sm-5 col-xs-12">
                                     	<label class="checkbox-inline "><input type="checkbox" id="transfer" name="transfer" onclick="transfer_lead()" >Yes</label>
                                     	</div>
                                    </div>  
                               </div>
                                    <?php } } ?>
                                    </div>
                                   </div>
   <!-- Transfer Div -->
				<div id="tassignto" style="display: none">
					<div class="panel panel-primary">		<h3 class="text-center">Transfer Lead</h3>
                	<div class="panel-body">		
                		<div class="col-md-12">			
                 <div class="col-md-6">
    		 			<div class="form-group">
    	                 <label class="control-label col-md-4 col-sm-4 col-xs-12" >Transfer Process:</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                	<select name="tprocess" id="tprocess" class="form-control" required disabled=true  onchange="select_transfer_location()">
                                      <option value="<?php echo $_SESSION['process_id']; ?>"><?php echo $_SESSION['process_name']; ?></option>
                     				<?php foreach($process as $fetch1){ ?>
												<option value="<?php echo $fetch1 -> process_id; ?>"><?php echo $fetch1 -> process_name; ?></option>
                     							 <?php } ?>
                       					</select>
                                   </div>
                             </div>
                         
                        </div>
             
                            <div id="tlocation_div" class="col-md-6" >
                            	
                             	<div class="form-group">
    	                 <label class="control-label col-md-4 col-sm-4 col-xs-12" >Transfer Location:</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                	<select name="tlocation" id="tlocation1" class="form-control" required disabled=true  onchange="select_assign_to()">
                                        <?php if($lead_detail[0]->location != ''){?>
												<option value=" <?php echo $lead_detail[0] -> location; ?>"> <?php echo $lead_detail[0] -> location; ?></option>
										<?php } else{ ?>
												<option value="">Please Select  </option>
										<?php } ?>
									<?php foreach($get_location1 as $fetch1){ ?>
												<option value="<?php echo $fetch1 -> location; ?>"><?php echo $fetch1 -> location; ?></option>
                     							 <?php } ?>
                       					</select>
                                   </div>
                             </div>
                               
                                 </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6" >
                                  <div id="assign_div">
                                 <div  class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Transfer To:</label>
                                        <div class="col-md-8 col-sm-8 col-xs-12" style="margin-top: -5px;">
                                           <select name="transfer_assign" id="tassignto1" class="form-control" required disabled=true>
                                         		<option value="">Please Select</option> 
											</select>
                                          </div>
                                      </div>
                               </div>
									</div>
									</div>
							</div>
						</div>
				 </div>
  <div class="form-group">
      <div class="col-md-2 col-md-offset-5">
          <button type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12">Submit</button>
     </div>
     <div class="col-md-2">
          <button type="reset" class="btn btn-primary col-md-12 col-xs-12 col-sm-12">Reset</button>
     </div>
    </div>
  </div>
</div>
</form>
    </div>
    </div>
  <?php } ?>
  </div>
  </div>
<?php if(isset($select_followup_lead))
{?>
<table class="table table-bordered datatable" id="results"> 
	<thead>
		<tr>
			<th>Follow Up By</th>
			<th>Call Date</th>		
			<th>N.F.D</th>
			<th>Feedback Status</th>
			<th>Next Action</th>					
			<th>Remark</th>	
		</tr>	
	</thead>
	<tbody>
		<?php foreach($select_followup_lead as $fetch){ ?>
		<tr>
			<td><?php echo $fetch -> fname . ' ' . $fetch -> lname; ?></td>
			<td><?php echo $fetch -> date; ?></td>
			<td><?php echo $fetch -> nextfollowupdate ?></td>
			<td><?php echo $fetch -> feedbackStatus; ?></td>
			<td><?php echo $fetch -> nextAction; ?></td>
			<td><?php echo $fetch -> comment; ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php } ?>
			
  
<script>
	window.onload= check_values();
function check_values()
{
	//Basic followup

	var email_old='<?php echo $lead_detail[0] -> email; ?>';
	var eagerness_old='<?php echo $lead_detail[0] -> eagerness; ?>';
var feedback='<?php echo $lead_detail[0] ->feedbackStatus; ?>';
var nextaction='<?php echo $lead_detail[0] ->nextAction; ?>';
		if(email_old == '')
		{

		document.getElementById("email").value = "";

		}else{
		document.getElementById("email").value = email_old;
		}
		if(eagerness_old == '')
		{

		document.getElementById("eagerness").value = "";

		}else{
		document.getElementById("eagerness").value = eagerness_old;
		}
		if(feedback == '')
		{

		document.getElementById("feedback").value = "";

		}else{
		document.getElementById("feedback").value = feedback;
		}
		if(nextaction == '')
		{

		document.getElementById("nextaction").value = "";

		}else{
		document.getElementById("nextaction").value = nextaction;
		}

		}
		function check_status (feedbackStatus) {
	
			$.ajax({
				url:"<?php echo site_url();?>add_followup_accessories/select_next_action",
				type:"POST",
				data:{feedbackStatus:feedbackStatus},
				success:function(reponse){
					  
					    $('#nextactiondiv').html(reponse);
				}				
			})
				}
</script>
		<script type="text/javascript">  
$(function()  
{  
$('#add').click(function()  
{  
addnewrow();  

});  
 $('body').delegate('.remove','click',function()  
{  
$(this).parent().parent().remove();  
}); 

});  

function addnewrow()   
{  
var n=($('.detail tr').length-0)+1;  
var tr = '<tr>'+  
'<td class="no">'+n+'</td>'+  
'<td><select class="form-control"  name="accessories_id[]" required><option value="">Please Select</option><?php foreach ($select_accessories as $row) {?><option value="<?php echo $row->accessories_id.'#'.$row->accessories_name;?>"><?php echo $row->accessories_name;?></option><?php } ?></select></td>'+  
'<td><select class="form-control"  name="model_id[]" required><option value="">Please Select</option><?php foreach ($select_model as $row) {?><option value="<?php echo $row->model_id;?>"><?php echo $row->model_name;?></option><?php } ?></select></td>'+  
'<td><select class="form-control"  name="quantity[]" required><option value="">Please Select</option><?php for($i=1;$i<=10;$i++){?><option value="<?php echo $i;?>"><?php echo $i;?> </option><?php } ?></select></td>'+  
'<td><input type="text" class="form-control quantity" name="price[]" onkeypress="return IsNumeric(event);" required></td>'+  
'<td><input type="text" class="form-control weight" name="date[]" value="<?php echo date('Y-m-d') ;?>"></td>'+  
'<td><a href="#" class="remove">Delete</td>'+  
'</tr>';  
$('.detail').append(tr);   
}  
</script>  
<script type="text/javascript">
        var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        function IsNumeric(e) {
           //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
     
               return false;
    }
        }
        	//Select user name using location
function select_transfer_location()
{
	var tprocess = document.getElementById("tprocess").value;
		$.ajax({
		url : '<?php echo site_url('add_followup_service/select_transfer_location'); ?>',
		type : 'POST',
		data : {'tprocess' : tprocess},
		success : function(result) {
			$("#tlocation_div").html(result);
		}
	});
}
//Select user name using location
function select_assign_to()
{
	var tlocation1 = document.getElementById("tlocation1").value;
	var tprocess = document.getElementById("tprocess").value;
	$.ajax({
		url : '<?php echo site_url('add_followup_service/select_assign_to'); ?>',
		type : 'POST',
		data : {'tlocation1' : tlocation1,'tprocess' : tprocess},
		success : function(result) {
		$("#assign_div").html(result);
	}
	});
}
			   //For Add Followup View
	//If click on transfer show and hide div
function transfer_lead() {
	if (document.getElementById('transfer').checked == true) {
		
		document.getElementById("tlocation1").disabled = false;
		document.getElementById("tassignto1").disabled = false;
		document.getElementById("tprocess").disabled = false;
		//document.getElementById("transfer_reason").disabled = false;
			$("#tlocation").show();
			$("#tassignto").show();
			$("#tprocess").show();
} else {
	document.getElementById("tlocation1").disabled = true;
	document.getElementById("tassignto1").disabled = true;
	document.getElementById("tprocess").disabled = true;
	//document.getElementById("transfer_reason").disabled = true;
			$("#tlocation").hide();
			$("#tassignto").hide();
			$("#tprocess").hide();
	}
}
    </script>         