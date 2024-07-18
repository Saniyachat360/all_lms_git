
  <script src="<?php echo base_url();?>assets/js/download_excel/FileSaver.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/download_excel/tableexport.min.js"></script>
  <style>
  
  	.btn-toolbar .btn {
	background-color: #1988b6;
	color:#fff;
	float: right;
}
	.btn-default,.btn-default:hover{
		background-color: #1988b6;
	color:#fff;
	float:right;
	}
  </style>
  
    <script>
  function dateRangeShow(val) {

if(val=="As on Date")
{
	document.getElementById("to_date").disabled = true; 
	 var hiddenDiv = document.getElementById("todateDiv");
	 hiddenDiv.style.display = "none";
	  document.getElementById("from_date").placeholder = "Date";
}
else
{
	 var hiddenDiv = document.getElementById("todateDiv");
	 hiddenDiv.style.display = "block";
	 document.getElementById("to_date").disabled = false; 
	 document.getElementById("from_date").placeholder = "From Date";
}	
}
</script>
  <script>
  function search() {
							

								var from_date=document.getElementById("from_date").value ;
								var to_date=document.getElementById("to_date").value ;
								var dse_id=document.getElementById("user_id").value ;
								var location=document.getElementById("location").value ;
								var date_type=document.getElementById("date_type").value ;
							//	alert(from_date);
							//	alert(to_date);
								if (location == ''  ) {
										alert("Please select Location");
										return false;
										}
										else if(date_type=="As on Date" && from_date == '')
								{
									alert("Please Select Date");
								}
								else if (date_type!="As on Date" && (from_date == '' || to_date == '') ) {
							alert("Please Select From Date and To Date");
								}
					
							else
							{
															//Create Loader
					src1 ="<?php echo base_url('assets/images/loader200.gif'); ?>";
						var elem = document.createElement("img");
						elem.setAttribute("src", src1);
						elem.setAttribute("height", "95");
						elem.setAttribute("width", "250");
						elem.setAttribute("alt", "loader");

						document.getElementById("blah").appendChild(elem);
								  $.ajax({
								  	url:' <?php echo site_url();?>new_reports/search_productivity',
								  	type:'POST',
								  	data:{dse_id:dse_id,from_date:from_date,to_date:to_date,location:location,date_type:date_type},
								  	 success: function(result){
        $("#table_div").html(result);
    }});
								
}
							}
  function clear_data() {
							
								document.getElementById("from_date").innerHTML = '';
								document.getElementById("to_date").innerHTML = '';
								document.getElementById("user_id").innerHTML = '';
								document.getElementById("location").innerHTML = '';
								
								 window.location="<?php echo site_url();?>new_reports/productivity_report";
							}
  	
	  
 
						function get_dse (location) {
		$.ajax({url: "<?php echo site_url();?>new_reports/get_dse",
		 type:"POST",
		 data:{location:location},
		success: function(result){
        $("#dse_div").html(result);
    }});
	  }
 
						$(document).ready(function() {
							$('.datett').daterangepicker({
								singleDatePicker : true,
								format : 'YYYY-MM-DD',
								calender_style : "picker_1"
							}, function(start, end, label) {
								console.log(start.toISOString(), end.toISOString(), label);
							});
							});
					
							
 						</script>
  <div class="row" >
	<h1 style="text-align:center; ">DSE Productivity Report</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary">
			<?php 
			/*$executive_array=array("3","4","8","10","12","14");
			if(in_array($_SESSION['role'],$executive_array)){}else{ */?>
			<div class="panel-body">			
			
							<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
					
						<div class="col-md-12">
							
							<div class="form-group col-md-2" style="padding:20px;">
							<!--	<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Location: </label>-->
								
									<select id="location" class="form-control" onchange="get_dse(this.value)" required name="location">
									<option value="">Select Location</option>
									<?php foreach($select_location as $location) { ?>
									<option value="<?php echo $location -> location_id; ?>"><?php echo $location -> location; ?></option>
									<?php } ?>
									
									</select>
								
							</div>
							<div class="form-group col-md-2" id="dse_div" style="padding:20px;">
						
									<select  class="form-control"  id="user_id" name="user_id">
									<option value="">Select DSE Name</option>
									<?php foreach($select_dse as $row) { ?>
									<option value="<?php echo $row -> id; ?>"><?php echo $row -> dse_name; ?></option>
									<?php } ?>
									
									</select>
								
							</div>
							<div class="col-md-2" style="padding:20px;">
						<div class="form-group">
									<select class="form-control" onchange='dateRangeShow(this.value)' id="date_type" name="date_type">
									<option value="">Select Date Type</option>
									<option value="As on Date">As on Date</option>
									<option value="Date Range">Date Range</option>
									</select>
								</div>
							</div>
							<div class="form-group col-md-2" style="padding:20px;">
						
								<input type="text" id="from_date" name="from_date" class="form-control datett" placeholder="From Date">
								
							</div>
						<div class="form-group col-md-2" id='todateDiv' style="padding:20px;">
								
								<input type="text" id="to_date" name="to_date" class="form-control datett" placeholder="To Date">
								
							</div>
							
							     <div class=" col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group">
                     
                         <button type="submit" class="btn btn-info" onclick="search()"><i class="entypo-search" > Search</i></button>
                         
                           <!--  <a target="_blank" href="<?php echo site_url('new_tracker/download_data/?campaign_name='. $campaign_name .'&nextaction=' .$nextaction .'&feedback='.$feedback .'&fromdate='. $fromdate.'&todate='.$todate.'&date_type='.$date_type ); ?>" >--></a>
                             <!-- <a target="_blank" onclick="test()" >
                            
                             	 <i class="btn btn-primary entypo-download">  Download</i></a>-->
                          
                                 <a onclick="clear_data()" > <i class="btn btn-success entypo-ccw"> Reset</i></a>
                                        </div>
                            </div>
						</div>
					</div>

							
							    
                                   

						</div>
					</div>

				
			

<div class="row" id="table_div">
	<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
	
	
	
	
</div>
					

