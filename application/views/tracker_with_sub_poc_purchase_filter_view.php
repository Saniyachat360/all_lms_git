
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
<script><?php
$page = $this -> uri -> segment(4);
if (isset($page)) {
	$page = $page + 1;

} else {
	$page = 0;

}
$offset1 = 100 * $page;
//$query=$sql->result();
echo $c = count($select_lead);
		?></script>
			<div class="col-md-12" >
<div class="control-group" id="blah" style="margin:0% 30% 1% 50%">
				
				</div>
		<div class="table-responsive" >
	
			<table id="example"  class="table " style="width:auto;" cellspacing="0"> 
		
		
		
				<thead>
						<tr>
							<tr>
							
							<th>Sr No.</th>
							<th>Lead Source</th>
							<th>Sub Lead Source</th>
							<th>Customer Name</th>
							<th>Mobile Number</th>
							<th>Alternate Mobile Number</th>
							<th>Address</th>
							<th>Email ID</th>
							<th>Lead Date</th>
							<th>Lead Time</th>
							<th>Booking within Days</th>
							<th>Customer Location</th>
							<th>Lead Assigned Date(CSE)</th>
							<th>Lead Assigned Time(CSE)</th>
							<th>CSE Name</th>
							<th>CSE Call Date</th>
							<th>CSE Call Time</th>
							<th>CSE Call Status</th>
							<th>CSE Feedback</th>
							<th>CSE Next Action</th>
							<th>CSE Remark</th>
							<th>CSE NFD</th>
							<th>CSE NFT</th>
							<th>Overdue</th>
							<th>Appointment Type</th>
							<th>Appointment Date</th>
							<th>Appointment Time</th>
							<th>Appointment Status</th>
							<th>Showroom Location</th>
							<th>Team Lead Name</th>
							<th>Evaluator Name</th>
							<th>Lead Assigned Date(Evaluator)</th>
							<th>Lead Assigned Time(Evaluator)</th>
							<th>Evaluator Call Date</th>
							<th>Evaluator Call Time</th>
							<th>Evaluator Call Status</th>
							<th>Evaluator Feedback</th>
							<th>Evaluator Next Action</th>
							<th>Evaluator Remark</th>
							<th>Evaluator NFD</th>
							<th>Evaluator NFT</th>
							<th>Overdue</th>
							<th>Evaluation No</th>
							<th>Outright/Exchange</th>
							<th>Vehicle Sale Category Customer\Dealer</th>
							<th>Exchange Make</th>
							<th>Exchange Model</th>
							<th>Sub Model</th>
							<th>Manufacturing Year</th>
							<th>Fuel Type</th>
							<th>Color</th>
							<th>Registration No</th>
							<th>Year of Regn</th>
							<th>KM</th>
							<th>Ownership</th>
							<th>Old Car Owner Name</th>
							<th>HP</th>
							<th>Finacier Name</th>
							<th>Insurance Type</th>
							<th>Insurance Co Name</th>
							<th>Insurance Validity date</th>
							<th>Photo Uploaded</th>
							<th>Type of Vehicle - Pvt\T permit</th>
							<th>Vehicle Accidental</th>
							<th>Accidental Details</th>
							<th>Tyre conditon</th>
							<th>Engine work</th>
							<th>body work</th>
							<th>Battery</th>
							<th>Mechanical</th>
							<th>Tyre</th>
							<th>Other</th>
							<th>Price Offered</th>
							<th>Customer Expectation</th>
							<th>Difference</th>
							<th>Refurbish cost Bodyshop</th>	
							<th>Price With RF & commission</th>		
							<th>Agent Commission Payable</th>	
							<th>Total RF</th>
							<th>Expected Selling Price</th>
							<th>Expected Date of Sale</th>
							<th>Bought at Price</th>							
							<th>Bought Date</th>
							<th>Payment date</th>
							<th>Payment mode</th>
							<th>Payment Made to</th>
							
							
							
							
							
						</tr>	
						
					</thead>
					<tbody>
					
			<?php
				$i=$offset1;
				
				if (!empty($select_lead)) 
				{
					foreach($select_lead as $fetch)
					{
						$enq_id=$fetch->enq_id;
						$i++; ?>
						
						
						<tr>
						<td><?php echo $i; ?></td>
						<td><?php
							if ($fetch -> lead_source == '') 
							{
								echo "Web  ";
							} 
							else 
							{
								echo $fetch -> lead_source;
							}
						?></td>
						<td><?php echo $fetch -> enquiry_for?></td>
						<td><?php echo $fetch -> name?></td>
						<td><?php echo $fetch -> contact_no?></td>
						<td><?php echo $fetch -> alternate_contact_no?></td>
						<td><?php echo $fetch -> address?></td>
						<td><?php echo $fetch -> email?></td>
						<td><?php echo $fetch -> lead_date?></td>
						<td><?php echo $fetch -> lead_time?></td>
						<td><?php echo $fetch -> days60_booking?></td>
						<td><?php echo $fetch -> customer_location?></td>
						<td><?php echo $fetch -> assign_to_cse_date?></td>
						<td><?php echo $fetch -> assign_to_cse_time?></td>
						<?php if($fetch->assign_to_cse == 0){?>
					
					<td><?php echo $fetch -> csetl_fname . ' ' . $fetch -> csetl_lname; ?></td>
					
					<?php }else{ ?>
						<td><?php echo $fetch -> cse_fname . ' ' . $fetch -> cse_lname; ?></td>
						<?php } ?>
						<td><?php echo $fetch -> cse_date?></td>
						<td><?php echo $fetch -> cse_time?></td>
						<td><?php echo $fetch -> csecontactibility?></td>
						<td><?php echo $fetch -> csefeedback?></td>
						<td><?php echo $fetch -> csenextAction?></td>
						<td><?php echo $fetch -> cse_comment?></td>
						<td><?php echo $fetch -> cse_nfd?></td>
						<td><?php echo $fetch -> cse_nftime?></td>
						<td><?php 
					$nfd=$fetch -> cse_nfd;
					if($nfd !='' && $nfd !='0000-00-00'){
					$today=strtotime(date('Y-m-d'));
							$nfd=strtotime($fetch -> cse_nfd);
							 $overdue=$today-$nfd; 
							 echo ($overdue)/60/60/24 ;
							 } ?></td>	
						<td><?php echo $fetch -> appointment_type?></td>
						<td><?php echo $fetch -> appointment_date?></td>
						<td><?php echo $fetch -> appointment_time?></td>
						<td><?php echo $fetch -> appointment_status?></td>
						<td><?php echo $fetch -> showroom_location?></td>
						<td><?php echo $fetch -> tlfname ." ". $fetch -> tllname?></td>
						<td><?php echo $fetch -> fname ." ". $fetch -> lname?></td>
						<td><?php echo $fetch -> assign_to_e_exe_date?></td>
						<td><?php echo $fetch -> assign_to_e_exe_time?></td>
						<td><?php echo $fetch -> evaluator_date?></td>
						<td><?php echo $fetch -> evaluator_time?></td>
						<td><?php echo $fetch -> evaluatorcontactibility?></td>
						<td><?php echo $fetch -> evaluatorfeedback?></td>
						<td><?php echo $fetch -> evaluatornextAction?></td>
						<td><?php echo $fetch -> evaluator_comment?></td>
						<td><?php echo $fetch -> evaluator_nfd?></td>
						<td><?php echo $fetch -> evaluator_nftime?></td>
						<td><?php 
					$nfd=$fetch -> evaluator_nfd;
					if($nfd !='' && $nfd !='0000-00-00'){
					$today=strtotime(date('Y-m-d'));
							$nfd=strtotime($fetch -> evaluator_nfd);
							 $overdue=$today-$nfd; 
							 echo ($overdue)/60/60/24 ;
							 } ?></td>	
						<td><?php echo $fetch -> enq_id?></td>
						<td><?php echo $fetch -> outright?></td>
						<td><?php echo $fetch -> vechicle_sale_category?></td>	
						<td><?php echo $fetch -> make_name?></td>
						<td><?php echo $fetch -> model_name?></td>		
						<td><?php echo $fetch -> variant_name?></td>
						<td><?php echo $fetch -> manf_year ?></td>
						<td><?php echo $fetch -> fuel_type?></td>
						<td><?php echo $fetch -> color?></td>
						<td><?php echo $fetch -> reg_no?></td>
						<td><?php echo $fetch -> reg_year ?></td>
						<td><?php echo $fetch -> km?></td>
						<td><?php echo $fetch -> ownership?></td>
						<td><?php echo $fetch -> old_car_owner_name?></td>
						<td><?php echo $fetch -> hp ?></td>
						<td><?php echo $fetch -> financier_name?></td>
						<td><?php echo $fetch -> insurance_type?></td>
						<td><?php echo $fetch -> insurance_company?>
						<td><?php echo $fetch -> insurance_validity_date?>
						<td><?php echo $fetch -> photo_uploaded?></td>
						<td><?php echo $fetch -> type_of_vehicle ?></td>
						<td><?php echo $fetch -> accidental_details?></td>
						<td><?php echo $fetch -> accidental_details?></td>
						<td><?php echo $fetch -> tyre_conditon?></td>					
						<td><?php echo $fetch -> engine_work?></td>
						<td><?php echo $fetch -> body_work?></td>
						<td><?php echo $fetch -> refurbish_cost_battery?></td>
						<td><?php echo $fetch -> refurbish_cost_mecahanical?></td>
						<td><?php echo $fetch -> refurbish_cost_tyre?></td>
						<td><?php echo $fetch -> refurbish_other?></td>
						<td><?php echo $fetch -> quotated_price?></td>
						<td><?php echo $fetch -> expected_price?></td>
						<td><?php echo $fetch -> expected_price - $fetch -> quotated_price?></td>
						<td><?php echo $fetch -> refurbish_cost_bodyshop?></td>
						<td><?php echo $fetch -> price_with_rf_and_commission?></td>
						<td><?php echo $fetch -> agent_commision_payable?></td>
						<td><?php echo $fetch -> total_rf?></td>
						<td><?php echo $fetch -> selling_price?></td>
						<td><?php echo $fetch -> expected_date_of_sale?></td>
						<td><?php echo $fetch -> bought_at?></td>
						<td><?php echo $fetch -> bought_date?></td>
						<td><?php echo $fetch -> payment_date?></td>
						<td><?php echo $fetch -> payment_mode?></td>
						<td><?php echo $fetch -> payment_made_to?></td>
						
						

						
					</tr>	
					<?php } } ?>
				
					</tbody>
					</table>

		<!--</div>
-->	
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
echo '<b>'. $total_record.'</b>';?>&nbsp;&nbsp;
<?php echo 'Total Pages :';$pages = $total_record / 100;
	echo '<b>' . $total_page = ceil($pages) . '</b>';
 ?>
 </div>
<div class="col-md-6  form-group">
<?php
	$campaign_name = str_replace('#', '%23', $campaign_name);
	$campaign_name = str_replace(' ', '+', $campaign_name);

	if ($c < 100) {
		$last = $page - 2;
		if ($last != -2) {
echo "<a class='col-md-push-1 col-md-2 btn btn-info'  href=" . site_url() . 'new_tracker/tracker_dse_filter/page/'.$last .'?campaign_name='.$campaign_name.'&nextaction='.$nextaction.'&feedback='.$feedback.'&fromdate='.$fromdate .'&todate='.$todate .'&date_type='.$date_type .">
<i class='fa fa-angle-left'></i>Previous</a>";
			echo "<a class='col-md-pull-3 col-md-1  btn btn-info'  href=" . site_url() . 'new_tracker/tracker_dse_filter?campaign_name=' . $campaign_name . '&nextaction=' . $nextaction . '&feedback=' . $feedback . '&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">First  
<i class='fa fa-angle-right'></i></a>";
			$last1 = $total_page - 2;
			echo "<a class=' col-md-push-5 col-md-1  btn btn-info' href=" . site_url() . 'new_tracker/tracker_dse_filter/page/' . $last1 . '?campaign_name=' . $campaign_name . '&nextaction=' . $nextaction . '&feedback=' . $feedback . '&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">Last  
<i class='fa fa-angle-right'></i></a>";
		}
	} else if ($page == 0) {

		echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px;' href=" . site_url() . 'new_tracker/tracker_dse_filter/page/' . $page . '?campaign_name=' . $campaign_name . '&nextaction=' . $nextaction . '&feedback=' . $feedback . '&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">Next  
<i class='fa fa-angle-right'></i></a>";
		echo "<a class=' col-md-1  btn btn-info'  href=" . site_url() . "new_tracker/leads>First  
<i class='fa fa-angle-right'></i></a>";
		$last1 = $total_page - 2;
		echo "<a class=' col-md-push-6 col-md-1  btn btn-info' href=" . site_url() . 'new_tracker/tracker_dse_filter/page/' . $last1 . '?campaign_name=' . $campaign_name . '&nextaction=' . $nextaction . '&feedback=' . $feedback . '&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">Last  
<i class='fa fa-angle-right'></i></a>";
	} else {

		$last = $page - 2;
		echo " <a class='col-md-push-2 col-md-2 btn btn-info'  href=" . site_url() . 'new_tracker/tracker_dse_filter/page/' . $last . '?campaign_name=' . $campaign_name . '&nextaction=' . $nextaction . '&feedback=' . $feedback . '&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">
<i class='fa fa-angle-left'></i>   Previous   </a> ";
		echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px ;' href=" . site_url() . 'new_tracker/tracker_dse_filter/page/' . $page . '?campaign_name=' . $campaign_name . '&nextaction=' . $nextaction . '&feedback=' . $feedback . '&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">Next  
<i class='fa fa-angle-right'></i></a>";

		echo "<a class='col-md-pull-3 col-md-1  btn btn-info' href=" . site_url() . 'new_tracker/tracker_dse_filter?campaign_name=' . $campaign_name . '&nextaction=' . $nextaction . '&feedback=' . $feedback . '&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">First  
<i class='fa fa-angle-right'></i></a>";
		$last1 = $total_page - 2;
		echo "<a class='  col-md-push-6 col-md-1  btn btn-info'  href=" . site_url() . 'new_tracker/tracker_dse_filter/page/' . $last1 . '?campaign_name=' . $campaign_name . '&nextaction=' . $nextaction . '&feedback=' . $feedback . '&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">Last  
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
         		var total_page='<?php echo $total_page; ?>';
				if(pageno >total_page){
				alert('Please Enter Page No. Less Than Total No. of Pages');
				return false;
				}else{
					//	alert(pageno);
				var pageno1=pageno-2;
				var campaign_name= '<?php echo $campaign_name; ?>';
					//alert (campaign_name);
				var nextaction='<?php echo $nextaction; ?>';
				var feedback='<?php echo $feedback; ?>';
				var fromdate='<?php echo $fromdate; ?>';
				var todate='<?php echo $todate; ?>';
				var date_type='<?php echo $date_type; ?>';
				
				window.location="<?php echo site_url(); ?>new_tracker/tracker_dse_filter/page/"+pageno1+"?campaign_name="+campaign_name+"&nextaction="+nextaction+"&feedback="+feedback+"&fromdate="+fromdate+"&todate="+todate+"&date_type="+date_type;

					}
					}
         </script>
         
        </div>
        