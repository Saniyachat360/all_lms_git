<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class All_lms_report extends CI_Controller {
private  $process_id;
private $process_name;
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
	//	$this -> load -> model('new_tracker_model');
		//$this -> load -> model('tracker_model1');
		 $this->process_id=$_SESSION['process_id'];
		  $this->process_name=$_SESSION['process_name'];		}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function leads() {

		$this -> session();
		// Get Filter select values
	//	$data['select_campaign'] = $this -> new_tracker_model -> select_campaign();
	//	$data['select_feedback'] = $this -> new_tracker_model -> select_feedback();
		//$data['select_next_action'] = $this -> new_tracker_model -> select_next_action();
	//	$data['select_lead_source'] = $this -> new_tracker_model -> select_lead_source();
	//	$data['campaign_name'] = $this -> input -> get('campaign_name');
	
		// Get All Selected Values
		$data['nextaction'] = $this -> input -> get('nextaction');
		$data['feedback'] = $this -> input -> get('feedback');
		$data['fromdate'] = $this -> input -> get('fromdate');
		$data['todate'] = $this -> input -> get('todate');
		$data['date_type'] = $this -> input -> get('date_type');
		$data['process_id']=$this->process_id;
		 $data['select_leads']=$this->get_count();

	
		
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('all_lms_report_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
	public function get_count()
	{
		$fromdate=$this->input->post('fromdate');
		$todate=$this->input->post('todate');
		if($fromdate==''){ $fromdate=date('Y-m-d');}
		if($todate==''){ $todate=date('Y-m-d');}
		$all_leads=$this->all_leads($fromdate,$todate);
		$facebook_leads=$this->facebook_leads($fromdate,$todate);
		$web_leads=$this->web_leads($fromdate,$todate);
		$nexa_web_leads=$this->nexa_web_leads($fromdate,$todate);
		$newcar_leads=$this->newusedcar_leads($fromdate,$todate,'New Car');
		$usedcar_leads=$this->newusedcar_leads($fromdate,$todate,'POC Sales');
		$evaluation_leads=$this->newusedcar_leads($fromdate,$todate,'Evaluation-POC Purchase');
		$finance_leads=$this->other_leads($fromdate,$todate,'Finance');
		$complaint_leads=$this->complaint_leads($fromdate,$todate);
		$service_leads=$this->other_leads($fromdate,$todate,'Service');
		$accessories_leads=$this->other_leads($fromdate,$todate,'Accessories');
		
		$select_leads[]=array('from_date'=>$fromdate,'to_date'=>$todate,'all_leads'=>$all_leads[0]->leadcount,'facebook_leads'=>$facebook_leads[0]->leadcount,'web_leads'=>$web_leads[0]->leadcount,'nexa_web_leads'=>$nexa_web_leads[0]->leadcount,'newcar_leads'=>$newcar_leads[0]->leadcount,'usedcar_leads'=>$usedcar_leads[0]->leadcount,'evaluation_leads'=>$evaluation_leads[0]->leadcount,'finance_leads'=>$finance_leads[0]->leadcount,'complaint_leads'=>$complaint_leads[0]->leadcount,'service_leads'=>$service_leads[0]->leadcount,'accessories_leads'=>$accessories_leads[0]->leadcount);
		return $select_leads;
	}
	public function all_leads($fromdate,$todate)
	{
		$this->db->select('count(enq_id) as leadcount');
		$this->db->from('lead_master');
		$this->db->where('created_date >=',$fromdate);
		$this->db->where('created_date <=',$todate);
		$query=$this->db->get();
		return $query->result();
		
	}
	public function facebook_leads($fromdate,$todate)
	{
		$this->db->select('count(enq_id) as leadcount');
		$this->db->from('lead_master');
		$this->db->where('lead_source','Facebook');
		$this->db->where('created_date >=',$fromdate);
		$this->db->where('created_date <=',$todate);
		$query=$this->db->get()->result();
		//echo $this->db->last_query();
		return $query;
		
	}
	public function web_leads($fromdate,$todate)
	{
		$this->db->select('count(enq_id) as leadcount');
		$this->db->from('lead_master');
		$this->db->where('lead_source','');
		$this->db->where('created_date >=',$fromdate);
		$this->db->where('created_date <=',$todate);
		$query=$this->db->get();
		return $query->result();
		
	}
	public function nexa_web_leads($fromdate,$todate)
	{
		$this->db->select('count(enq_id) as leadcount');
		$this->db->from('lead_master');
		$this->db->where('lead_source','Nexa Pune Web');
		$this->db->where('created_date >=',$fromdate);
		$this->db->where('created_date <=',$todate);
		$query=$this->db->get();
		return $query->result();
		
	}
	public function newusedcar_leads($fromdate,$todate,$process)
	{
		$this->db->select('count(enq_id) as leadcount');
		$this->db->from('lead_master');
		$this->db->where('process',$process);
		$this->db->where('created_date >=',$fromdate);
		$this->db->where('created_date <=',$todate);
		$query=$this->db->get();
		return $query->result();
		
	}
	public function other_leads($fromdate,$todate,$process)
	{
		$this->db->select('count(enq_id) as leadcount');
		$this->db->from('lead_master_all');
		$this->db->where('process',$process);
		$this->db->where('created_date >=',$fromdate);
		$this->db->where('created_date <=',$todate);
		$query=$this->db->get();
		return $query->result();
		
	}
	public function complaint_leads($fromdate,$todate)
	{
		$this->db->select('count(complaint_id) as leadcount');
		$this->db->from('lead_master_complaint');

		$this->db->where('created_date >=',$fromdate);
		$this->db->where('created_date <=',$todate);
		$query=$this->db->get();
		return $query->result();
		
	}
	
	
	public function filter_value(){
		 $fromdate=$this->input->post('fromdate');
		 $todate=$this->input->post('todate');
		 $select_leads=$this->get_count();

		 if(isset($select_leads)){
	if(count($select_leads)>0){ ?>
	<div class="col-md-12">
				<table class="table table-bordered datatable" id="table-4">
				<thead>
					<tr>
							<th><b>Sr No.</b></th>
							<th><b>Leads</b></th>
									<th><b>Count <?php foreach ($select_leads as $row) { echo '('.$row['from_date'].' TO '.$row['to_date'].')'; }?></b>
							</th>
							
					</tr>
				</thead>
				<tbody>
				
					<tr>
						<td>1</td>
						<td>All Leads</td>
						<?php foreach ($select_leads as $row) { ?>
								<td><?php echo $row['all_leads']; ?></td>
						 <?php } ?>
					
					</tr>
						<tr>
						<td>2</td>
						<td>Facebook Leads</td>
					<?php foreach ($select_leads as $row) { ?>
								<td><?php echo $row['facebook_leads']; ?></td>
						 <?php } ?>
					</tr>
						<tr>
						<td>3</td>
						<td>Web Leads</td>
					<?php foreach ($select_leads as $row) { ?>
								<td><?php echo $row['web_leads']; ?></td>
						 <?php } ?>
					</tr>
						<tr>
						<td>4</td>
						<td>Nexa Pune Web Leads</td>
					<?php foreach ($select_leads as $row) { ?>
								<td><?php echo $row['nexa_web_leads']; ?></td>
						 <?php } ?>
					</tr>
					
						<tr>
						<td>5</td>
						<td>New car Leads</td>
						<?php foreach ($select_leads as $row) { ?>
								<td><?php echo $row['newcar_leads']; ?></td>
						 <?php } ?>
					</tr>
					<tr>
						<td>6</td>
						<td>POC Sales Leads</td>
						<?php foreach ($select_leads as $row) { ?>
								<td><?php echo $row['usedcar_leads']; ?></td>
						 <?php } ?>
					</tr>
					<tr>
						<td>7</td>
						<td>Evaluation-POC Purchase Leads</td>
						<?php foreach ($select_leads as $row) { ?>
								<td><?php echo $row['evaluation_leads']; ?></td>
						 <?php } ?>
					</tr>
					<tr>
						<td>8</td>
						<td>Finance Leads</td>
						<?php foreach ($select_leads as $row) { ?>
								<td><?php echo $row['finance_leads']; ?></td>
						 <?php } ?>
					</tr>
					<tr>
						<td>9</td>
						<td>Complaint Leads</td>
						<?php foreach ($select_leads as $row) { ?>
								<td><?php echo $row['complaint_leads']; ?></td>
						 <?php } ?>
					</tr>
					<tr>
						<td>10</td>
						<td>Service Leads</td>
						<?php foreach ($select_leads as $row) { ?>
								<td><?php echo $row['service_leads']; ?></td>
						 <?php } ?>
					</tr>
					<tr>
						<td>11</td>
						<td>Accessories Leads</td>
						<?php foreach ($select_leads as $row) { ?>
								<td><?php echo $row['accessories_leads']; ?></td>
						 <?php } ?>
					</tr>
				
				</tbody>
			</table>
			</div>
<?php }} else {
	echo "No Record Found"; 
}
	
	
	}
public function select_next_action()
{
	$select_next_action=$this->new_tracker_model->select_next_action();
	?>
	 <select class="filter_s col-md-12 col-xs-12 form-control" id="nextaction" name="nextaction" >
											<option value="">Next Action</option>
										
											
											<?php foreach($select_next_action as $row)
									{?>
										<option value="<?php echo $row -> nextActionName; ?>"><?php echo $row -> nextActionName; ?></option>
								<?php } ?>
                                               
                                                </select>
	<?php
}

	public function tracker_dse_filter() {
		$this -> session();
		
		//Select Box Values
		$data['select_campaign'] = $this -> new_tracker_model -> select_campaign();
		$data['select_feedback'] = $this -> new_tracker_model -> select_feedback();
		$data['select_next_action'] = $this -> new_tracker_model -> select_next_action();
		$data['select_lead_source'] = $this -> new_tracker_model -> select_lead_source();
		
		// Get All Selected Values
		$data['campaign_name'] = $this -> input -> get('campaign_name');
		$data['nextaction'] = $this -> input -> get('nextaction');
		$data['feedback'] = $this -> input -> get('feedback');
		$data['fromdate'] = $this -> input -> get('fromdate');
		$data['todate'] = $this -> input -> get('todate');
		$data['date_type'] = $this -> input -> get('date_type');
		
		// selected values
		$data['select_lead'] = $this -> new_tracker_model -> select_leads();
		$data['count_lead'] = $this -> new_tracker_model -> select_leads_count();
		$data['process_id']=$this->process_id;
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('tracker_with_dse_tob_tab_view_new.php', $data);
		$this -> load -> view('tracker_with_dse_filter_new.php', $data);
		$this -> load -> view('include/footer.php');
	}

	public function download_data() {

		
		
			$this->download_new_car();
		
	}


public function download_new_car()
{
	
	$from_date = $this -> input -> get('fromdate');
		$to_date = $this -> input -> get('todate');
	
	$query = $this -> new_tracker_model -> select_lead_download();
	
	
	if($this->process_id==6){
			$csv= "Sr No,Lead Source,Customer Name,Mobile Number,Alternate Mobile Number,Address,Email ID,Lead Date,Lead Time,Assistance Required,Booking within Days,Customer Location,Lead Assigned Date(CSE),Lead Assigned Time(CSE),CSE Name,CSE Call Date,CSE Call Time,CSE Call Status,CSE Feedback,CSE Next Action,CSE Remark,CSE NFD,CSE NFT,Appointment Type,Appointment Date,Appointment Time,Appointment Status,Showroom Location,DSE Name,Lead Assigned Date,Lead Assigned Time,DSE Call Date,DSE Call Time,DSE Call Status,DSE Feedback,DSE Next Action,DSE Remark,DSE NFD,DSE NFT,Interested in Finance,Interested in Accessories,Interested in Insurance,Interested in EW,Buyer Type,Model,Variant,Auditor Name,Auditor call Date,Auditor call Time,Auditor call Status,Followup Pending,Call Received from Showroom,Fake Updation,Service Feedback,Auditor Remark\n";

	}else if($this->process_id==7){
			$csv= "Sr No,Lead Source,Customer Name,Mobile Number,Alternate Mobile Number,Address,Email ID,Lead Date,Lead Time,Assistance Required,Booking within Days,Customer Location,Lead Assigned Date(CSE),Lead Assigned Time(CSE),CSE Name,CSE Call Date,CSE Call Time,CSE Call Status,CSE Feedback,CSE Next Action,CSE Remark,CSE NFD,CSE NFT,Appointment Type,Appointment Date,Appointment Time,Appointment Status,Showroom Location,DSE Name,Lead Assigned Date,Lead Assigned Time,DSE Call Date,DSE Call Time,DSE Call Status,DSE Feedback,DSE Next Action,DSE Remark,DSE NFD,DSE NFT,Interested in Finance,Interested in Accessories,Interested in Insurance,Interested in EW,Buyer Type,Model,Variant,Exchange Make,Exchange Model,Manufacturing Year,Ownership,KM,Budget From,Budget To,Accidental Claim,Auditor Name,Auditor call Date,Auditor call Time,Auditor call Status,Followup Pending,Call Received from Showroom,Fake Updation,Service Feedback,Auditor Remark\n";

	}else{
		
			$csv="Sr No,Lead Source,Customer Name,Mobile Number,Alternate Mobile Number,Address,Email ID,Lead Date,Lead Time,Assistance Required,Booking within Days,Customer Location,Lead Assigned Date(CSE),Lead Assigned Time(CSE),CSE Name,CSE Call Date,CSE Call Time,CSE Call Status,CSE Feedback,CSE Next Action,CSE Remark,CSE NFD,CSE NFT,Appointment Type,Appointment Date,Appointment Time,Appointment Status,Showroom Location,Evaluator Name,Lead Assigned Date(Evaluator),Lead Assigned Time(Evaluator),Evaluator Call Date,Evaluator Call Time,Evaluator Call Status,Evaluator Feedback,Evaluator Next Action,Evaluator Remark,Evaluator NFD,Evaluator NFT,Exchange Make,Exchange Model,Manufacturing Year,	Ownership,KM,Accidental Claim,Evaluation within days,Fuel Type,Color,Registration Number,Quoted Price,Expected Price,Auditor Name,Auditor call Date,Auditor call Time,Auditor call Status,Followup Pending,Call Received from Showroom,Fake Updation,Service Feedback,Auditor Remark\n";
			
	}

		$i=0;
	foreach ($query as $row) {
		$i++;
		if ($row -> assign_to_cse == 0) {
				$cse_name = $row -> csetl_fname . ' ' . $row -> csetl_lname;
			} else {
				$cse_name = $row -> cse_fname . ' ' . $row -> cse_lname;
			}
			if ($row -> assign_to_dse == 0) {
				$dse_name = $row -> dsetl_fname . ' ' . $row -> dsetl_lname;
			} else {
				$dse_name = $row -> dse_fname . ' ' . $row -> dse_lname;
			}

			if ($row -> lead_source == '') { $lead_source = "Web-".$row->enquiry_for;
			} 
			else if($row->lead_source=='Facebook')
			{
				$lead_source=$row->enquiry_for;
			}
			else { $lead_source = $row -> lead_source;
			}
			$cse_comment = preg_replace('#[^\w()/.%\-&]#'," ", $row->cse_comment);
			$dse_comment = preg_replace('#[^\w()/.%\-&]#'," ", $row->dse_comment);
		if($this->process_id==6){
			  $csv.= $i.',"'.$lead_source.'","'.$row->name.'","'.$row->contact_no.'","'.$row->alternate_contact_no.'","'.$row->address.'","'.$row->email.'","'.$row->lead_date.'","'.$row->created_time.'","'.$row->assistance.'","'.$row->days60_booking.'","'.$row->customer_location.'","'.$row->assign_to_cse_date.'","'.$row->assign_to_cse_time.'","'.$cse_name.'","'.$row->cse_date.'","'.$row->cse_time.'","'.$row->csecontactibility.'","'.$row->csefeedback.'","'.$row->csenextAction.'","'.$cse_comment.'","'.$row->cse_nfd.'","'.$row->cse_nftime.'","'.$row->appointment_type.'","'.$row->appointment_date.'","'.$row->appointment_time.'","'.$row -> appointment_status.'","'.$row->showroom_location.'","'.$dse_name.'","'.$row->assign_to_dse_date.'","'.$row -> assign_to_dse_time.'","'.$row->dse_date.'","'.$row -> dse_time.'","'.$row -> dsecontactibility.'","'.$row -> dsefeedback.'","'.$row -> dsenextAction.'","'.$dse_comment.'","'.$row->dse_nfd.'","'.$row -> dse_nftime.'","'.$row -> interested_in_finance.'","'.$row -> interested_in_accessories.'","'. $row -> interested_in_insurance.'","'.$row -> interested_in_ew.'","'. $row -> buyer_type.'","'. $row -> new_model_name.'",'.$row -> variant_name .'","'.$row -> auditfname . ' ' . $row -> auditlname .'","'.$row->auditor_date.'","'.$row -> auditor_time.'","'.$row -> auditor_call_status.'","'.$row -> followup_pending.'","'.$row -> call_received.'","'.$row -> fake_updation.'","'.$row -> service_feedback.'","'.$row -> auditor_remark.'"'."\n";

		}elseif($this->process_id==7){
			  $csv.= $i.',"'.$lead_source.'","'.$row->name.'","'.$row->contact_no.'","'.$row->alternate_contact_no.'","'.$row->address.'","'.$row->email.'","'.$row->lead_date.'","'.$row->created_time.'",'.$row->assistance.','.$row->days60_booking.',"'.$row->customer_location.'",'.$row->assign_to_cse_date.','.$row->assign_to_cse_time.','.$cse_name.','.$row->cse_date.','.$row->cse_time.','.$row->csecontactibility.',"'.$row->csefeedback.'","'.$row->csenextAction.'","'.$row->cse_comment.'",'.$row->cse_nfd.','.$row->cse_nftime.',"'.$row->appointment_type.'",'.$row->appointment_date.','.$row->appointment_time.',"'.$row -> appointment_status.'","'.$row->showroom_location.'",'.$dse_name.','.$row->assign_to_dse_date.','.$row -> assign_to_dse_time.','.$row->dse_date.','.$row -> dse_time.','.$row -> dsecontactibility.','.$row -> dsefeedback.','.$row -> dsenextAction.',"'.$row -> dse_comment.'",'.$row->dse_nfd.','.$row -> dse_nftime.','.$row -> interested_in_finance.','.$row -> interested_in_accessories.','. $row -> interested_in_insurance.','.$row -> interested_in_ew.','. $row -> buyer_type.','. $row -> new_model_name.','.$row -> variant_name.','.$row->old_make.','. $row -> old_model.','.$row -> manf_year.','.$row -> ownership.','.$row -> km.','.$row -> budget_from.','.$row -> budget_to.','.$row -> accidental_claim.',"'.$row -> auditfname . ' ' . $row -> auditlname .'",'.$row->auditor_date.','.$row -> auditor_time.','.$row -> auditor_call_status.','.$row -> followup_pending.','.$row -> call_received.','.$row -> fake_updation.','.$row -> service_feedback.',"'.$row -> auditor_remark.'"'."\n";

		}else{
			 $csv.= $i.',"'.$lead_source.'","'.$row->name.'","'.$row->contact_no.'","'.$row->alternate_contact_no.'","'.$row->address.'","'.$row->email.'","'.$row->lead_date.'","'.$row->created_time.'",'.$row->assistance.','.$row->days60_booking.',"'.$row->customer_location.'",'.$row->assign_to_cse_date.','.$row->assign_to_cse_time.','.$cse_name.','.$row->cse_date.','.$row->cse_time.','.$row->csecontactibility.',"'.$row->csefeedback.'","'.$row->csenextAction.'","'.$row->cse_comment.'",'.$row->cse_nfd.','.$row->cse_nftime.',"'.$row->appointment_type.'",'.$row->appointment_date.','.$row->appointment_time.',"'.$row -> appointment_status.'","'.$row->showroom_location.'",'.$dse_name.','.$row->assign_to_dse_date.','.$row -> assign_to_dse_time.','.$row->dse_date.','.$row -> dse_time.','.$row -> dsecontactibility.','.$row -> dsefeedback.','.$row -> dsenextAction.',"'.$row -> dse_comment.'",'.$row->dse_nfd.','.$row -> dse_nftime.','.$row->old_make.','. $row -> old_model.','.$row -> manf_year.','.$row -> ownership.','.$row -> km.','.$row -> accidental_claim.','.$row -> evaluation_within_days.','.$row -> fuel_type.','. $row -> color.','. $row -> reg_no.','. $row -> quotated_price.','. $row -> expected_price .',"'.$row -> auditfname . ' ' . $row -> auditlname .'",'.$row->auditor_date.','.$row -> auditor_time.','.$row -> auditor_call_status.','.$row -> followup_pending.','.$row -> call_received.','.$row -> fake_updation.','.$row -> service_feedback.','.$row -> auditor_remark."\n";
		
			
		}
  
            }
$csv_handler = fopen ('tracker.csv','w');
fwrite ($csv_handler,$csv);
fclose ($csv_handler);	

$this->load->helper('download');
$filename = 'Tracker ' . $from_date . ' - ' . $to_date.'.csv';
    $data = file_get_contents('https://autovista.in/all_lms/tracker.csv'); // Read the file's contents
    
        force_download($filename, $data);
	
}




}
?>