
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
  <div class="row" >
	<h1 style="text-align:center; ">Locationwise Count</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary">
			<?php 
			/*$executive_array=array("3","4","8","10","12","14");
			if(in_array($_SESSION['role'],$executive_array)){}else{ */?>
			<div class="panel-body">			
				<form action="<?php echo $var; ?>" method="post">
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Location: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<select id="location_name" class="form-control" onchange="get_group()" required name="location_name">
									<option value="">Please Select</option>
									<?php foreach($select_location as $location) { ?>
									<option value="<?php echo $location -> location_id; ?>"><?php echo $location -> location; ?></option>
									<?php } ?>
									
									</select>
								</div>
							</div>

						</div>
					</div>

					</form>
				</div><?php // } ?>
		</div>
		
	</div>

</div>

<div class="row" id="count_div">
	<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
		<?php
if(isset($select_leads)){if(count($select_leads)>0){
			$executive_array=array("3","4","8","10","12","14","16");
			if(in_array($_SESSION['role'],$executive_array)){ ?>
	<div class="col-md-12">
				<table class="table table-bordered datatable" id="table-4">
				<thead>
					<tr>
							<th><b>Sr No.</b></th>
							<th><b>Leads</b></th>
							<?php foreach ($location_data as $row) {?>
							<th><b>Count <?php
								if ($row['fname'] != '') {echo '(' . $row['fname'] . ')';
								}
								?>
								</b>
							</th>
							<?php } ?>
					</tr>
				</thead>
				<tbody>
					
					<tr>
						<td>1</td>
						<td>Unassigned Leads</td>
						<?php  foreach ($location_data as $row) { ?>
						<td><a href="<?php echo site_url('unassign_leads/leads/?id='.$row['id']);?>"><?php echo $row['unassigned_leads']; ?></a>
							
						</td>
						<?php } ?>
					</tr>
					
					<tr>
						<td>2</td>
						<td>New Leads</td>
		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><a href="<?php echo site_url('new_lead/?id='.$row['id']);?>"><?php echo $row['new_leads']; ?></a>
							
						</td>
		
						<?php } ?>
					</tr>
					<tr>
						<td>3</td>
						<td>Call Today Leads</td>
		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><a  href="<?php echo site_url('today_followup/?id='.$row['id']);?>"><?php echo $row['call_today']; ?></a>
						
		
						<?php } ?>
					</tr>
					<tr>
						<td>4</td>
						<td>Pending New Leads</td>
		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><a  href="<?php echo site_url('pending/telecaller_leads_not_attended/?id='.$row['id']);?>"><?php echo $row['pending_new_leads']; ?></a>
						
		
						<?php } ?>
					</tr>
					<tr>
						<td>5</td>
						<td>Pending Followup Leads</td>
		
						<?php  foreach ($location_data as $row) { ?>
		
						<td><a  href="<?php echo site_url('pending/telecaller_leads/?id='.$row['id']);?>"><?php echo $row['pending_followup']; ?></a>
						
						<?php } ?>
					</tr>
				</tbody>
			</table>
			</div>
<?php }} else { 
}}?>
	
	
	
</div>
					
<script>
	function get_group()
	{
		//alert('Hi');
		var location_name=document.getElementById("location_name").value;
		//alert(location_name);location_name
		//Create Loader
					src1 ="<?php echo base_url('assets/images/loader200.gif'); ?>
						";
						var elem = document.createElement("img");
						elem.setAttribute("src", src1);
						elem.setAttribute("height", "95");
						elem.setAttribute("width", "250");
						elem.setAttribute("alt", "loader");

						document.getElementById("blah").appendChild(elem);

						$.ajax({url: "<?php echo site_url(); ?>New_notification/all_notification_counts",
	type:"POST",
	data:{location_name:location_name},
	success: function(result){
	$("#count_div").html(result)
	} });

	}

</script>
