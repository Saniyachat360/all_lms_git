<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Add_followup_complaint extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper('form');
		$this -> load -> helper('url');
		$this -> load -> model('Add_followup_complaint_model');
		date_default_timezone_set('Asia/Kolkata');
	}
public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	public function detail($id, $path) {
		$this -> session();
		$enq_id = $id;		
		$data['path'] = $path;
	
		
		$data['lead_detail'] =$query = $this ->Add_followup_complaint_model->select_lead($id);

		$data['select_followup_lead'] =$q= $this -> Add_followup_complaint_model -> select_followup_lead($enq_id);
		$data['feedback_status'] = $this -> Add_followup_complaint_model -> select_feedback_status();
		$data['next_action_status'] = $this -> Add_followup_complaint_model -> next_action_status();
		//$data['select_city'] = $this -> Add_followup_complaint_model -> select_city();
	
		$data['var'] = site_url('add_followup_complaint/insert_followup');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('add_followup_complaint_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
	

function insert_followup() {
$query=$this -> Add_followup_complaint_model -> insert_followup();
if (!$query) {
$this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Remark Added Successfully...!</strong>');
} else {
$this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Remark Not added ...!</strong>');
}
//Send quotation
$email = $this -> input -> post('email');
/*$quotation_location = $this -> input -> post('qlocation');
$quotation_model_name = $this -> input -> post('model_name');
$quotation_description = $this -> input -> post('description');
$phone = $this -> input -> post('phone');
if($quotation_location!='' && $quotation_model_name!='')
{
$this->send_mail($email,$quotation_location, $quotation_model_name, $quotation_description,$phone);
}*/

$nextaction = $this -> input -> post('nextaction');
$feedback = $this -> input -> post('feedback');
$this->db->select('sms');
$this->db->from('tbl_sms');
$this->db->where('nextActionName',$nextaction);
$this->db->where('feedBackStatus',$feedback);
$this->db->where('process_id',$_SESSION['process_id']);
$sms=$this->db->get()->result();
$sms_count=count($sms);

if($sms_count > 0)
{
foreach($sms as $row)
{
$sms1=$row->sms;
echo $sms1;
$phone = $this -> input -> post('phone');
//$this->send_sms($phone,$sms1);
}
//$this->send_sms($disposition,$phone,$sms1);
}
$a = $_POST['loc'];
$page_location=str_replace('%20',' ',$a);
if ($page_location == 'Pending Followup') {
//redirect pending attended details
redirect('pending/telecaller_leads');
} elseif ($page_location == 'Pending New') {
//redirect pending not attended details
redirect('pending/telecaller_leads_not_attended');
} elseif ($page_location == 'Today Followup') {
//redirect today followup details
redirect('today_followup');
} else if($page_location == 'New'){
//redirect new assign lead details
redirect(new_lead);
}else if($page_location == 'Transferred '){
//redirect transfer details
redirect(transfer_lead);
}
else if($page_location == 'transfer_report'){
//redirect transfer details
redirect(transfer_report);
}
else if($page_location=='tracker_lead')
{
redirect('tracker/leads');
}
else if($page_location=='call_date_tracker')
{
redirect('tracker/team_leader_leads');
}
else{
//redirect data leads details
redirect('website_leads/complaint/'.$page_location);
}
}

				public function select_next_action()
				{
				$next_action_status=$this->Add_followup_complaint_model->select_next_action();	   ?>
	     <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Next Action:
                                            </label>
                                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                                <select name="nextaction" id="nextaction" class="form-control"  onchange='hide_nfd(this.value);' required >
                                            	<option value="">Please Select </option> 
                                            	<?php foreach ($next_action_status as $row13) { ?>
												<option value="<?php echo $row13 -> nextActionName; ?>"><?php echo $row13 -> nextActionName; ?></option>
												<?php } ?>
                                            </select>
                                            </div>
                                            <?php
											}
											}										?>
