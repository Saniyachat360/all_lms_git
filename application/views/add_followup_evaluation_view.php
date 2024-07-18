<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<style>
.ui-timepicker {
   
    text-align: left;
}
.ui-timepicker-container {
	z-index:10000;
}

</style>
<script>
$(document).ready(function() {
		//alert(new Date());
		$('#followupdate').daterangepicker({
			singleDatePicker : true,
			minDate : new Date(),
			format : 'YYYY-MM-DD',
			showDropdowns: true,
			calender_style : "picker_1",
		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});
	});
function check_appointment_details()
{

	var appointment_type = document.getElementById("appointment_type").value;
	
	if(appointment_type != '' )
	{
		document.getElementById("appointment_time").required=true;
		document.getElementById("appointment_date").required=true;
		document.getElementById("appointment_status").required=true;
	}
	else
	{
		 document.getElementById("appointment_time").value = "";
		 document.getElementById("appointment_time").value = "";
		document.getElementById("appointment_date").value = "";
		document.getElementById("appointment_status").value = "";
		
		document.getElementById("appointment_time").required=false;
		document.getElementById("appointment_date").required=false;
		document.getElementById("appointment_status").required=false;
	}
	
}
//Select model name usign make id
	function select_model() {
	var make = document.getElementById("make").value;
	$.ajax({
	url : '<?php echo site_url('add_followup_evaluation/select_model'); ?>',
		type : 'POST',
		data : {'make' : make,},
		success : function(result) {
		$("#model_div").html(result);
		}
		});
		}
		// Get Next Action from Feed back status
function select_feedback (val) {
  //alert(val);
  var feedback = val;
  $.ajax({
	url : '<?php echo site_url('add_followup_evaluation/select_next_action'); ?>',
	type : 'POST',
	data : {
	'feedback' : feedback,

	},
	success : function(result) {
	$("#nextactiondiv").html(result);
	}
	});
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



//Select user name using location
function select_assign_to()
{
	var tlocation1 = document.getElementById("tlocation1").value;
	var tprocess = document.getElementById("tprocess").value;
	$.ajax({
		url : '<?php echo site_url('add_followup_evaluation/select_assign_to'); ?>',
		type : 'POST',
		data : {'tlocation1' : tlocation1,'tprocess' : tprocess},
		success : function(result) {
		$("#tassign_div").css("display", "block");
		$("#assign_div").html(result);
	}
	});
}
</script>
<script>

//Select user name using location
function select_transfer_location()
{
	var ctprocess= document.getElementById("tprocess").value;
		var a =ctprocess.split("#");
	var tprocess= a[0];
		var tprocess_name= a[1];
	

//	var old_tprocess="<?php // echo $lead_detail[0]->transfer_process ?>";
	var old_dse_tl_id="<?php echo $lead_detail[0]->assign_to_e_tl; ?>";
	var lead_process="<?php echo $lead_detail[0]->process; ?>";
 <?php $user_id=$this->session->userdata('user_id');
 $check_user_process_transfer = $this->db->query("select p.process_id
									from lmsuser l 
									Left join tbl_manager_process mp on mp.user_id=l.id 
									Left join tbl_process p on p.process_id=mp.process_id
									where mp.user_id='$user_id'  group by p.process_id")->result(); 
								?>
						var cupt = new Array();
    <?php foreach($check_user_process_transfer as $row){ ?>
        cupt.push('<?php echo $row->process_id; ?>');
    <?php } ?>
				
						var cupt_count=cupt.length;
						for(var i=0;i<=cupt_count;i++){
							
					if(cupt[i] == tprocess){
								document.getElementById("lead_status1").disabled = true; 
		document.getElementById("lead_status2").disabled = true; 
			document.getElementById("lead_status").style.display ="none"; 
		document.getElementById("tlocation_div").style.display ='block'; 
		document.getElementById("tassign_div").style.display ='block'; 
		document.getElementById("tlocation1").disabled = false; 
		document.getElementById("tassignto1").disabled = false; 
			 break;
		
	}	else{
		document.getElementById("lead_status").style.display ='block'; 
				document.getElementById("lead_status1").disabled = false; 
		document.getElementById("lead_status2").disabled = false; 
	}	
						}
				
			
									
									
	
/*	if(old_tprocess == tprocess_name){
		alert("Lead already transfer Same Process");
		document.getElementById("tlocation1").disabled = true; 
		document.getElementById("tassignto1").disabled = true; 
		return false;
	}
	else */
	/*if(old_dse_tl_id!=0 && tprocess_name == lead_process){
		alert("Lead already transfer to DSE TL Showroom");
		document.getElementById("tlocation1").disabled = true; 
		document.getElementById("tassignto1").disabled = true; 
		
		return false;
	}else{
		document.getElementById("tlocation1").disabled = false; 
		document.getElementById("tassignto1").disabled = false; 
	*/
		$.ajax({
		url : '<?php echo site_url('add_followup_evaluation/select_transfer_location'); ?>',
		type : 'POST',
		data : {'tprocess' : tprocess},
		success : function(result) {
			$("#tassign_div").css("display", "none");
			$("#tlocation_div").html(result);
		
		}
	});
//	}
}
</script>
      <script>
	   //For Add Followup View
	//If click on transfer show and hide div
function transfer_lead() {

	if (document.getElementById('transfer').checked == true) {
		
		$("#tlocation").show();
			$("#tassignto").show();
			$("#tprocess").show();
		
		document.getElementById("tlocation1").disabled = false;
		document.getElementById("tassignto1").disabled = false;
		document.getElementById("tprocess").disabled = false;
	
		//document.getElementById("transfer_reason").disabled = false;
			
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

// show and hide nfd div
function check_nfd(val) {
var nextaction = document.getElementById("nextaction").value;
var nfdDiv = document.getElementById("nfd");
if(nextaction=='Close' || nextaction=='Booked From Autovista' || nextaction=='Lead Transfer')
{
		document.getElementById("followupdate").disabled = true; 
		document.getElementById("timet").disabled = true; 
		nfdDiv.style.display = "none";
}else{
		nfdDiv.style.display = "block";
		document.getElementById("timet").disabled = false; 
		document.getElementById("followupdate").disabled = false; 
		
	}
}

</script>
<script>  
//Show pervious data in text box
function check_values()
{
	//Basic followup
	var email_old='<?php echo $lead_detail[0]->email;?>';
	var alternate_contact='<?php echo $lead_detail[0]->alternate_contact_no;?>';
	var feedbackStatus='<?php echo $lead_detail[0]->feedbackStatus;?>';
	var nextAction='<?php echo $lead_detail[0]->nextAction;?>';

	var days60_booking='<?php echo $lead_detail[0]->days60_booking;?>';

	
	//Exchange Details
	var old_make='<?php echo $lead_detail[0]->old_make;?>';
	//var old_model='<?php echo $lead_detail[0]->old_model;?>';
	var ownership='<?php echo $lead_detail[0]->ownership;?>';
	var mfg='<?php echo $lead_detail[0]->manf_year;?>';
	var accidental_claim='<?php echo $lead_detail[0]->accidental_claim;?>';
	var km='<?php echo $lead_detail[0]->km;?>';
	var evaluation_within_days='<?php echo $lead_detail[0]->evaluation_within_days?>';
	var fuel_type='<?php echo $lead_detail[0]->fuel_type;?>';
	var color='<?php echo $lead_detail[0]->color;?>';
	var reg_no='<?php echo $lead_detail[0]->reg_no;?>';
	var quotated_price='<?php echo $lead_detail[0]->quotated_price;?>';
	var expected_price='<?php echo $lead_detail[0]->expected_price;?>';
	

 
	
	//Appointment Details
	var appointment_type='<?php echo $lead_detail[0]->appointment_type;?>';
	var appointment_status='<?php echo $lead_detail[0]->appointment_status;?>';
	var appointment_date='<?php echo $lead_detail[0]->appointment_date;?>';
	
	var appointment_time='<?php echo $lead_detail[0]->appointment_time;?>';
	
	 var hiddenDiv = document.getElementById("Test_Home");
	
	//Basic Details
	if(email_old == '')
			{
			
			  document.getElementById("email").value = "";
	  
			}else{
				document.getElementById("email").value = email_old;
			}
	if(alternate_contact==''){
		
		  document.getElementById("alternate_contact").value = "";
	  
			}else{
				document.getElementById("alternate_contact").value = alternate_contact;
	}
	if(feedbackStatus == '')
			{
			  document.getElementById("feedback").value = "";
	  
			}else{
				document.getElementById("feedback").value = feedbackStatus;
			}	
		if(nextAction == '')
			{
			  document.getElementById("nextaction").value = "";
	  
			}else{
				document.getElementById("nextaction").value = nextAction;
			}	
			
			
			
			
				 var nfdDiv = document.getElementById("nfd");
			
		if(nextAction=='Close' || nextAction=='Booked From Autovista' || nextAction=='Lead Transfer')
{
		document.getElementById("followupdate").disabled = true; 
		document.getElementById("timet").disabled = true; 
		nfdDiv.style.display = "none";
}else{
		nfdDiv.style.display = "block";
		document.getElementById("timet").disabled = false; 
		document.getElementById("followupdate").disabled = false; 
		
	}


	
	
	// Exchange Car 
	if(old_make=='' || old_make=='0'){
		 document.getElementById("make").value = "";
	  
	}else{
		 document.getElementById("make").value = old_make;
	  
	}
	
	if(ownership==''){
		 document.getElementById("ownership").value = "";
	  
	}else{
		 document.getElementById("ownership").value = ownership;
	  
	}
	if(mfg==''){
		 document.getElementById("mfg").value = "";
	  
	}else{
		 document.getElementById("mfg").value = mfg;
	  
	}
		if(accidental_claim==''){
		 document.getElementById("claim2").checked =true;
	  
	}else{
		 document.getElementById("claim1").checked = true;
	  
	}
		if(km==''){
		 document.getElementById("km").value = "";
	  
	}else{
		 document.getElementById("km").value = km;
	  
	}
	
	if(reg_no == '')
			{
			
			  document.getElementById("registration_no").value = "";
	  
			}else{
				document.getElementById("registration_no").value = reg_no;
			}
			if(quotated_price == '')
			{
			
			  document.getElementById("quotated_price").value = "";
	  
			}else{
				document.getElementById("quotated_price").value = quotated_price;
			}
	 	if(expected_price == '')
			{
			
			  document.getElementById("expected_price").value = "";
	  
			}else{
				document.getElementById("expected_price").value = expected_price;
			}
	if(evaluation_within_days == '')
			{
			
			  document.getElementById("evaluation_within_days").value = "";
	  
			}else{
				document.getElementById("evaluation_within_days").value = evaluation_within_days;
			}
			if(fuel_type == '')
			{
			
			  document.getElementById("fuel_type").value = "";
	  
			}else{
				document.getElementById("fuel_type").value = fuel_type;
			}
			if(color == '')
			{
			
			  document.getElementById("color").value = "";
	  
			}else{
				document.getElementById("color").value = color;
			}
	
	//Interested In


			<?php  if((isset($insert[82]) && $_SESSION['process_id']==8))
				  {
				  	if($insert[82]==1){ ?>
		// Appointment Type
	 	if(appointment_type == '')
			{
			  document.getElementById("appointment_type").value = "";
	  
			}else{
				document.getElementById("appointment_type").value = appointment_type;
			}
			if(appointment_status == '')
			{
			  document.getElementById("appointment_status").value = "";
	  
			}else{
				document.getElementById("appointment_status").value = appointment_status;
			}
			if(appointment_date == '')
			{
			  document.getElementById("appointment_date").value = "";
	  
			}else{
				document.getElementById("appointment_date").value = appointment_date;
			}
			
				if(appointment_time == '')
			{
			  document.getElementById("appointment_time").value = "";
	  
			}else{
				document.getElementById("appointment_time").value = appointment_time;
			}
				<?php }} ?>	
}
</script>
<style>
     			label {
    margin-top: 10px;
}
     		</style>
<body class="page-body" onload="check_values(); ">
<div class="container " style="width: 100%;">
	<div class="row">
		<div id="abc">
<?php $today = date('d-m-Y'); ?>
 <div class="panel panel-primary">
     	<div class="panel-body">
         <div class="col-md-3">
     				<h1>Follow Up Details</h1>   
     			</div>
                 	<div class="col-md-9">
     				<div class="col-md-6" >   
                     
                       <p><b style="font-size: 15px;"> Name:</b> <?php echo $lead_detail[0] -> name; ?></p>
                    	<?php if($lead_detail[0]->comment!=''){?>
     					<p><b style="font-size: 15px;">comment:</b><?php echo $lead_detail[0]->comment; ?> </p>
              				<?php } ?>
                    </div>
                    <div class="col-md-6" >   
                    <p class="col-md-6" > <b style="font-size: 15px;"> Contact:</b><?php echo $lead_detail[0] -> contact_no; ?></p>
 					<p class="col-md-6" >
 	 <a id="sub"  class="pull-right"  href="<?php echo site_url();?>website_leads/lms_details/<?php echo $lead_detail[0] -> enq_id; ?>/<?php echo $path;?>">
	
<i class="btn btn-info entypo-doc-text-inv">Lead Details</i>
</a>
</p>
</div>
</div>
</div>
</div>
<?php $insert=$_SESSION['insert'];
if($insert[72]==1){?>
	
 	 <div class="panel panel-primary">
     	<div class="panel-body">
     	
     		<form action="<?php echo $var; ?>" method="post">
                	<input type="hidden" name="booking_id" id='enq_id' value="<?php echo $lead_detail[0] -> enq_id; ?>">
                	<input type="hidden" name="phone" value="<?php echo $lead_detail[0]->contact_no;?>">
					<input type="hidden" name="loc" value="<?php echo $path; ?>">
						<input type="hidden" name="customer_name" id='customer_name' value="<?php echo $lead_detail[0] -> name; ?>">
					
					<input type="hidden" value="<?php echo date("Y-m-d"); ?>" name="date"   class="form-control" style="background:white; cursor:default;" />
					<div id="demo-form2" data-parsley-validate class="">
							<!-- Basic Followup -->
                     	 <div class="panel panel-primary">
 							<div class="panel-body">
                         	
                       <section>
                         		<div class="col-md-4">
                         	  	<div class="form-group">
                                                  <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Alternate Contact No:
                                            </label>
                                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input placeholder="Enter Contact Number" onkeypress="return isNumberKey(event)" onkeyup="return limitlength(this, 10)" name="alternate_contact" id="alternate_contact" class="form-control" type="text" tabindex="1">
                                            </div>
                                        </div>
                 					  <div class="form-group">
                                                  <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Email:
                                            </label>
                                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="text"  placeholder="Enter Email"  name='email'  id="email" class="form-control" tabindex="2"/>
                                            </div>
                                        </div>
						<div class="form-group">
                                                  <label class="control-label col-md-12 col-sm-12 col-xs-12" >Address:
                                            </label>
                                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                                  	<textarea placeholder="Enter Address" name='address' id="location" class="form-control" style="height: 30px;" tabindex="3"/><?php echo $lead_detail[0] -> address; ?></textarea>
                                          
                                            </div>
                                      </div>
                                  
                                      <div class="form-group">
                                                  <label class="control-label col-md-12 col-sm-12 col-xs-12" >Call Status:         </label>
                                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                                <select name="contactibility" id="contactibility" class="form-control" required tabindex="4" >
                                                <option value="">Please Select </option> 	
												<option value="Connected">Connected</option>
												<option value="Not Connected">Not Connected</option>
												
                                            </select>
                                            </div>
                                         </div>
                                         <div class="form-group">
                                           	<label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Booking within days:</label>
                                        	<div class="col-md-12 col-sm-12 col-xs-12">
                                            <select name="days60_booking" id="days60_booking" class="form-control" tabindex="9">
                                            		<option value="">Please Select</option>		
                                            	<option value="30">30 days</option>
                                            <option value="60">60 days</option>
                                              <option value="90">90 days</option>
                                    	 	     <option value="Undecided">Undecided</option>                                     	
                                            </select>
                                            </div>
                                      </div>
                                       
                                      <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Evaluation within days: </label>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                           <select name="evaluation_within_days" id="evaluation_within_days" class="form-control" tabindex="24"  >
                            
							<option value="">Please Select  </option>
							<option value="30">30 days</option>
                             <option value="60">60 days</option>
                              <option value="90">90 days</option>
                              <option value="Undecided">Undecided</option> 
                              <option value="immediate">immediate</option>      
                       	</select>
                     	</div>
                     </div>
                                           	<div class="col-md-6 col-md-offset-3" style="margin-top:10px">
									<a href="javascript:;" onclick="jQuery('#modal-6').modal('show', {backdrop: 'static'});" class="btn btn-success ">Add Escalation</a>
									       </div>
                                                             
                                           
                        	</div>
                        	<div class="col-md-4">
                        		<p class="text-center" style="font-size: 15px;"><b>Old Car Details</b></p>
                        	<div class="form-group">
                             <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name"> Car Make: </label>
                             	<div class="col-md-12 col-sm-12 col-xs-12">
                                	<select name="old_make" id="make" class="form-control" required  onchange="select_model();" tabindex="15">
										<option value="">Please Select</option>
										<?php  foreach($makes as $row){ ?>
										<option value="<?php echo $row -> make_id; ?>"><?php echo $row -> make_name; ?></option>
                     					<?php } ?>
                  						</select>
                                 </div>
                             </div>
                            
                           <div class="form-group"  id="model_div">
                               <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name"> Car Model:</label>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <select name="old_model" id="model" class="form-control" required  tabindex="16">
                                     <?php  if($lead_detail[0]->old_model !='' && $lead_detail[0]->old_model !='0')
                                       {
                                       	?>
                                       	<option value="<?php echo $lead_detail[0]-> old_model; ?>"><?php echo $lead_detail[0] -> old_model_name; ?></option>
                                       <?php
                                       }else
                                       {
                                       	?>
                                       	<option value="">Please Select  </option>
                                       	<?php
                                       }?>
								
                      			 </select>
                               </div>
                          	</div>
                    
                      <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Color: </label>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text"  placeholder="Enter Color" id="color" name='color' autocomplete="off" class="form-control"  tabindex="17" />
                          
                     	</div>
                     </div>
                      <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Fuel Type: </label>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                           <select name="fuel_type" id="fuel_type" class="form-control"  tabindex="18">
                            
							<option value="">Please Select  </option>
						
                     		<option value="Petrol">Petrol</option>
                       		<option value="Diesel">Diesel </option>
                       		<option value="CNG">CNG</option>
                        
                       	</select>
                     	</div>
                     </div>
                      <div class="form-group">
                         <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Registration No.: </label>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text"  placeholder="Enter registration Number" id="registration_no" name='registration_no' autocomplete="off" class="form-control"  tabindex="19" />
                          
						  </div>
                        </div>
                         <div class="form-group">
                                                  <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Remark:
                                            </label>
                                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                                <textarea placeholder="Enter Remark" name='comment'  class="form-control" required tabindex="14" /></textarea>
                                            </div>
                                                               </div>
                     </div>
                     <div class="col-md-4">
                
                       
                      <div class="form-group">
                         <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">KMS: </label>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text"  placeholder="Enter Km" id="km" name='km' onkeypress="return isNumberKey(event)" onkeyup="return limitlength(this, 10)" autocomplete="off" class="form-control" tabindex="20"  />
                          
						  </div>
                        </div>
                   
                
                     <div class="form-group">
                      <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Manufacturing Year: </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <select name="mfg" id="mfg" class="form-control" tabindex="21" >
                            
							<option value="">Please Select  </option>
								<?php 
									$year=date('Y');
									for ($i=$year;$i>1980;$i--){ ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?> </option>
								<?php } ?>
							</select>
                           </div>
                        </div>
                       
                                  <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Ownership: </label>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                           <select name="ownership" id="ownership" class="form-control" tabindex="22" >
                            
							<option value="">Please Select  </option>
						
                     		<option value="First">First</option>
                       		<option value="Second">Second</option>
                       		<option value="Third">Third</option>
                        	<option value="More Than Three">More Than Three</option>
                       	</select>
                     	</div>
                     </div>
                      <div class="form-group">
                        <label class="control-label col-md-6 col-sm-6 col-xs-12">Any Accidental Claim: </label>
                         <div class="col-md-6 col-sm-6  col-xs-12" style="margin-top: 10px;">                            
                     	 	<input type="radio" value="Yes" id="claim1" required="" name="claim"> Yes &nbsp;&nbsp;
							<input type="radio" value="No" id="claim2" required="" name="claim"> No<br>
                          </div>
                          
                        </div>
                           <div class="form-group">
                         <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Quoted Price: </label>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text"  placeholder="Enter Quotated Price" id="quotated_price" name='quotated_price' onkeypress="return isNumberKey(event)" onkeyup="return limitlength(this, 10)" autocomplete="off" class="form-control" tabindex="25"  />
                          
						  </div>
                        </div>
                        <div class="form-group">
                         <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Expected Price: </label>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text"  placeholder="Enter Expectations Price" id="expected_price" name='expected_price' onkeypress="return isNumberKey(event)" onkeyup="return limitlength(this, 10)" autocomplete="off" class="form-control" tabindex="26"  />
                          
						  </div>
                        </div>
                     
                   <div class="col-md-12" id="replace_additional"></div>
                
                        	</div>
                      </div>
                      </div>
                         <div class="panel panel-primary" >
     		<div class="panel-body">
     			<div class="col-md-4">
                     <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Feedback Status: </label>
                               <div class="col-md-12 col-sm-12 col-xs-12">
                                                <select name="feedback" id="feedback" class="form-control" required onchange="select_feedback(this.value);" tabindex="5">
                                                <option value="">Please Select </option> 	
                                            	<!--<option value="<?php echo $lead_detail[0] -> feedbackStatus; ?>"><?php echo $lead_detail[0] -> feedbackStatus; ?></option>
												--><?php foreach ($feedback_status as $row1) { ?>
												<option value="<?php echo $row1 -> feedbackStatusName; ?>"><?php echo $row1 -> feedbackStatusName; ?></option>
												<?php } ?>
                                            </select>
                                            </div>
                                         </div>
                                     
                                         <div id="nextactiondiv" class="form-group">
                                                  <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Next Action:
                                            </label>
                                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                                <select name="nextaction" id="nextaction" class="form-control"  onchange='check_nfd(this.value);' required  tabindex="6"> 
                                             <?php  if($lead_detail[0]->nextAction !='')
                                       {
                                       	?>
                                       	<option value="<?php echo $lead_detail[0]-> nextAction; ?>"><?php echo $lead_detail[0] -> nextAction; ?></option>
                                       <?php
                                       }else
                                       {
                                       	?>
                                       		<option value="">Please Select  </option>
                                       	<?php
                                       }?>
                                            	
                                            </select>
                                            </div>
                                          </div>
                         	
								<div  id='nfd' style="display:block">
                              <div class="form-group">
                                                  <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Next Follow Up Date & Time:
                                            </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text"  placeholder="Enter Next Follow Up Date" id="followupdate" autocomplete="off" name='followupdate'  class=" form-control" required  style=" cursor:default;" tabindex="7" />
                                           
                                            </div>
                                             <div class="col-md-6 col-sm-6 col-xs-10">
												  
												   <input class="form-control "  data-template="dropdown" id="timet" autocomplete="off" name="followuptime" placeholder="Enter Next Follow Up Time" type="text" tabindex="8"> 

												  
												
                                                               </div>      
                                                               </div>
                                       
										</div>	
										</div>
						
										<div class="col-md-4">
										
                               	   
											
				  			                        	<?php if((isset($insert[82]) && $_SESSION['process_id']==8))
				  { 
				  	if($insert[82] == '1') {?>
                                      <div class="form-group">
                         <label class="control-label col-md-12 col-sm-12 col-xs-12" >Appointment Type:</label>
                           <div class="col-md-12 col-sm-12 col-xs-12">
                              <select name="appointment_type" id="appointment_type" class="form-control" tabindex="10" onchange="check_appointment_details()">
										<option value="">Please Select  </option>
                      					<option value="Home Visit">Home Visit</option>
                      					<option value="Showroom Visit">Showroom Visit</option>
                      					<option value="Test Drive">Test Drive</option>
                      					<option value="Evaluation Allotted">Evaluation Allotted</option>
                   					</select>
                                   </div>
                               </div>
                                  
										  <div class="form-group">
                                                  <label class="control-label col-md-12 col-sm-12 col-xs-12" >Appointment Date & Time:
                                            </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text"  placeholder="Enter Appointment Date" id="appointment_date" name='appointment_date'  class="datett form-control" autocomplete="off"  style=" cursor:default;" tabindex="11" />
                                           
                                            </div>
                                             <div class="col-md-6 col-sm-6 col-xs-10">
												  <input class="form-control "  data-template="dropdown" id="appointment_time" name="appointment_time" autocomplete="off" placeholder="Enter Appointment Time" type="text" tabindex="12"> 
													</div>               
                                                               </div>
     										
									 <div class="form-group" >
                                  <label class="control-label col-md-12 col-sm-12 col-xs-12" >Appointment Status:</label>
                                     <div class="col-md-12 col-sm-12 col-xs-12">
                                       <select name="appointment_status" id="appointment_status" class="form-control"  tabindex="13">
                                        
                                       	<option value="">Please Select  </option>
										<option value="Conducted">Conducted</option>	
										<option value="Not Conducted">Not Conducted</option>
										</select>
                                     </div>
                                </div>
                                <?php } } ?>
                                    
                                      </div>
                                      				<div class="col-md-4"></div>
                                       </div>
                                 </div>
            
               <!-- Transfer and send quotation -->
      
				<div class="panel panel-primary">
					<!--<h3 class="text-center">Transfer Lead</h3>-->
                	<div class="panel-body">
                		 <?php $insert= $_SESSION['insert'];
                        if($insert[71]==1)
						{
							?>
								
							
     					<div class="col-md-4">                      		
                        	<div class="form-group">
  								 <label class="control-label col-md-10 col-sm-10 col-xs-12" for="first-name">Click Here To Transfer Lead: </label>
                                 	<div class="col-md-2 col-sm-2 col-xs-12">
                                     	<label class="checkbox-inline "><input type="checkbox" id="transfer" name="transfer" onclick="transfer_lead()" tabindex="27" >Yes</label>
                                     	</div>
                                    </div>  
                               </div>
                                    <?php  } ?>
                      <div class="col-md-8">
          <!-- Transfer Div -->
					
				<div id="tassignto" style="display: none">
	
									<div class="col-md-12">                      		
                        	<div class="form-group">
                        			<?php
                        	
                        		 if($lead_detail[0]->assign_to_e_tl!=0){
                        			?>
  								 <label  style="color:#FF0000;"  class="col-md-12">	Lead Already Transferred  To Evaluator TL  </label>
  									<?php  }?>		
                        		
  									<?php if($lead_detail[0]->transfer_process!='' ){?>
  							
                     				<label style="color:#FF0000;"  class="col-md-12"> Lead Transferred To	<?php  
                     				$transfer_process_data=json_decode($lead_detail[0]->transfer_process);
									for($i=0;$i<count($transfer_process_data);$i++){
										$tdata=$transfer_process_data[$i];
											 $query_data=$this->db->query("select process_name from tbl_process where process_id IN('$tdata')");
										
											foreach($query_data->result() as $row){
												echo $row->process_name;
											}
									}
										 ?>  </label>
                     				<?php }else{
                     					$transfer_process_data='';
                     			
  								 	  }?>		   
                           </div>
                          </div>
                 <div class="col-md-6">
    		 			<div class="form-group">
    	                 <label class="control-label col-md-12 col-sm-12 col-xs-12" >Transfer Process:</label>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                	<select name="tprocess" id="tprocess" class="form-control"  disabled=true  onchange="select_transfer_location()">
                                      <option value="">Please Select </option>
                     				<?php 
                     				if($lead_detail[0]->transfer_process!=''){
                     					 $transfer_process_data=json_decode($lead_detail[0]->transfer_process);
                     				}else{
                     					$transfer_process_data='';
                     				}
									 foreach($process as $fetch1)
                     				{
                     				    	if($transfer_process_data !=''){
                             					if(!in_array($fetch1 ->process_id, $transfer_process_data) && $fetch1->process_id !=9){ ?>
        												<option value="<?php echo $fetch1 ->process_id.'#'.$fetch1 ->process_name; ?>"><?php echo $fetch1 -> process_name; ?></option>
            									<?php 
            									 }
    									   }
    									 else
    									 {
        									 if($fetch1->process_id !=9){ ?>
        												<option value="<?php echo $fetch1 ->process_id.'#'.$fetch1 ->process_name; ?>"><?php echo $fetch1 -> process_name; ?></option>
        									<?php  }
    									 }
									 }?>
                       					</select>
                                   </div>
                             </div>
                         
                          <div id="tlocation_div"  >
                            	
                             	<div class="form-group">
    	                 <label class="control-label col-md-12 col-sm-12 col-xs-12" >Transfer Location:</label>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                	<select name="tlocation" id="tlocation1" class="form-control"  disabled=true  onchange="select_assign_to()">
                                        <?php /*if($lead_detail[0]->location != ''){?>
												<option value=" <?php echo $lead_detail[0] -> location; ?>"> <?php echo $lead_detail[0] -> location; ?></option>
										<?php } else{ */?>
												<option value="">Please Select  </option>
										<?php //} ?>
									<?php /*foreach($tlocation as $fetch1){ ?>
												<option value="<?php echo $fetch1 -> location; ?>"><?php echo $fetch1 -> location; ?></option>
                     							 <?php } */ ?>
                       					</select>
                                   </div>
                             </div>
                             
                               
                                 </div>
                             
             
                          
                              
                                   
									</div>
									<div class="col-md-6">
									
                                 <div  class="form-group" id="tassign_div"> 
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Transfer To:</label>
                                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -5px;" id="assign_div">
                                           <select name="transfer_assign" id="tassignto1" class="form-control"  disabled=true>
                                         		<option value="">Please Select</option> 
											</select>
                                          </div>
                                      </div>
                               
									
									
									
                                 <div  class="form-group" id="lead_status">
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Current Process Lead Status:</label>
                                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 5px;">
                                        	 <input type="radio" id="lead_status1" value="Close" name="lead_status"> Close &nbsp;&nbsp;
							<input type="radio" value="Continue" id="lead_status2" name="lead_status"> Continue<br>
         
                                          </div>
                                      </div>
                               </div>
									
						
									<br>
								
									
							</div>
						</div>
				 </div>
				 
				 
				 
				 
				 
           </div>
       
            <div class="form-group">
             	<div class="col-md-2 col-md-offset-5">
                  <button type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12" tabindex="28">Submit</button>
                 </div>
                 <div class="col-md-2">
                    <button type="reset" class="btn btn-primary col-md-12 col-xs-12 col-sm-12">Reset</button>
                 </div>
            </div>
            
             </form>
          </div>
       
      </div>
  </div>
    <?php } ?>
<?php if(count($select_followup_lead)>0)
{?>
	<div class="col-md-12 table-responsive" style="overflow-x: scroll;padding: 0px">
	<table class="table table-bordered datatable" id="results1"> 
	
					<thead>
						<tr>
							<th>Sr No</th>
						
							<th>Follow Up By</th>
							<th>Call Status</th>		
							<th>Call Date Time</th>
															
								<th>Feedback Status</th>
							<th>Next Action</th>	
						
							<th>N.F.D.T.</th>
							<th>Appointment Type</th>	
							<th>Appointment Date Time</th>	
							<th>Appointment Status </th>									
							<th>Remark</th>	
						<!--	<th>Escalation Type</th>
						<th>Escalation Remark</th>	-->							
						</tr>	
					</thead>
					<tbody>
						<?php
						$i=0;
						foreach($select_followup_lead as $row)
						{
							
							$i++;
						
						?>
						<tr>
						<td><?php echo $i ;?></td>
					
							<td><?php echo $row -> fname . ' ' . $row -> lname; ?></td>
							<td><?php echo $row -> contactibility; ?></td>
							<td><?php echo $row -> c_date.' '.$row -> created_time; ?></td>
							<td><?php echo  $row  -> feedbackStatus; ?></td>
							<td><?php echo   $row  -> nextAction; ?></td>	
							
							<td><?php echo $row -> nextfollowupdate .' '.$row -> nextfollowuptime ?></td>
								<td><?php echo $row -> appointment_type ?></td>
								<td><?php echo $row -> appointment_date.' '.$row -> appointment_time  ?></td>
								<td><?php echo $row -> appointment_status ?></td>
							<td><?php echo $row -> f_comment; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>		                   
				     </div>
				<?php }  ?>
				</div>
			</div> 
	 </div>
	<!-- Modal -->
			<div class="modal fade" id="modal-6">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3>Escalation Details</h3> </div>
            <div class="modal-body">
                <div class="row">
				
				 <div class="col-md-12" style="margin-top:20px">
											<div class="panel panel-primary">
						<div class="panel-body">
				 	
						<?php if(isset($lead_detail[0]->esc_level1)){
							 if($lead_detail[0]->esc_level1=='Yes' || $lead_detail[0]->esc_level2=='Yes' || $lead_detail[0]->esc_level3=='Yes'){ ?>
			<h4 style='text-align: center'>Escalation Done</h4>
							 <?php }else{ ?>
			<p style='text-align: center'>Escalation Not Done Yet </p>
						<?php } } ?>
						<div class="table-responsive" style="overflow-x:scroll">
					<table class="table ">
						
						<?php if(isset($lead_detail[0]->esc_level1)){
							 if($lead_detail[0]->esc_level1=='Yes'){ ?>
										<tr>
										<th>Escalation Level 1</th>
										<td><?php if(isset($lead_detail[0]->esc_level1)){ echo $lead_detail[0]->esc_level1_remark; } ?></td>
										</tr>
							 <?php } } ?>
							 <?php if(isset($lead_detail[0]->esc_level2)){
							 if($lead_detail[0]->esc_level2=='Yes'){ ?>
										<tr>
										<th>Escalation Level 2</th>
										<td><?php if(isset($lead_detail[0]->esc_level1)){ echo $lead_detail[0]->esc_level2_remark; } ?></td>
										</tr>
							 <?php } } ?>
							  <?php if(isset($lead_detail[0]->esc_level3)){
							 if($lead_detail[0]->esc_level3=='Yes'){ ?>
										<tr>
										<th>Escalation Level 3</th>
										<td><?php if(isset($lead_detail[0]->esc_level3)){ echo $lead_detail[0]->esc_level3_remark; } ?></td>
										
										</tr>
							  <?php } } ?>
										</table>
										</div>
										</div>
										
						<?php if((isset($insert[83]) && $_SESSION['process_id']==8))
				  {
				  	if($insert[83]==1){ ?>
												<p style='text-align: center'>Add Escalation </p>
												<br>
										<form action="<?php echo site_url();?>add_followup_evaluation/insert_escalation_detail" method="post">
                    <div class="col-md-6">
					
                       <input type="hidden" name="booking_id" value="<?php echo $lead_detail[0]->enq_id ?>">
					   <input type="hidden" name="path" value="<?php echo $path ;?>">
					   <div class="form-group">
                            <label for="field-1" class="control-label">Escalation Type</label>
                           <select name="escalation_type" id="escalation_type" class="form-control" required>
                                       
										<option value="">Please Select  </option>
                      					<option value="Escalation Level 1">Escalation Level 1</option>
                      					<option value="Escalation Level 2">Escalation Level 2</option>
                      					<option value="Escalation Level 3">Escalation Level 3</option>
                       					
                   					</select>
                                   </div>
                                   <div class="form-group" >
                                    <button type="submit" class="btn btn-info">Submit</button>           
                                </div>
                               </div>
                      <div class="col-md-6">
                           	 <div class="form-group" >
                                   <label for="field-1" class="control-label">Escalation Remark:</label>
                                      
                                                <textarea placeholder="Enter Remark" id='escalation_remark' name='escalation_remark'  class="form-control"  required /></textarea>
                                          
                                </div>
                             
						  </div>
						  </form>
						   <?php } } ?>
						  </div>
						  </div>
						 
                 
                  <div class="col-md-12" style="margin-top:20px">
                    		<div class="panel panel-primary">
						<div class="panel-body">
				 	
						<?php if(isset($lead_detail[0]->esc_level1_resolved)){
							 if($lead_detail[0]->esc_level1_resolved=='Yes' || $lead_detail[0]->esc_level2_resolved=='Yes' || $lead_detail[0]->esc_level3_resolved=='Yes'){ ?>
			<p style='text-align: center'>Resolved Escalation</p>
							 <?php }else{ ?>
			<h4> </h4>
						<?php } } ?>
						<div class="table-responsive" style="overflow-x:scroll">
					<table class="table ">
						
						<?php if(isset($lead_detail[0]->esc_level1_resolved)){
							 if($lead_detail[0]->esc_level1_resolved=='Yes'){ ?>
										<tr>
										<th>Escalation Level 1</th>
										<!--<td><?php if(isset($lead_detail[0]->esc_level1)){ echo $lead_detail[0]->esc_level1; } ?></td>-->
										<td><?php if(isset($lead_detail[0]->esc_level1_resolved)){ echo $lead_detail[0]->esc_level1_resolved_remark; } ?></td>
										</tr>
							 <?php } } ?>
							 <?php if(isset($lead_detail[0]->esc_level2_resolved)){
							 if($lead_detail[0]->esc_level2_resolved=='Yes'){ ?>
										<tr>
										<th>Escalation Level 2</th>
										<!--<td><?php if(isset($lead_detail[0]->esc_level2)){ echo $lead_detail[0]->esc_level2; } ?></td>-->
										<td><?php if(isset($lead_detail[0]->esc_level1_resolved)){ echo $lead_detail[0]->esc_level2_resolved_remark; } ?></td>
										</tr>
							 <?php } } ?>
							  <?php if(isset($lead_detail[0]->esc_level3_resolved)){
							 if($lead_detail[0]->esc_level3_resolved=='Yes'){ ?>
										<tr>
										<th>Escalation Level 3</th>
										<!--<td><?php if(isset($lead_detail[0]->esc_level3)){ echo $lead_detail[0]->esc_level3; } ?></td>-->
										<td><?php if(isset($lead_detail[0]->esc_level3_resolved)){ echo $lead_detail[0]->esc_level3_resolved_remark; } ?></td>
										
										</tr>
							  <?php } } ?>
										</table>
										</div>
										</div>
										
                    	 <?php if((isset($insert[84]) && $_SESSION['process_id']==8))
				  {
				  	if($insert[84]==1){ ?>
                    			<h4 style='text-align: center'>Resolve Escalation </h4>
                    			<br>
										<form action="<?php echo site_url();?>add_followup_evaluation/insert_escalation_resolve_detail" method="post">
                    <div class="col-md-6">
					
                       <input type="hidden" name="booking_id" value="<?php echo $lead_detail[0]->enq_id ?>">
					   <input type="hidden" name="path" value="<?php echo $path ;?>">
					   <div class="form-group">
                            <label for="field-1" class="control-label">Escalation Type</label>
                           <select name="resolved_escalation_type" id="resolved_escalation_type" class="form-control" required>
                                       
										<option value="">Please Select  </option>
                      					<option value="Escalation Level 1">Escalation Level 1</option>
                      					<option value="Escalation Level 2">Escalation Level 2</option>
                      					<option value="Escalation Level 3">Escalation Level 3</option>
                       					
                   					</select>
                                   </div>
                                   <div class="form-group" >
                                    <button type="submit" class="btn btn-info">Submit</button>           
                                </div>
                               </div>
                      <div class="col-md-6">
                           	 <div class="form-group" >
                                   <label for="field-1" class="control-label">Escalation Resolve Remark:</label>
                                      
                                                <textarea placeholder="Enter Remark" id='resolved_escalation_remark' name='resolved_escalation_remark'  class="form-control"  required /></textarea>
                                          
                                </div>
                             
						  </div>
						  </form>
						  <?php } } ?>
						   </div>
						    </div>
						    
                    </div>
                    
                </div>
				
                
               
                
           
            <div class="modal-footer">
               
				 <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
			
        </div>
    </div>
</div>			