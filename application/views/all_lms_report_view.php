
<!--<ol class="breadcrumb bc-3" > <li> <a href=""><i class="fa fa-home"></i>Home</a> </li><li class="active"> <strong>Report</strong> </li> </ol>-->
<script>
function test()
{
	var c=document.getElementById("campaign_name").value;
	var nextaction=document.getElementById("nextaction").value;
	var feedback=document.getElementById("feedback").value;
	var f=document.getElementById("fromdate").value;
	var t=document.getElementById("todate").value;

	if(f=='' || t==''){
		alert("Please select Date type,From date,To date");
		return false;
	}
	var ur="<?php echo site_url(); ?>";
	window.open(ur+"new_tracker/download_data/?date_type="+date_type+"&fromdate="+f+"&todate="+t+"&nextaction="+nextaction+"&feedback="+feedback+"&campaign_name="+c,"_blank");
}
</script>      
<script>
	function search_data() {

		var f = document.getElementById("fromdate").value;
		var t = document.getElementById("todate").value;
		//var type = document.getElementById("date_type").value;

		if (f == '' || t == '') {
			alert("Please select From date,To date");
			return false;
		}
			  $.ajax({
			  	url: '<?php echo site_url(); ?>all_lms_report/filter_value',
			  	type:'POST',
			  	data:{'fromdate':f,'todate':t}, 
			  	success: function(result){
        $("#serchdiv").html(result);
    }});
			
		}
	
	
	function reset () { 
	 
	  document.getElementById("campaign_name").value= '' ;
	  document.getElementById("nextaction").value= '' ;
	  document.getElementById("feedback").value= '' ;
	  document.getElementById("fromdate").value= '' ;
	  document.getElementById("todate").value= '' ;
	  document.getElementById("date_type").value= '' ;
	 window.location="<?php echo site_url();?>new_tracker/leads";
	}
</script>
<!-- Filter-->
<body>
<div class="row" >
	<div class="col-md-12">
		<h1 style="text-align:center; ">All LMS  Count</h1>
	</div>
               <div class="panel panel-primary">
						<div class="panel-body">			
     	                
                  
                            <div class="x_panel">
                        
                                     
                            <div class="col-md-offset-2 col-lg-3 col-md-3 col-sm-3 col-xs-12" style="padding:20px; ">
                        
                                       <div class="form-group">
                                           
											
                                              <input type="text" id="fromdate" value="<?php //echo date('Y-m-d'); ?>" class="datett filter_s col-md-12 col-xs-12 form-control"  placeholder="From Lead Date" name="fromdate" readonly style="background:#F5F5F5; cursor:default;">
										
                                        </div>
                         
                              </div>
                                    
                                    
                                      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="padding:20px;" >
                        
                                       <div class="form-group">
                                           
											
                                              <input type="text" id="todate" value="" class="datett filter_s col-md-12 col-xs-12 form-control" placeholder="To Lead Date"   name="todate" readonly style="background:#F5F5F5; cursor:default;">
										
                                        </div>
                            </div>
                                    
                                <!--    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px; ">
                        
                                       <div class="form-group">
                                           
											
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="date_type" name="date_type">
											
													 <option value="">Date Type</option>
													  <option value="Lead">Lead Date</option>
													   <option value="CSE">CSE Call Date</option>
													   <?php if($_SESSION['process_id']=='7' || $_SESSION['process_id']=='6'){?>
													   	 <option value="DSE">DSE Call Date</option>
													   	 <option value="DSETLAssign">DSE TL Assign Date</option>
													   	 <option value="DSEAssign">DSE Assign Date</option>
													   	<?php } ?>
													  
                                             		   <?php if($_SESSION['process_id']=='8' ){?>
													   	 <option value="DSE">Evaluator Call Date</option>
													   	 <option value="DSETLAssign">Evaluator TL Assign Date</option>
													   	 <option value="DSEAssign">Evaluator Assign Date</option>
													   	<?php } ?>
													  
                                               
                                                </select>
                                        </div>  
                                    
                                    </div>-->
                            <div class=" col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group">
                                       
                         <button type="submit" onclick="search_data()" class="btn btn-info" ><i class="entypo-search"> Search</i></button>
                         
                           <!--  <a target="_blank" href="<?php echo site_url('new_tracker/download_data/?campaign_name='. $campaign_name .'&nextaction=' .$nextaction .'&feedback='.$feedback .'&fromdate='. $fromdate.'&todate='.$todate.'&date_type='.$date_type ); ?>" >--></a>
                            <!--  <a target="_blank" onclick="test()" >
                            
                             	 <i class="btn btn-primary entypo-download">  Download</i></a>-->
                          
                                 <a onclick="reset()" > <i class="btn btn-success entypo-ccw"> Reset</i></a>
                                        </div>
                            </div>
                                     
                    
                                </div>
                                 </form>
                                </div>
                                </div>
                                </div>
                                <div id="serchdiv">
                                	<?php 
                                	
		 if(isset($select_leads)){
	if(count($select_leads)>0){ ?>
	<div class="col-md-12">
		
				<table class="table table-bordered datatable" id="table-4">
				<thead>
					<tr>
							<th><b>Sr No.</b></th>
							<th><b>Leads</b></th>
							<th><b>Count <?php foreach ($select_leads as $row) { echo '('.$row['from_date'].' TO '.$row['to_date'].')'; }?></b>
							</th>
							
					</tr>
				</thead>
				<tbody>
				
					<tr>
						<td>1</td>
						<td>All Leads</td>
						<?php foreach ($select_leads as $row) { ?>
								<td><?php echo $row['all_leads']; ?></td>
						 <?php } ?>
					
					</tr>
						<tr>
						<td>2</td>
						<td>Facebook Leads</td>
					<?php foreach ($select_leads as $row) { ?>
								<td><?php echo $row['facebook_leads']; ?></td>
						 <?php } ?>
					</tr>
						<tr>
						<td>3</td>
						<td>Web Leads</td>
					<?php foreach ($select_leads as $row) { ?>
								<td><?php echo $row['web_leads']; ?></td>
						 <?php } ?>
					</tr>
						<tr>
						<td>4</td>
						<td>Nexa Pune Web Leads</td>
					<?php foreach ($select_leads as $row) { ?>
								<td><?php echo $row['nexa_web_leads']; ?></td>
						 <?php } ?>
					</tr>
					
						<tr>
						<td>5</td>
						<td>New car Leads</td>
						<?php foreach ($select_leads as $row) { ?>
								<td><?php echo $row['newcar_leads']; ?></td>
						 <?php } ?>
					</tr>
					<tr>
						<td>6</td>
						<td>POC Sales Leads</td>
						<?php foreach ($select_leads as $row) { ?>
								<td><?php echo $row['usedcar_leads']; ?></td>
						 <?php } ?>
					</tr>
					<tr>
						<td>7</td>
						<td>Evaluation-POC Purchase Leads</td>
						<?php foreach ($select_leads as $row) { ?>
								<td><?php echo $row['evaluation_leads']; ?></td>
						 <?php } ?>
					</tr>
					<tr>
						<td>8</td>
						<td>Finance Leads</td>
						<?php foreach ($select_leads as $row) { ?>
								<td><?php echo $row['finance_leads']; ?></td>
						 <?php } ?>
					</tr>
					<tr>
						<td>9</td>
						<td>Complaint Leads</td>
						<?php foreach ($select_leads as $row) { ?>
								<td><?php echo $row['complaint_leads']; ?></td>
						 <?php } ?>
					</tr>
					<tr>
						<td>10</td>
						<td>Service Leads</td>
						<?php foreach ($select_leads as $row) { ?>
								<td><?php echo $row['service_leads']; ?></td>
						 <?php } ?>
					</tr>
					<tr>
						<td>11</td>
						<td>Accessories Leads</td>
						<?php foreach ($select_leads as $row) { ?>
								<td><?php echo $row['accessories_leads']; ?></td>
						 <?php } ?>
					</tr>
				
				</tbody>
			</table>
			</div>
<?php }} else {
	echo "No Record Found"; 
}
	?>
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
function select_next_action(feedback){
	
    $.ajax({url: "<?php echo site_url();?>new_tracker/select_next_action",
    type:'POST',
    data:{feedback:feedback} ,
    success: function(result){
        $("#next_action_div").html(result);
    }});
}
</script>
 
                    <!-- date script -->

<!--Filter Ends-->                    