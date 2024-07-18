<div class="row">

		<h1 style="text-align:center; ">Login Logout Report</h1>
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="x_panel">
					<div class=" col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
						<div class="form-group">
							<select class="select2 col-md-12 col-xs-12 " name="type" id="type" onchange="custom1();" required>
								<option selected disabled value=" ">Select Type</option>
								<option value="Daily">Daily</option>
								<option value="Weekly">Weekly</option>
								<option value="Monthly">Monthly</option>
								<option value="Custom">Custom</option>
							</select>
						</div>
					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
						<div class="form-group">

							<!-- <select class="filter_s col-md-12 col-xs-12 form-control" name="user_name" id="user_name"> -->
							<select class=" select2 col-md-12 col-xs-12" multiple="multiple" name="user_name[]" id="user_name[]" data-dropdown-css-class="select2-purple" data-placeholder="Select User" style="width: 100%;" style="height: 10px;">
								<!-- <select class="filter_s col-md-12 col-xs-12 selectpicker" data-width="300px" data-size="7" name="user_name" id="user_name" multiple data-live-search="true"  > -->

								<option disabled value=" ">Select User</option>
								<option value="ALL">ALL</option>
								<?php foreach ($select_users as $row) { ?>

									<option value="<?php echo $row->id; ?>"><?php echo $row->fname;  ?><?php echo " ";  ?><?php echo $row->lname;  ?></option>

								<?php } ?>
							</select>

						</div>
					</div>


					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px; " id='crdiv' style="display: none">
						<div class="form-group">
							<input type="text" id="from_date"  class="datett filter_s col-md-12 col-xs-12 form-control" placeholder="From Date" name="from_date" readonly style="cursor:default;">
						</div>
					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;" id='crdiv1' style="display:none">
						<div class="form-group">
							<input type="text" id="to_date" value="" class="datett filter_s col-md-12 col-xs-12 form-control" placeholder="To Date" name="to_date" readonly style="cursor:default;">
						</div>
					</div>

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
						<div class="form-group">

							<button type="submit" id="submit" class="btn btn-info" onclick="filter_daily()" class="entypo-search"> Search</button><!--  -->
							<a onclick="reset()" class="btn btn-success entypo-ccw"> Reset</a>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	
</div>
<div class="row" id="filter_daily">
	<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
</div>





<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


<style>
	.select2-purple .select2-container--default .select2-selection--multiple .select2-selection__choice {
		background-color:
			#17a2b8;
		border-color:
			#17a2b8;
		color:
			#fff;
	}

	.select2-container .select2-selection--single {

		height: auto;
	}
</style>




<script>
	function reset() {
		document.getElementById("from_date").value = '';
		document.getElementById("to_date").value = '';


		document.getElementById("type").checked = false;
		var un = document.getElementsById('user_name');
		$('input[user_name=un]').prop("unchecked");
		$("#type").prop("checked", false);
	}

	// function validate_download() {

	// 	var f = document.getElementById("fromdate").value;
	// 	var t = document.getElementById("todate").value;


	// 	if (f == '' || t == '') {
	// 		alert("Please select From date and To date");
	// 		return false;
	// 	}
	// }
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.datett').daterangepicker({
			singleDatePicker: true,
			format: 'YYYY-MM-DD',
			calender_style: "picker_1"
		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});

		$('#fromdate').daterangepicker({
			singleDatePicker: true,
			format: 'YYYY-MM-DD',
			calender_style: "picker_1"
		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});

		$('#todate').daterangepicker({
			singleDatePicker: true,
			format: 'YYYY-MM-DD',
			calender_style: "picker_1"
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

<!-- <script>
	select {
  color: #000000;
};
option:not(:first-of-type) {
  color: black;
};
	$('select').selectpicker();
	$('select').selectpicker({

});
</script> -->


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

<!-- date script -->

<!--Filter Ends-->
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.min.css">

<script>
	$(function() {

		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0! 
		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd
		}
		if (mm < 10) {
			mm = '0' + mm
		}
		var today = yyyy + '-' + mm + '-' + dd;
		$('.date_user_disable').daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
			minDate: today,
			calender_style: "picker_1",
			locale: {
				format: 'YYYY-MM-DD'

			}
		}, function(start, end, label) {
			console.log("A new date selection was made: " + start.format('YYYY-MM-DD'));
		});

		$('.date_user').daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
			calender_style: "picker_1",
			locale: {
				format: 'YYYY-MM-DD'

			}
		}, function(start, end, label) {
			console.log("A new date selection was made: " + start.format('YYYY-MM-DD'));
		});
	});
</script>
<script>
	function custom1() {
		var type = document.getElementById("type").value;
		// alert (type);
		if (type == 'Custom') {
			$("#crdiv").show();
			$("#crdiv1").show();
			document.getElementById("from_date").disabled = false;
			document.getElementById("to_date").disabled = false;

			// alert ('hit');

		} else {

			document.getElementById("from_date").disabled = true;
			document.getElementById("to_date").disabled = true;

			$("#crdiv").hide();
			$("#crdiv1").hide();
		}
	}

	function filter_daily() {
		var type = document.getElementById("type").value;
		console.log(type);

		var from_date = document.getElementById("from_date").value;
		console.log(from_date);

		var to_date = document.getElementById("to_date").value;
		console.log(to_date);

		var name = document.getElementById('user_name[]');
		var user_name = [...name.selectedOptions]
			.map(option => option.value);
		console.log(user_name);

		var id = document.getElementById('user_name[]');
		var user_id = [...id.selectedOptions]
			.map(option => option.value);
		console.log(user_id);


		if (user_name == '') {
			alert("Please select user name");
		} else if (type == ' ') {
			alert("Please select type");
		} else if (type == 'Custom' && from_date == '' && to_date == '') {
			alert("Please select from date and to date");
		} else {
			src1 = "<?php echo base_url('assets/images/loader200.gif'); ?>";
			var elem = document.createElement("img");
			elem.setAttribute("src", src1);
			elem.setAttribute("height", "95");
			elem.setAttribute("width", "250");
			elem.setAttribute("alt", "loader");

			document.getElementById("blah").appendChild(elem);
			$.ajax({
				url: '<?php echo site_url('Login_out_report/filter_daily') ?>',
				type: 'POST',
				data: {
					type: type,
					user_id: user_name,
					user_name: user_name,
					from_date: from_date,
					to_date: to_date
				},
				success: function(result) {
					$("#filter_daily").html(result);
					// $("#filter_daily").html(result).FixedColumns( result );
					// new $.fn.dataTable.FixedColumns( oTable );
					// $('#table_div').DataTable().destroy();
				}
			});
		}
	}

	$(function() {
		//Initialize Select2 Elements
		$('.select2').select2()

		//Initialize Select2 Elements
		$('.select2bs4').select2({
			theme: 'bootstrap4'
		})
	});
</script>

<!-- Select2 -->
<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.full.min.js"></script>
