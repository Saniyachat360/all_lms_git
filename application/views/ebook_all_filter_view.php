<div class="row">
       	             
                            
                            <div class="x_panel">
                 
                                     
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px; ">
                        
                                       <div class="form-group">
                                           
											
                                              <input type="text" id="payment_fromdate" value="" class="datett filter_s col-md-12 col-xs-12 form-control" placeholder="Payment From Date" name="payment_fromdate" readonly="" style="cursor:default;">
										
                                        </div>
                         
                              </div>
                                    
                                    
                                      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group">
                                           
											
                                              <input type="text" id="payment_todate" value="" class="datett filter_s col-md-12 col-xs-12 form-control" placeholder="Payment To Date" name="payment_todate" readonly="" style="cursor:default;">
										
                                        </div>
                            </div>
                                    
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px; ">
                        
                                       <div class="form-group">
                                           
											
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="payment_status" name="payment_status">
											
													 <option value="">Payment Status</option>
													  <option value="Success">Success</option>
                                             		   													  
                                                <option value="Failure">Failure</option>
                                                </select>
                                        </div>  
                                    
                                    </div>
                            <div class=" col-md-4 col-sm-4 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group">
                         <button type="submit" class="btn btn-info" onclick="search_data();"><i class="entypo-search"> Search</i></button>
                          <a target="_blank" onclick="test()" >
                            
                             	 <i class="btn btn-primary entypo-download">  Download</i></a>
                           <button type="reset" class="btn btn-success" onclick="reset_data()"><i class="entypo-ccw">Reset</i></button>
                          
                                
                                        </div>
                            </div>
                                  <script>
function test()
{
	var payment_fromdate=document.getElementById('payment_fromdate').value;
							var payment_todate=document.getElementById('payment_todate').value;
							var payment_status=document.getElementById('payment_status').value;
							var lead_source='<?php echo $lead_source;?>';
							if(payment_fromdate=='' || payment_todate==''){
								alert('Please select Payment Date');
								return false;
							}
	var ur="<?php echo site_url(); ?>";
	window.open(ur+"ebook_leads/payment_all_download/?payment_fromdate="+payment_fromdate+"&payment_todate="+payment_todate+"&payment_status="+payment_status,"_blank");
}
</script>    
                    
                                </div>
                              
                                </div>
								<script>
						function search_data(){
							var payment_fromdate=document.getElementById('payment_fromdate').value;
							var payment_todate=document.getElementById('payment_todate').value;
							var payment_status=document.getElementById('payment_status').value;
							var lead_source='<?php echo $lead_source;?>';
							if(payment_fromdate=='' || payment_todate==''){
								alert('Please select Payment Date');
								return false;
							}
							//Create Loader
					src1 ="<?php echo base_url();?>assets/images/loader200.gif";
						var elem = document.createElement("img");
						elem.setAttribute("src", src1);
						elem.setAttribute("height", "95");
						elem.setAttribute("width", "250");
						elem.setAttribute("alt", "loader");

						document.getElementById("blah").appendChild(elem);
							 $.ajax({
								 url: "<?php echo site_url();?>ebook_leads/payment_all_filter",
								type:"POST",
								data:{'payment_status':payment_status,'payment_fromdate':payment_fromdate,'payment_todate':payment_todate,'lead_source':lead_source},	
							 success: function(result){
								$("#ebook_filter_div").html(result);
  }});
							
						}
							
							
							</script>