<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<link rel="stylesheet" href="https://demo.neontheme.com/assets/css/bootstrap.css" id="style-resource-4">
		<link rel="stylesheet" href="https://demo.neontheme.com/assets/css/neon-core.css" id="style-resource-5">
		<link rel="stylesheet" href="https://demo.neontheme.com/assets/css/neon-theme.css" id="style-resource-6">
		<link rel="stylesheet" href="https://demo.neontheme.com/assets/css/neon-forms.css" id="style-resource-7">
		<link rel="stylesheet" href="https://demo.neontheme.com/assets/css/custom.css" id="style-resource-8">
		<script src="https://demo.neontheme.com/assets/js/jquery-1.11.3.min.js"></script>
<style>
.ui-timepicker {
   
    text-align: left;
}
.ui-timepicker-container {
	z-index:10000;
}

</style>
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

// Get Next Action from Feed back status
function select_feedback (val) {
  //alert(val);
  var feedback = val;
  $.ajax({
	url : '<?php echo site_url('add_followup_new_car/select_next_action'); ?>',
	type : 'POST',
	data : {
	'feedback' : feedback,

	},
	success : function(result) {
	$("#nextactiondiv").html(result);
	}
	});
}
// Using next action show and hide div
function check_disp_name(val) {
var nextaction = document.getElementById("nextaction").value;
check_nfd(val);
 var hiddenDiv = document.getElementById("Test_Home");
 if(nextaction=='Home Visit' || nextaction=='Test Drive')
 {
		hiddenDiv.style.display = "block";
}else{
	
		hiddenDiv.style.display = "none";
	}
	
}
// show and hide nfd div
function check_nfd(val) {
var nextaction = document.getElementById("nextaction").value;
var nfdDiv = document.getElementById("nfd");
if(nextaction=='Close' || nextaction=='Booked From Autovista')
{
		document.getElementById("datett").disabled = true; 
		document.getElementById("timet").disabled = true; 
		nfdDiv.style.display = "none";
}else{
		nfdDiv.style.display = "block";
		document.getElementById("datett").disabled = false; 
		document.getElementById("timet").disabled = false; 
	}
}

//Select variant name using model 
function select_variant() {
var model = document.getElementById("new_model").value;
$.ajax({
	url : '<?php echo site_url('add_followup_new_car/select_variant'); ?>',
	type : 'POST',
	data : {
	'model' : model,
	},
	success : function(result) {
		$("#variant").html(result);
	}
	});
}
function send_brochure(){
	var model = document.getElementById("new_model").value;
	if(model == ''){
		alert("Please Select Model");
	}
/*$.ajax({
	url : '<?php echo site_url('add_followup_new_car/select_variant'); ?>',
	type : 'POST',
	data : {
	'model' : model,
	},
	success : function(result) {
		$("#variant").html(result);
	}
	});*/
}
//Select user name using location
function select_assign_to()
{
	var tlocation1 = document.getElementById("tlocation1").value;
	var tprocess = document.getElementById("tprocess").value;
	$.ajax({
		url : '<?php echo site_url('add_followup_new_car/select_assign_to'); ?>',
		type : 'POST',
		data : {'tlocation1' : tlocation1,'tprocess' : tprocess},
		success : function(result) {
		$("#assign_div").html(result);
	}
	});
}
//Select user name using location
function select_transfer_location()
{
	var tprocess = document.getElementById("tprocess").value;
		$.ajax({
		url : '<?php echo site_url('add_followup_new_car/select_transfer_location'); ?>',
		type : 'POST',
		data : {'tprocess' : tprocess},
		success : function(result) {
			$("#tlocation_div").html(result);
		}
	});
}
function select_model_name()
{
	var city = document.getElementById("qlocation").value;
	$.ajax({
		url : '<?php echo site_url('add_followup_new_car/select_model_name'); ?>',
		type : 'POST',
		data : {'city' : city,},
		success : function(result) {
			$("#model_name_div").html(result);
		}
	});
}
// For select Qutation description
function select_description()
{
	var model_name = document.getElementById("model_name").value;
	var city = document.getElementById("qlocation").value;
	$.ajax({
		url : '<?php echo site_url('add_followup_new_car/select_description'); ?>',
		type : 'POST',
		data : {'model_name' : model_name,'city' : city,},
		success : function(result) {
		$("#description_div").html(result);
		}
		});
		}

// For select Qutation description
function check_accessories()
{
	var model_name = document.getElementById("model_name").value;
	var city = document.getElementById("qlocation").value;
	var description = document.getElementById("description").value;
	$.ajax({
		url : '<?php echo site_url('add_followup_new_car/check_accessories'); ?>',
		type : 'POST',
		data : {'model_name' : model_name,'city' : city,'description' : description},
		success : function(result) {
		$("#checkprize_div").html(result);
		}
		});
		}
function insert_make_model()
{
	var make=document.getElementById("buy_make").value;
	var model=document.getElementById("buy_model").value;
	var enq_id=document.getElementById("enq_id").value;
	var buyer_type=document.getElementById("buyer_type").value;
	
		if(make=='')
	{
		alert("Please select make");
		return false;
	}
	if(model=='')
	{
		alert("Please select model");
		return false;
	}
	$.ajax({
		url : '<?php echo site_url('add_followup_new_car/insert_buy_car_data'); ?>',
		url : '<?php echo site_url('add_followup_new_car/insert_buy_car_data'); ?>',
	type : 'POST',
	data : {'make' : make,'model':model,'enq_id':enq_id,'buyer_type':buyer_type},
	success : function(result) {
	$("#replace_data").html(result);
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
function send_quotation() {
	
if (document.getElementById('quotation').checked == true) {
		document.getElementById("qlocation").disabled = false;
		document.getElementById("description").disabled = false;
		document.getElementById("model_name").disabled = false;
		
			$("#quotation1").show();
} else {
	document.getElementById("qlocation").disabled = true;
	document.getElementById("description").disabled = true;
	document.getElementById("model_name").disabled = true;
		
			$("#quotation1").hide();
	}
		
	}
	
	function showDiv()
	{
		if(document.getElementById('interested_in_finance').value == 'Yes') {
			document.getElementById('financeDiv').style.display = "block";
		}
		else
		{
			document.getElementById('financeDiv').style.display = "none";
		}
	}
  
//Show pervious data in text box
function check_values()
{
	
	//Basic followup

	var email_old='<?php echo $lead_detail[0]->email;?>';
	var feedbackStatus='<?php echo $lead_detail[0]->feedbackStatus;?>';
	//alert(feedbackStatus);
	var nextAction='<?php echo $lead_detail[0]->nextAction;?>';
	var tdhvdate='<?php echo $lead_detail[0]->td_hv_date;?>';
	//alert(tdhvdate);
	var new_model_old='<?php echo $lead_detail[0]->new_model_id;?>';
	var new_variant_old='<?php echo $lead_detail[0]->variant_id;?>';
	var days60_booking='<?php echo $lead_detail[0]->days60_booking;?>';
	var appointment_type='<?php echo $lead_detail[0]->appointment_type;?>';
	var appointment_status='<?php echo $lead_detail[0]->appointment_status;?>';
	var appointment_date='<?php echo $lead_detail[0]->appointment_date;?>';
	var appointment_rating='<?php echo $lead_detail[0]->appointment_rating;?>';
	var appointment_time='<?php echo $lead_detail[0]->appointment_time;?>';
	var appointment_feedback='<?php echo $lead_detail[0]->appointment_feedback;?>';
	var appointment_address='<?php echo $lead_detail[0]->appointment_address;?>';
	var interested_in_finance='<?php echo $lead_detail[0]->interested_in_finance;?>';
	var interested_in_accessories='<?php echo $lead_detail[0]->interested_in_accessories;?>';
	var interested_in_insurance='<?php echo $lead_detail[0]->interested_in_insurance;?>';
	var interested_in_ew='<?php echo $lead_detail[0]->interested_in_ew;?>';
	var customer_occupation='<?php echo $lead_detail[0]->customer_occupation;?>';
	var customer_designation='<?php echo $lead_detail[0]->customer_designation;?>';
	var customer_corporate_name='<?php echo $lead_detail[0]->customer_corporate_name;?>';
	var alternate_contact='<?php echo $lead_detail[0]->alternate_contact_no;?>';
	 var hiddenDiv = document.getElementById("Test_Home");
	// alert(appointment_type);
	if(alternate_contact==''){
		
		  document.getElementById("alternate_contact").value = "";
	  
			}else{
				document.getElementById("alternate_contact").value = alternate_contact;
	}
	if(interested_in_finance == '')
	{
			  document.getElementById("interested_in_finance").value = "";
	  
			}else{
				document.getElementById("interested_in_finance").value = interested_in_finance;
				if(document.getElementById("interested_in_finance").value=='Yes')
				{
					document.getElementById('financeDiv').style.display = "block";
					if(customer_occupation == '')
					{
					 	document.getElementById("customer_occupation").value = "";
					  
					}else{
							document.getElementById("customer_occupation").value = customer_occupation;
					}
					if(customer_corporate_name == '')
					{
					 	document.getElementById("customer_corporate_name").value = "";
					  
					}else{
							document.getElementById("customer_corporate_name").value = customer_corporate_name;
					}
					if(customer_designation == '')
					{
					 	document.getElementById("customer_designation").value = "";
					  
					}else{
							document.getElementById("customer_designation").value = customer_designation;
					}
				}
	}
	if(interested_in_accessories == '')
	{
	 	document.getElementById("interested_in_accessories").value = "";
	  
			}else{
				document.getElementById("interested_in_accessories").value = interested_in_accessories;
			}
		if(interested_in_insurance == '')
			{
			  document.getElementById("interested_in_insurance").value = "";
	  
			}else{
				document.getElementById("interested_in_insurance").value = interested_in_insurance;
			}
		if(interested_in_ew == '')
			{
			  document.getElementById("interested_in_ew").value = "";
	  
			}else{
				document.getElementById("interested_in_ew").value = interested_in_ew;
			}
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
			/*	if(appointment_rating == '')
			{
			  document.getElementById("appointment_rating").value = "";
	  
			}else{
				document.getElementById("appointment_rating").value = appointment_rating;
			}*/
				if(appointment_time == '')
			{
			  document.getElementById("appointment_time").value = "";
	  
			}else{
				document.getElementById("appointment_time").value = appointment_time;
			}
			/*if(appointment_feedback == '')
			{
			  document.getElementById("appointment_feedback").value = "";
	  
			}else{
				document.getElementById("appointment_feedback").value = appointment_feedback;
			}
			if(appointment_address == '')
			{
			  document.getElementById("appointment_address").value = "";
	  
			}else{
				document.getElementById("appointment_address").value = appointment_address;
			}
			*/
			if(days60_booking == '')
			{
			  document.getElementById("days60_booking").value = "";
	  
			}else{
				document.getElementById("days60_booking").value = days60_booking;
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
			if(email_old == '')
			{
			
			  document.getElementById("email").value = "";
	  
			}else{
				document.getElementById("email").value = email_old;
			}
			
			
			if(new_model_old == '' || new_model_old == 0)
			{
			
			  document.getElementById("new_model").value = "";
	  
			}
			else
			{
				document.getElementById("new_model").value = new_model_old;
			}
			
				 var nfdDiv = document.getElementById("nfd");
			
			if(nextAction=='Close' || nextAction=='Booked From Autovista'){
			
		
					
					document.getElementById("datett").disabled = true; 
					document.getElementById("timet").disabled = true; 
					nfdDiv.style.display = "none";
			}else{
		
				nfdDiv.style.display = "block";
				 document.getElementById("datett").disabled = false; 
				document.getElementById("timet").disabled = false; 
			}
			
			
						
						
}
</script>
<body class="page-body" onload="check_values();">
<div class="container " style="width: 100%;">
	<div class="row">
		<div id="abc">
<?php $today = date('d-m-Y'); ?>
                       <h1 style="text-align:center;">Follow Up Details</h1>
                        
                       <br/>
                       <div style="margin-bottom: 40px;">
                       <div class="col-md-3"></div>
                       <div class="col-md-3" style="text-align:center;"> Name: <b style="font-size: 15px;"><?php echo $lead_detail[0] -> name; ?></b></div>
                       <div class="col-md-3" style="text-align:center;">Contact: <b style="font-size: 15px;"><?php echo $lead_detail[0] -> contact_no; ?></b></div>
 					<div class="col-md-3"></div>
 					</div>
 	 <a id="sub" style="margin-top: -50px" class="pull-right"  href="<?php echo site_url();?>website_leads/lms_details/<?php echo $lead_detail[0] -> enq_id; ?>/<?php echo $path;?>">
	
<i class="btn btn-info entypo-doc-text-inv">Customer Details</i>
</a>
<?php $insert=$_SESSION['insert'];
if($insert[9]==1){?>
 	 <div class="panel panel-primary">
     	<div class="panel-body">
     		<form action="<?php echo $var; ?>" method="post">
                	<input type="hidden" name="booking_id" id='enq_id' value="<?php echo $lead_detail[0] -> enq_id; ?>">
                	<input type="hidden" name="phone" value="<?php echo $lead_detail[0]->contact_no;?>">
					<input type="hidden" name="loc" value="<?php echo $path; ?>">
						<input type="hidden" name="customer_name" id='customer_name' value="<?php echo $lead_detail[0] -> name; ?>">
					
					<input type="hidden" value="<?php echo date("Y-m-d"); ?>" name="date"   class="form-control" style="background:white; cursor:default;" />
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<!-- Basic Followup -->
                     	  <div class="panel panel-primary">
 							<div class="panel-body">
                         		<div class="col-md-6">
                         	   	<div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Alternate Contact No:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <input placeholder="Enter Contact Number" onkeypress="return isNumberKey(event)" onkeyup="return limitlength(this, 10)" name="alternate_contact" id="alternate_contact" class="form-control" type="text">
                                            </div>
                                        </div>
                                      
										
                                          <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" >Call Status:         </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <select name="contactibility" id="contactibility" class="form-control" required >
                                                <option value="">Please Select </option> 	
												<option value="Connected">Connected</option>
												<option value="Not Connected">Not Connected</option>
												
                                            </select>
                                            </div>
											
                                         </div>
                                         <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Feedback Status:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <select name="feedback" id="feedback" class="form-control" required onchange="select_feedback(this.value);">
                                                <option value="">Please Select </option> 	
                                            	<!--<option value="<?php echo $lead_detail[0] -> feedbackStatus; ?>"><?php echo $lead_detail[0] -> feedbackStatus; ?></option>
												--><?php foreach ($feedback_status as $row1) { ?>
												<option value="<?php echo $row1 -> feedbackStatusName; ?>"><?php echo $row1 -> feedbackStatusName; ?></option>
												<?php } ?>
                                            </select>
                                            </div>
                                         </div>
                                     
                                         <div id="nextactiondiv" class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Action:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <select name="nextaction" id="nextaction" class="form-control"  onchange='check_disp_name(this.value);' required >
                                            	<?php if(isset($lead_detail[0] -> nextAction)){if($lead_detail[0] -> nextAction==''){?>
												<option value="">Please Select </option>
												<?php } else{ ?>
                                            	<option value="<?php echo $lead_detail[0] -> nextAction; ?>"><?php echo $lead_detail[0] -> nextAction; ?></option>
												<?php } }else{?>
												<option value="">Please Select </option>
												<?php } ?> 
												
                                            	
                                            </select>
                                            </div>
                                          </div>
                                      	<div class="form-group">
                                           	<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Booking within days:</label>
                                        	<div class="col-md-8 col-sm-8 col-xs-12">
                                            <select name="days60_booking" id="days60_booking" class="form-control" >
                                            		<option value="">Please Select</option>		
                                            	<option value="30">30 days</option>
                                            <option value="60">60 days</option>
                                              <option value="90">90 days</option>
                                    	 	     <option value="Undecided">Undecided</option> 
                                    	 	      <option value="Just Researching">Just Researching</option>  
                                    	 	      <option value="immediate">immediate</option>                                    	
                                            </select>
                                            </div>
                                      </div>
                        	<div class="form-group">
                                           	<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Escalation:</label>
                                        	<div class="col-md-8 col-sm-8 col-xs-12">
										<table class="table datatable">
										<tr>
										<th>Escalation Level 1</th>
										<td><?php if(isset($lead_detail[0]->esc_level1)){ echo $lead_detail[0]->esc_level1; } ?></td>
										<td><?php if(isset($lead_detail[0]->esc_level1)){ echo $lead_detail[0]->esc_level1_remark; } ?></td>
										</tr>
										<tr>
										<th>Escalation Level 2</th>
										<td><?php if(isset($lead_detail[0]->esc_level2)){ echo $lead_detail[0]->esc_level2; } ?></td>
										<td><?php if(isset($lead_detail[0]->esc_level1)){ echo $lead_detail[0]->esc_level2_remark; } ?></td>
										</tr>
										<tr>
										<th>Escalation Level 3</th>
										<td><?php if(isset($lead_detail[0]->esc_level3)){ echo $lead_detail[0]->esc_level3; } ?></td>
										<td><?php if(isset($lead_detail[0]->esc_level1)){ echo $lead_detail[0]->esc_level3_remark; } ?></td>
										
										</tr>
										</table>
										
                      					<a class="btn btn-success col-md-12 col-xs-12 col-sm-12" data-toggle="modal" data-target="#esculation_modal" >Add Escalation</a>
									
									
									
									
									<a href="javascript:;" onclick="jQuery('#modal-7').modal('show', {backdrop: 'static'});" class="btn btn-default">Show Me</a>
									
									
									
									
									
									
									
									
									
									
                                            </div>
                                      </div>
                         </div>
                         <div class="col-md-6">
                         	  <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Email:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text"  placeholder="Enter Email"  name='email'  id="email" class="form-control"/>
                                            </div>
                                        </div>
						<div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" >Address:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                  	<textarea placeholder="Enter Address" name='address' id="location" class="form-control" /><?php echo $lead_detail[0] -> address; ?></textarea>
                                          
                                            </div>
                                      </div>
					
              
                                      <?php $nextAction=$lead_detail[0]->nextAction;
                                     /* 
                                      if($nextAction=='Home Visit' || $nextAction=='Test Drive'){
                                      ?>
                                      
               <div class="form-group" id='Test_Home'  style="display:block">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">TD/HV Date:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text" value="<?php echo $lead_detail[0]->td_hv_date;?>" placeholder="Enter Test Drive / Home Visit Date" id="datett" name='td_hv_date'  class="datett form-control" required readonly style="background:white; cursor:default;" />
                                           
                                            </div>
                                                               </div>
                                                               <?php } else{?>
                                       <div class="form-group" id='Test_Home'  style="display:none">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">TD/HV Date:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text"  placeholder="Enter Test Drive / Home Visit Date" id="datett" name='td_hv_date'  class="datett form-control" required readonly style="background:white; cursor:default;" />
                                           
                                            </div>
                                                               </div>
                                                                <?php } */?>
                             					<div  id='nfd' style="display:block">
                              <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Follow Up Date:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text"  placeholder="Enter Next Follow Up Date" id="datett" name='followupdate'  class="datett form-control" required  style="background:white; cursor:default;" />
                                           
                                            </div>
                                                               </div>
											      <div class="form-group" >
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Follow Up Time:
                                            </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-10">
												  
												  <div class="input-group"> <input class="form-control "  data-template="dropdown" id="timet" name="followuptime" placeholder="Enter Next Follow Up Time" type="text"> <div class="input-group-addon"> <a href="#timet"><i class="entypo-clock"></i></a> </div> </div>

												  
												  <?php ////////////// Time Filter ///////////////////
/*$timestamp = strtotime(date("H:i")) + 60*60;
$time = date("H:i:s", $timestamp);
$timestamp1 = strtotime(date("H:i")) - 60*60;
$time1 = date("H:i:s", $timestamp1);
echo 'Current Time'.date("H:i:s").'<br>';//11:09 
echo  'before one hr Time'.$time1.'<br>';
echo  'After one hr Time'.$time.'<br>';  */
?>
											<!--   <input type="text"  placeholder="Enter Next Follow Up Date" id="timet" name='followupdate'  class=" form-control" required readonly style="background:white; cursor:default;" />
                                             <span class="entypo-clock"></span>
										 
                                            </div>
											<div class="col-md-2 col-sm-2 col-xs-2">
											   <span class="input-group-addon">
                      
                    </span>
											</div>-->
                                                               </div>                
									</div>				   
                                            
									</div>
                                                            
									
     
                                     <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Remark:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <textarea placeholder="Enter Remark" name='comment'  class="form-control" required /></textarea>
                                            </div>
                                                               </div>
                                     
                                     
									  
                                      
                           
                                                              </div>
                                                              
                                                             </div>
                                                             </div>
               <!-- -->
           
       <!-- New Car Details-->
      <div class="panel panel-primary" id="first_div">
        <h3 class="text-center">New Car Details</h3>
     		<div class="panel-body">
                 <div class="col-md-12">
                     <div class="col-md-6">   
                       <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">New Car Model:</label>
                           <div class="col-md-8 col-sm-8 col-xs-12">
                              <select name="new_model" id="new_model" class="form-control"  onchange="select_variant();">
                                       
										<option value="">Please Select  </option>
										<?php  foreach($make_models as $row4) {?>
                      					<option value="<?php echo $row4 -> model_id; ?>"><?php echo $row4 -> model_name; ?></option>
                       					<?php } ?>
                   					</select>
                                   </div>
                               </div>
                       </div>
                           <div class="col-md-6">
                           	 <div class="form-group" id="variant">
                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">New Car Variant:</label>
                                     <div class="col-md-8 col-sm-8 col-xs-12">
                                       <select name="new_variant" id="new_variant" class="form-control"  >
                                         <?php  if($lead_detail[0]->variant_id !='')
                                       {
                                       	?>
                                       	<option value="<?php echo $lead_detail[0]-> variant_id; ?>"><?php echo $lead_detail[0] -> variant_name; ?></option>
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
                             
                                    
                        	 </div>
                   	  </div>
                  </div>
               </div>

               <!-- Other Details-->
      <div class="panel panel-primary" >
        <h3 class="text-center">Other Details</h3>
     		<div class="panel-body">
                 <div class="col-md-12">
                     <div class="col-md-6">   
                       <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" >Interested in Finance:</label>
                           <div class="col-md-8 col-sm-8 col-xs-12">
                              <select name="interested_in_finance" id="interested_in_finance" onchange="showDiv()" class="form-control" >
										<option value="">Please Select  </option>
                      					<option value="Yes">Yes</option>
                      					<option value="No">No</option>
                   					</select>
                                   </div>
                               </div>
                                <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" >Interested in Accessories:</label>
                           <div class="col-md-8 col-sm-8 col-xs-12">
                              <select name="interested_in_accessories" id="interested_in_accessories" class="form-control" >
										<option value="">Please Select  </option>
                      					<option value="Yes">Yes</option>
                      					<option value="No">No</option>
                   					</select>
                                   </div>
                               </div>
                       </div>
                           <div class="col-md-6">
                           	 <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" >Interested in Insurance:</label>
                           <div class="col-md-8 col-sm-8 col-xs-12">
                              <select name="interested_in_insurance" id="interested_in_insurance" class="form-control" >
										<option value="">Please Select  </option>
                      					<option value="Yes">Yes</option>
                      					<option value="No">No</option>
                   					</select>
                                   </div>
                               </div>
                              <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" >Interested in EW:</label>
                           <div class="col-md-8 col-sm-8 col-xs-12">
                              <select name="interested_in_ew" id="interested_in_ew" class="form-control" >
										<option value="">Please Select  </option>
                      					<option value="Yes">Yes</option>
                      					<option value="No">No</option>
                   					</select>
                                   </div>
                               </div>
                                    
                        	 </div>
                   	  </div>
                  </div>
               </div>
                <!-- Finance details -->
                     <div class="panel panel-primary" id='financeDiv' style="display:none">
        <h3 class="text-center">Finance Details</h3>
     		<div class="panel-body">
                 <div class="col-md-12">
                     <div class="col-md-6">   
                       <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" >Customer Type:</label>
                           <div class="col-md-8 col-sm-8 col-xs-12">
                              <select name="customer_occupation" id="customer_occupation" class="form-control" >
										<option value="">Please Select  </option>
                      					<option value="Salaried">Salaried</option>
                      					<option value="Self Employed">Self Employed</option>
                   					</select>
                                   </div>
                               </div>
                                <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" >Customer Designation:</label>
                           <div class="col-md-8 col-sm-8 col-xs-12">
                               <input type="text" id="customer_designation" name='customer_designation'  class="form-control"   placeholder="Enter Customer Designation"  />
                                   </div>
                               </div>
                       </div>
                           <div class="col-md-6">
                           	 <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" >Corporate Name:</label>
                           <div class="col-md-8 col-sm-8 col-xs-12">
                              <select name="customer_corporate_name" id="customer_corporate_name" class="form-control" >
										<option value="">Please Select  </option>
                      				<?php foreach($corporate as $cRow)
                      				{?>
                      					<option value="<?php echo $cRow->corporate_name?>"><?php echo $cRow->corporate_name?></option>
                      				<?php } ?>
                      					
                   					</select>
                                   </div>
                               </div>
                            
                                    
                        	 </div>
                   	  </div>
                  </div>
               </div>
               <!-- Transfer and send quotation -->
      
			
           </div>
       
            <div class="form-group">
             	<div class="col-md-2 col-md-offset-5">
                  <button type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12">Submit</button>
                 </div>
                 <div class="col-md-2">
                    <button type="reset" class="btn btn-primary col-md-12 col-xs-12 col-sm-12">Reset</button>
                 </div>
            </div>
            
             </form>
          </div>
       
      </div>
  
    <?php } ?>

				</div>
			</div> 
	 </div>
       	<!-- Modal -->
	<div class="modal fade" id="modal-7">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title">Dynamic Content</h4>
					</div>
					<div class="modal-body">
						Content is loading...
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							Close
						</button>
						<button type="button" class="btn btn-info">
							Save changes
						</button>
					</div>
				</div>
			</div>
		</div>
		
			<script src="https://demo.neontheme.com/assets/js/gsap/TweenMax.min.js" id="script-resource-1"></script>
		<script src="https://demo.neontheme.com/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
		<script src="https://demo.neontheme.com/assets/js/bootstrap.js" id="script-resource-3"></script>
		<script src="https://demo.neontheme.com/assets/js/joinable.js" id="script-resource-4"></script>
		<script src="https://demo.neontheme.com/assets/js/resizeable.js" id="script-resource-5"></script>
		<script src="https://demo.neontheme.com/assets/js/neon-api.js" id="script-resource-6"></script>
	
		<!-- JavaScripts initializations and stuff -->
		<script src="https://demo.neontheme.com/assets/js/neon-custom.js" id="script-resource-9"></script>
		<!-- Demo Settings -->
		<script src="https://demo.neontheme.com/assets/js/neon-demo.js" id="script-resource-10"></script>
		
										