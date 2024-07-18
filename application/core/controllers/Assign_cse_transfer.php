<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assign_cse_transfer extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('assign_cse_transfer_model');

	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function index() {
		$this -> session();
		$data['select_user'] = $this -> assign_cse_transfer_model -> select_fromuser();	
		$data['to_location'] = $this -> assign_cse_transfer_model -> to_location();		
		$data['var1'] = site_url('assign_cse_transfer/assign_data_admin');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('assign_cse_transfer.php', $data);
		$this -> load -> view('include/footer.php');

	}
	function assign_data_admin()
	{
		$this -> session();		
		
		if($this->input->post('lead_type')=='status'){
			$query = $this -> assign_cse_transfer_model -> assign_data_status();
		}else{
			$query = $this -> assign_cse_transfer_model -> assign_data_source();
		}
			
		
		
		if (!$query) {
			$this -> session -> set_flashdata('msg', '<div class="alert alert-success text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Assigned Successfully ...!</strong>');

		} else {
			$this -> session -> set_flashdata('msg', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead not Assigned Successfully ...!</strong>');

		}
		redirect('assign_cse_transfer');
	}

	function checkLeads()
	{
		$lead_type=$this->input->post('lead_type');
		if($lead_type=='source'){
		$all_count= $this -> assign_cse_transfer_model -> all_count_admin();
		$leads = $this -> assign_cse_transfer_model -> campaign_name();
		
		if(count($all_count)>0)
		{
			?>
				<div class="form-group">
                                                               	
									<label class="control-label col-md-9 col-sm-9 col-xs-12" for="first-name">
										 Total (<?php  echo $all_count[0] -> acount; ?>)</label>
								
								</div>
								<?php 
											$i=0;
											foreach ($leads as $row) {
												 
												$i++;
										
												?>
							 <div class="form-group">
                                                               	
									<label class="control-label col-md-9 col-sm-9 col-xs-12" for="first-name">
										<input type='radio'id="web-<?php echo $i ;?>" name='leads1' value="<?php 
										if($row->lead_source==''){echo 'Web'; }else{ echo $row->lead_source ;}?>" onclick="get_web('web_count-<?php echo $i;?>','web-<?php echo $i ;?>','w_count-<?php echo $i;?>');"> <?php if($row->lead_source==''){echo 'Web'; }else{ echo $row->lead_source ;}?> (<?php echo $row->wcount; ?>)</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
										
										<input type='text' id='web_count-<?php echo $i;?>' name='lead_count1' class="form-control" onblur="check_count('w_count-<?php echo $i;?>','web_count-<?php echo $i;?>')" disabled>
										
									<input type='hidden' id="w_count-<?php echo $i;?>" name='web_count' disabled class="form-control" value="<?php  echo $row -> wcount; ?>">
									</div>
								</div>
								<?php } ?>
										
								<input type='hidden' id='all_count' name='all_count' class="form-control" value="<?php echo count($leads);?>" >
                                 
								
			<?php
			}
			else {
			?>
			<label class="control-label col-md-3 col-sm-3 col-xs-4" for="first-name"> </label>
			<div class="col-md-9 col-sm-9 col-xs-8">
				No Records Found
				<input type='hidden' id='all_count'  class="form-control"  >
			</div>
			<?php
			
			}
}
if($lead_type=='status'){
	
		$new_leads = $this -> assign_cse_transfer_model -> new_lead_counts();	
		$today_followup_leads = $this -> assign_cse_transfer_model -> today_followup_lead_counts();			
		$pending_new_leads = $this -> assign_cse_transfer_model -> pending_new_lead_counts();		
		$pending_followup_leads = $this -> assign_cse_transfer_model -> pending_followup_lead_counts();		
		
		$i=0;
		foreach ($new_leads as $row) {
		$i++;
		?>
		
							 <div class="form-group">
                                                               	
									<label class="control-label col-md-9 col-sm-9 col-xs-12" for="first-name">
										<input type='radio' id="new_lead_radio" name='leads1' value="New Lead"  onclick="get_status('new_lead')">New Lead (<?php echo $row->count_lead; ?>)</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
										
										<input type='text' id='new_lead'  name='lead_count1' class="form-control"  disabled>
										
									<input type='hidden'  name='web_count' disabled class="form-control" >
									</div>
								</div>
								<input type='hidden' id='all_count' name='all_count' class="form-control" value="<?php echo $row->count_lead ; ?>">
								<?php }  ?>
									
                             
								<?php
		foreach ($today_followup_leads as $row) {
		$i++;
		?>
							 <div class="form-group">
                                                               	
									<label class="control-label col-md-9 col-sm-9 col-xs-12" for="first-name">
										<input type='radio' id="today_followup_lead_radio" name='leads1'  value="Today Followup Lead"  onclick="get_status('today_followup_lead')">Today Followup Lead (<?php echo $row->count_lead; ?>)</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
										
										<input type='text' id='today_followup_lead'  name='lead_count1' class="form-control"  disabled>
										
									<input type='hidden'  name='web_count' disabled class="form-control" >
									</div>
								</div>
								<?php } 
	foreach ($pending_new_leads as $row) {
		$i++;
		?>
							 <div class="form-group">
                                                               	
									<label class="control-label col-md-9 col-sm-9 col-xs-12" for="first-name">
										<input type='radio' id="pending_new_lead_radio" name='leads1' value="Pending New Lead" onclick="get_status('pending_new_lead')">Pending New Lead (<?php echo $row->count_lead; ?>)</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
										
										<input type='text' id='pending_new_lead' name='lead_count1' class="form-control"  disabled>
										
									<input type='hidden'  name='web_count' disabled class="form-control" >
									</div>
								</div>
								<?php } 
	foreach ($pending_followup_leads as $row) {
		$i++;
		?>
							 <div class="form-group">
                                                               	
									<label class="control-label col-md-9 col-sm-9 col-xs-12" for="first-name">
										<input type='radio' id="pending_followup_lead_radio"  name='leads1' value="Pending Followup Lead" onclick="get_status('pending_followup_lead')">Pending Followup Lead(<?php echo $row->count_lead; ?>)</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
										
										<input type='text' id="pending_followup_lead"  name='lead_count1' class="form-control"  disabled>
										
									<input type='hidden'  name='web_count' disabled class="form-control" >
									</div>
								</div>
								<?php } 
										
		}
	}
function select_touser()
{
	$from_user=$this->assign_cse_transfer_model->select_touser();		
		if(count($from_user)>0)
		{
			?>
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-4" for="first-name"> To User</label>
				<div class="col-md-9 col-sm-9 col-xs-8">
					<?php
					$i=0;
				foreach($from_user as $row)
				{
					$i++;
					?>
					<input type="checkbox" id="cse_name" name="cse_name[]" value='<?php echo $row -> id; ?>'>
					<?php echo $row -> fname . " " . $row -> lname; ?>
					<br>
					<?php } ?>
					
			</div>
			</div>
			
			<?php
			}
			else {
			?>
		
			<label class="control-label col-md-3 col-sm-3 col-xs-4" for="first-name"> </label>
			<div class="col-md-9 col-sm-9 col-xs-8">
				No Records Found
				
			</div>
			<?php
			
			}
}
}
