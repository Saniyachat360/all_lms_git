<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class website_leads extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
		$this->load->model('website_lead_model');
		
	}
		public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}		
	public function telecaller_leads()
	{
		$this->session();
		$data['enq']='All';
		$enq='All';
		$data['select_lead']=$this->website_lead_model->select_lead($enq);
		$data['all_count_lead']=$this->website_lead_model->select_lead_count($enq);
		
		$data['id']='';
		$data['role']='';
		$this -> load -> view('include/admin_header.php');
		if($_SESSION['role']!=1){
		$this->load->view('notification_view.php',$data);
		}
		//$this->load->view('telecaller_top_tab_view1.php',$data);
		$this->load->view('telecaller_lms_view.php',$data);
		$this->load->view('include/footer.php');
	}
	
	public function select_disposition_filter()
	{
		$this->session();
		$status=$this->input->post('filter_status');
		$query=$this->website_lead_model->select_disposition($status);
		?>           
		<div class="form-group">
			<select class="filter_s col-md-12 col-xs-12 form-control" id="filter_disposition" name="filter_disposition">
				<option value="">Disposition</option>
				<?php foreach ($query as $fetch) {?>
				<option value="<?php echo $fetch -> disposition_id; ?>"><?php echo $fetch -> disposition_name; ?></option>
	            <?php } ?> 	
	        </select>
	  	</div>
	 <?php 
	}
	public function lms_details($id,$enq=null)
	{
		$this->session();
		$enq_id=$id;
		$data['enq']=$enq;
		$data['details']=$this->website_lead_model->lms_details($enq_id);
		$data['followup_detail']=$this->website_lead_model->followup_detail($enq_id);
		$data['remark_detail']=$this->website_lead_model->select_manager_remark($enq_id);
		//$data['select_additional_info']=$this->website_lead_model->select_additional_info($enq_id);
		$data['select_accessories_list']=$this->website_lead_model->select_accessories_list($enq_id);
		$this->load->view('include/admin_header.php');
		$this->load->view('lms_detail_view.php',$data);
		$this->load->view('include/footer.php');
	}
	public function telecaller_filter()
	{
		$this->session();
		$enq=$this->input->post('enq');
		if($enq=='')
		{
		 	$enq='All';
		}
		
		//echo 'hii';
		$data['filter_campaign_name'] = $this -> input -> get('filter_campaign_name');
		$data['nxtaction'] = $this -> input -> get('nxtaction');
		$data['feedback'] = $this -> input -> get('feedback');
		$data['filter_fromdate']=$dt = $this -> input -> get('filter_fromdate'); 
		$ck='dae';
		//echo $dt;
		$data['enq']=$enq;
		$data['select_lead']=$this->website_lead_model->select_lead($enq);
		$data['select_feedback']=$this->website_lead_model->select_feedback();
		$data['select_next_action']=$this->website_lead_model->select_next_action();
		//$data['select_campaign']=$this->website_lead_model->select_campaign();
		$data['all_count_lead']=$this->website_lead_model->select_lead_count($enq);
		$data['select_campaign']=$this->website_lead_model->select_campaign();
		$data['select_lead_source']=$this->website_lead_model->select_lead_source();
		//$data['select_assign_to']=$this->website_lead_model->select_telecaller();
		//$data['select_status']=$this->website_lead_model->select_status();
		$this -> load -> view('include/admin_header.php');
			$this->load->view('notification_view.php',$data);
		$this->load->view('telecaller_top_tab_view1.php',$data);			
		$this->load->view('telecaller_followup_view.php',$data);
		$this -> load -> view('include/footer.php');
	}
public function search_contact()
{
	$this->session();
		$enq=$this->input->post('enq');
		if($enq=='')
		{
		 	$enq='All';
		}
		
		//echo 'hii';
		//$data['filter_campaign_name'] = $this -> input -> get('filter_campaign_name');
		//$data['nxtaction'] = $this -> input -> get('nxtaction');
		//$data['feedback'] = $this -> input -> get('feedback');
		//$data['filter_fromdate']=$dt = $this -> input -> get('filter_fromdate'); 
		//$ck='dae';
		//echo $dt;
		$data['enq']=$enq;
		$data['select_lead']=$this->website_lead_model->select_lead($enq);
		//$data['select_feedback']=$this->website_lead_model->select_feedback();
		//$data['select_next_action']=$this->website_lead_model->select_next_action();
		//$data['select_campaign']=$this->website_lead_model->select_campaign();
		//$data['all_count_lead']=$this->website_lead_model->select_lead_count($enq);
		//$data['select_campaign']=$this->website_lead_model->select_campaign();
		//$data['select_lead_source']=$this->website_lead_model->select_lead_source();
		$this->load->view('telecaller_followup_view.php',$data);
		
}
public function complaint()
{
	$enq=$this->input->post('enq');
		if($enq=='')
		{
		 	$enq='All';
		}
			$data['enq']=$enq;
		
	$data['select_lead']=$this->website_lead_model->select_complaint($enq);
	$data['select_lead_count']=$this->website_lead_model->select_complaint_count($enq);
	
	$this -> load -> view('include/admin_header.php');
		if($_SESSION['role']!=1){
			$this->load->view('notification_view.php',$data);
			}
	
	$this->load->view('complaint_view.php',$data);
		$this -> load -> view('include/footer.php');
}
	public function complaint_details($id,$enq=null)
	{
		$this->session();
		$complaint_id=$id;
		$data['enq']=$enq;
		$data['details']=$this->website_lead_model->complaint_details($complaint_id);
		$data['followup_detail']=$this->website_lead_model->complaint_followup_detail($complaint_id);
	
		$this->load->view('include/admin_header.php');
		$this->load->view('complaint_details_view.php',$data);
		$this->load->view('include/footer.php');
	}
	public function search_complaint() {

		$this -> session();

	$enq=$data['enq'] = 'All';
		
	$data['select_lead']=$this->website_lead_model->select_complaint($enq);
	$data['select_lead_count']=$this->website_lead_model->select_complaint_count($enq);
		
	$this -> load -> view('complaint_filter_view.php', $data);

	}
}
?>