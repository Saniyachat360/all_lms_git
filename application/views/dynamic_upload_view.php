

<div class="row" >
	<h1 style="text-align:center; ">Create Quotation</h1>
<div class="col-md-12" >
	<div class="panel panel-primary">
		<div class="panel-body">
			<form class="form-horizontal form-label-left">
				<div class="col-md-12">
					<div class="form-group">
						<label  class="control-label col-md-4 col-sm-4 col-xs-12">Location</label>
					<div class="col-md-5 col-sm-5 col-xs-12">
						<select class="filter_s col-md-12 col-xs-12 form-control" name="location" id="location" required>
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
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label col-md-4 col-sm-4 col-xs-12">Quotation Name</label>
					<div class="col-md-5 col-sm-5 col-xs-12">
						<input  onkeypress="return alpha(event)" class="filter_s col-md-12 col-xs-12 form-control" type="text" id="quotation" name="quotation" required>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label col-md-4 col-sm-4 col-xs-12">No. of Rows</label>
						<div class="col-md-5 col-sm-5 col-xs-12">
							<input onkeypress="return isNumberKey(event)" class="filter_s col-md-12 col-xs-12 form-control" type="text" id="no_of_rows" name="no_of_rows" required>
						</div>
					</div>
				</div>
				<div class="col-md-12">
				<div class="form-group">
				<div class="col-md-offset-4 col-md-5">
				
						<a class="btn btn-info col-md-5 col-xs-5 col-sm-5" onclick="changeIt()">Create </a>
					</div>
				</div>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
<div class="col-md-12" id="create_table" style="display:none">
	<div class="panel panel-primary">
		<div class="panel-body">
			<h2 style="text-align:center; ">Create Quotation Table</h2>
<form class="form-horizontal form-label-left" action="<?php echo site_url(); ?>dynamic_upload/insert_create_table" method="post" >

	<div id="my_div"></div>
	<input type="hidden" name="location_name" id="location_name" />
	<input type="hidden" name="quotation_name" id="quotation_name" />
		<div class="col-md-offset-5 col-md-6">
					<div class="form-group">
	<input class="btn btn-info col-md-5 col-xs-5 col-sm-5" id="table_submit" type="submit" name="submit" value="Save" />
	</div>
	</div>
</form>
</div>
</div>
</div>
<div class="row" >
<h2 style="text-align:center; ">Upload Quotation Table</h2>
<div class="col-md-12" id="upload_div">
	<div class="panel panel-primary">
		<div class="panel-body">
		
		<form class="form-horizontal form-label-left" action="<?php echo site_url(); ?>dynamic_upload/upload_data"  method="post" enctype="multipart/form-data">
			
			<div class="col-md-12">
				<div class="form-group">
					<label  class="control-label col-md-4 col-sm-4 col-xs-12">Select Table Name</label>
				<div class="col-md-5 col-sm-5 col-xs-12">
						<select class="filter_s col-md-12 col-xs-12 form-control" name="table_name" id="table_name" required onchange="check_quotation()">
							<option value="">Please Select</option>
								
								<?php			foreach ($select_quotation_name as $row) { ?>
												<option value=<?php echo $row->table_name ?>><?php echo $row -> quotation_name; ?></option>
									<?php } ?>
							</select>
							
	</div>
	<div id="download_data" class="col-md-3" style="display:none">
					
						<a class="btn btn-primary col-md-10 col-xs-10 col-sm-10" onclick="download_excel()">Download quotation excel format </a>
					
				</div>
	</div>
	
	</div>
	<div class="col-md-12" style="margin-top:20px">
		<div class="form-group">
			<label  class="control-label col-md-4 col-sm-4 col-xs-12">Upload file</label>
				<div class="col-md-5 col-sm-5 col-xs-12" >
					<input  type="file"  class="btn btn-info"  name="file" id="file" required  >
				</div>
			</div>
	</div>
	<div class="col-md-12" style="margin-top:20px">
				<div class="form-group">
					<div class="col-md-offset-4 col-md-7 col-sm-5 col-xs-12" >
<input type="submit" class="col-md-4 col-sm-4 col-xs-12 btn btn-primary" name="upload" value="Upload" />
</div>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
<script>
function check_quotation () {
  var table_name=document.getElementById('table_name').value;
  if(table_name!=''){
  	  document.getElementById('download_data').style.display = "block";
  }else{
  	  document.getElementById('download_data').style.display = "none";
  }
  
}
				function download_excel(){
	var table_name=document.getElementById('table_name').value;
	
	
window.open("<?php echo site_url(); ?>
	dynamic_upload/download_data/?table_name="+table_name,'_blank');
	}
</script>
<script type="text/javascript">
	function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		// Added to allow decimal, period, or delete
		if (charCode == 110 || charCode == 190 || charCode == 46)
			return true;

		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;

		return true;
	}

	function alpha(e) {
		var k;
		document.all ? k = e.keyCode : k = e.which;
		return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
	}

	function data_type_table(e) {
		function alpha(e) {
			var k;
			document.all ? k = e.keyCode : k = e.which;
			return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
		}

		isNumberKey(e);
		alpha(e);
		isSpace(e);
	}
    </script>
    <script language="javascript">
		function changeIt() {
			var no_of_rows = document.getElementById("no_of_rows").value;
			var location = document.getElementById("location").value;
			var quotation_name = document.getElementById("quotation").value;
			if (no_of_rows == '' || location == '' || quotation_name == '') {
				alert("Plese select all fields ");
				return false;
			}
			document.getElementById("location_name").value = location;
			document.getElementById("quotation_name").value = quotation_name;
			if (document.getElementById("create_table").style.display == "none") {
				my_div.innerHTML = my_div.innerHTML + "<div class='col-md-12'><table class='table'><tr><th>Sr No</th><th>Column Name</th><th>Type</th></tr></table></div>";
				my_div.innerHTML = my_div.innerHTML + "<div class='col-md-12'><table class='table'><tr><td> 1 </td><td><input  onkeypress='isSpace(event);isNumberKey(event)' class='form-control' type='text' name='mytext[]' value='location' required></td><td><select class=' form-control' name='dataty[]' required><option value='varchar(100)'>Character (e.g. name)</option></select></td></tr><tr><td> 2 </td><td><input  onkeypress='isSpace(event);isNumberKey(event)' class='form-control' type='text' name='mytext[]' value='model' required></td><td><select class=' form-control' name='dataty[]' required><option value='varchar(100)'>Character (e.g. name)</option></select></td></tr><tr><td> 3 </td><td><input  onkeypress='isSpace(event);isNumberKey(event)' class='form-control' type='text' name='mytext[]' value='variant' required></td><td><select class=' form-control' name='dataty[]' required><option value='varchar(100)'>Character (e.g. name)</option></select></td></tr></tabel></div>";
				var norow = no_of_rows - 3;
				for (var i = 1; i <= norow; i++) {
					var j = i + 3;
					my_div.innerHTML = my_div.innerHTML + "<div class='col-md-12'><table class='table'><tr><td>" + j + "</td><td><input  onkeypress='isSpace(event);' class='form-control' type='text' name='mytext[]' required></td><td><select class=' form-control' name='dataty[]' required><option value=''>Please select </option><option value='varchar(100)'>Character (e.g. name)</option><option value='DOUBLE'>Float (e.g. price)</option><option value='BIGINT'>Number (e.g. contact no)</option></select></td></tr>";

				}
				my_div.innerHTML = my_div.innerHTML + "</table></div>";

				document.getElementById("create_table").style.display = "block";

				return true;
			} else {

				return false;
			}
		}

		function validationdata() {
			alert('hiiiiiii');
			var arr = document.getElementById("mytext").value;
			for (var i = 0; i < count(arr); i++) {
				$arr[i] == $arr[i + 1];
				return false;
			}
		}

		function isSpace(e) {

			if (e.which === 32)
				return false;

		}
</script>

