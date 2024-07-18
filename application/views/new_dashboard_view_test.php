<script type="text/javascript" src="<?php echo base_url();?>assets/js/tableExport.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.base64.js"></script>
<script>
function select_telecaller(assign) {
	
	$.ajax({
			type : "POST",
			url : "<?php echo site_url('dashboard/updatetable')?>",
				data : {
				assign : assign
				},
				success : function(result) {

				$("#telecaller").html(result);

				}
	});
}
</script>
<script>
function select_campaign()
{
	var group_id=document.getElementById("group_name").value;
	$.ajax({
			url : '<?php echo site_url('dashboard_test/select_campaign'); ?>',
		type : 'POST',
		data : {'group_id' : group_id,},
		success : function(result) {
		$("#disposition_div").html(result);
		}
});
}
</script>
<script>
function select_leads(){
var campaign_name=document.getElementById("campaign_name").value;
//Create Loader
	src1 ="<?php echo base_url('assets/images/loader200.gif');?>";
	var elem = document.createElement("img");
	elem.setAttribute("src", src1);
	elem.setAttribute("height", "95");
	elem.setAttribute("width", "85");
	elem.setAttribute("alt", "loader");
	
	document.getElementById("campaign_loader").appendChild(elem);	  
	$.ajax({
		url : '<?php echo site_url('dashboard_test/select_table'); ?>',
		type : 'POST',
		data : {'campaign_name' : campaign_name,},
		success : function(result) {
		$("#campaign_table").html(result);
	}
});
}
</script>
<script>
function select_cse_leads(){
var cse_name=document.getElementById("cse_name").value;
//Create Loader
	src1 ="<?php echo base_url('assets/images/loader200.gif');?>";
	var elem = document.createElement("img");
	elem.setAttribute("src", src1);
	elem.setAttribute("height", "95");
	elem.setAttribute("width", "85");
	elem.setAttribute("alt", "loader");
	
	document.getElementById("blah1").appendChild(elem);	  
$.ajax({
		url : '<?php echo site_url('dashboard_test/select_cse_leads'); ?>',
		type : 'POST',
		data : {'cse_name' : cse_name,},
		success : function(result) {
		$("#cse_leads_table").html(result);
		}
	});
}
</script>
<script>
function test(a){
	//alert(a);
	var st=document.getElementById(a).value;
	 
	$.ajax({
		url : '<?php echo site_url('dashboard_test/details'); ?>',
		type : 'POST',
		data : {'st' : st,},
		success : function(result) {
		$("#tracker_list").html(result);
		}
	});
	
}
</script>

<div class="container body" style="width: 100%;">
	<div class="main_container">
			 <!-- page content -->
		<div class="right_col" role="main">
			<div class="row top_tiles">   
              
                    <div class="col-md-12">
                  
                <div class="pull-left">
                <h3>All Leads</h3></div>

 <div class="pull-right">
<a href="#" class="pull-right" onClick ="$('#xls_data').tableExport({type:'excel',escape:'false'});"><i class="btn btn-defult entypo-download"></i></a>
      </div></div>



 <!-- All Lead Table-->
             	<div class="table-responsive">
               		<table id="xls_data" class="table table-striped table-bordered table-responsive">
                         <tbody>
						<tr>
                            <td></td>
                            <td>New & Untouch</td>
                            <td>Live</td>                           
						    <td>Postponed</td>
							<td>Lost</td>
							<td>Converted</td>
							<td>Pending(Live)</td>
							<td>Today Followup</td>
							<td>Total Leads</td>
                        </tr>
                         <tr>                            
                           <td>MTD</td>
                           <td><?php $all_new_lead1=count($all_new_lead_m);                           
                           			echo $all_new_lead1;?>
							</td>
							<td>
								<?php 						
								$all_m_live1 =count($all_m_live);								
								 echo $all_m_live1;?>
							 <td>
							 	<?php 
								
								$all_m_Postponed1 = count($all_m_postponed);
								echo $all_m_Postponed1;   ?>
								
							</td>
							<td><?php 
							 
								 $all_m_Lost1=0; 
							$all_m_Lost1 = $all_m_Lost1 + count($all_m_lost);
							 $all_m_Lost1 = $all_m_Lost1 + count($all_m_lost_lc);
								echo $all_m_Lost1;
							?></td>
							<td><?php 
								
								 $all_m_Converted1 = 0;
							$all_m_Converted1 = $all_m_Converted1 + count($all_m_convert);
							 $all_m_Converted1 = $all_m_Converted1 + count($all_m_convert_lc);
								  echo $all_m_Converted1;
							?></td>
							<td>
								
						
								<?php 
								echo $all_pending_lead1=count($all_pending);
						 ?></td>
						 <td>
						 	<?php echo $all_todays_followup1=count($all_todays_followup);	 ?>
						  </td>
							<td>
								
								<?php echo $total = $all_new_lead1+$all_m_live1 + $all_m_Postponed1 + $all_m_Lost1 + $all_m_Converted1 + $all_todays_followup1; ?></td>
					</tr>
                              <tr>                            
                           <td>YTD</td>
                           <td><?php
								
								 $all_new_lead_y1=count($all_new_lead_y);
								  echo $all_new_lead_y=count($all_new_lead_y1);?>
							</a></td>
							<td>
								<?php 
								
								$all_y_live1 =count($all_y_live);
								
								echo $all_y_live1;?>
							</td>
							 <td><?php 
								
								$all_y_Postponed1 = count($all_y_postponed);
								echo $all_y_Postponed1;   ?></td>
							<td><?php 
								 $all_y_Lost1=0; 
							$all_y_Lost1 = $all_y_Lost1 + count($all_y_lost);
							 $all_y_Lost1 = $all_y_Lost1 + count($all_y_lost_lc);
															echo $all_y_Lost1;
							?></td>
							<td><?php
								 $all_y_Converted1 = 0;
							$all_y_Converted1 = $all_y_Converted1 + count($all_y_convert);
							 $all_y_Converted1 = $all_y_Converted1 + count($all_y_convert_lc);
								 echo $all_y_Converted1;
							?></a></td>
								<td>
								<?php		 
								$all_pending_lead_y1=count($all_pending_y);
								
								echo $all_pending_lead_y1;
						 ?></td>
						
						 
						
						  <td>
						 	<?php echo $all_todays_followup1=count($all_todays_followup);	 ?>
						  </td>
						 
						 
							<td>
								<?php echo $total = $all_new_lead_y+$all_y_live1 + $all_y_Postponed1 + $all_y_Lost1 + $all_y_Converted1+ $all_todays_followup1; ?></td>
                           </tr>
                             
                        
                      
                         </tbody>
                    </table>
</div>





 <!-- Web Lead Table-->

    <div class="col-md-12">
                  
                <div class="pull-left">
               <h3>Website Leads</h3></div>

 <div class="pull-right">
<a href="#" class="pull-right" onClick ="$('#website_count').tableExport({type:'excel',escape:'false'});"><i class="btn btn-defult entypo-download"></i></a>
      </div></div>
    <div class="table-responsive">
    	<!--
               <table id="website_count" class="table table-striped table-bordered table-responsive">
                         <tbody>
					<tr>
						<td></td>
						<td>New</td>
						<td>Live</td>
						<td>Postponed</td>
						<td>Lost</td>
						<td>Converted</td>
						<td>Pending(Live)</td>
						<td>Pending(New)</td>						
						<td>Total Leads</td>

                        </tr>
                         <tr>                            
                           <td>MTD</td>
							<td>
								<?php 
								$t = ' ( ';
								$i=0;
								foreach($web_new_lead as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								 $web_new_lead1=count($web_new_lead);
								if($web_new_lead1!=0)
								 { ?>
								<input type="hidden" id="web_new_lead" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('web_new_lead1');">
								<?php 
								 }
								echo $web_new_lead1?>
							</td>
							<td><?php 
								$t = ' ( ';
								$i=0;
								foreach($web_m_live as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								 $web_m_live1=count($web_m_live);
								if($web_m_live1!=0)
								 { ?>
								<input type="hidden" id="web_m_live" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('web_m_live');">
								<?php 
								 } echo $web_m_live1;
							 ?></td>
							 <td><?php 
								$t = ' ( ';
								$i=0;
								foreach($web_m_postponed as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								 $web_m_Postponed=count($web_m_postponed);
								if($web_m_Postponed!=0)
								 { ?>
								<input type="hidden" id="web_m_Postponed" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('web_m_Postponed');">
								<?php 
								 }
								echo $web_m_Postponed;
							 ?></td>
							<td><?php 
								$t = ' ( ';
								$i=0;
								foreach($web_m_lost as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
							
								foreach($web_m_lost_lc as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								 $web_m_Lost = count($web_m_lost);
							$web_m_Lost = $web_m_Lost+count($web_m_lost_lc);
								if($web_m_Lost!=0)
								 { ?>
								<input type="hidden" id="web_m_Lost" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('web_m_Lost');">
								<?php 
								 }
									echo $web_m_Lost;
							?></td>
							<td><?php 
								$t = ' ( ';
								$i=0;
								foreach($web_m_converted as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								
								foreach($web_m_convert_lc as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								 $web_m_Converted = count($web_m_converted);
								$web_m_Converted =$web_m_Converted + count($web_m_convert_lc);
								if($web_m_Converted!=0)
								 { ?>
								<input type="hidden" id="web_m_Converted" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('web_m_Converted');">
								<?php 
								 } echo $web_m_Converted;
							?></td>
							<td><?php 
								$t = ' ( ';
								$i=0;
								foreach($web_pending as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								  $web_pending_lead1=count($web_pending);
								if($web_pending_lead1!=0)
								 { ?>
								<input type="hidden" id="web_pending_lead" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('web_pending_lead');">
								<?php 
								 } echo $web_pending_lead1;
						 ?></td>
						 <td>
						 	<?php 
								$t = ' ( ';
								$i=0;
								foreach($web_not_attended_pending as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								  $web_pending_lead1=count($web_not_attended_pending);
								if($web_pending_lead1!=0)
								 { ?>
								<input type="hidden" id="web_pending_lead1" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('web_pending_lead1');">
								<?php 
								 }
							
							echo $web_pending_lead1=count($web_not_attended_pending);
						  ?></td>
						 <?php 
						 $t = ' ( ';
								$i=0;
								foreach($web_new_lead as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($web_m_live as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($web_m_postponed as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($web_m_lost as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($web_m_lost_lc as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($web_m_converted as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($web_m_convert_lc as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($web_not_attended_pending as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
						 ?>
							<td> <input type="hidden" id="total_web_m" value="<?php echo $st; ?>"><a href="#" onclick= "test('total_web_m');"><?php echo $total = $web_new_lead1+$web_m_live1 + $web_m_Postponed + $web_m_Lost + $web_m_Converted + $web_pending_lead1; ?></a></td>
					</tr>
                             <tr>                            
                              <td>YTD</td>
                              <td><?php 
								$t = ' ( ';
								$i=0;
								foreach($web_new_lead as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								  $web_new_lead_y = count($web_new_lead);
								if($web_new_lead_y!=0)
								 { ?>
								<input type="hidden" id="web_new_lead_y" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('web_new_lead_y');">
								<?php 
								 }
									echo $web_new_lead_y ;
									?>
							</td>
							<td><?php 
								$t = ' ( ';
								$i=0;
								foreach($web_y_live as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								 $web_y_live1=count($web_y_live);
								if($web_y_live1!=0)
								 { ?>
								<input type="hidden" id="web_y_live" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('web_y_live');">
								<?php 
								 } echo $web_y_live1;
							 ?></td>
							<td><?php 
								$t = ' ( ';
								$i=0;
								foreach($web_y_postponed as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								  $web_y_Postponed=count($web_y_postponed);
								if($web_y_Postponed!=0)
								 { ?>
								<input type="hidden" id="web_y_Postponed" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('web_y_Postponed');">
								<?php 
								 }
								echo $web_y_Postponed;
							?></td>
							<td><?php 
								$t = ' ( ';
								$i=0;
								foreach($web_y_lost as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
							
								foreach($web_y_lost_lc as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								$web_y_Lost =count($web_y_lost);
								$web_y_Lost =$web_y_Lost+count($web_y_lost_lc);
								if($web_y_Lost!=0)
								 { ?>
								<input type="hidden" id="web_y_Lost" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('web_y_Lost');">
								<?php 
								 }
								
								echo $web_y_Lost;
							?></td>
							<td><?php 
								$t = ' ( ';
								$i=0;
								foreach($web_y_converted as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
							
								foreach($web_y_convert_lc as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								 $web_y_Converted=count($web_y_converted);
								 $web_y_Converted=$web_y_Converted+count($web_y_convert_lc);
								if($web_y_Converted!=0)
								 { ?>
								<input type="hidden" id="web_y_Converted" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('web_y_Converted');">
								<?php 
								 }
								
							
							echo $web_y_Converted?></td>
							<td><?php 
								$t = ' ( ';
								$i=0;
								foreach($web_pending_y as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								 $web_pending_lead_y1=count($web_pending_y);
								if($web_pending_lead_y1!=0)
								 { ?>
								<input type="hidden" id="web_pending_lead_y1" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('web_pending_lead_y1');">
								<?php 
								 }
								echo $web_pending_lead_y1;
						 ?></td>
						 <td>
						 	<?php 
								$t = ' ( ';
								$i=0;
								foreach($web_not_attended_pending_y as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								$web_pending_lead_y=count($web_not_attended_pending_y);
								if($web_pending_lead_y!=0)
								 { ?>
								<input type="hidden" id="web_pending_lead_y" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('web_pending_lead_y');">
								<?php 
								 }
							
							echo $web_pending_lead_y;
						  ?></td>
						  <?php 
						  $t = ' ( ';
								$i=0;
								foreach($web_new_lead as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($web_y_live as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($web_y_postponed as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($web_y_lost as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
							
								foreach($web_y_lost_lc as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($web_y_converted as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
							
								foreach($web_y_convert_lc as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($web_not_attended_pending_y as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
						  ?>
							<td><input type="hidden" id="total_web_y" value="<?php echo $st; ?>"><a href="#" onclick= "test('total_web_y');"><?php echo $total = $web_new_lead_y+$web_y_live1 + $web_y_Postponed + $web_y_Lost + $web_y_Converted + $web_pending_lead_y; ?></a></td>
							
							
                             </tr>
                      
                         </tbody>
                 </table>-->
</div>








 <!-- Campaign Lead Table-->
 <div class="col-md-12">
    <div  class="col-md-5">
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> Group Name: </label>
									<div class="col-md-8 col-sm-8 col-xs-12">
							    
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="group_name" name="group_name" onchange="select_campaign();" required>
												 <option value=""> Please Select </option>
															<?php
								foreach ($select_grp as $row) {
									?>
									<option   value="<?php echo $row -> group_id; ?>"> <?php echo $row -> group_name; ?></option>
									<?php
									}
	 ?>	
										</select>
									</div>
								</div>

							</div>
							
							 <div  class="col-md-6">
								<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Campaign Name: </label>
									<div class="col-md-5 col-sm-5 col-xs-12" id="disposition_div">
										
										
									       
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="campaign_name"  name="campaign_name" required>
                                              
										
											<option   value=""> Please Select </option>
											
										</select>
									</div>
								</div>

							</div>
							<div class="pull-right" style="padding-top:20px;">
	
                                       
<a href="#" class="pull-right" onClick ="$('#campaign_count').tableExport({type:'excel',escape:'false'});"><i class="btn btn-defult entypo-download"></i></a>
           </div>
		</div>					<br><br><br>
     <div class="table-responsive" id="campaign_table">
    <div class="control-group" id="campaign_loader" style="margin:0% 30% 1% 50%"></div>
               <table id="campaign_count" class="table table-striped table-bordered table-responsive">
                         <tbody>
					<tr>
                            <td></td>
                            <td>New</td>
                            <td>Live</td>
                            <td>Postponed</td>
						    <td>Lost</td>
						    <td>Converted</td>
						    <td>Pending(Live)</td>
							<td>Today Followup</td>
							<td>Total Leads</td>
                        </tr>
                             <tr>
                          	<td>MTD</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							</tr>
                             <tr>
                        	<td>YTD</td>
                            <td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							</tr>
                      
                         </tbody>
                    </table>
</div>



 <div class="col-md-12">
    <div  class="col-md-4">
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name"> CSE Leads: </label>
									<div class="col-md-8 col-sm-8 col-xs-12">
							    
                                              <select class="filter_s col-md-12 col-xs-12 form-control" id="cse_name" name="cse_name" onchange="select_cse_leads();" required>
												 <option value=""> Please Select </option>
															<?php
								foreach ($select_cse as $row) {
									?>
									<option value="<?php echo $row -> id; ?>"><?php echo $row -> fname . " " . $row -> lname; ?></option>
									<?php
									}
	 ?>	
										</select>
										
										
										
									</div>
									
									
									
								</div>

							</div>
							<div class="pull-right" >
	
                                       
<a href="#" class="pull-right" onClick ="$('#cse_count').tableExport({type:'excel',escape:'false'});"><i class="btn btn-defult entypo-download"></i></a>
           </div>
					</div>		
						
							<br><br><br>
     <div class="table-responsive" id="cse_leads_table">
     	<div class="control-group" id="blah1" style="margin:0% 30% 1% 50%"></div>
               <table id="cse_count" class="table table-striped table-bordered table-responsive">
                         <tbody>
					<tr>
                            <td></td>
                            <td>New & Untouch</td>
                            <td>Live</td>
                            <td>Postponed</td>
						    <td>Lost</td>
						    <td>Converted</td>
						    <td>Pending(Live)</td>
							<td>Today Followup</td>
							<td>Total Leads</td>
                        </tr>
                             <tr>
                          	<td>MTD</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							</tr>
                             <tr>
                        	<td>YTD</td>
                            <td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							</tr>
                      
                         </tbody>
                    </table>
				</div>
            </div>
        </div>
     </div>
 </div>
                           