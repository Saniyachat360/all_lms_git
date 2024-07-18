<?php 
if($_SESSION['role']==4)
{
	$today=date('Y-m-d');
	$user=$_SESSION['user_id'];
	$in_time='09:30:00';
	$out_time='20:00:00';
	$in_time1='11:00:00';
	$current_time=date("H:i:s");
	$query=$this->db->query("select * from tbl_dse_daily_traking where report_date='$today' and user_id='$user' and status=1")->result();

	if(count($query)>0){
		$time=$query[0]->report_time;
		$times = strtotime($time) + 60*180;
		$timet = date("H:i:s", $times); 
		
		if($timet<$current_time && $in_time<$current_time && $out_time>$current_time )
		{
			echo '<div class="alert alert-success"><strong> Please Add Daily Report ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>';

		}
	}else{
		if($in_time1<$current_time && $out_time>$current_time ){
			echo '<div class="alert alert-success"><strong> Please Add Daily Report ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>';
		}
	}
}
?>	
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
		var location_id=document.getElementById('location_name').value;
	 	var fromdate=document.getElementById('fromdate').value;
	 	var status=document.getElementById('status').value;
	
	  	src1 ="<?php echo base_url('assets/images/loader200.gif'); ?>";
		var elem = document.createElement("img");
		elem.setAttribute("src", src1);
		elem.setAttribute("height", "95");
		elem.setAttribute("width", "250");
		elem.setAttribute("alt", "loader");
		document.getElementById("blah").appendChild(elem);
		$.ajax({
			url: "<?php echo site_url(); ?>dse_daily_reporting/show_data_filter",
			type:"POST",
			data:{location_id:location_id,fromdate:fromdate,status:status},
			success: function(result){
			$("#count_div").html(result);
		} });
	}
	function refresh () {
document.getElementById('location_name').value='';
document.getElementById('fromdate').value='';
document.getElementById('todate').value='';
get_report();
	}
</script>
<div class="container">
	<div class="row">
		<h1 style="text-align:center; ">DSE Daily Report</h1>
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-body">			
					<div id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left">
						<div class="col-md-12">
							<div class="col-md-offset-1 col-md-3 col-sm-3 col-xs-12">
								<div class="form-group">		
									<select id="location_name" class="form-control" required="" name="location_name">
										
										<option value="">Please Select Location</option>
										<?php foreach ($select_location as $row) {?>
										<option value="<?php echo $row->location_id;?>"><?php echo $row->location;?></option>
										<?php } ?>									
									</select>
								</div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-12" style="padding-left: 20px">
								<div class="form-group">		
									<select id="status" class="form-control" required="" name="status">
										
										<option value="">Please Select </option>
										
										<option value="All">All</option>
										<option value="Lastest">Latest</option>
																	
									</select>
								</div>
							</div>							
							<div class="col-md-3 col-sm-3 col-xs-12">
								<input id="fromdate" value="" class="datett filter_s col-md-12 col-xs-12 form-control active" placeholder="From Date" name="fromdate" readonly="" style="cursor:default;" type="text">
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
