<script>
	function select_details (val) {
	if(val != '')
	 $.ajax({
		 	url: "<?php echo site_url();?>dynamic_upload/select_qutation_location", 
		type:'POST',
		 data:{
		 	location:val
	 },
	success: function(result){
        $("#locationdiv").html(result);
	  
	}
	});
	}
</script>
<div class="col-md-12">
	<h1 style="text-align:center;">Check Active Quotation </h1>
	<div class="panel panel-primary">
		<div class="panel-body">
			<form class="form-horizontal form-label-left">
			<div class="col-md-12">
					<div class="form-group">
						<label  class="control-label col-md-4 col-sm-4 col-xs-12">Location</label>
					<div class="col-md-5 col-sm-5 col-xs-12">
						<select class="filter_s col-md-12 col-xs-12 form-control" name="location" id="location" required onchange="return select_details(this.value);">
							<option value=''>Select Location</option>
							<option value="Outside Pune">Outside Pune</option>
							<option value="PCMC">PCMC</option>
							<option value="PMC">PMC</option>
							<option value="MUMBAI THANE DISTRICT KALYAAN NAVI MUMBAI PANVEL">MUMBAI THANE DISTRICT KALYAAN NAVI MUMBAI PANVEL</option>
							<option value="Nexa Pune">Nexa Pune</option>
							<option value="Nexa Thane">Nexa Thane</option>
						</select>
					</div>
				</div>
			</div>
			</form>
				<br><br>
				<hr>
				<br><br>
				<div id="locationdiv"></div>
			
		</div>
	</div>
</div>
