<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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

//Select variant name usign model id
	function select_variant() {
	var model = document.getElementById("model").value;
	$.ajax({
	url : '<?php echo site_url('add_followup_evaluation_tracking/select_variant'); ?>',
		type : 'POST',
		data : {'model' : model,},
		success : function(result) {
		$("#variant_div").html(result);
		}
		});
		}
		//Select model name usign make id
	function select_model() {
	var make = document.getElementById("make").value;
	$.ajax({
	url : '<?php echo site_url('add_followup_evaluation_tracking/select_model'); ?>',
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
	url : '<?php echo site_url('add_followup_evaluation_tracking/select_next_action'); ?>',
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
		url : '<?php echo site_url('add_followup_new_car/select_assign_to'); ?>',
		type : 'POST',
		data : {'tlocation1' : tlocation1,'tprocess' : tprocess},
		success : function(result) {
		$("#tassign_div").css("display", "block");
		$("#assign_div").html(result);
	}
	});
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

//Show pervious data in text box
function check_values()
{
	//Basic followup
	var email_old='<?php echo $lead_detail[0]->email;?>';
	var alternate_contact='<?php echo $lead_detail[0]->alternate_contact_no;?>';
	var feedbackStatus='<?php echo $lead_detail[0]->feedbackStatus;?>';
	var nextAction='<?php echo $lead_detail[0]->nextAction;?>';

	//Exchange Details
	
	var old_make='<?php echo $lead_detail[0]->old_make;?>';
	var fuel_type='<?php echo $lead_detail[0]->fuel_type;?>';
	var reg_no='<?php echo $lead_detail[0]->reg_no;?>';
	var reg_year='<?php echo $lead_detail[0]->reg_year;?>';
	
	var mfg='<?php echo $lead_detail[0]->manf_year;?>';
	var color='<?php echo $lead_detail[0]->color;?>';
	var ownership='<?php echo $lead_detail[0]->ownership;?>';
	var km='<?php echo $lead_detail[0]->km;?>';
	var type_of_vehicle='<?php echo $lead_detail[0]->type_of_vehicle;?>';
	var outright='<?php echo $lead_detail[0]->outright;?>';
	var old_car_owner_name='<?php echo $lead_detail[0]->old_car_owner_name;?>';
	var photo_uploaded='<?php echo $lead_detail[0]->photo_uploaded;?>';
	var hp='<?php echo $lead_detail[0]->hp;?>';
	var financier_name='<?php echo $lead_detail[0]->financier_name;?>';
	var accidental_claim='<?php echo $lead_detail[0]->accidental_claim;?>';
	var accidental_details='<?php echo $lead_detail[0]->accidental_details;?>';
	var insurance_type='<?php echo $lead_detail[0]->insurance_type;?>';
	var insurance_company='<?php echo $lead_detail[0]->insurance_company;?>';
	var insurance_validity_date='<?php echo $lead_detail[0]->insurance_validity_date;?>';
	var tyre_conditon='<?php echo $lead_detail[0]->tyre_conditon;?>';			
	var engine_work='<?php echo $lead_detail[0]->engine_work;?>';
	var body_work='<?php echo $lead_detail[0]->body_work;?>';
	var vechicle_sale_category='<?php echo $lead_detail[0]->vechicle_sale_category;?>';
	var refurbish_cost_bodyshop='<?php echo $lead_detail[0]->refurbish_cost_bodyshop;?>';
	var refurbish_cost_mecahanical='<?php echo $lead_detail[0]->refurbish_cost_mecahanical;?>';
	var refurbish_cost_tyre='<?php echo $lead_detail[0]->refurbish_cost_tyre;?>';
	var refurbish_other='<?php echo $lead_detail[0]->refurbish_other;?>';
	var total_rf='<?php echo $lead_detail[0]->total_rf;?>';
	var price_with_rf_and_commission='<?php echo $lead_detail[0]->price_with_rf_and_commission;?>';
	var expected_price='<?php echo $lead_detail[0]->expected_price;?>';
	var selling_price='<?php echo $lead_detail[0]->selling_price;?>';
	var bought_at='<?php echo $lead_detail[0]->bought_at;?>';
	var bought_date='<?php echo $lead_detail[0]->bought_date;?>';
	var payment_date='<?php echo $lead_detail[0]->payment_date;?>';
	var payment_mode='<?php echo $lead_detail[0]->payment_mode;?>';
	var payment_made_to='<?php echo $lead_detail[0]->payment_made_to;?>';
	var agent_name='<?php echo $lead_detail[0]->agent_name;?>';
	var agent_commision_payable ='<?php echo $lead_detail[0]->agent_commision_payable ;?>';
	var expected_date_of_sale='<?php echo $lead_detail[0]->expected_date_of_sale;?>';
	var refurbish_cost_battery='<?php echo $lead_detail[0]->refurbish_cost_battery;?>';

			
	//Appointment Details
	var appointment_type='<?php echo $lead_detail[0]->appointment_type;?>';
	var appointment_status='<?php echo $lead_detail[0]->appointment_status;?>';
	var appointment_date='<?php echo $lead_detail[0]->appointment_date;?>';
	var appointment_time='<?php echo $lead_detail[0]->appointment_time;?>';
	var appointment_address='<?php echo $lead_detail[0]->appointment_address;?>';

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
			if(appointment_date == '' && appointment_date=='0000-00-00')
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
			
				// Exchange Car 
	if(old_make=='' || old_make=='0'){
		 document.getElementById("make").value = "";
	  
	}else{
		 document.getElementById("make").value = old_make;
	  
	}
	if(fuel_type == '')
			{
			
			  document.getElementById("fuel_type").value = "";
	  
			}else{
				document.getElementById("fuel_type").value = fuel_type;
			}
			if(reg_no == '')
			{
			
			  document.getElementById("registration_no").value = "";
	  
			}else{
				document.getElementById("registration_no").value = reg_no;
			}
			if(reg_year == '')
			{
			
			  document.getElementById("reg_year").value = "";
	  
			}else{
				document.getElementById("reg_year").value = reg_year;
			}
			
			if(mfg==''){
		 document.getElementById("mfg").value = "";
	  
	}else{
		 document.getElementById("mfg").value = mfg;
	  
	}
	if(color == '')
			{
			
			  document.getElementById("color").value = "";
	  
			}else{
				document.getElementById("color").value = color;
			}
	
	if(ownership==''){
		 document.getElementById("ownership").value = "";
	  
	}else{
		 document.getElementById("ownership").value = ownership;
	  
	}
	if(km==''){
		 document.getElementById("km").value = "";
	  
	}else{
		 document.getElementById("km").value = km;
	  
	}
	if(type_of_vehicle==''){
		 document.getElementById("type_of_vehicle").value = "";
	  
	}else{
		 document.getElementById("type_of_vehicle").value = type_of_vehicle;
	  
	}
	if(outright==''){
		 document.getElementById("outright").value = "";
	  
	}else{
		 document.getElementById("outright").value = outright;
	  
	}
	
	if(old_car_owner_name==''){
		 document.getElementById("old_car_owner_name").value = "";
	  
	}else{
		 document.getElementById("old_car_owner_name").value = old_car_owner_name;
	  
	}
	if(photo_uploaded==''){
		 document.getElementById("photo_uploaded").value = "";
	  
	}else{
		 document.getElementById("photo_uploaded").value = photo_uploaded;
	  
	}
	if(hp==''){
		 document.getElementById("hp").value = "";
	  
	}else{
		 document.getElementById("hp").value = hp;
	  
	}
	if(financier_name==''){
		 document.getElementById("financier_name").value = "";
	  
	}else{
		 document.getElementById("financier_name").value = financier_name;
	  
	}
	
		if(accidental_claim==''){
		 document.getElementById("claim").value = "";
	  
	}else{
		 document.getElementById("claim").value = accidental_claim;
	  
	}
		if(accidental_details==''){
		 document.getElementById("accidental_details").value = "";
	  
	}else{
		 document.getElementById("accidental_details").value = accidental_details;
	  
	}
		if(insurance_type==''){
		 document.getElementById("insurance_type").value = "";
	  
	}else{
		 document.getElementById("insurance_type").value = insurance_type;
	  
	}
		if(insurance_company==''){
		 document.getElementById("insurance_company").value = "";
	  
	}else{
		 document.getElementById("insurance_company").value = insurance_company;
	  
	}
	if(insurance_validity_date==''){
		 document.getElementById("insurance_validity_date").value = "";
	  
	}else{
		 document.getElementById("insurance_validity_date").value = insurance_validity_date;
	  
	}
	if(tyre_conditon==''){
		 document.getElementById("tyre_conditon").value = "";
	  
	}else{
		 document.getElementById("tyre_conditon").value = tyre_conditon;
	  
	}
			if(engine_work == '')
			{
			
			  document.getElementById("engine_work").value = "";
	  
			}else{
				document.getElementById("engine_work").value = engine_work;
			}
			if(body_work == '')
			{
			
			  document.getElementById("body_work").value = "";
	  
			}else{
				document.getElementById("body_work").value = body_work;
			}
	if(vechicle_sale_category == '')
			{
			
			  document.getElementById("vechicle_sale_category").value = "";
	  
			}else{
				document.getElementById("vechicle_sale_category").value = vechicle_sale_category;
			}
	
	if(refurbish_cost_bodyshop == '')
			{
			
			  document.getElementById("refurbish_cost_bodyshop").value = "";
	  
			}else{
				document.getElementById("refurbish_cost_bodyshop").value = refurbish_cost_bodyshop;
			}
			if(refurbish_cost_mecahanical == '')
			{
			
			  document.getElementById("refurbish_cost_mecahanical").value = "";
	  
			}else{
				document.getElementById("refurbish_cost_mecahanical").value = refurbish_cost_mecahanical;
			}
			if(refurbish_cost_tyre == '')
			{
			
			  document.getElementById("refurbish_cost_tyre").value = "";
	  
			}else{
				document.getElementById("refurbish_cost_tyre").value = refurbish_cost_tyre;
			}
			if(refurbish_other == '')
			{
			
			  document.getElementById("refurbish_other").value = "";
	  
			}else{
				document.getElementById("refurbish_other").value = refurbish_other;
			}
			if(total_rf == '')
			{
			
			  document.getElementById("total_rf").value = "";
	  
			}else{
				document.getElementById("total_rf").value = total_rf;
			}
	
			if(price_with_rf_and_commission == '')
			{
			
			  document.getElementById("price_with_rf_and_commission").value = "";
	  
			}else{
				document.getElementById("price_with_rf_and_commission").value = price_with_rf_and_commission;
			}
			if(expected_price == '')
			{
			
			  document.getElementById("expected_price").value = "";
	  
			}else{
				document.getElementById("expected_price").value = expected_price;
			}
			if(selling_price == '')
			{
			
			  document.getElementById("selling_price").value = "";
	  
			}else{
				document.getElementById("selling_price").value = selling_price;
			}
			if(bought_at == '')
			{
			
			  document.getElementById("bought_at").value = "";
	  
			}else{
				document.getElementById("bought_at").value = bought_at;
			}
			if(bought_date == '')
			{
			
			  document.getElementById("bought_date").value = "";
	  
			}else{
				document.getElementById("bought_date").value = bought_date;
			}
			if(payment_date == '')
			{
			
			  document.getElementById("payment_date").value = "";
	  
			}else{
				document.getElementById("payment_date").value = payment_date;
			}
	
	if(payment_mode == '')
			{
			
			  document.getElementById("payment_mode").value = "";
	  
			}else{
				document.getElementById("payment_mode").value = payment_mode;
			}
			if(payment_made_to == '')
			{
			
			  document.getElementById("payment_made_to").value = "";
	  
			}else{
				document.getElementById("payment_made_to").value = payment_made_to;
			}
				if(agent_name == '')
			{
			
			  document.getElementById("agent_name").value = "";
	  
			}else{
				document.getElementById("agent_name").value = agent_name;
			}
			if(agent_commision_payable == '')
			{
			
			  document.getElementById("agent_commision_payable").value = "";
	  
			}else{
				document.getElementById("agent_commision_payable").value = agent_commision_payable;
			}
			if(expected_date_of_sale == '')
			{
			
			  document.getElementById("expected_date_of_sale").value = "";
	  
			}else{
				document.getElementById("expected_date_of_sale").value = expected_date_of_sale;
			}
			if(refurbish_cost_battery == '')
			{
			
			  document.getElementById("refurbish_cost_battery").value = "";
	  
			}else{
				document.getElementById("refurbish_cost_battery").value = refurbish_cost_battery;
			}
	
	if(selling_price!='' || selling_price!=0){
		document.getElementById("payment_details").style.display = "block";
		document.getElementById("payment_check").checked=true;
							  	document.getElementById("selling_price").disabled = false;
							  		document.getElementById("bought_at").disabled = false;
							  		document.getElementById("bought_date").disabled = false;
							  		document.getElementById("payment_date").disabled = false; 
							  		document.getElementById("payment_mode").disabled = false; 
							  		document.getElementById("payment_made_to").disabled = false;  
							  	 
							  	
							  }else{
							  	document.getElementById("selling_price").disabled = true;
							  		document.getElementById("bought_at").disabled = true;
							  		document.getElementById("bought_date").disabled = true;
							  		document.getElementById("payment_date").disabled = true; 
							  		document.getElementById("payment_mode").disabled = true; 
							  		document.getElementById("payment_made_to").disabled = true; 
							  		document.getElementById("payment_details").style.display = "none";
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
	
				
					
}
function change_hp(){
	var hp=document.getElementById('hp').value;
	if(hp=='Yes'){
		document.getElementById("financier_name").required=true; 
	}else{
		document.getElementById("financier_name").required=false ; 
	}
}

</script>
<body class="page-body" onload="check_values(); ">
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
 <div class="panel panel-primary">
     	<div class="panel-body">
     		<form action="<?php echo $var; ?>" method="post">
                	<input type="hidden" name="booking_id" id='enq_id' value="<?php echo $lead_detail[0] -> enq_id; ?>">
                	<input type="hidden" name="phone" value="<?php echo $lead_detail[0]->contact_no;?>">
					<input type="hidden" name="loc" value="<?php echo $path; ?>">
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
<?php 
$insert_poc_purchase_tracking=$_SESSION['insert_poc_purchase_tracking'];

if(isset($insert_poc_purchase_tracking[2])){
if($insert_poc_purchase_tracking[2]==1){?>
		<?php if($lead_detail[0]->comment!=''){?>
     			 <div class="panel panel-primary">
     	<div class="panel-body">
     		<div class="col-md-offset-2 col-md-10">
     				<div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">comment: </label>
                 
 <label class="control-label col-md-10 col-sm-10 col-xs-12" for="first-name" style="text-align: left"><?php echo $lead_detail[0]->comment; ?> </label>
                           
                                        </div>
     		</div></div>
     		</div>
     		<?php } ?>
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
                                                <input type="text"  placeholder="Enter Next Follow Up Date" id="followupdate" autocomplete="off" name='followupdate'  class=" form-control" required  style="background:white; cursor:default;" tabindex="7" />
                                           
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
											
				  			                        	<?php  if((isset($insert_poc_purchase_tracking[4]) && $_SESSION['process_id']==8))
				  { 
				  	if($insert_poc_purchase_tracking[4] == '1') {?>
                                      <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" >Appointment Type:</label>
                           <div class="col-md-8 col-sm-8 col-xs-12">
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
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" >Appointment Date & Time:
                                            </label>
                                                  <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text"  placeholder="Enter Appointment Date" id="appointment_date" name='appointment_date'  class="datett form-control" autocomplete="off"  style="background:white; cursor:default;" tabindex="11" />
                                           
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

			                <!-- Exchange Car Details -->
               <div class="panel panel-primary" id="exchange" >
       				<h3 class="text-center">Old Car Details</h3>
     			 <div class="panel-body">
                 
	             <div class="col-md-6">  
                        	<div class="form-group ">
                             <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Car Make: </label>
                             	<div class="col-md-8 col-sm-8 col-xs-12">
                                	<select name="old_make" id="make" class="form-control" required  onchange="select_model();" tabindex="15">
										<option value="">Please Select</option>
										<?php  foreach($makes as $row){ ?>
										<option value="<?php echo $row -> make_id; ?>"><?php echo $row -> make_name; ?></option>
                     					<?php } ?>
                  						</select>
                                 </div>
                             </div>
                              <div class="form-group"  id="model_div">
                               <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Car Model:</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <select name="old_model" id="model" class="form-control" required  onchange="select_variant();" tabindex="16">
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
                            
                               <div class="form-group"  id="variant_div">
                       			 <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Car Variant: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                           <select name="variant" id="variant" class="form-control"  tabindex="17">
                            <?php  if($lead_detail[0]->old_variant_id !='' && $lead_detail[0]->old_variant_name !='0')
                                       {
                                       	?>
                                       	<option value="<?php echo $lead_detail[0]-> old_variant_id; ?>"><?php echo $lead_detail[0] -> old_variant_name; ?></option>
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
                           <div class="form-group ">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Fuel Type: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                           <select name="fuel_type" id="fuel_type" class="form-control"  tabindex="18">
                            
							<option value="">Please Select  </option>
						
                     		<option value="Petrol">Petrol</option>
                       		<option value="Diesel">Diesel </option>
                       		<option value="CNG">CNG</option>
                        
                       	</select>
                     	</div>
                     </div>
                        <div class="form-group  ">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Registration No.: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                              <input type="text"  placeholder="Enter registration Number" id="registration_no" name='registration_no' autocomplete="off" class="form-control"  tabindex="19" />
                          
						  </div>
                        </div>
                        
                     
                       <div class="form-group ">
                      <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Registration Year: </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <select name="reg_year" id="reg_year" class="form-control"  tabindex="20">
                            
							<option value="">Please Select  </option>
								<?php 
									$year=date('Y');
									for ($i=$year;$i>1980;$i--){ ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?> </option>
								<?php } ?>
							</select>
                           </div>
                        </div>
                         <div class="form-group ">
                      <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Manufacturing Year: </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <select name="mfg" id="mfg" class="form-control"  tabindex="21">
                            
							<option value="">Please Select  </option>
								<?php 
									$year=date('Y');
									for ($i=$year;$i>1980;$i--){ ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?> </option>
								<?php } ?>
							</select>
                           </div>
                        </div>
                        
                   
                         <div class="form-group ">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Color: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text"  placeholder="Enter Color" id="color" name='color' autocomplete="off" class="form-control"   tabindex="22"/>
                          
                     	</div>
                     </div>
                             <div class="form-group ">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Ownership: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                           <select name="ownership" id="ownership" class="form-control"  tabindex="23">
                            
							<option value="">Please Select  </option>
						
                     		<option value="First">First</option>
                       		<option value="Second">Second</option>
                       		<option value="Third">Third</option>
                        	<option value="More Than Three">More Than Three</option>
                       	</select>
                     	</div>
                     </div>
                     <div class="form-group ">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">KMS: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                              <input type="text"  placeholder="Enter Km" id="km" name='km' onkeypress="return isNumberKey(event)" onkeyup="return limitlength(this, 10)" autocomplete="off" class="form-control" tabindex="24"  />
                          
						  </div>
                        </div>
                          <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">   Type of Vehicle: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                           <select name="type_of_vehicle" id="type_of_vehicle" class="form-control"  tabindex="25">
                            
							<option value="">Please Select  </option>
						
                     		<option value="Private">Private</option>
                       		<option value="T permit">T permit </option>
                       		
                        
                       	</select>
                     	</div>
                     </div>
                     <div class="form-group ">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Outright\Exchange: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12"> 
                          	 <input type="text"  placeholder="Enter Outright\Exchange" id="outright" name='outright'  class=" form-control" tabindex="26"/>
                                           
                        
                       
                     	</div>
                     </div>
                      <div class="form-group ">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Old Car Owner Name: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                          	<input type="text" class="form-control"  name="old_car_owner_name" id="old_car_owner_name" placeholder="Old Car Owner Name" tabindex="27"/>
                       
                     	</div>
                     </div>
                     
                 
                     <div class="form-group ">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Image Uploaded : </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                           <select name="photo_uploaded" id="photo_uploaded" class="form-control"  tabindex="28">
                            
							<option value="">Please Select  </option>
						
                     		<option value="Yes">Yes</option>
                       		<option value="No">No </option>
                       		
                        
                       	</select>
                     	</div>
                     </div>
                     <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">HP: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                           <select name="hp" id="hp" class="form-control"  onchange="change_hp();" tabindex="29">
                            
							<option value="">Please Select  </option>
						
                     		<option value="Yes">Yes</option>
                       		<option value="No">No </option>
                       		
                        
                       	</select>
                     	</div>
                     </div>
                        <div class="form-group ">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Finacier Name: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                          	<input type="text" class="form-control"  name="financier_name"  placeholder="Enter Finacier Name" id ="financier_name" tabindex="30"/>
                       
                     	</div>
                     </div>
                        <div class="form-group ">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Any Accidental Claim: </label>
                         <div class="col-md-8 col-sm-8 col-xs-12">
                            <select name="claim" id="claim" class="form-control"  tabindex="31">
                         
							 <option value="">Please Select  </option>
								
							 <option value="Yes">Yes</option>
                     		<option value="No">No</option>
                     	 	</select>
                          </div>
                        </div>
                        
                         <div class="form-group  ">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">   Accidental Details: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12"> 
                          	 <input type="text"  placeholder="Enter Accidental Details" id="accidental_details" name='accidental_details'  class=" form-control" tabindex="32"/>
                                           
                        
                       
                     	</div>
                     </div>
                        
                          
                     </div>
                     <div class="col-md-6">
                     	  <div class="form-group ">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Insurance Type: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12"> 
                          	 <input type="text"  placeholder="Enter insurance Type" id="insurance_type" name='insurance_type'  class=" form-control" tabindex="33" />
                                           
                        
                       
                     	</div>
                     </div>
              <div class="form-group ">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Insurance company: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12"> 
                          	 <input type="text"  placeholder="Enter  Insurance company" id="insurance_company" name='insurance_company'  class=" form-control" tabindex="34"/>
                                           
                        
                       
                     	</div>
                     </div>
                      <div class="form-group ">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Insurance Validity date: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12"> 
                          <input type="text"  placeholder="Enter Insurance Validity date" id="insurance_validity_date" name='insurance_validity_date'  class="datett form-control"   style="background:white; cursor:default;" tabindex="35"/>
                   
                       
                     	</div>
                     </div>
                       
                        
                      
                          <div class="form-group ">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">  Tyre conditon: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                              <input type="text"  placeholder="Enter Tyre conditon" id="tyre_conditon" name='tyre_conditon'  autocomplete="off" class="form-control"  tabindex="36" />
                          
						  </div>
                        </div>
                         <div class="form-group ">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Engine work: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                              <input type="text"  placeholder="Enter Engine work" id="engine_work" name='engine_work'  autocomplete="off" class="form-control"  tabindex="37" />
                          
						  </div>
                        </div>
                        <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Body work: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                              <input type="text"  placeholder="Enter Body work" id="body_work" name='body_work'  autocomplete="off" class="form-control"   tabindex="38"/>
                          
						  </div>
                        </div>
                       <div class="form-group ">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">   Vehicle Sale Category: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12"> 
                          <select name="vechicle_sale_category" id="vechicle_sale_category" class="form-control" tabindex="39" >
                         
							 <option value="">Please Select  </option>
								
							 <option value="Customer">Customer</option>
                     		<option value="Dealer">Dealer</option>
                     	 	</select>
                       
                     	</div>
                     </div>
                  
                      <div class="form-group ">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Expected Date of Sale: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12"> 
                          <input type="text" placeholder="Enter Expected Date of Sale" name="expected_date_of_sale" id="expected_date_of_sale" class="datett form-control" tabindex="40" >
                         
                       
                     	</div>
                     </div>
                     <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Agent Name: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12"> 
                          <input type="text" placeholder="Enter Agent Name" name="agent_name" id="agent_name" class="form-control"  tabindex="41">
                         
                       
                     	</div>
                     </div>
                      <div class="form-group ">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">  Agent Commision payable: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12"> 
                          <input type="text" placeholder="Enter Agent Commission Payable" name="agent_commision_payable" id="agent_commision_payable" class="form-control" tabindex="42" >
                         
                       
                     	</div>
                     </div>
                   
                     <div class="form-group ">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Refurbish cost Bodyshop: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12"> 
       
                            <input type="text"  placeholder="Enter Refurbish cost Bodyshop" id="refurbish_cost_bodyshop" name='refurbish_cost_bodyshop'  autocomplete="off" class="form-control" tabindex="43"  />
                          
                       
                     	</div>
                     </div>
                     <div class="form-group ">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name" style="padding-left: 0px;
padding-right: 0px;">Refurbish cost Mecahanical: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12"> 
                        
                            <input type="text"  placeholder="Enter Refurbish cost Mecahanical" id="refurbish_cost_mecahanical" name='refurbish_cost_mecahanical'  autocomplete="off" class="form-control"  tabindex="44" />
                          
                       
                     	</div>
                     </div>
                         <div class="form-group ">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Refurbish cost Tyre: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12"> 
                        
                            <input type="text"  placeholder="Enter Refurbish cost Tyre" id="refurbish_cost_tyre" name='refurbish_cost_tyre'  autocomplete="off" class="form-control" tabindex="45"  />
                          
                       
                     	</div>
                     </div>
                       <div class="form-group ">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Refurbish cost Battery: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12"> 
                        
                            <input type="text"  placeholder="Enter Refurbish cost battery" id="refurbish_cost_battery" name='refurbish_cost_battery'  autocomplete="off" class="form-control"  tabindex="46" />
                          
                       
                     	</div>
                     </div>
                       <div class="form-group ">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Refurbish Other: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12"> 
                        
                            <input type="text"  placeholder="Enter Refurbish Other" id="refurbish_other" name='refurbish_other'  autocomplete="off" class="form-control" tabindex="47"  />
                          
                       
                     	</div>
                     </div>
                      <div class="form-group ">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Total RF: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12"> 
                        
                            <input type="text"  placeholder="Enter Total RF" id="total_rf" name='total_rf'  autocomplete="off" class="form-control"  tabindex="48" />
                          
                       
                     	</div>
                     </div>
                     <div class="form-group ">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name" > Price (RF & commission): </label>
                          <div class="col-md-8 col-sm-8 col-xs-12"> 
                        
                            <input type="text"  placeholder="Enter Price With RF & commission" id="price_with_rf_and_commission" name='price_with_rf_and_commission'  autocomplete="off" class="form-control" tabindex="49"  />
                          
                       
                     	</div>
                     </div>
                           <div class="form-group ">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Expected Price: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                              <input type="text"  placeholder="Enter Expectations Price" id="expected_price" name='expected_price' onkeypress="return isNumberKey(event)" onkeyup="return limitlength(this, 10)" autocomplete="off" class="form-control" tabindex="50"  />
                          
						  </div>
                        </div>
                       </div>
                        <script>
                        	function change_payment () {
							  if(document.getElementById("payment_check").checked==true){
							  	document.getElementById("payment_details").style.display = "block";
							  	document.getElementById("selling_price").disabled = false;
							  		document.getElementById("bought_at").disabled = false;
							  		document.getElementById("bought_date").disabled = false;
							  		document.getElementById("payment_date").disabled = false; 
							  		document.getElementById("payment_mode").disabled = false; 
							  		document.getElementById("payment_made_to").disabled = false;  
							  	 
							  	
							  }else{
							  	document.getElementById("selling_price").disabled = true;
							  		document.getElementById("bought_at").disabled = true;
							  		document.getElementById("bought_date").disabled = true;
							  		document.getElementById("payment_date").disabled = true; 
							  		document.getElementById("payment_mode").disabled = true; 
							  		document.getElementById("payment_made_to").disabled = true; 
							  		document.getElementById("payment_details").style.display = "none";
							  		
							  		
							  }
							}
                        </script>
                                    	<?php  if((isset($insert_poc_purchase_tracking[3]) && $_SESSION['process_id']==8))
				  { 
				  	if($insert_poc_purchase_tracking[3] == '1') {?>
                           <div class="form-group col-md-12"><input type="checkbox" onclick="change_payment()" id="payment_check" name="payment" value="payment" tabindex="51">     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">  Payment Details</label></div>
                      <?php } } ?>
                        <div id="payment_details" style="display: none">
                        	<div class="col-md-6">
                            <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Selling Price: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                              <input type="text"  placeholder="Enter Selling Price" id="selling_price" name='selling_price' onkeypress="return isNumberKey(event)" onkeyup="return limitlength(this, 10)" autocomplete="off" class="form-control"  tabindex="52" required  disabled/>
                          
						  </div>
                        </div>
                        
                         <div class="form-group ">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Bought at Price: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                              <input type="text"  placeholder="Enter Bought At" id="bought_at" name='bought_at' onkeypress="return isNumberKey(event)" onkeyup="return limitlength(this, 10)" autocomplete="off" class="form-control" tabindex="53" required   disabled/>
                          
						  </div>
                        </div>
						
                          <div class="form-group ">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Bought Date: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                              <input type="text"  placeholder="Enter Bought Date" id="bought_date" name='bought_date' class="datett  form-control"   required tabindex="54" disabled/>
                          
						  </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                         <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Payment date: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                          	
                              <input type="text"  placeholder="Enter Payment date" id="payment_date" name='payment_date' class="datett col-md-12 form-control"   required tabindex="55" disabled/>
                          
						  </div>
                        </div>
                    
                    
                         <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Payment mode: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                           <select name="payment_mode" id="payment_mode" class="form-control" required tabindex="56"  disabled>
                         
							 <option value="">Please Select  </option>
								
							 <option value="Cash">Cash</option>
                     		<option value="Cheque">Cheque</option>
                     	 	</select>
						  </div>
                        </div>
                         <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Payment Made to: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                              <input type="text"  placeholder="Enter Payment Made to" id="payment_made_to" name='payment_made_to' tabindex="57" class="form-control" required  disabled />
                          
						  </div>
                        </div>
                       </div>
                    		</div>
                          
                          
                       
					</div>
                   </div>
                   
                      
                    
                       
                     
                  
                                           
                </div>
            
			   
			   
			   

         
       
            <div class="form-group">
             	<div class="col-md-2 col-md-offset-5">
                  <button type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12" tabindex="58">Submit</button>
                 </div>
                 <div class="col-md-2">
                    <button type="reset" class="btn btn-primary col-md-12 col-xs-12 col-sm-12" tabindex="59">Reset</button>
                 </div>
            </div>
            
             </form>
          </div>
         </div>
      </div>
  
    <?php }} ?>

<?php if(count($select_followup_lead)>0)
{?><div class="col-md-12 table-responsive" style="overflow-x:scroll">         
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
				</table>		                        </div>
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
										
						<?php if((isset($insert_poc_purchase_tracking[5]) && $_SESSION['process_id']==8))
				  {
				  	if($insert_poc_purchase_tracking[5]==1){ ?>
												<h4 style='text-align: center'>Add Escalation </h4>
												<br>
										<form action="<?php echo site_url();?>add_followup_evaluation_tracking/insert_escalation_detail" method="post">
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
										
                    	 <?php if((isset($insert_poc_purchase_tracking[6]) && $_SESSION['process_id']==8))
				  {
				  	if($insert_poc_purchase_tracking[6]==1){ ?>
                    			<h4 style='text-align: center'>Resolve Escalation </h4>
                    			<br>
										<form action="<?php echo site_url();?>add_followup_evaluation_tracking/insert_escalation_resolve_detail" method="post">
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
<?php unset($insert_poc_purchase_tracking); ?>	