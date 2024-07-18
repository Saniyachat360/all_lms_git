<input type="hidden" value="<?php echo $username ; ?>" name="username" id="username" />

<div class="table-responsive">
							<table class="table table-bordered datatable"> 
							<thead>
							<tr>
							<th>Sr No.</th>
							<th>Module</th>
							<th>View  <input type="checkbox" name="view" class="pull-right" value="1" id="select_all" onclick="select_checkbox()"></th>
							<th>Insert<input type="checkbox" name="view" class="pull-right" value="1" id="select_all1" onclick="select_checkbox1()"></th>
							<th>Modify <input type="checkbox" name="view" class="pull-right" value="1" id="select_all2" onclick="select_checkbox2()"></th>
							<th>Delete<input type="checkbox" name="view" class="pull-right" value="1" id="select_all3" onclick="select_checkbox3()"></th>
							</tr>	
						</thead>
						<tbody>
							<?php
							// 	
							
							foreach ($select_right_data as $fetch) {
								$view[] = $fetch -> view;
								$insert[] = $fetch -> insert;
								$modify[] = $fetch -> modify;
								$delete[] = $fetch -> delete;
							}
							if(count($select_right_fin)>0)
							{
							   $c=1;
							   	foreach ($select_right_fin as $fetch1) {
								$fview[] = $fetch1 -> view;
								$finsert[] = $fetch1 -> insert;
								$fmodify[] = $fetch1 -> modify;
								$fdelete[] = $fetch1 -> delete;
							}
							   
							}
							else
							{
							    $c=0;
							}
						?>
							<input type="hidden" name="user_name"   value="<?php echo $select_right_data[0] -> id; ?> ">
						
						
						
							
					
							
						<tr>
							<td>1</td>
							<td><b>Master</b>
							</td>
							<td colspan='4'>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>1. Location 
							<input type="hidden" name="form_location"   value="Add Location">
							<input type="hidden" name="controller_location"   value="add_location">
							</td>
							<td><input type="checkbox" class="checkbox pull-right" name="add_location_view" value="1" <?php if(isset($view[0])){ if($view[0] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="add_location_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="add_location_insert" value="1" <?php  if(isset($insert[0])){ if($insert[0] =='1') {?>checked=checked <?php }}?>>
								<input type="hidden" name="add_location_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="add_location_modify" value="1" <?php if(isset($modify[0])){ if($modify[0] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="add_location_modify1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="add_location_delete" value="1" <?php if(isset($delete[0])){ if($delete[0] =='1') {?>checked=checked <?php } }?>>
								<input type="hidden" name="add_location_delete1"   value="0">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>2. Map Process to Location 
								<input type="hidden" name="form_map_process"   value="Map process to location">
							<input type="hidden" name="controller_map_process"   value="Link_process_location">
							</td>
							<td><input type="checkbox" class="checkbox pull-right" name="map_process_view" value="1" <?php if(isset($view[3])){ if($view[3] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="map_process_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="map_process_insert" value="1" <?php if(isset($insert[3])){ if($insert[3] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox1" name="map_process_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="map_process_modify" value="1" <?php if(isset($modify[3])){ if($modify[3] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox2" name="map_process_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="map_process_delete" value="1" <?php if(isset($delete[3])){ if($delete[3] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox3" name="map_process_delete1" value="0">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>3. Add User 
								<input type="hidden" name="form_user"   value="Add User">
							<input type="hidden" name="controller_user"   value="add_lms_user">
							</td>
							<td><input type="checkbox" class="checkbox pull-right" name="add_new_user_view" value="1" <?php if(isset($view[2])){ if($view[2] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="add_new_user_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="add_new_user_insert" value="1" <?php if(isset($insert[2])){ if($insert[2] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox1" name="add_new_user_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="add_new_user_modify" value="1 " <?php if(isset($modify[2])){ if($modify[2] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" class="checkbox2" name="add_new_user_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="add_new_user_delete" value="1" <?php  if(isset($delete[2])){ if($delete[2] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox3" name="add_new_user_delete1" value="0">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>4. User Rights 
								<input type="hidden" name="form_right"   value="Add Rights">
							<input type="hidden" name="controller_right"   value="add_right">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="add_right_view" value="1" <?php if(isset($view[8])){ if($view[8] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="add_right_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="add_right_insert" value="1" <?php if(isset($insert[8])){ if($insert[8] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="add_right_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="add_right_modify" value="1" <?php if(isset($modify[8])){ if($modify[8] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox2" name="add_right_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="add_right_delete" value="1" <?php if(isset($delete[8])){ if($delete[8] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox3" name="add_right_delete1" value="0">
							</td>
						</tr>
							<tr>
							<td></td>
							
							<td>5. Add Default Call Center TL
								<input type="hidden" name="form_call_center_tl"   value="Default call center TL">
							<input type="hidden" name="controller_call_center_tl"   value="default_call_center_tl">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="call_center_tl_view" value="1" <?php if(isset($view[21])){ if($view[21] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="call_center_tl_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="call_center_tl_insert" value="1" <?php if(isset($insert[21])){ if($insert[21] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="call_center_tl_insert1" value="0">
							</td>
						<td>
								<input type="checkbox" class="checkbox1 pull-right" name="call_center_tl_modify" disabled value="0">
								<input type="hidden" class="checkbox2" name="call_center_tl_modify1" value="0">
							</td>
							<td>
								<input type="checkbox" class="checkbox1 pull-right" name="call_center_tl_delete" disabled value="0">
							
								<input type="hidden" class="checkbox3" name="call_center_tl_delete1" value="0">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>6. Lead Source 
								<input type="hidden" name="form_lead_source"   value="Lead Source">
							<input type="hidden" name="controller_lead_source"   value="add_leadsource">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="lead_source_view" value="1" <?php if(isset($view[5])){ if($view[5] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="lead_source_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="lead_source_insert" value="1" <?php if(isset($insert[5])){ if($insert[5] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="lead_source_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="lead_source_modify" value="1" <?php if(isset($modify[5])){ if($modify[5] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox2" name="lead_source_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="lead_source_delete" value="1" <?php if(isset($delete[5])){ if($delete[5] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox3" name="lead_source_delete1" value="0">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>7. Feedback Status 
								<input type="hidden" name="form_status"   value="Add Feedback Status">
							<input type="hidden" name="controller_status"   value="add_status">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="add_status_view" value="1" <?php if(isset($view[6])){ if($view[6] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="add_status_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="add_status_insert" value="1" <?php if(isset($insert[6])){ if($insert[6] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="add_status_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="add_status_modify" value="1" <?php if(isset($modify[6])){ if($modify[6] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox2" name="add_status_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="add_status_delete" value="1" <?php if(isset($delete[6])){ if($delete[6] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox3" name="add_status_delete1" value="0">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>8. Next Action 
								<input type="hidden" name="form_next_action"   value="Add Next Action">
							<input type="hidden" name="controller_next_action"   value="next_action">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="next_action_view" value="1" <?php if(isset($view[7])){ if($view[7] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="next_action_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="next_action_insert" value="1" <?php if(isset($insert[7])){ if($insert[7] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="next_action_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="next_action_modify" value="1" <?php if(isset($modify[7])){ if($modify[7] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox2" name="next_action_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="next_action_delete" value="1" <?php if(isset($delete[7])){ if($delete[7] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox3" name="next_action_delete1" value="0">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>9. Map Next Action to Feedback Status 
								<input type="hidden" name="form_map_next_action"   value="Map Next Action">
							<input type="hidden" name="controller_map_next_action"   value="map_next_action_to_feedback">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="map_next_action_view" value="1" <?php if(isset($view[14])){ if($view[14] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="map_next_action_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="map_next_action_insert" value="1" <?php if(isset($insert[14])){  if($insert[14] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="map_next_action_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="map_next_action_modify" value="1">
								<input type="hidden" class="checkbox2" name="map_next_action_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="map_next_action_delete" value="1">
								<input type="hidden" class="checkbox3" name="map_next_action_delete1" value="0">
							</td>
						</tr>
						<tr>
							
							<td></td>
							<td>10. Download User Details
								<input type="hidden" name="form_download_user_details"   value="Download User Details">
							<input type="hidden" name="controller_download_user_details"   value="Download user details">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="download_user_details_view" value="1" <?php if(isset($view[19])){ if($view[19] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="download_user_details_view1" value="0">
							</td>
								<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">
							</td>
							
								<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>11.Add SMS
								<input type="hidden" name="form_add_sms"   value="Add SMS">
							<input type="hidden" name="controller_sms"   value="Add SMS">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="add_sms_view" value="1" <?php if(isset($view[62])){ if($view[62] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="add_sms_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="add_sms_insert" value="1" <?php if(isset($insert[62])){  if($insert[62] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="add_sms_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="add_sms_modify" value="1" <?php if(isset($modify[62])){  if($modify[62] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox2" name="add_sms_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="add_sms_delete" value="1" <?php if(isset($delete[62])){  if($delete[62] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox3" name="add_sms_delete1" value="0">
							</td>
						</tr>
							<tr>
							<td></td>
							<td>12.Send message to DSE
								<input type="hidden" name="form_send_message_to_dse"   value="Send message to DSE">
							<input type="hidden" name="controller_send_message_to_dse"   value="Send message to DSE">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="send_message_to_dse_view" value="1" <?php if(isset($view[63])){ if($view[63] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="send_message_to_dse_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="send_message_to_dse_insert" value="1" <?php if(isset($insert[63])){  if($insert[63] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="send_message_to_dse_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="send_message_to_dse_modify" value="1" <?php if(isset($modify[63])){  if($modify[63] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox2" name="send_message_to_dse_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="send_message_to_dse_delete" value="1" <?php if(isset($delete[63])){  if($delete[63] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox3" name="send_message_to_dse_delete1" value="0">
							</td>
						</tr>
							<tr>
							<td></td>
							<td>13. Auto Lead Assign 
								<input type="hidden" name="form_lead_report"   value="Auto Lead Assign">
							<input type="hidden" name="controller_lead_report"   value="Auto Lead Assign">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="lead_report_view" value="1" <?php if(isset($view[61])){ if($view[61] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="lead_report_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="lead_report_insert" value="1" <?php if(isset($insert[61])){  if($insert[61] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="lead_report_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="lead_report_modify" value="1" <?php if(isset($modify[61])){  if($modify[61] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox2" name="lead_report_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="lead_report_delete" value="1" <?php if(isset($delete[61])){  if($delete[61] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox3" name="lead_report_delete1" value="0">								
							</td>
						</tr>
						<tr>
							<td>2</td>
							<td><b>Upload Lead</b> 
							<input type="hidden" name="form_upload_lead"   value="Upload Lead">
							<input type="hidden" name="controller_upload_lead"   value="upload_xls">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="upload_xls_view" value="1" <?php  if(isset($view[11])){ if($view[11] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="upload_xls_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="upload_xls_insert" value="1" <?php if(isset($insert[11])){ if($insert[11] =='1') {?>checked=checked <?php } } ?>> 
								<input type="hidden" class="checkbox" name="upload_xls_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
							</td>
						</tr>
						<tr>
							<td>3</td>
							<td><b>Calling Task</b>  
							<input type="hidden" name="calling_notification"   value="Calling Notification">
							<input type="hidden" name="controller_calling_notification"   value="calling_notification">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="calling_notification_view" value="1" <?php if(isset($view[15])){ if($view[15] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="calling_notification_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right"  disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">
							</td>
						</tr>
						<tr>
							<td>4</td>
							<td><b>Dashboard</b>  
							<input type="hidden" name="form_dashboard"   value="Dashboard">
							<input type="hidden" name="controller_dashboard"   value="new_notification">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="dashboard_view" value="1" <?php if(isset($view[16])){ if($view[16] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="dashboard_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right"  disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">
							</td>
						</tr>
					<!--	<tr>
							<td>5</td>
							<td><b>Transfer Leads Admin(One user to another)</b> 
							<input type="hidden" name="form_admin_transfer"   value="admin_transfer">
							
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="admin_transfer_view" value="1" <?php  if(isset($view[21])){ if($view[21] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="admin_transfer_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="admin_transfer_insert" value="1" <?php if(isset($insert[21])){ if($insert[21] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="admin_transfer_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">
							</td>
					</tr>-->
						<tr>
							<td>5</td>
							<td><b>New Car</b>
							</td>
							<td colspan='4'>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>1. Add New Lead 
							<input type="hidden" name="form_new_lead"   value="Add New Lead">
							<input type="hidden" name="controller_new_lead"   value="add_new_customer">
							</td>
							<td><input type="checkbox" class="checkbox pull-right" name="new_lead_view" value="1" <?php if(isset($view[1])){ if($view[1] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="new_lead_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="new_lead_insert" value="1" <?php if(isset($insert[1])){ if($insert[1] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="new_lead_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>2. Assign New Lead 
								<input type="hidden" name="form_assign_lead"   value="Assign Lead ">
							<input type="hidden" name="controller_assign_lead"   value="assign_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="assign_leads_view" value="1" <?php if(isset($view[4])){ if($view[4] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="assign_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="assign_leads_insert" value="1" <?php if(isset($insert[4])){ if($insert[4] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="assign_leads_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">								
							</td>
						</tr>
						
						<tr>
							<td></td>
							<td>3. Call Center Transfer 
								<input type="hidden" name="form_call_center_transfer"   value="Call Center Transfer">
							<input type="hidden" name="controller_call_center_transfer"   value="call_center_transfer">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="call_center_transfer_view" value="1" <?php if(isset($view[58])){ if($view[58] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="call_center_transfer_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="call_center_transfer_insert" value="1" <?php if(isset($insert[58])){ if($insert[58] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="call_center_transfer_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">								
							</td>
						</tr>
						
						
						<tr>
							<td></td>
							<td>4. Assign Transferred Leads  
								<input type="hidden" name="form_assign"   value="Assign transferred leads">
							<input type="hidden" name="controller_assign"   value="assign_transferred_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="assign_transferred_leads_view" value="1" <?php if(isset($view[17])){ if($view[17] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="assign_transferred_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="assign_transferred_leads_insert" value="1" <?php if(isset($insert[17])){ if($insert[17] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="assign_transferred_leads_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>5. Transfer Lead 
							<input type="hidden" name="form_transfer_lead"   value="Transfer Lead">
							<input type="hidden" name="controller_transfer_lead"   value="request_lead_transfer">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="request_lead_transfer_view" value="1" <?php if(isset($view[12])){ if($view[12] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="request_lead_transfer_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="request_lead_transfer_insert" value="1" <?php if(isset($insert[22])){ if($insert[12] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="request_lead_transfer_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>6. Add Follow Up 
							<input type="hidden" name="form_follow_up"   value="Add Follow Up">
							<input type="hidden" name="controller_follow_up"   value="add_followup">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="add_followup_view" value="1" <?php if(isset($view[9])){ if($view[9] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="add_followup_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="add_followup_insert" value="1" <?php if(isset($insert[9])){ if($insert[9] =='1') {?>checked=checked <?php }  } ?>>
								<input type="hidden" name="add_followup_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						<tr>
							<td></td>
							<td>7. Add Appointment 
							<input type="hidden" name="form_add_appointment"   value="Add Appointment">
							<input type="hidden" name="controller_add_appointment"   value="add_appointment">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="add_appointment_view" value="1" <?php if(isset($view[76])){ if($view[76] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="add_appointment_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="add_appointment_insert" value="1" <?php if(isset($insert[76])){ if($insert[76] =='1') {?>checked=checked <?php }  } ?>>
								<input type="hidden" name="add_appointment_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						<tr>
							<td></td>
							<td>8. Add Escalation 
							<input type="hidden" name="form_add_escalation"   value="Add Escalation">
							<input type="hidden" name="controller_add_escalation"   value="add_escalation">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="add_escalation_view" value="1" <?php if(isset($view[77])){ if($view[77] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="add_escalation_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="add_escalation_insert" value="1" <?php if(isset($insert[77])){ if($insert[77] =='1') {?>checked=checked <?php }  } ?>>
								<input type="hidden" name="add_escalation_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						<tr>
							<td></td>
							<td>9. Resolve Escalation 
							<input type="hidden" name="form_resolve_escalation"   value="Resolve Escalation">
							<input type="hidden" name="controller_resolve_escalation"   value="resolve_escalation">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="resolve_escalation_view" value="1" <?php if(isset($view[78])){ if($view[78] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="resolve_escalation_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="resolve_escalation_insert" value="1" <?php if(isset($insert[78])){ if($insert[78] =='1') {?>checked=checked <?php }  } ?>>
								<input type="hidden" name="resolve_escalation_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						
						<tr>
							<td></td>
							<td>10. Add Auditor Remark 
							<input type="hidden" name="form_manager_remark"   value="Add Manager Remark">
							<input type="hidden" name="controller_manager_remark"   value="add_manager_remark">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="manager_remark_view" value="1" <?php if(isset($view[10])){ if($view[10] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="manager_remark_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="manager_remark_insert" value="1" <?php if(isset($insert[10])){ if($insert[10] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="manager_remark_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">							
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						<tr>
							<td></td>
							<td>11. Tracker 
							<input type="hidden" name="form_tracker"   value="Tracker">
							<input type="hidden" name="controller_tracker"  value="tracker/team_leader_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="all_tracker_view" value="1" <?php if(isset($view[13])){ if($view[13] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="all_tracker_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						
							<tr>
							<td></td>
							<td>12. Download Lead Tracker  
								<input type="hidden" name="form_download"   value="Download Lead Tracker">
							<input type="hidden" name="controller_download"   value="download_lead_tracker">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="download_lead_tracker_view" value="1" <?php if(isset($view[18])){ if($view[18] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="download_lead_tracker_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right"  disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
							</td>
						</tr>
						<!--<tr>
							<td></td>
							<td>9. Create Quotation Format 
								<input type="hidden" name="form_create_quotation"   value="Create Quotation Format">
							<input type="hidden" name="controller_create_quotation"   value="dynamic_upload">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="create_quotation_view" value="1" <?php if(isset($view[19])){ if($view[19] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="create_quotation_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="create_quotation_insert"  value="1" <?php if(isset($insert[19])){ if($insert[19] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="create_quotation_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
							</td>
						</tr>-->
						<tr>
							<td></td>
							<td>13. Upload Quotation 
								<input type="hidden" name="form_upload_quotation"   value="Upload Quotaion">
							<input type="hidden" name="controller_upload_quotation"   value="dynamic_upload">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="upload_quotation_view" value="1" <?php if(isset($view[20])){ if($view[20] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="upload_quotation_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="upload_quotation_insert"  value="1" <?php if(isset($insert[20])){ if($insert[20] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="upload_quotation_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>14. Upload Stock 
								<input type="hidden" name="form_upload_stock"   value="Upload Stock">
							<input type="hidden" name="controller_upload_stock"   value="upload_xls1">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="upload_stock_view" value="1" <?php if(isset($view[66])){ if($view[66] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="upload_stock_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="upload_stock_insert"  value="1" <?php if(isset($insert[66])){ if($insert[66] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="upload_stock_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>15. Check Stock 
								<input type="hidden" name="form_check_stock"   value="Check Stock">
							<input type="hidden" name="controller_check_stock"   value="">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="check_stock_view" value="1" <?php if(isset($view[67])){ if($view[67] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="check_stock_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="check_stock_insert"  value="1" <?php if(isset($insert[67])){ if($insert[67] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="check_stock_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">
							</td>
						</tr>
						<tr>
							<td>6</td>
							<td><b>Used Car</b>
							</td>
							<td colspan='4'>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>1. Add New Lead 
							<input type="hidden" name="uform_new_lead"   value="Add New Lead">
							<input type="hidden" name="ucontroller_new_lead"   value="add_new_customer">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="unew_lead_view" value="1" <?php if(isset($view[22])){ if($view[22] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="unew_lead_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="unew_lead_insert" value="1" <?php if(isset($insert[22])){ if($insert[22] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="unew_lead_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>2. Assign New Lead 
								<input type="hidden" name="uform_assign_lead"   value="Assign Lead ">
							<input type="hidden" name="ucontroller_assign_lead"   value="assign_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="uassign_leads_view" value="1" <?php if(isset($view[23])){ if($view[23] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="uassign_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="uassign_leads_insert" value="1" <?php if(isset($insert[23])){ if($insert[23] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="uassign_leads_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">								
							</td>
						</tr>
						
						
						<tr>
							<td></td>
							<td>3. Call Center Transfer 
								<input type="hidden" name="uform_call_center_transfer"   value="Call Center Transfer">
							<input type="hidden" name="ucontroller_call_center_transfer"   value="call_center_transfer">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="ucall_center_transfer_view" value="1" <?php if(isset($view[59])){ if($view[59] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="uassign_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="ucall_center_transfer_insert" value="1" <?php if(isset($insert[59])){ if($insert[59] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="ucall_center_transfer_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">								
							</td>
						</tr>
						
						
						<tr>
							<td></td>
							<td>4. Assign Transferred Leads  
								<input type="hidden" name="uform_assign"   value="Assign transferred leads">
							<input type="hidden" name="ucontroller_assign"   value="assign_transferred_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="uassign_transferred_leads_view" value="1" <?php if(isset($view[24])){ if($view[24] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="uassign_transferred_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="uassign_transferred_leads_insert" value="1" <?php if(isset($insert[24])){ if($insert[24] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="uassign_transferred_leads_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>5. Transfer Lead 
							<input type="hidden" name="uform_transfer_lead"   value="Transfer Lead">
							<input type="hidden" name="ucontroller_transfer_lead"   value="request_lead_transfer">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="urequest_lead_transfer_view" value="1" <?php if(isset($view[25])){if($view[25] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="urequest_lead_transfer_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="urequest_lead_transfer_insert" value="1" <?php if(isset($insert[25])){ if($insert[25] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="urequest_lead_transfer_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>6. Add Follow Up 
							<input type="hidden" name="uform_follow_up"   value="Add Follow Up">
							<input type="hidden" name="ucontroller_follow_up"   value="add_followup">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="uadd_followup_view" value="1" <?php if(isset($view[26])){ if($view[26] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="uadd_followup_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="uadd_followup_insert" value="1" <?php if(isset($insert[26])){ if($insert[26] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="uadd_followup_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						<tr>
							<td></td>
							<td>7. Add Appointment 
							<input type="hidden" name="uform_add_appointment"   value="Add Appointment">
							<input type="hidden" name="ucontroller_add_appointment"   value="add_appointment">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="uadd_appointment_view" value="1" <?php if(isset($view[79])){ if($view[79] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="uadd_appointment_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="uadd_appointment_insert" value="1" <?php if(isset($insert[79])){ if($insert[79] =='1') {?>checked=checked <?php }  } ?>>
								<input type="hidden" name="uadd_appointment_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						<tr>
							<td></td>
							<td>8. Add Escalation 
							<input type="hidden" name="uform_add_escalation"   value="Add Escalation">
							<input type="hidden" name="ucontroller_add_escalation"   value="add_escalation">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="uadd_escalation_view" value="1" <?php if(isset($view[80])){ if($view[80] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="uadd_escalation_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="uadd_escalation_insert" value="1" <?php if(isset($insert[80])){ if($insert[80] =='1') {?>checked=checked <?php }  } ?>>
								<input type="hidden" name="uadd_escalation_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						<tr>
							<td></td>
							<td>9. Resolve Escalation 
							<input type="hidden" name="uform_resolve_escalation"   value="Resolve Escalation">
							<input type="hidden" name="ucontroller_resolve_escalation"   value="resolve_escalation">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="uresolve_escalation_view" value="1" <?php if(isset($view[81])){ if($view[81] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="uresolve_escalation_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="uresolve_escalation_insert" value="1" <?php if(isset($insert[81])){ if($insert[81] =='1') {?>checked=checked <?php }  } ?>>
								<input type="hidden" name="uresolve_escalation_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						<tr>
							<td></td>
							<td>10. Add Auditor Remark 
							<input type="hidden" name="uform_manager_remark"   value="Add Manager Remark">
							<input type="hidden" name="ucontroller_manager_remark"   value="add_manager_remark">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="umanager_remark_view" value="1" <?php if(isset($view[27])){ if($view[27] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="umanager_remark_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="umanager_remark_insert" value="1" <?php if(isset($insert[27])){ if($insert[27] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="umanager_remark_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">							
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						<tr>
							<td></td>
							<td>11. Tracker 
							<input type="hidden" name="uform_tracker"   value="Tracker">
							<input type="hidden" name="ucontroller_tracker"  value="tracker/team_leader_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="uall_tracker_view" value="1" <?php if(isset($view[28])){ if($view[28] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="uall_tracker_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
							<tr>
							<td></td>
							<td>12. Download Lead Tracker  
								<input type="hidden" name="uform_download"   value="Download Lead Tracker">
							<input type="hidden" name="ucontroller_download"   value="download_lead_tracker">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="udownload_lead_tracker_view" value="1" <?php if(isset($view[29])){ if($view[29] =='1') {?>checked=checked <?php }} ?>>
							
								<input type="hidden" class="checkbox" name="udownload_lead_tracker_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right"  disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>13. Upload Stock 
								<input type="hidden" name="uform_upload_stock"   value="Upload Stock">
							<input type="hidden" name="ucontroller_upload_stock"   value="upload_xls1">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="uupload_stock_view" value="1" <?php if(isset($view[30])){ if($view[30] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="uupload_stock_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="uupload_stock_insert"  value="1" <?php if(isset($insert[30])){ if($insert[30] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="uupload_stock_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>14. Check Stock 
								<input type="hidden" name="uform_check_stock"   value="Check Stock">
							<input type="hidden" name="ucontroller_check_stock"   value="">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="ucheck_stock_view" value="1" <?php if(isset($view[31])){ if($view[31] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="ucheck_stock_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="ucheck_stock_insert"  value="1" <?php if(isset($insert[31])){ if($insert[31] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="ucheck_stock_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">
							</td>
						</tr>
						<tr>
							<td>7</td>
							<td><b>Evaluation</b>
							</td>
							<td colspan='4'>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>1. Add New Lead 
							<input type="hidden" name="eform_new_lead"   value="Add New Lead">
							<input type="hidden" name="econtroller_new_lead"   value="add_new_customer">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="enew_lead_view" value="1" <?php if(isset($view[68])){ if($view[68] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="enew_lead_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="enew_lead_insert" value="1" <?php if(isset($insert[68])){ if($insert[68] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="enew_lead_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
							<tr>
							<td></td>
							<td>2. Assign New Lead 
								<input type="hidden" name="eform_assign_lead"   value="Assign Lead ">
							<input type="hidden" name="econtroller_assign_lead"   value="assign_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="eassign_leads_view" value="1" <?php if(isset($view[69])){ if($view[69] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="eassign_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="eassign_leads_insert" value="1" <?php if(isset($insert[69])){ if($insert[69] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="eassign_leads_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>3. Call Center Transfer
								<input type="hidden" name="eform_call_center_transfer"   value="Call Center Transfer">
							<input type="hidden" name="econtroller_call_center_transfer"   value="call_center_transfer">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="ecall_center_transfer_view" value="1" <?php if(isset($view[60])){ if($view[60] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="ecall_center_transfer_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="ecall_center_transfer_insert" value="1" <?php if(isset($view[60])){ if($view[60] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="ecall_center_transfer_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>4. Assign Transferred Leads  
								<input type="hidden" name="eform_assign"   value="Assign transferred leads">
							<input type="hidden" name="econtroller_assign"   value="assign_transferred_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="eassign_transferred_leads_view" value="1" <?php if(isset($view[70])){ if($view[70] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="eassign_transferred_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="eassign_transferred_leads_insert" value="1" <?php if(isset($insert[70])){ if($insert[70] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="eassign_transferred_leads_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>5. Transfer Lead 
							<input type="hidden" name="eform_transfer_lead"   value="Transfer Lead">
							<input type="hidden" name="econtroller_transfer_lead"   value="request_lead_transfer">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="erequest_lead_transfer_view" value="1" <?php if(isset($view[71])){if($view[71] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="erequest_lead_transfer_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="erequest_lead_transfer_insert" value="1" <?php if(isset($insert[71])){ if($insert[71] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="erequest_lead_transfer_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>6. Add Follow Up 
							<input type="hidden" name="eform_follow_up"   value="Add Follow Up">
							<input type="hidden" name="econtroller_follow_up"   value="add_followup">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="eadd_followup_view" value="1" <?php if(isset($view[72])){ if($view[72] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="eadd_followup_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="eadd_followup_insert" value="1" <?php if(isset($insert[72])){ if($insert[72] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="eadd_followup_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						<tr>
							<td></td>
							<td>7. Add Appointment 
							<input type="hidden" name="eform_add_appointment"   value="Add Appointment">
							<input type="hidden" name="econtroller_add_appointment"   value="add_appointment">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="eadd_appointment_view" value="1" <?php if(isset($view[82])){ if($view[82] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="eadd_appointment_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="eadd_appointment_insert" value="1" <?php if(isset($insert[82])){ if($insert[82] =='1') {?>checked=checked <?php }  } ?>>
								<input type="hidden" name="eadd_appointment_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						<tr>
							<td></td>
							<td>8. Add Escalation 
							<input type="hidden" name="eform_add_escalation"   value="Add Escalation">
							<input type="hidden" name="econtroller_add_escalation"   value="add_escalation">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="eadd_escalation_view" value="1" <?php if(isset($view[83])){ if($view[83] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="eadd_escalation_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="eadd_escalation_insert" value="1" <?php if(isset($insert[83])){ if($insert[83] =='1') {?>checked=checked <?php }  } ?>>
								<input type="hidden" name="eadd_escalation_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						<tr>
							<td></td>
							<td>9. Resolve Escalation 
							<input type="hidden" name="eform_resolve_escalation"   value="Resolve Escalation">
							<input type="hidden" name="econtroller_resolve_escalation"   value="resolve_escalation">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="eresolve_escalation_view" value="1" <?php if(isset($view[84])){ if($view[84] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="eresolve_escalation_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="eresolve_escalation_insert" value="1" <?php if(isset($insert[84])){ if($insert[84] =='1') {?>checked=checked <?php }  } ?>>
								<input type="hidden" name="eresolve_escalation_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						<tr>
							<td></td>
							<td>10. Add Auditor Remark 
							<input type="hidden" name="eform_manager_remark"   value="Add Manager Remark">
							<input type="hidden" name="econtroller_manager_remark"   value="add_manager_remark">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="emanager_remark_view" value="1" <?php if(isset($view[73])){ if($view[73] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="emanager_remark_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="emanager_remark_insert" value="1" <?php if(isset($insert[73])){ if($insert[73] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="emanager_remark_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">							
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						<tr>
							<td></td>
							<td>11. Tracker 
							<input type="hidden" name="eform_tracker"   value="Tracker">
							<input type="hidden" name="econtroller_tracker"  value="tracker/team_leader_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="eall_tracker_view" value="1" <?php if(isset($view[74])){ if($view[74] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="eall_tracker_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
							<tr>
							<td></td>
							<td>12. Download Lead Tracker  
								<input type="hidden" name="eform_download"   value="Download Lead Tracker">
							<input type="hidden" name="econtroller_download"   value="download_lead_tracker">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="edownload_lead_tracker_view" value="1" <?php if(isset($view[75])){ if($view[75] =='1') {?>checked=checked <?php }} ?>>
							
								<input type="hidden" class="checkbox" name="edownload_lead_tracker_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right"  disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
							</td>
						</tr>
						
						
						
						
						
						<tr>
							<td>8</td>
							<td><b>Finance</b>
							</td>
							<td colspan='4'>
							</td>
						</tr>
							<tr>
							<td></td>
							<td>1.Finance Master
							</td>
							<td colspan='4'>
							</td>
						</tr>
							<tr>
							<td></td>
							<td>1.1 Login Status
							<input type="hidden" name="fform_login_status"   value="Add Login Status">
							<input type="hidden" name="fcontroller_login_status"   value="add_login_status">
							</td>
							<td><input type="checkbox" class="checkbox pull-right" name="flogin_status_view" value="1" <?php if(isset($fview[0])){ if($fview[0] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="flogin_status_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="flogin_status_insert" value="1" <?php if(isset($finsert[0])){ if($finsert[0] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="flogin_status_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="flogin_status_modify" value="1" <?php if(isset($fmodify[0])){ if($fmodify[0] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="flogin_status_modify1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="flogin_status_delete" value="1" <?php if(isset($fdelete[0])){ if($fdelete[0] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="flogin_status_delete1"   value="0">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>1.2 Reject Reason
							<input type="hidden" name="fform_reject_reason"   value="Add Reject Reason">
							<input type="hidden" name="fcontroller_reject_reason"   value="add_reject_reason">
							</td>
							<td><input type="checkbox" class="checkbox pull-right" name="freject_reason_view" value="1" <?php if(isset($fview[1])){ if($fview[1] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="freject_reason_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="freject_reason_insert" value="1" <?php if(isset($finsert[1])){ if($finsert[1] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="freject_reason_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="freject_reason_modify" value="1" <?php if(isset($fmodify[1])){ if($fmodify[1] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="freject_reason_modify1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="freject_reason_delete" value="1" <?php if(isset($fdelete[1])){ if($fdelete[1] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="freject_reason_delete1"   value="0">
							</td>
						</tr>
							<tr>
							<td></td>
							<td>1.3 Map Document to Loan
							<input type="hidden" name="fform_document"   value="Add document">
							<input type="hidden" name="fcontroller_document"   value="add_document">
							</td>
							<td><input type="checkbox" class="checkbox pull-right" name="fdocument_view" value="1" <?php if(isset($fview[2])){ if($fview[2] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="fdocument_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="fdocument_insert" value="1" <?php if(isset($finsert[2])){ if($finsert[2] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="fdocument_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="fdocument_modify" value="1" <?php if(isset($fmodify[2])){ if($fmodify[2] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="fdocument_modify1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="fdocument_delete" value="1" <?php if(isset($fdelete[2])){ if($fdelete[2] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="fdocument_delete1"   value="0">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>1.4 Script
							<input type="hidden" name="fform_script"   value="Add script">
							<input type="hidden" name="fcontroller_script"   value="add_script">
							</td>
							<td><input type="checkbox" class="checkbox pull-right" name="fscript_view" value="1" <?php if(isset($fview[3])){ if($fview[3] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="fscript_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="fscript_insert" value="1" <?php if(isset($finsert[3])){ if($finsert[3] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="fscript_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="fscript_modify" value="1" <?php if(isset($fmodify[3])){ if($fmodify[3] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="fscript_modify1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="fscript_delete" value="1" <?php if(isset($fdelete[3])){ if($fdelete[3] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="fscript_delete1"   value="0">
							</td>
						</tr>
							<tr>
							<td></td>
							<td>1.5 Scheme
							<input type="hidden" name="fform_scheme"   value="Add scheme">
							<input type="hidden" name="fcontroller_scheme"   value="add_scheme">
							</td>
							<td><input type="checkbox" class="checkbox pull-right" name="fscheme_view" value="1" <?php if(isset($fview[4])){ if($fview[4] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="fscheme_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="fscheme_insert" value="1" <?php if(isset($finsert[4])){ if($finsert[4] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="fscheme_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="fscheme_modify" value="1" <?php if(isset($fmodify[4])){ if($fmodify[4] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="fscheme_modify1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="fscheme_delete" value="1" <?php if(isset($fdelete[4])){ if($fdelete[4] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="fscheme_delete1"   value="0">
							</td>
						</tr>
							<tr>
							<td></td>
							<td>1.6 Employment Type
							<input type="hidden" name="fform_emp_type"   value="Add emp_type">
							<input type="hidden" name="fcontroller_emp_type"   value="add_emp_type">
							</td>
							<td><input type="checkbox" class="checkbox pull-right" name="femp_type_view" value="1" <?php if(isset($fview[5])){ if($fview[5] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="femp_type_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="femp_type_insert" value="1" <?php if(isset($finsert[5])){ if($finsert[5] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="femp_type_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="femp_type_modify" value="1" <?php if(isset($fmodify[5])){ if($fmodify[5] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="femp_type_modify1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="femp_type_delete" value="1" <?php if(isset($fdelete[5])){ if($fdelete[5] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="femp_type_delete1"   value="0">
							</td>
						</tr>
							<tr>
							<td></td>
							<td>1.7 Professional Type
							<input type="hidden" name="fform_prof_type"   value="Add prof_type">
							<input type="hidden" name="fcontroller_prof_type"   value="add_prof_type">
							</td>
							<td><input type="checkbox" class="checkbox pull-right" name="fprof_type_view" value="1" <?php if(isset($fview[6])){ if($fview[6] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="fprof_type_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="fprof_type_insert" value="1" <?php if(isset($finsert[6])){ if($finsert[6] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="fprof_type_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="fprof_type_modify" value="1" <?php if(isset($fmodify[6])){ if($fmodify[6] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="fprof_type_modify1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="fprof_type_delete" value="1" <?php if(isset($fdelete[6])){ if($fdelete[6] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="fprof_type_delete1"   value="0">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>2. Add New Lead 
							<input type="hidden" name="fform_new_lead"   value="Add New Lead">
							<input type="hidden" name="fcontroller_new_lead"   value="add_new_customer">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="fnew_lead_view" value="1" <?php if(isset($view[32])){ if($view[32] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="fnew_lead_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="fnew_lead_insert" value="1" <?php if(isset($insert[32])){ if($insert[32] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="fnew_lead_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>3. Assign New Lead 
								<input type="hidden" name="fform_assign_lead"   value="Assign Lead ">
							<input type="hidden" name="fcontroller_assign_lead"   value="assign_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="fassign_leads_view" value="1" <?php if(isset($view[33])){ if($view[33] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="fassign_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="fassign_leads_insert" value="1" <?php if(isset($insert[33])){ if($insert[33] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="fassign_leads_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>4. Assign Transferred Leads 
								<input type="hidden" name="fform_assign"   value="Assign transferred leads">
							<input type="hidden" name="fcontroller_assign"   value="assign_transferred_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="fassign_transferred_leads_view" value="1" <?php if(isset($view[34])){ if($view[34] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" class="checkbox" name="fassign_transferred_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="fassign_transferred_leads_insert" value="1" <?php if(isset($insert[34])){ if($insert[34] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="fassign_transferred_leads_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>5. Transfer Lead 
							<input type="hidden" name="fform_transfer_lead"   value="Transfer Lead">
							<input type="hidden" name="fcontroller_transfer_lead"   value="request_lead_transfer">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="frequest_lead_transfer_view" value="1" <?php if(isset($view[35])){ if($view[35] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="frequest_lead_transfer_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="frequest_lead_transfer_insert" value="1" <?php if(isset($insert[35])){ if($insert[35] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="frequest_lead_transfer_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>6. Add Follow Up 
							<input type="hidden" name="fform_follow_up"   value="Add Follow Up">
							<input type="hidden" name="fcontroller_follow_up"   value="add_followup">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="fadd_followup_view" value="1" <?php if(isset($view[36])){ if($view[36] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="fadd_followup_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="fadd_followup_insert" value="1" <?php if(isset($insert[36])){ if($insert[36] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="fadd_followup_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						
						<tr>
							<td></td>
							<td>7. Add Auditor Remark 
							<input type="hidden" name="fform_manager_remark"   value="Add Manager Remark">
							<input type="hidden" name="fcontroller_manager_remark"   value="add_manager_remark">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="fmanager_remark_view" value="1" <?php if(isset($view[37])){ if($view[37] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" name="fmanager_remark_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="fmanager_remark_insert" value="1" <?php if(isset($insert[37])){ if($insert[37] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="fmanager_remark_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">							
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						<tr>
							<td></td>
							<td>8. Tracker 
							<input type="hidden" name="fform_tracker"   value="Tracker">
							<input type="hidden" name="fcontroller_tracker"  value="tracker/team_leader_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="fall_tracker_view" value="1" <?php if(isset($view[38])){ if($view[38] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="fall_tracker_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						
							<tr>
							<td></td>
							<td>9. Download Lead Tracker 
								<input type="hidden" name="fform_download"   value="Download Lead Tracker">
							<input type="hidden" name="fcontroller_download"   value="download_lead_tracker">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="fdownload_lead_tracker_view" value="1" <?php if(isset($view[39])){ if($view[39] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="fdownload_lead_tracker_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right"  disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
							</td>
						</tr>
						<tr>
							<td>9</td>
							<td><b>Service</b>
							</td>
							<td colspan='4'>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>1. Add New Lead 
							<input type="hidden" name="sform_new_lead"   value="Add New Lead">
							<input type="hidden" name="scontroller_new_lead"   value="add_new_customer">
							</td>
							<td><input type="checkbox" class="checkbox pull-right" name="snew_lead_view" value="1" <?php if(isset($view[40])){ if($view[40] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="snew_lead_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="snew_lead_insert" value="1" <?php if(isset($insert[40])){ if($insert[40] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="snew_lead_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>2. Assign New Lead 
								<input type="hidden" name="sform_assign_lead"   value="Assign Lead ">
							<input type="hidden" name="scontroller_assign_lead"   value="assign_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="sassign_leads_view" value="1" <?php if(isset($view[41])){ if($view[41] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="sassign_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="sassign_leads_insert" value="1" <?php if(isset($insert[41])){ if($insert[41] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="sassign_leads_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>3. Assign Transferred Leads  
								<input type="hidden" name="sform_assign"   value="Assign transferred leads">
							<input type="hidden" name="scontroller_assign"   value="assign_transferred_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="sassign_transferred_leads_view" value="1" <?php if(isset($view[42])){ if($view[42] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="sassign_transferred_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="sassign_transferred_leads_insert" value="1" <?php if(isset($insert[42])){ if($insert[42] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="sassign_transferred_leads_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>4. Transfer Lead 
							<input type="hidden" name="sform_transfer_lead"   value="Transfer Lead">
							<input type="hidden" name="scontroller_transfer_lead"   value="request_lead_transfer">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="srequest_lead_transfer_view" value="1" <?php if(isset($view[43])){ if($view[43] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="srequest_lead_transfer_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="srequest_lead_transfer_insert" value="1" <?php if(isset($insert[43])){ if($insert[43] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="srequest_lead_transfer_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>5. Add Follow Up 
							<input type="hidden" name="sform_follow_up"   value="Add Follow Up">
							<input type="hidden" name="scontroller_follow_up"   value="add_followup">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="sadd_followup_view" value="1" <?php if(isset($view[44])){ if($view[44] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="sadd_followup_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="sadd_followup_insert" value="1" <?php if(isset($insert[44])){if($insert[44] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="sadd_followup_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						<tr>
							<td></td>
							<td>6. Add Auditor Remark 
							<input type="hidden" name="sform_manager_remark"   value="Add Manager Remark">
							<input type="hidden" name="scontroller_manager_remark"   value="add_manager_remark">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="smanager_remark_view" value="1" <?php  if(isset($view[45])){ if($view[45] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="smanager_remark_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="smanager_remark_insert" value="1" <?php  if(isset($insert[45])){  if($insert[45] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="smanager_remark_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">							
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						<tr>
							<td></td>
							<td>7. Tracker 
							<input type="hidden" name="sform_tracker"   value="Tracker">
							<input type="hidden" name="scontroller_tracker"  value="tracker/team_leader_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="sall_tracker_view" value="1" <?php  if(isset($view[46])){ if($view[46] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="sall_tracker_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						
							<tr>
							<td></td>
							<td>8. Download Lead Tracker  
								<input type="hidden" name="sform_download"   value="Download Lead Tracker">
							<input type="hidden" name="scontroller_download"   value="download_lead_tracker">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="sdownload_lead_tracker_view" value="1" <?php  if(isset($view[47])){ if($view[47] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="sdownload_lead_tracker_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right"  disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
							</td>
						</tr>
						<tr>
							<td>10</td>
							<td><b>Accessories</b>
							</td>
							<td colspan='4'>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>1. Add New Lead 
							<input type="hidden" name="aform_new_lead"   value="Add New Lead">
							<input type="hidden" name="acontroller_new_lead"   value="add_new_customer">
							</td>
							<td><input type="checkbox" class="checkbox pull-right" name="anew_lead_view" value="1" <?php if(isset($view[48])){  if($view[48] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="anew_lead_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="anew_lead_insert" value="1" <?php if(isset($insert[48])){  if($insert[48] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="anew_lead_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>2. Assign New Lead 
								<input type="hidden" name="aform_assign_lead"   value="Assign Lead ">
							<input type="hidden" name="acontroller_assign_lead"   value="assign_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="aassign_leads_view" value="1" <?php if(isset($view[49])){  if($view[49] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="aassign_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="aassign_leads_insert" value="1" <?php if(isset($insert[49])){  if($insert[49] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="aassign_leads_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>3. Assign Transferred Leads  
								<input type="hidden" name="aform_assign"   value="Assign transferred leads">
							<input type="hidden" name="acontroller_assign"   value="assign_transferred_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="aassign_transferred_leads_view" value="1" <?php if(isset($view[50])){  if($view[50] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="aassign_transferred_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="aassign_transferred_leads_insert" value="1" <?php if(isset($insert[50])){  if($insert[50] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="aassign_transferred_leads_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>4. Transfer Lead 
							<input type="hidden" name="aform_transfer_lead"   value="Transfer Lead">
							<input type="hidden" name="acontroller_transfer_lead"   value="request_lead_transfer">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="arequest_lead_transfer_view" value="1" <?php if(isset($view[51])){  if($view[51] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="arequest_lead_transfer_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="arequest_lead_transfer_insert" value="1" <?php if(isset($insert[51])){  if($insert[51] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="arequest_lead_transfer_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>5. Add Follow Up 
							<input type="hidden" name="aform_follow_up"   value="Add Follow Up">
							<input type="hidden" name="acontroller_follow_up"   value="add_followup">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="aadd_followup_view" value="1" <?php  if(isset($view[52])){ if($view[52] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="aadd_followup_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="aadd_followup_insert" value="1" <?php if(isset($insert[52])){ if($insert[52] =='1') {?>checked=checked <?php } }?>>
								<input type="hidden" name="aadd_followup_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						
						<tr>
							<td></td>
							<td>6. Add Auditor Remark 
							<input type="hidden" name="aform_manager_remark"   value="Add Manager Remark">
							<input type="hidden" name="acontroller_manager_remark"   value="add_manager_remark">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="amanager_remark_view" value="1" <?php if(isset($view[53])){ if($view[53] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="amanager_remark_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="amanager_remark_insert" value="1" <?php if(isset($insert[53])){ if($insert[53] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="amanager_remark_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">							
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						<tr>
							<td></td>
							<td>7. Tracker 
							<input type="hidden" name="aform_tracker"   value="Tracker">
							<input type="hidden" name="acontroller_tracker"  value="tracker/team_leader_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="aall_tracker_view" value="1" <?php if(isset($view[54])){ if($view[54] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="aall_tracker_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
							<tr>
							<td></td>
							<td>8. Download Lead Tracker 
								<input type="hidden" name="aform_download"   value="Download Lead Tracker">
							<input type="hidden" name="acontroller_download"   value="download_lead_tracker">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="adownload_lead_tracker_view" value="1" <?php if(isset($view[55])){ if($view[55] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="adownload_lead_tracker_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right"  disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
							</td>
						</tr>
						
						<!-- Insurancecode -->
			<tr>
				<td>11</td>
				<td><b>Insurance</b>
				</td>
				<td colspan='4'>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>1. Add New Lead
					<input type="hidden" name="iform_new_lead" value="Add New Lead">
					<input type="hidden" name="icontroller_new_lead" value="add_new_customer">
				</td>
				<td><input type="checkbox" class="checkbox pull-right" name="inew_lead_view" value="1" <?php if (isset($view[56])) {
																											if ($view[56] == '1') { ?>checked=checked <?php }
																																				} ?>>
					<input type="hidden" name="inew_lead_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="inew_lead_insert" value="1" <?php if (isset($insert[56])) {
																												if ($insert[56] == '1') { ?>checked=checked <?php }
																																					} ?>>
					<input type="hidden" name="inew_lead_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>2. Assign New Lead
					<input type="hidden" name="iform_assign_lead" value="Assign Lead ">
					<input type="hidden" name="icontroller_assign_lead" value="assign_leads">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="iassign_leads_view" value="1" <?php if (isset($view[57])) {
																												if ($view[57] == '1') { ?>checked=checked <?php }
																																					} ?>>
					<input type="hidden" class="checkbox" name="iassign_leads_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="iassign_leads_insert" value="1" <?php if (isset($insert[57])) {
																													if ($insert[57] == '1') { ?>checked=checked <?php }
																																						} ?>>
					<input type="hidden" class="checkbox" name="iassign_leads_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>3. Assign Transferred Leads
					<input type="hidden" name="iform_assign" value="Assign transferred leads">
					<input type="hidden" name="icontroller_assign" value="assign_transferred_leads">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="iassign_transferred_leads_view" value="1" <?php if (isset($view[58])) {
																															if ($view[58] == '1') { ?>checked=checked <?php }
																																								} ?>>
					<input type="hidden" class="checkbox" name="iassign_transferred_leads_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="iassign_transferred_leads_insert" value="1" <?php if (isset($insert[58])) {
																																if ($insert[58] == '1') { ?>checked=checked <?php }
																																									} ?>>
					<input type="hidden" class="checkbox" name="iassign_transferred_leads_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>4. Transfer Lead
					<input type="hidden" name="iform_transfer_lead" value="Transfer Lead">
					<input type="hidden" name="icontroller_transfer_lead" value="request_lead_transfer">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="irequest_lead_transfer_view" value="1" <?php if (isset($view[59])) {
																															if ($view[59] == '1') { ?>checked=checked <?php }
																																								} ?>>
					<input type="hidden" class="checkbox" name="irequest_lead_transfer_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="irequest_lead_transfer_insert" value="1" <?php if (isset($insert[59])) {
																															if ($insert[59] == '1') { ?>checked=checked <?php }
																																								} ?>>
					<input type="hidden" class="checkbox" name="irequest_lead_transfer_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>5. Add Follow Up
					<input type="hidden" name="iform_follow_up" value="Add Follow Up">
					<input type="hidden" name="icontroller_follow_up" value="add_followup">
				</td>

				<td><input type="checkbox" class="checkbox pull-right" name="iadd_followup_view" value="1" <?php if (isset($view[60])) {
																												if ($view[60] == '1') { ?>checked=checked <?php }
																																					} ?>>
					<input type="hidden" name="iadd_followup_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="iadd_followup_insert" value="1" <?php if (isset($insert[60])) {
																													if ($insert[60] == '1') { ?>checked=checked <?php }
																																						} ?>>
					<input type="hidden" name="iadd_followup_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>

			<tr>
				<td></td>
				<td>6. Add Auditor Remark
					<input type="hidden" name="iform_manager_remark" value="Add Manager Remark">
					<input type="hidden" name="icontroller_manager_remark" value="add_manager_remark">
				</td>

				<td><input type="checkbox" class="checkbox pull-right" name="imanager_remark_view" value="1" <?php if (isset($view[61])) {
																													if ($view[61] == '1') { ?>checked=checked <?php }
																																						} ?>>
					<input type="hidden" name="imanager_remark_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="imanager_remark_insert" value="1" <?php if (isset($insert[61])) {
																													if ($insert[61] == '1') { ?>checked=checked <?php }
																																						} ?>>
					<input type="hidden" name="imanager_remark_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>7. Tracker
					<input type="hidden" name="iform_tracker" value="Tracker">
					<input type="hidden" name="icontroller_tracker" value="tracker/team_leader_leads">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="iall_tracker_view" value="1" <?php if (isset($view[62])) {
																												if ($view[62] == '1') { ?>checked=checked <?php }
																																					} ?>>
					<input type="hidden" class="checkbox" name="iall_tracker_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>8. Download Lead Tracker
					<input type="hidden" name="iform_download" value="Download Lead Tracker">
					<input type="hidden" name="icontroller_download" value="download_lead_tracker">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="idownload_lead_tracker_view" value="1" <?php if (isset($view[63])) {
																															if ($view[63] == '1') { ?>checked=checked <?php }
																																								} ?>>
					<input type="hidden" class="checkbox" name="idownload_lead_tracker_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<!-- End Insurancecode -->
						
						<!--<tr>
							<td>12</td>
							<td><b>Complaint</b>
							</td>
							<td colspan='4'>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>1. Add New Complaint 
							<input type="hidden" name="cform_new_lead"   value="Add New Lead">
							<input type="hidden" name="ccontroller_new_lead"   value="add_new_customer">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="cnew_lead_view" value="1" <?php if(isset($view[76])){ if($view[76] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="cnew_lead_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="cnew_lead_insert" value="1" <?php if(isset($insert[76])){ if($insert[76] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="cnew_lead_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
							<tr>
							<td></td>
							<td>2. Assign New Complaint 
								<input type="hidden" name="cform_assign_lead"   value="Assign Lead ">
							<input type="hidden" name="ccontroller_assign_lead"   value="assign_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="cassign_leads_view" value="1" <?php if(isset($view[77])){ if($view[77] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="cassign_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="cassign_leads_insert" value="1" <?php if(isset($insert[77])){ if($insert[77] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="cassign_leads_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">								
							</td>
						</tr>
						
						<tr>
							<td></td>
							<td>3. Add Follow Up 
							<input type="hidden" name="cform_follow_up"   value="Add Follow Up">
							<input type="hidden" name="ccontroller_follow_up"   value="add_followup">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="cadd_followup_view" value="1" <?php if(isset($view[78])){ if($view[78] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="cadd_followup_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="cadd_followup_insert" value="1" <?php if(isset($insert[78])){ if($insert[78] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="cadd_followup_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						<tr>
							<td></td>
							<td>4. Add Auditor Remark 
							<input type="hidden" name="cform_manager_remark"   value="Add Manager Remark">
							<input type="hidden" name="ccontroller_manager_remark"   value="add_manager_remark">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="cmanager_remark_view" value="1" <?php if(isset($view[79])){ if($view[79] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="cmanager_remark_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="cmanager_remark_insert" value="1" <?php if(isset($insert[79])){ if($insert[79] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="cmanager_remark_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">							
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						<tr>
							<td></td>
							<td>5. Tracker 
							<input type="hidden" name="cform_tracker"   value="Tracker">
							<input type="hidden" name="ccontroller_tracker"  value="tracker/team_leader_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="call_tracker_view" value="1" <?php if(isset($view[80])){ if($view[80] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="call_tracker_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
							<tr>
							<td></td>
							<td>6. Download Lead Tracker  
								<input type="hidden" name="cform_download"   value="Download Lead Tracker">
							<input type="hidden" name="ccontroller_download"   value="download_lead_tracker">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="cdownload_lead_tracker_view" value="1" <?php if(isset($view[81])){ if($view[81] =='1') {?>checked=checked <?php }} ?>>
							
								<input type="hidden" class="checkbox" name="cdownload_lead_tracker_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right"  disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
							</td>
						</tr>-->
						
						<tr>
							<td>12</td>
							<td><b>Customer Operation</b>
							</td>
							<td colspan='4'>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>1. Search Customer 
							<input type="hidden" name="form_search_customer"   value="Search Customer">
							<input type="hidden" name="controller_search_customer"   value="search_customer">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="search_customer_view" value="1" <?php if(isset($view[56])){ if($view[56] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="search_customer_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>2. Edit Customer 
								<input type="hidden" name="form_edit_customer"   value="Edit Customer">
							<input type="hidden" name="controller_edit_customer"   value="edit_customer">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="edit_customer_view" value="1" <?php  if(isset($view[57])){ if($view[57] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="edit_customer_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="edit_customer_insert" value="1" <?php if(isset($insert[57])){ if($insert[57] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" class="checkbox" name="edit_customer_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">								
							</td>
						</tr>

						<tr>
							<td></td>
							<td>3. Booking Payment 
								<input type="hidden" name="form_add_payment_booking"   value="Add Payment Booking">
							<input type="hidden" name="controller_add_payment_booking"   value="add_payment_booking">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="add_payment_booking_view" value="1" <?php  if(isset($view[85])){ if($view[85] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="add_payment_booking_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="add_payment_booking_insert" value="1" <?php if(isset($insert[85])){ if($insert[85] =='1') {?>checked=checked <?php }} ?>>
								<input type="hidden" class="checkbox" name="add_payment_booking_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">								
							</td>
						</tr>
					<!--	<tr>
							<td>12</td>
							<td><b>Reports</b>
							</td>
							<td colspan='4'>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>1. Daily 
							<input type="hidden" name="form_daily_report"   value="daily_report">
							<input type="hidden" name="controller_daily_report"   value="daily_report">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="daily_report_view" value="1" <?php if(isset($view[58])){ if($view[58] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="daily_report_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>						
						<tr>
							<td></td>
							<td>2. Monthly 
								<input type="hidden" name="form_monthly_report"   value="monthly_report">
							<input type="hidden" name="controller_monthly_report"   value="monthly_report">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="monthly_report_view" value="1" <?php if(isset($view[59])){ if($view[59] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="monthly_report_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>3. DSEwise 
							<input type="hidden" name="form_dse_report"   value="dse_report">
							<input type="hidden" name="controller_dse_report"   value="dse_report">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="dse_report_view" value="1" <?php if(isset($view[60])){ if($view[60] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="dse_report_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" disabled value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>4. Lead Report 
								<input type="hidden" name="form_lead_report"   value="lead_report">
							<input type="hidden" name="controller_lead_report"   value="lead_report">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="lead_report_view"  value="1" <?php if(isset($view[61])){ if($view[61] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="lead_report_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" disabled value="0">
								
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">								
							</td>
						</tr>
					<tr>
							<td></td>
							<td>5. Add DSE Daily report
								<input type="hidden" name="form_add_dse_daily_report"   value="Add DSE Daily report">
							<input type="hidden" name="controller_add_dse_daily_report"   value="Add Daily report">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="add_dse_daily_report_view"  value="1" <?php if(isset($view[64])){ if($view[64] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="add_dse_daily_report_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" disabled value="0">
								
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">								
							</td>
						</tr>
					<tr>
							<td></td>
							<td>6. View DSE daily report
								<input type="hidden" name="form_view_dse_daily_report"   value="View DSE daily report">
							<input type="hidden" name="controller_add_daily_report"   value="View DSE daily report">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="dse_daily_report_view"  value="1" <?php if(isset($view[65])){ if($view[65] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="dse_daily_report_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" disabled value="0">
								
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">								
							</td>
					</tr>-->
						</tbody>
						</table>
						</div>
												<div class="col-md-12" style="margin-top:20px;">
								<div class="form-group">
									<div class="col-md-2" >
										
										<label class="control-label " for="first-name">Copy User Rights From:</label>
									</div>
                                    <div class="col-md-3" >
             					<select type="text" class="form-control" id="cpyright" name="cpyright" ><span class="glyphicon">&#xe252;</span>
                                            <option value=""> Select User</option> 
											<?php
											
											foreach($copy_user_rights as $row5)
											{												
											?>
											 <option value="<?php echo $row5 -> id; ?>"><?php echo $row5 -> fname . ' ' . $row5 -> lname; ?></option>
											
											<?php } ?>
											</select>   
 
  

                                        </div>
                                        
                                         <div class="col-md-2" style="margin-bottom: 20px">                                                     
                                  
									  <!--<div class="pull-middle  ">-->
                                        
                                        <button  class="btn btn-info" type="button" onClick="return copyRights();"><i class="entypo-search"></i>  </button>        
										
                                    <!--</div>--> 
									
									</div>
                                    </div>
                                </div>
						
						
                     	<div class="form-group">
							<div class="col-md-2 col-md-offset-4">
								<button type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12">Submit</button>
							</div>
							<div class="col-md-2">
								<input type='reset' class="btn btn-primary col-md-12 col-xs-12 col-sm-12" value='Reset'>
							</div>
						</div>