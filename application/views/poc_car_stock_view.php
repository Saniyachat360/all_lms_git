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
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">

		<div class="form-group">
	

		<select class="filter_s col-md-12 col-xs-12 form-control" name="make" id="make" onchange="select_model_div()" >

		<option value="">Car Make</option>
		<?php
		foreach ($select_make as $fetch) {

		?>
		<option value="<?php echo $fetch -> make_id; ?>"><?php echo $fetch -> make_name ?></option>
		<?php
		}
		?>
		</select>
	
</div>
</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
<div id="modeldiv" class="form-group">
	

		<select class="filter_s col-md-12 col-xs-12 form-control" name="model" id="model"  >

		<option value="">Car Model</option>
		
		</select>
	
</div>
</div>
		
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group">
                                       
                                               
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="stock_location" name="stock_location" >
											<option value=""> Stock Location</option>
												<?php foreach($stock_location as $fetch){?>
										<option value="<?php echo $fetch->stock_location; ?>"><?php echo $fetch->stock_location; ?></option>
												<?php }?>
                                                </select>
											  
                                            </div>
                           </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group">
                                       
                                               
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="fuel_type" name="fuel_type" required>
											<option value="">Fuel Type</option>
												
										<option value="Petrol">Petrol	</option>
							   <option value="Diesel">Diesel</option>
							   <option value="CNG">CNG</option>
                                                </select>
											  
                                            </div>
                           </div>
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group">
                                       
                                               
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="ageing" name="ageing" >
											<option value="">Ageing</option>
												<option value="1">0 to 15 Days</option>
										<option value="2">15 to 30 Days</option>
							   <option value="3">31 To 60 Days	</option>
							    <option value="4">60 To 90 Days	</option>
							   <option value="5">More Than 90 Days	</option>
                                                </select>
											  
                                            </div>
                           </div>
						 


          <div class="col-md-offset-5 col-md-2">                  
	    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding:20px;">

			      <a id="sub"  onclick="test()"> <i class="btn btn-md btn-info  entypo-search">Submit</i></a>
		</div>

		 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding:20px;">
		<a onclick="clear_data()"> <i class="btn btn-md btn-primary entypo-cancel">Clear</i></a>

		</div>
		</div>
	</form>


</div>
</div>

</div>











<div class="row" >
	
		<h1 style="text-align:center; ">POC Stock </h1>
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
							
							<th>Location</th>
							<th>Ageing</th>
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
								
							
							<td><?php echo $fetch -> stock_location; ?></td> 
							<td><?php echo $fetch -> ageing; ?></td>   
							<td><?php echo $fetch -> created_date; ?></td>                   
						 </tr>
						 
						 	 <?php } ?>
						 
					
					</tbody>
				</table>
</div>
	
		
		
			
 
  <script src="<?php echo base_url(); ?>assets/js/campaign.js"></script>    