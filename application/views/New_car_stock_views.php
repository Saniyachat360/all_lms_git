

<script>

	function test()
	{
			
  	var l=document.getElementById("assigned_location").value;
  	//alert(l);
   	
   	var model=document.getElementById("model").value;
   //alert(bf);
   	
  
 	
	$.ajax(
{
	url:"<?php echo site_url('new_car_stock/new_stock_filter'); ?>",
	type:'POST',
		

	data:{model:model,assigned_location:l},
	
	success:function(response)
		{$("#table_stock").html(response);}
	});


}
</script>

<!-- Filter-->
 <div class="container" style="width: 100%;">
<div class="row">

<div class="x_panel">
<form id="form_cse_filter" action="#" method="post">
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="padding:20px;">

		<div class="form-group">
		<div id="txtHint1">

		<select class="filter_s col-md-12 col-xs-12 form-control" name="model" id="model" >

		<option value="">Model</option>
		<?php
		foreach ($select_model as $fetch) {

		?>
		<option value="<?php echo $fetch -> submodel;?>"><?php echo $fetch -> submodel ?></option>
		<?php
		}
		?>
		</select>
	</div>
</div>
</div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group">
                                       
                                               
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="assigned_location" name="assigned_location" required>
											<option value="">Location</option>
													 <?php foreach($assigned_location as $row)
									{?>
										<option value="<?php echo $row -> assigned_location; ?>"><?php echo $row -> assigned_location; ?></option>
								<?php } ?>
                                               
                                                </select>
											  
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

</div>

</div>

</div>
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

<div class="row" >
	
		<h1 style="text-align:center; ">New Stock Summary</h1>
		 </div> 
	<script>
	$(document).ready(function() {
	
		var table = $('#example').DataTable({
			searching:false,
				scrollY : "400px",
				scrollX : true,
				scrollCollapse : true,
			/*fixedColumns:   true,
			fixedColumns : {
				leftColumns : 1,
				rightColumns : 0
			}*/
		});
		
	}); 
</script>
<style>
.DTFC_LeftHeadWrapper table.dataTable thead tr{
	height:45px;
} 
 th, td {
        white-space: nowrap;
        padding-left: 40px !important;
        padding-right: 40px !important;
		border-left: 1px solid #eaeaea;
		border-bottom: 1px solid #eaeaea;
    }
	table.dataTable thead th, table.dataTable thead td {
		border-bottom: 1px solid #eaeaea;
	}
    div.dataTables_wrapper {

        margin: 0 auto;
    }
</style>
<div  id="table_stock" >
	
			<table id="example" class="stripe row-border order-column" style="width:100%">
        <thead>
            <tr>
				<th rowspan="2">SR No</th>
                <th rowspan="2">Model</th>
				 <th rowspan="2">Varient</th>
                <th colspan="2" style="text-align:center">Vehicle Status</th>
                <th colspan="4" style="text-align:center">Ageing</th>
				<th colspan="4" style="text-align:center">Price</th>
            </tr>
            <tr>
			
                <th>FREE</th>
                <th>BLOCKED</th>
          
				
				<th>Before 15 Days</th>
				<th>15 to 30 Days</th>
				<th>31 To 60 Days</th>
				<th>More Than 60 Days</th>
				
				<th>Less than 4 lakh</th>
				<th>4 To 6 Lakh</th>
				<th>6 To 8 Lakh</th>
				<th>More than 8 Lakh</th>
				
            </tr>
        </thead>
		<tbody>
          <?php 
					$i=0;
					//print_r($select_new_stock);
						foreach($select_new_stock as $fetch) 
						{
							$i++;
						?>
						
						
						<tr>
						<td>	
						<?php echo $i; ?> 		
						
						</td>
						<td><?php echo $fetch['model_name']; ?></td>
						
						<td><?php echo $fetch['submodel'].  '    ('. $fetch['model_count'].')'; ?></td>
						
						<td><a href="<?php echo site_url('new_car_stock/stock_list/?id=1&submodel='.$fetch['submodel'].'&assigned_location='.$fetch['assigned_location']);?>"><?php echo $fetch['vehicle_status_1']; ?></a></td>
						<td><a href="<?php echo site_url('new_car_stock/stock_list/?id=2&submodel='.$fetch['submodel'].'&assigned_location='.$fetch['assigned_location']);?>"><?php echo $fetch['vehicle_status_2']; ?></a></td>
						
						<td><a href="<?php echo site_url('new_car_stock/stock_list/?id=3&submodel='.$fetch['submodel'].'&assigned_location='.$fetch['assigned_location']);?>"><?php echo $fetch['ageing_1']; ?></a></td>
						<td><a href="<?php echo site_url('new_car_stock/stock_list/?id=4&submodel='.$fetch['submodel'].'&assigned_location='.$fetch['assigned_location']);?>"><?php echo $fetch['ageing_2']; ?></a></td>
						<td><a href="<?php echo site_url('new_car_stock/stock_list/?id=5&submodel='.$fetch['submodel'].'&assigned_location='.$fetch['assigned_location']);?>"><?php echo $fetch['ageing_3']; ?></a></td>
						<td><a href="<?php echo site_url('new_car_stock/stock_list/?id=6&submodel='.$fetch['submodel'].'&assigned_location='.$fetch['assigned_location']);?>"><?php echo $fetch['ageing_4']; ?></a></td>
					
				
						<td><a href="<?php echo site_url('new_car_stock/stock_list/?id=7&submodel='.$fetch['submodel'].'&assigned_location='.$fetch['assigned_location']);?>"><?php echo $fetch['price_1']; ?></a></td>
						<td><a href="<?php echo site_url('new_car_stock/stock_list/?id=8&submodel='.$fetch['submodel'].'&assigned_location='.$fetch['assigned_location']);?>"><?php echo $fetch['price_2']; ?></a></td>
						<td><a href="<?php echo site_url('new_car_stock/stock_list/?id=9&submodel='.$fetch['submodel'].'&assigned_location='.$fetch['assigned_location']);?>"><?php echo $fetch['price_3']; ?></a></td>
						<td><a href="<?php echo site_url('new_car_stock/stock_list/?id=10&submodel='.$fetch['submodel'].'&assigned_location='.$fetch['assigned_location']);?>"><?php echo $fetch['price_4']; ?></a></td>
					
               
            </tr>
						<?php }?>
				
					</tbody>
				</table>
		
			
 
  <script src="<?php echo base_url(); ?>assets/js/campaign.js"></script>    