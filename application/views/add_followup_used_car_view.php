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
	var old_dse_tl_id="<?php echo $lead_detail[0]->assign_to_dse_tl; ?>";
	var lead_process="<?php echo $lead_detail[0]->process; ?>";
 <?php $user_id=$this->session->userdata('user_id');
 $check_user_process_transfer = $this->db->query("select p.process_id
									from lmsuser l 
									Left join tbl_manager_process mp on mp.user_id=l.id 
									Left join tbl_process p on p.process_id=mp.process_id
									where mp.user_id='$user_id' group by p.process_id ")->result(); ?>
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
		url : '<?php echo site_url('add_followup_used_car/select_transfer_location'); ?>',
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

function select_feedback (val) {
  //alert(val);
  var feedback = val;
  $.ajax({
	url : '<?php echo site_url('add_followup_used_car/select_next_action'); ?>',
	type : 'POST',
	data : {
	'feedback' : feedback,

	},
	success : function(result) {
	$("#nextactiondiv").html(result);
	}
	});
}
function check_disp_name(val) {

var nextaction = document.getElementById("nextaction").value;
	//alert(nextaction);
	check_nfd(val);
	 var hiddenDiv = document.getElementById("Test_Home");
  		
	if(nextaction=='Home Visit' || nextaction=='Test Drive'){
		
		 hiddenDiv.style.display = "block";
	
	}
	
	else{
	
		hiddenDiv.style.display = "none";
	}
	
		}
function check_nfd(val) {

var nextaction = document.getElementById("nextaction").value;
	//alert(nextaction);
	var nfdDiv = document.getElementById("nfd");
	
	if(nextaction=='Close' || nextaction=='Booked From Autovista'){
		
		
	 document.getElementById("followupdate").disabled = true; 
	 document.getElementById("timet").disabled = true; 
		   nfdDiv.style.display = "none";
	}
	
	else{
	
		nfdDiv.style.display = "block";
		 document.getElementById("followupdate").disabled = false; 
		  document.getElementById("timet").disabled = false; 
	}
	
		}

	//Select variant name using model 
function select_variant() {
var model = document.getElementById("new_model").value;
$.ajax({
	url : '<?php echo site_url('add_followup/select_variant'); ?>',
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
	url : '<?php echo site_url('add_followup/select_model'); ?>',
		type : 'POST',
		data : {'make' : make,},
		success : function(result) {
		$("#model_div").html(result);
		}
		});
		}
		//Select model name usign make id
	function select_buy_model() {
	var make = document.getElementById("buy_make").value;
	$.ajax({
	url : '<?php echo site_url('add_followup/select_buy_model'); ?>',
		type : 'POST',
		data : {'make' : make,},
		success : function(result) {
		$("#buy_model_div").html(result);
		}
		});
		}
		//Select user name using location
		
		//Select user name using location
function select_assign_to()
{
	var tlocation1 = document.getElementById("tlocation1").value;
	var tprocess = document.getElementById("tprocess").value;
	$.ajax({
		url : '<?php echo site_url('add_followup_used_car/select_assign_to'); ?>',
		type : 'POST',
		data : {'tlocation1' : tlocation1,'tprocess' : tprocess},
		success : function(result) {
		$("#tassign_div").css("display", "block");
		$("#assign_div").html(result);
	}
	});
}

function select_model_name()
		{
			
		var city = document.getElementById("qlocation").value;
		//alert(city);

		$.ajax({
		url : '<?php echo site_url('add_followup/select_model_name'); ?>',
		type : 'POST',
		data : {'city' : city,},
		success : function(result) {
		$("#model_name_div").html(result);
		}
		});
		}
		
		

function select_description()
		{
		
		var model_name = document.getElementById("model_name").value;
		//alert(model_name);
		var city = document.getElementById("qlocation").value;
		
	//	alert(city);

		$.ajax({
		url : '<?php echo site_url('add_followup/select_description'); ?>',
		type : 'POST',
		data : {'model_name' : model_name,'city' : city,},
		success : function(result) {
		$("#description_div").html(result);
		}
		});
		}



//Select dispostion using status
function check_status(val) {
	
$.ajax({
		url : '<?php echo site_url('add_followup/select_disposition'); ?>',
	type : 'POST',
	data : {'status' : val,},
	success : function(result) {
	$("#disposition_div").html(result);
	}
	});
	}
	
</script> 
<script>
function insert_additional_info()
{
	var make=document.getElementById("make").value;
	var model=document.getElementById("model").value;
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
	//alert(model);
	var color=document.getElementById("color").value;
	var ownership=document.getElementById("ownership").value;
	var mfg=document.getElementById("mfg").value;
	var km=document.getElementById("km").value;
	var claim=document.getElementById("claim").value;
	//alert(claim);
	var enq_id=document.getElementById("enq_id").value;
	
	var budget_from=document.getElementById("budget_from").value;
	var budget_to=document.getElementById("budget_to").value;
	var visit_status=document.getElementById("visit_status").value;
	var visit_location=document.getElementById("visit_location").value;
	var visit_booked=document.getElementById("visit_booked").value;
	var visit_date=document.getElementById("visit_date").value;
	var sales_status=document.getElementById("sales_status").value;
	var car_delivered=document.getElementById("car_delivered").value;
	var buyer_type=document.getElementById("buyer_type").value;
	
	
	$.ajax({
		url : '<?php echo site_url('add_followup/insert_additional_info'); ?>',
	type : 'POST',
	data : {'make' : make,'model':model,'color':color,'ownership':ownership,'mfg':mfg,'km':km,'claim':claim,'enq_id':enq_id,'budget_from':budget_from,'budget_to':budget_to,'visit_status':visit_status,'visit_location':visit_location,'visit_booked':visit_booked,'visit_date':visit_date,'sales_status':sales_status,'car_delivered':car_delivered,'buyer_type':buyer_type},
	success : function(result) {
	$("#exchange").html(result);
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
		url : '<?php echo site_url('add_followup/insert_buy_car_data'); ?>',
	type : 'POST',
	data : {'make' : make,'model':model,'enq_id':enq_id,'buyer_type':buyer_type},
	success : function(result) {
	$("#replace_data").html(result);
	}
	});
}

function check_values()
{
	//select Buyer type
	var buyer_type_old='<?php echo $lead_detail[0] -> buyer_type; ?>';
	//Basic followup

	var email_old='<?php echo $lead_detail[0]->email;?>';
	var feedbackStatus='<?php echo $lead_detail[0]->feedbackStatus;?>';
	var nextAction='<?php echo $lead_detail[0]->nextAction;?>';
	//var tdhvdate='<?php echo $lead_detail[0]->td_hv_date;?>';
	//alert(tdhvdate);
	var new_model_old='<?php echo $lead_detail[0]->new_model_id;?>';
	//var new_variant_old='<?php echo $lead_detail[0]->variant_id;?>';
	//var book_old='<?php //echo $lead_detail[0]->buy_status;?>';	
	//Buy old car details
	var buy_make_old='<?php echo $lead_detail[0]->buy_make;?>';	
	var buy_model_old='<?php echo $lead_detail[0]->buy_model;?>';
	var budget_to_old='<?php echo $lead_detail[0]->budget_to;?>';
	var budget_from_old='<?php echo $lead_detail[0]->budget_from;?>';
	//var visit_status_old='<?php echo $lead_detail[0]->visit_status;?>';	
	//var visit_booked_old='<?php echo $lead_detail[0]->visit_booked;?>';
	//var sale_status_old='<?php echo $lead_detail[0]->sale_status;?>';	
	//var visit_location_old='<?php echo $lead_detail[0]->visit_location;?>';	
//	var car_delivered_old='<?php echo $lead_detail[0]->car_delivered;?>';	
		
	//Sold old car details
	var old_make_old='<?php echo $lead_detail[0]->make_id;?>';
	//var old_model_old='<?php echo $lead_detail[0]->model_id;?>';
	var color_old='<?php echo $lead_detail[0]->color;?>';
	var ownership_old='<?php echo $lead_detail[0]->ownership;?>';
	var claim_old='<?php echo $lead_detail[0]->accidental_claim;?>';
	var mfg_old='<?php echo $lead_detail[0]->manf_year;?>';
	var km_old='<?php echo $lead_detail[0]->km;?>';
	
	var appointment_type='<?php echo $lead_detail[0]->appointment_type;?>';
	var appointment_date='<?php echo $lead_detail[0]->appointment_date;?>';
	var appointment_time='<?php echo $lead_detail[0]->appointment_time;?>';
	var appointment_address='<?php echo $lead_detail[0]->appointment_address;?>';
	var appointment_status='<?php echo $lead_detail[0]->appointment_status;?>';
	var appointment_rating='<?php echo $lead_detail[0]->appointment_rating;?>';
	var appointment_feedback='<?php echo $lead_detail[0]->appointment_feedback;?>';
	
	var interested_in_finance='<?php echo $lead_detail[0]->interested_in_finance;?>';
	var interested_in_accessories='<?php echo $lead_detail[0]->interested_in_accessories;?>';
	var interested_in_insurance='<?php echo $lead_detail[0]->interested_in_insurance;?>';
	var interested_in_ew='<?php echo $lead_detail[0]->interested_in_ew;?>';

	 var hiddenDiv = document.getElementById("Test_Home");
	 var alternate_contact=	'<?php echo $lead_detail[0] -> alternate_contact_no; ?>';	
	
	 
	 if(alternate_contact == '')
		{

		document.getElementById("alternate_contact").value = "";

		}else{
		document.getElementById("alternate_contact").value = alternate_contact;
		}
	 if(appointment_type == '')
			{
			  document.getElementById("appointment_type").value = "";
	  
			}else{
				document.getElementById("appointment_type").value = appointment_type;
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
			/* if(appointment_address == '')
			{
			  document.getElementById("appointment_address").value = "";
	  
			}else{
				document.getElementById("appointment_address").value = appointment_address;
			}
		 if(appointment_rating == '')
			{
			  document.getElementById("appointment_rating").value = "";
	  
			}else{
				document.getElementById("appointment_rating").value = appointment_rating;
			}
			 if(appointment_feedback == '')
			{
			  document.getElementById("appointment_feedback").value = "";
	  
			}else{
				document.getElementById("appointment_feedback").value = appointment_feedback;
			}*/
	 
	 if(appointment_status == '')
			{
			  document.getElementById("appointment_status").value = "";
	  
			}else{
				document.getElementById("appointment_status").value = appointment_status;
			}
			if(interested_in_finance == '')
			{
			  document.getElementById("interested_in_finance").value = "";
	  
			}else{
				document.getElementById("interested_in_finance").value = interested_in_finance;
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
		//alert(buyer_type_old);
	if(buyer_type_old == '')
			{
			  document.getElementById("buyer_type").value = "";
	  
			}else{
				document.getElementById("buyer_type").value = buyer_type_old;
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
		/*	if(new_variant_old == '' || new_variant_old == 0)
			{
			
			  document.getElementById("new_variant").value = "";
	  
			}
			else
			{
				document.getElementById("new_variant").value = new_variant_old;
			}*/
		/*	if(book_old == '')
			{
			
			  document.getElementById("book").value = "No";
	  
			}else{
				document.getElementById("book").value = book_old;
			}*/
			if(buy_make_old == '' || buy_make_old == 0)
			{
			
			  document.getElementById("buy_make").value = "";
	  
			}else{
				document.getElementById("buy_make").value = buy_make_old;
			}
			
			if(budget_from_old == '')
			{
			
			  document.getElementById("budget_from").value = "";
	  
			}else{
				document.getElementById("budget_from").value = budget_from_old;
			}
			if(budget_to_old == '')
			{
			
			  document.getElementById("budget_to").value = "";
	  
			}else{
				document.getElementById("budget_to").value = budget_to_old;
			}
			
			if(old_make_old == '' || old_make_old == 0)
			{
			
			  document.getElementById("make").value = "";
	  
			}else{
				document.getElementById("make").value = old_make_old;
			}
			
			if(ownership_old == '')
			{
			
			  document.getElementById("ownership").value = "";
	  
			}else{
				document.getElementById("ownership").value = ownership_old;
			}
			if(claim_old == '')
			{
			
			  document.getElementById("claim").value = "";
	  
			}else{
				document.getElementById("claim").value = claim_old;
			}
			if(mfg_old == '')
			{
			
			  document.getElementById("mfg").value = "";
	  
			}else{
				document.getElementById("mfg").value = mfg_old;
			}
			if(km_old == '')
			{
			
			  document.getElementById("km").value = "";
	  
			}else{
				document.getElementById("km").value = km_old;
			}
			 var nfdDiv = document.getElementById("nfd");
			
			if(nextAction=='Close' || nextAction=='Booked From Autovista'){
			
					document.getElementById("followupdate").disabled = true; 
					document.getElementById("timet").disabled = true; 
					nfdDiv.style.display = "none";
				
			}else{
		
				nfdDiv.style.display = "block";
				 document.getElementById("followupdate").disabled = false; 
					document.getElementById("timet").disabled = false; 
			}
			var customer_corporate_name='<?php echo $lead_detail[0]->customer_corporate_name;?>';
			var customer_designation='<?php echo $lead_detail[0]->customer_designation;?>';
			var customer_occupation='<?php echo $lead_detail[0]->customer_occupation;?>';
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
			if(customer_occupation == '')
			{
			
			  document.getElementById("customer_occupation").value = "";
	  
			}else{
				document.getElementById("customer_occupation").value = customer_occupation;
			}
				if(interested_in_finance =='Yes'){
				showDiv();
				}
			
			
						
						
}
</script>
<body class="page-body" onload="check_buyer('<?php echo $lead_detail[0] -> buyer_type; ?>');check_values();">
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
<?php if(count($duplicate_record)>0){?>
			
     				<div class="pull-right" style=" margin-bottom:20px">
          
 <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name" style="color:#FF0000">This lead is <?php echo count($duplicate_record); if(count($duplicate_record)==1){?> time <?php }else{?> times<?php }?>   already followed up.
 <a  style="color:#21a9e1" href="<?php echo site_url();?>add_followup_new_car/duplicate_record_details/<?php echo $lead_detail[0] -> enq_id; ?>" target='_blank'> (show details)</a></label>
                           
    		</div>
     		<?php } ?>
<?php $insert=$_SESSION['insert'];
if(isset($insert[26])){
if($insert[26]==1){?>
 	 <div class="panel panel-primary">
     	<div class="panel-body">
     		<form action="<?php echo $var; ?>" method="post">
                	<input type="hidden" name="booking_id" id='enq_id' value="<?php echo $lead_detail[0] -> enq_id; ?>">
                	<input type="hidden" name="phone" value="<?php echo $lead_detail[0]->contact_no;?>">
					<input type="hidden" name="loc" value="<?php echo $path; ?>">
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
							<!-- Basic Followup -->
                     	 <div class="panel panel-primary">
 							<div class="panel-body">
                         	
                       <section>
                         		<div class="col-md-6">
                         	  	<div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Alternate Contact No:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <input placeholder="Enter Contact Number" onkeypress="return isNumberKey(event)" onkeyup="return limitlength(this, 10)" name="alternate_contact" id="alternate_contact" class="form-control" type="text" tabindex="1">
                                            </div>
                                        </div>
                 					  <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Email:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text"  placeholder="Enter Email"  name='email'  id="email" class="form-control" tabindex="2"/>
                                            </div>
                                        </div>
						<div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" >Address:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                  	<textarea placeholder="Enter Address" name='address' id="location" class="form-control" style="height: 30px;" tabindex="3"/><?php echo $lead_detail[0] -> address; ?></textarea>
                                          
                                            </div>
                                      </div>
                                  
                                      <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" >Call Status:         </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <select name="contactibility" id="contactibility" class="form-control" required tabindex="4" >
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
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Action:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <select name="nextaction" id="nextaction" class="form-control"  onchange='check_disp_name(this.value);' required  tabindex="6"> 
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
                                      
                                   
                                                              
                                           
                        	</div>
                       
                       
                   
                         	
					
                         
                  
                                   
                               <div class="col-md-6">
                               	 
										      <div  id='nfd' style="display:block">
                              <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Follow Up Date & Time:
                                            </label>
                                                  <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text"  placeholder="Enter Next Follow Up Date" id="followupdate" autocomplete="off" name='followupdate'  class="form-control" required  style="cursor:default;" tabindex="7" />
                                           
                                            </div>
                                             <div class="col-md-4 col-sm-4 col-xs-10">
												  
												   <input class="form-control "  data-template="dropdown" id="timet" autocomplete="off" name="followuptime" placeholder="Enter Next Follow Up Time" type="text" tabindex="8"> 

												  
												
                                                               </div>      
                                                               </div>
                                       
										</div>	
										
                               	   <div class="form-group">
                                           	<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Booking within days:</label>
                                        	<div class="col-md-8 col-sm-8 col-xs-12">
                                            <select name="days60_booking" id="days60_booking" class="form-control" tabindex="9">
                                            		<option value="">Please Select</option>		
                                            	<option value="30">30 days</option>
                                            <option value="60">60 days</option>
                                              <option value="90">90 days</option>
                                    	 	     <option value="Undecided">Undecided</option>                                     	
                                            </select>
                                            </div>
                                      </div>
											
				  			                        	<?php if((isset($insert[79]) && $_SESSION['process_id']==7))
				  { 
				  	if($insert[79] == '1') {?>
                                      <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" >Appointment Type:</label>
                           <div class="col-md-8 col-sm-8 col-xs-12">
                              <select name="appointment_type" id="appointment_type" class="form-control" tabindex="10"  onchange="check_appointment_details();">
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
                                                <input type="text"  placeholder="Enter Appointment Date" id="appointment_date" name='appointment_date'  class="datett form-control" autocomplete="off"  style="cursor:default;" tabindex="11" />
                                           
                                            </div>
                                             <div class="col-md-4 col-sm-4 col-xs-10">
												  <input class="form-control "  data-template="dropdown" id="appointment_time" name="appointment_time" autocomplete="off" placeholder="Enter Appointment Time" type="text" tabindex="12"> 
													</div>               
                                                               </div>
     										
									 <div class="form-group" >
                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" >Appointment Status:</label>
                                     <div class="col-md-8 col-sm-8 col-xs-12">
                                       <select name="appointment_status" id="appointment_status" class="form-control"  tabindex="13">
                                        
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
                                                <textarea placeholder="Enter Remark" name='comment'  class="form-control" required tabindex="14" /></textarea>
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
             <div class="col-md-4 col-md-offset-2">
             	<div class="form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Buyer Type:</label>
                                         <div class="col-md-8 col-sm-8 col-xs-12">
                                           <select name="buyer_type" id="buyer_type" class="form-control"  onchange='check_buyer(this.value);' tabindex="15">
                                            
												 <option value="">Please Select  </option>
															
											
                       							<!--<option value="Exchange">Exchange with New Car</option>-->
                       							<option value="Exchange With Old Car">Exchange with Old Car</option>
                       							<option value="Buy Used Car">Buy Used Car</option>
												<option value="Sell Used Car">Sell Used Car</option>
                    						
                   							</select>
                                       </div>
                                   </div>
                                   </div>
                                   <div class="col-md-2 col-md-offset-1">
                                        
									<a href="javascript:;" onclick="jQuery('#modal-6').modal('show', {backdrop: 'static'});" class="btn btn-success col-md-12 col-xs-12 col-sm-12">Add Escalation</a>
								
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
                              <select name="new_model" id="new_model" class="form-control"  onchange="select_variant();" tabindex="16">
                                       
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
                                       <select name="new_variant" id="new_variant" class="form-control" tabindex="17" >
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
               <!-- buy Used  Car Details -->
               <div class="panel panel-primary" id="buy_used_car" >
       				<h3 class="text-center">Buy Used Car Details</h3>
     			 <div class="panel-body">
     			 	<div class="col-md-12">
     			 		<div class="col-md-6">
     			 			<div class="form-group">
                             <label class="control-label col-md-4 col-sm-4 col-xs-12" > Car Make: </label>
                             	<div class="col-md-8 col-sm-8 col-xs-12">
                                	<select name="buy_make" id="buy_make" class="form-control" required  onchange="select_buy_model();" tabindex="18">
                                    
										<option value="">Please Select  </option>
										<?php  foreach($makes as $row){ ?>
										<option value="<?php echo $row -> make_id; ?>"><?php echo $row -> make_name; ?></option>
                     					<?php } ?>
                  						</select>
                                 </div>
                             </div>
                                <div class="form-group"  id="buy_model_div">
                             <label class="control-label col-md-4 col-sm-4 col-xs-12" > Car Model:</label>
         					<div class="col-md-8 col-sm-8 col-xs-12" >
                                <select name="buy_model" id="buy_model" class="form-control" required tabindex="19">
                                     <?php  if($lead_detail[0]->buy_model !='')
                                       {
                                       	?>
                                       	<option value="<?php echo $lead_detail[0]-> buy_model; ?>"><?php echo $lead_detail[0] -> buy_model_name; ?></option>
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
                             <div class="col-md-6">
                                
                          	<div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Budget From: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                          
                          	<select name="budget_from" id="budget_from" class="form-control" required tabindex="20">
                                    
										<option value="">Please Select  </option>
									
										<option value="100000">100000</option>
                     					<option value="200000">200000</option>
                     					<option value="300000">300000</option>
                     					<option value="400000">400000</option>
                     					<option value="500000">500000</option>
                     					<option value="600000">600000</option>
                     					<option value="700000">700000</option>
                     					<option value="800000">800000</option>
                     					<option value="900000">900000</option>
                     					<option value="1000000">1000000</option>
                  						</select>
                           
                     	</div>
                     </div> 
                     	  <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Budget To: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                        
                          	<select name="budget_to" id="budget_to" class="form-control" required tabindex="21">
                                    
										<option value="">Please Select  </option>
									
										<option value="100000">100000</option>
                     					<option value="200000">200000</option>
                     					<option value="300000">300000</option>
                     					<option value="400000">400000</option>
                     					<option value="500000">500000</option>
                     					<option value="600000">600000</option>
                     					<option value="700000">700000</option>
                     					<option value="800000">800000</option>
                     					<option value="900000">900000</option>
                     					<option value="1000000">1000000</option>
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
                                	<select name="old_make" id="make" class="form-control" required  onchange="select_model();" tabindex="22">
                                    
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
                                <select name="old_model" id="model" class="form-control" required tabindex="23">
                                     <?php  if($lead_detail[0]->model_id !='')
                                       {
                                       	?>
                                       	<option value="<?php echo $lead_detail[0]-> model_id; ?>"><?php echo $lead_detail[0] -> model_name; ?></option>
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
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Ownership: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                           <select name="ownership" id="ownership" class="form-control"  tabindex="24">
                            
							<option value="">Please Select  </option>
						
                     		<option value="First">First</option>
                       		<option value="Second">Second</option>
                       		<option value="Third">Third</option>
                        	<option value="More Than Three">More Than Three</option>
                       	</select>
                     	</div>
                     </div>
                    
					</div>
                    <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Manufacturing Year: </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <select name="mfg" id="mfg" class="form-control" tabindex="25" >
                            
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
                              <input type="text"  placeholder="Enter Km" id="km" name='km' onkeypress="return isNumberKey(event)" onkeyup="return limitlength(this, 10)" autocomplete="off" class="form-control"  tabindex="26" />
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
                        <div class="form-group" id='additional_btn'>
                        	<div class="col-md-4 pull-right">
                          <a onclick="insert_additional_info()" class=" col-md-12 col-xs-12 col-sm-12"  style="cursor:pointer"><u>Add Next Car</u></a>
                         </div>
                         
                        </div>
                      </div>
                   </div>
                   <div class="col-md-12" id="replace_additional"></div>
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
                              <select name="interested_in_finance" id="interested_in_finance"  class="form-control" tabindex="27">
										<option value="">Please Select  </option>
                      					<option value="Yes">Yes</option>
                      					<option value="No">No</option>
                   					</select>
                                   </div>
                               </div>
                                <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" >Interested in Accessories:</label>
                           <div class="col-md-8 col-sm-8 col-xs-12">
                              <select name="interested_in_accessories" id="interested_in_accessories" class="form-control" tabindex="28">
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
                              <select name="interested_in_insurance" id="interested_in_insurance" class="form-control" tabindex="29">
										<option value="">Please Select  </option>
                      					<option value="Yes">Yes</option>
                      					<option value="No">No</option>
                   					</select>
                                   </div>
                               </div>
                              <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" >Interested in EW:</label>
                           <div class="col-md-8 col-sm-8 col-xs-12">
                              <select name="interested_in_ew" id="interested_in_ew" class="form-control" tabindex="30">
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
                              <select name="customer_occupation" id="customer_occupation" class="form-control" tabindex="31">
										<option value="">Please Select  </option>
                      					<option value="Salaried">Salaried</option>
                      					<option value="Self Employed">Self Employed</option>
                   					</select>
                                   </div>
                               </div>
                               	 <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" >Corporate Name:</label>
                           <div class="col-md-8 col-sm-8 col-xs-12">
                              <select name="customer_corporate_name" id="customer_corporate_name" class="form-control" tabindex="32">
										<option value="">Please Select  </option>
                      				<?php foreach($corporate as $cRow)
                      				{?>
                      					<option value="<?php echo $cRow->corporate_name?>"><?php echo $cRow->corporate_name?></option>
                      				<?php } ?>
                      					
                   					</select>
                                   </div>
                               </div>
                            
                       </div>
                           <div class="col-md-6">
                              <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" >Customer Designation:</label>
                           <div class="col-md-8 col-sm-8 col-xs-12">
                               <input type="text" id="customer_designation" name='customer_designation'  class="form-control"   placeholder="Enter Customer Designation"  tabindex="33"/>
                                   </div>
                               </div> 
                            
                                    
                        	 </div>
                   	  </div>
                  </div>
               </div>
			 
			 
			 
			 
			 
               <!-- Transfer and send quotation -->
      
			
					</div>
					
				<div class="panel panel-primary">
					<!--<h3 class="text-center">Transfer Lead</h3>-->
                	<div class="panel-body">
                	   		 <?php $insert= $_SESSION['insert'];
                        if($insert[25]==1)
						{
							/*if($lead_detail[0]->transfer_process!=''){
								?>
								<div class="col-md-6">                      		
                        	<div class="form-group">
  								 <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">	Lead Transferred To:&nbsp;&nbsp;&nbsp;     <?php echo  $lead_detail[0]->transfer_process; ?> </label>
                           </div>
                          </div>
							<?php  }else{*/ ?>
     					<div class="col-md-6">                      		
                        	<div class="form-group">
  								 <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">Click Here To Transfer Lead: </label>
                                 	<div class="col-md-5 col-sm-5 col-xs-12">
                                     	<label class="checkbox-inline "><input type="checkbox" id="transfer" name="transfer" onclick="transfer_lead()" tabindex="34" >Yes</label>
                                     	</div>
                                    </div>  
                               </div>
                                    <?php  } ?>
                                 
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
                                	<select name="tprocess" id="tprocess" class="form-control"  disabled=true  onchange="select_transfer_location()">
                                      <option value="">Please Select </option>
                     				<?php 
                     				if($lead_detail[0]->transfer_process!=''){
                     					 $transfer_process_data=json_decode($lead_detail[0]->transfer_process);
                     				}else{
                     					$transfer_process_data=array();
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
                                	<select name="tlocation" id="tlocation1" class="form-control"  disabled=true  onchange="select_assign_to()">
                                        <?php /*if($lead_detail[0]->location != ''){?>
												<option value=" <?php echo $lead_detail[0] -> location; ?>"> <?php echo $lead_detail[0] -> location; ?></option>
										<?php } else{ */?>
												<option value="">Please Select  </option>
										<?php //} ?>
									<?php //foreach($get_location1 as $fetch1){ ?>
											<!--	<option value="<?php echo $fetch1 -> location; ?>"><?php echo $fetch1 -> location; ?></option>
                     							-->
                     							 <?php //} ?>
                       					</select>
                                   </div>
                             </div>
                             
                               
                                 </div>
                             
                              
                                    <div class="col-md-6" id="tassign_div">
                                  <div >
                                 <div  class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Transfer To:</label>
                                        <div class="col-md-8 col-sm-8 col-xs-12" style="margin-top: -5px;" id="assign_div">
                                           <select name="transfer_assign" id="tassignto1" class="form-control" required  disabled=true>
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
                                        	 <input type="radio" value="Close" name="lead_status" id="lead_status1"> Close &nbsp;&nbsp;
							<input type="radio" value="Continue" name="lead_status" id="lead_status2"> Continue<br>
         
                                          </div>
                                      </div>
                               </div>
									</div>
									<div id="evaluation_location"></div>
									<div id="evaluation_assign_to"></div>
						
									<br>
								
									
							</div>
						</div>
				 </div>
            <div class="form-group">
             	<div class="col-md-2 col-md-offset-5">
                  <button type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12" tabindex="30">Submit</button>
                 </div>
                 <div class="col-md-2">
                    <button type="reset" class="btn btn-primary col-md-12 col-xs-12 col-sm-12">Reset</button>
                 </div>
            </div>
            
             </form>
          </div>
       
      </div>
<?php } } ?>
    
<?php if(count($select_followup_lead)>0)
{?>
	<div class="col-md-12 table-responsive" style="overflow-x: scroll">
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
										
						<?php if((isset($insert[80]) && $_SESSION['process_id']==7))
				  {
				  	if($insert[80]==1){ ?>
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
										
                    	 <?php if((isset($insert[81]) && $_SESSION['process_id']==7))
				  {
				  	if($insert[81]==1){ ?>
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
<script src="<?php echo base_url();?>assets/js/campaign.js" ></script>
                  