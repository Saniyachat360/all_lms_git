<script>
	function search() {
		var to_date = document.getElementById("to_date").value;
		var location = document.getElementById("location").value;

		if (location == '') {
			alert("Please select Location");
			return false;
		} else if (to_date == '') {
			alert("Please Select Date");
		} else {
			//Create Loader
			src1 = "<?php echo base_url('assets/images/loader200.gif'); ?>";
			var elem = document.createElement("img");
			elem.setAttribute("src", src1);
			elem.setAttribute("height", "95");
			elem.setAttribute("width", "250");
			elem.setAttribute("alt", "loader");

			document.getElementById("blah").appendChild(elem);
			$.ajax({
				url: ' <?php echo site_url(); ?>break_reports/search_break',
				type: 'POST',
				data: {
					to_date: to_date,
					location: location
				},
				success: function(result) {
					$("#table_div").html(result);
				}
			});

		}
	}

	function clear_data() {
		document.getElementById("to_date").innerHTML = '';
		document.getElementById("location").innerHTML = '';
		window.location = "<?php echo site_url(); ?>break_reports";
	}

	$(document).ready(function() {
		$('.datett').daterangepicker({
			singleDatePicker: true,
			format: 'YYYY-MM-DD',
			calender_style: "picker_1"
		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});
	});
</script>
<div class="row">
	<h1 style="text-align:center; ">Break time Report</h1>
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-body">

				<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

					<div class="col-md-12">
						<div class="form-group col-md-3" style="padding:20px;">
							<select id="location" class="form-control" required name="location">
								<option value="">Select Location</option>
								<?php foreach ($select_location as $location) { ?>
									<option value="<?php echo $location->location_id; ?>"><?php echo $location->location; ?></option>
								<?php } ?>
							</select>
						</div>

						<div class="form-group col-md-3" id='todateDiv' style="padding:20px;">
							<input type="text" id="to_date" name="to_date" class="form-control datett" max="<?php echo date("h:i:s"); ?>" placeholder="Select Date">
						</div>

						<div class=" col-md-4 col-sm-3 col-xs-12" style="padding:20px;">

							<div class="form-group">
								<button type="submit" class="btn btn-info" onclick="search()"><i class="entypo-search"> Search</i></button>
								<!--  <a target="_blank" href="<?php echo site_url('new_tracker/download_data/?campaign_name=' . $campaign_name . '&nextaction=' . $nextaction . '&feedback=' . $feedback . '&todate=' . $todate); ?>" >--></a>
								<a target="_blank" onclick="test()" >
                             	 <i class="btn btn-primary entypo-download">  Download</i>
								</a>
								<a onclick="clear_data()"> <i class="btn btn-success entypo-ccw"> Reset</i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row" id="table_div">
			<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
		</div>

		<script>
			function test() {
				var location = document.getElementById('location').value;
				var to_date = document.getElementById('to_date').value;
				var ur = "<?php echo site_url(); ?>";
				window.open(ur + "break_reports/break_time_all_download/?location=" + location + "&to_date=" + to_date, "_blank");
			}
		</script>