<script>
function open_quotation()
{
	$('#send_quotation_modal').modal({
		 backdrop: 'static',
    keyboard: false
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
		
	function modal_close()
	{
		 window.history.back();
	}	
	
</script>
<body class="page-body" onload="open_quotation();">
								
			
  					<div class="modal fade" id="send_quotation_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="pull-right" onclick='modal_close()'>×</button>
                <h3>Send Quotation</h3> </div>
            <div class="modal-body">
                <div class="row">
					<form action="<?php echo site_url();?>add_followup_new_car/send_quotation_from_header" method="POST">
						
				 <div class="col-md-12" >
											<div class="panel panel-primary">
				
						<div class="panel-body">
							<div class="col-md-6">
						<div class="form-group">
                                <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Name:    </label>
                                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="text"  placeholder="Enter Name"  name='customer_name'  id="customer_name"  required class="form-control" tabindex="2"/>
                                            </div>
                                        </div>
                                         </div>
							<div class="col-md-6">
						<div class="form-group">
                                <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Email:    </label>
                                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input type="email"  placeholder="Enter Email"  name='email'  id="email"  required class="form-control" tabindex="2"/>
                                            </div>
                                        </div>
                                         </div>
              	<div class="col-md-6" style="margin-top: 10px">
    		 			<div class="form-group">
    	                   <label class="control-label col-md-12 col-sm-12 col-xs-12" > Location: </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                             <select name="qlocation" id="qlocation" class="form-control" required onchange="select_model_name();">
                          	 	 <option value="">Please Select  </option>
									
                      			<option value="Mumbai">Mumbai</option>
								<option value="Pune">Pune</option>
								
                     		</select>
                        </div>
                     </div>
                     
                  </div>
                  <div class="col-md-6" style="margin-top: 10px">
                      <div class="form-group">
    	                 <label class="control-label col-md-12 col-sm-12 col-xs-12" >Model Name: </label>
                       <div class="col-md-12 col-sm-12 col-xs-12" id="model_name_div">
                          <select name="model_id" id="model_name" class="form-control" required >
                              <option value="">Please Select  </option>
							</select>
                         </div>
                        </div>
                   </div>
                   <br>
				 
                   <div class="col-md-6" style="margin-top: 10px" >
                       
                          <div  class="form-group">
                           <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Variant:</label>
                            	<div class="col-md-12 col-sm-12 col-xs-12" >
                                    <select name="variant"id="description_div" class="form-control" >
                                         <option value="">Please Select</option> 
									</select>
                           		</div>
                            </div>
                          </div>
                    
                           <div class="col-md-6" style="margin-top: 10px" >     
               	 <div  class="form-group  ">
                           <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Type:</label>
						   <div class="col-md-12 col-sm-12 col-xs-12" id="">
	
  <label><input type="radio"  value="Individual" name="quotation_type" required>Individual</label>&nbsp;&nbsp;&nbsp;

  <label><input type="radio" value="Company" name="quotation_type" required>Company</label>

			 </div>
		</div>
	</div>  
	<div class="col-md-12" style="margin: 14px" >     
               	 <div  class="form-group  ">
                           <label class="control-label " for="first-name">Need Finance Quotation : &nbsp;&nbsp;<input type="checkbox" name="finance_data" value="Yes">&nbsp;&nbsp; Yes</label>&nbsp;&nbsp;&nbsp;

		</div>
	</div> 
                        <div id='checkprize_div'>
                        	</div>
					</div>
					</div>
					</div>
							
							
							
       	</div>
       	</div>
       	 <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" >Submit </button>
      </div>
      </form>
       	</div>
       	</div>
       	</div>