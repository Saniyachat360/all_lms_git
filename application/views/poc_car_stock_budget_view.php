<script>
function select_model_div(){
		var m=document.getElementById("make").value;
	//	alert(m);
	$.ajax(
{
	url:"<?php echo site_url('poc_stock/select_model_div'); ?>",
	type:'POST',
		

	data:{make:m},
	
	success:function(response)
		{$("#modeldiv").html(response);}
	});

}
	function test()
	{
			
	var make=document.getElementById("make").value;
	var model=document.getElementById("model").value;
  	var stock_location=document.getElementById("stock_location").value;
	var fuel_type=document.getElementById("fuel_type").value;
	var ageing=document.getElementById("ageing").value;
	

   	//Create Loader
					src1 ="<?php echo base_url('assets/images/loader200.gif'); ?>";
						var elem = document.createElement("img");
						elem.setAttribute("src", src1);
						elem.setAttribute("height", "95");
						elem.setAttribute("width", "250");
						elem.setAttribute("alt", "loader");

						document.getElementById("blah").appendChild(elem);
  
 	
	$.ajax(
{
	url:"<?php echo site_url('poc_stock/stock_filter'); ?>",
	type:'POST',
		

	data:{make:make,model:model,stock_location:stock_location,fuel_type:fuel_type,ageing:ageing},
	
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
	<div class="row" >
	
		<h1 style="text-align:center; ">POC Stock Budget</h1>
		 </div> 
	<script>
	$(document).ready(function() {
	
		if($("#example").width()>1308){
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
		}else{
				var table = $('#example').DataTable({
				searching:false,
				scrollY : "400px",
				scrollX : false,
			scrollCollapse : true,

			fixedColumns : {
				leftColumns : 0,
				rightColumns : 0
			}
		});
				
			}
		
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
<div class="col-md-12 table-responsive"  id="table_stock" >
	<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>

<table class="table table-bordered  datatable" id="example"> 
					<thead>
						<tr>
							<th>Sr No.</th>
							<th>Make</th>
							<th>Model</th>
							<th>Color</th>
							<th>Fuel Type</th>
							<th>Price</th>
							<th>Outlet Name</th>
							<th>RTO Number</th>
							<th>Mfg Year</th>
							<th>Mfg Month</th>
							<th>Owner</th>
							<th>Location</th>
							<th>Ageing</th>
							<th>RC Status</th>
							<th>Vehicle Status</th>
							<th>Quality Status</th>
							<th>Reg Date</th>
							<th>Last Updated</th>
						</tr>	
					</thead>
					<tbody>
				
					 <?php 
					 $i=0;
						foreach($select_stock as $fetch) 
						{
							$i++;
						?>
						
						<tr>
						<td>	
						<?php echo $i; ?> 		
						
						</td>
							<td><?php echo $fetch -> make_name; ?></td>

							<td><?php echo $fetch -> model; ?></td>
							<td><?php echo $fetch -> color; ?></td>

							<td><?php echo $fetch -> fuel_type; ?></td>
							<td><?php echo $fetch -> expt_selling_price; ?></td>
							<td><?php echo $fetch -> outlet_name; ?></td>

							<td><?php echo $fetch -> rto_no; ?></td>
							<td><?php echo $fetch -> mfg_year; ?></td>
							<td><?php echo $fetch -> mfg_month; ?></td>
							<td><?php echo $fetch -> owner; ?></td>
							<td><?php echo $fetch -> stock_location; ?></td>
							

						 
							<td><?php echo $fetch -> ageing; ?></td>
							<td><?php echo $fetch -> rc_status; ?></td>
							<td><?php echo $fetch -> vehicle_status; ?></td>
							<td><?php echo $fetch -> quality_status; ?></td>
							<td><?php echo $fetch -> reg_date; ?></td>
							<td><?php echo $fetch -> created_date; ?></td>
						 </tr>
						 
						 	 <?php } ?>
						 
					
					</tbody>
				</table>
</div>
	
		
		
			
 
  <script src="<?php echo base_url(); ?>assets/js/campaign.js"></script>