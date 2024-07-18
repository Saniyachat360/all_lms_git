
  <script src="<?php echo base_url();?>assets/js/download_excel/FileSaver.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/download_excel/tableexport.min.js"></script>
  <style>
  
  	.btn-toolbar .btn {
	background-color: #1988b6;
	color:#fff;
	float: right;
}
  </style>
<script>
	function get_report () {
		//var location_id=document.getElementById('location_name').value;
	 	var fromdate=document.getElementById('fromdate').value;
	  	var todate=document.getElementById('todate').value;
	  	src1 ="<?php echo base_url('assets/images/loader200.gif'); ?>";
		var elem = document.createElement("img");
		elem.setAttribute("src", src1);
		elem.setAttribute("height", "95");
		elem.setAttribute("width", "250");
		elem.setAttribute("alt", "loader");
		document.getElementById("blah").appendChild(elem);
		$.ajax({
			url: "<?php echo site_url(); ?>lead_report/total_lead",
			type:"POST",
			data:{fromdate:fromdate,todate:todate},
			success: function(result){
			$("#count_div").html(result)
		} });
	}
	function refresh () {
//document.getElementById('location_name').value='';
document.getElementById('fromdate').value='';
document.getElementById('todate').value='';
get_report();
	}
</script>
<div class="container">
	<div class="row">
		<h1 style="text-align:center; ">Lead Report</h1>
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-body">			
					<div id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left">
						<div class="col-md-12">
							<!--<div class="col-md-offset-1 col-md-3 col-sm-3 col-xs-12">
								<div class="form-group">		
									<select id="location_name" class="form-control" required="" name="location_name">
										
										<option value="">Please Select</option>
										<?php foreach ($select_location as $row) {?>
										<option value="<?php echo $row->location_id;?>"><?php echo $row->location;?></option>
										<?php } ?>									
									</select>
								</div>
							</div>	-->						
							<div class="col-md-offset-1 col-md-3 col-sm-3 col-xs-12">
								<input id="fromdate" value="" class="datett filter_s col-md-12 col-xs-12 form-control active" placeholder="From Date" name="fromdate" readonly="" style="background:#F5F5F5; cursor:default;" type="text">
							</div>
							<div class="col-md-3 col-sm-3 col-xs-12">
								<input id="todate" value="" class="datett filter_s col-md-12 col-xs-12 form-control active" placeholder="To Date" name="todate" readonly="" style="background:#F5F5F5; cursor:default;" type="text">
							</div>
							<div class="col-md-2">
								<a id="sub"  onclick="return get_report();"> <i class="btn btn-info    entypo-search"></i></a>
									<a id="sub"  onclick="return refresh();"> <i class="btn btn-primary entypo-ccw"></i></a>
							</div>							
						</div>
					</div>
				</div>	
			</div>
	</div>
</div>
<div class="row" id="count_div">
	<div class="control-group" id="blah" style="margin:0% 20% 1% 35%"></div>
</div>