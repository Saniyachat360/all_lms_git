<input type="hidden" value="<?php echo $username; ?>" name="username" id="username" />
<div class="table-responsive">

	<table class="table table-bordered datatable">
		<thead>  
			<tr>
				<th>Sr No.</th>
				<th>Module</th>
				<th>View <input type="checkbox" name="view" class="pull-right" value="1" id="select_all" onclick="select_checkbox()"></th>
				<th>Insert<input type="checkbox" name="view" class="pull-right" value="1" id="select_all1" onclick="select_checkbox1()"></th>
				<th>Modify <input type="checkbox" name="view" class="pull-right" value="1" id="select_all2" onclick="select_checkbox2()"></th>
				<th>Delete<input type="checkbox" name="view" class="pull-right" value="1" id="select_all3" onclick="select_checkbox3()"></th>
			</tr>
		</thead>
		<tbody>
			<tr> 
				<td>1</td>
				<td><b>New Car</b>
				</td>
				<td colspan='4'>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>1. Sourcewise Report
					<input type="hidden" name="form_sourcewise_report" value="sourcewise report">
					<input type="hidden" name="controller_sourcewise_report" value="sourcewise_report">
				</td>
				<td>
				    <input type="checkbox" class="checkbox pull-right" name="sourcewise_report_view" value="1">
					<input type="hidden" name="sourcewise_report_view1" value="0">
				</td>
				<td>
				    <input type="checkbox" class="checkbox1 pull-right" name="sourcewise_report_insert" value="1">
					<input type="hidden" name="sourcewise_report_insert1" value="0">
				</td>

				<td>
				    <input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td>
				    <input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>2. CSE Productivity Report
					<input type="hidden" name="form_cse_productivity_report" value="cse productivity report">
					<input type="hidden" name="controller_cse_productivity_report" value="cse_productivity_report">
				</td>
				<td>
				    <input type="checkbox" class="checkbox pull-right" name="cse_productivity_report_view" value="1">
					<input type="hidden" class="checkbox" name="cse_productivity_report_view1" value="0">
				</td>
				<td>
				    <input type="checkbox" class="checkbox1 pull-right" name="cse_productivity_report_insert" value="1">
					<input type="hidden" class="checkbox1" name="cse_productivity_report_insert1" value="0">
				</td>
				<td>
				    <input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td>
				    <input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>3. CSE Performance Report
					<input type="hidden" name="form_cse_performance_report" value="cse performance report">
					<input type="hidden" name="controller_cse_performance_report" value="cse_performance_report">
				</td>
				<td>
				    <input type="checkbox" class="checkbox pull-right" name="cse_performance_report_view" value="1">
					<input type="hidden" class="checkbox" name="cse_performance_report_view1" value="0">
				</td>
				<td>
				    <input type="checkbox" class="checkbox1 pull-right" name="cse_performance_report_insert" value="1">
					<input type="hidden" class="checkbox1" name="cse_performance_report_insert1" value="0">
				</td>
				<td>
				    <input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td>
				    <input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>4. Locationwise Report
					<input type="hidden" name="form_locationwise_report" value="locationwise report">
					<input type="hidden" name="controller_locationwise_report" value="locationwise_report">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="locationwise_report_view" value="1">
					<input type="hidden" class="checkbox" name="locationwise_report_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="locationwise_report_insert" value="1"> 
					<input type="hidden" class="checkbox" name="locationwise_report_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>5. Appointment Report
					<input type="hidden" name="form_appointment_report" value="appointment report">
					<input type="hidden" name="controller_appointment_report" value="appointment_report">
				</td>  
				<td><input type="checkbox" class="checkbox pull-right " name="appointment_report_view" value="1">
					<input type="hidden" class="checkbox" name="appointment_report_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="appointment_report_insert" value="1">
					<input type="hidden" class="checkbox" name="appointment_report_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>6. DSE Productivity Report
					<input type="hidden" name="form_dse_productivity_report" value="dse productivity report">
					<input type="hidden" name="controller_dse_productivity_report" value="dse_productivity_report">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="dse_productivity_report_view" value="1">
					<input type="hidden" class="checkbox" name="dse_productivity_report_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="dse_productivity_report_insert" value="1">
					<input type="hidden" class="checkbox" name="dse_productivity_report_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>7. DSE Performance Report
					<input type="hidden" name="form_dse_performance_report" value="dse performance report">
					<input type="hidden" name="controller_dse_performance_report" value="dse_performance_report">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="dse_performance_report_view" value="1">
					<input type="hidden" class="checkbox" name="dse_performance_report_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="dse_performance_report_insert" value="1">
					<input type="hidden" class="checkbox" name="dse_performance_report_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>8. One Pager Report
					<input type="hidden" name="form_one_pager_report" value="one pager report">
					<input type="hidden" name="controller_one_pager_report" value="map_one_pager_report">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="one_pager_report_view" value="1">
					<input type="hidden" class="checkbox" name="one_pager_report_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="one_pager_report_insert" value="1">
					<input type="hidden" class="checkbox" name="one_pager_report_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>9. Add DSE Daily reporting
					<input type="hidden" name="form_add_dse_daily_reporting" value="add dse daily reporting">
					<input type="hidden" name="controller_add_dse_daily_reporting" value="add_dse_daily_reporting">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="add_dse_daily_reporting_view" value="1">
					<input type="hidden" class="checkbox" name="add_dse_daily_reporting_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="add_dse_daily_reporting_insert" value="1">
					<input type="hidden" class="checkbox" name="add_dse_daily_reporting_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>10. View DSE daily reporting
					<input type="hidden" name="form_view_dse_daily_reporting" value="view dse daily reporting">
					<input type="hidden" name="controller_view_dse_daily_reporting" value="view_dse_daily_reporting">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="send_message_to_dse_view" value="1">
					<input type="hidden" class="checkbox" name="send_message_to_dse_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="send_message_to_dse_insert" value="1">
					<input type="hidden" class="checkbox" name="send_message_to_dse_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>

			<tr>
				<td></td>
				<td>11. View Break Time reporting
					<input type="hidden" name="form_view_break_time_reporting" value="view break time reporting">
					<input type="hidden" name="controller_view_break_time_reporting" value="view_break_time_reporting">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="break_time_view" value="1">
					<input type="hidden" class="checkbox" name="break_time_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="break_time_insert" value="1">
					<input type="hidden" class="checkbox" name="break_time_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>


			<tr>
				<td></td>
				<td>12. View Login Logout reporting
					<input type="hidden" name="form_login_logout_reporting" value="view login logout reporting">
					<input type="hidden" name="controller_view_login_logout_reporting" value="view_login_logout_reporting">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="login_logout_view" value="1">
					<input type="hidden" class="checkbox" name="login_logout_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="login_logout_insert" value="1">
					<input type="hidden" class="checkbox" name="login_logout_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>


			<tr>

				<td>2</td>
				<td><b>POC Sales</b>
				</td>
				<td colspan='4'>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>1. Sourcewise Report
					<input type="hidden" name="pform_sourcewise_report" value="sourcewise report">
					<input type="hidden" name="pcontroller_sourcewise_report" value="psourcewise_report">
				</td>
				<td><input type="checkbox" class="checkbox pull-right" name="psourcewise_report_view" value="1">
					<input type="hidden" name="psourcewise_report_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="psourcewise_report_insert" value="1">
					<input type="hidden" name="psourcewise_report_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>2. CSE Productivity Report
					<input type="hidden" name="pform_cse_productivity_report" value="cse productivity report ">
					<input type="hidden" name="pcontroller_cse_productivity_report" value="assign_leads">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="pcse_productivity_report_view" value="1">
					<input type="hidden" class="checkbox" name="pcse_productivity_report_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="pcse_productivity_report_insert" value="1">
					<input type="hidden" class="checkbox" name="pcse_productivity_report_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>3. CSE Performance Report
					<input type="hidden" name="pform_cse_performance_report" value="cse performance report">
					<input type="hidden" name="pcontroller_cse_performance_report" value="pcse_performance_report">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="pcse_performance_report_view" value="1">
					<input type="hidden" class="checkbox" name="pcse_performance_report_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="pcse_performance_report_insert" value="1">
					<input type="hidden" class="checkbox" name="pcse_performance_report_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>4. Locationwise Report
					<input type="hidden" name="pform_locationwise_report" value="locationwise report">
					<input type="hidden" name="pcontroller_locationwise_report" value="plocationwise_report">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="plocationwise_report_view" value="1">
					<input type="hidden" class="checkbox" name="plocationwise_report_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="plocationwise_report_insert" value="1">
					<input type="hidden" class="checkbox" name="plocationwise_report_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>5. Appointment Report
					<input type="hidden" name="pform_appointment_report" value="appointment report">
					<input type="hidden" name="pcontroller_appointment_report" value="pappointment_report">
				</td>

				<td><input type="checkbox" class="checkbox pull-right" name="pappointment_report_view" value="1">
					<input type="hidden" name="pappointment_report_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="pappointment_report_insert" value="1">
					<input type="hidden" name="pappointment_report_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>6. DSE Productivity Report
					<input type="hidden" name="pform_dse_productivity_report" value="dse productivity report">
					<input type="hidden" name="pcontroller_dse_productivity_report" value="pdse_productivity_report">
				</td>

				<td><input type="checkbox" class="checkbox pull-right" name="pdse_productivity_report_view" value="1">
					<input type="hidden" name="pdse_productivity_report_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="pdse_productivity_report_insert" value="1">
					<input type="hidden" name="pdse_productivity_report_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>7. DSE Performance Report
					<input type="hidden" name="pform_dse_performance_report" value="dse performance report">
					<input type="hidden" name="pcontroller_dse_performance_report" value="pdse_performance_report">
				</td>

				<td><input type="checkbox" class="checkbox pull-right" name="pdse_performance_report_view" value="1">
					<input type="hidden" name="pdse_performance_report_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="pdse_performance_report_insert" value="1">
					<input type="hidden" name="pdse_performance_report_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>8. One Pager Report
					<input type="hidden" name="pform_one_pager_report" value="one pager report">
					<input type="hidden" name="pcontroller_one_pager_report" value="pone_pager_report">
				</td>

				<td><input type="checkbox" class="checkbox pull-right" name="pone_pager_report_view" value="1">
					<input type="hidden" name="pone_pager_report_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="pone_pager_report_insert" value="1">
					<input type="hidden" name="pone_pager_report_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>

			<tr>
				<td></td>
				<td>9. Add DSE Daily reporting
					<input type="hidden" name="pform_add_dse_daily_reporting" value="add dse daily reporting">
					<input type="hidden" name="pcontroller_add_dse_daily_reporting" value="padd_dse_daily_reporting">
				</td>

				<td><input type="checkbox" class="checkbox pull-right" name="padd_dse_daily_reporting_view" value="1">
					<input type="hidden" name="padd_dse_daily_reporting_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="padd_dse_daily_reporting_insert" value="1">
					<input type="hidden" name="padd_dse_daily_reporting_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>10. View DSE daily reporting
					<input type="hidden" name="pform_view_dse_daily_reporting" value="view dse daily reporting">
					<input type="hidden" name="pcontroller_view_dse_daily_reporting" value="pview_dse_daily_reporting">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="psend_message_to_dse_view" value="1">
					<input type="hidden" name="psend_message_to_dse_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="psend_message_to_dse_insert" value="1">
					<input type="hidden" name="psend_message_to_dse_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>

			<tr>
				<td></td>
				<td>11. View Break Time reporting
					<input type="hidden" name="pform_view_break_time_reporting" value="view break time reporting">
					<input type="hidden" name="pcontroller_view_break_time_reporting" value="pview_break_time_reporting">
				</td>
				<td><input type="checkbox" class="checkbox pull-right" name="pbreak_time_view" value="1">
					<input type="hidden" name="pbreak_time_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="pbreak_time_insert" value="1">
					<input type="hidden" name="pbreak_time_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>

			<tr>
				<td></td>
				<td>12. View Login Logout reporting
					<input type="hidden" name="pform_login_logout_reporting" value="view login logout reporting">
					<input type="hidden" name="pcontroller_view_login_logout_reporting" value="pview_login_logout_reporting">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="plogin_logout_view" value="1">
					<input type="hidden" name="plogin_logout_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="plogin_logout_insert" value="1">
					<input type="hidden" name="plogin_logout_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>


			<td>3</td>
			<td><b>POC Purchase</b>
			</td>
			<td colspan='4'>
			</td>
			</tr>
			<tr>
				<td></td>
				<td>1. Sourcewise Report
					<input type="hidden" name="cform_sourcewise_report" value="sourcewise report">
					<input type="hidden" name="ccontroller_sourcewise_report" value="csourcewise_report">
				</td>
				<td><input type="checkbox" class="checkbox pull-right" name="csourcewise_report_view" value="1">
					<input type="hidden" name="csourcewise_report_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="csourcewise_report_insert" value="1">
					<input type="hidden" name="csourcewise_report_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>2. CSE Productivity Report
					<input type="hidden" name="cform_cse_productivity_report" value="cse productivity report ">
					<input type="hidden" name="ccontroller_cse_productivity_report" value="cassign_leads">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="ccse_productivity_report_view" value="1">
					<input type="hidden" class="checkbox" name="ccse_productivity_report_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="ccse_productivity_report_insert" value="1">
					<input type="hidden" class="checkbox" name="ccse_productivity_report_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>3. CSE Performance Report
					<input type="hidden" name="cform_cse_performance_report" value="cse performance report">
					<input type="hidden" name="ccontroller_cse_performance_report" value="ccse_performance_report">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="ccse_performance_report_view" value="1">
					<input type="hidden" class="checkbox" name="ccse_performance_report_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="ccse_performance_report_insert" value="1">
					<input type="hidden" class="checkbox" name="ccse_performance_report_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>4. Locationwise Report
					<input type="hidden" name="cform_locationwise_report" value="locationwise report">
					<input type="hidden" name="ccontroller_locationwise_report" value="clocationwise_report">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="clocationwise_report_view" value="1">
					<input type="hidden" class="checkbox" name="clocationwise_report_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="clocationwise_report_insert" value="1">
					<input type="hidden" class="checkbox" name="clocationwise_report_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>5. Appointment Report
					<input type="hidden" name="cform_appointment_report" value="appointment report">
					<input type="hidden" name="ccontroller_appointment_report" value="cappointment_report">
				</td>

				<td><input type="checkbox" class="checkbox pull-right" name="cappointment_report_view" value="1">
					<input type="hidden" name="cappointment_report_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="cappointment_report_insert" value="1">
					<input type="hidden" name="cappointment_report_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>6. DSE Productivity Report
					<input type="hidden" name="cform_dse_productivity_report" value="dse productivity report">
					<input type="hidden" name="ccontroller_dse_productivity_report" value="cdse_productivity_report">
				</td>

				<td><input type="checkbox" class="checkbox pull-right" name="cdse_productivity_report_view" value="1">
					<input type="hidden" name="cdse_productivity_report_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="cdse_productivity_report_insert" value="1">
					<input type="hidden" name="cdse_productivity_report_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>7. DSE Performance Report
					<input type="hidden" name="cform_dse_performance_report" value="dse performance report">
					<input type="hidden" name="ccontroller_dse_performance_report" value="cdse_performance_report">
				</td>

				<td><input type="checkbox" class="checkbox pull-right" name="cdse_performance_report_view" value="1">
					<input type="hidden" name="cdse_performance_report_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="cdse_performance_report_insert" value="1">
					<input type="hidden" name="cdse_performance_report_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>8. One Pager Report
					<input type="hidden" name="cform_one_pager_report" value="one pager report">
					<input type="hidden" name="ccontroller_one_pager_report" value="cone_pager_report">
				</td>

				<td><input type="checkbox" class="checkbox pull-right" name="cone_pager_report_view" value="1">
					<input type="hidden" name="cone_pager_report_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="cone_pager_report_insert" value="1">
					<input type="hidden" name="cone_pager_report_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>

			<tr>
				<td></td>
				<td>9. Add DSE Daily reporting
					<input type="hidden" name="cform_add_dse_daily_reporting" value="add dse daily reporting">
					<input type="hidden" name="ccontroller_add_dse_daily_reporting" value="cadd_dse_daily_reporting">
				</td>

				<td><input type="checkbox" class="checkbox pull-right" name="cadd_dse_daily_reporting_view" value="1">
					<input type="hidden" name="cadd_dse_daily_reporting_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="cadd_dse_daily_reporting_insert" value="1">
					<input type="hidden" name="cadd_dse_daily_reporting_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>10. View DSE daily reporting
					<input type="hidden" name="cform_view_dse_daily_reporting" value="view dse daily reporting">
					<input type="hidden" name="ccontroller_view_dse_daily_reporting" value="cview_dse_daily_reporting">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="csend_message_to_dse_view" value="1">
					<input type="hidden" name="csend_message_to_dse_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="csend_message_to_dse_insert" value="1">
					<input type="hidden" name="csend_message_to_dse_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>

			<tr>
				<td></td>
				<td>11. View Break Time reporting
					<input type="hidden" name="cform_view_break_time_reporting" value="view break time reporting">
					<input type="hidden" name="ccontroller_view_break_time_reporting" value="cview_break_time_reporting">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="cbreak_time_view" value="1">
					<input type="hidden" name="cbreak_time_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="cbreak_time_insert" value="1">
					<input type="hidden" name="cbreak_time_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>

			<tr>
				<td></td>
				<td>12. View Login Logout reporting
					<input type="hidden" name="cform_login_logout_reporting" value="view login logout reporting">
					<input type="hidden" name="ccontroller_view_login_logout_reporting" value="cview_login_logout_reporting">
				</td>
				<td><input type="checkbox" class="checkbox pull-right " name="clogin_logout_view" value="1">
					<input type="hidden" name="clogin_logout_view1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox1 pull-right" name="clogin_logout_insert" value="1">
					<input type="hidden" name="clogin_logout_insert1" value="0">
				</td>
				<td><input type="checkbox" class="checkbox2 pull-right" disabled value="0">
				</td>
				<td><input type="checkbox" class="checkbox3 pull-right" disabled value="0">
				</td>
			</tr>




		</tbody>
	</table>
</div>
<div class="col-md-12" style="margin-top:20px;">
	<div class="form-group">
		<div class="col-md-2">

			<label class="control-label " for="first-name">Copy User Rights Report From:</label>
		</div>
		<div class="col-md-3">
			<select type="text" class="form-control" id="cpyright" name="cpyright"><span class="glyphicon">&#xe252;</span>
				<option value=""> Select User</option>
				<?php

				foreach ($copy_user_rights as $row5) {
				?>
					<option value="<?php echo $row5->id; ?>"><?php echo $row5->fname . ' ' . $row5->lname; ?></option>

				<?php } ?>
			</select>



		</div>

		<div class="col-md-2" style="margin-bottom: 20px">

			<!--<div class="pull-middle  ">-->

			<button class="btn btn-info" type="button" onClick="return copyRights();"><i class="entypo-search"></i> </button>

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