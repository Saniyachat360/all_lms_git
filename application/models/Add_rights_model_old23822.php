<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class add_rights_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->process_id=$this->session->userdata('process_id');
		$this->user_id=$this->session->userdata('user_id');
	}
	function checkUserRights()
	{
		if ($_SESSION['role'] != 1) {
			//$process_id = $_SESSION['process_id'];
			$user_id = $_SESSION['user_id'];
			$this -> db -> select('g.group_id');
			$this -> db -> from('tbl_group g');
			$this -> db -> join('tbl_user_group u', 'u.group_id=g.group_id');
			$this -> db -> where('u.user_id', $user_id);		
			$query1 = $this -> db -> get() -> result();
			$c = count($query1);
			if (count($query1) > 0) {
				$t = ' ( ';
				for ($i = 0; $i < $c; $i++) {
					if ($i == 0) {
						
							$t = $t . "group_id = '" . $query1[$i] -> group_id . "'";
						
					} else {
						$t = $t . " or group_id ='" . $query1[$i] -> group_id . "'";
					}
				}
				$st = $t . ')';

			}
		 return $st; 
		}
	}
	public function select_user() {
			$st = $this -> checkUserRights();
			$query=$this->db->query("select user_id from tbl_rights group by user_id");
			$query1_result = $query->result();
 		 $id= array();
  		foreach($query1_result as $row){
     		$id[] = $row->user_id;
   			}
 			 $id1 = implode(",",$id);
  			$ids = explode(",", $id1);
		$this -> db -> select('*');
		$this -> db -> from('lmsuser l');
		$this -> db -> join('tbl_user_group u', 'u.user_id=l.id');
		
		$this -> db -> where('status', '1');
	
		$this->db->where_not_in('l.id', $ids);
		if($_SESSION['role'] !=1)
		{
			$this -> db -> where('role !=',1);
			//$this -> db -> where('process_id',$_SESSION['process_id']);
			$this -> db -> where($st);
		}
		
		$this->db->group_by('u.user_id');
		$this->db->order_by('l.fname','asc');
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
	public function select_rights_user() {
		$this -> db -> select('l.*,r.form_name');
		$this -> db -> from('lmsuser l');
		$this -> db -> join('tbl_rights r','r.user_id=l.id','left');
		$this -> db -> where('status', '1');
		if($_SESSION['role'] !=1)
		{
			$this -> db -> where('role !=',1);
			$this -> db -> where('process_id',$_SESSION['process_id']);
		}
		$this->db->group_by('r.user_id');
		$query = $this -> db -> get();
		return $query -> result();
			/*,'fform_new_lead', 'fform_assign_lead','fform_assign','fform_transfer_lead','fform_follow_up', 'fform_manager_remark','fform_tracker', 'fform_download'*/
							
	}
	public function insert_right()
	{
		$user_id = $this -> input -> post('username');
		$qy = $this -> db -> query("delete from tbl_rights where user_id='$user_id'");
		$qy = $this -> db -> query("delete from tbl_rights_financem where user_id='$user_id'");
			$fform_data_array = array('fform_login_status','fform_reject_reason','fform_document','fform_script','fform_scheme','fform_emp_type','fform_prof_type');						
		$fview_data_array = array('flogin_status_view','freject_reason_view','fdocument_view','fscript_view','fscheme_view','femp_type_view','fprof_type_view');
		$fview_data_array1 = array('flogin_status_view1','freject_reason_view1','fdocument_view1','fscript_view1','fscheme_view1','femp_type_view1','fprof_type_view1');
		$finsert_data_array = array('flogin_status_insert','freject_reason_insert','fdocument_insert','fscript_insert','fscheme_insert','femp_type_insert','fprof_type_insert');
		$finsert_data_array1 = array('flogin_status_insert1','freject_reason_insert1','fdocument_insert1','fscript_insert1','fscheme_insert1','femp_type_insert1','fprof_type_insert1');
			$fmodify_data_array = array('flogin_status_modify','freject_reason_modify','fdocument_modify','fscript_modify','fscheme_modify','femp_type_modify','fprof_type_modify');
		$fmodify_data_array1 = array('flogin_status_modify1','freject_reason_modify1','fdocument_modify1','fscript_modify1','fscheme_modify1','femp_type_modify1','fprof_type_modify1');	
		$fdelete_data_array = array('flogin_status_delete','freject_reason_delete','fdocument_delete','fscript_delete','fscheme_delete','femp_type_delete','fprof_type_delete');
		$fdelete_data_array1 = array('flogin_status_delete1','freject_reason_delete1','fdocument_delete1','fscript_delete1','fscheme_delete1','femp_type_delete1','fprof_type_delete1');	
			$date=date('Y-m-d');
			$updated_by_id=$_SESSION['user_id'];
			$cheright=0;
		$fform_count = count($fform_data_array);
			for ($i = 0; $i < $fform_count; $i++) {
				//Form
				$fform_array[] = $this -> input -> post($fform_data_array[$i]);
				//View
				if (($this -> input -> post($fview_data_array[$i])) == '') {
					$fview_array[] = $this -> input -> post($fview_data_array1[$i]);
				} else {
					$fview_array[] = $this -> input -> post($fview_data_array[$i]);
					$cheright=1;
				}
				//Insert
				if (($this -> input -> post($finsert_data_array[$i])) == '') {
					$finsert_array[] = $this -> input -> post($finsert_data_array1[$i]);
				} else {
					$finsert_array[] = $this -> input -> post($finsert_data_array[$i]);
					$cheright=1;
				}
				//Modify
				if (($this -> input -> post($fmodify_data_array[$i])) == '') {
					$fmodify_array[] = $this -> input -> post($fmodify_data_array1[$i]);
				} else {
					$fmodify_array[] = $this -> input -> post($fmodify_data_array[$i]);
				}
				//Delete
				if (($this -> input -> post($fdelete_data_array[$i])) == '') {
					$fdelete_array[] = $this -> input -> post($fdelete_data_array1[$i]);
				} else {
					$fdelete_array[] = $this -> input -> post($fdelete_data_array[$i]);
				}
			}
			if($cheright==1){
			for ($i = 0; $i < $fform_count; $i++) {
			$query = $this -> db -> query("INSERT INTO `tbl_rights_financem`(`user_id`, `form_name`,`view`, `insert`, `modify`, `delete`,`updated_date`,`updated_by_id`)
			VALUES ('$user_id','$fform_array[$i]','$fview_array[$i]','$finsert_array[$i]','$fmodify_array[$i]','$fdelete_array[$i]','$date','$updated_by_id')");
			echo $this->db->last_query();
			}
			}
		
		$form_data_array = array('form_location', 'form_new_lead', 'form_user', 'form_map_process', 'form_assign_lead', 'form_lead_source', 'form_status', 'form_next_action', 'form_right', 'form_follow_up', 'form_manager_remark', 'form_upload_lead', 'form_transfer_lead', 'form_tracker', 'form_map_next_action','calling_notification','form_dashboard','form_assign','form_download'
								,'form_download_user_details','form_upload_quotation','form_call_center_tl'
								,'uform_new_lead', 'uform_assign_lead','uform_assign','uform_transfer_lead','uform_follow_up', 'uform_manager_remark','uform_tracker', 'uform_download','uform_upload_stock','uform_check_stock'
								,'fform_new_lead', 'fform_assign_lead','fform_assign','fform_transfer_lead','fform_follow_up', 'fform_manager_remark','fform_tracker', 'fform_download'
								,'sform_new_lead', 'sform_assign_lead','sform_assign','sform_transfer_lead','sform_follow_up', 'sform_manager_remark','sform_tracker', 'sform_download'
								,'aform_new_lead', 'aform_assign_lead','aform_assign','aform_transfer_lead','aform_follow_up', 'aform_manager_remark','aform_tracker', 'aform_download'
								,'form_search_customer','form_edit_customer','form_call_center_transfer','uform_call_center_transfer','eform_call_center_transfer','form_lead_report','form_add_sms'
								,'form_send_message_to_dse','form_add_dse_daily_report','form_view_dse_daily_report','form_upload_stock','form_check_stock'
								,'eform_new_lead','eform_assign_lead', 'eform_assign','eform_transfer_lead','eform_follow_up', 'eform_manager_remark','eform_tracker', 'eform_download'
								/*,'cform_new_lead','cform_assign_lead', 'cform_follow_up', 'cform_manager_remark','cform_tracker', 'cform_download'*/
								,'form_add_appointment','form_add_escalation','form_resolve_escalation','uform_add_appointment','uform_add_escalation','uform_resolve_escalation','eform_add_appointment','eform_add_escalation','eform_resolve_escalation'	
								);
		
										
		$view_data_array = array('add_location_view', 'new_lead_view', 'add_new_user_view', 'map_process_view', 'assign_leads_view','lead_source_view', 'add_status_view', 'next_action_view', 'add_right_view', 'add_followup_view', 'manager_remark_view', 'upload_xls_view', 'request_lead_transfer_view', 'all_tracker_view', 'map_next_action_view','calling_notification_view','dashboard_view','assign_transferred_leads_view','download_lead_tracker_view'
								,'download_user_details_view','upload_quotation_view','call_center_tl_view'
								,'unew_lead_view','uassign_leads_view','uassign_transferred_leads_view','urequest_lead_transfer_view','uadd_followup_view','umanager_remark_view', 'uall_tracker_view','udownload_lead_tracker_view','uupload_stock_view','ucheck_stock_view'
								,'fnew_lead_view','fassign_leads_view','fassign_transferred_leads_view','frequest_lead_transfer_view','fadd_followup_view','fmanager_remark_view', 'fall_tracker_view','fdownload_lead_tracker_view'
								,'snew_lead_view','sassign_leads_view','sassign_transferred_leads_view','srequest_lead_transfer_view','sadd_followup_view','smanager_remark_view', 'sall_tracker_view','sdownload_lead_tracker_view'
								,'anew_lead_view','aassign_leads_view','aassign_transferred_leads_view','arequest_lead_transfer_view','aadd_followup_view','amanager_remark_view', 'aall_tracker_view','adownload_lead_tracker_view'
								,'search_customer_view','edit_customer_view','call_center_transfer_view','ucall_center_transfer_view','ecall_center_transfer_view','lead_report_view','add_sms_view'
								,'send_message_to_dse_view','add_dse_daily_report_view','dse_daily_report_view','upload_stock_view','check_stock_view'
								,'enew_lead_view','eassign_leads_view','eassign_transferred_leads_view','erequest_lead_transfer_view','eadd_followup_view','emanager_remark_view', 'eall_tracker_view','edownload_lead_tracker_view'
								/*,'cnew_lead_view','cassign_leads_view','cadd_followup_view','cmanager_remark_view', 'call_tracker_view','cdownload_lead_tracker_view'*/
								,'add_appointment_view','add_escalation_view','resolve_escalation_view','uadd_appointment_view','uadd_escalation_view','uresolve_escalation_view','eadd_appointment_view','eadd_escalation_view','eresolve_escalation_view'
								);
	
		$view_data_array1 = array('add_location_view1', 'new_lead_view1', 'add_new_user_view1', 'map_process_view1', 'assign_leads_view1','lead_source_view1', 'add_status_view1', 'next_action_view1', 'add_right_view1', 'add_followup_view1', 'manager_remark_view1', 'upload_xls_view1', 'request_lead_transfer_view1', 'all_tracker_view1', 'map_next_action_view1','calling_notification_view1','dashboard_view1','assign_transferred_leads_view1','download_lead_tracker_view1'
								,'download_user_details_view1','upload_quotation_view1','call_center_tl_view1'
								,'unew_lead_view1','uassign_leads_view1','uassign_transferred_leads_view1','urequest_lead_transfer_view1','uadd_followup_view1','umanager_remark_view1', 'uall_tracker_view1','udownload_lead_tracker_view1','uupload_stock_view1','ucheck_stock_view1'
								,'fnew_lead_view1','fassign_leads_view1','fassign_transferred_leads_view1','frequest_lead_transfer_view1','fadd_followup_view1','fmanager_remark_view1', 'fall_tracker_view1','fdownload_lead_tracker_view1'
								,'snew_lead_view1','sassign_leads_view1','sassign_transferred_leads_view1','srequest_lead_transfer_view1','sadd_followup_view1','smanager_remark_view1', 'sall_tracker_view1','sdownload_lead_tracker_view1'
								,'anew_lead_view1','aassign_leads_view1','aassign_transferred_leads_view1','arequest_lead_transfer_view1','aadd_followup_view1','amanager_remark_view1', 'aall_tracker_view1','adownload_lead_tracker_view1'
								,'search_customer_view1','edit_customer_view1','call_center_transfer_view1','ucall_center_transfer_view1','ecall_center_transfer_view1','lead_report_view1','add_sms_view1'
								,'send_message_to_dse_view1','add_dse_daily_report_view1','dse_daily_report_view1','upload_stock_view1','check_stock_view1'
								,'enew_lead_view1','eassign_leads_view1','eassign_transferred_leads_view1','erequest_lead_transfer_view1','eadd_followup_view1','emanager_remark_view1', 'eall_tracker_view1','edownload_lead_tracker_view1'
								/*,'cnew_lead_view1','cassign_leads_view1','cadd_followup_view1','cmanager_remark_view1', 'call_tracker_view1','cdownload_lead_tracker_view1'*/
								,'add_appointment_view1','add_escalation_view1','resolve_escalation_view1','uadd_appointment_view1','uadd_escalation_view1','uresolve_escalation_view1','eadd_appointment_view1','eadd_escalation_view1','eresolve_escalation_view1'
								);		
								
		$insert_data_array = array('add_location_insert', 'new_lead_insert', 'add_new_user_insert', 'map_process_insert', 'assign_leads_insert', 'lead_source_insert', 'add_status_insert', 'next_action_insert', 'add_right_insert', 'add_followup_insert', 'manager_remark_insert', 'upload_xls_insert', 'request_lead_transfer_insert', 'all_tracker_insert', 'map_next_action_insert','calling_notification_insert','dashboard_insert','assign_transferred_leads_insert','download_lead_tracker_insert'
								,'download_user_details_insert','upload_quotation_insert','call_center_tl_insert'
								,'unew_lead_insert','uassign_leads_insert','uassign_transferred_leads_insert','urequest_lead_transfer_insert','uadd_followup_insert','umanager_remark_insert', 'uall_tracker_insert','udownload_lead_tracker_insert','uupload_stock_insert','ucheck_stock_insert'
								,'fnew_lead_insert','fassign_leads_insert','fassign_transferred_leads_insert','frequest_lead_transfer_insert','fadd_followup_insert','fmanager_remark_insert', 'fall_tracker_insert','fdownload_lead_tracker_insert'
								,'snew_lead_insert','sassign_leads_insert','sassign_transferred_leads_insert','srequest_lead_transfer_insert','sadd_followup_insert','smanager_remark_insert', 'sall_tracker_insert','sdownload_lead_tracker_insert'
								,'anew_lead_insert','aassign_leads_insert','aassign_transferred_leads_insert','arequest_lead_transfer_insert','aadd_followup_insert','amanager_remark_insert', 'aall_tracker_insert','adownload_lead_tracker_insert'
								,'search_customer_insert','edit_customer_insert','call_center_transfer_insert','ucall_center_transfer_insert','ecall_center_transfer_insert','lead_report_insert','add_sms_insert'
								,'send_message_to_dse_insert','add_dse_daily_report_insert','view_dse_daily_report_insert','upload_stock_insert','check_stock_insert'
								,'enew_lead_insert','eassign_leads_insert','eassign_transferred_leads_insert','erequest_lead_transfer_insert','eadd_followup_insert','emanager_remark_insert', 'eall_tracker_insert','edownload_lead_tracker_insert'
								/*,'cnew_lead_insert','cassign_leads_insert','cadd_followup_insert','cmanager_remark_insert', 'call_tracker_insert','cdownload_lead_tracker_insert'*/
								,'add_appointment_insert','add_escalation_insert','resolve_escalation_insert','uadd_appointment_insert','uadd_escalation_insert','uresolve_escalation_insert','eadd_appointment_insert','eadd_escalation_insert','eresolve_escalation_insert'
								);
								
								
		$insert_data_array1 = array('add_location_insert1', 'new_lead_insert1', 'add_new_user_insert1', 'map_process_insert1', 'assign_leads_insert1', 'lead_source_insert1', 'add_status_insert1', 'next_action_insert1', 'add_right_insert1', 'add_followup_insert1', 'manager_remark_insert1', 'upload_xls_insert1', 'request_lead_transfer_insert1', 'all_tracker_insert1', 'map_next_action_insert1','calling_notification_insert1','dashboard_insert1','assign_transferred_leads_insert1','download_lead_tracker_insert1'
								,'download_user_details_insert1','upload_quotation_insert1','call_center_tl_insert1'	
								,'unew_lead_insert1','uassign_leads_insert1','uassign_transferred_leads_insert1','urequest_lead_transfer_insert1','uadd_followup_insert1','umanager_remark_insert1', 'uall_tracker_insert1','udownload_lead_tracker_insert1','uupload_stock_insert1','ucheck_stock_insert1'
								,'fnew_lead_insert1','fassign_leads_insert1','fassign_transferred_leads_insert1','frequest_lead_transfer_insert1','fadd_followup_insert1','fmanager_remark_insert1', 'fall_tracker_insert1','fdownload_lead_tracker_insert1'
								,'snew_lead_insert1','sassign_leads_insert1','sassign_transferred_leads_insert1','srequest_lead_transfer_insert1','sadd_followup_insert1','smanager_remark_insert1', 'sall_tracker_insert1','sdownload_lead_tracker_insert1'
								,'anew_lead_insert1','aassign_leads_insert1','aassign_transferred_leads_insert1','arequest_lead_transfer_insert1','aadd_followup_insert1','amanager_remark_insert1', 'aall_tracker_insert1','adownload_lead_tracker_insert1'
								,'search_customer_insert1','edit_customer_insert1','call_center_transfer_insert1','ucall_center_transfer_insert1','ecall_center_transfer_insert1','lead_report_insert1','add_sms_insert1'
								,'send_message_to_dse_insert1','add_dse_daily_report_insert1','view_dse_daily_report_insert1','upload_stock_insert1','check_stock_insert1'
								,'enew_lead_insert1','eassign_leads_insert1','eassign_transferred_leads_insert1','erequest_lead_transfer_insert1','eadd_followup_insert1','emanager_remark_insert1', 'eall_tracker_insert1','edownload_lead_tracker_insert1'
								/*,'cnew_lead_insert1','cassign_leads_insert1','cadd_followup_insert1','cmanager_remark_insert1', 'call_tracker_insert1','cdownload_lead_tracker_insert1'*/
								,'add_appointment_insert1','add_escalation_insert1','resolve_escalation_insert1','uadd_appointment_insert1','uadd_escalation_insert1','uresolve_escalation_insert1','eadd_appointment_insert1','eadd_escalation_insert1','eresolve_escalation_insert1'
								);
									
		$modify_data_array = array('add_location_modify', 'new_lead_modify', 'add_new_user_modify', 'map_process_modify','assign_leads_modify', 'lead_source_modify', 'add_status_modify' ,'next_action_modify', 'add_right_modify', 'add_followup_modify', 'manager_remark_modify', 'upload_xls_modify', 'request_lead_transfer_modify', 'all_tracker_modify', 'map_next_action_modify','calling_notification_modify','dashboard_modify','assign_transferred_leads_modify','download_lead_tracker_modify'
								,'download_user_details_modify','upload_quotation_modify','call_center_tl_modify'
								,'unew_lead_modify','uassign_leads_modify','uassign_transferred_leads_modify','urequest_lead_transfer_modify','uadd_followup_modify','umanager_remark_modify', 'uall_tracker_modify','udownload_lead_tracker_modify','uupload_stock_modify','ucheck_stock_modify'
								,'fnew_lead_modify','fassign_leads_modify','fassign_transferred_leads_modify','frequest_lead_transfer_modify','fadd_followup_modify','fmanager_remark_modify', 'fall_tracker_modify','fdownload_lead_tracker_modify'
								,'snew_lead_modify','sassign_leads_modify','sassign_transferred_leads_modify','srequest_lead_transfer_modify','sadd_followup_modify','smanager_remark_modify', 'sall_tracker_modify','sdownload_lead_tracker_modify'
								,'anew_lead_modify','aassign_leads_modify','aassign_transferred_leads_modify','arequest_lead_transfer_modify','aadd_followup_modify','amanager_remark_modify', 'aall_tracker_modify','adownload_lead_tracker_modify'
								,'search_customer_modify','edit_customer_modify','call_center_transfer_modify','ucall_center_transfer_modify','ecall_center_transfer_modify','lead_report_modify','add_sms_modify'
								,'send_message_to_dse_modify','add_dse_daily_report_modify','view_dse_daily_report_modify','upload_stock_modify','check_stock_modify'
								,'enew_lead_modify','eassign_leads_modify','eassign_transferred_leads_modify','erequest_lead_transfer_modify','eadd_followup_modify','emanager_remark_modify', 'eall_tracker_modify','edownload_lead_tracker_modify'
								/*,'cnew_lead_modify','cassign_leads_modify','cadd_followup_modify','cmanager_remark_modify', 'call_tracker_modify','cdownload_lead_tracker_modify'*/
								,'add_appointment_modify','add_escalation_modify','resolve_escalation_modify','uadd_appointment_modify','uadd_escalation_modify','uresolve_escalation_modify','eadd_appointment_modify','eadd_escalation_modify','eresolve_escalation_modify'
								);
								
								
		$modify_data_array1 = array('add_location_modify1', 'new_lead_modify1', 'add_new_user_modify1', 'map_process_modify1','assign_leads_modify1', 'lead_source_modify1', 'add_status_modify1' ,'next_action_modify1', 'add_right_modify1', 'add_followup_modify1', 'manager_remark_modify1', 'upload_xls_modify1', 'request_lead_transfer_modify1', 'all_tracker_modify1', 'map_next_action_modify1','calling_notification_modify1','dashboard_modify1','assign_transferred_leads_modify1','download_lead_tracker_modify1'
								,'download_user_details_modify1','upload_quotation_modify1','call_center_tl_modify1'
								,'unew_lead_modify1','uassign_leads_modify1','uassign_transferred_leads_modify1','urequest_lead_transfer_modify1','uadd_followup_modify1','umanager_remark_modify1', 'uall_tracker_modify1','udownload_lead_tracker_modify1','uupload_stock_modify1','ucheck_stock_modify1'
								,'fnew_lead_modify1','fassign_leads_modify1','fassign_transferred_leads_modify1','frequest_lead_transfer_modify1','fadd_followup_modify1','fmanager_remark_modify1', 'fall_tracker_modify1','fdownload_lead_tracker_modify1'
								,'snew_lead_modify1','sassign_leads_modify1','sassign_transferred_leads_modify1','srequest_lead_transfer_modify1','sadd_followup_modify1','smanager_remark_modify1', 'sall_tracker_modify1','sdownload_lead_tracker_modify1'
								,'anew_lead_modify1','aassign_leads_modify1','aassign_transferred_leads_modify1','arequest_lead_transfer_modify1','aadd_followup_modify1','amanager_remark_modify1', 'aall_tracker_modify1','adownload_lead_tracker_modify1'
								,'search_customer_modify1','edit_customer_modify1','call_center_transfer_modify1','ucall_center_transfer_modify1','ecall_center_transfer_modify1','lead_report_modify1','add_sms_modify1'
								,'send_message_to_dse_modify1','add_dse_daily_report_modify1','view_dse_daily_report_modify1','upload_stock_modify1','check_stock_modify1'
								,'enew_lead_modify1','eassign_leads_modify1','eassign_transferred_leads_modify1','erequest_lead_transfer_modify1','eadd_followup_modify1','emanager_remark_modify1', 'eall_tracker_modify1','edownload_lead_tracker_modify1'
								/*,'cnew_lead_modify1','cassign_leads_modify1','cadd_followup_modify1','cmanager_remark_modify1', 'call_tracker_modify1','cdownload_lead_tracker_modify1'*/
								,'add_appointment_modify1','add_escalation_modify1','resolve_escalation_modify1','uadd_appointment_modify1','uadd_escalation_modify1','uresolve_escalation_modify1','eadd_appointment_modify1','eadd_escalation_modify1','eresolve_escalation_modify1'
								);
									
	
		$delete_data_array = array('add_location_delete', 'new_lead_delete', 'add_new_user_delete', 'map_process_delete', 'assign_leads_delete', 'lead_source_delete', 'add_status_delete', 'next_action_delete', 'add_right_delete', 'add_followup_delete', 'manager_remark_delete', 'upload_xls_delete', 'request_lead_transfer_delete', 'all_tracker_delete', 'map_next_action_delete','calling_notification_delete','dashboard_delete','assign_transferred_leads_delete','download_lead_tracker_delete'
								,'download_user_details_delete','upload_quotation_delete','call_center_tl_delete'
								,'unew_lead_delete','uassign_leads_delete','uassign_transferred_leads_delete','urequest_lead_transfer_delete','uadd_followup_delete','umanager_remark_delete', 'uall_tracker_delete','udownload_lead_tracker_delete','uupload_stock_delete','ucheck_stock_delete'
								,'fnew_lead_delete','fassign_leads_delete','fassign_transferred_leads_delete','frequest_lead_transfer_delete','fadd_followup_delete','fmanager_remark_delete', 'fall_tracker_delete','fdownload_lead_tracker_delete'
								,'snew_lead_delete','sassign_leads_delete','sassign_transferred_leads_delete','srequest_lead_transfer_delete','sadd_followup_delete','smanager_remark_delete', 'sall_tracker_delete','sdownload_lead_tracker_delete'
								,'anew_lead_delete','aassign_leads_delete','aassign_transferred_leads_delete','arequest_lead_transfer_delete','aadd_followup_delete','amanager_remark_delete', 'aall_tracker_delete','adownload_lead_tracker_delete'
								,'search_customer_delete','edit_customer_delete','call_center_transfer_delete','ucall_center_transfer_delete','ecall_center_transfer_delete','lead_report_delete','add_sms_delete'
								,'send_message_to_dse_delete','add_dse_daily_report_delete','view_dse_daily_report_delete','upload_stock_delete','check_stock_delete'
								,'enew_lead_delete','eassign_leads_delete','eassign_transferred_leads_delete','erequest_lead_transfer_delete','eadd_followup_delete','emanager_remark_delete', 'eall_tracker_delete','edownload_lead_tracker_delete'
								/*,'cnew_lead_delete','cassign_leads_delete','cadd_followup_delete','cmanager_remark_delete', 'call_tracker_delete','cdownload_lead_tracker_delete'*/
								,'add_appointment_delete','add_escalation_delete','resolve_escalation_delete','uadd_appointment_delete','uadd_escalation_delete','uresolve_escalation_delete','eadd_appointment_delete','eadd_escalation_delete','eresolve_escalation_delete'
								);
								
								
		$delete_data_array1 = array('add_location_delete1', 'new_lead_delete1', 'add_new_user_delete1', 'map_process_delete1', 'assign_leads_delete1', 'lead_source_delete1', 'add_status_delete1', 'next_action_delete1', 'add_right_delete1', 'add_followup_delete1', 'manager_remark_delete1', 'upload_xls_delete1', 'request_lead_transfer_delete1', 'all_tracker_delete1', 'map_next_action_delete1','calling_notification_delete1','dashboard_delete1','assign_transferred_leads_delete1','download_lead_tracker_delete1'
								,'download_user_details_delete1','upload_quotation_delete1','call_center_tl_delete1'
								,'unew_lead_delete1','uassign_leads_delete1','uassign_transferred_leads_delete1','urequest_lead_transfer_delete1','uadd_followup_delete1','umanager_remark_delete1', 'uall_tracker_delete1','udownload_lead_tracker_delete1','uupload_stock_delete1','ucheck_stock_delete1'
								,'fnew_lead_delete1','fassign_leads_delete1','fassign_transferred_leads_delete1','frequest_lead_transfer_delete1','fadd_followup_delete1','fmanager_remark_delete1', 'fall_tracker_delete1','fdownload_lead_tracker_delete1'
								,'snew_lead_delete1','sassign_leads_delete1','sassign_transferred_leads_delete1','srequest_lead_transfer_delete1','sadd_followup_delete1','smanager_remark_delete1', 'sall_tracker_delete1','sdownload_lead_tracker_delete1'
								,'anew_lead_delete1','aassign_leads_delete1','aassign_transferred_leads_delete1','arequest_lead_transfer_delete1','aadd_followup_delete1','amanager_remark_delete1', 'aall_tracker_delete1','adownload_lead_tracker_delete1'
								,'search_customer_delete1','edit_customer_delete1','call_center_transfer_delete1','ucall_center_transfer_delete1','ecall_center_transfer_delete1','lead_report_delete1','add_sms_delete1'
								,'send_message_to_dse_delete1','add_dse_daily_report_delete1','view_dse_daily_report_delete1','upload_stock_delete1','check_stock_delete1'
								,'enew_lead_delete1','eassign_leads_delete1','eassign_transferred_leads_delete1','erequest_lead_transfer_delete1','eadd_followup_delete1','emanager_remark_delete1', 'eall_tracker_delete1','edownload_lead_tracker_delete1'
								/*,'cnew_lead_delete1','cassign_leads_delete1','cadd_followup_delete1','cmanager_remark_delete1', 'call_tracker_delete1','cdownload_lead_tracker_delete1'*/
								,'add_appointment_delete1','add_escalation_delete1','resolve_escalation_delete1','uadd_appointment_delete1','uadd_escalation_delete1','uresolve_escalation_delete1','eadd_appointment_delete1','eadd_escalation_delete1','eresolve_escalation_delete1'
								);
				$process_array = array('0', '6', '0', '0', '6', '0', '0', '0', '0', '6', '6', '0'
										,'6', '6', '0','0','0','6','6','0','6','0'
										,'7', '7','7','7','7', '7','7', '7','7','7'
										,'1', '1','1','1','1', '1','1', '1'
										,'4', '4','4','4','4', '4','4', '4'
										,'5', '5','5','5','5', '5','5', '5'
										,'0','0','6','7','8','0','0'
											,'0','0','0','6','6'
										,'8', '8','8','8', '8','8', '8', '8'
										/*,'9', '9','9','9', '9','9'*/
										,'6','6','6','7','7','7','8','8','8'	
								);
										
		
		$form_count = count($form_data_array);
			for ($i = 0; $i < $form_count; $i++) {
				//Form
				$form_array[] = $this -> input -> post($form_data_array[$i]);
				//View
				if (($this -> input -> post($view_data_array[$i])) == '') {

					$view_array[] = $this -> input -> post($view_data_array1[$i]);
				} else {

					$view_array[] = $this -> input -> post($view_data_array[$i]);
				}
				//Insert
				if (($this -> input -> post($insert_data_array[$i])) == '') {

					$insert_array[] = $this -> input -> post($insert_data_array1[$i]);
				} else {

					$insert_array[] = $this -> input -> post($insert_data_array[$i]);
				}
				//Modify
				if (($this -> input -> post($modify_data_array[$i])) == '') {

					$modify_array[] = $this -> input -> post($modify_data_array1[$i]);
				} else {

					$modify_array[] = $this -> input -> post($modify_data_array[$i]);
				}
				//Delete
				if (($this -> input -> post($delete_data_array[$i])) == '') {

					$delete_array[] = $this -> input -> post($delete_data_array1[$i]);
				} else {

					$delete_array[] = $this -> input -> post($delete_data_array[$i]);
				}

			}
		
			for ($i = 0; $i < $form_count; $i++) {
			$query = $this -> db -> query("INSERT INTO `tbl_rights`(`user_id`, `form_name`,`view`, `insert`, `modify`, `delete`,`process_id`,`updated_date`,`updated_by_id`) VALUES ('$user_id','$form_array[$i]','$view_array[$i]','$insert_array[$i]','$modify_array[$i]','$delete_array[$i]','$process_array[$i]','$date','$updated_by_id')");
			echo $this->db->last_query();
			}
			if ($query) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Rights added Successfully ...!</strong>');

		} else {
			//$this -> db -> where('user_id', $user_id);
		
			
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Right Not added ...!</strong>');

		}
		
		
		
	}
	public function insert_right1() {
		echo $user_id = $this -> input -> post('username');
		$form_location = $this -> input -> post('form_location');
		$form_map_process = "Map process to location";
		$form_user = $this -> input -> post('form_user');
		$form_right = $this -> input -> post('form_right');
		$form_lead_source = "lead_source";
		$form_group = $this -> input -> post('form_group');
		$form_campaign = $this -> input -> post('form_campaign');
		$form_status = "Add Feedback Status";
		$form_next_action = $this -> input -> post('form_next_action');
		$form_map_next_action = "Map Next Action";
		$form_new_lead = $this -> input -> post('form_new_lead');
		$form_assign_lead = $this -> input -> post('form_assign_lead');
		$form_follow_up = $this -> input -> post('form_follow_up');
		$form_manager_remark = $this -> input -> post('form_manager_remark');
		$form_transfer_lead = $this -> input -> post('form_transfer_lead');
		$form_upload_lead = $this -> input -> post('form_upload_lead');
		$form_tracker = $this -> input -> post('form_tracker');
		$form_transferred = $this -> input -> post('form_transferred');
		$calling_notification = $this -> input -> post('calling_notification');
		
		$form_sms = $this -> input -> post('form_sms');
		$form_assign = $this -> input -> post('form_assign');
		$form_download = $this -> input -> post('form_download');
		
		/*$form_name12=$this->input->post('form_name12');
		 $form_name13=$this->input->post('form_name13');
		 $form_name14=$this->input->post('form_name14');*/
		$controller_location = $this -> input -> post('controller_location');
		$controller_map_process = "Link_process_location";
		$controller_user = $this -> input -> post('controller_user');
		$controller_right = $this -> input -> post('controller_right');
		$controller_lead_source = "lead_source";
		$controller_group = $this -> input -> post('controller_group');
		$controller_campaign = $this -> input -> post('controller_campaign');
		$controller_status = "feedback_status";
		$controller_next_action = $this -> input -> post('controller_next_action');
		$controller_map_next_action = "map_next_action_to_feedback";
		$controller_new_lead = $this -> input -> post('controller_new_lead');
		$controller_assign_lead = $this -> input -> post('controller_assign_lead');
		$controller_follow_up = $this -> input -> post('controller_follow_up');
		$controller_manager_remark = $this -> input -> post('controller_manager_remark');
		$controller_transfer_lead = $this -> input -> post('controller_transfer_lead');
		$controller_upload_lead = $this -> input -> post('controller_upload_lead');
		$controller_tracker = $this -> input -> post('controller_tracker');
		$controller_transferred = $this -> input -> post('controller_transferred');
		$controller_calling_notification = $this -> input -> post('controller_calling_notification');
		$controller_sms = $this -> input -> post('controller_sms');
		$controller_assign = $this -> input -> post('controller_assign');
		$controller_download = $this -> input -> post('controller_download');
		
		/*$controller_name13=$this->input->post('controller_name13');
		 $controller_name14=$this->input->post('controller_name14');*/
		if ($this -> input -> post('add_location_view') == '') {
			echo $add_location_view = $this -> input -> post('add_location_view1');
		} else {
			echo $add_location_view = $this -> input -> post('add_location_view');
		}
		if ($this -> input -> post('add_location_insert') == '') {
			echo $add_location_insert = $this -> input -> post('add_location_insert1');
		} else {
			echo $add_location_insert = $this -> input -> post('add_location_insert');
		}
		if ($this -> input -> post('add_location_modify') == '') {
			echo $add_location_modify = $this -> input -> post('add_location_modify1');
		} else {
			echo $add_location_modify = $this -> input -> post('add_location_modify');
		}
		if ($this -> input -> post('add_location_delete') == '') {
			echo $add_location_delete = $this -> input -> post('add_location_delete1');
		} else {
			echo $add_location_delete = $this -> input -> post('add_location_delete');
		}
		
		if ($this -> input -> post('map_process_view') == '') {
			echo $map_process_view = $this -> input -> post('map_process_view1');
		} else {
			echo $map_process_view = $this -> input -> post('map_process_view');
		}
		if ($this -> input -> post('map_process_insert') == '') {
			echo $map_process_insert = $this -> input -> post('map_process_insert1');
		} else {
			echo $map_process_insert = $this -> input -> post('map_process_insert');
		}
		if ($this -> input -> post('map_process_modify') == '') {
			echo $map_process_modify = $this -> input -> post('map_process_modify1');
		} else {
			echo $map_process_modify = $this -> input -> post('map_process_modify');
		}
		if ($this -> input -> post('map_process_delete') == '') {
			echo $map_process_delete = $this -> input -> post('map_process_delete1');
		} else {
			echo $map_process_delete = $this -> input -> post('map_process_delete');
		}
		
		if ($this -> input -> post('lead_source_view') == '') {
			echo $lead_source_view = $this -> input -> post('lead_source_view1');
		} else {
			echo $lead_source_view = $this -> input -> post('lead_source_view');
		}
		if ($this -> input -> post('lead_source_insert') == '') {
			echo $lead_source_insert = $this -> input -> post('lead_source_insert1');
		} else {
			echo $lead_source_insert = $this -> input -> post('lead_source_insert');
		}
		if ($this -> input -> post('lead_source_modify') == '') {
			echo $lead_source_modify = $this -> input -> post('lead_source_modify1');
		} else {
			echo $lead_source_modify = $this -> input -> post('lead_source_modify');
		}
		if ($this -> input -> post('lead_source_delete') == '') {
			echo $lead_source_delete = $this -> input -> post('lead_source_delete1');
		} else {
			echo $lead_source_delete = $this -> input -> post('lead_source_delete');
		}
		
		if ($this -> input -> post('manager_remark_view') == '') {
			echo $manager_remark_view = $this -> input -> post('manager_remark_view1');
		} else {
			echo $manager_remark_view = $this -> input -> post('manager_remark_view');
		}
		if ($this -> input -> post('manager_remark_insert') == '') {
			echo $manager_remark_insert = $this -> input -> post('manager_remark_insert1');
		} else {
			echo $manager_remark_insert = $this -> input -> post('manager_remark_insert');
		}
		if ($this -> input -> post('manager_remark_modify') == '') {
			echo $manager_remark_modify = $this -> input -> post('manager_remark_modify1');
		} else {
			echo $manager_remark_modify = $this -> input -> post('manager_remark_modify');
		}
		if ($this -> input -> post('manager_remark_delete') == '') {
			echo $manager_remark_delete = $this -> input -> post('manager_remark_delete1');
		} else {
			echo $manager_remark_delete = $this -> input -> post('manager_remark_delete');
		}

		if ($this -> input -> post('add_followup_view') == '') {
			echo $add_followup_view = $this -> input -> post('add_followup_view1');
		} else {
			echo $add_followup_view = $this -> input -> post('add_followup_view');
		}
		if ($this -> input -> post('add_followup_insert') == '') {
			echo $add_followup_insert = $this -> input -> post('add_followup_insert1');
		} else {
			echo $add_followup_insert = $this -> input -> post('add_followup_insert');
		}
		if ($this -> input -> post('add_followup_modify') == '') {
			echo $add_followup_modify = $this -> input -> post('add_followup_modify1');
		} else {
			echo $add_followup_modify = $this -> input -> post('add_followup_modify');
		}
		if ($this -> input -> post('add_followup_delete') == '') {
			echo $add_followup_delete = $this -> input -> post('add_followup_delete1');
		} else {
			echo $add_followup_delete = $this -> input -> post('add_followup_delete');
		}

		if ($this -> input -> post('add_right_view') == '') {
			echo $add_right_view = $this -> input -> post('add_right_view1');
		} else {
			echo $add_right_view = $this -> input -> post('add_right_view');
		}
		if ($this -> input -> post('add_right_insert') == '') {
			echo $add_right_insert = $this -> input -> post('add_right_insert1');
		} else {
			echo $add_right_insert = $this -> input -> post('add_right_insert');
		}
		if ($this -> input -> post('add_right_modify') == '') {
			echo $add_right_modify = $this -> input -> post('add_right_modify1');
		} else {
			echo $add_right_modify = $this -> input -> post('add_right_modify');
		}
		if ($this -> input -> post('add_right_delete') == '') {
			echo $add_right_delete = $this -> input -> post('add_right_delete1');
		} else {
			echo $add_right_delete = $this -> input -> post('add_right_delete');
		}

		if ($this -> input -> post('new_lead_view') == '') {
			echo $new_lead_view = $this -> input -> post('new_lead_view1');
		} else {
			echo $new_lead_view = $this -> input -> post('new_lead_view');
		}
		if ($this -> input -> post('new_lead_insert') == '') {
			echo $new_lead_insert = $this -> input -> post('new_lead_insert1');
		} else {
			echo $new_lead_insert = $this -> input -> post('new_lead_insert');
		}
		if ($this -> input -> post('new_lead_modify') == '') {
			echo $new_lead_modify = $this -> input -> post('new_lead_modify1');
		} else {
			echo $new_lead_modify = $this -> input -> post('new_lead_modify');
		}
		if ($this -> input -> post('new_lead_delete') == '') {
			echo $new_lead_delete = $this -> input -> post('new_lead_delete1');
		} else {
			echo $new_lead_delete = $this -> input -> post('new_lead_delete');
		}

		if ($this -> input -> post('add_new_user_view') == '') {
			echo $add_new_user_view = $this -> input -> post('add_new_user_view1');
		} else {
			echo $add_new_user_view = $this -> input -> post('add_new_user_view');
		}
		if ($this -> input -> post('add_new_user_insert') == '') {
			echo $add_new_user_insert = $this -> input -> post('add_new_user_insert1');
		} else {
			echo $add_new_user_insert = $this -> input -> post('add_new_user_insert');
		}
		if ($this -> input -> post('add_new_user_modify') == '') {
			echo $add_new_user_modify = $this -> input -> post('add_new_user_modify1');
		} else {
			echo $add_new_user_modify = $this -> input -> post('add_new_user_modify');
		}
		if ($this -> input -> post('add_new_user_delete') == '') {
			echo $add_new_user_delete = $this -> input -> post('add_new_user_delete1');
		} else {
			echo $add_new_user_delete = $this -> input -> post('add_new_user_delete');
		}

		if ($this -> input -> post('add_group_view') == '') {
			echo $add_group_view = $this -> input -> post('add_group_view1');
		} else {
			echo $add_group_view = $this -> input -> post('add_group_view');
		}
		if ($this -> input -> post('add_group_insert') == '') {
			echo $add_group_insert = $this -> input -> post('add_group_insert1');
		} else {
			echo $add_group_insert = $this -> input -> post('add_group_insert');
		}
		if ($this -> input -> post('add_group_modify') == '') {
			echo $add_group_modify = $this -> input -> post('add_group_modify1');
		} else {
			echo $add_group_modify = $this -> input -> post('add_group_modify');
		}
		if ($this -> input -> post('add_group_delete') == '') {
			echo $add_group_delete = $this -> input -> post('add_group_delete1');
		} else {
			echo $add_group_delete = $this -> input -> post('add_group_delete');
		}

		if ($this -> input -> post('assign_leads_view') == '') {
			echo $assign_leads_view = $this -> input -> post('assign_leads_view1');
		} else {
			echo $assign_leads_view = $this -> input -> post('assign_leads_view');
		}
		if ($this -> input -> post('assign_leads_insert') == '') {
			echo $assign_leads_insert = $this -> input -> post('assign_leads_insert1');
		} else {
			echo $assign_leads_insert = $this -> input -> post('assign_leads_insert');
		}
		if ($this -> input -> post('assign_leads_modify') == '') {
			echo $assign_leads_modify = $this -> input -> post('assign_leads_modify1');
		} else {
			echo $assign_leads_modify = $this -> input -> post('assign_leads_modify');
		}
		if ($this -> input -> post('assign_leads_delete') == '') {
			echo $assign_leads_delete = $this -> input -> post('assign_leads_delete1');
		} else {
			echo $assign_leads_delete = $this -> input -> post('assign_leads_delete');
		}

		if ($this -> input -> post('add_campaign_view') == '') {
			echo $add_campaign_view = $this -> input -> post('add_campaign_view1');
		} else {
			echo $add_campaign_view = $this -> input -> post('add_campaign_view');
		}
		if ($this -> input -> post('add_campaign_insert') == '') {
			echo $add_campaign_insert = $this -> input -> post('add_campaign_insert1');
		} else {
			echo $add_campaign_insert = $this -> input -> post('add_campaign_insert');
		}
		if ($this -> input -> post('add_campaign_modify') == '') {
			echo $add_campaign_modify = $this -> input -> post('add_campaign_modify1');
		} else {
			echo $add_campaign_modify = $this -> input -> post('add_campaign_modify');
		}
		if ($this -> input -> post('add_campaign_delete') == '') {
			echo $add_campaign_delete = $this -> input -> post('add_campaign_delete1');
		} else {
			echo $add_campaign_delete = $this -> input -> post('add_campaign_delete');
		}

		if ($this -> input -> post('add_status_view') == '') {
			echo $add_status_view = $this -> input -> post('add_status_view1');
		} else {
			echo $add_status_view = $this -> input -> post('add_status_view');
		}
		if ($this -> input -> post('add_status_insert') == '') {
			echo $add_status_insert = $this -> input -> post('add_status_insert1');
		} else {
			echo $add_status_insert = $this -> input -> post('add_status_insert');
		}
		if ($this -> input -> post('add_status_modify') == '') {
			echo $add_status_modify = $this -> input -> post('add_status_modify1');
		} else {
			echo $add_status_modify = $this -> input -> post('add_status_modify');
		}
		if ($this -> input -> post('add_status_delete') == '') {
			echo $add_status_delete = $this -> input -> post('add_status_delete1');
		} else {
			echo $add_status_delete = $this -> input -> post('add_status_delete');
		}

		if ($this -> input -> post('next_action_view') == '') {
			echo $next_action_view = $this -> input -> post('next_action_view1');
		} else {
			echo $next_action_view = $this -> input -> post('next_action_view');
		}
		if ($this -> input -> post('next_action_insert') == '') {
			echo $next_action_insert = $this -> input -> post('next_action_insert1');
		} else {
			echo $next_action_insert = $this -> input -> post('next_action_insert');
		}
		if ($this -> input -> post('next_action_modify') == '') {
			echo $next_action_modify = $this -> input -> post('next_action_modify1');
		} else {
			echo $next_action_modify = $this -> input -> post('next_action_modify');
		}
		if ($this -> input -> post('next_action_delete') == '') {
			echo $next_action_delete = $this -> input -> post('next_action_delete1');
		} else {
			echo $next_action_delete = $this -> input -> post('next_action_delete');
		}
		
		
		if ($this -> input -> post('map_next_action_view') == '') {
			echo $map_next_action_view = $this -> input -> post('map_next_action_view1');
		} else {
			echo $map_next_action_view = $this -> input -> post('map_next_action_view');
		}
		if ($this -> input -> post('map_next_action_insert') == '') {
			echo $map_next_action_insert = $this -> input -> post('map_next_action_insert1');
		} else {
			echo $map_next_action_insert = $this -> input -> post('map_next_action_insert');
		}
		if ($this -> input -> post('map_next_action_modify') == '') {
			echo $map_next_action_modify = $this -> input -> post('map_next_action_modify1');
		} else {
			echo $map_next_action_modify = $this -> input -> post('map_next_action_modify');
		}
		if ($this -> input -> post('map_next_actionn_delete') == '') {
			echo $map_next_action_delete = $this -> input -> post('map_next_action_delete1');
		} else {
			echo $map_next_action_delete = $this -> input -> post('map_next_action_delete');
		}
		if ($this -> input -> post('upload_xls_view') == '') {
			echo $upload_xls_view = $this -> input -> post('upload_xls_view1');
		} else {
			echo $upload_xls_view = $this -> input -> post('upload_xls_view');
		}
		if ($this -> input -> post('upload_xls_insert') == '') {
			echo $upload_xls_insert = $this -> input -> post('upload_xls_insert1');
		} else {
			echo $upload_xls_insert = $this -> input -> post('upload_xls_insert');
		}
		if ($this -> input -> post('upload_xls_modify1') == '') {
			echo $upload_xls_modify = $this -> input -> post('upload_xls_modify');
		} else {
			echo $upload_xls_modify = $this -> input -> post('upload_xls_modify1');
		}
		if ($this -> input -> post('upload_xls_delete1') == '') {
			echo $upload_xls_delete = $this -> input -> post('upload_xls_delete');
		} else {
			echo $upload_xls_delete = $this -> input -> post('upload_xls_delete1');
		}

		if ($this -> input -> post('request_lead_transfer_view') == '') {
			echo $request_lead_transfer_view = $this -> input -> post('request_lead_transfer_view1');
		} else {
			echo $request_lead_transfer_view = $this -> input -> post('request_lead_transfer_view');
		}
		if ($this -> input -> post('request_lead_transfer_insert') == '') {
			echo $request_lead_transfer_insert = $this -> input -> post('request_lead_transfer_insert1');
		} else {
			echo $request_lead_transfer_insert = $this -> input -> post('request_lead_transfer_insert');
		}
		if ($this -> input -> post('request_lead_transfer_modify1') == '') {
			echo $request_lead_transfer_modify = $this -> input -> post('request_lead_transfer_modify');
		} else {
			echo $request_lead_transfer_modify = $this -> input -> post('request_lead_transfer_modify1');
		}
		if ($this -> input -> post('request_lead_transfer_delete1') == '') {
			echo $request_lead_transfer_delete = $this -> input -> post('request_lead_transfer_delete');
		} else {
			echo $request_lead_transfer_delete = $this -> input -> post('request_lead_transfer_delete1');
		}

		if ($this -> input -> post('cse_dashboard_view') == '') {
			echo $cse_dashboard_view = $this -> input -> post('cse_dashboard_view1');
		} else {
			echo $cse_dashboard_view = $this -> input -> post('cse_dashboard_view');
		}
		if ($this -> input -> post('cse_dashboard_insert1') == '') {
			echo $cse_dashboard_insert = $this -> input -> post('cse_dashboard_insert');
		} else {
			echo $cse_dashboard_insert = $this -> input -> post('cse_dashboard_insert1');
		}
		if ($this -> input -> post('cse_dashboard_modify1') == '') {
			echo $cse_dashboard_modify = $this -> input -> post('cse_dashboard_modify');
		} else {
			echo $cse_dashboard_modify = $this -> input -> post('cse_dashboard_modify1');
		}
		if ($this -> input -> post('cse_dashboard_delete1') == '') {
			echo $cse_dashboard_delete = $this -> input -> post('cse_dashboard_delete');
		} else {
			echo $cse_dashboard_delete = $this -> input -> post('cse_dashboard_delete1');
		}

		if ($this -> input -> post('tl_dashboard_view') == '') {
			echo $tl_dashboard_view = $this -> input -> post('tl_dashboard_view1');
		} else {
			echo $tl_dashboard_view = $this -> input -> post('tl_dashboard_view');
		}
		if ($this -> input -> post('tl_dashboard_insert1') == '') {
			echo $tl_dashboard_insert = $this -> input -> post('tl_dashboard_insert');
		} else {
			echo $tl_dashboard_insert = $this -> input -> post('tl_dashboard_insert1');
		}
		if ($this -> input -> post('tl_dashboard_modify1') == '') {
			echo $tl_dashboard_modify = $this -> input -> post('tl_dashboard_modify');
		} else {
			echo $tl_dashboard_modify = $this -> input -> post('tl_dashboard_modify1');
		}
		if ($this -> input -> post('tl_dashboard_delete1') == '') {
			echo $tl_dashboard_delete = $this -> input -> post('tl_dashboard_delete');
		} else {
			echo $tl_dashboard_delete = $this -> input -> post('tl_dashboard_delete1');
		}

		if ($this -> input -> post('all_tracker_view') == '') {
			echo $all_tracker_view = $this -> input -> post('all_tracker_view1');
		} else {
			echo $all_tracker_view = $this -> input -> post('all_tracker_view');
		}
		if ($this -> input -> post('all_tracker_insert1') == '') {
			echo $all_tracker_insert = $this -> input -> post('all_tracker_insert');
		} else {
			echo $all_tracker_insert = $this -> input -> post('all_tracker_insert1');
		}
		if ($this -> input -> post('all_tracker_modify1') == '') {
			echo $all_tracker_modify = $this -> input -> post('all_tracker_modify');
		} else {
			echo $all_tracker_modify = $this -> input -> post('all_tracker_modify1');
		}
		if ($this -> input -> post('all_tracker_delete1') == '') {
			echo $all_tracker_delete = $this -> input -> post('all_tracker_delete');
		} else {
			echo $all_tracker_delete = $this -> input -> post('all_tracker_delete1');
		}

		if ($this -> input -> post('cse_tracker_view') == '') {
			echo $cse_tracker_view = $this -> input -> post('cse_tracker_view1');
		} else {
			echo $cse_tracker_view = $this -> input -> post('cse_tracker_view');
		}
		if ($this -> input -> post('cse_tracker_insert1') == '') {
			echo $cse_tracker_insert = $this -> input -> post('cse_tracker_insert');
		} else {
			echo $cse_tracker_insert = $this -> input -> post('cse_tracker_insert1');
		}
		if ($this -> input -> post('cse_tracker_modify1') == '') {
			echo $cse_tracker_modify = $this -> input -> post('cse_tracker_modify');
		} else {
			echo $cse_tracker_modify = $this -> input -> post('cse_tracker_modify1');
		}
		if ($this -> input -> post('cse_tracker_delete1') == '') {
			echo $cse_tracker_delete = $this -> input -> post('cse_tracker_delete');
		} else {
			echo $cse_tracker_delete = $this -> input -> post('cse_tracker_delete1');
		}

		if ($this -> input -> post('transferred_leads_view') == '') {
			echo $transferred_leads_view = $this -> input -> post('transferred_leads_view1');
		} else {
			echo $transferred_leads_view = $this -> input -> post('transferred_leads_view');
		}
		if ($this -> input -> post('transferred_leads_insert1') == '') {
			echo $transferred_leads_insert = $this -> input -> post('transferred_leads_insert');
		} else {
			echo $transferred_leads_insert = $this -> input -> post('transferred_leads_insert1');
		}
		if ($this -> input -> post('transferred_leads_modify1') == '') {
			echo $transferred_leads_modify = $this -> input -> post('transferred_leads_modify');
		} else {
			echo $transferred_leads_modify = $this -> input -> post('transferred_leads_modify1');
		}
		if ($this -> input -> post('transferred_leads_delete1') == '') {
			echo $transferred_leads_delete = $this -> input -> post('transferred_leads_delete');
		} else {
			echo $transferred_leads_delete = $this -> input -> post('transferred_leads_delete1');
		}
if ($this -> input -> post('calling_notification_view') == '') {
			echo $calling_notification_view = $this -> input -> post('calling_notification_view1');
		} else {
			echo $calling_notification_view = $this -> input -> post('calling_notification_view');
		}
		
			echo $calling_notification_insert = $this -> input -> post('calling_notification_insert1');
		
			echo $calling_notification_modify = $this -> input -> post('calling_notification_modify1');
		
			echo $calling_notification_delete = $this -> input -> post('calling_notification_delete1');
		
		
			
			if ($this -> input -> post('add_sms_view') == '') {
			echo $add_sms_view = $this -> input -> post('add_sms_view1');
		} else {
			echo $add_sms_view = $this -> input -> post('add_sms_view');
		}
		if ($this -> input -> post('add_sms_insert') == '') {
			echo $add_sms_insert = $this -> input -> post('add_sms_insert1');
		} else {
			echo $add_sms_insert = $this -> input -> post('add_sms_insert');
		}
		if ($this -> input -> post('add_sms_modify') == '') {
			echo $add_sms_modify = $this -> input -> post('add_sms_modify1');
		} else {
			echo $add_sms_modify = $this -> input -> post('add_sms_modify');
		}
		if ($this -> input -> post('add_sms_delete') == '') {
			echo $add_sms_delete = $this -> input -> post('add_sms_delete1');
		} else {
			echo $add_sms_delete = $this -> input -> post('add_sms_delete');
		}
		
		
			
			if ($this -> input -> post('assign_transferred_leads_view') == '') {
			echo $assign_transferred_leads_view = $this -> input -> post('assign_transferred_leads_view1');
		} else {
			echo $assign_transferred_leads_view = $this -> input -> post('assign_transferred_leads_view');
		}
		if ($this -> input -> post('assign_transferred_leads_insert') == '') {
			echo $assign_transferred_leads_insert = $this -> input -> post('assign_transferred_leads_insert1');
		} else {
			echo $assign_transferred_leads_insert = $this -> input -> post('assign_transferred_leads_insert');
		}
		if ($this -> input -> post('assign_transferred_leads_modify') == '') {
			echo $assign_transferred_leads_modify = $this -> input -> post('assign_transferred_leads_modify1');
		} else {
			echo $assign_transferred_leads_modify = $this -> input -> post('assign_transferred_leads_modify');
		}
		if ($this -> input -> post('assign_transferred_leads_delete') == '') {
			echo $assign_transferred_leads_delete = $this -> input -> post('assign_transferred_leads_delete1');
		} else {
			echo $assign_transferred_leads_delete = $this -> input -> post('assign_transferred_leads_delete');
		}
		
		
			
			if ($this -> input -> post('download_lead_tracker_view') == '') {
			echo $download_lead_tracker_view = $this -> input -> post('download_lead_tracker_view1');
		} else {
			echo $download_lead_tracker_view = $this -> input -> post('download_lead_tracker_view');
		}
		if ($this -> input -> post('download_lead_tracker_insert') == '') {
			echo $download_lead_tracker_insert = $this -> input -> post('download_lead_tracker_insert1');
		} else {
			echo $download_lead_tracker_insert = $this -> input -> post('download_lead_tracker_insert');
		}
		if ($this -> input -> post('download_lead_tracker_modify') == '') {
			echo $download_lead_tracker_modify = $this -> input -> post('download_lead_tracker_modify1');
		} else {
			echo $download_lead_tracker_modify = $this -> input -> post('download_lead_tracker_modify');
		}
		if ($this -> input -> post('download_lead_tracker_delete') == '') {
			echo $download_lead_tracker_delete = $this -> input -> post('download_lead_tracker_delete1');
		} else {
			echo $download_lead_tracker_delete = $this -> input -> post('download_lead_tracker_delete');
		}
		
		
		

		$form_array = array($form_location, $form_new_lead, $form_user, $form_map_process, $form_assign_lead, $form_lead_source, $form_status, $form_next_action, $form_right, $form_follow_up, $form_manager_remark, $form_upload_lead, $form_transfer_lead, $form_tracker, $form_transferred,$calling_notification,$form_sms,$form_assign,$form_download);
		
		$controller_array = array($controller_location, $controller_new_lead, $controller_user, $controller_map_process, $controller_assign_lead, $controller_lead_source, $controller_status, $controller_next_action, $controller_right, $controller_follow_up, $controller_manager_remark, $controller_upload_lead, $controller_transfer_lead, $controller_tracker, $controller_transferred,$controller_calling_notification,$controller_sms,$controller_assign,$controller_download);

		$view_array = array($add_location_view, $new_lead_view, $add_new_user_view, $map_process_view, $assign_leads_view, $lead_source_view, $add_status_view, $next_action_view, $add_right_view, $add_followup_view, $manager_remark_view, $upload_xls_view, $request_lead_transfer_view, $all_tracker_view, $transferred_leads_view,$calling_notification_view,$add_sms_view,$assign_transferred_leads_view,$download_lead_tracker_view);

		$insert_array = array($add_location_insert, $new_lead_insert, $add_new_user_insert, $map_process_insert, $assign_leads_insert, $lead_source_insert, $add_status_insert, $next_action_insert, $add_right_insert, $add_followup_insert, $manager_remark_insert, $upload_xls_insert, $request_lead_transfer_insert, $all_tracker_insert, $transferred_leads_insert,$calling_notification_insert,$add_sms_insert,$assign_transferred_leads_insert,$download_lead_tracker_insert);

		$modify_array = array($add_location_modify, $new_lead_modify, $add_new_user_modify, $map_process_modify,$assign_leads_modify, $lead_source_modify, $add_status_modify, $next_action_modify, $add_right_modify, $add_followup_modify, $manager_remark_modify, $upload_xls_modify, $request_lead_transfer_modify, $all_tracker_modify, $transferred_leads_modify,$calling_notification_modify,$add_sms_modify,$assign_transferred_leads_modify,$download_lead_tracker_modify);
		
		$delete_array = array($add_location_delete, $new_lead_delete, $add_new_user_delete, $map_process_delete, $assign_leads_delete, $lead_source_delete, $add_status_delete, $next_action_delete, $add_right_delete, $add_followup_delete, $manager_remark_delete, $upload_xls_delete, $request_lead_transfer_delete, $all_tracker_delete, $transferred_leads_delete,$calling_notification_delete,$add_sms_delete,$assign_transferred_leads_delete,$download_lead_tracker_delete);

		$view_count = count($view_array);
		$qy = $this -> db -> query("delete from tbl_rights where user_id='$user_id'");
		for ($i = 0; $i < $view_count; $i++) {
			
			
			$query = $this -> db -> query("INSERT INTO `tbl_rights`(`user_id`, `form_name`,`controller_name`,`view`, `insert`, `modify`, `delete`) VALUES ('$user_id','$form_array[$i]','$controller_array[$i]','$view_array[$i]','$insert_array[$i]','$modify_array[$i]','$delete_array[$i]')");

		}

		if ($query) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Rights added Successfully ...!</strong>');

		} else {
			//$this -> db -> where('user_id', $user_id);
		
			
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Right Not added ...!</strong>');

		}
		
	}

	public function select_data() {
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		
		$this -> db -> select('u.fname,u.lname,u.email,u.role_name,u.mobileno,l.location,r.right_id,r.view,r.insert,r.modify,r.delete,r.form_name,u.id,p.process_name');
		$this -> db -> from('tbl_rights r');
		$this -> db -> join('lmsuser u', 'u.id=r.user_id');
		$this -> db -> join('tbl_location l', 'l.location_id=u.location');
		$this -> db -> join('tbl_process p', 'p.process_id=u.process_id');
		if($_SESSION['role'] !=1)
		{
			$this -> db -> where('u.role !=',1);
			$this -> db -> where('p.process_id',$_SESSION['process_id']);
		}
		$this -> db -> group_by('r.user_id');		
		$this -> db -> order_by('u.fname', 'asc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		return $query -> result();
	}
	
	public function select_rightsuser() {
		
		
		$this -> db -> select('u.fname');
		$this -> db -> from('tbl_rights r');
		$this -> db -> join('lmsuser u', 'u.id=r.user_id');
		$this -> db -> join('tbl_location l', 'l.location_id=u.location');
		$this -> db -> join('tbl_process p', 'p.process_id=u.process_id');
		if($_SESSION['role'] !=1)
		{
			$this -> db -> where('u.role !=',1);
			$this -> db -> where('p.process_id',$_SESSION['process_id']);
		}
		$this -> db -> group_by('r.user_id');		
		$this -> db -> order_by('u.fname', 'asc');
		$query = $this -> db -> get();
		return $query -> result();
	}
	
	
	public function select_right_data($id) {
		$this -> db -> select('u.fname,u.lname,u.email,u.mobileno,r.right_id,r.view,r.insert,r.modify,r.delete,r.form_name,u.id');
		$this -> db -> from('tbl_rights r');
		$this -> db -> join('lmsuser u', 'u.id=r.user_id');

		$this -> db -> where('user_id', $id);
		$this -> db -> order_by('right_id', 'asc');
		$query = $this -> db -> get();
		return $query -> result();
	}

	public function delete_rights() {
		$user_id = $this -> input -> post('user_name');
		$this -> db -> where('user_id', $user_id);
		$this -> db -> delete('tbl_rights');
		$this -> insert_right();
	}

	public function delete_all_rights($id) {

		$this -> db -> where('user_id', $id);
		$query = $this -> db -> delete('tbl_rights');

		if ($query) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Rights Deleted Successfully ...!</strong>');

		} else {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Right Not Deleted ...!</strong>');

		}

	}
	
	public function select_location() {
	//	$user_id = $this -> input -> post('user_name');
		$this -> db -> select('*');
		$this -> db -> from('tbl_location l');
		$this -> db -> join('tbl_manager_process p','p.location_id=l.location_id');
		$this -> db -> where('process_id', $this->process_id);
		$this -> db -> where('user_id', $this->user_id);
		 $this->db->where('p.status !=','-1');
        $this->db->where('l.location_status !=','Deactive');
		$this->db->order_by('l.location','asc');
		$query = $this -> db -> get();
		return $query -> result();
	}
	
	public function checkUser() {
		 $locationId = $this -> input -> post('locationId');
		 $process_id=$_SESSION['process_id'];
		/* $where="(l.process_id='$process_id' or m.process_id='$process_id')";	*/
		$this -> db -> select('l.fname,l.lname,l.id');
		$this -> db -> from('lmsuser l');
		$this -> db -> join('tbl_manager_process m', 'm.user_id=l.id','left');
		//$this -> db -> join('tbl_rights r','r.user_id=l.id','left');
		$this -> db -> where('m.location_id', $locationId);
		$this -> db -> where('m.process_id',$_SESSION['process_id']);
	//	$this -> db -> where($where);
		$this -> db -> where('role!=', '1');
		$this -> db -> where('m.status!=', '-1');
		$this -> db -> where('l.status!=', '-1');
		$this -> db -> group_by('l.id');
		$this -> db -> order_by('fname', 'asc');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}

	public function checkRights() {
		$id= $this -> input -> post('username');
		$this -> db -> select('u.fname,u.lname,u.email,u.mobileno,r.right_id,r.view,r.insert,r.modify,r.delete,r.form_name,u.id');
		$this -> db -> from('tbl_rights r');
		$this -> db -> join('lmsuser u', 'u.id=r.user_id');

		$this -> db -> where('user_id', $id);
		$this -> db -> order_by('right_id', 'asc');
		$query = $this -> db -> get();
		return $query -> result();
	}
		public function select_right_fin() {
		$id= $this -> input -> post('username');
		$this -> db -> select('r.right_id,r.view,r.insert,r.modify,r.delete,r.form_name');
		$this -> db -> from('tbl_rights_financem r');
		$this -> db -> where('user_id', $id);
		$this -> db -> order_by('right_id', 'asc');
		$query = $this -> db -> get();
		return $query -> result();
	}
	public function checkComplaintRights() {
		$id= $this -> input -> post('username');
		$this -> db -> select('u.fname,u.lname,u.email,u.mobileno,r.right_id,r.view,r.insert,r.modify,r.delete,r.form_name,u.id');
		$this -> db -> from('tbl_rights_complaint r');
		$this -> db -> join('lmsuser u', 'u.id=r.user_id');

		$this -> db -> where('user_id', $id);
		$this -> db -> order_by('right_id', 'asc');
		$query = $this -> db -> get();
		return $query -> result();
	}
	
	public function copy_user_rights() {
		$this -> db -> select('u.fname,u.lname,u.id');
		$this -> db -> from('tbl_rights r');
		$this -> db -> join('lmsuser u', 'u.id=r.user_id');
		$this -> db -> join('tbl_manager_process m', 'm.user_id=u.id','left');
		$this -> db -> where('m.process_id',$_SESSION['process_id']);
		
		$this -> db -> where('role!=', '1');
		$this -> db -> where('m.status!=', '-1');
		$this->db->group_by('r.user_id');
		$this -> db -> order_by('fname', 'asc');
		$query = $this -> db -> get();
	//	echo $this->db->last_query();
		return $query -> result();
	}
	public function copy_user_rights_complaint() {
		$this -> db -> select('u.fname,u.lname,u.id');
		$this -> db -> from('tbl_rights_complaint r');
		$this -> db -> join('lmsuser u', 'u.id=r.user_id');
		$this -> db -> join('tbl_manager_process m', 'm.user_id=u.id','left');
		$this -> db -> where('m.process_id',$_SESSION['process_id']);
		
		$this -> db -> where('role!=', '1');
		$this -> db -> where('m.status!=', '-1');
		$this->db->group_by('r.user_id');
		$this -> db -> order_by('fname', 'asc');
		$query = $this -> db -> get();
	//	echo $this->db->last_query();
		return $query -> result();
	}

	public function cpyRights() {
		$id= $this -> input -> post('cpyuser');
		$this -> db -> select('u.fname,u.lname,u.email,u.mobileno,r.right_id,r.view,r.insert,r.modify,r.delete,r.form_name,u.id');
		$this -> db -> from('tbl_rights r');
		$this -> db -> join('lmsuser u', 'u.id=r.user_id');

		$this -> db -> where('user_id', $id);
		$this -> db -> order_by('right_id', 'asc');
		$query = $this -> db -> get();
		return $query -> result();
	}
	public function cpyrightComplaint() {
		$id= $this -> input -> post('cpyuser');
		$this -> db -> select('u.fname,u.lname,u.email,u.mobileno,r.right_id,r.view,r.insert,r.modify,r.delete,r.form_name,u.id');
		$this -> db -> from('tbl_rights_complaint r');
		$this -> db -> join('lmsuser u', 'u.id=r.user_id');

		$this -> db -> where('user_id', $id);
		$this -> db -> order_by('right_id', 'asc');
		$query = $this -> db -> get();
		return $query -> result();
	}
	public function insert_rights_complaint()
	{
		$user_id = $this -> input -> post('username');
		$qy = $this -> db -> query("delete from tbl_rights_complaint where user_id='$user_id'");
		
		$form_data_array = array('cform_new_lead','cform_assign_lead', 'cform_follow_up', 'cform_manager_remark','cform_tracker', 'cform_download'
								);
										
		$view_data_array = array('cnew_lead_view','cassign_leads_view','cadd_followup_view','cmanager_remark_view', 'call_tracker_view','cdownload_lead_tracker_view'
								);
								
		$view_data_array1 = array('cnew_lead_view1','cassign_leads_view1','cadd_followup_view1','cmanager_remark_view1', 'call_tracker_view1','cdownload_lead_tracker_view1'
								);		
								
		$insert_data_array = array('cnew_lead_insert','cassign_leads_insert','cadd_followup_insert','cmanager_remark_insert', 'call_tracker_insert','cdownload_lead_tracker_insert'
								);
								
								
		$insert_data_array1 = array('cnew_lead_insert1','cassign_leads_insert1','cadd_followup_insert1','cmanager_remark_insert1', 'call_tracker_insert1','cdownload_lead_tracker_insert1'
								);
									
		$modify_data_array = array('cnew_lead_modify','cassign_leads_modify','cadd_followup_modify','cmanager_remark_modify', 'call_tracker_modify','cdownload_lead_tracker_modify'
								);
								
								
		$modify_data_array1 = array('cnew_lead_modify1','cassign_leads_modify1','cadd_followup_modify1','cmanager_remark_modify1', 'call_tracker_modify1','cdownload_lead_tracker_modify1'
								);
									
									
		$delete_data_array = array('cnew_lead_delete','cassign_leads_delete','cadd_followup_delete','cmanager_remark_delete', 'call_tracker_delete','cdownload_lead_tracker_delete'
								);
								
								
		$delete_data_array1 = array('cnew_lead_delete1','cassign_leads_delete1','cadd_followup_delete1','cmanager_remark_delete1', 'call_tracker_delete1','cdownload_lead_tracker_delete1'
								);
				$process_array = array('9', '9','9','9', '9','9'
								);
										
		
		$form_count = count($form_data_array);
			for ($i = 0; $i < $form_count; $i++) {
				//Form
				$form_array[] = $this -> input -> post($form_data_array[$i]);
				//View
				if (($this -> input -> post($view_data_array[$i])) == '') {

					$view_array[] = $this -> input -> post($view_data_array1[$i]);
				} else {

					$view_array[] = $this -> input -> post($view_data_array[$i]);
				}
				//Insert
				if (($this -> input -> post($insert_data_array[$i])) == '') {

					$insert_array[] = $this -> input -> post($insert_data_array1[$i]);
				} else {

					$insert_array[] = $this -> input -> post($insert_data_array[$i]);
				}
				//Modify
				if (($this -> input -> post($modify_data_array[$i])) == '') {

					$modify_array[] = $this -> input -> post($modify_data_array1[$i]);
				} else {

					$modify_array[] = $this -> input -> post($modify_data_array[$i]);
				}
				//Delete
				if (($this -> input -> post($delete_data_array[$i])) == '') {

					$delete_array[] = $this -> input -> post($delete_data_array1[$i]);
				} else {

					$delete_array[] = $this -> input -> post($delete_data_array[$i]);
				}

			}
			$date=date('Y-m-d');
			$updated_by_id=$_SESSION['user_id'];
			for ($i = 0; $i < $form_count; $i++) {
			$query = $this -> db -> query("INSERT INTO `tbl_rights_complaint`(`user_id`, `form_name`,`view`, `insert`, `modify`, `delete`,`process_id`,`updated_date`,`updated_by_id`) VALUES ('$user_id','$form_array[$i]','$view_array[$i]','$insert_array[$i]','$modify_array[$i]','$delete_array[$i]','$process_array[$i]','$date','$updated_by_id')");
			echo $this->db->last_query();
			}
			if ($query) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Rights added Successfully ...!</strong>');

		} else {
			//$this -> db -> where('user_id', $user_id);
		
			
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Right Not added ...!</strong>');

		}
		
	}
	
	/************ POC Tracking ***************************/
		public function insert_poc_tracking_rights()
	{
		$user_id = $this -> input -> post('username');
		$qy = $this -> db -> query("delete from  tbl_rights_poc_purchase_tracking where user_id='$user_id'");
		
			$form_data_array = array(/*'form_assign' , 'form_transfer_lead' ,*/ 'form_follow_up' , 'form_update_payment_details' , 
								/* 'form_add_appointment' , 'form_add_escalation' , 'form_resolve_escalation' , 'form_manager_remark' , */
								 'form_tracker' , 'form_download');
										
		$view_data_array = array(/*'assign_transferred_leads_view' , 'request_lead_transfer_view' , */ 'add_followup_view' , 'update_payment_details_view' , 
								/* 'add_appointment_view' , 'add_escalation_view' , 'resolve_escalation_view' , 'manager_remark_view' , */
								 'all_tracker_view' , 'download_lead_tracker_view');
								
		$view_data_array1 = array(/*'assign_transferred_leads_view1' , 'request_lead_transfer_view1' ,*/ 'add_followup_view1' ,  'update_payment_details_view1' , 
								 /* 'add_appointment_view1' , 'add_escalation_view1' ,  'resolve_escalation_view1' , 'manager_remark_view1' ,*/
								  'all_tracker_view1' , 'download_lead_tracker_view1');		
								
		$insert_data_array = array(/*'assign_transferred_leads_insert' , 'request_lead_transfer_insert' , */'add_followup_insert' ,  'update_payment_details_insert' , 
								   /*'add_appointment_insert' , 'add_escalation_insert' ,  'resolve_escalation_insert' , 'manager_remark_insert' ,*/
								    'all_tracker_insert' ,   'download_lead_tracker_insert');
								
								
		$insert_data_array1 = array(/*'assign_transferred_leads_insert1' , 'request_lead_transfer_insert1' , */'add_followup_insert1' ,'update_payment_details_insert1' ,
									/* 'add_appointment_insert1' , 'add_escalation_insert1' , 'resolve_escalation_insert1' , 'manager_remark_insert1' ,*/
									 'all_tracker_insert1' ,	'download_lead_tracker_insert1');
		$process_array = array(/*'8' , '8' ,*/'8' ,'8' ,
								/*'8' ,'8' ,'8' ,'8' ,*/
								'8' ,'8');	
										
		
		$form_count = count($form_data_array);
			for ($i = 0; $i < $form_count; $i++) {
				//Form
				$form_array[] = $this -> input -> post($form_data_array[$i]);
				//View
				if (($this -> input -> post($view_data_array[$i])) == '') {

					$view_array[] = $this -> input -> post($view_data_array1[$i]);
				} else {

					$view_array[] = $this -> input -> post($view_data_array[$i]);
				}
				//Insert
				if (($this -> input -> post($insert_data_array[$i])) == '') {

					$insert_array[] = $this -> input -> post($insert_data_array1[$i]);
				} else {

					$insert_array[] = $this -> input -> post($insert_data_array[$i]);
				}
			

			}
			$date=date('Y-m-d');
			$updated_by_id=$_SESSION['user_id'];
			for ($i = 0; $i < $form_count; $i++) {
			$query = $this -> db -> query("INSERT INTO `tbl_rights_poc_purchase_tracking`(`user_id`, `form_name`,`view`, `insert`,`process_id`,`updated_date`,`updated_by_id`) VALUES ('$user_id','$form_array[$i]','$view_array[$i]','$insert_array[$i]','$process_array[$i]','$date','$updated_by_id')");
		//	echo $this->db->last_query();
			}
			if ($query) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-success">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Rights added Successfully ...!</strong>');

		} else {
			//$this -> db -> where('user_id', $user_id);
		
			
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Right Not added ...!</strong>');

		}
		
	}
	
	
	public function poc_tracking_check_rights() {
		$id= $this -> input -> post('username');
		$this -> db -> select('u.fname,u.lname,u.email,u.mobileno,p.right_id,p.view,p.insert,p.modify,p.delete,p.form_name,u.id');
		$this -> db -> from(' tbl_rights_poc_purchase_tracking p');
		$this -> db -> join('lmsuser u', 'u.id=p.user_id');

		$this -> db -> where('user_id', $id);
		$this -> db -> order_by('right_id', 'asc');
		$query = $this -> db -> get();
		return $query -> result();
	}
	
	
	public function copy_poc_tracking_rights() {
		$this -> db -> select('u.fname,u.lname,u.id');
		$this -> db -> from(' tbl_rights_poc_purchase_tracking p');
		$this -> db -> join('lmsuser u', 'u.id=p.user_id');
		$this -> db -> join('tbl_manager_process m', 'm.user_id=u.id','left');
		$this -> db -> where('m.process_id',$_SESSION['process_id']);
		
		$this -> db -> where('role!=', '1');
		$this -> db -> where('m.status!=', '-1');
		$this->db->group_by('p.user_id');
		$this -> db -> order_by('fname', 'asc');
		$query = $this -> db -> get();
	//	echo $this->db->last_query();
		return $query -> result();
	}
	public function cpypocTRights() {
		$id = $this -> input -> post('cpyuser');
		$this -> db -> select('u.fname,u.lname,u.email,u.mobileno,pt.right_id,pt.view,pt.insert,pt.modify,pt.delete,pt.form_name,u.id');
		$this -> db -> from('tbl_rights_poc_purchase_tracking pt');
		$this -> db -> join('lmsuser u', 'u.id=pt.user_id');

		$this -> db -> where('user_id', $id);
		$this -> db -> order_by('right_id', 'asc');
		$query = $this -> db -> get();
		return $query -> result();
	}
	/***********************************************************/
	
	

}
