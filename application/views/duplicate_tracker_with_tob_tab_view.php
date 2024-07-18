
<!--<ol class="breadcrumb bc-3" > <li> <a href=""><i class="fa fa-home"></i>Home</a> </li><li class="active"> <strong>Report</strong> </li> </ol>-->
<script>
function test()
{
	var c=document.getElementById("campaign_name").value;
	
	var f=document.getElementById("fromdate").value;
	var t=document.getElementById("todate").value;
	var date_type=document.getElementById("date_type").value;
	if(f=='' || t=='' || date_type==''){
		alert("Please select Date type,From date,To date");
		return false;
	}
	var ur="<?php echo site_url(); ?>";
	window.open(ur+"duplicate_lead_tracker/download_data/?date_type="+date_type+"&fromdate="+f+"&todate="+t+"&campaign_name="+c,"_blank");
}
</script>      
<script>
	function validate_download() {

		var f = document.getElementById("fromdate").value;
		var t = document.getElementById("todate").value;
		var type = document.getElementById("date_type").value;

		if (f == '' || t == '' || type == '') {
			alert("Please select Date type,From date,To date");
			return false;
		}
	}
	function getalldata () {
	  var campaign= '<?php echo $campaign_name ; ?>';
	
	  var fdate= '<?php echo $fromdate ; ?>';
	  var tdate= '<?php echo $todate ; ?>';
	  var type= '<?php echo $date_type ; ?>';	
	   var campaign= campaign.replace('#', "%23");
	  document.getElementById("campaign_name").value= campaign ;
	  /*document.getElementById("nextaction").value= action ;
	  document.getElementById("feedback").value= fback ;*/
	  document.getElementById("fromdate").value= fdate ;
	  document.getElementById("todate").value= tdate ;
	  document.getElementById("date_type").value= type ;
	}
	function reset () { 
	 
	  document.getElementById("campaign_name").value= '' ;
	 /* document.getElementById("nextaction").value= '' ;
	  document.getElementById("feedback").value= '' ;*/
	  document.getElementById("fromdate").value= '' ;
	  document.getElementById("todate").value= '' ;
	  document.getElementById("date_type").value= '' ;
	 window.location="<?php echo site_url();?>duplicate_lead_tracker/leads";
	}
</script>
<!-- Filter-->
<body onload="getalldata();">
<div class="row" >
                  <?php if($_SESSION['process_id']==9)
	{?>
                   <form  action="<?php echo site_url(); ?>duplicate_lead_tracker/tracker_dse_filter_complaint" method="get" onsubmit="return validate_download();">     
     <?php }
     else
     {
     	?>
     	                 <form  action="<?php echo site_url(); ?>duplicate_lead_tracker/tracker_dse_filter" method="get" onsubmit="return validate_download();">     
  <?php
     }?>
                  
                            <div class="x_panel">
                        
                            <div class=" col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group">
                                       
                                               
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="campaign_name"  name="campaign_name"   >
										
													 <option value="">Campaign Name</option>
													
													  <option value="All">All</option>
													   <option value="Manual%23Facebook">Facebook</option>
													   <?php foreach($select_lead_source as $row)
													  {
													
													  	?>
														<option value="<?php echo $row -> lead_source_value; ?>"><?php echo ucwords(strtolower($row -> lead_source_name)); ?></option>
														<?php
														}
													  ?>
													  
														
													 <!--<?php foreach ($select_campaign as $fetch) {
														 ?>
													 
                                             	<option value="Facebook%23<?php echo $fetch -> enquiry_for; ?>"><?php echo $fetch -> enquiry_for; ?></option>
                                              
                                               <?php } ?>-->
                                                </select>
											  
                                            </div>
                            </div>
                             
                                  <!--<div id="disposition_div" class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group">
                                       
                                               
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="feedback" name="feedback" onchange="select_next_action(this.value);">
											
													 <option value="">Feedback</option>
                                             
											<?php foreach($select_feedback as $row)
									{?>
										<option value="<?php echo $row -> feedbackStatusName; ?>"><?php echo $row -> feedbackStatusName; ?></option>
								<?php } ?>
                                               
                                                </select>
                                               
                                                </select>
											  
                                            </div>
                            </div>-->
                                        
                                   <!--  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group" id="next_action_div">
                                       
                                               
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="nextaction" name="nextaction" >
											<option value="">Next Action</option>
										
											
											<?php foreach($select_next_action as $row)
									{?>
										<option value="<?php echo $row -> nextActionName; ?>"><?php echo $row -> nextActionName; ?></option>
								<?php } ?>
                                               
                                                </select>
											  
                                            </div>
                            </div> -->
                                    
                                    
                       
							
                                     
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
                                    
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px; ">
                        
                                       <div class="form-group">
                                           
											
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="date_type" name="date_type">
											
													 <option value="">Date Type</option>
													  <option value="Lead">Lead Date</option>
													  <!-- <option value="CSE">CSE Call Date</option>
													   <?php if($_SESSION['process_id']=='7' || $_SESSION['process_id']=='6'){?>
													   	 <option value="DSE">DSE Call Date</option>
													   	 <option value="DSETLAssign">DSE TL Assign Date</option>
													   	 <option value="DSEAssign">DSE Assign Date</option>
													   	<?php } ?>
													  
                                             		   <?php if($_SESSION['process_id']=='8' ){?>
													   	 <option value="DSE">Evaluator Call Date</option>
													   	 <option value="DSETLAssign">Evaluator TL Assign Date</option>
													   	 <option value="DSEAssign">Evaluator Assign Date</option>
													   	<?php } ?>-->
													  
                                               
                                                </select>
                                        </div>  
                                    
                                    </div>
                            <div class="col-md-offset-4 col-lg-offset-4 col-lg-7 col-md-7 col-sm-7 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group">
                                           
											
                                            
                             
                           
                         <button type="submit" class="btn btn-info" ><i class="entypo-search"> Search</i></button>
                         
                           <!--  <a target="_blank" href="<?php echo site_url('new_tracker/download_data/?campaign_name='. $campaign_name .'&nextaction=' .$nextaction .'&feedback='.$feedback .'&fromdate='. $fromdate.'&todate='.$todate.'&date_type='.$date_type ); ?>" >--></a>
                              <a target="_blank" onclick="test()" >
                            
                             	 <i class="btn btn-primary entypo-download">  Download</i></a>
                          
                                 <a onclick="reset()" > <i class="btn btn-success entypo-ccw"> Reset</i></a>
                                        </div>
                            </div>
                                     
                    
                                </div>
                                 </form>
                                </div>
                              <!-- <a class="pull-right" onclick="download_data()" > <i class="btn btn-info entypo-search">Download</i></a>-->
    <!-- date script -->
                    <script>
							function clear() {
								document.getElementById("status").innerHTML = 'All';

								document.getElementById("fromdate").innerHTML = '';
								document.getElementById("assign_to").innerHTML = '';

								document.getElementById("todate").innerHTML = '';
								test();

							}
    </script>
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

						function Lead_Date_disabled() {

							document.getElementById("lead_date").disabled = true;

						}

						function from_Date_disabled() {

							document.getElementById("fromdate").disabled = true;

						}

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
 
                    




<!--- Fetch Table Data -->
<script><?php
$page = $this -> uri -> segment(4);
if (isset($page)) {
	$page = $page + 1;

} else {
	$page = 0;

}
$offset1 = 100 * $page;
//$query=$sql->result();
//echo $c = count($select_lead);
		?></script>
<div class="row">
	<div id="leaddiv" class="col-md-12" >
		<div class="control-group" id="blah" style="margin:0% 30% 1% 50%">
				
				</div>
	
        </div>
        
        </div>
        </div>		
      
                