

<div class="row" >
    <h1 style="text-align:center; ">Sourcewise Count</h1>
     	  <div class="col-md-12" >
		<div class="panel panel-primary">              
     	                
     	                 <form  action="<?php echo site_url(); ?>reports/lead_sourcewise_filter" method="get" onsubmit="return validate_download();">     

                  
                            <div class="x_panel">
                        
                            <div class=" col-md-offset-1 col-lg-3 col-md-3 col-sm-3 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group">
                                       
                                               
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="campaign_name"  name="campaign_name"   >
										
													 <option value="">Campaign Name</option>
													
													  <option value="All">All</option>
													   <option value="Facebook">Facebook</option>
													   <?php foreach($select_lead_source as $row)
													  {
													
													  	?>
														<option value="<?php echo $row -> lead_source_name; ?>"><?php echo $row -> lead_source_name; ?></option>
														<?php
														}
													  ?>
													  
													
                                                </select>
											  
                                            </div>
                            </div>
                             
                               
                                
                                    
                                    
                       
							
                                     
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px; ">
                        
                                       <div class="form-group">
                                           
											
                                              <input type="text" id="fromdate" value="<?php //echo date('Y-m-d'); ?>" class="datett filter_s col-md-12 col-xs-12 form-control"  placeholder="From Date" name="fromdate" readonly style="cursor:default;">
										
                                        </div>
                         
                              </div>
                                    
                                    
                                      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;" >
                        
                                       <div class="form-group">
                                           
											
                                              <input type="text" id="todate" value="" class="datett filter_s col-md-12 col-xs-12 form-control" placeholder="To Date"   name="todate" readonly style="cursor:default;">
										
                                        </div>
                            </div>
                                    
                                  
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group">
                                           
											
                                            
                             
                           
                        <!-- <button type="submit" class="btn btn-info" ><i class="entypo-search"> Search</i></button>-->
                            <a  onclick="searchData()" >
                            
                             	 <i class="btn btn-info entypo-search">  Search</i></a>
                         
                           <!--  <a target="_blank" href="<?php echo site_url('new_tracker/download_data/?campaign_name='. $campaign_name .'&nextaction=' .$nextaction .'&feedback='.$feedback .'&fromdate='. $fromdate.'&todate='.$todate.'&date_type='.$date_type ); ?>" >--></a>
                              <!--<a target="_blank" onclick="test()" >
                            
                             	 <i class="btn btn-primary entypo-download">  Download</i></a>-->
                          
                                 <a onclick="reset()" > <i class="btn btn-success entypo-ccw"> Reset</i></a>
                                        </div>
                            </div>
                                     
                    
                                </div>
                                 </form>
    </div>
         </div>
             </div>                     
  <div class="row">
	<div id="leaddiv" class="col-md-12" >
		<div class="control-group" id="blah" style="margin:0% 30% 1% 50%">
				
				</div>
	
        </div>
        
        </div>
        </div>		               
                   <script type="text/javascript">
						$(document).ready(function() {
							$('.datett').daterangepicker({
								singleDatePicker : true,
								format : 'YYYY-MM-DD',
								calender_style : "picker_1"
							}, function(start, end, label) {
								console.log(start.toISOString(), end.toISOString(), label);
							});

							$('#fromdate').daterangepicker({
								singleDatePicker : true,
								format : 'YYYY-MM-DD',
								calender_style : "picker_1"
							}, function(start, end, label) {
								console.log(start.toISOString(), end.toISOString(), label);
							});

							$('#todate').daterangepicker({
								singleDatePicker : true,
								format : 'YYYY-MM-DD',
								calender_style : "picker_1"
							}, function(start, end, label) {
								console.log(start.toISOString(), end.toISOString(), label);
							});

							//Code for Hide & Show for select control

						});						

						

                    </script>
					
<script>
	$(document).ready(function() {
		$("#fromdate1").click(function() {
			$("#leaddate1").toggle();
		});
	}); 
</script>
 
 					
<script>
	$(document).ready(function() {
		$("#leaddate1").click(function() {
			$("#fromdate1").toggle();
		});
	}); 
</script>

<script>
function test()
{
	var c=document.getElementById("campaign_name").value;
	var nextaction=document.getElementById("nextaction").value;
	var feedback=document.getElementById("feedback").value;
	var f=document.getElementById("fromdate").value;
	var t=document.getElementById("todate").value;
	var date_type=document.getElementById("date_type").value;
	if(f=='' || t=='' || date_type==''){
		alert("Please select Date type,From date,To date");
		return false;
	}
	var ur="<?php echo site_url(); ?>";
	window.open(ur+"new_tracker/download_data/?date_type="+date_type+"&fromdate="+f+"&todate="+t+"&nextaction="+nextaction+"&feedback="+feedback+"&campaign_name="+c,"_blank");
}
</script>      
<script>
function reset()
{
	document.getElementById("fromdate").value='';
		document.getElementById("todate").value='';
	var radios = document.getElementsByName('campaign_name');
$( 'input[type=radio]' ).prop( "checked", false );

	//window.open("<?php echo site_url()?>/reports/lead_sourcewise");
}
	function validate_download() {

		var f = document.getElementById("fromdate").value;
		var t = document.getElementById("todate").value;
	

		if (f == '' || t == ''  ) {
			alert("Please select From date and To date");
			return false;
		}
	}
	</script>
	<script>
	function searchData()
	{
		
		var c = document.getElementById("campaign_name").value;
		var f = document.getElementById("fromdate").value;
		
		var t = document.getElementById("todate").value;
		if (f == '' || t == '' ) {
			alert("Please select From date and To date");
			
		}
		else
		{
			//Create Loader
					
			src1 ="<?php echo base_url('assets/images/loader200.gif'); ?>
						";
						var elem = document.createElement("img");
						elem.setAttribute("src", src1);
						elem.setAttribute("height", "95");
						elem.setAttribute("width", "250");
						elem.setAttribute("alt", "loader");

						document.getElementById("blah").appendChild(elem);
						<?php 
							$ajaxurl= site_url()."reports/lead_sourcewise_filter";
						
						?>

						$.ajax({url: "<?php echo $ajaxurl; ?>",
	type:"POST",
	data:{fromdate:f,todate:t,campaign_name:c},
	success: function(result){
	$("#leaddiv").html(result)
	} });

		}
		
	}
	
</script>    



      
               