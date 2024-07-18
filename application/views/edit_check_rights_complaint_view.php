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
							//echo count($select_right_data) ;
							foreach ($select_right_data as $fetch) {
								$view[] = $fetch -> view;
								$insert[] = $fetch -> insert;
								$modify[] = $fetch -> modify;
								$delete[] = $fetch -> delete;
							}
						?>
							<input type="hidden" name="user_name"   value="<?php echo $select_right_data[0] -> id; ?> ">
						
						
						
							
					
						
						<tr>
							<td>1</td>
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="cnew_lead_view" value="1" <?php if(isset($view[0])){ if($view[0] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="cnew_lead_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="cnew_lead_insert" value="1" <?php if(isset($insert[0])){ if($insert[0] =='1') {?>checked=checked <?php } } ?>>
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
							<td><input type="checkbox" class="checkbox pull-right " name="cassign_leads_view" value="1" <?php if(isset($view[1])){ if($view[1] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" class="checkbox" name="cassign_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="cassign_leads_insert" value="1" <?php if(isset($insert[1])){ if($insert[1] =='1') {?>checked=checked <?php } } ?>>
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="cadd_followup_view" value="1" <?php if(isset($view[2])){ if($view[2] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="cadd_followup_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="cadd_followup_insert" value="1" <?php if(isset($insert[2])){ if($insert[2] =='1') {?>checked=checked <?php } } ?>>
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
							
							<td><input type="checkbox" class="checkbox pull-right" name="cmanager_remark_view" value="1" <?php if(isset($view[3])){ if($view[3] =='1') {?>checked=checked <?php } } ?>>
								<input type="hidden" name="cmanager_remark_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" name="cmanager_remark_insert" value="1" <?php if(isset($insert[3])){ if($insert[3] =='1') {?>checked=checked <?php } } ?>>
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
							<td><input type="checkbox" class="checkbox pull-right " name="call_tracker_view" value="1" <?php if(isset($view[4])){ if($view[4] =='1') {?>checked=checked <?php } } ?>>
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
							<td><input type="checkbox" class="checkbox pull-right " name="cdownload_lead_tracker_view" value="1" <?php if(isset($view[5])){ if($view[5] =='1') {?>checked=checked <?php }} ?>>
							
								<input type="hidden" class="checkbox" name="cdownload_lead_tracker_view1" value="0">
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