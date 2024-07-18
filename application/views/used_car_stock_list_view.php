
<script>

	function test()
	{
			
	var m=document.getElementById("make").value;
   	//alert(m);
  	var l=document.getElementById("stock_location").value;
  	//alert(l);
   	
   	var bf=document.getElementById("budget_from").value;
   //alert(bf);
   	
   	var bt=document.getElementById("budget_to").value;
   	//alert(bt);
   	
	var cd=document.getElementById("created_date").value;
	//alert(cd);
 	
	$.ajax(
{
	url:"<?php echo site_url('used_car_stock/old_stock_filter'); ?>",
	type:'POST',
		

	data:{make:m,stock_location:l,budget_from:bf,budget_to:bt,created_date:cd},
	
	success:function(response)
		{$("#table_stock").html(response);}
	});


}
</script>

<!-- Filter--
 <div class="container" style="width: 100%;">
<div class="row">

	<div class="x_panel">
<form id="form_cse_filter" action="#" method="post">
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">

		<div class="form-group">
		<div id="txtHint1">

		<select class="filter_s col-md-12 col-xs-12 form-control" name="make" id="make" >

		<option value="">Make</option>
		<?php
		foreach ($select_make as $fetch) {

		?>
		<option value="<?php echo $fetch -> make_id; ?>
		"><?php echo $fetch -> make_name ?></option>
		<?php
		}
		?>
		</select>
	</div>
</div>
</div>
	
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group">
                                       
                                               
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="stock_location" name="stock_location" required>
											<option value="">Location</option>
													 <?php foreach($stock_location as $row)
									{?>
										<option value="<?php echo $row ->stock_location; ?>"><?php echo $row ->stock_location; ?></option>
								<?php } ?>
                                               
                                                </select>
											  
                                            </div>
                           </div>
                            

    


<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">

	<div class="form-group">

 	<select name="budget_from" id="budget_from" class="form-control" required >
                                    
										<option value="">Budget From  </option>
									
										<option value="100000">100000</option>
                     					<option value="200000">200000</option>
                     					<option value="300000">300000</option>
                     					<option value="400000">400000</option>
                     					<option value="500000">500000</option>
                     					<option value="600000">600000</option>
                     					<option value="700000">700000</option>
                     					<option value="800000">800000</option>
                     					<option value="900000">900000</option>
                     					<option value="1000000">1000000</option>
                  						</select>

	</div>
</div>



<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">

	<div class="form-group">

	<select name="budget_to" id="budget_to" class="form-control" required >
                                    
										<option value="">Budget To  </option>
									
										<option value="100000">100000</option>
                     					<option value="200000">200000</option>
                     					<option value="300000">300000</option>
                     					<option value="400000">400000</option>
                     					<option value="500000">500000</option>
                     					<option value="600000">600000</option>
                     					<option value="700000">700000</option>
                     					<option value="800000">800000</option>
                     					<option value="900000">900000</option>
                     					<option value="1000000">1000000</option>
                  						</select>

	</div>
</div>



<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">

	<div class="form-group">

			<input type="text" id="created_date" class="datett filter_s col-md-12 col-xs-12 form-control" placeholder="Created Date" name="date_of_booking" readonly style="background:#F5F5F5; cursor:default;">

	</div>
</div>
		    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-6" style="padding:20px;">

			      <a id="sub"  onclick="test()"> <i class="btn btn-info  entypo-search"></i></a>
		</div>

		 <div class="col-lg-1 col-md-1 col-sm-1 col-xs-6" style="padding:20px;">
		<a onclick="clear_data()"> <i class="btn btn-primary entypo-cancel"></i></a>

		</div>
	</form>


</div>
</div>

</div>-->
<!-- date script -->

          <script>
			function clear_data() {

				document.getElementById("form_cse_filter").reset();
		
			}
    </script>
                    

<script type="text/javascript">
	$(document).ready(function() {
		$('.datett').daterangepicker({
			singleDatePicker : true,
			format : 'YYYY-MM-DD',
			calender_style : "picker_1"
		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});

		$('#fromdate').daterangepicker({
			singleDatePicker : true,
			format : 'YYYY-MM-DD',
			calender_style : "picker_1"
		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});

		$('#todate').daterangepicker({
			singleDatePicker : true,
			format : 'YYYY-MM-DD',
			calender_style : "picker_1"
		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});

	});

	function clear_text() {

		window.location.assign("lms.php");
	}
</script>

<!-- date script -->

<!--Filter Ends-->
<?php
	$page = $this -> uri -> segment(4);
	if (isset($page)) {
		$page = $page + 1;
	
	} else {
		$page = 0;
	
	}
	$offset1 = 100 * $page;
	//$query=$sql->result();
	$c = count($select_old_stock);
?>
<div class="row" >
	
		<h1 style="text-align:center; ">POC Stock Vehicle Detail</h1>
		 </div> 
	<script>
	$(document).ready(function() {
	
		var table = $('#example').DataTable({
			searching:false,
				scrollY : "400px",
				scrollX : true,
			scrollCollapse : true,

			fixedColumns : {
				leftColumns : 0,
				rightColumns : 0
			}
		});
		
	}); 
</script>

<div class="col-md-12 table-responsive " id="table_stock" >
	
				<table class="table table-bordered datatable" id="example"> 
					<thead>
						<tr>
							<th>Sr No.</th>
							<th>Make</th>
						
							<th>Sub Model</th>
							<th>Color</th>
							<th>Fuel Type</th>
							<th>Owner</th>							
							<th>Mfg year</th>
							<th>Mileage</th>
							<th>Odo Meter</th>
							<th>Insurance</th>
							<th>Insurance Expiry</th>
							<th>Category</th>
							<th>Vehicle Status</th>
							<th>Stock Location</th>
							<th>Expt Selling Price</th>
							<th>Total landing Cost</th>
							<th>Ageing</th>
							<th>Last Updated</th>
						</tr>	
					</thead>
					<tbody>
				
					 <?php 
					 	$i=$offset1;	
						foreach($select_old_stock as $fetch) 
						{
							$i++;
						?>
						
						
						<tr>
						<td>	
						<?php echo $i; ?> 		
						
						</td>
						<td><?php echo $fetch -> make_name; ?></td>
						
						<td><?php echo $fetch -> submodel; ?></td>
						<td><?php echo $fetch -> color; ?></td>
						<td><?php echo $fetch -> fuel_type; ?></td>	
						<td><?php echo $fetch -> owner; ?></td>	
						<td><?php echo $fetch -> mfg_year; ?></td>	
						<td><?php echo $fetch -> mileage; ?></td>	
						<td><?php echo $fetch -> odo_meter; ?></td>		
						<td><?php echo $fetch -> insurance_type; ?></td>		
						<td><?php echo $fetch -> insurance_expiry_date; ?></td>	
						<td><?php echo $fetch -> category; ?></td>						
						<td><?php echo $fetch -> vehicle_status; ?></td>  
						<td><?php echo $fetch -> stock_location; ?></td> 
						<td><?php echo $fetch -> expt_selling_price; ?></td> 
						<td><?php echo $fetch -> total_landing_cost; ?></td>
						<td><?php echo $fetch -> stock_ageing; ?></td>   
						<td><?php echo $fetch -> created_date; ?></td>                  
						 </tr>
						 
						 	 <?php } ?>
						 
					
					</tbody>
				</table>
		
			</div>
	</div>    
        </div>
        
     
	
  <script src="<?php echo base_url(); ?>assets/js/campaign.js"></script>    