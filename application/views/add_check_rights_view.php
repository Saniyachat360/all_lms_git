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
							<td><input type="checkbox" class="checkbox pull-right" name="add_location_view" value="1">
								<input type="hidden" name="add_location_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="add_location_insert" value="1">
								<input type="hidden" name="add_location_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="add_location_modify" value="1">
								<input type="hidden" name="add_location_modify1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="add_location_delete" value="1">
								<input type="hidden" name="add_location_delete1"   value="0">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>2. Map Process to Location
								<input type="hidden" name="form_map_process"   value="Map process to location">
							<input type="hidden" name="controller_map_process"   value="Link_process_location">
							</td>
							<td><input type="checkbox" class="checkbox pull-right" name="map_process_view" value="1">
								<input type="hidden" class="checkbox" name="map_process_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="map_process_insert" value="1">
								<input type="hidden" class="checkbox1" name="map_process_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="map_process_modify" value="1">
								<input type="hidden" class="checkbox2" name="map_process_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="map_process_delete" value="1">
								<input type="hidden" class="checkbox3" name="map_process_delete1" value="0">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>3. Add User
								<input type="hidden" name="form_user"   value="Add User">
							<input type="hidden" name="controller_user"   value="add_lms_user">
							</td>
							<td><input type="checkbox" class="checkbox pull-right" name="add_new_user_view" value="1">
								<input type="hidden" class="checkbox" name="add_new_user_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="add_new_user_insert" value="1">
								<input type="hidden" class="checkbox1" name="add_new_user_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="add_new_user_modify" value="1">
								<input type="hidden" class="checkbox2" name="add_new_user_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="add_new_user_delete" value="1">
								<input type="hidden" class="checkbox3" name="add_new_user_delete1" value="0">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>4. User Rights
								<input type="hidden" name="form_right"   value="Add Rights">
							<input type="hidden" name="controller_right"   value="add_right">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="add_right_view" value="1">
								<input type="hidden" class="checkbox" name="add_right_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="add_right_insert" value="1">
								<input type="hidden" class="checkbox" name="add_right_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="add_right_modify" value="1">
								<input type="hidden" class="checkbox2" name="add_right_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="add_right_delete" value="1">
								<input type="hidden" class="checkbox3" name="add_right_delete1" value="0">
							</td>
						</tr>
							<tr>
							<td></td>
							<td>5. Add Default Call Center TL
								<input type="hidden" name="form_call_center_tl"   value="Default call center TL">
							<input type="hidden" name="controller_call_center_tl"   value="default_call_center_tl">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="call_center_tl_view" value="1">
								<input type="hidden" class="checkbox" name="call_center_tl_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="call_center_tl_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="lead_source_view" value="1">
								<input type="hidden" class="checkbox" name="lead_source_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="lead_source_insert" value="1">
								<input type="hidden" class="checkbox" name="lead_source_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="lead_source_modify" value="1">
								<input type="hidden" class="checkbox2" name="lead_source_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="lead_source_delete" value="1">
								<input type="hidden" class="checkbox3" name="lead_source_delete1" value="0">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>7. Feedback Status
								<input type="hidden" name="form_status"   value="Add Feedback Status">
							<input type="hidden" name="controller_status"   value="add_status">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="add_status_view" value="1">
								<input type="hidden" class="checkbox" name="add_status_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="add_status_insert" value="1">
								<input type="hidden" class="checkbox" name="add_status_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="add_status_modify" value="1">
								<input type="hidden" class="checkbox2" name="add_status_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="add_status_delete" value="1">
								<input type="hidden" class="checkbox3" name="add_status_delete1" value="0">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>8. Next Action
								<input type="hidden" name="form_next_action"   value="Add Next Action">
							<input type="hidden" name="controller_next_action"   value="next_action">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="next_action_view" value="1">
								<input type="hidden" class="checkbox" name="next_action_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="next_action_insert" value="1">
								<input type="hidden" class="checkbox" name="next_action_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="next_action_modify" value="1">
								<input type="hidden" class="checkbox2" name="next_action_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="next_action_delete" value="1">
								<input type="hidden" class="checkbox3" name="next_action_delete1" value="0">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>9. Map Next Action to Feedback Status
								<input type="hidden" name="form_map_next_action"   value="Map Next Action">
							<input type="hidden" name="controller_map_next_action"   value="map_next_action_to_feedback">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="map_next_action_view" value="1">
								<input type="hidden" class="checkbox" name="map_next_action_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="map_next_action_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="download_user_details_view" value="1">
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
							<td>11. Add SMS
								<input type="hidden" name="form_add_sms"   value="Add SMS">
							<input type="hidden" name="controller_sms"   value="Add SMS">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="add_sms_view" value="1">
								<input type="hidden" class="checkbox" name="add_sms_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="add_sms_insert" value="1">
								<input type="hidden" class="checkbox" name="add_sms_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" name="add_sms_modify" value="1">
								<input type="hidden" class="checkbox2" name="add_sms_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="add_sms_delete" value="1">
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
							<td><input type="checkbox" class="checkbox2 pull-right" name="send_message_to_dse_modify" value="1" <?php if(isset($insert[63])){  if($modify[63] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox2" name="send_message_to_dse_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" name="send_message_to_dse_delete" value="1" <?php if(isset($insert[63])){  if($delete[63] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox3" name="send_message_to_dse_delete1" value="0">
							</td>
						</tr>
						<tr>
							<td>2</td>
							<td><b>Upload Lead</b>
							<input type="hidden" name="form_upload_lead"   value="Upload Lead">
							<input type="hidden" name="controller_upload_lead"   value="upload_xls">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="upload_xls_view" value="1">
								<input type="hidden" class="checkbox" name="upload_xls_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="upload_xls_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="calling_notification_view" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="dashboard_view" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="admin_transfer_view" value="1">
								<input type="hidden" class="checkbox" name="admin_transfer_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="admin_transfer_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right" name="new_lead_view" value="1">
								<input type="hidden" name="new_lead_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="new_lead_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="assign_leads_view" value="1">
								<input type="hidden" class="checkbox" name="assign_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="assign_leads_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="call_center_transfer_view" value="1">
								<input type="hidden" class="checkbox" name="call_center_transfer_view_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="call_center_transfer_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="assign_transferred_leads_view" value="1">
								<input type="hidden" class="checkbox" name="assign_transferred_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="assign_transferred_leads_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="request_lead_transfer_view" value="1">
								<input type="hidden" class="checkbox" name="request_lead_transfer_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="request_lead_transfer_insert" value="1">
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="add_followup_view" value="1">
								<input type="hidden" name="add_followup_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="add_followup_insert" value="1">
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="add_appointment_view" value="1">
								<input type="hidden" name="add_appointment_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="add_appointment_insert" value="1">
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="add_escalation_view" value="1" >
								<input type="hidden" name="add_escalation_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="add_escalation_insert" value="1">
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="resolve_escalation_view" value="1" >
								<input type="hidden" name="resolve_escalation_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="resolve_escalation_insert" value="1">
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="manager_remark_view" value="1">
								<input type="hidden" name="manager_remark_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="manager_remark_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="all_tracker_view" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="download_lead_tracker_view" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="create_quotation_view" value="1">
								<input type="hidden" class="checkbox" name="create_quotation_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="create_quotation_insert"  value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="upload_quotation_view" value="1">
								<input type="hidden" class="checkbox" name="upload_quotation_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="upload_quotation_insert"  value="1">
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="unew_lead_view" value="1">
								<input type="hidden" name="unew_lead_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="unew_lead_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="uassign_leads_view" value="1">
								<input type="hidden" class="checkbox" name="uassign_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="uassign_leads_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="ucall_center_transfer_view" value="1">
								<input type="hidden" class="checkbox" name="uassign_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="ucall_center_transfer_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="uassign_transferred_leads_view" value="1">
								<input type="hidden" class="checkbox" name="uassign_transferred_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="uassign_transferred_leads_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="urequest_lead_transfer_view" value="1">
								<input type="hidden" class="checkbox" name="urequest_lead_transfer_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="urequest_lead_transfer_insert" value="1">
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="uadd_followup_view" value="1">
								<input type="hidden" name="uadd_followup_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="uadd_followup_insert" value="1">
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="uadd_appointment_view" value="1" >
								<input type="hidden" name="uadd_appointment_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="uadd_appointment_insert" value="1" >
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="uadd_escalation_view" value="1" >
								<input type="hidden" name="uadd_escalation_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="uadd_escalation_insert" value="1" >
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="uresolve_escalation_view" value="1" >
								<input type="hidden" name="uresolve_escalation_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="uresolve_escalation_insert" value="1" >
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="umanager_remark_view" value="1">
								<input type="hidden" name="umanager_remark_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="umanager_remark_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="uall_tracker_view" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="udownload_lead_tracker_view" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="uupload_stock_view" value="1">
								<input type="hidden" class="checkbox" name="uupload_stock_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="uupload_stock_insert"  value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="ucheck_stock_view" value="1">
								<input type="hidden" class="checkbox" name="ucheck_stock_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="ucheck_stock_insert"  value="1">
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="enew_lead_view" value="1">
								<input type="hidden" name="enew_lead_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="enew_lead_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="eassign_leads_view" value="1">
								<input type="hidden" class="checkbox" name="eassign_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="eassign_leads_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="ecall_center_transfer_view" value="1">
								<input type="hidden" class="checkbox" name="ecall_center_transfer_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="ecall_center_transfer_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="eassign_transferred_leads_view" value="1">
								<input type="hidden" class="checkbox" name="eassign_transferred_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="eassign_transferred_leads_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="erequest_lead_transfer_view" value="1">
								<input type="hidden" class="checkbox" name="erequest_lead_transfer_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="erequest_lead_transfer_insert" value="1">
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="eadd_followup_view" value="1">
								<input type="hidden" name="eadd_followup_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="eadd_followup_insert" value="1">
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="eadd_appointment_view" value="1" >
								<input type="hidden" name="eadd_appointment_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="eadd_appointment_insert" value="1" >
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="eadd_escalation_view" value="1" >
								<input type="hidden" name="eadd_escalation_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="eadd_escalation_insert" value="1" >
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="eresolve_escalation_view" value="1" >
								<input type="hidden" name="eresolve_escalation_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="eresolve_escalation_insert" value="1" >
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="emanager_remark_view" value="1">
								<input type="hidden" name="emanager_remark_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="emanager_remark_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="eall_tracker_view" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="edownload_lead_tracker_view" value="1">
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
							<td>1. Add New Lead
							<input type="hidden" name="fform_new_lead"   value="Add New Lead">
							<input type="hidden" name="fcontroller_new_lead"   value="add_new_customer">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="fnew_lead_view" value="1">
								<input type="hidden" name="fnew_lead_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="fnew_lead_insert" value="1">
								<input type="hidden" name="fnew_lead_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>2. Assign New Lead
								<input type="hidden" name="fform_assign_lead"   value="Assign Lead ">
							<input type="hidden" name="fcontroller_assign_lead"   value="assign_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="fassign_leads_view" value="1">
								<input type="hidden" class="checkbox" name="fassign_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="fassign_leads_insert" value="1">
								<input type="hidden" class="checkbox" name="fassign_leads_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">								
							</td>
						</tr>
						
						<tr>
							<td></td>
							<td>3. Assign Transferred Leads 
								<input type="hidden" name="fform_assign"   value="Assign transferred leads">
							<input type="hidden" name="fcontroller_assign"   value="assign_transferred_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="fassign_transferred_leads_view" value="1">
								<input type="hidden" class="checkbox" name="fassign_transferred_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="fassign_transferred_leads_insert" value="1">
								<input type="hidden" class="checkbox" name="fassign_transferred_leads_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>4. Transfer Lead
							<input type="hidden" name="fform_transfer_lead"   value="Transfer Lead">
							<input type="hidden" name="fcontroller_transfer_lead"   value="request_lead_transfer">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="frequest_lead_transfer_view" value="1">
								<input type="hidden" class="checkbox" name="frequest_lead_transfer_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="frequest_lead_transfer_insert" value="1">
								<input type="hidden" class="checkbox" name="frequest_lead_transfer_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>5. Add Follow Up
							<input type="hidden" name="fform_follow_up"   value="Add Follow Up">
							<input type="hidden" name="fcontroller_follow_up"   value="add_followup">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="fadd_followup_view" value="1">
								<input type="hidden" name="fadd_followup_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="fadd_followup_insert" value="1">
								<input type="hidden" name="fadd_followup_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						
						<tr>
							<td></td>
							<td>6. Add Auditor Remark
							<input type="hidden" name="fform_manager_remark"   value="Add Manager Remark">
							<input type="hidden" name="fcontroller_manager_remark"   value="add_manager_remark">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" name="fmanager_remark_view" value="1">
								<input type="hidden" name="fmanager_remark_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="fmanager_remark_insert" value="1">
								<input type="hidden" name="fmanager_remark_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">							
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							
							</td>
						</tr>
						<tr>
							<td></td>
							<td>7. Tracker
							<input type="hidden" name="fform_tracker"   value="Tracker">
							<input type="hidden" name="fcontroller_tracker"  value="tracker/team_leader_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="fall_tracker_view" value="1">
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
							<td>8. Download Lead Tracker 
								<input type="hidden" name="fform_download"   value="Download Lead Tracker">
							<input type="hidden" name="fcontroller_download"   value="download_lead_tracker">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " name="fdownload_lead_tracker_view" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right" name="snew_lead_view" value="1">
								<input type="hidden" name="snew_lead_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="snew_lead_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="sassign_leads_view" value="1">
								<input type="hidden" class="checkbox" name="sassign_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="sassign_leads_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="sassign_transferred_leads_view" value="1">
								<input type="hidden" class="checkbox" name="sassign_transferred_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="sassign_transferred_leads_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="srequest_lead_transfer_view" value="1">
								<input type="hidden" class="checkbox" name="srequest_lead_transfer_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="srequest_lead_transfer_insert" value="1">
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="sadd_followup_view" value="1">
								<input type="hidden" name="sadd_followup_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="sadd_followup_insert" value="1">
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="smanager_remark_view" value="1">
								<input type="hidden" name="smanager_remark_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="smanager_remark_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="sall_tracker_view" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="sdownload_lead_tracker_view" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right" name="anew_lead_view" value="1">
								<input type="hidden" name="anew_lead_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="anew_lead_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="aassign_leads_view" value="1">
								<input type="hidden" class="checkbox" name="aassign_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="aassign_leads_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="aassign_transferred_leads_view" value="1">
								<input type="hidden" class="checkbox" name="aassign_transferred_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="aassign_transferred_leads_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="arequest_lead_transfer_view" value="1">
								<input type="hidden" class="checkbox" name="arequest_lead_transfer_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="arequest_lead_transfer_insert" value="1">
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="aadd_followup_view" value="1">
								<input type="hidden" name="aadd_followup_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="aadd_followup_insert" value="1">
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="amanager_remark_view" value="1">
								<input type="hidden" name="amanager_remark_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="amanager_remark_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="aall_tracker_view" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="adownload_lead_tracker_view" value="1">
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
				<td><input type="checkbox" class="checkbox pull-right" name="inew_lead_view" value="1">
					<input type="hidden" name="inew_lead_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="inew_lead_insert" value="1">
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
				<td><input type="checkbox" class="checkbox pull-right " name="iassign_leads_view" value="1">
					<input type="hidden" class="checkbox" name="iassign_leads_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="iassign_leads_insert" value="1">
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
				<td><input type="checkbox" class="checkbox pull-right " name="iassign_transferred_leads_view" value="1">
					<input type="hidden" class="checkbox" name="iassign_transferred_leads_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="iassign_transferred_leads_insert" value="1">
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
				<td><input type="checkbox" class="checkbox pull-right " name="irequest_lead_transfer_view" value="1">
					<input type="hidden" class="checkbox" name="irequest_lead_transfer_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="irequest_lead_transfer_insert" value="1">
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

				<td><input type="checkbox" class="checkbox pull-right" name="iadd_followup_view" value="1">
					<input type="hidden" name="iadd_followup_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="iadd_followup_insert" value="1">
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

				<td><input type="checkbox" class="checkbox pull-right" name="imanager_remark_view" value="1">
					<input type="hidden" name="imanager_remark_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="imanager_remark_insert" value="1">
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
				<td><input type="checkbox" class="checkbox pull-right " name="iall_tracker_view" value="1">
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
				<td><input type="checkbox" class="checkbox pull-right " name="idownload_lead_tracker_view" value="1">
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
					<!--	<tr>
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="cnew_lead_view" value="1" >
								<input type="hidden" name="cnew_lead_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="cnew_lead_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="cassign_leads_view" value="1" >
								<input type="hidden" class="checkbox" name="cassign_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="cassign_leads_insert" value="1" >
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="cadd_followup_view" value="1" >
								<input type="hidden" name="cadd_followup_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="cadd_followup_insert" value="1" >
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="cmanager_remark_view" value="1" >
								<input type="hidden" name="cmanager_remark_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="cmanager_remark_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="call_tracker_view" value="1" >
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
							<td><input type="checkbox" class="checkbox pull-right " name="cdownload_lead_tracker_view" value="1" >
							
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="search_customer_view" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="edit_customer_view" value="1">
								<input type="hidden" class="checkbox" name="edit_customer_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="edit_customer_insert" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="add_payment_booking_view" value="1">
								<input type="hidden" class="checkbox" name="add_payment_booking_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="add_payment_booking_insert" value="1">
								<input type="hidden" class="checkbox" name="add_payment_booking_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">								
							</td>
						</tr>
						
				<!--		<tr>
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="daily_report_view" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="monthly_report_view" value="1">
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="dse_report_view" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="lead_report_view" value="1">
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
							<td><input type="checkbox" class="checkbox pull-right " name="add_dse_daily_report_view"  value="1" >
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
							<td><input type="checkbox" class="checkbox pull-right " name="dse_daily_report_view"  value="1" >
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