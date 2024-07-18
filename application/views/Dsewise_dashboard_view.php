<script>
	$(document).ready(function() {
		var table = $('#example').DataTable({

			scrollY : "400px",
			scrollX : true,
			scrollCollapse : true,

			fixedColumns : {
				//leftColumns : 5,
				//rightColumns : 1
			}
		});
	});
	
	
	function get_dse_name (){
		
		var location=document.getElementById("location").value;
		var fromdate=document.getElementById("fromdate").value;
		var todate=document.getElementById("todate").value;
		
		//alert(fromdate);
		//alert(todate);
		src1 ="<?php echo base_url('assets/images/loader200.gif');?>";
	var elem = document.createElement("img");
	elem.setAttribute("src", src1);
	elem.setAttribute("height", "95");
	elem.setAttribute("width", "250");
	//elem.setAttribute("alt", "loader");
	
	document.getElementById("campaign_loader").appendChild(elem);
		$.ajax({
    		url : '<?php echo site_url('Dsewise_dashboard/get_dse_name'); ?>',
               data:{"location":location,"fromdate":fromdate,"todate":todate},
        type: 'POST',
		
        success: function(result){
          if(result=='No User Found') 
		{
			
			alert("Please assign Rights");
			return false();
		}
		else
		{
			$("#countview").html(result);
		}
        }
    });
		
	}
	
</script>
<div class="row" >
	<div class="col-md-12">
		<?php echo $this -> session -> flashdata('message'); ?>
	</div>
	
	<h1 style="text-align:center; ">DSE Wise Report</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary">

			<div class="panel-body">
				<form action="" method="post">

					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="col-md-12">
							<div class="col-md-1"></div>
							<div class="col-md-3">
							<div class="form-group">
								
								 <select type="text" class="form-control" id="location" name="location"  ><span class="glyphicon">&#xe252;</span>
                                            <option value=""> Select Location</option> 
											<?php
											
											foreach($locations as $row)
											{
												
											?>
											 <option value="<?php echo $row -> location_id; ?>"><?php echo $row ->location; ?></option> 
											
											<?php } ?>
											</select>   
							</div>
							</div>
							<div class="col-md-3">
								<input type="text" id="fromdate" class="datett filter_s col-md-12 col-xs-12 form-control" placeholder="From Date" name="fromdate" readonly style="background:#F5F5F5; cursor:default;">
										
							</div>
							<div class="col-md-3">
								
								<input type="text" id="todate" class="datett filter_s col-md-12 col-xs-12 form-control" placeholder="To Date" name="todate" readonly style="background:#F5F5F5; cursor:default;">
										
							</div>
							<div class="col-md-2">
								<a id="sub" onclick="get_dse_name();" > <i class="btn btn-info    entypo-search"></i></a>
								<a class="btn btn-primary" onclick='reset()' ><i class="entypo-ccw"></i></a>
							</div>
							
						</div>
					</div>

				<!--	<div class="form-group">
						<div class="col-md-2 col-md-offset-4">

							<button type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12">
								Submit
							</button>
						</div>

						<div class="col-md-2">
							<input type='reset' class="btn btn-primary col-md-12 col-xs-12 col-sm-12" value='Reset'>

						</div>
				</div>-->
			</div>
		</div>
		</form>
	</div>

</div>
<div class="row" id="countview" >
<div class="control-group" id="campaign_loader" style="margin:0% 20% 1% 32%"></div>


	</div>
	
	<script>
		
		function reset()
	{
		window.location="<?php echo site_url('Dsewise_dashboard')?>";
	}
		
	</script>
<script src="<?php echo base_url(); ?>assets/js/campaign.js"></script>