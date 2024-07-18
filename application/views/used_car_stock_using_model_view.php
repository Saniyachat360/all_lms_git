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
function select_model_div(){
		var m=document.getElementById("make").value;
	//	alert(m);
	$.ajax(
{
	url:"<?php echo site_url('used_car_stock/select_model_div'); ?>",
	type:'POST',
		

	data:{make:m},
	
	success:function(response)
		{$("#model_div").html(response);}
	});

}
	function test()
	{
			
	var m1=document.getElementById("make").value;
	
	var submodel=document.getElementById("model").value;
  	var l=document.getElementById("stock_location").value;
	var m=document.getElementById("mfg_year").value;
	var o=document.getElementById("owner").value;
	var a=document.getElementById("ageing").value;
	var p=document.getElementById("price").value;

   	
  
 	
	$.ajax(
{
	url:"<?php echo site_url('used_car_stock/with_model_filter'); ?>",
	type:'GET',
		

	data:{make:m1,submodel:submodel,stock_location:l,mfg_year:m,owner:o,ageing:a,price:p},
	
	success:function(response)
		{$("#table_stock").html(response);}
	});


}
	function stock_list(submodel)
	{
			
	
  	var l=document.getElementById("stock_location").value;
	var m=document.getElementById("mfg_year").value;
	var o=document.getElementById("owner").value;
	var a=document.getElementById("ageing").value;
	var p=document.getElementById("price").value;

   	
 window.open("<?php echo site_url(); ?>used_car_stock/stock_list1/?id=1&submodel="+submodel+"&stock_location="+l+"&mfg_year="+m+"&ageing="+a+"&owner="+o+"&price="+p );				
  


}
</script>


<!-- Filter-->
 <div class="container" style="width: 100%;">
<div class="row" style='padding-top:20px'>

	<div class="x_panel">
<form id="form_cse_filter" action="#" method="post">
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" >

		<div class="form-group">
	

		<select class="filter_s col-md-12 col-xs-12 form-control" name="make" id="make" onchange="select_model_div()" >

		<option value="">Make</option>
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
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" >

		<div class="form-group " id="model_div">
	

		<select class="filter_s col-md-12 col-xs-12 form-control" name="model" id="model" >

		<option value="">Model</option>
		
		</select>
	
</div>
</div>
		
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" >
                        
                                       <div class="form-group">
                                       
                                               
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="stock_location" name="stock_location" >
											<option value=""> Stock Location</option>
												<?php foreach($stock_location as $fetch){?>
										<option value="<?php echo $fetch->stock_location; ?>"><?php echo $fetch->stock_location; ?></option>
												<?php }?>
                                                </select>
											  
                                            </div>
                           </div>
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" >
                        
                                       <div class="form-group">
                                       
                                               
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="mfg_year" name="mfg_year" >
											<option value=""> Mfg Year</option>
												
										<option value="1">Before 2010</option>
							   <option value="2">2010-12</option>
							   <option value="3">2012-15</option>
							    <option value="4">After 2015</option>
                                                
												</select>
											  
                                            </div>
                           </div>
	<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12" >
                        
                                       <div class="form-group">
                                       
                                               
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="owner" name="owner" >
											<option value="">Owner</option>
												
										<option value="1">One</option>
							   <option value="2">Two</option>
							   <option value="3">More than two	</option>
                                                </select>
											  
                                            </div>
                           </div>
						   <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12" >
                        
                                       <div class="form-group">
                                       
                                               
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="ageing" name="ageing" required>
											<option value="">Ageing</option>
												
										<option value="1">Before 15 Days	</option>
							   <option value="2">15 to 30 Days	</option>
							   <option value="3">31 To 60 Days</option>
							     <option value="4">More Than 60 Days</option>
                                                </select>
											  
                                            </div>
                           </div>

						   <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" >
                        
                                       <div class="form-group">
                                       
                                               
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="price" name="price" required>
											<option value="">Price</option>
												
										<option value="1">Less than 2 lakh</option>
							   <option value="2">2 To 5 Lakh</option>
							   <option value="3">More than 5 Lakh</option>
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
	
		<h1 style="text-align:center; ">POC Stock Summary</h1>
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
                <th>Make</th>
				 <th>Model</th>
				  <th>submodel</th>
               <th>Count</th>
            </tr>
           
        </thead>
		<tbody>
          <?php 
					$i=0;
						foreach($select_old_stock as $fetch) 
						{
							$i++;
						?>
						
						
						<tr>
						<td>	
						<?php echo $i; ?> 		
						
						</td>
						<td><?php echo $fetch->make_name;  ?></td>
						
						<td><?php echo $fetch->model; ?></td>
						<td><?php echo $fetch->submodel ;?></td>
						<td><a onclick="stock_list('<?php echo $fetch->submodel;?>')" style="cursor:pointer"><?php echo $fetch->model_count ; ?></a></td>
            </tr>
						<?php }?>
					
					</tbody>
				</table>
		
			
 
  <script src="<?php echo base_url(); ?>assets/js/campaign.js"></script>    