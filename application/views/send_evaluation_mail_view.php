<!DOCTYPE html>
<html><body>

	<style> 
	td{
		padding:8px;
		 border: 1px solid #ddd;
	}
	
	</style>
	<table >
	<caption style="font-size:18px;font-weight:bold;padding-bottom: 20px;">Escalation Details </caption>
	<?php if(isset($query[0]->esc_level1_remark)){
		if($query[0]->esc_level1_remark!=''){?>
		<tr>
		<td>Escalation Type</td>
		<td>Escalation Remark</td>
			</tr>
<tr>
		<td>Escalation Level 1</td>
		<td><?php echo $query[0]->esc_level1_remark;  ?></td>
			</tr>
	<?php } } ?>
	<?php if(isset($query[0]->esc_level2_remark)){
		if($query[0]->esc_level2_remark!=''){?>
			<tr>
		<td>Escalation Level 2</td>
		<td><?php if(isset($query[0]->esc_level2_remark)){echo $query[0]->esc_level2_remark;} ?></td>
			</tr>
	<?php } } ?>
	<?php if(isset($query[0]->esc_level3_remark)){
		if($query[0]->esc_level3_remark!=''){?>
			<tr>
		<td>Escalation Level 3</td>
		<td><?php if(isset($query[0]->esc_level3_remark)){echo $query[0]->esc_level3_remark;} ?></td>
			</tr>
	<?php } } ?>
		</table>
		
 <table  style="margin-top:20px">
 <caption style="font-size:18px;font-weight:bold;padding-bottom: 20px;">Customer Details</caption>
<tr>
		<td>Customer Name </td>
		<td><?php if(isset($query[0]->name)){echo $query[0]->name;} ?></td>
			</tr>
			 <tr>
		<td>Contact No </td>
		<td><?php if(isset($query[0]->contact_no)){echo $query[0]->contact_no;} ?></td>
			</tr>
 	 <tr>
		<td>CSE TL Name </td>
		<td><?php if(isset($query[0]->csetl_fname)){ echo $query[0]->csetl_fname.' '.$query[0]->csetl_lname; } ?></td>
			</tr>
			 <tr>
		<td>CSE Name </td>
		<td><?php if(isset($query[0]->cse_fname)){ echo $query[0]->cse_fname.' '.$query[0]->cse_lname; } ?></td>
			</tr>
		 <tr>
		<td>CSE Remark </td>
		<td><?php  if(isset($query[0]->cse_remark)){ echo $query[0]->cse_remark; } ?></td>
			</tr>
		<tr>
		<td>Showroom Location</td>
		<td><?php if(isset($query[0]->location)){ echo $query[0]->location; } ?></td>
		</tr>
			 <tr>
		<td>DSE TL Name </td>
		<td><?php  if(isset($query[0]->dsetl_fname)){ echo $query[0]->dsetl_fname.' '.$query[0]->dsetl_lname; } ?></td>
			</tr>
			 <tr>
		<td>DSE  Name </td>
		<td><?php  if(isset($query[0]->dsetl_fname)){ echo $query[0]->dse_fname.' '.$query[0]->dse_lname; } ?></td>
			</tr>
			 <td>DSE Remark </td>
		<td><?php if(isset($query[0]->dse_remark)){ echo $query[0]->dse_remark; } ?></td>
			</tr>
	
			</table>
			</body></html>
			