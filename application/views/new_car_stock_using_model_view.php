<script>
function select_variant_div(){
		var m=document.getElementById("model").value;
	//	alert(m);
	$.ajax(
{
	url:"<?php echo site_url('new_car_stock/select_model_div'); ?>",
	type:'POST',
		

	data:{model:m},
	
	success:function(response)
		{$("#variantdiv").html(response);}
	});

}
	function test()
	{
			
	var m=document.getElementById("model").value;
	var submodel=document.getElementById("submodel").value;
  	var l=document.getElementById("stock_location").value;
	var v=document.getElementById("vehicle_status").value;
	var a=document.getElementById("ageing").value;
	var p=document.getElementById("price").value;

   	
  
 	
	$.ajax(
{
	url:"<?php echo site_url('new_car_stock/with_model_filter'); ?>",
	type:'GET',
		

	data:{model:m,submodel:submodel,stock_location:l,vehicle_status:v,ageing:a,price:p},
	
	success:function(response)
		{$("#table_stock").html(response);}
	});


}
function stock_list(submodel)
	{
			
	
  	var l=document.getElementById("stock_location").value;
	var v=document.getElementById("vehicle_status").value;
	var a=document.getElementById("ageing").value;
	var p=document.getElementById("price").value;

 window.open("<?php echo site_url(); ?>new_car_stock/stock_list1/?id=1&submodel="+submodel+"&stock_location="+l+"&vehicle_status="+v+"&ageing="+a+"&price="+p );				
  
 	
	/*$.ajax(
{
	url:"<?php echo site_url('new_car_stock/stock_list1'); ?>",
	type:'POST',
		

	data:{submodel:submodel,stock_location:l,vehicle_status:v,ageing:a,price:p},
	
	//success:function(response)
	//	{ 
		 //window.open('http://google.com');
	//	window.open('<?php echo site_url();?>new_car_stock/stock_list1');
	//	}
	});*/

}
</script>

<!-- Filter-->
 <div class="container" style="width: 100%;">
<div class="row">

	<div class="x_panel">
<form id="form_cse_filter" action="#" method="post">
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">

		<div class="form-group">
	

		<select class="filter_s col-md-12 col-xs-12 form-control" name="model" id="model" onchange=" select_variant_div()" >

		<option value="">Model</option>
		<?php
		foreach ($select_model as $fetch) {

		?>
		<option value="<?php echo $fetch -> model_id; ?>"><?php echo $fetch -> model_name ?></option>
		<?php
		}
		?>
		</select>
	
</div>
</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">

		<div class="form-group" id="variantdiv">
	

		<select class="filter_s col-md-12 col-xs-12 form-control" name="submodel" id="submodel" >

		<option value="">Submodel</option>
	
		</select>
	
</div>
</div>  
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group">
                                       
                                               
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="stock_location" name="stock_location" >
											<option value=""> Stock Location</option>
												<?php foreach($assigned_location as $fetch){?>
										<option value="<?php echo $fetch->assigned_location; ?>"><?php echo $fetch->assigned_location; ?></option>
												<?php }?>
                                                </select>
											  
                                            </div>
                           </div>
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group">
                                       
                                               
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="vehicle_status" name="vehicle_status" >
											<option value=""> Vehicle Status</option>
												
										<option value="FREE">FREE</option>
							   <option value="BLOCKED">BLOCKED</option>
                                                </select>
											  
                                            </div>
                           </div>
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group">
                                       
                                               
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="ageing" name="ageing" >
											<option value="">Ageing</option>
												
										<option value="1">15 to 30 Days</option>
							   <option value="2">31 To 60 Days	</option>
							   <option value="3">More Than 60 Days	</option>
                                                </select>
											  
                                            </div>
                           </div>
						   <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding:20px;">
                        
                                       <div class="form-group">
                                       
                                               
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="price" name="price" required>
											<option value="">Price</option>
												
										<option value="1">4 To 6 Lakh	</option>
							   <option value="2">6 To 8 Lakh</option>
							   <option value="3">More than 8 Lakh</option>
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
			<th>SR No</th>
                <th>Model</th>
				 <th>Variant</th>
               <th>Count</th>
            </tr>
           
        </thead>
		<tbody>
          <?php 
					$i=0;
						foreach($select_new_stock as $fetch) 
						{
							$i++;
						?>
						
						
						<tr>
						<td>	
						<?php echo $i; ?> 		
						
						</td>
						<td><?php echo $fetch->model_name;  ?></td>
						
						<td><?php echo $fetch->submodel; ?></td>
						<td><a onclick="stock_list('<?php echo $fetch->submodel;?>')" style="cursor:pointer"><?php echo $fetch->model_count ?></a></td>
            </tr>
						<?php }?>
					
					</tbody>
				</table>
		
			
 
  <script src="<?php echo base_url(); ?>assets/js/campaign.js"></script>    