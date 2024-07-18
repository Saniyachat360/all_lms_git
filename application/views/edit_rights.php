<script>
	function select_checkbox() {

		var select_all = document.getElementById("select_all");
		//select all checkbox
		var checkboxes = document.getElementsByClassName("checkbox");
		//checkbox items
		//select all checkboxes
		select_all.addEventListener("change", function(e) {
			for ( i = 0; i < checkboxes.length; i++) {
				checkboxes[i].checked = select_all.checked;
			}
		});
		for (var i = 0; i < checkboxes.length; i++) {
			checkboxes[i].addEventListener('change', function(e) {//".checkbox" change
				//uncheck "select all", if one of the listed checkbox item is unchecked
				if (this.checked == false) {
					select_all.checked = false;
				}
				//check "select all" if all checkbox items are checked
				if (document.querySelectorAll('.checkbox:checked').length == checkboxes.length) {
					select_all.checked = true;
				}
			});
		}
	}

	function select_checkbox1() {

		var select_all = document.getElementById("select_all1");
		//select all checkbox
		var checkboxes = document.getElementsByClassName("checkbox1");
		//checkbox items
		//select all checkboxes
		select_all.addEventListener("change", function(e) {
			for ( i = 0; i < checkboxes.length; i++) {
				checkboxes[i].checked = select_all.checked;
			}
		});
		for (var i = 0; i < checkboxes.length; i++) {
			checkboxes[i].addEventListener('change', function(e) {//".checkbox" change
				//uncheck "select all", if one of the listed checkbox item is unchecked
				if (this.checked == false) {
					select_all.checked = false;
				}
				//check "select all" if all checkbox items are checked
				if (document.querySelectorAll('.checkbox:checked').length == checkboxes.length) {
					select_all.checked = true;
				}
			});
		}
	}

	function select_checkbox2() {

		var select_all = document.getElementById("select_all2");
		//select all checkbox
		var checkboxes = document.getElementsByClassName("checkbox2");
		//checkbox items
		//select all checkboxes
		select_all.addEventListener("change", function(e) {
			for ( i = 0; i < checkboxes.length; i++) {
				checkboxes[i].checked = select_all.checked;
			}
		});
		for (var i = 0; i < checkboxes.length; i++) {
			checkboxes[i].addEventListener('change', function(e) {//".checkbox" change
				//uncheck "select all", if one of the listed checkbox item is unchecked
				if (this.checked == false) {
					select_all.checked = false;
				}
				//check "select all" if all checkbox items are checked
				if (document.querySelectorAll('.checkbox:checked').length == checkboxes.length) {
					select_all.checked = true;
				}
			});
		}
	}

	function select_checkbox3() {

		var select_all = document.getElementById("select_all3");
		//select all checkbox
		var checkboxes = document.getElementsByClassName("checkbox3");
		//checkbox items
		//select all checkboxes
		select_all.addEventListener("change", function(e) {
			for ( i = 0; i < checkboxes.length; i++) {
				checkboxes[i].checked = select_all.checked;
			}
		});
		for (var i = 0; i < checkboxes.length; i++) {
			checkboxes[i].addEventListener('change', function(e) {//".checkbox" change
				//uncheck "select all", if one of the listed checkbox item is unchecked
				if (this.checked == false) {
					select_all.checked = false;
				}
				//check "select all" if all checkbox items are checked
				if (document.querySelectorAll('.checkbox:checked').length == checkboxes.length) {
					select_all.checked = true;
				}
			});
		}
	}
</script>
<!--<ol class="breadcrumb bc-3" >
		<li>
			<a href="dashboard.php"><i class="fa fa-home"></i>Home</a>
		</li>
		<li class="active">
			<strong>Add Department</strong>
		</li>
</ol>-->
<div class="col-md-12">
<?php echo $this -> session -> flashdata('message'); ?>
</div>
<div class="row" >

<h1 style="text-align:center; ">Edit Rights</h1>
	<div class="col-md-12" >
			<div class="panel panel-primary">
				<div class="panel-body">
					<form action="<?php echo $var; ?>" method="post">
						<div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
							<div class="col-md-12">
								<div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">User Name: </label>
										<div class="col-md-5 col-sm-5 col-xs-12">
											 <label class="control-label col-md-6 col-sm-6 col-xs-12" for="first-name"><?php echo $select_right_data[0] -> fname . ' ' . $select_right_data[0] -> lname; ?></label>
                                         </div>
                                    </div>
                                </div>
							</div><br><br><br>
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
							//print_r($select_right_data) ;
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
							<td>Add Location 
							<input type="hidden" name="form_location"   value="Add Location">
							<input type="hidden" name="controller_location"   value="add_location">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" <?php if($view[0] =='1') {?>checked=checked <?php } ?> name="add_location_view" value="1">
								<input type="hidden" name="add_location_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" <?php if($insert[0] =='1') {?>checked=checked <?php } ?>  name="add_location_insert" value="1">
								<input type="hidden" name="add_location_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" <?php if($modify[0] =='1') {?>checked=checked <?php } ?> name="add_location_modify" value="1">
								<input type="hidden" name="add_location_modify1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" <?php if($delete[0] =='1') {?>checked=checked <?php } ?> name="add_location_delete" value="1">
								<input type="hidden" name="add_location_delete1"   value="0">
							</td>
						</tr>
						<tr>
							<td>2</td>
							<td>Add User 
								<input type="hidden" name="form_user"   value="Add User">
							<input type="hidden" name="controller_user"   value="add_lms_user">
							</td>
							<td><input type="checkbox" class="checkbox pull-right" <?php if($view[2] =='1') {?>checked=checked <?php } ?> name="add_new_user_view" value="1">
								<input type="hidden" class="checkbox" name="add_new_user_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" <?php if($insert[2] =='1') {?>checked=checked <?php } ?> name="add_new_user_insert" value="1">
								<input type="hidden" class="checkbox1" name="add_new_user_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" <?php if($modify[2] =='1') {?>checked=checked <?php } ?> name="add_new_user_modify" value="1">
								<input type="hidden" class="checkbox2" name="add_new_user_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" <?php if($delete[2] =='1') {?>checked=checked <?php } ?> name="add_new_user_delete" value="1">
								<input type="hidden" class="checkbox3" name="add_new_user_delete1" value="0">
							</td>
						</tr>
						<tr>
							<td>3</td>
							<td>Add group 
								<input type="hidden" name="form_group"   value="Add Group ">
							<input type="hidden" name="controller_group"   value="add_group">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " <?php if($view[3] =='1') {?>checked=checked <?php } ?> name="add_group_view" value="1">
								<input type="hidden" class="checkbox" name="add_group_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" <?php if($insert[3] =='1') {?>checked=checked <?php } ?> name="add_group_insert" value="1">
								<input type="hidden" class="checkbox" name="add_group_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" <?php if($modify[3] =='1') {?>checked=checked <?php } ?> name="add_group_modify" value="1">
								<input type="hidden" class="checkbox2" name="add_group_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" <?php if($delete[3] =='1') {?>checked=checked <?php } ?> name="add_group_delete" value="1">
								<input type="hidden" class="checkbox3" name="add_group_delete1" value="0">
							</td>
						</tr>
							<tr>
							<td>4</td>
							<td>Add Campaign 
								<input type="hidden" name="form_campaign"   value="Add Campaign">
							<input type="hidden" name="controller_campaign"   value="add_campaign">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " <?php if($view[5] =='1') {?>checked=checked <?php } ?> name="add_campaign_view" value="1">
								<input type="hidden" class="checkbox" name="add_campaign_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" <?php if($insert[5] =='1') {?>checked=checked <?php } ?> name="add_campaign_insert" value="1">
								<input type="hidden" class="checkbox" name="add_campaign_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" <?php if($modify[5] =='1') {?>checked=checked <?php } ?> name="add_campaign_modify" value="1">
								<input type="hidden" class="checkbox2" name="add_campaign_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" <?php if($delete[5] =='1') {?>checked=checked <?php } ?> name="add_campaign_delete" value="1">
								<input type="hidden" class="checkbox3" name="add_campaign_delete1" value="0">
							</td>
						</tr>
						<tr>
							<td>5</td>
							<td>Add Status 
								<input type="hidden" name="form_status"   value="Add Status">
							<input type="hidden" name="controller_status"   value="add_status">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " <?php if($view[6] =='1') {?>checked=checked <?php } ?> name="add_status_view" value="1">
								<input type="hidden" class="checkbox" name="add_status_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" <?php if($insert[6] =='1') {?>checked=checked <?php } ?> name="add_status_insert" value="1">
								<input type="hidden" class="checkbox" name="add_status_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" <?php if($modify[6] =='1') {?>checked=checked <?php } ?> name="add_status_modify" value="1">
								<input type="hidden" class="checkbox2" name="add_campaign_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" <?php if($delete[6] =='1') {?>checked=checked <?php } ?> name="add_status_delete" value="1">
								<input type="hidden" class="checkbox3" name="add_status_delete1" value="0">
							</td>
						</tr>
							<tr>
							<td>6</td>
							<td>Add Disposition 
								<input type="hidden" name="form_disposition"   value="Add Disposition">
							<input type="hidden" name="controller_disposition"   value="add_disposition">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " <?php if($view[7] =='1') {?>checked=checked <?php } ?> name="add_disposition_view" value="1">
								<input type="hidden" class="checkbox" name="add_disposition_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" <?php if($insert[7] =='1') {?>checked=checked <?php } ?> name="add_disposition_insert" value="1">
								<input type="hidden" class="checkbox" name="add_disposition_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" <?php if($modify[7] =='1') {?>checked=checked <?php } ?> name="add_disposition_modify" value="1">
								<input type="hidden" class="checkbox2" name="add_disposition_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" <?php if($delete[7] =='1') {?>checked=checked <?php } ?> name="add_disposition_delete" value="1">
								<input type="hidden" class="checkbox3" name="add_disposition_delete1" value="0">
							</td>
						</tr>
						<tr>
							<td>7</td>
							<td>Add Rights
								<input type="hidden" name="form_right"   value="Add Rights">
							<input type="hidden" name="controller_right"   value="add_right">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " <?php if($view[8] =='1') {?>checked=checked <?php } ?> name="add_right_view" value="1">
								<input type="hidden" class="checkbox" name="add_right_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" <?php if($insert[8] =='1') {?>checked=checked <?php } ?> name="add_right_insert" value="1">
								<input type="hidden" class="checkbox" name="add_right_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" <?php if($modify[8] =='1') {?>checked=checked <?php } ?> name="add_right_modify" value="1">
								<input type="hidden" class="checkbox2" name="add_right_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" <?php if($delete[8] =='1') {?>checked=checked <?php } ?> name="add_right_delete" value="1">
								<input type="hidden" class="checkbox3" name="add_right_delete1" value="0">
							</td>
						</tr>
						<tr>
							
							<td>8</td>
							<td>Add New Lead 
							<input type="hidden" name="form_new_lead"   value="Add New Lead">
							<input type="hidden" name="controller_new_lead"   value="add_new_customer">
							</td>
							
							<td>
								
								<input type="checkbox" class="checkbox pull-right"<?php if($view[1] =='1') {?>checked=checked <?php } ?> name="new_lead_view" value="1">
								<input type="hidden" name="new_lead_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" <?php if($insert[1] =='1') {?>checked=checked <?php } ?> name="new_lead_insert" value="1">
								<input type="hidden" name="new_lead_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" <?php if($modify[1] =='1') {?>checked=checked <?php } ?> name="new_lead_modify" value="1">
								<input type="hidden" name="new_lead_modify1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" <?php if($delete[1] =='1') {?>checked=checked <?php } ?> name="new_lead_delete" value="1">
								<input type="hidden" name="new_lead_delete1"   value="0">
							</td>
						</tr>
						
						
						<tr>
							<td>9</td>
							<td>Assign Lead 
								<input type="hidden" name="form_assign_lead"   value="Assign Lead ">
							<input type="hidden" name="controller_assign_lead"   value="assign_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " <?php if($view[4] =='1') {?>checked=checked <?php } ?> name="assign_leads_view" value="1">
								<input type="hidden" class="checkbox" name="assign_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" <?php if($insert[4] =='1') {?>checked=checked <?php } ?> name="assign_leads_insert" value="1">
								<input type="hidden" class="checkbox" name="assign_leads_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" <?php if($modify[4] =='1') {?>checked=checked <?php } ?> name="assign_leads_modify" value="1">
								<input type="hidden" class="checkbox2" name="assign_leads_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" <?php if($delete[4] =='1') {?>checked=checked <?php } ?> name="assign_leads_delete" value="1">
								<input type="hidden" class="checkbox3" name="assign_leads_delete1" value="0">
							</td>
						</tr>
					<tr>
							<td>10</td>
							<td>Add Follow Up 
							<input type="hidden" name="form_follow_up"   value="Add Follow Up">
							<input type="hidden" name="controller_follow_up"   value="add_followup">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" <?php if($view[9] =='1') {?>checked=checked <?php } ?> name="add_followup_view" value="1">
								<input type="hidden" name="add_followup_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" <?php if($insert[9] =='1') {?>checked=checked <?php } ?> name="add_followup_insert" value="1">
								<input type="hidden" name="add_followup_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" <?php if($modify[9] =='1') {?>checked=checked <?php } ?> name="add_followup_modify" value="1">
								<input type="hidden" name="add_followup_modify1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" <?php if($delete[9] =='1') {?>checked=checked <?php } ?> name="add_followup_delete" value="1">
								<input type="hidden" name="add_followup_delete1"   value="0">
							</td>
						</tr>
						<tr>
							<td>11</td>
							<td>Add Manager Remark 
							<input type="hidden" name="form_manager_remark"   value="Add Manager Remark">
							<input type="hidden" name="controller_manager_remark"   value="add_manager_remark">
							</td>
							
							<td><input type="checkbox" class="checkbox pull-right" <?php if($view[10] =='1') {?>checked=checked <?php } ?> name="manager_remark_view" value="1">
								<input type="hidden" name="manager_remark_view1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" <?php if($insert[10] =='1') {?>checked=checked <?php } ?> name="manager_remark_insert" value="1">
								<input type="hidden" name="manager_remark_insert1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" <?php if($modify[10] =='1') {?>checked=checked <?php } ?> name="manager_remark_modify" value="1">
								<input type="hidden" name="manager_remark_modify1"   value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right" <?php if($delete[10] =='1') {?>checked=checked <?php } ?> name="manager_remark_delete" value="1">
								<input type="hidden" name="manager_remark_delete1"   value="0">
							</td>
						</tr>
						<tr>
							<td>12</td>
							<td>Transfer Lead 
							<input type="hidden" name="form_transfer_lead"   value="Transfer Lead">
							<input type="hidden" name="controller_transfer_lead"   value="request_lead_transfer">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " <?php if($view[12] =='1') {?>checked=checked <?php } ?> name="request_lead_transfer_view" value="1">
								<input type="hidden" class="checkbox" name="request_lead_transfer_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" <?php if($insert[12] =='1') {?>checked=checked <?php } ?> name="request_lead_transfer_insert" value="1">
								<input type="hidden" class="checkbox" name="request_lead_transfer_insert1" value="0">
							</td>
							<td><!--<input type="checkbox" class="checkbox2 pull-right" name="request_lead_transfer_modify" value="1">-->
								<input type="hidden" class="checkbox2" name="request_lead_transfer_modify1" value="0">
							</td>
							<td><!--<input type="checkbox" class="checkbox3 pull-right" name="request_lead_transfer_delete" value="1">-->
								<input type="hidden" class="checkbox3" name="request_lead_transfer_delete1" value="0">
							</td>
						</tr>
					
						<tr>
							<td>13</td>
							<td>Upload Lead 
							<input type="hidden" name="form_upload_lead"   value="Upload Lead">
							<input type="hidden" name="controller_upload_lead"   value="upload_xls">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " <?php if($view[11] =='1') {?>checked=checked <?php } ?> name="upload_xls_view" value="1">
								<input type="hidden" class="checkbox" name="upload_xls_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" <?php if($insert[11] =='1') {?>checked=checked <?php } ?> name="upload_xls_insert" value="1">
								<input type="hidden" class="checkbox" name="upload_xls_insert1" value="0">
							</td>
							<td><!--<input type="checkbox" class="checkbox2 pull-right" name="upload_xls_modify" value="1">-->
								<input type="hidden" class="checkbox2" name="upload_xls_modify1" value="0">
							</td>
							<td><!--<input type="checkbox" class="checkbox3 pull-right" name="upload_xls_delete" value="1">-->
								<input type="hidden" class="checkbox3" name="upload_xls_delete1" value="0">
							</td>
						</tr>
						
							
					
						<tr>
							<td>14</td>
							<td> Tracker 
							<input type="hidden" name="form_tracker"   value="Tracker">
							<input type="hidden" name="controller_tracker"   value="tracker/team_leader_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " <?php if($view[13] =='1') {?>checked=checked <?php } ?> name="all_tracker_view" value="1">
								<input type="hidden" class="checkbox" name="all_tracker_view1" value="0">
							</td>
							<td><!--<input type="checkbox" class="checkbox1 pull-right" name="all_tracker_insert" value="1">-->
								<input type="hidden" class="checkbox" name="all_tracker_insert1" value="0">
							</td>
							<td><!--<input type="checkbox" class="checkbox2 pull-right" name="all_tracker_modify" value="1">-->
								<input type="hidden" class="checkbox2" name="all_tracker_modify1" value="0">
							</td>
							<td><!--<input type="checkbox" class="checkbox3 pull-right" name="all_tracker_delete" value="1">-->
								<input type="hidden" class="checkbox3" name="all_tracker_delete1" value="0">
							</td>
						</tr>
						
						<tr>
							<td>15</td>
							<td>Transferred leads 
							<input type="hidden" name="form_transferred"   value="Transferred Leads">
							<input type="hidden" name="controller_transferred"   value="request_lead_transfer">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " <?php if($view[14] =='1') {?>checked=checked <?php } ?> name="transferred_leads_view" value="1">
								<input type="hidden" class="checkbox" name="cse_tracker_view1" value="0">
							</td>
							<td><!--<input type="checkbox" class="checkbox1 pull-right" name="transferred_leads_insert" value="1">-->
								<input type="hidden" class="checkbox" name="transferred_leads_insert1" value="0">
							</td>
							<td><!--<input type="checkbox" class="checkbox2 pull-right" name="transferred_leads_modify" value="1">-->
								<input type="hidden" class="checkbox2" name="transferred_leads_modify1" value="0">
							</td>
							<td><!--<input type="checkbox" class="checkbox3 pull-right" name="transferred_leads_delete" value="1">-->
								<input type="hidden" class="checkbox3" name="transferred_leads_delete1" value="0">
							</td>
						</tr>
						<tr>
						
							<td>16</td>
							<td>Calling Notification 
							<input type="hidden" name="calling_notification"   value="Calling Notification">
							<input type="hidden" name="controller_calling_notification"   value="">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " <?php if(isset($view[15])){
							 if($view[15] =='1') {?>checked=checked <?php }}?> name="calling_notification_view" value="1">
								<input type="hidden" class="checkbox" name="calling_notification_view1" value="0">
							</td>
							<td><!--<input type="checkbox" class="checkbox1 pull-right" name="transferred_leads_insert" value="1">-->
								<input type="hidden" class="checkbox" name="calling_notification_insert1" value="0">
							</td>
							<td><!--<input type="checkbox" class="checkbox2 pull-right" name="transferred_leads_modify" value="1">-->
								<input type="hidden" class="checkbox2" name="calling_notification_modify1" value="0">
							</td>
							<td><!--<input type="checkbox" class="checkbox3 pull-right" name="transferred_leads_delete" value="1">-->
								<input type="hidden" class="checkbox3" name="calling_notification_delete1" value="0">
							</td>
						</tr>
					
						<tr>
							<td>17</td>
							<td>Add SMS 
								<input type="hidden" name="form_sms"   value="Add SMS ">
							<input type="hidden" name="controller_sms"   value="add_sms">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " <?php if(isset($view[16])){ if($view[16] =='1') {?>checked=checked <?php } } ?> name="add_sms_view" value="1">
								<input type="hidden" class="checkbox" name="add_sms_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" <?php if(isset($insert[16])){ if($insert[16] =='1') {?>checked=checked <?php } } ?> name="add_sms_insert" value="1">
								<input type="hidden" class="checkbox" name="add_sms_insert1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox2 pull-right" <?php if(isset($modify[16])){ if($modify[16] =='1') {?>checked=checked <?php } } ?> name="add_sms_modify" value="1">
								<input type="hidden" class="checkbox2" name="add_sms_modify1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox3 pull-right"<?php if(isset($delete[16])){ if($delete[16] =='1') {?>checked=checked <?php  } } ?>  name="add_sms_delete" value="1">
								<input type="hidden" class="checkbox3" name="add_sms_delete1" value="0">
							</td>
						</tr>
						
						
						
							<tr>
							<td>18</td>
							<td>Assign transferred leads 
									<input type="hidden" name="form_assign"   value="Assign transferred leads">
							<input type="hidden" name="controller_assign"   value="assign_transferred_leads">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " <?php if(isset($view[17])){ if($view[17] =='1') {?>checked=checked <?php } } ?> name="assign_transferred_leads_view" value="1">
								<input type="hidden" class="checkbox" name="assign_transferred_leads_view1" value="0">
							</td>
							<td><input type="checkbox" class="checkbox1 pull-right" <?php if(isset($insert[17])){ if($insert[17] =='1') {?>checked=checked <?php } } ?> name="assign_transferred_leads_insert" value="1">
								<input type="hidden" class="checkbox" name="assign_transferred_leads_insert1" value="0">
							</td>
							<td><!--<input type="checkbox" class="checkbox2 pull-right" <?php if(isset($modify[17])){ if($modify[17] =='1') {?>checked=checked <?php } } ?> name="assign_transferred_leads_modify" value="1">-->
								<input type="hidden" class="checkbox2" name="assign_transferred_leads_modify1" value="0">
							</td>
							<td><!--<input type="checkbox" class="checkbox3 pull-right"<?php if(isset($delete[17])){ if($delete[17] =='1') {?>checked=checked <?php  } } ?>  name="assign_transferred_leads_delete" value="1">-->
								<input type="hidden" class="checkbox3" name="assign_transferred_leads_delete1" value="0">
							</td>
						</tr>
					
					
					
							<tr>
							<td>19</td>
							<td>Download Lead Tracker  
									<input type="hidden" name="form_download"   value="Download Lead Tracker">
							<input type="hidden" name="controller_download"   value="download_lead_tracker">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " <?php if(isset($view[18])){ if($view[18] =='1') {?>checked=checked <?php } } ?> name="download_lead_tracker_view" value="1">
								<input type="hidden" class="checkbox" name="download_lead_tracker_view1" value="0">
							</td>
							<td><!--<input type="checkbox" class="checkbox1 pull-right" <?php if(isset($insert[18])){ if($insert[18] =='1') {?>checked=checked <?php } } ?> name="download_lead_tracker_insert" value="1">-->
								<input type="hidden" class="checkbox" name="download_lead_tracker_insert1" value="0">
							</td>
							<td><!--<input type="checkbox" class="checkbox2 pull-right" <?php if(isset($modify[18])){ if($modify[18] =='1') {?>checked=checked <?php } } ?> name="download_lead_tracker_modify" value="1">-->
								<input type="hidden" class="checkbox2" name="download_lead_tracker_modify1" value="0">
							</td>
							<td><!--<input type="checkbox" class="checkbox3 pull-right"<?php if(isset($delete[18])){ if($delete[18] =='1') {?>checked=checked <?php  } } ?>  name="download_lead_tracker_delete" value="1">-->
								<input type="hidden" class="checkbox3" name="download_lead_tracker_delete1" value="0">
							</td>
						</tr>
						<tr>
							<td>20</td>
							<td>	Send message to DSE
									<input type="hidden" name="form_download"   value="Download Lead Tracker">
							<input type="hidden" name="controller_download"   value="download_lead_tracker">
							</td>
							<td><input type="checkbox" class="checkbox pull-right " <?php if(isset($view[18])){ if($view[18] =='1') {?>checked=checked <?php } } ?> name="download_lead_tracker_view" value="1">
								<input type="hidden" class="checkbox" name="download_lead_tracker_view1" value="0">
							</td>
							<td><!--<input type="checkbox" class="checkbox1 pull-right" <?php if(isset($insert[18])){ if($insert[18] =='1') {?>checked=checked <?php } } ?> name="download_lead_tracker_insert" value="1">-->
								<input type="hidden" class="checkbox" name="download_lead_tracker_insert1" value="0">
							</td>
							<td><!--<input type="checkbox" class="checkbox2 pull-right" <?php if(isset($modify[18])){ if($modify[18] =='1') {?>checked=checked <?php } } ?> name="download_lead_tracker_modify" value="1">-->
								<input type="hidden" class="checkbox2" name="download_lead_tracker_modify1" value="0">
							</td>
							<td><!--<input type="checkbox" class="checkbox3 pull-right"<?php if(isset($delete[18])){ if($delete[18] =='1') {?>checked=checked <?php  } } ?>  name="download_lead_tracker_delete" value="1">-->
								<input type="hidden" class="checkbox3" name="download_lead_tracker_delete1" value="0">
							</td>
						</tr>
				
						</tbody>
						</table>
						</div>
                     	<div class="form-group">
							<div class="col-md-2 col-md-offset-4">
								<button type="submit" class="btn btn-success col-md-12 col-xs-12 col-sm-12">Update</button>
							</div>
							<div class="col-md-2">
								<input type='reset' class="btn btn-primary col-md-12 col-xs-12 col-sm-12" value='Reset'>
							</div>
						</div>
					</div>
				</div>
			</div>
			

 
   </div>