<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.timepicker.min.css">
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
		$('#datett').daterangepicker({
			singleDatePicker : true,
			minDate : new Date(),
			format : 'YYYY-MM-DD',
			showDropdowns: true,
			calender_style : "picker_1",
		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});
		$('#appointment_date').daterangepicker({
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
//Select user name using location
function select_transfer_location()
{
	var ctprocess= document.getElementById("tprocess").value;
		var a =ctprocess.split("#");
	var tprocess= a[0];
		var tprocess_name= a[1];
	

//	var old_tprocess="<?php // echo $lead_detail[0]->transfer_process ?>";
	var old_dse_tl_id="<?php echo $lead_detail[0]->assign_to_dse_tl; ?>";
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
/*	if(old_dse_tl_id!=0 && tprocess_name == lead_process){
		alert("Lead already transfer to DSE TL Showroom");
		document.getElementById("tlocation1").disabled = true; 
		document.getElementById("tassignto1").disabled = true; 
		document.getElementById("tlocation_div").style.display ='none'; 
		document.getElementById("tassign_div").style.display ='none'; 
		document.getElementById("lead_status").style.display ='none'; 
		document.getElementById("tprocess").value="";
		return false;
	}*/
	
		$.ajax({
		url : '<?php echo site_url('add_followup_new_car/select_transfer_location'); ?>',
		type : 'POST',
		data : {'tprocess' : tprocess},
		success : function(result) {
			$("#tassign_div").css("display", "none");
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
		url : '<?php echo site_url('add_followup_new_car/select_assign_to'); ?>',
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
//Select model name usign make id
	function select_model() {
	var make = document.getElementById("make").value;
	$.ajax({
	url : '<?php echo site_url('add_followup_new_car/select_model'); ?>',
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
// show and hide nfd div
function check_nfd(val) {
var nextaction = document.getElementById("nextaction").value;
var nfdDiv = document.getElementById("nfd");
if(nextaction=='Close' || nextaction=='Booked From Autovista' || nextaction=='Lead Transfer')
{
		document.getElementById("datett").disabled = true; 
		document.getElementById("timet").disabled = true; 
		nfdDiv.style.display = "none";
}else{
		nfdDiv.style.display = "block";
		document.getElementById("datett").disabled = false; 
		document.getElementById("timet").disabled = false; 
	}
	if(nextaction=='Booked From Autovista'){
		document.getElementById("edms_booking_no").disabled = false; 
		edms_booking_noDiv.style.display = "block";
	}else{
		document.getElementById("edms_booking_no").disabled = true; 
		edms_booking_noDiv.style.display = "none";
	}
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
</script>
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
function select_assign_to1()
{
	var evaluation_location = document.getElementById("evaluation_location").value;
	var evaluation_process = document.getElementById("evaluation_process").value;
	$.ajax({
		url : '<?php echo site_url('add_followup_new_car/select_assign_to_evaluation'); ?>',
		type : 'POST',
		data : {'tlocation1' : evaluation_location,'tprocess' : evaluation_process},
		success : function(result) {
		$("#evaluation_assign_div").html(result);
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
	var tdhvdate='<?php echo $lead_detail[0]->td_hv_date;?>';
	var days60_booking='<?php echo $lead_detail[0]->days60_booking;?>';
	
	//Buyer Details
	 var buyer_type='<?php echo $lead_detail[0]->buyer_type;?>';
	 
	//New Car Details
	var new_model_old='<?php echo $lead_detail[0]->new_model_id;?>';
	//var new_variant_old='<?php echo $lead_detail[0]->variant_id;?>';
	
	//Exchange Details
	var old_make='<?php echo $lead_detail[0]->old_make;?>';
	//var old_model='<?php echo $lead_detail[0]->old_model;?>';
	var ownership='<?php echo $lead_detail[0]->ownership;?>';
	var mfg='<?php echo $lead_detail[0]->manf_year;?>';
	var accidental_claim='<?php echo $lead_detail[0]->accidental_claim;?>';
	var km='<?php echo $lead_detail[0]->km;?>';
	
	
	//Appointment Details
	var appointment_type='<?php echo $lead_detail[0]->appointment_type;?>';
	var appointment_status='<?php echo $lead_detail[0]->appointment_status;?>';
	var appointment_date='<?php echo $lead_detail[0]->appointment_date;?>';
	var appointment_rating='<?php echo $lead_detail[0]->appointment_rating;?>';
	var appointment_time='<?php echo $lead_detail[0]->appointment_time;?>';
	var appointment_feedback='<?php echo $lead_detail[0]->appointment_feedback;?>';
	var appointment_address='<?php echo $lead_detail[0]->appointment_address;?>';
	
	//Interested In
	var interested_in_finance='<?php echo $lead_detail[0]->interested_in_finance;?>';
	var interested_in_accessories='<?php echo $lead_detail[0]->interested_in_accessories;?>';
	var interested_in_insurance='<?php echo $lead_detail[0]->interested_in_insurance;?>';
	var interested_in_ew='<?php echo $lead_detail[0]->interested_in_ew;?>';
	
	//Corporate details
	var customer_occupation='<?php echo $lead_detail[0]->customer_occupation;?>';
	var customer_designation='<?php echo $lead_detail[0]->customer_designation;?>';
	var customer_corporate_name='<?php echo $lead_detail[0]->customer_corporate_name;?>';
	
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
			if(days60_booking == '')
			{
			  document.getElementById("days60_booking").value = "";
	  
			}else{
				document.getElementById("days60_booking").value = days60_booking;
			}
			
			
			
				 var nfdDiv = document.getElementById("nfd");
			
			if(nextAction=='Close' || nextAction=='Booked From Autovista' || nextAction=='Lead Transfer'){
			
		
					
					document.getElementById("datett").disabled = true; 
					document.getElementById("timet").disabled = true; 
					nfdDiv.style.display = "none";
			}else{
		
				nfdDiv.style.display = "block";
				 document.getElementById("datett").disabled = false; 
				document.getElementById("timet").disabled = false; 
			}
			
	
	//Buyer Type
	if(buyer_type==''){
		 document.getElementById("buyer_type").value = "";
	  
	}else{
		 document.getElementById("buyer_type").value = buyer_type;
	  
	}
	
	// New Car
	if(new_model_old == '' || new_model_old == 0)
			{
			
			  document.getElementById("new_model").value = "";
	  
			}
			else
			{
				document.getElementById("new_model").value = new_model_old;
			}
	
	// Exchange Car 
	if(old_make==''){
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
		 document.getElementById("claim").value = "";
	  
	}else{
		 document.getElementById("claim").value = accidental_claim;
	  
	}
		if(km==''){
		 document.getElementById("km").value = "";
	  
	}else{
		 document.getElementById("km").value = km;
	  
	}
	
	//Interested In
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
			
			
			
			
						
						
}
</script>
<body class="page-body" onload="check_buyer('<?php echo $lead_detail[0] -> buyer_type; ?>');check_values(); ">
<div class="container " style="width: 100%;">
	<div class="row">
		<div id="abc">
			<div class="col-md-12"><?php echo $this -> session -> flashdata('message'); ?></div>
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
<?php if(count($duplicate_record)>0){?>
			
     				<div class="pull-right" style=" margin-bottom:20px">
          
 <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name" style="color:#FF0000">This lead is <?php echo count($duplicate_record); if(count($duplicate_record)==1){?> time <?php }else{?> times<?php }?>   already followed up.
 <a  style="color:#21a9e1" href="<?php echo site_url();?>add_followup_new_car/duplicate_record_details/<?php echo $lead_detail[0] -> enq_id; ?>" target='_blank'> (show details)</a></label>
                           
    		</div>
     		<?php } ?>
<?php $insert=$_SESSION['insert'];
if($insert[9]==1){?>
	<?php if($lead_detail[0]->comment!=''){?>
     			 <div class="panel panel-primary">
     	<div class="panel-body">
     		<div class="col-md-offset-2 col-md-10">
     				<div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">comment: </label>
                 
 <label class="control-label col-md-10 col-sm-10 col-xs-12" for="first-name"><?php echo $lead_detail[0]->comment; ?> </label>
                           
                                        </div>
     		</div></div>
     		</div>
     		<?php } ?>
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
                                           	<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"></label>
                                        	<div class="col-md-8 col-sm-8 col-xs-12">
									<a href="javascript:;" onclick="jQuery('#modal-6').modal('show', {backdrop: 'static'});" class="btn btn-success col-md-6 col-xs-6 col-sm-6">Add Escalation</a>
									       </div>
                                   </div> 
                         </div>
                         <div class="col-md-6">
                                                     <div  id='nfd' style="display:block">
                              <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Follow Up Date & Time:
                                            </label>
                                                  <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text"  placeholder="Enter Next Follow Up Date" id="datett" autocomplete="off" name='followupdate'  class="form-control" required  tabindex="7" style="background-color:#24243e; cursor:default;" />
                                           
                                            </div>
                                             <div class="col-md-4 col-sm-4 col-xs-10">
												  
												   <input class="form-control "  data-template="dropdown" id="timet" autocomplete="off" name="followuptime" placeholder="Enter Next Follow Up Time" type="text" tabindex="8"> 

												  
												
                                                               </div>      
                                                               </div>
                                       
										</div>	
                          <div  id='edms_booking_noDiv' style="display:none">
                              <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">EdMS Booking No:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                               <input type="text"  placeholder="Enter EDMS Booking No" id="edms_booking_no" autocomplete="off" name='edms_booking_id'  class="form-control"   tabindex="7" style="background-color:#24243e; cursor:default;" />
                                           
                                            </div>
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
                                            	<?php if((isset($insert[76]) && $_SESSION['process_id']==6))
				  { 
				  	if($insert[76] == '1') {?>
                                      <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" >Appointment Type:</label>
                           <div class="col-md-8 col-sm-8 col-xs-12">
                              <select name="appointment_type" id="appointment_type" class="form-control" onchange="check_appointment_details();">
										<option value="">Please Select  </option>
                      					<option value="Home Visit">Home Visit</option>
                      					<option value="Showroom Visit">Showroom Visit</option>
                      					<option value="Test Drive">Test Drive</option>
                      					<option value="Evaluation Allotted">Evaluation Allotted</option>
                   					</select>
                                   </div>
                               </div>
                               
                                                            
										  <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" >Appointment Date & Time:
                                            </label>
                                                  <div class="col-md-4 col-sm-4 col-xs-12">
                                                 <input type="text"  placeholder="Enter Appointment Date" id="appointment_date" name='appointment_date'  class="datett form-control"   tabindex="11" style="background-color:#24243e; cursor:default;" />
                                           
                                            </div>
                                             <div class="col-md-4 col-sm-4 col-xs-10">
												  <input class="form-control "  data-template="dropdown" id="appointment_time" name="appointment_time" autocomplete="off" placeholder="Enter Appointment Time" type="text" tabindex="12"> 
													</div>               
                                                               </div>
     										
     										
									 <div class="form-group" >
                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" >Appointment Status:</label>
                                     <div class="col-md-8 col-sm-8 col-xs-12">
                                       <select name="appointment_status" id="appointment_status" class="form-control"  >
                                        
                                       	<option value="">Please Select  </option>
										<option value="Conducted">Conducted</option>	
										<option value="Not Conducted">Not Conducted</option>
										</select>
                                     </div>
                                </div>
      <?php } } ?>
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
            <!-- Check Buyer Type -->
             <div class="panel panel-primary">
        <h3 class="text-center"></h3>
     		<div class="panel-body">
             <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Buyer Type:</label>
                                         <div class="col-md-3 col-sm-3 col-xs-12">
                                           <select name="buyer_type" id="buyer_type" class="form-control"  onchange='check_buyer(this.value);'>
                                            
												 <option value="">Please Select  </option>
															
												<option value="First">First</option>
                       							<option value="Exchange">Exchange with New Car</option>
                       						
                    						
                   							</select>
                                       </div>
                                   </div>
                                   </div>
                                   </div>
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
			                <!-- Exchange Car Details -->
               <div class="panel panel-primary" id="exchange" >
       				<h3 class="text-center">Old Car Details</h3>
     			 <div class="panel-body">
                  	<div class="col-md-12">
	                	<div class="col-md-6">   
                        	<div class="form-group">
                             <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Car Make: </label>
                             	<div class="col-md-8 col-sm-8 col-xs-12">
                                	<select name="old_make" id="make" class="form-control" required  onchange="select_model();">
                                    
										<option value="">Please Select  </option>
										<?php  foreach($makes as $row){ ?>
										<option value="<?php echo $row -> make_id; ?>"><?php echo $row -> make_name; ?></option>
                     					<?php } ?>
                  						</select>
                                 </div>
                             </div>
                            
                            <div class="form-group"  id="model_div">
                               <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Car Model:</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <select name="old_model" id="model" class="form-control" required >
                                     <?php  if($lead_detail[0]->old_model !='')
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
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Any Accidental Claim: </label>
                         <div class="col-md-8 col-sm-8 col-xs-12">
                            <select name="claim" id="claim" class="form-control"  >
                         
							 <option value="">Please Select  </option>
								
							 <option value="Yes">Yes</option>
                     		<option value="No">No</option>
                     	 	</select>
                          </div>
                        </div>
					</div>
                    <div class="col-md-6">
                     <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Ownership: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                           <select name="ownership" id="ownership" class="form-control"  >
                            
							<option value="">Please Select  </option>
						
                     		<option value="First">First</option>
                       		<option value="Second">Second</option>
                       		<option value="Third">Third</option>
                        	<option value="More Than Three">More Than Three</option>
                       	</select>
                     	</div>
                     </div>
                     <div class="form-group">
                      <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Manufacturing Year: </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <select name="mfg" id="mfg" class="form-control"  >
                            
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
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">KMS: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                              <input type="text"  placeholder="Enter Km" id="km" name='km' onkeypress="return isNumberKey(event)" onkeyup="return limitlength(this, 10)" autocomplete="off" class="form-control"   />
                          
						  </div>
                        </div>
                        <input type="hidden"  placeholder="Enter Km" id="buy_make"  />
						<input type="hidden"  placeholder="Enter Km" id="buy_model" />
						<input type="hidden"  placeholder="Enter Km" id="budget_to"   />
						<input type="hidden"  placeholder="Enter Km" id="budget_from"  />
                      <!--  <div class="form-group" id='additional_btn'>
                        	<div class="col-md-4 pull-right">
                          <a onclick="insert_additional_info()" class=" col-md-12 col-xs-12 col-sm-12"  style="cursor:pointer"><u>Add Next Car</u></a>
                         </div>
                         
                        </div>-->
                      </div>
                   </div>
                   <div class="col-md-12" id="replace_additional"></div>
                </div>
             </div>
			   
			   
			   
                     <!-- Appointment Details--
      <div class="panel panel-primary">
        <h3 class="text-center">Appointment Details</h3>
     		<div class="panel-body">
                 <div class="col-md-12">
                     <div class="col-md-6">   
                       <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" >Appointment Type:</label>
                           <div class="col-md-8 col-sm-8 col-xs-12">
                              <select name="appointment_type" id="appointment_type" class="form-control" >
										<option value="">Please Select  </option>
                      					<option value="Home Visit">Home Visit</option>
                      					<option value="Showroom Visit">Showroom Visit</option>
                      					<option value="Test Drive">Test Drive</option>
                      					<option value="Evaluation Allotted">Evaluation Allotted</option>
                   					</select>
                                   </div>
                               </div>
                                <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" >Appointment Date:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text"  placeholder="Enter Next Follow Up Date" id="appointment_date" name='appointment_date'  class="datett form-control"   style="background:white; cursor:default;" />
                                           
                                            </div>
                                                               </div>
											      
                                 <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" >Appointment Address:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <textarea placeholder="Enter Remark" id='appointment_address' name='appointment_address'  class="form-control" ></textarea>
                                            </div>
                                  </div>
                       </div>
                           <div class="col-md-6">
                           	 <div class="form-group" >
                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" >Appointment Status:</label>
                                     <div class="col-md-8 col-sm-8 col-xs-12">
                                       <select name="appointment_status" id="appointment_status" class="form-control"  >
                                        
                                       	<option value="">Please Select  </option>
										<option value="Conducted">Conducted</option>	
										<option value="Not Conducted">Not Conducted</option>
										</select>
                                     </div>
                                </div>
								<div class="form-group" >
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Appointment Time:
                                            </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-10">
												  
												  <div class="input-group"> <input class="form-control "  data-template="dropdown" id="appointment_time" name="appointment_time" placeholder="Enter Next Follow Up Time" type="text"> <div class="input-group-addon"> 
												  	<a href="#timet"><i class="entypo-clock"></i></a> </div> </div>
</div>                
									</div>
                             <div class="form-group" >
                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" >Appointment Rating:</label>
                                     <div class="col-md-8 col-sm-8 col-xs-12">
                                       <select name="appointment_rating" id="appointment_rating" class="form-control">
                                       	<option value="">Please Select  </option>
										<option value="Excellent">Excellent</option>	
										<option value="Good">Good</option>	
										<option value="Poor">Poor</option>
										</select>
                                     </div>
                                </div>
                               <!--   <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" >Appointment Feedback:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <textarea placeholder="Enter Remark" id='appointment_feedback' name='appointment_feedback'  class="form-control"  ></textarea>
                                            </div>
                                  </div>   --
                        	 </div>
                   	  </div>
                  </div>
            </div>-->
                     <!-- Escallation Details-->
     <!-- <div class="panel panel-primary" >
        <h3 class="text-center">Escalation Details</h3>
     		<div class="panel-body">
                 <div class="col-md-12">
                     <div class="col-md-6">   
                       <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" >Escalation Type:</label>
                           <div class="col-md-8 col-sm-8 col-xs-12">
                              <select name="escalation_type" id="escalation_type" class="form-control" >
                                       
										<option value="">Please Select  </option>
                      					<option value="Escalation Level 1">Escalation Level 1</option>
                      					<option value="Escalation Level 2">Escalation Level 2</option>
                      					<option value="Escalation Level 3">Escalation Level 3</option>
                       					
                   					</select>
                                   </div>
                               </div>
                       </div>
                           <div class="col-md-6">
                           	 <div class="form-group" >
                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Escalation Remark:</label>
                                      <div class="col-md-8 col-sm-8 col-xs-12">
                                                <textarea placeholder="Enter Remark" id='escalation_remark' name='escalation_remark'  class="form-control"  /></textarea>
                                            </div>
                                </div>
                             
                                    
                        	 </div>
                   	  </div>
                  </div>
               </div>-->
               <!-- Other Details-->
      <div class="panel panel-primary" >
        <h3 class="text-center">Other Details</h3>
     		<div class="panel-body">
                 <div class="col-md-12">
                     <div class="col-md-6">   
                       <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" >Interested in Finance:</label>
                           <div class="col-md-8 col-sm-8 col-xs-12">
                              <select name="interested_in_finance" id="interested_in_finance" class="form-control" >
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
      
				<div class="panel panel-primary">
					<!--<h3 class="text-center">Transfer Lead</h3>-->
                	<div class="panel-body">
                		 <?php $insert= $_SESSION['insert'];
                        if($insert[12]==1)
						{ ?>
							
     					<div class="col-md-4">                      		
                        	<div class="form-group">
  								 <label class="control-label col-md-8 col-sm-8 col-xs-12" for="first-name">Click Here To Transfer Lead: </label>
                                 	<div class="col-md-4 col-sm-4 col-xs-12">
                                     	<label class="checkbox-inline "><input type="checkbox" id="transfer" name="transfer" onclick="transfer_lead()" >Yes</label>
                                     	</div>
                                    </div>  
                               </div>
                                    <?php  } ?>
                                
                               <div class="col-md-4">                      		
                                 <div class="form-group">
  									<label class="control-label col-md-8 col-sm-8 col-xs-12" for="first-name">Click Here To Send Quotation :  </label>
                                  	<div class="col-md-4 col-sm-4 col-xs-12">
                                        <label class="checkbox-inline "><input type="checkbox" id="quotation" name="quotation" onclick="send_quotation()" >Yes</label>
									</div>
                                  </div>  
                                </div>
								 <div class="col-md-4">                      		
                                 <div class="form-group">
  									<label class="control-label col-md-8 col-sm-8 col-xs-12" for="first-name">Click Here To Send Brochure :  </label>
                                  	<div class="col-md-4 col-sm-4 col-xs-12">
                                        <label class="checkbox-inline "><input type="checkbox" id="brochure" name="brochure" onclick="send_brochure()" >Yes</label>
									</div>
                                  </div>  
                                </div>
                               </div>
                              </div>
               <!-- Send Quotation div -->
            <div id="quotation1"  style="display: none">
            	<div class="panel panel-primary">	<h3 class="text-center">Send Quotation</h3>
                	<div class="panel-body">
              	<div class="col-md-6">
    		 			<div class="form-group">
    	                   <label class="control-label col-md-4 col-sm-4 col-xs-12" > Location: </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                             <select name="qlocation" id="qlocation" class="form-control" required disabled=true onchange="select_model_name();">
                          	 	 <option value="">Please Select  </option>
										 <?php foreach ($select_city as $row) {?>
                      			<option value="<?php echo $row->location;?>"><?php echo $row->location;?></option>
								  <?php } ?>
                     		</select>
                        </div>
                     </div>
                     
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
    	                 <label class="control-label col-md-4 col-sm-4 col-xs-12" >Model Name: </label>
                       <div class="col-md-8 col-sm-8 col-xs-12" id="model_name_div">
                          <select name="model_id" id="model_name" class="form-control" required disabled=true>
                              <option value="">Please Select  </option>
							</select>
                         </div>
                        </div>
                   </div>
				   <div id="description_div">
                   <div class="col-md-6">
                       
                          <div  class="form-group">
                           <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Description:</label>
                            	<div class="col-md-8 col-sm-8 col-xs-12" id="">
                                    <select name="description" id="description" class="form-control"  disabled=true>
                                         <option value="">Please Select</option> 
									</select>
                           		</div>
                            </div>
                          </div>
                        </div>
                        <div id='checkprize_div'>
                        	</div>
					</div>
					</div>
					</div>
					<!-- Transfer Div -->
					
				<div id="tassignto" style="display: none">
					<div class="panel panel-primary">		
					
					<h3 class="text-center">Transfer Lead</h3>
                	<div class="panel-body">		
                	
                				<?php 	/* if($lead_detail[0]->transfer_process!='' && $lead_detail[0]->assign_to_dse_tl!=0){?>
                						<div class="col-md-12">                      		
                        	<div class="form-group">
                        		 <label for="first-name" style="color:#FF0000;" class="col-md-12">	Lead Already Transferred  To Showroom  </label>
  									<label for="first-name" style="color:#FF0000;"  class="col-md-12">Lead Transferred To  <?php echo  $lead_detail[0]->transfer_process; ?>  </label>
  								   </div>
                          </div>
                         
							
							<?php }else{ */ ?>
									<div class="col-md-12">                      		
                        	<div class="form-group">
                        		
                        		<?php
                        	
                        		 if($lead_detail[0]->assign_to_dse_tl!=0){
                        			?>
  								 <label  style="color:#FF0000;"  class="col-md-12">	Lead Already Transferred  To Showroom  </label>
  									<?php  }?>		
  									<?php if($lead_detail[0]->transfer_process!=''){?>
  							
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
    	                 <label class="control-label col-md-4 col-sm-4 col-xs-12" >Transfer Process:</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                	<select name="tprocess" id="tprocess" class="form-control" required  disabled=true  onchange="select_transfer_location()">
                                      <option value="">Please Select </option>
                     				<?php 
                     				if($lead_detail[0]->transfer_process!=''){
                     					 $transfer_process_data=json_decode($lead_detail[0]->transfer_process);
                     				}else{
                     					$transfer_process_data='';
                     				}
                     				foreach($process as $fetch1)
                     				{
                     					
                     					
                     					 	
                     			
                     					if(!in_array($fetch1 ->process_id, $transfer_process_data) && $fetch1->process_id !=9){
											 
										 
                     					 	?>
												<option value="<?php echo $fetch1 ->process_id.'#'.$fetch1 ->process_name; ?>"><?php echo $fetch1 -> process_name; ?></option>
									<?php 
									
									 } }?>
                       					</select>
                                   </div>
                             </div>
                         
                        </div>
             
                            <div id="tlocation_div" class="col-md-6" >
                            	
                             	<div class="form-group">
    	                 <label class="control-label col-md-4 col-sm-4 col-xs-12" >Transfer Location:</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                	<select name="tlocation" id="tlocation1" class="form-control" required  disabled=true  onchange="select_assign_to()">
                                        <?php /*if($lead_detail[0]->location != ''){?>
												<option value=" <?php echo $lead_detail[0] -> location; ?>"> <?php echo $lead_detail[0] -> location; ?></option>
										<?php } else{ */?>
												<option value="">Please Select  </option>
										<?php //} ?>
									<?php foreach($get_location1 as $fetch1){ ?>
												<option value="<?php echo $fetch1 -> location; ?>"><?php echo $fetch1 -> location; ?></option>
                     							 <?php } ?>
                       					</select>
                                   </div>
                             </div>
                             
                               
                                 </div>
                             
                              
                                    <div class="col-md-6" id="tassign_div">
                                  <div >
                                 <div  class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Transfer To:</label>
                                        <div class="col-md-8 col-sm-8 col-xs-12" style="margin-top: -5px;" id="assign_div">
                                           <select name="transfer_assign" id="tassignto1" required class="form-control"  disabled=true>
                                         		<option value="">Please Select</option> 
											</select>
                                          </div>
                                      </div>
                               </div>
									</div>
									 <div class="col-md-6" >
                                  <div >
                                 <div  class="form-group" id="lead_status">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Current Process Lead Status:</label>
                                        <div class="col-md-8 col-sm-8 col-xs-12" style="margin-top: 5px;">
                                        	 <input type="radio" value="Close" id="lead_status1" disabled=true required name="lead_status"> Close &nbsp;&nbsp;
							<input type="radio" value="Continue" id="lead_status2" required disabled=true name="lead_status"> Continue<br>
         
                                          </div>
                                      </div>
                               </div>
									</div>
									
						
									<br>
									<!-- <?php if($lead_detail[0]->evaluation != ''){ ?>
									 	<label style="color:#FF0000;"  class="col-md-12">Lead Transferred To Evaluator </label>
  								
									 	<?php } ?>
										<div class="col-md-12"><h3 class="text-center">Transfer Lead to Evaluation</h3>	<br></div>
									
										 <div class="col-md-12">
										 <!-- For Evaluation process 
										<input type="hidden" name="evaluation_process" id="evaluation_process" value="8">
                                
								
                                    <div class="col-md-6" >
                                 
                                 <div  class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Evaluation Location:</label>
                                        <div class="col-md-8 col-sm-8 col-xs-12"  >
                                           <select name="evaluation_location" id="evaluation_location" class="form-control"  disabled=true   onchange="select_assign_to1()">
                                         
                                        <?php /*if($lead_detail[0]-> evaluation_location  != ''){?>
												<option value=" <?php echo $lead_detail[0] -> evaluation_location ; ?>"> <?php echo $lead_detail[0] -> 	evaluation_location ; ?></option>
										<?php } else{ */ ?>
												<option value="">Please Select  </option>
										<?php //} ?>
									<?php foreach($evalution_location as $fetch1){ ?>
												<option value="<?php echo $fetch1 -> location; ?>"><?php echo $fetch1 -> location; ?></option>
                     							 <?php } ?>
                       					</select>
											
                                          </div>
                                      </div>
                               
									</div>
									<div class="col-md-6">
								
									 	 <div class="form-group">
										<label class="control-label col-md-4 col-sm-4 col-xs-12">Transfer to Evaluation:</label>
										<div class="col-md-8 col-sm-8 col-xs-12" id="evaluation_assign_div">
												<select name="evaluation_assign_to" id="evaluation_assign_to" class="form-control" disabled=true  >
													<option value="">Please Select</option> 
												</select>
                               </div>
							   </div>
									</div>
							
									</div>-->
										<?php // } ?>
							</div>
						</div>
						<div id="evaluation_location"></div><div id="evaluation_assign_to"></div>
						

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
            
             </form>
          </div>
       
      </div>
  
    <?php } ?>
<?php if(count($select_followup_lead)>0)
{?>
<div class="col-md-12 table-responsive" style="overflow-x:scroll">        
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
				
				
				
				
								
					<div class="row">
					<?php if(isset($lead_detail[0]->esc_level1)){
										if($lead_detail[0]->esc_level1=='Yes' || $lead_detail[0]->esc_level2=='Yes' || $lead_detail[0]->esc_level3=='Yes'){ ?>

					        <h3 class="text-center">Escalation Details</h3>
						<div class="col-md-6" style="margin-top:20px">
						
							<div class="panel panel-primary" >
							
								<div class="panel-body" >
				 	
									<?php if(isset($lead_detail[0]->esc_level1)){
										if($lead_detail[0]->esc_level1=='Yes' || $lead_detail[0]->esc_level2=='Yes' || $lead_detail[0]->esc_level3=='Yes'){ ?>
										<h4 style='text-align: center'>Escalation Done</h4>
										<?php }else{ ?>
											
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
										
								
							</div>
						</div>
						 
						<div class="col-md-6" style="margin-top:20px">
                    		<div class="panel panel-primary">
								<div class="panel-body">
				 	
									<?php if(isset($lead_detail[0]->esc_level1_resolved)){
									if($lead_detail[0]->esc_level1_resolved=='Yes' || $lead_detail[0]->esc_level2_resolved=='Yes' || $lead_detail[0]->esc_level3_resolved=='Yes'){ ?>
									<h4 style='text-align: center'>Resolved Escalation</h4>
									<?php }else{ ?>
										<h4> </h4>
									<?php } } ?>
									<?php if(isset($lead_detail[0]->esc_level1_resolved)){
									if($lead_detail[0]->esc_level1_resolved=='Yes' || $lead_detail[0]->esc_level2_resolved=='Yes' || $lead_detail[0]->esc_level3_resolved=='Yes'){ ?>
								
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
									<?php }} ?>
								</div>
										
								
							</div>
						</div>
						<?php } } ?>
					</div>
				<?php if($_SESSION['user_id']== '1'){?>
				<div class="col-md-12 table-responsive" style="overflow-x:scroll">        
	<table class="table table-bordered datatable" id="results1"> 
	
					<thead>
						<tr>
							<th>Sr No</th>
						
							<th>Location</th>
							<th>Model </th>	
							<th>Variant</th>
							<th>Buyer Type</th>
															
								<th>Followup By</th>
							<th>Send Date</th>	
						
							
						<!--	<th>Escalation Type</th>
						<th>Escalation Remark</th>	-->							
						</tr>	
					</thead>
					<tbody>
					    <?php $i=0;
					    foreach($quotation_download as $qrow){
					    $i++; ?>
					    <tr>
					        <td><?php echo $i ;?></td>
					        <td><?php echo $qrow->location ;?></td>
					        <td><?php echo $qrow->model_name ;?></td>
					        <td><?php echo $qrow->variant_name ;?></td>
					        <td><?php echo $qrow->fname.' '.$qrow->lname ;?></td>
					        <td><?php echo $qrow->quotation_send_date ;?></td>
					    </tr>
					    <?php } ?>
					    </tbody>
				</div>
				
				<?php } ?>
				
				
				
				
				
				
				
				
				
				</div>
			</div> 
	 </div>
       	<!-- Modal -->
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
			<h4 style='text-align: center'>Escalation Not Done Yet </h4>
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
										
						<?php if((isset($insert[77]) && $_SESSION['process_id']==6))
				  {
				  	if($insert[77]==1){ ?>
												<p style='text-align: center'>Add Escalation </p>
												<br>
										<form action="<?php echo site_url();?>add_followup_new_car/insert_escalation_detail" method="post">
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
			<h4 style='text-align: center'>Resolved Escalation</h4>
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
										
                    	 <?php if((isset($insert[78]) && $_SESSION['process_id']==6))
				  {
				  	if($insert[78]==1){ ?>
                    			<p style='text-align: center'>Resolve Escalation </p>
                    			<br>
										<form action="<?php echo site_url();?>add_followup_new_car/insert_escalation_resolve_detail" method="post">
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
<script>
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
<script src="<?php echo base_url();?>assets/js/campaign.js" ></script>					