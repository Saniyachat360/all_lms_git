
<script>
	$(document).ready(function() {
		var table = $('#example').DataTable({

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
<!--- Fetch Table Data -->
<script><?php
$page = $this -> uri -> segment(4);
if (isset($page)) {
	$page = $page + 1;

} else {
	$page = 0;

}
$offset1 = 100 * $page;
//$query=$sql->result();
//echo $c = count($select_lead);
		?></script>
<div class="row">
	<div id="leaddiv" class="col-md-12" >
		<div class="control-group" id="blah" style="margin:0% 30% 1% 50%">
				
				</div>
	<!--	<div class="table-responsive"  >
	
			<table id="example"  class="table " style="width:auto;" cellspacing="0"> 
		
		
		
				<thead>
						<tr>
							<tr>
							<th>Sr No.</th>
							<th>Lead Source</th>
							<th>Customer Name</th>
							<th>Mobile Number</th>
							<th>Address</th>
							<th>Email ID</th>
							<th>Lead Date</th>
							
							
							<th>CSE Name</th>
							
							<th>CSE Call Date</th>
							<th>CSE Nextaction</th>
							<th>CSE Feedback</th>
							<th>CSE Remark</th>	
							<th>CSE NFD</th>
							<th>TD/HV date</th>
							
							<th>Booking within Days</th>
							<th>DSE Name</th>
							<th>DSE Call Date</th>
							<th>DSE Nextaction</th>
							<th>DSE Feedback</th>
							<th>DSE Remark</th>	
							<th>DSE NFD</th>
								
						
							<th>Buyer Type</th>
							<th>Model/Variant</th>
							<th>Exchange Make/Model</th>
							<th>Manufacturing Year</th>
						
						</tr>	
						</tr>	
					</thead>
					<tbody>
					
							<?php
					$i=$offset1;
				
				if (!empty($select_lead)) 
					{
					foreach($select_lead as $fetch)
					{
						//print_r($fetch);
						  $enq_id=$fetch->enq_id;
							$i++; ?>
							<tr>
					<td><?php echo $i; ?></td>
				<td><?php
						if ($fetch -> lead_source == '') { echo "Website";
						} else { echo $fetch -> lead_source;
						}
 ?></td>
					<td><b><?php echo $fetch -> name; ?></b></td>
                    <td><?php echo $fetch -> contact_no; ?></td>
                    <td><?php echo $fetch -> address; ?></td>
                    <td><?php echo $fetch -> email; ?></td>
                     <td><?php echo $fetch -> lead_date; ?></td>
                 
							
							 CSE Information
								<?php if($fetch->assign_to_cse == 0){?>
									<td><?php echo $fetch -> csetl_fname . ' ' . $fetch -> csetl_lname; ?></td>
					
					<?php }else{ ?>
						<td><?php echo $fetch -> cse_fname . ' ' . $fetch -> cse_lname; ?></td>
						<?php } ?>
					
					
					<td><?php echo $fetch -> cse_date; ?></td>
						<td><?php echo $fetch -> csenextAction; ?></td>
						
					<td><?php echo $fetch -> csefeedback; ?></td>
				
					<td><?php echo $fetch -> cse_comment; ?></td>
					
					<td><?php echo $fetch -> cse_nfd; ?></td>
					
					<td><?php echo $fetch -> td_hv_date; ?></td>
					<td><?php echo $fetch -> days60_booking; ?></td>
						
						
						dSE Informat						
							 		 <?php   if($fetch->assign_to_dse == 0){
							 	?>
							 	<td><?php echo $fetch -> dsetl_fname . ' ' . $fetch -> dsetl_lname; ?></td>
							 <?php	}else{
									if($fetch->dse_role ==4 || $fetch->dse_role ==5 ){
							  ?>
							 <td><?php echo $fetch -> dse_fname . ' ' . $fetch -> dse_lname; ?></td>
							 			<?php ?>
					<?php }else{ ?>
						<td></td>	
						<?php } } ?>
							 <?php  if($fetch->dse_role ==4 || $fetch->dse_role ==5 ){?>
					<td><?php echo $fetch -> dse_date; ?></td>
					<?php }else{ ?>
						<td></td>
						<?php } ?>
						<?php  if($fetch->dse_role ==4 || $fetch->dse_role ==5 ){?>
					<td><?php echo $fetch -> dsenextAction; ?></td>
					<?php } else{ ?>
						<td></td>
						<?php } ?>
						
							 <?php  if($fetch->dse_role ==4 || $fetch->dse_role ==5 ){?>
					<td><?php echo $fetch -> dsefeedback; ?></td>
					<?php } else{ ?>
						<td></td>
						<?php } ?>
							 <?php  if($fetch->dse_role ==4 || $fetch->dse_role ==5 ){?>
					<td><?php echo $fetch -> dse_comment; ?></td>
						<?php }else{ ?>
						<td></td>	
						<?php } ?>
					<td><?php echo $fetch -> dse_nfd; ?></td>	
						
			
              
                  	<td><?php echo $fetch -> buyer_type; ?></td>
                    <td><?php echo $fetch -> new_model_name . ' ' . $fetch -> variant_name; ?></td>
          			 <td><?php echo $fetch -> make_name . ' ' . $fetch -> old_model_name; ?></td>
                    <td><?php echo $fetch -> manf_year; ?></td>
                  
							
						</tr>	
					<?php } } ?>
				
					</tbody>
					</table>

	
</div>			
<div class="col-md-12" style="margin-top: 20px;">
<div class="col-md-6" style="font-size: 14px">

   <?php
$lead_count = count($select_lead);
// echo $count_total;
if (isset($count_lead_dse_lc)) {$count_lead_dse_lc = $count_lead_dse_lc[0] -> count_lead_dse_lc;
}
if (isset($count_lead_dse)) {$count_lead_dse = $count_lead_dse[0] -> count_lead_dse;
}
$total_record = 0;
foreach ($count_lead as $row) {
	$total_record = $total_record + $row -> lead_count;
}
//$lead_cou = $count_lead_dse_lc+$count_lead_dse;
echo 'Total Records :';
echo '<b>' . $total_record . '</b>';
//print_r($count_lead);
		?>
   &nbsp;&nbsp;
  
     <?php echo 'Total Pages :';
	$pages = $total_record / 100;
	echo '<b>' . $total_page = ceil($pages) . '</b>';
 ?>
 
    </div>

<div class="col-md-6  form-group">
 
     
	
		
	<?php

			if ($c < 100) {
				$last = $page - 2;
				if ($last != -2) {
					echo "<a class='col-md-push-1 col-md-2 btn btn-info'  href=" . site_url() . 'new_tracker/leads/page/'.$last.'?campaign_name='.$campaign_name.'&nextaction='.$nextaction.'&feedback='.$feedback.'&fromdate='.$fromdate.'&todate='.$todate.'&date_type='.$date_type.">
<i class='fa fa-angle-left'></i>   Previous   </a>";
					echo "<a class='col-md-pull-3 col-md-1  btn btn-info'  href=" . site_url() . 'new_tracker/leads?campaign_name='.$campaign_name.'&nextaction='.$nextaction.'&feedback='.$feedback.'&fromdate='.$fromdate.'&todate='.$todate.'&date_type='.$date_type.">First  
<i class='fa fa-angle-right'></i></a>";
					$last1 = $total_page - 2;
					echo "<a class=' col-md-push-5 col-md-1  btn btn-info' href=" . site_url() . 'new_tracker/leads/page/'.$last1.'?campaign_name='.$campaign_name.'&nextaction='.$nextaction.'&feedback='.$feedback.'&fromdate='.$fromdate.'&todate='.$todate.'&date_type='.$date_type.">Last  
<i class='fa fa-angle-right'></i></a>";
				}
			} else if ($page == 0) {
				echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px;' href=" . site_url() . 'new_tracker/leads/page/'.$page.'?campaign_name='.$campaign_name.'&nextaction='.$nextaction.'&feedback='.$feedback.'&fromdate='.$fromdate.'&todate='.$todate.'&date_type='.$date_type.">Next  
<i class='fa fa-angle-right'></i></a>";
				echo "<a class=' col-md-1  btn btn-info'  href=" . site_url() . "new_tracker/leads>First  
<i class='fa fa-angle-right'></i></a>";
				$last1 = $total_page - 2;
				echo "<a class=' col-md-push-6 col-md-1  btn btn-info' href=" . site_url() . 'new_tracker/leads/page/'.$last1.'?campaign_name='.$campaign_name.'&nextaction='.$nextaction.'&feedback='.$feedback.'&fromdate='.$fromdate.'&todate='.$todate.'&date_type='.$date_type.">Last  
<i class='fa fa-angle-right'></i></a>";
			} else {
				$last = $page - 2;
				echo " <a class='col-md-push-2 col-md-2 btn btn-info'  href=" . site_url() . 'new_tracker/leads/page/'.$last.'?campaign_name='.$campaign_name.'&nextaction='.$nextaction.'&feedback='.$feedback.'&fromdate='.$fromdate.'&todate='.$todate.'&date_type='.$date_type.">
<i class='fa fa-angle-left'></i>   Previous   </a> ";
				echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px ;' href=" . site_url() . 'new_tracker/leads/page/'.$page.'?campaign_name='.$campaign_name.'&nextaction='.$nextaction.'&feedback='.$feedback.'&fromdate='.$fromdate.'&todate='.$todate.'&date_type='.$date_type.">Next  
<i class='fa fa-angle-right'></i></a>";

				echo "<a class='col-md-pull-3 col-md-1  btn btn-info' href=" . site_url() . 'new_tracker/leads?campaign_name='.$campaign_name.'&nextaction='.$nextaction.'&feedback='.$feedback.'&fromdate='.$fromdate.'&todate='.$todate.'&date_type='.$date_type.">First  
<i class='fa fa-angle-right'></i></a>";
				$last1 = $total_page - 2;
				echo "<a class='  col-md-push-6 col-md-1  btn btn-info'  href=" . site_url() . 'new_tracker/leads/page/'.$last1.'?campaign_name='.$campaign_name.'&nextaction='.$nextaction.'&feedback='.$feedback.'&fromdate='.$fromdate.'&todate='.$todate.'&date_type='.$date_type.">Last  
<i class='fa fa-angle-right'></i></a>";

			}

			$page1 = $page + 1;
		?>

       <label class="col-md-pull-1 col-md-2  control-label" style="margin-top: 7px;" >Page No</label>
         <input class="col-md-pull-1  col-md-1" type="text" value="<?php echo $page1?>" name="pageNo" id="pageNo" style="width: 56px;border-radius:4px;height: 35px">
         <input class="col-md-pull-1  col-md-1  btn btn-danger "  style="margin-left: 10px;" type="submit" value="Go" onclick="go_on_page();">
        <script>

         								function go_on_page(){
        
         		var pageno= document.getElementById("pageNo").value;
         		var total_page='<?php echo $total_page ;?>';
         		if(pageno >total_page){
         			alert('Please Enter Page No. Less Than Total No. of Pages');
         			return false;
         		}else{
         	//	alert(pageno);
         		var pageno1=pageno-2;
         		var campaign_name= '<?php echo $campaign_name ;?>';
         		//alert (campaign_name);
         		var nextaction='<?php echo $nextaction; ?>';
         		var feedback='<?php echo $feedback; ?>';
         		var fromdate='<?php echo $fromdate; ?>';
         		var todate='<?php echo $todate; ?>';
         		var date_type='<?php echo $date_type; ?>';
         		
         		window.location="<?php echo site_url(); ?>new_tracker/leads/page/"+pageno1+"?campaign_name="+campaign_name+"&nextaction="+nextaction+"&feedback="+feedback+"&fromdate="+fromdate+"&todate="+todate+"&date_type="+date_type;
         	}
         	
         	}
         </script>
        -->
        </div>
        
        </div>
        </div>		
      
