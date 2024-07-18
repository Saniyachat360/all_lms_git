
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
 function reportelement(report) {					
if(report=="CSE Productivity" || report=='CSE Performance')
{
	var hiddenDiv1 = document.getElementById("csereportelementDiv");
	 hiddenDiv1.style.display = "block";
	 document.getElementById("cse_user_id").disabled = false; 
	document.getElementById("location").disabled = true; 
	//document.getElementById("dse_user_id").disabled = true; 
	 var hiddenDiv = document.getElementById("dsereportelementDiv");
	 hiddenDiv.style.display = "none";
}
else
{
	 var hiddenDiv = document.getElementById("dsereportelementDiv");
	 hiddenDiv.style.display = "block";
	document.getElementById("location").disabled = false; 
	//document.getElementById("dse_user_id").disabled = true; 
	
	document.getElementById("cse_user_id").disabled = true; 
	 var hiddenDiv1 = document.getElementById("csereportelementDiv");
	 hiddenDiv1.style.display = "none";
}
		


}
</script>
  <script>
  function download_data(){
  var report=document.getElementById("report").value ;
								var from_date=document.getElementById("from_date").value ;
								var to_date=document.getElementById("to_date").value ;
								var cse_user_id=document.getElementById("cse_user_id").value ;
								//var dse_user_id=document.getElementById("dse_user_id").value ;
								var date_type=document.getElementById("date_type").value ;
								var location=document.getElementById("location").value ;
								if(report=='')
								{
									alert("Please Select Report Name");
									return false;
								}
								if((report=='DSE Productivity' || report=='DSE Performance') && location==''){
									alert("Please Select Location");
									return false;
								}
								else if(date_type=="" )
								{
									alert("Please Select Date Type");
									return false;
								}
								
								else if(date_type=="As on Date" && from_date == '')
								{
									alert("Please Select Date");
									return false;
								}
								else if (date_type!="As on Date" && (from_date == '' || to_date == '') ) {
							alert("Please Select From Date and To Date");
							return false;
								}
  var ur='<?php echo site_url();?>';  	
  
  window.open(ur+"One_pager_report/download_data/?report="+report+"&location="+location+"&from_date="+from_date+"&to_date="+to_date+"&date_type="+date_type+"&cse_id="+cse_user_id,"_blank");

  }
  function search() {
							
								var report=document.getElementById("report").value ;
								var from_date=document.getElementById("from_date").value ;
								var to_date=document.getElementById("to_date").value ;
								var cse_user_id=document.getElementById("cse_user_id").value ;
								//var dse_user_id=document.getElementById("dse_user_id").value ;
								var date_type=document.getElementById("date_type").value ;
								var location=document.getElementById("location").value ;
								if(report=='')
								{
									alert("Please Select Report Name");
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
								  	url:' <?php echo site_url();?>one_pager_report/get_report',
								  	type:'POST',
								  	data:{report:report,cse_user_id:cse_user_id,location:location,from_date:from_date,to_date:to_date,date_type:date_type},
								  	 success: function(result){
        $("#table_div").html(result);
    }});
								
}

							}
								function get_dse (location) {
		$.ajax({url: "<?php echo site_url();?>one_pager_report/get_dse",
		 type:"POST",
		 data:{location:location},
		success: function(result){
        $("#dse_div").html(result);
    }});
	  }
  function clear_data() {
							
								document.getElementById("from_date").innerHTML = '';
								document.getElementById("to_date").innerHTML = '';
								document.getElementById("user_id").innerHTML = '';
								 window.location="<?php echo site_url();?>CSE_reports";
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
	<h1 style="text-align:center; ">One Pager Report</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary">
			
			<div class="panel-body">			
			
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
					
						<div class=" col-md-12">
							<div class="form-group  col-md-2" style="padding:20px;">
							<!--	<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Location: </label>-->
								
									<select id="report" class="form-control" onchange="reportelement(this.value)" required name="report">
										
									<option value="">Select Report</option>
									
									<option value="CSE Productivity">CSE Productivity</option>
									<option value="CSE Performance">CSE Performance</option>
									<option value="DSE Productivity">DSE Productivity</option>
									<option value="DSE Performance">DSE Performance</option>
									</select>
							</div>
							<div id='dsereportelementDiv' style='display: none'>	
							<div class="form-group  col-md-2" style="padding:20px;">
							<!--	<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Location: </label>-->
								
									<select id="location" class="form-control" onchange="get_dse(this.value)" required name="location">
										
									<option value="">Select Location</option>
									<option value="All">All</option>
									<?php foreach($select_location as $location) { ?>
									<option value="<?php echo $location -> location_id; ?>"><?php echo $location -> location; ?></option>
									<?php } ?>
									
									</select>
								
							</div>	
							<!--<div class="form-group col-md-2" id="dse_div" style="padding:20px;">
						
									<select class="form-control"  id="dse_user_id" name="dse_user_id">
									<option value="">Select DSE Name</option>
									<?php foreach($select_dse as $row) { ?>
									<option value="<?php echo $row -> id; ?>"><?php echo $row -> dse_name; ?></option>
									<?php } ?>
									
									</select>
							</div>-->
							</div>
							<div id='csereportelementDiv' style='display: none'>	
						<div class="col-md-2" style="padding:20px;">
						<div class="form-group">
									<select class="form-control"  id="cse_user_id" name="cse_user_id">
									<option value="">Select CSE Name</option>
									<?php foreach($select_cse as $row) { ?>
									<option value="<?php echo $row -> id; ?>"><?php echo $row -> cse_name; ?></option>
									<?php } ?>
									
									</select>
								</div>
							</div>
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
							<div class="form-group col-md-2" id='from_dateDiv' style="padding:20px;">
						
								<input type="text" id="from_date" name="from_date" class="form-control datett" placeholder="From Date">
								
							</div>
						<div class="form-group col-md-2" id='todateDiv' style="padding:20px;">
								
								<input type="text" id="to_date" name="to_date" class="form-control datett" placeholder="To Date">
								
						</div>
							
							      <div class=" col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group">
                     
                       <!--  <button type="submit" class="btn btn-info" onclick="search()"><i class="entypo-search" > Search</i></button>-->
                          <button type="submit" class="btn btn-info" onclick="download_data()"><i class="entypo-download" > Download</i></button>
                        
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
		
	</div>

</div>


<div class="row" id="table_div">
	<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
	
	
	
	
</div>
					

