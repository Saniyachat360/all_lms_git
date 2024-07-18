<?php if($campaign_name=='campaign')
{?>
<div class="control-group" id="campaign_loader" style="margin:0% 30% 1% 50%"></div>
<?php }else{?>
<div class="control-group" id="blah1" style="margin:0% 30% 1% 50%"></div>
<?php } ?>
<table id="cse_count" class="table table-striped table-bordered table-responsive">
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
			<td>Today Followup</td>
			<td>Total Leads</td>                                         
		</tr>
        <tr>
			<td>MTD</td>
			<td><?php 
								$t = ' ( ';
								$i=0;
								foreach($campaign_new as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								 $campaign_new_lead2=count($campaign_new);
								 if($campaign_new_lead2!=0)
								 {?>
								 	<input type="hidden" id="cse_new_lead2" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('cse_new_lead2');">
								<?php }
				echo $campaign_new_lead2;?>
			</td>
			<td><?php 
								$t = ' ( ';
								$i=0;
								foreach($campaign_m_live as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								$campaign_m_live1=count($campaign_m_live);
								 if($campaign_m_live1!=0)
								 {?>
								 	<input type="hidden" id="cse_m_live" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('cse_m_live');">
								<?php } 
					
				echo $campaign_m_live1;?>
			</td>
			<td><?php 
								$t = ' ( ';
								$i=0;
								foreach($campaign_m_postponed as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								$campaign_m_postponed1=count($campaign_m_postponed);
								 if($campaign_m_postponed1!=0)
								  {?>
								 <input type="hidden" id="cse_m_postponed" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('cse_m_postponed1');">
								<?php } 
					
					echo $campaign_m_postponed1;?>
			</td>
							<td>
							<?php 
								$t = ' ( ';
								$i=0;
								foreach($campaign_m_lost as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
							
								foreach($campaign_m_lost_lc as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								$campaign_m_lost1 = count($campaign_m_lost);
								$campaign_m_lost1 = $campaign_m_lost1 + count($campaign_m_lost_lc);
								 if($campaign_m_lost1!=0)
								  {?>
								 <input type="hidden" id="cse_m_lost" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('cse_m_lost');">
								<?php } 
									
									
							echo $campaign_m_lost1;
									 ?></td>
								<td>
								<?php 
								$t = ' ( ';
								$i=0;
								foreach($campaign_m_convert as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								
								foreach($campaign_m_convert_lc as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								$campaign_m_convert1 = count($campaign_m_convert);
								$campaign_m_convert1 = $campaign_m_convert1 + count($campaign_m_convert_lc);
								 if($campaign_m_convert1!=0)
								  {?>
								 <input type="hidden" id="cse_m_convert" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('cse_m_convert');">
								<?php } 
										
								echo $campaign_m_convert1;
									 ?>
							</td>
							<td><?php 
								$t = ' ( ';
								$i=0;
								foreach($campaign_pending as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								$campaign_pending_lead1=count($campaign_pending);
								 if($campaign_pending_lead1!=0)
								  {?>
								 <input type="hidden" id="cse_pending_lead1" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('cse_pending_lead1');">
								<?php } 
								echo $campaign_pending_lead1;
						 ?></td>
						  <td>
						 	<?php 
								$t = ' ( ';
								$i=0;
								foreach($campaign_not_attended_pending_y as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								$campaign_pending_lead=count($campaign_not_attended_pending_y);
								 if($campaign_pending_lead!=0)
								  {?>
								 <input type="hidden" id="cse_pending_lead" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('cse_pending_lead');">
								<?php } 
							
							echo $campaign_pending_lead;
						  ?></td>
						 <td>
						  	
						  	<?php 
								$t = ' ( ';
								$i=0;
								foreach($campaign_today_followup as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								$campaign_today_followup1=count($campaign_today_followup);
								 if($campaign_today_followup1!=0)
								  {?>
								 <input type="hidden" id="cse_pending_lead" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('campaign_today_followup');">
								<?php } 
							echo $campaign_today_followup1;
						  ?>
						  	
						  	
						  </td>
							<td>
								<?php 
								$t = ' ( ';
								$i=0;
								foreach($campaign_new as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($campaign_m_live as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($campaign_m_lost as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($campaign_m_postponed as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($campaign_m_convert as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($campaign_m_lost_lc as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($campaign_m_convert_lc as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($campaign_not_attended_pending as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								
								
								$st = $t . ')';	 ?>
								<input type="hidden" id="total_m_cse" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('total_m_cse');">
								<?php
								echo $total = $campaign_new_lead2 + $campaign_m_live1 + $campaign_m_postponed1 + $campaign_m_lost1 + $campaign_m_convert1 +$campaign_pending_lead;
 ?>
								
							 </td>
							
							
                             </tr>
                             
                        <tr>
						 <td>YTD</td>
						 <td>	<?php 
								$t = ' ( ';
								$i=0;
								foreach($campaign_new as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								$campaign_new_lead = count($campaign_new);
								 if($campaign_new_lead!=0)
								  {?>
								 <input type="hidden" id="cse_new_lead" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('cse_new_lead');">
								<?php } 
								echo $campaign_new_lead ;
							
						?></td>
						<td><?php 
								$t = ' ( ';
								$i=0;
								foreach($campaign_y_live as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								$campaign_y_live1=count($campaign_y_live);
								 if($campaign_y_live1!=0)
								  {?>
								 <input type="hidden" id="cse_y_live" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('cse_y_live');">
								<?php } 
							echo $campaign_y_live1;
								?>
							</td>
							<td>
							<?php 
								$t = ' ( ';
								$i=0;
								foreach($campaign_y_postponed as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								$campaign_y_postponed1=count($campaign_y_postponed);
								 if($campaign_y_postponed1!=0)
								  {?>
								 <input type="hidden" id="cse_y_postponed" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('cse_y_postponed');">
								<?php } 
							
							echo $campaign_y_postponed1;
	 ?>
							</td>
							<td>
							<?php 
								$t = ' ( ';
								$i=0;
								foreach($campaign_y_lost as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$i=0;
								foreach($campaign_y_lost_lc as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								$campaign_y_lost1 = count($campaign_y_lost);
								$campaign_y_lost1 = $campaign_y_lost1 + count($campaign_y_lost_lc);
							
								 if($campaign_y_lost1!=0)
								  {?>
								 <input type="hidden" id="cse_y_lost" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('cse_y_lost');">
								<?php } 
									
							echo $campaign_y_lost1;
									 ?></td>
								<td>
								<?php 
								$t = ' ( ';
								$i=0;
								foreach($campaign_y_convert as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$i=0;
								foreach($campaign_y_convert_lc as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								$campaign_y_convert1 = count($campaign_y_convert);
								$campaign_y_convert1 = $campaign_y_convert1 +count($campaign_y_convert_lc);
							
								 if($campaign_y_convert1!=0)
								  {?>
								 <input type="hidden" id="cse_y_convert" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('cse_y_convert');">
								<?php } 
									
									
								echo $campaign_y_convert1;
									 ?>
							</td>
							<td><?php 
								$t = ' ( ';
								$i=0;
								foreach($campaign_pending_y as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								$campaign_pending_lead1=count($campaign_pending_y);
								 if($campaign_pending_lead1!=0)
								  {?>
								 <input type="hidden" id="cse_pending_lead1" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('cse_pending_lead1');">
								<?php } 
							
								echo $campaign_pending_lead1;
						 ?></td>
						 <td>
						 	<?php 
								$t = ' ( ';
								$i=0;
								foreach($campaign_not_attended_pending_y as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								$campaign_pending_lead=count($campaign_not_attended_pending_y);
								 if($campaign_pending_lead!=0)
								  {?>
								 <input type="hidden" id="cse_pending_lead" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('cse_pending_lead');">
								<?php } 
							
							echo $campaign_pending_lead;
						  ?></td>
						   <td>
						  	
						  	<?php 
								$t = ' ( ';
								$i=0;
								foreach($campaign_today_followup as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	 
								$campaign_today_followup=count($campaign_today_followup);
								 if($campaign_today_followup!=0)
								  {?>
								 <input type="hidden" id="cse_pending_lead" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('campaign_today_followup');">
								<?php } 
							echo $campaign_today_followup;
						  ?>
						  	
						  	
						  </td>
							<td>
								<?php 
								$t = ' ( ';
								$i=0;
								foreach($campaign_new as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($campaign_y_live as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($campaign_y_lost as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($campaign_y_postponed as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($campaign_y_convert as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($campaign_y_lost_lc as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($campaign_y_convert_lc as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								foreach($campaign_not_attended_pending_y as $row){
								if ($i == 0) {
								$t = $t . "enq_id = '" . $row -> enq_id . "'";
								} else {
								$t = $t . " or enq_id ='" . $row -> enq_id . "'";
								}
								$i++;
								}
								$st = $t . ')';	?>
								 <input type="hidden" id="total_y_cse" value="<?php echo $st; ?>">
							<a href="#" onclick= "test('total_y_cse');">
								<?php
								echo $total = $campaign_new_lead + $campaign_y_live1 + $campaign_y_postponed1 + $campaign_y_lost1 + $campaign_y_convert1 + $campaign_pending_lead;
 ?>
								
							 </td>
							
							
                             </tr>
                         </tbody>
                    </table>
