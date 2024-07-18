<script>
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
		function select_assign_to()
		{
		var tlocation1 = document.getElementById("tlocation1").value;
		//alert(make);

		$.ajax({
		url : '<?php echo site_url('add_followup/select_assign_to'); ?>',
		type : 'POST',
		data : {'tlocation1' : tlocation1,},
		success : function(result) {
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
	var eagerness_old='<?php echo $lead_detail[0]->eagerness;?>';
	var disposition_old='<?php echo $lead_detail[0]->disposition_id;?>';

	//New car details
	var new_model_old='<?php echo $lead_detail[0]->new_model_id;?>';
	var new_variant_old='<?php echo $lead_detail[0]->variant_id;?>';
	//var book_old='<?php //echo $lead_detail[0]->buy_status;?>';	
	//Buy old car details
	var buy_make_old='<?php echo $lead_detail[0]->buy_make;?>';	
	var buy_model_old='<?php echo $lead_detail[0]->buy_model;?>';
	var budget_to_old='<?php echo $lead_detail[0]->budget_to;?>';
	var budget_from_old='<?php echo $lead_detail[0]->budget_from;?>';
	var visit_status_old='<?php echo $lead_detail[0]->visit_status;?>';	
	var visit_booked_old='<?php echo $lead_detail[0]->visit_booked;?>';
	var sale_status_old='<?php echo $lead_detail[0]->sale_status;?>';	
	var visit_location_old='<?php echo $lead_detail[0]->visit_location;?>';	
	var car_delivered_old='<?php echo $lead_detail[0]->car_delivered;?>';	
		
	//Sold old car details
	var old_make_old='<?php echo $lead_detail[0]->make_id;?>';
	var old_model_old='<?php echo $lead_detail[0]->model_id;?>';
	var color_old='<?php echo $lead_detail[0]->color;?>';
	var ownership_old='<?php echo $lead_detail[0]->ownership;?>';
	var claim_old='<?php echo $lead_detail[0]->accidental_claim;?>';
	var mfg_old='<?php echo $lead_detail[0]->manf_year;?>';
	var km_old='<?php echo $lead_detail[0]->km;?>';
	
	
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
			if(eagerness_old == '')
			{
			
			  document.getElementById("eagerness").value = "";
	  
			}else{
				document.getElementById("eagerness").value = eagerness_old;
			}
			
			if(disposition_old == '')
			{
			
			  document.getElementById("disposition1").value = "";
	  
			}else{
				document.getElementById("disposition1").value = disposition_old;
			}
			
			if(new_model_old == '' || new_model_old == 0)
			{
			
			  document.getElementById("new_model").value = "";
	  
			}else{
				document.getElementById("new_model").value = new_model_old;
			}
			if(new_variant_old == '' || new_variant_old == 0)
			{
			
			  document.getElementById("new_variant").value = "";
	  
			}else{
				document.getElementById("new_variant").value = new_variant_old;
			}
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
			if(buy_model_old == '' || buy_model_old == 0)
			{
			
			  document.getElementById("buy_model").value = "";
	  
			}else{
				document.getElementById("buy_model").value = buy_model_old;
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
			if(visit_status_old == '')
			{
			
			  document.getElementById("visit_status").value = "";
	  
			}else{
				document.getElementById("visit_status").value = visit_status_old;
			}
			if(visit_booked_old == '')
			{
			
			  document.getElementById("visit_booked").value = "";
	  
			}else{
				document.getElementById("visit_booked").value = visit_booked_old;
			}
			if(sale_status_old == '')
			{
			
			  document.getElementById("sales_status").value = "";
	  
			}else{
				document.getElementById("sales_status").value = sale_status_old;
			}
			if(visit_location_old == '')
			{
			
			  document.getElementById("visit_location").value = "";
	  
			}else{
				document.getElementById("visit_location").value = visit_location_old;
			}
			if(car_delivered_old == '')
			{
			
			  document.getElementById("car_delivered").value = "";
	  
			}else{
				document.getElementById("car_delivered").value = car_delivered_old;
			}
			if(old_make_old == '' || old_make_old == 0)
			{
			
			  document.getElementById("make").value = "";
	  
			}else{
				document.getElementById("make").value = old_make_old;
			}
			if(old_model_old == '' || old_model_old == 0)
			{
			
			  document.getElementById("model").value = "";
	  
			}else{
				document.getElementById("model").value = old_model_old;
			}
			if(color_old == '')
			{
			
			  document.getElementById("color").value = "";
	  
			}else{
				document.getElementById("color").value = color_old;
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
			
			
			
						
						
}
</script>
<body onload="check_buyer('<?php echo $lead_detail[0] -> buyer_type; ?>');check_values();">
<div class="container " style="width: 100%;">
	<div class="row">
		<div id="abc">
<?php $today = date('d-m-Y'); ?>
                       <h1 style="text-align:center;">Follow Details</h1>
                        
                       <br/>
                       <p style="text-align:center;"> Name: <b style="font-size: 15px;"><?php if(isset($lead_detail[0] -> name)){echo $lead_detail[0] -> name;} ?></b></p>
                       <p style="text-align:center;">Contact: <b style="font-size: 15px;"><?php if(isset($lead_detail[0] -> name)){ echo $lead_detail[0] -> contact_no; }?></b></p>
 	 <a id="sub" style="margin-top: -50px" class="pull-right"  href="<?php echo site_url();?>accessories_lead/lms_details/<?php echo $lead_detail[0] -> enq_id; ?>">
	
<i class="btn btn-info entypo-doc-text-inv">Customer Details</i>
</a>
 	 <div class="panel panel-primary">
     	<div class="panel-body">
     		<form action="<?php echo site_url();?>accessories_add_followup/insert_followup" method="post">
			
                	<input type="hidden" name="booking_id" id='enq_id' value="<?php echo $lead_detail[0] -> enq_id; ?>">
                	<input type="hidden" name="phone" value="<?php echo $lead_detail[0]->contact_no;?>">
					<input type="hidden" name="loc" value="">
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<!-- Basic Followup -->
                     	 <div class="panel panel-primary">
 							<div class="panel-body">
                         		<div class="col-md-6">
                         	   		<div class="form-group">
                                    	<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Activity:</label>
                                        	<div class="col-md-8 col-sm-8 col-xs-12">
                                            <select name="activity" class="form-control" required>
                                            	<option value="Outbound Call">Outbound Call</option>
                                            <option value="Inbound Call">Inbound Call</option>
                                    	 	
                                        	<option value="Email">Email</option>
                                        	<option value="SMS">SMS</option>
                                            </select>
                                            </div>
                                      </div>
                              		<div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Status: </label>
                                   	<div class="col-md-8 col-sm-8 col-xs-12">
                                                   <select name="status1" class="form-control" required onchange='check_status(this.value);'>
                                	<?php if($lead_detail[0] -> status_id==1)
                                	{?>
                                		<option value="">Please Select</option>
                                		
                                	<?php }else{ ?>
                                		<option value="<?php echo $lead_detail[0] -> status_id; ?>"><?php echo $lead_detail[0] -> status_name; ?></option>
                                	
                                		<?php }foreach ($status as $row1) { ?>
										
                                		<option value="<?php echo $row1 -> status_id; ?>"><?php echo $row1 -> status_name; ?></option>
                                		<?php } ?>
                                </select>
                                            </div>
                                                               </div>
                 
                                  
                                        <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Email:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text"  placeholder="Enter Email"  name='email'  id="email" class="form-control" value="<?php echo $lead_detail[0] -> email; ?>"/>
                                            </div>
                                                               </div>
                                      
                                         
                                        <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" >Address:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                  	<textarea placeholder="Enter Address" name='address' id="location" class="form-control" /><?php echo $lead_detail[0] -> address; ?></textarea>
                                          
                                            </div>
                                      </div>
                        
                                                <input type="hidden" value="<?php echo date("Y-m-d"); ?>" name="date"   class="form-control" style="background:white; cursor:default;" />
                                    
                                	
                                
                                      
                               

                                   
                         </div>
                         <div class="col-md-6">
                         	     <div class="form-group">
                      <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Eagerness:
                                            </label>
                                             <div class="col-md-8 col-sm-8 col-xs-12">
							<select class="form-control" id="eagerness" name="eagerness" required>
							
							<option value="">Please Select</option>		
												
							<option value="HOT">HOT</option>		
							<option value="WARM">WARM</option>		
							<option value="COLD">COLD</option>		
							</select>		
							</div>				
						</div>
					
                                 <div id="disposition_div" class="form-group" >
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Disposition:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                  <select name="disposition1" id="disposition1" class="form-control" onchange='check_status1(this.value);' required >
                                                     <option value="">Please Select</option>
                                       <?php 
                                       foreach($disposition as $row)
									{?>
						 <option value="<?php echo $row -> disposition_id; ?>"><?php echo $row -> disposition_name; ?></option>
										<?php }?>
							

							
                                    
                                
                                        
                                         </select>
                                            </div>
                                      </div> 
             
                                      
                              <div class="form-group" id='nfd'>
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Follow Up Date:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <input type="text"  placeholder="Enter Next Follow Up Date" id="datett" name='followupdate'  class="datett form-control" required readonly style="background:white; cursor:default;" />
                                           
                                            </div>
                                                               </div>
                                                            
									
     
                                     <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Remark:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <textarea placeholder="Enter Remark" name='comment'  class="form-control" /></textarea>
                                            </div>
                                                               </div>
                                     
                                     
									  
                                      
                           
                                                              </div>
                                                              
                                                             </div>
                                                             </div>
               <!-- -->
             
            <!-- Check Buyer Type --
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
                       							<option value="Exchange With Old Car">Exchange with Old Car</option>
                       							<option value="Buy Used Car">Buy Used Car</option>
												<option value="Sell Used Car">Sell Used Car</option>
                    							<option value="Additional">Additional</option>
                   							</select>
                                       </div>
                                   </div>
                                   </div>
                                   </div>
       <!-- New Car Details--
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
                        <!-- <div class="form-group">
                                   <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Booked:</label>
                                     <div class="col-md-8 col-sm-8 col-xs-12">
                                        <select name="book_status" id="book" class="form-control"  >
                                          
											<option value="No">No</option>
                     						<option value="Yes">Yes</option>
                 							</select>
                                           </div>
                                </div>--
                           </div>
                           <div class="col-md-6">
                           	 <div class="form-group" id="variant">
                                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">New Car Variant:</label>
                                     <div class="col-md-8 col-sm-8 col-xs-12">
                                       <select name="new_variant" id="new_variant" class="form-control"  >
                                       
											<option value="">Please Select  </option>
											<?php	foreach($model_variant as $row){?>
		<option value="<?php echo $row -> variant_id; ?>"><?php echo $row -> variant_name; ?></option>
        <?php } ?>
										</select>
                                     </div>
                                </div>
                             
                                    
                        	 </div>
                   	  </div>
                  </div>
               </div>-->
               <!-- buy Used  Car Details -
               <div class="panel panel-primary" id="buy_used_car" >
       				<h3 class="text-center">Buy Used Car Details</h3>
     			 <div class="panel-body">
     			 	<div class="col-md-12">
     			 		<div class="col-md-6">
     			 			<div class="form-group">
                             <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Car Make: </label>
                             	<div class="col-md-8 col-sm-8 col-xs-12">
                                	<select name="buy_make" id="buy_make" class="form-control" required  onchange="select_buy_model();">
                                    
										<option value="">Please Select  </option>
										<?php  foreach($makes as $row){ ?>
										<option value="<?php echo $row -> make_id; ?>"><?php echo $row -> make_name; ?></option>
                     					<?php } ?>
                  						</select>
                                 </div>
                             </div>
                             </div>
                             <div class="col-md-5" style="width: 38.6%;">
                               <div class="form-group"  id="buy_model_div">
                             <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name" style="width: 43.333%;"> Car Model:</label>
         					<div class="col-md-8 col-sm-8 col-xs-12" style="width: 56.667%;">
                                <select name="buy_model" id="buy_model" class="form-control" required >
                                    
									<option value="">Please Select  </option>
									<?php  foreach($make_model as $row){ ?>
										<option value="<?php echo $row -> model_id; ?>"><?php echo $row -> model_name; ?></option>
                     					<?php } ?>
								
                      			 </select>
                               </div>
                          </div>
                          </div>
                        	 <div class="col-md-1" style="width: 11.400%">
                          <a onclick="insert_make_model()" class=" col-md-12 col-xs-12 col-sm-12"  style="cursor:pointer"><u>Add New</u></a>

     			 	</div>
     			 </div>
     			 <div class="col-md-12" id="replace_data">
     			 	
     			 </div>
                  	<div class="col-md-12">
             
	                	<div class="col-md-6"> 
	                	
                        
                             
                          	<div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Budget From: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                          
                          	<select name="budget_from" id="budget_from" class="form-control" required >
                                    
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
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Visit Status: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                           <select name="visit_status" id="visit_status" class="form-control" required  onchange="check_visitstatus(this.value)">
                           
							<option value="">Please Select  </option>
							
                     		<option value="Yes">Yes</option>
                       		<option value="No">No</option>
                       		
                       	</select>
                     	</div>
                     </div> 
                       <div class="form-group" id="visit_booked_div">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Visit Booked :</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                	<select name="visit_booked" id="visit_booked" class="form-control">
                                       
												<option value="">Please Select  </option>
										
											<option value="Home Visit">Home Visit</option>
											<option value="Store Visit">Store Visit</option>
											<option value="Call Back">Call Back</option>
                       					</select>
                                </div>
                            </div>
                          <div class="form-group">
                         <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Sale Status : </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                             <select name="sales_status" id="sales_status" class="form-control"  >
                              
							 <option value="">Please Select  </option>
								
							 <option value="Sold">Sold</option>
                     		<option value="Not Interested">Not Interested</option>
                     		<option value="Undecided">Undecided</option>
                     		<option value="Booked ">Booked</option>
                     		 

                     	 	</select>
                     	 	 </div>
                        </div>
                      
					</div>
                    <div class="col-md-6">
                    	  <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Budget To: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                        
                          	<select name="budget_to" id="budget_to" class="form-control" required >
                                    
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
                    	  <div class="form-group" id="visit_location_div">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Visit Location:</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                	<select name="visit_location" id="visit_location" class="form-control">
                                      
												<option value="">Please Select  </option>
										
									<?php foreach($get_location1 as $fetch1){ ?>
												<option value="<?php echo $fetch1 -> location; ?>"><?php echo $fetch1 -> location; ?></option>
                     							 <?php } ?>
                       					</select>
                                </div>
                            </div>
                      
                     <div class="form-group" id="visit_booked_date_div">
                      <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Visit Booked Date : </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text"  placeholder="Enter Visit Booked Date" id="visit_date" value="<?php if($lead_detail[0] ->  visit_booked_date!='0000-00-00'){ echo $lead_detail[0] ->  visit_booked_date; }?>" name='visit_date'  class="datett form-control" required readonly style="background:white; cursor:default;" />
                                           
                           </div>
                        </div>
                      
                          <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Car Delivered: </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                           <select name="car_delivered" id="car_delivered" class="form-control"  >
                         
							
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
             <!-- Exchange Car Details --
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
                            
                            <div class="form-group">
                              <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Colour:</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                   <input type="text"  placeholder="Enter Colour" id="color" name='color' onkeypress="return alpha(event)" autocomplete="off"  class=" form-control" required />
                                </div>
                            </div>
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
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Any Assidental Claim: </label>
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
                     <div class="form-group"  id="model_div">
                               <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Car Model:</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <select name="old_model" id="model" class="form-control" required >
                                    
									<option value="">Please Select  </option>
								
								<?php  foreach($make_model as $row){ ?>
										<option value="<?php echo $row -> model_id; ?>"><?php echo $row -> model_name; ?></option>
                     					<?php } ?>
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
               <!-- Transfer and send quotation --
      
				<div class="panel panel-primary">
                	<div class="panel-body">
                		 <?php $insert= $_SESSION['insert'];
                        if($insert[12]==1)
						{ ?>
     					<div class="col-md-6">                      		
                        	<div class="form-group">
  								 <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">Click Here To Transfer Lead: </label>
                                 	<div class="col-md-5 col-sm-5 col-xs-12">
                                     	<label class="checkbox-inline "><input type="checkbox" id="transfer" name="transfer" onclick="transfer_lead()" >Yes</label>
                                     	</div>
                                    </div>  
                               </div>
                                    <?php } ?>
                               <div class="col-md-6">                      		
                                 <div class="form-group">
  									<label class="control-label col-md-6 col-sm-6 col-xs-12" for="first-name">Click Here To Send Quotation :  </label>
                                  	<div class="col-md-4 col-sm-4 col-xs-12">
                                        <label class="checkbox-inline "><input type="checkbox" id="quotation" name="quotation" onclick="send_quotation()" >Yes</label>
									</div>
                                  </div>  
                                </div>
                               </div>
                              </div>
               <!-- Send Quotation div --
            <div id="quotation1"  style="display: none">
            	<div class="panel panel-primary">
                	<div class="panel-body">
              	<div class="col-md-6">
    		 			<div class="form-group">
    	                   <label class="control-label col-md-4 col-sm-4 col-xs-12" > Location: </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                             <select name="qlocation" id="qlocation" class="form-control" required disabled=true onchange="select_model_name();">
                          	 	 <option value="">Please Select  </option>
										 <?php foreach ($select_city as $row) {?>
                      			<option value="<?php echo $row->city;?>"><?php echo $row->city;?></option>
								  <?php } ?>
                                  <?php foreach ($select_city1 as $row) {?>
                      			<option value="<?php echo $row->city;?>"><?php echo $row->city;?></option>
					  			<?php } ?>
					  			 <?php foreach ($select_city2 as $row) {?>
                      			<option value="<?php echo $row->city;?>"><?php echo $row->city;?></option>
					  			<?php } ?>
                   				<option value="PANVEL"> PANVEL  </option>
                   					<option value="NON LBT"> Outside Pune  </option>
                     		</select>
                        </div>
                     </div>
                     
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
    	                 <label class="control-label col-md-4 col-sm-4 col-xs-12" >Model Name: </label>
                       <div class="col-md-8 col-sm-8 col-xs-12" id="model_name_div">
                          <select name="model_name" id="model_name" class="form-control" required disabled=true>
                              <option value="">Please Select  </option>
							</select>
                         </div>
                        </div>
                   </div>
                   <div class="col-md-6">
                       <div id="desc_div">
                          <div  class="form-group">
                           <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Description:</label>
                            	<div class="col-md-8 col-sm-8 col-xs-12" id="description_div">
                                    <select name="description" id="description" class="form-control"  disabled=true>
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
					<!-- Transfer Div --
				<div id="tassignto" style="display: none">
					<div class="panel panel-primary">
                	<div class="panel-body">
                 <div class="col-md-6">
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
                        <div class="col-md-6">
                           <div class="form-group">
    	                        <label class="control-label col-md-4 col-sm-4 col-xs-12" >Transfer Reason:</label>
                                 <div class="col-md-8 col-sm-8 col-xs-12">
                                    <select name="transfer_reason" id="transfer_reason" class="form-control" required disabled=true>
                                        <option value="">Please Select  </option>
										<option value="Test Drive Alloted">Test Drive Alloted</option>
                       					<option value="Home visit Alloted">Home visit Alloted</option>
                       					<option value="Showroom Visit">Showroom Visit</option>
                        				<option value="Final Deal">Final Deal</option>
                        				<option value="Finance Issue">Finance Issue</option>
                         				<option value="POC">POC</option>
                             			<option value="Final Quotation Required">Final Quotation Required</option>   
                              			<option value="Evaluation Alloted">Evaluation Alloted</option>   
                           			</select>
                                   </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                               <div id="assign_div">
                                 <div  class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Assign To:</label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                           <select name="transfer_assign" id="tassignto1" class="form-control" required disabled=true>
                                         		<option value="">Please Select</option> 
											</select>
                                          </div>
                                      </div>
                                    </div>
                                 </div>
								<div class="col-md-12 form-group">
								 <label class="control-label col-md-2 col-sm-2 col-xs-12" >Group: </label>
									<div class="col-md-9 col-sm-9 col-xs-12" >
									<?php foreach($select_group as $row2){?>
										<label class="checkbox-inline"><input type="checkbox" name="group_id[]" value="<?php echo $row2 -> group_name; ?>"><?php echo $row2 -> group_name; ?></label>
									<?php } ?>
									</div>
								</div>
							</div>
						</div>
				 </div>-->
           
       
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
  
    
<?php if($lead_detail[0]->followup_id!='')
{?>
	<table class="table table-bordered datatable" id="results"> 
					<thead>
						<tr>
		
							<th>Activity</th>
							<th>Location</th>
							<th>Follow Up By</th>
							<th>Call Date</th>		
							<th>N.F.D</th>
							<th>Status</th>
							<th>Disposition</th>					
							<th>Remark</th>	
						</tr>	
					</thead>
					<tbody>
						<?php
						
						foreach($select_followup_lead as $row)
						{
							$activity=$row->activity;
							
						
						?>
						<tr>
						
							<td><?php echo $activity; ?></td>
							<td><?php echo $lead_detail[0] -> location; ?></td>
							<td><?php echo $row -> fname . ' ' . $row -> lname; ?></td>
							<td><?php echo $row -> c_date; ?></td>
							<td><?php echo $row -> nextfollowupdate ?></td>
							<td><?php echo $row -> status_name; ?></td>
							<td><?php echo $row -> disposition_name; ?></td>
							<td><?php echo $row -> f_comment; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php } ?>
				</div>
			</div> 
	 </div>

<script src="<?php echo base_url();?>assets/js/campaign.js" ></script>
                  