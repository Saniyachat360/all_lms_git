
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
  <div class="row" >
	<h1 style="text-align:center; ">Evaluation</h1>
	<div class="col-md-12" >
		<div class="panel panel-primary">
			<?php 
			/*$executive_array=array("3","4","8","10","12","14");
			if(in_array($_SESSION['role'],$executive_array)){}else{ */?>
			<div class="panel-body">			
		<?php 	$header_process_id=$this->session->userdata('process_id');
		
		
		
		$executive_array=array("1","2","5","7","9","11","13","15");
			if(in_array($this->session->userdata('role'),$executive_array)){ ?>
					<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="col-md-offset-1 col-md-11">
							<div class="form-group  col-md-6">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" >Location: </label>
								<div class="col-md-7 col-sm-7 col-xs-12">
									<select id="location_name" class="form-control"  required name="location_name">
									<option value="">Please Select</option>
									<?php foreach($select_location as $location) { ?>
									<option value="<?php echo $location -> location_id; ?>"><?php echo $location -> location; ?></option>
									<?php } ?>
									
									</select>
								</div>
							</div>
							<div class="form-group col-md-2">
							 <input type="radio" name="get_user" value="TL"> TL &nbsp;&nbsp;
							<input type="radio" name="get_user" value="DSE" > Executive<br>
							</div>
							<div class="form-group col-md-3 ">
							<button type="submit" class="btn btn-info col-md-5" onclick="get_group()" >Submit</button>
							
							<button type="submit" class="btn btn-primary col-md-offset-1 col-md-5" onclick="clear_data()" >Clear</button>
							</div>
						</div>
					</div>
		<?php }else{ ?>
							<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						<div class="col-md-offset-2 col-md-9">
							<div class="form-group ">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Location: </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<select id="location_name" class="form-control"  required name="location_name" onchange="get_group()">
									<option value="">Please Select</option>
									<?php foreach($select_location as $location) { ?>
									<option value="<?php echo $location -> location_id; ?>"><?php echo $location -> location; ?></option>
									<?php } ?>
									
									</select>
								</div>
							</div>
							
						
						</div>
					</div>
		<?php } ?>
				</div><?php // } ?>
		</div>
		
	</div>

</div>

<div class="row" id="count_div">
	<div class="control-group" id="blah" style="margin:0% 20% 1% 32%"></div>
		<?php
		if(isset($select_leads)){if(count($select_leads)>0){
			 foreach ($location_data as $row) {
// 			$unassigned_leads_count=$unassigned_leads_count+$row['unassigned_leads'];
// 			$new_leads_count=$new_leads_count+$row['new_leads'];
// 			$call_today_leads_count=$call_today_leads_count+$row['call_today'];
// 			$pending_new_leads_count=$pending_new_leads_count+$row['pending_new_leads'];
// 			$pending_followup_leads_count=$pending_followup_leads_count+$row['pending_followup'];
			 }
			/*$executive_array=array("3","4","8","10","12","14");
			if(in_array($_SESSION['role'],$executive_array)){*/ ?>
	<!--<div class="col-md-12">
				<table class="table table-bordered datatable" id="table-4">
				<thead>
					<tr>
							<th><b>Sr No.</b></th>
							<th><b>Leads</b></th>

							<th><b>Count
								</b>
							</th>
						
					</tr>
				</thead>
				<tbody>
					
					<tr>
						<td>1</td>
						<td>Unassigned Leads</td>
					
						<td><?php echo $unassigned_leads_count; ?>
							
						</td>
						<?php } ?>
					</tr>
					
					<tr>
						<td>2</td>
						<td>New Leads</td>
		
						
		
						<td><?php echo $new_leads_count; ?>
							
						</td>
		
						
					</tr>
					<tr>
						<td>3</td>
						<td>Call Today Leads</td>
		
						
		
						<td><?php echo $call_today_leads_count; ?>
						
		
					
					</tr>
					<tr>
						<td>4</td>
						<td>Pending New Leads</td>
		
						
		
						<td><?php echo $pending_new_leads_count; ?>
						
		
					
					</tr>
					<tr>
						<td>5</td>
						<td>Pending Followup Leads</td>
		
					
		
						<td><?php echo $pending_followup_leads_count; ?>
				
					</tr>
				</tbody>
			</table>
			</div>-->
<?php //}
} else { 
}
//}?>
	
	
	
</div>
					
<script>
function clear_data(){
	document.getElementById("location_name").value='';
	var radios = document.getElementsByName('get_user');
$( 'input[type=radio]' ).prop( "checked", false );
}
	function get_group()
	{
// 		alert('Hi');
		var location_name=document.getElementById("location_name").value;
		
		var radios = document.getElementsByName('get_user');

        for (var i = 0, length = radios.length; i < length; i++)
        {
            if (radios[i].checked)
            {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
                var user=radios[i].value;
            // only one radio can be logically checked, don't check the rest
                break;
            }
        }
        //alert(user);
		//alert(location_name);location_name
		//Create Loader
			src1 ="<?php echo base_url('assets/images/loader200.gif'); ?>";
		    var elem = document.createElement("img");
		    elem.setAttribute("src", src1);
		    elem.setAttribute("height", "95");
		    elem.setAttribute("width", "250");
		    elem.setAttribute("alt", "loader");

		    document.getElementById("blah").appendChild(elem);
		    <?php if($this->session->userdata('process_id')==9){
		    	$ajaxurl=site_url()."Notification_evaluation/all_notification_complaint_counts";
		    }else{
		    	$ajaxurl= site_url()."Notification_evaluation/all_notification_counts";
		    }
		    ?>

		    $.ajax({url: "<?php echo $ajaxurl; ?>",
	        type:"POST",
	        data:{location_name:location_name,user:user},
	        success: function(result){
	        $("#count_div").html(result)
	        } 
						    
		});
	}

</script>
