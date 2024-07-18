

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

  function search() {

							



								var from_date=document.getElementById("from_date").value ;

								var to_date=document.getElementById("to_date").value ;

								var location_id=document.getElementById("location_id").value ;

										if (from_date == '' || to_date == '' ) {

			alert("Please select From date and To date");

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

								  	url:' <?php echo site_url();?>reports/search_locationwise_report',

								  	type:'POST',

								  	data:{location_id:location_id,from_date:from_date,to_date:to_date},

								  	 success: function(result){

        $("#table_div").html(result);

    }});

			}					



							}

  function clear_data() {

							

								document.getElementById("from_date").innerHTML = '';

								document.getElementById("to_date").innerHTML = '';

								document.getElementById("location_id").innerHTML = '';

								 window.location="<?php echo site_url();?>reports/locationwise_report";

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

	<h1 style="text-align:center; ">Locationwise Report</h1>

	<div class="col-md-12" >

		<div class="panel panel-primary">

			<?php 

			/*$executive_array=array("3","4","8","10","12","14");

			if(in_array($_SESSION['role'],$executive_array)){}else{ */?>

			<div class="panel-body">			

			

					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

					

						<div class=" col-md-12">

							

						<div class="col-md-offset-1  col-md-3" style="padding:20px;">

						<div class="form-group">

									<select class="form-control"  id="location_id" name="user_id">

									<option value="">Select Location</option>

									<?php foreach($select_location as $row) { ?>

									<option value="<?php echo $row -> location_id; ?>"><?php echo $row -> location; ?></option>

									<?php } ?>

									

									</select>

								</div>

							</div>

							<div class="form-group col-md-2" style="padding:20px;">

						

								<input type="text" id="from_date" name="from_date" class="form-control datett" placeholder="From Date">

								

							</div>

						<div class="form-group col-md-2" style="padding:20px;">

								

								<input type="text" id="to_date" name="to_date" class="form-control datett" placeholder="To Date">

								

							</div>

							

							      <div class=" col-md-4 col-sm-4 col-xs-12" style="padding:20px;">

                        

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

		

	</div>



</div>



<div class="row" id="table_div">

	<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>

	

	

	

	

</div>

					



