<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

						//	echo count($select_right_data) ;

							foreach ($select_right_data as $fetch) {

								$view[] = $fetch -> view;

								$insert[] = $fetch -> insert;

								$modify[] = $fetch -> modify;

								$delete[] = $fetch -> delete;

							}

						?>

						<input type="hidden" name="user_name"   value="<?php echo $select_right_data[0] -> id; ?>">

						

					<!--	<tr>

							<td>1.</td>

							<td>Assign Transferred Leads  

								<input type="hidden" name="form_assign"   value="Assign transferred leads">

							<input type="hidden" name="controller_assign"   value="assign_transferred_leads">

							</td>

							<td><input type="checkbox" class="checkbox pull-right " name="assign_transferred_leads_view" value="1" <?php if(isset($view[0])){ if($view[0] =='1') {?>checked=checked <?php } } ?>>

								<input type="hidden" class="checkbox" name="assign_transferred_leads_view1" value="0">

							</td>

							<td><input type="checkbox" class="checkbox1 pull-right" name="assign_transferred_leads_insert" value="1" <?php if(isset($insert[0])){ if($insert[0] =='1') {?>checked=checked <?php } } ?>>

								<input type="hidden" class="checkbox" name="assign_transferred_leads_insert1" value="0">

							</td>

							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								

							</td>

							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								

							</td>

						</tr>

						

						<tr>

							<td>2.</td>

							<td>Transfer Lead 

							<input type="hidden" name="form_transfer_lead"   value="Transfer Lead">

							<input type="hidden" name="controller_transfer_lead"   value="request_lead_transfer">

							</td>

							<td><input type="checkbox" class="checkbox pull-right " name="request_lead_transfer_view" value="1" <?php if(isset($view[1])){ if($view[1] =='1') {?>checked=checked <?php } } ?>>

								<input type="hidden" class="checkbox" name="request_lead_transfer_view1" value="0">

							</td>

							<td><input type="checkbox" class="checkbox1 pull-right" name="request_lead_transfer_insert" value="1" <?php if(isset($insert[1])){ if($insert[1] =='1') {?>checked=checked <?php } } ?>>

								<input type="hidden" class="checkbox" name="request_lead_transfer_insert1" value="0">

							</td>

							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">								

							</td>

							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">								

							</td>

						</tr>
-->
						<tr>

							<td>1.</td>

							<td>Add Follow Up 

							<input type="hidden" name="form_follow_up"   value="Add Follow Up">

							<input type="hidden" name="controller_follow_up"   value="add_followup">

							</td>

							

							<td><input type="checkbox" class="checkbox pull-right" name="add_followup_view" value="1" <?php if(isset($view[0])){ if($view[0] =='1') {?>checked=checked <?php } } ?>>

								<input type="hidden" name="add_followup_view1"   value="0">

							</td>

							<td><input type="checkbox" class="checkbox1 pull-right" name="add_followup_insert" value="1" <?php if(isset($insert[0])){ if($insert[0] =='1') {?>checked=checked <?php }  } ?>>

								<input type="hidden" name="add_followup_insert1"   value="0">

							</td>

							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">								

							</td>

							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							

							</td>

						</tr>
						
						
						<tr>

							<td>2.</td>

							<td>Update payment details 

							<input type="hidden" name="form_update_payment_details"   value="Update payment details">

							<input type="hidden" name="controller_update_payment_details"   value="update_payment_details">

							</td>

							

							<td><input type="checkbox" class="checkbox pull-right" name="update_payment_details_view" value="1" <?php if(isset($view[1])){ if($view[1] =='1') {?>checked=checked <?php } } ?>>

								<input type="hidden" name="update_payment_details_view1"   value="0">

							</td>

							<td><input type="checkbox" class="checkbox1 pull-right" name="update_payment_details_insert" value="1" <?php if(isset($insert[1])){ if($insert[1] =='1') {?>checked=checked <?php }  } ?>>

								<input type="hidden" name="update_payment_details_insert1"   value="0">

							</td>

							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">								

							</td>

							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							

							</td>

						</tr>
						
						
						
						<!--
						<tr>

							<td>5.</td>

							<td>Add Appointment 

							<input type="hidden" name="form_add_appointment"   value="Add Appointment">

							<input type="hidden" name="controller_add_appointment"   value="add_appointment">

							</td>

							

							<td><input type="checkbox" class="checkbox pull-right" name="add_appointment_view" value="1" <?php if(isset($view[4])){ if($view[4] =='1') {?>checked=checked <?php } } ?>>

								<input type="hidden" name="add_appointment_view1"   value="0">

							</td>

							<td><input type="checkbox" class="checkbox1 pull-right" name="add_appointment_insert" value="1" <?php if(isset($insert[4])){ if($insert[4] =='1') {?>checked=checked <?php }  } ?>>

								<input type="hidden" name="add_appointment_insert1"   value="0">

							</td>

							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">								

							</td>

							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							

							</td>

						</tr>
						
						
						
						
						<tr>

							<td>6.</td>

							<td>Add Escalation 

							<input type="hidden" name="form_add_escalation"   value="Add Escalation">

							<input type="hidden" name="controller_add_escalation"   value="add_escalation">

							</td>

							

							<td><input type="checkbox" class="checkbox pull-right" name="add_escalation_view" value="1" <?php if(isset($view[5])){ if($view[5] =='1') {?>checked=checked <?php } } ?>>

								<input type="hidden" name="add_escalation_view1"   value="0">

							</td>

							<td><input type="checkbox" class="checkbox1 pull-right" name="add_escalation_insert" value="1" <?php if(isset($insert[5])){ if($insert[5] =='1') {?>checked=checked <?php }  } ?>>

								<input type="hidden" name="add_escalation_insert1"   value="0">

							</td>

							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">								

							</td>

							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							

							</td>

						</tr>
						
						
						
						
						<tr>

							<td>7.</td>

							<td>Resolve Escalation 

							<input type="hidden" name="form_resolve_escalation"   value="Resolve Escalation">

							<input type="hidden" name="controller_resolve_escalation"   value="resolve_escalation">

							</td>

							

							<td><input type="checkbox" class="checkbox pull-right" name="resolve_escalation_view" value="1" <?php if(isset($view[6])){ if($view[6] =='1') {?>checked=checked <?php } } ?>>

								<input type="hidden" name="resolve_escalation_view1"   value="0">

							</td>

							<td><input type="checkbox" class="checkbox1 pull-right" name="resolve_escalation_insert" value="1" <?php if(isset($insert[6])){ if($insert[6] =='1') {?>checked=checked <?php }  } ?>>

								<input type="hidden" name="resolve_escalation_insert1"   value="0">

							</td>

							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">								

							</td>

							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							

							</td>

						</tr>

						

						<tr>

							<td>8.</td>

							<td>Add Auditor Remark 

							<input type="hidden" name="form_manager_remark"   value="Add Manager Remark">

							<input type="hidden" name="controller_manager_remark"   value="add_manager_remark">

							</td>

							

							<td><input type="checkbox" class="checkbox pull-right" name="manager_remark_view" value="1" <?php if(isset($view[7])){ if($view[7] =='1') {?>checked=checked <?php } } ?>>

								<input type="hidden" name="manager_remark_view1"   value="0">

							</td>

							<td><input type="checkbox" class="checkbox1 pull-right" name="manager_remark_insert" value="1" <?php if(isset($insert[7])){ if($insert[7] =='1') {?>checked=checked <?php } } ?>>

								<input type="hidden" name="manager_remark_insert1"   value="0">

							</td>

							<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">							

							</td>

							<td><input type="checkbox" class="checkbox3 pull-right"  disabled value="0">							

							</td>

						</tr>
						
						-->

						<tr>

							<td>3.</td>

							<td>Tracker 

							<input type="hidden" name="form_tracker"   value="Tracker">

							<input type="hidden" name="controller_tracker"  value="tracker/team_leader_leads">

							</td>

							<td><input type="checkbox" class="checkbox pull-right " name="all_tracker_view" value="1" <?php if(isset($view[2])){ if($view[2] =='1') {?>checked=checked <?php } } ?>>

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

							<td>4.</td>

							<td>Download Lead Tracker  

								<input type="hidden" name="form_download"   value="Download Lead Tracker">

							<input type="hidden" name="controller_download"   value="download_lead_tracker">

							</td>

							<td><input type="checkbox" class="checkbox pull-right " name="download_lead_tracker_view" value="1" <?php if(isset($view[3])){ if($view[3] =='1') {?>checked=checked <?php } } ?>>

								<input type="hidden" class="checkbox" name="download_lead_tracker_view1" value="0">

							</td>

							<td><input type="checkbox" class="checkbox1 pull-right"  disabled value="0">

							</td>

							<td><input type="checkbox" class="checkbox2 pull-right"  disabled value="0">

							</td>

							<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">

							</td>

						</tr>

						

						</tbody>

						</table>
						</div>
												<div class="col-md-12" style="margin-top:20px;">
								<div class="form-group">
									<div class="col-md-2" >
										
										<label class="control-label " for="first-name">Copy User Rights From:</label>
									</div>
                                    <div class="col-md-3" >
             					<select type="text" class="form-control" id="cpypocTright" name="cpypocTright" ><span class="glyphicon">&#xe252;</span>
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
                                        
                                        <button  class="btn btn-info" type="button" onClick="return cpypocTRights();"><i class="entypo-search"></i>  </button>        
										
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
						




<!--------------------------------------------------------  ------------------------------------------------------------------------------>

