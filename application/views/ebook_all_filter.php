<script>
	
	$(document).ready(function() {
		
		
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
	
});	
</script>	<?php
	$page = $this -> uri -> segment(4);
	if (isset($page)) {
		$page = $page + 1;
	
	} else {
		$page = 0;
	
	}
	$offset1 = 100 * $page;
	//$query=$sql->result();
	$c = count($select_lead);
	//echo $c;
	$today = date('d-m-Y');	
?>
<div class="control-group" id="blah" style="margin:0% 30% 1% 50%"></div>
		<div class="panel-body">
					
					<br><br>	
					<div id='searchdiv'  style='overflow-x;scroll'>
						<div class="table-responsive" >	
							<table id="example"  class="table " style="width: 100%" > 		
								<thead>
									<tr>
										<!-- Show Select box if add followup or remark right 1 -->										
										<th>Sr</th>
											<th>Name</th>					
										<th>Contact</th>
										<th>Email ID</th>
										
										
										     <th>Registration No</th>
										      
										<th>Amount</th>
										<th>Payment Date</th>
										<th>Payment Id</th>
											<th>Order Id</th>
										<th>Payment Status</th>
											<th>Paid Status</th>
										<th>Payment Link</th>
															
								</tr>
							</thead>
							<tbody>
								<?php
									$i=$offset1;				
									if (!empty($select_lead)) 
									{
										foreach($select_lead as $fetch)
										{						
										 	
											$i++;
											?>
											<tr id='t<?php echo $i; ?>'>
											<input type="hidden" value="<?php echo count($select_lead); ?>" id="lead_count">
										
											<td><?php echo $i; ?></td>
										
											<td><b>
												
											
												<?php echo $fetch -> name;
															
													?>
												</a></b>
											</td>
											<td><?php echo $fetch -> contact_no; ?></td>
											<td><?php echo $fetch -> email; ?></td>
										    
										
										     <td><?php echo $fetch -> customer_reg_no; ?></td>
										      
										     <td><?php echo $fetch -> amount; ?></td>
											<td><?php echo $fetch -> created_date.' '. $fetch -> created_time; ?></td>
											<td><?php echo $fetch -> razorpay_payment_id; ?></td>
											<td><?php echo $fetch -> razorpay_order_id; ?></td>
											<td><?php echo $fetch -> payment_status; ?></td>
												<td><?php if($fetch -> status=='captured'){ echo "Paid";} ?></td>
										<td>https://marutiinsurance.autovista.in/payment-link/pay-now/<?php echo $fetch -> customer_id; ?></td>
								
								
								
								
							</tr>
							<?php } }?>
						</tbody>
					</table>
				</div>
		
	<div class="col-md-12" style="margin-top: 20px;">
<div class="col-md-6" style="font-size: 14px">

   <?php


	$url='ebook_leads/payment_all_leads/';
	$total_record=count($select_lead_count);

	

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

		</div>
	</div>    
        
        

        </div>