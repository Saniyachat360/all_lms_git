
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
							<th>Assistance Required </th>
							<th>Booking within Days</th>
							<th>Customer Location</th>
							
							
								
							
						
							
          					
          					
          
							
								
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
					if ($fetch -> lead_source == '') {
							 echo "Web  ";
							 //.$fetch->enquiry_for;
						} 
					/*	else if($fetch->lead_source=='Facebook')
						{
							echo $fetch->enquiry_for;
						}*/
						 else { echo $fetch -> lead_source;
						}
 ?></td>
 <td><?php echo $fetch -> enquiry_for; ?></td>
 <td><b><?php echo $fetch -> name; ?></b></td>
                    <td><?php echo $fetch -> contact_no; ?></td>
                    <td><?php echo $fetch -> alternate_contact_no; ?></td>
                    <td><?php echo $fetch -> address; ?></td>
                    <td><?php echo $fetch -> email; ?></td>
                    <td><?php echo $fetch -> lead_date; ?></td>
                    <td><?php echo $fetch -> lead_time; ?></td>
					<td><?php echo $fetch -> assistance; ?></td>
 					<td><?php echo $fetch -> days60_booking; ?></td>
 					<td><?php echo $fetch -> customer_location; ?></td>
					
                    
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
echo '<b>'. $total_record;
echo'</b>';?>&nbsp;&nbsp;
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
echo "<a class='col-md-push-1 col-md-2 btn btn-info'  href=" . site_url() . 'duplicate_lead_tracker/tracker_dse_filter/page/'.$last .'?campaign_name='.$campaign_name.'&fromdate='.$fromdate .'&todate='.$todate .'&date_type='.$date_type .">
<i class='fa fa-angle-left'></i>Previous</a>";
			echo "<a class='col-md-pull-3 col-md-1  btn btn-info'  href=" . site_url() . 'duplicate_lead_tracker/tracker_dse_filter?campaign_name=' . $campaign_name .'&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">First  
<i class='fa fa-angle-right'></i></a>";
			$last1 = $total_page - 2;
			echo "<a class=' col-md-push-5 col-md-1  btn btn-info' href=" . site_url() . 'duplicate_lead_tracker/tracker_dse_filter/page/' . $last1 . '?campaign_name=' . $campaign_name .'&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">Last  
<i class='fa fa-angle-right'></i></a>";
		}
	} else if ($page == 0) {

		echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px;' href=" . site_url() . 'duplicate_lead_tracker/tracker_dse_filter/page/' . $page . '?campaign_name=' . $campaign_name .'&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">Next  
<i class='fa fa-angle-right'></i></a>";
		echo "<a class=' col-md-1  btn btn-info'  href=" . site_url() . "new_tracker/leads>First  
<i class='fa fa-angle-right'></i></a>";
		$last1 = $total_page - 2;
		echo "<a class=' col-md-push-6 col-md-1  btn btn-info' href=" . site_url() . 'duplicate_lead_tracker/tracker_dse_filter/page/' . $last1 . '?campaign_name=' . $campaign_name .'&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">Last  
<i class='fa fa-angle-right'></i></a>";
	} else {

		$last = $page - 2;
		echo " <a class='col-md-push-2 col-md-2 btn btn-info'  href=" . site_url() . 'duplicate_lead_tracker/tracker_dse_filter/page/' . $last . '?campaign_name=' . $campaign_name .'&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">
<i class='fa fa-angle-left'></i>   Previous   </a> ";
		echo "<a class='col-md-push-7  col-md-1 btn btn-info' style='margin-right:20px ;' href=" . site_url() . 'duplicate_lead_tracker/tracker_dse_filter/page/' . $page . '?campaign_name=' . $campaign_name  . '&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">Next  
<i class='fa fa-angle-right'></i></a>";

		echo "<a class='col-md-pull-3 col-md-1  btn btn-info' href=" . site_url() . 'duplicate_lead_tracker/tracker_dse_filter?campaign_name=' . $campaign_name . '&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">First  
<i class='fa fa-angle-right'></i></a>";
		$last1 = $total_page - 2;
		echo "<a class='  col-md-push-6 col-md-1  btn btn-info'  href=" . site_url() . 'duplicate_lead_tracker/tracker_dse_filter/page/' . $last1 . '?campaign_name=' . $campaign_name . '&fromdate=' . $fromdate . '&todate=' . $todate . '&date_type=' . $date_type . ">Last  
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
         		//alert(pageno);
         		var total_page='<?php echo $total_page; ?>';
         		//alert(total_page);
				if(pageno >total_page){
				alert('Please Enter Page No. Less Than Total No. of Pages');
				return false;
				}else{
					//	alert(pageno);
				var pageno1=pageno-2;
				var campaign_name= '<?php echo $campaign_name; ?>';
					//alert (campaign_name);
				
			
				var fromdate='<?php echo $fromdate; ?>';
				var todate='<?php echo $todate; ?>';
				var date_type='<?php echo $date_type; ?>';
				
				window.location="<?php echo site_url(); ?>duplicate_lead_tracker/tracker_dse_filter/page/"+pageno1+"?campaign_name="+campaign_name+"&fromdate="+fromdate+"&todate="+todate+"&date_type="+date_type;

					}
					}
         </script>
         
        </div>
        